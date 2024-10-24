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
        Schema::table('application_school', function (Blueprint $table) {
            //
            $table->string('study_abroad_application')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_school', function (Blueprint $table) {
            //
            $table ->dropColumn('study_abroad_application');
        });
    }
};
