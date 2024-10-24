<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        // $request->session()->regenerate();

        // User is inactive
        if ($request->user()->isOutOfJob()) {
            \Auth::logout();
            return $this->sendInactiveUserResponse($request);
        }
        return view('hk.frontend.show');
        

    }

    protected function sendInactiveUserResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Người dùng đã ngưng hoạt động trên ASMS.',
            ]);
    }

    public function logoutOtherDevices($user)
    {
        $currentSessionId = Session::getId();

        // Check if the user has another active session
        if ($user->current_session_id && $user->current_session_id !== $currentSessionId) {
            // Invalidate the previous session
            $previousSession = \DB::table('sessions')->where('id', $user->current_session_id)->first();
            if ($previousSession) {
                \DB::table('sessions')->where('id', $previousSession->id)->delete();
            }
        }

        // Update the current session ID in the users table
        $user->current_session_id = $currentSessionId;
        $user->save();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->current_session_id = null;
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
