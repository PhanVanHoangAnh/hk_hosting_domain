<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AccountController extends Controller
{
    public function setupTeacher(Request $request)
    {
        $user = $request->user();
        $sameEmailTeachers = Teacher::where('email', '=', $user->email);

        return view('teacher.account.setupTeacher', [
            'sameEmailTeachers' => $sameEmailTeachers,
        ]);
    }

    public function setupTeacherSave(Request $request)
    {
        if ($request->teacher_id == 'new') {
            $teacher = $request->user()->account->createNewDefaultTeacher($request->user()->name, $request->user()->email);
        } else {
            $teacher = Teacher::find($request->teacher_id);
        }

        $request->user()->account->setTeacher($teacher);

        return redirect()->action([\App\Http\Controllers\Teacher\DashboardController::class, 'index']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->action([\App\Http\Controllers\Teacher\DashboardController::class, 'index']);
    }

    public function createNewTeacher(Request $request)
    {
        return view('teacher.account.createNewTeacher');
    }
}

