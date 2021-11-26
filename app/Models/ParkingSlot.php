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
        'qr_code', 
        'parking_number', 
        'department_id',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
