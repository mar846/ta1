<?php

namespace App\Policies;

use App\User;
use App\UnitController;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any unit controllers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can view the unit controller.
     *
     * @param  \App\User  $user
     * @param  \App\UnitController  $unitController
     * @return mixed
     */
    public function view(User $user, UnitController $unitController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can create unit controllers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can update the unit controller.
     *
     * @param  \App\User  $user
     * @param  \App\UnitController  $unitController
     * @return mixed
     */
    public function update(User $user, UnitController $unitController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can delete the unit controller.
     *
     * @param  \App\User  $user
     * @param  \App\UnitController  $unitController
     * @return mixed
     */
    public function delete(User $user, UnitController $unitController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can restore the unit controller.
     *
     * @param  \App\User  $user
     * @param  \App\UnitController  $unitController
     * @return mixed
     */
    public function restore(User $user, UnitController $unitController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the unit controller.
     *
     * @param  \App\User  $user
     * @param  \App\UnitController  $unitController
     * @return mixed
     */
    public function forceDelete(User $user, UnitController $unitController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }
}
