<?php

namespace App\Http\Controllers\Admin\Imports;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import() 
    {
        // dd(asset('storage/public/imports/users.xlsx'));
        Excel::import(new UsersImport, 'users.xlsx');
    }
}
