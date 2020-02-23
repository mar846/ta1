<?php

namespace App\Policies;

use App\User;
use App\Specification;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecificationPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any specifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the specification.
     *
     * @param  \App\User  $user
     * @param  \App\Specification  $specification
     * @return mixed
     */
    public function view(User $user, Specification $specification)
    {
        //
    }

    /**
     * Determine whether the user can create specifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the specification.
     *
     * @param  \App\User  $user
     * @param  \App\Specification  $specification
     * @return mixed
     */
    public function update(User $user, Specification $specification)
    {
        //
    }

    /**
     * Determine whether the user can delete the specification.
     *
     * @param  \App\User  $user
     * @param  \App\Specification  $specification
     * @return mixed
     */
    public function delete(User $user, Specification $specification)
    {
        //
    }

    /**
     * Determine whether the user can restore the specification.
     *
     * @param  \App\User  $user
     * @param  \App\Specification  $specification
     * @return mixed
     */
    public function restore(User $user, Specification $specification)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the specification.
     *
     * @param  \App\User  $user
     * @param  \App\Specification  $specification
     * @return mixed
     */
    public function forceDelete(User $user, Specification $specification)
    {
        //
    }
}
