<?php

namespace App\Http\Controllers\Abroad;

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
use App\Models\OrderItem;
use App\Events\NewCourseCreated;
use App\Events\NewAbroadCourseCreated;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::abroad()->with('teacher')->get();
        $listViewName = 'edu.course';
        $columns = [
            ['id' => 'class_code', 'title' => trans('messages.class.class_code'), 'checked' => true],
            ['id' => 'class_code_old', 'title' => trans('messages.class.class_code_old'), 'checked' => true],
            
            ['id' => 'order_code', 'title' => trans('messages.class.order_code'), 'checked' => true],
            ['id' => 'student', 'title' => trans('messages.class.student'), 'checked' => true],
            ['id' => 'abroad_service_id', 'title' => trans('messages.courses.abroad_service_id'), 'checked' => true],
            ['id' => 'end_time', 'title' => trans('messages.courses.end_time'), 'checked' => true],
            ['id' => 'study_method', 'title' => trans('messages.courses.study_method'), 'checked' => true],
            ['id' => 'branch', 'title' => trans('messages.courses.branch'), 'checked' => true],
            ['id' => 'location', 'title' => trans('messages.courses.location'), 'checked' => true],
            ['id' => 'teachers', 'title' => trans('messages.courses.teachers'), 'checked' => true],
            ['id' => 'class_room', 'title' => trans('messages.courses.class_room'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
            ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false],
            ['id' => 'class_schedule', 'title' => trans('messages.class.class_schedule'), 'checked' => true],

        ];

        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('abroad.courses.index', [
            'courses' => $courses,
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = Course::abroad()->with('teacher')->with('subject')->byBranch(\App\Library\Branch::getCurrentBranch());

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->has('subjects')) {
            $query = $query->filterByAbroadServices($request->subjects);
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

        return view('abroad.courses.list', [
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

    /**
     * Delete all courses which have selected
     */
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

    /**
     * Show screen create new course
     */
    public function add(Request $request)
    {
        $courseCopy = null;

        if (isset($request->courseCopyId)) {
            $courseCopy =  Course::find($request->courseCopyId);

            if (!$courseCopy) {
                throw new Error("Not found course to copy!");
            }
        }

        $zoomUsers = \App\Models\ZoomUser::all();

        return view('abroad.courses.add', [
            'action' => 'add',  
            'sections' => $courseCopy ? $courseCopy->sections : null,
            'courseCopy' => $courseCopy,
            'zoomUsers' => $zoomUsers->toArray()
        ]);
    }

    /**
     * Store new course
     */
    public function create(Request $request)
    {
        $course = Course::newDefault();
        $errors = $course->saveFromRequest($request);
        parse_str($request->form, $formReturn);

        $zoomUsers = \App\Models\ZoomUser::all();

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses._form', [
                'errors' => $errors,
                'course' => $course,
                'action' => 'add',
                'branch' => isset($formReturn['branch']) ? $formReturn['branch'] : '',
                'order_item' => isset($formReturn['order_item']) ? $formReturn['order_item'] : null,
                'zoomUsers' => $zoomUsers->toArray(),
                'formReturn' => $formReturn,
            ], 400);
        }

        $course->generateCodeName();

        NewCourseCreated::dispatch($course);
        NewAbroadCourseCreated::dispatch($course);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới lớp du học thành công!'
        ]);
    }

    /**
     * Show screen edit schedule of course
     */
    public function edit(Request $request)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)
            ->isNotDestroy()
            ->get();

        $zoomUsers = \App\Models\ZoomUser::all();
        // Have to check is this course using zoom user to generate zoom links
        $isUsingZoomUser = $course->isUsingZoomUserToGenerateLinks();

        return view('abroad.courses.edit', [
            'course' => $course,
            'sections' => $sections,
            'action' => 'edit',
            'isUsingZoomUser' => $isUsingZoomUser
        ]);
    }

    /**
     * Update schedule of course
     */
    public function editCalendar(Request $request)
    {
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)
            ->isNotDestroy()
            ->get();

        $zoomUsers = \App\Models\ZoomUser::all();
        $isUsingZoomUser = $course->isUsingZoomUserToGenerateLinks();

        return view('abroad.courses.editCalendar', [
            'course' => $course,
            'action' => 'edit',
            'sections' => $sections,
            'zoomUsers' => $zoomUsers->toArray(),
            'isUsingZoomUser' => $isUsingZoomUser
        ]);
    }

    /**
     * Update course sections data
     */
    public function updateCalendar(Request $request)
    {
        $course = Course::find($request->id);
        $errors = $course->saveFromRequest($request);
        parse_str($request->form, $formReturn);
        $zoomUsers = \App\Models\ZoomUser::all();

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses._form', [
                'errors' => $errors,
                'course' => $course,
                'action' => 'edit',
                'branch' => isset($formReturn['branch']) ? $formReturn['branch'] : '',
                'order_item' => isset($formReturn['order_item']) ? $formReturn['order_item'] : null,
                'zoomUsers' => $zoomUsers->toArray(),
                'formReturn' => $formReturn,
            ], 400);
            // return response()->view('abroad.courses.editCalendar', [
            //     'errors' => $errors,
            //     'course' => $course
            // ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thời khóa biểu thành công!'
        ]);
    }

    /**
     * Update a course data
     */
    public function update(Request $request)
    {
        $course = Course::find($request->id);
        $errors = $course->updateFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses.edit', [
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

    /**
     * Show course data in detail view
     */
    public function showDetail(Request $request, $id)
    {
        $course = Course::find($id);

        return view('abroad.courses.showDetail', [
            'course' => $course,

        ]);
    }

    /**
     * Show all course students
     */
    public function students(Request $request, $id)
    {
        $course = Course::find($id);
        $students = CourseStudent::rightJoin('contacts', 'course_student.student_id', '=', 'contacts.id')->where('course_id', $request->id)->get();

        return view('abroad.courses.students', [
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

        return view('abroad.courses.studentList', [
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

        return view('abroad.courses.schedule', [
            'course' => $course,
            'sections' => $sections
        ]);
    }

    public function addSchedule(Request $request)
    {
        // if (is_null($request->subject_id)) {
        //     throw new \Exception("Error: Invalid subject id!");
        // } 

        // if (is_null($request->area)) {
        //     throw new \Exception("Error: Invalid branch");
        // }

        return view('abroad.courses.addSchedule', [
            'day_name' => $request->day_name,
            // 'subject_id' => $request->subject_id,
            // 'area' => $request->area
        ]);
    }

    public function createScheduleItem(Request $request)
    {
        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses.addSchedule', [
                "errors" => $errors,
                "schedule" => $schedule,
                // "subject_id" => $request->subject_id,
                // 'area' => $request->area
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
        // if (is_null($request->subject_id)) {
        //     throw new \Exception("Error: Invalid subject id!");
        // } 

        // if (is_null($request->area)) {
        //     throw new \Exception("Error: Invalid branch");
        // }

        $weekEventEdit = $request->all();

        return view('abroad.courses.addSchedule', [
            'weekEventEdit' => $weekEventEdit,
            'day_name' => $request->dayName,
            // 'subject_id' => $request->subject_id,
            // 'area' => $request->area
        ]);
    }

    public function editWeekScheduleItem(Request $request)
    {
        // if (is_null($request->subject_id)) {
        //     throw new \Exception("Error: Invalid subject id!");
        // } 

        // if (is_null($request->area)) {
        //     throw new \Exception("Error: Invalid branch");
        // }

        $errors = Course::validateScheduleItemsFromRequest($request);
        $weekEventEdit = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses.addSchedule', [
                "errors" => $errors,
                "weekEventEdit" => $weekEventEdit,
                'day_name' => $request->day_name,
                // 'subject_id' => $request->subject_id,
                // 'area' => $request->area
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

        return view('abroad.courses.sections', [
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
        return view('abroad.courses.sectionList', [
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

        return view('abroad.courses.reschedulePopup', [
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
        $errors = $section->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            // $zoomUsers = \App\Models\ZoomMeeting::listUsers();
                $zoomUsers = \App\Models\ZoomUser::all();

            return response()->view('abroad.courses.reschedulePopup', [
                'section' => $section,
                'errors' => $errors,
                'sectionAll' => $sectionAll,
                'students' => $students,
                'zoomUsers' => $zoomUsers->toArray(),  
                'switch' => isset($request->zoom_switch) && $request->zoom_switch == "on" ? true : false,
                'zoomUserId' => isset($request->zoom_user_id) ? $request->zoom_user_id : null,
                'zoomStartLink' => isset($request->zoom_start_link) ? $request->zoom_start_link : null,
                'zoomJoinLink' => isset($request->zoom_join_link) ? $request->zoom_join_link : null,
                'zoomPassword' => isset($request->zoom_password) ? $request->zoom_password : null,
            ], 400);
        }

        if ($request['zoom_user_id']) {
            $section->generateZoomLinks($request['zoom_user_id']);
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

        return view('abroad.courses.attendancePopup', [
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

        return view('abroad.courses.courseStopped', [
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

        return view('abroad.courses.suggest_teacher', [
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

    public function assignStudentToClass(Request $request)
    {

        $course_id = $request->id;
        $course = Course::find($course_id);

        $orderItems = OrderItem::getOrderItemByCourse($course);


        return view('abroad.courses.assignStudentToClass', [
            'orderItems' => $orderItems,
            'course' => $course
        ]);
    }

    public function doneAssignStudentToClass(Request $request)
    {
        $orderItemIds = $request->order_item_ids;

        foreach ($orderItemIds as $orderItemId) {
            $requestData = $request->all();
            $orderItem = OrderItem::find($orderItemId);
            $studentId =  $orderItem->order->student->id;
            $courseId = $request->course_id;
            $studentName = Contact::find($studentId)->name;
            $class = Course::find($courseId)->code;
            $start_at = Course::find($courseId)->start_at;
            $start_at = new \DateTime($start_at);
            $start_at = $start_at->format('d/m/Y');
            $end_at = Course::find($courseId)->end_at;
            $end_at = new \DateTime($end_at);
            $end_at = $end_at->format('d/m/Y');

            // Xếp học viên vào lớp học
            $student = Contact::find($studentId);
            $course = Course::find($courseId);
            $sectionIds = $course->getSectionIds();
            //thử nghiệm
            $assignment_date = $request->assignment_date;
            
            // $student->checkHourSectionsChecked($sectionIds, $orderItem);
            try {
                //thử nghiệm
                $student->assignCourse($course, $orderItem,$assignment_date ); // xếp lớp phải thông qua hợp đồng

                // add note log. @todo Event: CourseStudentAssigned
                $student->addNoteLog(
                    $request->user()->account,
                    "Đã được xếp vào lớp [" . $course->code . "] theo hợp đồng [" . $orderItem->orders->code . "]"
                );
            } catch (\Exception $e) {

                // after
                return response()->json([
                    "message" => "Xếp lớp không thành công. Lỗi: " . $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            "message" => "Xếp lớp thành công "
        ], 200);
    }

    public function copy(Request $request) 
    {
        $course = Course::find($request->id);

        if (!$course) {
            throw new \Exception("Error: Not found course to copy!");
        }

        return view('abroad.courses.add', [
            'action' => 'add'
        ]);
    }
}
