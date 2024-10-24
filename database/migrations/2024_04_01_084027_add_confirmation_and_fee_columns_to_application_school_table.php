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
        Schema::table('application_school', function (Blueprint $table) {
            $table->string('file_confirmation')->nullable();
            $table->string('file_fee_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_school', function (Blueprint $table) {
            $table->dropColumn('file_confirmation');
            $table->dropColumn('file_fee_paid');
        });
    }
};
