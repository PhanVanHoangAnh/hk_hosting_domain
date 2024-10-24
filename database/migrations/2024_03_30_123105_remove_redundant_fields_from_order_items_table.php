<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * remove from order_items: discount_code, exchange, have_studied, train_hours, demo_hours, gender,
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn("discount_code");
            $table->dropColumn("have_studied");
            $table->dropColumn("has_demo_hour_deduction");
            $table->dropColumn("train_hours");
            $table->dropColumn("demo_hours");
            $table->dropColumn("exchange");
            $table->dropColumn("gender");
            $table->dropColumn("is_by_more");
            $table->dropColumn("service");
            $table->dropColumn("package");
            $table->dropColumn("train_product");
            $table->dropColumn("abroad_product");
            $table->dropColumn("vietnam_teacher");
            $table->dropColumn("foreign_teacher");
            $table->dropColumn("tutor_teacher");
            $table->dropColumn("duration");
            $table->dropColumn("unit");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string("discount_code");
            $table->string("have_studied");
            $table->string("has_demo_hour_deduction");
            $table->string("demo_hours");
            $table->string("train_hours");
            $table->string("exchange");
            $table->string("gender");
            $table->string("is_by_more");
            $table->string("service");
            $table->string("package");
            $table->string("train_product");
            $table->string("abroad_product");
            $table->string("vietnam_teacher");
            $table->string("foreign_teacher");
            $table->string("tutor_teacher");
            $table->string("duration");
            $table->string("unit");
        });
    }
};
