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
        $staffs = [
            Role::ALIAS_ABROAD_TEACHER,
            Role::ALIAS_VN_TEACHER,
            Role::ALIAS_TUTOR,
            Role::ALIAS_ASSISTANT,
            Role::ALIAS_HOMEROOM_TEACHER,
        ];

        Role::where('module', ['teacher', 'teaching_assistant'])->delete();

        Schema::table('roles', function (Blueprint $table) use ($staffs) {
            foreach($staffs as $staff) {
                Role::create([
                    'module' => Module::TEACHER,
                    'alias' => $staff,
                    'name' => trans('messages.role.' . $staff)
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
};
