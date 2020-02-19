<?php

namespace App\Policies;

use App\User;
use App\Surveyor;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any surveyor controllers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role_id,[
          '1',
          '3',
          '2',
          '5',
          '4',
        ]);
    }

    /**
     * Determine whether the user can view the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\Surveyor  $surveyor
     * @return mixed
     */
    public function view(User $user, Surveyor $surveyor)
    {
      return in_array($user->role_id,[
          '1',
          '3',
          '2',
          '5',
          '4',
        ]);
    }

    /**
     * Determine whether the user can create surveyor controllers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role_id,[
          '1',
          '3',
          '2',
        ]);
    }

    /**
     * Determine whether the user can update the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\Surveyor  $surveyor
     * @return mixed
     */
    public function update(User $user, Surveyor $surveyor)
    {
      return in_array($user->role_id,[
          '1',
          '3',
          '2',
        ]);
    }

    /**
     * Determine whether the user can delete the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\Surveyor  $surveyor
     * @return mixed
     */
    public function delete(User $user, Surveyor $surveyor)
    {
      return in_array($user->role_id,[
          '1',
          '3',
          '2',
        ]);
    }

    /**
     * Determine whether the user can restore the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\Surveyor  $surveyor
     * @return mixed
     */
    public function restore(User $user, Surveyor $surveyor)
    {
      return in_array($user->role_id,[
          '1',
        ]);
    }

    /**
     * Determine whether the user can permanently delete the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\Surveyor  $surveyor
     * @return mixed
     */
    public function forceDelete(User $user, Surveyor $surveyor)
    {
      return in_array($user->role_id,[
          '1',
        ]);
    }
    public function approve(User $user)
    {
      return in_array($user->role_id,[
          '1',
          '3',
        ]);
    }
    public function approval(User $user, Surveyor $surveyor)
    {
      return in_array($user->role_id,[
          '1',
          '3',
        ]);
    }
}
