<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Extracurricular;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    public function index(Request $request)
    {
        return view('student.extracurricular.index', [
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.extracurricular.name'), 'checked' => true],
                ['id' => 'type', 'title' => trans('messages.extracurricular.type'), 'checked' => false],
                ['id' => 'address', 'title' => trans('messages.extracurricular.address'), 'checked' => true],
                ['id' => 'coordinator', 'title' => trans('messages.extracurricular.coordinator'), 'checked' => false],
                ['id' => 'price', 'title' => trans('messages.extracurricular.price'), 'checked' => false],
                ['id' => 'max_student', 'title' => trans('messages.extracurricular.max_student'), 'checked' => false],
                ['id' => 'min_student', 'title' => trans('messages.extracurricular.min_student'), 'checked' => false],
                ['id' => 'study_method', 'title' => trans('messages.extracurricular.study_method'), 'checked' => false],
                ['id' => 'start_at', 'title' => trans('messages.extracurricular.start_at'), 'checked' => true],
                ['id' => 'end_at', 'title' => trans('messages.extracurricular.end_at'), 'checked' => true],
            ],
            'filter' => isset($request->filter) ? $request->filter : null
        ]);
    }

    public function list(Request $request)
    {
        $query = Extracurricular::query();

        // User selected extracurricular activities
        // Select registered and pending activities
        if (isset($request->filter) && $request->filter == Extracurricular::FILTER_KEY_REGISTED) {
            if (\Auth::user()->isStudent()) {
                $query->filterByStudent(\Auth::user()->getStudent()); // registed
                $query->haventHappenedYet(); // Pending to start
            } else {
                throw new \Exception('[Dev_log] This user is not a student, please log in with student account to continue developing the feature! (hoanganh)');
            }
        }

        // Select completed activities
        if (isset($request->filter) && $request->filter == Extracurricular::FILTER_KEY_DONE) {
            if (\Auth::user()->isStudent()) {
                $query->filterByStudent(\Auth::user()->getStudent()); // registed
                $query->done(); // Done
            } else {
                throw new \Exception('[Dev_log] This user is not a student, please log in with student account to continue developing the feature! (hoanganh)');
            }
        } else {    
            // Select all upcoming activities on the system
            $query->haventHappenedYet();
        }

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->status === 'deputy_director_approved') {
            $query = $query->filterByAbroadStatus($request->status);
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

        if ($request->abroadStatuses) {
            $query = $query->filterByAbroadStatus($request->abroadStatuses);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->orderBy($sortColumn, $sortDirection);
        $extracurriculars = $query->paginate($request->perpage ?? 10);

        return view('student.extracurricular.list', [
            'extracurriculars' => $extracurriculars,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Delete all extracurricular which have selected
     */
    public function deleteAll(Request $request)
    {
        if (!empty($request->items)) {
            Extracurricular::destroyAll($request->items);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công các hoạt động ngoại khóa!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không tìm thấy các hoạt động ngoại khóa!'
        ], 400);
    }
}
