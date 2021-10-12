<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\ApiController;
use App\Patient;
use Illuminate\Http\Request;

class PatientController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return $this->showAll(Patient::all());
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $patient = new Patient($request->all());
        return $patient;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     */
    public function show(Patient $patient)
    {
        return $this->showOne($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     */
    public function update(Request $request, Patient $patient)
    {
        $this->validate($request, Patient::$rules);
        $patient->fill($request->only(
            'name',
            'lastname',
            'info_medic'
        ));

        if($patient->isClean()){
            return $this->error('A different value must be specified to update', 422);
        }

        $patient->save();
        return $patient;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return $this->showMessage('Record deleted successfully');
    }
}
