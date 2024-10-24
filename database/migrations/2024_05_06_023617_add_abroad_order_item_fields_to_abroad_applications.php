<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExcelData;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->date('apply_time')->nullable();
            $table->string('std_score')->nullable();
            $table->string('eng_score')->nullable();
            $table->string('postgraduate_plan')->nullable();
            $table->string('personality')->nullable();
            $table->string('subject_preference')->nullable();
            $table->string('language_culture')->nullable();
            $table->string('research_info')->nullable();
            $table->string('aim')->nullable();
            $table->string('essay_writing_skill')->nullable();
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
            $table->json('top_school')->nullable();
            $table->string('estimated_enrollment_time')->nullable();

            $table->unsignedBigInteger('current_program_id')->nullable();
            $table->unsignedBigInteger('plan_apply_program_id')->nullable();
            $table->unsignedBigInteger('intended_major_id')->nullable();

            $table->foreign('current_program_id')->references('id')->on('current_programs')->onDelete('set null');
            $table->foreign('plan_apply_program_id')->references('id')->on('plan_apply_programs')->onDelete('set null');
            $table->foreign('intended_major_id')->references('id')->on('intended_majors')->onDelete('set null');
        });

        $excelFile = new ExcelData();
        $academicAwardDatas = $excelFile->getDataFromSheet(ExcelData::ACADEMIC_AWARDS_SHEET_NAME, 2);
        $extraActivityDatas = $excelFile->getDataFromSheet(ExcelData::EXTRA_ACTIVITIES_SHEET_NAME, 2);
        $gradeDatas = $excelFile->getDataFromSheet(ExcelData::GPA_SHEET_NAME, 2);

        for ($i = 0; $i < count($academicAwardDatas); ++$i) {
            Schema::table('abroad_applications', function (Blueprint $table) use ($i) {
                $table->boolean('academic_award_' . $i + 1)->nullable();
            $table->text('academic_award_text_' . $i + 1)->nullable();
            });
        }

        for ($i = 0; $i < count($extraActivityDatas); ++$i) {
            Schema::table('abroad_applications', function (Blueprint $table) use ($i) {
                $table->boolean('extra_activity_' . $i + 1)->nullable();
            $table->text('extra_activity_text_' . $i + 1)->nullable();
            });
        }
        
        for ($i = 0; $i < count($gradeDatas); ++$i) {
            Schema::table('abroad_applications', function (Blueprint $table) use ($i) {
                $table->boolean('grade_' . $i + 1)->nullable();
            $table->text('point_' . $i + 1)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            // $table->dropForeign(['current_program_id']);
            
            // $table->dropColumn('apply_time');
            // $table->dropColumn('std_score');
            // $table->dropColumn('eng_score');
            // $table->dropColumn('postgraduate_plan');
            // $table->dropColumn('personality');
            // $table->dropColumn('subject_preference');
            // $table->dropColumn('language_culture');
            // $table->dropColumn('research_info');
            // $table->dropColumn('aim');
            // $table->dropColumn('essay_writing_skill');
            // $table->dropColumn('personal_countling_need');
            // $table->dropColumn('other_need_note');
            // $table->dropColumn('parent_job');
            // $table->dropColumn('parent_highest_academic');
            // $table->dropColumn('is_parent_studied_abroad');
            // $table->dropColumn('parent_income');
            // $table->dropColumn('parent_familiarity_abroad');
            // $table->dropColumn('is_parent_family_studied_abroad');
            // $table->dropColumn('parent_time_spend_with_child');
            // $table->dropColumn('financial_capability');
            // $table->dropColumn('top_school');
            // $table->dropColumn('estimated_enrollment_time');

            // $table->dropColumn('current_program_id');
            // $table->dropColumn('plan_apply_program_id');
            // $table->dropColumn('intended_major_id');
        });

        $excelFile = new ExcelData();
        $academicAwardDatas = $excelFile->getDataFromSheet(ExcelData::ACADEMIC_AWARDS_SHEET_NAME, 2);
        $extraActivityDatas = $excelFile->getDataFromSheet(ExcelData::EXTRA_ACTIVITIES_SHEET_NAME, 2);
        $gradeDatas = $excelFile->getDataFromSheet(ExcelData::GPA_SHEET_NAME, 2);

        for ($i = 0; $i < count($academicAwardDatas); ++$i) {
            Schema::table('abroad_applications', function (Blueprint $table) use ($i) {
                $table->dropColumn('academic_award_' . $i + 1);              
                $table->dropColumn('academic_award_text_' . $i + 1);              
            });
        }

        for ($i = 0; $i < count($extraActivityDatas); ++$i) {
            Schema::table('abroad_applications', function (Blueprint $table) use ($i) {
                $table->dropColumn('extra_activity_' . $i + 1);              
                $table->dropColumn('extra_activity_text_' . $i + 1);              
            });
        }

        for ($i = 0; $i < count($gradeDatas); ++$i) {
            Schema::table('abroad_applications', function (Blueprint $table) use ($i) {
                $table->dropColumn('grade_' . $i + 1);              
                $table->dropColumn('point_' . $i + 1);              
            });
        }
    }
};
