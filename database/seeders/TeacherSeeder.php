<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\ExcelData;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::query()->delete();
        
        $excelFile = new ExcelData();
        $teachersData = $excelFile->getDataFromSheet(ExcelData::TEACHER_SHEET_NAME, 2);
    
        foreach($teachersData as $data) 
        {
            $this->addTeachers($data, false);
        }

        $homeRoomsData = $excelFile->getDataFromSheet(ExcelData::HOMEROOM_SHEET_NAME, 2);

        foreach($homeRoomsData as $data) 
        {
            $this->addTeachers($data, true);
        }
    }

    public function addTeachers($teachers, $isHomeRoom)
    {
        [$id, $name, $type, $status, $email, $phone, $birthday, $area] = $teachers;

        // Handle data
        $id = trim($id);
        $name = trim($name);
        $type = trim($type);
        $status = trim($status);
        $email = trim($email);
        $phone = \App\Library\Tool::extractPhoneNumber(trim($phone));
        $birthday = trim($birthday);
        $area = trim($area);

        if ($id == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu import_id cho giáo viên!\n");
            return;
        }

        if (!$isHomeRoom) {
            if ($type == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu loại giáo viên- import_id: " . $id . "!\n");
                return;
            }
        }

        if ($area == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu vùng cho giáo viên - import_id: " . $id . "!\n");
            return;
        }

        if ($status == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu trạng thái (status) cho giáo viên - import_id: " . $id . "!\n");
            return;
        }

        $newTeacher = Teacher::create([
            'import_id' => $id,
            'name' => $name,
            'type' => !$isHomeRoom ? $type : Teacher::TYPE_HOMEROOM,
            'status' => $status === 'Đang dạy' ? Teacher::STATUS_ACTIVE : Teacher::STATUS_OFF,
            'email' => $email,
            'phone' => $phone,
            'birthday' => $birthday,
            'area' => 'HN',
        ]);

        if ($newTeacher) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công NHÂN SỰ - import_id: " . $id . "\n");
        }

        return $newTeacher;
    }
}