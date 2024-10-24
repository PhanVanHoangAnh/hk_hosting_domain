<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactRequest;
use App\Models\Tag;
use App\Models\Account;
use App\Models\NoteLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use App\Events\ContactRequestsAssigned;
use App\Events\SingleContactRequestAssigned;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Storage;
use function Laravel\Prompts\alert;

class ContactRequestController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        $accounts = Account::all();
        $lead_status_name = ContactRequest::getLeadStatusName($request->lead_status_menu);
        $lifecycle_stage_name = ContactRequest::getLifecycleStageName($request->lifecycle_stage_menu);

        // List view & Columns
        $listViewName = 'student.contact_requests';
        $columns = [
            ['id' => 'code', 'title' => trans('messages.contact_request.code'), 'checked' => false],
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'demand', 'title' => trans('messages.contact.demand'), 'checked' => true],
            ['id' => 'deadline', 'title' => trans('messages.contact.deadline'), 'checked' => in_array($request->status, ['no_action_yet', 'outdated'])],
            // ['id' => 'order', 'title' => trans('messages.contact.order'), 'checked' => true],
            ['id' => 'lead_status', 'title' => trans('messages.contact.lead_status'), 'checked' => true],
            ['id' => 'account_id', 'title' => trans('messages.contact.account_id'), 'checked' => false],
            ['id' => 'note_log', 'title' => trans('messages.contact.note_log'), 'checked' => true],
            ['id' => 'school', 'title' => trans('messages.contact.school'), 'checked' => false],
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
            // ['id' => 'source_type', 'title' => trans('messages.contact.source_type'), 'checked' => false],
            // ['id' => 'channel', 'title' => trans('messages.contact.channel'), 'checked' => false],
            // ['id' => 'sub_channel', 'title' => trans('messages.contact.sub_channel'), 'checked' => false],
            // ['id' => 'campaign', 'title' => trans('messages.contact.campaign'), 'checked' => false],
            // ['id' => 'adset', 'title' => trans('messages.contact.adset'), 'checked' => false],
            // ['id' => 'ads', 'title' => trans('messages.contact.ads'), 'checked' => false],
            // ['id' => 'device', 'title' => trans('messages.contact.device'), 'checked' => false],
            // ['id' => 'placement', 'title' => trans('messages.contact.placement'), 'checked' => false],
            // ['id' => 'term', 'title' => trans('messages.contact.term'), 'checked' => false],
            // ['id' => 'type_match', 'title' => trans('messages.contact.type_match'), 'checked' => false],
            // ['id' => 'gclid', 'title' => trans('messages.contact.gclid'), 'checked' => false],
            // ['id' => 'fbcid', 'title' => trans('messages.contact.fbcid'), 'checked' => false],
            // ['id' => 'first_url', 'title' => trans('messages.contact.first_url'), 'checked' => false],
            // ['id' => 'last_url', 'title' => trans('messages.contact.last_url'), 'checked' => false],
            // ['id' => 'contact_owner', 'title' => trans('messages.contact.contact_owner'), 'checked' => false],
            // ['id' => 'lifecycle_stage', 'title' => trans('messages.contact.lifecycle_stage'), 'checked' => false],
            // ['id' => 'pic', 'title' => trans('messages.contact.pic'), 'checked' => false],
        ];

        // list view name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('student.contact_requests.index', [
            'accounts' => $accounts,
            'tags' => $tags,
            'status' => $request->status,
            'lead_status_menu' => $request->lead_status_menu,
            'listViewName' => $listViewName,
            'columns' => $columns,
            'lifecycle_stage_menu' => $request->lifecycle_stage_menu,
            'lead_status_name' => $lead_status_name,
            'lifecycle_stage_name' => $lifecycle_stage_name,
        ]);
    }

    public function list(Request $request)
    {
        // init
        $contactRequests = $request->user()->account->contactRequests()
            ->select('contact_requests.*')
            ->join('contacts', 'contacts.id', '=', 'contact_requests.contact_id');
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();
        // $accounts = Account::all();
        $accounts = Account::sales()->get();

        // filter deleted ones
        if ($request->status && $request->status == ContactRequest::STATUS_DELETED) {
            $contactRequests = $contactRequests->deleted();
        } else {
            $contactRequests = $contactRequests->active();
        }

        // keyword
        if ($request->keyword) {
            $contactRequests = $contactRequests->search($request->keyword);
        }

        // filter by source_type
        if ($request->has('source_type')) {
            $contactRequests = $contactRequests->filterByMarketingType($request->input('source_type'));
        }
        // filter by channel
        if ($request->has('channel')) {
            $contactRequests = $contactRequests->filterByMarketingSource($request->input('channel'));
        }
        // filter by sub_channel
        if ($request->has('sub_channel')) {
            $contactRequests = $contactRequests->filterByMarketingSourceSub($request->input('sub_channel'));
        }
        // filter by lifecycle_stage
        if ($request->has('lifecycle_stage')) {
            $contactRequests = $contactRequests->filterByLifecycleStage($request->input('lifecycle_stage'));
        }
        // filter by lead_status
        if ($request->has('lead_status')) {
            $contactRequests = $contactRequests->filterByLeadStatus($request->input('lead_status'));
        }
        // filter by sales_person
        if ($request->has('salesperson_ids')) {
            $contactRequests = $contactRequests->filterBySalespersonIds($request->input('salesperson_ids'));
        }
        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $contactRequests = $contactRequests->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $contactRequests = $contactRequests->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // filter by status
        if ($request->has('status')) {
            if ($request->status == 'is_assigned') {
                $contactRequests = $contactRequests->isAssigned();
            } else if ($request->status == 'is_new') {
                $contactRequests = $contactRequests->isNew();
            } else if ($request->status == 'no_action_yet') {
                $contactRequests = $contactRequests->noActionYet();
            } else if ($request->status == 'has_action') {
                $contactRequests = $contactRequests->hasAction();
            } else if ($request->status == 'outdated') {
                $contactRequests = $contactRequests->outdated();
            }
        }

        // filter lead status menu
        if ($request->has('lead_status_menu')) {
            $contactRequests = ContactRequest::getLeadStatusMenu($contactRequests, $request->lead_status_menu);
        }

        // filter lifecycle stage menu
        if ($request->has('lifecycle_stage_menu')) {
            $contactRequests = ContactRequest::getLifecycleStageMenu($contactRequests, $request->lifecycle_stage_menu);
        }

        // sort
        $contactRequests = $contactRequests->orderBy($sortColumn, $sortDirection);

        // pagination
        $contactRequests = $contactRequests->paginate($request->per_page ?? '20');

        return view('student.contact_requests.list', [
            'contactRequests' => $contactRequests,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'accounts' => $accounts,
        ]);
    }

    public function create(Request $request)
    {
        // init
        $contactRequest = ContactRequest::newDefault();
        $tags = Tag::all();
        $accounts = Account::all();

        if ($request->contact_id) {
            $contactRequest->contact_id = $request->contact_id;
        }

        //
        return view('student.contact_requests.create', [
            'contactRequest' => $contactRequest,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function store(Request $request)
    {
        $account = $request->user()->account;

        if ($request->contact_id) {
            $contact = Contact::find($request->contact_id);
        } else {
            $contact = $account->newContact();
        }
        $contactRequest = $contact->newContactRequest();
        $tags = Tag::all();
        $accounts = Account::all();

        // validate
        list($contactRequest, $errors) = $contact->saveAndAddContactRequestFromRequest($request);

        // error
        if (!$errors->isEmpty()) {
            return response()->view('marketing.contact_requests.create', [
                'contactRequest' => $contactRequest,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        // assign
        $contactRequest->assignToAccount($account);

        // event
        SingleContactRequestAssigned::dispatch($account, $contactRequest, $request->user());

        // success
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm đơn hàng thành công',
        ]);
    }

    public function update(Request $request, $id)
    {
        // init
        $contactRequest = ContactRequest::find($id);
        $tags = Tag::all();
        $accounts = Account::all();
        // validate
        $errors = $contactRequest->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.contact_requests.edit', [
                'contactRequest' => $contactRequest,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        // Lưu đơn hàng vào cơ sở dữ liệu
        $contactRequest->save();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật đơn hàng thành công',
        ]);
    }
    public function edit(Request $request, $id)
    {
        // init
        $contactRequest = ContactRequest::find($id);
        $tags = Tag::all();
        $accounts = Account::all();

        // 
        return view('student.contact_requests.edit', [
            'contactRequest' => $contactRequest,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // init
        $contactRequest = ContactRequest::find($id);

        // delete
        $contactRequest->deleteContactRequest();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa đơn hàng thành công',
        ]);
    }
    public function noteLogList(Request $request, $id)
    {
        $query = NoteLog::where('contact_request_id', $id);
        $contactRequest = ContactRequest::find($id);

        if ($request->key) {
            $query = $query->search($request->key);
        }

        // filter by contact id
        if ($request->contact_request_ids) {
            $query = $query->filterByContactRequestIds($request->contact_request_ids);
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

        return view('student.contact_requests.note-logs-list', [
            'notes' => $notes,
            'contactRequest' => $contactRequest,

        ]);
    }

    public function importHubspot(Request $request)
    {
        return view('student.contact_requests.importHubspot');
    }

    public function importHubspotRun(Request $request)
    {
    }

    public function importExcel(Request $request)
    {
        return view('student.contact_requests.importExcel');
    }

    public function importExcelShow(Request $request)
    {
        $datas = [];

        if ($request->file('file')) {
            $file = $request->file('file');
            $tempFilePath = $file->getRealPath();
            $datas = ContactRequest::importFromExcel($tempFilePath);

            return view('student.contact_requests.showExcelData', [
                'datas' => $datas
            ]);
        }

        return view('student.contact_requests.importExcel', [
            'error' => 'Chưa có file dữ liệu!'
        ]);
    }

    public function importExcelRunning(Request $request)
    {
        $datas = json_decode($request->getContent(), true);
        $excelDatas = $datas['excelDatas'];
        $accountId = $datas['accountId'];
        $importStatus = ContactRequest::saveExcelDatas($excelDatas, $accountId);

        return view('student.contact_requests.importExcelDone', [
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
        return view('student.contact_requests.importExcelDone');
    }

    public function show(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);
        $accounts = Account::sales()->get();
        //
        return view('student.contact_requests.show', [
            'contactRequest' => $contactRequest,
            'accounts' => $accounts,
        ]);
    }

    public function importExcelSuccess(Request $request)
    {
    }

    public function education(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.education', [
            'contactRequest' => $contactRequest,
        ]);
    }

    public function contract(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.contract', [
            'contactRequest' => $contactRequest,
        ]);
    }
    public function debt(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.debt', [
            'contactRequest' => $contactRequest,
        ]);
    }
    public function studyAbroad(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.study-abroad', [
            'contactRequest' => $contactRequest,
        ]);
    }
    public function extraActivity(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.extra-activity', [
            'contactRequest' => $contactRequest,
        ]);
    }
    public function kidTech(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.kid-tech', [
            'contactRequest' => $contactRequest,
        ]);
    }

    public function updateHistory(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);

        //
        return view('student.contact_requests.update-history', [
            'contactRequest' => $contactRequest,
        ]);
    }
    public function addTags(Request $request)
    {
        $tags = Tag::all();
        return view('student.contact_requests.add-tags', [
            'tags' => $tags,
        ]);
    }

    //Hiển thị Xoá nhiều tags 1 lần
    public function deleteTags(Request $request)
    {
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_ids)->get();
        // $contactRequests = ContactRequest::limit(5)->get();
        return view('student.contact_requests.deleteTags', [
            'contactRequests' => $contactRequests
        ]);
    }

    //Xóa tags nhiều contact
    public function actionDeleteTags(Request $request)
    {
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_ids)->get();
        $tags = Tag::whereIn('id', $request->tag_ids)->get();

        // 
        foreach ($contactRequests as $contactRequest) {
            $contactRequest->removeTags();
        }

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa thành công các tags của đơn hàng đã chọn',
        ]);
    }
    //Edit nhiều tags một lần
    public function addTagsBulk(Request $request)
    {
        $tags = Tag::all();

        //
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_ids)->get();

        return view('student.contact_requests.addTagsBulk', [
            'tags' => $tags,
            'contactRequests' => $contactRequests
        ]);
    }
    // add tag cho nhiều contact
    public function addTagsBulkSave(Request $request)
    {

        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_id)->get();
        $selectedTags = $request->input('tags');

        // Kiểm tra xem có tags được chọn không

        foreach ($contactRequests as $contactRequest) {
            $contactRequest->tags()->sync($selectedTags);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm tags thành công cho các đơn hàng',
        ]);
    }

    // handover một tài khoản
    public function addHandover(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);
        $accounts = Account::sales()->get();
        return view('student.contact_requests.handover', [
            'contactRequest' => $contactRequest,
            'accounts' => $accounts,
        ]);
    }
    //Cập nhật bàn giao một tài khoản
    public function saveHandover(Request $request, $id)
    {
        $user = $request->user();
        $contactRequest = ContactRequest::find($id);
        $account = Account::find($request->input('accounts'));

        if (!$account) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Không tìm thấy tài khoàn' . $request->input('accounts'),
            ], 400);
        }

        // assign
        $contactRequest->assignToAccount($account);

        // event
        SingleContactRequestAssigned::dispatch($account, $contactRequest, $user);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã bàn giao đơn hàng thành công',
        ]);
    }
    //Chỉnh sửa cập nhật bàn giao nhiều tài khoản
    public function addHandoverBulk(Request $request)
    {
        $accounts = Account::sales()->get();

        // Get contacts list
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_ids)->get();

        return view('student.contact_requests.addHandoverBulk', ['accounts' => $accounts, 'contactRequests' => $contactRequests]);
    }
    public function addHandoverBulkSave(Request $request)
    {
        $user = $request->user();
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_id)->get();
        $account = Account::find($request->input('accounts'));

        // Kiểm tra xem có tags được chọn không
        foreach ($contactRequests as $contactRequest) {
            // assign
            $contactRequest->assignToAccount($account);
        }

        // Bàn giao nhiều đơn hàng event
        ContactRequestsAssigned::dispatch($account, $contactRequests, $user);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã bàn giao đơn hàng thành công',
        ]);
    }

    public function select2(Request $request)
    {
        // init
        $contactRequests = ContactRequest::query();

        // keyword
        if ($request->q) {
            $contactRequests = $contactRequests->search($request->q);
        }

        // pagination
        $contactRequests = $contactRequests->paginate($request->per_page ?? '2');

        return response()->json([
            "results" => $contactRequests->map(function ($contactRequest) {
                return [
                    'id' => $contactRequest->id,
                    'text' => $contactRequest->contact->name,
                ];
            })->toArray(),
            "pagination" => [
                "more" => $contactRequests->lastPage() != $request->page,
            ]
        ]);
    }

    public function save(Request $request, $id)
    {
        $user = $request->user();
        $contactRequest = ContactRequest::find($id);
        $account = Account::find($request->salesperson_id);

        // salesperson id
        if ($request->salesperson_id) {
            if ($request->salesperson_id == 'unassign') {
                $contactRequest->account_id = null;
            } else {
                $contactRequest->assignToAccount($account);

                // event
                SingleContactRequestAssigned::dispatch($account, $contactRequest, $user);
            }

            $contactRequest->save();
        }

        //email
        if ($request->has('email')) {
            $contactRequest->contact->email = $request->email;
            $contactRequest->save();
        }

        //phone
        if ($request->has('phone')) {
            $contactRequest->contact = \App\Library\Tool::extractPhoneNumber($request->phone);
            $contactRequest->save();
        }

        //lead_status
        if ($request->lead_status) {
            $contactRequest->updateLeadStatus($request->lead_status);
        }

        return response()->json([
            'status' => 'success',
            'salepersone_name' => $contactRequest->account ? $contactRequest->account->name : '<span class="text-gray-500">Chưa bàn giao</span>',
            'email' => $contactRequest->contact->email ? $contactRequest->contact->email : '<span class="text-gray-500">Chưa có email</span>',
            'phone' => $contactRequest->contact->phone ? $contactRequest->contact->phone : '<span class="text-gray-500">Chưa có số điện thoại</span>',
            'lead_status' => $contactRequest->lead_status,
        ]);
    }
    public function showFilterForm(Request $request)
    {
        $accounts = Account::all();
        $lead_status_name = ContactRequest::getLeadStatusName($request->lead_status_menu);
        $lifecycle_stage_name = ContactRequest::getLifecycleStageName($request->lifecycle_stage_menu);

        return view('student.contact_requests.export', [
            'accounts' => $accounts,
            'lifecycle_stage_menu' => $request->lifecycle_stage_menu,
            'lead_status_name' => $lead_status_name,
            'lifecycle_stage_name' => $lifecycle_stage_name,
        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/form-export-contact-request.xlsx');
        $filteredContactRequests = $this->filterContactRequests($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        ContactRequest::exportToExcel($templateSpreadsheet, $filteredContactRequests);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_contacts_request.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_contacts_request.xlsx');
    }

    public static function filterContactRequests(Request $request)
    {
        $query = ContactRequest::query(); // Create a new query for the ContactRequest model

        if ($request->has('source_type')) {
            $query->filterByMarketingType($request->input('source_type'));
        }

        if ($request->has('channel')) {

            $query->filterByMarketingSource($request->input('channel'));
        }

        if ($request->has('sub_channel')) {
            $query->filterByMarketingSourceSub($request->input('sub_channel'));
        }

        if ($request->has('lifecycle_stage')) {
            $query->filterByLifecycleStage($request->input('lifecycle_stage'));
        }

        if ($request->has('lead_status')) {
            $query->filterByLeadStatus($request->input('lead_status'));
        }

        if ($request->has('salesperson_ids')) {
            $query->filterBySalespersonIds($request->input('salesperson_ids'));
        }

        if ($request->has('status')) {
            if ($request->status == 'is_assigned') {
                $query->isAssigned();
            } elseif ($request->status == 'is_new') {
                $query->isNew();
            } elseif ($request->status == 'no_action_yet') {
                $query->noActionYet();
            } elseif ($request->status == 'has_action') {
                $query->hasAction();
            } elseif ($request->status == 'outdated') {
                $query->outdated();
            }
        }

        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        return $query->get();
    }

    public function exportContactRequestSelected(Request $request)
    {
        // Get contacts list
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_ids)->get();

        return view('student.contact_requests.exportContactRequestSelected', [
            'contactRequests' => $contactRequests,
            'contact_request_ids' => $request->contact_request_ids,
        ]);
    }

    public function exportContactRequestSelectedRun(Request $request)
    {
        $contactRequests = ContactRequest::whereIn('id', $request->contact_request_ids)->get();
        $templatePath = public_path('templates/form-export-contact-request.xlsx');
        $templateSpreadsheet = IOFactory::load($templatePath);

        ContactRequest::exportToExcel($templateSpreadsheet, $contactRequests);

        // // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'contacts_request_selected.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportContactRequestSelectedDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'contacts_request_selected.xlsx');
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->contactRequests)) {
            ContactRequest::deleteAll($request->contactRequests);

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
