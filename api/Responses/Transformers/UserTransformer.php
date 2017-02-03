<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.02.2017
 * Time: 13:05
 */

namespace Api\Responses\Transformers;


use App\Group;
use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
  protected $availableIncludes = [
    'group'
  ];
  /**
   * @param User $user
   * @return array
   */
  public function transform(User $user)
  {
    return [
      'id'      => (int) $user->id,
      'firstname'   => $user->firstname,
      'lastname'    => $user->lastname,
      "name"=>$user->name,
      "email"=>$user->email,
      "phone_number"=>$user->phone_number,
      "sex"=>  $user->sex ? "male": "female",
      "role"=> $user->role ? $user->role->name : null,
      //"group"=> $user->group,
      "status"=> $user->status->first() ? $user->status->first()->name : null,
      'links'   => [
        [
          'rel' => 'self',
          'uri' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('users.show',$user)
        ]
      ],
    ];
  }
  
  public function includeGroup(User $user)
  {
    if($user->group != null)
      return $this->item($user->group, new GroupTransformer);
    return $this->null();
  }
  
}