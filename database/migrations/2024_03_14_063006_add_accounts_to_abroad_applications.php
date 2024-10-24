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
        Schema::table('abroad_applications', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('account_1')->nullable();
            $table->unsignedBigInteger('account_2')->nullable();

            $table->foreign('account_1')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('account_2')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            //
            $table->dropForeign(['account_1']);
            $table->dropForeign(['account_2']);

            $table->dropColumn('account_1');
            $table->dropColumn('account_2');
        });
    }
};
