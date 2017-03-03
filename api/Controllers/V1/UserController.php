<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use Api\Controllers\BaseController;
use Api\Requests\Filtering\StatusFilterable;
use Api\Responses\Transformers\UserTransformer;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        return User::all();

    }
    public function show(Request $request, User $user)
    {
        return $user;
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return $this->response()->accepted();
    }
    public function store(CreateUserRequest $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->save();
        return $this->response()->created(route("users.show"),$user);
    }
    public function delete(User $user)
    {
        return $user->delete();
    }

    public function addGroup(Request $request, User $user)
    {
        $group = Group::findOrFail($request->get("group"));
        $user->group()->associate($group);
    }
    public function changeGroup(Request $request, User $user, Group $group)
    {
        $user->group()->associate($group);
    }
    public function removeGroup(Request $request, User $user)
    {
        $user->group()->dissociate();
    }

}
