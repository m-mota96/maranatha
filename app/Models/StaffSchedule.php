<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    use HasFactory;

    protected $fillable= [
        'staff_id', 'day', 'start_time', 'end_time', 'meal_start_time', 'meal_end_time', 'status', 
    ];

    public function staff() {
        return $this->belongsTo(Staff::class);
    }
}
