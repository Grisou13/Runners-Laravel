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
use Illuminate\Database\Eloquent\Model;
use Lib\Models\Comment;
use Lib\Models\Run;

class CommentController extends BaseController
{
  public function index(Request $request, Run $run)
  {
    return $run->comments;
  }
  public function show(Request $request, Comment $comment)
  {
    return $comment;
  }
  public function store(Request $request, Run $run)
  {
    $comment = new Comment;
    $comment->fill($request->except("_token"));
    $comment->commentable()->associate($run);
    $user = $this->user();
    $comment->user()->associate($user);
    $comment->save();
    return $comment;
  }
  public function update(Request $request, Comment $comment)
  {
    $comment->update($request->except(["token","_token"]));
    return $comment;
  }
}
