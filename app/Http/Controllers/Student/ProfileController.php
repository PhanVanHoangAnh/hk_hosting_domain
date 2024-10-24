<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\NoteLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View; 
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('student.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updatePassword(Request $request): View
    {
        return view('student.profile._update_password', [
            'user' => $request->user(),
        ]);
    }

    public function activities(Request $request): View
    {
        $query = NoteLog::where('account_id', Auth::User()->id);

        if ($request->status && $request->status == NoteLog::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->active();
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $notes = $query->sortList($sortColumn, $sortDirection)->get();

        return view('student.profile.activities', [
            'user' => $request->user(),
            'notes' => $notes,
        ]);
    }

    public function notelogs(Request $request): View
    {
        $query = $request->user()->getStudent()->noteLogs()->noteLogFromSystem();

        if ($request->status && $request->status == NoteLog::STATUS_DELETED) {
            $query = $query->deleted();
        } else {
            $query = $query->active();
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $notes = $query->sortList($sortColumn, $sortDirection)->get();

        return view('student.profile.notelogs', [
            'user' => $request->user(),
            'notes' => $notes,
        ]);
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

        return Redirect::route('student.profile.edit')->with('status', 'profile-updated');
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
