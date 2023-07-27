<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'daudov199895@mail.ru';
        $pasword = 'admin';
        DB::table('users')->insert([
            [
                'name' => 'Magomed',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make($pasword),
                'remember_token' => Str::random(10),
                'rank' => 'Администратор',
                'table_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'Magomed TEST',
            //     'email' => "daudov199895@yandex.ru",
            //     'email_verified_at' => now(),
            //     'password' => Hash::make($pasword),
            //     'remember_token' => Str::random(10),
            //     'rank' => 'Admin',
            //     'table_id' => 2,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'Rasul',
            //     'email' => "rasul@mail.ru",
            //     'email_verified_at' => now(),
            //     'password' => Hash::make('qwerty'),
            //     'remember_token' => null,
            //     'rank' => 'Работник',
            //     'table_id' => 1,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
