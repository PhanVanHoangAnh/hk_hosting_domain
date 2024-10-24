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
        Schema::create('extracurricular_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abroad_application_id');
            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');
            $table->string('name');
            $table->string('address')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_schedule');
    }
};
