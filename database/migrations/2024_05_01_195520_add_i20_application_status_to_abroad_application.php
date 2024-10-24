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
            $table->string('i20_application_status')->nullable()->default(AbroadApplication::STATUS_I20_APPLICATION_WAIT);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->dropColumn('i20_application_status');
        });
    }
};
