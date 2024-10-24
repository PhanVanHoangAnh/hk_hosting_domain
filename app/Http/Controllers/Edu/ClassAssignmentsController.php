<?php

namespace App\Http\Controllers\Edu;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ClassAssignmentsController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'edu.class_assignments';
        $columns = [
            ['id' => 'code', 'title' => trans('messages.class.code'), 'checked' => true],
            ['id' => 'student_code_old', 'title' => trans('messages.contact.student_code_old'), 'checked' => true],
            ['id' => 'import_id', 'title' => trans('messages.order.import_id'), 'checked' => true],
            ['id' => 'import_contact_id', 'title' => trans('messages.order.import_contact_id'), 'checked' => true],
            ['id' => 'order_date', 'title' => trans('messages.class.order_date'), 'checked' => true],
            // ['id' => 'created_at', 'title' => trans('messages.class.created_at'), 'checked' => true],
            ['id' => 'parent_note', 'title' => trans('messages.class.parent_note'), 'checked' => true],
            ['id' => 'branch', 'title' => trans('messages.class.branch'), 'checked' => true],
            ['id' => 'training_location_id', 'title' => trans('messages.class.training_location_id'), 'checked' => true],
            ['id' => 'code_student', 'title' => trans('messages.class.code_student'), 'checked' => true],
            // ['id' => 'home_room', 'title' => trans('messages.class.home_room'), 'checked' => true],
            ['id' => 'name', 'title' => trans('messages.class.name_student'), 'checked' => true],
            ['id' => 'class_type', 'title' => trans('messages.class.class_type'), 'checked' => true],
            ['id' => 'subject_name', 'title' => trans('messages.class.subject_name'), 'checked' => true],
            ['id' => 'level', 'title' => trans('messages.class.level'), 'checked' => true],
            ['id' => 'train_style', 'title' => trans('messages.class.train_style'), 'checked' => true],
            ['id' => 'vietnam_teacher', 'title' => trans('messages.class.vietnam_teacher'), 'checked' => true],
            ['id' => 'foreign_teacher', 'title' => trans('messages.class.foreign_teacher'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.class.status'), 'checked' => true],
            ['id' => 'class_code', 'title' => trans('messages.class.class_code'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.class.email'), 'checked' => false],
            ['id' => 'phone', 'title' => trans('messages.class.phone_number'), 'checked' => false],
            // ['id' => 'order_type', 'title' => trans('messages.class.order_type'), 'checked' => false],
            ['id' => 'updated_at', 'title' => trans('messages.class.updated_at'), 'checked' => false],
            ['id' => 'num_of_student', 'title' => trans('messages.class.num_of_student'), 'checked' => false],
            ['id' => 'study_type', 'title' => trans('messages.class.study_type'), 'checked' => false],
            ['id' => 'tutor_teacher', 'title' => trans('messages.class.tutor_teacher'), 'checked' => false],
            // ['id' => 'vietnam_teacher_minutes_per_section', 'title' => trans('messages.class.vietnam_teacher_minutes_per_section'), 'checked' => false],
            // ['id' => 'foreign_teacher_minutes_per_section', 'title' => trans('messages.class.foreign_teacher_minutes_per_section'), 'checked' => false],
            // ['id' => 'tutor_minutes_per_section', 'title' => trans('messages.class.tutor_minutes_per_section'), 'checked' => false],
            // ['id' => 'target', 'title' => trans('messages.class.target'), 'checked' => false],
            ['id' => 'duration', 'title' => trans('messages.class.duration'), 'checked' => false],
            ['id' => 'train_hours', 'title' => trans('messages.class.train_hours'), 'checked' => false],
            ['id' => 'father_email', 'title' => trans('messages.class.father_email'), 'checked' => false],
            ['id' => 'father_phone', 'title' => trans('messages.class.father_phone'), 'checked' => false],
            ['id' => 'mother_email', 'title' => trans('messages.class.mother_email'), 'checked' => false],
            ['id' => 'mother_phone', 'title' => trans('messages.class.mother_phone'), 'checked' => false],
        ];

        //
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('edu.class_assignments.index', [
            'columns' => $columns,
            'listViewName' => $listViewName,
            'status' => $request->status,
            'type' => $request->type,
        ]);
    }

    public function list(Request $request)
    {
        $query = $this->filterListClass();

        // $sortColumn = $request->sort_by ?? 'updated_at';
        $sortColumn = $request->sort_by ?? 'order_items.updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $type = $request->type;

        if ($request->type === \App\Models\OrderItem::TYPE_EDU) {
            $query = $query->typeEdu();
        }

        if ($request->type === 'request-demo') {
            $query = $query->typeRequestDemo();
        }

        if ($request->status == 'enrolled') {
            $query = $query->WhichHasCousrseByType($request->type);
        }

        if ($request->status == 'reserve') {
            $query = $query->reserve();
        }

        if ($request->status == 'refund') {
            $query = $query->refund();
        }

        if ($request->status == 'transfer') {
            $query = $query->transfer();
        }

        if ($request->status == 'notEnrolled') {
            $query = $query->whichDoesntHasCousrse($request->type);
        }
        
        if (isset($request->statusStudent) && is_array($request->statusStudent) && in_array('enrolled', $request->statusStudent)) {
            $query = $query->WhichHasCousrseByType($request->type);
        }
        if (isset($request->statusStudent) && is_array($request->statusStudent) && in_array('notEnrolled', $request->statusStudent)) {
            $query = $query->whichDoesntHasCousrse($request->type);
        }
       
        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->student) {
            $query =  $query->filterByStudent($request->student);
        }
        
        if ($request->homeRoom) {
            $query =  $query->filterByHomeRoom($request->homeRoom);
        }

        if ($request->subjectName) {
            $query =  $query->filterBySubjectName($request->subjectName);
        }
       
        if ($request->orderType) {
            $query = $query->filterByOrderType($request->orderType);
        }

        if ($request->classRoom) {
            $query = $query->filterByClassRoom($request->classRoom);
        }
     
        if ($request->branchName) {
            $query = $query->filterByBranchName($request->branchName);
        }
      
        if ($request->locationName) {
            $query = $query->filterByLocationName($request->locationName);
        }
       
        if ($request->level) {
            $query = $query->filterByLevel($request->level);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        $query = $query->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('contacts', 'contacts.id', '=', 'orders.contact_id')
            ->leftJoin('training_locations', 'training_locations.id', '=', 'order_items.training_location_id')
            ->select('order_items.*', 'contacts.phone', 'contacts.email', 'contacts.name', 'orders.code',);

        if ($sortColumn == 'email' || $sortColumn == 'phone' || $sortColumn == 'name' ) {
            $query = $query->orderBy("contacts.{$sortColumn}", $sortDirection);
        } elseif ($sortColumn == "code") {
            $query = $query->orderBy("orders.{$sortColumn}", $sortDirection);
        } elseif($sortColumn == "branch") {
            $query = $query->orderBy("training_locations.{$sortColumn}", $sortDirection);
        } else {
            $query = $query->orderBy($sortColumn, $sortDirection);
        }

        if ($request->suitableClass == 'less_than_0') {
            $query = $query->filterBySuitableClassLess();
        }

        if ($request->suitableClass == 'greater_than_0') {
            $query = $query->filterBySuitableClassGreater();
        }

        $classes = $query->paginate($request->perpage ?? 10);
        
        return view('edu.class_assignments.list', [
            'classes' => $classes,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'type' => $type
        ]);
    }

    public function filterListClass()
    {
        $classes = OrderItem::byBranchEdu(\App\Library\Branch::getCurrentBranch());
        $classes = $classes->filterOrderApproved();

        return $classes;
    }

    public function assignToClass(Request $request)
    {
        return view('edu.students.assignToClass');
    }
}
