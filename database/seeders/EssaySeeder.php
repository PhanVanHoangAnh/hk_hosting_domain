<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Essay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EssaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        for ($i = 1; $i <= 10; $i++) {
            $sale = Account::inRandomOrder()->first();
            Essay::create([
                'abroad_application_id' => $i,
                'account_id' => $sale->id, 
                'name' => 'Essay ' . $i,
                'date' => now()->subDays($i),
                'status' => Essay::STATUS_DRAFT,
                'content' => 'Sample content for essay ' . $i,
            ]);
        }
    }
    
}
