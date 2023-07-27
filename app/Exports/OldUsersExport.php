<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class OldUsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::all();
    // }

    public function view(): View
    {
        $users = DB::table('test_users')
            ->select('name', 'rank', 'category')
            ->where('category','>', 0)
            ->get();

        return view('admin.exports.old-users', [
            'users' => $users
        ]);
    }
}
