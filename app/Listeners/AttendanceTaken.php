<?php

namespace App\Listeners;

use App\Events\AttendanceProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;
use App\Models\Contact;

class AttendanceTaken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AttendanceProcessed $event): void
    {
        $users = [];
        $studentSection = $event->studentSection;
        $section = $studentSection->section;
        $student = $studentSection->student;
        $users = $section->getUser();
        if($student){
            $account = Account::where('student_id', $student->id)->first();
            if($account){
                $student->addNoteLog($account, "Bạn đã điểm danh buổi học thứ {$section->order_number} của lớp {$section->course->code}!");
                
                foreach($account->users as $user) 
                {
                    $users[]=$user;
                }
            }        
          
        }
        
        foreach($users as $user) 
        {
            
            $user->notify(new \App\Notifications\Attendance($studentSection));
        }

        // // SMS send
        if ($student->phone) {
            $message = 'Học viên vào lớp lúc '.$studentSection->start_at.' và kết thúc lớp học lúc '.$studentSection->end_at;
            \App\Library\Sms::send($message, $student->phone);
        }
        $courseStudent = \App\Models\CourseStudent::where('student_id', $student->id)->where('course_id', $section->course->id)->first();
        $contact = $courseStudent->orderItems->order->contacts;

        if($student->phone !== $contact->phone){   
            $message = 'Học viên vào lớp lúc '.$studentSection->start_at.' và kết thúc lớp học lúc '.$studentSection->end_at;
            \App\Library\Sms::send($message, $student->phone);
        }
        $teachers=$section->getTeacher();
        foreach($teachers as $teacher){
            if ($teacher->phone) {
                $message = 'Học viên vào lớp lúc '.$studentSection->start_at.' và kết thúc lớp học lúc '.$studentSection->end_at;
                \App\Library\Sms::send($message, $student->phone);
            }
        }
       
       
    }
}
