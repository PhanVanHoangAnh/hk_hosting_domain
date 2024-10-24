<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentReminder;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\OrderApprovalRequested;
use App\Events\OrderApproved;
use App\Events\OrderRejected;

use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'accounting.order';
        $columns = [
            ['id' => 'code', 'title' => trans('messages.order.code'), 'checked' => true],
            ['id' => 'parent_note', 'title' => trans('messages.order.parent_note'), 'checked' => true   ],
            ['id' => 'fullname', 'title' => trans('messages.order.fullname'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.order.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.order.email'), 'checked' => true],
            ['id' => 'price', 'title' => trans('messages.order.price'), 'checked' => true],
            ['id' => 'paid_amount', 'title' => trans('messages.order.paid_amount'), 'checked' => true],
            ['id' => 'remain_amount', 'title' => trans('messages.order.remain_amount'), 'checked' => true],
            ['id' => 'is_pay_all', 'title' => trans('messages.order.is_pay_all'), 'checked' => true],
            ['id' => 'payment_status', 'title' => trans('messages.order.payment_status'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.order.status'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.order.created_at'), 'checked' => true],
            ['id' => 'updated_at', 'title' => trans('messages.order.updated_at'), 'checked' => true],
            ['id' => 'sale', 'title' => trans('messages.order.sale'), 'checked' => true],
            ['id' => 'sale_sup', 'title' => trans('messages.order.sale_sup'), 'checked' => true],
            ['id' => 'current_school', 'title' => trans('messages.order.current_school'), 'checked' => false],
            // ['id' => 'industry', 'title' => trans('messages.order.industry'), 'checked' => false],
            ['id' => 'type', 'title' => trans('messages.order.type'), 'checked' => false],
        ];

        //
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));
        return view('accounting.orders.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted();

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->orderTypes) {
            $query = $query->filterByOrderTypes($request->orderTypes);
        }
        
        if ($request->industries) {
            $query = $query->filterByIndustries($request->industries);
        }

        // if ($request->types) {
        //     $query = $query->filterByTypes($request->types);
        // }

        if ($request->types) {
            $query = $query->filterByTypeSubjects($request->types);
        }
        
        if ($request->sales) {
            $query = $query->filterBySales($request->sales);
        }

        if ($request->saleSups) {
            $query = $query->filterBySaleSups($request->saleSups);
        }

        if ($request->paymentOrderStatus) {
            $query = $query->filterByPaymentOrderStatus($request->paymentOrderStatus);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // statuses
        if ($request->status) {
            switch ($request->status) {
                case Order::STATUS_DRAFT:
                    $query = $query->draft();
                    break;

                case Order::STATUS_PENDING:
                    $query = $query->pending();
                    break;

                case Order::STATUS_APPROVED:
                    $query = $query->approved();
                    break;

                case Order::STATUS_REJECTED:
                    $query = $query->rejected();
                    break;
                case Order::STATUS_DELETED:
                    $query = $query->deleted();
                    break;
                case Order::STATUS_REACHING_DUE_DATE:
                    $query = $query->reachingDueDate()->checkIsNotPaid();
                    break;
                case Order::STATUS_PAID:
                    $query = $query->checkIsPaid();
                    break;
                case Order::STATUS_OVER_DUE_DATE:
                    $query = $query->overDueDate()->checkIsNotPaid();
                    break;
                case Order::STATUS_PART_PAID:
                    $query = $query->partPaid()->checkIsNotPaid();
                    break;
                case 'all':
                    break;

                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        $orders = $query->paginate($request->perpage ?? 10);

        return view('accounting.orders.list', [
            'orders' => $orders,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function createConstract(Request $request)
    {
        $order = $request->user()->account->newOrder();

        $errors = $order->saveOrderCustomerInfoFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.orders.pickContact', [
                'errors' => $errors
            ], 400);
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới hợp đồng thành công!',
            'orderId' => $order->id
        ]);
    }

    public function showFormDeleteConstract(Request $request, $orderId)
    {
        return view('accounting.orders.deleteOrder', [
            "orderId" => $orderId
        ]);
    }

    public function delete(Request $request)
    {
        $order = Order::find($request->id);

        $order->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Xóa hợp đồng thành công!"
        ]);
    }

    public function showFormCreateConstract(Request $request)
    {
        $orderId = $request->orderId;
        $order = Order::find($orderId);

        return view('accounting.orders.createConstract', [
            "orderId" => $orderId,
            "order" => $order,
            "orderItems" => OrderItem::where('order_id', $orderId)->get(),
            "contactId" => $order->contacts->id,
            "actionType" => $request->actionType,
            "message" => "Thêm mới đơn hàng thành công!"
        ]);
    }

    public function saveOrderItemData(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json([
                "message" => "Thất bại!"
            ], 400);
        }

        $orderItem = !$request->order_item_id ? OrderItem::newDefault() : OrderItem::find($request->order_item_id);

        $request->merge(['schedule_items' => json_encode($request->schedule_items)]);

        $errors = $orderItem->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.orders.' . ($request->type == "Đào tạo" ? "createTrainOrder" : "createAbroadOrder"), [
                "errors" => $errors,
                "orderItemId" => $request->order_item_id,
                "orderItem" => $orderItem
            ], 400);
        }

        return response()->json([
            "message" => "Thành công!"
        ]);
    }

    public function saveConstractData(Request $request)
    {
        $orderId = $request->order_id;

        $order = Order::find($orderId);

        $errors = $order->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.orders.createConstract', [
                "orderId" => $orderId,
                "order" => $order,
                "orderItems" => OrderItem::where('order_id', $orderId)->get(),
                "contactId" => Order::find($orderId)->contacts->id,
                "errors" => $errors
            ], 400);
        }

        return response()->json([
            "message" => "Thành công!"
        ]);
    }

    public function createTrainOrder(Request $request)
    {
        $orderItemId = $request->orderItemId;
        $orderItem = OrderItem::find($request->orderItemId);

        return view('accounting.orders.createTrainOrder', [
            'orderItemId' => $orderItemId,
            'orderItem' => $orderItem
        ]);
    }

    public function createAbroadOrder(Request $request)
    {
        $orderItemId = $request->orderItemId;
        $orderItem = OrderItem::find($request->orderItemId);

        return view('accounting.orders.createAbroadOrder', [
            'orderItemId' => $orderItemId,
            'orderItem' => $orderItem
        ]);
    }

    public function pickContact(Request $request)
    {
        return view('accounting.orders.pickContact');
    }

    public function requestApproval(Request $request, $id)
    {
        $order = Order::find($id);

        $order->requestApproval();

        // event
        OrderApprovalRequested::dispatch($order);

        return response()->json([
            'status' => 'success',
            'message' => 'Hợp đồng đã được yêu cầu duyệt thành công',
        ]);
    }

    public function approve(Request $request, $id)
    {
        $order = Order::find($id);

        $order->duyetHopDong();

        // event
        OrderApproved::dispatch($order, $request->user());

        return response()->json([
            'status' => 'success',
            'message' => 'Hợp đồng đã được duyệt thành công',
        ]);
    }

    public function reject(Request $request, $id)
    {
        $order = Order::find($id);

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'rejected_reason' => 'required',
            ]);

            if ($validator->fails()) {

                return response()->view('accounting.orders.reject', [
                    'order' => $order,
                    'errors' => $validator->errors(),
                ], 400);
            }

            $order->reject($request->rejected_reason);

            // event
            OrderRejected::dispatch($order, $request->user());

            // add note log
            // $order->contacts->addNoteLog($request->user()->account, "Hợp đồng mã số <strong>{$order->getCode()}</strong> của bạn không được duyệt. Lý do: " . $request->rejected_reason);

            return response()->json([
                'status' => 'success',
                'message' => 'Hợp đồng đã được từ chối thành công',
            ]);
        }

        return view('accounting.orders.reject', [
            'order' => $order,
        ]);
    }


    public function showConstract(Request $request)
    {
        $order = Order::find($request->id);

        $teachers = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR])->get();

        $orderItems = OrderItem::where('order_id', $request->id)->get();
        $paymentReminders = PaymentReminder::where('order_id', $request->id)->get()->sortBy('due_date');

        return view('accounting.orders.showConstract', [
            'order' => $order,
            'orderItems' => $orderItems,
            'paymentReminders' => $paymentReminders,
            'teachers' => $teachers

        ]);
    }

    public function historyRejected(Request $request, $id)
    {
        $order = Order::find($id);
        $rejections = $order->rejections;
        
        return view('accounting.orders.historyRejected', [
           'order' => $order,
           'rejections' => $rejections
           
        ]);
    }


    public function exportOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            abort(404);
        } 
        if($order->type == \App\Models\Order::TYPE_EDU){ 
            $html = view('accounting.orders.pdfEdu', compact('order'))->render();
        }
        if($order->type == \App\Models\Order::TYPE_ABROAD){ 
            $html = view('accounting.orders.pdfAbroad', compact('order'))->render();
        }
        if($order->type == \App\Models\Order::TYPE_EXTRACURRICULAR){ 
            $html = view('accounting.orders.pdfExtra', compact('order'))->render();
        }
        
     
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
    
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
    
        
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        
        $pdfContent = $dompdf->output();
    
        return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Length', strlen($pdfContent));
      
    }
}
