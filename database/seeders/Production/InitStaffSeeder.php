<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;
use App\Models\AccountGroup;
use App\Models\Role;

class InitStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default account
        // AccountGroup::query()->delete();

        // READ file execel database+path('InitData.xlsx');
        // foreach rows as $row
            $this->addStaff(
                $accountNam = 'Nguyễn Thị Hải Linh',
                $accountGroupTypeName = 'Kinh Doanh',
                $email = ' ',
                $phoneNumber = '
                ',
                $accountGroupManagerName = 'Nguyễn Thị Hải Linh',
                $accountGroupName = 'Team Trang',
            );
    }

    public function addStaff($accountName, $accountGroupTypeName, $email, $phoneNumber, $accountGroupManagerName, $accountGroupName)
    {
        // 
        // $accountName = trim($accountName);
        // $email = validate email if khong co email thi cho 1 uniq@asms.com
        // $phone = .... trim
        // $accountGroup = ->where(name, $accountGroupName)->first() :  chua co group cung ten thi tao moi, neu có rồi thì first()
        //       if (!accountGroup) { $accountGroup = new ....} accountGroup = $this->addAccountGroup('Team Trang', AccountGroup::TYPE_SALES); }
        // $accountGroupManagerName ... lien quan den $accountGroupName

        // Nguyễn Thị Hải Linh	Kinh Doanh			Nguyễn Thị Hải Linh	Team Trang

        // Add AccountGroup : name: Team Trang
        $accountGroup = $this->addAccountGroup('Team Trang', AccountGroup::TYPE_SALES);
        
        // sales
        $roleSales= Role::create([
            'name' => 'Sales',
        ]);
        // Permissions
        $roleSales->addPermission(\App\Library\Permission::SALES_CUSTOMER);

        // Add user
        $user = $this->addUserAndAccount('Nguyễn Thị Hải Linh', uniqid() . '@asms.com', '123456', $roleSales, $accountGroup);

        // if $user->account->name == $accountGroupManagerName $accountGroup->account_manager_id = user->account->id
    }

    public function addAccountGroup($name, $type)
    {
        $accountGroup = AccountGroup::newDefault();
        $accountGroup->name = $name;
        $accountGroup->type = $type;
        $accountGroup->save();
        
        return $accountGroup;
    }

    public function addUserAndAccount($name, $email, $password, $role, $accountGroup)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // account
        $account = Account::create([
            'name' => $name,
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
