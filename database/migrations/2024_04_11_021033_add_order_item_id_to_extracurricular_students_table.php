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
        Schema::table('extracurricular_students', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular_students', function (Blueprint $table) {
            //
            $table->dropForeign(['order_item_id']);
            $table->dropColumn(['order_item_id']);
        });
    }
};