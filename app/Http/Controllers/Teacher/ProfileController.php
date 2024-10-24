<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\FreeTimeRecord;
use App\Models\NoteLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View; 
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Models\Teacher;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('teacher.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updatePassword(Request $request): View
    {
        return view('teacher.profile._update_password', [
            'user' => $request->user(),
        ]);
    }

    public function freetimes(Request $request): View
    {
        $teacher = $request->user()->getTeacher();
        $courses = Course::where('teacher_id', $teacher->id)->get();
        $sectionCourses = Section::where(function($query) use ($teacher) {
            $query->where('vn_teacher_id', $teacher->id)
                  ->orWhere('foreign_teacher_id', $teacher->id)
                  ->orWhere('tutor_id', $teacher->id)
                  ->orWhere('assistant_id', $teacher->id);
            })->distinct('course_id')->get(['course_id']); 

        return view('teacher.profile.freetimes', [ 
            'user' => $request->user(),
            'teacher' => $teacher,
            'courses' => $courses,
            'sectionCourses' => $sectionCourses, 
        ]);
    }
    public function createFreetime(Request $request)
    {
        $teacher = $request->user()->getTeacher();

        return view('teacher.profile.busy-schedule', [
            'teacher' => $teacher,
        ]);
    }

    public function saveBusySchedule(Request $request)
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
   
    
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        $request->user()->updateAccountInfo();

        return Redirect::route('teacher.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
