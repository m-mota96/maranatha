<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'name', 'status', 
    ];

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->orderBy('name');
    }
}
