<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Payrate;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Events\PayrateUpdate;
class PayrateController  extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'accounting.payrate';
        $columns = [
            ['id' => 'teacher_id', 'title' => trans('messages.payrates.teacher_id'), 'checked' => true],
            ['id' => 'subject_id', 'title' => trans('messages.payrates.subject_id'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.payrates.type'), 'checked' => true],
            ['id' => 'amount', 'title' => trans('messages.payrates.amount'), 'checked' => true],
            ['id' => 'effective_date', 'title' => trans('messages.payrates.effective_date'), 'checked' => true],
            ['id' => 'training_location_id', 'title' => trans('messages.payrates.training_location_id'), 'checked' => true],
            ['id' => 'study_method', 'title' => trans('messages.payrates.study_method'), 'checked' => true],
            ['id' => 'class_status', 'title' => trans('messages.payrates.class_status'), 'checked' => true],
            ['id' => 'class_size', 'title' => trans('messages.payrates.class_size'), 'checked' => true],
        ];

        //
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('accounting.payrates.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }
    public function list(Request $request)
    {
        $query = Payrate::byBranch(\App\Library\Branch::getCurrentBranch())->with('subject');
        if ($request->keyword) {
            $query = $query->search($request->keyword);
        }

        $sortColumn = $request->sort_by ?? 'effective_date';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->teachers) {
            $query = $query->filterByTeachers($request->teachers);
        }
        if ($request->subjects) {
            $query = $query->filterBySubjects($request->subjects);
        }
        if ($request->types) {
            $query = $query->filterByTypes($request->types);
        }
        // Filter by effective_date
        if ($request->has('effective_date_from') && $request->has('effective_date_to')) {
            $effective_date_from = $request->input('effective_date_from');
            $effective_date_to = $request->input('effective_date_to');
            $query = $query->filterByEffectiveDate($effective_date_from, $effective_date_to);
        }

        

        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        //pagination
        $salarySheets = $query->paginate($request->perpage ?? 20);

        return view('accounting.payrates.list', [
            'salarySheets' => $salarySheets,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create()
    {
        $teachers = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR])->get();
        $subjects = Subject::all();
        $salarySheet = Payrate::newDefault();
        return view('accounting.payrates.create', [
            'salarySheet' => $salarySheet,
            'teachers' => $teachers,
            'subjects' => $subjects, 
        ]);
    }

    public function store(Request $request)
    {
       
        $salarySheet = Payrate::newDefault();
        $subjects = Subject::all();
        $errors = $salarySheet->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payrates.create', [ 
                'salarySheet' => $salarySheet,
                'errors' => $errors,
                'subjects' => $subjects
            ], 400);
        }
        $teacherNotification = Teacher::find($request->teacher_id);

        PayrateUpdate::dispatch($teacherNotification, $request->user());
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm bậc lương thành công',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $salarySheet = Payrate::find($id);
        $salarySheet->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa bậc lương thành công',
        ]);
    }

    public function edit(Request $request)
    {   
        $teachers = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR])->get();
        $salarySheet = Payrate::find($request->id);
        $subjects = Subject::all();

        return view('accounting.payrates.edit', [
            'teachers' => $teachers,
            'salarySheet' => $salarySheet,
            'subjects' => $subjects
        ]);
    }

    public function update(Request $request)
    {
        $teachers = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR])->get();
        $salarySheet = Payrate::find($request->id);
        $subjects = Subject::all();
        $errors = $salarySheet->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payrates.edit', [
                'teachers' => $teachers,
                'salarySheet' => $salarySheet,
                'errors' => $errors,
                'subjects' => $subjects
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm bậc lương thành công',
        ]);
    }
    public function select2(Request $request)
    {
        return response()->json(Payrate::select2($request));
    }

    public function export(Request $request)
    { 
        return view('accounting.payrates.export', [
            
        ]);
    }
    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/export-payrates.xlsx');
        $filteredContactRequests = $this->filterPayrates($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        Payrate::exportToExcel($templateSpreadsheet, $filteredContactRequests);

        
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'export-payrates.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'export-payrates.xlsx');
    }
    public static function filterPayrates(Request $request)
    {
        $query = Payrate::query(); 
        
        if ($request->has('teachers')) {
            $query->filterByTeachers($request->input('teachers'));
        }
        if ($request->has('subjects')) {
            $query->filterBySubjects($request->input('subjects'));
        }
        if ($request->has('type_classes')) {
            $query->filterByTypes($request->input('type_classes'));
        }

        
        if ($request->has('effective_date_from') && $request->has('effective_date_to')) {
            $effective_date_from = $request->input('effective_date_from');
            $effective_date_to = $request->input('effective_date_to');
            $query->filterByEffectiveDate($effective_date_from, $effective_date_to);
        }

        return $query->get();
    }
}
