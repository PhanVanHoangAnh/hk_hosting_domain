<?php

namespace App\Http\Controllers\Hk;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\SoftwareRequest;
use App\Models\NoteLog;
use Illuminate\Http\Request;

class SoftwareRequestNoteController extends Controller
{
    public function index()
    {
        return view('hk.software_request_notes.index');
    }

    public function list(Request $request)
    {
        return view('hk.software_request_notes.list');
    }

    public function create($id)
    {
        $softwareRequest = SoftwareRequest::find($id);
        
        return view('hk.software_request_notes.create', [
           'softwareRequest' => $softwareRequest,
        ]);
    }

    public function store(Request $request, $id)
    {
        $softwareRequest = SoftwareRequest::find($id);
        $contact = Contact::find($request->contact_id);
        $noteLog = NoteLog::newDefault();
        $errors = $noteLog->storeNoteLogFromRequest($request);
    
        if (!$errors->isEmpty()) {
            return response()->view('hk.software_request_notes.create', [
                'errors' => $errors,
                'contact' => $contact,
                'softwareRequest' => $softwareRequest,
                'contact' => Contact::all(), // Ensure that contacts are passed to the view
            ], 400);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới thành công!'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // dd(1);
        $note = NoteLog::find($id);
        $note->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa ghi chú thành công!'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $noteLog = NoteLog::find($id);

        return view('hk.software_request_notes.edit', [
            'noteLog' => $noteLog,

        ]);
    }

    public function update(Request $request, $id)
    {
        $note = NoteLog::find($id);

        $errors = $note->saveNoteLogFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('hk.software_request_notes.edit', [
                'errors' => $errors,
                'noteLog' => $note
            ], 400);
        };

        $note->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }
}
