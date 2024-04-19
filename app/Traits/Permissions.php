<?php

namespace App\Traits;
use App\Models\Permission;

trait Permissions {
    public static function permissionsUser($moduleId) {
        $permissions = Permission::where('module_id', $moduleId)->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        $permissionsUser = [];
        foreach ($permissions as $key => $p) {
            $permissionsUser[] = $p->id;
        }
        return $permissionsUser;
    }
}