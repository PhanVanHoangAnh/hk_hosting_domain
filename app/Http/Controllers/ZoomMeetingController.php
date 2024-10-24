<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ZoomMeeting;

class ZoomMeetingController extends Controller
{
    public function getAvailableZoomUserIdsBySections(Request $request)
    {
        try {
            $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections($request->sections, isset($request->courseId) ? $request->courseId : null);
    
            return response()->json([
                'availableZoomUserIds' => $availableZoomUserIds
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve available Zoom user IDs',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getZoomUserSelectOptionsByIds(Request $request)
    {   
        $zoomUserIds = $request->zoomUserIds;
        $users = ZoomMeeting::getZoomUsersByIds($zoomUserIds);

        return response()->view('generals.zoom_meeting.zoom_user_options', [
            'zoomUsers' => $users
        ]);
    }
}
