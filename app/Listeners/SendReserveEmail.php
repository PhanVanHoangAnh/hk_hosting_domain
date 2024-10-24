<?php

namespace App\Listeners;

use App\Events\UpdateReserve;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReserveEmail
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
    public function handle(UpdateReserve $event): void
    {
        $users=[];
        $orderItem = OrderItem::whereIn('id', $event->orderItemIds)->first();
        $student = $orderItem->order->student;
        $contact = $orderItem->order->contacts;
    
        $accountStudent = \App\Models\Account::where('student_id',$student->id)->first();
        if($accountStudent){
            $userStudent = \App\Models\User::where('account_id', $accountStudent->id)->first();
            $userStudent->notify(new \App\Notifications\SendReserveEmail($event->orderItemIds,$event->reserveStartAt,$event->reserveEndAt ));
    
        }
      
      

        // $teacherCurrentCourseIds = $currentCourse->getTeachersFromCourse();
        // foreach ($teacherCurrentCourseIds as $teacherCurrentCourseId){
        //     $accounts = \App\Models\Account::where('teacher_id',$teacherCurrentCourseId)->get();
        //     foreach ($accounts as $account) {
        //             $userTeacher = \App\Models\User::where('account_id', $account->id)->first();
        //             if ($userTeacher) {
        //                 $users[] = $userTeacher;
        //             }
        //         }
        // }

        // $teacherCourseTransferIds = $courseTransfer->getTeachersFromCourse();
        // foreach ($teacherCourseTransferIds as $teacherCourseTransferId){
        //     $accounts = \App\Models\Account::where('teacher_id',$teacherCourseTransferId)->get();
        //     foreach ($accounts as $account) {
        //             $userTeacher = \App\Models\User::where('account_id', $account->id)->first();
        //             if ($userTeacher) {
        //                 $users[] = $userTeacher;
        //             }
        //         }
        // }
       
        // $orderItem = $event->orderItem;
        // $saleId = $orderItem->order->sale;
       
        // $accountSale = \App\Models\Account::find($saleId);
       
        // $userSale = \App\Models\User::where('account_id', $accountSale->id)->first();
        // if ($userSale) {
        //     $users[] = $userSale;
        // }
           

        // $user =  $event->user;
        // $users[] = $user;
      
        // // // Notify to users(accounting)
        // foreach ($users as $user) {
        //     $user->notify(new \App\Notifications\SendUpdateReserveNotification($currentCourse, $courseTransfer, $orderItem));

        // }

           

      
       
    }
}

