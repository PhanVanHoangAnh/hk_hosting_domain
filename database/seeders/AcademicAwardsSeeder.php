<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AcademicAward;
use App\Models\ExcelData;
use App\Exceptions\CustomException;

class AcademicAwardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicAward::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::ACADEMIC_AWARDS_SHEET_NAME, 2);
    
        foreach($datas as $data) {
            try {
                $newAward = $this->addAcademicAward($data);
            } catch(CustomException $e) {
                switch ($e->getMessage()) {
                    case 'import_id_not_found':
                        echo("  \033[1m\033[31mERROR\033[0m  : Không có import_id!\n");
                        break;
                    case "name_not_found":
                        echo("  \033[1m\033[31mERROR\033[0m  : Không có tên giải thưởng (name)!\n");
                        break;
                    default:
                        echo("  \033[1m\033[31mERROR\033[0m  : SYSTEM ERROR, CANNOT CATCH ERROR!\n");
                }
            }
        }
    }

    public function addAcademicAward($data) : AcademicAward 
    {
        [$import_id, $name] = $data;

        if ($import_id == '') {
            throw new CustomException("import_id_not_found");
        }

        if ($name == '') {
            throw new CustomException("name_not_found");
        }

        $newAward = AcademicAward::create([
            'import_id' => $import_id,
            'name' => $name,
        ]);

        if ($newAward) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công GIẢI THƯỞNG DU HỌC - import_id: " . $newAward->import_id . "\n");
        }

        return $newAward;
    }
}