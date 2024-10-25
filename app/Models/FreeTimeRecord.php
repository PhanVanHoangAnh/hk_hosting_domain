<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class FreeTimeRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'from',
        'to',
        'free_time_id', 
    ];
   

    
    public function saveBusyScheduleFromRequest($request)
    {
        $busySchedule = json_decode($request->busy_schedule, true);

        
        $validator = Validator::make(['busy_schedule' => $busySchedule], [
            'busy_schedule' => 'required|array',
        ]);

        
        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        

        $teacher_id = $request->has('teacher_id') ? $request->teacher_id : null;
        $contact_id = $request->has('contact_id') ? $request->contact_id : null;
        
        $from_date = $request->from_date;
        $to_date = $request->to_date;



        if (!is_null($teacher_id)) {
            $teacher = Teacher::find($teacher_id);
            
            if (!is_null($teacher) && $teacher->checkHasCoursesInFreeTime($from_date, $to_date, $busySchedule)) {
                throw new \Exception("Trùng lịch rảnh với lịch dạy hiện tại!");
            }
        }

        // Kiểm tra xung đột lịch trong khoảng thời gian
        $this->checkScheduleConflictInRangeForSave($from_date, $to_date, $busySchedule);

        try {
        
            $freeTime = FreeTime::create([
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'teacher_id' => $request->teacher_id,
                'contact_id' => $request->contact_id,
            ]);

        
            $freeTimeId = $freeTime->id;

        
            foreach ($busySchedule as $schedule) {
                foreach ($schedule as $event) {
                   
                    $this->create([
                        'day_of_week' => $event['day'],
                        'from' => $event['time'],
                        'to' => $event['endTime'],
                        'free_time_id' => $freeTimeId,
                    ]);
                }
            }

            return [];
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    
    
    }
    public function updateBusyScheduleFromRequest($request)
    {
        $eventData = $request->input('event_data');
        
        $freeTime = FreeTime::find($request->id);
        if (!$freeTime) {
            return ['FreeTime not found'];
        }

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        if ($request->has('teacher_id')) {
            $teacher = Teacher::find($request->teacher_id);
            if ($teacher && $teacher->checkHasCoursesInFreeTime($from_date, $to_date, $eventData)) {
                throw new \Exception("Trùng lịch rảnh với lịch dạy hiện tại!");
            } 
        }
     
        // Kiểm tra xung đột lịch trong khoảng thời gian
        if (is_array($eventData)) {
            $this->checkScheduleConflictInRangeForUpdate($from_date, $to_date, $eventData);
        } else {
            throw new \Exception("event_data is not an array");
        }

        try {
            $freeTime->update([
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'teacher_id' => $request->teacher_id,
                'contact_id' => $request->contact_id,
            ]);
    
            $freeTime->freeTimeRecords()->delete(); 
        
            foreach ($eventData as $event) {
                
                if (!isset($event['day'], $event['time'], $event['endTime'])) {
                    return ['Invalid event format'];
                }
    
                
                $freeTimeRecord = new FreeTimeRecord([
                    'day_of_week' => $event['day'],
                    'from' => $event['time'],
                    'to' => $event['endTime'],
                ]);
    
                
                $freeTime->freeTimeRecords()->save($freeTimeRecord);
            }
    
            return [];
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }
    function checkScheduleConflictInRangeForSave($from_date, $to_date, $busySchedule)
    {
        $daysToCheck = [1, 2, 3, 4, 5, 6, 7];  
        $hasConflict = false; 

        for ($date = Carbon::parse($from_date); $date->lte(Carbon::parse($to_date)); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek + 1;
        
            if (in_array($dayOfWeek, $daysToCheck)) {
                foreach ($busySchedule as $schedule) {
                    foreach ($schedule as $event) {
                        if ((int)$event['day'] === $dayOfWeek) {
                            $hasConflict = true;
                            break ; 
                        }
                    }
                }
            }
        }
        
        if (!$hasConflict) {
            throw new \Exception("Không hợp lệ trong khoảng thời gian.");
        }
    }
    function checkScheduleConflictInRangeForUpdate($from_date, $to_date, $busySchedule)
    {
        
        $daysToCheck = [1, 2, 3, 4, 5, 6, 7]; // 1 for Sunday, 2 for Monday, ..., 7 for Saturday
        $hasConflict = false; 
        
        // Loop through each date in the range
        for ($date = Carbon::parse($from_date); $date->lte(Carbon::parse($to_date)); $date->addDay()) {
            
            $dayOfWeek = $date->dayOfWeek + 1; // Adjust to match the indexing (1 for Sunday, 2 for Monday, ..., 7 for Saturday)

            // Check if the current day is one of the days we want to check
            if (in_array($dayOfWeek, $daysToCheck)) {
                foreach ($busySchedule as $event) {
                    
                    $eventDay = (int) $event['day']; 

                    if ($eventDay === $dayOfWeek) {
                   
                        $hasConflict = true;
                        break ; 
                    }
                }
            }
        }

        
        if (!$hasConflict) {
            throw new \Exception("Không hợp lệ trong khoảng thời gian.");
        }
    }


    
    

    

}
