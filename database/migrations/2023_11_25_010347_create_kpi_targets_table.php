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
        Schema::create('kpi_targets', function (Blueprint $table) {
            $table->id();

            $table->string('type');

            $table->bigInteger('account_id')->unsigned()->index();
            $table->foreign("account_id")
                ->references("id")
                ->on("accounts")
                ->onDelete("cascade") 
                ->onUpdate("cascade");

            $table->decimal('amount', 16, 2)->nullable();

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_targets');
    }
};
