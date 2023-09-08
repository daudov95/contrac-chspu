<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\SemesterUser;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{

    public function addUsers(Request $request) {

        $usersList = [...$request->user_ids];
        $table_id = $request->table_id;

        $users = User::query()->select('id', 'name', 'rank')->findMany($usersList);
        $settings = Setting::find(1);
        $semester = Semester::query()->where('year', $settings->year)->where('semester', $settings->semester)->first();

        foreach ($users as $user) {
            SemesterUser::firstOrCreate([
                'name' => $user->name,
                'user_id' => $user->id,
                'semester_id' => $semester->id,
                'table_id' => $table_id, 
                'rank' => $user->rank
            ]);

            $user->update(['table_id' => $table_id]);
        }
        
        session()->flash('success', 'Вы успешно добавили пользователей в таблицу');

        return response()->json(['status' => true, 'message' => 'Вы успешно добавили пользователей в таблицу']);
    }
}