<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyExtracurricularActivityTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('extracurricular_activity', function (Blueprint $table) {
            // Xoá cột execution_date và link
            $table->dropColumn('execution_date');
            $table->dropColumn('link');

            // Thêm các cột mới
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->string('link_document')->nullable();
            $table->string('link_file')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->string('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular_activity', function (Blueprint $table) {
            // Thêm lại cột execution_date và link
            $table->date('execution_date')->nullable();
            $table->string('link')->nullable();

            // Xoá các cột mới
            $table->dropColumn('start_at');
            $table->dropColumn('end_at');
            $table->dropColumn('link_document');
            $table->dropColumn('link_file');
            $table->dropColumn('category');
            $table->dropColumn('status');
            $table->dropColumn('role');
        });
    }
}
