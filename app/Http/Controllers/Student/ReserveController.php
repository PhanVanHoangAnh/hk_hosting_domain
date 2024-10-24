<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use App\Models\Section;
use App\Models\Tag;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\NoteLog;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Account;
use App\Models\Reserve;

use App\Models\ContactRequest;

use Illuminate\Http\Request;


class ReserveController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        $accounts = Account::all();


        return view('student.reserve.index', [
            'accounts' => $accounts,
            'tags' => $tags,
            'status' => $request->status,
            'lead_status_menu' => $request->lead_status_menu,
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.contact.name'), 'title' => trans('messages.contact.name'), 'checked' => true],
                ['id' => 'phone', 'title' => trans('messages.contact.phone'), 'checked' => true],
                ['id' => 'email', 'title' => trans('messages.contact.email'), 'checked' => true],
                ['id' => 'status', 'title' => trans('messages.reserve.status'), 'checked' => true],
                ['id' => 'demand', 'title' => trans('messages.contact.demand'), 'checked' => false],
                ['id' => 'school', 'title' => trans('messages.contact.school'), 'checked' => false],
                ['id' => 'start_at', 'title' => trans('messages.reserve.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.reserve.end_at'), 'checked' => true],
                ['id' => 'reason', 'title' => trans('messages.reserve.reason'), 'checked' => true],

                ['id' => 'mother', 'title' => trans('messages.contact.mother'), 'checked' => false],
                ['id' => 'birthday', 'title' => trans('messages.contact.birthday'), 'checked' => false],
                ['id' => 'age', 'title' => trans('messages.contact.age'), 'checked' => false],
                ['id' => 'class', 'title' => trans('messages.contact.class'), 'checked' => true],
                ['id' => 'awaiting_class_arrangement', 'title' => trans('messages.contact.awaiting_class_arrangement'), 'checked' => true],
                ['id' => 'reserve', 'title' => trans('messages.contact.reserve'), 'checked' => true],
                ['id' => 'list', 'title' => trans('messages.contact.list'), 'checked' => false],
                ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => false],
                ['id' => 'updated_at', 'title' => trans('messages.contact.updated_at'), 'checked' => false],

            ],
        ]);
    }

    public function list(Request $request)
    {
        $reserves = Reserve::query();
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $tags = Tag::all();
        if ($request->type == 'limit') {
            $reserves =  $reserves->limit();
        }
        if ($request->type == 'expired') {
            $reserves =  $reserves->expired();
        }
        if ($request->subjectName) {
            $reserves =  $reserves->filterBySubjectName($request->subjectName);
        }
        if ($request->homeRoom) {
            $reserves =  $reserves->filterByHomeRoom($request->homeRoom);
        }
        if ($request->classRoom) {
            $reserves =  $reserves->filterByClassRoom($request->classRoom);
        }
        if ($request->student) {
            $reserves =  $reserves->filterByStudent($request->student);
        }
        if ($request->keyword) {
            $reserves = $reserves->search($request->keyword);
        }
        if ($request->classRoom) {
            $reserves = $reserves->filterByClassRoom($request->classRoom);
        }
        $reserves = $reserves->orderBy($sortColumn, $sortDirection);
        $reserves = $reserves->paginate($request->per_page ?? '20');

        return view('student.reserve.list', [
            'reserves' => $reserves,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function reserveStudent(Request $request)
    {
        $student_id = $request->id;
        $student = Contact::find($student_id);

        return view('student.reserve.reserveStudent', [
            'student' => $student,
        ]);
    }

    public function reserveExtend(Request $request)
    {
        $reserve = Reserve::find($request->id);

        return view('student.reserve.reserveExtend', [
            'reserve' => $reserve,

        ]);
    }
    public function doneReserveExtend(Request $request)
    {

        $reserve = Reserve::find($request->reserve);


        try {
            //
            $reserve->reserveExtend($request->reserve_end_at);
        } catch (\Exception $e) {

            // after
            return response()->json([
                "message" => "Gia hạn bảo lưu lỗi. Lỗi: " . $e->getMessage(),
            ], 500);
        }


        return response()->json([
            "message" => "Gia hạn bảo lưu thành công"
        ], 200);
    }
    public function reserveCancelled(Request $request)
    {
        $reserve = Reserve::find($request->id);

        return view('student.reserve.reserveCancelled', [
            'reserve' => $reserve,

        ]);
    }
    public function doneReserveCancelled(Request $request)
    {

        $reserve = Reserve::find($request->reserve);

        try {
            //
            $reserve->reserveCancelled();
        } catch (\Exception $e) {

            // after
            return response()->json([
                "message" => "Dừng bảo lưu lỗi. Lỗi: " . $e->getMessage(),
            ], 500);
        }


        return response()->json([
            "message" => "Dừng bảo lưu thành công"
        ], 200);
    }
}
