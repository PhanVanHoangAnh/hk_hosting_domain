<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\PaymentAccount;
use App\Models\RefundRequest;
use Illuminate\Http\Request;

class RefundRequestController extends Controller
{
    public function index(Request $request)
    {
        return view('abroad.refund_requests.index',[
            'status' => $request->status,
            'columns' => [
                ['id' => 'payment_date', 'title' => trans('messages.payment.payment_date'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.payment.created_at'), 'checked' => false],
                // ['id' => 'id', 'title' => trans('messages.payment.id'), 'checked' => true],
                ['id' => 'order_id', 'title' => trans('messages.payment.order_id'), 'checked' => true],
                ['id' => 'contact_id', 'title' => trans('messages.contact.id'), 'checked' => true],
                ['id' => 'contact_name', 'title' => trans('messages.contact.name'), 'checked' => true],
                ['id' => 'contact_name', 'title' => trans('messages.contact.name'), 'checked' => true],
                ['id' => 'industry', 'title' => trans('messages.order.industry'), 'checked' => true],
                ['id' => 'type', 'title' => trans('messages.payment.type'), 'checked' => true],
                ['id' => 'description', 'title' => trans('messages.payment.description'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.payment.updated_at'), 'checked' => false],
                ['id' => 'account_id', 'title' => trans('messages.payment.account_id'), 'checked' => false],
                ['id' => 'amount', 'title' => trans('messages.payment.amount'), 'checked' => true],
            ],
        ]);
    }

    public function list(Request $request)
    {
        $query = RefundRequest::query()->with('student', 'course','courseStudent');
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

        $query = $query->orderBy($sortColumn, $sortDirection);
        $requests = $query->paginate($request->perpage ?? 20);

        return view('abroad.refund_requests.list',[
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

        return view('abroad.refund_requests.showRequest', [
            'paymentAccounts' => $paymentAccounts,
            // 'courseStudents' => $courseStudents,
            'refundRequest' => $refundRequest,
        ]);
    }
}
