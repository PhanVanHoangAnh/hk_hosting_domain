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
            $table->unsignedBigInteger('abroad_payment_account_id')->nullable();
            $table->unsignedBigInteger('edu_payment_account_id')->nullable();
            $table->unsignedBigInteger('extracurricular_payment_account_id')->nullable();
            $table->unsignedBigInteger('teach_payment_account_id')->nullable();

            $table->foreign('abroad_payment_account_id')->references('id')->on('payment_accounts')->onDelete('cascade');
            $table->foreign('edu_payment_account_id')->references('id')->on('payment_accounts')->onDelete('cascade');
            $table->foreign('extracurricular_payment_account_id')->references('id')->on('payment_accounts')->onDelete('cascade');
            $table->foreign('teach_payment_account_id')->references('id')->on('payment_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_groups', function (Blueprint $table) {
            $table->dropForeign(['abroad_payment_account_id']);
            $table->dropForeign(['edu_payment_account_id']);
            $table->dropForeign(['extracurricular_payment_account_id']);
            $table->dropForeign(['teach_payment_account_id']);

            $table->dropColumn(['abroad_payment_account_id']);
            $table->dropColumn(['edu_payment_account_id']);
            $table->dropColumn(['extracurricular_payment_account_id']);
            $table->dropColumn(['teach_payment_account_id']);
        });
    }
};
