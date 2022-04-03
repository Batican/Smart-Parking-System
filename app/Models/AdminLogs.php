<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'description',
        'date_time',
    ];
}
