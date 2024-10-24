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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('debt_allow')->nullable();
            $table->date('debt_due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'debt_allow')) {
                $table->dropColumn('debt_allow');
            }

            if (Schema::hasColumn('orders', 'debt_due_date')) {
                $table->dropColumn('debt_due_date');
            }
            //
        });
    }
};
