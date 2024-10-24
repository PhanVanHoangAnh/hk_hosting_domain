<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;

class UpdateAccountTeacherIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->get()->each(function ($account) {
    
            $teacher = DB::table('teachers')->where('name', $account->name)->where('type',Teacher::TYPE_HOMEROOM)->first();

            if ($teacher) {
                DB::table('accounts')->where('id', $account->id)->update(['teacher_id' => $teacher->id]);
            }
        });
    }
}
