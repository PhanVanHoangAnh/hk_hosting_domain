<?php

namespace App\Policies;

use App\Models\ContactRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContactRequestPolicy
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
    public function view(User $user, ContactRequest $contactRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContactRequest $contactRequest): bool
    {
        return !$contactRequest->hasOrders();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContactRequest $contactRequest): bool
    {
        return !$contactRequest->hasOrders();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContactRequest $contactRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContactRequest $contactRequest): bool
    {
        //
    }

    public function updateLeadStatus(User $user, ContactRequest $contactRequest): bool
    {
        return !in_array($contactRequest->lead_status, [
            ContactRequest::LS_MAKING_CONSTRACT,
            ContactRequest::LS_HAS_CONSTRACT,
        ]);
    }
}
