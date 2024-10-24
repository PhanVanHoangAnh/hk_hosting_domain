<?php
namespace App\Http\Controllers\Abroad;
use App\Http\Controllers\Controller;

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
        // Validate When apply or show calendar
        Calendar::validateToLoadCalendar($request);
        
        // If pass validate
        $calendar = Calendar::newDefault();
        
        try {
            $calendar->loadData($request);
        } catch (LoadCalendarException $exception) {
            throw $exception;
        }

        return view('abroad.courses.calendar', [
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

        return view('abroad.courses.sectionsList', [
            'calendar' => $calendar,
            'isShowCode' => isset($request->isShowCode) ? true : false
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

        return view('abroad.courses.dashboard_calendar', [
            'calendar' => $calendar,
            'isShowCode' => isset($request->isShowCode) ? true : false
        ]);
    }

    /**
     * Add event when click icon plus in day cell in calendar
     */
    public function addEventInCalendar(Request $request)
    {
        return view('abroad.courses.addSchedule', [
            'studyDate' => $request->study_date,
            'isAddEventInCalendar' => true,
            'changeType' => true,
        ]);
    }

    /**
     * Edit event when click icon edit in day cell in calendar
     * @param (Request) - Http request
     */
    public function editEventInCalendar(Request $request)
    {
        $weekEventEditInCalendar = $request->eventData;

        return view('abroad.courses.addSchedule', [
            'weekEventEditInCalendar' => $weekEventEditInCalendar,
            'changeType' => true,
        ]);
    }

    /**
     * When click icon "plus" to create section in calendar view
     * @param (Request) - Http request
     */
    public function createEventInCalendar(Request $request)
    {
        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses.addSchedule', [
                "errors" => $errors,
                "schedule" => $schedule,
                'changeType' => true,
                'isAddEventInCalendar' => true,
            ], 400); 
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm lịch học thành công!'
            ], 200);
        }
    }

    /**
     * When click icon "edit" to update section in calendar view
     */
    public function updateEventInCalendar(Request $request)
    {
        $errors = Course::validateScheduleItemsFromRequest($request);
        $schedule = $request->all();
        $weekEventEditInCalendar = $request->all();

        if (!$errors->isEmpty()) {
            return response()->view('abroad.courses.addSchedule', [
                "errors" => $errors,
                "schedule" => $schedule,
                'weekEventEditInCalendar' => $weekEventEditInCalendar,
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
