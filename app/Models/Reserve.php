<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Reserve extends Model
{
    use HasFactory;
    protected $table = 'reserve';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELLED  = 'caccelled';

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id', 'id');
    }
    protected $fillable = [
        'student_id',
        'order_item_id',
        'reason',
        'start_at',
        'end_at',
        'status'

    ];
    // Trong mô hình CourseStudent
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }
    public static function scopeLimit($query)
    {
        $now = Carbon::now();

        // Thêm 14 ngày
        $sevenDaysLater = Carbon::now()->addDays(14);
        return $query->where('end_at', '<', $sevenDaysLater)
            ->where('end_at', '>=', $now);
    }
    public static function scopeExpired($query)
    {
        $now = Carbon::now();

        // Lấy các bản ghi có 'end_at' nhỏ hơn ngày hiện tại 
        return $query->where('end_at', '<', $now);
    }
    public function reserveExtend($reserve_end_at)
    {

        DB::beginTransaction();

        try {
            $this->end_at = $reserve_end_at;
            $this->update(['end_at' => $reserve_end_at]);
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
        DB::commit();
    }
    public function reserveCancelled()
    {
        DB::beginTransaction();

        try {

            $this->status = self::STATUS_CANCELLED;
            $this->orderItem->updateStatusActive();
            $this->update(['status' => self::STATUS_CANCELLED]);
            $this->reserveCancelledStudentSection();
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        DB::commit();
    }
    public function reserveCancelledStudentSection()
    {
        DB::beginTransaction();

        try {
            $currentCourse = CourseStudent::where('student_id', $this->student_id)
                ->where('order_item_id', $this->order_item_id)->first();


            if ($currentCourse) {
                $currentCourse = $currentCourse->course_id;

                $sections = StudentSection::where('student_id', $this->student->id)
                    ->whereHas('section', function ($query) use ($currentCourse) {
                        $query->where('course_id', $currentCourse);
                    })
                    ->where('status', '=', StudentSection::STATUS_RESERVE)
                    ->get();

                // Thêm tất cả buổi học cha học của lớp học đó vào student section của học viên
                foreach ($sections as $section) {
                    $section->setReserveCancelled();
                }
            }
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        DB::commit();
    }
    public static function scopeGetReserveByContact($query, $student)
    {
        $query->where('student_id', $student);
    }
    public function status()
    {

        if ($this->status == self::STATUS_ACTIVE) {
            return 'Đang bảo lưu';
        } elseif ($this->status == self::STATUS_CANCELLED) {
            return 'Dừng bảo lưu';
        }
        return '--';
    }
    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('orderItem', function ($q) use ($branch) {
            $q->byBranch($branch);
        });
    }

}
