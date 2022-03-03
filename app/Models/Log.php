<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_of_user',
        'number_of_slot',
        'description',
        'date_time',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function parkingSlots()
    {
        return $this->belongsTo(ParkingSlot::class);
    }
}
