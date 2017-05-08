<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:25
 */

namespace Api\Responses\Transformers;

use Lib\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
  public $availableIncludes = [
    "schedules",
    "users"
  ];
  public function transform(Group $group)
  {
    return array_merge($group->toArray(),[]);
  }
  public function includeSchedules(Group $group)
  {
    return $this->collection($group->schedules, new ScheduleTransformer);
  }
  public function includeUsers(Group $group)
  {
    return $this->collection($group->users, new UserTransformer);
  }
}