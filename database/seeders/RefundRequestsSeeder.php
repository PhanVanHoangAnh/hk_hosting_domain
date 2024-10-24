<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseStudent;
use App\Models\RefundRequest;
use Carbon\Carbon;


class RefundRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseStudents = CourseStudent::take(4)->get();
        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::create(2024, 1, 31);
        $randomRefundDate = Carbon::createFromTimestamp(mt_rand($startDate->timestamp, $endDate->timestamp));
        foreach ($courseStudents as $courseStudent) {
            RefundRequest::create([
                'student_id' => $courseStudent->student_id,
                'course_id' => $courseStudent->course_id,
                'refund_date' => $randomRefundDate,
                'status' => RefundRequest::STATUS_PENDING,
            ]);
        }
    }
}
