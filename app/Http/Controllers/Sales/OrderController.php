<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Controllers\Controller;
use App\Library\Permission;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Contact;
use App\Models\ContactRequest;
use App\Models\PaymentReminder;
use App\Models\TrainingLocation;
use App\Models\AbroadService;
use App\Models\Extracurricular;
use App\Models\ExcelData;
use App\Models\Account;
use App\Models\RevenueDistribution;

use App\Events\NewOrderCreated;
use App\Events\OrderApprovalRequested;
use App\Events\OrderCreated;


use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // List view & Columns
        $listViewName = 'sales.orders';
        $columns = [
            ['id' => 'code', 'title' => trans('messages.order.code'), 'checked' => true],
            ['id' => 'import_id', 'title' => trans('messages.order.import_id'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.order.type'), 'checked' => true],
            ['id' => 'contact_code', 'title' => trans('messages.contact.code'), 'checked' => true],
            ['id' => 'parent_note', 'title' => trans('messages.order.parent_note'), 'checked' => true],
            ['id' => 'fullname', 'title' => trans('messages.order.customer_name'), 'checked' => true],
            ['id' => 'code_student', 'title' => trans('messages.order.student_code'), 'checked' => true],
            ['id' => 'student', 'title' => trans('messages.order.student'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.order.type'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.order.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.order.email'), 'checked' => true],
            ['id' => 'price', 'title' => trans('messages.order.price'), 'checked' => true],
            ['id' => 'paid_amount', 'title' => trans('messages.order.paid_amount'), 'checked' => true],
            ['id' => 'remain_amount', 'title' => trans('messages.order.remain_amount'), 'checked' => true],
            ['id' => 'is_pay_all', 'title' => trans('messages.order.is_pay_all'), 'checked' => true],
            ['id' => 'payment_status', 'title' => trans('messages.order.payment_status'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.order.status'), 'checked' => true],
            ['id' => 'order_date', 'title' => trans('messages.order.order_date'), 'checked' => true],
            ['id' => 'updated_at', 'title' => trans('messages.order.updated_at'), 'checked' => true],
            ['id' => 'sale', 'title' => trans('messages.order.sale'), 'checked' => true],
            ['id' => 'sale_sup', 'title' => trans('messages.order.sale_sup'), 'checked' => true],
            ['id' => 'current_school', 'title' => trans('messages.order.current_school'), 'checked' => false],
            ['id' => 'industry', 'title' => trans('messages.order.industry'), 'checked' => false],
            ['id' => 'rejected_reason', 'title' => trans('messages.order.rejected_reason'), 'checked' => false]
        ];

        // list view name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('sales.orders.index', [
            'listViewName' => $listViewName,
            'columns' => $columns,
            'screenType' => $request->type
        ]);
    }

    public function list(Request $request)
    {
        $query = $request->user()->account->saleOrders(); 

        if ($request->user()->can('changeBranch', \App\Library\Branch::class)) {
            $query = Order::byBranch(\App\Library\Branch::getCurrentBranch())->select('orders.*')
            ->join('contacts', 'contacts.id', '=' , 'orders.student_id');

            // $query = $query->whereHas('salesperson', function ($subquery) {
            //     // $subquery->where('branch', \App\Library\Branch::getCurrentBranch());
            //     $subquery->where('branch', "HN");
            // });
        } else {
            $query = $request->user()->account->saleOrdersByAccount()
            ->select('orders.*')
            ->join('contacts', 'contacts.id', '=' , 'orders.student_id');
        }

        // filter deleted ones
        if ($request->status && $request->status == Order::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->notDeleted();
        }

        if ($request->screenType) {
            $query = $query->filterByScreenType($request->screenType);
        }

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->contact) {
            $query = $query->filterByContact($request->contact);
        }

        if ($request->student_id) {
            $query = $query->filterByStudentId($request->student_id);
        }

        if ($request->industries) {
            $query = $query->filterByIndustries($request->industries);
        }

        if ($request->orderTypes) {
            $query = $query->filterByOrderTypes($request->orderTypes);
        }

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

        if ($request->has('order_date_from') && $request->has('order_date_to')) {
            $order_date_from = $request->input('order_date_from');
            $order_date_to = $request->input('order_date_to');
            $query = $query->filterByOrderDate($order_date_from, $order_date_to);
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

        if (isset($request->screenType) && $request->screenType == Order::TYPE_GENERAL) {
            $query->getGeneral();
        } else {
            $query->getRequestDemo();
        }
        
        $orders = $query->paginate($request->perpage ?? 10);

        return view('sales.orders.list', [
            'orders' => $orders,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'screenType' => $request->screenType ? $request->screenType : Order::TYPE_GENERAL
        ]);
    }

    public function createConstract(Request $request)
    {
        if ($request->order_id) {
            $order = Order::find($request->order_id);
        } else {
            $order = $request->user()->account->newOrder();
        }
        
        $errors = $order->saveOrderCustomerInfoFromRequest($request);

        $viewReturn = $request->type == Order::TYPE_REQUEST_DEMO ? 'pickContactForRequestDemo' : 'pickContact';

        if (!$errors->isEmpty()) {
            return response()->view('sales.orders.' . $viewReturn, [
                'errors' => $errors,
                'order' => $order,
                'type' => $request->type,
                'contact' => Contact::find($request->contact),
            ], 400);
        };

        // copy from
        if ($request->copy_from_order_id) {
            if (!isset($request->contact_id)) {
                $viewReturn = 'pickContactForRequestDemo';

                // Temporary understanding: if contact_id is not passed, then by default errors are indicating a problem.
                return response()->view('sales.orders.' . $viewReturn, [
                    'errors' => $errors,
                    'order' => $order,
                    'type' => $request->type,
                    'contact' => Contact::find($request->contact),
                ], 400);
            }

            $copyFromOrder = Order::find($request->copy_from_order_id);
            $order->copyFrom($copyFromOrder);
        }

        // event
        OrderCreated::dispatch($order);
        NewOrderCreated::dispatch($order);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới hợp đồng thành công!',
            'orderId' => $order->id,
            "redirect" => action([OrderController::class, 'showFormCreateConstract'], [
                'orderId' => $order->id,
                'actionType' => 'create',
            ]),
        ]);
    }

    public function showFormDeleteConstract(Request $request, $orderId)
    {
        return view('sales.orders.deleteOrder', [
            "orderId" => $orderId
        ]);
    }

    public function showFormCreateConstract(Request $request)
    {
        $orderId = $request->orderId;
        $order = Order::find($orderId);

        return view('sales.orders.createConstract', [
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
        $abroadApplications = Extracurricular::all();

        if (!$order) {
            throw new \Exception("Không tìm thấy hợp đồng!");
        }

        $orderItem = !$request->order_item_id ? OrderItem::newDefault() : OrderItem::find($request->order_item_id);
        $demoItemsByContactId = Order::getDemoItemsByContactId($order->contact_id);
        $request->merge(['schedule_items' => json_encode($request->schedule_items)]);
        $errors = $orderItem->saveFromRequest($request);

        $viewName;
        $prefix = 'sales.orders.';

        switch ($request->type) {
            case Order::TYPE_EDU:
                $viewName = "createTrainOrder";
                break;
            case Order::TYPE_ABROAD:
                $viewName = "createAbroadOrder";
                break;
            case Order::TYPE_EXTRACURRICULAR:
                $viewName = "createExtraItem";
                break;
            case Order::TYPE_REQUEST_DEMO:
                $viewName = "createDemoOrder";
                break;
            default:
                $viewName = "createDemoOrder";
        }

        if (!$errors->isEmpty()) {
            return response()->view($prefix . $viewName, [
                "errors" => $errors,
                'sales_revenued_list' => $request->has('sales_revenued_list') ? collect(json_decode($request->sales_revenued_list, true)) : [],
                'abroadServiceType' => isset($request->abroad_service_type) ? $request->abroad_service_type : null,
                "orderItemId" => $request->order_item_id,
                'demoItemsByContactId' => $demoItemsByContactId,
                "orderId" => $order->id,
                'order' => $order,
                "orderItem" => $orderItem,
                'extracurricular' => isset($request->extracurricular_id) ? Extracurricular::find($request->extracurricular_id) : null,
                'type' => isset($orderItem->type) ? $orderItem->type : null,
                'subject_id' => isset($orderItem->subject_id) ? $orderItem->subject_id : null,
                'subjectType' => isset($request->subject_type) ? $request->subject_type : null,
                'abroadApplications' => $abroadApplications,
                'priceReturn' => isset($request->price) ? $request->price : null,

                'defaultSaleId' => $order->salesperson->id,
                'revenueData' => isset($request->sales_revenued_list) ? $request->sales_revenued_list : null
            ], 400);
        }

        return response()->view('sales.orders.createConstract', [
            "orderId" => Order::find($order->id),
            "order" => $order,
            "orderItems" => OrderItem::where('order_id', $order->id)->get(),
            "contactId" => $order->contacts->id
        ], 200);
    }

    // Use this method when click temparary save contractData
    public function saveConstractData(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::find($orderId);
        $errors = $order->temporarySaveFromRequest($request);
        
        if (!$errors->isEmpty()) {
            return response()->view('sales.orders.createConstract', [
                "orderId" => $orderId,
                "order" => $order,
                "orderItems" => OrderItem::where('order_id', $orderId)->get(),
                "contactId" => Order::find($orderId)->contacts->id,
                "errors" => $errors
            ], 200);
        }

        return response()->view('sales.orders.createConstract', [
            "orderId" => $orderId,
            "order" => $order,
            "orderItems" => OrderItem::where('order_id', $orderId)->get(),
            "contactId" => Order::find($orderId)->contacts->id,
        ], 200);
    }

    // Use this when finish action create, save contract -> return list contract
    public function doneCreateConstractData(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::find($orderId);
        $errors = $order->temporarySaveFromRequest($request);
        
        if (!$errors->isEmpty()) {
            return response()->view('sales.orders.createConstract', [
                "orderId" => $orderId,
                "order" => $order,
                "orderItems" => OrderItem::where('order_id', $orderId)->get(),
                "contactId" => Order::find($orderId)->contacts->id,
                "errors" => $errors
            ], 400);
        }

        $errors = $order->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.orders.createConstract', [
                "orderId" => $orderId,
                "order" => $order,
                "orderItems" => OrderItem::where('order_id', $orderId)->get(),
                "contactId" => Order::find($orderId)->contacts->id,
                "errors" => $errors
            ], 400);
        }
        
        if ($request->save_and_request) {
            if($order->type ==='request-demo'){
                $order->approve();
                OrderApprovalRequested::dispatch($order);
            }else{
                $order->requestApproval();
                OrderApprovalRequested::dispatch($order);
            }
        }

        return response()->json([
            "message" => "Thành công!"
        ]);
    }

    // Show popup create extra order item
    public function showCreateExtraPopup(Request $request)
    {
        $sales_revenued_list = [];
        $orderItemId = $request->orderItemId;
        $order = isset($request->orderId) ? Order::find($request->orderId) : OrderItem::find($request->orderItemId)->orders;

        if ($request->has('currOrderItemId')) {
            $sales_revenued_list = OrderItem::find($request->currOrderItemId)->revenueDistributions->toArray();
        }

        $abroadApplications = Extracurricular::all();

        return view('sales.orders.createExtraItem', [
            'abroadApplications' => $abroadApplications,
            'order' => $order,
            'raw_sales_revenued_list' => $sales_revenued_list,
            'orderItemId' => isset($orderItemId) ? $orderItemId : null,
            'copyOrderItemId' => isset($request->currOrderItemId) ? $request->currOrderItemId : null,
            'extracurricular' => isset($orderItemId) ? OrderItem::find($orderItemId)->extracurricular : null,
            'orderItem' => isset($orderItemId) && $orderItemId ? OrderItem::find($orderItemId) : null,
            
            // revenue
            'defaultSaleId' => $order->salesperson->id,
        ]);
    }

    // Show popup create train order item
    public function createTrainOrder(Request $request)
    {
        $orderItemId = $request->orderItemId;
        $orderItem = OrderItem::find($request->orderItemId);
        $order = isset($request->orderId) ? Order::find($request->orderId) : OrderItem::find($request->orderItemId)->orders;
        $demoItemsByContactId = Order::getDemoItemsByContactId($request->contactId);
        $sales_revenued_list = [];

        if ($request->has('currOrderItemId')) {
            $sales_revenued_list = OrderItem::find($request->currOrderItemId)->revenueDistributions->toArray();
        }

        return view('sales.orders.createTrainOrder', [
            'orderId' => $request->orderId,
            'orderItemId' => isset($orderItemId) ? $orderItemId : null,
            'copyOrderItemId' => isset($request->currOrderItemId) ? $request->currOrderItemId : null,
            'raw_sales_revenued_list' => $sales_revenued_list,
            'orderItem' => $orderItem,
            'demoItemsByContactId' => $demoItemsByContactId,
            'type' => isset($orderItem->type) ? $orderItem->type : null,
            'subject_id' => isset($orderItem->subject_id) ? $orderItem->subject_id : null,

            'defaultSaleId' => $order->salesperson->id,
        ]);
    }

    public function createAbroadOrder(Request $request)
    {
        ini_set("memory_limit", "-1");
        $orderItemId = $request->orderItemId;
        $orderItem = OrderItem::find($request->orderItemId);
        $order = isset($request->orderId) ? Order::find($request->orderId) : OrderItem::find($request->orderItemId)->orders;
        $sales_revenued_list = [];

        if ($request->has('currOrderItemId')) {
            $sales_revenued_list = OrderItem::find($request->currOrderItemId)->revenueDistributions->toArray();
        }

        return view('sales.orders.createAbroadOrder', [
            'orderId' => $request->orderId,
            'orderItemId' => isset($orderItemId) ? $orderItemId : null,
            'orderItem' => $orderItem,
            'copyOrderItemId' => isset($request->currOrderItemId) ? $request->currOrderItemId : null,
            'raw_sales_revenued_list' => $sales_revenued_list,
            'type' => isset($orderItem->type) ? $orderItem->type : null,

            'defaultSaleId' => $order->salesperson->id,
        ]);
    }

    public function createDemoOrder(Request $request)
    {
        $orderItemId = $request->orderItemId;
        $orderItem = OrderItem::find($request->orderItemId);

        return view('sales.orders.createDemoOrder', [
            'orderId' => $request->orderId,
            'orderItemId' => $orderItemId,
            'orderItem' => $orderItem,
            'type' => isset($orderItem->type) ? $orderItem->type : null,
            'subject_id' => isset($orderItem->subject_id) ? $orderItem->subject_id : null
        ]);
    }

    public function pickContact(Request $request)
    {
        // init
        $copyFromOrder = null;

        if ($request->order_id) {
            $order = Order::find($request->order_id);
        } else {
            $order = $request->user()->account->newOrder();
        }

        // copy from
        if ($request->copy_from_order_id) {
            $copyFromOrder = Order::find($request->copy_from_order_id);
            $order->type = $copyFromOrder->type;
        }

        if ($request->contact_id) {
            $order->contact_id = $request->contact_id;
        }

        if ($request->contact_request_id) {
            $contactRequest = \App\Models\ContactRequest::find($request->contact_request_id);
            $order->contact_id = $contactRequest->contact_id;
            $order->contact_request_id = $contactRequest->id;
        }

        return view('sales.orders.pickContact', [
            'order' => $order,
            'copyFromOrder' => $copyFromOrder,
        ]);
    }

    public function editOrderCustomer(Request $request, $id)
    {
        $order = Order::find($id);

        if ($request->contact_request_id) {
            $contactRequest = \App\Models\ContactRequest::find($request->contact_request_id);
            $order->contact_id = $contactRequest->contact_id;
            $order->contact_request_id = $contactRequest->id;
        }

        if ($request->copy_from_order_id) {
            $copyFromOrder = Order::find($request->copy_from_order_id);
            $order->type = $copyFromOrder->type;
        }

        return view('sales.orders.pickContact', [
            'order' => $order,
            'copyFromOrder' => $copyFromOrder,
        ]);
    }

    public function pickContactForRequestDemo(Request $request)
    {
        // init
        $copyFromOrder = null;
        
        $order = $request->user()->account->newOrder();
        $order->type = 'request-demo';

        // copy from
        if ($request->copy_from_order_id) {
            $copyFromOrder = Order::find($request->copy_from_order_id);
            $order->type = $copyFromOrder->type;
        }

        if ($request->contact_request_id) {
            $contactRequest = \App\Models\ContactRequest::find($request->contact_request_id);
            $order->contact_id = $contactRequest->contact_id;
            $order->contact_request_id = $contactRequest->id;
        }

        if ($request->contact_id) {
            $order->contact_id = $request->contact_id;
        }

        return view('sales.orders.pickContactForRequestDemo', [
            'order' => $order,
            'copyFromOrder' => $copyFromOrder,
        ]);
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

    public function confirmRequestDemo(Request $request, $id)
    {
        $order = Order::find($id);
        $order->confirmRequestDemo();

        // event
        // OrderApprovalRequested::dispatch($order);

        return response()->json([
            'status' => 'success',
            'message' => 'Yêu cầu học thử đã được xác nhận',
        ]);
    }

    public function delete(Request $request)
    {
        $order = Order::find($request->id);

        $order->deleteOrder();

        return response()->json([
            "status" => "Success",
            "message" => "Xóa hợp đồng thành công!"
        ]);
    }

    public function showConstract(Request $request)
    {
        $order = Order::find($request->id);
        $orderItems = OrderItem::where('order_id', $request->id)->get();
        $paymentReminders = PaymentReminder::where('order_id', $request->id)->get()->sortBy('due_date');
        
        return view('sales.orders.showConstract', [
            'order' => $order,
            'orderItems' => $orderItems,
            'paymentReminders' => $paymentReminders,
        ]);
    }

    public function pickContactRequest(Request $request)
    {
        if (!$request->contact_ids) {
            return '';
        }

        // permission on all contact requests
        if ($request->user()->hasPermission(Permission::SALES_DASHBOARD_ALL)) {
            $newContactRequests = ContactRequest::NotDeleted()
                ->whereIn('contact_id', $request->contact_ids)
                ->doesntHaveNewOrder();

            $contactRequests = ContactRequest::NotDeleted()
                ->whereIn('contact_id', $request->contact_ids)
                ->haveOrderIsDraft();

        // only create contract for own contact requests
        } else {
            $newContactRequests = $request->user()->account->contactRequests()->NotDeleted()
                ->whereIn('contact_id', $request->contact_ids)
                ->doesntHaveNewOrder();

            $contactRequests = $request->user()->account->contactRequests()->NotDeleted()
                ->whereIn('contact_id', $request->contact_ids)
                ->haveOrderIsDraft();
        }

        return view('sales.orders.pickContactRequest', [
            'newContactRequests' => $newContactRequests,
            'contactRequests' => $contactRequests,
            'contactRequestId' => $request->contact_request_id,
            'contactIds' => isset($request->contact_ids) ? $request->contact_ids : null,
            'orderType' => isset($request->orderType) ? $request->orderType : null,
        ]);
    }


    public function relationshipForm(Request $request)
    {
        $contact = Contact::find($request->contact_id);
        $toContact = Contact::find($request->to_contact_id);

        return view('sales.orders.relationshipForm', [
            'contact' => $contact,
            'toContact' => $toContact,
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->orders)) {
            Order::deleteAll($request->orders);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Xóa thất bại!'
        ], 400);
    }

    public function getTotalPriceOfItems(Request $request) 
    {
        $order = Order::find($request->id);

        return $order->getTotalPriceOfOrderItems();
    }

    public function getSaleSup(Request $request) 
    {
        $order = Order::find($request->orderId);

        if (!$order) {
            throw new \Exception("Không tìm thấy order!");
        }

        return $order->getSaleSup()->id;
    }

    public function showQrCode(Request $request, $id)
    {
        $order = Order::find($id);
        
        if ($order->salesperson->accountGroup) {
            switch ($order->type) {
                case Order::TYPE_ABROAD:
                    $paymentAccount = $order->salesperson->accountGroup->paymentAccountAbroad()->first();
                    break;
                case Order::TYPE_EDU:
                    $paymentAccount = $order->salesperson->accountGroup->paymentAccountEdu()->first();
                    break;
                case Order::TYPE_EXTRACURRICULAR:
                    $paymentAccount = $order->salesperson->accountGroup->paymentAccountExtracurricular()->first();
                    break;
                default:
            }
        }
        return view('sales.orders.qrCode', [
           'order' => $order,
           'paymentAccount' => $paymentAccount
        ]);
    }
    public function historyRejected(Request $request, $id)
    {
        $order = Order::find($id);
        $rejections = $order->rejections;
        
        return view('sales.orders.historyRejected', [
           'order' => $order,
           'rejections' => $rejections
        ]);
    }

    public function loadAbroadServiceOptionsByType(Request $request)
    {
        $type = $request->type;

        if (!in_array($type, AbroadService::types()->toArray())) {
            throw new \Exception("Invalid abroad services type, this type is not in the type array!");
        }

        $services = AbroadService::getServiceByType($type);

        return response()->view('servicesByType', [
            'services' => $services,
            'selectedValue' => isset($request->serviceSelectedId) ? $request->serviceSelectedId : null 
        ]);
    }

    public function saveSale(Request $request)
    {
        $order = Order::find($request->orderId);

        $order->sale = $request->sale;
        $order->sale_sup = $request->saleSup;
        $order->save();
        $order->checkRevenueDistributions();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật sale thành công',
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
    
    public function export(Request $request)
    {
        $templatePath = public_path('templates/orders.xlsx');
        $filterOrders = $this->filterOrders($request);
        $templateSpreadsheet = IOFactory::load($templatePath);
        Order::exportSalesOrder($templateSpreadsheet, $filterOrders);
    
        // Output path
        $storagePath = storage_path('app/exports');
    
        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }
    
        $outputFileName = 'orders.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
    
        $writer->save($outputFilePath);

        if (!file_exists($outputFilePath)) {
            return response()->json(['error' => 'Failed to save the file.'], 500);
        }
    
        return response()->download($outputFilePath, $outputFileName);
    }


    public function filterOrders(Request $request)
    {
        $query = $request->user()->account->saleOrders(); 
        if ($request->user()->hasPermission(Permission::SALES_DASHBOARD_ALL)) {
            $query = Order::byBranch(\App\Library\Branch::getCurrentBranch())->select('orders.*')
            ->join('contacts', 'contacts.id', '=' , 'orders.student_id');
            
            // $query = $query->whereHas('salesperson', function ($subquery) {
                //     // $subquery->where('branch', \App\Library\Branch::getCurrentBranch());
                //     $subquery->where('branch', "HN");
                // });
            } else {
                $query = $request->user()->account->saleOrdersByAccount()
                ->select('orders.*')
                ->join('contacts', 'contacts.id', '=' , 'orders.student_id');
            }
            
        // filter deleted ones
        if ($request->status && $request->status == Order::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->notDeleted();
        }

        if ($request->screenType) {
            $query = $query->filterByScreenType($request->screenType);
        }

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->contact) {
            $query = $query->filterByContact($request->contact);
        }

        if ($request->student_id) {
            $query = $query->filterByStudentId($request->student_id);
        }

        if ($request->industries) {
            $query = $query->filterByIndustries($request->industries);
        }

        if ($request->orderTypes) {
            $query = $query->filterByOrderTypes($request->orderTypes);
        }

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
        
        if ($request->has('order_date_from') && $request->has('order_date_to')) {
            $order_date_from = $request->input('order_date_from');
            $order_date_to = $request->input('order_date_to');
      
            $query = $query->filterByOrderDate($order_date_from, $order_date_to);
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
        
        if (isset($request->screenType) && $request->screenType == Order::TYPE_GENERAL) {
            $query->getGeneral();
        } else {
            $query->getRequestDemo();
        }
            // Add logging to check the query after filtering
        return $query->get();
    }
}
