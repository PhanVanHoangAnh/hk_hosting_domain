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
        Schema::table('extracurricular', function (Blueprint $table) {
            //
            $table->integer('hours_per_week')->nullable();
            $table->integer('weeks_per_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular', function (Blueprint $table) {
            //
            $table->dropColumn('hours_per_week');
            $table->dropColumn('weeks_per_year');

        });
    }
};
