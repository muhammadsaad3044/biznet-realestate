<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'image',
        'phone_number_type',
        'phone_number',
        'agent_id',
        'connect_with_facebook',
        'connect_with_google',
        'google_id',
        'google_token',
        'google_refresh_token',
        'google_token_expiry',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles(){
        return $this->belongsTo(roles::class, 'user_role');       
    }
    
    public function tour_in_person(){
        return $this->belongsTo(TourInPerson::class, 'user_id');
    }
    
    
    public function special_offer(){
        return $this->hasMany(SpeicalOffer::class, 'user_id');       
    }
    
    public function fvt_jobs(){
        return $this->hasMany(FvtJob::class, 'user_id');       
    }
}
