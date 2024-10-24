<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Account;
use App\Models\AccountKpiNote;

class AccountKpiNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $contacts = Contact::inRandomOrder()->get();
        $content = config('contentNoteLog');
        // Define the number of records you want to create
        

            for ($i = 0; $i < 30; $i++) {
                AccountKpiNote::create([
                    'contact_id' => Contact::inRandomOrder()->first()->id,
                    'account_id' => Account::inRandomOrder()->first()->id,
                    'subject_id' => Subject::inRandomOrder()->first()->id,
                    'note' =>  fake()->randomElement($content),
                    'amount' =>fake()->numberBetween($min = 50000000, $max = 1000000000),
                    'estimated_payment_date' =>  fake()->dateTimeBetween('2024-01-01', '2024-03-01'),
                ]);
            }
        
    }
}
