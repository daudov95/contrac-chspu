<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $info = ['posts' => 5, 'users' => $users->count()];
        return view('admin.main', compact('info'));
    }
}
