<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\ExcelData;
use Illuminate\Support\Facades\File;

class InitTeacherSeeder extends Seeder
{
    private $errors = [];
    private $warnings = [];
    public function run(): void
    {
        $excelFile = new ExcelData();
        $teachersData = $excelFile->getDataFromSheet(ExcelData::TEACHER_SHEET_NAME, 2);
    
        foreach($teachersData as $key => $data) 
        {
            $this->addTeachers($key + 2,$data, false);
        }

        // $homeRoomsData = $excelFile->getDataFromSheet(ExcelData::HOMEROOM_SHEET_NAME, 2);

        // foreach($homeRoomsData as $key => $data) 
        // {
        //     $this->addTeachers($key + 2, $data, true);
        // }
        
        $this->exportErrorsAndWarnings();
    }

    public function addTeachers($rowNumber, $teachers, $isHomeRoom)
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
        $failCheck = false;
        $teacher = Teacher::where('import_id', $id)->first();
        
        if ($teacher) {
            if ($teacher->type == $type) {
                echo("  \033[33mWARNING\033[0m  : Đã tồn tại nhân sự import_id = " . $id . "\n");
                $failCheck = true;
            }

            if (strtolower(trim($type)) == 'việt nam' || strtolower(trim($type)) == 'nước ngoài') {
                $teacher = Teacher::where('import_id', $id)->where('type', Teacher::TYPE_HOMEROOM)->first();

                if ($teacher) {
                    echo("  \033[33mWARNING\033[0m  : Đã tồn tại chủ nhiệm import_id = " . $id . "\n");
                    $failCheck = true;
                }
            }
        }

        if ($id == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu import_id cho giáo viên!\n");
            $this->addError($rowNumber, "Không có dữ liệu import_id cho giáo viên", $teachers);
            $failCheck = true;
        }

        if (!$isHomeRoom) {
            if ($type == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu loại giáo viên- import_id: " . $id . "!\n");
                $this->addError($rowNumber, "Không có dữ liệu loại giáo viên- import_id", $teachers);
                $failCheck = true;
            }
        }

        if ($area == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu vùng cho giáo viên - import_id: " . $id . "!\n");
            $this->addError($rowNumber, "Không có dữ liệu vùng cho giáo viên - import_id", $teachers);
            $failCheck = true;
        }

        if ($status == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu trạng thái (status) cho giáo viên - import_id: " . $id . "!\n");
            $this->addError($rowNumber, "Không có dữ liệu trạng thái (status) cho giáo viên - import_id", $teachers);
            $failCheck = true;
        }

        if ($failCheck) {
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
            'area' => $area,
        ]);
        
        $newTeacher->generateCode();

        if ($newTeacher) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công NHÂN SỰ - import_id: " . $id . "\n");
        }

        return $newTeacher;
    }

    private function addError($rowNumber, $message, $data)
    {
        $this->errors[] = [
            'message' => $message . " tại dòng " . $rowNumber,
            'data' => $data
        ];
    }
    private function exportErrorsAndWarnings()
    {
        $filePath = storage_path('logs/loi_giaovien.txt');
        $fileContent = "LỖI:\n";

        foreach ($this->errors as $error) {
            $fileContent .= $error['message'] . "\n";
        }

        $fileContent .= "\CẢNH BÁO:\n";

        foreach ($this->warnings as $warning) {
            $fileContent .= $warning['message'] . "\n";
        }

        File::put($filePath, $fileContent);

        echo("  \033[1m\033[34mINFO\033[0m: Course data errors and warnings have been exported to " . $filePath . "\n");
    }
}
