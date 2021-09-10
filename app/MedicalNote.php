<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class MedicalNote extends Model
{
    protected $primaryKey = '_id';

    protected $collection = 'medical_notes';

    protected $fillable = [
        '_id',
        'name',
        'lastname',
        'info_medic',
        'patient_id',
        'user_id'
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
