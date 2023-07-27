<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('curators')->insert([
            [
                'name' => 'Начальник учебно-методического управления',
                'user_id' => 1,
            ],
            [
                'name' => 'Директор института непрерывного образования',
                'user_id' => 1,
            ],
            [
                'name' => 'Начальник управления по научно-исследовательской, грантовой и международной деятельности',
                'user_id' => 1,
            ],
            [
                'name' => 'Проректор по научной и международной деятельности',
                'user_id' => 1,
            ],
            [
                'name' => 'Начальник управления стратегического планирования и проектной деятельности',
                'user_id' => 1,
            ],
            [
                'name' => 'Начальник управления кадров',
                'user_id' => 1,
            ],
            [
                'name' => 'Начальник управления по воспитательной и социальной работе',
                'user_id' => 1,
            ],
            [
                'name' => 'Начальник управления информационных технологий',
                'user_id' => 1,
            ],
        ]);
    }
}
