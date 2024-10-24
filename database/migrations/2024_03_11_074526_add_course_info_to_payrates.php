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
        Schema::table('payrates', function (Blueprint $table) {
            $table->string('study_method')->nullable();
            $table->string('class_status')->nullable();
            $table->integer('class_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrates', function (Blueprint $table) {
            $table->dropColumn('study_method');
            $table->dropColumn('class_status');
            $table->dropColumn('class_size');
        });
    }
};
