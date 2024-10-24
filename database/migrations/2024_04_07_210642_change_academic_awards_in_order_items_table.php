<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExcelData;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::ACADEMIC_AWARDS_SHEET_NAME, 2);

        for ($i = 0; $i < count($datas); ++$i) {
            Schema::table('order_items', function (Blueprint $table) use ($i) {
                $table->boolean('academic_award_' . $i + 1)->nullable();
            $table->text('academic_award_text_' . $i + 1)->nullable();
            });
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('academic_award');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::ACADEMIC_AWARDS_SHEET_NAME, 2);

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('academic_award')->nullable();
        });

        for ($i = 0; $i < count($datas); ++$i) {
            Schema::table('order_items', function (Blueprint $table) use ($i) {
                $table->dropColumn('academic_award_' . $i + 1);              
                $table->dropColumn('academic_award_text_' . $i + 1);              
            });
        }
    }
};
