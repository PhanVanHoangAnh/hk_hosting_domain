<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Events\UpdateSchedule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Collection;

class Course extends Model
{
    use HasFactory;

    public const MODULE_EDU = 'edu';
    public const MODULE_ABROAD = 'abroad';

    protected $fillable = [
        'type',
        'subject_id',
        'level',
        'study_method',
        'status',
        'teacher_id',
        'max_students',
        'min_students',
        'start_at',
        'end_at',
        'total_hours',
        'vn_teacher_duration',
        'foreign_teacher_duration',
        'tutor_duration',
        'assistant_duration',
        'joined_students',
        'flexible_students',
        'week_schedules',
        'training_location_id',
        'class_type',
        'zoom_start_link',
        'zoom_join_link',
        'zoom_password',
        'module',
        'test_hours',
        'class_room',
        'extracurricular_id',
        'abroad_service_id',
        'order_item_id',
        'zoom_user_id',
        'code_year',
        'code_number',
    ];

    const STATUS_DELETED = 'deleted';
    const STATUS_ACTIVE = 'active';
    public const OPENING_STATUS = 'Đang học';
    public const COMPLETED_STATUS = 'Hoàn thành';
    public const WAITING_OPEN_STATUS = 'Chưa học';
    public const STUDY_METHOD_ONLINE = 'Online';
    public const STUDY_METHOD_OFFLINE = 'Offline';

    public const DATE_COMPARE = '2024-06-01';

