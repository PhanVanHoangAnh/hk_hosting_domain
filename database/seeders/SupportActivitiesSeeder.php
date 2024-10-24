<?php

namespace Database\Seeders;

use App\Models\AbroadApplication;
use App\Models\SupportActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportActivitiesSeeder extends Seeder
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
            SupportActivity::create([
                'abroad_application_id' => $abroadApplication->id,
                'airport_pickup_person' => 'John Doe',
                'guardian_person' => 'Jane Smith',
                'address' => 'Main Street',
            ]);
        });
    }
}
