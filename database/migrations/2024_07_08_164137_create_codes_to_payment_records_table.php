<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PaymentRecord;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       $paymentRecordes = PaymentRecord::all();
       foreach ($paymentRecordes as $paymentRecord){
        if(!$paymentRecord->code){
            $paymentRecord->generateCode();
        } 
       }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_records', function (Blueprint $table) {
            //
        });
    }
};
