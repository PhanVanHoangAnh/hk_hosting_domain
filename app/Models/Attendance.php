<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'student_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function student()
    {
        return $this->belongsTo(Contact::class);
    }
    public static function newDefault()
    {
        $attendence = new self();
        
        return $attendence;
    }
    public function updateFromRequest($request, $id)
    {
        $attendanceData = json_decode($request->input('attendance'), true);
        
        Attendance::where('section_id', $id)->delete();

        foreach ($attendanceData as $data) {
            $studentId = $data['studentId'];
            $sectionId = $data['itemId'];


            Attendance::updateOrInsert(
                ['student_id' => $studentId, 'section_id' => $sectionId],
                ['student_id' => $studentId, 'section_id' => $sectionId]
            );
        }
    }


    public function scopeCheckAttendance($query, $studentId, $sectionId)
    {
        return $query->where('student_id', $studentId)
            ->where('section_id', $sectionId)
            ->exists();
    }
}
