<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function topBar(Request $request)
    {
        $user = $request->user();

        return view('notifications.topBar');
    }

    public function unreadAll(Request $request)
    {
        $user = $request->user();

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function check(Request $request)
    {
        if (!$request->user()) {
            return response()->json([[
                'status' => 'user_session_expired',
                'title' => 'Hệ thống',
                'message' => 'Bạn đã hết phiên đăng nhập hoặc đăng nhập ở thiết bị khác.',
            ]]);
        }

        $newNotifications = $request->user()
            ->unreadNotifications()
            ->limit(3)
            ->where('pushed', false)
            // ->where('created_at', '>', \Carbon\Carbon::now()->subMinutes(60))
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = $newNotifications->map(function($n) {
            return [
                'id' => $n->id,
                'status' => 'info',
                'title' => 'Hệ thống',
                'message' => $n->data['message'] ?? null,
                'url' => \App\Helpers\Functions::getNotificationUrl($n),
            ];
        });

        return response()->json($notifications);
    }

    public function setPushed(Request $request)
    {
        if (!$request->user()) {
            return;
        }

        // set pushed
        $request->user()
            ->notifications()
            ->whereIn('id', $request->ids)
            ->update([
                'pushed' => true,
            ]);

        return response()->json($request->ids);
    }
}
