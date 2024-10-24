<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class InactivityTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $inactiveTimeout = config('session.lifetime') * 60; // Convert minutes to seconds
        $lastActivity = Session::get('last_activity', 0);

        // check auth
        if (Auth::check()) {
            if ($inactiveTimeout - (time() - $lastActivity) < 0) {
                Auth::logout(); // Log the user out

                return redirect()->route('login')
                    ->with('error', 'Bạn đã không hoạt động quá 30 phút. Vui lòng đăng nhập lại để tiếp tục sử dụng.');
            }
        }

        // Update the last activity time
        Session::put('last_activity', time());

        return $next($request);
    }
}
