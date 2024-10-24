<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Gpa;
use App\Models\ExcelData;
use App\Exceptions\CustomException;
use App\Helpers\Functions;

class InitGpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gpa::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::GPA_SHEET_NAME, 2);
        
        foreach($datas as $data) {
            try {
                $newGpa = $this->addGpa($data);
            } catch(CustomException $e) {
                switch ($e->getMessage()) {
                    case 'import_id_not_found':
                        echo("  \033[1m\033[31mERROR\033[0m  : Không có import_id!\n");
                        break;
                    case "grade_not_found":
                        echo("  \033[1m\033[31mERROR\033[0m  : Không có tên lớp (grade)!\n");
                        break;
                    default:
                        echo("  \033[1m\033[31mERROR\033[0m  : SYSTEM ERROR, CANNOT CATCH ERROR!\n");
                }
            }
        }
    }

    public function addGpa($data) : Gpa 
    {
        [$import_id, $grade, $point] = $data;

        if ($import_id == '') {
            throw new CustomException("import_id_not_found");
        }

        if ($grade == '') {
            throw new CustomException("grade_not_found");
        }

        $pointAccept = 0;

        if ($point == '') {
            $pointAccept = null;
        }

        if ($point != '') {
            $pointAccept = Functions::convertStringPriceToNumber($point);
        }

        $newGpa = Gpa::create([
            'import_id' => $import_id,
            'grade' => $grade,
            'point' => $pointAccept,
        ]);

        if ($newGpa) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công GPA mới - import_id: " . $newGpa->import_id . "\n");
        }

        return $newGpa;
    }
}
