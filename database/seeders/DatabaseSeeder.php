<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Production seeder
            ProductionSeeder::class,


            // development seeder
            SchoolSeeder::class,
            ExtracurricularSeeder::class,
            IntendedMajorSeeder::class



            /*
            AbroadStatusSeeder::class,
            ContactListSeeder::class,
            UserSeeder::class,
            ContactSeeder::class,
            NoteLogSeeder::class,
            TagSeeder::class,
            SubjectSeeder::class,
            \Database\Seeders\Production\InitTeacherSeeder::class,
            PaymentAccountSeeder::class,
            AccountGroupSeeder::class,
            AssignAccountGroupSeeder::class,
            TrainingLocationSeeder::class,
            InitExtraActivitiesSeeder::class,
            InitGpaSeeder::class,
            AcademicAwardsSeeder::class,
            InitCurrentProgramSeeder::class,
            InitPlanApplyProgram::class,
            // \Database\Seeders\Production\InitOrderProductionSeeder::class,
            OrderSeeder::class,
            // OrderItemSeeder::class,
            // CourseSeeder::class,
            AccountKpiNoteSeeder::class,
            PaymentRecordSeeder::class,
            PaymentReminderSeeder::class,
            // CourseStudentSeeder::class,
            PayrateSeeder::class,
            StaffGroupSeeder::class,
            // RefundRequestsSeeder::class,
            AbroadServiceSeeder::class,
            // SocialNetworkSeeder::class,
            // CulturalOrientationSeeder::class,
            // SupportActivitiesSeeder::class,
            SchoolSeeder::class,
            ExtracurricularSeeder::class,
            IntendedMajorSeeder::class
            */
        ]);
    }
}
