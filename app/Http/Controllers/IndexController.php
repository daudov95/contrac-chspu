<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Models\Comment;
use App\Models\Criteria;
use App\Models\CriteriaQuestion;
use App\Models\CriteriaQuestionUser;
use App\Models\Document;
use App\Models\SemesterUser;
use App\Models\TableQuestionUser;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $documents = UserDocument::query()->where('user_id', $semester_user->id)->get();

        // dd($semester_user->documents);
        return view('frontend.index', compact('semester_user', 'semester_user_questions', 'comments', 'documents'));
    }

    public function documents()
    {
        $documents = Document::all();
        return view('frontend.documents', compact('documents'));
    }

    public function settings()
    {
        $user = User::query()->where('id', Auth::id())->first();
        return view('frontend.settings', compact('user'));
    }

    public function settingsUpdate(SettingsRequest $request)
    {
        $password = trim($request->password);
        
        if(empty($password)) {
            $password = null;
        }

        $user = User::find(Auth::id());
        
        $user->name = $request->name;
        $user->email = $request->email;
        if(!is_null($password)) $user->password = Hash::make($password);

        $user->save();
        session()->flash('success', 'Вы успешно изменили данные');

        return redirect()->back();
    }
}
