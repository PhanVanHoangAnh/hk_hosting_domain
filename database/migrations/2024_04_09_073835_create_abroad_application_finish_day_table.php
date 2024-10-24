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
        Schema::create('abroad_application_finish_day', function (Blueprint $table) {
            $table->id();
            $table->date('lo_trinh_ht_cl')->nullable();
            $table->date('lo_trinh_hd_nk')->nullable();
            $table->date('application_school')->nullable();
            $table->date('extracurricular_schedule')->nullable();
            $table->date('certificate')->nullable();
            $table->date('extracurricular_activity')->nullable();
            $table->date('recommendation_letters')->nullable();
            $table->date('essay_results')->nullable();
            $table->date('social_network')->nullable();
            $table->date('financial_document')->nullable();
            $table->date('student_cv')->nullable();
            $table->date('study_abroad_applications')->nullable();
            $table->date('complete_file')->nullable();
            $table->date('admission_letter')->nullable();
            $table->date('scan_of_information')->nullable();
            $table->date('application_fees')->nullable();
            $table->unsignedBigInteger('abroad_application_id');
            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abroad_application_finish_day');
    }
};
