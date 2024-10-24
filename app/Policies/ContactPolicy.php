<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ContactPolicy
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
    public function view(User $user, Contact $contact): bool
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
    public function update(User $user, Contact $contact): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contact $contact): bool
    {
        return !$contact->hasContactRequests();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contact $contact): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contact $contact): bool
    {
        //
    }

    public function userAccount(User $user, Contact $contact): bool
    {
        return $user->hasPermission(\App\Library\Permission::CONTACT_MANAGE_USER_ACCOUNT);
    }

    public function viewPhoneNumber(User $user): bool
    {
        return Cache::remember('permission_viewPhoneNumber_' . $user->id, now()->addMinutes(1), function () use ($user) {
            return $user->hasPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_VIEW_PHONE);
        });
    }

    public function exportContactRequest(User $user): bool
    {
        return $user->hasPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_EXPORT);
    }
}
