<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->where('is_hide', '!=', '1')->paginate(30);
        return view('admin.pages.user.list', compact('users'));
    }

    public function create()
    {
        $settings = Setting::find(1);
        $semester = Semester::query()->where('year', $settings->year)->where('semester', $settings->semester)->get();
        $categories = Table::with('semester')->whereIn('semester_id', $semester->map(function ($sem) {return $sem->id;}))->get();

        // dd($categories);
        return view('admin.pages.user.create', compact('categories'));
    }

    public function store(StoreUserRequest $request)
    {
        $is_curator = $request->is_curator && $request->is_curator == 'on' ? '1' : '0';
        $is_admin = $request->is_admin && $request->is_admin == 'on' ? '1' : '0';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rank' => $request->rank,
            'table_id' => $request->table_id,
            'is_curator' => $is_curator,
            'is_admin' => $is_admin,
        ]);

        $settings = Setting::find(1);
        $semester = Semester::query()->where('year', $settings->year)->where('semester', $settings->semester)->first();

        $user->semesterUser()->create([
            'name' => $request->name,
            'rank' => $request->rank,
            'table_id' => $request->table_id,
            'semester_id' => $semester->id,
        ]);

        session()->flash('success', "Вы успешно добавили нового пользователя");
        return redirect()->route('admin.user.list');
    }

    public function edit(User $user)
    {
        // dd($semester);
        $categories = Table::with('semester')->get();
        return view('admin.pages.user.edit', compact('user','categories'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);

        $is_curator = $request->is_curator && $request->is_curator == 'on' ? '1' : '0';
        $is_admin = $request->is_admin && $request->is_admin == 'on' ? '1' : '0';
        $password = trim($request->password);
        
        if(empty($password)) {
            $password = null;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if(!is_null($password)) $user->password = Hash::make($password);
        $user->rank = $request->rank;
        $user->table_id = $request->table_id;
        $user->is_curator = $is_curator;
        $user->is_admin = $is_admin;
        $user->save();
        

        session()->flash('success', 'Вы успешно обновили пользователя');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {

        try {
            $user = User::find($request->id);
            $user->delete();
            session()->flash('success', 'Пользователь успешно удален');

            // Сделать удаление и с таблицы semester_users

            return response()->json(['status' => true, 'message' => 'Пользователь успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении пользователя']);
        }
    }


    public function search(Request $request)
    {
        $name = $request->name;

        if($name) $users = User::query()->where('is_hide', '!=', '1')->where('name', 'like', "%". $name ."%")->paginate(8)->withQueryString();
        else $users = User::query()->where('is_hide', '!=', '1')->paginate(8);

        return view('admin.pages.user.search', compact('users'));
    }


}
