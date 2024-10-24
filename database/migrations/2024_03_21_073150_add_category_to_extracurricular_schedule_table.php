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
        Schema::table('extracurricular_schedule', function (Blueprint $table) {
            //
            $table->string('category')->nullable()->after('link');
            $table->string('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular_schedule', function (Blueprint $table) {
            //
            $table->dropColumn('category');
            $table->dropColumn('role');
        });
    }
};