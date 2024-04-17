<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'name', 'icon', 'target', 'class', 'description', 'status', 
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function subModules() {
        return $this->hasMany(Module::class)->orderBy('name');
    }

    public function dad() {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function permissions() {
        return $this->hasMany(Permission::class)->orderBy('name');
    }
}
