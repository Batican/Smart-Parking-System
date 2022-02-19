<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slot_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',  

    ];

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class,"slot_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
