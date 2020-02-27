<?php

namespace App\Policies;

use App\User;
use App\Receipt;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any receipts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '10',
      ]);
    }

    /**
     * Determine whether the user can view the receipt.
     *
     * @param  \App\User  $user
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function view(User $user, Receipt $receipt)
    {
      return in_array($user->role_id,[
        '1',
        '10',
      ]);
    }

    /**
     * Determine whether the user can create receipts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return in_array($user->role_id,[
        '1',
        '10',
      ]);
    }

    /**
     * Determine whether the user can update the receipt.
     *
     * @param  \App\User  $user
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function update(User $user, Receipt $receipt)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can delete the receipt.
     *
     * @param  \App\User  $user
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function delete(User $user, Receipt $receipt)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can restore the receipt.
     *
     * @param  \App\User  $user
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function restore(User $user, Receipt $receipt)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }

    /**
     * Determine whether the user can permanently delete the receipt.
     *
     * @param  \App\User  $user
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function forceDelete(User $user, Receipt $receipt)
    {
      return in_array($user->role_id,[
        '1',
      ]);
    }
}
