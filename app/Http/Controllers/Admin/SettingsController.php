<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateSettingsRequest;
use App\Models\Semester;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::find(1);
        $semesters = Semester::all();

        // dd($semesters->unique('year'));

        return view('admin.pages.settings.index', compact('settings', 'semesters'));
    }

    public function update(UpdateSettingsRequest $request)
    {
        // dd($request->all());
        $settings = Setting::find(1);
        $allow = '0';
        if($request->allow == "on") {
            $allow = '1';
        }

        $settings->update([
            'year' => $request->year,
            'semester' => $request->semester,
            'active' => $allow,
        ]);
        session()->flash('success', "Вы успешно обновили настройки");
        return redirect()->back();
    }

}
