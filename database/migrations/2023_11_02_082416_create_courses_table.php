<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Course;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->nullable();
            $table->string('study_method')->nullable();
            $table->longText('location')->nullable();
            $table->longText('zoom_start_link')->nullable();
            $table->longText('zoom_join_link')->nullable();
            $table->longText('zoom_password')->nullable();
            $table->string('level')->nullable();
            $table->string('status')->default(Course::WAITING_OPEN_STATUS)->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->integer('vn_teacher_duration')->nullable(); // minutes
            $table->integer('foreign_teacher_duration')->nullable(); // minutes
            $table->integer('tutor_duration')->nullable(); // minutes
            $table->integer('assistant_duration')->nullable(); // minutes
            $table->integer('duration_each_lesson')->nullable(); // temporary deny -> set nullable
            $table->integer('max_students')->nullable();
            $table->integer('min_students')->nullable();
            $table->integer('joined_students')->nullable();
            $table->json('flexible_students')->nullable();
            $table->decimal('total_hours')->nullable();
            $table->json('week_schedules')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
