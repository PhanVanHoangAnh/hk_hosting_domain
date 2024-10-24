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
        Schema::table('extracurricular', function (Blueprint $table) {
            //
            $table->string('type')->nullable();
            $table->string('describe')->nullable();
            $table->unsignedBigInteger('coordinator')->nullable();
            $table->foreign('coordinator')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('max_student')->nullable();
            $table->integer('min_student')->nullable();
            $table->decimal('expected_costs', 16, 2)->nullable();
            $table->decimal('actual_costs', 16, 2)->nullable();
            $table->decimal('total_revenue', 16, 2)->nullable();
            $table->string('study_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular', function (Blueprint $table) {
            //
            $table->dropColumn('type');
            $table->dropColumn('describe');
            $table->dropForeign(['coordinator']);
            $table->dropColumn('coordinator');
            $table->dropColumn('max_student');
            $table->dropColumn('min_student');
            $table->dropColumn('expected_costs');
            $table->dropColumn('actual_costs');
            $table->dropColumn('total_revenue');
            $table->dropColumn('study_method');
        });
    }
};
