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
        Schema::table('contact_requests', function (Blueprint $table) {
            $table->timestamp('assigned_expired_at')->nullable();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->timestamp('assigned_expired_at')->nullable();
        });

        // Update all contact assigned_expired_at
        foreach(\App\Models\Contact::whereNotNull('assigned_at')->get() as $c) {
            $c->assigned_expired_at = \App\Helpers\Functions::calculateExpiredAt(\Carbon\Carbon::parse($c->assigned_at));
            $c->save();
        }

        foreach(\App\Models\ContactRequest::whereNotNull('assigned_at')->get() as $c) {
            $c->assigned_expired_at = \App\Helpers\Functions::calculateExpiredAt(\Carbon\Carbon::parse($c->assigned_at));
            $c->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropColumn('assigned_expired_at');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('assigned_expired_at');
        });
    }
};
