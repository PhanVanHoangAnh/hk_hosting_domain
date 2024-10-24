<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbroadService;
use App\Models\ExcelData;

class AbroadServiceSeeder extends Seeder
{
    public function run(): void
    {
        AbroadService::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::ABROAD_SERVICES_SHEET_NAME, 2);

        $currImportId = null;
        $currService = null;

        foreach($datas as $data) {
            if ($currImportId != $data[0]) {
                $currService = $this->addService($data);

                if ($currService) {
                    $currImportId = $data[0];
                } else {
                    $currService = null;
                }
            } else {
                echo("  \033[1m\033[31mERROR\033[0m  : import_id bị trùng với dữ liệu đã có!\n");
            }
        }
    }

    public function addService($data)
    {
        [$import_id, $name] = $data;

        if ($import_id == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có import id!\n");
            return;
        }

        $existedService;

        $existedService = AbroadService::where('import_id', $import_id)->first();

        if ($existedService) {
            echo("  \033[1m\033[31mERROR\033[0m  : import_id bị trùng với dữ liệu đã có!\n");
            return;
        } else {
            $existedService = null;
        }

        if ($name == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có tên môn học!\n");
            return;
        }

        $existedService = AbroadService::where('name', $name)->first();

        if ($existedService) {
            echo("  \033[1m\033[31mERROR\033[0m  : tên bị trùng với dữ liệu đã có!\n");
            return;
        }

        $newService = AbroadService::create([
            'import_id' => $import_id,
            'name' => $name,
        ]);

        if ($newService) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công DỊCH VỤ DU HỌC tên " . $newService->name . " - import_id: " . $newService->import_id . "\n");
        }
    }
}
