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
        Schema::table('free_times', function (Blueprint $table) {
            $table->renameColumn('contact_request_id', 'contact_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_times', function (Blueprint $table) {
            $table->renameColumn('contact_id', 'contact_request_id');
        });
    }
};
