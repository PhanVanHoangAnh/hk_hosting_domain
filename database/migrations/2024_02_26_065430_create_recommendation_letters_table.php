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
        Schema::create('recommendation_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abroad_application_id');
            $table->unsignedBigInteger('account_id');
            $table->string('name');
            $table->string('path');
            $table->date('date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_letters');
    }
};
