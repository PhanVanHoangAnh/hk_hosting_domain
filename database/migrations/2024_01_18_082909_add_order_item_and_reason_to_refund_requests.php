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
        Schema::table('refund_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->text('reason')->nullable();

            // Foreign key constraint for order_item_id
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refund_requests', function (Blueprint $table) {
            //
            // Drop the foreign key constraint
            $table->dropForeign(['order_item_id']);

            // Drop the columns
            $table->dropColumn(['order_item_id', 'reason']);
        });
    }
};
