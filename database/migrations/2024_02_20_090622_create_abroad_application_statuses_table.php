<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abroad_application_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abroad_application_id');
            $table->unsignedBigInteger('abroad_status_id');
            $table->timestamps();

            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');
            $table->foreign('abroad_status_id')->references('id')->on('abroad_statuses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abroad_application_statuses');
    }
};
