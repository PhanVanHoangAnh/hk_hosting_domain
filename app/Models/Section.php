<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_STUDIED = 'studied';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_UNPLANNED_CANCELLED = 'status_unplanned_cancelled';
    public const LATE_CANCELLED_TEACHER = 'late_cancelled_teacher';
    public const LATE_CANCELLED_STUDENT = 'late_cancelled_student';
    public const STATUS_DESTROY = 'destroy';

    public const LEARNING_STATUS = 'Đang học';
    public const COMPLETED_STATUS = 'Đã học';
    public const UNSTUDIED_STATUS = 'Chưa học';
    public const STATUS_STOPPED = 'stopped';
    public const STATUS_NOT_ACTIVE = 'not_active';

    // Type
    public const TYPE_GENERAL = 'general';
    public const TYPE_TEST = 'test';
    public const TYPE_FREE_TIME = 'freetime';

    //Chốt ca
    public const STATUS_SHIFT_CLOSED = 'shift_closed';
    public const STATUS_OVERDUE_SHIFT_CLOSED = 'shift_overdue_closed';
    public const STATUS_NOT_SHIFT_CLOSED = 'not_shift_closed';

    protected $fillable = [
        'course_id',
        'study_date',
        'start_at',
        'end_at',
        'is_vn_teacher_check',
        'vn_teacher_id',
        'vn_teacher_from',
        'vn_teacher_to',
        'is_foreign_teacher_check',
        'foreign_teacher_id',
        'foreign_teacher_from',
        'foreign_teacher_to',
        'is_tutor_check',
        'tutor_id',
        'tutor_from',
        'tutor_to',
        'is_assistant_check',
        'assistant_id',
        'assistant_from',
        'assistant_to',
        'is_add_later',
        'code',
        'is_modified',
        'type',
        'closing_shift_status',
        'order_number',
        'import_id',

        'zoom_start_link',
        'zoom_join_link',
        'zoom_password',
    ];

    public static function getAllType()
    {
        return [
            self::TYPE_GENERAL,
            self::TYPE_TEST
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function studentSections()
    {
        return $this->hasMany(StudentSection::class, 'section_id', 'id');
    }

    public function scopeIsNotOver($query)
    {
        $query->where('start_at', '>', Carbon::now());
    }
    //thử nghiệm
    public function scopeIsNotOverDayStart($query,$assignment_date)
    {
        $query->where('start_at', '>', $assignment_date);
    }
    public function scopeStartAt($query, $startAt)
    {
        $query->where('start_at', '>', Carbon::parse($startAt));
    }

    public static function getSectionsByCourseIdAssignment($courseId)
    {
        return self::where('course_id', $courseId)->where('study_date', '>', Carbon::now())->pluck('id')->toArray();
    }

    public function vnTeacher()
    {
        return $this->belongsTo(Teacher::class, 'vn_teacher_id', 'id');
    }

    public function foreignTeacher()
    {
        return $this->belongsTo(Teacher::class, 'foreign_teacher_id', 'id');
    }

    public function tutor()
    {
        return $this->belongsTo(Teacher::class, 'tutor_id', 'id');
    }

    public function assistant()
    {
        return $this->belongsTo(Teacher::class, 'assistant_id', 'id');
    }

    public function sectionReports()
    {
        return $this->hasMany(SectionReport::class, 'section_id');
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->orWhereHas('vnTeacher', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
                ->orWhereHas('foreignTeacher', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('tutor', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('assistant', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('course.subject', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('course', function ($query) use ($keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                })
                ->orWhere('start_at', 'LIKE', "%{$keyword}%")
                ->orWhere('end_at', 'LIKE', "%{$keyword}%")
                ->orWhere('study_date', 'LIKE', "%{$keyword}%")
                ->orWhere(\DB::raw('DATE_FORMAT(study_date, "%d/%m/%Y")'), 'LIKE', "%{$keyword}%");;
        });
    }

    public static function scopeNotActive($query)
    {
        $query = $query->where('sections.status', self::STATUS_NOT_ACTIVE);
    }

    public static function scopeActive($query)
    {
        $query = $query->where('sections.status', self::STATUS_ACTIVE);
    }

    public static function scopeIsDestroy($query)
    {
        $query = $query->where('sections.status', self::STATUS_DESTROY);
    }

    public static function scopeIsOverdueShiftClosed($query)
    {
        $query =  $query->where('closing_shift_status', null)
            ->where(function ($query) {
                $query->where('closing_shift_status', null)
                    ->whereRaw('(NOW() > DATE_ADD(end_at, INTERVAL 24 HOUR))');
            });
    }

    public static function scopeIsNotShiftClosed($query)
    {
        $now = Carbon::now();
        $query =  $query->where('closing_shift_status', null)
            ->where('end_at', '<', $now)
            ->whereRaw('(DATE_ADD(end_at, INTERVAL 24 HOUR) > ?)', [$now]);
    }

    public function scopeIsNotDestroy($query)
    {
        $query->where('sections.status', '<>', self::STATUS_DESTROY);
    }

    public static function scope($query)
    {
        $query = $query->where('sections.status', self::STATUS_DESTROY);
    }

    public static function scopeGeneral($query)
    {
        $query = $query->where('sections.type', self::TYPE_GENERAL);
    }

    public function scopeTest($query)
    {
        $query->where('sections.type', self::TYPE_TEST);
    }

    public static function scopeDeleteSections($query, $items)
    {
        self::whereIn('id', $items)->update(['status' => self::STATUS_DESTROY]);
    }

    public static function scopeFilterByCourses($query, $courses)
    {
        $query = $query->whereHas('course', function ($query) use ($courses) {
            $query->whereIn('id', $courses);
        });
    }

    public static function scopeFilterByTeachers($query, $teacherIds)
    {
        return $query->whereIn('vn_teacher_id', $teacherIds)
                     ->orWhereIn('foreign_teacher_id', $teacherIds)
                     ->orWhereIn('tutor_id', $teacherIds);
        // $courses = Course::whereIn('teacher_id', $teacherIds)->get();
        // $sectionIds = [];

        // foreach ($courses as $course) {
        //     $sectionIds = array_merge($sectionIds, $course->sections()->pluck('id')->toArray());
        // }

        // return $query->whereIn('id', $sectionIds);
    }

    public static function scopeFilterByHomeRooms($query, $homeRoomIds)
    {
        return $query->whereHas('course', function($q) use ($homeRoomIds) {
            $q->whereIn('teacher_id', $homeRoomIds);
        });
    }

    public static function scopeFilterByTypes($query, $types)
    {
        return $query->whereIn('type', $types);
    }

    public static function scopeFilterBySubjects($query, $subjectIds)
    {
        $courses = Course::whereIn('subject_id', $subjectIds)->get();
        $sectionIds = [];

        foreach ($courses as $course) {
            $sectionIds = array_merge($sectionIds, $course->sections()->pluck('id')->toArray());
        }

        $query->whereIn('id', $sectionIds);
    }

    public static function scopeFilterByStartAt($query, $start_at_from, $start_at_to)
    {
        if (!empty($start_at_from) && !empty($start_at_to)) {
            return $query->whereBetween('start_at', [$start_at_from, \Carbon\Carbon::parse($start_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByStudyDate($query, $study_date_from, $study_date_to)
    {
        if (!empty($study_date_from) && !empty($study_date_to)) {
            return $query->whereBetween('study_date', [$study_date_from, \Carbon\Carbon::parse($study_date_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByStudentId($query, $studentId)
    {
        $query->whereHas('course', function ($q) use ($studentId) {
            $q->whereHas('students', function ($q2) use ($studentId) {
                $q2->where('contacts.id', $studentId);
            });
        });
    }

    public function updateZoomLinksFromRequest($request)
    {
        $validator = Validator::make($request->all(), []);

        $validator->after(function($validator) use ($request) {
            // Chỉ kiểm tra với buổi học ONLINE
            // if ($this->course->study_method === \App\Models\Course::STUDY_METHOD_ONLINE) {
                // Trường hợp chưa nhập link zoom và chưa chọn tài khoản zoom
                if (!(!!$request->zoom_user_id) && !(!!$request->zoom_start_link)) {
                    $validator->errors()->add('overlap_zoom_schedule_errors', 'Vui lòng nhập thông tin Zoom hoặc chọn 1 tài khoản để tự động tạo link zoom!');
                } else {
                    // Trường hợp chọn tài khoản zoom có sẵn để tự động tạo link zoom
                    if (!!$request->zoom_user_id) {
                        if ($this->checkZoomLinkOverlapByZoomUser($this->study_date, $request->zoom_user_id)) {
                            $validator->errors()->add('overlap_zoom_schedule_errors', 'Tài khoản Zoom bạn chọn đang bị trùng lịch vào ngày sắp chuyển tới, vui lòng chọn tài khoản zoom khác!');
                        }
                    } elseif (!!$request->zoom_start_link) { // Trường hợp nhập vào link zoom đã có sẵn (Có thể đây không phải là link thuộc quản lý của tài khoản chính)
                        if ($this->checkZoomLinkOverlapByPastLink($this->study_date, $request->zoom_start_link)) {
                            $validator->errors()->add('overlap_zoom_schedule_errors', 'Thông tin link zoom bạn điền vào đang bị trùng lịch vào ngày sắp chuyển tới, vui lòng điền vào thông tin phòng học zoom khác!');
                        }

                        if (!(!!$request->zoom_join_link)) {
                            $validator->errors()->add('overlap_zoom_schedule_errors', 'Thông tin Zoom cần có đủ link mở lớp và link tham gia lớp, vui lòng nhập link tham gia lớp!');
                        }
                    }
                }
            // }
        });

        if ($validator->fails()) {
            return $validator->errors();
        };
       
        if (!!$request->zoom_user_id) {
            $this->generateZoomLinks($request['zoom_user_id']);
        } elseif (!!$request->zoom_start_link) {
            $this->pastZoomLinks($request['zoom_start_link'], $request['zoom_join_link'], $request['zoom_password']);
        }

        return $validator->errors();
    }

    public function saveFromRequest($request)
    {
        // Lấy ra zoom start link đã lưu trước khi fill giá trị mới vào
        $currentZoomStartLink = $this->zoom_start_link;

        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'study_date' => 'required',
        ]);
        
        $validator->after(function($validator) use ($request, $currentZoomStartLink) {
            // Chỉ kiểm tra với buổi học ONLINE
            if ($this->course->study_method === \App\Models\Course::STUDY_METHOD_ONLINE) {
                // Không truyền vào zoom user id mới hoặc zoom start link mới
                // 2 trường hợp: 
                //      + Nhấn lưu lần đầu (lúc này chưa báo lỗi trùng zoom user nên chưa hiện khung chọn zoom user/dán link)
                //      + Đã báo lỗi trùng lịch zoom và hiện khung zoom nhưng không chọn zoom user và không dán link mới
                if (!(!!$request->zoom_user_id) && !(!!$request->zoom_start_link)) {
                    // Kiểm tra zoom start link đã lưu từ trước
                    if ($currentZoomStartLink) { // Nếu đang có sẵn zoom_start_link được lưu từ trước
                        $zoomUserId = ZoomMeeting::getZoomUserIdByStartLink($currentZoomStartLink);

                        // Nếu lấy được zoom user id từ start link
                        // nghĩa là link này được tạo ra từ các user thuộc quản lý của zoom account ASMS
                        if ($zoomUserId) {
                            if ($this->checkZoomLinkOverlapByZoomUser($request['study_date'], $zoomUserId)) {
                                $validator->errors()->add('overlap_zoom_schedule_errors', 'Tài khoản Zoom hiện tại của buổi học này đang bị trùng lịch vào ngày sắp chuyển tới, vui lòng chọn tài khoản zoom khác!');
                            }
                        } else {
                            // Không lấy được zoom user id
                            // Nghĩa là link không được tạo ra từ các user thuộc quản lý của account ASMS
                            if ($this->checkZoomLinkOverlapByPastLink($request['study_date'], $currentZoomStartLink)) {
                                $validator->errors()->add('overlap_zoom_schedule_errors', 'Link zoom hiện tại của buổi học này đang bị trùng lịch vào ngày sắp chuyển tới, vui lòng điền vào thông tin phòng học zoom khác hoặc chọn 1 tài khoản zoom khác để tự động tạo link zoom!');
                            }
                        }
                    } else { // Nếu không có sẵn zoom_start_link lưu trước đó
                        $validator->errors()->add('overlap_zoom_schedule_errors', 'Buổi học này đang chưa có link zoom, vui lòng chọn 1 tài khoản zoom để tạo mới link zoom hoặc nhập vào link zoom đã có sẵn!');
                    }
                } else { // Có chọn zoom user mới hoặc dán start link mới (Trường hợp này chỉ xảy ra khi đã báo lỗi trùng lịch zoom)
                    if (!!$request->zoom_user_id) { // Chọn zoom user mới
                        if ($this->checkZoomLinkOverlapByZoomUser($request['study_date'], $request->zoom_user_id)) {
                            $validator->errors()->add('overlap_zoom_schedule_errors', 'Tài khoản Zoom bạn chọn đang bị trùng lịch vào ngày sắp chuyển tới, vui lòng chọn tài khoản zoom khác!');
                        }
                    } elseif (!!$request->zoom_start_link) { // Dán link mới (link có sẵn, có thể là link không thuộc quản lý của zoom account ASMS)
                        if ($this->checkZoomLinkOverlapByPastLink($request['study_date'], $request->zoom_start_link)) {
                            $validator->errors()->add('overlap_zoom_schedule_errors', 'Thông tin link zoom bạn điền vào đang bị trùng lịch vào ngày sắp chuyển tới, vui lòng điền vào thông tin phòng học zoom khác!');
                        }

                        if (!(!!$request->zoom_join_link)) {
                            $validator->errors()->add('overlap_zoom_schedule_errors', 'Thông tin Zoom cần có đủ link mở lớp và link tham gia lớp, vui lòng nhập link tham gia lớp!');
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            return $validator->errors();
        };

        $this->update([
            'study_date' => $request['study_date'],
        ]);

        return $validator->errors();
    }

    public function updateTeacher($request)
    {
        $this->fill($request->all());

        $studyDate = explode(' ', $this->study_date, 2);

        $this->start_at = $studyDate[0] . ' ' . $request->start_at;
        $this->end_at = $studyDate[0] . ' ' . $request->end_at;

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return $errors;
        }

        return $validator->errors();
    }

    public function isStatusNew()
    {
        return $this->studentSections->first()->status == StudentSection::STATUS_NEW;
    }

    public function isExcusedAbsence()
    {
        return $this->studentSections->first()->status == StudentSection::STATUS_EXCUSED_ABSENCE;
    }

    public function isUnExcusedAbsence()
    {
        return $this->studentSections->first()->status == StudentSection::STATUS_UNEXCUSED_ABSENCE;
    }

    public function isReserve()
    {
        return $this->studentSections->first()->status == StudentSection::STATUS_RESERVE;
    }

    public function isUnstudied()
    {
        return $this->study_date > today();
    }

    public function isStudied()
    {
        return $this->status === self::STATUS_STUDIED;
    }

    public function isStopped()
    {
        return $this->status === self::STATUS_STOPPED;
    }

    public function isPastner()
    {
        return $this->studentSections->first()->status == StudentSection::STATUS_STUDY_PARTNER;
    }

    public static function scopeNotStudyYet($query)
    {
        $query->where('start_at', ">", today());
    }

    public static function scopeStudied($query)
    {
        $query->where('end_at', "<", today());
    }

    public static function scopeLearning($query)
    {
        $query->where('start_at', '>', now())
            ->where('end_at', '<', now());
    }

    public function isStatusCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    public function isLateCancelledTeacher()
    {
        return $this->status == self::LATE_CANCELLED_TEACHER;
    }

    public function isLateCancelledStudent()
    {
        return $this->status == self::LATE_CANCELLED_STUDENT;
    }

    public function checkStatusSectionCalendar()
    {
        if ($this->isStudied()) {
            return 'Đã học';
        } elseif ($this->isStatusCancelled()) {
            return 'Nghỉ có kế hoạch';
        } elseif ($this->isLateCancelledTeacher()) {
            return 'Nghỉ do giáo viên';
        } elseif ($this->isLateCancelledStudent()) {
            return 'Nghỉ do học viên';
        } elseif ($this->isStudied()) {
            return 'Đã học';
        } elseif ($this->isStopped()) {
            return 'Đã dừng';
        } elseif ($this->isUnstudied()) {
            return 'Chưa học';
        }
        return 'Đang học';
    }

    public function checkStatusSection()
    {
        if ($this->isStatusNew()) {
            return 'Chưa học';
        } else if ($this->isExcusedAbsence()) {
            return 'Vắng có phép';
        } else if ($this->isUnExcusedAbsence()) {
            return 'Vắng không phép';
        } else if ($this->isReserve()) {
            return 'Bảo lưu';
        } else if ($this->isStudied()) {
            return 'Đã học';
        } else if ($this->isPastner())
            return 'Học bù';
    }

    public static function getSectionsByCourseIds($courseIds)
    {
        return Section::whereIn('course_id', $courseIds)->get();
    }

    public static function getSectionsByStudentId($studentId)
    {
        $studentSections = StudentSection::where('student_id', $studentId)->get()->pluck('section_id');

        return Section::whereIn('id', $studentSections)->get();
    }

    public function calculateDurationSection()
    {
        $startDateTime = Carbon::parse($this->start_at);
        $endDateTime = Carbon::parse($this->end_at);

        return $startDateTime->diffInMinutes($endDateTime);
    }

    public function hasReportForStudent($studentId)
    {
        $report = $this->sectionReports()
            ->where('student_id', $studentId)
            ->first();

        if (!$report) {
            return false;
        }
        return $report->status !== SectionReport::STATUS_DELETED;
    }

    public static function scopeWhichStudied($query)
    {
        return $query->active()
            ->where('study_date', '<', today());
    }

    public static function scopeWhichUnStudied($query)
    {
        return $query->active()
            ->where('study_date', '>=', today());
    }

    public static function scopeFilterSectionByCourses($query, $courses, $studentId)
    {
        $query = $query->whereHas('course', function ($query) use ($courses) {
            $query->whereIn('id', $courses);
        })->where('start_at', '>', today())
            ->whereDoesntHave('studentSections', function ($q3) use ($studentId) {
                $q3->where('student_id', $studentId);
            });
    }

    public static function scopeFilterSectionStudentByCourses($query, $courses, $studentId)
    {
        $query->whereHas('course', function ($query) use ($courses) {
            $query->whereIn('id', $courses);
        })->whereDoesntHave('studentSections', function ($q3) use ($studentId, $courses) {
            $q3->where('student_id', $studentId)
                ->whereIn('section_id', function ($query) use ($courses) {
                    $query->select('section_id')
                        ->from('student_sections')
                        ->whereIn('course_id', $courses);
                });
        });
    }

    public static function scopeGetSectionStudentByCourse($query, $studentId, $courseId)
    {
        return $query
            ->where('course_id', $courseId)
            ->whereHas('studentSections', function ($subQuery) use ($studentId, $courseId) {
                $subQuery
                    ->where('student_id', $studentId)
                    ->where('course_id', $courseId)
                    ->where('status', StudentSection::STATUS_PRESENT);
            });
    }

    public static function getTotalHoursOfSections($sections)
    {
        $totalMinutes = 0;

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->start_at);
            $endAt = Carbon::parse($section->end_at);

            $durationInMinutes = $endAt->diffInMinutes($startAt);
            $totalMinutes += $durationInMinutes;
        }

        return floatval($totalMinutes);
    }

    public function scopeIncoming($query)
    {
        return $query->where('study_date', '>=', Carbon::today())
            ->orderBy('study_date');
    }

    public function getDiffTimeStudyDate()
    {
        $diff = Carbon::now()->diff($this->study_date);
        $result = '';

        if ($diff->d > 0) {
            $result .= $diff->d . ' ngày ';
        }
        if ($diff->h > 0) {
            $result .= $diff->h . ' giờ ';
        }
        if ($diff->i > 0) {
            $result .= $diff->i . ' phút ';
        }

        return $result . ' nữa';
    }

    public static function filterSectionsForStudentCalendar($sections)
    {
        $studentSections = StudentSection::all();

        $sectionsForStudentCalendar = $sections->filter(function ($section) use ($studentSections) {
            $filteredSections = $studentSections->where('section_id', $section->id);
            $status = $filteredSections->isNotEmpty() ? $filteredSections->first()->status : null;

            return in_array($status, [StudentSection::STATUS_NEW, StudentSection::STATUS_PRESENT, StudentSection::STATUS_RESERVE]);
        })->map(function ($section) use ($studentSections) {
            $filteredSections = $studentSections->where('section_id', $section->id);
            $status = $filteredSections->isNotEmpty() ? $filteredSections->first()->status : null;

            return array_merge($section->toArray(), ['status' => $status]);
        });

        return $sectionsForStudentCalendar;
    }

    public function setStopped()
    {
        $this->status = self::STATUS_STOPPED;
        $this->studentSections()->update(['status' => StudentSection::STATUS_STOPPED]);
        $this->save();
    }

    public function getVnTeacher()
    {
        if (
            $this->is_vn_teacher_check === 'checked'
            || $this->is_vn_teacher_check
            || intval($this->is_vn_teacher_check) === 1
            || $this->is_vn_teacher_check === 'true'
        ) {
            return Teacher::find($this->vn_teacher_id);
        } else {
            return null;
        }
    }

    public function getForeignTeacher()
    {
        if (
            $this->is_foreign_teacher_check === 'checked'
            || $this->is_foreign_teacher_check
            || intval($this->is_foreign_teacher_check) === 1
            || $this->is_foreign_teacher_check === 'true'
        ) {
            return Teacher::find($this->foreign_teacher_id);
        } else {
            return null;
        }
    }

    public function getTutor()
    {
        if (
            $this->is_tutor_check === 'checked'
            || $this->is_tutor_check
            || intval($this->is_tutor_check) === 1
            || $this->is_tutor_check === 'true'
        ) {
            return Teacher::find($this->tutor_id);
        } else {
            return null;
        }
    }

    public function getAssistant()
    {
        if (
            $this->is_assistant_check === 'checked'
            || $this->is_assistant_check
            || intval($this->is_assistant_check) === 1
            || $this->is_assistant_check === 'true'
        ) {
            return Teacher::find($this->assistant_id);
        } else {
            return null;
        }
    }

    public function calculateInMinutesVnTeacherInSection()
    {
        $startAt = Carbon::parse($this->vn_teacher_from);
        $endAt = Carbon::parse($this->vn_teacher_to);

        return $endAt->diffInMinutes($startAt);
    }

    public function calculateInMinutesForeignTeacherInSection()
    {
        $startAt = Carbon::parse($this->foreign_teacher_from);
        $endAt = Carbon::parse($this->foreign_teacher_to);

        return $endAt->diffInMinutes($startAt);
    }

    public function calculateInMinutesTutorInSection()
    {
        $startAt = Carbon::parse($this->tutor_from);
        $endAt = Carbon::parse($this->tutor_to);

        return $endAt->diffInMinutes($startAt);
    }
    public function calculateInMinutesAssistantInSection()
    {
        $startAt = Carbon::parse($this->assistant_from);
        $endAt = Carbon::parse($this->assistant_to);

        return $endAt->diffInMinutes($startAt);
    }
    public function saveShift($request)
    {
        // Nghiệp vụ: subject phải giống nhau
        // if ($currentCourse->subject_id !== $courseTransfer->subject_id) {
        //     throw new \Exception("Môn học của lớp học hiện tại [" . $currentCourse->subject->name . "] và lớp học chuyển tới [" . $courseTransfer->subject->name . "] không giống nhau");
        // }

        // Begin transaction
        DB::beginTransaction();

        try {
            if ($request->checkShift === self::STATUS_STUDIED) {
                $this->status = $request->checkShift;
                // $this->save();

                // $studentSections = $this->studentSections;

                // foreach ($studentSections as $studentSection) {
                //     $studentSection->updateStatusSection($request->checkShift);
                // }
            }

            if ($request->checkShift === self::STATUS_CANCELLED) {
                if ($request->cancelled === self::STATUS_CANCELLED) {
                    $this->status = $request->cancelled;
                    // $this->save();

                    // $studentSections = $this->studentSections;

                    // foreach ($studentSections as $studentSection) {
                    //     $studentSection->updateStatusSection($request->cancelled);
                    // }
                }

                if ($request->cancelled === self::STATUS_UNPLANNED_CANCELLED) {
                    $this->status = $request->unplannedCancelled;
                    $this->note = $request->note;

                    // $studentSections = $this->studentSections;

                    // foreach ($studentSections as $studentSection) {
                    //     $studentSection->updateStatusSection($request->unplannedCancelled);
                    // }
                }
            }

            $this->closing_shift_status = self::STATUS_SHIFT_CLOSED;
            $this->save();
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
    
    public function checkStatusShiftClosed()
    {
        if ($this->closing_shift_status == self::STATUS_SHIFT_CLOSED) {
            return 'Đã chốt ca';
        } elseif ($this->closing_shift_status == null && $this->checkEndAtSection()) {
            return 'Sẵn sàng chốt ca';
        } elseif ($this->closing_shift_status == null && !$this->checkOverdueShiftClosed()) {
            return 'Chưa tới giờ chốt ca';
        } elseif ($this->closing_shift_status == null && $this->checkOverdueShiftClosed()) {
            return 'Quá hạn chốt ca';
        }
    }

    public function checkEndAtSection()
    {
        $now = now();

        $hoursDifference = $now->diffInHours($this->end_at);
        return $hoursDifference < 24;
    }

    public function checkOverdueShiftClosed()
    {
        $now = now();

        // Thêm 24 giờ vào $this->end_at
        $endAt = \Carbon\Carbon::parse($this->end_at);

        // Thêm 24 giờ vào thời điểm $this->end_at
        $endAtPlus24Hours = $endAt->addHours(24);

        // Kiểm tra xem thời điểm hiện tại có lớn hơn $this->end_at cộng thêm 24 giờ hay không
        return $now > $endAtPlus24Hours;
    }

    public static function beforeDate($sections, $date)
    {
        $compareDate = Carbon::parse($date);

        $filteredSections = $sections->filter(function ($section) use ($compareDate) {
            return Carbon::parse($section['study_date'])->lt($compareDate);
        });

        return $filteredSections;
    }

    // public static function beforeDateForeignTeacher($sections, $date)
    // {
    //     {
    //         $compareDate = Carbon::parse($date);

    //         $filteredSections = $sections->filter(function ($section) use ($compareDate) {
    //             return Carbon::parse($section['foreign_teacher'])->lt($compareDate);
    //         });

    //         return $filteredSections;
    //     }
    // }

    public static function scopeEdu($query)
    {
        $query = $query->whereHas('course', function ($q) {
            $q->edu();
        });
    }

    public static function scopeAbroad($query)
    {
        $query = $query->whereHas('course', function ($q) {
            $q->abroad();
        });
    }

    // Số phiếu đào tạo
    public function getCode(){
        $orderNumber = str_pad($this->order_number, 4, '0', STR_PAD_LEFT);
        $code = $this->course->code . '/' . $orderNumber;
       
        return $code;
    }

    public static function getTotalHoursOfSectionsStudied($sections)
    {
        $totalMinutes = 0;

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->start_at);
            $endAt = Carbon::parse($section->end_at);

            $durationInMinutes = $endAt->diffInMinutes($startAt);
            $totalMinutes += $durationInMinutes;
        }

        return floatval($totalMinutes);
    }

    public function scopeInSectionRange($query, $teacherId, $section_from, $section_to)
    {
        return $query
                    ->where('study_date', '<=', $section_to)
                    ->where('study_date', '>=', $section_from)
                    ->where(function ($subQuery) use ($teacherId) {
                        $subQuery->where('vn_teacher_id', $teacherId)
                                ->orWhere('foreign_teacher_id', $teacherId)
                                ->orWhere('tutor_id', $teacherId)
                                ->orWhere('assistant_id', $teacherId);
                    });
    }

    public static function newDefault()
    {
        $contact = new self();
        $contact->status = self::STATUS_ACTIVE;
        return $contact;
    }

    public static function importFromExcelSeeder($data)
    {
        try {
            $section = new Section();
            // $section->id = $data['id'];
            $section->course_id = $data['course_id'];
            $section->study_date =$data['study_date'];
            $section->start_at =$data['start_at'];
            $section->end_at =$data['end_at'];
            $section->status = self::STATUS_ACTIVE;
            $section->vn_teacher_id = $data['vn_teacher_id'];
            $section->foreign_teacher_id = $data['foreign_teacher_id'];
            $section->tutor_id = $data['tutor_id'];
            $section->assistant_id = $data['assistant_id'];
            $section->vn_teacher_from = $data['vn_teacher_from'];
            $section->vn_teacher_to = $data['vn_teacher_to'];
            $section->foreign_teacher_from = $data['foreign_teacher_from'];
            $section->foreign_teacher_to = $data['foreign_teacher_to'];
            $section->tutor_from = $data['tutor_from'];
            $section->tutor_to = $data['tutor_to'];
            $section->assistant_from = $data['assistant_from'];
            $section->assistant_to = $data['assistant_to'];
            $section->order_number = 1;
            $section->import_id = $data['import_id'];
            $section->save();
            echo("  \033[32mSUCCESS\033[0m: Tạo buổi học thành công cho lớp  - import_id: " . $section->course_id ."\n");
        } catch (\Exception $e) {
            echo ("\n  \033[31mERROR\033[0m  :".$e->getMessage());
        }
    }

    public function scopeToday($query)
    {
        return $query->whereDate('study_date', Carbon::today());
    } 

    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('course', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->byBranch($branch);
            }
        });
    }
    
    public function checkSectionCanRequestAbsent()
    {
        if (!$this->isUnstudied()) {
            return false;
        } elseif ($this->isStatusCancelled()) {
            return false;
        } elseif ($this->isLateCancelledTeacher()) {
            return false;
        } elseif ($this->isLateCancelledStudent()) {
            return false;
        } elseif ($this->isStopped()) {
            return false;
        } 

        return true;
    }

    public function getReasonRequestAbsent($studentId){
        return $this->studentSections()->where('student_id', $studentId)->first()->absence_request_reason;
    }

    public function scopeHasAbsentStudents($query)
    {
        return $query->whereHas('studentSections', function ($query) {
            $query->whereNotNull('absence_request_reason');
        });
    }

    public function scopeWithTeacherId($query, $teacherId)
    {
        return $query->where('vn_teacher_id', $teacherId)
                    ->orWhere('foreign_teacher_id', $teacherId)
                    ->orWhere('tutor_id', $teacherId)
                    ->orWhere('assistant_id', $teacherId);
    }

    // public static function scopeAlmostTimeSaveShift($query, $hours = 2) 
    // {
    //     $query = $query->where('section.end_at', '<',  \Carbon\Carbon::now()->subHours($hours));
    //     return $query;
    // }

    public static function scopeAlmostTimeSaveShift($query, $hours = 2) 
    {
        return $query->where('end_at', '<', Carbon::now()->subHours(24)->addHours($hours))
        ->where('end_at', '>', Carbon::now()->subHours(24))->whereNull('add_almost_time_save_shift');
    }

    public static function scopeOverTimeSaveShift($query) 
    {
        return $query->where('end_at', '<', Carbon::now()->subHours(24))->whereNull('add_over_time_save_shift');
    }
    
    public function getUser(){
        $teacherIds = [];
        $users = [];

        if (!is_null($this->vn_teacher_id)) {
            $teacherIds[] = $this->vn_teacher_id;
        }

        if (!is_null($this->foreign_teacher_id)) {
            $teacherIds[] = $this->foreign_teacher_id;
        }

        if (!is_null($this->tutor_id)) {
            $teacherIds[] = $this->tutor_id;
        }
        
        foreach ($teacherIds as $teacher){
            $accounts = \App\Models\Account::where('teacher_id',$teacher)->get();
        
            foreach ($accounts as $account) {
                $user = \App\Models\User::where('account_id', $account->id)->first();
               
                if ($user) {
                    $users[] = $user;
                }
            }
        }

        return $users;
    }

    public function outdatedApprovalNotified(){
        $this->add_almost_time_save_shift = Carbon::now();
        $this->save();
    }

    public function outdatedOverTimeNotified(){
        $this->add_over_time_save_shift = Carbon::now();
        $this->save();
    }

    public static function scopeUpcomingClass($query) 
    {
        return $query->where('end_at', '<=', Carbon::now()->addHours(24))->where('end_at', '>=', Carbon::now()->addHours(23))->whereNull('notification_upcoming_class');
    }

    public function getUserTeacherAndStudent(){
        $studentSections = [];
        $users = [];
        $users = $this->getUser();
        $studentSections = $this->studentSections()->get();
       
        foreach ($studentSections as $studentSection){
            $studentId = $studentSection->student()->get()->first()->id;

            if($studentId){
                $accounts = \App\Models\Account::where('student_id',$studentId)->get();
               
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

    public function outdatedNotificationUpcomingClass(){
        $this->notification_upcoming_class = Carbon::now();
        $this->save();
    }
    
    public function getTeacher(){
        $teacher = [];

        if (!is_null($this->vn_teacher_id)) {
            $teacher[] = Teacher::find($this->vn_teacher_id);
        }

        if (!is_null($this->foreign_teacher_id)) {
            $teacher[] = Teacher::find($this->foreign_teacher_id);
        }

        if (!is_null($this->tutor_id)) {
            $teacher[] = Teacher::find($this->tutor_id);
        }

        if (!is_null($this->assistant_id)) {
            $teacher[] = Teacher::find($this->assistant_id);
        }
        
        return $teacher;
    }

    public function getStudent(){
        $students = [];
        $studentSections = $this->studentSections()->get();
        
        foreach ($studentSections as $studentSection){
            $student = $studentSection->student()->get()->first();

            if($student){
                $students[] = $student;
            }
        }
       
        return $students;
    }

    public function calculateDurationSectionVN()
    {
        $startDateTime = Carbon::parse($this->vn_teacher_from);
        $endDateTime = Carbon::parse($this->vn_teacher_to);

        return $startDateTime->diffInMinutes($endDateTime);
    }

    public function calculateDurationSectionForeignTeacher()
    {
        $startDateTime = Carbon::parse($this->foreign_teacher_from);
        $endDateTime = Carbon::parse($this->foreign_teacher_to);

        return $startDateTime->diffInMinutes($endDateTime);
    }

    public function calculateDurationSectionTutor()
    {
        $startDateTime = Carbon::parse($this->tutor_from);
        $endDateTime = Carbon::parse($this->tutor_to);

        return $startDateTime->diffInMinutes($endDateTime);
    }

    public function calculateDurationSectionAssistant()
    {
        $startDateTime = Carbon::parse($this->assistant_from);
        $endDateTime = Carbon::parse($this->assistant_to);

        return $startDateTime->diffInMinutes($endDateTime);
    }

    public function getZoomUserId()
    {
        if (!$this->zoom_start_link) return null;

        $zoomUserId = ZoomMeeting::getZoomUserIdByStartLink($this->zoom_start_link);

        return $zoomUserId;
    }

    public function getMeetingId()
    {
        if (!$this->zoom_start_link) return null;

        $zoomMeetingId = null;
    
        if ($this->zoom_start_link) $zoomMeetingId = ZoomMeeting::getMeetingIdFromStartLink($this->zoom_start_link);
        elseif($this->zoom_join_link) $zoomMeetingId = ZoomMeeting::getMeetingIdFromJoinLink($this->zoom_join_link);
        else $zoomMeetingId = null;

        if (!$zoomMeetingId) return null;

        $payloadArray = ZoomMeeting::getPayloadArrayFromStartUrl($this->zoom_start_link);

        return $payloadArray['mnum'];
    }

    public function getSectionsWithZoomStarLinkStringOverlap($newStudyDate, $zoomStartLink=null)
    {
        $newStudyDate = Carbon::parse($newStudyDate);

        $startAt = Carbon::parse($this->start_at);
        $endAt = Carbon::parse($this->end_at);

        // Format startAt, endAt
        $startAt->setDate($newStudyDate->year, $newStudyDate->month, $newStudyDate->day);
        $endAt->setDate($newStudyDate->year, $newStudyDate->month, $newStudyDate->day);
        
        $overlapSections = Section::whereDate('study_date', $newStudyDate->toDateString())->where('id', '<>', $this->id)->where('zoom_start_link', ($zoomStartLink ?? $this->zoom_start_link))->get();

        return $overlapSections;
    }

    public function checkZoomLinkOverlapByPastLink($newStudyDate, $zoomStartLink=null): bool
    {
        $conflictSections = $this->getSectionsWithZoomStarLinkStringOverlap($newStudyDate, $zoomStartLink ?? null);

        if ($conflictSections->count()) {
            return true;
        }

        return false;
    }

    /**
     * Check wherther there is any section in the system that overlaps in terms of 
     * timing with the current section being taught and shares the same Zoom user.
     *
     * @param  string  $newStudyDate  The new study date in "Y-m-d" format.
     * @return bool  True if there is an overlap, false otherwise.
     */
    public function checkZoomLinkOverlapByZoomUser($newStudyDate, $zoomUserId=null): bool
    {
        // Convert new study date to Carbon instance
        $newStudyDate = Carbon::parse($newStudyDate);

        // Parse start_at and end_at as independent Carbon instances
        $startAt = Carbon::parse($this->start_at);
        $endAt = Carbon::parse($this->end_at);

        // Set date part of start_at and end_at to match $newStudyDate
        $startAt->setDate($newStudyDate->year, $newStudyDate->month, $newStudyDate->day);
        $endAt->setDate($newStudyDate->year, $newStudyDate->month, $newStudyDate->day);

        // Get all sections on the same new study date
        $sections = Section::whereDate('study_date', $newStudyDate->toDateString())->get();

        foreach ($sections as $section) {
            if ($section->id == $this->id) continue; // Skip the current section
            // Check overlap userId
            $tests[] = $zoomUserId;
            $tests2[] = $section->getZoomUserId();

            if (($zoomUserId ?? $this->getZoomUserId()) && $section->getZoomUserId() == ($zoomUserId ?? $this->getZoomUserId())) {
                // Parse section's start_at and end_at as independent Carbon instances
                $sectionStartAt = Carbon::parse($section->study_date)->toDateString() . ' ' . Carbon::parse($section->start_at)->toTimeString();
                $sectionEndAt = Carbon::parse($section->study_date)->toDateString() . ' ' . Carbon::parse($section->end_at)->toTimeString();

                if (($startAt->lt($sectionEndAt) && $endAt->gt($sectionStartAt)) ||
                    ($sectionStartAt->lt($endAt) && $sectionEndAt->gt($startAt))) {
                    return true;
                }
            }
        }

        return false;
    }

    public function checkForOverlapZoomScheduleWithNewDate($newStudyDate): bool
    {
        if (!$this->getZoomUserId()) { // If cannot get zoom user ID of this section
            return $this->checkZoomLinkOverlapByPastLink($newStudyDate);
        } else {
            return $this->checkZoomLinkOverlapByZoomUser($newStudyDate);
        }
    }

    public function generateZoomLinks($zoomUserId)
    {
        $meetingCreated = ZoomMeeting::createMeetingForUser(ZoomMeeting::getTestData(), $zoomUserId);
        $joinLink = $meetingCreated['data']['join_url'];

        // find param pwd index
        $pos = strpos($joinLink, '?pwd');
                
        // If pwd found, handle string
        if ($pos !== false) {
            $linkHandled = substr($joinLink, 0, $pos);
        } else {
            $linkHandled = $joinLink; // pwd not found => no password => return full url
        }

        $startLink = $meetingCreated['data']['start_url'];
        $joinLink = $linkHandled;
        $password = $meetingCreated['data']['password'];

        $this->zoom_start_link = $startLink;
        $this->zoom_join_link = $joinLink;
        $this->zoom_password = $password;

        $this->save();
    }

    public function pastZoomLinks($zoomStartLink, $zoomJoinLink, $zoomPassword)
    {
        $this->zoom_start_link = $zoomStartLink;
        $this->zoom_join_link = $zoomJoinLink;
        $this->zoom_password = $zoomPassword;

        $this->save();
    }

    public function createZoomLinksFromRequest($request) {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'study_date' => 'required',
        ]);

        $meetingCreated = ZoomMeeting::createMeetingForUser(ZoomMeeting::getTestData(), $request['zoom_user_id']);
        $joinLink = $meetingCreated['data']['join_url'];

        // find param pwd index
        $pos = strpos($joinLink, '?pwd');
                
        // If pwd found, handle string
        if ($pos !== false) {
            $linkHandled = substr($joinLink, 0, $pos);
        } else {
            $linkHandled = $joinLink; // pwd not found => no password => return full url
        }

        $startLink = $meetingCreated['data']['start_url'];
        $joinLink = $linkHandled;
        $password = $meetingCreated['data']['password'];

        $this->zoom_start_link = $startLink;
        $this->zoom_join_link = $joinLink;
        $this->zoom_password = $password;

        $validator->after(function ($validator) use ($request, $startLink) {
            if ($this->checkForOverlapZoomScheduleWithNewDate($request['study_date'])) {
                $validator->errors()->add('overlap_zoom_schedule_errors', 'Tài khoản zoom của user hiện tại đang bị trùng lịch vào ngày này, vui lòng chọn tài khoản zoom khác!');
            }
        });

        if ($validator->fails()) {
            return $validator->errors();
        };

        $this->save();

        return $validator->errors();
    }
    
    public static function scopeConflictWith($query, $startAt, $endAt)
    {
        $query->where(function ($q) use ($startAt, $endAt) {
            $date = date('Y-m-d', strtotime($startAt));

            $startTime = date('H:i:s', strtotime($startAt));
            $endTime = date('H:i:s', strtotime($endAt));

            $q->where(function ($q2) use ($date, $startTime, $endTime) {
                $q2->whereDate('start_at', $date)
                   ->whereTime('start_at', '<', $endTime)
                   ->whereTime('end_at', '>', $startTime);
            })->orWhere(function ($q2) use ($date, $startTime, $endTime) {
                $q2->whereDate('end_at', $date)
                   ->whereTime('start_at', '<', $endTime)
                   ->whereTime('end_at', '>', $startTime);
            });
        });
    }

    public static function getAvailableZoomUserFromArrayOfEvents($events)
    {
        // Get available ids to create zoom meeting for events that not overlap with the others section time in system 
        $availableZoomUserIds = ZoomMeeting::getAvailableZoomUserIdsBySections($events); 
        $zoomUsers = ZoomUser::all()->toArray();

        // From available ids array, get zoom users from that ids
        $availableZoomUsers = array_filter($zoomUsers, function ($user) use ($availableZoomUserIds) {
            return in_array($user['user_id'], $availableZoomUserIds);
        });

        return $availableZoomUsers;
    }

    public function scopeSameZoomRoom($query, $zoomLink)
    {
        $commonPart = substr($zoomLink, 0, strpos($zoomLink, "?zak="));

        $query->where('zoom_start_link', 'like', $commonPart . "%");
    }

    public function getSectionWithSameZoomRoom()
    {
        if (!$this->zoom_start_link) return null;
        $commonPart = substr($this->start_zoom_link, 0, strpos($this->start_zoom_link, "?zak="));

        return self::whereNot('id', $this->id)
                    ->where('zoom_start_link', 'like', $commonPart . "%")->get();
    }

    public function scopeOutDate($query)
    {
        $query->where('study_date', '<', Carbon::now());
    }

    /**
     * Check is outdate
     */
    public function isOutDate()
    {
        $studyTime = Carbon::parse($this->study_date);
        $now = Carbon::now();

        return $studyTime < $now;
    }

    public function caculateVnTeacherMinutes()
    {
        if (!$this->vn_teacher_id 
         || $this->vn_teacher_from == '' 
         || $this->vn_teacher_to == '' 
         || !$this->vn_teacher_from 
         || !$this->vn_teacher_to) return 0;

        $fromTime = Carbon::createFromFormat('H:i', $this->vn_teacher_from);
        $toTime = Carbon::createFromFormat('H:i', $this->vn_teacher_to);

        return $fromTime->diffInMInutes($toTime);
    }

    public function caculateForeignTeacherMinutes()
    {
        if (!$this->foreign_teacher_id 
         || $this->foreign_teacher_from == '' 
         || $this->foreign_teacher_to == '' 
         || !$this->foreign_teacher_from 
         || !$this->foreign_teacher_to) return 0;

        $fromTime = Carbon::createFromFormat('H:i', $this->foreign_teacher_from);
        $toTime = Carbon::createFromFormat('H:i', $this->foreign_teacher_to);

        return $fromTime->diffInMInutes($toTime);
    }

    public function caculateTutorMinutes()
    {
        if (!$this->tutor_id 
         || $this->tutor_from == '' 
         || $this->tutor_to == '' 
         || !$this->tutor_from 
         || !$this->tutor_to) return 0;

        $fromTime = Carbon::createFromFormat('H:i', $this->tutor_from);
        $toTime = Carbon::createFromFormat('H:i', $this->tutor_to);

        return $fromTime->diffInMInutes($toTime);
    }

    public function caculateAssistantMinutes()
    {
        if (!$this->assistant_id 
         || $this->assistant_from == '' 
         || $this->assistant_to == '' 
         || !$this->assistant_from 
         || !$this->assistant_to) return 0;

        $fromTime = Carbon::createFromFormat('H:i', $this->assistant_from);
        $toTime = Carbon::createFromFormat('H:i', $this->assistant_to);

        return $fromTime->diffInMInutes($toTime);
    }

    // public static function countStudentSections() {
    //     $total = 0;
    //     $course_ids = Section::pluck('course_id')->unique(); // Không cần dùng all() vì pluck đã trả về collection
    //     foreach ($course_ids as $course_id) {
    //         $courseSectionCount = Section::where('course_id', $course_id)->count();
    //         $studentCourseCount = CourseStudent::where('course_id', $course_id)->count();
    //         $total += $courseSectionCount * $studentCourseCount;
    //     }
    //     return $total;
    // }

    public function getZoomMeetingHostInformation()
    {
        $zoomStartLink = $this->zoom_start_link;
        if (!$zoomStartLink) return null;

        $zoomUserId = ZoomMeeting::getZoomUserIdByStartLink($zoomStartLink);
        if (!$zoomUserId) return null;
        
        return ZoomMeeting::getUserInfo($zoomUserId);
    }

    public function canShowZoomLinkInformations()
    {
        return $this->zoom_start_link;
    }

    public function scopeOverlapVnTimes($query, $section)
    {   
        $query->where('study_date', $section->study_date)
              ->where(function($q) use ($section) {
                    $q->where(function($q2) use ($section) {
                        $q2->where('vn_teacher_from', '<', $section->vn_teacher_from)
                        ->where('vn_teacher_to', '>', $section->vn_teacher_from);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('vn_teacher_from', '>=', $section->vn_teacher_from)
                        ->where('vn_teacher_to', '<=', $section->vn_teacher_to);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('vn_teacher_from', '<', $section->vn_teacher_to)
                        ->where('vn_teacher_to', '>', $section->vn_teacher_to);
                    });
              });
    }

    public function scopeOverlapForeignTimes($query, $section)
    {   
        $query->where('study_date', $section->study_date)
              ->where(function($q) use ($section) {
                    $q->where(function($q2) use ($section) {
                        $q2->where('foreign_teacher_from', '<', $section->foreign_teacher_from)
                        ->where('foreign_teacher_to', '>', $section->foreign_teacher_from);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('foreign_teacher_from', '>=', $section->foreign_teacher_from)
                        ->where('foreign_teacher_to', '<=', $section->foreign_teacher_to);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('foreign_teacher_from', '<', $section->foreign_teacher_to)
                        ->where('foreign_teacher_to', '>', $section->foreign_teacher_to);
                    });
              });
    }

    public function scopeOverlapTutorTimes($query, $section)
    {   
        $query->where('study_date', $section->study_date)
              ->where(function($q) use ($section) {
                    $q->where(function($q2) use ($section) {
                        $q2->where('tutor_from', '<', $section->tutor_from)
                        ->where('tutor_to', '>', $section->tutor_from);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('tutor_from', '>=', $section->tutor_from)
                        ->where('tutor_to', '<=', $section->tutor_to);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('tutor_from', '<', $section->tutor_to)
                        ->where('tutor_to', '>', $section->tutor_to);
                    });
              });
    }

    public function scopeOverlapAssistantTimes($query, $section)
    {   
        $query->where('study_date', $section->study_date)
              ->where(function($q) use ($section) {
                    $q->where(function($q2) use ($section) {
                        $q2->where('assistant_from', '<', $section->assistant_from)
                        ->where('assistant_to', '>', $section->assistant_from);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('assistant_from', '>=', $section->assistant_from)
                        ->where('assistant_to', '<=', $section->assistant_to);
                    })->orWhere(function($q2) use ($section) {
                        $q2->where('assistant_from', '<', $section->assistant_to)
                        ->where('assistant_to', '>', $section->assistant_to);
                    });
              });
    }
}
