<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Library\Module;
use App\Models\Role;
use App\Library\Permission; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $reporterRole = Role::addRole(Module::MARKETING, Role::ALIAS_MARKETING_REPORTER, 'Reporter');

        // Define permissions
        $permissions = [
            Permission::MARKETING_CUSTOMER,
            Permission::MARKETING_CONTACT_REQUEST_ADD,
            Permission::MARKETING_CONTACT_REQUEST_UPDATE,
            Permission::MARKETING_CONTACT_REQUEST_EXPORT,
           
        ];

        // Attach permissions to the role
        foreach ($permissions as $permission) {
            $reporterRole->addPermission($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
