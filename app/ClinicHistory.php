<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ClinicHistory extends Model
{
    protected $primaryKey = '_id';

    protected $collection = 'clinic_histories';

    protected $fillable = [
        '_id',
        'information',
        'patient_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
