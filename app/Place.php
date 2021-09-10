<?php

namespace App;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class Place extends Model
{
    protected $primaryKey = '_id';

    protected $collection = 'places';

    protected $fillable = [
        '_id',
        'name',
        'address',
        'information',
        'user_pay_id'
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function patient(){
        return $this->hasMany(Patient::class);
    }
}
