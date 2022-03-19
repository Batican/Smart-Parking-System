<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;
    
    const AVAILABLE = 1;
    const OCCUPIED = 2;
    const RESERVED = 3;

    protected $fillable = [
        'qrCode_path',
        'qrCode_value',
        'parking_number',
        'slotFor', 
        'department_id',
        'status', 
        'user_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class, 
            'slot_id'
        );
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
