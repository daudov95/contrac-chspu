<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Table\Question\StoreQuestionRequest;
use App\Http\Requests\Admin\Table\Question\UpdateQuestionRequest;
use App\Http\Requests\Admin\Table\StoreTableRequest;
use App\Http\Requests\Admin\Table\UpdateTableRequest;
use App\Models\Comment;
use App\Models\Curator;
use App\Models\Semester;
use App\Models\SemesterUser;
use App\Models\Table;
use App\Models\TableQuestion;
use App\Models\TableQuestionUser;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TableController extends Controller
{
    public function index() 
    {
        $tables = Table::with('semester')->select('tables.*')
                    ->join('semesters', 'semesters.id', '=', 'tables.semester_id')
                    ->orderBy('semesters.year', 'desc')
                    ->orderBy('semesters.semester', 'desc')
                    ->simplepaginate(5);

        return view('admin.pages.table.list', compact('tables'));
    }

    public function create()
    {
        $semesters = Semester::orderByDesc('year')->orderBy('semester')->get();
        return view('admin.pages.table.create', compact('semesters'));
    }

    public function store(StoreTableRequest $request)
    {
        Table::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'semester_id' => $request->semester_id,
        ]);
        session()->flash('success', "Вы успешно добавили новую критерию");
        return redirect()->route('admin.table.list');
    }

    public function edit(Table $table)
    {
        // dd($semester);
        $semesters = Semester::orderByDesc('year')->orderBy('semester')->get();
        return view('admin.pages.table.edit', compact('table','semesters'));
    }

    public function update(UpdateTableRequest $request)
    {
        $table = Table::find($request->id);

        $table->update([
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
            $table = Table::find($request->id);
            $table->delete();
            session()->flash('success', 'Критерия успешно удалена');

            return response()->json(['status' => true, 'message' => 'Критерия успешно удалена']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении критерии']);
        }
    }


    public function questions(Table $table)
    {
        return view('admin.pages.table.questions.questions', compact('table'));
    }

    public function questionCreate(Table $table)
    {
        $curators = Curator::all();
        return view('admin.pages.table.questions.create', compact('table', 'curators'));
    }

    public function questionStore(StoreQuestionRequest $request)
    {
        TableQuestion::create($request->validated());
        session()->flash('success', 'Вы успешно добавили новый показатель');

        return redirect()->route('admin.table.questions', [$request->table_id]);
    }

    public function questionEdit(TableQuestion $tableQuestion)
    {
        $question = $tableQuestion;
        $curators = Curator::all();

        return view('admin.pages.table.questions.edit', compact('question', 'curators'));
    }

    public function questionUpdate(UpdateQuestionRequest $request)
    {
        $question = TableQuestion::find($request->id);
        $question->update($request->validated());

        session()->flash('success', 'Вы успешно обновили показатель');

        return redirect()->back();
    }

    public function questionDestroy(Request $request)
    {
        try {
            $question = TableQuestion::find($request->id);
            $question->delete();
            session()->flash('success', 'Вы успешно удалили показатель');

            return response()->json(['status' => true, 'message' => 'Показатель успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении показателя']);
        }
    }


    public function users(Table $table)
    {
        $hide_users = User::select('id')->where(function ($query) {
            $query->where('is_admin', '!=', 1)
                ->orWhere('is_curator', '!=', 1);
        });

        $users = SemesterUser::query()->whereNotIn('user_id', $hide_users)->where('table_id', $table->id)->paginate(30);
        $user_answers = TableQuestionUser::query()->where('table_id', $table->id)->get();

        $type1 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '1')
            ->get();
        $type2 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '2')
            ->get();
        $type3 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '3')
            ->get();

        $type4 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '4')
            ->get();

        return view('admin.pages.table.users', compact('users', 'table','user_answers', 'type1', 'type2', 'type3', 'type4'));
    }
    public function usersSearch(Table $table, Request $request)
    {
        $name = $request->name;

        $hide_users = User::select('id')->where(function ($query) {
            $query->where('is_admin', '!=', 1)
                ->orWhere('is_curator', '!=', 1);
        });

        $users = SemesterUser::query()->whereNotIn('user_id', $hide_users)->where('table_id', $table->id)->where('name', 'like', "%". $name ."%")->paginate(30)->withQueryString();
        $user_answers = TableQuestionUser::query()->where('table_id', $table->id)->get();

        $type1 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '1')
            ->get();
        $type2 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '2')
            ->get();
        $type3 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '3')
            ->get();

        $type4 = DB::table('table_question_users')
            ->select('points', 'user_id')
            ->join('table_questions', 'table_questions.id', '=', 'table_question_users.question_id')
            ->where('table_questions.type', '4')
            ->get();

        return view('admin.pages.table.search', compact('users', 'table','user_answers', 'type1', 'type2', 'type3', 'type4'));
    }



    public function user(Table $table, SemesterUser $user)
    {
        // dd($user->questions);
        $semester_user = $user;
        $semester_user_questions = TableQuestionUser::query()->where('user_id', $semester_user->id)->where('table_id', $semester_user->table_id)->get();
        $comments = Comment::all();
        $documents = UserDocument::query()->where('user_id', $semester_user->id)->get();

        // dd($semester_user->questions);
        return view('admin.pages.table.user', compact('semester_user', 'semester_user_questions', 'comments', 'documents'));
    }

    public function addUsers(Table $table, Request $request)
    {
        $hide_users = SemesterUser::select('user_id')->where('table_id', '=', $table->id);
        $name = $request->name;

        if($name) $users = User::query()
                                ->where('is_hide', '!=', '1')
                                ->where('is_admin', '!=', '1')
                                ->where('is_curator', '!=', '1')
                                ->whereNotIn('id', $hide_users)
                                ->where('name', 'like', "%". $name ."%")
                                ->paginate(100)->withQueryString();
        else $users = User::query()
                            ->where('is_hide', '!=', '1')
                            ->where('is_admin', '!=', '1')
                            ->where('is_curator', '!=', '1')
                            ->whereNotIn('id', $hide_users)
                            ->paginate(100);


        // dd($users);
        return view('admin.pages.table.add-users', compact('users', 'table'));
    }

    public function destroyUser(Table $table, Request $request)
    {
        try {
            $user = SemesterUser::query()->where('table_id', $table->id)->where('id', $request->id)->first();
            $documents = $user->documents()->where('table_id', $table->id)->get();

            foreach ($documents as $document) {
                $this->destroyFile($document->path);
            }

            $user->delete();
            session()->flash('success', 'Вы успешно удалили пользователя');

            return response()->json(['status' => true, 'message' => 'Пользователь успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении пользователя']);
        }
    }

    public function destroyFile($oldFile)
    {
        if(Storage::disk('public')->exists($oldFile)){
            Storage::delete($oldFile);
        }
    }
}
