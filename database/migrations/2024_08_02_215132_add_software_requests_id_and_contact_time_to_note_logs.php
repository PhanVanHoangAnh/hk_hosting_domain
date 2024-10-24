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
        Schema::table('note_logs', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('software_request_id')->nullable();
            $table->foreign('software_request_id')->references('id')->on('software_requests')->onDelete('set null');

            $table->timestamp('contact_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('note_logs', function (Blueprint $table) {
            $table->dropForeign(['software_request_id']);
            $table->dropColumn('software_request_id');
            $table->dropColumn('contact_time');
        });
    }
};
