<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\ApiController;
use App\Place;
use Illuminate\Http\Request;

class PlaceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index()
    {
        return $this->showAll(Place::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     */

    public function store(Request $request)
    {
        $place = new Place($request->all());
        $place->save();
        return $this->show($place);
    }

    /**
     * Display the specified resource.
     * @param \App\Place $place
     */
    public function show(Place $place)
    {
        return $this->show($place);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Place $place
     */
    public function update(Request $request, Place $place)
    {
        $this->validate($request, Place::$rules);
        $place->fill($request->only(
            'name',
            'address',
            'information'
        ));
        if ($place->isClean()) {
            return $this->error('A different value must be specified to update', 422);
        }
        $place->save();
        return $place;
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Place $place
     */

    public function destroy(Place $place)
    {
        $place->delete();
        return $this->showMessage('Record deleted successfully');
    }
}
