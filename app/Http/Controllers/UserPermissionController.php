<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\User;
use App\Traits\Modules;

class UserPermissionController extends Controller
{
    public function usersPermissions() {
        $module = Module::with(['dad.dad'])->where('id', 5)
        ->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->first();
        if (empty($module)) {
            return redirect('dashboard');
        }
        return view('configuration.usersPermissions')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'allModules' => Modules::allModules()
        ]);
    }

    public function updateUsersPermissions(Request $request) {
        $modules = !empty($request->modulesActive) ? array_values($request->modulesActive) : [];
        dd($modules);
        $user = User::find($request->userId);
        $user->modules()->sync($modules);
        return response()->json([
            'error' => false,
            'msj'   => 'Los permisos se actualizaron correctamente'
        ], 200);
    }
}
