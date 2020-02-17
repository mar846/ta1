<?php

namespace App\Policies;

use App\User;
use App\DesignerController;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any designer controllers.
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
     * Determine whether the user can view the designer controller.
     *
     * @param  \App\User  $user
     * @param  \App\DesignerController  $designerController
     * @return mixed
     */
    public function view(User $user, DesignerController $designerController)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
        'Designer',
      ]);
    }

    /**
     * Determine whether the user can create designer controllers.
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
     * Determine whether the user can update the designer controller.
     *
     * @param  \App\User  $user
     * @param  \App\DesignerController  $designerController
     * @return mixed
     */
    public function update(User $user, DesignerController $designerController)
    {
      return in_array($user->role,[
        'Admin',
        'Designer',
      ]);
    }

    /**
     * Determine whether the user can delete the designer controller.
     *
     * @param  \App\User  $user
     * @param  \App\DesignerController  $designerController
     * @return mixed
     */
    public function delete(User $user, DesignerController $designerController)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
      ]);
    }

    /**
     * Determine whether the user can restore the designer controller.
     *
     * @param  \App\User  $user
     * @param  \App\DesignerController  $designerController
     * @return mixed
     */
    public function restore(User $user, DesignerController $designerController)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the designer controller.
     *
     * @param  \App\User  $user
     * @param  \App\DesignerController  $designerController
     * @return mixed
     */
    public function forceDelete(User $user, DesignerController $designerController)
    {
      return in_array($user->role,[
        'Admin',
        'DesignerSPV',
      ]);
    }
}
