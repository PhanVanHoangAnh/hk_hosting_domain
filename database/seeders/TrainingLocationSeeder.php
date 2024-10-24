<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TrainingLocation;

class TrainingLocationSeeder extends Seeder
{
    public function run(): void
    {
        TrainingLocation::query()->delete();

        $loacations = config('trainingLocations');

        foreach ($loacations as $i) 
        {
            TrainingLocation::create($i);
        }
    }
}
