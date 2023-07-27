<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Semester;
use App\Models\SemesterUser;
use App\Models\Setting;
use App\Models\Table;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    public function showRegistrationForm()
    {
        $settings = Setting::find(1);
        $semester = Semester::query()->where('year', $settings->year)->where('semester', $settings->semester)->get();
        $criterias = Table::query()->whereIn('semester_id', $semester->map(function ($sem) {return $sem->id;}))->get();
        // dd($criterias);

        return view('auth.register', compact('criterias'));
    }


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'rank' => ['required', 'string', 'max:255'],
            'table_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'rank' => $data['rank'],
            'table_id' => $data['table_id'],
            'password' => Hash::make($data['password']),
        ]);

        $settings = Setting::find(1);
        $semester = Semester::query()->where('year', $settings->year)->where('semester', $settings->semester)->first();

        SemesterUser::create([
            'name' => $user->name,
            'rank' => $data['rank'],
            'user_id' => $user->id,
            'semester_id' => $semester->id,
            'table_id' => $user->table_id,
        ]);

        return $user;
    }
}
