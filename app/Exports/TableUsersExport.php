<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;


use App\Invoice;
use App\Models\CriteriaQuestionUser;
use App\Models\SemesterUser;
use App\Models\TableQuestionUser;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class TableUsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::all();
    // }

    private $table_id = null;

    function __construct($table_id) {
        $this->table_id = $table_id;
    }

    public function view(): View
    {

        $hide_users = User::select('id')->where(function ($query) {
            $query->where('is_admin', '!=', 1)
                ->orWhere('is_curator', '!=', 1);
        });

        $users = SemesterUser::query()->whereNotIn('user_id', $hide_users)->where('table_id', $this->table_id)->get();
        $user_answers = TableQuestionUser::query()->where('table_id', $this->table_id)->get();

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

        return view('admin.exports.table-users', compact('users', 'user_answers', 'type1', 'type2', 'type3', 'type4'));
    }
}
