<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Semester\StoreSemesterRequest;
use App\Http\Requests\Admin\Semester\UpdateSemesterRequest;
use App\Models\Semester;
use App\Models\Table;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderByDesc('year')->orderBy('semester', 'asc')->paginate(8);
        return view('admin.pages.semester.list', compact('semesters'));
    }

    public function create()
    {
        return view('admin.pages.semester.create');
    }

    public function store(StoreSemesterRequest $request)
    {
        $semester = Semester::create([
            'semester' => $request->semester,
            'year' => $request->year
        ]);
        session()->flash('success', "Вы успешно добавили новый семестер");
        return redirect()->route('admin.semester.list');
        // dd($request->all());
    }

    public function edit(Semester $semester)
    {
        // dd($semester);
        return view('admin.pages.semester.edit', compact('semester'));
    }

    public function update(UpdateSemesterRequest $request)
    {
        $semester = Semester::find($request->id);

        $semester->update([
            'semester' => $request->semester,
            'year' => $request->year
        ]);
        session()->flash('success', 'Вы успешно обновили данные');
        return redirect()->back();
        // dd($request->all());
    }

    public function destroy(Request $request)
    {
        try {
            $semester = Semester::find($request->id);
            $semester->delete();
            session()->flash('success', 'Семестер успешно удален');

            return response()->json(['status' => true, 'message' => 'Семестер успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении семестра']);
        }
    }

    public function tables(Semester $semester)
    {
        $tables = Table::query()->where('semester_id', $semester->id)->paginate();
        return view('admin.pages.semester.tables', compact('tables'));
    }
}
