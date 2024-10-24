<?php

namespace Database\Seeders;

use App\Models\AccountGroup;
use App\Models\PaymentAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountGroupSeeder extends Seeder
{
    public function run(): void
    {
        AccountGroup::query()->delete();

        $this->addAccountGroup(AccountGroup::GROUP_TYPE_SALE_A);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_SALE_B);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_SALE_C);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_MARKETING);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_ACCOUNTING);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_EDU);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_TVCL);
        $this->addAccountGroup(AccountGroup::GROUP_TYPE_TTSK);
    }

    public function addAccountGroup($groupType)
    {
        $name;

        switch ($groupType) {
            case AccountGroup::GROUP_TYPE_SALE_A:
                $name = 'Sale - A';
                $managerId = 2;
                break;
            case AccountGroup::GROUP_TYPE_SALE_B:
                $name = 'Sale - B';
                $managerId = 3;
                break;
            case AccountGroup::GROUP_TYPE_SALE_C:
                $name = 'Sale - C';
                $managerId = 1;
                break;
            case AccountGroup::GROUP_TYPE_MARKETING:
                $name = 'Marketing';
                $managerId = 4;
                break;
            case AccountGroup::GROUP_TYPE_ACCOUNTING:
                $name = 'Kế toán';
                $managerId = 6;
                break;
            case AccountGroup::GROUP_TYPE_EDU:
                $name = 'Đào tạo';
                $managerId = 5;
                break;
            case AccountGroup::GROUP_TYPE_TVCL:
                $name = 'Tư vấn chiến lược';
                $managerId = 7;
                break;
            case AccountGroup::GROUP_TYPE_TTSK:
                $name = 'Truyền thông và sự kiện';
                $managerId = 8;
                break;
            default:
                $name = 'Sale - A';
                $managerId = null;
        }

        $accountGroup = AccountGroup::create([
            'name' => $name,
            'manager_id' => $managerId,
            'type' => $groupType,
            'abroad_payment_account_id' => PaymentAccount::inRandomOrder()->pluck('id')->first(),
            'edu_payment_account_id' => PaymentAccount::inRandomOrder()->pluck('id')->first(),
            'extracurricular_payment_account_id' => PaymentAccount::inRandomOrder()->pluck('id')->first(),
            'teach_payment_account_id' => PaymentAccount::inRandomOrder()->pluck('id')->first(),
        ]);

        $accountGroup->save();
    }
}
