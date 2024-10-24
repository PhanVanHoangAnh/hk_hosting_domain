<?php

namespace App\Http\Controllers\Abroad\Report;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\OrderItem;
use App\Models\StudentSection;
use Illuminate\Http\Request;

class StudentHourReportController extends Controller
{
    public function index()
    {
        return view('abroad.reports.student_hour_report.index');
    }

    public function list(Request $request)
    {
        $courseStudents = CourseStudent::query();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $courseStudents = $courseStudents->orderBy($sortColumn, $sortDirection);
        $courseStudents = $courseStudents->paginate($request->perpage ?? '5');

        return view('abroad.reports.student_hour_report.list',[
            'courseStudents' => $courseStudents,
        ]);
    }

    public function listDetailStudent(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);
        $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent($orderItem->id, $orderItem->orders->student_id);
        $courseIds = $courseStudents->pluck('course_id')->toArray();
        $studentSections = collect();
        
        foreach ($courseIds as $courseId) {
            $studentSections = $studentSections->merge(StudentSection::getSectionsPresent($orderItem->orders->student_id, $courseId));
        }
        
        return view('abroad.reports.student_hour_report.listDetailStudent',[
            'orderItem' => $orderItem,
            'studentSections' => $studentSections,
        
        ]);
    }
}
