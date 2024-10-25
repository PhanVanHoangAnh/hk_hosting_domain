<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\Carbon;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type','phone', 'email','birthday', 'busy_schedule', 'area', 'code'];

    // public const TYPE_VIETNAM = 'Giáo viên Việt Nam';
    // public const TYPE_FOREIGN = 'Giáo viên Nước Ngoài';
    // public const TYPE_TUTOR = 'TUTOR';
    // public const TYPE_HOMEROOM = 'Chủ nhiệm';
    // public const TYPE_ASSISTANT = 'Trợ giảng';
    // public const TYPE_ASSISTANT_KID = 'Trợ giảng KID';
    public const TYPE_VIETNAM = Role::ALIAS_VN_TEACHER;
    public const TYPE_FOREIGN = Role::ALIAS_ABROAD_TEACHER;
    public const TYPE_TUTOR = Role::ALIAS_TUTOR;
    public const TYPE_HOMEROOM = Role::ALIAS_HOMEROOM_TEACHER;
    public const TYPE_ASSISTANT = Role::ALIAS_ASSISTANT;
    public const TYPE_ASSISTANT_KID = Role::ALIAS_KID_ASSISTANT;
    public const TYPE_TRAINING = 'Giáo viên Đào tạo';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_OFF = 'off';

    // Homeroom
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function freeTimes()
    {
        return $this->hasMany(FreeTime::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function getAllStatus() 
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_OFF
        ];
    }

    public static function scopeGetAllTypeVariable()
    {
        return [
            self::TYPE_VIETNAM,
            self::TYPE_FOREIGN,
            self::TYPE_TUTOR,
            self::TYPE_HOMEROOM,
            self::TYPE_ASSISTANT,
            // self::TYPE_TRAINING,
            self::TYPE_ASSISTANT_KID,
        ];
    }

    public static function scopeSearch($query, $keyword) 
    {   
        $query = $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('teachers.type', 'LIKE', "%{$keyword}%");
    }

    public static function scopeDeleteStaffs($query, $items)
    {
        Teacher::whereIn('id', $items)->delete();
    }

    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        return $query->orderBy($sortColumn, $sortDirection);
    }

    public static function scopeFilterByTeacherIds($query, $teacherId)
    {
        $query = $query->whereIn('teachers.id', $teacherId);
    }
    
    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('teachers.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('teachers.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeIsVietNam($query)
    {
        $query = $query->where('teachers.type', self::TYPE_VIETNAM);
    }

    public static function scopeIsForeign($query)
    {
        $query = $query->where('teachers.type', self::TYPE_FOREIGN);
    }

    public static function scopeIsTutor($query)
    {
        $query = $query->where('teachers.type', self::TYPE_TUTOR);
    }

    public static function scopeIsAssistant($query)
    {
        $query = $query->where('teachers.type', self::TYPE_ASSISTANT);
    }

    public static function scopeIsAssistantKid($query)
    {
        $query = $query->where('teachers.type', self::TYPE_ASSISTANT_KID);
    }

    public static function scopeIsAssistantAndAssistantKid($query)
    {
        $query = $query->whereIn('teachers.type', [self::TYPE_ASSISTANT, self::TYPE_ASSISTANT_KID]);
    }

    public static function scopeIsHomeRoom($query)
    {
        $query = $query->where('teachers.type', self::TYPE_HOMEROOM);
    }

    public function scopeHomeRooms($query)
    {
        $query->where('type', self::TYPE_HOMEROOM);
    }

    public function checkIsVietnam()
    {
        return $this->type === self::TYPE_VIETNAM;
    }

    public function checkIsForeign()
    {
        return $this->type === self::TYPE_FOREIGN;
    }

    public function checkIsTutor()
    {
        return $this->type === self::TYPE_TUTOR;
    }
    
    public static function scopeFilterByStaffTypes($query, $staffTypes)
    {   
        $query = $query->whereIn('teachers.type', $staffTypes);
    }

    public static function scopeFilterByStatuses($query, $statuses)
    {   
        $query = $query->whereIn('teachers.status', $statuses);
    }

    public function storeFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'email' => 'required|email', 
            'area' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->generateCode();
        $this->save();

        return $validator->errors();
    }

    public function generateCode()
    {
        if($this->type == self::TYPE_VIETNAM){
            $this->generateCodeVN();
        }

        if($this->type == self::TYPE_FOREIGN){
            $this->generateCodeForeign();
        }

        if($this->type == self::TYPE_TUTOR){
            $this->generateCodeTutor();
        }

        if($this->type == self::TYPE_ASSISTANT){
            $this->generateCodeAssistant();
        }
    }

    public function generateCodeAssistant()
    {
        // Tìm mã giáo viên cuối cùng đã được tạo
        $lastCode = self::where('code', 'like', "TA%")
                        ->orderBy('code', 'desc')
                        ->first();
    
        // Xác định số mã tiếp theo
        $number = 1; // Bắt đầu từ 1 nếu không có mã trước đó

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode->code, 2); // Lấy các số từ ký tự thứ 3 trở đi
            $number = $lastNumber + 1;
        }
    
        // Tạo mã mới
        $code = "TA" . str_pad($number, 4, '0', STR_PAD_LEFT);
    
        // Lưu mã vào cơ sở dữ liệu
        $this->code = $code;
        $this->save();
    }

    public function generateCodeTutor()
    {
        // Tìm mã giáo viên cuối cùng đã được tạo
        $lastCode = self::where('code', 'like', "TT%")
                        ->orderBy('code', 'desc')
                        ->first();
    
        // Xác định số mã tiếp theo
        $number = 1; // Bắt đầu từ 1 nếu không có mã trước đó

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode->code, 2); // Lấy các số từ ký tự thứ 3 trở đi
            $number = $lastNumber + 1;
        }
    
        // Tạo mã mới
        $code = "TT" . str_pad($number, 4, '0', STR_PAD_LEFT);
    
        // Lưu mã vào cơ sở dữ liệu
        $this->code = $code;
        $this->save();
    }

    public function generateCodeVN()
    {
        // Tìm mã giáo viên cuối cùng đã được tạo
        $lastCode = self::where('code', 'like', "GV%")
                        ->orderBy('code', 'desc')
                        ->first();
    
        // Xác định số mã tiếp theo
        $number = 1; // Bắt đầu từ 1 nếu không có mã trước đó

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode->code, 2); // Lấy các số từ ký tự thứ 3 trở đi
            $number = $lastNumber + 1;
        }
    
        // Tạo mã mới
        $code = "GV" . str_pad($number, 4, '0', STR_PAD_LEFT);
    
        // Lưu mã vào cơ sở dữ liệu
        $this->code = $code;
        $this->save();
    }

    public function generateCodeForeign()
    {
        // Tìm mã giáo viên cuối cùng đã được tạo
        $lastCode = self::where('code', 'like', "GN%")
                        ->orderBy('code', 'desc')
                        ->first();
    
        // Xác định số mã tiếp theo
        $number = 1; // Bắt đầu từ 1 nếu không có mã trước đó

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode->code, 2); // Lấy các số từ ký tự thứ 3 trở đi
            $number = $lastNumber + 1;
        }
    
        // Tạo mã mới
        $code = "GN" . str_pad($number, 4, '0', STR_PAD_LEFT);
    
        // Lưu mã vào cơ sở dữ liệu
        $this->code = $code;
        $this->save();
    }
    
    public function saveBusyScheduleFromRequest($request)
    {
        $this->fill($request->all());

        $busySchedule = json_decode($request->busy_schedule);
        
        if ($this->hasCoursesInBusyTime($busySchedule)) {
            throw new \Exception("Trùng lịch rảnh với lịch dạy hiện tại!");
        }

        $validator = Validator::make($request->all(), [
            'busy_schedule' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();

        return $validator->errors();
    }

    public static function newDefault()
    {
        $teacher = new self();

        return $teacher;
    }

    public function getAmountForSubject($subjectId)
    {
        $payrate = $this->payrates()
            ->where('subject_id', $subjectId)
            ->where('effective_date', '<', now()) 
            ->orderBy('effective_date', 'desc') 
            ->first();

        return $payrate ? $payrate->amount : null;
    }

    public function getAmountForSubjectOfCourse($course)
    {
        $maxClassSize = ($course->max_students < 10) ? $course->max_students : 10;
        $payrate = $this->payrates()
            ->where('subject_id', $course->subject_id)
            ->where('study_method', $course->study_method)
            ->where('class_size',  $maxClassSize)
            ->where('effective_date', '<', now())
            ->orderBy('effective_date', 'desc')
            ->first();
       
            return $payrate ;
    }

    public function payrates()
    {
        return $this->hasMany(Payrate::class);
    }

    public function calculateTotalAmountForOrderItem($orderItem)
    {
        $vietnamAmount = $this->checkIsVietnam() ? $orderItem->getTotalVnMinutes() / 60 * $this->getAmountForSubject($orderItem->subject_id) : 0;
        $foreignAmount = $this->checkIsForeign() ? $orderItem->getTotalForeignMinutes() / 60 * $this->getAmountForSubject($orderItem->subject_id) : 0;
        $tutorAmount = $this->checkIsTutor() ? $orderItem->getTotalTutorMinutes() / 60 * $this->getAmountForSubject($orderItem->subject_id) : 0;
        $totalAmount = $vietnamAmount + $foreignAmount + $tutorAmount;

        return $totalAmount;
    }

    private function getCoursesForTeacher($teacherId)
    {
        $sectionCourses = Section::where(function ($query) use ($teacherId) {
            $query->where('vn_teacher_id', $teacherId)
                ->orWhere('foreign_teacher_id', $teacherId)
                ->orWhere('tutor_id', $teacherId)
                ->orWhere('assistant_id', $teacherId);
        })->distinct('course_id')->pluck('course_id');

        return Course::whereIn('id', $sectionCourses)->get();
    }

    public function getCoursesForTeacherFromTo($section_from, $section_to)
    {
        $courses = $this->getCoursesForTeacher($this->id);
        $filteredCourses = $courses->filter(function ($course) use ($section_from, $section_to) {
            //nếu khóa học có section nằm trong khoảng thời gian
            
            return $course->sections()->whereBetween('study_date', [$section_from, $section_to])->exists();
        });
    
        return $filteredCourses;
    }
    
    /**
     * Check to see if the current teacher is available during the specified time slot?
     * 
     * @return Boolean
     * @param from Start time
     * @param to End time
     */
    public function isBusy($day, $from, $to) {
        $busySchedule = $this->busy_schedule;
    
        if (is_null($busySchedule)) {
            return false;
        }

        // Decode JSON string into PHP array
        $busySlots = json_decode($busySchedule, true);

        foreach ($busySlots as $slot) {
            foreach ($slot as $schedule) {
                $busyStartTime = strtotime($schedule['time']);
                $busyEndTime = strtotime($schedule['endTime']);
                $checkStartTime = strtotime($from);
                $checkEndTime = strtotime($to);

                $dayName;

                switch($schedule['day']) {
                    case '1':
                        $dayName = 'sun';
                        break;
                    case '2':
                        $dayName = 'mon';
                        break;
                    case '3':
                        $dayName = 'tue';
                        break;
                    case '4':
                        $dayName = 'wed';
                        break;
                    case '5':
                        $dayName = 'thur';
                        break;
                    case '6':
                        $dayName = 'fri';
                        break;
                    case '7':
                        $dayName = 'sat';
                        break;
                    default:
                        $dayName = 'sun';
                        break;
                }
    
                // Check for overlap
                if ($dayName == $day) {
                    if (($checkStartTime >= $busyStartTime && $checkStartTime < $busyEndTime) || ($checkEndTime > $busyStartTime && $checkEndTime <= $busyEndTime)) {
                        return true; // Overlap found, teacher is busy
                    }
                }
            }
        }
    
        return false; // No overlap found, teacher is not busy
    }

    /**
     * Retrieve all courses that have this teacher(not homeroom) V.1
     * 
     * Can use the query builder to find teachers in various sections based on their teacher ID, then trace back to courses. 
     * However, there might be cases where classes are created but not yet scheduled, leading to the absence of sections. 
     * In such cases, it's necessary to find courses through the JSON schedule
     * 
     * Use this function when not certain whether the classes have been scheduled and applied to the timetable yet
     */
    public function getCourses(): Collection
    {
        $courses = Course::where('week_schedules', '!=', null)->get();
        $teacherCourses = collect();

        foreach ($courses as $course) {
            $weekSchedules = json_decode($course->week_schedules, true);

            foreach ($weekSchedules as $weekSchedule) {
                foreach ($weekSchedule['schedules'] as $schedule) {
                    if ($schedule['vn_teacher_id'] == $this->id ||
                        $schedule['foreign_teacher_id'] == $this->id ||
                        $schedule['tutor_id'] == $this->id) {
                        $teacherCourses->push($course);

                        break 2;
                    }
                }
            }
        }

        return $teacherCourses;
    }

    /**
     * Retrieve all courses that have this teacher(not homeroom) V.2
     * 
     * Use this function when certain that the class has been scheduled and applied to the timetable,
     * and sections have been created.
     */
    public function getCoursesThroughSections(): Collection
    {
        return Course::whereHas('sections', function ($q) {
            $q->where(function ($q2) {
                $q2->where('vn_teacher_id', $this->id)
                ->orWhere('foreign_teacher_id', $this->id)
                ->orWhere('tutor_id', $this->id)
                ->orWhere('assistant_id', $this->id);
            });
        })->get();
    }

    public function scopeAllCourses($query, $teacher)
    {
        return Course::whereHas('sections', function ($q) use ($teacher) {
            $q->where(function ($q2) {
                $q2->where('vn_teacher_id', $teacher->id)
                ->orWhere('foreign_teacher_id', $teacher->id)
                ->orWhere('tutor_id', $teacher->id)
                ->orWhere('assistant_id', $teacher->id);
            });
        });
    }

    public function scopeAllSections($query, $teacher)
    {
        return Section::where(function ($query) use ($teacher) {
            $query->where('vn_teacher_id', $teacher->id)
                ->orWhere('foreign_teacher_id', $teacher->id)
                ->orWhere('tutor_id', $teacher->id)
                ->orWhere('assistant_id', $teacher->id);
        });
    }

    public function getCourses2(): Collection
    {
        return Section::where(function ($query) {
            $query->where('vn_teacher_id', $this->id)
                ->orWhere('foreign_teacher_id', $this->id)
                ->orWhere('tutor_id', $this->id)
                ->orWhere('assistant_id', $this->id);
        })->get(); // This return a collection of sections, not courses
    }

    public function convertDayOfWeek($dayOfWeek) {
        // Chuyển đổi giá trị từ 1-7 thành 0-6
        $dayOfWeek = ($dayOfWeek == 7) ? 0 : $dayOfWeek;
    
        // Tăng giá trị lên 1 để CN được đánh số là 1
        return $dayOfWeek + 1;
    }

    public function checkHasCoursesInFreeTime($from_date, $to_date, $busy_schedule)
    {
        $sections = $this->getCourses2();
        $conflictFound = false;

        foreach ($sections as $section) {
            // Kiểm tra nếu ngày học nằm trong khoảng thời gian rảnh
            if ($section->study_date >= $from_date && $section->study_date <= $to_date) { 
                $dayOfWeekSection = $this->convertDayOfWeek(date('N', strtotime($section->study_date)));

                // Duyệt qua các lịch rảnh
                foreach ($busy_schedule as $schedule) {
                    foreach ($schedule as $entry) {
                        if (is_array($entry)) {
                            if ($dayOfWeekSection == $entry['day'] || $dayOfWeekSection == (int) $entry['day']) {
                                if ($this->checkTimeOverlap($entry, $section, $dayOfWeekSection)) {
                                    return true;
                                }
                            }
                        } else { 
                            if ($dayOfWeekSection == $schedule['day'] || $dayOfWeekSection == (int) $schedule['day']) {
                                if ($this->checkTimeOverlap($schedule, $section, $dayOfWeekSection)) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        } 

        return false;
    }

    public function checkTimeOverlap($entry, $section, $dayOfWeekSection)
    {
        $startTimeBusy = date('H:i', strtotime($entry['time']));
        $endTimeBusy = date('H:i', strtotime($entry['endTime']));
        $startTimeSection = date('H:i', strtotime($section->start_at));
        $endTimeSection = date('H:i', strtotime($section->end_at));
                                    
        return !($endTimeBusy <= $startTimeSection || $startTimeBusy >= $endTimeSection);
    }
    
    /**
     * Check in all courses of this teacher whether has overlap with the busytime
     */
    public function hasCoursesInBusyTime($busySchedule)
    {
        $courses = $this->getCourses();
        $idField;
        $isOverLap = false;

        switch($this->type) {
            case self::TYPE_VIETNAM: 
                $idField = "vn_teacher";
                break;
            case self::TYPE_FOREIGN: 
                $idField = "foreign_teacher";
                break;
            case self::TYPE_TUTOR:
                $idField = "tutor";
                break;
            default:
                $idField = "vn_teacher";
                break;
        }

        if ($courses->count() == 0) {
            return false;
        }

        foreach ($courses as $course) {
            $weekSchedules = json_decode($course->week_schedules, true);
    
            foreach ($weekSchedules as $item) {
                $day = $item['name'];
                $schedules = $item['schedules'][0];
                
                if ($isOverLap) {
                    break;
                }
    
                if (!is_null($schedules) && !is_null($schedules[$idField . '_id'])) {
                    $checkStartTime = strtotime($schedules[$idField . '_from']);
                    $checkEndTime = strtotime($schedules[$idField . '_to']);
    
                    foreach ($busySchedule as $busyTime) {
                        $dayName;
    
                        if (isset($busyTime[0])) {
                            switch($busyTime[0]->day) {
                                case '1':
                                    $dayName = 'sun';
                                    break;
                                case '2':
                                    $dayName = 'mon';
                                    break;
                                case '3':
                                    $dayName = 'tue';
                                    break;
                                case '4':
                                    $dayName = 'wed';
                                    break;
                                case '5':
                                    $dayName = 'thur';
                                    break;
                                case '6':
                                    $dayName = 'fri';
                                    break;
                                case '7':
                                    $dayName = 'sat';
                                    break;
                                default:
                                    $dayName = 'sun';
                                    break;
                            }
        
                            if (count($busyTime) > 0) {
                                $time = $busyTime[0];
                                $busyStartTime = strtotime($time->time);
                                $busyEndTime = strtotime($time->endTime);
            
                                if ($dayName == $day) {
                                    if (($checkStartTime >= $busyStartTime && $checkStartTime < $busyEndTime) || ($checkEndTime > $busyStartTime && $checkEndTime <= $busyEndTime)) {
                                        $isOverLap = true;
                                        break; // Overlap found, teacher is busy
                                    }    
                                }
                            }
                        }
                    }
                }
            }
        }

        return $isOverLap;
    }

    public static function exportToExcelTeacherHourReport($templatePath, $filteredTeachers, $section_from, $section_to)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
    
        foreach ($filteredTeachers as $index => $teacher) {
            $courseCodes = [];
            $numberStudent = [];
            $subject = [];
            $classType = [];
            $timeSlot = [];
            $statusSubject = [];
            $time = [];
            $rate = [];
            $total = [];
            $totalStudiedHours = 0; // Initialize $totalStudiedHours here
            $totalAmount = 0; // Initialize $totalStudiedHours here

            foreach ($teacher->getCoursesForTeacherFromTo($section_from, $section_to) as $course) {
                $courseCodes[] = $course->code;
                $numberStudent[] = $course->countStudentsByCourse() . '/' . $course->max_students . ' học viên';
                $subject[] = $course->subject->name;
                $classType[] = trans('messages.courses.class_type.' . $course->class_type);
                $timeSlot[] = \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') . '-' . ($course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--');
                $statusSubject[] = $course->checkStatusSubject();
    
                $studiedHours = 0;
                if ($teacher->type === Teacher::TYPE_VIETNAM) {
                    $studiedHours = $course->getStudiedHoursForCourseFromToOfTeacher('vn_teacher', $section_from, $section_to);
                } elseif ($teacher->type === Teacher::TYPE_FOREIGN) {
                    $studiedHours = $course->getStudiedHoursForCourseFromToOfTeacher('foreign_teacher', $section_from, $section_to);
                } elseif ($teacher->type === Teacher::TYPE_TUTOR) {
                    $studiedHours = $course->getStudiedHoursForCourseFromToOfTeacher('tutor', $section_from, $section_to);
                }

                $totalStudiedHours += $studiedHours;
                $time[] = number_format($studiedHours, 2) . 'giờ';
    
                $rateValue = $teacher->getAmountForSubject($course->subject_id);
                $rate[] = $rateValue !== null ? number_format($rateValue) . '₫' : 'Chưa có rate';
    
                $amount = $rateValue !== null ? $studiedHours * $rateValue : 0;
                $totalAmount += $amount;
                $total[] = $rateValue !== null ? number_format($amount) . '₫' : 'Chưa có rate';
            }
    
            $rowData = [
                // $index + 1,
                $teacher->id,
                $teacher->name,
                $teacher->type,
                implode(PHP_EOL, $courseCodes),
                implode(PHP_EOL, $numberStudent),
                implode(PHP_EOL, $subject),
                implode(PHP_EOL, $classType),
                implode(PHP_EOL, $timeSlot),
                implode(PHP_EOL, $statusSubject),
                implode(PHP_EOL, $time),
                implode(PHP_EOL, $rate),
                implode(PHP_EOL, $total),
            ];
    
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }
               
    public static function scopeHasPayrateBySubject($query, $subjectId)
    {
        $query->whereHas('payrates', function ($q) use ($subjectId) {
            $q->where('subject_id', $subjectId);
        });
    }

    /**
     * Get teacher in area
     */
    public static function scopeInArea($query, $area)
    {
        if (in_array($area, TrainingLocation::getBranchs()->toArray())) {
            $sgArray = [
                'SG',
                'Sài Gòn'
            ];

            $hnArray = [
                'HN',
                'Hà Nội'
            ];

            $areaArray;

            if ($area == 'HN') {
                $areaArray = $hnArray;
            } 

            if ($area == 'SG') {
                $areaArray = $sgArray;
            } 

            $query = $query->whereIn('area', $areaArray);
        } elseif($area == 'all') {
            $query = $query;
        } else {
            throw new \Exception("Invalid area!");
        }
    }

    //Giờ dạy
    public function getTeachedHours($section_from, $section_to)
    {
        $teacherHour = $this->getSectionForTeacher($this->id,$section_from, $section_to);
        
        return $teacherHour;
    }

    private function getSectionForTeacher($teacherId,$section_from, $section_to)
    {
        $sectionCourses = Section::where('status','=',Section::STATUS_STUDIED)
        ->where(function ($query) use ($teacherId,$section_from, $section_to) {
            $query->where('study_date','<=',$section_to)
            ->where('study_date','>=',$section_from)
            
            ->where('vn_teacher_id', $teacherId)
                ->orWhere('foreign_teacher_id', $teacherId)
                ->orWhere('tutor_id', $teacherId)
                ->orWhere('assistant_id', $teacherId);
        })
        ->get();

        $teacherHour = Section::getTotalHoursOfSectionsStudied($sectionCourses);

        return $teacherHour;
    }

    //Giờ nghỉ có kế hoạch
    public function getCancelledTeachedHours($section_from, $section_to)
    {
        $teacherHour = $this->getCancelledSectionForTeacher($this->id,$section_from, $section_to);
        
        return $teacherHour;
    }

    private function getCancelledSectionForTeacher($teacherId,$section_from, $section_to)
    {
        $sectionCourses = Section::where('status','=',Section::STATUS_CANCELLED)
        ->where(function ($query) use ($teacherId,$section_from, $section_to) {
            $query->where('study_date','<=',$section_to)
            ->where('study_date','>=',$section_from)
            
            ->where('vn_teacher_id', $teacherId)
                ->orWhere('foreign_teacher_id', $teacherId)
                ->orWhere('tutor_id', $teacherId)
                ->orWhere('assistant_id', $teacherId);
        })->get();

        $teacherHour = Section::getTotalHoursOfSectionsStudied($sectionCourses);

        return $teacherHour;
    }

    //Giờ nghỉ do giảng viên
    public function getLateCancelledTeacherHours($section_from, $section_to)
    {
        $teacherHour = $this->getLateCancelledTeacherSection($this->id,$section_from, $section_to);
        
        return $teacherHour;
    }

    private function getLateCancelledTeacherSection($teacherId,$section_from, $section_to)
    {
        $sectionCourses = Section::where('status','=',Section::LATE_CANCELLED_TEACHER)
        ->where(function ($query) use ($teacherId,$section_from, $section_to) {
            $query->where('study_date','<=',$section_to)
            ->where('study_date','>=',$section_from)
            
            ->where('vn_teacher_id', $teacherId)
                ->orWhere('foreign_teacher_id', $teacherId)
                ->orWhere('tutor_id', $teacherId)
                ->orWhere('assistant_id', $teacherId);
        })->get();

        $teacherHour = Section::getTotalHoursOfSectionsStudied($sectionCourses);

        return $teacherHour;
    }

    //Giờ nghỉ do học sinh
    public function getLateCancelledStudentHours($section_from, $section_to)
    {
        $teacherHour = $this->getLateCancelledStudentSection($this->id,$section_from, $section_to);
        
        return $teacherHour;
    }

    private function getLateCancelledStudentSection($teacherId,$section_from, $section_to)
    {
        $sectionCourses =Section::where('status','=',Section::LATE_CANCELLED_STUDENT)
        ->where(function ($query) use ($teacherId,$section_from, $section_to) {
            $query->where('study_date','<=',$section_to)
            ->where('study_date','>=',$section_from)
          
            ->where('vn_teacher_id', $teacherId)
                ->orWhere('foreign_teacher_id', $teacherId)
                ->orWhere('tutor_id', $teacherId)
                ->orWhere('assistant_id', $teacherId);
        })->get();

        $teacherHour = Section::getTotalHoursOfSectionsStudied($sectionCourses);

        return $teacherHour;
    }

    //Giờ chưa dạy
    public function getTeachedHoursActive($section_from, $section_to)
    {
        $teacherHour = $this->getSectionForTeacherActive($this->id,$section_from, $section_to);
        
        return $teacherHour;
    }

    private function getSectionForTeacherActive($teacherId,$section_from, $section_to)
    {
        $sectionCourses = Section::where('status','=',Section::STATUS_ACTIVE)
        ->where(function ($query) use ($teacherId,$section_from, $section_to) {
            $query->where('study_date','<=',$section_to)
            ->where('study_date','>=',$section_from)
            
            ->where('vn_teacher_id', $teacherId)
                ->orWhere('foreign_teacher_id', $teacherId)
                ->orWhere('tutor_id', $teacherId)
                ->orWhere('assistant_id', $teacherId);
        })->get();

        $teacherHour = Section::getTotalHoursOfSectionsStudied($sectionCourses);

        return $teacherHour;
    }

    // Tổng cộng
    public function getTeachedHoursTotal($section_from, $section_to)
    {
        $teacherHourTotal = $this->getTeachedHoursActive($section_from, $section_to) 
                          + $this->getLateCancelledStudentHours($section_from, $section_to) 
                          + $this->getLateCancelledTeacherHours($section_from, $section_to) 
                          + $this->getCancelledTeachedHours($section_from, $section_to) 
                          + $this->getTeachedHours($section_from, $section_to);

        return $teacherHourTotal;
    }

     // Tỷ lệ thực tế / Cam kết
     public function getTeachedHoursRatio($section_from, $section_to)
     { 
        $teacherHoursCommitted = 0;

        foreach ($this->payrates as $payrate) {
            $teacherHoursCommitted += $payrate->hours_committed;
        }
        
        if ($teacherHoursCommitted !== 0) {
            $teacherHourRatio = ($this->getTeachedHours($section_from, $section_to) / $teacherHoursCommitted) * 100;
        } else {
            return 100;
        }
      
         return $teacherHourRatio;
     }

     /**
      * Get the free time sections for the teacher
      * 
      * @return array
      */
     public function getFreeTimeSections(): array
     {
        $freeTimes = $this->freeTimes()->get();
        $result = [];

        foreach($freeTimes as $freeTime) {
            // Count num of days
            $startDate = new DateTime($freeTime->from_date);
            $endDate = new DateTime($freeTime->to_date);
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

            // Loop per day in the period
            foreach($period as $date) {
                $dayOfWeek = $date->format('N');

                if ($dayOfWeek == 7) {
                    $dayOfWeek = 1; // Change number 7 -> 1 (Sunday)
                } else {
                    $dayOfWeek += 1; // Upgrade +1 to every day
                }

                // Get the timestamps in the day from free_time_records
                $freeTimeRecords = $freeTime->freeTimeRecords()
                                            ->where('day_of_week', $dayOfWeek)
                                            ->get();

                // Loop per timestamps and push into result[]
                foreach($freeTimeRecords as $record) {
                    $result[] = [
                        'study_date' => $date->format('Y-m-d'),
                        'start_at' => $date->format('Y-m-d') . ' ' . $record->from,
                        'end_at' => $date->format('Y-m-d') . ' ' . $record->to,
                        // Additional fields with default values
                        "code" => "",
                        "type" => "",
                        "is_vn_teacher_check" => false,
                        "vn_teacher_id" => null,
                        "vn_teacher_from" => "",
                        "vn_teacher_to" => "",
                        "is_foreign_teacher_check" => false,
                        "foreign_teacher_id" => null,
                        "foreign_teacher_from" => "",
                        "foreign_teacher_to" => "",
                        "is_tutor_check" => false,
                        "tutor_id" => null,
                        "tutor_from" => "",
                        "tutor_to" => "",
                        "is_assistant_check" => false,
                        "assistant_id" => null,
                        "assistant_from" => "",
                        "assistant_to" => "",
                        "order_number" => 1,
                        "viewer" => 'freetime',
                    ];
                }
            }
        }

        return $result;
     }

     public static function scopeHasSubject($query, $subject)
     {
        $query->whereHas('payrates', function($q) use ($subject) {
            $q->where('subject_id', $subject->id);
        });
     }

     /**
      * Check with day name, period times input, this teacher is in free?
      * 
      * @return bool
      */
     public function isInFreeTime($dayName, $start, $end): bool
     {
        // Convert dayname to number of day in week
        $dayOfWeek = strtolower($dayName);
        $dayNumber = date('N', strtotime($dayOfWeek));

        // Get list of free time base on day in week and start, end
        $freeTimes = FreeTime::where('from_date', '<=', now()->endOfMonth())
                             ->where('to_date', '>=', now()->startOfMonth())
                             ->whereHas('freeTimeRecords', function ($query) use ($dayNumber, $start, $end) {
                                $query->where('day_of_week', $dayNumber)
                                      ->where('from', '<=', $start)
                                      ->where('to', '>=', $end);
                             })
                            ->get();

        return $freeTimes->isNotEmpty();
     } 
    public static function scopeByBranch($query, $branch)
    {   
        if ($branch === \App\Library\Branch::BRANCH_ALL) {
            $area = ['HN', 'SG']; 
        } else {
            $area = ($branch === 'HN') ? ['HN', 'Hà Nội'] : (($branch === 'SG') ? ['SG', 'Sài Gòn'] : [$branch]);
        }

        return $query->whereIn('area', $area);
    }

    public function getSections()
    {
        return Section::withTeacherId($this->id)->get();
    }

    public function getAllSections()
    {
        return Section::where(function ($q) {
            $q->where('vn_teacher_id', $this->id)
              ->orWhere('foreign_teacher_id', $this->id)
              ->orWhere('tutor_id', $this->id)
              ->orWhere('assistant_id', $this->id);
        });
    }

    public function getAllSectionsByCourse($course)
    {
        return $this->getAllSections()->where('couser_id', $course->id);
    }

    public function findOrNewUser()
    {
        $user = User::where('email', '=', $this->email)->first();

        if (!$user) {
            $user = new User([
                'name' => $this->name,
                'email' => $this->email,
                'branch' => $this->account && $this->account->branch ? $this->account->branch : \App\Library\Branch::getDefaultBranch(),
            ]);
        }

        return $user;
    }

    public function saveUserAccountFromRequest($request)
    {
        $user = $this->findOrNewUser();
        $errors = $user->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return [$user, $errors];
        }

        // update contact email address
        $this->email = $user->email;
        $this->save();
        
        //
        $user = User::find($user->id);
        
        // set teacher
        $user->account->setTeacher($this);

        return [$user, collect([])];
    }

    public function getCode()
    {
        return 'STA' . sprintf('%05d', $this->id);
    }
}
