<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactList;

class ContactListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactList::query()->delete();

        for ($i = 1; $i <= 50; $i++) {
            ContactList::create([
                'name' => fake()->name,


            ]);
        }
    }
}