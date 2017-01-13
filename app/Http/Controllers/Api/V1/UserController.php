<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseController;
use App\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index()
    {
        return User::all();
    }
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $this->response()->accepted(route("api.user.show",$user->id));
    }
    public function store(Request $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->save();
        return $this->response()->created(route("api.user.show",$user->id));
    }
    public function delete(User $user)
    {
        return $user->delete();
    }
}