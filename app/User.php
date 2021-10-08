<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;

//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
        'address',
        'personal_info',
        'permission',
        'status',
        'place_id'
    ];

    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $collection = 'users';

    protected $primaryKey = '_id';

    static $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
        'name' => 'required|string',
        'address' => 'string',
        'personal_info' => '',
        'permission' => 'required',
        'status' => 'required|int',
        'place_id' => 'required|int'
    ];


    public function medical_consultation()
    {
        return $this->hasMany(MedicalConsultation::class);
    }

    public function clinic_history()
    {
        return $this->hasMany(ClinicHistory::class);
    }

    public function medical_note()
    {
        return $this->hasMany(MedicalNote::class);
    }

    public function place(){
        return $this->belongsTo(Place::class);
    }
}
