<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Curator\StoreCuratorRequest;
use App\Http\Requests\Admin\Curator\UpdateCuratorRequest;
use App\Models\Criteria;
use App\Models\Curator;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;

class CuratorController extends Controller
{
    public function index()
    {
        $curators = Curator::with('user')->paginate(8);
        return view('admin.pages.curator.list', compact('curators'));
    }

    public function create()
    {
        $users = User::query()->where('is_curator', '1')->get();
        return view('admin.pages.curator.create', compact('users'));
    }

    public function store(StoreCuratorRequest $request)
    {
        // dd($request->all());
        Curator::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);
        session()->flash('success', "Вы успешно добавили нового куратора");
        return redirect()->route('admin.curator.list');
    }

    public function edit(Curator $curator)
    {
        $users = User::query()->where('is_curator', '1')->get();
        return view('admin.pages.curator.edit', compact('curator','users'));
    }

    public function update(UpdateCuratorRequest $request)
    {
        $curator = Curator::find($request->id);

        $curator->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);
        session()->flash('success', 'Вы успешно обновили куратора');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        try {
            $curator = Curator::find($request->id);
            $curator->delete();
            session()->flash('success', 'Куратор успешно удален');

            return response()->json(['status' => true, 'message' => 'Куратор успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении куратора']);
        }
    }
}
