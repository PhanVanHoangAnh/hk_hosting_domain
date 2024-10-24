<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\Account;
use App\Models\NoteLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use App\Events\SingleContactRequestAssigned;
use App\Library\Permission;
use Storage;

use function Laravel\Prompts\alert;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        // init
        $tags = Tag::all();
        $accounts = Account::all();
        $lead_status_name = Contact::getLeadStatusName($request->lead_status_menu);
        $lifecycle_stage_name = Contact::getLifecycleStageName($request->lifecycle_stage_menu);

        // List view & Columns
        $listViewName = 'abroad.extracurricular.contacts';
        $columns = [
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'father', 'title' => trans('messages.contact.father'), 'checked' => false],
            ['id' => 'mother', 'title' => trans('messages.contact.mother'), 'checked' => false],
            ['id' => 'country', 'title' => trans('messages.contact.country'), 'checked' => false],
            ['id' => 'city', 'title' => trans('messages.contact.city'), 'checked' => false],
            ['id' => 'district', 'title' => trans('messages.contact.district'), 'checked' => false],
            ['id' => 'ward', 'title' => trans('messages.contact.ward'), 'checked' => false],
            ['id' => 'address', 'title' => trans('messages.contact.address'), 'checked' => false],
            ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => false],
            ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => true],
            ['id' => 'note_log', 'title' => trans('messages.contact.note_log'), 'checked' => true],

            ['id' => 'identity_id', 'title' => trans('messages.contact.identity_id'), 'checked' => false],
            ['id' => 'identity_date', 'title' => trans('messages.contact.identity_date'), 'checked' => false],
            ['id' => 'identity_place', 'title' => trans('messages.contact.identity_place'), 'checked' => false],
        ];

        // list view name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('abroad.extracurricular.contacts.index', [
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
        if ($request->user()->hasPermission(Permission::SALES_DASHBOARD_ALL)) {
            $contacts = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isNotCustomer();
        } else{
            $contacts = $request->user()->account->onlyContactsOrHasContactRequests();
        }
       
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();

        // keyword
        if ($request->keyword) {
            $contacts = $contacts->search($request->keyword);
        }

        // filter deleted ones
        if($request->status && $request->status == Contact::STATUS_DELETED){
            $contacts = $contacts->deleted();
        }else {
            $contacts = $contacts->active();
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

        return view('abroad.extracurricular.contacts.list', [
            'contacts' => $contacts,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        // init
        $contact = $request->user()->account->newContact();
        $tags = Tag::all();
        $accounts = Account::all();

        // keyword from contact selector helper
        if ($request->keyword) {
            $contact->infoFromKeyword($request->keyword);
        }

        //
        return view('abroad.extracurricular.contacts.create', [
            'contact' => $contact,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function store(Request $request)
    {
        // init
        $contact = $request->user()->account->newContact();
        $tags = Tag::all();
        $accounts = Account::all();
        $accounts = $request->input('accounts');

        // validate
        $errors = $contact->saveFromRequest($request);

        // error
        if (!$errors->isEmpty()) {
            return response()->view('abroad.extracurricular.contacts.create', [
                'contact' => $contact,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        // success
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm liên hệ thành công',
            'id' => $contact->id,
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
            return response()->view('abroad.extracurricular.contacts.edit', [
                'contact' => $contact,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        // Lưu liên hệ vào cơ sở dữ liệu
        $contact->save();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật liên hệ thành công',
            'id' => $contact->id,
            'text' => $contact->getSelect2Text(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        // init
        $contact = Contact::find($id);
        $tags = Tag::all();
        $accounts = Account::all();

        // 
        return view('abroad.extracurricular.contacts.edit', [
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
            'message' => 'Đã xóa liên hệ thành công',
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
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query  = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query  = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $notes = $query->paginate($request->perpage ?? 5);

        return view('abroad.extracurricular.contacts.note-logs-list', [
            'notes' => $notes,
            'contact' => $contact,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }

    public function importHubspot(Request $request)
    {
        return view('abroad.extracurricular.contacts.importHubspot');
    }

    public function importHubspotRun(Request $request)
    {
    }

    public function importExcel(Request $request)
    {
        return view('abroad.extracurricular.contacts.importExcel');
    }

    public function importExcelShow(Request $request)
    {
        $datas = [];

        if ($request->file('file')) {
            $file = $request->file('file');
            $tempFilePath = $file->getRealPath();
            $datas = Contact::importFromExcel($tempFilePath);

            return view('abroad.extracurricular.contacts.showExcelData', [
                'datas' => $datas
            ]);
        }

        return view('abroad.extracurricular.contacts.importExcel', [
            'error' => 'Chưa có file dữ liệu!'
        ]);
    }

    public function importExcelRunning(Request $request)
    {
        $datas = json_decode($request->getContent(), true);

        $excelDatas = $datas['excelDatas'];

        $accountId = $datas['accountId'];

        $importStatus = Contact::saveExcelDatas($excelDatas, $accountId);

        return view('abroad.extracurricular.contacts.importExcelDone', [
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
        return view('abroad.extracurricular.contacts.importExcelDone');
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('abroad.extracurricular.contacts.show', [
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

        //
        return view('abroad.extracurricular.contacts.education', [
            'contact' => $contact,
        ]);
    }

    public function contract(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        //
        return view('abroad.extracurricular.contacts.contract', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }
    public function debt(Request $request, $id)
    {
        $contact = Contact::find($id);

        //
        return view('abroad.extracurricular.contacts.debt', [
            'contact' => $contact,
        ]);
    }
    public function studyAbroad(Request $request, $id)
    {
        $contact = Contact::find($id);

        //
        return view('abroad.extracurricular.contacts.study-abroad', [
            'contact' => $contact,
        ]);
    }
    public function extraActivity(Request $request, $id)
    {
        $contact = Contact::find($id);

        //
        return view('abroad.extracurricular.contacts.extra-activity', [
            'contact' => $contact,
        ]);
    }
    public function kidTech(Request $request, $id)
    {
        $contact = Contact::find($id);

        //
        return view('abroad.extracurricular.contacts.kid-tech', [
            'contact' => $contact,
        ]);
    }
    public function noteLog(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();

        //
        return view('abroad.extracurricular.contacts.note-logs', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function updateHistory(Request $request, $id)
    {
        $contact = Contact::find($id);

        //
        return view('abroad.extracurricular.contacts.update-history', [
            'contact' => $contact,
        ]);
    }

    public function addTags(Request $request)
    {
        $tags = Tag::all();
        return view('abroad.extracurricular.contacts.add-tags', [
            'tags' => $tags,
        ]);
    }

    //Hiển thị Xoá nhiều tags 1 lần
    public function deleteTags(Request $request)
    {
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();
        // $contacts = Contact::limit(5)->get();
        return view('abroad.extracurricular.contacts.deleteTags', [
            'contacts' => $contacts
        ]);
    }

    //Xóa tags nhiều contact
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
            'message' => 'Đã xóa thành công các tags của liên hệ đã chọn',
        ]);
    }

    //Edit nhiều tags một lần
    public function addTagsBulk(Request $request)
    {
        $tags = Tag::all();

        //
        $contacts = Contact::whereIn('id', $request->contact_ids)->get();

        return view('abroad.extracurricular.contacts.addTagsBulk', [
            'tags' => $tags,
            'contacts' => $contacts
        ]);
    }

    // add tag cho nhiều contact
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
            'message' => 'Đã thêm tags thành công cho các liên hệ',
        ]);
    }

    public function select2(Request $request)
    {
        return response()->json(Contact::select2($request));
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

        // lead_status
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


    public function storeNoteLogs(Request $request)
    {
        $notelog = NoteLog::newDefault();
        $errors = $notelog->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('abroad.note_logs.create', [
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới ghi chú thành công!'
        ]);
    }


    public function showFilterForm(Request $request)
    {
        
        // $accounts = Account::all();
        $lead_status_name = Contact::getLeadStatusName($request->lead_status_menu);
        $lifecycle_stage_name = Contact::getLifecycleStageName($request->lifecycle_stage_menu); 

        return view('abroad.extracurricular.contacts.export', [
            
            // 'accounts' => $accounts,
            'lifecycle_stage_menu' => $request->lifecycle_stage_menu,
            'lead_status_name' => $lead_status_name,
            'lifecycle_stage_name' => $lifecycle_stage_name,
            
        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/form-export-contact.xlsx');
        $filteredContacts = $this->filterContacts($request);

        
        $templateSpreadsheet = IOFactory::load($templatePath);

        
        Contact::exportToExcel($templateSpreadsheet, $filteredContacts);

        // Output path
        $outputFileName = 'filtered_contacts.xlsx';
        $storagePath = storage_path('app/exports');
        $outputFilePath = $storagePath . '/' . $outputFileName;

        // Save the spreadsheet to the output file
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_contacts.xlsx');
    }
    public static function filterContacts(Request $request)
    {
        $query = $request->user()->account->onlyContactsOrHasContactRequests();
       
       
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

    public function infoBox(Request $request, $id)
    {
        $contact = Contact::find($id);

        return view('abroad.extracurricular.contacts.infoBox', [
            'contact' => $contact,
        ]);
    }

    public function relatedContactsBox(Request $request)
    {
        $contacts = Contact::findRelatedContacts([
            'contact_id' => $request->contact_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return view('abroad.extracurricular.contacts.relatedContactsBox', [
            'contacts' => $contacts,
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
