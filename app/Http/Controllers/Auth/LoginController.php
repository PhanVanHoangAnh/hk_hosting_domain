<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
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
}
