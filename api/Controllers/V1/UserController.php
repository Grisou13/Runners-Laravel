<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use Api\Controllers\BaseController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;

use Unlu\Laravel\Api\QueryBuilder;
use Api\Requests\Filtering\RequestFilter;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        $queryBuilder = new QueryBuilder(new User, $request);
        if($request->has("page") || $request->has("limit"))
          return $queryBuilder->build()->paginate();
        return $queryBuilder->build()->get();

    }
    public function show(Request $request, User $user)
    {
        $queryBuilder = new RequestFilter($user, $request);
        //return $user;
        $user = $queryBuilder->build()->get();
        if($user->count() != 1)//just in case something happens during the querying of the model
          throw new HttpException("sorry bru");
        return $user->first();//we need to get the index 0, since RequestFilter can only use a global query ->returns a list of 1 item
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
        return $this->response()->created();
    }
    public function delete(User $user)
    {
        return $user->delete();
    }
    public function me()
    {
        return $this->user();
    }

}
