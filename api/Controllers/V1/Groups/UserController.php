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
  public function index(Request $request, Group $group)
  {
    return $group->users;
  }
  
  public function show(Request $request,Group $group, User $user)
  {
    return $user;
  }
  public function store(Request $request, Group $group)
  {
    
    $user = $this->user();
    /**
     * @var User
     */
    $currentUser = $request->get("user",$user);
    if(!$currentUser instanceof Model)
      $currentUser = User::find($currentUser);
    
    $currentUser->group()->associate($group);
    return $group;
  }
  public function destroy(Request $request, Group $group, User $user)
  {
    $user->group()->dissociate();
    return $this->response()->accepted();
  }
  
}
