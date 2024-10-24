<?php

namespace App\Http\Controllers\Sales;

use App\Events\SingleContactRequestAssigned;
use App\Http\Controllers\Controller;
use App\Library\Permission;
use App\Models\Contact;
use App\Models\PaymentRecord;
use App\Models\Tag;
use App\Models\Order;
use App\Models\Account;
use App\Models\NoteLog;
use App\Models\ContactRequest;
use App\Models\CourseStudent;
use App\Models\StudentSection;
use App\Models\Section;
use App\Models\AbroadApplication;
use App\Library\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use App\Library\Module;

use Storage;
use function Laravel\Prompts\alert;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        $accounts = Account::all();
        $lead_status_name = Contact::getLeadStatusName($request->lead_status_menu);
        $lifecycle_stage_name = Contact::getLifecycleStageName($request->lifecycle_stage_menu);
        $listViewName = 'sales.customer';
        $columns = [
            ['id' => 'account_id', 'title' => trans('messages.contact.account_id'), 'checked' => true],
            ['id' => 'sale_sup', 'title' => trans('messages.order.sale_sup'), 'checked' => true],
            ['id' => 'student_code_old', 'title' => trans('messages.contact.student_code_old'), 'checked' => true],
            ['id' => 'code', 'title' => trans('messages.student.code'), 'checked' => true],
            ['id' => 'name', 'title' => trans('messages.student.name'), 'title' => trans('messages.student.name'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'demand', 'title' => trans('messages.contact.demand'), 'checked' => false],
            ['id' => 'school', 'title' => trans('messages.contact.school'), 'checked' => false],
            ['id' => 'father', 'title' => trans('messages.contact.father'), 'checked' => false],
            ['id' => 'mother', 'title' => trans('messages.contact.mother'), 'checked' => false],
            ['id' => 'birthday', 'title' => trans('messages.contact.birthday'), 'checked' => false],
            ['id' => 'age', 'title' => trans('messages.contact.age'), 'checked' => false],

            ['id' => 'time_to_call', 'title' => trans('messages.contact.time_to_call'), 'checked' => false],
            ['id' => 'country', 'title' => trans('messages.contact.country'), 'checked' => false],
            ['id' => 'city', 'title' => trans('messages.contact.city'), 'checked' => false],
            ['id' => 'district', 'title' => trans('messages.contact.district'), 'checked' => false],
            ['id' => 'ward', 'title' => trans('messages.contact.ward'), 'checked' => false],
            ['id' => 'address', 'title' => trans('messages.contact.address'), 'checked' => false],
            ['id' => 'efc', 'title' => trans('messages.contact.efc'), 'checked' => false],
            ['id' => 'list', 'title' => trans('messages.contact.list'), 'checked' => false],
            ['id' => 'target', 'title' => trans('messages.contact.target'), 'checked' => false],
            // ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => false],
            // ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => true],
            // ['id' => 'lead_status', 'title' => trans('messages.contact.lead_status'), 'checked' => true],
            ['id' => 'pic', 'title' => trans('messages.contact.pic'), 'checked' => false],
            // ['id' => 'account_id', 'title' => trans('messages.contact.account_id'), 'checked' => true],
            ['id' => 'note_log', 'title' => trans('messages.student.note_log'), 'checked' => true],
            ['id' => 'gender', 'title' => trans('messages.contact.gender'), 'checked' => true],
            ['id' => 'source_type', 'title' => trans('messages.student.source_type'), 'checked' => true],
            ['id' => 'order_type', 'title' => trans('messages.student.order_type'), 'checked' => true],
            ['id' => 'order_date', 'title' => trans('messages.order.order_date'), 'checked' => true],
            ['id' => 'note_log_father', 'title' => trans('messages.student.note_log_father'), 'checked' => true],
            ['id' => 'note_log_mother', 'title' => trans('messages.student.note_log_mother'), 'checked' => true],
            
            // ['id' => 'deadline', 'title' => trans('messages.contact.deadline'), 'checked' => true],
        ];
        
        //list view  name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('sales.customers.index', [
            'accounts' => $accounts,
            'tags' => $tags,
            'status' => $request->status,
            'lead_status_menu' => $request->lead_status_menu,
            'columns' => $columns,
            'lifecycle_stage_menu' => $request->lifecycle_stage_menu,
            'lead_status_name' => $lead_status_name,
            'lifecycle_stage_name' => $lifecycle_stage_name,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        // init
        if ($request->user()->can('changeBranch', Branch::class)) {
            $contacts = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isStudent();
        } 
        // elseif ($request->user()->can('manager', \App\Models\User::class))  {
        //     $accountIds = $request->user()->account->accountGroup->getAllAccountAndManagerIds();
        //     $contacts = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isCustomer()->where(function ($q) use ($accountIds) {
        //         $q->whereIn('account_id', $accountIds)
        //             ->orWhereHas('contactRequests', function ($q) use ($accountIds) {
        //                 $q->whereIn('account_id', $accountIds);
        //             });
        //     });
        // }
        // elseif ($request->user()->can('mentor', \App\Models\User::class))  {
        //     $accountIds = $request->user()->mentees()->pluck('id'); 
        //     $contacts = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isCustomer()->where(function ($q) use ($accountIds) {
        //         $q->whereIn('account_id', $accountIds)
        //             ->orWhereHas('contactRequests', function ($q) use ($accountIds) {
        //                 $q->whereIn('account_id', $accountIds);
        //             });
        //     });
        // }
        else{
            $contacts = $request->user()->account->onlyContactsHasOrder();
        }
      
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();

        // filter deleted ones
        if ($request->status && $request->status == Contact::STATUS_DELETED) {
            $contacts = $contacts->deleted();
        } else {
            $contacts = $contacts->active();
        }

        // keyword
        if ($request->keyword) {
            $contacts = $contacts->search($request->keyword);
        }

        // filter by source_type
        if ($request->has('source_type')) {
            $contacts = $contacts->filterByMarketingType($request->input('source_type'));
        }
        // filter by channel
        if ($request->has('channel')) {
            $contacts = $contacts->filterByMarketingSource($request->input('channel'));
        }
        // filter by sub_channel
        if ($request->has('sub_channel')) {
            $contacts = $contacts->filterByMarketingSourceSub($request->input('sub_channel'));
        }
        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $contacts = $contacts->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $contacts = $contacts->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }
        // filter by lifecycle_stage
        if ($request->has('lifecycle_stage')) {
            $contacts = $contacts->filterByLifecycleStage($request->input('lifecycle_stage'));
        }
        // filter by lead_status
        if ($request->has('lead_status')) {
            $contacts = $contacts->filterByLeadStatus($request->input('lead_status'));
        }
        // filter by sales_person
        if ($request->has('salesperson_ids')) {
            $contacts = $contacts->filterBySalespersonIds($request->input('salesperson_ids'));
        }

        // filter by status
        if ($request->has('status')) {
            if ($request->status == 'is_assigned') {
                $contacts = $contacts->isAssigned();
            } else if ($request->status == 'is_new') {
                $contacts = $contacts->isNew();
            } else if ($request->status == 'no_action_yet') {
                $contacts = $contacts->noActionYet();
            } else if ($request->status == 'has_action') {
                $contacts = $contacts->hasAction();
            } else if ($request->status == 'outdated') {
                $contacts = $contacts->outdated();
            }
        }

        // filter lead status menu
        if ($request->has('lead_status_menu')) {
            $contacts = Contact::getLeadStatusMenu($contacts, $request->lead_status_menu);
        }

        // filter lifecycle stage menu
        if ($request->has('lifecycle_stage_menu')) {
            $contacts = Contact::getLifecycleStageMenu($contacts, $request->lifecycle_stage_menu);
        }

        // sort
        $contacts = $contacts->orderBy($sortColumn, $sortDirection);
        // pagination
        $contacts = $contacts->paginate($request->per_page ?? '20');

        return view('sales.customers.list', [
            'contacts' => $contacts,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        // init
        $contact = Contact::newDefault();
        $tags = Tag::all();
        $accounts = Account::all();
        //
        return view('sales.customers.create', [
            'contact' => $contact,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function store(Request $request)
    {
        // init
        $contact = Contact::newDefault();
        $tags = Tag::all();
        $accounts = Account::all();

        // validate
        $errors = $contact->saveFromRequest($request);

        // error
        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.create', [
                'contact' => $contact,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        // assign if success
        $contact->assignToAccount($request->user()->account);

        // success
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm khách hàng thành công',
        ]);
    }
    public function update(Request $request, $id)
    {
        // init
        $contact = Contact::find($id);
        $tags = Tag::all();
        $accounts = Account::all();
        // validate
        $errors = $contact->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.edit', [
                'contact' => $contact,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        // Lưu khách hàng vào cơ sở dữ liệu
        $contact->save();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật khách hàng thành công',
        ]);
    }
    public function edit(Request $request, $id)
    {
        // init
        $contact = Contact::find($id);
        $tags = Tag::all();
        $accounts = Account::all();

        // 
        return view('sales.customers.edit', [
            'contact' => $contact,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // init
        $contact = Contact::find($id);

        // delete
        $contact->deleteContact();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa khách hàng thành công',
        ]);
    }
    public function noteLogList(Request $request, $id)
    {
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);

        if ($request->key) {
            $query = $query->search($request->key);
        }

        // filter by contact id
        if ($request->customer_ids) {
            $query = $query->filterByContactIds($request->customer_ids);
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

        // filter by account id
        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }

        // sort
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);

        // pagination
        $notes = $query->paginate($request->perpage ?? 5);

        return view('sales.customers.note-logs-list', [
            'notes' => $notes,
            'contact' => $contact,

        ]);
    }

    public function importHubspot(Request $request)
    {
        return view('sales.customers.importHubspot');
    }

    public function importHubspotRun(Request $request)
    {
    }

    public function importExcel(Request $request)
    {
        return view('sales.customers.importExcel');
    }

    public function importExcelShow(Request $request)
    {
        $datas = [];

        if ($request->file('file')) {
            $file = $request->file('file');
            $tempFilePath = $file->getRealPath();
            $datas = Contact::importFromExcel($tempFilePath);

            return view('sales.customers.showExcelData', [
                'datas' => $datas
            ]);
        }

        return view('sales.customers.importExcel', [
            'error' => 'Chưa có file dữ liệu!'
        ]);
    }

    public function importExcelRunning(Request $request)
    {
        $datas = json_decode($request->getContent(), true);
        $excelDatas = $datas['excelDatas'];
        $accountId = $datas['accountId'];
        $importStatus = Contact::saveExcelDatas($excelDatas, $accountId);

        return view('sales.customers.importExcelDone', [
            "status" => $importStatus
        ]);
    }

    public function downloadLog()
    {
        $logFileName = 'contact_logs.txt';
        $logContent = Storage::disk('logs')->get($logFileName);

        // Create an response object contain log content & header
        $response = new Response($logContent);

        // Config header 
        $response->header('Content-Type', 'text/plain');
        $response->header('Content-Disposition', 'attachment; filename=' . $logFileName);

        return $response;
    }

    public function testImportDone(Request $request)
    {
        return view('sales.customers.importExcelDone');
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('sales.customers.show', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function importExcelSuccess(Request $request)
    {
    }

    public function education(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();

        //
        return view('sales.customers.education', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function contract(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $orders = Order::where('contact_id', $contact->id);

        if (isset($request->screenType) && $request->screenType == Order::TYPE_GENERAL) {
            $orders->getGeneral();
        } else {
            $orders->getRequestDemo();
        }


        //
        return view('sales.customers.contract', [
            'contact' => $contact,
            'accounts' => $accounts,
            'screenType' => $request->screenType ? $request->screenType : Order::TYPE_GENERAL
        ]);
    }

    public function contractList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $orders = Order::where('contact_id', $contact->id);

        if ($request->keyword) {
            $orders = $orders->search($request->keyword);
        }

        $orders->orderBy($sortColumn, $sortDirection);
        $orders = $orders->paginate($request->per_page ?? '20');
        //

        return view('sales.customers.contract-list', [
            'contact' => $contact,
            'accounts' => $accounts,
            'orders' => $orders,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function paymentList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $sortColumn = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $payments = PaymentRecord::where('contact_id', $contact->id);

        if ($request->keyword) {
            $payments = $payments->search($request->keyword);
        }

        $payments->orderBy($sortColumn, $sortDirection);

        $payments = $payments->paginate($request->per_page ?? '20');

        return view('sales.customers.payment-list', [
            'contact' => $contact,
            'accounts' => $accounts,
            'payments' => $payments,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function debt(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();

        return view('sales.customers.debt', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function studyAbroad(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
      
        if ($contact) {
            $abroadApplication = $contact->abroadApplications()->first();
        } else {
            $abroadApplication = null;
        }
        return view('sales.customers.study-abroad', [
            'contact' => $contact,
            'accounts' => $accounts,
            'abroadApplication'=>$abroadApplication
        ]);
    }

    public function extraActivity(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        if ($contact) {
            $abroadApplication = $contact->abroadApplications()->first();
        } else {
            $abroadApplication = null;
        }
        return view('sales.customers.extra-activity', [
            'contact' => $contact,
            'accounts' => $accounts,
            'abroadApplication'=>$abroadApplication
        ]);
    }

    public function kidTech(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();

        return view('sales.customers.kid-tech', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function noteLog(Request $request, $id)
    {
        $accounts = Account::sales()->get();
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);

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

        if ($request->key) {
            $query = $query->search($request->key);
        }

        // filter by contact id
        if ($request->customer_ids) {
            $query = $query->filterByContactIds($request->customer_ids);
        }

        // filter by contact id
        if ($request->contact_ids) {
            $query = $query->filterByContactIds($request->contact_ids);
        }

        // filter by account id
        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }

        // sort
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);

        // pagination
        $notes = $query->paginate($request->perpage ?? 5);

        return view('sales.customers.note-logs', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function updateHistory(Request $request, $id)
    {
        $contact = Contact::find($id);

        return view('sales.customers.update-history', [
            'contact' => $contact,
        ]);
    }

    public function addTags(Request $request)
    {
        $tags = Tag::all();

        return view('sales.customers.add-tags', [
            'tags' => $tags,
        ]);
    }
  
    // Hiển thị Xoá nhiều tags 1 lần
    public function deleteTags(Request $request)
    {
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();

        return view('sales.customers.deleteTags', [
            'contacts' => $contacts
        ]);
    }

    // Xóa tags nhiều customer
    public function actionDeleteTags(Request $request)
    {
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();
        $tags = Tag::whereIn('id', $request->tag_ids)->get();

        // 
        foreach ($contacts as $contact) {
            $contact->removeTags();
        }

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa thành công các tags của khách hàng đã chọn',
        ]);
    }

    //Edit nhiều tags một lần
    public function addTagsBulk(Request $request)
    {
        $tags = Tag::all();
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();

        return view('sales.customers.addTagsBulk', [
            'tags' => $tags,
            'contacts' => $contacts
        ]);
    }

    // add tag cho nhiều customer
    public function addTagsBulkSave(Request $request)
    {
        $contacts = Contact::whereIn('id', $request->contact_id)->get();
        $selectedTags = $request->input('tags');

        // Kiểm tra xem có tags được chọn không
        foreach ($contacts as $contact) {
            $contact->tags()->sync($selectedTags);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm tags thành công cho các khách hàng',
        ]);
    }

    public function select2(Request $request)
    {
        // init
        $contacts = $request->user()->account->customers();

        // keyword
        if ($request->q) {
            $contacts = $contacts->search($request->q);
        }

        // pagination
        $contacts = $contacts->paginate($request->per_page ?? '2');

        return response()->json([
            "results" => [
                [
                    "id" => 1,
                    "text" => "Option 1",
                ],
                [
                    "id" => 2,
                    "text" => "Option 2",
                ]
            ],
            "pagination" => [
                "more" => $contacts->lastPage() != $request->page,
            ]
        ]);
    }

    public function save(Request $request, $id)
    {
        $user = $request->user();
        $contact = Contact::find($id);
        $account = Account::find($request->salesperson_id);

        // salesperson id
        if ($request->salesperson_id) {
            if ($request->salesperson_id == 'unassign') {
                $contact->account_id = null;
            } else {
                $contact->assignToAccount($account);

                // event
                SingleContactRequestAssigned::dispatch($account, $contact, $user);
            }

            $contact->save();
        }

        //email
        if ($request->has('email')) {
            $contact->email = $request->email;
            $contact->save();
        }

        //phone
        if ($request->has('phone')) {
            $contact->phone = \App\Library\Tool::extractPhoneNumber($request->phone);
            $contact->save();
        }

        //lead_status
        if ($request->lead_status) {
            $contact->lead_status = $request->lead_status;
            $contact->save();
        }

        return response()->json([
            'status' => 'success',
            'salepersone_name' => $contact->account ? $contact->account->name : '<span class="text-gray-500">Chưa bàn giao</span>',
            'email' => $contact->email ? $contact->email : '<span class="text-gray-500">Chưa có email</span>',
            'phone' => $contact->phone ? $contact->phone : '<span class="text-gray-500">Chưa có số điện thoại</span>',
            'lead_status' => $contact->lead_status,
        ]);
    }

    public function noteLogsPopup(Request $request, $id)
    {
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);

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

        $notes = $query->orderBy('updated_at', 'desc')->get();

        return view('sales.customers.note-logs-popup', [
            'notes' => $notes,
            'contact' => $contact,
        ]);
    }

    public function addNoteLogContact(Request $request, $id)
    {
        $contact = Contact::find($id);

        return view('sales.contacts.add-notelog-customer', [
            'contact' => $contact
        ]);
    }

    public function storeNoteLogContact(Request $request, $id)
    {
        $contact = Contact::find($id);
        $notelog = NoteLog::newDefault();
        $errors = $notelog->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.contacts.add-notelog-customer', [
                'errors' => $errors,
                'contact' => $contact
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới ghi chú thành công!'
        ]);
    }

    public function requestContact(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $contactRequests = ContactRequest::where('contact_id', $contact->id)->get();

        return view('sales.customers.request-contact', [
            'contact' => $contact,
            'accounts' => $accounts,
            'customerRequests' => $contactRequests,
        ]);
    }

    public function requestContactList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $contactRequestsQuery = ContactRequest::select('contact_requests.*')
            ->join('contacts', 'contacts.id', '=', 'contact_requests.contact_id')->where('contact_id', $contact->id);

        // keyword
        if ($request->keyword) {
            $contactRequestsQuery = $contactRequestsQuery->search($request->keyword);
        }
        
        // Apply orderBy based on your logic
        $contactRequestsQuery->orderBy($sortColumn, $sortDirection);

        // Get the paginated results
        $contactRequests = $contactRequestsQuery->paginate($request->per_page ?? '20');

        return view('sales.customers.request-contact-list', [
            'contact' => $contact,
            'accounts' => $accounts,
            'contactRequests' => $contactRequests,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->contacts)) {
            Contact::deleteAll($request->contacts);

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

    public function calendar(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)->get();
        $sectionStudents = StudentSection::where('student_id', $contact->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds)->whereHas('course', function ($query) {
            $query->where('module', Module::EDU);
        })->get();
        $accounts = Account::all();
        $sectionsWithStatus = $sections->map(function ($section) use ($contact) {
            $status = $contact->getStudentSectionStatus($section);

            return array_merge($section->toArray(), [
                'status' => $status,
                'viewer' => 'student'
            ]);
        });

        $freeTimeSections = $contact->getFreeTimeSections();
        $eventSections = array_merge($sectionsWithStatus->toArray(), $freeTimeSections);

        return view('sales.customers.calendar', [
            'contact' => $contact,
            'courseStudents' => $courseStudents,
            'sections' => $eventSections,
            'orderItems' => $orderItems,
            'accounts' => $accounts
        ]);
    }

    public function section(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)->whereHas('course', function ($query) {
            $query->where('module', Module::EDU);
        })->get();
        $accounts = Account::all();

        return view('sales.customers.section', [
            'contact' => $contact,
            'orderItems' => $orderItems,
            'courseStudents' => $courseStudents,
            'accounts' => $accounts
        ]);
    }

    public function showFreeTimeSchedule(Request $request)
    {
        $student = Contact::find($request->id);
        $orderItems = $student->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $request->id)->get();
        $accounts = Account::all();

        return view('sales.customers.busySchedule', [
            'student' => $student,
            'contact' => $student,
            'orderItems' => $orderItems,
            'courseStudents' => $courseStudents,
            'accounts' => $accounts
        ]);
    }

    public function sectionList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $sectionStudents = StudentSection::where('student_id', $contact->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds)
        ->whereHas('course', function ($query) {
            $query->where('module', Module::EDU);
        });
        $accounts = Account::all();

        if ($request->keyword) {
            $sections = $sections->search($request->keyword);
        }
        if ($request->teachers) {
            $sections = $sections->filterByTeachers($request->teachers);
        }

        if ($request->subjects) {
            $sections = $sections->filterBySubjects($request->subjects);
        }

        if ($request->has('types')) {
            $sections = $sections->filterByTypes($request->types);
        }

        if ($request->has('study_date_from') && $request->has('study_date_to')) {
            $study_date_from = $request->input('study_date_from');
            $study_date_to = $request->input('study_date_to');
            $sections = $sections->filterByStudyDate($study_date_from, $study_date_to);
        }

        $sortColumn = $request->sort_by ?? 'study_date';
        $sortDirection = $request->sort_direction ?? 'asc';
        $sections = $sections->orderBy($sortColumn, $sortDirection);

        if ($sortColumn == 'code') {
            $sections->leftJoin('courses', 'sections.course_id', '=', 'courses.id')
                ->orderBy("courses.code", $sortDirection)
                ->select('sections.*');;
        }
        // pagination
        $sections = $sections->paginate($request->per_page ?? '20');

        return view('sales.customers.sectionList', [
            'contact' => $contact,
            'sections' => $sections,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'num' => $sections->count(),
            'accounts' => $accounts
        ]);
    }

    public function class(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)->whereHas('course', function ($query) {
            $query->where('module', Module::EDU);
        })->get();

        return view('sales.customers.class', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'orderItems' => $orderItems,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'duration_each_lesson', 'title' => trans('messages.courses.duration_each_lesson'), 'checked' => true],
                ['id' => 'max_students', 'title' => trans('messages.courses.max_students'), 'checked' => true],
                ['id' => 'joined_students', 'title' => trans('messages.courses.joined_students'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }
    public function classList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $query = CourseStudent::where('student_id', $id) ->whereHas('course', function ($query) {
            $query->where('module', Module::EDU);
        })->leftJoin('courses', 'course_student.course_id', '=', 'courses.id');

        if ($request->keyword) {
            $query = $query->search($request->keyword);
        }

        if ($request->teachers) {
            $query = $query->filterByTeachers($request->teachers);
        }

        if ($request->subjects) {
            $query = $query->filterBySubjects($request->subjects);
        }

        if ($request->has('start_at_from') && $request->has('start_at_to')) {
            $start_at_from = $request->input('start_at_from');
            $start_at_to = $request->input('start_at_to');
            $query = $query->filterByStartAt($start_at_from, $start_at_to);
        }

        if ($request->has('end_at_from') && $request->has('end_at_to')) {
            $end_at_from = $request->input('end_at_from');
            $end_at_to = $request->input('end_at_to');
            $query = $query->filterByEndAt($end_at_from, $end_at_to);
        }

        $sortColumn = $request->sort_by ?? 'start_at';
        $sortDirection = $request->sort_direction ?? 'asc';

        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $courseStudents = $query->paginate($request->per_page ?? '20');
        //
        return view('sales.customers.classList', [
            'courseStudents' => $courseStudents,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function export(Request $request)
    {
        $templatePath = public_path('templates/customers.xlsx');
        $filterCustomers = $this->filterCustomer($request);
        $templateSpreadsheet = IOFactory::load($templatePath);
    
        Contact::exportCustomer($templateSpreadsheet, $filterCustomers);
    
        // Output path
        $storagePath = storage_path('app/exports');
    
        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }
    
        $outputFileName = 'customers.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
    
        $writer->save($outputFilePath);

        if (!file_exists($outputFilePath)) {
            return response()->json(['error' => 'Failed to save the file.'], 500);
        }
    
        return response()->download($outputFilePath, $outputFileName);
    }

    public function filterCustomer(Request $request)
    {
        // init
        if ($request->user()->hasPermission(Permission::SALES_DASHBOARD_ALL)) {
            $contacts = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isCustomer();
        } 
        else{
            $contacts = $request->user()->account->onlyContactsHasOrder();
        }
      
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();

        // filter deleted ones
        if ($request->status && $request->status == Contact::STATUS_DELETED) {
            $contacts = $contacts->deleted();
        } else {
            $contacts = $contacts->active();
        }

        // keyword
        if ($request->keyword) {
            $contacts = $contacts->search($request->keyword);
        }

        // filter by source_type
        if ($request->has('source_type')) {
            $contacts = $contacts->filterByMarketingType($request->input('source_type'));
        }
        // filter by channel
        if ($request->has('channel')) {
            $contacts = $contacts->filterByMarketingSource($request->input('channel'));
        }
        // filter by sub_channel
        if ($request->has('sub_channel')) {
            $contacts = $contacts->filterByMarketingSourceSub($request->input('sub_channel'));
        }
        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $contacts = $contacts->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $contacts = $contacts->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }
        // filter by lifecycle_stage
        if ($request->has('lifecycle_stage')) {
            $contacts = $contacts->filterByLifecycleStage($request->input('lifecycle_stage'));
        }
        // filter by lead_status
        if ($request->has('lead_status')) {
            $contacts = $contacts->filterByLeadStatus($request->input('lead_status'));
        }
        // filter by sales_person
        if ($request->has('salesperson_ids')) {
            $contacts = $contacts->filterBySalespersonIds($request->input('salesperson_ids'));
        }

        // filter by status
        if ($request->has('status')) {
            if ($request->status == 'is_assigned') {
                $contacts = $contacts->isAssigned();
            } else if ($request->status == 'is_new') {
                $contacts = $contacts->isNew();
            } else if ($request->status == 'no_action_yet') {
                $contacts = $contacts->noActionYet();
            } else if ($request->status == 'has_action') {
                $contacts = $contacts->hasAction();
            } else if ($request->status == 'outdated') {
                $contacts = $contacts->outdated();
            }
        }

        // filter lead status menu
        if ($request->has('lead_status_menu')) {
            $contacts = Contact::getLeadStatusMenu($contacts, $request->lead_status_menu);
        }

        // filter lifecycle stage menu
        if ($request->has('lifecycle_stage_menu')) {
            $contacts = Contact::getLifecycleStageMenu($contacts, $request->lifecycle_stage_menu);
        }

        // sort
        $contacts = $contacts->orderBy($sortColumn, $sortDirection);

        return $contacts->get();
    }
}
