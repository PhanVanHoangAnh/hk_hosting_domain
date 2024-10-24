<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\DB;

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
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Contact;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Role;
use App\Events\NewCourseCreated;
use App\Events\UpdateReschedule;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::edu()->with('teacher')->get();
        $listViewName = 'student.course';
        $columns = [
            ['id' => 'training_location_id', 'title' => trans('messages.courses.training_location_id'), 'checked' => true],
            ['id' => 'location', 'title' => trans('messages.courses.location'), 'checked' => true],
            ['id' => 'class_code', 'title' => trans('messages.class.class_code'), 'checked' => true],
            ['id' => 'class_code_old', 'title' => trans('messages.class.class_code_old'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.courses.status'), 'checked' => true],
            ['id' => 'subject_id', 'title' => trans('messages.courses.subject_id'), 'checked' => true],
            ['id' => 'level', 'title' => trans('messages.courses.level'), 'checked' => true],
            ['id' => 'study_method', 'title' => trans('messages.courses.study_method'), 'checked' => true],
            ['id' => 'number_students', 'title' => trans('messages.courses.number_students'), 'checked' => true],

            ['id' => 'total_hours_vn', 'title' => trans('messages.courses.total_hours_vn'), 'checked' => true],
            ['id' => 'total_hours_foreign', 'title' => trans('messages.courses.total_hours_foreign'), 'checked' => true],
            ['id' => 'total_hours_tutor', 'title' => trans('messages.courses.total_hours_tutor'), 'checked' => true],
            ['id' => 'total_hours_assistant', 'title' => trans('messages.courses.total_hours_assistant'), 'checked' => true],

            ['id' => 'total_hours', 'title' => trans('messages.courses.total_hours'), 'checked' => true],
            ['id' => 'suitable_students', 'title' => trans('messages.courses.suitable_students'), 'checked' => true],

            ['id' => 'stopped_at', 'title' => trans('messages.class.stopped_at'), 'checked' => false],

            ['id' => 'assistant', 'title' => trans('messages.class.assistant'), 'checked' => false],
            ['id' => 'start_at', 'title' => trans('messages.courses.start_at'), 'checked' => false],
            ['id' => 'end_at', 'title' => trans('messages.courses.end_at'), 'checked' => false],

            ['id' => 'test_hours', 'title' => trans('messages.courses.test_hours'), 'checked' => false],
            ['id' => 'studied_hours', 'title' => trans('messages.courses.studied_hours'), 'checked' => false],
            ['id' => 'remain_hours', 'title' => trans('messages.courses.remain_hours'), 'checked' => false],
            ['id' => 'teacher_id', 'title' => trans('messages.courses.teacher_id'), 'checked' => false],
            ['id' => 'class_type', 'title' => trans('messages.courses.class_type'), 'checked' => false],

            ['id' => 'min_students', 'title' => trans('messages.courses.min_students'), 'checked' => false],
            ['id' => 'order_date', 'title' => trans('messages.courses.order_date'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.courses.created_at'), 'checked' => false],
            ['id' => 'updated_at', 'title' => trans('messages.courses.updated_at'), 'checked' => false],
        ];
        //
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('student.courses.index', [
            'courses' => $courses,
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->with('teacher')->with('subject');
        // if ($request->user()->can('changeBranch', User::class) || !$request->user()->account->teacher) {
        //     $query = Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->with('teacher')->with('subject');
        
        // }
        // else{
        //     $query = $request->user()->account->getCoursesForUser();
        // }
        
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

        if ($request->locations) {
            $query = $query->filterByLocations($request->locations);
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

        DB::beginTransaction();

        try {
            if ($course->study_method === Course::STUDY_METHOD_ONLINE) {
                $course->removeAllZoomMeetings();
            }

            // Before delete, check zoom meeting and delete all zoom meeting currently existing
            $course->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return response()->json([
            "status" => "Success",
            "message" => "Xóa khóa học thành công!"
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

        return view('student.courses.edit', [
            'course' => $course,
            'sections' => $sections,
            'action' => 'edit'
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
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        $courseCopy = null;

        if (isset($request->courseCopyId)) {
            $courseCopy =  Course::find($request->courseCopyId);

            if (!$courseCopy) {
                throw new Error("Not found course to copy!");
            }
        }

        $zoomUsers = \App\Models\ZoomUser::all();

        return view('student.courses.add', [
            'action' => 'add',
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

        if (!$errors->isEmpty()) {
            $availableZoomUsers = \App\Models\Section::getAvailableZoomUserFromArrayOfEvents(json_decode($request->events, true));

            return response()->view('student.courses._form', [
                'errors' => $errors,
                'course' => $course,
                'action' => 'add',
                'branch' => isset($formReturn['branch']) ? $formReturn['branch'] : '',
                'formReturn' => $formReturn,
                'zoomUsers' => $availableZoomUsers
            ], 400);
        }

        $course->generateCodeName();

        // Events
        NewCourseCreated::dispatch($course);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới khóa học thành công!'
        ]);
    }

     /**
     * Update schedule of course
     */
    public function editCalendar(Request $request)
    {
        set_time_limit(0);
        $course = Course::find($request->id);
        $sections = Section::where('course_id', $request->id)
            ->isNotDestroy()
            ->get();

        $zoomUsers = \App\Models\ZoomUser::all();

        // Have to check is this course using zoom user to generate zoom links
        $isUsingZoomUser = $course->isUsingZoomUserToGenerateLinks();
        
        return view('student.courses.editCalendar', [
            'action' => 'edit',
            'course' => $course,
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
        // $errors = $course->saveEventsFromRequest($request);
        $errors = $course->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            $availableZoomUsers = [];
            
            if ($course->study_method === \App\Models\Course::STUDY_METHOD_ONLINE) {
                $eventsInput = json_decode($request->events, true); // Array
                $eventsWithoutId = array_filter($eventsInput, function($event) {
                    return !isset($event['id']);
                });
                $availableZoomUsers = \App\Models\Section::getAvailableZoomUserFromArrayOfEvents($eventsWithoutId);
            }

            parse_str($request->form, $form);

            $isUsingZoomUser = $course->isUsingZoomUserToGenerateLinks();

            return response()->view('student.courses._form_edit_calendar', [
                'action' => 'edit',
                'errors' => $errors,
                'course' => $course,
                'zoomUserId' => isset($form['zoom_user_id']) && $form['zoom_user_id'] ? $form['zoom_user_id'] : null,
                'zoomUsers' => $availableZoomUsers,
                'isUsingZoomUser' => $isUsingZoomUser
            ], 400);
        }

        $course->updateStudentDataExistingInCourseForAllSections();

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

    /**
     * Show course data in detail view
     */
    public function showDetail(Request $request, $id)
    {
        $course = Course::find($id);

        return view('student.courses.showDetail', [
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
        if (is_null($request->subject_id)) {
            throw new \Exception("Error: Invalid subject id!");
        } 

        if (is_null($request->area)) {
            throw new \Exception("Error: Invalid branch");
        }

        return view('student.courses.addSchedule', [
            'day_name' => $request->day_name,
            'subject_id' => $request->subject_id,
            'area' => $request->area
        ]);
    }

    public function createScheduleItem(Request $request)
    {
        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('student.courses.addSchedule', [
                "errors" => $errors,
                "schedule" => $schedule,
                "subject_id" => $request->subject_id,
                'area' => $request->area
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
        if (is_null($request->subject_id)) {
            throw new \Exception("Error: Invalid subject id!");
        } 

        if (is_null($request->area)) {
            throw new \Exception("Error: Invalid branch");
        }

        $weekEventEdit = $request->all();

        return view('student.courses.addSchedule', [
            'weekEventEdit' => $weekEventEdit,
            'day_name' => $request->dayName,
            'subject_id' => $request->subject_id,
            'area' => $request->area
        ]);
    }

    public function editWeekScheduleItem(Request $request)
    {
        if (is_null($request->subject_id)) {
            throw new \Exception("Error: Invalid subject id!");
        } 

        if (is_null($request->area)) {
            throw new \Exception("Error: Invalid branch");
        }

        $errors = Course::validateScheduleItemsFromRequest($request);
        $weekEventEdit = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('student.courses.addSchedule', [
                "errors" => $errors,
                "weekEventEdit" => $weekEventEdit,
                'day_name' => $request->day_name,
                'subject_id' => $request->subject_id,
                'area' => $request->area
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
        set_time_limit(0);
        $section = Section::find($request->id);
        $sectionAll = Section::where('course_id', $section->course->id)
            ->whereDate('study_date', '>', now()->toDateString())->active()->get();
        // $sectionAll = Section::where('course_id', $section->course->id)->get();
        $students = CourseStudent::where('course_id', $request->id)->get();
        $zoomUsers = \App\Models\ZoomUser::all();
        

        return view('student.courses.reschedulePopup', [
            'sectionAll' => $sectionAll,
            'students' => $students,
            'section' => $section,
            'zoomUsers' => $zoomUsers->toArray(),
        ]);
    }

    public function updateSchedulePopup(Request $request, $id)
    {
        set_time_limit(0);
        $section = Section::find($id);
        $sectionCurrent = Section::find($id);
        $sectionAll = Section::where('course_id', $section->course->id)->get();
        $students = CourseStudent::where('course_id', $id)->get();
        $errors = $section->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            
            $zoomUsers = \App\Models\ZoomUser::all();

            return response()->view('student.courses.reschedulePopup', [
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

        UpdateReschedule::dispatch( $sectionCurrent, $section);
        
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
        set_time_limit(0);
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


        return view('student.courses.assignStudentToClass', [
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

        return view('student.courses.add', [
            'action' => 'add'
        ]);

        // $newCourse = new Course();

        // $newCourse->copyFrom($course);

        // if ($newCourse) {
        //     return response()->json([
        //         'status' => 'success',
        //         'messages' => 'Sao chép lớp học thành công!!',
        //     ], 200);
        // }

        // return response()->json([
        //     'status' => 'fail',
        //     'messages' => 'Sao chép lớp học thất bại!',
        // ], 500);
    }

    public function export(Request $request)
    {
        $courses = Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->with('teacher')->with('subject');
        // if ($request->user()->can('changeBranch', User::class) || !$request->user()->account->teacher) {
        //     $courses = Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->with('teacher')->with('subject');
        // }
        // else{
        //     $courses = $request->user()->account->getCoursesForUser();
        // }
        
        if ($request->key) {
            $courses = $courses->search($request->key);
        }

        if ($request->maxStudents) {
            $courses = $courses->filterByMaxStudents($request->maxStudents);
        }

        if ($request->teachers) {
            $courses = $courses->filterByTeachers($request->teachers);
            
        }

        if ($request->subjects) {
            $courses = $courses->filterBySubjects($request->subjects);
        }

        if ($request->classRoom) {
            $courses =  $courses->filterByClassRoom($request->classRoom);
        }

        if ($request->locations) {
            $courses = $courses->filterByLocations($request->locations);
        }

        if ($request->has('start_at_from') && $request->has('start_at_to')) {
            $start_at_from = $request->input('start_at_from');
            $start_at_to = $request->input('start_at_to');
            $courses = $courses->filterByStartAt($start_at_from, $start_at_to);
        }

        if ($request->has('end_at_from') && $request->has('end_at_to')) {
            $end_at_from = $request->input('end_at_from');
            $end_at_to = $request->input('end_at_to');
            $courses = $courses->filterByEndAt($end_at_from, $end_at_to);
        }
        
        if ($request->has('status')) {
            if ($request->status == Course::OPENING_STATUS) {
                $courses = $courses->getIsLearning();
            } elseif ($request->status == Course::COMPLETED_STATUS) {
                $courses = $courses->getIsStudied();
            } elseif ($request->status == Course::WAITING_OPEN_STATUS) {
                $courses = $courses->getIsUnstudied();
            } elseif ($request->status == Section::STATUS_STOPPED) {
                $courses = $courses->getStoppedClass();
            };
        }

        // $courses = $courses->orderBy('updated_at', 'desc')->get();
        // $courses = $courses->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'NGÀY TẠO KHÓA HỌC',
            'ĐỊA ĐIỂM HỌC',
            'MÃ LỚP HỌC',
            'MÃ LỚP CŨ',
            'HÌNH THỨC HỌC',
            'NGÀY CẬP NHẬT KHÓA HỌC',
            'CHI NHÁNH',
            'TRẠNG THÁI',
            'TÊN MÔN HỌC',
            'TRÌNH ĐỘ',
            'SÔ LUỌNG HỌC VIÊN',
            'SỐ LƯỢNG HỌC VIÊN TỐI THIỂU',
            'GIỜ DẠY GVVN',
            'GIỜ DẠY GVNN',
            'GIỜ DẠY GIA SƯ',
            'GIỜ DẠY TRỢ GIẢNG',
            'TỔNG GIỜ HỌC',
            'TỔNG GIỜ KIỂM TRA',
            'GIỜ ĐÃ HỌC',
            'GIỜ CHƯA HỌC',
            'HỌC VIÊN PHÙ HỢP',
            'THỜI GIAN DỪNG LỚP',
            'TRỢ GIẢNG',
            'THỜI GIAN BẮT ĐẦU',
            'THỜI GIAN KẾT THÚC',
            'GIÁO VIÊN CHỦ NHIỆM',
            'HÌNH THỨC HỌC',
        ];
        
        $column = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }

        $row = 2; 

        foreach ($courses->get() as $course) {
            $assistants = $course->getAssistants();
            $assistantNames = '';

            foreach ($assistants as $assistant) {
                if (isset($assistant->name)) {
                    $assistantNames .= '- ' . $assistant->name . "\n";
                }
            }
            $assistantNames = rtrim($assistantNames, "\n");

            $sheet->setCellValue('A' . $row, $course->created_at ? \Carbon\Carbon::parse($course->created_at)->format('d/m/Y') : '');
            $sheet->setCellValue('B' . $row, $course->training_location_id ? \App\Models\TrainingLocation::find($course->training_location_id)->name : "--");
            $sheet->setCellValue('C' . $row, $course->code);
            $sheet->setCellValue('D' . $row, $course->import_id);
            $sheet->setCellValue('E' . $row, $course->study_method ?? '--');
            $sheet->setCellValue('F' . $row, $course->updated_at ? \Carbon\Carbon::parse($course->updated_at)->format('d/m/Y') : '');
            $sheet->setCellValue('G' . $row, $course->training_location_id ? trans('messages.training_locations.' . \App\Models\TrainingLocation::find($course->training_location_id)->branch) : "");
            $sheet->setCellValue('H' . $row, $course->checkStatusSubject());
            $sheet->setCellValue('I' . $row, $course->subject->name ?? '');

            $sheet->setCellValue('J' . $row, $course->level ?? '--');
            $sheet->setCellValue('K' . $row, $course->countStudentsByCourse() . ' / ' . $course->max_students);
            $sheet->setCellValue('L' . $row, $course->min_students ?? '--');
            $sheet->setCellValue('M' . $row, number_format($course->getTotalMinutesOfTeacher('VNTeacher') / 60, 2) . ' giờ');

            $sheet->setCellValue('N' . $row, number_format($course->getTotalMinutesOfTeacher('ForeignTeacher') / 60, 2) . ' giờ');
            $sheet->setCellValue('O' . $row, number_format($course->getTotalMinutesOfTeacher('Tutor') / 60, 2) . ' giờ');
            $sheet->setCellValue('P' . $row, number_format($course->getTotalMinutesOfTeacher('Assistant') / 60, 2) . ' giờ');
            $sheet->setCellValue('Q' . $row, $course->total_hours . ' giờ');
            $sheet->setCellValue('R' . $row, $course->test_hours . ' giờ');
            $sheet->setCellValue('S' . $row, number_format($course->getStudiedHoursForCourse(), 2) . ' giờ');
            $sheet->setCellValue('T' . $row, number_format($course->getTotalStudyHoursForCourse() - $course->getStudiedHoursForCourse(), 2) . ' giờ');
            $sheet->setCellValue('U' . $row, count(\App\Models\OrderItem::getOrderItemByCourse($course)) ?? 0);
            $sheet->setCellValue('V' . $row, $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->stop_at)->format('d/m/Y') : '--');
            $sheet->setCellValue('W' . $row, $assistantNames);
            $sheet->setCellValue('X' . $row, $course->start_at ? \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') : '');
            $sheet->setCellValue('Y' . $row, $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--');
            $sheet->setCellValue('Z' . $row, $course->teacher_id ? $course->teacher->name : '--');
            $sheet->setCellValue('AA' . $row, $course->class_type ? trans('messages.courses.class_type.' . $course->class_type) : '--');
            
            $row++; 
        }


        $fileName = 'courses.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
    
        
        return Response::download($tempFile, $fileName)->deleteFileAfterSend(true);
        }
    
    }
