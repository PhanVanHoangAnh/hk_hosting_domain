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
            $table->timestamp('google_form_submit_date')->nullable();
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->timestamp('google_form_submit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('google_form_submit_date');
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropColumn('google_form_submit_date');
        });
    }
};
