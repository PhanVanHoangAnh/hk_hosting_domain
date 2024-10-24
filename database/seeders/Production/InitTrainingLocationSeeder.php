<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExcelData;

use App\Models\TrainingLocation;

class InitTrainingLocationSeeder extends Seeder
{
    public function run(): void
    {
        TrainingLocation::query()->delete();

        $excelFile = new ExcelData();
        $locations = $excelFile->getDataFromSheet(ExcelData::TRAINING_LOCATION_SHEET_NAME, 2);
        $branchs = $excelFile->getDataFromSheet(ExcelData::BRANCH_SHEET_NAME, 2);

        $currId = null;
        $currLocation = null;

        foreach ($locations as $location) {
            // $location[1] is id of location in excel list
            if ($currId != $location[1]) {
                $currLocation = $this->addLocation($location, $branchs);
            }
        }
    }

    public function addLocation($data, $branchs)
    {
        [$id, $branch, $name] = $data;

        if ($branch == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Chưa có dữ liệu chi nhánh!");
            return;
        }

        $branchFound = false;

        foreach($branchs as $item) {
            if ($branch == $item[1]) {
                $branchFound = true;
                break;
            } else {
                $branchFound = false;
            }
        }

        if (!$branchFound) {
            echo("  \033[1m\033[31mERROR\033[0m  : Dữ liệu chi nhánh không khớp với chi nhánh nào trong sheet Chi nhánh!");
            return;
        }

        if ($name == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Chưa có dữ liệu tên địa điểm! (location)!");
            return;
        }

        switch(strtolower($branch)) {
            case 'hn':
            case 'hà nội':
                $branch = \App\Library\Branch::BRANCH_HN;
                break;
            case 'sg':
            case 'sài gòn':
                $branch = \App\Library\Branch::BRANCH_SG;
                break;
            default:
                throw new \Exception("Branch is not valid $branch");
        }

        $newLocation = TrainingLocation::create([
            'import_id' => $id,
            'branch' => $branch,
            'name' => $name,
        ]);

        if ($newLocation) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo thành công địa điểm đào tạo - import_id: " . $id . "\n");
        }

        return $newLocation;
    }
}
