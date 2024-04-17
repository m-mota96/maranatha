<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use App\Traits\Modules;

class ModuleController extends Controller
{
    public function modules() {
        $module = Modules::module(2);
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
        return view('configuration.modules')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'permissions' => $permissionsUser
        ]);
    }

    public function getModules() {
        return DataTables::make(Module::from('modules as m')->with(['dad', 'permissions'])->select('m.*'))->toJson();
    }

    public function createModifyModule(Request $request) {
        if (empty($request->moduleId)) {
            $txt = 'guardo';
            Module::create([
                'module_id'   => ($request->dad == 0) ? null : $request->dad,
                'name'        => trim($request->nameModule),
                'target'      => empty($request->target) ? null : trim($request->target),
                'class'       => empty($request->class) ? null : trim($request->class),
                'icon'        => empty($request->icon) ? null : trim($request->icon),
                'description' => empty($request->description) ? null : trim($request->description),
            ]);
        } else {
            $module = Module::where('id', $request->moduleId)->first();
            if (empty($module->module_id) && $request->dad != 0) {
                return response()->json([
                    'error' => true,
                    'msj'   => 'No es posible modificar el padre de un módulo principal'
                ], 200);
            }

            $txt = 'modifico';

            $module->module_id   = ($request->dad == 0) ? null : $request->dad;
            $module->name        = trim($request->nameModule);
            $module->target      = empty($request->target) ? null : trim($request->target);
            $module->class       = empty($request->class) ? null : trim($request->class);
            $module->icon        = empty($request->icon) ? null : trim($request->icon);
            $module->description = empty($request->description) ? null : trim($request->description);
            $module->save();
        }
        return response()->json([
            'error' => false,
            'msj'   => 'El módulo se '.$txt.' correctamente'
        ], 200);
    }
}
