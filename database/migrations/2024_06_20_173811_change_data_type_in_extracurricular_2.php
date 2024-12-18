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
            $table->text('name')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->text('document_link')->nullable()->change();
            $table->text('image_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular', function (Blueprint $table) {
            //
        });
    }
};
