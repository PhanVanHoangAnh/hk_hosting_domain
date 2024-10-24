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
            $table->string('added_from')->nullable();
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->string('added_from')->nullable();
        });

        // Update all contact added_from if null
        \App\Models\Contact::whereNull('added_from')->update([
            'added_from' => \App\Models\Contact::ADDED_FROM_SYSTEM,
        ]);

        \App\Models\ContactRequest::whereNull('added_from')->update([
            'added_from' => \App\Models\Contact::ADDED_FROM_SYSTEM,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('added_from');
        });

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropColumn('added_from');
        });
    }
};
