<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\lk\QuestionDocumentStore;
use App\Http\Requests\Api\lk\QuestionStore;
use App\Models\Comment;
use App\Models\SemesterUser;
use App\Models\Setting;
use App\Models\TableQuestion;
use App\Models\TableQuestionUser;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    //
    public function question(int $id)
    {
        $question = TableQuestion::findOrFail($id);
        return response()->json(['data' => $question, 'status' => true], 200);
    }

    public function questionOptions(int $id)
    {
        $question = TableQuestion::findOrFail($id);
        return response()->json(['data' => $question->options, 'status' => true], 200);
    }

    public function userQuestion(int $user_id, int $question_id, int $table_id, string $token = "null")
    {
        if($token !== env('API_TOKEN')) {
            return abort(403);
        }


        $question = TableQuestionUser::query()->where('user_id', $user_id)->where('question_id', $question_id)->where('table_id', $table_id)->first();
        if($question === null) {
            return response()->json(['error' => 'Ничего не найдено', 'status' => false], 404);
        }
        // dd($question);
        return response()->json(['data' => $question, 'status' => true], 200);
    }

    public function store(QuestionStore $request)
    {
        $settings = Setting::find(1);

        if($settings->active !== '1') {
            return response()->json(['status' => false, 'message' => 'Доступ к изменениям баллов закрыт'], 403);
        }

        $semester_user = SemesterUser::query()->where('id',  $request->user_id)->first();
        

        if(!$semester_user) {
            return response()->json(['status' => false, 'message' => 'Такой пользователь не найден!'], 403);
        }

        // if(!$semester_user) {
        //     return;
        //     // SemesterUser::create([
        //     //     'name' => $user->name,
        //     //     'user_id' => $user->id,
        //     //     'semester_id' => $semester->semester_id,
        //     //     'table_id' => $user->table_id,
        //     // ]);
        // }

        

        $question = TableQuestionUser::query()->where('user_id',  $request->user_id)->where('question_id', $request->question_id)->first();

        
        if(!$question) {
            // return response()->json(['status' => true, 'message' => $request->points], 200);
            
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



    public function questionDocuments(int $user_id, int $question_id, int $table_id, string $token = "null")
    {
        if($token !== env('API_TOKEN')) {
            return abort(403);
        }

        $documents = UserDocument::query()->where('user_id', $user_id)->where('question_id', $question_id)->where('table_id', $table_id)->select('id', 'name', 'path')->get();

        if(count($documents) <= 0) {
            return response()->json(['status' => false, 'message' => 'Ничего не найдено'], 404);
        }
        
        return response()->json(['status' => true, 'data' => $documents]);
    }


    public function documentUpload(Request $request)
    {

        return $this->storeFiles($request);

        // return response()->json(['status' => true, 'data' => $response]);
    }


    public function storeFiles($request)
    {
        $settings = Setting::find(1);

        if($settings->active !== '1') {
            return response()->json(['status' => false, 'message' => 'Доступ к добавлению документов закрыт'], 403);
        }

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
            return response()->json(['status'=> true, 'data' => $paths], 200);
        }
        else {
            return response()->json(['status'=> false, 'message' => 'Ошибка при загрузке файлов'], 403);
        }
    }

    public function destoyDocument(Request $request)
    {
        
        $settings = Setting::find(1);

        if($settings->active !== '1') {
            return response()->json(['status' => false, 'message' => 'Доступ к удалению документов закрыт'], 403);
        }

        try {
            $document = UserDocument::query()->where('id', $request->document_id)->where('user_id', $request->user_id)->first();

            // return response()->json(['status' => false, 'message' => $document->path]);
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


    public function comments(int $id, int $user_id)
    {
        try {
            $question = TableQuestionUser::query()->where('user_id', $user_id)->where('question_id', $id)->first();
            $comments = Comment::query()->where('question_id', $question->id)->select('id', 'text', 'created_at')->get();

            if($comments->count() <= 0) {
                return response()->json(['status' => false, 'message' => 'Ошибка при получении комментариев']);
            }

            return response()->json(['status' => true, 'data' => $comments]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при получении комментариев']);
        }
    }
}
