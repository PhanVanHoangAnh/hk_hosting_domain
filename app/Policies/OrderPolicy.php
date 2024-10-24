<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        return $order->isDraft() 
        || $order->isRejected() 
        || ($user->isAlias(\App\Models\Role::ALIAS_SYSTEM_MANAGER) 
            && $order->isImported()  
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return $order->isDraft() && $order->sale == $user->account_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        //
    }

    public function requestApproval(User $user, Order $order): bool
    {
        return $order->isDraft() && ($user->can('changeBranch', User::class) || $order->sale == $user->account_id) && !$order->isRequestDemo();
    }
    

    public function approve(User $user, Order $order): bool
    {
        return $order->isPending();
    }

    public function reject(User $user, Order $order): bool
    {
        return $order->isPending();
    }

    public function confirmRequestDemo(User $user, Order $order): bool
    {
        return  ($order->sale == $user->account_id || $user->can('changeBranch', User::class)) && $order->isRequestDemo() && $order->isDraft();
    }

    public function copy(User $user, Order $order): bool
    {
        return true;
    }
}
