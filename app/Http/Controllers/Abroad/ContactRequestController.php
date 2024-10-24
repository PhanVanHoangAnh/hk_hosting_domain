<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactRequest;
use App\Models\FreeTime;
use App\Models\FreeTimeRecord;
use App\Models\Tag;
use App\Models\Account;
use App\Models\NoteLog;
use App\Models\AccountGroup;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use App\Events\ContactRequestsAssigned;
use App\Events\SingleContactRequestAssigned;
use App\Library\Permission;
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
        $listViewName = 'abroad.extracurricular.contact_requests';
        $columns = [
            ['id' => 'code', 'title' => trans('messages.contact_request.code'), 'checked' => false],
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'demand', 'title' => trans('messages.contact.demand'), 'checked' => true],
            ['id' => 'account_id', 'title' => trans('messages.contact.account_id'), 'checked' => false],
            ['id' => 'deadline', 'title' => trans('messages.contact.deadline'), 'checked' => in_array($request->status, ['no_action_yet', 'outdated'])],
            // ['id' => 'order', 'title' => trans('messages.contact.order'), 'checked' => true],
            ['id' => 'lead_status', 'title' => trans('messages.contact.lead_status'), 'checked' => true],
            
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
        ];

        // list view name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('abroad.extracurricular.contact_requests.index', [
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
        // $contactRequests = ContactRequest::isExtracurricular();
        if ($request->user()->can('changeBranch', User::class)) {
            $contactRequests = ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())
            ->select('contact_requests.*')
            ->join('contacts', 'contacts.id', '=', 'contact_requests.contact_id')
            ->whereHas('account.users', function ($query) {
                $query->byModule('EXTRACURRICULAR');
            });

            if ($request->has('accountGroup')) {
                $accountGroup = AccountGroup::find($request->accountGroup);
                $accountIds = $accountGroup->members->pluck('id');
                $contactRequests = ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())
                ->whereIn('contact_requests.account_id', $accountIds)
                ->select('contact_requests.*')
                ->join('contacts', 'contacts.id', '=', 'contact_requests.contact_id');
            }
        }else{
            $contactRequests = $request->user()->account->contactRequestsByAccount()
            ->select('contact_requests.*')
            ->join('contacts', 'contacts.id', '=', 'contact_requests.contact_id');
        }
       
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
            if ($request->lead_status_menu == 'no_action_yet') {
                $contactRequests = $contactRequests->noActionYet();
            } else {
                $contactRequests = ContactRequest::getLeadStatusMenu($contactRequests, $request->lead_status_menu);
            }
        }

        // filter lifecycle stage menu
        if ($request->has('lifecycle_stage_menu')) {
            $contactRequests = ContactRequest::getLifecycleStageMenu($contactRequests, $request->lifecycle_stage_menu);
        }

        // sort
        $contactRequests = $contactRequests->orderBy($sortColumn, $sortDirection);

        // pagination
        $contactRequests = $contactRequests->paginate($request->per_page ?? '20');

        return view('abroad.extracurricular.contact_requests.list', [
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
        return view('abroad.extracurricular.contact_requests.create', [
            'contactRequest' => $contactRequest,
            'tags' => $tags,
            'accounts' => $accounts,
            'orderType' => isset($request->orderType) ? $request->orderType : null
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
            return response()->view('abroad.extracurricular.contact_requests.create', [
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
            return response()->view('abroad.extracurricular.contact_requests.edit', [
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
        return view('abroad.extracurricular.contact_requests.edit', [
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

        return view('abroad.extracurricular.contact_requests.note-logs-list', [
            'notes' => $notes,
            'contactRequest' => $contactRequest,

        ]);
    }

   
    public function show(Request $request, $id)
    {
        $contactRequest = ContactRequest::find($id);
        $accounts = Account::sales()->get();
        //
        return view('abroad.extracurricular.contact_requests.show', [
            'contactRequest' => $contactRequest,
            'accounts' => $accounts,
        ]);
    }

    
}
