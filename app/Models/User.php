<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
  
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'type',
        'password',
        'rfid_number'
    ];
  
 
    protected $hidden = [
        'password',
        'remember_token',
    ];
  

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function parkingSlot()
    {
        return $this->hasOne(
            ParkingSlot::class, 
            'user_id'
        );
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

}