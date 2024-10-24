<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ClassAssignmentsController extends Controller
{
    public function index(Request $request)
    {
        return view('abroad.class_assignments.index', [
            'columns' => [
                ['id' => 'code', 'title' => trans('messages.class.code'), 'checked' => true],
                // ['id' => 'home_room', 'title' => trans('messages.class.home_room'), 'checked' => true],
                ['id' => 'name', 'title' => trans('messages.class.name_student'), 'checked' => true],
                ['id' => 'email', 'title' => trans('messages.class.email'), 'checked' => true],
                ['id' => 'phone', 'title' => trans('messages.class.phone_number'), 'checked' => true],
                // ['id' => 'order_type', 'title' => trans('messages.class.order_type'), 'checked' => false],
                ['id' => 'subject_name', 'title' => trans('messages.class.subject_name'), 'checked' => true],
                // ['id' => 'train_style', 'title' => trans('messages.class.train_style'), 'checked' => true],

                ['id' => 'status', 'title' => trans('messages.class.status'), 'checked' => true],


                ['id' => 'class_code', 'title' => trans('messages.class.class_code'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.class.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.class.updated_at'), 'checked' => false],
                ['id' => 'level', 'title' => trans('messages.class.level'), 'checked' => false],
                ['id' => 'class_type', 'title' => trans('messages.class.class_type'), 'checked' => true],
                ['id' => 'num_of_student', 'title' => trans('messages.class.num_of_student'), 'checked' => false],
                ['id' => 'study_type', 'title' => trans('messages.class.study_type'), 'checked' => false],
                ['id' => 'branch', 'title' => trans('messages.class.branch'), 'checked' => false],
                ['id' => 'vietnam_teacher', 'title' => trans('messages.class.vietnam_teacher'), 'checked' => false],
                ['id' => 'foreign_teacher', 'title' => trans('messages.class.foreign_teacher'), 'checked' => false],
                ['id' => 'tutor_teacher', 'title' => trans('messages.class.tutor_teacher'), 'checked' => false],
                // ['id' => 'vietnam_teacher_minutes_per_section', 'title' => trans('messages.class.vietnam_teacher_minutes_per_section'), 'checked' => false],
                // ['id' => 'foreign_teacher_minutes_per_section', 'title' => trans('messages.class.foreign_teacher_minutes_per_section'), 'checked' => false],
                // ['id' => 'tutor_minutes_per_section', 'title' => trans('messages.class.tutor_minutes_per_section'), 'checked' => false],
                // ['id' => 'target', 'title' => trans('messages.class.target'), 'checked' => false],
                ['id' => 'duration', 'title' => trans('messages.class.duration'), 'checked' => false],
                ['id' => 'train_hours', 'title' => trans('messages.class.train_hours'), 'checked' => false],
            ],
            'status' => $request->status,
            'type' => $request->type,
        ]);
    }

    public function list(Request $request)
    {

        $query  = $this->filterListClass();

        // $sortColumn = $request->sort_by ?? 'updated_at';
        $sortColumn = $request->sort_by ?? 'order_items.updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';


        $type = $request->type;
        // Thực hiện truy vấn

        // // Kiểm tra dữ liệu trả về
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

        $query = $query->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('contacts', 'contacts.id', '=', 'orders.contact_id')
            ->select('order_items.*', 'contacts.phone', 'contacts.email', 'contacts.name', 'orders.code',);
        if ($sortColumn == 'email' || $sortColumn == 'phone' || $sortColumn == 'name') {

            $query = $query->orderBy("contacts.{$sortColumn}", $sortDirection);
        } else 
        if ($sortColumn == "code") {
            $query = $query->orderBy("orders.{$sortColumn}", $sortDirection);
        } else {
            $query = $query->orderBy($sortColumn, $sortDirection);
        }

        $classes = $query->paginate($request->perpage ?? 10);
        return view('abroad.class_assignments.list', [
            'classes' => $classes,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'type' => $type
        ]);
    }

    public function filterListClass()
    {
        $classes = OrderItem::query();
        return $classes;
    }

    public function assignToClass(Request $request)
    {
        return view('abroad.students.assignToClass');
    }
}
