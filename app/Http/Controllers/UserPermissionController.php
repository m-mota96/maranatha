<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\Modules;
use App\Traits\Permissions;

class UserPermissionController extends Controller
{
    public function usersPermissions() {
        $module = Modules::module(5);
        if (empty($module)) {
            return redirect('dashboard');
        }

        return view('configuration.usersPermissions')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'allModules' => Modules::allModules(),
            'permissions' => Permissions::permissionsUser($module->id)
        ]);
    }

    public function updateUsersPermissions(Request $request) {
        $modules     = !empty($request->modulesActive) ? array_values($request->modulesActive) : [];
        $permissions = !empty($request->permissionsActive) ? array_values($request->permissionsActive) : [];
        $user = User::find($request->userId);
        $user->modules()->sync($modules);
        $user->permissions()->sync($permissions);
        return response()->json([
            'error' => false,
            'msj'   => 'Los permisos se actualizaron correctamente'
        ], 200);
    }
}
