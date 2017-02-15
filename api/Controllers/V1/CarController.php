<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use Api\Requests\Filtering\RequestFilter;
use App\Car;
use App\User;
use App\Comment;
use Api\Controllers\BaseController;
use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Unlu\Laravel\Api\QueryBuilder;

class CarController extends BaseController
{
    public function index(Request $request)
    {
      $queryBuilder = new QueryBuilder(new Car, $request);
      if($request->has("page") || $request->has("limit"))
        return $queryBuilder->build()->paginate();
      return $queryBuilder->build()->get();
    }
    public function show(Request $request, Car $car)
    {
      $queryBuilder = new RequestFilter($car, $request);
      //return $user;
      $car = $queryBuilder->build()->get();
      if($car->count() != 1)//just in case something happens during the querying of the model
        throw new HttpException("sorry bru");
      return $car->first();//we need to get the index 0, since RequestFilter can only use a global query ->returns a list of 1 item
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->all());
        return $this->response()->accepted();
    }
    public function store(CreateCarRequest $request)
    {
        $car = new Car;
        $car->fill($request->all());
        $car->save();
        return $this->response()->created();
    }
    public function delete(Car $car)
    {
        return $car->delete();
    }
    public function addComment(CreateCommentRequest $request, Car $car){
        $comment = new Comment;
        $comment->fill($request->except("user"));
        $comment->commentable()->associate($car);
        if($request->has("user"))
            $user = User::find($request->get("user"));
        else
            $user = $request->user();
        $comment->user()->associate($user);
        $comment->save();
        return $comment;
    }
    public function showComment(Request $request, Comment $comment){
      return $comment;
    }
    public function removeComment(Request $request, Comment $comment){
      $comment->delete();
    }
}
