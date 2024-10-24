<?php

use App\Models\Essay;
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
            Schema::create('essays', function (Blueprint $table) {
                $table->id();
                $table->timestamps();

                $table->unsignedBigInteger('abroad_application_id');
                $table->foreign('abroad_application_id')->references('id')->on('abroad_applications')->onDelete('cascade');

                $table->unsignedBigInteger('account_id');
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

                $table->string('name');
                $table->date('date')->nullable();
                $table->string('status')->default(Essay::STATUS_DRAFT);
                $table->text('content')->nullable();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('essays');
        }
};
