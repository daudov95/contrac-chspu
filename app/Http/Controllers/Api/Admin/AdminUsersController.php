<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{

    public function addUsers(Request $request) {

        $usersList = [...$request->user_ids];



        return response()->json(['status' => true, 'message' => $usersList]);
    }
}