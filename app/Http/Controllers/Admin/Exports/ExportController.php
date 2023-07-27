<?php

namespace App\Http\Controllers\Admin\Exports;

use App\Exports\OldUsersExport;
use App\Exports\TableUsersExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function usersExport() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function tableUsersExport(Table $table) 
    {
        $date = Date('d.m.Y');
        return Excel::download(new TableUsersExport($table->id), "table($table->id)_users($date).xlsx");
    }

    public function oldUsersExport() 
    {
        return Excel::download(new OldUsersExport, "old_users.xlsx");
    }
}
