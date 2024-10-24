<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Section;
use App\Models\SectionReport;
use App\Models\StudentSection;
use Illuminate\Http\Request;

class SectionReportsController extends Controller
{
    public function reportSection(Request $request, $id)
    {
        $course = Course::find($request->id);
        // $sections = Section::where('course_id', $course->id)->whereDate('study_date', '<', now()->toDateString())->get();
        $sections = Section::where('course_id', $course->id)->get();

        return view('teacher.courses.reportSection', [
            'course' => $course,
            'sections' => $sections
        ]);
    }

    public function getStudents(Request $request)
    {
        $students = collect();

        if ($request->section_id) {
            $section = Section::find($request->section_id);

            // $students = StudentSection::where('section_id', $section->id)->present()->get();
            $students = StudentSection::where('section_id', $section->id)->get();
        }

        $studentsData = $students->map(function ($student) {
            return [
                'id' => $student->student_id,
                'name' => $student->student->name,
            ];
        });
        return response()->json($studentsData);
    }
    public function getSectionReportData(Request $request)
{
    $sectionId = $request->input('section_id');
    $studentId = $request->input('student_id');

    
    if(isset($sectionId) && isset($studentId)) {
    
        $sectionReport = SectionReport::where('section_id', $sectionId)
            ->where('student_id', $studentId)
            ->active()
            ->first();

        \Log::info('report:', ['report' => $sectionReport]);

      
    } else {
    
        return response()->json(['message' => 'Chưa có studentId và sectionId'], 400);
    }

    // if isset a SectionReport 
    if (isset($sectionReport)) {
        $data = [
            'content' => $sectionReport->content,
            'teacher_comment' => $sectionReport->teacher_comment,
            'tinh_dung_gio' => $sectionReport->tinh_dung_gio,
            'muc_do_tap_trung' => $sectionReport->muc_do_tap_trung,
            'muc_do_hieu_bai' => $sectionReport->muc_do_hieu_bai,
            'muc_do_tuong_tac' => $sectionReport->muc_do_tuong_tac,
            'tu_hoc_va_giai_quyet_van_de' => $sectionReport->tu_hoc_va_giai_quyet_van_de,
            'tu_tin_trach_nhiem' => $sectionReport->tu_tin_trach_nhiem,
            'trung_thuc_ky_luat' => $sectionReport->trung_thuc_ky_luat,
            'ket_qua_tren_lop' => $sectionReport->ket_qua_tren_lop,
        ];

        return response()->json($data);
    } else {
        // return default values when no sectionReport is found
        return response()->json([
            'content' => '',
            'teacher_comment' => '',
            'tinh_dung_gio' => '5', 
            'muc_do_tap_trung' => '5',
            'muc_do_hieu_bai' => '5',
            'muc_do_tuong_tac' => '5',
            'tu_hoc_va_giai_quyet_van_de' => '5',
            'tu_tin_trach_nhiem' => '5',
            'trung_thuc_ky_luat' => '5',
            'ket_qua_tren_lop' => '5',
        ]);
    }
}

    
    public function saveReportSectionInCourse(Request $request, $id)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $course->id)->whereDate('study_date', '<', now()->toDateString())->get();
        
        $sectionReport = SectionReport::newDefault();
        $errors = $sectionReport->updateFromRequest($request, $id);

        if (!$errors->isEmpty()) {
            return response()->view('teacher.courses.reportSection', [
                'sectionReport'=> $sectionReport,
                'course' => $course,
                'sections' => $sections,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm báo cáo thành công!'
        ]);
    }

    public function saveReportSection(Request $request, $id, $contact_id)
    {
        $section = Section::find($id);
        $contact = Contact::find($contact_id);
        $sectionReport = SectionReport::newDefault();
        $errors = $sectionReport->updateFromRequest($request, $id);

        if (!$errors->isEmpty()) {
            return response()->view('teacher.report_sections.create', [
                'sectionReport'=> $sectionReport,
                'contact' => $contact,
                'section' => $section,
                'errors' => $errors,
            ], 400);
        }
        $sectionReport->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm báo cáo thành công!'
        ]);
    }
    public function updateReportSection(Request $request, $id, $contact_id)
    {
        $section = Section::find($request->id);

        $contact = Contact::find($contact_id);
        $sectionReport = SectionReport::newDefault();
        $errors = $sectionReport->updateFromRequest($request, $id);

        if (!$errors->isEmpty()) {
            return response()->view('teacher.report_sections.edit', [
                'sectionReport'=> $sectionReport,
                'contact' => $contact,
                'section' => $section,
                'errors' => $errors,
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm báo cáo thành công!'
        ]);
    }
    public function saveReportSectionPopup(Request $request, $id, $contact_id)
    {
        $section = Section::find($request->id);
        
        $contact = Contact::find($contact_id);
        $sectionReport = SectionReport::newDefault();
        $errors = $sectionReport->updateFromRequest($request, $id);
        
        if (!$errors->isEmpty()) {
            return response()->view('teacher.report_sections.create-report-section-popup', [
                'sectionReport'=> $sectionReport,
                'contact' => $contact,
               'section' => $section,
                'errors' => $errors,
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm báo cáo thành công!'
        ]);
    }
    public function create(Request $request, $id, $contact_id)
    {
        $contact = Contact::find($contact_id);
        $section = Section::find($request->id);
       

        return view('teacher.report_sections.create', [
            'contact' => $contact,
            'section' => $section
        ]);
    }

    public function edit(Request $request, $id, $contact_id)
    {
        $sectionReport = SectionReport::where('student_id', $contact_id)->where('section_id', $id)->first();

        
        $contact = Contact::find($contact_id);
        $section = Section::find($request->id);

        return view('teacher.report_sections.edit', [
            'sectionReport' => $sectionReport,
            'contact' => $contact,
            'section' => $section
            
        ]);
    }
    public function destroy($section_id, $contact_id)
    {
        
        $sectionReport = SectionReport::where('section_id', $section_id)
            ->where('student_id', $contact_id)
            ->first();
        
        $sectionReport->deleteSectionReport();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa báo cáo thành công',
        ]);
    }
   
    public function reportSectionPopup(Request $request, $id, $course_id)
    {
        $student = Contact::find($id);
        $course = Course::find($course_id);
        $courseId = $course->id;
        $sectionReports = SectionReport::filterSectionOfStudentInCourse($student->id, $courseId)->get();

        return view('teacher.report_sections.report-section-popup', [
            'student' => $student,
            'course' => $course,
            'sectionReports' => $sectionReports

        ]);
    }

    public function createReportSectionPopup(Request $request, $id, $course_id)
    {
        $student = Contact::find($id);
        $course = Course::find($course_id);
        $courseId = $course->id;
        $sectionReports = SectionReport::filterSectionOfStudentInCourse($student->id, $courseId)->get();
        $sections = Section::getSectionStudentByCourse($student->id, $courseId)->get();
        

        return view('teacher.report_sections.create-report-section-popup', [
            'student' => $student,
            'course' => $course,
            'sections' => $sections,
            'sectionReports' => $sectionReports
        ]);
    }

}
