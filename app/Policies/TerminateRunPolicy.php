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
      if($user->isRole("admin"))
        return true;
    }
    public function end(User $user, Run $run)
    {
      if($this->force($user))
        return true;
      
      if($run->subscriptions()->whereHas("user",function($q) use ($user){
        return $q->where("id",$user->id);
      })->first())
        return true;
      
      return false;
    }
    public function forceEnd(User $user)
    {
      return $user->isRole("coordinator");
    }
    /**
     * Determine whether the user can view the run.
     *
     * @param  \App\User  $user
     * @param  \App\Run  $run
     * @return mixed
     */
    public function view(User $user, Run $run)
    {
        //
    }

    /**
     * Determine whether the user can create runs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the run.
     *
     * @param  \App\User  $user
     * @param  \App\Run  $run
     * @return mixed
     */
    public function update(User $user, Run $run)
    {
        //
    }

    /**
     * Determine whether the user can delete the run.
     *
     * @param  \App\User  $user
     * @param  \App\Run  $run
     * @return mixed
     */
    public function delete(User $user, Run $run)
    {
        //
    }
}
