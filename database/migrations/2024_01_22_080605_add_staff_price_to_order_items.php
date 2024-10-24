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
            $table->decimal('vn_teacher_price', 16, 2)->nullable();
            $table->decimal('foreign_teacher_price', 16, 2)->nullable();
            $table->decimal('tutor_price', 16, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['vn_teacher_price', 'foreign_teacher_price', 'tutor_price']);
        });
    }
};
