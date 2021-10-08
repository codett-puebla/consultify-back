<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return $this->showAll(User::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $user = new User($request->all());
        $user->password = bcrypt($user->password);
        $user->save();
        return $this->show($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     */
    public function show(User $user)
    {
        $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, User::$rules);

        $user->fill($request->only(
            'password',
            'name',
            'address',
            'personal_info',
            'permission',
            'status'
        ));

        if($user->isClean()){
            return $this->error('A different value must be specified to update', 422);
        }

        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\User  $user
     */

    public function destroy(User $user)
    {
        $user->delete();
            return $this->showMessage('Record deleted successfully');
    }

}
