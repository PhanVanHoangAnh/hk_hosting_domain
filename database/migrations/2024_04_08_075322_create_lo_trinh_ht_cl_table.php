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
        Schema::create('lo_trinh_ht_cl', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('content')->nullable();
            $table->date('intend_time')->nullable();
            $table->string('taget')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('abroad_application_id');
            $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lo_trinh_ht_cl');
    }
};
