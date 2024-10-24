<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();
        $requirements = [
            'High GPA',
            'Letter of Recommendation',
            'Standardized Test Scores',
            'Portfolio',
            'Interview',
            // Add more requirements as needed
        ];

        for ($i = 1; $i <= 5; $i++) {
            $schoolName = $faker->unique()->company() . ' University';
            $requirement = $requirements[array_rand($requirements)]; // Lấy ngẫu nhiên một yêu cầu từ mảng

            School::create([
                'name' => $schoolName,
                'requirement' => $requirement,
            ]);
        }
    }
}
