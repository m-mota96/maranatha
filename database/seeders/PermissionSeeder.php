<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions[0] = [
        'module_id' => 2,
        'name' => 'Nuevo modulo',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[1] = [
        'module_id' => 2,
        'name' => 'Editar modulo',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[2] = [
        'module_id' => 2,
        'name' => 'Desactivar modulo',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[3] = [
        'module_id' => 3,
        'name' => 'Nuevo usuario',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[4] = [
        'module_id' => 3,
        'name' => 'Editar usuario',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[5] = [
        'module_id' => 3,
        'name' => 'Desactivar usuario',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[6] = [
        'module_id' => 5,
        'name' => 'Ver permisos',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[7] = [
        'module_id' => 5,
        'name' => 'Actualizar permisos',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions[8] = [
        'module_id' => 6,
        'name' => 'Editar permisos',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        Permission::insert($permissions);
    }
}
