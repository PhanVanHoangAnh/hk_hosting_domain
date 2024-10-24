<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\Order;
use App\Models\PaymentAccount;
use App\Models\PaymentRecord;
use App\Models\RefundRequest;
use App\Models\StudentSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RefundRequestController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'accounting.refund_request';
        $columns = [
            ['id' => 'student_id', 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'class', 'title' => trans('messages.contact.class'), 'checked' => true],
            ['id' => 'orderItem_id', 'title' => trans('messages.refund_requests.orderItem_id'), 'checked' => true],
            ['id' => 'level', 'title' => trans('messages.refund_requests.level'), 'checked' => true],

            ['id' => 'train_hours', 'title' => trans('messages.refund_requests.train_hours'), 'checked' => true],
            ['id' => 'studied_hours', 'title' => trans('messages.refund_requests.studied_hours'), 'checked' => true],
            ['id' => 'refund_hours', 'title' => trans('messages.refund_requests.refund_hours'), 'checked' => true],
            ['id' => 'remain_hours', 'title' => trans('messages.refund_requests.remain_hours'), 'checked' => true],
            ['id' => 'refund_date', 'title' => trans('messages.refund_requests.refund_date'), 'checked' => true],


            ['id' => 'reject_reason', 'title' => trans('messages.refund_requests.reject_reason'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.refund_requests.status'), 'checked' => true],
           


        //     ['id' => 'payment_date', 'title' => trans('messages.payment.payment_date'), 'checked' => true],
        //     ['id' => 'created_at', 'title' => trans('messages.payment.created_at'), 'checked' => false],
        //     // ['id' => 'id', 'title' => trans('messages.payment.id'), 'checked' => true],
        //     ['id' => 'order_id', 'title' => trans('messages.payment.order_id'), 'checked' => true],
        //     ['id' => 'contact_id', 'title' => trans('messages.contact.id'), 'checked' => true],
            
        //     ['id' => 'industry', 'title' => trans('messages.order.industry'), 'checked' => true],
        //     ['id' => 'type', 'title' => trans('messages.payment.type'), 'checked' => true],
        //     ['id' => 'description', 'title' => trans('messages.payment.description'), 'checked' => false],
        //     ['id' => 'updated_at', 'title' => trans('messages.payment.updated_at'), 'checked' => false],
        //     ['id' => 'account_id', 'title' => trans('messages.payment.account_id'), 'checked' => false],
        //     ['id' => 'amount', 'title' => trans('messages.payment.amount'), 'checked' => true],
        ];

        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));


        return view('accounting.refund_requests.index',[
            'status' => $request->status,
            'columns' =>$columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->with('student', 'course','courseStudent');
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->status) {
            switch ($request->status) {
                case RefundRequest::STATUS_PENDING:
                    $query = $query->pending();
                    break;
                case RefundRequest::STATUS_APPROVED:
                    
                    $query = $query->approved();
                    break;
                case RefundRequest::STATUS_REJECTED:
                    $query = $query->rejected();
                    break;
                case 'all':
                    break;
                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }
        if ($request->contact_ids) {
            $query = $query->filterByContactIds($request->contact_ids);
        }

        if ($request->has('refund_date_from') && $request->has('refund_date_to')) { 
            $refund_date_from = $request->input('refund_date_from');
            $refund_date_to = $request->input('refund_date_to');
            $query = $query->filterByRefundDate($refund_date_from, $refund_date_to);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) { 
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }
        $query = $query->orderBy($sortColumn, $sortDirection);
        $requests = $query->paginate($request->perpage ?? 20);

        return view('accounting.refund_requests.list',[
            'requests' => $requests,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function showRequest(Request $request, $id)
    {
        $refundRequest = RefundRequest::find($id);
        $paymentAccounts = PaymentAccount::all();
        $courseStudents = CourseStudent::where('student_id', $refundRequest->student_id)
        ->with('course.subject')
        ->get();

        return view('accounting.refund_requests.showRequest', [
            'paymentAccounts' => $paymentAccounts,
            'courseStudents' => $courseStudents,
            'refundRequest' => $refundRequest,
        
        ]);
    }

    public function rejectRefundRequest(Request $request, $id)
    {
        $refundRequest = RefundRequest::find($id);
       
        return view('accounting.refund_requests.reject_refund_request', [
            'refundRequest' => $refundRequest
        ]);
    }

    public function reject(Request $request, $id)
    {
        $refundRequest = RefundRequest::find($id);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'reject_reason' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->view('accounting.refund_requests.reject_refund_request', [
                    'refundRequest' => $refundRequest,
                    'errors' => $validator->errors(),
                ], 400);
            }

            $refundRequest->reject($request->reject_reason);

            return response()->json([
                'status' => 'success',
                'message' => 'Yêu cầu đã từ chối thành công',
            ]);
        }

        return view('accounting.refund_requests.reject_refund_request', [
            'refundRequest' => $refundRequest,
        ]);
    }

    public function saveRefund(Request $request, $id)
    {
        // init
        $refundRequest = RefundRequest::find($id);
        $paymentRecord = PaymentRecord::newDefault();
        $paymentAccounts = PaymentAccount::all();
        $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);

        // Hoàn phí - Approve
        $errors = $refundRequest->approveAndRefund($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.refund_requests.showRequest', [
                'paymentAccounts' => $paymentAccounts,
                'courseStudents' => $courseStudents,
                'refundRequest' => $refundRequest,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Duyệt vào tạo hoàn phí thành công!'
        ]);
    }

    public function cancelRequest(Request $request, $id)
    {
        $refundRequest = RefundRequest::find($id);
        $refundRequest->cancelRequest();

        return response()->json([
            'status' => 'success',
            'message' => 'Yêu cầu đã được hủy thành công',
        ]);
    }
}
