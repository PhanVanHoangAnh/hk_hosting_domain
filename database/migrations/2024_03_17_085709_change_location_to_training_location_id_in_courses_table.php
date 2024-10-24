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
            $table->dropColumn('location');
            $table->unsignedBigInteger('training_location_id')->nullable();

            // Check if foreign key constraint exists before creating it
            if (!Schema::hasColumn('courses', 'training_location_id')) {
                $table->foreign('training_location_id')
                      ->references('id')->on('training_locations')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Check if foreign key constraint exists before dropping it
            if (Schema::hasColumn('courses', 'training_location_id')) {
                $table->dropForeign(['training_location_id']);
            }

            $table->dropColumn('training_location_id');
            $table->string('location');
        });
    }
};
