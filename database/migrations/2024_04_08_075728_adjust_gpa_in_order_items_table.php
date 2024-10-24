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
        $datas = $excelFile->getDataFromSheet(ExcelData::GPA_SHEET_NAME, 2);
        
        for ($i = 0; $i < count($datas); ++$i) {
            Schema::table('order_items', function (Blueprint $table) use ($i) {
                $table->boolean('grade_' . $i + 1)->nullable();
            $table->text('point_' . $i + 1)->nullable();
            });
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('GPA');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::GPA_SHEET_NAME, 2);

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('GPA', 8, 2)->nullable();
        });
        
        for ($i = 0; $i < count($datas); ++$i) {
            Schema::table('order_items', function (Blueprint $table) use ($i) {
                $table->dropColumn('grade_' . $i + 1);              
                $table->dropColumn('point_' . $i + 1);              
            });
        }
    }
};
