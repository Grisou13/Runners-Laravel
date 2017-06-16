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
    /**
     * Get all groups
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response()->collection(Group::all(), new GroupTransformer);
    }

    /**
     * Show specific group
     * @param Request $request
     * @param Group $group
     * @return Group
     */
    public function show(Request $request,Group $group)
    {
      return $group;
    }

    /**
     * Change value of the given group
     * @param Request $request
     * @param Group $group
     * @return Group
     */
    public function update(Request $request, Group $group)
    {

        $group->update($request->all());
        $group->save();

        if($request->has("user")){
          $user = User::findOrFail($request->get("user"));
          //dd($group);
          $user->group()->associate($group)->save();
        }

      return $group;
    }

    /**
     * Create a new group
     * The color assigned to it is random (check the helper for details)
     * @param Request $request
     * @return Group
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->fill($request->all());
        $group->active = true;
        $group->color = Helpers\Helper::getRandomGroupColor();
        $group->save();
        // reload a fresh model instance from the database
        if($group->fresh()->name == null){
            // get the groups name (Group A, Group B, Group AA, etc...)
            // can generate up to 702 different groups name
            $alphabet = Helpers\Helper::mkrange("A", "ZZ");

            $group->name = $alphabet[Group::count() - 1];
            $group->save();
        }
        return $group;
    }

    /**
     * Destroy the given group
     * @param Request $request
     * @param Group $group
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Group $group)
    {
        // in this case, we want to delete the user from the given group
        if($request->has("user")){
            $user = User::findOrFail($request->get("user"));
            $user->group_id = null;
            $user->save();
            return $this->response()->accepted();
        }
        $group->delete();
        $this->response()->accepted();
        return $group;
    }

}
