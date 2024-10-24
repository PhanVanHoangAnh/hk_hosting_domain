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
        Schema::table('lo_trinh_ht_cl', function (Blueprint $table) {
            //
            $table->string('frequency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lo_trinh_ht_cl', function (Blueprint $table) {
            //
            $table->dropColumn('frequency');
        });
    }
};
