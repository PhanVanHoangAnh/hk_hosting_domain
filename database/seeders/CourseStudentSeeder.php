<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseStudent;
use App\Models\Course;
use App\Models\OrderItem;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseIds = Course::pluck('id')->toArray();
        $studentIds = Contact::pluck('id')->toArray();
        $orderItemIds = OrderItem::pluck('id')->toArray();

        // Tạo dữ liệu ảo cho bảng CourseStudent
        // Ví dụ tạo 10 bản ghi ngẫu nhiên
        for ($i = 0; $i < 10; $i++) {
            CourseStudent::create([
                'course_id' => $courseIds[array_rand($courseIds)],
                'student_id' => $studentIds[array_rand($studentIds)],
                'order_item_id' => $orderItemIds[array_rand($orderItemIds)],
            ]);
        }
    }
}
