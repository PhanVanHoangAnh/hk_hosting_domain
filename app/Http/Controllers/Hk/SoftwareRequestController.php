<?php

namespace App\Http\Controllers\Hk;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\SoftwareRequest;
use App\Models\Contact;

class SoftwareRequestController extends Controller
{
    public function index(Request $request)
    {

        // $listViewName = 'hk.software_requests';
        $columns = [
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'company_name', 'title' => trans('messages.payrates.company_name'), 'checked' => true],
            ['id' => 'company_size', 'title' => trans('messages.payrates.company_size'), 'checked' => true],
            ['id' => 'company_branch', 'title' => trans('messages.payrates.company_branch'), 'checked' => true],
            ['id' => 'line_of_business', 'title' => trans('messages.payrates.line_of_business'), 'checked' => true],
            ['id' => 'note', 'title' => trans('messages.payrates.note'), 'checked' => true],
            ['id' => 'account', 'title' => trans('messages.payrates.account'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.payrates.status'), 'checked' => true],
        ];

        //
        // $columns = \App\Helpers\Functions::columnsFromListView($columns, $listViewName);

        return view('hk.software_requests.index', [
            'columns' => $columns,
            // 'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = SoftwareRequest::select('software_requests.*')
            ->join('contacts', 'software_requests.contact_id', '=', 'contacts.id');

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->has('status')) {
            if ($request->status == 'delivered') {
                $query = $query->delivered();
            } else if ($request->status == 'new') {
                $query = $query->new();
            } else if ($request->status == 'needs_care') {
                $query = $query->care();
            }else if ($request->status == 'progress'){
                $query = $query->progress();
            }
            else if ($request->status == 'completed'){
                $query = $query->completed();
            }
        }

        $query->orderBy($sortColumn, $sortDirection);

        //pagination
        $requests = $query->paginate($request->perpage ?? 20);

        return view('hk.software_requests.list', [
            'requests' => $requests,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function requestForm()
    {
        return view('hk.software_requests.requestForm');
    }

    public function requestFormSave(Request $request)
    {
        $contact = Contact::newDefault();
        $errors = $contact->saveAndAddSoftwareRequestFromRequest($request);

        if (!$errors->isEmpty()) {
            $errorsArray = $errors->messages();
            $firstItem = reset($errorsArray);

            if (is_array($firstItem)) {
                $firstError = reset($firstItem);
            } else {
                $firstError = $firstItem;
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Xảy ra lỗi trong quá trình đăng ký!',
                'errors' => $errors,
                'firstError' => $firstError
            ], 400);
        }

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đăng ký tư vấn thành công',
        ], 200);
    }

    public function assignedIndex(Request $request)
    {
        // $listViewName = 'hk.software_requests';
        $columns = [
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'company_name', 'title' => trans('messages.payrates.company_name'), 'checked' => true],
            ['id' => 'company_size', 'title' => trans('messages.payrates.company_size'), 'checked' => true],
            ['id' => 'company_branch', 'title' => trans('messages.payrates.company_branch'), 'checked' => true],
            ['id' => 'line_of_business', 'title' => trans('messages.payrates.line_of_business'), 'checked' => true],
            ['id' => 'note', 'title' => trans('messages.payrates.note'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.payrates.status'), 'checked' => true],
        ];

        //
        // $columns = \App\Helpers\Functions::columnsFromListView($columns, $listViewName);

        return view('hk.assignedIndex.assignedIndex', [
            'columns' => $columns,
            // 'listViewName' => $listViewName,
        ]);
    }
    public function assignedList(Request $request)
    {
        $query = SoftwareRequest::select('software_requests.*')
            ->join('contacts', 'software_requests.contact_id', '=', 'contacts.id');

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->has('status')) {
            if ($request->status == 'delivered') {
                $query = $query->delivered();
            } else if ($request->status == 'new') {
                $query = $query->new();
            } else if ($request->status == 'needs_care') {
                $query = $query->care();
            }
        }

        $query->orderBy($sortColumn, $sortDirection);

        //pagination
        $requests = $query->paginate($request->perpage ?? 20);

        return view('hk.assignedIndex.assignedList', [
            'requests' => $requests,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function show(Request $request, $id)
    {
        $softwareRequest = SoftwareRequest::with('softwareRequestNotes')->find($id);

        return view('hk.software_requests.show', [
            'softwareRequest' => $softwareRequest,
            'softwareRequestNotes' => $softwareRequest->softwareRequestNotes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $softwareRequest = SoftwareRequest::find($id);
        $errors = $softwareRequest->saveFromRequest($request);
        
        if (!$errors->isEmpty()) {
            return response()->view('hk.software_requests._form_detail_content', [
                'softwareRequest' => $softwareRequest,
                'errors' => $errors,
            ], 400);
        }
        
        // Lưu đơn hàng vào cơ sở dữ liệu
        $softwareRequest->save();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật thành công',
        ]);
    }

    public function assignedDetail(Request $request)
    {
        $softwareRequest = SoftwareRequest::find($request->id);

        return view('hk.assignedIndex.assignedDetail', [
            'softwareRequest' => $softwareRequest,
            // 'listViewName' => $listViewName,
        ]);
    }

    public function assignAccount(Request $request, $id)
    {
        $softwareRequest = SoftwareRequest::find($id);

        return view('hk.assignedIndex.assignAccount', [
            'softwareRequest' => $softwareRequest
        ]);
    }
    public function doneAssignAccount(Request $request, $id)
    {

        $softwareRequest = SoftwareRequest::find($id);
        $softwareRequest->account_id = $request->account_id;
        $softwareRequest->status = SoftwareRequest::STATUS_DELIVERED;
        $softwareRequest->save();

        return view('hk.assignedIndex.assignAccount', [
            'softwareRequest' => $softwareRequest
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $softwareRequest = SoftwareRequest::find($id);

        return view('hk.software_requests.updateStatus', [
            'softwareRequest' => $softwareRequest
        ]);
    }
    public function doneUpdateStatus(Request $request, $id)
    {
       
        $softwareRequest = SoftwareRequest::find($id);
        $softwareRequest->status = $request->status;
        $softwareRequest->save();

        return view('hk.assignedIndex.assignAccount', [
            'softwareRequest' => $softwareRequest
        ]);
    }
}
