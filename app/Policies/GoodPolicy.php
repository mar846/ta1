<?php

namespace App\Policies;

use App\User;
use App\Good;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any goods.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '5',
        '4',
      ]);
    }

    /**
     * Determine whether the user can view the good.
     *
     * @param  \App\User  $user
     * @param  \App\Good  $good
     * @return mixed
     */
    public function view(User $user, Good $good)
    {
      return in_array($user->role_id,[
        '1',
        '5',
        '4',
      ]);
    }

    /**
     * Determine whether the user can create goods.
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
     * Determine whether the user can update the good.
     *
     * @param  \App\User  $user
     * @param  \App\Good  $good
     * @return mixed
     */
    public function update(User $user, Good $good)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can delete the good.
     *
     * @param  \App\User  $user
     * @param  \App\Good  $good
     * @return mixed
     */
    public function delete(User $user, Good $good)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can restore the good.
     *
     * @param  \App\User  $user
     * @param  \App\Good  $good
     * @return mixed
     */
    public function restore(User $user, Good $good)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the good.
     *
     * @param  \App\User  $user
     * @param  \App\Good  $good
     * @return mixed
     */
    public function forceDelete(User $user, Good $good)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }
}
