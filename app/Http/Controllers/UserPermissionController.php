<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Traits\Modules;

class UserPermissionController extends Controller
{
    public function usersPermissions() {
        $module = Module::with(['dad'])->where('id', 5)->first();
        return view('configuration.usersPermissions')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'allModules' => Modules::allModules()
        ]);
    }
}
