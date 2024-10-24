<?php

namespace App\Http\Controllers\Edu;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\FreeTime;
use App\Models\FreeTimeRecord;
use App\Models\Payrate;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'edu.staff';
        $columns = [
            ['id' => 'id', 'title' => trans('messages.staffs.id'), 'checked' => true],
            ['id' => 'name', 'title' => trans('messages.staffs.name'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.staffs.type'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.staffs.status'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.staffs.email'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.staffs.phone'), 'checked' => true],
            ['id' => 'birthday', 'title' => trans('messages.staffs.birthday'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.staffs.created_at'), 'checked' => true],
            ['id' => 'updated_at', 'title' => trans('messages.staffs.updated_at'), 'checked' => true],
        ];
        //
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('edu.staffs.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = Teacher::byBranch(\App\Library\Branch::getCurrentBranch());

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if($request->staffTypes) {
            $query = $query->filterByStaffTypes($request->staffTypes);
        }

        if($request->statuses) {
            $query = $query->filterByStatuses($request->statuses);
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

        if($request->has('type')) {
            if ($request->type == Teacher::TYPE_VIETNAM) {
                $query = $query->isVietNam();
            } elseif ($request->type == Teacher::TYPE_FOREIGN) {
                $query = $query->isForeign();
            } elseif ($request->type == Teacher::TYPE_TUTOR) {
                $query = $query->isTutor();
            } elseif ($request->type == Teacher::TYPE_HOMEROOM) {
                $query = $query->isHomeRoom();
            }elseif ($request->type == Teacher::TYPE_ASSISTANT) {
                $query = $query->isAssistant();
            };
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $staffs = $query->paginate($request->perpage ?? 10);

        return view('edu.staffs.list', [
            'staffs' => $staffs,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function delete(Request $request)
    {
        $staff = Teacher::find($request->id);

        $staff->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Xóa nhân viên thành công!"
        ]);
    }

    public function deleteAll(Request $request) 
    {
        if(!empty($request->items)) {
            Teacher::deleteStaffs($request->items);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công các nhân sự!'
            ], 200); 
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không tìm thấy các nhân sự!'
        ], 400);
    }

    public function create(Request $request)
    {
        return view('edu.staffs.create');
    }

    public function store(Request $request)
    {
        $staff = Teacher::newDefault();
        $errors = $staff->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('edu.staffs.create', [
                'errors' => $errors,
                'staff' => $staff
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới nhân sự thành công!'
        ]);
    }

    public function show(Request $request, $id)
    {
       $teacher = Teacher::find($id);
       $courses = Course::where('teacher_id', $id)->get();
       $sectionCourses = Section::where(function($query) use ($id) {
        $query->where('vn_teacher_id', $id)
              ->orWhere('foreign_teacher_id', $id)
              ->orWhere('tutor_id', $id)
              ->orWhere('assistant_id', $id);
        })->distinct('course_id')->get(['course_id']);

        return view('edu.staffs.show', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
        ]);
    }

    public function busySchedule(Request $request, $id)
    {
       $teacher = Teacher::find($id);
       
        return view('edu.staffs.busy-schedule', [
            'teacher' => $teacher,
        ]);
    }

    public function showFreeTimeSchedule(Request $request)
    {
        $teacherId = $request->id;
        $teacher = Teacher::find($teacherId);
        $courses = Course::where('teacher_id', $teacherId)->get();
        $sectionCourses = Section::where(function($query) use ($teacherId) {
            $query->where('vn_teacher_id', $teacherId)
                  ->orWhere('foreign_teacher_id', $teacherId)
                  ->orWhere('tutor_id', $teacherId)
                  ->orWhere('assistant_id', $teacherId);
            })->distinct('course_id')->get(['course_id']);

        $busySchedule = json_decode($teacher->busy_schedule);

        return view('edu.staffs.busySchedule', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses,
            'busySchedule' => $busySchedule,
        ]);
    }

    public function showSchedule(Request $request)
    {
        $teacherId = $request->id;
        $teacher = Teacher::find($teacherId);
       
        return view('edu.staffs.show-busy-schedule', [
            'teacher' => $teacher,
        ]);
    }

    public function editBusySchedule(Request $request)
    {
        $freeTimeId = $request->id;
        $freeTime = FreeTime::find($freeTimeId);
        $teacher = Teacher::find($freeTime->teacher_id);
        $freeTimeRecords = $freeTime->freeTimeRecords;

        foreach (range(1, 7) as $dayOfWeek) {
            $eventsForDay = $freeTimeRecords->filter(function ($record) use ($dayOfWeek) {
                return $record->day_of_week == $dayOfWeek;
            })->map(function ($record) {
                
                $record->from = substr($record->from, 0, 5);
                $record->to = substr($record->to, 0, 5); 
                return $record;
            })->toArray();
           
            $sortedFreeTime[] = $eventsForDay;
        }

        return view('edu.staffs.edit-busy-schedule', [
            'freeTime' => $freeTime,
            'sortedFreeTime' => $sortedFreeTime,
            'teacher' => $teacher,
            'freeTimeRecords' => $freeTimeRecords
        ]);
    }
    
    public function updateBusySchedule(Request $request)
    {
        $freeTimeRecord = new FreeTimeRecord();
        $result = $freeTimeRecord->updateBusyScheduleFromRequest($request);

        if (!empty($result)) {
            return response()->json([
                'status' => 'error',
                'errors' => $result
            ], 400);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm lịch rảnh thành công'
        ], 200);
    }

    public function deleteFreeTime(Request $request, $id)
    {
        $freeTime = FreeTime::find($id);
        
        if (!$freeTime) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy ',
            ], 404);
        }
        
        FreeTimeRecord::where('free_time_id', $id)->delete();
        
        $freeTime->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa kết quả thành công',
        ]);
    }
    
    public function saveBusySchedule(Request $request, $id)
    {
        $freeTimeRecord = new FreeTimeRecord();
        $result = $freeTimeRecord->saveBusyScheduleFromRequest($request);
        
        if (!empty($result)) {
            return response()->json([
                'status' => 'error',
                'errors' => $result
            ], 400);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm lịch rảnh thành công'
        ], 200);
    }

    public function class(Request $request, $id)
    {
       $teacher = Teacher::find($id);
       $courses = Course::where('teacher_id', $id)->get();
       $sectionCourses = Section::where(function($query) use ($id) {
            $query->where('vn_teacher_id', $id)
                ->orWhere('foreign_teacher_id', $id)
                ->orWhere('tutor_id', $id)
                ->orWhere('assistant_id', $id);
        })->distinct('course_id')->get(['course_id']);
    
        return view('edu.staffs.class', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses,
            'columns' => [
                ['id' => 'code', 'title' => trans('messages.courses.code'), 'checked' => true],
                ['id' => 'class_code_old', 'title' => trans('messages.class.class_code_old'), 'checked' => true],
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

    public function classList(Request $request, $id)
    {
        $teacher = Teacher::find($id);
       
        if ($teacher->type !== Teacher::TYPE_HOMEROOM) {
            $sectionCourses = Section::where(function ($query) use ($id) {
                $query->where('vn_teacher_id', $id)
                ->orWhere('foreign_teacher_id', $id)
                ->orWhere('tutor_id', $id)
                ->orWhere('assistant_id', $id);
            })->distinct('course_id')->pluck('course_id');
    
            $query = Course::whereIn('id', $sectionCourses);
        } else {
            $query = Course::where('teacher_id', $id);
        }
        
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

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'asc';
   
        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $courses = $query->paginate($request->per_page ?? '20');
        //
        return view('edu.staffs.classList', [
            'courses' => $courses,
            'teacher' => $teacher,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function calendar(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        $courses = Course::where('teacher_id', $id)->get();
        $sectionCourses = Section::where(function($query) use ($id) {
            $query->where('vn_teacher_id', $id)
                  ->orWhere('foreign_teacher_id', $id)
                  ->orWhere('tutor_id', $id)
                  ->orWhere('assistant_id', $id);
        })->distinct('course_id')->get();

        foreach ($sectionCourses as $sectionCourse) {
            $sectionCourse->viewer = 'staff';
        }

        $freeTimeSections = $teacher->getFreeTimeSections();

        // event sections is all item of section courses and free time sections
        $eventSections = array_merge($sectionCourses->toArray(), $freeTimeSections);

        return view('edu.staffs.calendar', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses,
            'eventSections' => $eventSections
        ]);
    }

    public function teachingSchedule(Request $request, $id)
    {
       $teacher = Teacher::find($id);
       $courses = Course::where('teacher_id', $id)->get();
       $sectionCourses = Section::where(function($query) use ($id) {
            $query->where('vn_teacher_id', $id)
                ->orWhere('foreign_teacher_id', $id)
                ->orWhere('tutor_id', $id)
                ->orWhere('assistant_id', $id);
        })->distinct('course_id')->get(['course_id']);
    
        return view('edu.staffs.teachingSchedule', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
        ]);
    }

    public function teachingScheduleList(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        $sections = Section::where(function($query) use ($id) {
            $query->where('vn_teacher_id', $id)
                  ->orWhere('foreign_teacher_id', $id)
                  ->orWhere('tutor_id', $id)
                  ->orWhere('assistant_id', $id);
            });
        
        if ($request->keyword) {
            $sections = $sections->search($request->keyword);
        }

        if ($request->teachers) {
            $sections = $sections->filterByTeachers($request->teachers);
        }

        if ($request->subjects) {
            $sections = $sections->filterBySubjects($request->subjects);
        }

        if ($request->has('study_date_from') && $request->has('study_date_to')) {
            $study_date_from = $request->input('study_date_from');
            $study_date_to = $request->input('study_date_to');
            $sections = $sections->filterByStudyDate($study_date_from, $study_date_to);
        }

        if ($request->has('types')) {
            $sections = $sections->filterByTypes($request->types);
        }
        
        $students = CourseStudent::where('course_id', $request->id)->get();
        $sortColumn = $request->sort_by ?? 'study_date';
        $sortDirection = $request->sort_direction ?? 'asc';
        // sort
        $sections = $sections->orderBy($sortColumn, $sortDirection);

        if ($sortColumn == 'subject_id') {
            $sections->leftJoin('courses', 'sections.course_id', '=', 'courses.id')
                ->orderBy("courses.code", $sortDirection)
                ->select('sections.*');;
        }

        // pagination
        $sections = $sections->paginate($request->per_page ?? '20');
        
        return view('edu.staffs.teachingScheduleList', [
            'sections' => $sections,
            'students' => $students,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function salarySheet(Request $request, $id)
    {
       $teacher = Teacher::find($id);
       $courses = Course::where('teacher_id', $id)->get();
       $sectionCourses = Section::where(function($query) use ($id) {
            $query->where('vn_teacher_id', $id)
                ->orWhere('foreign_teacher_id', $id)
                ->orWhere('tutor_id', $id)
                ->orWhere('assistant_id', $id);
        })->distinct('course_id')->get(['course_id']);

        return view('edu.staffs.salarySheet', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
        ]);
    }

    public function salarySheetList(Request $request, $id)
    {
        $salarySheets = Payrate::query()->where('teacher_id', $id)->with('subject');

        if ($request->key) {
            $salarySheets = $salarySheets->search($request->key);
        }

        $sortColumn = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $salarySheets = $salarySheets->filterByCreatedAt($created_at_from, $created_at_to);
        }

        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $salarySheets = $salarySheets->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // sort
        $salarySheets = $salarySheets->orderBy($sortColumn, $sortDirection);

        //pagination
        $salarySheets = $salarySheets->paginate($request->perpage ?? 20);

        return view('edu.staffs.salarySheetList', [
            'salarySheets' => $salarySheets,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function expenseHistory(Request $request, $id)
    {
       $teacher = Teacher::find($id);
       $courses = Course::where('teacher_id', $id)->get();
       $sectionCourses = Section::where(function($query) use ($id) {
            $query->where('vn_teacher_id', $id)
                ->orWhere('foreign_teacher_id', $id)
                ->orWhere('tutor_id', $id)
                ->orWhere('assistant_id', $id);
        })->distinct('course_id')->get(['course_id']);

        return view('edu.staffs.expenseHistory', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
        ]);
    }

    public function getHomeRoomByArea(Request $request)
    {
        $area = $request->area;

        if (!$area) {
            throw new \Exception("Not found area!");
        }

        $homeRooms = Teacher::query()->homeRooms()->inArea($area)->get();

        if (!$homeRooms) {
            throw new \Exception("Not found area!");
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'get homeroom in area successfully!',
            'homeRooms' => $homeRooms
        ], 200);
    }

    public function export(Request $request)
    {
        $query = Teacher::byBranch(\App\Library\Branch::getCurrentBranch());
       
        if ($request->key) {
            $query = $query->search($request->key);
        }

        if($request->staffTypes) {
            $query = $query->filterByStaffTypes($request->staffTypes);
        }

        if($request->statuses) {
            $query = $query->filterByStatuses($request->statuses);
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

        if($request->has('type')) {
            if ($request->type == Teacher::TYPE_VIETNAM) {
                $query = $query->isVietNam();
            } elseif ($request->type == Teacher::TYPE_FOREIGN) {
                $query = $query->isForeign();
            } elseif ($request->type == Teacher::TYPE_TUTOR) {
                $query = $query->isTutor();
            } elseif ($request->type == Teacher::TYPE_HOMEROOM) {
                $query = $query->isHomeRoom();
            }elseif ($request->type == Teacher::TYPE_ASSISTANT) {
                $query = $query->isAssistant();
            };
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $teachers = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'MÃ NV', 'TÊN NHÂN VIÊN', 'LOẠI HÌNH NHÂN VIÊN', 'TÌNH TRẠNG HOẠT ĐỘNG', 'EMAIL', 'ĐIỆN THOẠI', 'NGÀY SINH',
            'NGÀY BẮT ĐẦU LÀM VIỆC', 'NGÀY CẬP NHẬT' 
        ];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }

        $row = 2;
        foreach ($teachers as $teacher) {
            $sheet->setCellValue('A' . $row, $teacher->code);
            $sheet->setCellValue('B' . $row, $teacher->name);
            $sheet->setCellValue('C' . $row, $teacher->type);
            $sheet->setCellValue('D' . $row, trans('messages.staffs.status.' . $teacher->status));
            $sheet->setCellValue('E' . $row, $teacher->email);
            $sheet->setCellValue('F' . $row, $teacher->phone);
            $sheet->setCellValue('G' . $row, $teacher->birthday ? date('d/m/Y', strtotime($teacher->birthday)) : '--' );
            $sheet->setCellValue('H' . $row, $teacher->created_at ? date('d/m/Y', strtotime($teacher->created_at)) : '--' );
            $sheet->setCellValue('I' . $row, $teacher->updated_at ? date('d/m/Y', strtotime($teacher->updated_at)) : '--' );
          
            $row++;
        }

        $fileName = 'teachers.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
    
        
        return Response::download($tempFile, $fileName)->deleteFileAfterSend(true);
        }
    }

