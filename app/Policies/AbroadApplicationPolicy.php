<?php

namespace App\Policies;

use App\Models\AbroadApplication;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class AbroadApplicationPolicy
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
    public function view(User $user, AbroadApplication $abroadApplication): bool
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
    public function update(User $user, AbroadApplication $abroadApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AbroadApplication $abroadApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AbroadApplication $abroadApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AbroadApplication $abroadApplication): bool
    {
        //
    }

    public function handover(User $user, AbroadApplication $abroadApplication): bool
    {
        return $user->isAlias(Role::ALIAS_SYSTEM_MANAGER) || $user->isAlias(Role::ALIAS_ABROAD_MANAGER) || $user->isAlias(Role::ALIAS_ABROAD_LEADER) || $user->isAlias(Role::ALIAS_EXTRACURRICULAR_LEADER) || $user->isAlias(Role::ALIAS_EXTRACURRICULAR_MANAGER) || $user->isAlias(Role::ALIAS_DIRECTOR_ALL) || $user->isAlias(Role::ALIAS_DIRECTOR_BRANCH); 
    }
    
}
