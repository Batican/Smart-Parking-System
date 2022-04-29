<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkedCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parking_number',
        'date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
