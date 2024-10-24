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
            $table->index('channel');
            $table->index('sub_channel');
            $table->index('lead_status');
            $table->index('source_type');
            $table->index('added_from');
            $table->index('lifecycle_stage');
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->index('channel');
            $table->index('sub_channel');
            $table->index('lead_status');
            $table->index('source_type');
            $table->index('added_from');
            $table->index('lifecycle_stage');
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
