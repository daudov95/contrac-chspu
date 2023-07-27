<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Criteria\Question\StoreQuestionRequest;
use App\Http\Requests\Admin\Criteria\Question\UpdateQuestionRequest;
use App\Http\Requests\Admin\Criteria\StoreCriteriaRequest;
use App\Http\Requests\Admin\Criteria\UpdateCriteriaRequest;
use App\Models\Comment;
use App\Models\Criteria;
use App\Models\CriteriaQuestion;
use App\Models\CriteriaQuestionUser;
use App\Models\Curator;
use App\Models\Semester;
use App\Models\SemesterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    public function index()
    {
        // $criterias = Criteria::with('semester')->simplepaginate(5);
        $criterias = Criteria::with('semester')->select('criterias.*')
                    ->join('semesters', 'semesters.id', '=', 'criterias.semester_id')
                    ->orderBy('semesters.year', 'desc')
                    // ->orderBy('semesters.semester', 'asc')
                    ->simplepaginate(5);
        return view('admin.pages.criteria.list', compact('criterias'));
    }

    public function create()
    {
        $semesters = Semester::orderByDesc('year')->orderBy('semester')->get();
        return view('admin.pages.criteria.create', compact('semesters'));
    }

    public function store(StoreCriteriaRequest $request)
    {
        Criteria::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'semester_id' => $request->semester_id,
        ]);
        session()->flash('success', "Вы успешно добавили новую критерию");
        return redirect()->route('admin.criteria.list');
    }

    public function edit(Criteria $criteria)
    {
        // dd($semester);
        $semesters = Semester::orderByDesc('year')->orderBy('semester')->get();
        return view('admin.pages.criteria.edit', compact('criteria','semesters'));
    }

    public function update(UpdateCriteriaRequest $request)
    {
        $criteria = Criteria::find($request->id);

        $criteria->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'semester_id' => $request->semester_id,
        ]);
        session()->flash('success', 'Вы успешно обновили данные');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        try {
            $criteria = Criteria::find($request->id);
            $criteria->delete();
            session()->flash('success', 'Критерия успешно удалена');

            return response()->json(['status' => true, 'message' => 'Критерия успешно удалена']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении критерии']);
        }
    }


    public function questions(Criteria $criteria)
    {
        // $criteria = Criteria::with('users')->paginate();
        // $questions = $criteria;
        // dd($criteria);
        return view('admin.pages.criteria.questions.questions', compact('criteria'));
    }

    public function questionCreate(Criteria $criteria)
    {
        $curators = Curator::all();
        return view('admin.pages.criteria.questions.create', compact('criteria', 'curators'));
    }

    public function questionStore(StoreQuestionRequest $request)
    {
        CriteriaQuestion::create($request->validated());
        session()->flash('success', 'Вы успешно добавили новый показатель');

        return redirect()->route('admin.criteria.questions', [$request->criteria_id]);
    }

    public function questionEdit(CriteriaQuestion $criteriaQuestion)
    {
        $question = $criteriaQuestion;
        $curators = Curator::all();

        // dd('edit question', $question->criteria->id);
        return view('admin.pages.criteria.questions.edit', compact('question', 'curators'));
    }

    public function questionUpdate(UpdateQuestionRequest $request)
    {
        // dd($request->all());
        $question = CriteriaQuestion::find($request->id);
        $question->update($request->validated());

        session()->flash('success', 'Вы успешно обновили показатель');

        return redirect()->back();
        // return redirect()->route('admin.criteria.questions', [$question->criteria_id]);
    }

    public function questionDestroy(Request $request)
    {
        try {
            $question = CriteriaQuestion::find($request->id);
            $question->delete();
            session()->flash('success', 'Вы успешно удалили показатель');

            return response()->json(['status' => true, 'message' => 'Показатель успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении показателя']);
        }
    }


    public function users(Criteria $criteria)
    {
        // $criteria = Criteria::with('users')->paginate();
        $users = SemesterUser::query()->where('criteria_id', $criteria->id)->simplepaginate(10);
        $user_answers = CriteriaQuestionUser::query()->where('criteria_id', $criteria->id)->get();

        $type1 = DB::table('criteria_question_users')
            ->select('points', 'user_id')
            ->join('criteria_questions', 'criteria_questions.id', '=', 'criteria_question_users.question_id')
            ->where('criteria_questions.type', '1')
            ->get();
        $type2 = DB::table('criteria_question_users')
            ->select('points', 'user_id')
            ->join('criteria_questions', 'criteria_questions.id', '=', 'criteria_question_users.question_id')
            ->where('criteria_questions.type', '2')
            ->get();
        $type3 = DB::table('criteria_question_users')
            ->select('points', 'user_id')
            ->join('criteria_questions', 'criteria_questions.id', '=', 'criteria_question_users.question_id')
            ->where('criteria_questions.type', '3')
            ->get();

        // dd($type1);

        return view('admin.pages.criteria.users', compact('users', 'criteria','user_answers', 'type1', 'type2', 'type3'));
    }
    public function user(Criteria $criteria, SemesterUser $user)
    {
        // dd($user->questions);
        // $criteria = Criteria::with('users')->paginate();
        // $users = SemesterUser::query()->where('criteria_id', $criteria->id)->simplepaginate(10);
        // dd($userss->users);

        // FIXME: Выбрать вопросы и ответы по переданому пользователю
        // $semester_user = SemesterUser::query()->with(['questions.curator', 'questions.documents' => function($doc) {
        //     return $doc->where('user_id', Auth::user()->id);
        // }])->where('user_id', Auth::user()->id)->first();

        $semester_user = $user;
        $semester_user_questions = CriteriaQuestionUser::query()->where('user_id', $semester_user->id)->where('criteria_id', $semester_user->criteria_id)->get();
        $comments = Comment::all();

        // dd($semester_user->questions);



        return view('admin.pages.criteria.user', compact('semester_user', 'semester_user_questions', 'comments'));
    }
}
