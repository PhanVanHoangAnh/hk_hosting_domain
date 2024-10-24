<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\AccountGroup;

class AssignAccountGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Account::get() as $account) {
            $account->account_group_id = AccountGroup::inRandomOrder()->first()->id;
            $account->save();
        }
    }
}
