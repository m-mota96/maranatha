<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use App\Models\User;
use App\Traits\Modules;

class ModulePermissionController extends Controller
{
    public function modulesPermissions() {
        $module = Modules::module(6);
        if (empty($module)) {
            return redirect('dashboard');
        }
        return view('configuration.modulesPermissions')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu()
        ]);
    }

    public function updateModulesPermissions(Request $request) {
        for ($i = 0; $i < sizeof($request->permissionId); $i++) { 
            if (empty($request->permissionId[$i])) {
                Permission::create([
                    'module_id' => $request->moduleId,
                    'name' => $request->permissionName[$i],
                    'status' => $request->permissionStatus[$i]
                ]);
            } else {
                $permission = Permission::where('id', $request->permissionId[$i])->first();
                $permission->name = $request->permissionName[$i];
                $permission->status = $request->permissionStatus[$i];
                $permission->save();
            }
        }
        return response()->json([
            'error' => false,
            'msj' => 'Los permisos se actualizaron correctamente'
        ], 200);
    }

    public function deletePermissionUser(Request $request) {
        $users = User::whereHas('permissions', function($query) use($request) {
            $query->where('permission_id', $request->permissionId);
        })->get();
        foreach ($users as $key => $u) {
            $u->permissions()->detach($request->permissionId);
        }
        $permission = Permission::where('id', $request->permissionId)->delete();

        return response()->json([
            'error' => false,
            'msj' => 'El permiso se eliminó correctamente'
        ], 200);
    }
}
