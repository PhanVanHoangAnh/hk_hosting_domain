<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
    public function view(User $user, User $model): bool
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
    public function update(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }

    public function changeBranch(User $user): bool
    {
        return $user->isAlias(Role::ALIAS_SYSTEM_MANAGER) || $user->isAlias(Role::ALIAS_MARKETING_MANAGER) || $user->isAlias(Role::ALIAS_ACCOUNTANT_MANAGER) || $user->isAlias(Role::ALIAS_ABROAD_MANAGER) || $user->isAlias(Role::ALIAS_EXTRACURRICULAR_LEADER );
    }

    //Giám đốc và quản lý bộ phận
    public function leaderEdu(User $user): bool
    {
        return $user->isAlias(Role::ALIAS_SYSTEM_MANAGER) || $user->isAlias(Role::ALIAS_EDU_DIRECTOR) || $user->isAlias(Role::ALIAS_EDU_MANAGER) || $user->isAlias(Role::ALIAS_EDU_LEADER) ;
    }

    // Trưởng nhóm
    public function manager(User $user): bool
    {
        return $user->isAlias(Role::ALIAS_EXTRACURRICULAR_MANAGER) || $user->isAlias(Role::ALIAS_ABROAD_LEADER) || $user->isAlias(Role::ALIAS_SALES_LEADER) || $user->isAlias(Role::ALIAS_EDU_LEADER_GROUP);
    }
    public function mentor(User $user): bool
    {
        return $user->isAlias(Role::ALIAS_SALES_MENTOR) ;
    }
    public function adminExtracurricular(User $user): bool
    {
        return $user->isAlias(Role::ALIAS_EXTRACURRICULAR_ADMIN) ;
    }
}

