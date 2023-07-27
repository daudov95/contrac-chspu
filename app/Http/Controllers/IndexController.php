<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Criteria;
use App\Models\CriteriaQuestion;
use App\Models\CriteriaQuestionUser;
use App\Models\Document;
use App\Models\SemesterUser;
use App\Models\TableQuestionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //

    public function index()
    {
        $semester_user = SemesterUser::query()->with(['questions.curator', 'questions.documents' => function($doc) {
            return $doc->where('user_id', Auth::user()->id);
        }])->where('user_id', Auth::user()->id)->where('table_id', Auth::user()->table_id)->first();

        if(!$semester_user) {
            return abort(403);
        }

        $semester_user_questions = TableQuestionUser::query()->with('comments')->where('user_id', $semester_user->id)->where('table_id', $semester_user->table_id)->get();
        $comments = Comment::all();

        // dd($semester_user_questions);
        return view('frontend.index', compact('semester_user', 'semester_user_questions', 'comments'));
    }

    public function documents()
    {
        $documents = Document::all();
        return view('frontend.documents', compact('documents'));
    }
}
