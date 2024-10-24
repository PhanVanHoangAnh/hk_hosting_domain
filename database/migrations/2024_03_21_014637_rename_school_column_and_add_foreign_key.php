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
        //
       // Thêm cột 'school_id' vào bảng 'application_school'
       Schema::table('application_school', function (Blueprint $table) {
        $table->unsignedBigInteger('school_id')->nullable()->after('abroad_application_id');
        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });

        // Thêm cột 'status' vào bảng 'application_school'
        Schema::table('application_school', function (Blueprint $table) {
            $table->string('status')->nullable()->after('type');
        });

        // Xóa cột 'school' khỏi bảng 'application_school'
        Schema::table('application_school', function (Blueprint $table) {
            $table->dropColumn('school');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         // Thêm cột 'school' vào bảng 'application_school'
         Schema::table('application_school', function (Blueprint $table) {
            $table->string('school')->nullable()->after('abroad_application_id');
        });

        // Xóa cột 'status' khỏi bảng 'application_school'
        Schema::table('application_school', function (Blueprint $table) {
            // $table->dropColumn('status');
        });

        // Xóa cột 'school_id' khỏi bảng 'application_school'
        Schema::table('application_school', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
