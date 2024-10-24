<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AbroadApplication;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('deposit_cost')->nullable();
            $table->string('deposit_status')->default(AbroadApplication::STATUS_DEPOSIT_WAITING);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->dropColumn('deposit_cost');
            $table->dropColumn('deposit_status');
        });
    }
};
