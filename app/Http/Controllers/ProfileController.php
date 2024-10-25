<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\NoteLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
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

        return view('profile.activities', [
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function changePassword(Request $request): View
    {
        return view('profile.changePassword', [
            'user' => $request->user(),
        ]);
    }

    public function notification(Request $request): View
    {
        return view('profile.notification', [
            'user' => $request->user(),
        ]);
    }
}
