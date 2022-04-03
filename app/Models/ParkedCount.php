<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkedCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_number',
        'date'
    ];
}
