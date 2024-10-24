<?php

namespace Database\Seeders\Production;

use App\Library\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;
use App\Models\AccountGroup;
use App\Models\Role;
use App\Models\ExcelData;
use PhpOffice\PhpSpreadsheet\IOFactory; 


class InitAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountGroup::query()->delete();

        $excelFile = new ExcelData();
        $staffData = $excelFile->getDataFromSheet(ExcelData::STAFF_SHEET_NAME, 2);

        foreach($staffData as $data) 
        {
            $this->addStaff($data);
        }
    }

    public function addStaff($data)
    {
        // default
        $role = Role::create([
            'name' => 'QT Hệ thống',
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


        // marketing
        $roleMarketing = Role::create([
            'name' => 'NV Marketing',
        ]);

        // Permissions
        $roleMarketing->addPermission(\App\Library\Permission::MARKETING_CUSTOMER);


        // sales
        $roleSales = Role::create([
            'name' => 'NV Kinh Doanh',
        ]);
        // Permissions
        $roleSales->addPermission(\App\Library\Permission::SALES_CUSTOMER);


        // sales manager
        $roleSalesManager = Role::create([
            'name' => 'Quản lý chung',
        ]);

        // Permissions
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_CUSTOMER);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_DASHBOARD_ALL);
        $roleSalesManager->addPermission(\App\Library\Permission::SALES_REPORT_ALL);


        // accountant
        $roleAccountant = Role::create([
            'name' => 'NV Kế toán',
        ]);

        // Permissions
        $roleAccountant->addPermission(\App\Library\Permission::ACCOUNTING_GENERAL);


        // Học viên
        $roleStudent = Role::create([
            'name' => 'Học viên',
        ]);

        // Permissions
        $roleStudent->addPermission(\App\Library\Permission::STUDENT_GENERAL);


        // Giảng viên
        $roleTeacher = Role::create([
            'name' => 'Giảng viên',
        ]);

        // Permissions
        $roleTeacher->addPermission(\App\Library\Permission::TEACHER_GENERAL);


        // Trợ giảng
        $roleTeachingAssistant = Role::create([
            'name' => 'Trợ giảng',
        ]);

        // Permissions
        $roleTeachingAssistant->addPermission(\App\Library\Permission::TEACHING_ASSISTANT_GENERAL);


        // Phòng đạo tạo
        $roleEdu = Role::create([
            'name' => 'NV Đào tạo',
        ]);

        // Permissions
        $roleEdu->addPermission(\App\Library\Permission::EDU_GENERAL);


        // Phòng du học
        $roleAbroad = Role::create([
            'name' => 'NV Du Học',
        ]);
        // Permissions
        $roleAbroad->addPermission(\App\Library\Permission::ABROAD_GENERAL);



        [$accountName, $accountGroupTypeName, $email, $phoneNumber, $accountGroupManagerName, $accountGroupName] = $data;

        //  bỏ khoảng trắng 
        $accountName = trim($accountName);
        $email = trim($email);
        $phoneNumber = trim($phoneNumber);
        $accountGroupManagerName = trim($accountGroupManagerName);
        $accountGroupName = trim($accountGroupName);

        // Validate email 
        if ($email === '' || is_null($email)) {
            $email = \Illuminate\Support\Str::slug($accountName, '') . fake()->randomNumber(4)  . '@asms.com';
        } 
 
        switch ($accountGroupTypeName) {
            case 'NV Marketing':
            case 'Marketing':
                $roleUser = $roleMarketing;
                break;
            case 'NV Kinh Doanh':
            case 'Kinh Doanh':
                $roleUser = $roleSales;
              
                break; 
            case 'Kế Toán':
            case 'NV Kế Toán':
                $roleUser = $roleAccountant;
                break;
            case 'NV Đào Tạo':
            case 'Đào Tạo':
                $roleUser = $roleEdu;
                break;
            case 'Quản lý': 
                $roleUser = $role;
                break;
            default:
                
                break;

            }
            
        $accountGroup = AccountGroup::where('name', $accountGroupName)->first();
        if (!$accountGroup) {
            $accountGroup = $this->addAccountGroup($accountGroupName, $roleUser->name);
        }
        // Thêm người dùng
        $password = 123456;
        $user = $this->addUserAndAccount($accountName, $email, $password, $roleUser, $accountGroup);

        // if $user->account->name == $accountGroupManagerName $accountGroup->account_manager_id = user->account->id
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
        
        // echo "SUCCESS: Tạo thành nhóm tài khoản $accountGroup \n";
        
        return $accountGroup;
    }

    public function addUserAndAccount($name, $email, $password, $role, $accountGroup)
    {
        // check exist
        $existingUser = User::where('email', $email)->first();

        
        if ($existingUser) {
            echo "Error: Trùng email: $email\n";
            return $existingUser;
        }
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $branches = [Branch::BRANCH_HN, Branch::BRANCH_SG];
        
        // account
        $account = Account::create([
            'name' => $name,             
            'branch' => $branches[array_rand($branches)],
        ]);
        $account->account_group_id = $accountGroup->id;
        $account->generateCode();

        $user->account()->associate($account);
        $user->save();

        // role
        $user->roles()->attach($role);
        
        // send first notification
        $user->notifications()->delete();
        $user->notify(new \App\Notifications\SalesWelcomeNewAccount($user));

        return $user;
    }

}
