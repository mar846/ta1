<?php

namespace App\Policies;

use App\User;
use App\Deliver;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliverPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any delivers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '10',
      ]);
    }

    /**
     * Determine whether the user can view the deliver.
     *
     * @param  \App\User  $user
     * @param  \App\Deliver  $deliver
     * @return mixed
     */
    public function view(User $user, Deliver $deliver)
    {
      return in_array($user->role_id,[
        '1',
        '10',
      ]);
    }

    /**
     * Determine whether the user can create delivers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '10',
      ]);
    }

    /**
     * Determine whether the user can update the deliver.
     *
     * @param  \App\User  $user
     * @param  \App\Deliver  $deliver
     * @return mixed
     */
    public function update(User $user, Deliver $deliver)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can delete the deliver.
     *
     * @param  \App\User  $user
     * @param  \App\Deliver  $deliver
     * @return mixed
     */
    public function delete(User $user, Deliver $deliver)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can restore the deliver.
     *
     * @param  \App\User  $user
     * @param  \App\Deliver  $deliver
     * @return mixed
     */
    public function restore(User $user, Deliver $deliver)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the deliver.
     *
     * @param  \App\User  $user
     * @param  \App\Deliver  $deliver
     * @return mixed
     */
    public function forceDelete(User $user, Deliver $deliver)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }
}
