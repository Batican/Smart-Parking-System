<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'color', 
    ];

    public function parkingSlots()
    {
        return $this->hasMany(
            ParkingSlot::class, 
            'department_id'
        );
    }
}
