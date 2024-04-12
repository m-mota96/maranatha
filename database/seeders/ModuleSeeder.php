<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules[0] = [
            'module_id' => null,
            'name' => 'Configuración',
            'target' => null,
            'icon' => 'fa-solid fa-gear',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $modules[1] = [
            'module_id' => 1,
            'name' => 'Menu',
            'target' => 'configuracion_menu',
            'icon' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $modules[2] = [
            'module_id' => 1,
            'name' => 'Usuarios',
            'target' => 'configuracion_usuarios',
            'icon' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        Module::insert($modules);
    }
}