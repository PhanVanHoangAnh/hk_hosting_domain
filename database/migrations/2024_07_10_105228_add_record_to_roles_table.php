<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Role; 
use App\Library\Permission; 
use App\Library\Module; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        $adminRole = Role::create([
            'name' => 'Admin',
            'module' => Module::EXTRACURRICULAR,
            
        ]);
        $adminRole->alias = Role::ALIAS_EXTRACURRICULAR_ADMIN;
        $adminRole->save();
        
        $permissions = [
            Permission::EXTRACURRICULAR_GENERAL,
            Permission::EXTRACURRICULAR_ALL,
            Permission::EXTRACURRICULAR_DETAIL,
            Permission::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT,
            Permission::EXTRACURRICULAR_MANAGE_ALL,
            Permission::EXTRACURRICULAR_MANAGE_LIST,
            Permission::EXTRACURRICULAR_MANAGE_UPDATE,
            Permission::EXTRACURRICULAR_MANAGE_STUDENT,
            Permission::EXTRACURRICULAR_MANAGE_STUDENT_ADD,
            Permission::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE,
            Permission::EXTRACURRICULAR_STUDENT_PROFILE,
            Permission::EXTRACURRICULAR_ORDER_ALL,
            Permission::EXTRACURRICULAR_ORDER_ADD,
            Permission::EXTRACURRICULAR_ORDER_DELETE,
            Permission::EXTRACURRICULAR_ORDER_LIST,
            Permission::EXTRACURRICULAR_ORDER_SHOW_CONTRACT,
            Permission::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT,
        
        ];

        
        foreach ($permissions as $permission) {
            $adminRole->addPermission($permission);
        }
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $adminRole = Role::where('name', 'Admin')
            ->where('module', Module::EXTRACURRICULAR)
            ->where('alias', Role::ALIAS_EXTRACURRICULAR_ADMIN)
            ->first();

        
        if ($adminRole) {
            $adminRole->permissions()->detach();
        }

        
        if ($adminRole) {
            $adminRole->delete();
        }
    }
};
