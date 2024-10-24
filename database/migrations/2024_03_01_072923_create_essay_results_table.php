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
        Schema::create('essay_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('abroad_application_id');
            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');

            $table->string('school')->nullable();
            $table->text('content')->nullable();
            $table->integer('word_count')->nullable();
            $table->string('classification')->nullable();
            $table->string('quality_of_content')->nullable();
            $table->string('execution')->nullable();
            $table->string('personal_voice')->nullable();
            $table->string('overall')->nullable();
            $table->string('path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('essay_results');
    }
};
