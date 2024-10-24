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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();

            $table->string('type');

            $table->bigInteger('contact_id')->unsigned()->index();
            $table->foreign("contact_id")
                ->references("id")
                ->on("contacts")
                ->onDelete("cascade") 
                ->onUpdate("cascade");

            $table->bigInteger('to_contact_id')->unsigned()->index();
            $table->foreign("to_contact_id")
                ->references("id")
                ->on("contacts")
                ->onDelete("cascade") 
                ->onUpdate("cascade");

            $table->string('other')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
