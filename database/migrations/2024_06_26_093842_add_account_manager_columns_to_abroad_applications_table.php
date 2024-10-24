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
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('account_manager_extracurricular_id')->nullable();
            $table->unsignedBigInteger('account_manager_abroad_id')->nullable();

            $table->foreign('account_manager_extracurricular_id')->references('id')->on('accounts')->onDelete('set null');
            $table->foreign('account_manager_abroad_id')->references('id')->on('accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
             $table->dropForeign(['account_manager_extracurricular_id']);
             $table->dropForeign(['account_manager_abroad_id']);
 
             $table->dropColumn('account_manager_extracurricular_id');
             $table->dropColumn('account_manager_abroad_id');
        });
    }
};
