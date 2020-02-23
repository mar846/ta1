<?php

namespace App\Policies;

use App\User;
use App\File;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any files.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }

    /**
     * Determine whether the user can view the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function view(User $user, File $file)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }

    /**
     * Determine whether the user can create files.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function update(User $user, File $file)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function delete(User $user, File $file)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }

    /**
     * Determine whether the user can restore the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function restore(User $user, File $file)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function forceDelete(User $user, File $file)
    {
      return in_array($user->role_id,[
        '1',
        '2',
        '3',
        '4',
        '5',
      ]);
    }
}
