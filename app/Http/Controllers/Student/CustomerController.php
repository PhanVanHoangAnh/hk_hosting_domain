<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\PaymentRecord;
use App\Models\Tag;
use App\Models\Order;
use App\Models\Account;
use App\Models\NoteLog;
use App\Models\ContactRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;

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


        return view('student.customers.index', [
            'accounts' => $accounts,
            'tags' => $tags,
            'status' => $request->status,
            'lead_status_menu' => $request->lead_status_menu,
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
                ['id' => 'code', 'title' => trans('messages.contact.code'), 'checked' => true],
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
                ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => true],
                // ['id' => 'lead_status', 'title' => trans('messages.contact.lead_status'), 'checked' => true],
                ['id' => 'pic', 'title' => trans('messages.contact.pic'), 'checked' => false],
                // ['id' => 'account_id', 'title' => trans('messages.contact.account_id'), 'checked' => true],
                ['id' => 'note_log', 'title' => trans('messages.contact.note_log'), 'checked' => true],
                // ['id' => 'deadline', 'title' => trans('messages.contact.deadline'), 'checked' => true],


            ],
            'lifecycle_stage_menu' => $request->lifecycle_stage_menu,
            'lead_status_name' => $lead_status_name,
            'lifecycle_stage_name' => $lifecycle_stage_name,
        ]);
    }

    public function list(Request $request)
    {
        // init
        $contacts = $request->user()->account->customers();
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

        return view('student.customers.list', [
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
        return view('student.customers.create', [
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
            return response()->view('student.customers.create', [
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
            return response()->view('student.customers.edit', [
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
        return view('student.customers.edit', [
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

        return view('student.customers.note-logs-list', [
            'notes' => $notes,
            'contact' => $contact,

        ]);
    }

    public function importHubspot(Request $request)
    {
        return view('student.customers.importHubspot');
    }

    public function importHubspotRun(Request $request)
    {
    }

    public function importExcel(Request $request)
    {
        return view('student.customers.importExcel');
    }

    public function importExcelShow(Request $request)
    {
        $datas = [];

        if ($request->file('file')) {
            $file = $request->file('file');
            $tempFilePath = $file->getRealPath();
            $datas = Contact::importFromExcel($tempFilePath);

            return view('student.customers.showExcelData', [
                'datas' => $datas
            ]);
        }

        return view('student.customers.importExcel', [
            'error' => 'Chưa có file dữ liệu!'
        ]);
    }

    public function importExcelRunning(Request $request)
    {
        $datas = json_decode($request->getContent(), true);
        $excelDatas = $datas['excelDatas'];
        $accountId = $datas['accountId'];
        $importStatus = Contact::saveExcelDatas($excelDatas, $accountId);

        return view('student.customers.importExcelDone', [
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
        return view('student.customers.importExcelDone');
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('student.customers.show', [
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
        return view('student.customers.education', [
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
        return view('student.customers.contract', [
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

        return view('student.customers.contract-list', [
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
        //

        return view('student.customers.payment-list', [
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
        //
        return view('student.customers.debt', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }
    public function studyAbroad(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('student.customers.study-abroad', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }
    public function extraActivity(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('student.customers.extra-activity', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }
    public function kidTech(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('student.customers.kid-tech', [
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

        //
        return view('student.customers.note-logs', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function updateHistory(Request $request, $id)
    {
        $contact = Contact::find($id);

        //
        return view('student.customers.update-history', [
            'contact' => $contact,
        ]);
    }

    public function addTags(Request $request)
    {
        $tags = Tag::all();
        return view('student.customers.add-tags', [
            'tags' => $tags,
        ]);
    }
  
    //Hiển thị Xoá nhiều tags 1 lần
    public function deleteTags(Request $request)
    {
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();

        return view('student.customers.deleteTags', [
            'contacts' => $contacts
        ]);
    }

    //Xóa tags nhiều customer
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

        //
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();

        return view('student.customers.addTagsBulk', [
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

        return view('student.customers.note-logs-popup', [
            'notes' => $notes,
            'contact' => $contact,

        ]);
    }

    public function addNoteLogContact(Request $request, $id)
    {
        $contact = Contact::find($id);
        return view('student.contacts.add-notelog-customer', [
            'contact' => $contact
        ]);
    }

    public function storeNoteLogContact(Request $request, $id)
    {
        $contact = Contact::find($id);
        $notelog = NoteLog::newDefault();
        $errors = $notelog->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.contacts.add-notelog-customer', [
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

        return view('student.customers.request-contact', [
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

        return view('student.customers.request-contact-list', [
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
}
