<?php

namespace App\Traits;
use App\Models\Module;

trait Modules {

    public static function modulesMenu() {
        $modules = Module::with(['submodules' => function($query) {
            $query->whereHas('users', function($query2) {
                $query2->where('user_id', auth()->user()->id);
            });
        }, 'submodules.submodules' => function($query) {
            $query->whereHas('users', function($query2) {
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
        $modules = Module::with(['submodules.submodules'])->where('status', 1)->where('module_id', null)->get();
        return $modules;
    }
}