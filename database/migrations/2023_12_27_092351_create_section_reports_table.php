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
        Schema::create('section_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->longText('teacher_comment')->nullable();
            $table->longText('content')->nullable();
            $table->integer('tinh_dung_gio')->nullable();
            $table->integer('muc_do_tap_trung')->nullable();
            $table->integer('muc_do_hieu_bai')->nullable();
            $table->integer('muc_do_tuong_tac')->nullable();
            $table->integer('tu_hoc_va_giai_quyet_van_de')->nullable();
            $table->integer('tu_tin_trach_nhiem')->nullable();
            $table->integer('trung_thuc_ky_luat')->nullable();
            $table->integer('ket_qua_tren_lop')->nullable();
            $table->foreign('student_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_reports');
    }
};
