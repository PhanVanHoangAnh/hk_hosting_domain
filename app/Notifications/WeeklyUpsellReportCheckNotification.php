<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Carbon\Carbon;

use App\Models\User;
use App\Models\ExcelExport;
use App\Helpers\Excel;
use Illuminate\Support\Facades\Log;

class WeeklyUpsellReportCheckNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }   

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Get current day
        $now = Carbon::now();
        
        // Get monday in last week
        $dateFrom = $now->startOfWeek()->subWeek()->toDateString();
        
        // Get the sunday in last week
        $dateTo = $now->startOfWeek()->subDay()->toDateString();

        $account = $notifiable->account;

        if ($account) {
            // Export report file
            $upsellReportFilePath = Excel::exportUpsellReportExcelFile($account->id, $dateFrom, $dateTo);

    
            // Send mail with file
            return (new MailMessage)
                        ->line('Thông báo từ ASMS')
                        ->line('Bạn cần kiểm tra lại báo cáo upsell đào tạo!')
                        ->attach($upsellReportFilePath, [
                            'as' => 'upsell_report.xlsx',
                            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ]);
        } else {
            // Send mail without file
            return (new MailMessage)
                        ->line('Thông báo từ ASMS')
                        ->line('Bạn cần kiểm tra lại báo cáo upsell đào tạo!');
        }

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Bạn cần kiểm tra lại báo cáo upsell đào tạo!"
        ];
    }
}
