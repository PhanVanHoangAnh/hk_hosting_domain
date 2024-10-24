<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $supervisorRole = \App\Models\Role::where('module', \App\Library\Module::MARKETING)
            ->where('alias', \App\Models\Role::ALIAS_MARKETING_SUPERVISOR)
            ->first();

        $managerRole = \App\Models\Role::where('module', \App\Library\Module::MARKETING)
            ->where('alias', \App\Models\Role::ALIAS_MARKETING_MANAGER)
            ->first();

        $adminRole = \App\Models\Role::where('module', \App\Library\Module::SYSTEM)
            ->where('alias', \App\Models\Role::ALIAS_SYSTEM_MANAGER)
            ->first();

        // add permissions
        $managerRole->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_EXPORT);
        $managerRole->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_VIEW_PHONE);

        // add permission
        $adminRole->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_EXPORT);
        $adminRole->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_VIEW_PHONE);

        // add permission
        $supervisorRole->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_VIEW_PHONE);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
