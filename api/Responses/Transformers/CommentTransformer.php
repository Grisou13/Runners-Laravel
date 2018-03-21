<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:11
 */

namespace Api\Responses\Transformers;

use Dingo\Api\Contract\Http\Request;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;
use Lib\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
  /*public $availableIncludes = [
    "user"
  ];*/
  public $defaultIncludes = [
    "user"
  ];
  public function transform(Comment $comment)
  {
    
    return [
      "id"=>$comment->id,
      "content"=>$comment->content,
      "created_at"=>(string)$comment->created_at,
      
    ];
  }
  
  public function includeUser(Comment $comment)
  {
   
      return $this->item($comment->user, new UserTransformer);
    
  }
}
