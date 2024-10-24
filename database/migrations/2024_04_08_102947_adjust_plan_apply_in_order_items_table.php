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
            $table->dropColumn('plan_apply');
            $table->unsignedBigInteger('plan_apply_program_id')->nullable();
            $table->foreign('plan_apply_program_id')->references('id')->on('plan_apply_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('plan_apply')->nullable();

            $table->dropForeign(['plan_apply_program_id']);
            $table->dropColumn('plan_apply_program_id');
        });
    }
};
