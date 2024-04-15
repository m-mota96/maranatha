<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Traits\Modules;

class ModuleController extends Controller
{
    public function modules() {
        // $modules = Module::with(['submodules' => function($query) {
        //     $query->whereHas('users', function($query2) {
        //         $query2->where('user_id', auth()->user()->id);
        //     });
        // }, 'submodules.submodules' => function($query) {
        //     $query->whereHas('users', function($query2) {
        //         $query2->where('user_id', auth()->user()->id);
        //     });
        // }])->whereHas('users', function($query) {
        //     $query->where('user_id', auth()->user()->id);
        // })
        // ->where('status', 1)->where('module_id', null)
        // ->get();
        $modules = Modules::modulesMenu();
        // dd($modules[0]->submodules[2]->submodules);
        $module = Module::with(['dad'])->where('id', 2)->first();
        
        return view('configuration.modules')->with([
            'modulo' => $module,
            'menu' => $modules
        ]);
    }

    public function getModules() {
        return DataTables::make(Module::from('modules as m')->with(['dad'])->select('m.*'))->toJson();
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
