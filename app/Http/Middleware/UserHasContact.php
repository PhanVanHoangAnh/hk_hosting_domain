<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserHasContact
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->getStudent()) {
            // return response('User chưa có thông tin khách hàng/học viên tương ứng. Thử đăng nhập lại bằng tài khoản học viên/khách hàng', 200)->header('Content-Type', 'text/html');
            return redirect()->action([\App\Http\Controllers\Student\AccountController::class, 'setupStudent']);
        }

        return $next($request);
    }
}
