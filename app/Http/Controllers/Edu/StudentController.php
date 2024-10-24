<?php

namespace App\Http\Controllers\Edu;

use App\Http\Controllers\Controller;

use App\Models\RefundRequest;
use App\Models\Section;
use App\Models\Tag;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\NoteLog;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Account;
use App\Models\CourseStudent;

use App\Models\ContactRequest;
use App\Models\Reserve;
use App\Models\StudentSection;
use App\Models\FreeTimeRecord;
use App\Models\FreeTime;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Parser\Multiple;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;
use Illuminate\Support\Facades\Validator;
use App\Events\AssigmentClass;

use App\Events\UpdateReserve;
use function Laravel\Prompts\alert;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        $accounts = Account::all();

        $listViewName = 'edu.students';
        $columns = [
            ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
            ['id' => 'code', 'title' => trans('messages.contact.code'), 'checked' => true],
            ['id' => 'student_code_old', 'title' => trans('messages.contact.student_code_old'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
            ['id' => 'demand', 'title' => trans('messages.contact.demand'), 'checked' => false],
            ['id' => 'school', 'title' => trans('messages.contact.school'), 'checked' => false],
            ['id' => 'father', 'title' => trans('messages.contact.father'), 'checked' => false],
            ['id' => 'mother', 'title' => trans('messages.contact.mother'), 'checked' => false],
            ['id' => 'birthday', 'title' => trans('messages.contact.birthday'), 'checked' => false],
            ['id' => 'age', 'title' => trans('messages.contact.age'), 'checked' => false],
            ['id' => 'class', 'title' => trans('messages.contact.class'), 'checked' => true],
            ['id' => 'awaiting_class_arrangement', 'title' => trans('messages.contact.awaiting_class_arrangement'), 'checked' => true],
            ['id' => 'reserve', 'title' => trans('messages.contact.reserve'), 'checked' => true],
            // ['id' => 'time_to_call', 'title' => trans('messages.contact.time_to_call'), 'checked' => false],
            ['id' => 'country', 'title' => trans('messages.contact.country'), 'checked' => false],
            ['id' => 'city', 'title' => trans('messages.contact.city'), 'checked' => false],
            ['id' => 'district', 'title' => trans('messages.contact.district'), 'checked' => false],
            ['id' => 'ward', 'title' => trans('messages.contact.ward'), 'checked' => false],
            ['id' => 'address', 'title' => trans('messages.contact.address'), 'checked' => false],
            // ['id' => 'efc', 'title' => trans('messages.contact.efc'), 'checked' => false],
            ['id' => 'list', 'title' => trans('messages.contact.list'), 'checked' => false],
            // ['id' => 'target', 'title' => trans('messages.contact.target'), 'checked' => false],
            ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => false],
            ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => true],
            // ['id' => 'pic', 'title' => trans('messages.contact.pic'), 'checked' => false],
            // ['id' => 'note_log', 'title' => trans('messages.contact.note_log'), 'checked' => true],

        ];
        //
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));

        return view('edu.students.index', [
            'accounts' => $accounts,
            'tags' => $tags,
            'status' => $request->status,
            'lead_status_menu' => $request->lead_status_menu,
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $students = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->student();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();

        if ($request->status == 'learning') {
            $students = $students->learning();
        }
        if ($request->status == 'waiting') {
            $students = $students->waiting();
        }

        if ($request->status == 'finished') {
            $students = $students->finished();
        }

        if ($request->status == 'notenrolled') {
            $students = $students->notenrolled();
        }

        if ($request->status == 'enrolled') {
            $students = $students->enrolled();
        }

        if ($request->status == 'reserve') {
            $students = $students->reserveOrderItem();
        }

        if ($request->status == 'refund') {
            $students = $students->refund();
        }

        if ($request->status == 'requestRefund') {
            $students = $students->requestRefund();
        }

        if ($request->status == 'rejected') {
            $students = $students->rejected();
        }

        if ($request->subjectName) {
            $students =  $students->filterBySubjectName($request->subjectName);
        }

        if ($request->homeRoom) {
            $students =  $students->filterByHomeRoom($request->homeRoom);
        }

        if ($request->branchs) {
            $students =  $students->filterEduStudentsByBranchs($request->branchs);
        }

        if ($request->classRoom) {
            $students =  $students->filterByClassRoom($request->classRoom);
        }

        if ($request->student) {
            $students =  $students->filterByStudent($request->student);
        }

        if ($request->keyword) {
            $students = $students->search($request->keyword);
        }

        if ($request->classRoom) {
            $students = $students->filterByClassRoom($request->classRoom);
        }

        if ($request->has('status')) {
            if ($request->status == 'is_assigned') {
                $students = $students->isAssigned();
            } else if ($request->status == 'is_new') {
                $students = $students->isNew();
            } else if ($request->status == 'no_action_yet') {
                $students = $students->noActionYet();
            } else if ($request->status == 'has_action') {
                $students = $students->hasAction();
            } else if ($request->status == 'outdated') {
                $students = $students->outdated();
            }
        }

        if ($request->has('lead_status_menu')) {
            $students = Contact::getLeadStatusMenu($students, $request->lead_status_menu);
        }

        if ($request->has('lifecycle_stage_menu')) {
            $students = Contact::getLifecycleStageMenu($students, $request->lifecycle_stage_menu);
        }

        $students = $students->orderBy($sortColumn, $sortDirection);
        $students = $students->paginate($request->per_page ?? '20');

        return view('edu.students.list', [
            'students' => $students,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        $contact = Contact::newDefault();
        $tags = Tag::all();
        $accounts = Account::all();

        return view('edu.students.create', [
            'contact' => $contact,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function store(Request $request)
    {
        $contact = Contact::newDefault();
        $tags = Tag::all();
        $accounts = Account::all();
        $errors = $contact->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('edu.students.create', [
                'contact' => $contact,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        $contact->assignToAccount($request->user()->account);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm học viên thành công',
        ]);
    }

    public function noteLogsPopup(Request $request, $id)
    {
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->contact_ids) {
            $query = $query->filterByContactIds($request->contact_ids);
        }

        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }

        $notes = $query->orderBy('updated_at', 'desc')->get();
        $notes = $query->paginate($request->perpage ?? 5);

        return view('edu.students.note-logs-popup', [
            'notes' => $notes,
            'contact' => $contact,
        ]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $tags = Tag::all();
        $accounts = Account::all();
        $errors = $contact->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('edu.students.edit', [
                'contact' => $contact,
                'errors' => $errors,
                'tags' => $tags,
                'accounts' => $accounts,
            ], 400);
        }

        $contact->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật học viên thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $contact = Contact::find($id);
        $tags = Tag::all();
        $accounts = Account::all();

        return view('edu.students.edit', [
            'contact' => $contact,
            'tags' => $tags,
            'accounts' => $accounts,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::find($id);
        $contact->deleteContact();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa học viên thành công',
        ]);
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)
            ->with('course.subject')
            ->get();

        $courseStudents = $courseStudents->sortBy(fn ($courseStudent) => $courseStudent->course->subject->id);

        return view('edu.students.show', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'orderItems' => $orderItems,
        ]);
    }

    public function class(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)->get();

        return view('edu.students.class', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'orderItems' => $orderItems,
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

    public function classList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $query = CourseStudent::where('student_id', $id);

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

        $sortColumn = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'asc';

        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $courseStudents = $query->paginate($request->per_page ?? '20');
        //
        return view('edu.students.classList', [
            'courseStudents' => $courseStudents,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function calendar(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)->get();
        $sectionStudents = StudentSection::where('student_id', $contact->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds)->get();
        $sectionsWithStatus = $sections->map(function ($section) use ($contact) {
            $status = $contact->getStudentSectionStatus($section);

            return array_merge($section->toArray(), [
                'status' => $status,
                'viewer' => 'student'
            ]);
        });

        $freeTimeSections = $contact->getFreeTimeSections();
        $eventSections = array_merge($sectionsWithStatus->toArray(), $freeTimeSections);

        return view('edu.students.calendar', [
            'contact' => $contact,
            'courseStudents' => $courseStudents,
            'sections' => $eventSections,
            'orderItems' => $orderItems,
        ]);
    }

    public function section(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $id)->get();
        //
        return view('edu.students.section', [
            'contact' => $contact,
            'orderItems' => $orderItems,
            'courseStudents' => $courseStudents
        ]);
    }

    public function sectionList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $sectionStudents = StudentSection::where('student_id', $contact->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds);

        if ($request->keyword) {
            $sections = $sections->search($request->keyword);
        }
        if ($request->teachers) {
            $sections = $sections->filterByTeachers($request->teachers);
        }

        if ($request->subjects) {
            $sections = $sections->filterBySubjects($request->subjects);
        }

        if ($request->has('types')) {
            $sections = $sections->filterByTypes($request->types);
        }

        if ($request->has('study_date_from') && $request->has('study_date_to')) {
            $study_date_from = $request->input('study_date_from');
            $study_date_to = $request->input('study_date_to');
            $sections = $sections->filterByStudyDate($study_date_from, $study_date_to);
        }

        $sortColumn = $request->sort_by ?? 'study_date';
        $sortDirection = $request->sort_direction ?? 'asc';
        $sections = $sections->orderBy($sortColumn, $sortDirection);

        if ($sortColumn == 'code') {
            $sections->leftJoin('courses', 'sections.course_id', '=', 'courses.id')
                ->orderBy("courses.code", $sortDirection)
                ->select('sections.*');;
        }
        // pagination
        $sections = $sections->paginate($request->per_page ?? '20');

        return view('edu.students.sectionList', [
            'contact' => $contact,
            'sections' => $sections,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'num' => $sections->count()
        ]);
    }

    public function schedule(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $id)->get();

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        return view('edu.students.schedule', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,

            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }


    public function contract(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();
        $orders = Order::where('contact_id', $contact->id);
        $courseStudents = CourseStudent::where('student_id', $id)->get();

        if (isset($request->screenType) && $request->screenType == Order::TYPE_GENERAL) {
            $orders->getGeneral();
        } else {
            $orders->getRequestDemo();
        }


        //
        return view('edu.students.contract', [
            'courseStudents' => $courseStudents,
            'contact' => $contact,
            'accounts' => $accounts,
            'screenType' => $request->screenType ? $request->screenType : Order::TYPE_GENERAL
        ]);
    }

    public function contractList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $accounts = Account::sales()->get();

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $orders = Order::where('contact_id', $contact->id);

        if ($request->keyword) {
            $orders = $orders->search($request->keyword);
        }



        $orders->orderBy($sortColumn, $sortDirection);


        $orders = $orders->paginate($request->per_page ?? '20');
        //

        return view('edu.students.contract-list', [
            'contact' => $contact,
            'accounts' => $accounts,
            'orders' => $orders,

            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }



    public function noteLog(Request $request, $id)
    {
        $accounts = Account::sales()->get();
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);
        $courseStudents = CourseStudent::where('student_id', $id)->get();

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

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->customer_ids) {
            $query = $query->filterByContactIds($request->customer_ids);
        }

        if ($request->contact_ids) {
            $query = $query->filterByContactIds($request->contact_ids);
        }

        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $notes = $query->paginate($request->perpage ?? 5);

        return view('edu.students.note-logs', [
            'courseStudents' => $courseStudents,
            'contact' => $contact,
            'accounts' => $accounts,
        ]);
    }

    public function noteLogList(Request $request, $id)
    {
        $query = NoteLog::where('contact_id', $id);
        $contact = Contact::find($id);

        if ($request->status && $request->status == NoteLog::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->active();
        }

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->customer_ids) {
            $query = $query->filterByContactIds($request->customer_ids);
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

        if ($request->account_id) {
            $query = $query->filterByAccountId($request->account_id);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $notes = $query->paginate($request->perpage ?? 5);

        return view('edu.students.note-logs-list', [
            'notes' => $notes,
            'contact' => $contact,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function extraActivity(Request $request, $id)
    {
        $contact = Contact::find($id);
        $courseStudents = CourseStudent::where('student_id', $id)->get();
        //
        return view('edu.students.extra-activity', [
            'contact' => $contact,
            'courseStudents' => $courseStudents
        ]);
    }


    public function kidTech(Request $request, $id)
    {
        $contact = Contact::find($id);
        $courseStudents = CourseStudent::where('student_id', $id)->get();
        return view('edu.students.kid-tech', [
            'contact' => $contact,
            'courseStudents' => $courseStudents
        ]);
    }

    public function select2(Request $request)
    {
        $request->merge(['type' => 'student']);

        return response()->json(Contact::select2($request));
    }

    public function addNoteLogContact(Request $request, $id)
    {
        $contact = Contact::find($id);

        return view('edu.contacts.add-notelog-customer', [
            'contact' => $contact
        ]);
    }

    public function storeNoteLogContact(Request $request, $id)
    {
        $contact = Contact::find($id);
        $notelog = NoteLog::newDefault();
        $errors = $notelog->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('edu.contacts.add-notelog-customer', [
                'errors' => $errors,
                'contact' => $contact
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới ghi chú thành công!'
        ]);
    }

    public function save(Request $request, $id)
    {
        $user = $request->user();
        $contact = Contact::find($id);
        $account = Account::find($request->salesperson_id);

        if ($request->salesperson_id) {
            if ($request->salesperson_id == 'unassign') {
                $contact->account_id = null;
            } else {
                $contact->assignToAccount($account);

                SingleContactRequestAssigned::dispatch($account, $contact, $user);
            }

            $contact->save();
        }

        if ($request->has('email')) {
            $contact->email = $request->email;
            $contact->save();
        }

        if ($request->has('phone')) {
            $contact->phone = \App\Library\Tool::extractPhoneNumber($request->phone);
            $contact->save();
        }

        if ($request->lead_status) {
            $contact->lead_status = $request->lead_status;
            $contact->save();
        }

        return response()->json([
            'status' => 'success',
            'salepersone_name' => $contact->account ? $contact->account->name : '<span class="text-gray-500">Chưa bàn giao</span>',
            'email' => $contact->email ? $contact->email : '<span class="text-gray-500">Chưa có email</span>',
            'phone' => $contact->phone ? $contact->phone : '<span class="text-gray-500">Chưa có số điện thoại</span>',
            'lead_status' => $contact->lead_status,
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->contacts)) {
            Contact::deleteAll($request->contacts);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Xóa thất bại!'
        ], 400);
    }

    public function assignToClass(Request $request)
    {
        $student_id = $request->id;
        $student = Contact::find($student_id);

        return view('edu.students.assignToClass', [
            'student' => $student,
        ]);
    }

    public function orderForm(Request $request)
    {
        $orders = collect();

        if ($request->student_id) {
            $student = Contact::find($request->student_id);
            $orders = $student->studentOrders()->get();
        }

        return view('edu.students.order_form', [
            'orders' => $orders
        ]);
    }

    public function eduItemsForm(Request $request)
    {
        $orderIds = [];

        if ($request->student_id) {
            $student = Contact::find($request->student_id);
            $orders = $student->studentOrders()->get();
            $orderIds = $orders->pluck('id')->toArray();
        }

        $orderItems = OrderItem::getEduItemsByOrderIds($orderIds);
        $student = $firstOrderItemId = $orderItems->first()?->orders->contact_id;

        return view('edu.students.orderItemForm', [
            'orderItems' => $orderItems,
            'student' => $student
        ]);
    }

    public function orderItemForm(Request $request)
    {
        $orderItems = OrderItem::getEduItemsByOrderId($request);
        $student = $firstOrderItemId = $orderItems->first()?->orders->contact_id;

        return view('edu.students.orderItemForm', [
            'orderItems' => $orderItems,
            'student' => $student
        ]);
    }

    public function courseForm(Request $request)
    {
        $subjects = OrderItem::getSubjectsByOrderItemId($request);
        $courses = collect();
        $student = $request->studentId;
        $order_item_id = $request->order_item_ids;

        if ($order_item_id) {
            $order_item = OrderItem::find($order_item_id)->first();
            $courses = Course::getCoursesBySubjects($subjects, $student, $order_item);
        }

        return view('edu.students.course_form', [
            'courses' => $courses
        ]);
    }

    public function doneAssignToClass(Request $request)
    {
        // init
        $orderItemId = $request->order_item_id;
        $requestData = $request->all();

        $studentId = null;
        foreach ($requestData as $key => $value) {
            if (strpos($key, 'contact_id-') !== false) {
                $studentId = $value;
                break;
            }
        }

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

        $orderItem = OrderItem::find($orderItemId);
        $assignment_date = $request->assignment_date;

        // $student->checkHourSectionsChecked($sectionIds, $orderItem);
        try {
            //
            $student->assignCourse($course, $orderItem,$assignment_date); // xếp lớp phải thông qua hợp đồng
            AssigmentClass::dispatch( $request->user(),$course, $orderItem );
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

        return response()->json([
            "message" => "Xếp lớp thành công cho học viên $studentName vào lớp $class thời gian học bắt đầu từ $start_at kết thúc  $end_at"
        ], 200);
    }

    public function studyPartner(Request $request)
    {
        $section_id = $request->id;
        $studentId = $request->studentId;
        $section = Section::find($section_id);

        return view('edu.students.studyPartner', [
            'section' => $section,
            'studentId' => $studentId
        ]);
    }

    public function sectionForm(Request $request)
    {
        $sections = collect();
        $studentId = $request->studentId;

        if ($request->courseIds) {
            $sections = Section::filterSectionByCourses($request->courseIds, $studentId)->get();
        }
        return view('edu.students.section_form', [
            'sections' => $sections
        ]);
    }

    public function courseStudentForm(Request $request)
    {
        $courseStudents = collect();
        $studentId = $request->student_id;

        $courseStudents = CourseStudent::coursesByStudentId($request->student_id);

        return view('edu.students.course_student_form', [
            'courseStudents' => $courseStudents,
            'studentId' => $studentId
        ]);
    }

    public function sectionStudent(Request $request)
    {
        $sections = collect();
        $studentId = $request->studentId;

        if ($request->courseStudentId) {
            $sections = Section::filterSectionStudentByCourses($request->courseStudentId, $studentId)->get();
        }

        return view('edu.students.section_student_form', [
            'sections' => $sections
        ]);
    }

    public function coursePartner(Request $request)
    {
        $coursePartner = collect();
        $sectionStudentId = $request->sectionStudentId;
        $section = Section::find($sectionStudentId);
        $subject = $section->course->subject->name;
        $courseStudentId = $section->course->id;
        $coursePartner = Course::getCoursesCourseTransfersBySubjects($subject, $courseStudentId);

        return view('edu.students.course_partner_form', [
            'coursePartners' => $coursePartner
        ]);
    }

    public function doneStudyPartner(Request $request)
    {
        $studentId = $request->studentId;
        $sectionId = $request->section_id;
        $sectionStudentId = $request->section_student_id;

        try {
            //
            StudentSection::addStudyPartner($studentId, $sectionId, $sectionStudentId);
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Xếp lớp không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Đã cho học viên vào học bù lớp  "
        ], 200);
    }

    public function transferClass(Request $request)
    {
        $student_id = $request->id;
        $currentCourseId = $request->courseId;
        $currentCourse = Course::find($currentCourseId);
        $student = Contact::find($student_id);
        // $student = ContactRequest::find(1);

        return view('edu.students.transferClass', [
            'student' => $student,
            'currentCourse' => $currentCourse
        ]);
    }

    public function courseTransferStudentForm(Request $request)
    {
        $currentCourses = collect();
        $studentId = $request->student_id;
        $currentCourseStudentId = $request->current_course_id;
        $orderItem = CourseStudent::where('student_id', $studentId)->get();
        $currentCourses = CourseStudent::coursesByStudentId($request->student_id);

        return view('edu.students.course_transfer_student_form', [
            'currentCourses' => $currentCourses,
            'currentCourseStudentId' => $currentCourseStudentId,
        ]);
    }

    public function courseTransfer(Request $request)
    {
        $courseTransfers = collect();
        $currentCourseId = $request->currentCourseId;
        $subject = Course::courseStudentSubjects($currentCourseId);
        $courseTransfers = Course::getCoursesCourseTransfersBySubjects($subject, $currentCourseId);

        return view('edu.students.course_transfer_form', [
            'courseTransfers' => $courseTransfers
        ]);
    }

    public function doneTransferClass(Request $request)
    {
        // init
        $currentCourseId = $request->current_course_id;
        $courseTransferId = $request->course_transfer_id;
        $requestData = $request->all();
        $studentId = null;

        foreach ($requestData as $key => $value) {
            if (strpos($key, 'contact_id-') !== false) {
                $studentId = $value;
                break;
            }
        }

        // $courseId = $request->course_id;
        // $studentName = Contact::find($studentId)->name;
        // $class = Course::find($courseId)->code;
        // $start_at = Course::find($courseId)->start_at;
        // $start_at = new \DateTime($start_at);
        // $start_at = $start_at->format('d/m/Y');
        // $end_at = Course::find($courseId)->end_at;
        // $end_at = new \DateTime($end_at);
        // $end_at = $end_at->format('d/m/Y');

        // Xếp học viên vào lớp học
        $student = Contact::find($studentId);
        $currentCourse = Course::find($currentCourseId);
        $courseTransfer = Course::find($courseTransferId);
        $orderItem = CourseStudent::getOrderItemId($studentId, $currentCourseId);
        $orderItem = $orderItem->getOrderItem();

        try {
            //
            $student->transferCourse($currentCourse, $courseTransfer, $orderItem, $request); // xếp lớp phải thông qua hợp đồng
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Xếp lớp không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Chuyển lớp thành công cho học viên "
        ], 200);
    }

    public function reserveClass(Request $request)
    {
        $student_id = $request->id;
        $currentCourseId = $request->courseId;
        $currentCourse = Course::find($currentCourseId);
        $student = Contact::find($student_id);

        return view('edu.students.reserveClass', [
            'student' => $student,
            'currentCourse' => $currentCourse
        ]);
    }

    public function courseReserveStudentForm(Request $request)
    {
        $currentCourses = collect();
        $studentId = $request->student_id;
        $currentCourseStudentId = $request->current_course_id;
        $orderItem = CourseStudent::where('student_id', $studentId)->get();
        $currentCourses = CourseStudent::coursesByStudentId($request->student_id);

        return view('edu.students.course_reserve_student_form', [
            'currentCourses' => $currentCourses,
            'currentCourseStudentId' => $currentCourseStudentId,
        ]);
    }

    public function doneReserveClass(Request $request)
    {
        // init
        $currentCourseId = $request->current_course_id;
        $reserveStartAt = $request->reserve_start_at;
        $requestData = $request->all();
        $studentId = null;

        foreach ($requestData as $key => $value) {
            if (strpos($key, 'contact_id-') !== false) {
                $studentId = $value;
                break;
            }
        }

        // Bảo lưu lớp học
        $student = Contact::find($studentId);
        $currentCourse = Course::find($currentCourseId);
        $orderItem = CourseStudent::getOrderItemId($studentId, $currentCourseId);
        $orderItem = $orderItem->getOrderItem();

        try {
            //
            $student->reserveCourse($currentCourse, $reserveStartAt, $orderItem);
        } catch (\Exception $e) {

            // after
            return response()->json([
                "message" => "Bảo lưu không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Bảo lưu thành công cho học viên "
        ], 200);
    }

    public function refundRequest(Request $request)
    {
        $student_id = $request->id;
        $currentCourseId = $request->courseId;
        $currentCourse = Course::find($currentCourseId);
        $student = Contact::find($student_id);

        return view('edu.students.refundRequest', [
            'student' => $student,
            'currentCourse' => $currentCourse
        ]);
    }

    public function courseRefundRequestForm(Request $request)
    {
        $currentCourses = collect();
        $studentId = $request->studentId;
        $order_item = $request->order_item_ids;
        $currentCourses = new Course;
        $currentCourses = $currentCourses->getCoursesByOrderItemAndStudent($order_item, $studentId);

        return view('edu.students.course_refund_request_form', [
            'currentCourses' => $currentCourses,
            'studentId' => $studentId,
        ]);
    }

    public function orderItemRefundRequestForm(Request $request)
    {
        $studentId = $request->student_id;
        $orders = Order::where('student_id', $studentId)->get();
        $orderItems = OrderItem::getOrderItemByOrderRefundRequest($orders);

        return view('edu.students.order_item_refund_request_form', [
            'orderItems' => $orderItems,

            'studentId' => $studentId,
        ]);
    }

    public function doneRefundRequest(Request $request)
    {
        $studentId = null;
        foreach ($request->all() as $key => $value) {
            // Kiểm tra nếu key có chứa 'contact_id'
            if (strpos($key, 'contact_id-') === 0) {
                // Lấy giá trị contact_id
                $studentId = $value;
                break;
            }
        }

        // init
        $orderItemIds = $request->orderItemIds;

        $reserveStartAt = $request->reserve_start_at;
        $reason = $request->reason;


        // Bảo lưu lớp học
        $student = Contact::find($studentId);
        // $currentCourse = Course::find($currentCourseId);
        // $orderItem = CourseStudent::getOrderItemId($studentId, $currentCourseId);
        // $orderItem = $orderItem->getOrderItem();

        try {
            $student->doneRefundRequest($orderItemIds, $reserveStartAt, $reason);

            // add note log
            $subjectsString = OrderItem::whereIn('id', $orderItemIds)->get()->map(function ($oi) {
                return "[" . $oi->getSubjectName() . " (HĐ: " . $oi->orders->code . ")]";
            })->join(',');

            $student->addNoteLog(
                $request->user()->account,
                "Gửi yêu cầu hoàn phí các dịch vụ: " . $subjectsString . ". Lý do hoàn phí: $reason"
            );
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Yêu cầu hoàn phí không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Yêu cầu hoàn phí thành công"
        ], 200);
    }

    public function assignToClassRequestDemo(Request $request)
    {
        $student_id = $request->id;
        $student = Contact::find($student_id);

        return view('edu.students.assignToClassRequestDemo', [
            'student' => $student,
        ]);
    }

    public function orderFormRequestDemo(Request $request)
    {
        $orders = collect();

        if ($request->student_id) {
            $student = Contact::find($request->student_id);
            $orders = $student->studentOrders()->get();
        }

        return view('edu.students.order_form_request_demo', [
            'orders' => $orders
        ]);
    }

    public function orderItemFormRequestDemo(Request $request)
    {
        $orderItems = OrderItem::getEduItemsByOrderIdRequestDemo($request);

        return view('edu.students.orderItemFormRequestDemo', [
            'orderItems' => $orderItems
        ]);
    }

    public function courseFormRequestDemo(Request $request)
    {
        $subjects = OrderItem::getSubjectsByOrderItemIdRequestDemo($request);

        $courses = collect();
        $student = $request->studentId;
        $order_item_id = $request->order_item_ids;

        if ($order_item_id) {
            $order_item = OrderItem::find($order_item_id)->first();

            $courses = Course::getCoursesBySubjectsDemo($subjects, $student, $order_item);
        }

        return view('edu.students.course_form_request_demo', [
            'courses' => $courses
        ]);
    }

    public function sectionFormRequestDemo(Request $request)
    {
        $sections = collect();
        $studentId = $request->studentId;

        if ($request->courseIds) {
            $sections = Section::filterSectionByCourses($request->courseIds, $studentId)->get();
        }
        return view('edu.students.section_form_request_demo', [
            'sections' => $sections
        ]);
    }
    public function doneAssignToClassRequestDemo(Request $request)
    {
        // init
        $orderItemId = $request->order_item_id;
        $requestData = $request->all();
        $sectionIds =  $request->sectionIds;
        $studentId = null;

        foreach ($requestData as $key => $value) {
            if (strpos($key, 'contact_id-') !== false) {
                $studentId = $value;
                break;
            }
        }

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
        $orderItem = OrderItem::find($orderItemId);

        $student->checkHourSectionsChecked($sectionIds, $orderItem);

        try {
            //
            $student->assignToClassRequestDemo($course, $orderItem, $sectionIds); // xếp lớp phải thông qua hợp đồng
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Xếp lớp không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Xếp lớp demo thành công cho học viên $studentName vào lớp $class thời gian học bắt đầu từ $start_at kết thúc  $end_at"
        ], 200);
    }

    public function refund(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $id)->get();

        return view('edu.students.refund', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'orderItems' => $orderItems,
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

    public function refundList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $query = RefundRequest::where('student_id', $id);

        // if ($request->keyword) {
        //     $query = $query->search($request->keyword);
        // }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'asc';

        // sort
        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $requests = $query->paginate($request->per_page ?? '20');

        return view('edu.students.refundList', [
            'requests' => $requests,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }

    //Bảo lưu

    public function reserve(Request $request)
    {
        $student_id = $request->id;
        $currentCourseId = $request->courseId;
        $currentCourse = Course::find($currentCourseId);
        $student = Contact::find($student_id);

        return view('edu.reserve.reserve', [
            'student' => $student,
            'currentCourse' => $currentCourse
        ]);
    }

    public function orderItemReserveForm(Request $request)
    {
        $studentId = $request->student_id;
        $orders = Order::where('student_id', $studentId)->get();
        $orderItems = OrderItem::getOrderItemByOrder($orders);

        return view('edu.reserve.orderItemReserveForm', [
            'orderItems' => $orderItems,
            'studentId' => $studentId,
        ]);
    }

    public function courseReserveForm(Request $request)
    {
        $currentCourses = collect();
        $studentId = $request->studentId;
        $order_item = $request->order_item_ids;
        $currentCourses = new Course;
        $currentCourses = $currentCourses->getCoursesByOrderItemAndStudent($order_item, $studentId);

        return view('edu.reserve.courseReserveForm', [
            'currentCourses' => $currentCourses,
            'studentId' => $studentId,
        ]);
    }

    public function doneReserve(Request $request)
    {
        // init
        $orderItemIds = $request->orderItemIds;
        $reserveStartAt = $request->reserve_start_at;
        $reserveEndAt = $request->reserve_end_at;
        $reason = $request->reason;
        $studentId = $request->studentId;

        // Bảo lưu lớp học
        $student = Contact::find($studentId);

        try {
            $student->doneReserve($orderItemIds, $reserveStartAt, $reserveEndAt, $reason);
            //các buổi chưa học của dịch vụ tương ứng bị xoá ra khỏi lớp
            if ($request->current_course_ids) {
                $currentCourses = $request->current_course_ids;
                $student->reserveCourse($currentCourses, $reserveStartAt);
            }

            UpdateReserve::dispatch($orderItemIds,$request->current_course_ids,$reserveStartAt,  $reserveEndAt, $request->user());
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Bảo lưu không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Bảo lưu thành công"
        ], 200);
    }

    public function transfer(Request $request)
    {
        // init
        $student = Contact::find($request->id);
        $currentCourse = Course::find($request->courseId);

        return view('edu.students.transfer', [
            'student' => $student,
            'currentCourse' => $currentCourse
        ]);
    }

    public function transferSave(Request $request)
    {
        // init
        $orderItem = OrderItem::find($request->order_item_id);
        $startAt = $request->reserve_start_at;
        $reason = $request->reason;

        // Chuyển phí
        $student = Contact::find($request->studentId);

        try {
            //
            $student->chuyenPhi($orderItem, $startAt, $reason, $request);
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Yêu cầu hoàn phí không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Yêu cầu chuyển phí thành công"
        ], 200);
    }

    public function transferOrderItemSelect(Request $request)
    {
        $studentId = $request->student_id;
        $orders = Order::where('student_id', $studentId)->get();
        $orderItems = OrderItem::getOrderItemByOrderTransfer($orders);

        return view('edu.students.transferOrderItemSelect', [
            'orderItems' => $orderItems,
            'studentId' => $studentId,
        ]);
    }

    public function transferFormDetail(Request $request)
    {
        $currentCourses = collect();
        $studentId = $request->studentId;
        $orderItem = OrderItem::find($request->order_item_id);
        $currentCourses = new Course;
        $currentCourses = $currentCourses->getCoursesByOrderItemAndStudent($request->order_item_id, $studentId);

        return view('edu.students.transferFormDetail', [
            'currentCourses' => $currentCourses,
            'studentId' => $studentId,
            'orderItem' => $orderItem
        ]);
    }

    public function reserveStudentDetail(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $id)->get();

        return view('edu.students.reserveStudentDetail', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'orderItems' => $orderItems,
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

    public function reserveList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $reserves = Reserve::getReserveByContact($id);
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $reserves = $reserves->orderBy($sortColumn, $sortDirection);
        $reserves = $reserves->paginate($request->per_page ?? '20');

        return view('edu.students.reserveList', [
            'reserves' => $reserves,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }

    public function transferStudentDetail(Request $request, $id)
    {
        $contact = Contact::find($id);
        $orderItems = $contact->getEduOrderItems();
        $accounts = Account::sales()->get();
        $courseStudents = CourseStudent::where('student_id', $id)->get();

        return view('edu.students.transferStudentDetail', [
            'contact' => $contact,
            'accounts' => $accounts,
            'courseStudents' => $courseStudents,
            'orderItems' => $orderItems,
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

    public function transferList(Request $request, $id)
    {
        $contact = Contact::find($id);
        $transfers = OrderItem::getOrderItemTransferListByContact($id);
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $transfers = $transfers->orderBy($sortColumn, $sortDirection);
        $transfers = $transfers->paginate($request->per_page ?? '20');

        return view('edu.students.transferList', [
            'transfers' => $transfers,
            'contact' => $contact,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function exitClass(Request $request)
    {
        $student_id = $request->id;
        $currentCourseId = $request->course;
        $course = Course::find($currentCourseId);
        $student = Contact::find($student_id);
        // $student = ContactRequest::find(1);

        return view('edu.students.exitClass', [
            'student' => $student,
            'course' => $course
        ]);
    }

    public function doneExitClass(Request $request)
    {
        // Xếp học viên vào lớp học
        $student = Contact::find($request->studentId);
        $course = Course::find($request->course_id);
        $orderItem = CourseStudent::getOrderItemId($request->studentId, $request->course_id);
        $orderItem = $orderItem->getOrderItem();

        try {
            $student->doneExitClass($course, $orderItem);
        } catch (\Exception $e) {
            // after
            return response()->json([
                "message" => "Xếp lớp không thành công. Lỗi: " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            "message" => "Chuyển lớp thành công cho học viên "
        ], 200);
    }

    public function showFreeTimeSchedule(Request $request)
    {
        $student = Contact::find($request->id);
        $orderItems = $student->getEduOrderItems();
        $courseStudents = CourseStudent::where('student_id', $request->id)->get();

        return view('edu.students.busySchedule', [
            'student' => $student,
            'contact' => $student,
            'orderItems' => $orderItems,
            'courseStudents' => $courseStudents
        ]);
    }
    public function showFreeTimeScheduleOfStudent(Request $request)
    {
        $contactId = $request->id;
        $contact = Contact::find($contactId);

        return view('edu.students.show-freetime-schedule', [
            'contact' => $contact,
        ]);
    }

    public function createFreetimeSchedule(Request $request)
    {
        $contact = Contact::find($request->id);

        return view('edu.students.create-freetime-schedule', [
            'contact' => $contact,
        ]);
    }

    public function saveFreetimeSchedule(Request $request)
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
            '123' =>$request,
            'status' => 'success',
            'message' => 'Thêm lịch rảnh thành công'
        ], 200);
    }

    public function editFreetimeSchedule(Request $request)
    {
        $freeTimeId = $request->id;
        $freeTime = FreeTime::find($freeTimeId);
        $contact = Contact::find($freeTime->contact_id);
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

        return view('edu.students.edit-freetime-schedule', [
            'freeTime' => $freeTime,
            'sortedFreeTime' => $sortedFreeTime,
            'contact' => $contact,
            'freeTimeRecords' => $freeTimeRecords
        ]);
    }

    public function updateFreetimeSchedule(Request $request)
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

    public function export(Request $request)
    {
        $templatePath = public_path('templates/students.xlsx');
        $filterStudents = $this->filterStudents($request);
        $templateSpreadsheet = IOFactory::load($templatePath);
    
        Contact::exportStudent($templateSpreadsheet, $filterStudents);
    
        // Output path
        $storagePath = storage_path('app/exports');
    
        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }
    
        $outputFileName = 'students.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
    
        $writer->save($outputFilePath);

        if (!file_exists($outputFilePath)) {
            return response()->json(['error' => 'Failed to save the file.'], 500);
        }
    
        return response()->download($outputFilePath, $outputFileName);
    }
    

    public function filterStudents(Request $request)
    {
        $students = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->student();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();

        if ($request->status == 'learning') {
            $students = $students->learning();
        }
        if ($request->status == 'waiting') {
            $students = $students->waiting();
        }

        if ($request->status == 'finished') {
            $students = $students->finished();
        }

        if ($request->status == 'notenrolled') {
            $students = $students->notenrolled();
        }

        if ($request->status == 'enrolled') {
            $students = $students->enrolled();
        }

        if ($request->status == 'reserve') {
            $students = $students->reserveOrderItem();
        }

        if ($request->status == 'refund') {
            $students = $students->refund();
        }

        if ($request->status == 'requestRefund') {
            $students = $students->requestRefund();
        }

        if ($request->status == 'rejected') {
            $students = $students->rejected();
        }

        if ($request->subjectName) {
            $students =  $students->filterBySubjectName($request->subjectName);
        }

        if ($request->homeRoom) {
            $students =  $students->filterByHomeRoom($request->homeRoom);
        }

        if ($request->branchs) {
            $students =  $students->filterEduStudentsByBranchs($request->branchs);
        }

        if ($request->classRoom) {
            $students =  $students->filterByClassRoom($request->classRoom);
        }

        if ($request->student) {
            $students =  $students->filterByStudent($request->student);
        }

        if ($request->keyword) {
            $students = $students->search($request->keyword);
        }

        // if ($request->classRoom) {
        //     $students = $students->filterByClassRoom($request->classRoom);
        // }

        if ($request->has('status')) {
            if ($request->status == 'is_assigned') {
                $students = $students->isAssigned();
            } else if ($request->status == 'is_new') {
                $students = $students->isNew();
            } else if ($request->status == 'no_action_yet') {
                $students = $students->noActionYet();
            } else if ($request->status == 'has_action') {
                $students = $students->hasAction();
            } else if ($request->status == 'outdated') {
                $students = $students->outdated();
            }
        }

        if ($request->has('lead_status_menu')) {
            $students = Contact::getLeadStatusMenu($students, $request->lead_status_menu);
        }

        if ($request->has('lifecycle_stage_menu')) {
            $students = Contact::getLifecycleStageMenu($students, $request->lifecycle_stage_menu);
        }

        $students = $students->orderBy($sortColumn, $sortDirection);

        return $students->get();
    }
}
