<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExtracurricularPlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('extracurricular_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abroad_application_id');
            $table->date('time')->nullable();
            $table->string('content')->nullable();
            $table->string('status')->default(ExtracurricularPlan::STATUS_TEMPORARY)->nullable();
            $table->timestamps();

            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_plans');
    }
};
