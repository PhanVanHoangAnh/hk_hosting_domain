<?php

namespace App\Listeners;

use App\Events\AssigmentClass;

class SendAssigmentClassNotification
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
    public function handle(AssigmentClass $event)
    {
        $users=[];
        $course = $event->course ;

        $teacherIds = $course->getTeachersFromCourse();
        foreach ($teacherIds as $teacherId){
          
            $accounts = \App\Models\Account::where('teacher_id',$teacherId)->get();
            foreach ($accounts as $account) {
                    $userTeacher = \App\Models\User::where('account_id', $account->id)->first();
                    if ($userTeacher) {
                        $users[] = $userTeacher;
                    }
                }
        }

        $orderItem = $event->orderItem;
        $saleId = $orderItem->order->sale;
       
        $accountSale = \App\Models\Account::find($saleId);
       
        $userSale = \App\Models\User::where('account_id', $accountSale->id)->first();
        if ($userSale) {
            $users[] = $userSale;
        }
           

        $user =  $event->user;
        $users[] = $user;



        // $userSale = $event->orderItem->getUserSale();
        // $userStudent = $event->orderItem->getUserStudent();
        // $userTeacher =  $event->course->getUserTeacher();
        // $accounts = \App\Models\Account::where('id',$event->user->id)->orWhere('teacher_id',$event->teacher->id)->get();
      
        // $users = $this->user
        // 
       $student = $orderItem->order->student;
       $contact = $orderItem->order->contacts;


        // // SMS send
        if ($student->phone) {
            $mesanger = 'Hợp đồng đào tạo '. $orderItem->order->code .' đã được xếp lớp thành công.
            Tên lớp: : '.$course->code.'truy cập cổng học viên để biết thêm thông tin.';
            \App\Library\Sms::send($mesanger, $student->phone);
        }
        if($student->phone !== $contact->phone){
            $mesanger = 'Hợp đồng đào tạo '. $orderItem->order->code .' đã được xếp lớp thành công.
            Tên lớp: : '.$course->code.'truy cập cổng học viên để biết thêm thông tin.';
            \App\Library\Sms::send($mesanger, $student->phone);
        }

        // Email
        if ($student->email) {
            $m = (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('ASMS - Xếp lớp thành công')
                ->view('emails.AssigmentClass',[
                    'course'=>$course,
                    'orderItem'=>$orderItem,
                ]);

            \Illuminate\Support\Facades\Mail::to(env('MAIL_TEST_ADDRESS') ?? $student->email)->send(new \App\Library\CustomEmail($m));
        }

        // // Notify to users(accounting)
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\SendAssigmentClassNotification($orderItem,$course));

        }
       
    }
}

