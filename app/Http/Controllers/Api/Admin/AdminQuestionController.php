<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\TableQuestionUser;
use App\Models\Curator;
use App\Models\SemesterUser;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminQuestionController extends Controller
{
    private const ALLOW_EMAIL = 'daudov199895@mail.ru';

    function adminStore(Request $request)
    {
        $admin = User::find($request->curator_id);
        $curator = Curator::find($request->question_curator_id);
        $isAllow = $admin->is_admin && $admin->email === self::ALLOW_EMAIL;

        if(!$isAllow && $curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного показателя'], 403);
        }
        
        $semester_user = SemesterUser::query()->where('id',  $request->user_id)->first();

        if(!$semester_user) {
            return response()->json(['status' => false, 'message' => 'Такой пользователь не найден!'], 403);
        }

        $question = TableQuestionUser::query()->where('user_id',  $request->user_id)->where('question_id', $request->question_id)->first();
        
        if(!$question) {
            $new = TableQuestionUser::create([
                "user_id" => $request->user_id,
                "question_id" => $request->question_id,
                "table_id" => $request->table_id,
                "points" => $request->points,
            ]);

            if($new) {
                return response()->json(['status' => true, 'message' => 'вы успешно добавили запись'], 201);
            }
            return response()->json(['status' => false, 'message' => 'Ошибка при создании записи'], 403);
        }

        $question->points = $request->points;
        $question->save();

        return response()->json(['status' => true, 'message' => 'Запись успешно обновлена'], 200);
    }

    public function documentUpload(Request $request)
    {
        $admin = User::find($request->curator_id);
        $curator = Curator::find($request->question_curator_id);
        $isAllow = $admin->is_admin && $admin->email === self::ALLOW_EMAIL;

        if(!$isAllow && $curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного показателя'], 403);
        }

        return $this->storeFiles($request);
    }

    public function storeFiles($request)
    {
        if($request->hasFile('files')) {
            $allowedfileExtension=['pdf','jpg','png','docx'];
            $files = $request->file('files');
            $paths = [];

            foreach($files as $file){
                $user_id = $request->user_id;
                $question_id = $request->question_id;
                $table_id = $request->table_id;

                $filenameWithExt = $file->getClientOriginalName();
                $filenameOriginal = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $filename = str()->slug(pathinfo($filenameWithExt, PATHINFO_FILENAME));
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = "files/users/user_". $user_id ."/". $filename ."_".time().".".$extension;
                $check = in_array($extension, $allowedfileExtension);

                $maxSize = 10000;
                $kb = $file->getSize() * 0.001;
                
                if($check) {
                    if($kb > $maxSize) {
                        return response()->json(['status'=> false, 'message' => 'Файл не должен весить больше 10 мб.'], 403);
                    }

                    $file->storeAs($fileNameToStore);
                    
                    $new = UserDocument::create([
                        'name' => $filenameOriginal,
                        'path' => $fileNameToStore,
                        'user_id' => $user_id,
                        'question_id' => $question_id,
                        'table_id' => $table_id,
                    ]);

                    $new = ['id' => $new->id, 'name' => $filenameOriginal, "path" => $fileNameToStore];
                    $paths = [...$paths, $new];
                }
                else {
                    return response()->json(['status'=> false, 'message' => 'Неверный формат файла'], 403);
                }
            }
            return response()->json(['status' => true, 'data' => $paths], 200);
        }
        else {
            return response()->json(['status' => false, 'message' => 'Ошибка при загрузке файлов'], 500);
        }

    }

    public function destoyDocument(Request $request)
    {
        $admin = User::find($request->curator_id);
        $curator = Curator::find($request->question_curator_id);
        $isAllow = $admin->is_admin && $admin->email === self::ALLOW_EMAIL;

        if(!$isAllow && $curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного показателя'], 403);
        }

        try {
            $document = UserDocument::query()->where('id', $request->document_id)->where('user_id', $request->user_id)->first();

            $this->destroyFile($document->path);
            $document->delete();
            session()->flash('success', 'Вы успешно удалили показатель');

            return response()->json(['status' => true, 'message' => 'Документ успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении документа']);
        }
    }

    public function destroyFile($oldFile)
    {
        if(Storage::disk('public')->exists($oldFile)){
            Storage::delete($oldFile);
        }
    }


    function commentStore(Request $request) 
    {
        $admin = User::find($request->curator_id);
        $curator = Curator::find($request->question_curator_id);
        $isAllow = $admin->is_admin && $admin->email === self::ALLOW_EMAIL;

        if(!$isAllow && $curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного показателя'], 403);
        }
        
        $user_question_answer = TableQuestionUser::query()->where('user_id', $request->user_id)->where('question_id', $request->question_id)->where('table_id', $request->table_id)->first();
        $semester_user = SemesterUser::query()->where('id',  $request->user_id)->first();

        if(!$semester_user) {
            return response()->json(['status' => false, 'message' => 'Такой пользователь не найден!'], 404);
        }

        if($user_question_answer) {
            $new = Comment::create([
                "user_id" => $request->user_id,
                "question_id" => $user_question_answer->id,
                "curator_id" => $request->question_curator_id,
                "text" => $request->comment,
            ]);
    
            if($new) {
                return response()->json(['status' => true, 'message' => 'Вы успешно добавили коментарий'], 201);
            }else {
                return response()->json(['status' => false, 'message' => 'Ошибка при добавлении комментария'], 403);
            }
        }else {
            return response()->json(['status' => false, 'message' => 'Пользователь сперва должен вписать баллы'], 403);
        }
        
    }


    function commentDestroy(Request $request)
    {
        $admin = User::find($request->curator_id);
        $curator = Curator::find($request->question_curator_id);
        $isAllow = $admin->is_admin && $admin->email === self::ALLOW_EMAIL;

        if(!$isAllow && $curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного показателя'], 403);
        }
        
        $comment = Comment::query()->where('id',  $request->id)->first();

        if(!$comment) {
            return response()->json(['status' => false, 'message' => 'Такой комментарии не найдено!'], 404);
        }

        $com = $comment->delete();

        if($com) {
            return response()->json(['status' => true, 'message' => 'Вы успешно удалили коментарий'], 200);
        }else {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалили комментария'], 403);
        }
    }

}