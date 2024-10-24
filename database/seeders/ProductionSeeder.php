<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Production\initUserSeeder::class,
            \Database\Seeders\Production\initBankAccountSeeder::class,
            AbroadStatusSeeder::class,
            InitExtraActivitiesSeeder::class,
            InitGpaSeeder::class,
            AcademicAwardsSeeder::class,
            SubjectSeeder::class,
            AbroadServiceSeeder::class,
            InitCurrentProgramSeeder::class,
            InitPlanApplyProgram::class,
            IntendedMajorSeeder::class,
            \Database\Seeders\Production\InitContactAndContactRequestSeeder::class,
            \Database\Seeders\Production\InitTeacherSeeder::class,
            \Database\Seeders\Production\InitTrainingLocationSeeder::class,
            \Database\Seeders\Production\InitPayrateSeeder::class,
            \Database\Seeders\Production\InitOrderProductionSeeder::class,
            \Database\Seeders\Production\InitCourseSeeder::class,
            \Database\Seeders\Production\InitSectionSeeder::class,
            
        ]);
    }
}
