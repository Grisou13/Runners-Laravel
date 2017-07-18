<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;

use Api\Controllers\BaseController;
use Api\Requests\SearchRequest;
use Lib\Models\User;
use Api\Requests\Filtering\StatusFilterable;
use Api\Responses\Transformers\UserTransformer;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Image as Intervention;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        return User::all();

    }
    public function search(SearchRequest $request)
    {
      $query = $request->get("q");
      return User::where("name","like","%$query%")
        ->orWhere("firstname","like","%$query%")
        ->orWhere("lastname","like","%$query%")
        ->orWhere("email","like","%$query%")
        ->get();
    }
    public function image(Request $request, User $user)
    {
      if($user->profileImage() == null)
        throw new NotFoundHttpException("unable to find image of user {$user->id}");
      $imagePath = public_path($user->profileImage()->filename);
      $img = Intervention::make($imagePath);
      return $img->response();
    }
    public function show(Request $request, User $user)
    {
        return $user;
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        //$this->response()->accepted();
        return $user;
    }
    public function store(CreateUserRequest $request)
    {

        $user = new User;
        $user->fill($request->all());
        $user->save();
        $user->assignRole("runner");
        return $this->response()->created(route("users.show"),$user);
    }
    public function delete(User $user)
    {
        $user->delete();
        return $user;
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
