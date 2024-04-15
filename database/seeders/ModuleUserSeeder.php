<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module_user[0] = [
            'module_id' => 1,
            'user_id' => 1
        ];

        $module_user[1] = [
            'module_id' => 2,
            'user_id' => 1
        ];

        DB::table('module_user')->insert($module_user);
    }
}
