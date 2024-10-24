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
        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('vn_teacher_id')->nullable();
            $table->unsignedBigInteger('foreign_teacher_id')->nullable();
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->unsignedBigInteger('assistant_id')->nullable();
            
            $table->foreign('vn_teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('foreign_teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('assistant_id')->references('id')->on('teachers')->onDelete('cascade');
            
            $table->string('vn_teacher_from')->nullable();
            $table->string('vn_teacher_to')->nullable();
            $table->string('foreign_teacher_from')->nullable();
            $table->string('foreign_teacher_to')->nullable();
            $table->string('tutor_from')->nullable();
            $table->string('tutor_to')->nullable();
            $table->string('assistant_from')->nullable();
            $table->string('assistant_to')->nullable();

            $table->string('is_vn_teacher_check')->nullable();
            $table->string('is_foreign_teacher_check')->nullable();
            $table->string('is_tutor_check')->nullable();
            $table->string('is_assistant_check')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['vn_teacher_id']);
            $table->dropColumn('vn_teacher_id');
            $table->dropForeign(['foreign_teacher_id']);
            $table->dropColumn('foreign_teacher_id');
            $table->dropForeign(['tutor_id']);
            $table->dropColumn('tutor_id');
            $table->dropForeign(['assistant_id']);
            $table->dropColumn('assistant_id');
            
            $table->dropColumn('vn_teacher_from');
            $table->dropColumn('vn_teacher_to');
            $table->dropColumn('foreign_teacher_from');
            $table->dropColumn('foreign_teacher_to');
            $table->dropColumn('tutor_from');
            $table->dropColumn('tutor_to');
            $table->dropColumn('assistant_from');
            $table->dropColumn('assistant_to');

            $table->dropColumn('is_vn_teacher_check');
            $table->dropColumn('is_foreign_teacher_check');
            $table->dropColumn('is_tutor_check');
            $table->dropColumn('is_assistant_check');
        });
    }
};

