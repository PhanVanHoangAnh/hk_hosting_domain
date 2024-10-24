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

        Schema::table('contacts', function (Blueprint $table) {
            // $table->string('fullname')->after('name')->nullable();
            $table->string('district')->after('state')->nullable();
            $table->string('source_type')->after('marketing_type')->nullable();
            $table->string('channel')->after('marketing_source')->nullable();
            $table->string('sub_channel')->after('marketing_source_sub')->nullable();
            $table->string('ads')->after('ad_name')->nullable();
            $table->text('first_url')->after('ad_url')->nullable();
            $table->string('contact_owner')->after('contact')->nullable();
        });

        DB::table('contacts')->update([
            // 'fullname' => DB::raw('name'),
            'district' => DB::raw('state'),
            'source_type' => DB::raw('marketing_type'),
            'channel' => DB::raw('marketing_source'),
            'sub_channel' => DB::raw('marketing_source_sub'),
            'ads' => DB::raw('ad_name'),
            'first_url' => DB::raw('ad_url'),
            'contact_owner' => DB::raw('contact'),
        ]);


        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['state', 'marketing_type', 'marketing_source', 'marketing_source_sub', 'ad_name', 'ad_url', 'contact']);
        });


        Schema::table('contacts', function (Blueprint $table) {

            // $table->dropColumn(['first_name', 'last_name']);

            $table->date('birthday')->nullable();
            $table->integer('age')->nullable();
            $table->string('time_to_call')->nullable();
            $table->string('ward')->nullable();
            $table->string('type_match')->nullable();
            $table->text('last_url')->nullable();
        });
    }





    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
};
