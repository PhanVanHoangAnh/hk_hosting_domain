<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\TrainingLocation;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('branch');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('status')->default(TrainingLocation::STATUS_ACTIVE);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_locations');
    }
};
