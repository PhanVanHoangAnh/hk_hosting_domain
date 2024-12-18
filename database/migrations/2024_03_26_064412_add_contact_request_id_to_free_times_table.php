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
        Schema::table('free_times', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_request_id')->nullable(); 
            $table->foreign('contact_request_id')->references('id')->on('contact_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        Schema::table('free_times', function (Blueprint $table) {
            // $table->dropForeign(['contact_id']);
            // $table->dropColumn('contact_request_id');
        });
    }
};
