<?php

namespace Database\Seeders;

use App\Models\AbroadApplication;
use App\Models\CulturalOrientation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CulturalOrientationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abroadApplications = AbroadApplication::all();

        if ($abroadApplications->isEmpty()) {
           
            return;
        }

        $abroadApplications->each(function ($abroadApplication) {
            CulturalOrientation::create([
                'abroad_application_id' => $abroadApplication->id,
                'need_open_bank_account' => (bool)random_int(0, 1),
                'need_buy_sim' => (bool)random_int(0, 1),
            ]);
        });
    }
}
