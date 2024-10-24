<?php

namespace Database\Seeders;

use App\Models\AbroadApplication;
use App\Models\DepositForSchool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepositForSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abroadApplications = AbroadApplication::take(10)->get();

        if ($abroadApplications->isEmpty()) {
            return;
        }
        
        $abroadApplications->each(function ($abroadApplication) {
            DepositForSchool::create([
                'abroad_application_id' => $abroadApplication->id, 
                'amount' => round(fake()->numberBetween($min = 50000000, $max = 100000000), -3),
                'date' => now()->subDays(rand(1, 30)), 
                'deposit_receipt_link' => fake()->url(),
               
            ]);
        });
    }
    
}
