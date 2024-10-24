<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('demand')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('school')->nullable();
            $table->string('efc')->nullable();
            $table->string('list')->nullable();
            $table->string('target')->nullable();
            $table->string('marketing_source')->nullable();
            $table->string('marketing_source_sub')->nullable();
            $table->string('campaign')->nullable();
            $table->string('adset')->nullable();
            $table->string('ad_name')->nullable();
            $table->string('device')->nullable();
            $table->string('placement')->nullable();
            $table->string('term')->nullable();
            $table->string('ad_url')->nullable();
            $table->string('contact')->nullable();
            $table->string('lifecycle_stage')->nullable();
            $table->string('lead_status')->nullable();
            $table->string('pic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // $table->dropColumn('demand');
            // $table->dropColumn('country');
            // $table->dropColumn('state');
            // $table->dropColumn('city');
            // $table->dropColumn('school');
            // $table->dropColumn('efc');
            // $table->dropColumn('list');
            // $table->dropColumn('target');
            // $table->dropColumn('marketing_source');
            // $table->dropColumn('marketing_source_sub');
            // $table->dropColumn('campaign');
            // $table->dropColumn('adset');
            // $table->dropColumn('ad_name');
            // $table->dropColumn('device');
            // $table->dropColumn('placement');
            // $table->dropColumn('term');
            // $table->dropColumn('ad_url');
            // $table->dropColumn('contact');
            // $table->dropColumn('lifecycle_stage');
            // $table->dropColumn('lead_status');
            // $table->dropColumn('pic');
        });
    }
};