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
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id'); // Thêm cột khóa ngoại
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade'); // Tạo ràng buộc khóa ngoại
            $table->unsignedBigInteger('account_id')->nullable(); // Thêm cột khóa ngoại
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null'); // Tạo ràng buộc khóa ngoại
            $table->integer('code_year')->nullable();
            $table->integer('code_number')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('source_type')->nullable();
            $table->string('demand')->nullable();
            $table->string('country')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('school')->nullable();
            $table->string('efc')->nullable();
            $table->string('list')->nullable();
            $table->string('target')->nullable();
            $table->string('channel')->nullable();
            $table->string('sub_channel')->nullable();
            $table->string('campaign')->nullable();
            $table->string('adset')->nullable();
            $table->string('ads')->nullable();
            $table->string('device')->nullable();
            $table->string('placement')->nullable();
            $table->string('term')->nullable();
            $table->text('first_url')->nullable();
            $table->string('contact_owner')->nullable();
            $table->string('lifecycle_stage')->nullable();
            $table->string('lead_status')->nullable();
            $table->string('pic')->nullable();
            $table->string('hubspot_id')->nullable();
            $table->string('fbcid')->nullable();
            $table->string('gclid')->nullable();
            $table->string('birthday')->nullable();
            $table->integer('age')->nullable();
            $table->string('time_to_call')->nullable();
            $table->string('ward')->nullable();
            $table->string('type_match')->nullable();
            $table->text('last_url')->nullable();
            $table->string('assigned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};
