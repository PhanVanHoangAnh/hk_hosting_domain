<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExcelData;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
      

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::SUBJECT_SHEET_NAME, 2);
        $abroadServices = $excelFile->getDataFromSheet(ExcelData::SERVICE_SHEET_NAME, 2);

        foreach ($datas as $data) {
            $this->addSubject($data);
        }
    }

    public function addSubject($data) 
    {
        [$name, $type, $level] = $data;

       
        $name = trim($name);
        $type = trim($type);
        $level = trim($level);

        $section = Subject::where('name',$name)->first();
        // return;
        if(!is_null($section) && !is_null($name)) {
            echo("  \033[33mWARNING\033[0m  : Đã tồn tại Môn học: name" . $name . "\n");
            return;
            
        }
        if ($name == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Chưa có dữ liệu tên môn học!\n");
            return;
        }

        if ($type == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Chưa có dữ liệu loại môn học!\n");
            return;
        }

        Subject::create([
            'name' => $name,
            'type' => $type,
            'level' => $level != '' ? $level : null,
        ]);
    }
}
