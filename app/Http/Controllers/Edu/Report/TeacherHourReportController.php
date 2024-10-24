<?php

namespace App\Http\Controllers\Edu\Report;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherHourReportController extends Controller
{
    public function index()
    {
        return view('edu.reports.teacher_hour_report.index');
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
        return view('edu.reports.teacher_hour_report.list',[
            'teachers' => $teachers,
            'updated_at_from' => $updated_at_from,
            'updated_at_to' => $updated_at_to,
            'section_from' => $section_from,
            'section_to' => $section_to,
        ]);
    }

    public function listDetailTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        $section_from = $request->input('section_from');
        $section_to = $request->input('section_to');
    
        $sectionsInRange = Section::inSectionRange($teacher->id, $section_from, $section_to)->get();
        
        return view('edu.reports.teacher_hour_report.listDetailTeacher',[
            'teacher' => $teacher,
            'sectionsInRange' => $sectionsInRange,
        ]);
    }
}
