<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace App\Http\Controllers\Api\V1;


use App\User;

class UserController
{
    public function index()
    {
        return User::all();
    }
    public function show(User $user)
    {
        return $user;
    }
    public function store(Request $request)
    {
        return;
    }
    public function delete(User $user)
    {
        return $user->delete();
    }
}