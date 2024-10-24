<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\Section;
use App\Models\Attendance;
use App\Models\Teacher;

use App\Models\StudentSection;

use Illuminate\Http\Request;    

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'teacher.sections';
        $columns = [
            ['id' => 'course_id', 'title' => trans('messages.section.course_id'), 'title' => trans('messages.section.course_id'), 'checked' => true],
            ['id' => 'import_id', 'title' => trans('messages.section.import_id'), 'title' => trans('messages.section.import_id'), 'checked' => true],

            
            ['id' => 'study_date', 'title' => trans('messages.section.study_date'), 'checked' => true],
            ['id' => 'start_at', 'title' => trans('messages.section.start_at'), 'checked' => true],
            ['id' => 'end_at', 'title' => trans('messages.section.end_at'), 'checked' => true],
            ['id' => 'teacher_id', 'title' => trans('messages.courses.teacher_id'), 'checked' => true],
            ['id' => 'assistant', 'title' => trans('messages.section.assistant'), 'checked' => true],
            ['id' => 'vietnam_teacher', 'title' => trans('messages.section.vietnam_teacher'), 'checked' => true],
            ['id' => 'foreign_teacher', 'title' => trans('messages.section.foreign_teacher'), 'checked' => true],
            ['id' => 'tutor_teacher', 'title' => trans('messages.section.tutor_teacher'), 'checked' => true],
            ['id' => 'section', 'title' => trans('messages.section.section'), 'checked' => true],
            ['id' => 'num_of_students', 'title' => trans('messages.section.num_of_students'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.section.status'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.section.type'), 'checked' => true],
        ];
        //list view  name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));
        return view('teacher.sections.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $teacher = $request->user()->getTeacher();
        $sections = Teacher::allSections($teacher);

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->subjects) {
            $sections = $sections->filterBySubjects($request->subjects);
        }

        if ($request->has('start_at_from') && $request->has('start_at_to')) {
            $start_at_from = $request->input('start_at_from');
            $start_at_to = $request->input('start_at_to');
            $sections = $sections->filterByStartAt($start_at_from, $start_at_to);
        }

        if ($request->has('status')) {
            if ($request->status == Section::STATUS_NOT_ACTIVE) {
                $sections = $sections->notStudyYet();
            } elseif ($request->status == Section::STATUS_ACTIVE) {
                $sections = $sections->learning();
            } elseif ($request->status == Section::COMPLETED_STATUS) {
                $sections = $sections->studied();
            } elseif ($request->status == Section::STATUS_DESTROY) {
                $sections = $sections->isDestroy();
            } elseif ($request->status == Section::STATUS_OVERDUE_SHIFT_CLOSED) {
                $sections = $sections->isOverdueShiftClosed();
            } elseif ($request->status == Section::STATUS_NOT_SHIFT_CLOSED) {
                $sections = $sections->isNotShiftClosed();
            };
        }

        if ($request->has('studentId')) {
            $sections = $sections->filterByStudentId($request->studentId);
        }

        if ($request->has('teachers')) {
            $sections = $sections->filterByTeachers($request->teachers);
        }

        if ($request->has('homeRooms')) {
            $sections = $sections->filterByHomeRooms($request->homeRooms);
        }

        if ($request->has('types')) {
            $sections = $sections->filterByTypes($request->types);
        }

        if ($sortColumn == 'teacher_id' || $sortColumn == 'assistant' || $sortColumn == 'vietnam_teacher' || $sortColumn == 'foreign_teacher' || $sortColumn == 'tutor_teacher') {
            $sections = Section::query()
                ->join('courses', 'sections.course_id', '=', 'courses.id')
                ->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
                ->select('sections.*')
                ->with(['course.teacher'])
                ->orderBy('teachers.name', $sortDirection);
        } elseif ($sortColumn == 'num_of_students') {
            $sections = Section::query()
                ->join('courses', 'sections.course_id', '=', 'courses.id')
                ->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
                ->select('sections.*')
                ->with(['course.teacher'])
                ->orderBy('courses.max_students', $sortDirection);
        } else {
            $sections = $sections->orderBy($sortColumn, $sortDirection);
        }

        $sections = $sections->paginate($request->perpage ?? '20');

        return view('teacher.sections.list', [
            'sections' => $sections,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function calendar(Request $request)
    {
        return view('teacher.sections.calendar', [
            'columns' => [
                ['id' => 'course_id', 'title' => trans('messages.section.course_id'), 'title' => trans('messages.section.course_id'), 'checked' => true],
                ['id' => 'study_date', 'title' => trans('messages.section.study_date'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.section.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.section.end_at'), 'checked' => true],
                ['id' => 'num_of_students', 'title' => trans('messages.section.num_of_students'), 'checked' => true],
                ['id' => 'status', 'title' => trans('messages.section.status'), 'checked' => true],
            ]
        ]);
    }

    public function eduCalendarContent(Request $request)
    {
        $teacher = $request->user()->getTeacher();
        $sections = Teacher::allSections($teacher);
        
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->keyword) {
            $sections = $sections->search($request->keyword);
        }

        if ($request->courses) {
            $sections = $sections->filterByCourses($request->courses);
        }

        if ($request->subjects) {
            $sections = $sections->filterBySubjects($request->subjects);
        }

        if ($request->has('start_at_from') && $request->has('start_at_to')) {
            $start_at_from = $request->input('start_at_from');
            $start_at_to = $request->input('start_at_to');
            $sections = $sections->filterByStartAt($start_at_from, $start_at_to);
        }

        if ($request->has('status')) {
            if ($request->status == Section::STATUS_NOT_ACTIVE) {
                $sections = $sections->notActive();
            } elseif ($request->status == Section::STATUS_ACTIVE) {
                $sections = $sections->active();
            } elseif ($request->status == Section::STATUS_DESTROY) {
                $sections = $sections->isDestroy();
            };
        }

        if ($request->has('studentId')) {
            $sections = $sections->filterByStudentId($request->studentId);
        }

        if ($request->has('teachers')) {
            $sections = $sections->filterByTeachers($request->teachers);
        }

        if ($request->has('homeRooms')) {
            $sections = $sections->filterByHomeRooms($request->homeRooms);
        }

        if ($request->has('types')) {
            $sections = $sections->filterByTypes($request->types);
        }

        $sections = $sections->orderBy($sortColumn, $sortDirection);
        $sections = $sections->get();

        return view('teacher.sections.calendarContent', [
            'sections' => $sections,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'showCourseCode' => true
        ]);
    }

    public function destroy(Request $request)
    {
        $section = Section::find($request->id);

        if ($section) {
            if ($section->course->study_method === \App\Models\Course::STUDY_METHOD_ONLINE) {
                // Delete meeting link
                if ($section->getMeetingId()) {
                    $sectionsWithSameZoomRoom = $section->getSectionWithSameZoomRoom();
    
                    if ($sectionsWithSameZoomRoom->count() === 0) {
                        \App\Models\ZoomMeeting::deleteMeeting($section->getMeetingId());
                    }
                }
            }

            $section->zoom_start_link = null;
            $section->zoom_join_link = null;
            $section->zoom_password = null;
            $section->status = Section::STATUS_DESTROY;

            $section->save();
        }

        return response()->json([
            "status" => "Success",
            "message" => "Hủy buổi học thành công!"
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->items)) {
            Section::deleteSections($request->items);

            return response()->json([
                'status' => 'success',
                'message' => 'Hủy thành công các buổi học!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không tìm thấy các buổi học!'
        ], 400);
    }

    public function saveAttendancePopup(Request $request, $id)
    {
        $attendance = new StudentSection();

        $attendance->updateAttendanceSection($request, $id);
        $this->saveShift($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Chốt ca thành công !'
        ]);
    }

    public function changeTeacherPopup(Request $request, $id)
    {
        $section = Section::find($request->id);
        $students = CourseStudent::where('course_id', $request->id)->get();

        return view('teacher.sections.changeTeacherPopup', [
            'students' =>   $students,
            'section' => $section
        ]);
    }

    public function saveChangeTeacherPopup(Request $request, $id)
    {
        $section = Section::find($id);
        $errors = $section->updateTeacher($request);

        if (!$errors->isEmpty()) {
            return response()->view('teacher.sections.changeTeacherPopup', [
                'section' => $section,
                'errors' => $errors,
            ], 400);
        }

        $section->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật giáo viên thành công',
            'id' => $section->id,
        ]);
    }
    public function shiftPopup(Request $request)
    {
        $section = Section::find($request->id);
        $studentSection = new StudentSection(); // Tạo một đối tượng StudentSection
        $students = $studentSection->getAttendance($section)->get();

        return view('teacher.sections.shiftPopup', [
            'students' =>   $students,
            'section' => $section
        ]);
    }

    public function saveShift(Request $request)
    {
        $section = Section::find($request->section);

        try {
            //
            $section->saveShift($request);
        } catch (\Exception $e) {

            // after
            return response()->json([
                "message" => "Chốt ca không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Chốt ca thành công cho buổi học"
        ], 200);
    }

    public function showZoomStartLinks(Request $request)
    {
        return response()->view('teacher.courses.show_start_links_popup', [
            'section' => \App\Models\Section::find($request->id)
        ]);
    }

    public function showZoomJoinLinks(Request $request)
    {
        $section = \App\Models\Section::find($request->id);

        return response()->view('teacher.courses.show_join_links_popup', [
            'section' => $section,
            'hostInformation' => $section->getZoomMeetingHostInformation()
        ]);
    }

    public function updateZoomLinksPopup(Request $request, $id)
    {
        $section = Section::find($request->id);
        $zoomUsers = \App\Models\ZoomUser::all();

        return view('teacher.courses.updateZoomLinksPopup', [
            'section' => $section,
            'zoomUsers' => $zoomUsers->toArray(),
        ]);
    }

    public function createZoomLinksForOfflineSectionPopup(Request $request, $id)
    {
        $section = Section::find($request->id);
        $zoomUsers = \App\Models\ZoomUser::all();

        return view('teacher.courses.createZoomLinksForOfflineSectionPopup', [
            'section' => $section,
            'zoomUsers' => $zoomUsers->toArray(),
        ]);
    }

    public function updateZoomLinks(Request $request, $id)
    {
        $section = Section::find($id);
        $errors = $section->updateZoomLinksFromRequest($request);

        if (!$errors->isEmpty()) {
            $zoomUsers = \App\Models\ZoomUser::all();

            return response()->view('teacher.courses.updateZoomLinksPopup', [
                'section' => $section,
                'errors' => $errors,
                'zoomUsers' => $zoomUsers->toArray(),  
                'switch' => isset($request->zoom_switch) && $request->zoom_switch == "on" ? true : false,
                'zoomUserId' => isset($request->zoom_user_id) ? $request->zoom_user_id : null,
                'zoomStartLink' => isset($request->zoom_start_link) ? $request->zoom_start_link : null,
                'zoomJoinLink' => isset($request->zoom_join_link) ? $request->zoom_join_link : null,
                'zoomPassword' => isset($request->zoom_password) ? $request->zoom_password : null,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật link Zooms thành công',
            'id' => $section->id,
        ]);
    }

    public function createZoomLinksForOfflineSection(Request $request, $id)
    {
        $section = Section::find($id);
        $errors = $section->updateZoomLinksFromRequest($request);

        if (!$errors->isEmpty()) {
            $zoomUsers = \App\Models\ZoomUser::all();

            return response()->view('teacher.courses.createZoomLinksForOfflineSectionPopup', [
                'section' => $section,
                'errors' => $errors,
                'zoomUsers' => $zoomUsers->toArray(),  
                'switch' => isset($request->zoom_switch) && $request->zoom_switch == "on" ? true : false,
                'zoomUserId' => isset($request->zoom_user_id) ? $request->zoom_user_id : null,
                'zoomStartLink' => isset($request->zoom_start_link) ? $request->zoom_start_link : null,
                'zoomJoinLink' => isset($request->zoom_join_link) ? $request->zoom_join_link : null,
                'zoomPassword' => isset($request->zoom_password) ? $request->zoom_password : null,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo link Zooms cho buổi học thành công',
            'id' => $section->id,
        ]);
    }
}
