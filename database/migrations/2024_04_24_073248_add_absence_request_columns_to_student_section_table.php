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
        Schema::table('student_section', function (Blueprint $table) {
            $table->string('absence_request_reason')->nullable();
            $table->dateTime('absence_request_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_section', function (Blueprint $table) {
            $table->dropColumn('absence_request_reason');
            $table->dropColumn('absence_request_at');
        });
    }
};
