<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Payrate;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        return view('system.staffs.index', [
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.staffs.name'), 'checked' => true],
                ['id' => 'type', 'title' => trans('messages.staffs.type'), 'checked' => true],
                ['id' => 'status', 'title' => trans('messages.staffs.status'), 'checked' => true],
                ['id' => 'email', 'title' => trans('messages.staffs.email'), 'checked' => true],
                ['id' => 'phone', 'title' => trans('messages.staffs.phone'), 'checked' => true],
                ['id' => 'birthday', 'title' => trans('messages.staffs.birthday'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.staffs.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.staffs.updated_at'), 'checked' => true],
            ]
        ]);
    }

    public function list(Request $request)
    {
        $query = Teacher::query();

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
            };
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $staffs = $query->paginate($request->perpage ?? 10);

        return view('system.staffs.list', [
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
        return view('system.staffs.create');
    }

    public function store(Request $request)
    {
        $staff = Teacher::newDefault();
        $errors = $staff->storeFromRequest($request);


        if (!$errors->isEmpty()) {
            return response()->view('system.staffs.create', [
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

        return view('system.staffs.show', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
        ]);
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
    
        return view('system.staffs.class', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses,
            'columns' => [
                ['id' => 'code', 'title' => trans('messages.courses.code'), 'checked' => true],
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
        }

        else {
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
        return view('system.staffs.classList', [
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

        //
        return view('system.staffs.calendar', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
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
    

        return view('system.staffs.teachingSchedule', [
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
        //
        return view('system.staffs.teachingScheduleList', [
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
    

        return view('system.staffs.salarySheet', [
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

        return view('system.staffs.salarySheetList', [
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
    

        return view('system.staffs.expenseHistory', [
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses
        ]);
    }
}
