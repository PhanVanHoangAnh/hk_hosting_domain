<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use App\Events\AttendanceProcessed;

class StudentSection extends Model
{
    use HasFactory;

    // CÓ THAM GIA, DỰ ĐỊNH THAM GIA
    public const STATUS_NEW = 'status_new';

    // học bù, không trừ giờ trên hợp đồng
    public const STATUS_STUDY_PARTNER = 'study_partner';

    // đã học
    public const STATUS_PRESENT = 'present';
    

    // KHÔNG THAM GIA, HỦY, DỪNG, KHÔNG CÓ DỰ ĐỊNH HỌC
    // bảo lưu
    public const STATUS_RESERVE = 'reserve';
    public const STATUS_CANCELLED = 'cancelled';

    // hoàn phí
    public const STATUS_REFUND = 'refund';
    public const STATUS_TRANSFERRED = 'transferred';

    // dừng lớp : khi lớp dùng thì toàn bộ student section sẽ được đánh dấu là dừng.
    public const STATUS_STOPPED = 'stopped';

    // vắng có phép, vẩn trừ giờ, nhưng có chức năng là học bù.
    public const STATUS_EXCUSED_ABSENCE = 'excused_absence';

    // vắng không phép
    public const STATUS_UNEXCUSED_ABSENCE = 'unexcused_absence';
    //thoát lớp
    public const STATUS_EXIT = 'exit';
    protected $table = 'student_section';
    protected $fillable = [
        'student_id',
        'section_id',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function scopePresent($query)
    {
        $query = $query->where('status', self::STATUS_PRESENT);
    }

    public static function scopeNew($query)
    {
        $query = $query->where('status', self::STATUS_NEW);
    }

    public static function scopeReserve($query)
    {
        $query->where('status', self::STATUS_RESERVE);
    }

    public function scopeAddStudyPartner($query, $studentId, $section_id, $sectionStudentId)
    {
        DB::beginTransaction();
        try {
            $query->create([
                'section_id' => $section_id,
                'student_id' => $studentId,
                'status' => self::STATUS_STUDY_PARTNER,
            ]);

            self::where('section_id', $sectionStudentId)
                ->where('student_id', $studentId)
                ->delete();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    public function updateAttendanceSection($request, $id)
    {
        $attendanceData = json_decode($request->input('attendance'), true);
      
        foreach ($attendanceData as $key => $data) {
            $studentId = $data['studentId'];
            $sectionId = $data['sectionId'];
            $status = $data['status'];
            
            $startAt = $data['start_at'] ?? null; 
            $endAt = $data['end_at'] ?? null;
        if($studentId){
            $studentSectionUpdate = StudentSection::where('student_id', $studentId)
            ->where('section_id', $sectionId)->first();
            
            $studentSectionUpdate->status = $status;
            $studentSectionUpdate->start_at = $startAt;
            $studentSectionUpdate->end_at = $endAt;
            
            $studentSectionUpdate->save();

            if (!is_null($studentSectionUpdate->get()) && $studentSectionUpdate->get()->count() > 0) {
                AttendanceProcessed::dispatch($studentSectionUpdate->first());
            }
        }
           
        }
    }

    public static function scopeEndAtIsOver($query)
    {
        $query = $query->whereHas('section', function ($q) {
            $q->where('end_at', '>', Carbon::now());
        });
    }

    public static function checkPresentStatuses()
    {
        $studentSections = self::new()
            ->endAtIsOver()
            ->get();

        // update status to present
        // Nghiệp vụ: qua thời gian của buổi học rồi thì mặc định là đã học
        foreach ($studentSections as $studentSection) {
            $studentSection->setStatusPresent();
        }
    }

    public function setStatusPresent()
    {
        $this->status = self::STATUS_PRESENT;
        $this->save();
    }

    public function setStatusRefund()
    {
        $this->status = self::STATUS_REFUND;
        $this->save();
    }

    public function setStatusTransferred()
    {
        $this->status = self::STATUS_TRANSFERRED;
        $this->save();
    }

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'student_id', 'student_id');
    }

    protected function getSections($studentId, $courseId)
    {
        return $this->where('student_id', $studentId)
            ->whereHas('courseStudent', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId);
            })
            ->whereHas('section', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId)->general();
            })
            ->whereNotIn('status', [self::STATUS_RESERVE, self::STATUS_REFUND])
            ->get();
    }

    protected function getSectionsPresent($studentId, $courseId)
    {
        return $this->where('student_id', $studentId)
            ->whereHas('courseStudent', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId);
            })
            ->whereHas('section', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId)->general();
            })
            ->whereIn('status', [self::STATUS_PRESENT, self::STATUS_EXCUSED_ABSENCE, self::STATUS_UNEXCUSED_ABSENCE])
            ->get();
    }

    public static function getSectionsRefund($studentId, $courseId, $refundDate)
    {
        return self::where('student_id', $studentId)
            ->whereHas('courseStudent', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId);
            })
            ->whereHas('section', function ($subquery) use ($courseId, $refundDate) {
                $subquery->where('course_id', $courseId)->general()
                    ->where('study_date', '>', $refundDate);
            })
            ->where('status', self::STATUS_NEW)
            ->get();
    }

    public function scopeCalculateTotalHours($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSections($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->start_at);
            $endAt = Carbon::parse($section->section->end_at);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursStudied($query, $studentId, $courseId)
    {
        $sumMinutes = 0;
        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->start_at);
            $endAt = Carbon::parse($section->section->end_at);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }

        return round($sumMinutes / 60, 2);
    }
    public static function calculateTotalHoursStudiedWithCondition($studentId, $courseId, $updatedAtFrom, $updatedAtTo = null)
    {
        $sumMinutes = 0;
        $sumMinutesVnTeacher = 0;
        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesAssistant = 0;
        $sections = self::getPresentSections($studentId, $courseId);

        if ($updatedAtFrom && $updatedAtTo) {
            $sections = $sections->whereBetween('section.study_date', [Carbon::parse($updatedAtFrom), Carbon::parse($updatedAtTo)]);
            
        } elseif ($updatedAtFrom) {
            $sections = $sections->where('section.study_date', '<', Carbon::parse($updatedAtFrom));
        }
        foreach ($sections as $section) {
            
            $startAt = Carbon::parse($section->section->start_at);
            $endAt = Carbon::parse($section->section->end_at);
            $minutes = $endAt->diffInMinutes($startAt);

            // Calculate time for vn_teacher
            if ($section->section->vn_teacher_from && $section->section->vn_teacher_to) {
                $vnTeacherFrom = Carbon::parse($section->section->vn_teacher_from);
                $vnTeacherTo = Carbon::parse($section->section->vn_teacher_to);
                $minutesVnTeacher = $vnTeacherTo->diffInMinutes($vnTeacherFrom);
                $sumMinutesVnTeacher += $minutesVnTeacher;
            }
            // Calculate time for foreign_teacher
            if ($section->section->foreign_teacher_from && $section->section->foreign_teacher_to) {
                $foreignTeacherFrom = Carbon::parse($section->section->foreign_teacher_from);
                $foreignTeacherTo = Carbon::parse($section->section->foreign_teacher_to);
                $minutesForeignTeacher = $foreignTeacherTo->diffInMinutes($foreignTeacherFrom);
                $sumMinutesForeignTeacher += $minutesForeignTeacher;
            }

            // Calculate time for tutor
            if ($section->section->tutor_from && $section->section->tutor_to) {
                $tutorFrom = Carbon::parse($section->section->tutor_from);
                $tutorTo = Carbon::parse($section->section->tutor_to);
                $minutesTutor = $tutorTo->diffInMinutes($tutorFrom);
                $sumMinutesTutor += $minutesTutor;
            }

            // Calculate time for assistant
            if ($section->section->assistant_from && $section->section->assistant_to) {
                $assistantFrom = Carbon::parse($section->section->assistant_from);
                $assistantTo = Carbon::parse($section->section->assistant_to);
                $minutesAssistant = $assistantTo->diffInMinutes($assistantFrom);
                $sumMinutesAssistant += $minutesAssistant;
            }
            $sumMinutes += $minutes;
            
        }
        

        return [
            'sum_minutes' => $sumMinutes,
            'vn_teacher_minutes' => $sumMinutesVnTeacher,
            'foreign_teacher_minutes' => $sumMinutesForeignTeacher,
            'tutor_minutes' => $sumMinutesTutor,
            'assistant_minutes' => $sumMinutesAssistant,
        ];

    }
    public static function getPresentSections($studentId, $courseId)
    {
        return self::where('student_id', $studentId)
            ->whereHas('courseStudent', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId);
            })
            ->whereHas('section', function ($subquery) use ($courseId) {
                $subquery->where('course_id', $courseId)->general();
            })
            ->whereIn('status', [self::STATUS_PRESENT, self::STATUS_EXCUSED_ABSENCE, self::STATUS_UNEXCUSED_ABSENCE])
            ->get();
    }


    public function scopeCalculateTotalHoursRefund($query, $studentId, $courseId, $refundDate)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsRefund($studentId, $courseId, $refundDate);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->start_at);
            $endAt = Carbon::parse($section->section->end_at);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursOfvnTeacher($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSections($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->vn_teacher_from);
            $endAt = Carbon::parse($section->section->vn_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursOfvnTeacherPresent($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->vn_teacher_from);
            $endAt = Carbon::parse($section->section->vn_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursOfForeignTeacher($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSections($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->foreign_teacher_from);
            $endAt = Carbon::parse($section->section->foreign_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursOfForeignTeacherPresent($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->foreign_teacher_from);
            $endAt = Carbon::parse($section->section->foreign_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursOfTutor($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSections($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->tutor_from);
            $endAt = Carbon::parse($section->section->tutor_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCalculateTotalHoursOfTutorPresent($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->tutor_from);
            $endAt = Carbon::parse($section->section->tutor_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function scopeCountByStatusAndDate($query, $status)
    {
        return $query
            ->where('status', $status)
            ->whereHas('section', function ($subQuery) {
                $subQuery->whereMonth('study_date', '=', now()->month)
                    ->where('study_date', '>=', now()->startOfMonth());
            });
    }

    public function setSkipped()
    {
        $this->status = self::STATUS_RESERVE;
        $this->save();
    }

    public static function calculateTotalHoursStudiedForOrderItem($orderItem, $request)
    {
        return $orderItem->sum(function ($courseStudent) use ($request) {
            return self::calculateTotalHoursStudied($request->student_id, $request->course_id);
        });
    }

    public function calculateTotalHoursStudiedForOrderItemOfVnTeacher($orderItem, $refundRequest)
    {
        return collect($orderItem)->sum(function ($courseStudent) use ($refundRequest) {
            return $this->calculateTotalHoursOfvnTeacherPresent($courseStudent->student_id, $courseStudent->course_id, $refundRequest);
        });
    }

    public function calculateTotalHoursStudiedForOrderItemOfForeignTeacher($orderItem, $refundRequest)
    {
        return collect($orderItem)->sum(function ($courseStudent) use ($refundRequest) {
            return $this->calculateTotalHoursOfForeignTeacherPresent($courseStudent->student_id, $courseStudent->course_id, $refundRequest);
        });
    }

    public function calculateTotalHoursStudiedForOrderItemOfTutor($orderItem, $refundRequest)
    {
        return collect($orderItem)->sum(function ($courseStudent) use ($refundRequest) {
            return $this->calculateTotalHoursOfTutorPresent($courseStudent->student_id, $courseStudent->course_id, $refundRequest);
        });
    }

    public static function calculateTotalHoursStudiedForCourseStudents($courseStudents, $request)
    {
        $courseStudentList = $courseStudents->filter(function ($courseStudent) use ($request) {
            // Filter records based on order_item_id
            return $courseStudent->orderItems->subject_id === $request->course->subject_id;
        });

        $totalHours = 0;
        $totalHours = self::calculateTotalHoursStudiedForOrderItem($courseStudentList, $request);

        return $totalHours;
    }

    public function calculateTotalHoursStudiedForCourseStudentsOfTutor($courseStudents, $refundRequest)
    {
        $totalHours = 0;
        $uniqueStudentIds = [];

        $courseStudentList = $courseStudents
            ->groupBy(function ($courseStudent) {
                return optional($courseStudent->course->subject)->id;
            })
            ->first();

        if ($courseStudentList) {
            foreach ($courseStudentList as $courseStudent) {
                $currentStudentId = $courseStudent->student_id;

                if (!in_array($currentStudentId, $uniqueStudentIds)) {
                    $totalHours += $this->calculateTotalHoursStudiedForOrderItemOfTutor([$courseStudent], $refundRequest);
                    $uniqueStudentIds[] = $currentStudentId;
                }
            }
        }

        return $totalHours;
    }

    public function calculateTotalHoursStudiedForCourseStudentsOfVnTeacher($courseStudents, $refundRequest)
    {
        $totalHours = 0;
        $uniqueStudentIds = [];

        $courseStudentList = $courseStudents
            ->groupBy(function ($courseStudent) {
                return optional($courseStudent->course->subject)->id;
            })
            ->first();

        if ($courseStudentList) {
            foreach ($courseStudentList as $courseStudent) {
                $currentStudentId = $courseStudent->student_id;

                if (!in_array($currentStudentId, $uniqueStudentIds)) {
                    $totalHours += $this->calculateTotalHoursStudiedForOrderItemOfVnTeacher([$courseStudent], $refundRequest);
                    $uniqueStudentIds[] = $currentStudentId;
                }
            }
        }

        return $totalHours;
    }

    public function calculateTotalHoursStudiedForCourseStudentsOfForeignTeacher($courseStudents, $refundRequest)
    {
        $totalHours = 0;
        $uniqueStudentIds = [];

        $courseStudentList = $courseStudents
            ->groupBy(function ($courseStudent) {
                return optional($courseStudent->course->subject)->id;
            })
            ->first();

        if ($courseStudentList) {
            foreach ($courseStudentList as $courseStudent) {
                $currentStudentId = $courseStudent->student_id;

                if (!in_array($currentStudentId, $uniqueStudentIds)) {
                    $totalHours += $this->calculateTotalHoursStudiedForOrderItemOfForeignTeacher([$courseStudent], $refundRequest);
                    $uniqueStudentIds[] = $currentStudentId;
                }
            }
        }

        return $totalHours;
    }

    public function scopeGetSectionRefund($query, $refundDate)
    {
        return $query->where('study_date', '>', $refundDate);
    }

    public function getAttendance($section)
    {
        return self::where('section_id', '=', $section->id)->where('status', '!=', self::STATUS_RESERVE)->where('status', '!=', self::STATUS_REFUND);
    }

    public function studyHours($contact, $sections)
    {
        $sectionInOrderItems = [];

        foreach ($sections as $section) {

            $result = $this->where('student_id', $contact->id)
                ->where('section_id', $section['id'])
                ->whereIn('status', [self::STATUS_NEW, self::STATUS_STUDY_PARTNER, self::STATUS_PRESENT, self::STATUS_EXCUSED_ABSENCE, self::STATUS_UNEXCUSED_ABSENCE, Section::LATE_CANCELLED_STUDENT]);
            if ($result->exists()) {
                $sectionInOrderItems[] = $section;
            }
        }

        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesVNTeacher = 0;
        foreach ($sectionInOrderItems as $sectionInOrderItem) {
            $foreignTeacherStartAt = Carbon::parse($sectionInOrderItem['foreign_teacher_from']);
            $foreignTeacherEndAt = Carbon::parse($sectionInOrderItem['foreign_teacher_to']);
            $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
            $sumMinutesForeignTeacher += $minutesForeignTeacher;

            $tutorStartAt = Carbon::parse($sectionInOrderItem['tutor_from']);
            $tutorEndAt = Carbon::parse($sectionInOrderItem['tutor_to']);
            $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
            $sumMinutesTutor += $minutesTutor;

            $VNTeacherStartAt = Carbon::parse($sectionInOrderItem['vn_teacher_from']);
            $VnTeacherEndAt = Carbon::parse($sectionInOrderItem['vn_teacher_to']);
            $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
            $sumMinutesVNTeacher += $minutesVNTeacher;
        }

        return [
            'sumMinutesForeignTeacher' => $sumMinutesForeignTeacher,
            'sumMinutesTutor' => $sumMinutesTutor,
            'sumMinutesVNTeacher' => $sumMinutesVNTeacher,
        ];
    }

    public function setReserveCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    public function scopeEndAtForCourse($query, $studentId, $courseId)
    {
        $studentSections = $query
            ->where('student_id', $studentId)
            ->whereHas('section', function ($q) use ($courseId) {
                $q->where('course_id', $courseId)
                    ->whereNotNull('end_at');
            })
            ->whereIn('student_section.status', [self::STATUS_NEW, self::STATUS_PRESENT, self::STATUS_STUDY_PARTNER])
            ->get();

        if ($studentSections->isEmpty()) {
            return 'Chưa có buổi học';
        }

        $startAt = $studentSections->max(function ($studentSection) {
            return $studentSection->section->end_at;
        });

        return \Carbon\Carbon::parse($startAt)->format('d/m/Y');
    }

    public function setExit()
    {
        $this->status = self::STATUS_EXIT;
        $this->save();
    }

    //Tính tổng giờ đã dạy của giáo viên việt nam
    public function totalHoursStudiedForCourseStudentsOfVnTeacher($courseStudents)
    {
        $totalHours = 0;
        $uniqueStudentIds = [];

        $courseStudentList = $courseStudents
            ->groupBy(function ($courseStudent) {
                return optional($courseStudent->course->subject)->id;
            })
            ->first();

        if ($courseStudentList) {
            foreach ($courseStudentList as $courseStudent) {
                $currentStudentId = $courseStudent->student_id;

                if (!in_array($currentStudentId, $uniqueStudentIds)) {
                    $totalHours += $this->totalHoursStudiedForOrderItemOfVnTeacher([$courseStudent]);
                    $uniqueStudentIds[] = $currentStudentId;
                }
            }
        }

        return $totalHours;
    }

    public function totalHoursStudiedForOrderItemOfVnTeacher($orderItem)
    {
        return collect($orderItem)->sum(function ($courseStudent) {
            return $this->totalHoursOfvnTeacherPresent($courseStudent->student_id, $courseStudent->course_id);
        });
    }

    public function scopeTotalHoursOfvnTeacherPresent($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->vn_teacher_from);
            $endAt = Carbon::parse($section->section->vn_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    //Tính tổng giờ đã dạy của giáo viên nước ngoài
    public function   totalHoursStudiedForCourseStudentsOfForeignTeacher($courseStudents)
    {
        $totalHours = 0;
        $uniqueStudentIds = [];

        $courseStudentList = $courseStudents
            ->groupBy(function ($courseStudent) {
                return optional($courseStudent->course->subject)->id;
            })
            ->first();

        if ($courseStudentList) {
            foreach ($courseStudentList as $courseStudent) {
                $currentStudentId = $courseStudent->student_id;

                if (!in_array($currentStudentId, $uniqueStudentIds)) {
                    $totalHours += $this->totalHoursStudiedForOrderItemOfForeignTeacher([$courseStudent]);
                    $uniqueStudentIds[] = $currentStudentId;
                }
            }
        }

        return $totalHours;
    }

    public function totalHoursStudiedForOrderItemOfForeignTeacher($orderItem)
    {
        return collect($orderItem)->sum(function ($courseStudent) {
            return $this->totalHoursOfForeignTeacherPresent($courseStudent->student_id, $courseStudent->course_id);
        });
    }

    public function scopeTotalHoursOfForeignTeacherPresent($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->foreign_teacher_from);
            $endAt = Carbon::parse($section->section->foreign_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    //Tính tổng giờ đã dạy của trợ giảng
    public function totalHoursStudiedForCourseStudentsOfTutorTeacher($courseStudents)
    {
        $totalHours = 0;
        $uniqueStudentIds = [];

        $courseStudentList = $courseStudents
            ->groupBy(function ($courseStudent) {
                return optional($courseStudent->course->subject)->id;
            })
            ->first();

        if ($courseStudentList) {
            foreach ($courseStudentList as $courseStudent) {
                $currentStudentId = $courseStudent->student_id;

                if (!in_array($currentStudentId, $uniqueStudentIds)) {
                    $totalHours += $this->totalHoursStudiedForOrderItemOfTutorTeacher([$courseStudent]);
                    $uniqueStudentIds[] = $currentStudentId;
                }
            }
        }

        return $totalHours;
    }
    
    public function totalHoursStudiedForOrderItemOfTutorTeacher($orderItem)
    {
        return collect($orderItem)->sum(function ($courseStudent) {
            return $this->totalHoursOfTutorTeacherPresent($courseStudent->student_id, $courseStudent->course_id);
        });
    }

    public function scopeTotalHoursOfTutorTeacherPresent($query, $studentId, $courseId)
    {
        $sumMinutes = 0;

        $sections = $this->getSectionsPresent($studentId, $courseId);

        foreach ($sections as $section) {
            $startAt = Carbon::parse($section->section->tutor_teacher_from);
            $endAt = Carbon::parse($section->section->tutor_teacher_to);

            $minutes = $endAt->diffInMinutes($startAt);

            $sumMinutes += $minutes;
        }
        return round($sumMinutes / 60, 2);
    }

    public function updateStatusSection($checkShift)
    {
        $this->status = $checkShift;
        $this->save();
    }

    public function scopeFindByOrderItemAndStudent($query, $orderItemId, $studentId)
    {
        return $query->whereHas('courseStudent', function ($query) use ($orderItemId, $studentId) {
            $query->where('order_item_id', $orderItemId)
                ->where('student_id', $studentId);
        });
    }

    public function calculateValueSectionByOrderItem($orderItemId, $teacherType)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);

        switch ($teacherType) {
            case 'tutor':
                $priceHour = $orderItem->getPriceTutorHour();
                $sectionMinutes = $this->section->calculateInMinutesTutorInSection() / 60;
                break;
            case 'foreign':
                $priceHour = $orderItem->getPriceForeignTeacherHour();
                $sectionMinutes = $this->section->calculateInMinutesForeignTeacherInSection() / 60;
                break;
            case 'vn':
                $priceHour = $orderItem->getPriceVnTeacherHour();
                $sectionMinutes = $this->section->calculateInMinutesVnTeacherInSection() / 60;
                break;
            default:
                return 0;
        }

        return $priceHour * $sectionMinutes;
    }

    public function studyHoursByDay($contact, $sections, $end_at)
    {
        $sectionInOrderItems = [];

        foreach ($sections as $section) {

            $result = $this->whereHas('section', function ($query) use ($section, $end_at) {
                                $query->where('id', $section['id'])
                                    ->where('study_date', '<=', $end_at);
                            })
                            ->where('student_id', $contact->id)
                            ->where('section_id', $section['id'])
                            ->whereIn('status', [  self::STATUS_PRESENT, self::STATUS_EXCUSED_ABSENCE, self::STATUS_UNEXCUSED_ABSENCE, Section::LATE_CANCELLED_STUDENT]);
            if ($result->exists()) {
                $sectionInOrderItems[] = $section;
            }
        }

        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesVNTeacher = 0;
        

        foreach ($sectionInOrderItems as $sectionInOrderItem) {
            $foreignTeacherStartAt = Carbon::parse($sectionInOrderItem['foreign_teacher_from']);
            $foreignTeacherEndAt = Carbon::parse($sectionInOrderItem['foreign_teacher_to']);
            $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
            $sumMinutesForeignTeacher += $minutesForeignTeacher;

            $tutorStartAt = Carbon::parse($sectionInOrderItem['tutor_from']);
            $tutorEndAt = Carbon::parse($sectionInOrderItem['tutor_to']);
            $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
            $sumMinutesTutor += $minutesTutor;

            $VNTeacherStartAt = Carbon::parse($sectionInOrderItem['vn_teacher_from']);
            $VnTeacherEndAt = Carbon::parse($sectionInOrderItem['vn_teacher_to']);
            $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
            $sumMinutesVNTeacher += $minutesVNTeacher;
        }
        
        $sumMinutesTotal = $sumMinutesForeignTeacher + $sumMinutesTutor + $sumMinutesVNTeacher;
       
        return [
            'sumMinutesForeignTeacher' => $sumMinutesForeignTeacher,
            'sumMinutesTutor' => $sumMinutesTutor,
            'sumMinutesVNTeacher' => $sumMinutesVNTeacher,
            'sumMinutesTotal'=>$sumMinutesTotal,
        ];
    }
    public function studyHoursByTrongKy($contact, $sections, $updated_at_from, $updated_at_to)
    {
        $sectionInOrderItems = [];

        foreach ($sections as $section) {

            $result = $this->whereHas('section', function ($query) use ($section, $updated_at_to,$updated_at_from) {
                                $query->where('id', $section['id'])
                                    ->where('study_date', '<=', $updated_at_to)
                                    ->where('study_date', '>=', $updated_at_from);
                            })
                            ->where('student_id', $contact->id)
                            ->where('section_id', $section['id'])
                            ->whereIn('status', [  self::STATUS_PRESENT, self::STATUS_EXCUSED_ABSENCE, self::STATUS_UNEXCUSED_ABSENCE, Section::LATE_CANCELLED_STUDENT]);
            if ($result->exists()) {
                $sectionInOrderItems[] = $section;
            }
        }

        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesVNTeacher = 0;
        

        foreach ($sectionInOrderItems as $sectionInOrderItem) {
            $foreignTeacherStartAt = Carbon::parse($sectionInOrderItem['foreign_teacher_from']);
            $foreignTeacherEndAt = Carbon::parse($sectionInOrderItem['foreign_teacher_to']);
            $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
            $sumMinutesForeignTeacher += $minutesForeignTeacher;

            $tutorStartAt = Carbon::parse($sectionInOrderItem['tutor_from']);
            $tutorEndAt = Carbon::parse($sectionInOrderItem['tutor_to']);
            $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
            $sumMinutesTutor += $minutesTutor;

            $VNTeacherStartAt = Carbon::parse($sectionInOrderItem['vn_teacher_from']);
            $VnTeacherEndAt = Carbon::parse($sectionInOrderItem['vn_teacher_to']);
            $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
            $sumMinutesVNTeacher += $minutesVNTeacher;
        }
        
        $sumMinutesTotal = $sumMinutesForeignTeacher + $sumMinutesTutor + $sumMinutesVNTeacher;
       
        return [
            'sumMinutesForeignTeacher' => $sumMinutesForeignTeacher,
            'sumMinutesTutor' => $sumMinutesTutor,
            'sumMinutesVNTeacher' => $sumMinutesVNTeacher,
            'sumMinutesTotal'=>$sumMinutesTotal,
        ];
    }
    public function studyHoursByEndDay($contact, $sections, $end_at)
    {
        $sectionInOrderItems = [];

        foreach ($sections as $section) {

            $result = $this->whereHas('section', function ($query) use ($section, $end_at) {
                                $query->where('id', $section['id'])
                                    ->where('study_date', '>', $end_at);
                            })
                            ->where('student_id', $contact->id)
                            ->where('section_id', $section['id'])
                            ->whereIn('status', [  self::STATUS_PRESENT, self::STATUS_EXCUSED_ABSENCE, self::STATUS_UNEXCUSED_ABSENCE, Section::LATE_CANCELLED_STUDENT]);
            if ($result->exists()) {
                $sectionInOrderItems[] = $section;
            }
        }

        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesVNTeacher = 0;
        

        foreach ($sectionInOrderItems as $sectionInOrderItem) {
            $foreignTeacherStartAt = Carbon::parse($sectionInOrderItem['foreign_teacher_from']);
            $foreignTeacherEndAt = Carbon::parse($sectionInOrderItem['foreign_teacher_to']);
            $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
            $sumMinutesForeignTeacher += $minutesForeignTeacher;

            $tutorStartAt = Carbon::parse($sectionInOrderItem['tutor_from']);
            $tutorEndAt = Carbon::parse($sectionInOrderItem['tutor_to']);
            $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
            $sumMinutesTutor += $minutesTutor;

            $VNTeacherStartAt = Carbon::parse($sectionInOrderItem['vn_teacher_from']);
            $VnTeacherEndAt = Carbon::parse($sectionInOrderItem['vn_teacher_to']);
            $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
            $sumMinutesVNTeacher += $minutesVNTeacher;
        }
        
        $sumMinutesTotal = $sumMinutesForeignTeacher + $sumMinutesTutor + $sumMinutesVNTeacher;
       
        return [
            'sumMinutesForeignTeacher' => $sumMinutesForeignTeacher,
            'sumMinutesTutor' => $sumMinutesTutor,
            'sumMinutesVNTeacher' => $sumMinutesVNTeacher,
            'sumMinutesTotal'=>$sumMinutesTotal,
        ];
    }
    public static function importFromExcelSeeder($data)
    {
        
        $studentSection = new StudentSection();
        $studentSection->section_id = $data['section_id'];
        // $studentSection->student_id = $data['student_id'];
        $studentSection->student_id = $data['student_id'];
        $studentSection->status =self::STATUS_NEW;
       

        $studentSection->save();
    }

    public function getCourseNameOfSection()
    {
        return $this->section->getCode();
    }

    public function requestAbsent($request)
    {
        $validator = Validator::make($request->all(), [
            'absence_request_reason' => 'required',
           
        ]);
        $this->absence_request_reason = $request->absence_request_reason;
        $this->absence_request_at = Carbon::now();
        

        if ($validator->fails()) {
            return $validator->errors();
        }
    
        $this->save();
    
        return $validator->errors();
    }
    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('section', function ($q1) use ($branch) {
            $q1->byBranch($branch);
        });
    }

    public static function getLessonsByStudentId($studentId)
    {
        return self::where('student_id', $studentId)
            ->where('status', '!=', self::STATUS_CANCELLED) // Lọc các buổi học bị hủy
            ->get()
            ->map(function ($studentSection) {
                return [
                    'start_at' => $studentSection->section->start_at,
                    'end_at' => $studentSection->section->end_at,
                ];
            })
            ->toArray();
    }
}
