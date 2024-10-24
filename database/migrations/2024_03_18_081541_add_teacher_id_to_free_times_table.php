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
            $table->unsignedBigInteger('teacher_id')->nullable(); 
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });

        Schema::table('free_time_records', function (Blueprint $table) { 
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_times', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });

        Schema::table('free_time_records', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->after('to');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }
};
