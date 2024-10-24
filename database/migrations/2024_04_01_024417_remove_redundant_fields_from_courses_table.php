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
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn("joined_students");
            $table->dropColumn("flexible_students");
            $table->dropColumn("type");
            $table->dropColumn("stopped_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer("joined_students")->nullable();
            $table->integer("flexible_students")->nullable();
            $table->string("type")->nullable();
            $table->date("stopped_at")->nullable();
        });
    }
};
