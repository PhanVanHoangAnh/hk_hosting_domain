<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use App\Models\RefundRequest;
use App\Models\Section;
use App\Models\Tag;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\NoteLog;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Account;
use App\Models\CourseStudent;

use App\Models\ContactRequest;
use App\Models\Reserve;
use App\Models\StudentSection;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use Illuminate\Support\Facades\Validator;
use App\Events\AssigmentClass;

use App\Events\UpdateReserve;
use function Laravel\Prompts\alert;
use Carbon\Carbon;

class StudentController extends Controller
{

    
    public function courseRefundRequestForm(Request $request)
    {
        $currentCourses = collect();
        $studentId = $request->studentId;
        $order_item = $request->order_item_ids;
        $currentCourses = new Course;
        $currentCourses = $currentCourses->getCoursesByOrderItemAndStudent($order_item, $studentId);

        return view('sales.students.course_refund_request_form', [
            'currentCourses' => $currentCourses,
            'studentId' => $studentId,
        ]);
    }
    public function refundRequest(Request $request)
    {
        $student_id = $request->id;
        $currentCourseId = $request->courseId;
        $currentCourse = Course::find($currentCourseId);
        $student = Contact::find($student_id);

        return view('sales.students.refundRequest', [
            'student' => $student,
            'currentCourse' => $currentCourse
        ]);
    }

    public function doneRefundRequest(Request $request)
    {
        
        $studentId = null;
        foreach ($request->all() as $key => $value) {
            // Kiểm tra nếu key có chứa 'contact_id'
            if (strpos($key, 'contact_id') === 0) {
                // Lấy giá trị contact_id
                $studentId = $value;
                break;
            }
        }
       
        // init
        $orderItemIds = $request->orderItemIds;

        $reserveStartAt = $request->reserve_start_at;
        $reason = $request->reason;
       

        // Bảo lưu lớp học
        $student = Contact::find($studentId);
        // $currentCourse = Course::find($currentCourseId);
        // $orderItem = CourseStudent::getOrderItemId($studentId, $currentCourseId);
        // $orderItem = $orderItem->getOrderItem();

        try {
            $student->doneRefundRequest($orderItemIds, $reserveStartAt, $reason);

            // add note log
            $subjectsString = OrderItem::whereIn('id', $orderItemIds)->get()->map(function ($oi) {
                return "[" . $oi->getSubjectName() . " (HĐ: " . $oi->orders->code . ")]";
            })->join(',');

            $student->addNoteLog(
                $request->user()->account,
                "Gửi yêu cầu hoàn phí các dịch vụ: " . $subjectsString . ". Lý do hoàn phí: $reason"
            );
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Yêu cầu hoàn phí không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Yêu cầu hoàn phí thành công"
        ], 200);
    }
    public function orderItemRefundRequestForm(Request $request)
    {
        $studentId = $request->student_id;
        $orders = Order::where('student_id', $studentId)->get();
        $orderItems = OrderItem::getOrderItemByOrderRefundRequest($orders);

        return view('sales.students.order_item_refund_request_form', [
            'orderItems' => $orderItems,

            'studentId' => $studentId,
        ]);
    }

    

    

    public function select2(Request $request)
    {
        
        $request->merge(['type' => 'student']);

        return response()->json(Contact::select2RefundRequest($request));
    }

    
}
