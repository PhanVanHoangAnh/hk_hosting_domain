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
            $table->integer('num_of_vn_teacher_sections')->nullable();
            $table->integer('num_of_foreign_teacher_sections')->nullable();
            $table->integer('num_of_tutor_sections')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('num_of_vn_teacher_sections');
            $table->dropColumn('num_of_foreign_teacher_sections');
            $table->dropColumn('num_of_tutor_sections');
        });
    }
};
