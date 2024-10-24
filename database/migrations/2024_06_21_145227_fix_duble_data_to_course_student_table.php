<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      
        // Tìm và xóa các bản ghi trùng lặp
        $duplicates = CourseStudent::select('course_id', 'student_id', 'order_item_id', DB::raw('MIN(id) as min_id'))
            ->groupBy('course_id', 'student_id', 'order_item_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            CourseStudent::where('course_id', $duplicate->course_id)
                ->where('student_id', $duplicate->student_id)
                ->where('order_item_id', $duplicate->order_item_id)
                ->where('id', '!=', $duplicate->min_id)
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_student', function (Blueprint $table) {
            //
        });
    }
};
