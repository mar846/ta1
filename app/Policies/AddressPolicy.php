<?php

namespace App\Policies;

use App\User;
use App\AddressController;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any address controllers.
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
     * Determine whether the user can view the address controller.
     *
     * @param  \App\User  $user
     * @param  \App\AddressController  $addressController
     * @return mixed
     */
    public function view(User $user, AddressController $addressController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can create address controllers.
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
     * Determine whether the user can update the address controller.
     *
     * @param  \App\User  $user
     * @param  \App\AddressController  $addressController
     * @return mixed
     */
    public function update(User $user, AddressController $addressController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can delete the address controller.
     *
     * @param  \App\User  $user
     * @param  \App\AddressController  $addressController
     * @return mixed
     */
    public function delete(User $user, AddressController $addressController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can restore the address controller.
     *
     * @param  \App\User  $user
     * @param  \App\AddressController  $addressController
     * @return mixed
     */
    public function restore(User $user, AddressController $addressController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the address controller.
     *
     * @param  \App\User  $user
     * @param  \App\AddressController  $addressController
     * @return mixed
     */
    public function forceDelete(User $user, AddressController $addressController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }
}
