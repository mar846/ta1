<?php

namespace App\Policies;

use App\User;
use App\Catalog;
use Illuminate\Auth\Access\HandlesAuthorization;

class CatalogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any catalogs.
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
     * Determine whether the user can view the catalog.
     *
     * @param  \App\User  $user
     * @param  \App\Catalog  $catalog
     * @return mixed
     */
    public function view(User $user, Catalog $catalog)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can create catalogs.
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
     * Determine whether the user can update the catalog.
     *
     * @param  \App\User  $user
     * @param  \App\Catalog  $catalog
     * @return mixed
     */
    public function update(User $user, Catalog $catalog)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can delete the catalog.
     *
     * @param  \App\User  $user
     * @param  \App\Catalog  $catalog
     * @return mixed
     */
    public function delete(User $user, Catalog $catalog)
    {
        //
    }

    /**
     * Determine whether the user can restore the catalog.
     *
     * @param  \App\User  $user
     * @param  \App\Catalog  $catalog
     * @return mixed
     */
    public function restore(User $user, Catalog $catalog)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the catalog.
     *
     * @param  \App\User  $user
     * @param  \App\Catalog  $catalog
     * @return mixed
     */
    public function forceDelete(User $user, Catalog $catalog)
    {
        //
    }
}
