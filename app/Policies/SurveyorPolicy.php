<?php

namespace App\Policies;

use App\User;
use App\SurveyorController;
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

        return in_array($user->role,[
          'Admin',
          'SurveyorSPV',
          'Surveyor',
          'DesignerSPV',
          'Designer',
        ]);
    }

    /**
     * Determine whether the user can view the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyorController  $surveyorController
     * @return mixed
     */
    public function view(User $user, SurveyorController $surveyorController)
    {

        return in_array($user->role,[
          'Admin',
          'SurveyorSPV',
          'Surveyor',
          'DesignerSPV',
          'Designer',
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

        return in_array($user->role,[
          'Admin',
          'SurveyorSPV',
          'Surveyor',
        ]);
    }

    /**
     * Determine whether the user can update the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyorController  $surveyorController
     * @return mixed
     */
    public function update(User $user, SurveyorController $surveyorController)
    {

        return in_array($user->role,[
          'Admin',
          'SurveyorSPV',
          'Surveyor',
        ]);
    }

    /**
     * Determine whether the user can delete the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyorController  $surveyorController
     * @return mixed
     */
    public function delete(User $user, SurveyorController $surveyorController)
    {

        return in_array($user->role,[
          'Admin',
          'SurveyorSPV',
          'Surveyor',
        ]);
    }

    /**
     * Determine whether the user can restore the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyorController  $surveyorController
     * @return mixed
     */
    public function restore(User $user, SurveyorController $surveyorController)
    {

        return in_array($user->role,[
          'Admin',
        ]);
    }

    /**
     * Determine whether the user can permanently delete the surveyor controller.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyorController  $surveyorController
     * @return mixed
     */
    public function forceDelete(User $user, SurveyorController $surveyorController)
    {

        return in_array($user->role,[
          'Admin',
        ]);
    }
}
