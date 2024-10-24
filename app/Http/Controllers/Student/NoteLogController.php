<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\NoteLog;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class NoteLogController extends Controller
{
    public function index(Request $request)
    {
        return view('student.note_logs.index', [
            'status' => $request->status,
            'columns' => [
                // ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
                // ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
                // ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
                // ['id' => 'demand', 'title' => trans('messages.contact.demand'), 'checked' => true],
                // ['id' => 'school', 'title' => trans('messages.contact.school'), 'checked' => true],
                // ['id' => 'age', 'title' => trans('messages.contact.age'), 'checked' => true],
                // ['id' => 'time_to_call', 'title' => trans('messages.contact.time_to_call'), 'checked' => true],
                // ['id' => 'country', 'title' => trans('messages.contact.country'), 'checked' => true],
                // ['id' => 'city', 'title' => trans('messages.contact.city'), 'checked' => true],
                // ['id' => 'district', 'title' => trans('messages.contact.district'), 'checked' => true],
                // ['id' => 'ward', 'title' => trans('messages.contact.ward'), 'checked' => true],
                // ['id' => 'address', 'title' => trans('messages.contact.address'), 'checked' => true],
                // ['id' => 'efc', 'title' => trans('messages.contact.efc'), 'checked' => true],
                // ['id' => 'list', 'title' => trans('messages.contact.list'), 'checked' => true],
                // ['id' => 'target', 'title' => trans('messages.contact.target'), 'checked' => true],
                // ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => true],
                // ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => true],
                // ['id' => 'lead_status', 'title' => trans('messages.contact.lead_status'), 'checked' => true],
                // ['id' => 'pic', 'title' => trans('messages.contact.pic'), 'checked' => true],
                // // ['id' => 'account_id', 'title' => trans('messages.contact.account_id'), 'checked' => true],
                // ['id' => 'note_log', 'title' => trans('messages.contact.note_log'), 'checked' => true],
                // ['id' => 'deadline', 'title' => trans('messages.contact.deadline'), 'checked' => true],
                ['id' => 'name', 'title' => trans('messages.notelog.name'), 'checked' => true],
                ['id' => 'content', 'title' => trans('messages.notelog.content'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.notelog.updated_at'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.notelog.created_at'), 'checked' => true],
                ['id' => 'account_id', 'title' => trans('messages.notelog.account_id'), 'checked' => true],
            ],
        ]);
    }

    public function list(Request $request)
    {
        $query = NoteLog::with('contacts', 'account');

        if ($request->key) {
            $query = $query->search($request->key);
        }

        // filter deleted ones
        if ($request->status && $request->status == NoteLog::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->active();
        }        

        // filter by contact id
        if ($request->contact_ids) {
            $query = $query->filterByContactIds($request->contact_ids);
        }

        // filter by account id
        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }
        // Filter by created_at
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
        // sort
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        // pagination
        $notes = $query->paginate($request->perpage ?? 20);

        return view('student.note_logs.list', [
            'notes' => $notes,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $note = NoteLog::find($id);

        return view('student.note_logs.edit', [
            'note' => $note
        ]);
    }

    public function update(Request $request, $id)
    {
        $note = NoteLog::find($id);

        $errors = $note->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.note_logs.edit', [
                'errors' => $errors,
                'note' => $note
            ], 400);
        };

        $note->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }

    public function create(Request $request)
    {
        $notelog = NoteLog::newDefault();

        return view('student.note_logs.create', [
            'notelog' => $notelog,
        ]);
    }
    
    public function createNoteLogCustomer(Request $request, $id)
    {
        $contact = Contact::find($id);
        return view('student.note_logs.create-notelog-customer', [
            'contact' => $contact
        ]);
    }

    public function storeNoteLog(Request $request, $id)
    {

        $contact = Contact::find($id);
        $notelog = NoteLog::newDefault();
        $errors = $notelog->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.note_logs.create-notelog-customer', [
                'errors' => $errors,
                'contact' => $contact
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới ghi chú thành công!'
        ]);
    }

    public function store(Request $request)
    {
        $notelog = NoteLog::newDefault();
        $errors = $notelog->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.note_logs.create', [
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới ghi chú thành công!'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $note = NoteLog::find($id);

        $note->deleteNoteLog();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa ghi chú thành công!'
        ]);
    }

    public function destroyAll(Request $request)
    {
        if (!empty($request->noteIds)) {
            NoteLog::deleteListNotes(($request->noteIds));
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa ghi chú thành công!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không có ghi chú nào để xóa!'
        ], 400);
    }



    public function noteLogsPopup(Request $request, $id)
    {
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->status && $request->status == NoteLog::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->active();
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

        // pagination
        $notes = $query->paginate($request->perpage ?? 5);

        return view('student.note_logs.note-logs-popup', [
            'notes' => $notes,
            'contact' => $contact,

        ]);
    }
    
    public function addNoteLog(Request $request, $id)
    {
        $contact = Contact::find($id);
        return view('student.note_logs.add-notelog', [
            'contact' => $contact
        ]);
    }
}