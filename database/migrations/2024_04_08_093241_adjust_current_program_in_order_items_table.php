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
            $table->dropColumn('current_program');
            $table->unsignedBigInteger('current_program_id')->nullable();
            $table->foreign('current_program_id')->references('id')->on('current_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('current_program')->nullable();

            $table->dropForeign(['current_program_id']);
            $table->dropColumn('current_program_id');
        });
    }
};
