<?php

namespace App\Policies;

use App\Models\User;

class BranchPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function changeBranch(User $user): bool
    {
        return $user->hasPermission(\App\Library\Permission::CHANGE_TO_SG)  || $user->hasPermission(\App\Library\Permission::CHANGE_TO_HN);
    }
    public function changeToHN(User $user): bool
    {
        return \App\Library\Branch::getCurrentBranch() !== \App\Library\Branch::BRANCH_HN && $user->hasPermission(\App\Library\Permission::CHANGE_TO_HN);
    }
    public function changeToSG(User $user): bool
    {
        return \App\Library\Branch::getCurrentBranch() !== \App\Library\Branch::BRANCH_SG && $user->hasPermission(\App\Library\Permission::CHANGE_TO_SG);
    }
    public function changeToSGAndHN(User $user): bool
    {
        return \App\Library\Branch::getCurrentBranch() !== \App\Library\Branch::BRANCH_ALL && $user->hasPermission(\App\Library\Permission::CHANGE_TO_SG)  && $user->hasPermission(\App\Library\Permission::CHANGE_TO_HN);
    }
}
