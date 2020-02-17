<?php

namespace App\Policies;

use App\User;
use App\GoodsController;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any goods controllers.
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
     * Determine whether the user can view the goods controller.
     *
     * @param  \App\User  $user
     * @param  \App\GoodsController  $goodsController
     * @return mixed
     */
    public function view(User $user, GoodsController $goodsController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can create goods controllers.
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
     * Determine whether the user can update the goods controller.
     *
     * @param  \App\User  $user
     * @param  \App\GoodsController  $goodsController
     * @return mixed
     */
    public function update(User $user, GoodsController $goodsController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can delete the goods controller.
     *
     * @param  \App\User  $user
     * @param  \App\GoodsController  $goodsController
     * @return mixed
     */
    public function delete(User $user, GoodsController $goodsController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can restore the goods controller.
     *
     * @param  \App\User  $user
     * @param  \App\GoodsController  $goodsController
     * @return mixed
     */
    public function restore(User $user, GoodsController $goodsController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the goods controller.
     *
     * @param  \App\User  $user
     * @param  \App\GoodsController  $goodsController
     * @return mixed
     */
    public function forceDelete(User $user, GoodsController $goodsController)
    {
      return in_array($user->role,[
        'Admin',
      ]);
    }
}
