<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.02.2017
 * Time: 14:54
 */

namespace Api\Responses\Transformers;


use App\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
  public function transform(Group $group)
  {
    return [
      "name"=>$group->name
    ];
  }
}