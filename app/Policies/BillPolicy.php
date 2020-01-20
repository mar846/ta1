<?php

namespace App\Policies;

use App\User;
use App\BillOfMaterial;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any bill of material controllers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the bill of material controller.
     *
     * @param  \App\User  $user
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return mixed
     */
    public function view(User $user, BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Determine whether the user can create bill of material controllers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the bill of material controller.
     *
     * @param  \App\User  $user
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return mixed
     */
    public function update(User $user, BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Determine whether the user can delete the bill of material controller.
     *
     * @param  \App\User  $user
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return mixed
     */
    public function delete(User $user, BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Determine whether the user can restore the bill of material controller.
     *
     * @param  \App\User  $user
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return mixed
     */
    public function restore(User $user, BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the bill of material controller.
     *
     * @param  \App\User  $user
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return mixed
     */
    public function forceDelete(User $user, BillOfMaterial $billOfMaterial)
    {
        //
    }
}
