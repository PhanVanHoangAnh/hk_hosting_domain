<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Payrate;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TrainingLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subjects = Subject::all();
        $classTypes = Course::getAllClassTypes();
        
        foreach ($subjects as $subject) {
            $amount = rand(100000, 300000); 
            $teachers = Teacher::all();
            
            foreach ($teachers as $teacher) {
                foreach ($classTypes as $class) {
                    Payrate::create([
                        'teacher_id' => $teacher->id,
                        'amount' => round(fake()->numberBetween(100000, 300000), -3),
                        'effective_date' => now()->subDays(rand(1, 30)),
                        'subject_id' => $subject->id,
                        'type' => $class,
                        'training_location_id' => TrainingLocation::inRandomOrder()->first()->id,
                        'study_method' => Course::getAllStudyMethod()[rand(0, count(Course::getAllStudyMethod()) - 1)],
                        'class_status' => Course::getAllStatus()[rand(0, count(Course::getAllStatus()) - 1)],
                        'class_size' => rand(10, 30)
                    ]);
                }

            }
        }
        
    }
}
