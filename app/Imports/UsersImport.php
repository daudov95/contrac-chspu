<?php

namespace App\Imports;

use App\Models\Semester;
use App\Models\SemesterUser;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $settings = Setting::find(1);
            $semester = Semester::query()->where('year', $settings->year)->where('semester', $settings->semester)->first();

            $name = trim($row[0]);
            $email = trim($row[3]);
            $password = trim(stristr($row[3], '@', true));
            $rank = trim($row[1]);
            $table_id = trim($row[2]);

            $user = User::firstOrCreate([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'rank' => $rank,
                'table_id' => $table_id,
            ]);
            

            SemesterUser::firstOrCreate([
                'name' => $name,
                'rank' => $rank,
                'user_id' => $user->id,
                'semester_id' => $semester->id,
                'table_id' => $table_id,
            ]);

            // dd($semesterUser);
        }
    }
}