<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 14.06.2017
 * Time: 12:12
 */

namespace Api\Controllers\V1\Cars;


use Illuminate\Http\Request;
use Lib\Models\Car;

class CommentController
{
  public function index(Request $request, Car $car)
  {
    return $car->comments;
  }
  public function store(Request $request, Car $car)
  {
	/*
	$comment = new \Lib\Models\Comment();
	$comment->content = $request->input("content");
	$comment->user()->associate(app('Dingo\Api\Auth\Auth')->user());
	$comment->commentable()->save($car);*/
	$comment = $car->comments()->create(["content"=>$request->input("content"), "user_id" =>app('Dingo\Api\Auth\Auth')->user()->id]);
	return $comment;
  }
  public function destroy(Request $request, Car $car)
  {
    
  }
  public function update(Request $request, Car $car)
  {
    
  }
}
