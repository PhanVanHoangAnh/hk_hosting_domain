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
        Schema::create('plan_apply_programs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('import_id')->nullable();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->dropForeign(['plan_apply_program_id']);
        });
        Schema::dropIfExists('plan_apply_programs');
    }
};
