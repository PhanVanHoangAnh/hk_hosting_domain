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
        Schema::table('software_requests', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('company_size')->nullable();
            $table->integer('company_branch')->nullable();
            $table->string('line_of_business')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('software_requests', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('company_size');
            $table->dropColumn('company_branch');
            $table->dropColumn('line_of_business');
            $table->dropColumn('note');

            });
    }
};
