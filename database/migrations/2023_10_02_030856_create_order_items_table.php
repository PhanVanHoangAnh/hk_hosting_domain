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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('type')->nullable();
            $table->string('order_type')->nullable();
            $table->string('service')->nullable();
            $table->string('package')->nullable();
            $table->string('is_by_more')->nullable();
            $table->string('train_product')->nullable();
            $table->string('abroad_product')->nullable();
            $table->integer('price')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('exchange')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('level')->nullable();
            $table->string('class_type')->nullable();
            $table->integer('num_of_student')->nullable();
            $table->string('study_type')->nullable();
            $table->string('branch')->nullable();
            $table->string('vietnam_teacher')->nullable();
            $table->string('foreign_teacher')->nullable();
            $table->string('tutor_teacher')->nullable();
            $table->integer('vietnam_teacher_minutes_per_section')->nullable();
            $table->integer('foreign_teacher_minutes_per_section')->nullable();
            $table->integer('tutor_minutes_per_section')->nullable();
            $table->decimal('target')->nullable();
            
            $table->decimal('duration')->nullable();
            $table->string('unit')->nullable();

            $table->string('has_demo_hour_deduction')->nullable();
            $table->string('have_studied')->nullable();
            $table->string('train_hours')->nullable();
            $table->string('demo_hours')->nullable();

            $table->date('apply_time')->nullable();
            $table->string('gender')->nullable();
            $table->string('current_program')->nullable();
            $table->decimal('GPA')->nullable();
            $table->string('std_score')->nullable();
            $table->string('eng_score')->nullable();
            $table->string('plan_apply')->nullable();
            $table->string('intended_major')->nullable();
            $table->string('academic_award')->nullable();
            $table->string('postgraduate_plan')->nullable();
            $table->string('personality')->nullable();
            $table->string('subject_preference')->nullable();
            $table->string('language_culture')->nullable();
            $table->string('research_info')->nullable();
            $table->string('aim')->nullable();
            $table->string('essay_writing_skill')->nullable();
            $table->string('extra_activity')->nullable();
            $table->string('personal_countling_need')->nullable();
            $table->longText('other_need_note')->nullable();
            $table->string('parent_job')->nullable();
            $table->string('parent_highest_academic')->nullable();
            $table->string('is_parent_studied_abroad')->nullable();
            $table->string('parent_income')->nullable();
            $table->string('parent_familiarity_abroad')->nullable();
            $table->string('is_parent_family_studied_abroad')->nullable();
            $table->string('parent_time_spend_with_child')->nullable();
            $table->string('financial_capability')->nullable();

            $table->json('schedule_items')->nullable();
            $table->json('top_school')->nullable();

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
