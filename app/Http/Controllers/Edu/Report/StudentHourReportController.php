<?php

namespace App\Http\Controllers\Edu\Report;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\OrderItem;
use App\Models\StudentSection;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentHourReportController extends Controller
{
    public function index()
    {
        return view('edu.reports.student_hour_report.index');
    }

    public function list(Request $request)
    {
        $orderItems = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch());
        $orderItems = $orderItems->isActive();
        // $sections = $orderItems->first()->getSections();
        $end = null;
        $updated_at_from = null;
        $updated_at_to = null;
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            // $orderItems = $orderItems->filterByUpdatedAt($updated_at_from, $updated_at_to);
            // $end = $updated_at_to;
            // \App\Models\OrderItem::caculateTotalHoursBeforeDate($sections, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $orderItems = $orderItems->orderBy($sortColumn, $sortDirection);
        $orderItems = $orderItems->paginate($request->perpage ?? '5');

        return view('edu.reports.student_hour_report.list',[
            'orderItems' => $orderItems,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'updated_at_from'=>$updated_at_from,
            'updated_at_to' => $updated_at_to,
        ]);
    }

    public function listDetailStudent(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);
        $studentSections = StudentSection::findByOrderItemAndStudent($orderItem->id, $orderItem->orders->student_id)->get();
        
        return view('edu.reports.student_hour_report.listDetailStudent',[
            'orderItem' => $orderItem,
            'studentSections' => $studentSections,
        ]);
    }

    public function export(Request $request)
    {
        $templatePath = public_path('templates/edu-student-hour-report.xlsx');
        $filterStudentReport = $this->filterStudentReport($request);
        $templateSpreadsheet = IOFactory::load($templatePath);
        $updated_at_to = $request->input('updated_at_to');
        $updated_at_from = $request->input('updated_at_from');
    
        OrderItem::exportStudentReport($templateSpreadsheet, $filterStudentReport, $updated_at_to, $updated_at_from);
    
        // Output path
        $storagePath = storage_path('app/exports');
    
        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }
    
        $outputFileName = 'edu-student-hour-report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
    
        $writer->save($outputFilePath);

        if (!file_exists($outputFilePath)) {
            return response()->json(['error' => 'Failed to save the file.'], 500);
        }
    
        return response()->download($outputFilePath, $outputFileName);    
    }

    public function filterStudentReport(Request $request)
    {
        $orderItems = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch());
        $orderItems = $orderItems->isActive();
        // $sections = $orderItems->first()->getSections();
        $end = null;
        $updated_at_from = null;
        $updated_at_to = null;
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            // $orderItems = $orderItems->filterByUpdatedAt($updated_at_from, $updated_at_to);
            // $end = $updated_at_to;
            // \App\Models\OrderItem::caculateTotalHoursBeforeDate($sections, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $orderItems = $orderItems->orderBy($sortColumn, $sortDirection);

        return $orderItems->get();
    }
}
