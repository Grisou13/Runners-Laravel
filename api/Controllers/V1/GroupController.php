<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use Api\Requests\Filtering\RequestFilter;
use App\Group;
use App\User;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Unlu\Laravel\Api\QueryBuilder;
use App\Http\Helpers;

class GroupController extends BaseController
{
    public function index(Request $request)
    {
        $queryBuilder = new QueryBuilder(new Group, $request);
        if($request->has("page") || $request->has("limit"))
          return $queryBuilder->build()->paginate();
        return $queryBuilder->build()->get();
    }

    public function show(Request $request,Group $group)
    {
      $queryBuilder = new RequestFilter($group, $request);
      //return $user;
      $group = $queryBuilder->build()->get();
      if($group->count() != 1)//just in case something happens during the querying of the model
        throw new HttpException("sorry bru");
      return $group->first();//we need to get the index 0, since RequestFilter can only use a global query ->returns a list of 1 item
    }
    public function update(Request $request, Group $group)
    {
        $group->update($request->all());
        //$userID = $request->input()["data"];

        $user = User::findOrFail($request->get("user"));

        $user->group_id = $group->id;

        $user->save();

        return $this->response()->accepted(route("groups.update",$group->id));

    }
    public function store(Request $request)
    {
        $group = new Group;
        $group->fill($request->all());
        $group->active = true;
        $group->color = Helpers\Helper::getRandomGroupColor();
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
            return "true";
        }
        return $group->delete();
    }

}
