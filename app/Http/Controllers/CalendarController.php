<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Calendar;
use App\Models\Course;

class CalendarController extends Controller
{
    /**
     * Show Calendar in create course screen
     */
    public function getCalendar(Request $request)
    {
        // Validate when apply or show calendar
        Calendar::validateToLoadCalendar($request);
        
        // If pass validate
        $calendar = Calendar::newDefault();

        try {
            $calendar->loadData($request);
        } catch (\Excption $e) {
            throw $e;
        }

        return view('helpers.calendar.calendar', [
            'calendar' => $calendar,
            'isShowCode' => isset($request->isShowCode) ? true : false,
            'isAbroad' => isset($request->isAbroad) ? 1 : 0
        ]);
    }

    public function getSectionsList(Request $request) 
    {
        Calendar::validateToLoadCalendar($request);

        $calendar = Calendar::newDefault();

        try {
            $calendar->loadData($request);
        } catch (LoadCalendarException $exception) {
            throw $exception;
        }

        return view('helpers.calendar.sectionsList', [
            'calendar' => $calendar,
            'isShowCode' => isset($request->isShowCode) ? true : false,
            'type' => isset($request->type) ? $request->type : null
        ]);
    }

    /**
     * Show calendar in dashboard
     */
    public function getDashboardCalendar(Request $request)
    {
        // Validate When apply or show calendar
        Calendar::validateToLoadCalendar($request);

        // If pass validate
        $calendar = Calendar::newDefault();

        try {
            $calendar->loadData($request);
        } catch (LoadCalendarException $exception) {
            throw $exception;
        }

        return view('helpers.calendar.dashboard_calendar', [
            'calendar' => $calendar,
            'isShowCode' => isset($request->isShowCode) ? true : false
        ]);
    }

    /**
     * Add event when click icon plus in day cell in calendar
     */
    public function addEventInCalendar(Request $request)
    {
        if (!$request->isAbroad) {
            if (is_null($request->subject_id)) {
                throw new \Exception("Error: Invalid subject id!");
            }
    
            if (is_null($request->area)) {
                throw new \Exception("Error: Invalid branch");
            }
        }

        if (!!$request->isAbroad) {
            return view('abroad.courses.addSchedule', [
                'studyDate' => $request->study_date,
                'isAddEventInCalendar' => true,
                'changeType' => true,
                'subject_id' => isset($request->subject_id) ? $request->subject_id : null,
                'area' => $request->area ?? null,
            ]);    
        }

        return view('edu.courses.addSchedule', [
            'studyDate' => $request->study_date,
            'isAddEventInCalendar' => true,
            'changeType' => true,
            'subject_id' => isset($request->subject_id) ? $request->subject_id : null,
            'area' => $request->area ?? null,
        ]);
    }

    /**
     * Edit event when click icon edit in day cell in calendar
     */
    public function editEventInCalendar(Request $request)
    {
        if (!$request->isAbroad) {
            if (is_null($request->subject_id)) {
                throw new \Exception("Error: Invalid subject id!");
            }
    
            if (is_null($request->area)) {
                throw new \Exception("Error: Invalid branch!");
            }
        }

        $weekEventEditInCalendar = $request->eventData;
        // $zoomUsers = \App\Models\ZoomMeeting::listUsers();
        $zoomUsers = \App\Models\ZoomUser::all();

        if (!!$request->isAbroad) {
            return view('abroad.courses.addSchedule', [
                'weekEventEditInCalendar' => $weekEventEditInCalendar,
                'changeType' => true,
                'subject_id' => isset($request->subject_id) ? $request->subject_id : null,
                'area' => $request->area ?? null,
                'zoomUsers' => $zoomUsers->toArray(),
            ]);    
        }

        return view('edu.courses.addSchedule', [
            'weekEventEditInCalendar' => $weekEventEditInCalendar,
            'changeType' => true,
            'subject_id' => isset($request->subject_id) ? $request->subject_id : null,
            'area' => $request->area ?? null,
            'zoomUsers' => $zoomUsers->toArray(),
        ]);
    }

    /**
     * When click icon "plus" to create section in calendar view
     */
    public function createEventInCalendar(Request $request)
    {
        if (!$request->isAbroad) {
            if (is_null($request->subject_id)) {
                throw new \Exception("Error: Invalid subject id!");
            }
    
            if (is_null($request->area)) {
                throw new \Exception("Error: Invalid branch!");
            }
        }

        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();

        if (!$errors->isEmpty()) {
            if (!!$request->isAbroad) {
                return response()->view('abroad.courses.addSchedule', [
                    "errors" => $errors,
                    "schedule" => $schedule,
                    'changeType' => true,
                    'isAddEventInCalendar' => true,
                    'subject_id' => isset($request->subject_id) ? $request->subject_id : null,
                    'area' => $request->area ?? null,
                ], 400);  
            } else {
                return response()->view('edu.courses.addSchedule', [
                    "errors" => $errors,
                    "schedule" => $schedule,
                    'changeType' => true,
                    'isAddEventInCalendar' => true,
                    'subject_id' => isset($request->subject_id) ? $request->subject_id : null,
                    'area' => $request->area ?? null,
                ], 400); 
            }
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm lịch học thành công!'
            ], 200);
        }
    }

    /**
     * When click "Lưu" save data section edited in calendar
     * normaly in edit or create course screen
     */
    public function updateEventInCalendar(Request $request)
    {
        if (is_null($request->subject_id)) {
            throw new \Exception("Error: Invalid subject id!");
        }

        if (is_null($request->area)) {
            throw new \Exception("Error: Invalid branch!");
        }

        // Validate data
        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();

        // Events have been validated
        $weekEventEditInCalendar = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('edu.courses.addSchedule', [
                "errors" => $errors,
                "schedule" => $schedule,
                'weekEventEditInCalendar' => $weekEventEditInCalendar,
                "subject_id" => $request->subject_id,
                'area' => $request->area,
                'changeType' => true,
            ], 400);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật lịch học thành công!',
            ], 200);
        }
    }
}
