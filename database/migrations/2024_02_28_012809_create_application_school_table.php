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
        Schema::create('application_school', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abroad_application_id');
            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');
            $table->string('school')->nullable();
            $table->date('apply_date')->nullable();
            $table->string('type')->nullable();
            $table->string('requirement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_school');
    }
};
