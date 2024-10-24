<?php

namespace App\Http\Controllers\Abroad\Report;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherHourReportController extends Controller
{
    public function index()
    {
        return view('abroad.reports.teacher_hour_report.index');
    }

    public function list(Request $request)
    {
        $query = Teacher::whereIn('type', [Teacher::TYPE_VIETNAM, Teacher::TYPE_FOREIGN, Teacher::TYPE_TUTOR]);

        if ($request->teacherId) {
            $query = $query->where('id', $request->teacherId);
        }

        $updated_at_from = $request->input('updated_at_from', null);
        $updated_at_to = $request->input('updated_at_to', null);
        $section_from = $request->input('section_from', null);
        $section_to = $request->input('section_to', null);
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $teachers = $query->paginate($request->perpage ?? 10);
        
        return view('abroad.reports.teacher_hour_report.list',[
            'teachers' => $teachers,
            'updated_at_from' => $updated_at_from,
            'updated_at_to' => $updated_at_to,
            'section_from' => $section_from,
            'section_to' => $section_to,
        ]);
    }
}
