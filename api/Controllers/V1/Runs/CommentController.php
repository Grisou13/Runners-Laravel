<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 01.05.2017
 * Time: 21:00
 */

namespace Api\Controllers\V1\Runs;


use Api\Controllers\BaseController;
use Dingo\Api\Http\Request;
use Lib\Models\Comment;
use Lib\Models\Run;

class CommentController extends BaseController
{
  public function index(Request $request, Run $run)
  {
    return $run->comments;
  }
  public function store(Request $request, Run $run)
  {
    $comment = new Comment;
    $comment->fill($request->except("_token"));
    $comment->commentable()->associate($run);
    //TODO refactor this to authorize only coordinators and up to add a user to a comment
    if($request->has("user"))
      $user = $request->get("user");
    else
      $user = $this->user();
    $comment->user()->associate($user);
    $comment->save();
    return $comment;
  }
}