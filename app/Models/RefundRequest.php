<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefundRequest extends Model
{
    use HasFactory;
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    const STATUS_CANCEL = 'cancel';


    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }
    protected $fillable = [
        'student_id',
        'refund_date',
        'status',
        'order_item_id',
        'reason'
    ];
    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'course_id', 'course_id');
    }
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    public function scopeSearch($query, $keyword)
    {
        return $query->join('contacts', 'contacts.id', '=', 'refund_requests.student_id')
        ->where('contacts.name', 'LIKE', "%{$keyword}%")
        ->select('refund_requests.*');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeCancel($query)
    {
        return $query->where('status', self::STATUS_CANCEL);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }
    public function reject($reason)
    {
        $this->status = self::STATUS_REJECTED;
        $this->reject_reason = $reason;
        $this->save();
    }

    public function cancelRequest()
    {
        $this->status = self::STATUS_CANCEL;
        $this->save();
    }
    public function approvedRequest()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }
    public function hoanPhi($refundRequest, $courseIds)
    {
        $sections = collect();

        foreach ($courseIds as $courseId) {
            $sections = $sections->merge(StudentSection::getSectionsRefund($refundRequest->student_id, $courseId, $refundRequest->refund_date));
        }
        $sections->each(function ($section) {
            $section->setStatusRefund();
        });

        $this->approvedRequest();
    }

    public function approveAndRefund($request) // aka approve hoan phi
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            // init
            $paymentRecord = PaymentRecord::newDefault();
            $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent($this->order_item_id, $this->student_id);
            $courseIds = $courseStudents->pluck('course_id')->toArray();

            // Tạo phiếu chi
            $errors = $paymentRecord->saveRefundPayment($request);

            if (!$errors->isEmpty()) {
                return $errors;
            }

            // Hoàn phí
            $this->hoanPhi($this, $courseIds);

            // update order cache total
            $this->orderItem->orders->updateCacheTotal();
            //
            $this->orderItem->updateStatusRefund();
            // update reminders of order
            $this->orderItem->orders->updateReminders();

            // add note log
            $this->student->addNoteLog(
                $request->user()->account,
                "Hoàn phí thành công môn [" . $this->orderItem->getSubjectName() . "] theo hợp đồng [" . $this->orderItem->orders->code . "]"
            );

            // commit
            DB::commit();

            // return empty errors aka sccess
            return collect([]);
        } catch (\Throwable $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            // return $e->getMessage();

            // Create a new MessageBag instance
            $errors = new \Illuminate\Support\MessageBag;

            // Add an error message
            $errors->add('amount', $e->getMessage());

            // 
            return $errors;
        }
    }

    public function calculateTotalStudiedAmount()
    {
        $studentSection = new StudentSection;
        $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent(
            $this->order_item_id,
            $this->student_id
        );

        $totalHoursStudiedOfTutor = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfTutor($courseStudents, $this);
        $totalHoursStudiedOfForeignTeacher = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfForeignTeacher($courseStudents, $this);
        $totalHoursStudiedOfVnTeacher = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfVnTeacher($courseStudents, $this);

        $totalRefundAmount = (
            $this->orderItem->getPriceTutorHour() * $totalHoursStudiedOfTutor +
            $this->orderItem->getPriceForeignTeacherHour() * $totalHoursStudiedOfForeignTeacher +
            $this->orderItem->getPriceVnTeacherHour() * $totalHoursStudiedOfVnTeacher
        );

        return number_format($totalRefundAmount);
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('refund_requests.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function exportToExcelRefundReport($templatePath, $filteredRefundRequests)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;


        foreach ($filteredRefundRequests as $index => $refundRequest) {
            $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id)->groupBy('subject_id');
            $subjectTotalHoursStudied = 0;
            foreach ($groupedCourseStudents as $subjectId => $group) {
                $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($refundRequest) {
                    return \App\Models\StudentSection::calculateTotalHoursStudied($refundRequest->student_id, $courseStudent->course_id);
                });
            }
            $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);
            $totalHoursNotWorked = '';
            if ($courseStudents->count() > 0) {
                foreach ($courseStudents as $courseStudent) {
                    $totalHoursRefund = \App\Models\StudentSection::calculateTotalHoursRefund($refundRequest->student_id, $courseStudent->course_id, $refundRequest->refund_date);
                    $totalHoursNotWorked .= $totalHoursRefund . 'giờ';
                }
            } else {
                $totalHoursNotWorked = number_format($refundRequest->orderItem->getTotalMinutes() / 60, 2) . 'giờ';
            }

            $totalValueImplemented = PaymentRecord::getAmountForRefundRequest($refundRequest->order_item_id, $refundRequest->student_id) ?? 0;
            $totalValueNotImplemented = $refundRequest->orderItem->getTotalPriceOfEdu() - $totalValueImplemented;
            $rowData = [
                $index + 1,
                $refundRequest->student->code,
                $refundRequest->student->name,
                $refundRequest->orderItem->orders->salesperson->name,
                $refundRequest->orderItem->subject->name,
                $refundRequest->orderItem->getHomeRoomName(),
                number_format($refundRequest->orderItem->getTotalMinutes() / 60, 2) . 'giờ',
                Functions::formatNumber($refundRequest->orderItem->getTotalPriceOfEdu()) . '₫',
                number_format($subjectTotalHoursStudied, 2) . ' giờ',
                $refundRequest->calculateTotalStudiedAmount() . '₫',
                $totalHoursNotWorked,
                number_format($totalValueNotImplemented) . '₫',
                number_format(PaymentRecord::getAmountForRefundRequest($refundRequest->order_item_id, $refundRequest->student_id) ?? 0) . '₫',
                $refundRequest->reason,
            ];


            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }
    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('orderItem', function ($q) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $q->byBranch($branch);
            }
        });
    }
    public static function scopeFilterByContactIds($query, $contactIds)
    {
        if (in_array('all', $contactIds)) {
            return $query;
        } else {
            return $query->whereIn('student_id', $contactIds);
        } 
    }

    public static function scopeFilterByRefundDate($query, $refund_date_from, $refund_date_to)
    {
        if (!empty($refund_date_from) && !empty($refund_date_to)) {
            return $query->whereBetween('refund_date', [$refund_date_from, \Carbon\Carbon::parse($refund_date_to)->endOfDay()]);
        }

        return $query;
    }
    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($refund_date_to)) {
            return $query->whereBetween('created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        } 
        return $query;
    }
}
