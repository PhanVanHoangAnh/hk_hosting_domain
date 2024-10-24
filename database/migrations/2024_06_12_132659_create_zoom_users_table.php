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
        Schema::create('zoom_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('user_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('email')->nullable();
            $table->string('type')->nullable();
            $table->string('pmi')->nullable();
            $table->string('timezone')->nullable();
            $table->string('verified')->nullable();
            $table->string('dept')->nullable();
            $table->string('record_created_at')->nullable();
            $table->string('last_login_time')->nullable();
            $table->string('pic_url')->nullable();
            $table->string('language')->nullable();
            $table->string('status')->nullable();
            $table->string('role_id')->nullable();
            $table->string('user_created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_users');
    }
};
