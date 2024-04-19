<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission_user[0] = [
            'permission_id' => 1,
            'user_id' => 1
        ];

        $permission_user[1] = [
            'permission_id' => 2,
            'user_id' => 1
        ];

        $permission_user[2] = [
            'permission_id' => 3,
            'user_id' => 1
        ];

        $permission_user[3] = [
            'permission_id' => 4,
            'user_id' => 1
        ];

        $permission_user[4] = [
            'permission_id' => 5,
            'user_id' => 1
        ];

        $permission_user[5] = [
            'permission_id' => 6,
            'user_id' => 1
        ];

        $permission_user[6] = [
            'permission_id' => 7,
            'user_id' => 1
        ];

        $permission_user[7] = [
            'permission_id' => 8,
            'user_id' => 1
        ];

        $permission_user[8] = [
            'permission_id' => 9,
            'user_id' => 1
        ];

        DB::table('permission_user')->insert($permission_user);
    }
}
