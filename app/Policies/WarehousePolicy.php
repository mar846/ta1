<?php

namespace App\Policies;

use App\User;
use App\Warehouse;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehousePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any warehouses.
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
     * Determine whether the user can view the warehouse.
     *
     * @param  \App\User  $user
     * @param  \App\Warehouse  $warehouse
     * @return mixed
     */
    public function view(User $user, Warehouse $warehouse)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can create warehouses.
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
     * Determine whether the user can update the warehouse.
     *
     * @param  \App\User  $user
     * @param  \App\Warehouse  $warehouse
     * @return mixed
     */
    public function update(User $user, Warehouse $warehouse)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can delete the warehouse.
     *
     * @param  \App\User  $user
     * @param  \App\Warehouse  $warehouse
     * @return mixed
     */
    public function delete(User $user, Warehouse $warehouse)
    {
        //
    }

    /**
     * Determine whether the user can restore the warehouse.
     *
     * @param  \App\User  $user
     * @param  \App\Warehouse  $warehouse
     * @return mixed
     */
    public function restore(User $user, Warehouse $warehouse)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the warehouse.
     *
     * @param  \App\User  $user
     * @param  \App\Warehouse  $warehouse
     * @return mixed
     */
    public function forceDelete(User $user, Warehouse $warehouse)
    {
        //
    }
}
