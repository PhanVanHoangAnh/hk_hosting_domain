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
        Schema::create('free_time_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
 
            $table->integer('day_of_week')->unsigned();
            $table->time('from');
            $table->time('to');

            $table->unsignedBigInteger('free_time_id')->nullable(); 
            $table->foreign('free_time_id')->references('id')->on('free_times')->onDelete('cascade');

            $table->unsignedBigInteger('teacher_id')->nullable(); 
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            $table->unsignedBigInteger('contact_request_id')->nullable(); 
            $table->foreign('contact_request_id')->references('id')->on('contact_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_time_records');
    }
};
