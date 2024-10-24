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
        \App\Models\Course::query()->update(['module' => \App\Models\Course::MODULE_EDU]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
