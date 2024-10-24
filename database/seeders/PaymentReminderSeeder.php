<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\PaymentReminder;
use Illuminate\Support\Facades\Log;

class PaymentReminderSeeder extends Seeder
{
    public function run()
    {
        // delete all reminders
        PaymentReminder::query()->delete();

        $orders = Order::all();
        
        foreach ($orders as $order) {
            $order->updateReminders();
            // Thêm log để kiểm tra xem có đang chạy vào đây không
            // Log::info('Updated reminders for order ID: ' . $order->id);
        }
    }
}
