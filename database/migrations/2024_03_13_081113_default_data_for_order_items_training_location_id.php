<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Fix cho dữ liệu hiện tại của hệ thống
            if (\App\Models\TrainingLocation::first()) {
                // Giá trị mặc định cho training_location_id nếu order item chưa có
                \App\Models\OrderItem::whereNull('training_location_id')
                    ->update(['training_location_id' => \App\Models\TrainingLocation::first()->id]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
};
