<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Import from HubSpot
        $schedule->call(function () {
            if (\App\Models\Setting::get('hubspot.auto_update')) {
                \App\Models\Contact::importFromHubspot(1,100);
            }
        })->everyMinute();

        // Import from Google Sheet
        // $schedule->command('app:import-from-google-sheet')->everyFiveMinutes();

        // $schedule->command('out_date_contact_request:cron')->everyMinute();

        // // Đơn hàng quá hạn 2 tiếng chưa khai thác
        // $schedule->command('unfulfill_over_2_hours:cron')->everyMinute();

        // // Quá hạn duyệt hợp đồng
        // $schedule->command('out_date_approval_contract:cron')->timezone('Asia/Ho_Chi_Minh')->everyMinute()->between('8:00', '17:00');

        // // Công nợ
        // $schedule->command('debt_reminders:cron')->timezone('Asia/Ho_Chi_Minh')->dailyAt('9:00');

        // Săp hết giờ chôt ca
        $schedule->command('almost_time_save_shift:cron')->everyMinute();

        // Quá giờ chốt ca
        $schedule->command('over_time_save_shift:cron')->everyMinute();

        // Sắp tới giờ học
        // $schedule->command('upcoming_class:cron')->everyMinute();

        //Sắp tới giờ học
        $schedule->command('send-students-to-study-abroad:cron')->timezone('Asia/Ho_Chi_Minh')->dailyAt('9:00');

        // // Cảnh báo dự thu chưa thu được
        $schedule->command('payment_reminder_out_date:cron')->timezone('Asia/Ho_Chi_Minh')->dailyAt('9:00');

        // Thông báo kiểm tra báo cáo upsell đào tạo sáng thứ 2 hàng tuần
        // $schedule->command('weekly-upsell-report-check:cron')->timezone('Asia/Ho_Chi_Minh')->weeklyOn(1, '9:00');

        // Tiến độ KPI
        // $schedule->command('weekly-kpi-check:cron')->timezone('Asia/Ho_Chi_Minh')->weeklyOn(1, '9:00');
        // $schedule->command('send-weekly-report-kpi:cron')->timezone('Asia/Ho_Chi_Minh')->weeklyOn(1, '9:00');
        // $schedule->command('send-monthly-report-kpi:cron')->monthly()->timezone('Asia/Ho_Chi_Minh')->at('9:00');

        // Call api to zoom serve to get all users and update to zoom_users table
        $schedule->command('update-zoom-users:cron')->everyMinute();

        //Đặt lịch hẹn sales
        $schedule->command('reminder-contact-request:cron')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
