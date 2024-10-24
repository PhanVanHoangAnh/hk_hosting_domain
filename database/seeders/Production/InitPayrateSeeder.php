<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\AccountGroup;
use App\Models\ExcelData;
use App\Models\Payrate;
use App\Models\TrainingLocation;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use Illuminate\Support\Facades\DB;

class InitPayrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AccountGroup::query()->delete();

        $excelFile = new ExcelData();
        $staffData = $excelFile->getDataFromSheet(ExcelData::PAYRATE_SHEET_NAME, 2);

        foreach($staffData as $data)
        {
          $this->addPayrate($data);
        }
    }

    public function addPayrate($data)
    {
        try { 
            [$teacherName, $subjectName, $classType, $amount, $currency, $effectiveDate, $studyMethod, $classSize, $branchName, $address, $classStatus] = $data;
            // $unixTimestamp = (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($effectiveDate));
            // $formattedDate = date('Y-m-d', $unixTimestamp);
            $formattedDate = \Carbon\Carbon::parse($effectiveDate);

            // Find teacher by name
            $teacher = Teacher::where('name', $teacherName)->first();

            if ($teacher === null) {
                echo  "\033[31mERROR\033[0m  : Không tìm thấy giáo viên: $teacherName\n";
                return; 
            }

            // Find subject by name
            $subject = Subject::where('name', $subjectName)->first();

            if ($subject === null) {
                echo  "\033[31mERROR\033[0m  : Không tìm thấy môn học: $subjectName\n";
                return; 
            }

            $type = ($classType == 'Nhóm') ? \App\Models\Course::CLASS_TYPE_GROUP : \App\Models\Course::CLASS_TYPE_ONE_ONE;
            $studyMethodValue = ($studyMethod == 'Online') ? \App\Models\Course::STUDY_METHOD_ONLINE : \App\Models\Course::STUDY_METHOD_OFFLINE;

            switch(strtolower($branchName)) {
                case 'hn':
                case 'hà nội':
                    $branchName = \App\Library\Branch::BRANCH_HN;
                    break;
                case 'sg':
                case 'sài gòn':
                    $branchName = \App\Library\Branch::BRANCH_SG;
                    break;
                default:
                    throw new \Exception("Branch is not valid $branchName");
            }

            // Find training location 
            $trainingLocation = null;

            if ($address !== null) {
                $trainingLocation = TrainingLocation::where('branch', $branchName)
                    ->where('name', $address)
                    ->first();
            }
            
            // Check training location exists
            if ($trainingLocation === null) {
                echo  "\033[31mERROR\033[0m  : Không tìm thấy địa điểm đào tạo: $address, $branchName\n";
                return; 
            }
            
            DB::beginTransaction();

            // Create payrate
            $payrate = Payrate::create([
                'amount' => str_replace(',', '', $amount),
                'type' => $type,
                'effective_date' => $formattedDate,
                'subject_id' => $subject->id,
                'teacher_id' => $teacher->id,
                'training_location_id' => $trainingLocation->id,
                'study_method' => $studyMethodValue,
                'class_status' => $classStatus,
                'class_size' => $classSize,
                'currency' => $currency
            ]);

            DB::commit();

            // echo "SUCCESS: Tạo thành công bậc lương cho $teacherName và $subjectName\n";
        } catch (\Exception $e) {
            
            DB::rollback();
            echo  "\033[31mERROR\033[0m  : Dữ liệu không tìm thấy: " . implode(', ', $data) . "\n";
            echo "Exception: " . $e->getMessage() . "\n";
        }
    }
}