<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;

use Lib\Models\Car;
use Lib\Models\User;
use Lib\Models\Comment;
use Api\Controllers\BaseController;
use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarController extends BaseController
{
    public function index(Request $request)
    {
      return Car::all();
    }
    public function show(Request $request, Car $car)
    {
      return $car;
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->all());
        $car->save();
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
