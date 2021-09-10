<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class Patient extends Model
{
    protected $primaryKey = '_id';

    protected $collection = 'patients';

    protected $fillable = [
        '_id',
        'name',
        'lastname',
        'info_medic',
        'place_id'
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
