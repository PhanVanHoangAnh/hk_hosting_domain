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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');

            $table->unsignedBigInteger('sale')->nullable();
            $table->foreign('sale')->references('id')->on('accounts')->onDelete('cascade');

            $table->unsignedBigInteger('sale_sup')->nullable();
            $table->string('fullname')->nullable();
            $table->date("birthday")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("current_school")->nullable();
            $table->longText("parent_note")->nullable();
            $table->string("industry")->nullable();
            $table->string("type")->nullable();
            $table->string("status");
            $table->text("rejected_reason")->nullable();
            $table->string('price')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('exchange')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('is_pay_all')->nullable();
            $table->json('schedule_items')->nullable();

            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
