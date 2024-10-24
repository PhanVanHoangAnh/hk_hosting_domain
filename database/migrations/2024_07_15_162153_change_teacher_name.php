<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\Teacher;
use App\Library\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $foreignTeachers = Teacher::where('type', 'LIKE', '%Giáo viên nước ngoài%')->get();
            $vnTeachers = Teacher::where('type', 'LIKE', '%Giáo viên Việt Nam%')->get();
            $tutors = Teacher::where('type', 'LIKE', '%TUTOR%')->get();
            $assistants = Teacher::where('type', 'Trợ giảng')->get();
            $kidAssistants = Teacher::where('type', 'Trợ giảng KID')->get();
            $homeRooms = Teacher::where('type', 'Chủ nhiệm')->get();

            foreach($foreignTeachers as $teacher) {
                $teacher->type = Role::ALIAS_ABROAD_TEACHER;
                $teacher->save();
            }

            foreach($vnTeachers as $teacher) {
                $teacher->type = Role::ALIAS_VN_TEACHER;
                $teacher->save();
            }

            foreach($tutors as $teacher) {
                $teacher->type = Role::ALIAS_TUTOR;
                $teacher->save();
            }

            foreach($assistants as $teacher) {
                $teacher->type = Role::ALIAS_ASSISTANT;
                $teacher->save();
            }

            foreach($kidAssistants as $teacher) {
                $teacher->type = Role::ALIAS_KID_ASSISTANT;
                $teacher->save();
            }

            foreach($homeRooms as $teacher) {
                $teacher->type = Role::ALIAS_HOMEROOM_TEACHER;
                $teacher->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            //
        });
    }
};
