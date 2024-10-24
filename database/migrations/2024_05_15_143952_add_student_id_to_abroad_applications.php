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
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable();

            $table->foreign('student_id')->references('id')->on('contacts')->onDelete('cascade');
        });

        foreach (\App\Models\AbroadApplication::all() as $abroadApplication) {
            $abroadApplication->student_id = $abroadApplication->orderItem->order->student_id;
            $abroadApplication->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_applications', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });
    }
};
