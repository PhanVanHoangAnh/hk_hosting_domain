<?php

use App\Models\Section;
use App\Models\CourseStudent;
use App\Models\StudentSection;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       $sections = Section::all();
       foreach($sections as $section){
            $this->addContactToSection($section);
       }
    }
    
    public function addContactToSection($section){
        $studentIds = CourseStudent::where('course_id', $section->course_id)->pluck('student_id');
      
        foreach( $studentIds as $studentId ){
            $studentSection = StudentSection::where('student_id', $studentId)->where('section_id', $section->id)->first();
            if($studentSection){
                echo("  \033[1m\033[33mWARNING\033[0m: StudentSection đã tồn tại \n" );
            }else{
                $newStudentSection = new StudentSection();
                $newStudentSection->student_id = $studentId;
                $newStudentSection->section_id = $section->id;
                $newStudentSection->status = StudentSection::STATUS_NEW;
                $newStudentSection->save();
                echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo thành công StudentSection\n");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
