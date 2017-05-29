<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1\Groups;

use Api\Responses\Transformers\GroupTransformer;
use Lib\Models\Group;
use Lib\Models\User;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Helpers;

class GroupController extends BaseController
{
    public function index(Request $request)
    {
        return $this->response()->collection(Group::all(), new GroupTransformer);
    }

    public function show(Request $request,Group $group)
    {
      return $group;
    }
    public function update(Request $request, Group $group)
    {
      //dd($request->all());
        $group->update($request->all());
        $group->save();

        //$userID = $request->input()["data"];
        if($request->has("user")){
          $user = User::findOrFail($request->get("user"));
          //dd($group);
          $user->group()->associate($group)->save();
        }

      return $group;
    }
    public function store(Request $request)
    {
        $group = new Group;
        $group->fill($request->all());
        $group->active = true;
        $group->color = Helpers\Helper::getRandomGroupColor();
        $group->save();
        $alphabet = Helpers\Helper::mkrange("A", "ZZ");
        $group->name = $alphabet[Group::count() - 1];
        $group->save();
        return $group;
        return $this->response()->created(route("groups.show",$group->id));

    }
    public function destroy(Request $request, Group $group)
    {
        // in this case, we want to delete the user from the given group
        if($request->has("user")){
            $user = User::findOrFail($request->get("user"));
            $user->group_id = null;
            $user->save();
            return $this->response()->accepted();
        }
        return $group->delete();
    }

}
