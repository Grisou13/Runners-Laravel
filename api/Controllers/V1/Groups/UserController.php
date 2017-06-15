<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1\Groups;

use Api\Responses\Transformers\GroupTransformer;
use Illuminate\Database\Eloquent\Model;
use Lib\Models\Group;
use Lib\Models\User;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Helpers;

class UserController extends BaseController
{
    /**
     * Get the users of a given group
     * @param Request $request
     * @param Group $group
     * @return mixed
     */
    public function index(Request $request, Group $group)
    {
        return $group->users;
    }

    /**
     * Return the user
     * @param Request $request
     * @param Group $group
     * @param User $user
     * @return User
     */
    public function show(Request $request,Group $group, User $user)
    {
        return $user;
    }

    /**
     * Associate a user to a group
     * and return the group
     * @param Request $request
     * @param Group $group
     * @return Group
     */
    public function store(Request $request, Group $group)
    {
        $user = $this->user();

        $currentUser = $request->get("user",$user);
        if(!$currentUser instanceof Model)
        $currentUser = User::find($currentUser);

        $currentUser->group()->associate($group);
        return $group;
    }

    /**
     * Dissociate the given user from its group
     * @param Request $request
     * @param Group $group
     * @param User $user
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Request $request, Group $group, User $user)
    {
        $user->group()->dissociate();
        return $this->response()->accepted();
    }
  
}