    // Class type
    public const CLASS_TYPE_ONE_ONE = '1:1';
    public const CLASS_TYPE_GROUP = 'Nhóm';

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id', 'id');
    }

    public function abroadService()
    {
        return $this->belongsTo(AbroadService::class);
    }

    public static function getAllClassTypes()
    {
        return [
            self::CLASS_TYPE_ONE_ONE,
            self::CLASS_TYPE_GROUP,
        ];
    }

    public static function scopeGetAllStudyMethod()
    {
        return [
            self::STUDY_METHOD_ONLINE,
            self::STUDY_METHOD_OFFLINE,
        ];
    }

    public static function scopeGetAllStatus()
    {
        return [
            self::OPENING_STATUS,
            self::COMPLETED_STATUS,
            self::WAITING_OPEN_STATUS,
        ];
    }

    public static function newDefault()
    {
        $course = new self();
        $course->status = self::WAITING_OPEN_STATUS;
        
        return $course;
    }

    public static function scopeCourse()
    {
        $course = new self();
        $course->status = self::WAITING_OPEN_STATUS;
        return $course;
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }

    // Homeroom
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        return $query->orderBy($sortColumn, $sortDirection);
    }

    public function scopeWithAbroadService($query, $abroadServiceNames)
    {
        if (!is_array($abroadServiceNames)) {
            $abroadServiceNames = [$abroadServiceNames];
        }

        return $query->whereHas('abroadService', function ($query) use ($abroadServiceNames) {
            $query->whereIn('name', $abroadServiceNames);
        });
    }

    public static function scopeSearch($query, $keyword)
    {
        $query = $query
                ->where('code', 'LIKE', "%{$keyword}%")
                ->orWhere('import_id', 'LIKE', "%{$keyword}%")
                ->orWhereHas('subject', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
              
                ->orWhereHas('teacher', function($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                })

                ->orWhereHas('sections', function($q) use ($keyword) {
                    $q->whereHas('vnTeacher', function($q2) use ($keyword) {
                        $q2->where('name', 'LIKE', "%{$keyword}%");
                    })->orWhereHas('foreignTeacher', function($q2) use ($keyword) {
                        $q2->where('name', 'LIKE', "%{$keyword}%");
                    })->orWhereHas('tutor', function($q2) use ($keyword) {
                        $q2->where('name', 'LIKE', "%{$keyword}%");
                    })->orWhereHas('assistant', function($q2) use ($keyword) {
                        $q2->where('name', 'LIKE', "%{$keyword}%");
                    });
                })

                ->orWhereHas('orderItem', function ($q3) use ($keyword) {
                    $q3->whereHas('order', function ($q4) use ($keyword) {
                        $q4->where('code', 'LIKE', "%{$keyword}%");
                    });
                })

                ->orWhereHas('courseStudents', function ($q5) use ($keyword) {
                    $q5->whereHas('student', function ($q6) use ($keyword) {
                        $q6->where('name', 'LIKE', "%{$keyword}%");
                    });
                });
    }

    public static function scopeFilterByMaxStudents($query, $maxStudents)
    {
        return $query->where('max_students', '<=', $maxStudents)
            ->orderByRaw("ABS(max_students - {$maxStudents})");
            // ->limit(1);
    }

    public function generateCodeName()
    {
        if ($this->code) {
            throw new \Exception("Course code exists!");
        }

        // Tạo tên viết tắt từ trình độ
        $levelAbbr = ''; // Tên viết tắt của trình độ (nếu có)
        if (isset($this->level)) {
            $levelAbbr = $this->generateLevelAbbreviation($this->level);
        }

        // Tên môn học, mặc định là 'DUHOC' nếu không có
        $subjectName = 'DUHOC';
        if (isset($this->subject_id)) {
            $subject = Subject::find($this->subject_id);
            if ($subject) {
                $subjectName = $subject->name;
            }
        }

        // Chuẩn hóa tên môn học
        $subjectName = $this->normalizeName($subjectName);

        // Trình độ inside code
        $levelPrefix = ($levelAbbr ? $levelAbbr . '.' : '');

        // Lấy năm và tháng hiện tại
        $currentYear = $this->created_at->format('y'); // Lấy 2 chữ số cuối của năm
        $currentMonth = $this->created_at->format('m'); // Lấy 2 chữ số của tháng

        // Tìm mã cuối cùng tạo trong cùng tháng và năm với cùng subjectName
        $lastCode = self::where('code', 'like', $levelPrefix . "$subjectName.$currentYear$currentMonth.%")
                        ->where('module', $this->module)
                        ->orderBy('code', 'desc')
                        ->lockForUpdate() // Khoá hàng được chọn để tránh việc đọc ghi đồng thời
                        ->first();

        // Xác định số mã tiếp theo
        $number = 1; // Bắt đầu từ 1 nếu không có mã trước đó
        if ($lastCode) {
            $lastNumber = (int)substr($lastCode->code, strrpos($lastCode->code, '.') + 1); // Lấy số cuối từ mã cuối cùng
            $number = $lastNumber + 1;
        }

        // Tạo mã mới
        $code = $levelPrefix . $subjectName . ".$currentYear$currentMonth." . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Lưu mã vào cơ sở dữ liệu
        $this->code = $code;
        $this->save();
    }

    // Phương thức tạo tên viết tắt từ trình độ
    protected function generateLevelAbbreviation($level)
    {
        return Config::get('level_abbreviations.' . $level, '');
        // // Chia chuỗi thành các từ
        // $words = explode(' ', $level);
        // // Lấy chữ cái đầu tiên của từng từ và nối chúng lại
        // $abbreviation = '';
        // foreach ($words as $word) {
        //     $abbreviation .= strtoupper(substr($word, 0, 1));
        // }
        // return $abbreviation;
    }

    // Phương thức chuẩn hóa tên môn học
    protected function normalizeName($name)
    {
        $name = preg_replace('/[ÀÁẢÃẠÂẤẦẪẬĂẮẰẴẶ]/u', 'A', $name);
        $name = preg_replace('/[àáảãạâấầẫậăắằẵặ]/u', 'a', $name);
        $name = preg_replace('/[ÉÈẼẸÊẾỀỄỆ]/u', 'E', $name);
        $name = preg_replace('/[éèẹẻẽêếềệểễ]/u', 'e', $name);
        $name = preg_replace('/[ÍÌĨỊ]/u', 'I', $name);
        $name = preg_replace('/[íìịỉĩ]/u', 'i', $name);
        $name = preg_replace('/[ÓÒÕỌÔỐỒỖỘƠỚỜỠỢ]/u', 'O', $name);
        $name = preg_replace('/[óòõọôốồỗộơớờỡợ]/u', 'o', $name);
        $name = preg_replace('/[ÚÙŨỤƯỨỪỮỰ]/u', 'U', $name);
        $name = preg_replace('/[úùũụưứừữự]/u', 'u', $name);
        $name = preg_replace('/[ÝỲỸỴ]/u', 'Y', $name);
        $name = preg_replace('/[ýỳỵỷỹ]/u', 'y', $name);
        $name = preg_replace('/Đ/u', 'D', $name);
        $name = preg_replace('/đ/u', 'd', $name);
        $name = preg_replace('/[\x{0300}\x{0301}\x{0303}\x{0309}\x{0323}]/u', '', $name);
        $name = preg_replace('/[\x{02C6}\x{0306}\x{031B}]/u', '', $name);
        $name = strtoupper($name);
        $name = preg_replace('/[^a-zA-Z0-9]/', '', $name); // Loại bỏ ký tự không phải chữ và số

        return $name;
    }
    
    // public function generateCodeName()
    // {
    //     $name;

    //     if (isset($this->subject_id)) {
    //         $name = Subject::find($this->subject_id)->name;
    //     } else {
    //         $name = 'DUHOC';
    //     }

    //     $year = Carbon::now()->year;

    //     $name = preg_replace('/[ÀÁẢÃẠÂẤẦẪẬĂẮẰẴẶ]/u', 'A', $name);
    //     $name = preg_replace('/[àáảãạâấầẫậăắằẵặ]/u', 'a', $name);
    //     $name = preg_replace('/[ÉÈẼẸÊẾỀỄỆ]/u', 'E', $name);
    //     $name = preg_replace('/[éèẹẻẽêếềệểễ]/u', 'e', $name);
    //     $name = preg_replace('/[ÍÌĨỊ]/u', 'I', $name);
    //     $name = preg_replace('/[íìịỉĩ]/u', 'i', $name);
    //     $name = preg_replace('/[ÓÒÕỌÔỐỒỖỘƠỚỜỠỢ]/u', 'O', $name);
    //     $name = preg_replace('/[óòõọôốồỗộơớờỡợ]/u', 'o', $name);
    //     $name = preg_replace('/[ÚÙŨỤƯỨỪỮỰ]/u', 'U', $name);
    //     $name = preg_replace('/[úùũụưứừữự]/u', 'u', $name);
    //     $name = preg_replace('/[ÝỲỸỴ]/u', 'Y', $name);
    //     $name = preg_replace('/[ýỳỵỷỹ]/u', 'y', $name);
    //     $name = preg_replace('/Đ/u', 'D', $name);
    //     $name = preg_replace('/đ/u', 'd', $name);
    //     $name = preg_replace('/[\x{0300}\x{0301}\x{0303}\x{0309}\x{0323}]/u', '', $name);
    //     $name = preg_replace('/[\x{02C6}\x{0306}\x{031B}]/u', '', $name);
    //     $name = strtoupper($name);
    //     $pattern = '/[^a-zA-Z0-9\s]/';
    //     $name = preg_replace($pattern, '', $name);

    //     $number = self::where('code_year', $year)
    //                   ->where('module', $this->module)
    //                   ->max('code_number') + 1;

    //     // $code = preg_replace('/\s+/', '', $name) . $year . "." . str_pad((string)$this->id, 4, '0', STR_PAD_LEFT);
    //     $code = preg_replace('/\s+/', '', $name) . $year . "." . str_pad((string) $number, 4, '0', STR_PAD_LEFT);

    //     $this->code = $code;
    //     $this->code_year = $year;
    //     $this->code_number = $number;
    //     $this->save();
    // }

    public static function scopeFilterByTeachers($query, $teachers)
    {
        $query = $query->whereHas('teacher', function ($query) use ($teachers) {
            $query->whereIn('id', $teachers);
        });
    }
    
    public static function scopeFilterBySubjects($query, $subjects)
    {
        $query = $query->whereHas('subject', function ($query) use ($subjects) {
            $query->whereIn('id', $subjects);
        });
    }

    public static function scopeFilterByClassRoom($query, $classRoom)
    {
        return $query->whereIn('code', (array) $classRoom);
    }

    public static function scopeFilterByBranchs($query, $branchs)
    {
        $query->whereHas('TrainingLocation', function($q) use ($branchs) {
            $q->whereIn('branch', $branchs);
        });
    }

    public static function scopeFilterByLocations($query, $locations)
    {
        $query->whereHas('TrainingLocation', function($q) use ($locations) {
            $q->whereIn('id', $locations);
        });
    }

    public static function scopeFilterByTeacherTypes($query, $teacherTypes)
    {
        $query = $query->whereHas('teacher', function ($query) use ($teacherTypes) {
            $query->whereIn('type', $teacherTypes);
        });
    }

    public static function scopeFilterByStartAt($query, $start_at_from, $start_at_to)
    {
        if (!empty($start_at_from) && !empty($start_at_to)) {
            return $query->whereBetween('start_at', [$start_at_from, \Carbon\Carbon::parse($start_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByExtraItem($query, $subjects)
    {
        $query = $query->whereHas('extracurricular', function($q) use ($subjects) {
            $q->whereIn('id', $subjects);
        });
    }

    public static function scopeFilterByAbroadServices($query, $services)
    {
        $query = $query->whereHas('abroadService', function($q) use ($services) {
            $q->whereIn('id', $services);
        });
    }

    public static function scopeFilterByEndAt($query, $end_at_from, $end_at_to)
    {
        if (!empty($end_at_from) && !empty($end_at_to)) {
            return $query->whereBetween('end_at', [$end_at_from, \Carbon\Carbon::parse($end_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeDeleteCourses($query, $items)
    {
        self::whereIn('id', $items)->delete();
    }

    public static function scopeIsOpening($query)
    {
        $query = $query->where('courses.status', self::OPENING_STATUS);
    }

    public static function scopeIsCompleted($query)
    {
        $query = $query->where('courses.status', self::COMPLETED_STATUS);
    }

    public static function scopeIsWaiting($query)
    {
        $query = $query->where('courses.status', self::WAITING_OPEN_STATUS);
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('courses.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('courses.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public function updateSections($sections)
    {
        $this->sections()->delete();

        $newSections = [];

        foreach ($sections as $section) {
            $newSection = (array) $section;
            $newSection['course_id'] = $this->id;
            $newSections[] = $newSection;
        }

        $this->sections()->createMany($newSections);
    }

    /**
     * Update sections of course
     * 
     * Rules:
     * - Keep the sections before the schedule change.
     * - Delete the sections after the schedule change.
     * - Add the new sections after the schedule change.
     * 
     * When this course created:
     *      If study type is online, the course only save the zoom_user_id.
     *      New meeting will be create in this scope and apply data to all sections.
     * 
     * @param sections array of section datas generate in create/edit course screen 
     * @return void
     */
    public function updateSectionsWhenChangeCalendar($sections)
    {
        // Retrieve the list of section_ids for the new sections.
        $newSectionIds = collect($sections)
                       ->pluck('section_id')
                       ->filter()
                       ->toArray();

        // Retrieve the list of sections to delete (with id but not in the list of new sections).
        $sectionsToDelete = $this->sections()
                                 ->whereNotIn('id', $newSectionIds)
                                 ->get();

        // Retrieve the list of new sections to save (sections without section_id).
        $sectionsToSave = collect($sections)
                        ->whereNull('section_id')
                        ->map(function ($section) {
                            return (array) $section;
                        })
                        ->each(function (&$section) {
                            $section['course_id'] = $this->id;
                            $section['order_number'] = $section['order_number'];
                        })
                        ->toArray();

        $meetingIds = [];

        // Delete meeting current existing in each sectio before delete section
        foreach($this->sections()->whereIn('id', $sectionsToDelete->pluck('id'))->get() as $section) {
            $meetingId = $section->getMeetingId();

            if ($meetingId) { // Exist zoom meeting link
                // Delete that meeting throughout meeting id
                $meetingIds[] = $meetingId;
            }
        }

        // Remove duplicate meeting IDs
        $uniqueMeetingIds = array_unique($meetingIds);

        // Perform the deletion of unique meeting IDs
        if (!empty($uniqueMeetingIds)) {
            foreach($uniqueMeetingIds as $id) {
                ZoomMeeting::deleteMeeting($id);
            }
        }

        // Delete the sections to be deleted.
        $this->sections()->whereIn('id', $sectionsToDelete->pluck('id'))->delete();

        // Save new sections
        $this->sections()->createMany($sectionsToSave);

        foreach ($this->sections as $section) {
            $section->status = Section::STATUS_ACTIVE;
        }
    }

    public function updateZoomDataForAllSectionsByZoomAccount()
    {
        // If study method is ONLINE => handle
        if ($this->study_method === self::STUDY_METHOD_ONLINE) {
            // Handle old meetings
            $oldStartLinks = [];
            $sections = $this->sections;

            foreach($sections as $key => $section) {
                $startLink = $section->zoom_start_link;

                if ($startLink && $startLink != '') {
                    $oldStartLinks[] = $startLink;
                }
            }

            $oldUniqStartLinks = array_unique($oldStartLinks);

            // Delete all old meetings
            foreach($oldUniqStartLinks as $starLink) {
                // Get meeting by id
                $meetingId = ZoomMeeting::getMeetingIdFromStartLink($startLink);
                // Delete by meeting id
                ZoomMeeting::deleteMeeting($meetingId);
            }

            // Regenerate meetings with new zoom user id and apply meeting information to all sections
            $meeting = ZoomMeeting::createMeetingForUser(ZoomMeeting::getTestData(), $this->zoom_user_id);
            $joinLink = $meeting['data']['join_url'];

            // find param pwd index
            $pos = strpos($joinLink, '?pwd');
            
            // If pwd found, handle string
            if ($pos !== false) {
                $linkHandled = substr($joinLink, 0, $pos);
            } else {
                $linkHandled = $joinLink; // pwd not found => no password => return full url
            }

            foreach($this->sections as $section) {
                // Save zooms information from generate from user selected when create course into each section generating
                $section->status = Section::STATUS_ACTIVE;
                $section->zoom_start_link = $meeting['data']['start_url'];
                $section->zoom_join_link = $linkHandled;
                $section->zoom_password = $meeting['data']['password'];
                $section->save();
            }
        }
    }

    public function updateZoomDataForAllSectionsByExistingValue($startLink, $joinLink, $password)
    {
        // find param pwd index
        $pos = strpos($joinLink, '?pwd');
            
        // If pwd found, handle string
        if ($pos !== false) {
            $linkHandled = substr($joinLink, 0, $pos);
        } else {
            $linkHandled = $joinLink; // pwd not found => no password => return full url
        }

        foreach($this->sections as $section) {
            // Save zooms information from generate from user selected when create course into each section generating
            $section->status = Section::STATUS_ACTIVE;

            $section->zoom_start_link = $startLink;
            $section->zoom_join_link = $linkHandled;
            $section->zoom_password = $password;

            $section->save();
        }
    }

    public function trainingLocation()
    {
        return $this->belongsTo(TrainingLocation::class);
    }

    public function saveFromRequest($request)
    {   
        parse_str($request->form, $form);   

        $formToFill = $form;

        if (isset($form['type'])) {
            $formToFill = Arr::except($form, 'type');

            if ($form['type'] === "" || !$form['type']) {
                $form['type'] = Section::TYPE_GENERAL;
            }
        }

        if (isset($form['study_method'])) {
            if ($form['study_method'] === "") {
                $form['training_location_id'] = "";
            }
        }

        $this->fill($formToFill);

        // In case that the end date has not yet been determined
        if (isset($form['end_at'])) {
            if ($form['end_at'] === "" || !$form['end_at']) {
                $this->end_at = null;
            }
        } else {
            $this->end_at = null;
        }

        $this->week_schedules = json_encode($request->week_schedules);

        $sections = $this->sections()->get();
        $sections->status = self::STATUS_ACTIVE;

        if ($form['module'] === self::MODULE_EDU) {
            // Validate when this course is edu type
            $validator = Validator::make($form, [
                'type' => 'required',
                'subject_id' => 'required',
                'teacher_id' => 'required',
                'study_method' => 'required',
                'start_at' => 'required',
                'total_hours' => 'required',
            ]);

            $validator->after(function ($validator) use ($form, $request) {
                // Start time must be greater than or equal 1/6/2024
                // The validation for whether start date has been provided is already done elsewhere
                if ($form['start_at'] != '') {
                    $startDate = Carbon::parse($form['start_at']);
                    $compareDate = Carbon::parse(self::DATE_COMPARE);

                    if ($startDate->lessThan($compareDate)) {
                        $validator->errors()->add('start_at', "Thời gian bắt đầu phải từ thời điểm ngày 01-06-2024 trở đi!");
                    }
                }

                // Validate test hours
                // Get all events form calendar
                $events = collect(json_decode($request->events));
                $studyEvents = $events->where('type', Section::TYPE_GENERAL);
                $testEvents = $events->where('type', Section::TYPE_TEST);

                // caculate total minutes from calendar events
                $totalStudyMinutes = $studyEvents->reduce(function ($carry, $event) {
                    $startAt = Carbon::parse($event->start_at);
                    $endAt = Carbon::parse($event->end_at);
                    return $carry + $startAt->diffInMinutes($endAt);
                }, 0);

                // Caculate test minutes
                $totalTestMinutes = $testEvents->reduce(function ($carry, $event) {
                    $startAt = Carbon::parse($event->start_at);
                    $endAt = Carbon::parse($event->end_at);
                    return $carry + $startAt->diffInMinutes($endAt);
                }, 0);

                $totalHours = floatval($form['total_hours']);
                $totalStudyHours = $totalStudyMinutes / 60;
                $totalTestHours = $totalTestMinutes / 60;

                // Round hours to two decimal places
                $totalStudyHoursRounded = round($totalStudyHours, 2);
                $totalHoursRounded = round($totalHours, 2);

                if ($totalStudyHoursRounded > $totalHoursRounded || $totalStudyHoursRounded < $totalHoursRounded) {
                    $validator->errors()->add('total_hours', "Tổng giờ học tính được là " . number_format($totalStudyHoursRounded, 2) . " giờ, chưa khớp với cấu hình giờ học dự kiến: " . number_format($totalHoursRounded, 2) . "!");
                }

                if ($form['test_hours']) {
                    // User had filled the test hours input
                    $testHours = floatval($form['test_hours']);

                    // Compare the test hours input value with total test minutes from calendar
                    if ($totalTestHours != $testHours) {
                        $validator->errors()->add('test_hours', "Tổng giờ kiểm tra tính được là " . number_format($totalTestHours, 2) . " giờ, chưa khớp với cấu hình!");
                    }
                } else {
                    // User not fill in the test hours input yet
                    // Check are there any test minutes in calendar?
                    if ($totalTestMinutes > 0) {
                        $validator->errors()->add('test_hours', "Chưa cấu hình giờ kiểm tra nhưng trong lịch lại có buổi kiểm tra!");
                    }
                }

                if ($form['study_method'] === self::STUDY_METHOD_ONLINE) {
                    if (isset($form['zoom_switch']) && $form['zoom_switch'] == "on") {
                        if ($form['zoom_user_id'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa chọn tài khoản Zoom!");
                        } else {
                            // We only check sections which is creating new, not check the section had created before (Course editing case).
                            // => Get all events which is not have id field, that are all new event need to check time overlap
                            $eventsInput = json_decode($request->events, true); // Array
                            $eventsWithoutId = array_filter($eventsInput, function($event) {
                                return !isset($event['id']);
                            });

                            if ($eventsWithoutId) {
                                $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections($eventsWithoutId, $this->id ?? null);
    
                                if (!in_array($form['zoom_user_id'], $availableZoomUserIds)) {
                                    $validator->errors()->add('study_method_error_custom', "Tài khoản Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng chọn tài khoản khác!");
                                }
                            }
                        }
                    } else {
                        if ($form['zoom_start_link'] === "" || $form['zoom_join_link'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa nhập đủ thông tin về phòng học Zoom!");
                        } else {
                            $conflictZoomUserIds = ZoomMeeting::getConflictZoomMeetingLinksWithSections(json_decode($request->events, true), $this->id ?? null);

                            if (in_array($form['zoom_start_link'], $conflictZoomUserIds)) {
                                $validator->errors()->add('study_method_error_custom', "Link Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng nhập link Zoom khác!");
                            }
                        }
                    }
                }

                // Validate training location id
                if (isset($form['training_location_id'])) {
                    if ($form['training_location_id'] === "") {
                        $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");
                    }
                } else {
                    $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");
                }

                // Validate class type (1:1 or group) and number of student (Min/Max)
                if (
                    $form['class_type'] === ""
                    || intval($form['min_students']) === 0
                    || intval($form['max_students']) === 0
                ) {
                    $validator->errors()->add('validate_fill_students', "Số lượng và loại hình lớp không được để trống!");
                }

                // validate MIN students
                if (intval($form['min_students']) < 0) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu < 0 là không hợp lệ!");
                }

                // validate MIN students
                if (intval($form['min_students']) > 1000) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu > 1000 là không hợp lệ!");
                }

                // validate MAX students
                if ($form['class_type'] === self::CLASS_TYPE_ONE_ONE
                    && (intval($form['min_students']) !== 1 || intval($form['max_students']) !== 1)) {
                    $validator->errors()->add('range_number_of_students', "Lớp học 1:1 thì không được chọn học sinh tối thiểu hoặc tối đa lớn hơn 1!");
                }

                // validate MAX students
                if (intval($form['max_students']) < 0) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu < 0 là không hợp lệ!");
                }

                // validate MAX students
                if (intval($form['max_students']) > 1000) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu > 1000 là không hợp lệ!");
                }
            });

            $weekSchedules = $request->all()['week_schedules'];

            $validator->after(function ($validator) use ($weekSchedules) {
                if (count($weekSchedules) > 0) {
                    foreach ($weekSchedules as $item) {
                        $schedules = $item['schedules'][0];

                        if (isset($schedules['vn_teacher_id'])) {
                            if (!is_null($schedules['vn_teacher_id'])) {
                                $teacher = Teacher::find($schedules['vn_teacher_id']);

                                if ($teacher->isBusy($item['name'], $schedules['vn_teacher_from'], $schedules['vn_teacher_to'])) {
                                    $validator->errors()->add('staff_busy_schedule', "Giáo viên Việt Nam {$teacher->name} bị vướng lịch rảnh!");
                                }
                            }
                        }

                        if (isset($schedules['foreign_teacher_id'])) {
                            if (!is_null($schedules['foreign_teacher_id'])) {
                                $teacher = Teacher::find($schedules['foreign_teacher_id']);

                                if ($teacher->isBusy($item['name'], $schedules['foreign_teacher_from'], $schedules['foreign_teacher_to'])) {
                                    $validator->errors()->add('staff_busy_schedule', "Giáo viên nước ngoài {$teacher->name} bị vướng lịch rảnh!");
                                }
                            }
                        }

                        if (isset($schedules['tutor_id'])) {
                            if (!is_null($schedules['tutor_id'])) {
                                $teacher = Teacher::find($schedules['tutor_id']);

                                if ($teacher->isBusy($item['name'], $schedules['tutor_from'], $schedules['tutor_to'])) {
                                    $validator->errors()->add('staff_busy_schedule', "Gia sư {$teacher->name} bị vướng lịch rảnh!");
                                }
                            }
                        }
                    }
                }
            });

            // In case user fill test hours input with empty value
            if ($form['test_hours'] == '') {
                $this->test_hours = 0;
            }
        } elseif ($form['module'] === self::MODULE_ABROAD) {
            // Validate when this course is abroad
            $validator = Validator::make($form, [
                'abroad_service_id' => 'required',
                'order_item_id' => 'required',
                'study_method' => 'required',
            ]);

            $validator->after(function ($validator) use ($form, $request) { 
                if ($form['study_method'] === self::STUDY_METHOD_ONLINE) {
                    if (isset($form['zoom_switch']) && $form['zoom_switch'] == "on") {
                        if ($form['zoom_user_id'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa chọn tài khoản Zoom!");
                        } else {
                            if ($request->events && count(json_decode($request->events, true))) {
                                // We only check sections which is creating new, not check the section had created before (Course editing case).
                                // => Get all events which is not have id field, that are all new event need to check time overlap
                                $eventsInput = json_decode($request->events, true); // Array
                                $eventsWithoutId = array_filter($eventsInput, function($event) {
                                    return !isset($event['id']);
                                });
                                
                                if ($eventsWithoutId) {
                                    $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections($eventsWithoutId, $this->id ?? null);
        
                                    // Have add a condition validate here about: is the conflict zoom link section a section of this course?
                                    if (!in_array($form['zoom_user_id'], $availableZoomUserIds)) {
                                        $validator->errors()->add('study_method_error_custom', "Tài khoản Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng chọn tài khoản khác!");
                                    }
                                }
                            }
                        }
                    } else {
                        if ($form['zoom_start_link'] === "" || $form['zoom_join_link'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa nhập đủ thông tin về phòng học Zoom!");
                        } else {
                            $conflictZoomUserIds = ZoomMeeting::getConflictZoomMeetingLinksWithSections(json_decode($request->events, true), $this->id ?? null);

                            if (in_array($form['zoom_start_link'], $conflictZoomUserIds)) {
                                $validator->errors()->add('study_method_error_custom', "Link Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng nhập link Zoom khác!");
                            }
                        }
                    }
                } elseif ($form['study_method'] === self::STUDY_METHOD_OFFLINE) {
                    if (isset($form['training_location_id'])) {
                        if ($form['training_location_id'] === "") {
                            $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");
                        }
                    } else {
                        $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");   
                    }
                }

                if (!json_decode($request->events)) {
                    $validator->errors()->add('sections_null_error_custom', "Chưa có buổi học nào cho lớp du học, vui lòng tạo 1 buổi học!");
                }
            });

            $this->subject_id = null;
            $this->level = null;
            $this->status = null;
            $this->start_at = null;
            $this->end_at = null;
            $this->teacher_id = null;
            $this->vn_teacher_duration = null;
            $this->foreign_teacher_duration = null;
            $this->tutor_duration = null;
            $this->assistant_duration = null;
            $this->duration_each_lesson = null;
            $this->max_students = null;
            $this->min_students = null;
            $this->class_type = null;
            $this->module = self::MODULE_ABROAD;
            $this->test_hours = null;
            $this->import_id = null;
        } else {
            throw new \Exception("Not valid course module!");
        }

        if ($validator->fails()) {
            return $validator->errors();
        };

        $this->save(); // save course informations
        // Update sections of this course
        $this->updateSectionsWhenChangeCalendar(json_decode($request->events));

        // Check if any section overlap with a section with a section from another course
        $validator->after(function ($validator) use ($form) {
            $conflictSections = $this->findStaffConflictSections();

            if ($conflictSections->count() > 0) {
                $sectionConflictsString = "";

                for ($i = 0; $i < $conflictSections->count(); ++$i) {
                    $sectionConflictsString = $sectionConflictsString . Carbon::parse($conflictSections->get($i)->study_date)->format('d-m-Y') . ($i < ($conflictSections->count() - 1) ? " , " : "");
                }

                $validator->errors()->add('teacher_conflict_teach_time_custom', "Giảng viên cấu hình trong lịch học bị trùng giờ dạy với lớp học " . ($conflictSections->first()->course->code ? $conflictSections->first()->course->code : "##") . " - Các buổi học bị trùng: [" . $sectionConflictsString . "]");
                $this->delete();
            }
        });

        // Kiểm tra lịch rảnh của giảng viên có phù hợp với các buổi học không
        // $validator->after(function ($validator) use ($form) {
        //     $checkFreeTimeValid = $this->checkFreeTimeValid();

        //     // if (!$checkFreeTimeValid) {
        //     //     $validator->errors()->add('teacher_conflict_teach_time_custom', "Giảng viên cấu hình trong lịch học bị trùng giờ dạy với lớp học " . $conflictSections->first()->course->code);
        //     //     $this->delete();
        //     // }
        // });

        if ($validator->fails()) {
            return $validator->errors();
        };

        // Create zoom meeting and apply zoom information to all sections
        if ($this->study_method === self::STUDY_METHOD_ONLINE) {
            if (isset($form['zoom_switch']) && $form['zoom_switch'] == "on") {
                $this->updateZoomDataForAllSectionsByZoomAccount();
            } else {
                $this->updateZoomDataForAllSectionsByExistingValue($form['zoom_start_link'], $form['zoom_join_link'], $form['zoom_password']);
            }
        }
    
        if ($form['module'] === self::MODULE_ABROAD) {
            $orderItem = $this->orderItem;

            if ($orderItem) {
                $this->assignItem($orderItem);
            } else {
                throw new \Exception("Custom Error: Order Item not found!");
            }
        }

        return $validator->errors();
    }

    public function editFromRequest($request)
    {   
        parse_str($request->form, $form);   

        $formToFill = $form;

        if (isset($form['type'])) {
            $formToFill = Arr::except($form, 'type');

            if ($form['type'] === "" || !$form['type']) {
                $form['type'] = Section::TYPE_GENERAL;
            }
        }

        if (isset($form['study_method'])) {
            if ($form['study_method'] === "") {
                $form['training_location_id'] = "";
            }
        }

        $this->fill($formToFill);

        // In case that the end date has not yet been determined
        if (isset($form['end_at'])) {
            if ($form['end_at'] === "" || !$form['end_at']) {
                $this->end_at = null;
            }
        } else {
            $this->end_at = null;
        }

        $this->week_schedules = json_encode($request->week_schedules);

        $sections = $this->sections()->get();
        $sections->status = self::STATUS_ACTIVE;

        if ($form['module'] === self::MODULE_EDU) {
            // Validate when this course is edu type
            $validator = Validator::make($form, [
                'type' => 'required',
                'subject_id' => 'required',
                'teacher_id' => 'required',
                'study_method' => 'required',
                'start_at' => 'required',
                'total_hours' => 'required',
            ]);

            $validator->after(function ($validator) use ($form, $request) {
                // Start time must be greater than or equal 1/6/2024
                // The validation for whether start date has been provided is already done elsewhere
                if ($form['start_at'] != '') {
                    $startDate = Carbon::parse($form['start_at']);
                    $compareDate = Carbon::parse(self::DATE_COMPARE);

                    if ($startDate->lessThan($compareDate)) {
                        $validator->errors()->add('start_at', "Thời gian bắt đầu phải từ thời điểm ngày 01-06-2024 trở đi!");
                    }
                }

                // Validate test hours
                // Get all events form calendar
                $events = collect(json_decode($request->events));
                $studyEvents = $events->where('type', Section::TYPE_GENERAL);
                $testEvents = $events->where('type', Section::TYPE_TEST);

                // caculate total minutes from calendar events
                $totalStudyMinutes = $studyEvents->reduce(function ($carry, $event) {
                    $startAt = Carbon::parse($event->start_at);
                    $endAt = Carbon::parse($event->end_at);
                    return $carry + $startAt->diffInMinutes($endAt);
                }, 0);

                // Caculate test minutes
                $totalTestMinutes = $testEvents->reduce(function ($carry, $event) {
                    $startAt = Carbon::parse($event->start_at);
                    $endAt = Carbon::parse($event->end_at);
                    return $carry + $startAt->diffInMinutes($endAt);
                }, 0);

                $totalHours = floatval($form['total_hours']);
                $totalStudyHours = $totalStudyMinutes / 60;
                $totalTestHours = $totalTestMinutes / 60;

                // Round hours to two decimal places
                $totalStudyHoursRounded = round($totalStudyHours, 2);
                $totalHoursRounded = round($totalHours, 2);

                if ($totalStudyHoursRounded > $totalHoursRounded || $totalStudyHoursRounded < $totalHoursRounded) {
                    $validator->errors()->add('total_hours', "Tổng giờ học tính được là " . number_format($totalStudyHoursRounded, 2) . " giờ, chưa khớp với cấu hình giờ học dự kiến: " . number_format($totalHoursRounded, 2) . "!");
                }

                if ($form['test_hours']) {
                    // User had filled the test hours input
                    $testHours = floatval($form['test_hours']);

                    // Compare the test hours input value with total test minutes from calendar
                    if ($totalTestHours != $testHours) {
                        $validator->errors()->add('test_hours', "Tổng giờ kiểm tra tính được là " . number_format($totalTestHours, 2) . " giờ, chưa khớp với cấu hình!");
                    }
                } else {
                    // User not fill in the test hours input yet
                    // Check are there any test minutes in calendar?
                    if ($totalTestMinutes > 0) {
                        $validator->errors()->add('test_hours', "Chưa cấu hình giờ kiểm tra nhưng trong lịch lại có buổi kiểm tra!");
                    }
                }

                if ($form['study_method'] === self::STUDY_METHOD_ONLINE) {
                    if (isset($form['zoom_switch']) && $form['zoom_switch'] == "on") {
                        if ($form['zoom_user_id'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa chọn tài khoản Zoom!");
                        } else {
                            // We only check sections which is creating new, not check the section had created before (Course editing case).
                            // => Get all events which is not have id field, that are all new event need to check time overlap
                            $eventsInput = json_decode($request->events, true); // Array
                            $eventsWithoutId = array_filter($eventsInput, function($event) {
                                return !isset($event['id']);
                            });

                            if ($eventsWithoutId) {
                                $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections($eventsWithoutId, $this->id ?? null);
    
                                if (!in_array($form['zoom_user_id'], $availableZoomUserIds)) {
                                    $validator->errors()->add('study_method_error_custom', "Tài khoản Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng chọn tài khoản khác!");
                                }
                            }
                        }
                    } else {
                        if ($form['zoom_start_link'] === "" || $form['zoom_join_link'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa nhập đủ thông tin về phòng học Zoom!");
                        } else {
                            $conflictZoomUserIds = ZoomMeeting::getConflictZoomMeetingLinksWithSections(json_decode($request->events, true), $this->id ?? null);

                            if (in_array($form['zoom_start_link'], $conflictZoomUserIds)) {
                                $validator->errors()->add('study_method_error_custom', "Link Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng nhập link Zoom khác!");
                            }
                        }
                    }
                }

                // Validate training location id
                if (isset($form['training_location_id'])) {
                    if ($form['training_location_id'] === "") {
                        $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");
                    }
                } else {
                    $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");
                }

                // Validate class type (1:1 or group) and number of student (Min/Max)
                if (
                    $form['class_type'] === ""
                    || intval($form['min_students']) === 0
                    || intval($form['max_students']) === 0
                ) {
                    $validator->errors()->add('validate_fill_students', "Số lượng và loại hình lớp không được để trống!");
                }

                // validate MIN students
                if (intval($form['min_students']) < 0) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu < 0 là không hợp lệ!");
                }

                // validate MIN students
                if (intval($form['min_students']) > 1000) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu > 1000 là không hợp lệ!");
                }

                // validate MAX students
                if (
                    $form['class_type'] === self::CLASS_TYPE_ONE_ONE
                    && (intval($form['min_students']) !== 1 || intval($form['max_students']) !== 1)
                ) {
                    $validator->errors()->add('range_number_of_students', "Lớp học 1:1 thì không được chọn học sinh tối thiểu hoặc tối đa lớn hơn 1!");
                }

                // validate MAX students
                if (intval($form['max_students']) < 0) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu < 0 là không hợp lệ!");
                }

                // validate MAX students
                if (intval($form['max_students']) > 1000) {
                    $validator->errors()->add('range_number_of_students', "Số lượng học viên tối thiểu > 1000 là không hợp lệ!");
                }
            });

            $weekSchedules = $request->all()['week_schedules'];

            $validator->after(function ($validator) use ($weekSchedules) {
                if (count($weekSchedules) > 0) {
                    foreach ($weekSchedules as $item) {
                        $schedules = $item['schedules'][0];

                        if (isset($schedules['vn_teacher_id'])) {
                            if (!is_null($schedules['vn_teacher_id'])) {
                                $teacher = Teacher::find($schedules['vn_teacher_id']);

                                if ($teacher->isBusy($item['name'], $schedules['vn_teacher_from'], $schedules['vn_teacher_to'])) {
                                    $validator->errors()->add('staff_busy_schedule', "Giáo viên Việt Nam {$teacher->name} bị vướng lịch rảnh!");
                                }
                            }
                        }

                        if (isset($schedules['foreign_teacher_id'])) {
                            if (!is_null($schedules['foreign_teacher_id'])) {
                                $teacher = Teacher::find($schedules['foreign_teacher_id']);

                                if ($teacher->isBusy($item['name'], $schedules['foreign_teacher_from'], $schedules['foreign_teacher_to'])) {
                                    $validator->errors()->add('staff_busy_schedule', "Giáo viên nước ngoài {$teacher->name} bị vướng lịch rảnh!");
                                }
                            }
                        }

                        if (isset($schedules['tutor_id'])) {
                            if (!is_null($schedules['tutor_id'])) {
                                $teacher = Teacher::find($schedules['tutor_id']);

                                if ($teacher->isBusy($item['name'], $schedules['tutor_from'], $schedules['tutor_to'])) {
                                    $validator->errors()->add('staff_busy_schedule', "Gia sư {$teacher->name} bị vướng lịch rảnh!");
                                }
                            }
                        }
                    }
                }
            });

            // In case user fill test hours input with empty value
            if ($form['test_hours'] == '') {
                $this->test_hours = 0;
            }
        } elseif ($form['module'] === self::MODULE_ABROAD) {
            // Validate when this course is abroad
            $validator = Validator::make($form, [
                'abroad_service_id' => 'required',
                'order_item_id' => 'required',
                'study_method' => 'required',
            ]);

            $validator->after(function ($validator) use ($form, $request) { 
                if ($form['study_method'] === self::STUDY_METHOD_ONLINE) {
                    if (isset($form['zoom_switch']) && $form['zoom_switch'] == "on") {
                        if ($form['zoom_user_id'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa chọn tài khoản Zoom!");
                        } else {
                            if ($request->events && count(json_decode($request->events, true))) {
                                // We only check sections which is creating new, not check the section had created before (Course editing case).
                                // => Get all events which is not have id field, that are all new event need to check time overlap
                                $eventsInput = json_decode($request->events, true); // Array
                                $eventsWithoutId = array_filter($eventsInput, function($event) {
                                    return !isset($event['id']);
                                });
                                
                                if ($eventsWithoutId) {
                                    $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections($eventsWithoutId, $this->id ?? null);
        
                                    // Have add a condition validate here about: is the conflict zoom link section a section of this course?
                                    if (!in_array($form['zoom_user_id'], $availableZoomUserIds)) {
                                        $validator->errors()->add('study_method_error_custom', "Tài khoản Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng chọn tài khoản khác!");
                                    }
                                }
                            }
                        }
                    } else {
                        if ($form['zoom_start_link'] === "" || $form['zoom_join_link'] === "") {
                            $validator->errors()->add('study_method_error_custom', "Chưa nhập đủ thông tin về phòng học Zoom!");
                        } else {
                            $conflictZoomUserIds = ZoomMeeting::getConflictZoomMeetingLinksWithSections(json_decode($request->events, true), $this->id ?? null);

                            if (in_array($form['zoom_start_link'], $conflictZoomUserIds)) {
                                $validator->errors()->add('study_method_error_custom', "Link Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng nhập link Zoom khác!");
                            }
                        }
                    }
                } elseif ($form['study_method'] === self::STUDY_METHOD_OFFLINE) {
                    if (isset($form['training_location_id'])) {
                        if ($form['training_location_id'] === "") {
                            $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");
                        }
                    } else {
                        $validator->errors()->add('training_location_id', "Chưa chọn địa điểm đào tạo!");   
                    }
                }

                if (!json_decode($request->events)) {
                    $validator->errors()->add('sections_null_error_custom', "Chưa có buổi học nào cho lớp du học, vui lòng tạo 1 buổi học!");
                }
            });

            $this->subject_id = null;
            $this->level = null;
            $this->status = null;
            $this->start_at = null;
            $this->end_at = null;
            $this->teacher_id = null;
            $this->vn_teacher_duration = null;
            $this->foreign_teacher_duration = null;
            $this->tutor_duration = null;
            $this->assistant_duration = null;
            $this->duration_each_lesson = null;
            $this->max_students = null;
            $this->min_students = null;
            $this->class_type = null;
            $this->module = self::MODULE_ABROAD;
            $this->test_hours = null;
            $this->import_id = null;
        } else {
            throw new \Exception("Not valid course module!");
        }

        if ($validator->fails()) {
            return $validator->errors();
        };

        $this->save(); // save course informations
        // Update sections of this course
        $this->updateSectionsWhenChangeCalendar(json_decode($request->events));

        // Check if any section overlap with a section with a section from another course
        $validator->after(function ($validator) use ($form) {
            $conflictSections = $this->findStaffConflictSections();

            if ($conflictSections->count() > 0) {
                $sectionConflictsString = "";

                for ($i = 0; $i < $conflictSections->count(); ++$i) {
                    $sectionConflictsString = $sectionConflictsString . Carbon::parse($conflictSections->get($i)->study_date)->format('d-m-Y') . ($i < ($conflictSections->count() - 1) ? " , " : "");
                }

                $validator->errors()->add('teacher_conflict_teach_time_custom', "Giảng viên cấu hình trong lịch học bị trùng giờ dạy với lớp học " . ($conflictSections->first()->course->code ? $conflictSections->first()->course->code : "##") . " - Các buổi học bị trùng: [" . $sectionConflictsString . "]");
            }
        });

        // Kiểm tra lịch rảnh của giảng viên có phù hợp với các buổi học không
        // $validator->after(function ($validator) use ($form) {
        //     $checkFreeTimeValid = $this->checkFreeTimeValid();

        //     // if (!$checkFreeTimeValid) {
        //     //     $validator->errors()->add('teacher_conflict_teach_time_custom', "Giảng viên cấu hình trong lịch học bị trùng giờ dạy với lớp học " . $conflictSections->first()->course->code);
        //     //     $this->delete();
        //     // }
        // });

        if ($validator->fails()) {
            return $validator->errors();
        };

        // Create zoom meeting and apply zoom information to all sections
        if ($this->study_method === self::STUDY_METHOD_ONLINE) {
            if (isset($form['zoom_switch']) && $form['zoom_switch'] == "on") {
                $this->updateZoomDataForAllSectionsByZoomAccount();
            } else {
                $this->updateZoomDataForAllSectionsByExistingValue($form['zoom_start_link'], $form['zoom_join_link'], $form['zoom_password']);
            }
        }
    
        if ($form['module'] === self::MODULE_ABROAD) {
            $orderItem = $this->orderItem;

            if ($orderItem) {
                $this->assignItem($orderItem);
            } else {
                throw new \Exception("Custom Error: Order Item not found!");
            }
        }

        return $validator->errors();
    }

    public function updateStudentDataExistingInCourseForAllSections()
    {
        DB::beginTransaction();

        $studentsAssignedToThisCourse = Contact::whereIn('id', CourseStudent::where('course_id', $this->id)
            ->get()
            ->pluck('student_id')
            ->toArray())
            ->get()
            ->toArray();

        $notOverSections = $this->sections()->isNotOver()->get();

        try {
            foreach ($studentsAssignedToThisCourse as $student) {
                foreach ($notOverSections as $section) {
                    StudentSection::create([
                        'section_id' => $section->id,
                        'student_id' => $student['id'],
                        'status' => StudentSection::STATUS_NEW,
                    ]);
                }
            }
        } catch(\Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        DB::commit();
        UpdateSchedule::dispatch($this, \Auth::user());
    }

    public function checkFreeTimeValid()
    {
        foreach($this->sections as $key => $section) {
            if ($section->vnTeacher) {
                // lấy toàn bộ sections lớp đó của giảng viên VN
                $timesheets = $section->vnTeacher->getAllSectionsByCourse($this)->get()->map(function($s) {
                    return [
                        'start_at' => $s->start_at,
                        'end_at' => $s->end_at,
                    ];
                })->toArray();

                // $freeTimes = $section->vnTeacher->
            }
        }
    }

    /**
     * Find any meeting of this Zoom user conflicting with the schedule
     */
    public function findZoomMeetingsConflicting()
    {
        $sections = $this->sections;
    }

    public function getConflictSections(Section $section, string $staffType, $findOverlapMethod)
    {
        if ($section->$staffType) {
            $sectionsQuery = $section->$staffType->getAllSections()->whereNot('course_id', $this->id);

            return $sectionsQuery->$findOverlapMethod($section)->get();
        }

        return collect([]);
    }

    public function findStaffConflictSections()
    {
        foreach($this->sections as $key => $section) {
            $conflictSections = $this->getConflictSections($section, 'vnTeacher', 'overlapVnTimes');
            if ($conflictSections->count() > 0) return $conflictSections;

            $conflictSections = $this->getConflictSections($section, 'foreignTeacher', 'overlapForeignTimes');
            if ($conflictSections->count() > 0) return $conflictSections;

            $conflictSections = $this->getConflictSections($section, 'tutor', 'overlapTutorTimes');
            if ($conflictSections->count() > 0) return $conflictSections;

            $conflictSections = $this->getConflictSections($section, 'assistant', 'overlapAssistantTimes');
            if ($conflictSections->count() > 0) return $conflictSections;
        }

        return collect([]);
    }

    public function assignItem(OrderItem $orderItem)
    {
        DB::beginTransaction();

        try {
            $coursStudent = CourseStudent::create([
                'order_item_id' => $orderItem->id,
                'student_id' => $orderItem->order->contacts->id,
                'course_id' => $this->id,
            ]);

            $sections = $this->sections()->isNotOver()->get();
            $sumMinutesForeignTeacher = 0;
            $sumMinutesTutor = 0;
            $sumMinutesVNTeacher = 0;

            foreach ($sections as $section) {
                $foreignTeacherStartAt = Carbon::parse($section->foreign_teacher_from);
                $foreignTeacherEndAt = Carbon::parse($section->foreign_teacher_to);
                $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
                $sumMinutesForeignTeacher += $minutesForeignTeacher;

                $tutorStartAt = Carbon::parse($section->tutor_from);
                $tutorEndAt = Carbon::parse($section->tutor_to);
                $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
                $sumMinutesTutor += $minutesTutor;

                $VNTeacherStartAt = Carbon::parse($section->vn_teacher_from);
                $VnTeacherEndAt = Carbon::parse($section->vn_teacher_to);
                $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
                $sumMinutesVNTeacher += $minutesVNTeacher;

                StudentSection::create([
                    'section_id' => $section->id,
                    'student_id' => $orderItem->order->contacts->id,
                    'status' => StudentSection::STATUS_NEW,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            
            throw $e;
        }

        // commit
        DB::commit();
    }

    /**
     * Get array of teachers throught sections
     * 
     * @return array
     */
    public function getTeachersFromSections(): array
    {
        $vnTeachers = $this->sections
                            ->where('vn_teacher_id', '!=', '')
                            ->pluck('vn_teacher_id')
                            ->toArray();

        $foreignTeachers = $this->sections
                            ->where('foreign_teacher_id', '!=', '')
                            ->pluck('foreign_teacher_id')
                            ->toArray();

        return array_merge($vnTeachers, $foreignTeachers);
    }

    /**
     * Retrieve the latest section of course
     */
    public function retrieveLatestSection()
    {
        $latestSection = $this->sections()->orderBy('study_date', 'desc')->first();

        if ($latestSection) {
            return $latestSection;
        }
    
        return null;
    }

    /**
     * Check the course has finished?
     * 
     * @return Boolean
     */
    public function hasFinished()
    {
        $now = Carbon::now();
        $endAt = Carbon::parse($this->end_at);

        return $now->gt($endAt);
    }

    /**
     * Check if the course has started learning.
     * 
     * @return Boolean
     */
    public function hasStartedLearning()
    {
        $now = Carbon::now();
        $startAt = Carbon::parse($this->start_at);

        return $now->gte($startAt);
    }

    /**
     * Check if the course has been assigned.
     * 
     * @return Boolean
     */
    public function hasBeenAssigned()
    {
        $sectionIds = $this->sections()->get()->pluck('id')->toArray();
        $hasBeenAssigned = StudentSection::whereIn('section_id', $sectionIds)->exists();

        return $hasBeenAssigned;
    }

    private static function isSimilarDate($date1, $date2)
    {
        $dateTime1 = Carbon::parse($date1);
        $dateTime2 = Carbon::parse($date2);
        $formattedDate1 = $dateTime1->toDateString();
        $formattedDate2 = $dateTime2->toDateString();

        return $formattedDate1 === $formattedDate2;
    }

    public static function validateToApplyCalendar($request)
    {
        parse_str($request->form, $form);

        $now = Carbon::now()->toDateTimeString();
        $startDate = (new Carbon($form['start_at']))->toDateTimeString();

        if ($now > $startDate) {
            throw new \Exception('Thời gian không hợp lệ, ngày bắt đầu phải lớn hơn hoặc trùng với thời gian hiện tại!');
        }
    }

    private static function validateToUpdate($formData, $course)
    {
        $validator = Validator::make($formData, [
            'type' => 'required',
            'subject_id' => 'required',
            // 'level' => 'required',
            'teacher_id' => 'required',
            'study_method' => 'required',
            'start_at' => 'required',
            'total_hours' => 'required',
            'min_students' => ['numeric', 'min:1'],
            'max_students' => ['numeric', 'min:1'],
        ]);

        $validator->after(function ($validator) use ($course, $formData) {
            if ($course->hasFinished()) {
                // The course has finished

                $validator->errors()->add('time_range_validate', 'Lớp học này đã hoàn thành, không thể chỉnh sửa!');
            } elseif (!$course->hasStartedLearning()) {
                // The course hasn't started learning yet
                if ($course->hasBeenAssigned()) {
                    // The course has been assigned to student 
                    if (!self::isSimilarDate($course->start_at, $formData['start_at'])) {
                        $validator->errors()->add('start_at', 'Lớp học này đã được xếp cho học viên, không thể sửa thời gian bắt đầu học!');
                    }
                }
            } else {
                // The course has started learning

                // Not allowed to edit the start date
                if (!self::isSimilarDate($course->start_at, $formData['start_at'])) {
                    $validator->errors()->add('start_at', 'Lớp học này đã bắt đầu học, không thể sửa lại thời gian bắt đầu học!');
                }

                // Not allowed to edit the total hours
                if (floatval($course->total_hours) != floatval($formData['total_hours'])) {
                    $validator->errors()->add('total_hours', 'Lớp học này đã bắt đầu học, không thể sửa lại tổng số giờ cần học!');
                }
            }

            // In all cases, editing the following information is not allowed:

            // Not allowed to change the subject
            if (intval($course->subject_id) != intval($formData['subject_id'])) {
                $validator->errors()->add('subject_id', 'Lớp học này đã được tạo, không thể sửa môn học!');
            }

            // Not allowed to edit the minimum number of students
            if ($course->min_students != $formData['min_students']) {
                $validator->errors()->add('min_students', 'Lớp học này đã được tạo, không thể sửa số học viên tối thiểu, số học viên tối thiểu đã lưu là ' . $course->min_students);
            }

            // Not allowed to edit the maximum number of students
            if ($course->max_students != $formData['max_students']) {
                $validator->errors()->add('max_students', 'Lớp học này đã được tạo, không thể sửa số học viên tối đa, số học viên tối đa đã lưu là ' . $course->max_students);
            }

            // Not allowed to change the level
            if ($course->level != $formData['level']) {
                $validator->errors()->add('level', 'Lớp học này đã được tạo, không thể sửa trình độ!');
            }
        });

        return $validator;
    }

    public function updateFromRequest($request)
    {
        parse_str($request->form, $form);

        $validator = self::validateToUpdate($form, $this);

        if ($validator->fails()) {
            $this->fill($form);
            return $validator->errors();
        };

        $formWithoutType = Arr::except($form, 'type');

        if ($form['type'] === "" || !$form['type']) {
            $form['type'] = Section::TYPE_GENERAL;
        }

        $this->fill($formWithoutType);

        // In case that the end date has not yet been determined
        if ($form['end_at'] === "" || !$form['end_at']) {
            $this->end_at = null;
        }

        if ($form['type'] === "" || !$form['type']) {
            $this->type = Section::TYPE_GENERAL;
        }

        $this->week_schedules = json_encode($request->week_schedules);

        $sections = $this->sections()->get();
        $sections->status = self::STATUS_ACTIVE;

        if ($validator->fails()) {
            return $validator->errors();
        };

        $this->save();
        $this->updateSections(json_decode($request->events));

        return $validator->errors();
    }

    public function saveEventsFromRequest($request)
    {
        $oldZoomUserId = null;

        if ($this->study_method === self::STUDY_METHOD_ONLINE) {
            $oldZoomUserId = $this->zoom_user_id;
        }

        parse_str($request->form, $form);

        $this->end_at = $form['end_at'];
        $this->total_hours = $form['total_hours'];
        $this->start_at = $form['start_at'];
        $this->zoom_user_id = isset($form['zoom_user_id']) ? $form['zoom_user_id'] : null;
        $this->week_schedules = json_encode($request->week_schedules);

        // In case that the end date has not yet been determined
        if ($form['end_at'] === "" || !$form['end_at']) {
            $this->end_at = null;
        }

        $validator = Validator::make($form, [
            'start_at' => 'required',
            'total_hours' => 'required',
        ]);

        $validator->after(function ($validator) use ($request, $form) {
            // Start time must be greater than or equal 1/6/2024
            // The validation for whether start date has been provided is already done elsewhere
            if ($form['start_at'] != '') {
                $startDate = Carbon::parse($form['start_at']);
                $compareDate = Carbon::parse(self::DATE_COMPARE);

                if ($startDate->lessThan($compareDate)) {
                    $validator->errors()->add('start_at', "Thời gian bắt đầu phải từ thời điểm ngày 01-06-2024 trở đi!");
                }
            }
                
            if (Functions::convertStringPriceToNumber($form['total_hours']) <= 0) {
                $validator->errors()->add('total_hours', "Tổng giờ học phải lớn hơn 0!");
            }

            if ($this->study_method === self::STUDY_METHOD_ONLINE) {
                // Check zoom user id
                if ($form['zoom_user_id'] === "") {
                    $validator->errors()->add('study_method_error_custom', "Chưa chọn tài khoản ZOOM MEETING!");
                }

                $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections(json_decode($request->events, true));

                if (!in_array($form['zoom_user_id'], $availableZoomUserIds)) {
                    $validator->errors()->add('study_method_error_custom', "Tài khoản Zoom hiện tại đang bị trùng lịch mở lớp với 1 trong số các buổi học, vui lòng chọn tài khoản khác!");
                }
            }
        });

        if ($validator->fails()) {
            return $validator->errors();    
        };

        DB::beginTransaction();

        try {
            $this->save();
            $this->updateSectionsWhenChangeCalendar(json_decode($request->events));

            $validator->after(function ($validator) use ($form) {
                $conflictSections = $this->findStaffConflictSections();
    
                if ($conflictSections->count() > 0) {
                    $validator->errors()->add('teacher_conflict_teach_time_custom', "Giảng viên cấu hình trong lịch học bị trùng giờ dạy với lớp học " . $conflictSections->first()->course->code);
                    $this->delete();
                }
            });
    
            if ($validator->fails()) {
                return $validator->errors();
            };

            if ($this->study_method === self::STUDY_METHOD_ONLINE) {
                if ($this->zoom_user_id != $oldZoomUserId) {
                    // Update all old links
                    $this->updateZoomDataForAllSectionsByZoomAccount();
                } 
            }

            $studentsAssignedToThisCourse = Contact::whereIn('id', CourseStudent::where('course_id', $this->id)
                ->get()
                ->pluck('student_id')
                ->toArray())
                ->get()
                ->toArray();

            $notOverSections = $this->sections()->isNotOver()->get();

            foreach ($studentsAssignedToThisCourse as $student) {
                foreach ($notOverSections as $section) {
                    StudentSection::create([
                        'section_id' => $section->id,
                        'student_id' => $student['id'],
                        'status' => StudentSection::STATUS_NEW,
                    ]);
                }
            }
            UpdateSchedule::dispatch( $this, $request->user() );
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        DB::commit();

        return $validator->errors();
    }

    public static function validateScheduleItemsFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            "start_at" => "required|date_format:H:i",
            "end_at" => "required|date_format:H:i|after:start_at",
            "vn_teacher_from" => $request->has('is_vn_teacher_check') ? "required|date_format:H:i" : "",
            "vn_teacher_to" => $request->has('is_vn_teacher_check') ? "required|date_format:H:i|after:vn_teacher_from" : "",
            "foreign_teacher_from" => $request->has('is_foreign_teacher_check') ? "required|date_format:H:i" : "",
            "foreign_teacher_to" => $request->has('is_foreign_teacher_check') ? "required|date_format:H:i|after:foreign_teacher_from" : "",
            "tutor_from" => $request->has('is_tutor_check') ? "required|date_format:H:i" : "",
            "tutor_to" => $request->has('is_tutor_check') ? "required|date_format:H:i|after:tutor_from" : "",
            "assistant_from" => $request->has('is_assistant_check') ? "required|date_format:H:i" : "",
            "assistant_to" => $request->has('is_assistant_check') ? "required|date_format:H:i|after:assistant_from" : "",
            "vn_teacher_id" => $request->has('is_vn_teacher_check') ? "required_if:is_vn_teacher_check,1" : "",
            "foreign_teacher_id" => $request->has('is_foreign_teacher_check') ? "required_if:is_foreign_teacher_check,1" : "",
            "tutor_id" => $request->has('is_tutor_check') ? "required_if:is_tutor_check,1" : "",
            "type" => "required",
        ]);

        if (
            !$request->has('is_vn_teacher_check') &&
            !$request->has('is_foreign_teacher_check') &&
            !$request->has('is_tutor_check') &&
            !$request->has('is_assistant_check')
        ) {
            $validator->errors()->add('teaching_errors', 'Chưa chọn giáo viên nào để dạy');
            return $validator->errors();
        }

        $totalTeachingTime = 0;
        $assistantTeachingTime = 0;

        $totalVnTeachingTime = 0;
        $totalForeignTeachingTime = 0;
        $assistantTeachingTime = 0;

        // Caculate total of all staffs teaching times (ignore assistant)
        if ($request->has('is_vn_teacher_check')) {
            $totalVnTeachingTime += self::calculateTimeDifference($request->vn_teacher_from, $request->vn_teacher_to);
        }

        if ($request->has('is_foreign_teacher_check')) {
            $totalForeignTeachingTime += self::calculateTimeDifference($request->foreign_teacher_from, $request->foreign_teacher_to);
        }

        if ($request->has('is_tutor_check')) {
            $totalTeachingTime += self::calculateTimeDifference($request->tutor_from, $request->tutor_to);
        }

        $totalTeachingTime += ($totalVnTeachingTime + $totalForeignTeachingTime);

        // Caculate assistant teaching times
        if ($request->has('is_assistant_check')) {
            $assistantTeachingTime += self::calculateTimeDifference($request->assistant_from, $request->assistant_to);
        }

        $hasErrorAfter = false;

        $validator->after(function ($validator) use ($request) {
            if ($request->has('is_vn_teacher_check') && !$request->vn_teacher_id) {
                $validator->errors()->add('vn_teacher_id', "Chưa chọn giảng viên!");
                $hasErrorAfter = true;
            }

            if ($request->has('is_foreign_teacher_check') && !$request->foreign_teacher_id) {
                $validator->errors()->add('foreign_teacher_id', "Chưa chọn giảng viên!");
                $hasErrorAfter = true;
            }

            if ($request->has('is_tutor_check') && !$request->tutor_id) {
                $validator->errors()->add('tutor_id', "Chưa chọn gia sư!");
                $hasErrorAfter = true;
            }

            if ($request->has('is_assistant_check') && !$request->assistant_id) {
                $validator->errors()->add('assistant_id', "Chưa chọn trợ giảng!");
                $hasErrorAfter = true;
            }
        });

        // Check total teaching times in section
        $validator->after(function ($validator) use ($assistantTeachingTime, $totalTeachingTime, $totalVnTeachingTime, $totalForeignTeachingTime, $request, $hasErrorAfter) {
            $totalSessionTime = self::calculateTimeDifference($request->start_at, $request->end_at);

            if ($totalVnTeachingTime + $totalForeignTeachingTime + $assistantTeachingTime === 0) {
                $validator->errors()->add('teaching_errors', "Chưa có giờ dạy của giáo viên");
                $hasErrorAfter = true;
                
                return $validator->errors();
            }

            if ($totalTeachingTime > $totalSessionTime && $hasErrorAfter == false) {
                $validator->errors()->add('teaching_errors', 'Tổng thời gian dạy của các giảng viên vượt quá tổng thời gian buổi học');

                $hasErrorAfter = true;

                return $validator->errors();
            }

            if ($totalTeachingTime < $totalSessionTime && $hasErrorAfter == false) {
                $total = $totalTeachingTime + $assistantTeachingTime;

                if ($assistantTeachingTime > 0) {
                    // if ($total != $totalSessionTime) {
                    //     $validator->errors()->add('teaching_errors', 'Tổng thời gian dạy của các giảng viên chưa khớp với tổng thời gian buổi học');
                        
                    //     $hasErrorAfter = true;
        
                    //     return $validator->errors();
                    // } 
                }

                if ($total < $totalSessionTime) {
                    $validator->errors()->add('teaching_errors', 'Thời gian dạy chưa đủ!');
                    
                    $hasErrorAfter = true;
    
                    return $validator->errors();
                } 
            }
        });

        // Check assistant teaching times in section
        $validator->after(function ($validator) use ($assistantTeachingTime, $request, $hasErrorAfter) {
            $totalSessionTime = self::calculateTimeDifference($request->start_at, $request->end_at);

            if ($assistantTeachingTime > $totalSessionTime && $hasErrorAfter == false) {
                $validator->errors()->add('teaching_errors', 'Thời gian dạy của trợ giảng vượt quá tổng thời gian buổi học!');

                $hasErrorAfter = true;

                return $validator->errors();
            }
        });

        // Check if at least one staff has start time equal to session start time
        $validator->after(function ($validator) use ($request, $hasErrorAfter) {
            $staffs = [
                'giáo viên Việt Nam' => ['from' => $request->vn_teacher_from, 'to' => $request->vn_teacher_to, 'check' => $request->is_vn_teacher_check],
                'giáo viên nước ngoài' => ['from' => $request->foreign_teacher_from, 'to' => $request->foreign_teacher_to, 'check' => $request->is_foreign_teacher_check],
                'gia sư' => ['from' => $request->tutor_from, 'to' => $request->tutor_to, 'check' => $request->is_tutor_check],
                'trợ giảng' => ['from' => $request->assistant_from, 'to' => $request->assistant_to, 'check' => $request->is_assistant_check],
            ];

            $sessionStartTime = Carbon::parse($request->start_at);

            foreach ($staffs as $staff => $times) {
                if ($times['check'] && self::isSameTime($times['from'], $sessionStartTime) && $hasErrorAfter == false) {

                    $hasErrorAfter = true;

                    return;
                }
            }

            $validator->errors()->add('teaching_errors', 'Ít nhất một giáo viên phải có thời gian bắt đầu trùng với thời gian bắt đầu của buổi học');

            return $validator->errors();
        });

        // Check if at least one staff has end time equal to session end time
        $validator->after(function ($validator) use ($request, $hasErrorAfter) {
            $staffs = [
                'giáo viên Việt Nam' => ['from' => $request->vn_teacher_from, 'to' => $request->vn_teacher_to, 'check' => $request->is_vn_teacher_check],
                'giáo viên nước ngoài' => ['from' => $request->foreign_teacher_from, 'to' => $request->foreign_teacher_to, 'check' => $request->is_foreign_teacher_check],
                'gia sư' => ['from' => $request->tutor_from, 'to' => $request->tutor_to, 'check' => $request->is_tutor_check],
                'trợ giảng' => ['from' => $request->assistant_from, 'to' => $request->assistant_to, 'check' => $request->is_assistant_check],
            ];

            $sessionEndTime = Carbon::parse($request->end_at);

            foreach ($staffs as $staff => $times) {
                if ($times['check'] && self::isSameTime($times['to'], $sessionEndTime) && $hasErrorAfter == false) {

                    $hasErrorAfter = true;

                    return;
                }
            }

            $validator->errors()->add('teaching_errors', 'Ít nhất một giáo viên phải có thời gian kết thúc trùng với thời gian kết thúc của buổi học');
            return $validator->errors();
        });

        // Check if teaching times overlap for non-assistant staff
        $validator->after(function ($validator) use ($request, $hasErrorAfter) {
            $staffs = [
                'giáo viên Việt Nam' => ['from' => $request->vn_teacher_from, 'to' => $request->vn_teacher_to, 'check' => $request->is_vn_teacher_check],
                'giáo viên nước ngoài' => ['from' => $request->foreign_teacher_from, 'to' => $request->foreign_teacher_to, 'check' => $request->is_foreign_teacher_check],
                'gia sư' => ['from' => $request->tutor_from, 'to' => $request->tutor_to, 'check' => $request->is_tutor_check],
            ];

            foreach ($staffs as $staff1 => $times1) {
                if (!$times1['check']) {
                    continue;
                }

                foreach ($staffs as $staff2 => $times2) {
                    if (!$times2['check'] || $staff1 === $staff2) {
                        continue;
                    }

                    if (self::doTimesOverlap($times1['from'], $times1['to'], $times2['from'], $times2['to']) && $hasErrorAfter == false) {
                        $hasErrorAfter = true;

                        $validator->errors()->add('teaching_errors', 'Thời gian dạy của ' . $staff1 . ' và ' . $staff2 . ' trùng nhau');
                        return $validator->errors();
                    }
                }
            }
        });

        // Check if teaching times are within session start and end times
        $validator->after(function ($validator) use ($request, $hasErrorAfter) {
            $staffs = [
                'giáo viên Việt Nam' => ['from' => $request->vn_teacher_from, 'to' => $request->vn_teacher_to, 'check' => $request->is_vn_teacher_check],
                'giáo viên nước ngoài' => ['from' => $request->foreign_teacher_from, 'to' => $request->foreign_teacher_to, 'check' => $request->is_foreign_teacher_check],
                'gia sư' => ['from' => $request->tutor_from, 'to' => $request->tutor_to, 'check' => $request->is_tutor_check],
                'assistant' => ['from' => $request->assistant_from, 'to' => $request->assistant_to, 'check' => $request->is_assistant_check],
            ];

            $sessionStartTime = Carbon::parse($request->start_at);
            $sessionEndTime = Carbon::parse($request->end_at);

            foreach ($staffs as $staff => $times) {
                if ($times['check']) {
                    $fromTime = Carbon::parse($times['from']);
                    $toTime = Carbon::parse($times['to']);

                    if ($fromTime->lt($sessionStartTime) || $toTime->gt($sessionEndTime) && $hasErrorAfter == false) {
                        $hasErrorAfter = true;
                        $validator->errors()->add('teaching_errors', 'Thời gian dạy của ' . $staff . ' không nằm trong khoảng thời gian của buổi học');
                        return $validator->errors();
                    }
                }
            }
        });

        if ($validator->fails()) {
            return $validator->errors();
        };

        return $validator->errors();
    }

    private static function calculateTimeDifference($start, $end)
    {
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);

        return $endTime->diffInMinutes($startTime);
    }

    private static function isSameTime($time1, $time2)
    {
        return Carbon::parse($time1)->eq(Carbon::parse($time2));
    }

    private static function doTimesOverlap($start1, $end1, $start2, $end2)
    {
        $start1 = Carbon::parse($start1);
        $end1 = Carbon::parse($end1);
        $start2 = Carbon::parse($start2);
        $end2 = Carbon::parse($end2);

        return ($start1->lt($end2) && $end1->gt($start2));
    }

    public function getNumberSections()
    {
        return $this->sections()->count();
    }

    public function getEndAt()
    {
        if (!$this->sections()->count()) {
            return '--';
        }
        return $this->sections()->orderBy('end_at', 'desc')->first()->end_at;
    }

    public function getSubjects()
    {
        $weekSchedules = json_decode($this->week_schedules);
        $subjects = [];

        foreach ($weekSchedules as $weekSchedule) {
            foreach ($weekSchedule['schedules'] as $schedule) {
                $subjects[] = $schedule['subjectName'];
            }
        }

        return $subjects;
    }

    public function getCoursesBySubjectName($request)
    {
        return self::whereJsonContains('week_schedules->*->schedules[*]->subjectName', $request->subject_name)->get();
    }

    // Hàm để loại trừ thời gian của buổi học khỏi khoảng thời gian rảnh
    public static function excludeLessonsFromFreeTime($freeTimes, $lessons) {
        $result = [];

        foreach ($freeTimes as $freeTime) {
            $freeTimeStart = strtotime($freeTime["start_at"]);
            $freeTimeEnd = strtotime($freeTime["end_at"]);

            foreach ($lessons as $lesson) {
                $lessonStart = strtotime($lesson["start_at"]);
                $lessonEnd = strtotime($lesson["end_at"]);

                // Nếu thời gian rảnh và thời gian học không trùng nhau, giữ nguyên khoảng thời gian rảnh
                if ($lessonEnd <= $freeTimeStart || $lessonStart >= $freeTimeEnd) {
                    continue;
                }

                // Nếu thời gian học nằm trong khoảng thời gian rảnh
                if ($lessonStart > $freeTimeStart && $lessonEnd < $freeTimeEnd) {
                    $result[] = ["start_at" => date("Y-m-d H:i:s", $freeTimeStart), "end_at" => date("Y-m-d H:i:s", $lessonStart)];
                    $freeTimeStart = $lessonEnd;
                }
                // Nếu thời gian học bắt đầu trước hoặc trùng với thời gian rảnh và kết thúc trong hoặc sau thời gian rảnh
                else if ($lessonStart <= $freeTimeStart && $lessonEnd < $freeTimeEnd) {
                    $freeTimeStart = $lessonEnd;
                }
                // Nếu thời gian học bắt đầu trong hoặc sau thời gian rảnh và kết thúc sau thời gian rảnh
                else if ($lessonStart > $freeTimeStart && $lessonEnd >= $freeTimeEnd) {
                    $result[] = ["start_at" => date("Y-m-d H:i:s", $freeTimeStart), "end_at" => date("Y-m-d H:i:s", $lessonStart)];
                    $freeTimeEnd = $lessonStart;
                }
                // Nếu thời gian học bao trùm toàn bộ khoảng thời gian rảnh
                else if ($lessonStart <= $freeTimeStart && $lessonEnd >= $freeTimeEnd) {
                    $freeTimeStart = $freeTimeEnd;
                }
            }

            // Nếu sau khi loại trừ buổi học, vẫn còn khoảng thời gian rảnh
            if ($freeTimeStart < $freeTimeEnd) {
                $result[] = ["start_at" => date("Y-m-d H:i:s", $freeTimeStart), "end_at" => date("Y-m-d H:i:s", $freeTimeEnd)];
            }
        }

        return $result;
    }

    //Kiểm tra giờ rảnh của học viên và lớp học
    public static function checkDay($course,$student_free_times,$day_map, $studentId){
        $weekSchedules = json_decode($course->week_schedules, true);
        $sections = $course->sections()->get();
        $courseSections = [];

        foreach ($sections as $section) {
            $courseSections[] = $section->getAttributes();
        }
       
        $lessons = StudentSection::getLessonsByStudentId($studentId);
        
        if (empty($student_free_times)) {
            // Nếu freeTimes rỗng, coi như sinh viên luôn rảnh
            $student_free_times = [["start_at" => "1970-01-01 00:00:00", "end_at" => "9999-12-31 23:59:59"]];
        }
       
        $student_free_times = self::excludeLessonsFromFreeTime($student_free_times,$lessons);
        
        // foreach ($weekSchedules as $item) {
        //     $day = $item['name'];
        //     $dayNumber = $day_map[$day];
        //     $uniqueDaysOfWeeks = [];
        //     foreach ($student_free_times as $student_free_time) {
        //         if (!in_array($student_free_time['day_of_week'], $uniqueDaysOfWeeks)) {
        //             $uniqueDaysOfWeeks[] = $student_free_time['day_of_week'];
        //         }
        //     }
        //     if (!in_array($dayNumber, $uniqueDaysOfWeeks)) {
        //        return false;
        //     }
        // }

        foreach($courseSections as $courseSection) {
            // $study_date = Carbon::parse($courseSection['study_date'])->startOfDay();
            // $free_date = Carbon::parse($student_free_time['study_date'])->startOfDay();
            $courseStart = strtotime($courseSection["start_at"]);
            $courseEnd = strtotime($courseSection["end_at"]);
            $checkDuplicates = false;

            foreach ($student_free_times as $student_free_time) {
                $freeTimeStart = strtotime($student_free_time["start_at"]);
                $freeTimeEnd = strtotime($student_free_time["end_at"]);
                
                // Kiểm tra nếu thời gian bắt đầu hoặc kết thúc của buổi học nằm trong thời gian rảnh
                if (($freeTimeStart <= $courseStart && $courseStart <= $freeTimeEnd) && ($freeTimeStart <= $courseEnd && $courseEnd <= $freeTimeEnd)) {
                    $checkDuplicates = true;  
                }
            }
            
            if(!$checkDuplicates) {
                return false;
            }      
        }

        return true;
    }

    public static function getCoursesBySubjects($subjects, $student, $order_item)
    {
        // Lấy thời gian rảnh của học viên
      
        $student_availabilities = Contact::where('id', $student)->first();
       
        $studentId =  $student_availabilities->id;
        $student_free_times = $student_availabilities->getFreeTimeStudent();
      
        // Ánh xạ ngày từ dạng số sang dạng chuỗi tương ứng
        if (!is_array($subjects)) {
            $subjects = [$subjects];
        }

        $day_map = [
            'sun'=>1,
            'mon'=>2,
            'tue'=>3,
            'wed'=>4,
            'thu'=>5,
            'fri'=>6,
            'sat'=>7
        ];

        $courses = self::whereDoesntHave('students', function ($q) use ($student) {
            $q->where('student_id', $student);
        })
        ->whereHas('subject', function ($q2) use ($subjects) {
            $q2->whereIn('name', $subjects)
                ->whereDate('end_at', '>', now());
        })
        ->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->has('students', '<', DB::raw('courses.max_students'))
                    ->orWhereNull('max_students');
            });
        })
        ->where('class_type', $order_item->class_type)
        ->where('study_method', $order_item->study_type)
        ->where('status', '!=', Section::STATUS_STOPPED);
       
        if($order_item->level) {
            $courses = $courses->where('level', $order_item->level);
        }

        if ($order_item->study_type != 'Online') {
            $courses = $courses->where('training_location_id', $order_item->training_location_id);
        }
       
        $courses = $courses->get();
        $sumMinutesForeignTeacher =$order_item->getTotalForeignMinutes() - $order_item->studyHours($order_item, $order_item->orders->contacts)['sumMinutesForeignTeacher'];
        $sumMinutesVNTeacher = $order_item->getTotalVnMinutes() - $order_item->studyHours($order_item, $order_item->orders->contacts)['sumMinutesVNTeacher'];
        
        if(!$courses->isEmpty()){
            foreach ($courses as $key => $course) {
                $isOverLap = true; // Khởi tạo biến flag là true, giả sử không có trùng khớp
                $remainStudyHoursForCourseOfForeignTeacher = $course->getRemainStudyHoursForCourseOfForeignTeacher()*60;
                $remainStudyHoursForCourseOfvnTeacher = $course->getRemainStudyHoursForCourseOfvnTeacher()*60;

                if($sumMinutesForeignTeacher > 0 && $sumMinutesVNTeacher > 0){
                    if($remainStudyHoursForCourseOfForeignTeacher <= 0 && $remainStudyHoursForCourseOfvnTeacher <= 0 ){
                        $isOverLap = false; 
                    }
                }

                if($sumMinutesForeignTeacher > 0 && $sumMinutesVNTeacher <= 0 ){
                    if($remainStudyHoursForCourseOfForeignTeacher <= 0){
                        $isOverLap = false; 
                    }
                }
               
                if($sumMinutesVNTeacher > 0 && $sumMinutesForeignTeacher <= 0){
                    if($remainStudyHoursForCourseOfvnTeacher <= 0){
                        $isOverLap = false; 
                    }
                }
                
                $checkday = self::checkDay($course,$student_free_times,$day_map, $studentId);
               
                if(!$checkday){
                    $isOverLap = false; 
                }

                if (!$isOverLap) {
                    unset($courses[$key]);
                }
            }
        }
        
        return $courses;
    }

    public static function getCoursesBySubjectsDemo($subjects, $student, $order_item)
    {
        // Lấy thời gian rảnh của học viên
        $student_availabilities = Contact::where('id', $student)->first();
        $studentId =  $student_availabilities->id;
        $student_free_times = $student_availabilities->getFreeTimeStudent();
      
        // Ánh xạ ngày từ dạng số sang dạng chuỗi tương ứng
        if (!is_array($subjects)) {
            $subjects = [$subjects];
        }

        $day_map = [
            'sun'=>1,
            'mon'=>2,
            'tue'=>3,
            'wed'=>4,
            'thu'=>5,
            'fri'=>6,
            'sat'=>7
        ];
       
        $courses = self::whereDoesntHave('students', function ($q) use ($student) {
            $q->where('student_id', $student);
        })
        ->whereHas('subject', function ($q2) use ($subjects) {
            $q2->whereIn('name', $subjects)
                ->whereDate('end_at', '>', now());
        })
        ->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->has('students', '<', DB::raw('courses.max_students'))
                    ->orWhereNull('max_students');
            });
        })
        ->where('class_type', $order_item->class_type)
        ->where('study_method', $order_item->study_type)
        ->where('status', '!=', Section::STATUS_STOPPED);

        $courses = $courses->get();
        $sumMinutesForeignTeacher =$order_item->getTotalForeignMinutes() - $order_item->studyHours($order_item, $order_item->orders->contacts)['sumMinutesForeignTeacher'];
        $sumMinutesVNTeacher = $order_item->getTotalVnMinutes() - $order_item->studyHours($order_item, $order_item->orders->contacts)['sumMinutesVNTeacher'];

        if(!$courses->isEmpty()){
            foreach ($courses as $key => $course) {
                $isOverLap = true; // Khởi tạo biến flag là true, giả sử không có trùng khớp
                $remainStudyHoursForCourseOfForeignTeacher = $course->getRemainStudyHoursForCourseOfForeignTeacher()*60;
                $remainStudyHoursForCourseOfvnTeacher = $course->getRemainStudyHoursForCourseOfvnTeacher()*60;

                if($sumMinutesForeignTeacher > 0){
                    if($remainStudyHoursForCourseOfForeignTeacher <= 0){
                        $isOverLap = false; 
                    }
                }
               
                if($sumMinutesVNTeacher > 0){
                    if($remainStudyHoursForCourseOfvnTeacher <= 0){
                        $isOverLap = false; 
                    }
                }
                
                $checkday = self::checkDay($course,$student_free_times,$day_map, $studentId);
               
                if(!$checkday){
                    $isOverLap = false; 
                }

                if (!$isOverLap) {
                    unset($courses[$key]);
                }
            }
        }
          
        return $courses;
    }

    public static function getCoursesCourseTransfersBySubjects($subjects, $currentCourseId)
    {
        $course = self::where('id', $currentCourseId)->first();
        $study_method = $course->study_method;
        $courses = Course::whereHas('subject', function ($q) use ($subjects, $study_method) {
            $q->where('name', $subjects)
                ->where('study_method', $study_method)
                ->whereDate('end_at', '>', now());
        })->whereNot('id', [$currentCourseId])->get();

        return $courses;
    }

    public function scopeGetTotalStudyHoursForCourse($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.end_at, sections.start_at))), 0) / 3600 AS total_study_hours')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->first()
            ->total_study_hours;
    }

    public function scopeGetStudiedHoursForCourse($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.end_at, sections.start_at))), 0) / 3600 AS total_duration')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->whereDate('sections.study_date', '<', today())
            ->first()
            ->total_duration;
    }

    public function scopeGetRemainStudyHoursForCourse($query)
    {
        return $this->getTotalStudyHoursForCourse() - $this->getStudiedHoursForCourse();
    }

    public function scopeGetRemainStudyHoursForCourseOfvnTeacher($query)
    {
        return $this->getTotalStudyHoursForCourseOfvnTeacher() - $this->getStudiedHoursForCourseOfvnTeacher();
    }

    public function scopeGetRemainStudyHoursForCourseOfForeignTeacher($query)
    {
        return $this->getTotalStudyHoursForCourseOfForeignTeacher() - $this->getStudiedHoursForCourseOfForeignTeacher();
    }

    public function scopeGetTotalStudyHoursForCourseOfvnTeacher($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.vn_teacher_to, sections.vn_teacher_from))), 0) / 3600 AS total_study_hours')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->first()
            ->total_study_hours;
    }

    public function scopeGetStudiedHoursForCourseOfvnTeacher($query)
    {
       
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.vn_teacher_to, sections.vn_teacher_from))), 0) / 3600 AS total_duration')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->whereDate('sections.study_date', '<', today())
            ->first()
            ->total_duration;
    }

    public function scopeGetTotalStudyHoursForCourseOfForeignTeacher($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.foreign_teacher_to, sections.foreign_teacher_from))), 0) / 3600 AS total_study_hours')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->first()
            ->total_study_hours;
    }

    public function scopeGetStudiedHoursForCourseOfForeignTeacher($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.foreign_teacher_to, sections.foreign_teacher_from))), 0) / 3600 AS total_duration')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->whereDate('sections.study_date', '<', today())
            ->first()
            ->total_duration;
    }

    public function scopeGetTotalStudyHoursForCourseOfTutor($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.tutor_to, sections.tutor_from))), 0) / 3600 AS total_study_hours')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->first()
            ->total_study_hours;
    }

    public function scopeGetStudiedHoursForCourseOfTutor($query)
    {
        return $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.tutor_to, sections.tutor_from))), 0) / 3600 AS total_duration')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->whereDate('sections.study_date', '<', today())
            ->first()
            ->total_duration;
    }

    public function scopeCountStudentsByCourse($query)
    {
        return CourseStudent::select(\DB::raw('COUNT(student_id) as student_count'))
            ->where('course_id', $this->id)
            ->value('student_count') ?? 0;
    }

    public function students()
    {
        return $this->belongsToMany(Contact::class, 'course_student', 'course_id', 'student_id');
    }

    public function isStudied()
    {
        return now()->greaterThanOrEqualTo($this->end_at);
    }

    public static function scopeGetIsStudied($query)
    {
        return $query->where(function ($query) {
            $query->whereDate('end_at', '<=', now());
        });
    }

    public function isLearning()
    {
        return now()->greaterThanOrEqualTo($this->start_at) && now()->lessThanOrEqualTo($this->end_at);
    }

    public static function scopeGetIsLearning($query)
    {
        return $query->where(function ($query) {
            $query->whereDate('start_at', '<=', now())
                ->whereDate('end_at', '>=', now());
        });
    }

    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class, 'course_id', 'id');
    }

    public function isUnstudied()
    {
        return now()->lessThan($this->start_at);
    }

    public static function scopeGetIsUnstudied($query)
    {
        return $query->where(function ($query) {
            $query->whereDate('start_at', '>', now());
        });
    }

    public static function scopeGetStoppedClass($query)
    {
        return $query->where('status', Section::STATUS_STOPPED);
    }

    public function isStopped()
    {
        return $this->status == Section::STATUS_STOPPED;
    }

    public function checkStatusSubject()
    {
        if ($this->isStopped()) {
            return 'Dừng lớp';
        }
        if ($this->isStudied()) {
            return 'Hoàn thành';
        } elseif ($this->isLearning()) {
            return 'Đang học';
        } elseif ($this->isUnstudied()) {
            return 'Chưa học';
        }
    }

    public static function scopeFilterById($query, $id)
    {
        $query = $query->where('id', $id);
    }

    public static function scopeCourseStudentSubjects($query, $courseIds)
    {
        $subjects = collect();

        if (is_array($courseIds)) {
            foreach ($courseIds as $courseId) {
                $course = $query->find($courseId);

                if ($course) {
                    $subject = $course->subject;
                    if ($subject) {
                        $subjects->push($subject->name);
                    }
                }
            }
        }

        return $subjects;
    }

    public static function scopeCountCoursesBySubjects($query, $subjects)
    {
        return $query->whereHas('subject', function ($query) use ($subjects) {
            $query->where('name', $subjects);
        });
    }

    public static function scopeCoursesBySubjects($query, $subjects)
    {
        return $query->whereHas('subject', function ($query) use ($subjects) {
            $query->whereIn('name', $subjects);
        })->get();
    }

    public function getAssistants()
    {
        $assistantIds = $this->sections
            ->filter(function ($section) {
                return $section->is_assistant_check === 'checked'
                    || $section->is_assistant_check
                    || intval($section->is_assistant_check) === 1
                    || $section->is_assistant_check === 'true';
            })
            ->pluck('assistant_id')->unique();

        $assistants = Teacher::whereIn('id', $assistantIds)->get();

        return $assistants;
    }

    public function getVnTeachers()
    {
        $vnTeacherIds = $this->sections
            ->filter(function ($section) {
                return $section->is_vn_teacher_check === 'checked'
                    || $section->is_vn_teacher_check
                    || intval($section->is_vn_teacher_check) === 1
                    || $section->is_vn_teacher_check === 'true';
            })
            ->pluck('vn_teacher_id')->unique();

        $assistants = Teacher::whereIn('id', $vnTeacherIds)->get();

        return $assistants;
    }

    public function getForeignTeachers()
    {
        $foreignTeacherIds = $this->sections
            ->filter(function ($section) {
                return $section->is_foreign_teacher_check === 'checked'
                    || $section->is_foreign_teacher_check
                    || intval($section->is_foreign_teacher_check) === 1
                    || $section->is_foreign_teacher_check === 'true';
            })
            ->pluck('foreign_teacher_id')->unique();

        $assistants = Teacher::whereIn('id', $foreignTeacherIds)->get();

        return $assistants;
    }

    public function getTutors()
    {
        $tutorIds = $this->sections
            ->filter(function ($section) {
                return $section->is_tutor_check === 'checked'
                    || $section->is_tutor_check
                    || intval($section->is_tutor_check) === 1
                    || $section->is_tutor_check === 'true';
            })
            ->pluck('tutor_id')->unique();

        $assistants = Teacher::whereIn('id', $tutorIds)->get();

        return $assistants;
    }

    public function scopeCountCoursesBySubject($query)
    {
        return $query->groupBy('subject_id')
            ->select('subject_id', \DB::raw('count(*) as count'))
            ->orderByDesc('count');
    }

    public function courseStopped(Course $course, $stoppedAt)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $course->status = Section::STATUS_STOPPED;
            $course->stopped_at = $stoppedAt;

            $course->save();
            $sections = Section::where('course_id', $course->id)->where('start_at', '>', Carbon::parse($stoppedAt))->get();

            foreach ($sections as $section) {
                $section->setStopped();
            }
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function caculateTotalMinutes($type)
    {
        if (!$type) {
            throw new \Exception("Miss param type!");
        }

        $sections;

        if ($type == Section::TYPE_GENERAL) {
            $sections = $this->sections()->general()->get();
        } elseif ($type == Section::TYPE_TEST) {
            $sections = $this->sections()->test()->get();
        } else {
            throw new \Exception("Invalid section type!");
        }

        $totalMinutes = 0;

        foreach ($sections as $section) {
            $totalMinutes += $section->calculateDurationSection();
        }

        return $totalMinutes;
    }

    public function caculateStudiedMinutes()
    {
        $studiedMinutes = 0;
        $sections = $this->sections()->whichStudied()->get();

        foreach ($sections as $section) {
            $studiedMinutes += $section->calculateDurationSection();
        }

        return $studiedMinutes;
    }

    public function caculateUnstudiedMinutes()
    {
        $unstudiedMinutes = 0;
        $sections = $this->sections()->whichUnStudied()->get();

        foreach ($sections as $section) {
            $unstudiedMinutes += $section->calculateDurationSection();
        }

        return $unstudiedMinutes;
    }

    public function getSectionIds()
    {
        return $this->sections()->pluck('id')->toArray();
    }

    public function getCoursesByOrderItemAndStudent($order_items, $studentId)
    {
        if ($order_items === null) {

            return collect();
        }

        if (!is_array($order_items)) {
            // Chuyển $order_items thành mảng với một phần tử nếu nó không phải là mảng
            $order_items = [$order_items];
        }

        return self::where('end_at', '>', Carbon::parse(now()))
            ->whereHas('courseStudents', function ($q) use ($order_items, $studentId) {
                $q->where('student_id', $studentId)->whereIn('order_item_id', $order_items);
            })->get();
    }

    public function scopeGetStudiedHoursForCourseFromTo($query, $section_from = null, $section_to = null)
    {
        $query->selectRaw('COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.end_at, sections.start_at))), 0) / 3600 AS total_duration')
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->whereDate('sections.study_date', '<', today());

        if ($section_from && $section_to) {
            $query->whereBetween('sections.study_date', [$section_from, $section_to]);
        } else {
            if ($section_from) {
                $query->whereDate('sections.study_date', '>=', $section_from);
            }

            if ($section_to) {
                $query->whereDate('sections.study_date', '<=', $section_to);
            }
        }

        return $query->first()->total_duration;
    }

    public function scopeGetStudiedHoursForCourseFromToOfTeacher($query, $teacherType, $section_from = null, $section_to = null)
    {
        return $query->selectRaw("COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(sections.{$teacherType}_to, sections.{$teacherType}_from))), 0) / 3600 AS total_duration")
            ->join('sections', 'courses.id', '=', 'sections.course_id')
            ->where('courses.id', $this->id)
            ->whereDate('sections.study_date', '<', today())
            ->when($section_from, function ($query) use ($section_from) {
                return $query->whereDate('sections.study_date', '>=', $section_from);
            })
            ->when($section_to, function ($query) use ($section_to) {
                return $query->whereDate('sections.study_date', '<=', $section_to);
            })
            ->value('total_duration') ?? 0;
    }

    public static function scopeFinished($query)
    {
        $query->whereHas('courseStudents', function ($q) {
            $q->whereHas('course', function ($q2) {
                $q2->where('end_at', '<', now());
            });
        });
    }

    public static function scopeEdu($query)
    {
        $query->where('module', self::MODULE_EDU);
    }

    public static function scopeAbroad($query)
    {
        $query->where('module', self::MODULE_ABROAD);
    }

    /**
     * Copy (create new course form input course)
     * According to the business requirements of the client
     * Currently, we will not copy:
     *  - Homeroom teacher
     *  - Start time of classes
     *  - Schedule configuration (class schedule)
     * 
     * @param course course to copy
     * @return Course new course copy from input course 
     */
    public function copyFrom($course)
    {
        $this->subject_id = $course->subject_id;
        $this->zoom_start_link = $course->zoom_start_link;
        $this->zoom_join_link = $course->zoom_join_link;
        $this->zoom_password = $course->zoom_password;
        $this->level = $course->level;
        $this->status = $course->status;
        $this->max_students = $course->max_students;
        $this->min_students = $course->min_students;
        $this->joined_students = $course->joined_students;
        $this->total_hours = $course->total_hours;
        $this->type = $course->type;
        $this->class_type = $course->class_type;
        $this->module = $course->module;
        $this->test_hours = $course->test_hours;
        $this->training_location_id = $course->training_location_id;
        $this->class_room = $course->class_room;
        $this->study_method = $course->study_method;
        $this->zoom_user_id = $course->zoom_user_id;

        $this->save();
        $this->generateCodeName();

        return $this;
    }

    public function scopeByBranch($query, $branch)
    {
        $query->where('training_location_id', null)
              ->orWhereHas('trainingLocation', function ($q) use ($branch) {
                if ($branch !== \App\Library\Branch::BRANCH_ALL) {  
                    $q->where('branch', $branch);
                }
              });
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->whereHas('sections', function ($query) use ($teacherId) {
            $query->withTeacherId($teacherId);
        });
    }

    public static function checkTeacherInCount($course,$teacher){

        $weekSchedules = json_decode($course->week_schedules, true);

        if (!$weekSchedules) {
            return false;
        }
       
        foreach ($weekSchedules as $item) {
            $schedules = $item['schedules'];
            
           foreach ($schedules as $schedule){
           
                if($schedule['vn_teacher_id'] == $teacher->id ){
                    return true;
                }
                if($schedule['foreign_teacher_id'] == $teacher->id ){
                    return true;
                }
                if($schedule['assistant_id'] == $teacher->id ){
                    return true;
                }
                if($schedule['tutor_id'] == $teacher->id ){
                    return true;
                }
            }
        }
        
        return false;
    }

    public static function getByTeacherUser($teacher)
    {
        $query = self::query();
        $courses = $query->get();
      
        // Lọc các khóa học không phù hợp
        foreach ($courses as $key => $course) {
            
            if (!self::checkTeacherInCount($course, $teacher)) {
                unset($courses[$key]);
            }
        }
      
       // Lấy danh sách id của các khóa học đã lọc
        $courseIds = $courses->pluck('id')->all();

        // Tạo truy vấn mới từ danh sách id đã lọc
        $filteredQuery = $query->whereIn('id', $courseIds);

        return $filteredQuery;
    }

    public function getCountStudentsByCourse()
    {
        return CourseStudent::where('course_id', $this->id)->count();
    }

    public function getCountRefundedStudentsByCourse()
    {
        return CourseStudent::where('course_id', $this->id)
            ->join('refund_requests', function ($join) {
                $join->on('course_student.student_id', '=', 'refund_requests.student_id')
                    ->on('course_student.order_item_id', '=', 'refund_requests.order_item_id');
            })
            ->count();
    }

    public function getCountReserveStudentsByCourse()
    {
        return CourseStudent::where('course_id', $this->id)
            ->join('reserve', function ($join) {
                $join->on('course_student.student_id', '=', 'reserve.student_id')
                    ->on('course_student.order_item_id', '=', 'reserve.order_item_id');
            })
            ->count();
    }

    public function getTeachersFromCourse(): array
    {
            $vnTeachers = $this->sections
                                ->where('vn_teacher_id', '!=', '')
                                ->pluck('vn_teacher_id')
                                ->toArray();
        
            $foreignTeachers = $this->sections
                                ->where('foreign_teacher_id', '!=', '')
                                ->pluck('foreign_teacher_id')
                                ->toArray();
        
            $tutor = $this->sections
                                ->where('tutor_id', '!=', '')
                                ->pluck('tutor_id')
                                ->toArray();
        
            $assistant = $this->sections
                                ->where('assistant_id', '!=', '')
                                ->pluck('assistant_id')
                                ->toArray();
        
            // Gộp các mảng lại
            $allTeachers = array_merge($vnTeachers, $foreignTeachers, $tutor, $assistant);
        
            // Loại bỏ các phần tử trùng lặp mà không đánh lại chỉ mục
            $uniqueTeachers = array_values(array_unique($allTeachers));
        
            return $uniqueTeachers;
    }

    public function getUserTeacherAndStudent(){
        $studentSections = [];
        $users = [];
        $teacherIds = array_values($this->getTeachersFromCourse());

        foreach ($teacherIds as $teacher){
            $accounts = \App\Models\Account::where('teacher_id',$teacher)->get();
        
            foreach ($accounts as $account) {
                $user = \App\Models\User::where('account_id', $account->id)->first();
               
                if ($user) {
                    $users[] = $user;
                }
            }
        }
        
        $studentSections = Contact::whereIn('id', CourseStudent::where('course_id', $this->id)
                            ->get()
                            ->pluck('student_id')
                            ->toArray())
                            ->get()
                            ->toArray();

        foreach ($studentSections as $studentSection){
            if($studentSection){
                $accounts = \App\Models\Account::where('student_id',$studentSection['id'])->get();
            
                foreach ($accounts as $account) {
                    $user = \App\Models\User::where('account_id', $account->id)->first();
                 
                    if ($user) {
                        $users[] = $user;
                    }
                }
            }
        }

       $users = array_values(array_unique($users));
       
        return $users;
    }

    public function getStartStudyStudent($orderItem){
        $studentSections = CourseStudent::where('student_id',$orderItem->student_id)->where('course_id',$this->id)->where('order_item_id ',$orderItem->id);
        $sections = Section::where('course_id', $this->id)->orderBy('study_date', 'asc')->get();
        $studentSection = null;

       foreach($sections as $section){
            $studentSection = StudentSection::where('section_id',$section->id)->where('student_id',$orderItem->order->student->id)->first();
           
            if($studentSection){
                break;
            }
       }
       
        return $studentSection->section;
    }

    public function getTotalMinutesOfTeacher($teacher_type)
    {
        $totalMinutes = 0;

        if($teacher_type == 'VNTeacher'){
            $sections = $this->sections()->general()->whereNotNull('vn_teacher_id')->get(); 
            
            foreach ($sections as $section) {
                $totalMinutes += $section->calculateDurationSectionVN();
            }
        }

        if($teacher_type == 'ForeignTeacher'){
            $sections = $this->sections()->general()->whereNotNull('foreign_teacher_id')->get(); 
            
            foreach ($sections as $section) {
                $totalMinutes += $section->calculateDurationSectionForeignTeacher();
            }
        }

        if($teacher_type == 'Tutor'){
            $sections = $this->sections()->general()->whereNotNull('tutor_id')->get(); 
            
            foreach ($sections as $section) {
                $totalMinutes += $section->calculateDurationSectionTutor();
            }
        }

        if($teacher_type == 'Assistant'){
            $sections = $this->sections()->general()->whereNotNull('assistant_id')->get(); 
            
            foreach ($sections as $section) {
                $totalMinutes += $section->calculateDurationSectionAssistant();
            }
        }

        return $totalMinutes;
    }

    /**
     * Delete all meetings existing in this course
     * 
     * Make sure only use this function when delete course
     */
    public function removeAllZoomMeetings()
    {
        // Just handle if this is online course
        if ($this->study_method = self::STUDY_METHOD_ONLINE) {
            $sections = $this->sections;
            $zoomMeetingIdToDelete = [];

            foreach ($sections as $section) {
                $meetingId = $section->getMeetingId();

                if ($meetingId) {
                    $zoomMeetingIdToDelete[] = $meetingId;
                }
            }

            $uniqMeetingIds = array_unique($zoomMeetingIdToDelete);

            if (!empty($uniqMeetingIds)) {
                foreach ($uniqMeetingIds as $id) {
                    ZoomMeeting::deleteMeeting($id);
                }
            }
        }
    }

    public function isOnlineCourse()
    {
        return $this->study_method === self::STUDY_METHOD_ONLINE;
    }

    public function isUsingZoomUserToGenerateLinks()
    {
        // This course is not online course
        if (!$this->isOnlineCourse()) return false; // FALSE

        $zoomUserId = $this->zoom_user_id;

        // Somehow, this course is not have zoom_user_id, 
        // Maybe error or this course was imported from init data
        if (!$zoomUserId) return false; // FALSE

        $sections = $this->sections->all();
        $zoomStartLinks = [];

        foreach($sections as $section) {
            $startLink = $section->zoom_start_link;

            if ($startLink) $zoomStartLinks[] = $startLink;
        }

        $zoomStartLinks = array_unique($zoomStartLinks);

        if (count($zoomStartLinks) <= 0) return false; // FALSE

        $meetingIds = [];

        foreach($zoomStartLinks as $startLink) {
            $meetingId = ZoomMeeting::getMeetingIdFromStartLink($startLink);

            if ($meetingId && $meetingId != '') $meetingIds[] = $meetingId;
        }

        if (count($meetingIds) <= 0) return false; // FALSE

        // At least one meeting is enable -> this course is using zoom user to generate zoom meeting
        foreach($meetingIds as $id) {
            if (ZoomMeeting::isMeetingEnable($id)) return true;
        }

        return false;
    }

    public function getRemainStudyMinutesOfVnTeacher()
    {
        $sections = $this->sections;

        if (!$sections) return 0;

        $minutes = 0;

        foreach($sections as $section) {
            if (!$section->isOutDate()) $minutes += $section->caculateVnTeacherMinutes();
        }

        return $minutes;
    }

    public function getRemainStudyMinutesOfForeignTeacher()
    {
        $sections = $this->sections;

        if (!$sections) return 0;

        $minutes = 0;

        foreach($sections as $section) {
            if (!$section->isOutDate()) $minutes += $section->caculateForeignTeacherMinutes();
        }

        return $minutes;
    }

    public function getRemainStudyMinutesOfTutor()
    {
        $sections = $this->sections;

        if (!$sections) return 0;

        $minutes = 0;

        foreach($sections as $section) {
            if (!$section->isOutDate()) $minutes += $section->caculateTutorMinutes();
        }

        return $minutes;
    }

    public function getRemainStudyMinutesOfAssistant()
    {
        $sections = $this->sections;

        if (!$sections) return 0;

        $minutes = 0;

        foreach($sections as $section) {
            if (!$section->isOutDate()) $minutes += $section->caculateAssistantMinutes();
        }

        return $minutes;
    }

    public static function scopeIsImportData($query)
    {
        $query->where('import_id', '!=', null);
    }

    public static function scopeIsNotImportData($query)
    {
        $query->where('import_id', null);
    }
}
