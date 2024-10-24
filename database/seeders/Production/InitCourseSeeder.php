<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExcelData;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TrainingLocation;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InitCourseSeeder extends Seeder
{
    private $errors = [];
    private $warnings = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Course::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::COURSE_SHEET_NAME, 3);
        $levels = $excelFile->getDataFromSheet(ExcelData::LEVEL_SHEET_NAME, 2);

        $currId = null;
        $currCourse = null;

        foreach($datas as $data) 
        {
            if ($currId != $data[0]) {
                $currCourse = $this->addCourse($data, $levels);
            } 
        }

        $this->exportErrorsAndWarnings();
    }

    public function addCourse($data, $levels)
    {
        [
            $id, $subject_id, $study_method, $zoom_start_link, $zoom_join_link, 
            $zoom_pass,$zoom_user_id, $level, $status, $start_at, $end_at, $teacher_id, $vn_teacher_duration, 
            $foreign_teacher_duration, $tutor_duration, $assistant_duration, 
            $duration_each_lesson, $max_students, $min_students, $joined_students, $flexible_students, 
            $total_hours, $type, $stopped_at, $class_type, $module, $test_hours, $training_location_id,
            $class_room
        ] = $data;

        $id = trim($id);
        $subject_id = trim($subject_id);
        $study_method = trim($study_method);
        $zoom_start_link = trim($zoom_start_link);
        $zoom_join_link = trim($zoom_join_link);
        $zoom_pass = trim($zoom_pass);
        $zoom_user_id = trim($zoom_user_id);
        $level = trim($level);
        $status = trim($status);
        $start_at = trim($start_at);
        $end_at = trim($end_at);
        $vn_teacher_duration = trim($vn_teacher_duration);
        $foreign_teacher_duration = trim($foreign_teacher_duration);
        $tutor_duration = trim($tutor_duration);
        $assistant_duration = trim($assistant_duration);
        $duration_each_lesson = trim($duration_each_lesson);
        $max_students = trim($max_students);
        $min_students = trim($min_students);
        $joined_students = trim($joined_students);
        $flexible_students = trim($flexible_students);
        $total_hours = trim($total_hours);
        $type = trim($type);
        $stopped_at = trim($stopped_at);
        $class_type = trim($class_type);
        $module = trim($module);
        $test_hours = trim($test_hours);
        $training_location_id = trim($training_location_id);
        $class_room = trim($class_room);
        



        $course = Course::where('import_id',$id)->first();
        // return;
        if(!is_null($course) && !is_null($id)) {
            echo("  \033[33mWARNING\033[0m  : Đã tồn tại Course: import_id" . $id . "\n");
            $course->generateCodeName();
           
                if ($training_location_id == '') {
                    echo("  \033[1m\033[31mERROR\033[0m  : Không có địa điểm học - import_id: " . $id . "!\n" .$training_location_id);
                    $this->addError("Không có địa điểm học - import_id: " . $id, $data);
                    return;
                }
    
                $trainingLocation = TrainingLocation::where('import_id', $training_location_id)->first();
    
                if (!$trainingLocation) {
                    echo("  \033[1m\033[31mERROR\033[0m  :" . "Không tồn tại địa điểm đào tạo: " . $training_location_id . " - import_id: " . $id . "!\n");
                    $this->addError("Không tồn tại địa điểm đào tạo: " . $training_location_id . " - import_id: " . $id, $data);
                    return;
                }
                $course->training_location_id =  $trainingLocation->id;
                $course->save();
           
           
            return;
            
        }

        if ($id == '') {
            echo("  \033[1m\033[31mERROR\033[0m  :Không có import_id!\n");
            $this->addError("Không có import_id!", $data);
            return;
        }
       

        if ($subject_id == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu môn học - import_id: " . $id . "!\n");
            $this->addError("Không có dữ liệu môn học - import_id: " . $id, $data);
            return;
        }

        $subject = Subject::where('name', $subject_id)->first();

        if (!$subject) {
            echo("  \033[1m\033[31mERROR\033[0m  :" . "Môn học: " . $subject_id . " không tồn tại - import_id: " . $id . "!\n");
            $this->addError("Môn học: " . $subject_id . " không tồn tại - import_id: " . $id, $data);
            return;
        }

        // Validate level
        // if ($level == '') {
        //     echo("  \033[1m\033[33mWARNING\033[0m: Chưa có dữ liệu trình độ - import_id: " . $id . "!\n");
        //     $this->addWarning("Chưa có dữ liệu trình độ - import_id: " . $id, $data);
        // }

        if ($study_method == '') {
            echo("  \033[1m\033[33mWARNING\033[0m: Chưa có hình thức học, tự động gán bằng online - import_id: " . $id . "!\n");
            $this->addWarning("Chưa có hình thức học, tự động gán bằng online - import_id: " . $id, $data);
            $study_method = Course::STUDY_METHOD_ONLINE;
        }
        if ($study_method != 'ONLINE') {
            $study_method = 'Online';
        }
        if ($study_method != 'OFFLINE') {
            $study_method = 'Offline';
        }
        if ($study_method != '' && !in_array($study_method, Course::getAllStudyMethod())) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "Hình thức học nhập vào: " . $study_method . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("Hình thức học nhập vào: " . $study_method . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        // Check condition for course follow by study_method
        // If ONLINE
        // if ($study_method == Course::STUDY_METHOD_ONLINE) {
        //     if ($zoom_start_link == '') {
        //         echo("  \033[1m\033[31mERROR\033[0m  : Không có link zoom start - import_id: " . $id . "!\n");
        //         return;
        //     }

        //     if ($zoom_join_link == '') {
        //         echo("  \033[1m\033[31mERROR\033[0m  : Không có link zoom join - import_id: " . $id . "!\n");
        //         return;
        //     }
        // }

        $trainingLocation = null;

        // If OFFLINE
        if ($study_method == Course::STUDY_METHOD_OFFLINE) {
            if ($training_location_id == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có địa điểm học - import_id: " . $id . "!\n" .$training_location_id);
                $this->addError("Không có địa điểm học - import_id: " . $id, $data);
                return;
            }

            $trainingLocation = TrainingLocation::where('import_id', $training_location_id)->first();

            if (!$trainingLocation) {
                echo("  \033[1m\033[31mERROR\033[0m  :" . "Không tồn tại địa điểm đào tạo: " . $training_location_id . " - import_id: " . $id . "!\n");
                $this->addError("Không tồn tại địa điểm đào tạo: " . $training_location_id . " - import_id: " . $id, $data);
                return;
            }
        }
        
        $levelNames = [];

        foreach ($levels as $item) {
            $levelNames[] = $item[0];
        }
        
        if ($level != '' && !in_array($level, $levelNames)) {
            echo("  \033[1m\033[31mERROR\033[0m  :" . " Trình độ:" . $level . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("Trình độ: " . $level . " không hợp lệ - import_id: " . $id, $data);
            return;
        }   
        if ($start_at == '') {
            $start_at="2024-06-01 0:00:00";
        }

        if ($end_at == '') {
            $end_at="2024-08-31 0:00:00";
        }
        if ($vn_teacher_duration == '-' ) {
            $vn_teacher_duration =0;
        }
        if ($foreign_teacher_duration == '-' ) {
            $foreign_teacher_duration =0;
        }
        if ($tutor_duration == '-' ) {
            $tutor_duration =0;
        }
        if ($assistant_duration == '-' ) {
            $assistant_duration =0;
        }
        if ($duration_each_lesson == '-' ) {
            $duration_each_lesson =0;
        }

        if ($vn_teacher_duration !== '' && floatval($vn_teacher_duration) > 0 && !filter_var($vn_teacher_duration, FILTER_VALIDATE_FLOAT)) {
            echo("  \033[1m\033[31mERROR\033[0m  :" . " vn_teacher_duration: " . $vn_teacher_duration . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("vn_teacher_duration: " . $vn_teacher_duration . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($foreign_teacher_duration !== '' && floatval($foreign_teacher_duration) > 0 && !filter_var($foreign_teacher_duration, FILTER_VALIDATE_FLOAT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "foreign_teacher_duration: " . $foreign_teacher_duration . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("foreign_teacher_duration: " . $foreign_teacher_duration . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($tutor_duration !== '' && floatval($tutor_duration) > 0 && !filter_var($tutor_duration, FILTER_VALIDATE_FLOAT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "tutor_duration: " . $tutor_duration . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("tutor_duration: " . $tutor_duration . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($assistant_duration !== '' && floatval($assistant_duration) > 0 && !filter_var($assistant_duration, FILTER_VALIDATE_FLOAT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "assistant_duration: " . $assistant_duration . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("assistant_duration: " . $assistant_duration . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($duration_each_lesson !== '' && floatval($duration_each_lesson) > 0 && !filter_var($duration_each_lesson, FILTER_VALIDATE_FLOAT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "duration_each_lesson: " . $duration_each_lesson . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("duration_each_lesson: " . $duration_each_lesson . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($max_students == '') {
            // echo("  \033[1m\033[31mERROR\033[0m  : Chưa có max_students - import_id: " . $id . "!\n");
            // $this->addError("Chưa có max_students - import_id: " . $id, $data);
            // return;
            $max_students = "100";
        }

        if ($min_students == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Chưa có min_students - import_id: " . $id . "!\n");
            $this->addError("Chưa có min_students - import_id: " . $id, $data);
            return;
        }

        if ($max_students !== '' && intval($max_students) > 0 && !filter_var($max_students, FILTER_VALIDATE_INT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "max_students: " . $max_students . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("max_students: " . $max_students . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($min_students !== '' && intval($min_students) > 0 && !filter_var($min_students, FILTER_VALIDATE_INT)) {
            // echo("  \033[1m\033[31mERROR\033[0m  : " . "min_students: " . $min_students . " không hợp lệ - import_id: " . $id . "!\n");
            // $this->addError("min_students: " . $min_students . " không hợp lệ - import_id: " . $id, $data);
            // return;
            $min_students = '1';
        }

        if ($total_hours == '') {
            $total_hours = "100";
        }

        if ($total_hours !== '' && intval($total_hours) > 0 && !filter_var($total_hours, FILTER_VALIDATE_INT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "total_hours: " . $total_hours . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("total_hours: " . $total_hours . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        if ($test_hours !== '' && intval($test_hours) > 0 && !filter_var($test_hours, FILTER_VALIDATE_INT)) {
            echo("  \033[1m\033[31mERROR\033[0m  : " . "test_hours: " . $test_hours . " không hợp lệ - import_id: " . $id . "!\n");
            $this->addError("test_hours: " . $test_hours . " không hợp lệ - import_id: " . $id, $data);
            return;
        }

        // if ($start_at != '') {
            
        //     if (!boolval(filter_var($start_at, FILTER_VALIDATE_INT))) {
        //         echo("  \033[1m\033[31mERROR\033[0m  : Ngày bắt đầu không hợp lệ - import_id: " . $id . "!\n" . $start_at);
        //         $this->addError("Ngày bắt đầu không hợp lệ - import_id: " . $id, $data);
        //         return;
        //     }
         
        //     $startAtUnixTimestamp = (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($start_at));
        //     $formattedStartAt = date('Y-m-d H:i:s', $startAtUnixTimestamp);
        //     $start_at = $formattedStartAt;
        // }
        if ($start_at != '') {
            // Kiểm tra nếu $start_at là số (Excel lưu trữ ngày tháng dưới dạng số).
            if (is_numeric($start_at)) {
                // Chuyển đổi từ Excel timestamp sang UNIX timestamp.
                $startAtUnixTimestamp = Date::excelToTimestamp($start_at);
                
                // Sử dụng Carbon để định dạng lại.
                $carbonStartAt = Carbon::createFromTimestamp($startAtUnixTimestamp);
                $formattedStartAt = $carbonStartAt->format('Y-m-d H:i:s');
                $start_at = $formattedStartAt;
            } else {
                // Nếu không phải là số, kiểm tra nếu nó là một định dạng thời gian hợp lệ.
                try {
                    $carbonStartAt = Carbon::parse($start_at);
                    $formattedStartAt = $carbonStartAt->format('Y-m-d H:i:s');
                    $start_at = $formattedStartAt;
                } catch (\Exception $e) {
                    echo("  \033[1m\033[31mERROR\033[0m  : Ngày bắt đầu không hợp lệ - import_id: " . $id . "!\n" . $start_at);
                    $this->addError("Ngày bắt đầu không hợp lệ - import_id: " . $id, $data);
                    return;
                }
            }
        }
        if ($end_at != '') {
            // Kiểm tra nếu $end_at là số (Excel lưu trữ ngày tháng dưới dạng số).
            if (is_numeric($end_at)) {
                // Chuyển đổi từ Excel timestamp sang UNIX timestamp.
                $startAtUnixTimestamp = Date::excelToTimestamp($end_at);
                
                // Sử dụng Carbon để định dạng lại.
                $carbonStartAt = Carbon::createFromTimestamp($startAtUnixTimestamp);
                $formattedStartAt = $carbonStartAt->format('Y-m-d H:i:s');
                $end_at = $formattedStartAt;
            } else {
                // Nếu không phải là số, kiểm tra nếu nó là một định dạng thời gian hợp lệ.
                try {
                    $carbonStartAt = Carbon::parse($end_at);
                    $formattedStartAt = $carbonStartAt->format('Y-m-d H:i:s');
                    $end_at = $formattedStartAt;
                } catch (\Exception $e) {
                    echo("  \033[1m\033[31mERROR\033[0m  : Ngày bắt đầu không hợp lệ - import_id: " . $id . "!\n" . $end_at);
                    $this->addError("Ngày bắt đầu không hợp lệ - import_id: " . $id, $data);
                    return;
                }
            }
        }

        // if ($end_at != '') {
        //     if (!boolval(filter_var($end_at, FILTER_VALIDATE_INT))) {
        //         echo("  \033[1m\033[31mERROR\033[0m  : Ngày kết thúc không hợp lệ - import_id: " . $id . "!\n");
        //         $this->addError("Ngày kết thúc không hợp lệ - import_id: " . $id, $data);
        //         return;
        //     }
         
        //     $endAtUnixTimestamp = (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($end_at));
        //     $formattedEndAt = date('Y-m-d H:i:s', $endAtUnixTimestamp);
        //     $end_at = $formattedEndAt;
        // }

        if ($teacher_id == '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu chủ nhiệm - import_id: " . $id . "!\n");
            $this->addError("Không có dữ liệu chủ nhiệm - import_id: " . $id, $data);
            return;
        }

        $homeRoom = Teacher::where('type', Teacher::TYPE_HOMEROOM)->where('name', $teacher_id)->first();

        if (!$homeRoom) {
            echo("  \033[1m\033[31mERROR\033[0m  : Giáo viên chủ nhiệm này không tồn tại - import_id: " . $id . "!\n");
            $this->addError("Giáo viên chủ nhiệm này không tồn tại - import_id: " . $id, $data);
            return;
        }

        $newCourse = Course::create([
            'import_id' => $id,
            'subject_id' => $subject->id,
            'study_method' => $study_method,
            'zoom_start_link' => $study_method == Course::STUDY_METHOD_ONLINE ? $zoom_start_link : null,
            'zoom_join_link' => $study_method == Course::STUDY_METHOD_ONLINE ? $zoom_join_link : null,
            'zoom_password' => $study_method == Course::STUDY_METHOD_ONLINE ? $zoom_pass : null,
            'level' => $level,
            'start_at' => $start_at,
            'end_at' => $end_at,
            'status' => Course::WAITING_OPEN_STATUS,
            'module' => Course::MODULE_EDU,
            'teacher_id' => $homeRoom->id,
            'vn_teacher_duration' => $vn_teacher_duration == '' ? null : $vn_teacher_duration,
            'foreign_teacher_duration' => $foreign_teacher_duration == '' ? null : $foreign_teacher_duration,
            'tutor_duration' => $tutor_duration == '' ? null : $tutor_duration,
            'assistant_duration' => $assistant_duration == '' ? null : $assistant_duration,
            'duration_each_lesson' => $duration_each_lesson == '' ? null : $duration_each_lesson,
            'max_students' => $max_students,
            'min_students' => $min_students,
            'total_hours' => $total_hours,
            'test_hours' => $test_hours != '' ? $test_hours : 0,
            'training_location_id' => $study_method == Course::STUDY_METHOD_OFFLINE ? $trainingLocation->id : null,
        ]);

        $newCourse->generateCodeName();

        if ($newCourse) {
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công LỚP HỌC - import_id: " . $id . "\n");
        }

        return $newCourse;
    }

    private function addError($message, $data)
    {
        $this->errors[] = [
            'message' => $message,
            'data' => $data
        ];
    }

    private function addWarning($message, $data)
    {
        $this->warnings[] = [
            'message' => $message,
            'data' => $data
        ];
    }

    private function exportErrorsAndWarnings()
    {
        $filePath = storage_path('logs/loi_lophoc.txt');
        $fileContent = "Lỗi:\n";

        foreach ($this->errors as $error) {
            $fileContent .= $error['message'] . "\n";
        }

        $fileContent .= "\nCảnh báo:\n";

        foreach ($this->warnings as $warning) {
            $fileContent .= $warning['message'] . "\n";
        }

        File::put($filePath, $fileContent);

        echo("  \033[1m\033[34mINFO\033[0m: Course data errors and warnings have been exported to " . $filePath . "\n");
    }
}
