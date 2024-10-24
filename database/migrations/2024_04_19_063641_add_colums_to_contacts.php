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
            //
            $table->date('hubspot_modified_at')->nullable()->after('hubspot_id');
            $table->date('hubspot_created_at')->nullable()->after('hubspot_modified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
            $table->dropColumn('hubspot_modified_at');
            $table->dropColumn('hubspot_created_at');
        });
    }
};
