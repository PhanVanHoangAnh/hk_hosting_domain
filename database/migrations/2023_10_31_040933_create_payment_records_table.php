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
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('contact_id')->unsigned()->index()->nullable();
            $table->foreign("contact_id")
                ->references("id")
                ->on("contacts")
                ->onDelete("cascade") 
                ->onUpdate("cascade");
            

            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign("order_id")
                ->references("id")
                ->on("orders")
                ->onDelete("cascade") 
                ->onUpdate("cascade");
           

            $table->bigInteger('account_id')->unsigned()->index()->nullable();
            $table->foreign("account_id")
                ->references("id")
                ->on("accounts")
                ->onDelete("cascade") 
                ->onUpdate("cascade");

            $table->date('payment_date')->nullable();;
            $table->decimal('amount', 16, 2)->nullable();
            $table->text('description')->nullable();

            $table->string('method')->nullable();
            
            $table->string('type');
            $table->timestamps();

          
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_records');
    }
};
