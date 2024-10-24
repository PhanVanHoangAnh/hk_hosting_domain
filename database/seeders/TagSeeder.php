<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tag::query()->delete();

        $randomAccount = Account::inRandomOrder()->first();

        for ($i = 1; $i <= 11; $i++) {
            Tag::create([
                'name' => fake()->word(),
                'account_id' => $randomAccount->id,
            ]);
        }
    }
}