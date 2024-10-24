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
            $table->dropColumn('intended_major');
            $table->unsignedBigInteger('intended_major_id')->nullable();
            $table->foreign('intended_major_id')->references('id')->on('intended_majors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('intended_major')->nullable();

            $table->dropForeign(['intended_major_id']);
            $table->dropColumn('intended_major_id');
        });
    }
};
