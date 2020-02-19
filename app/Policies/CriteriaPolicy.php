<?php

namespace App\Policies;

use App\User;
use App\Criteria;
use Illuminate\Auth\Access\HandlesAuthorization;

class CriteriaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any criterias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can view the criteria.
     *
     * @param  \App\User  $user
     * @param  \App\Criteria  $criteria
     * @return mixed
     */
    public function view(User $user, Criteria $criteria)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can create criterias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can update the criteria.
     *
     * @param  \App\User  $user
     * @param  \App\Criteria  $criteria
     * @return mixed
     */
    public function update(User $user, Criteria $criteria)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can delete the criteria.
     *
     * @param  \App\User  $user
     * @param  \App\Criteria  $criteria
     * @return mixed
     */
    public function delete(User $user, Criteria $criteria)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can restore the criteria.
     *
     * @param  \App\User  $user
     * @param  \App\Criteria  $criteria
     * @return mixed
     */
    public function restore(User $user, Criteria $criteria)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the criteria.
     *
     * @param  \App\User  $user
     * @param  \App\Criteria  $criteria
     * @return mixed
     */
    public function forceDelete(User $user, Criteria $criteria)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }
}
