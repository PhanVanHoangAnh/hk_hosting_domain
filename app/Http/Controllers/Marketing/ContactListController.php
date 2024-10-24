<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;

use App\Models\ContactList;

use Illuminate\Http\Request;

class ContactListController extends Controller
{
    public function index()
    {
        return view('marketing.contact_lists.index');
    }

    public function list(Request $request)
    {
        // init
        $contacts = ContactList::query();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // keyword
        if ($request->keyword) {
            $contacts = $contacts->search($request->keyword);
        }

        // sort
        $contacts = $contacts->orderBy($sortColumn, $sortDirection);

        // pagination
        $contacts = $contacts->paginate($request->per_page ?? '20');

        return view('marketing.contact_lists.list', [
            'contacts' => $contacts,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }

    public function create(Request $request)
    {
        // init
        $contact = ContactList::newDefault();

        //
        return view('marketing.contact_lists.create', [
            'contact' => $contact,
        ]);
    }

    public function store(Request $request)
    {

        // init
        $contact = ContactList::newDefault();

        // validate
        $errors = $contact->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('marketing.contact_lists.create', [
                'contact' => $contact,
                'errors' => $errors,
            ], 400);
        }

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm hợp đồng thành công',
        ]);
    }
    public function update(Request $request, $id)
    {

        // init
        $contact = ContactList::find($id);

        // validate
        $errors = $contact->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('marketing.contact_lists.create', [
                'contact' => $contact,
                'errors' => $errors,
            ], 400);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Đã chỉnh sửa hợp đồng thành công',
        ]);
    }
    public function edit(Request $request, $id)
    {
        // init
        $contact = ContactList::find($id);

        //
        return view('marketing.contact_lists.edit', [
            'contact' => $contact,
        ]);
    }
    public function destroy(Request $request, $id)
    {
        // init
        $contact = ContactList::find($id);

        // delete
        $contact->deleteContact();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa hợp đồng thành công',
        ]);
    }


}