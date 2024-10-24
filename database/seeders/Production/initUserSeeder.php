<?php

namespace Database\Seeders\Production;

use App\Library\Branch;
use App\Library\Module;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AccountGroup;
use App\Models\Role;
use App\Models\ExcelData;

class initUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // cleanup all account groups
        AccountGroup::query()->delete();

        // cleanup all roles
        Role::query()->delete();

        // cleanup all roles
        User::query()->delete();

        // create default roles
        $this->createDefaultRoles();
        
        // Super Admin
        $this->addStaff(['Ethan Nguyễn', Module::SYSTEM, 'Quản trị viên', 'ethan.nguyen@asms.com', '84976009003', null, null, Branch::BRANCH_HN, Account::STATUS_ACTIVE, null]);
        $this->addStaff(['ASMS Admin', Module::SYSTEM, 'Quản trị viên', 'admin@asms.com', '84976009003', null, null, Branch::BRANCH_HN, Account::STATUS_ACTIVE, null]);
        $this->addStaff(['Ms. Đức', Module::SYSTEM, 'Quản trị viên', 'ductt@americanstudy.edu.vn', '84976009003', null, null, Branch::BRANCH_HN, Account::STATUS_ACTIVE, null]);
        $this->addStaff(['Admin', Module::SYSTEM, 'Quản trị viên', 'hki@asms.com', '84976009003', null, null, Branch::BRANCH_HN, Account::STATUS_ACTIVE, null]);

        // Sale mặc định
        $this->addStaff(['Sales Default', Module::SALES, 'Nhân viên', 'sales@asms.com', null, null, null, Branch::BRANCH_HN, Account::STATUS_ACTIVE, null]);

        // // Ms Duc
        // $this->addStaff(['Ms Đức', Module::SALES, 'Quản lý bộ phận', 'duc@asms.com', null, null, null]);

        // // Ms Truc
        // $this->addStaff(['Ms Trúc', Module::SALES, 'Nhân viên', 'truc@asms.com', null, null, null]);

        // // Mr Nhan
        // $this->addStaff(['Mr Nhân', Module::MARKETING, 'Nhân viên', 'truc@asms.com', null, null, null]);

        // // Ms Hien
        // $this->addStaff(['Ms Hien', Module::ACCOUNTING, 'Nhân viên', 'hien@asms.com', null, null, null]);

        // // Phạm Thị Tuyên
        // $this->addStaff(['Phạm Thị Tuyên', Module::DIRECTOR, 'Quản lý chung', 'dangtuyen19@yahoo.com.vn', null, null, null]);

        // // Nguyễn Thị Tuyết
        // $this->addStaff(['Nguyễn Thị Tuyết', Module::DIRECTOR, 'Quản lý chung', 'tracy.americanstudy@gmail.com', null, null, null]);

        // // Phạm Thành Đức
        // $this->addStaff(['Phạm Thành Đức', Module::DIRECTOR, 'Quản lý chung', 'ducpt@americanstudy.edu.vn', null, null, null]);

        // all users from init data
        $excelFile = new ExcelData();
        $staffData = $excelFile->getDataFromSheet(ExcelData::STAFF_SHEET_NAME, 2);

        foreach($staffData as $data) 
        {
            $this->addStaff($data);
        }
    }

    public function createDefaultRoles()
    {
        // default
        $role = Role::create([
            'name' => 'Quản trị viên',
            'module' => Module::SYSTEM,
            'alias' => Role::ALIAS_SYSTEM_MANAGER,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_ALL);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $role->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_GENERAL);
        $role->addPermission(\App\Library\Permission::EDU_GENERAL);
        $role->addPermission(\App\Library\Permission::SYSTEM_ADMIN);
        $role->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $role->addPermission(\App\Library\Permission::ABROAD_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MANAGE);
        $role->addPermission(\App\Library\Permission::CONTACT_MANAGE_USER_ACCOUNT);
        $role->addPermission(\App\Library\Permission::TEACHER_MANAGE_USER_ACCOUNT);

        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_UPDATE);

        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_ALL);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_BRANCH_ALL);

        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $role->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $role->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $role->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);





        //Kế toán
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_HISTORY_REJECTED);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_SHOW_CONTRACT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_REJECT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_LIST); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_IMPORT_EXCEL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_LIST);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_EXPORT_PDF); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_SHOW_PAYMENT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_UPDATE);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_DELETE); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_EXCEL);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_EXCEL);

        //Du học
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_HANDOVER);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_LIST);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAITING);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ASSIGNED_ACCOUNT);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAIT_FOR_APPROVAL);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_APPROVED);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_DONE);

        $role->addPermission(\App\Library\Permission::ABROAD_STUDENT_PROFILE);

        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_ADD);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_UPDATE);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_DELETE);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_LIST);

        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_LIST);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ACTIVE);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DONE);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DESTROY);

        $role->addPermission(\App\Library\Permission::ABROAD_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ABROAD_REPORT_EXCEL);




        //Ngoại khóa
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_HANDOVER);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_DETAIL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_WAITING);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST);


        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_LIST); 
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ADD);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_UPDATE);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_DELETE);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_ADD);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE);

        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_STUDENT_PROFILE);

        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ADD);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_DELETE);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_LIST);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_SHOW_CONTRACT); 
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT);
        



        // marketing
        $roleMarketing = Role::create([
            'name' => 'Nhân viên',
            'module' => Module::MARKETING,
            'alias' => Role::ALIAS_MARKETING_STAFF,
        ]);

        // Permissions
        $roleMarketing->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);
        $roleMarketing->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_ADD);
        $roleMarketing->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_UPDATE);

        // marketing leader
        $role = Role::create([
            'name' => 'Trưởng nhóm',
            'module' => Module::MARKETING,
            'alias' => Role::ALIAS_MARKETING_LEADER,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_UPDATE);

        // marketing manager
        $role = Role::create([
            'name' => 'Quản lý bộ phận',
            'module' => Module::MARKETING,
            'alias' => Role::ALIAS_MARKETING_MANAGER,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_UPDATE);

        // sales
        $roleSales = Role::create([
            'name' => 'Nhân viên',
            'module' => Module::SALES,
            'alias' => Role::ALIAS_SALESPERSON,
        ]);

        // Permissions
        $roleSales->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $roleSales->addPermission(\App\Library\Permission::CONTACT_MANAGE_USER_ACCOUNT);

        $roleSales->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);

        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $roleSales->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $roleSales->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $roleSales->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $roleSales->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $roleSales->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $roleSales->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $roleSales->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $roleSales->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $roleSales->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $roleSales->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $roleSales->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $roleSales->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $roleSales->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $roleSales->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSales->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $roleSales->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $roleSales->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $roleSales->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $roleSales->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $roleSales->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $roleSales->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);
      

        
        // sales leader
        $roleSalesManager = Role::create([
            'name' => 'Trưởng nhóm',
            'module' => Module::SALES,
            'alias' => Role::ALIAS_SALES_LEADER,
        ]);

        // Permissions
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MANAGE);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_DASHBOARD_MANAGER);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);

        // sales manager
        $roleSalesManager = Role::create([
            'name' => 'Quản lý bộ phận',
            'module' => Module::SALES,
            'alias' => Role::ALIAS_SALES_MANAGER,
        ]);

        // Permissions
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_DASHBOARD_ALL); 
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MANAGE);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_DASHBOARD_MANAGER);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);

         // sales mentor
         $roleSalesMentor = Role::create([
            'name' => 'Mentor',
            'module' => Module::SALES,
            'alias' => Role::ALIAS_SALES_MENTOR,
        ]);

        // Permissions
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MENTOR);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_DASHBOARD_MENTOR);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $roleSalesMentor->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);








        // accountant
        $role = Role::create([
            'name' => 'Nhân viên',
            'module' => Module::ACCOUNTING,
            'alias' => Role::ALIAS_ACCOUNTANT,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::ACCOUNTING_GENERAL);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_HISTORY_REJECTED);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_SHOW_CONTRACT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_REJECT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_LIST); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_IMPORT_EXCEL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_LIST);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_EXPORT_PDF); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_SHOW_PAYMENT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_UPDATE);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_DELETE); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_EXCEL);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_EXCEL);

        // accountant manager
        $role = Role::create([
            'name' => 'Quản lý bộ phận',
            'module' => Module::ACCOUNTING,
            'alias' => Role::ALIAS_ACCOUNTANT_MANAGER,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::ACCOUNTING_GENERAL);


        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_HISTORY_REJECTED);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_SHOW_CONTRACT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_REJECT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_LIST); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_IMPORT_EXCEL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_LIST);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_EXPORT_PDF); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_SHOW_PAYMENT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_UPDATE);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_DELETE); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_EXCEL);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_EXCEL);




        // Học viên
        $roleStudent = Role::create([
            'name' => 'Học Viên',
            'module' => Module::STUDENT,
            'alias' => Role::ALIAS_STUDENT,
        ]);

        // Permissions
        $roleStudent->addPermission(\App\Library\Permission::STUDENT_GENERAL);

        // Giảng viên
        $roleTeacher = Role::create([
            'name' => 'Giảng Viên',
            'module' => Module::TEACHER,
            'alias' => Role::ALIAS_TEACHER,
        ]);

        // Permissions
        $roleTeacher->addPermission(\App\Library\Permission::TEACHER_GENERAL);
        $roleTeacher->addPermission(\App\Library\Permission::TEACHER_SHIFT_ASSIGNMENT);
        $roleTeacher->addPermission(\App\Library\Permission::TEACHER_SECTION);
        



        // Trợ giảng
        $roleTeachingAssistant = Role::create([
            'name' => 'Trợ Giảng',
            'module' => Module::TEACHING_ASSISTANT,
            'alias' => Role::ALIAS_TEACHING_ASSISTANT,
        ]);

        // Permissions
        $roleTeachingAssistant->addPermission(\App\Library\Permission::TEACHING_ASSISTANT_GENERAL);
        $roleTeachingAssistant->addPermission(\App\Library\Permission::TEACHER_GENERAL);
        $roleTeachingAssistant->addPermission(\App\Library\Permission::TEACHER_REPORT_SECTION);
        $roleTeachingAssistant->addPermission(\App\Library\Permission::TEACHER_SHIFT_ASSIGNMENT);
        $roleTeachingAssistant->addPermission(\App\Library\Permission::TEACHER_SECTION);

        // Phòng đạo tạo
        $roleEdu = Role::create([
            'name' => 'Nhân viên',
            'module' => Module::EDU,
            'alias' => Role::ALIAS_EDU_STAFF,
        ]);

        // Permissions
        $roleEdu->addPermission(\App\Library\Permission::EDU_GENERAL);

        
        $roleLeadGroup = Role::create([
            'name' => 'Trưởng nhóm',
            'module' => Module::EDU,
            'alias' => Role::ALIAS_EDU_LEADER_GROUP,
        ]);
        $roleLeadGroup->addPermission(\App\Library\Permission::EDU_GENERAL);

        $roleLead = Role::create([
            'name' => 'Trưởng phòng',
            'module' => Module::EDU,
            'alias' => Role::ALIAS_EDU_LEADER,
        ]);
        // Permissions
        $roleLead->addPermission(\App\Library\Permission::EDU_GENERAL);

        $roleManager = Role::create([
            'name' => 'Quản lý bộ phận',
            'module' => Module::EDU,
            'alias' => Role::ALIAS_EDU_MANAGER,
        ]);

        // Permissions
        $roleManager->addPermission(\App\Library\Permission::EDU_GENERAL);
        
        $roleDirector = Role::create([
            'name' => 'Giám đốc',
            'module' => Module::EDU,
            'alias' => Role::ALIAS_EDU_DIRECTOR,
        ]);

        // Permissions
        $roleDirector->addPermission(\App\Library\Permission::EDU_GENERAL);

        // Phòng du học
        $roleAbroad = Role::create([
            'name' => 'Nhân viên',
            'module' => Module::ABROAD,
            'alias' => Role::ALIAS_ABROAD_STAFF,
        ]);
        
        // Permissions
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_GENERAL);

        //Du học
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ALL);


        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ASSIGNED_ACCOUNT);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAIT_FOR_APPROVAL);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_APPLICATION_APPROVED);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_APPLICATION_DONE);

        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_STUDENT_PROFILE);

        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_COURSES_ALL);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_COURSES_ADD);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_COURSES_UPDATE);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_COURSES_LIST);

        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ALL);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_LIST);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ACTIVE);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DONE);
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DESTROY);
         
        // Phòng du học
        $roleAbroadLead = Role::create([
            'name' => 'Trưởng nhóm',
            'module' => Module::ABROAD,
            'alias' => Role::ALIAS_ABROAD_LEADER,
        ]);
        
        // Permissions
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_MANAGE_ALL);

        //Du học
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ALL);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_HANDOVER);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_LIST);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAITING);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ASSIGNED_ACCOUNT);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAIT_FOR_APPROVAL);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_APPROVED);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_APPLICATION_DONE);

        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_STUDENT_PROFILE);

        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_COURSES_ALL);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_COURSES_ADD);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_COURSES_UPDATE);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_COURSES_DELETE);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_COURSES_LIST);

        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ALL);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_LIST);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ACTIVE);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DONE);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DESTROY);

        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_REPORT_ALL);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_REPORT_LIST);
        $roleAbroadLead->addPermission(\App\Library\Permission::ABROAD_REPORT_EXCEL);

        // Phòng du học
        $roleAbroadManager = Role::create([
            'name' => 'Quản lý bộ phận',
            'module' => Module::ABROAD,
            'alias' => Role::ALIAS_ABROAD_MANAGER,
        ]);
        
        // Permissions
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_MANAGE_ALL);

        //Du học
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ALL);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_HANDOVER);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_LIST);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAITING);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ASSIGNED_ACCOUNT);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAIT_FOR_APPROVAL);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_APPROVED);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_APPLICATION_DONE);

        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_STUDENT_PROFILE);

        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_COURSES_ALL);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_COURSES_ADD);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_COURSES_UPDATE);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_COURSES_DELETE);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_COURSES_LIST);

        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ALL);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_LIST);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ACTIVE);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DONE);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DESTROY);

        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_REPORT_ALL);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_REPORT_LIST);
        $roleAbroadManager->addPermission(\App\Library\Permission::ABROAD_REPORT_EXCEL);



        // Phòng ngoại khóa
        $roleExtra = Role::create([
            'name' => 'Nhân viên',
            'module' => Module::EXTRACURRICULAR,
            'alias' => Role::ALIAS_EXTRACURRICULAR_STAFF,
        ]);
        // Permissions
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL);

        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ALL);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_DETAIL);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT);
        


        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_LIST); 
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_UPDATE);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_ADD);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE);

        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_STUDENT_PROFILE);

        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ALL);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ADD);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_DELETE);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_LIST);
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_SHOW_CONTRACT); 
        $roleExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT);
        

        // Phòng ngoại khóa
        $roleLeadExtra = Role::create([
            'name' => 'Quản lý bộ phận',
            'module' => Module::EXTRACURRICULAR,
            'alias' => Role::ALIAS_EXTRACURRICULAR_LEADER,
        ]);
        // Permissions
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);

        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ALL);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_HANDOVER);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_DETAIL);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_WAITING);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST);


        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_LIST); 
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ADD);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_UPDATE);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_DELETE);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_ADD);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE);

        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_STUDENT_PROFILE);

        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ALL);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ADD);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_DELETE);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_LIST);
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_SHOW_CONTRACT); 
        $roleLeadExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT);
        

        // Phòng ngoại khóa
        $roleManagerExtra = Role::create([
            'name' => 'Trưởng nhóm',
            'module' => Module::EXTRACURRICULAR,
            'alias' => Role::ALIAS_EXTRACURRICULAR_MANAGER,
        ]);
        // Permissions
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);

        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ALL);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_HANDOVER);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_DETAIL);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_WAITING);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST);


        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_LIST); 
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ADD);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_UPDATE);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_DELETE);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_ADD);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE);

        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_STUDENT_PROFILE);

        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ALL);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ADD);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_DELETE);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_LIST);
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_SHOW_CONTRACT); 
        $roleManagerExtra->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT);
        
        // directo branch
        $role = Role::create([
            'name' => 'Quản lý chi nhánh',
            'module' => Module::DIRECTOR,
            'alias' => Role::ALIAS_DIRECTOR_BRANCH,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_ALL);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $role->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_GENERAL);
        $role->addPermission(\App\Library\Permission::EDU_GENERAL);
        $role->addPermission(\App\Library\Permission::SYSTEM_ADMIN);
        $role->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $role->addPermission(\App\Library\Permission::ABROAD_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MANAGE);
        $role->addPermission(\App\Library\Permission::CONTACT_MANAGE_USER_ACCOUNT);
        $role->addPermission(\App\Library\Permission::TEACHER_MANAGE_USER_ACCOUNT);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);

        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_UPDATE);

        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_BRANCH);

        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $role->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $role->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $role->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);





        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_HISTORY_REJECTED);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_SHOW_CONTRACT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_REJECT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_LIST); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_IMPORT_EXCEL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_LIST);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_EXPORT_PDF); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_SHOW_PAYMENT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_UPDATE);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_DELETE); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_EXCEL);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_EXCEL);

        // directo all
        $role = Role::create([
            'name' => 'Giám đốc',
            'module' => Module::DIRECTOR,
            'alias' => Role::ALIAS_DIRECTOR_ALL,
        ]);

        // Permissions
        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_ALL);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $role->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_GENERAL);
        $role->addPermission(\App\Library\Permission::EDU_GENERAL);
        $role->addPermission(\App\Library\Permission::SYSTEM_ADMIN);
        $role->addPermission(\App\Library\Permission::ABROAD_GENERAL);
        $role->addPermission(\App\Library\Permission::ABROAD_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MANAGE);
        $role->addPermission(\App\Library\Permission::CONTACT_MANAGE_USER_ACCOUNT);
        $role->addPermission(\App\Library\Permission::TEACHER_MANAGE_USER_ACCOUNT);

        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::MARKETING_CONTACT_REQUEST_UPDATE);

        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_GENERAL);
        $role->addPermission(\App\Library\Permission::SALES_DASHBOARD_BRANCH_ALL);

        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_ADD);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_DELETE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_REQUEST_EXCEL);

        $role->addPermission(\App\Library\Permission::SALES_CONTACT_ALL);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_ADD);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CONTACT_EXCEL);

        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER_LIST);
        $role->addPermission(\App\Library\Permission::SALES_CUSTOMER_UPDATE);

        $role->addPermission(\App\Library\Permission::SALES_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_ADD);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_DELETE);
        $role->addPermission(\App\Library\Permission::SALES_ORDER_LIST);

        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_ALL);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_LIST);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_ADD);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_NOTELOG_DELETE);

        $role->addPermission(\App\Library\Permission::SALES_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::SALES_REPORT_EXCEL);
         
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ALL);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_LIST);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_ADD);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_UPDATE);
        $role->addPermission(\App\Library\Permission::SALES_ACCOUNT_KPI_NOTE_DELETE);







        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_HISTORY_REJECTED);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_SHOW_CONTRACT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_REJECT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_LIST); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REFUND_REQUESTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_IMPORT_EXCEL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_KPI_TARGET_LIST);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_EXPORT_PDF); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_SHOW_PAYMENT);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_DELETE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_APPROVE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYMENTS_REJECT);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_ACCOUNT_GROUPS_UPDATE);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_ADD);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_UPDATE);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_DELETE); 
        $role->addPermission(\App\Library\Permission::ACCOUNTING_PAYRATES_EXCEL);

        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ACCOUNTING_REPORT_EXCEL);

        





        //Duhoc
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_HANDOVER);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_LIST);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAITING);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_ASSIGNED_ACCOUNT);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_WAIT_FOR_APPROVAL);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_APPROVED);
        $role->addPermission(\App\Library\Permission::ABROAD_APPLICATION_DONE);

        $role->addPermission(\App\Library\Permission::ABROAD_STUDENT_PROFILE);

        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_ADD);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_UPDATE);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_DELETE);
        $role->addPermission(\App\Library\Permission::ABROAD_COURSES_LIST);

        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_LIST);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_ACTIVE);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DONE);
        $role->addPermission(\App\Library\Permission::ABROAD_SECTIONS_CALENDAR_DESTROY);

        $role->addPermission(\App\Library\Permission::ABROAD_REPORT_ALL);
        $role->addPermission(\App\Library\Permission::ABROAD_REPORT_LIST);
        $role->addPermission(\App\Library\Permission::ABROAD_REPORT_EXCEL);



        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_HANDOVER);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_DETAIL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_WAITING);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_LIST);


        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_LIST); 
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ADD);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_UPDATE);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_DELETE);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_ADD);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE);

        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_STUDENT_PROFILE);

        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ALL);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_ADD);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_DELETE);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_LIST);
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_SHOW_CONTRACT); 
        $role->addPermission(\App\Library\Permission::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT);
        

        
        
        

        
    }

    public function addStaff($data)
    {
        
        [$accountName, $module, $position, $email, $phoneNumber, $accountGroupManagerName, $accountGroupName, $branch, $status, $mentorName] = $data;

        //  bỏ khoảng trắng 
        $accountName = trim($accountName);
        $email = trim($email);
        $phoneNumber = trim($phoneNumber);
        $accountGroupManagerName = trim($accountGroupManagerName);
        $accountGroupName = trim($accountGroupName);
        
        

        if ($accountName == '' && $email == '') {
            return;
        }

        // Validate email 
        if ($email === '' || is_null($email)) {
            $email = \Illuminate\Support\Str::slug($accountName, '') . fake()->randomNumber(4)  . '@asms.com';
        } 

        // Kinh Doanh - Nhân viên
        if (in_array($module, [Module::SALES, 'Kinh Doanh']) && in_array($position, ['Nhân viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_SALESPERSON
            )->first();
        }

         // Kinh Doanh - Mentor
        elseif (in_array($module, [Module::SALES, 'Kinh Doanh']) && in_array($position, ['Mentor'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_SALES_MENTOR
            )->first();
        }

        // Kinh Doanh - Trưởng nhóm
        elseif (in_array($module, [Module::SALES, 'Kinh Doanh']) && in_array($position, ['Trưởng nhóm'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_SALES_LEADER
            )->first();
        }

        // Kinh Doanh - Quản lý bộ phận
        elseif (in_array($module, [Module::SALES, 'Kinh Doanh']) && in_array($position, ['Quản lý bộ phận'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_SALES_MANAGER
            )->first();
        }

        // Kế Toán - Nhân viên
        elseif (in_array($module, [Module::ACCOUNTING, 'Kế Toán']) && in_array($position, ['Nhân viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_ACCOUNTANT
            )->first();
        }

        // Kế Toán - Quản lý bộ phận
        elseif (in_array($module, [Module::ACCOUNTING, 'Kế Toán']) && in_array($position, ['Quản lý bộ phận'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_ACCOUNTANT_MANAGER
            )->first();
        }

        // Marketing - Nhân viên
        elseif (in_array($module, [Module::MARKETING, 'Marketing']) && in_array($position, ['Nhân viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_MARKETING_STAFF
            )->first();
        }
        // Marketing - Quản lý bộ phận
        elseif (in_array($module, [Module::MARKETING, 'Marketing']) && in_array($position, ['Quản lý bộ phận'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_MARKETING_MANAGER
            )->first();
        }
        // Đào tạo - Nhân viên
        elseif (in_array($module, [Module::EDU, 'Đào Tạo']) && in_array($position, ['Nhân viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EDU_STAFF
            )->first();
        }

        // Đào tạo - Trưởng nhóm
        elseif (in_array($module, [Module::EDU, 'Đào Tạo']) && in_array($position, ['Trưởng nhóm'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EDU_LEADER_GROUP
            )->first();
        }

        // Đào tạo - Trưởng phòng
        elseif (in_array($module, [Module::EDU, 'Đào Tạo']) && in_array($position, ['Trưởng phòng'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EDU_LEADER
            )->first();
        }
        // Đào tạo - Quản lý bộ phận
        elseif (in_array($module, [Module::EDU, 'Đào Tạo']) && in_array($position, ['Quản lý bộ phận'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EDU_MANAGER
            )->first();
        }
         // Đào tạo - Giám  đốc
         elseif (in_array($module, [Module::EDU, 'Đào Tạo']) && in_array($position, ['Giám đốc'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EDU_DIRECTOR
            )->first();
        }
        // Du Học - Nhân viên
        elseif (in_array($module, [Module::ABROAD, 'Du Học']) && in_array($position, ['Nhân viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_ABROAD_STAFF
            )->first();
        }
        
        // Du Học - Trưởng nhóm
        elseif (in_array($module, [Module::ABROAD, 'Du Học']) && in_array($position, ['Trưởng nhóm'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_ABROAD_LEADER
            )->first();
        }

        // Du Học - Quản lý bộ phận
        elseif (in_array($module, [Module::ABROAD, 'Du Học']) && in_array($position, ['Quản lý bộ phận'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_ABROAD_MANAGER
            )->first();
        }

        // Ngoại Khóa - Nhân viên
        elseif (in_array($module, [Module::EXTRACURRICULAR, 'Ngoại Khóa']) && in_array($position, ['Nhân viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EXTRACURRICULAR_STAFF
            )->first();
        }
         // Ngoại Khóa - Quản lý bộ phận
        elseif (in_array($module, [Module::EXTRACURRICULAR, 'Ngoại Khóa']) && in_array($position, ['Quản lý bộ phận'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_EXTRACURRICULAR_LEADER
            )->first();
        }
         // Ngoại Khóa - Trưởng nhóm
        elseif (in_array($module, [Module::EXTRACURRICULAR, 'Ngoại Khóa']) && in_array($position, ['Trưởng nhóm'])) {
        $roleUser = Role::where(
                'alias', Role::ALIAS_EXTRACURRICULAR_MANAGER
            )->first();
        }

        // Hệ thống - Quản trị viên
        elseif (in_array($module, [Module::SYSTEM]) && in_array($position, ['Quản trị viên'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_SYSTEM_MANAGER
            )->first();
        }

        // Giám đốc - Quản lý chung
        elseif (in_array($module, [Module::DIRECTOR, 'Ban giám đốc']) && in_array($position, ['Giám đốc'])) {
            $roleUser = Role::where(
                'alias', Role::ALIAS_DIRECTOR_ALL
            )->first();

            
        } else { 
            throw new \Exception("Can not find [$module - $position] role");
        }

            $accountGroupNameToUse = $accountGroupName ?: $accountGroupManagerName;

            if ($accountGroupNameToUse) {
               
                $accountGroup = AccountGroup::where('name', $accountGroupNameToUse)->first();
                if (!$accountGroup) {
                    $accountGroup = $this->addAccountGroup($accountGroupNameToUse, $roleUser->name);
                }
            } else { 
                $accountGroup = null; 
            }
            // Thêm người dùng
            $password = 123456;
            // precess branch
            if (in_array(strtolower($branch), [
                strtolower(Branch::BRANCH_HN),
                'hà nội'
            ])) {
                $branch = Branch::BRANCH_HN;
            }
            if (in_array(strtolower($branch), [
                strtolower(Branch::BRANCH_SG),
                'sg',
                'hcm',
                'ho chi minh',
                'hồ chí minh'
            ])) {
                $branch = Branch::BRANCH_SG;
            }
            
            if (in_array(strtolower($status), [
                strtolower(Account::STATUS_ACTIVE),
                'Đang làm việc',
                ''
            ])) {
                $status = Account::STATUS_ACTIVE;
            }
            if (in_array(strtolower($status), [
                strtolower(Account::STATUS_OUT_OF_JOB),
                'Đã nghỉ'
            ])) {
                $status = Account::STATUS_OUT_OF_JOB;
            }

            
            // if $user->account->name == $accountGroupManagerName $accountGroup->account_manager_id = user->account->id
            $user = $this->addUserAndAccount($phoneNumber, $accountName, $email, $password, $roleUser, $accountGroup, $branch, $mentorName, $status);
            if ($user->account->name === $accountGroupManagerName) {
                $accountGroup->manager_id = $user->account->id;
                $accountGroup->save();
            }
    }

    public function addAccountGroup($name, $type)
    {
        $accountGroup = AccountGroup::newDefault();
        $accountGroup->name = $name;
        $accountGroup->type = $type;
        $accountGroup->save();
        
        echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo thành nhóm tài khoản $accountGroup->name \n");
        
        return $accountGroup;
    }

    public function addUserAndAccount($phone, $name, $email, $password, $role, $accountGroup, $branch, $mentorName, $status)
    {
        // check exist
        $existingUser = User::where('email', $email)->first();

        if ($phone) {
            $phone = \App\Library\Tool::extractPhoneNumber(trim($phone));
        }
        if ($existingUser) {
            echo("  \033[1m\033[31mERROR\033[0m  Trùng email: $email\n");
            return $existingUser;
        }
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password),
        ]);
        if ($mentorName) {
        
            $userMentor = User::where('name',$mentorName)->withPermission(\App\Library\Permission::SALES_ACCOUNT_GROUP_MENTOR)->first();
            $user->mentor_id = $userMentor->id;
        }
        // account
        $account = $user->createDefaultAccount($branch, $status);
        if($accountGroup){
            
            $account->account_group_id = $accountGroup->id;
        }

        // required change password. Bắt đổi mật khẩu lần đầu đăng nhập
        $user->change_password_required = true;
        
        // save
        $account->save();
        $user->save();

        // set account
        $user->setAccount($account);
        // role
        $user->addRole($role);
        echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo thành tài khoản $user->name \n");
        
        // send first notification
        $user->notifications()->delete();
        $user->notify(new \App\Notifications\SalesWelcomeNewAccount($user));
        return $user;
    }
}
