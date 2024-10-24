<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\ExtracurricularStudent;
use App\Models\Account;




use Illuminate\Http\Request;

class ExtracurricularStudentController extends Controller
{
    public function index(Request $request)
    {
        $extracurricularStudents = ExtracurricularStudent::getByExtracurricularId($request->id);
        $extracurricularId = $request->id;
        return view('abroad.extracurricular.extracurricular_student.index', [
            'extracurricularStudents' => $extracurricularStudents,
            'extracurricularId' => $extracurricularId
        ]);
    }
    public function  indexShow(Request $request)
    {
        $extracurricularStudents = ExtracurricularStudent::getByExtracurricularId($request->id);
        $extracurricularId = $request->id;
        return view('abroad.extracurricular.extracurricular_student.indexShow', [
            'extracurricularStudents' => $extracurricularStudents,
            'extracurricularId' => $extracurricularId
        ]);
    }
   
    public function create(Request $request, $id)
    {
        return view('abroad.extracurricular.extracurricular_student.create', [
            'id' => $id,
        ]);
    }
    public function save(Request $request)
    {
        ExtracurricularStudent::saveExtracurricularStudent($request);

        return response()->json([
            'message' => 'Thêm học viên thành công'
        ]);
    }
    public function select2(Request $request)
    {
        return response()->json(Account::select2($request));
    }
}
