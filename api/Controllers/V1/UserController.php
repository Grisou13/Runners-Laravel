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

use Unlu\Laravel\Api\QueryBuilder;
use Api\Requests\Filtering\RequestFilter;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends BaseController
{
    public function index(Request $request)
    {
//        $queryBuilder = new StatusFilterable(new User, $request);
//        if($request->has("page") || $request->has("limit"))
//          return $queryBuilder->build()->paginate();
//
//        return $this->response()->collection($queryBuilder->build()->get(), new UserTransformer);
      if($request->has("limit"))
          return $this->response()->paginator(User::paginate($request->get("limit")), new UserTransformer);
      return $this->response()->collection(User::all(), new UserTransformer);

    }
    public function show(Request $request, User $user)
    {
      return $this->response()->item($user,new UserTransformer);
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
