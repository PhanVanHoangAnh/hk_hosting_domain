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
        Schema::create('staff_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('group_manager_id');
            $table->unsignedBigInteger('default_payment_account_id');
            $table->string('type');
            $table->timestamps();

            $table->foreign('group_manager_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('default_payment_account_id')->references('id')->on('payment_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_groups');
    }
};
