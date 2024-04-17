<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use App\Models\User;
use App\Traits\Modules;

class UserPermissionController extends Controller
{
    public function usersPermissions() {
        $module = Modules::module(5);
        if (empty($module)) {
            return redirect('dashboard');
        }

        $permissions = Permission::where('module_id', $module->id)->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        $permissionsUser = [];
        foreach ($permissions as $key => $p) {
            $permissionsUser[] = $p->id;
        }
        return view('configuration.usersPermissions')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'allModules' => Modules::allModules(),
            'permissions' => $permissionsUser
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
