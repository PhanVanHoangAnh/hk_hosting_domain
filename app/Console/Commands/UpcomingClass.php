<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;



class UpcomingClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upcoming_class:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("It's upcoming class");

        $sections = Section::upcomingClass()->get();
        $sections = Section::where('id',1473)->get();
       
        foreach($sections as $section) {
            
            $course = $section->course;

            $users = $section->getUserTeacherAndStudent();
          
         
             foreach ($users as $user) {
                
               
                if ($user) {
                    // Send notification to customers
                    $user->notify(new \App\Notifications\SendUpcomingClassNotification($course,$section)); 
                }  
            }
            $students = $section->getStudent();
           
            foreach ($students as $student){
               
                if ($student->phone) {
                    $startAt = new \DateTime($section->start_at);
                    $endAt = new \DateTime($section->end_at);
                    $startDay = $startAt->format('l'); // Ngày trong tuần
                    $startTime = $startAt->format('H:i'); // Giờ bắt đầu
                    $endTime = $endAt->format('H:i'); // Giờ kết thúc
                    $message = $section->course->code . ' học vào thứ: ' . $startDay . ' từ ' . $startTime . ' đến ' . $endTime;
                    \App\Library\Sms::send($message, $student->phone);
                   
                }
                $studentSection = \App\Models\CourseStudent::where('student_id', $student->id)->where('course_id', $section->course->id)->first();
                $contact = $studentSection->orderItems->order->contacts;
                if($student->phone !== $contact->phone){
                    $startAt = new \DateTime($section->start_at);
                    $endAt = new \DateTime($section->end_at);
                    $startDay = $startAt->format('l'); // Ngày trong tuần
                    $startTime = $startAt->format('H:i'); // Giờ bắt đầu
                    $endTime = $endAt->format('H:i'); // Giờ kết thúc
                    $message = $section->course->code . ' học vào thứ: ' . $startDay . ' từ ' . $startTime . ' đến ' . $endTime;
                    \App\Library\Sms::send($message, $student->phone);
                }
            }
            if ($section) {
                $section->outdatedNotificationUpcomingClass();
            }
        }
    }
}
