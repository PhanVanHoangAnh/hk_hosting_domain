<?php

namespace App\Listeners;

use App\Events\TransferCourse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTransferCourseNotification
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
    public function handle(TransferCourse $event): void
    {
        $users=[];
        $currentCourse = $event->currentCourse ;
        $courseTransfer = $event->courseTransfer ;

        $teacherCurrentCourseIds = $currentCourse->getTeachersFromCourse();
        foreach ($teacherCurrentCourseIds as $teacherCurrentCourseId){
            $accounts = \App\Models\Account::where('teacher_id',$teacherCurrentCourseId)->get();
            foreach ($accounts as $account) {
                    $userTeacher = \App\Models\User::where('account_id', $account->id)->first();
                    if ($userTeacher) {
                        $users[] = $userTeacher;    
                    }
                }
        }

        $teacherCourseTransferIds = $courseTransfer->getTeachersFromCourse();
        foreach ($teacherCourseTransferIds as $teacherCourseTransferId){
            $accounts = \App\Models\Account::where('teacher_id',$teacherCourseTransferId)->get();
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
      
        // // Notify to users(accounting)
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\SendTransferCourseNotification($currentCourse, $courseTransfer, $orderItem));

        }
///SMS
       
                    
        if ($orderItem->order->student->phone) {
            $message = 'Thông tin chuyển lớp của môn học:'.$currentCourse->subject->name.' từ lớp ' .$currentCourse->code. 'sang lớp X02'.$courseTransfer->code.'Truy cập hệ thống để biết thêm thông tin';
            \App\Library\Sms::send($message, $teacherCourseTransferId->phone);
            
        }
        if ($orderItem->order->student->phone !==$orderItem->order->contacts->phone ) {
            $message = 'Thông tin chuyển lớp của môn học:'.$currentCourse->subject->name.' từ lớp ' .$currentCourse->code. 'sang lớp X02'.$courseTransfer->code.'Truy cập hệ thống để biết thêm thông tin';
            \App\Library\Sms::send($message, $teacherCourseTransferId->phone);
            
        }
        
        foreach ($teacherCourseTransferIds as $teacherCourseTransferId){
               
            if ($teacherCourseTransferId->phone) {
                
                $message = 'Thông tin chuyển lớp của môn học:'.$currentCourse->subject->name.' từ lớp ' .$currentCourse->code. 'sang lớp X02'.$courseTransfer->code.'Truy cập hệ thống để biết thêm thông tin';
                \App\Library\Sms::send($message, $teacherCourseTransferId->phone);
                
            }
        }  

        foreach ($teacherCurrentCourseIds as $teacherCurrentCourseIds){
               
            if ($teacherCurrentCourseIds->phone) {
                
                $message = 'Thông tin chuyển lớp của môn học:'.$currentCourse->subject->name.' từ lớp ' .$currentCourse->code. 'sang lớp X02'.$courseTransfer->code.'Truy cập hệ thống để biết thêm thông tin';
                \App\Library\Sms::send($message, $teacherCurrentCourseIds->phone);
                
            }
        }
   



}
}

