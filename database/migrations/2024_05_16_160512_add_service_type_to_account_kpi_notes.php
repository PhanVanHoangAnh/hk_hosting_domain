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
        Schema::table('account_kpi_notes', function (Blueprint $table) {
            $table->string('service_type')->nullable();
        });

        \App\Models\AccountKpiNote::query()->update([
            'service_type' => config('constants.SERVICE_TYPE_EDU'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_kpi_notes', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });
    }
};
