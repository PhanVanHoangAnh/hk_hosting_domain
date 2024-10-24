<?php

namespace App\Http\Controllers\Student\Report;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\OrderItem;
use App\Models\StudentSection;
use Illuminate\Http\Request;

class StudentHourReportController extends Controller
{
    public function index()
    {
        return view('student.reports.student_hour_report.index');
    }

    public function list(Request $request)
    {
        $orderItems = OrderItem::query();
        $orderItems = $orderItems->isActive();
        // $sections = $orderItems->first()->getSections();
        $end = null;
        
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $orderItems = $orderItems->filterByUpdatedAt($updated_at_from, $updated_at_to);
            // $end = $updated_at_to;
            // \App\Models\OrderItem::caculateTotalHoursBeforeDate($sections, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $orderItems = $orderItems->orderBy($sortColumn, $sortDirection);
        $orderItems = $orderItems->paginate($request->perpage ?? '5');

        return view('student.reports.student_hour_report.list',[
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
        
        return view('student.reports.student_hour_report.listDetailStudent',[
            'orderItem' => $orderItem,
            'studentSections' => $studentSections,
        ]);
    }
}
