<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ExcelData;
use App\Exceptions\CustomException;
use App\Models\PlanApplyProgram;

class InitPlanApplyProgram extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanApplyProgram::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::PLAN_APPLY_PROGRAM_SHEET_NAME, 2);

        foreach($datas as $data) {
            try {
                $newPlanApply = $this->addPlanApplyProgram($data);
            } catch(CustomException $e) {
                switch ($e->getMessage()) {
                    case 'import_id_not_found':
                        echo("  \033[1m\033[31mERROR\033[0m  : Không có import_id!\n");
                        break;
                    case "name_not_found":
                        echo("  \033[1m\033[31mERROR\033[0m  : Không có tên chương trình hiện tại (name)!\n");
                        break;
                    default:
                        echo("  \033[1m\033[31mERROR\033[0m  : SYSTEM ERROR, CANNOT CATCH ERROR!\n");
                }
            }
        }
    }

    public function addPlanApplyProgram($data) : PlanApplyProgram
    {
        [$import_id, $name] = $data;

        if ($import_id == '') {
            throw new CustomException("import_id_not_found");
        }

        if ($name == '') {
            throw new CustomException("name_not_found");
        }

        $newPlanApply = PlanApplyProgram::create([
            'import_id' => $import_id,
            'name' => $name,
        ]);

        if ($newPlanApply) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công 1 KẾ HOẠCH TRONG TƯƠNG LAI - import_id: " . $newPlanApply->import_id . "\n");
        }

        return $newPlanApply;
    }
}
