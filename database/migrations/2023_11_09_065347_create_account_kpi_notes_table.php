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
        Schema::create('account_kpi_notes', function (Blueprint $table) {
            $table->id();
            $table->foreign("contact_id")
            ->references("id")
            ->on("contacts")
            ->onDelete("cascade")
            ->onUpdate("cascade"); 
            
        $table->bigInteger('account_id')->unsigned()->index()->nullable();

        $table->foreign("account_id")
            ->references("id")
            ->on("accounts")
            ->onDelete("cascade") 
            ->onUpdate("cascade"); 
            $table->text('note')->nullable();
            $table->decimal('amount', 16, 2)->nullable();
            $table->date('estimated_payment_date')->nullable();
            $table->timestamps();

            $table->bigInteger('contact_id')->unsigned()->index()->nullable();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_kpi_notes');
    }
};
