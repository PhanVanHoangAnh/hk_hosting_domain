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
        Schema::create('abroad_application_done', function (Blueprint $table) {
            $table->id();
            $table->string('lo_trinh_ht_cl')->nullable();
            $table->string('lo_trinh_hd_nk')->nullable();
            $table->string('application_school')->nullable();
            $table->string('extracurricular_schedule')->nullable();
            $table->string('certificate')->nullable();
            $table->string('extracurricular_activity')->nullable();
            $table->string('recommendation_letters')->nullable();
            $table->string('essay_results')->nullable();
            $table->string('social_network')->nullable();
            $table->string('financial_document')->nullable();
            $table->string('student_cv')->nullable();
            $table->string('study_abroad_applications')->nullable();
            $table->string('complete_file')->nullable();
            $table->string('admission_letter')->nullable();
            $table->string('scan_of_information')->nullable();
            $table->string('application_fees')->nullable();
            $table->string('hsdt')->nullable();
            $table->string('deposit_for_school')->nullable();
            $table->string('cultural_orientation')->nullable();
            $table->string('support_activity')->nullable();
            $table->string('complete_application')->nullable();


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
        Schema::dropIfExists('abroad_application_done');
    }
};
