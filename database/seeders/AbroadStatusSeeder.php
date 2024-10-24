<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbroadStatus;

class AbroadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AbroadStatus::query()->delete();

        $statuses = AbroadStatus::getAllStatuses();

        foreach ($statuses as $s) {
            AbroadStatus::create([
                'name' => $s
            ]);
        }
    }
}
