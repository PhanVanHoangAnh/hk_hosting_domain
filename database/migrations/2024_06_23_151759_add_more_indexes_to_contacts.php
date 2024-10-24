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
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('latest_activity_date');
            $table->index('google_sheet_id');
            $table->index('latest_sub_channel');
            $table->index('assigned_at');
            $table->index('assigned_expired_at');
            $table->index('created_at');
            $table->index('updated_at');
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->index('latest_activity_date');
            $table->index('google_sheet_id');
            $table->index('latest_sub_channel');
            $table->index('assigned_at');
            $table->index('assigned_expired_at');
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
};
