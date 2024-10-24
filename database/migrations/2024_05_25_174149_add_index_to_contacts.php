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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index('name');
            $table->index('demand');
            $table->index('phone');
            $table->index('email');
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->index('name');
            $table->index('demand');
            $table->index('phone');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
};
