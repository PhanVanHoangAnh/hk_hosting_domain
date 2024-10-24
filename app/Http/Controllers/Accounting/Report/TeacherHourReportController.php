<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TeacherHourReportController extends Controller
{
    public function index()
    {
        return view('accounting.reports.teacher_hour_report.index');
    }

    public function list(Request $request)
    {
        $query = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR]);

        if ($request->teacherId) {
            $query = $query->where('id', $request->teacherId);
        } else {
            $query = $query->byBranch(\App\Library\Branch::getCurrentBranch());
        }

        $updated_at_from = $request->input('updated_at_from', null);
        $updated_at_to = $request->input('updated_at_to', null);

        $section_from = $request->input('section_from', null);
        $section_to = $request->input('section_to', null);

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        $teachers = $query->paginate($request->perpage ?? 10);
        return view('accounting.reports.teacher_hour_report.list',[
            'teachers' => $teachers,
            'updated_at_from' => $updated_at_from,
            'updated_at_to' => $updated_at_to,
            'section_from' => $section_from,
            'section_to' => $section_to,
        ]);
    }

    public function showFilterForm(Request $request)
    {
        return view('accounting.reports.teacher_hour_report.exportTeacherHourReport',[

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-teacher-hour-report.xlsx');
        $filteredTeachers = $this->filterTeachers($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        $section_from = $request->input('section_from', null);
        $section_to = $request->input('section_to', null);

        Teacher::exportToExcelTeacherHourReport($templateSpreadsheet, $filteredTeachers, $section_from, $section_to);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_accounting_teacher_hour_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_accounting_teacher_hour_report.xlsx');
    }

    public function filterTeachers(Request $request)
    {
        $query = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR]);

        if ($request->teacherId) {
            $query = $query->where('id', $request->teacherId);
        }

        $section_from = $request->input('section_from', null);
        $section_to = $request->input('section_to', null);

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        return $query->get();
    }
}
