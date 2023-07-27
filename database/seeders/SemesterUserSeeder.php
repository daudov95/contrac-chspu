<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semester_users')->insert([
            [
                'name' => 'Magomed',
                'rank' => 'Администратор',
                'user_id' => 1,
                'semester_id' => 1,
                'table_id' => 1,
            ],
            // [
            //     'name' => 'Magomed TEST',
            //     'rank' => 'Дизайнер',
            //     'user_id' => 2,
            //     'semester_id' => 1,
            //     'table_id' => 2,
            // ],
            // [
            //     'name' => 'Rasul',
            //     'rank' => 'Работник',
            //     'user_id' => 3,
            //     'semester_id' => 1,
            //     'table_id' => 1,
            // ],
        ]);
    }
}
