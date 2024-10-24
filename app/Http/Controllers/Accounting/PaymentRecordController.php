<?php

namespace App\Http\Controllers\Accounting;

use App\Events\ConfirmReceiptFromSale;
use App\Events\NewPaymentRecordCreated;
use App\Http\Controllers\Controller;
use App\Models\PaymentAccount;
use App\Models\PaymentReminder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentRecord;
use App\Models\Contact;
use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Facades\Validator;

class PaymentRecordController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'accounting.payment_record';
        $columns = [
            ['id' => 'payment_date', 'title' => trans('messages.payment.payment_date'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.payment.created_at'), 'checked' => false],
            // ['id' => 'id', 'title' => trans('messages.payment.id'), 'checked' => true],
            ['id' => 'order_id', 'title' => trans('messages.payment.order_id'), 'checked' => true],
            ['id' => 'contact_id', 'title' => trans('messages.contact.id'), 'checked' => true],
            ['id' => 'contact_name', 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'industry', 'title' => trans('messages.order.industry'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.payment.type'), 'checked' => true],
            ['id' => 'description', 'title' => trans('messages.payment.description'), 'checked' => false],
            ['id' => 'updated_at', 'title' => trans('messages.payment.updated_at'), 'checked' => false],
            ['id' => 'account_id', 'title' => trans('messages.payment.account_id'), 'checked' => false],
            ['id' => 'amount', 'title' => trans('messages.payment.amount'), 'checked' => true],
        ];

        // list name view
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));
        
        return view('accounting.payments.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
            'status' => $request->status,
        ]);
    }

    public function list(Request $request)
    {
        $query = PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->with('contact', 'account')
        ->join('contacts', 'contacts.id', '=', 'payment_records.contact_id')->select('payment_records.*','contacts.name');
        
        // $query = PaymentRecord::with('contact', 'account')
        // ->join('contacts', 'contacts.id', '=', 'payment_records.contact_id')->select('payment_records.*','contacts.name');
        
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // filter deleted ones
        if ($request->status && $request->status == PaymentRecord::STATUS_DELETED) {
            $query = $query->isDeleted();
        } 

        if ($request->key) {
            $query = $query->search($request->key);
        }

        // filter by contact id
        if ($request->contact_ids) {
            $query = $query->filterByContactIds($request->contact_ids);
        }

        // filter by account id
        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }

        // filter by order id
        if ($request->order_id) {
            $query = $query->filterByOrderId($request->order_id);
        }

        // Filter by payment_date
        if ($request->has('payment_date_from') && $request->has('payment_date_to')) {
            $payment_date_from = $request->input('payment_date_from');
            $payment_date_to = $request->input('payment_date_to');
            $query = $query->filterByCreatedAt($payment_date_from, $payment_date_to);
        }

        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        if ($request->status) {
            switch ($request->status) {
                case PaymentRecord::TYPE_REFUND:
                    $query = $query->refund();
                    break;
                case PaymentRecord::TYPE_RECEIVED:
                    $query = $query->received();
                    break;
                case PaymentRecord::STATUS_PENDING:
                    $query = $query->received()->pending();
                    break;
                case PaymentRecord::STATUS_PAID:
                    $query = $query->received()->paid();
                    break;
                case PaymentRecord::STATUS_DELETED:
                    $query = $query->isDeleted();
                    break;
                case PaymentRecord::STATUS_REJECT:
                    $query = $query->rejected();
                    break;
                case 'all':
                    break;
                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }

        // sort
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->orderBy($sortColumn, $sortDirection);
        $payments = $query->paginate($request->perpage ?? 20);

        return view('accounting.payments.list', [
            'payments' => $payments,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $order = Order::find($id);
        $orders = Order::all();
        $paymentRecord = PaymentRecord::find($id);
        $paymentAccounts = PaymentAccount::all();

        return view('accounting.payments.edit', [
            'paymentRecord' => $paymentRecord,
            'paymentAccounts' => $paymentAccounts,
            'order' => $order,
            'orders' => $orders,
        ]);
    }

    public function update(Request $request, $id)
    {
        $paymentRecord = PaymentRecord::find($id);
        $errors = $paymentRecord->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payments.edit', [
                'errors' => $errors,
                'paymentRecord' => $paymentRecord
            ], 400);
        };

        $paymentRecord->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }

    public function showPayment(Request $request, $id)
    {
        $paymentRecord = PaymentRecord::find($id);
        $order = Order::find($paymentRecord->order_id);
        $paymentAccounts = PaymentAccount::all();

        return view('accounting.payments.showPayment', [
            'paymentRecord' => $paymentRecord,
            'paymentAccounts' => $paymentAccounts,
            'order' => $order,
        ]);
    }

    public function exportPDF(Request $request, $id)
    {
        $exportPdf = true;
        $paymentRecord = PaymentRecord::find($id); 
        $order = Order::find($paymentRecord->order_id); 
        $paymentAccounts = PaymentAccount::all();
        $view = view('accounting.payments.paymentPDF', [
            'paymentRecord' => $paymentRecord,
            'paymentAccounts' => $paymentAccounts,
            'order' => $order,
            'exportPdf' => $exportPdf
        ])->render();

        $options = new Options();
        
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set( 'isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($view);
        $dompdf->render();
        
        return $dompdf->stream("payment_receipt_$id.pdf");
    } 

    public function create(Request $request)
    {
        $orders = Order::all();
        $paymentAccounts = PaymentAccount::all();
        $paymentRecords = PaymentRecord::all();
        $paymentRecord = PaymentRecord::newDefault();
        $contactIds = $this->select2($request)['contact_ids'];

        return view('accounting.payments.create', [
            'orders' => $orders,
            'paymentAccounts' => $paymentAccounts,
            'paymentRecord' => $paymentRecord,
            'paymentRecords' => $paymentRecords,
            'contact_ids' => $contactIds,
        ]);
    }

    public function select2(Request $request)
    {
        $orders = Order::active()->get();
        $response = Order::select2($request, $orders);
        $contactIds = collect($response['results'])->pluck('id');
        
        return [
            'results' => $response['results'],
            'contact_ids' => $contactIds,
            'pagination' => $response['pagination'],
        ];
    }

    public function store(Request $request)
    {
        $paymentRecord = PaymentRecord::newDefault();
        $orders = Order::all();
        $paymentRecords = PaymentRecord::all();
        $errors = $paymentRecord->saveFromRequest($request);
        $paymentAccounts = PaymentAccount::all();

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payments.create', [
                'paymentAccounts'=> $paymentAccounts,
                'paymentRecords' => $paymentRecords,
                'orders' => $orders,
                'errors' => $errors,
            ], 400);
        }
        
        NewPaymentRecordCreated::dispatch($paymentRecord);
        
        return response()->json([
            // 'status' => 'success',
            'message' => 'Tạo phiếu thu thành công!'
        ]);
    }

    public function storeReceiptContact(Request $request, $id)
    {
        $paymentRecord = PaymentRecord::newDefault();
        $orders = Order::all();
        $order = Order::find($request->id);
        $paymentAccounts = PaymentAccount::all();
        $contact = Contact::find($id);
        $paymentRecord = PaymentRecord::newDefault();
        $errors = $paymentRecord->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payments.createReceiptContact', [
                'errors' => $errors,
                'contact' => $contact,
                'paymentAccounts'=> $paymentAccounts,
                'order' => Order::find($request->order_id),
                'orders' => $orders,
                '$id' =>$id
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo phiếu thu thành công!'
        ]);
    }
    
    public function createReceiptContact(Request $request)
    {
        $paymentRecord = $request->user()->account->newDefault();
        $paymentAccounts = PaymentAccount::all();
        $order = Order::find($request->id);
        $orders = Order::all();
        $schedulePayments = PaymentReminder::where('order_id', $order->id)
        ->get()
        ->sortBy('due_date');

        //
        return view('accounting.payments.createReceiptContact', [
            'paymentRecord' => $paymentRecord,
            'order' => $order,
            'orders' => $orders,
            'paymentAccounts' => $paymentAccounts,
            'schedulePayments' =>$schedulePayments
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $paymentRecord = PaymentRecord::find($id);
        $paymentRecord->deletedPaymentRecords();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa phiếu thu thành công!'
        ]);
    }

    public function paymentListPopup(Request $request, $id){
        $contact = PaymentAccount::find($id);
        $paymentRecords = PaymentRecord::where('payment_account_id', $contact->id)->get();
        
        return view('accounting.payments.payment-list-popup', [
            'paymentRecords' => $paymentRecords,
            'contact' => $contact,

        ]);
    }

    public function createReceipt(Request $request, $id)
    {
        $paymentRecord = $request->user()->account->newDefault();
        $paymentAccounts = PaymentAccount::all();
        $paymentReminder = PaymentReminder::find($id);

        $schedulePayments = PaymentReminder::where('order_id', $paymentReminder->order_id)
        ->get()
        ->sortBy('due_date');
    
        return view('accounting.payments.createReceipt', [
            'paymentRecord' => $paymentRecord,
            'paymentReminder' => $paymentReminder,
            'paymentAccounts' => $paymentAccounts,
            'schedulePayments' => $schedulePayments
            
        ]);
    }

    public function storeReceipt(Request $request, $id)
    {
        $paymentRecord = PaymentRecord::newDefault();
        $paymentAccounts = PaymentAccount::all();
        $paymentReminder = PaymentReminder::find($id);
        $errors = $paymentRecord->storeFromRequest($request);
        $schedulePayments = PaymentReminder::where('order_id', $paymentReminder->order_id);
        // $paymentReminder->paid();

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payments.createReceipt', [
                'errors' => $errors,
                'paymentReminder' => $paymentReminder,
                'schedulePayments' => $schedulePayments,
                'paymentAccounts' => $paymentAccounts,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo phiếu thu thành công!'
        ]);
    }

    public function getOrders(Request $request)
    {
        $orders = Order::where('contact_id', $request->contact_id)->approved()->get();
        $subjectData = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'status' => trans('messages.order.status.' . $order->status),
                'cache_total' =>$order->getTotal(),
                'paid_amount' =>$order->getPaidAmount(),
                
            ];
        });
        
        return response()->json($subjectData);
    }

    public function getPaymentAccount(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        $paymentAccounts = $order->salesperson->accountGroup ? $order->salesperson->accountGroup->paymentAccountEdu()->get() : collect([]);
        $result = [];

        if ($paymentAccounts && $paymentAccounts->count() > 0) {
            $firstPaymentAccount = $paymentAccounts->first(); 
            $result = [
                'id' => $firstPaymentAccount->id,
                'account_name' => $firstPaymentAccount->account_name,
                'account_number' => $firstPaymentAccount->account_number,
                'bank_name' => $firstPaymentAccount->bank,
            ];
        }

        return $result;
    }

    public function getProgressOrder(Request $request)
    {
        $schedulePayments = collect(); 
        $order = Order::find($request->order_id);
        if ($request->order_id) {
            $schedulePayments = PaymentReminder::where('order_id', $request->order_id)
                ->get()
                ->sortBy('due_date'); 
        }  
        
        return view('accounting.payments._progress_order_form', [
            'schedulePayments' => $schedulePayments,
            'order' => $order,
        ]);
    }
    public function approval(Request $request)
    {
        $paymentRecord = PaymentRecord::find($request->id);

        $paymentRecord->approval();

        
        // event
        ConfirmReceiptFromSale::dispatch($paymentRecord);

        return response()->json([
            'status' => 'success',
            'message' => 'Phiếu thu đã được yêu cầu duyệt thành công',
        ]);
    }
    public function reject(Request $request)
    {
        $paymentRecord = PaymentRecord::find($request->id);

        $paymentRecord->reject();

        // event 

        return response()->json([
            'status' => 'success',
            'message' => 'Phiếu thu đã được từ chối duyệt thành công',
        ]);
    }
}