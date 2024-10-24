<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StaffGroup;
use App\Models\Account;
use App\Models\PaymentAccount;

class StaffGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(StaffGroup::getAllType() as $type) {
            $name;

            switch ($type) {
                case StaffGroup::TYPE_EDU:
                    $name = "Đào tạo";
                    break;
                case StaffGroup::TYPE_MARKETING:
                    $name = "Marketing";
                    break;
                case StaffGroup::TYPE_SALE:
                    $name = "Sale";
                    break;
                case StaffGroup::TYPE_ACCOUNTING:
                    $name = "Kế toán";
                    break;
                default:
                    $name = "Đào tạo";
            }

            StaffGroup::create([
                'name' => $name,
                'group_manager_id' => Account::inRandomOrder()->first()->id,
                'type' => $type,
                'default_payment_account_id' => PaymentAccount::inRandomOrder()->first()->id
            ]);
        }
    }
}
