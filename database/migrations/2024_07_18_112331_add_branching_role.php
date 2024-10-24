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
        $managerHNSalesRole = Role::addRole(Module::SALES, Role::ALIAS_SALES_MANAGER_HN, 'Quản lý chi nhánh Hà Nội');
        $managerSGSalesRole = Role::addRole(Module::SALES, Role::ALIAS_SALES_MANAGER_SG, 'Quản lý chi nhánh Sài Gòn');

        $managerHNAccountingRole = Role::addRole(Module::ACCOUNTING, Role::ALIAS_ACCOUNTANT_MANAGER_HN, 'Quản lý chi nhánh Hà Nội');
        $managerSGAccountingRole = Role::addRole(Module::ACCOUNTING, Role::ALIAS_ACCOUNTANT_MANAGER_SG, 'Quản lý chi nhánh Sài Gòn');

        $managerHNEduRole = Role::addRole(Module::EDU, Role::ALIAS_EDU_MANAGER_HN, 'Quản lý chi nhánh Hà Nội');
        $managerSGEduRole = Role::addRole(Module::EDU, Role::ALIAS_EDU_MANAGER_SG, 'Quản lý chi nhánh Sài Gòn');

        $managerHNEduRole = Role::addRole(Module::EDU, Role::ALIAS_EDU_MANAGER_HN, 'Quản lý chi nhánh Hà Nội');
        $managerSGEduRole = Role::addRole(Module::EDU, Role::ALIAS_EDU_MANAGER_SG, 'Quản lý chi nhánh Sài Gòn');

        $managerHNAbroadRole = Role::addRole(Module::ABROAD, Role::ALIAS_ABROAD_MANAGER_HN, 'Quản lý chi nhánh Hà Nội');
        $managerSGAbroadRole = Role::addRole(Module::ABROAD, Role::ALIAS_ABROAD_MANAGER_SG, 'Quản lý chi nhánh Sài Gòn');

        $managerHNExtraRole = Role::addRole(Module::EXTRACURRICULAR, Role::ALIAS_EXTRACURRICULAR_MANAGER_HN, 'Quản lý chi nhánh Hà Nội');
        $managerSGExtraRole = Role::addRole(Module::EXTRACURRICULAR, Role::ALIAS_EXTRACURRICULAR_MANAGER_SG, 'Quản lý chi nhánh Sài Gòn');

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
