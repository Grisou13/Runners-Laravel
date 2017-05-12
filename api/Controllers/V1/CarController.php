<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;

use Api\Requests\SearchRequest;
use App\Helpers\Status;
use App\Http\Requests\CreateCommentRequest;
use Api\Requests\ListCarRequest;
use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\User;
use Lib\Models\Comment;
use Api\Controllers\BaseController;
use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarController extends BaseController
{
    public function type(Car $car)
    {
      return $car->car_type;
    }
    public function search(SearchRequest $request)
    {
      $query = $request->get("q","");
      return Car::where("name","like","%$query%")->get();
    }
    public function index(ListCarRequest $request)
    {
      $query = Car::with("car_type");
      if($request->has("type"))
      {
        $query->whereHas("car_type",function($q) use ($request){
          $q->whereIn("name",explode(",",$request->get("type")));
        });
      }
      if($request->has("status"))
      {
        $query->ofStatus($request->get("status"));
      }
      /*
       * In the following requests we use id's instead of retrieving the object.
       * This allows us to be much more efficient when filtering query like this
       */
      if($request->has("between"))
      {
        $runs = Run::whenBetween(explode(",",$request->get("between")))->has("cars")->get();
        $cars = $runs->map(function($r){
          return $r->subscriptions->map(function($s){
            return $s->car_id ? $s->car_id : null;
          });
        })->filter(function($c){
          return $c != null;
        });
        $query->whereIn("id",$cars->all());
      }
      if($request->has("after"))
      {
        $runs = Run::when($request->get("after"))->has("cars")->get();
        $cars = $runs->map(function($r){
          return $r->subscriptions->map(function($s){
            return $s->car_id ? $s->car_id : null;
          });
        })->filter(function($c){
          return $c != null;
        });
        $query->whereIn("id",$cars->all());
      }

      return $query->get();

    }
    public function show(Request $request, Car $car)
    {
      return $car;
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->all());
        if($request->has("car_type"))
        {
          $car->car_type()->associate($request->get("car_type"));
        }
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
    public function showAllComments(Request $request, Car $car){
      return $car->comments;
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
