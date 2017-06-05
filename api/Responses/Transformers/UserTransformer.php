<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:17
 */

namespace Api\Responses\Transformers;

use Lib\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
  public function transform(User $user)
  {
    $sex = $user->sex ? "male" : "female";
    return array_merge($user->toArray(),[
      "sex"=>$sex,
      "profile_image"=>$user->profileImage()->url()
    ]);//put data to be transformed in last array, this way we always have the right model data
  }
}
