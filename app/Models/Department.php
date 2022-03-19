<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation', 
        'color', 
    ];

    protected $appends = ['slot_availlables_count'];

    public function getSlotAvaillablesCountAttribute(){
        return $this->parkingSlots()->where('status', ParkingSlot::AVAILABLE)->count();
    }

    public function parkingSlots()
    {
        return $this->hasMany(
            ParkingSlot::class, 
            'department_id'
        );
    }
}
