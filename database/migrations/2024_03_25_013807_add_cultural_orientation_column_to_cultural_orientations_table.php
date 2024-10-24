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
        Schema::table('cultural_orientations', function (Blueprint $table) {
            
            $table->boolean('american_cultural_education_status')->default(false);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cultural_orientations', function (Blueprint $table) {
            Schema::table('cultural_orientations', function (Blueprint $table) {
                $table->dropColumn('american_cultural_education_status');
            });
        });
    }
};
