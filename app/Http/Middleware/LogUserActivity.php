<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $url = $request->fullUrl();

            //
            if (!in_array($url, [
                url(action([\App\Http\Controllers\NotificationController::class, 'check'])),
                url(action([\App\Http\Controllers\NotificationController::class, 'topBar'])),
                url(action([\App\Http\Controllers\NotificationController::class, 'unreadAll'])),
                url(action([\App\Http\Controllers\UserController::class, 'saveListColumns'])),
            ]) &&
            strpos($url, 'notification/set-pushed') === false &&
            strpos($url, 'log-viewer') === false
            
            
            ) {
                $url = str_replace(url('/'), '', $url);
                Log::channel('user_activity')->info("{$user->name} ({$user->id}): {$request->method()} {$url}", [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'url' => $url,
                    'request' => $request->all(),
                ]);
            }
        }

        return $next($request);
    }
}
