<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SectionReport extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    protected $fillable = [
        'student_id',
        'section_id',
        'content',
        'tinh_dung_gio',
        'muc_do_tap_trung',
        'muc_do_hieu_bai',
        'muc_do_tuong_tac',
        'tu_hoc_va_giai_quyet_van_de',
        'tu_tin_trach_nhiem',
        'trung_thuc_ky_luat',
        'ket_qua_tren_lop',
        'teacher_comment',
    ];

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function scopeActive($query)
    {
        $query = $query->where('status', self::STATUS_ACTIVE);
    }
    public static function newDefault()
    {
        $sectionReport = new self();
        $sectionReport->status = self::STATUS_ACTIVE;
        return $sectionReport;
    }

    public function deleteSectionReport()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public function updateFromRequest($request, $id)
    {
        $sectionId = $request->input('section_id');
        $studentId = $request->input('student_id');

       
        
        $this->fill($request->all());
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'section_id' => 'required',
            'tinh_dung_gio' => 'required',
            'muc_do_tap_trung' => 'required',
            'muc_do_hieu_bai' => 'required',
            'muc_do_tuong_tac' => 'required',
            'tu_hoc_va_giai_quyet_van_de' => 'required',
            'tu_tin_trach_nhiem' => 'required',
            'trung_thuc_ky_luat' => 'required',
            'ket_qua_tren_lop' => 'required',
        ]);
    
        if ($validator->fails()) {
            return $validator->errors();
        }
    
        $existingReport = self::where('section_id', $sectionId)
            ->where('student_id', $studentId)
            ->first();

        if ($existingReport) {
            $existingReport->delete();
        }
        $this->save();
    
        return $validator->errors();
    }

    public static function getStatusLabel($value)
    {
        switch ($value) {
            case 1:
                return 'Poor';
            case 2:
                return 'Fair';
            case 3:
                return 'Good';
            case 4:
                return 'Very Good';
            case 5:
                return 'Excellent';
            default:
                return '--';
           
        }
    }
    public function getTinhDungGioLabel()
    {
        return self::getStatusLabel($this->tinh_dung_gio);
    }

    public function getMucDoTapTrungLabel()
    {
        return self::getStatusLabel($this->muc_do_tap_trung);
    }

    public function getMucDoHieuBaiLabel()
    {
        return self::getStatusLabel($this->muc_do_hieu_bai);
    }

    public function getMucDoTuongTacLabel()
    {
        return self::getStatusLabel($this->muc_do_tuong_tac);
    }

    public function getTuHocVaGiaiQuyetVanDeLabel()
    {
        return self::getStatusLabel($this->tu_hoc_va_giai_quyet_van_de);
    }

    public function getTuTinTrachNhiemLabel()
    {
        return self::getStatusLabel($this->tu_tin_trach_nhiem);
    }

    public function getTrungThucKyLuatLabel()
    {
        return self::getStatusLabel($this->trung_thuc_ky_luat);
    }

    public function getKetQuaTrenLopLabel()
    {
        return self::getStatusLabel($this->ket_qua_tren_lop);
    }

    public function scopeFilterSectionOfStudentInCourse($query, $studentId, $courseId)
    {
        return $query
            ->join('sections', 'section_reports.section_id', '=', 'sections.id')
            ->where('sections.course_id', $courseId)
            ->where('section_reports.student_id', $studentId)
            ->where('section_reports.status', '!=', self::STATUS_DELETED);;
    }

    public function scopeCountFilteredSectionsOfStudentInCourse($query, $studentId, $courseId)
    {
        return $query
            ->join('sections', 'section_reports.section_id', '=', 'sections.id')
            ->where('sections.course_id', $courseId)
            ->where('section_reports.student_id', $studentId)
            ->where('section_reports.status', '!=', self::STATUS_DELETED)
            ->count();
    }
   
}
