<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Lib\Models\Run;
use Lib\Models\User;

class TerminateRunPolicy
{
    use HandlesAuthorization;
    public function before(User $user, $ability)
    {
      if($user->hasPermissionTo("force run end"))
        return true;
    }

  /**
   * Tells if the user can end a run
   * He can if he is part of the run, or is a coordinator
   * @param User $user
   * @param Run $run
   * @return bool
   */
    public function end(User $user, Run $run)
    {
      if($run->subscriptions()->whereHas("user",function($q) use ($user){
        return $q->where("id",$user->id);
      })->first())
        return true;
      
      return false;
    }
    public function forceEnd(User $user)
    {
      return $user->hasAnyRole(["coordinator","admin"]);
    }

}
