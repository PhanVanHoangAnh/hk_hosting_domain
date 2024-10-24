<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Session::get('origin_user_id') && Auth::check() && Auth::user()->change_password_required) {
            $url = action([\App\Http\Controllers\ProfileController::class, 'changePassword']) . '#ChangePassword';
            return redirect($url)
                ->with('warning', 'Bạn cần đổi mật khẩu trước khi tiếp tục sử dụng tài khoản này!');
        }

        return $next($request);
    }
}