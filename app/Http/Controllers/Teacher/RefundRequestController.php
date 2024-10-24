<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\PaymentAccount;
use App\Models\RefundRequest;
use Illuminate\Http\Request;

class RefundRequestController extends Controller
{
    public function index(Request $request)
    {
        return view('teacher.refund_requests.index',[
            'status' => $request->status,
            'columns' => [
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
           
                
            ],
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
                case RefundRequest::STATUS_CANCEL:
                    $query = $query->cancel();
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
        if ($request->key) {
            $query = $query->search($request->key);
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
        
        return view('teacher.refund_requests.list',[
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
        // $courseStudents = CourseStudent::where('student_id', $refundRequest->student_id)
        // ->with('course.subject')
        // ->get();

        return view('teacher.refund_requests.showRequest', [
            'paymentAccounts' => $paymentAccounts,
            // 'courseStudents' => $courseStudents,
            'refundRequest' => $refundRequest,
        ]);
    }
}
