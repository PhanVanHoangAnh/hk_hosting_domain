<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KpiTarget;

class KpiTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listViewName = 'accounting.kpi_target';
        $columns = [
            ['id' => 'account_code', 'title' => trans('messages.account.code'), 'checked' => true],
            ['id' => 'account_id', 'title' => trans('messages.kpi_target.account'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.kpi_target.type'), 'checked' => true],
            ['id' => 'amount', 'title' => trans('messages.kpi_target.amount'), 'checked' => true],
            ['id' => 'start_at', 'title' => trans('messages.kpi_target.start_at'), 'checked' => true],
            ['id' => 'end_at', 'title' => trans('messages.kpi_target.end_at'), 'checked' => true],
        ];

        //list view  name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('kpi_targets.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        
        $kpiTargets = KpiTarget::byBranch(\App\Library\Branch::getCurrentBranch())->join('accounts', 'accounts.id', '=', 'kpi_targets.account_id')
            ->select('kpi_targets.*','accounts.name');
        $sortColumn = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // keyword search
        if ($request->keyword) {
            $kpiTargets = $kpiTargets->search($request->keyword);
        }

        // type
        if ($request->type) {
            $kpiTargets = $kpiTargets->byType($request->type);
        }

        // start at
        if ($request->start_at) {
            $kpiTargets = $kpiTargets->startAt($request->start_at);
        }

        // end at
        if ($request->end_at) {
            $kpiTargets = $kpiTargets->endAt($request->end_at);
        }

        // account_ids
        if ($request->account_ids) {
            $kpiTargets = $kpiTargets->byAccountIds($request->account_ids);
        }

        // sort
        $kpiTargets = $kpiTargets->orderBy($sortColumn, $sortDirection);

        // pagination
        $kpiTargets = $kpiTargets->paginate($request->perpage ?? 20);

        return view('kpi_targets.list', [
            'kpiTargets' => $kpiTargets,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kpiTarget = KpiTarget::newDefault();

        return view('kpi_targets.create', [
            'kpiTarget' => $kpiTarget,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kpiTarget = KpiTarget::newDefault();
        $errors = $kpiTarget->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('kpi_targets.create', [
                'kpiTarget' => $kpiTarget,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm kế hoạch KPI thành công',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kpiTarget = KpiTarget::find($id);

        return view('kpi_targets.edit', [
            'kpiTarget' => $kpiTarget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kpiTarget = KpiTarget::find($id);
        $errors = $kpiTarget->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('kpi_targets.edit', [
                'kpiTarget' => $kpiTarget,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật kế hoạch KPI thành công',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete(Request $request, string $id)
    {
        $kpiTarget = KpiTarget::find($id);
        
        $kpiTarget->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa hoạch KPI thành công',
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->ids)) {
            KpiTarget::deleteAll($request->ids);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa kế hoạch đã chọn thành công!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Xóa kế hoạch đã chọn thất bại!'
        ], 400);
    }

    public function importDownloadTemplate(Request $request)
    {
        $filePath = KpiTarget::getImportTemplate();

        return response()->download($filePath, 'import-kpi-target.xlsx');
    }

    public function importUpload(Request $request)
    {
        if ($request->isMethod('post')) {
            list($uploadedFilePath, $errors) = KpiTarget::uploadImportFile($request);

            if (!$errors->isEmpty()) {
                return response()->view('kpi_targets.importUpload', [
                    'errors' => $errors,
                ], 400);
            }

            return response()->json([
                'previewUrl' => action([KpiTargetController::class, 'importPreview'], [
                    'path' => \App\Helpers\Functions::base64urlEncode($uploadedFilePath),
                ]),
            ]);
        }

        return view('kpi_targets.importUpload');
    }

    public function importPreview(Request $request)
    {
        $decodedPath = \App\Helpers\Functions::base64urlDecode($request->path);

        // get all kpi targets
        $kpiTargets = KpiTarget::readFromExcelFile($decodedPath);

        return view('kpi_targets.importPreview', [
            'kpiTargets' => $kpiTargets,
            'path' => $request->path,
        ]);
    }

    public function importRun(Request $request)
    {
        $decodedPath = \App\Helpers\Functions::base64urlDecode($request->path);

        // get all kpi targets
        $kpiTargets = KpiTarget::readFromExcelFile($decodedPath);

        // save all
        foreach ($kpiTargets as $kpiTarget) {
            $kpiTarget->save();
        }

        return view('kpi_targets.importResult', [
            'kpiTargets' => $kpiTargets,
            'success' => $kpiTargets->count(),
        ]);
    }
}
