<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ExtraActivity;
use App\Models\ExcelData;
use App\Exceptions\CustomException;

class InitExtraActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExtraActivity::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::EXTRA_ACTIVITIES_SHEET_NAME, 2);
    
        foreach($datas as $data) {
            try {
                $newExtraActivity = $this->addExtraActivity($data);
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

    public function addExtraActivity($data) : ExtraActivity 
    {
        [$import_id, $name] = $data;

        if ($import_id == '') {
            throw new CustomException("import_id_not_found");
        }

        if ($name == '') {
            throw new CustomException("name_not_found");
        }

        $newExtraActivity = ExtraActivity::create([
            'import_id' => $import_id,
            'name' => $name,
        ]);

        if ($newExtraActivity) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công HOẠT ĐỘNG NGOẠI KHÓA CỦA HỌC VIÊN - import_id: " . $newExtraActivity->import_id . "\n");
        }

        return $newExtraActivity;
    }
}
