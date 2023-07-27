<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\TableQuestionUser;
use App\Models\Curator;
use App\Models\SemesterUser;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminQuestionController extends Controller
{

    function adminStore(Request $request)
    {
        $curator = Curator::find($request->question_curator_id);

        if($curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного вопроса'], 200);
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



    public function destoyDocument(Request $request)
    {
        $curator = Curator::find($request->question_curator_id);

        if($curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного вопроса'], 403);
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
            Storage::delete('public/'. $oldFile);
        }
    }


    function commentStore(Request $request) 
    {

        $curator = Curator::find($request->question_curator_id);
        $user_question_answer = TableQuestionUser::query()->where('user_id', $request->user_id)->where('question_id', $request->question_id)->where('table_id', $request->table_id)->first();

        if($curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного вопроса'], 403);
        }

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


    function commentDestroy(Request $request) {

        $curator = Curator::find($request->question_curator_id);

        if($curator->user_id != $request->curator_id) {
            return response()->json(['status' => false, 'message' => 'Вы не являетесь куратором данного вопроса'], 403);
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