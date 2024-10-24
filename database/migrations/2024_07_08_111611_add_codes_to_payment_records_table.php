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
        Schema::table('payment_records', function (Blueprint $table) {
            $table->integer('code_year')->nullable();
            $table->integer('code_month')->nullable();
            $table->integer('code_day')->nullable();
            $table->integer('code_number')->nullable();
            $table->string('code_name')->nullable();
            $table->string('code')->nullable();
            //
            $table->index('code_year');
            $table->index('code_month');
            $table->index('code_day');
            $table->index('code_number');
            $table->index('code_name');
            $table->index('code');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_records', function (Blueprint $table) {
            //
        });
    }
};
