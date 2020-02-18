<?php

namespace App\Policies;

use App\User;
use App\Designer;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any designers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
        'Designer',
      ]);
    }

    /**
     * Determine whether the user can view the designer.
     *
     * @param  \App\User  $user
     * @param  \App\Designer  $designer
     * @return mixed
     */
    public function view(User $user, Designer $designer)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
        'Designer',
      ]);
    }

    /**
     * Determine whether the user can create designers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
        'Designer',
      ]);
    }

    /**
     * Determine whether the user can update the designer.
     *
     * @param  \App\User  $user
     * @param  \App\Designer  $designer
     * @return mixed
     */
    public function update(User $user, Designer $designer)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
        'Designer',
      ]);
    }

    /**
     * Determine whether the user can delete the designer.
     *
     * @param  \App\User  $user
     * @param  \App\Designer  $designer
     * @return mixed
     */
    public function delete(User $user, Designer $designer)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
      ]);
    }

    /**
     * Determine whether the user can restore the designer.
     *
     * @param  \App\User  $user
     * @param  \App\Designer  $designer
     * @return mixed
     */
    public function restore(User $user, Designer $designer)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the designer.
     *
     * @param  \App\User  $user
     * @param  \App\Designer  $designer
     * @return mixed
     */
    public function forceDelete(User $user, Designer $designer)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can approve the designer.
     *
     * @param  \App\User  $user
     * @param  \App\Designer  $designer
     * @return mixed
     */
    public function approve(User $user, Designer $designer)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
      ]);
    }
}
