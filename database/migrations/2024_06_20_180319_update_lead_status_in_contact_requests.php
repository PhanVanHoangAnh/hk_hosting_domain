<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            $statusMapping = [
                'Sai số' => 'ls_error',
                'Không nghe máy, gọi lại sau' => 'ls_not_pick_up',
                'Có đơn hàng' => 'ls_has_request',
                'Follow dài' => 'ls_follow',
                'Tiềm năng' => 'ls_potential',
                'Hợp đồng AS' => 'ls_customer',
                'Đang làm hợp đồng' => 'ls_making_contract',
            ];
    
            
            foreach ($statusMapping as $oldStatus => $newStatus) {
                DB::table('contact_requests')
                    ->where('lead_status', $oldStatus)
                    ->update(['lead_status' => $newStatus]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            $statusMapping = [
                'ls_error' => 'Sai số',
                'ls_not_pick_up' => 'Không nghe máy, gọi lại sau',
                'ls_has_request' => 'Có đơn hàng',
                'ls_follow' => 'Follow dài',
                'ls_potential' => 'Tiềm năng',
                'ls_customer' => 'Hợp đồng AS',
                'ls_making_contract' => 'Đang làm hợp đồng',
            ];
    
            
            foreach ($statusMapping as $newStatus => $oldStatus) {
                DB::table('contact_requests')
                    ->where('lead_status', $newStatus)
                    ->update(['lead_status' => $oldStatus]);
            }
        });
    }
};
