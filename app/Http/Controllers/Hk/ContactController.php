<?php

namespace App\Http\Controllers\Hk;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Models\Account;
use App\Library\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use App\Events\SingleContactRequestAssigned;
use App\Library\Permission;
use Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        // init
        $accounts = Account::all();

        // List view & Columns
        $listViewName = 'hk.contacts';
        $columns = [
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'company_name', 'title' => trans('messages.contact.company_name'), 'checked' => true],
            ['id' => 'type_of_business', 'title' => trans('messages.contact.type_of_business'), 'checked' => true],
            ['id' => 'tax_identification_number', 'title' => trans('messages.contact.tax_identification_number'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'country', 'title' => trans('messages.contact.country'), 'checked' => true],
            ['id' => 'city', 'title' => trans('messages.contact.city'), 'checked' => true],
            ['id' => 'district', 'title' => trans('messages.contact.district'), 'checked' => true],
            ['id' => 'ward', 'title' => trans('messages.contact.ward'), 'checked' => true],
            ['id' => 'address', 'title' => trans('messages.contact.address'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => true],
            ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => true],
            ['id' => 'note_log', 'title' => trans('messages.contact.note_log'), 'checked' => true],
        ];

        // list view name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, User::first()->getListView($listViewName));

        return view('hk.contacts.index', [
            'accounts' => $accounts,
            'status' => $request->status,
            'listViewName' => $listViewName,
            'columns' => $columns,
        ]);
    }

    public function list(Request $request)
    {
        $contacts = Contact::query();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // keyword
        if ($request->keyword) {
            $contacts = $contacts->search($request->keyword);
        }

        // filter deleted ones
        if ($request->status && $request->status == Contact::STATUS_DELETED){
            $contacts = $contacts->deleted();
        } else {
            $contacts = $contacts->active();
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

        // filter by status
        // if ($request->has('status')) {
        //     if ($request->status == 'is_assigned') {
        //         $contacts = $contacts->isAssigned();
        //     } else if ($request->status == 'is_new') {
        //         $contacts = $contacts->isNew();
        //     } else if ($request->status == 'no_action_yet') {
        //         $contacts = $contacts->noActionYet();
        //     } else if ($request->status == 'has_action') {
        //         $contacts = $contacts->hasAction();
        //     } else if ($request->status == 'outdated') {
        //         $contacts = $contacts->outdated();
        //     }
        // }

        // sort
        $contacts = $contacts->orderBy($sortColumn, $sortDirection);

        // pagination
        $contacts = $contacts->paginate($request->per_page ?? '20');

        return view('hk.contacts.list', [
            'contacts' => $contacts,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function show()
    {
        return view('hk.frontend.show');
    }

    public function edit(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::all();

        return view('hk.contacts.edit', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::all();
        $errors = $contact->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('hk.contacts.edit', [
                'contact' => $contact,
                'errors' => $errors,
                'accounts' => $accounts,
            ], 400);
        }

        $contact->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật khách hàng thành công',
            'id' => $contact->id,
            'text' => $contact->getSelect2Text(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::find($id);

        $contact->deleteContact();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa khách hàng thành công',
        ]);
    }

    public function create(Request $request)
    {
        $contact = User::first()->account->newContact();
        $accounts = Account::all();

        // keyword from contact selector helper
        if ($request->keyword) {
            $contact->infoFromKeyword($request->keyword);
        }

        return view('hk.contacts.create', [
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function store(Request $request)
    {
        $contact = Account::first()->newContact();
        $accounts = Account::all();
        $accounts = $request->input('accounts');

        // validate
        $errors = $contact->saveFromRequest($request);

        // error
        if (!$errors->isEmpty()) {
            return response()->view('hk.contacts.create', [
                'contact' => $contact,
                'errors' => $errors,
                'accounts' => $accounts,
            ], 400);
        }

        // success
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm khách hàng thành công',
            'id' => $contact->id,
        ]);
    }

    public function save(Request $request, $id)
    {
        $contact = Contact::find($id);
        $account = Account::find($request->salesperson_id);

        // email
        if ($request->has('email')) {
            $contact->email = $request->email;
            $contact->save();
        }

        //phone
        if ($request->has('phone')) {
            $contact->phone = \App\Library\Tool::extractPhoneNumber($request->phone);
            $contact->save();
        }

        return response()->json([
            'status' => 'success',
            'email' => $contact->email ? $contact->email : '<span class="text-gray-500">Chưa có email</span>',
            'phone' => $contact->phone ? $contact->phone : '<span class="text-gray-500">Chưa có số điện thoại</span>',
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

    public function select2(Request $request)
    {
        $accountIds = User::first()->account->accountGroup->getAllAccountAndManagerIds();
        $contacts = Contact::where(function ($q) use ($accountIds) {
            $q->whereIn('account_id', $accountIds);
        });

        return response()->json($contacts->select2($request));
    }

    public function relatedContactsBox(Request $request)
    {
        $contacts = Contact::findRelatedContacts([
            'contact_id' => $request->contact_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return view('hk.contacts.relatedContactsBox', [
            'contacts' => $contacts,
        ]);
    }
}
