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
        Schema::table('account_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('manager_id')->nullable();

            $table->foreign('manager_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_groups', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);

            $table->dropColumn(['manager_id']);
        });
    }
};
