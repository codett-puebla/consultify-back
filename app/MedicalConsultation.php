<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class MedicalConsultation extends Model
{
    protected $primaryKey = '_id';

    protected $collection = 'medical_consultations';

    protected $fillable = [
        '_id',
        'info',
        'user_id',
        'patient_id'
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
