<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ExcelData;
use App\Exceptions\CustomException;
use App\Models\CurrentProgram;

class InitCurrentProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CurrentProgram::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::CURRENT_PROGRAM_SHEET_NAME, 2);

        foreach($datas as $data) {
            try {
                $newProgram = $this->addCurrentProgram($data);
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

    public function addCurrentProgram($data) : CurrentProgram
    {
        [$import_id, $name] = $data;

        if ($import_id == '') {
            throw new CustomException("import_id_not_found");
        }

        if ($name == '') {
            throw new CustomException("name_not_found");
        }

        $newProgram = CurrentProgram::create([
            'import_id' => $import_id,
            'name' => $name,
        ]);

        if ($newProgram) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công 1 CHƯƠNG TRÌNH HỌC HIỆN TẠI - import_id: " . $newProgram->import_id . "\n");
        }

        return $newProgram;
    }
}
