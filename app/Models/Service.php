<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type_id', 'name', 'price', 'discounted_price', 'time', 'status', 
    ];

    public function service_type() {
        return $this->belongsTo(ServiceType::class);
    }

    public function staff() {
        return $this->belongsToMany(Staff::class)->where('status', 1)->orderBy('name');
    }
}
