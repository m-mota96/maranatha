<?php

namespace App\Traits;
use App\Models\Module;

trait Modules {

    public static function module($moduleId) {
        $module = Module::with(['dad.dad'])->where('id', $moduleId)
        ->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->first();
        return $module;
    }

    public static function modulesMenu() {
        $modules = Module::with(['submodules' => function($query) {
            $query->with(['submodules' => function($query2) {
                $query2->whereHas('users', function($query3) {
                    $query3->where('user_id', auth()->user()->id);
                });
            }])->whereHas('users', function($query2) {
                $query2->where('user_id', auth()->user()->id);
            });
        }])->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->where('status', 1)->where('module_id', null)
        ->get();
        return $modules;
    }

    public static function allModules() {
        $modules = Module::with([
            'permissions',
            'submodules.dad',
            'submodules.permissions',
            'submodules.submodules.dad',
            'submodules.submodules.permissions'
        ])->where('status', 1)->where('module_id', null)->get();
        return $modules;
    }
}