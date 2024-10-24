<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\ZoomMeeting;
use App\Models\CourseStudent;
use App\Models\Payrate;
use App\Models\Section;
use App\Models\StudentSection;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Contact;
use App\Models\RefundRequest;
use App\Models\Reserve;
use App\Models\OrderItem;
use App\Models\Account;

class CourseController2 extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('teacher')->get();

        return view('student.edu.courses.index', [
            'courses' => $courses,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'class_code', 'title' => trans('messages.class.class_code'), 'checked' => true],
                ['id' => 'assistant', 'title' => trans('messages.class.assistant'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'total_hours', 'title' => trans('messages.courses.total_hours'), 'checked' => true],
                ['id' => 'studied_hours', 'title' => trans('messages.courses.studied_hours'), 'checked' => true],
                ['id' => 'remain_hours', 'title' => trans('messages.courses.remain_hours'), 'checked' => true],
                ['id' => 'teacher_id', 'title' => trans('messages.courses.teacher_id'), 'checked' => true],
                ['id' => 'study_method', 'title' => trans('messages.courses.study_method'), 'checked' => true],
                ['id' => 'level', 'title' => trans('messages.courses.level'), 'checked' => true],

                ['id' => 'min_students', 'title' => trans('messages.courses.min_students'), 'checked' => true],
                ['id' => 'number_students', 'title' => trans('messages.courses.number_students'), 'checked' => true],
                ['id' => 'status', 'title' => trans('messages.courses.status'), 'checked' => true],
                ['id' => 'location', 'title' => trans('messages.courses.location'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }

    public function list(Request $request)
    {
        $query = Course::with('teacher')->with('subject');

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->maxStudents) {
            $query = $query->filterByMaxStudents($request->maxStudents);
        }

        if ($request->teachers) {
            $query = $query->filterByTeachers($request->teachers);
        }

        if ($request->subjects) {
            $query = $query->filterBySubjects($request->subjects);
        }

        if ($request->classRoom) {
            $query =  $query->filterByClassRoom($request->classRoom);
        }

        if ($request->has('start_at_from') && $request->has('start_at_to')) {
            $start_at_from = $request->input('start_at_from');
            $start_at_to = $request->input('start_at_to');
            $query = $query->filterByStartAt($start_at_from, $start_at_to);
        }

        if ($request->has('end_at_from') && $request->has('end_at_to')) {
            $end_at_from = $request->input('end_at_from');
            $end_at_to = $request->input('end_at_to');
            $query = $query->filterByEndAt($end_at_from, $end_at_to);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        if ($request->has('status')) {
            if ($request->status == Course::OPENING_STATUS) {
                $query = $query->getIsLearning();
            } elseif ($request->status == Course::COMPLETED_STATUS) {
                $query = $query->getIsStudied();
            } elseif ($request->status == Course::WAITING_OPEN_STATUS) {
                $query = $query->getIsUnstudied();
            } elseif ($request->status == Section::STATUS_STOPPED) {
                $query = $query->getStoppedClass();
            };
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($sortColumn == 'assistant') {
            $query = $query->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
                ->orderBy('teachers.name', $sortDirection)
                ->select('courses.*');
        } else {
            $query = $query->orderBy($sortColumn, $sortDirection);
        }

        $courses = $query->paginate($request->perpage ?? 10);

        return view('student.courses.list', [
            'courses' => $courses,
            'status' => $request->status,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function delete(Request $request)
    {
        $course = Course::find($request->id);
        $course->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Xóa khóa học thành công!"
        ]);
    }

    public function edit(Request $request)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)
            ->isNotDestroy()
            ->get();

        return view('student.courses.edit', [
            'course' => $course,
            'sections' => $sections,
            'action' => 'edit'
        ]);
    }

    public function editCalendar(Request $request)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)
            ->isNotDestroy()
            ->get();

        return view('student.courses.editCalendar', [
            'course' => $course,
            'sections' => $sections
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->items)) {
            Course::deleteCourses($request->items);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công các khóa học!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không tìm thấy các khóa học!'
        ], 400);
    }

    public function add(Request $request)
    {
        return view('student.courses.add', [
            'action' => 'add'
        ]);
    }

    public function create(Request $request)
    {
        $course = Course::newDefault();
        $errors = $course->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.courses._form', [
                'errors' => $errors,
                'course' => $course,
                'action' => 'add'
            ], 400);
        }

        $course->generateCodeName();

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới khóa học thành công!'
        ]);
    }

    public function update(Request $request)
    {
        $course = Course::find($request->id);
        $errors = $course->updateFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.courses.edit', [
                'errors' => $errors,
                'course' => $course,
                'action' => 'edit'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật khóa học thành công!'
        ]);
    }

    public function updateCalendar(Request $request)
    {
        $course = Course::find($request->id);
        $errors = $course->saveEventsFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('student.courses.editCalendar', [
                'errors' => $errors,
                'course' => $course
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thời khóa biểu thành công!'
        ]);
    }

    public function showDetail(Request $request, $id)
    {
        $course = Course::find($id);

        return view('student.courses.showDetail', [
            'course' => $course,

        ]);
    }

    public function students(Request $request, $id)
    {
        $course = Course::find($id);
        $students = CourseStudent::rightJoin('contacts', 'course_student.student_id', '=', 'contacts.id')->where('course_id', $request->id)->get();

        return view('student.courses.students', [
            'course' => $course,
            'students' => $students,
        ]);
    }

    public function studentList(Request $request, $id)
    {
        $course = Course::find($id);
        $students = CourseStudent::rightJoin('contacts', 'course_student.student_id', '=', 'contacts.id')->where('course_id', $request->id);

        if ($request->keyword) {
            $students = $students->search($request->keyword);
        }

        if ($request->student) {
            $students =  $students->filterByStudent($request->student);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // sort
        $students = $students->orderBy("contacts.$sortColumn", $sortDirection);

        // pagination
        $students = $students->paginate($request->per_page ?? '20');

        return view('student.courses.studentList', [
            'course' => $course,
            'students' => $students,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function schedule(Request $request, $id)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)->get();

        return view('student.courses.schedule', [
            'course' => $course,
            'sections' => $sections
        ]);
    }

    public function addSchedule(Request $request)
    {
        return view('student.courses.addSchedule', [
            'day_name' => $request->day_name
        ]);
    }

    public function createScheduleItem(Request $request)
    {
        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('student.courses.addSchedule', [
                "errors" => $errors,
                "schedule" => $schedule
            ], 400);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm lịch học thành công!'
            ], 200);
        }
    }

    public function editSchedule(Request $request)
    {
        $weekEventEdit = $request->all();

        return view('student.courses.addSchedule', [
            'weekEventEdit' => $weekEventEdit,
            'day_name' => $request->dayName
        ]);
    }

    public function editWeekScheduleItem(Request $request)
    {
        $errors = Course::validateScheduleItemsFromRequest($request);
        $weekEventEdit = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('student.courses.addSchedule', [
                "errors" => $errors,
                "weekEventEdit" => $weekEventEdit,
                'day_name' => $request->day_name
            ], 400);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật lịch học thành công!'
            ], 200);
        }
    }

    public function sections(Request $request, $id)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)->get();

        return view('student.courses.sections', [
            'course' => $course,
            'sections' => $sections
        ]);
    }

    public function sectionList(Request $request, $id)
    {
        $sections = Section::where('course_id', $request->id);

        if ($request->keyword) {
            $sections = $sections->search($request->keyword);
        }

        $students = CourseStudent::where('course_id', $request->id)->get();

        if ($request->has('study_date_from') && $request->has('study_date_to')) {
            $study_date_from = $request->input('study_date_from');
            $study_date_to = $request->input('study_date_to');
            $sections = $sections->filterByStudyDate($study_date_from, $study_date_to);
        }

        if ($request->statusSection == 'studied') {
            $sections->whichStudied();
        } elseif ($request->statusSection == 'unstudied') {
            $sections->whichUnStudied();
        }

        if ($request->has('types')) {
            $sections = $sections->filterByTypes($request->types);
        }

        $sortColumn = $request->sort_by ?? 'study_date';
        $sortDirection = $request->sort_direction ?? 'asc';
        // sort
        $sections = $sections->orderBy($sortColumn, $sortDirection);

        // pagination
        $sections = $sections->paginate($request->per_page ?? '20');
        //
        return view('student.courses.sectionList', [
            'sections' => $sections,
            'students' => $students,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function reschedulePopup(Request $request, $id)
    {
        $section = Section::find($request->id);
        $sectionAll = Section::where('course_id', $section->course->id)
            ->whereDate('study_date', '>', now()->toDateString())->active()->get();
        $students = CourseStudent::where('course_id', $request->id)->get();

        return view('student.courses.reschedulePopup', [
            'sectionAll' => $sectionAll,
            'students' =>   $students,
            'section' => $section
        ]);
    }

    public function updateSchedulePopup(Request $request, $id)
    {
        $section = Section::find($id);
        $sectionAll = Section::where('course_id', $section->course->id)->get();
        $students = CourseStudent::where('course_id', $id)->get();
        $errors = $section->saveFromRequest($request->all());

        if (!empty($errors)) {
            return response()->view('student.courses.reschedulePopup', [
                'section' => $section,
                'errors' => $errors,
                'sectionAll' => $sectionAll,
                'students' => $students,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã chuyển buổi học thành công',
            'id' => $section->id,
        ]);
    }

    public function attendancePopup(Request $request, $id)
    {
        $section = Section::find($request->id);
        $studentSection = new StudentSection(); // Tạo một đối tượng StudentSection
        $students = $studentSection->getAttendance($section)->get();

        return view('student.courses.attendancePopup', [
            'students' =>   $students,
            'section' => $section
        ]);
    }

    public function saveAttendancePopup(Request $request, $id)
    {
        $attendance = Attendance::newDefault();
        $attendance->updateFromRequest($request, $id);

        return response()->json([
            'status' => 'success',
            'message' => 'Điểm danh thành công!'
        ]);
    }

    public function courseStopped(Request $request)
    {
        $course = Course::find($request->id);

        return view('student.courses.courseStopped', [
            'course' => $course
        ]);
    }

    public function doneCourseStopped(Request $request)
    {
        $course = Course::find($request->course_id);
        $stoppedAt = $request->stopped_at;

        try {
            //
            $course->courseStopped($course, $stoppedAt);
        } catch (\Exception $e) {

            // after
            return response()->json([
                "message" => "Dừng lớp bị lỗi. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Dừng lớp thành công"
        ], 200);
    }

    public function suggestTeacher(Request $request)
    {
        $subjects = Subject::all();

        return view('student.courses.suggest_teacher', [
            'subjects' => $subjects
        ]);
    }

    public function getPayrateTeachers(Request $request)
    {
        $payrates = collect();

        if ($request->subject_id) {
            $subjectId = $request->subject_id;
            $payrates = Payrate::subjectTeachers($subjectId)->whereDate('effective_date', '<=', now())->get();
        }

        $studentsData = $payrates->map(function ($payrate) {
            return [
                'amount' => $payrate->amount,
                'name' => $payrate->teacher->name,
                'vn_teaching_hour' => $payrate->teacher->type == Teacher::TYPE_VIETNAM ? $payrate->amount : '--',
                'foreign_teaching_hour' => $payrate->teacher->type == Teacher::TYPE_FOREIGN ? $payrate->amount : '--',
                'tutor_teaching_hour' => $payrate->teacher->type == Teacher::TYPE_TUTOR ? $payrate->amount : '--',
            ];
        });

        return response()->json($studentsData);
    }


    public function getSubjects(Request $request)
    {
        $subjects = Subject::getSubjectsByType($request->type);
        $subjectData = $subjects->map(function ($subject) {
            return [
                'id' => $subject->id,
                'name' => $subject->name,
            ];
        });

        return response()->json($subjectData);
    }

    public function getZoomMeetingLink(Request $request)
    {
        $data = ZoomMeeting::create($request);
        $dataReturn = [
            'startUrl' => $data['data']['start_url'],
            'joinUrl' => $data['data']['join_url'],
            'password' => $data['data']['password']
        ];

        return $dataReturn;
    }

    // Lớp học
    public function class(Request $request)
    {
        $contact = $request->user()->getStudent();
        $accounts = Account::sales()->get();
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $contact->id)->get();
        $sectionStudents = StudentSection::where('student_id', $contact->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds)->today()->get(); 
        $sectionsInComing = $sections->take(1);

        return view('student.edu.courses.class', [
            'contact' => $contact,
            'accounts' => $accounts,
            'orderItems' => $orderItems,
            'courseStudents' => $courseStudents,
            'sectionsInComing' => $sectionsInComing,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'duration_each_lesson', 'title' => trans('messages.courses.duration_each_lesson'), 'checked' => true],
                ['id' => 'max_students', 'title' => trans('messages.courses.max_students'), 'checked' => true],
                ['id' => 'joined_students', 'title' => trans('messages.courses.joined_students'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }

    public function classList(Request $request)
    {
        $contact = $request->user()->getStudent();
        $query = CourseStudent::where('student_id', $contact->id)->leftJoin('courses', 'course_student.course_id', '=', 'courses.id');

        if ($request->keyword) {
            $query = $query->search($request->keyword);
        }

        if ($request->teachers) {
            $query = $query->filterByTeachers($request->teachers);
        }

        if ($request->subjects) {
            $query = $query->filterBySubjects($request->subjects);
        }

        if ($request->has('start_at_from') && $request->has('start_at_to')) {
            $start_at_from = $request->input('start_at_from');
            $start_at_to = $request->input('start_at_to');
            $query = $query->filterByStartAt($start_at_from, $start_at_to);
        }

        if ($request->has('end_at_from') && $request->has('end_at_to')) {
            $end_at_from = $request->input('end_at_from');
            $end_at_to = $request->input('end_at_to');
            $query = $query->filterByEndAt($end_at_from, $end_at_to);
        }

        $sortColumn = $request->sort_by ?? 'start_at';
        $sortDirection = $request->sort_direction ?? 'asc';

        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $courseStudents = $query->paginate($request->per_page ?? '20');

        return view('student.edu.courses.classList', [
            'courseStudents' => $courseStudents,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    // Hoàn phí
    public function refund(Request $request)
    {
        $contact = $request->user()->getStudent();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $contact->id)->get();

        return view('student.edu.courses.refund', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'duration_each_lesson', 'title' => trans('messages.courses.duration_each_lesson'), 'checked' => true],
                ['id' => 'max_students', 'title' => trans('messages.courses.max_students'), 'checked' => true],
                ['id' => 'joined_students', 'title' => trans('messages.courses.joined_students'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }

    public function refundList(Request $request)
    {
        $contact = $request->user()->getStudent();
        $query = RefundRequest::where('student_id',  $contact->id);

        // if ($request->keyword) {
        //     $query = $query->search($request->keyword);
        // }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'asc';

        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $requests = $query->paginate($request->per_page ?? '20');

        return view('student.edu.courses.refundList', [
            'requests' => $requests,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }

    // Bảo lưu
    public function reserveStudent(Request $request)
    {
        $contact = $request->user()->getStudent();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $contact->id)->get();

        return view('student.edu.courses.reserveStudent', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'duration_each_lesson', 'title' => trans('messages.courses.duration_each_lesson'), 'checked' => true],
                ['id' => 'max_students', 'title' => trans('messages.courses.max_students'), 'checked' => true],
                ['id' => 'joined_students', 'title' => trans('messages.courses.joined_students'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }

    public function reserveList(Request $request)
    {
        $contact = $request->user()->getStudent();
        $reserves = Reserve::getReserveByContact($contact->id);
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $reserves = $reserves->orderBy($sortColumn, $sortDirection);
        $reserves = $reserves->paginate($request->per_page ?? '20');

        return view('student.edu.courses.reserveList', [
            'reserves' => $reserves,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    //Chuyển phí
    public function transfer(Request $request)
    {
        $contact = $request->user()->getStudent();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $contact->id)->get();

        return view('student.edu.courses.transfer', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'duration_each_lesson', 'title' => trans('messages.courses.duration_each_lesson'), 'checked' => true],
                ['id' => 'max_students', 'title' => trans('messages.courses.max_students'), 'checked' => true],
                ['id' => 'joined_students', 'title' => trans('messages.courses.joined_students'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }

    public function transferList(Request $request)
    {
        $contact = $request->user()->getStudent();
        $transfers = OrderItem::getOrderItemTransferListByContact($contact->id);

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $transfers = $transfers->orderBy($sortColumn, $sortDirection);
        $transfers = $transfers->paginate($request->per_page ?? '20');
        //
        return view('student.edu.courses.transferList', [
            'transfers' => $transfers,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }
    public function reportsection(Request $request)
    {
        $contact = $request->user()->getStudent();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $contact->id)->get();
       
        return view('student.courses.reportSectionSelect', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'columns' => [
                ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
                ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => true],
                ['id' => 'duration_each_lesson', 'title' => trans('messages.courses.duration_each_lesson'), 'checked' => true],
                ['id' => 'max_students', 'title' => trans('messages.courses.max_students'), 'checked' => true],
                ['id' => 'joined_students', 'title' => trans('messages.courses.joined_students'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false]
            ]
        ]);
    }

    // public function transferList(Request $request)
    // {
    //     $contact = $request->user()->getStudent();
    //     $transfers = OrderItem::getOrderItemTransferListByContact($contact->id);

    //     $sortColumn = $request->sort_by ?? 'updated_at';
    //     $sortDirection = $request->sort_direction ?? 'desc';

    //     $transfers = $transfers->orderBy($sortColumn, $sortDirection);
    //     $transfers = $transfers->paginate($request->per_page ?? '20');
    //     //
    //     return view('student.edu.courses.transferList', [
    //         'transfers' => $transfers,
    //         'contact' => $contact,
    //         'columns' => $request->columns ?? [],
    //         'sortColumn' => $sortColumn,
    //         'sortDirection' => $sortDirection,

    //     ]);
    // }
    
}
