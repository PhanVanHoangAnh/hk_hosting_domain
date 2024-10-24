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
        Schema::table('sections', function (Blueprint $table) {
            $table->text('zoom_vn_start_link')->nullable();
            $table->text('zoom_vn_join_link')->nullable();
            $table->string('zoom_vn_password')->nullable();

            $table->text('zoom_foreign_start_link')->nullable();
            $table->text('zoom_foreign_join_link')->nullable();
            $table->string('zoom_foreign_password')->nullable();

            $table->text('zoom_tutor_start_link')->nullable();
            $table->text('zoom_tutor_join_link')->nullable();
            $table->string('zoom_tutor_password')->nullable();

            $table->text('zoom_assistant_start_link')->nullable();
            $table->text('zoom_assistant_join_link')->nullable();
            $table->string('zoom_assistant_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('zoom_vn_start_link');
            $table->dropColumn('zoom_vn_join_link');
            $table->dropColumn('zoom_vn_password');

            $table->dropColumn('zoom_foreign_start_link');
            $table->dropColumn('zoom_foreign_join_link');
            $table->dropColumn('zoom_foreign_password');

            $table->dropColumn('zoom_tutor_start_link');
            $table->dropColumn('zoom_tutor_join_link');
            $table->dropColumn('zoom_tutor_password');

            $table->dropColumn('zoom_assistant_start_link');
            $table->dropColumn('zoom_assistant_join_link');
            $table->dropColumn('zoom_assistant_password');
        });
    }
};
