<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;
    
    protected $table = 'course_student';

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id', 'id');
    }

    protected $fillable = [
        'order_item_id',
        'student_id',
        'course_id',

    ];

    // Trong mô hình CourseStudent
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function orderItems()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }

    public static function scopeFilterByStudent($query, $student)
    {
        if (is_array($student) && in_array('all', $student)) {
            return $query;
        } else {
            return $query->whereIn('student_id', (array) $student);
        }
    }

    public static function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->orWhereHas('student', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                    ->orWhereHas('course.subject', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('course.teacher', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('orderItems', function ($query) use ($keyword) {
                        $query->where('type', 'LIKE', "%{$keyword}%");
                    });
            });
        });
    }

    public static function scopeFilterByTeachers($query, $teachers)
    {
        $query = $query->whereHas('course', function ($query) use ($teachers) {
            $query->whereIn('teacher_id', $teachers);
        });
    }
    public static function scopeFilterBySubjects($query, $subjects)
    {
        $query = $query->whereHas('course', function ($query) use ($subjects) {
            $query->whereIn('subject_id', $subjects);
        });
    }
    public static function scopeFilterByStartAt($query, $start_at_from, $start_at_to)
    {
        if (!empty($start_at_from) && !empty($start_at_to)) {
            $query = $query->whereHas('course', function ($query) use ($start_at_from, $start_at_to) {
                $query->whereBetween('start_at', [$start_at_from, \Carbon\Carbon::parse($start_at_to)->endOfDay()]);
            });
        }
        return $query;
    }

    public static function scopeFilterByEndAt($query, $end_at_from, $end_at_to)
    {
        if (!empty($end_at_from) && !empty($end_at_to)) {
            $query = $query->whereHas('course', function ($query) use ($end_at_from, $end_at_to) {
                $query->whereBetween('end_at', [$end_at_from, \Carbon\Carbon::parse($end_at_to)->endOfDay()]);
            });
        }
        return $query;
    }

    public function addCourseStudent($orderItem, $student, $course)
    {
        return self::create([
            'order_item_id' => $orderItem->id,
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }

    public function scopeCountRecordsForCourseStudent($query, $studentId, $courseId)
    {
        return $query
            ->join('section_reports', function ($join) use ($studentId) {
                $join->on('course_student.student_id', '=', 'section_reports.student_id')
                    ->where('section_reports.student_id', $studentId)
                    ->where('section_reports.status', '!=', SectionReport::STATUS_DELETED);
            })
            ->join('sections', function ($join) use ($courseId) {
                $join->on('section_reports.section_id', '=', 'sections.id')
                    ->where('sections.course_id', $courseId);
            })
            ->count();
    }
    public static function  scopeCoursesByStudentId($query, $studentId)
    {
        // Sử dụng mô hình CourseStudent để lấy danh sách các khóa học mà sinh viên tham gia
        $courseStudents = $query->where('student_id', $studentId)->get();

        // Tạo một Collection để lưu trữ các khóa học
        $courses = collect();

        // Duyệt qua mỗi đối tượng CourseStudent để lấy thông tin về khóa học và thêm vào Collection $courses
        foreach ($courseStudents as $courseStudent) {
            $course = $courseStudent->course()->first();
            if ($course) {
                $courses->push($course);
            }
        }

        return $courses;
    }

    public function getOrderItem()
    {
        return OrderItem::find($this->order_item_id);
    }

    public static function getOrderItemId($studentId, $courseId)
    {
        $courseStudent = self::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        return $courseStudent;
    }

    public static function  scopeOrderItemByCourse($query, $course)
    {
        //     $q->where('id', $course);
        // })->with('orderItems')->get());
        $orderItemIds = $query->whereHas('course', function ($q) use ($course) {
            $q->where('id', $course);
        })->pluck('order_item_id');

        // Tạo một Collection để lưu trữ các khóa học
        $orderItemCurrent = collect();

        // Duyệt qua mỗi đối tượng CourseStudent để lấy thông tin về khóa học và thêm vào Collection $courses
        foreach ($orderItemIds as $orderItemId) {
            $orderItem = OrderItem::find($orderItemId);

            if ($course) {
                $orderItemCurrent->push($orderItem);
            }
        }

        return $orderItemCurrent;
    }

    public static function  scopeCoursesByCourseId($query, $currentCourseStudentId, $studentId)
    {
        // Sử dụng mô hình CourseStudent để lấy danh sách các khóa học mà sinh viên tham gia
        $courseStudents = $query->where('course_id', $currentCourseStudentId)->where('student_id', $studentId)->get();

        // Tạo một Collection để lưu trữ các khóa học
        $courses = collect();

        // Duyệt qua mỗi đối tượng CourseStudent để lấy thông tin về khóa học và thêm vào Collection $courses
        foreach ($courseStudents as $courseStudent) {
            $course = $courseStudent->course()->first();
            if ($course) {
                $courses->push($course);
            }
        }

        return $courses;
    }

    public function scopeFindByOrderItem($query, $orderItemId, $studentId)
    {
        return $query->where('order_item_id', $orderItemId)->whereHas('orderItems.orders', function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            });
    }

    public static function getCourseStudentsByOrderItemAndStudent($orderItemId, $studentId)
    {
        return self::findByOrderItem($orderItemId, $studentId)->get();
    }

    public function importFromExcelSeeder($data)
    {
        try {
            $this->course_id = $data['course_id'];
            $this->student_id = $data['contact_id'];
            $this->order_item_id = $data['order_item_id'];
            $this->save();
            echo("  \033[32mSUCCESS\033[0m: Xếp lớp thành công cho học viên  - import_id: " . $this->student_id ."vào lớp : ". $this->course_id ."\n");
        } catch (\Exception $e) {
            echo($e);
        }
    }
}
