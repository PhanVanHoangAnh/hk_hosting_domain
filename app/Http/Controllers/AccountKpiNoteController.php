<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Permission;
use Illuminate\Http\Request;
use App\Models\AccountKpiNote;
use App\Models\Contact;
use App\Models\Account;

class AccountKpiNoteController extends Controller
{
    public function index(Request $request)
    {
        $account_kpi_notes = AccountKpiNote::all();

        return view('account-kpi-note.index',[
            'user' => $request->user(),
        ]);
    }
    
    public function list(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_DASHBOARD_ALL)) {
            $account_kpi_notes = AccountKpiNote::byBranch(\App\Library\Branch::getCurrentBranch());
            // $account_kpi_notes = AccountKpiNote::query();
        } else{
            
            $account_kpi_notes= $request->user()->account->accountKpiNotes();
        }
        

        if ($request->keyword) {
            $account_kpi_notes = $account_kpi_notes->search($request->keyword);
        }
        
        // filter by contact id
        if ($request->contact_ids) {
            $account_kpi_notes = $account_kpi_notes->filterByContactIds($request->contact_ids);
        }

        if ($request->account_id) {
            $account_kpi_notes = $account_kpi_notes->filterByAccountId($request->account_id);
        }

        // Filter by payment_date
        if ($request->has('estimated_payment_date_from') && $request->has('estimated_payment_date_to')) {
            $estimated_payment_date_from = $request->input('estimated_payment_date_from');
            $estimated_payment_date_to = $request->input('estimated_payment_date_to');
            $account_kpi_notes = $account_kpi_notes->filterByPaymentDate($estimated_payment_date_from, $estimated_payment_date_to);
        }

        // sort
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $account_kpi_notes = $account_kpi_notes->orderBy($sortColumn, $sortDirection);

        // pagination
        $account_kpi_notes = $account_kpi_notes->paginate($request->per_page ?? '20');

        return view('account-kpi-note.list', [
            'account_kpi_notes' => $account_kpi_notes,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }


    public function edit(Request $request, $id)
    {
        $account_kpi_notes = AccountKpiNote::find($id);

        return view('account-kpi-note.edit', [
            'account_kpi_notes' => $account_kpi_notes
        ]);
    }

    public function update(Request $request, $id)
    {
        $account_kpi_notes = AccountKpiNote::find($id);

        $errors = $account_kpi_notes->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('account-kpi-note.edit', [
                'errors' => $errors,
                'account_kpi_notes' => $account_kpi_notes
            ], 400);
        };

        $account_kpi_notes->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }

    public function create(Request $request, $id = null)
    { 
        $contact = null;
        if ($id) { 
            $contact = Contact::find($id); 
            $account_kpi_note = new AccountKpiNote(['contact_id' => $id]);
        } else {
            
            $account_kpi_note = AccountKpiNote::newDefault();
        } 
        return view('account-kpi-note.create', [
            'contact' => $contact,
            'account_kpi_note' => $account_kpi_note,
        ]);
    }
    public function store(Request $request)
    {
        $account_kpi_note = AccountKpiNote::newDefault();
        $errors = $account_kpi_note->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('account-kpi-note.create', [
                'errors' => $errors
            ], 400);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới thành công!',
        ]);
    }
    
    public function destroy(Request $request, $id)
    {
        $note = AccountKpiNote::find($id);

        $note->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa  thành công!'
        ]);
    }

    public function destroyAll(Request $request)
    {
        if (!empty($request->noteIds)) {
            AccountKpiNote::deleteListAcountKpiNotes(($request->noteIds));
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không có nào để xóa!'
        ], 200);
    }
}