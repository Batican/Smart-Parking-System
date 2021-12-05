<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 

    ];

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
