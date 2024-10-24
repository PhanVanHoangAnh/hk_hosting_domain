<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extracurricular;
use App\Models\AbroadApplication;
use Faker\Factory as Faker;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = \App\Models\User::byModule(\App\Library\Module::EXTRACURRICULAR)->get();
        for ($i = 0; $i < 10; $i++) {
            $extracurricular = new Extracurricular();
            $extracurricular->name = $faker->sentence($nbWords = 3);
            $extracurricular->type = config('typeExtracurricular')[array_rand(config('typeExtracurricular'))];;
            $extracurricular->address = $faker->address;
            $extracurricular->start_at = $faker->dateTimeBetween('-1 years', 'now');
            $extracurricular->end_at = $faker->dateTimeBetween($extracurricular->start_at, '+1 years');

            $extracurricular->hours_per_week = rand(5, 15);
            $extracurricular->weeks_per_year = rand(10, 20);

            $extracurricular->coordinator = $users->random()->account->id;
            $extracurricular->study_method = config('studyTypes')[array_rand(config('studyTypes'))];;
            
            $extracurricular->max_student = rand(10, 25);
            $extracurricular->min_student = rand(1, 10);
            
            $extracurricular->price = round($faker->numberBetween(5000000, 100000000), -3);
            $extracurricular->expected_costs = round($faker->numberBetween(5000000, 100000000), -3);
            $extracurricular->save();
        }
    }
}
