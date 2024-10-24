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
            $table->decimal('scholarship', 16, 2)->nullable();
            $table->string('result')->nullable();
            $table->string('scholarship_file')->nullable();
            $table->string('study')->nullable();
            $table->string('status_recruitment_results')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_school', function (Blueprint $table) {
            //
            $table->dropColumn(['scholarship', 'result', 'scholarship_file', 'study','status','status_recruitment_results']);
        });
    }
   
};
