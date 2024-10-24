<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function getTeacherSelectOptionsBySubjectId(Request $request)
    {
        if (!$request->has('id')) {
            throw new \Exception('Subject id to load teachers not found!');
        }

        $subject = Subject::find($request->id);

        if (is_null($subject)) {
            throw new \Exception('Subject not found!');
        }

        $teachers = Teacher::hasSubject($subject)->get();

        return response()->view('teacher_options_by_subject', [
            'teachers' => $teachers,
            'selectedTeacher' => isset($request->selectedTeacher) ? $request->selectedTeacher : null
        ]);
    }

    public function account(Request $request, $id)
    {
        $teacher = Teacher::find($id);  
        $user = $teacher->findOrNewUser();

        if (!$request->user()->can('userAccount', $teacher)) {
            abort(403);
        }

        if ($request->isMethod('post')) {
            // validate
            list($user, $errors) = $teacher->saveUserAccountFromRequest($request);

            if (!$errors->isEmpty()) {
                return response()->view('teachers.account', [
                    'teacher' => $teacher,
                    'user' => $user,
                    'errors' => $errors,
                ], 400);
            }

            // add student role
            $user->addTeacherRole();

            return response()->json([
                'status' => 'success',
                'message' => 'Đã tạo tài khoản nhân sự giảng dạy thành công',
            ]);
        }

        return view('teachers.account', [
            'teacher' => $teacher,
            'user' => $user,
        ]);
    }
}
