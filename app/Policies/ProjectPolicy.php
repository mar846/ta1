<?php

namespace App\Policies;

use App\User;
use App\ProjectController;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any project controllers.
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
     * Determine whether the user can view the project controller.
     *
     * @param  \App\User  $user
     * @param  \App\ProjectController  $projectController
     * @return mixed
     */
    public function view(User $user, ProjectController $projectController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can create project controllers.
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
     * Determine whether the user can update the project controller.
     *
     * @param  \App\User  $user
     * @param  \App\ProjectController  $projectController
     * @return mixed
     */
    public function update(User $user, ProjectController $projectController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can delete the project controller.
     *
     * @param  \App\User  $user
     * @param  \App\ProjectController  $projectController
     * @return mixed
     */
    public function delete(User $user, ProjectController $projectController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can restore the project controller.
     *
     * @param  \App\User  $user
     * @param  \App\ProjectController  $projectController
     * @return mixed
     */
    public function restore(User $user, ProjectController $projectController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the project controller.
     *
     * @param  \App\User  $user
     * @param  \App\ProjectController  $projectController
     * @return mixed
     */
    public function forceDelete(User $user, ProjectController $projectController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }
}
