<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExtracurricularSchedule extends Model
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';


    public const CATEGORY_CONTEST_AWARD_TITLE  = 'category_contest_award_title';
    public const CATEGORY_RESEARCH = 'cetegory_research';
    public const CATEGORY_INTERN = 'cetegory_intern';
    public const CATEGORY_PROJECT = 'category_project';
    public const CATEGORY_STUDENT_CLUB = 'category_student_club';
    public const CATEGORY_TRIP = 'category_trip';
    public const CATEGORY_GIFTED = 'category_gifted';

    public const ROLE_LEADER = 'role_leader';
    public const ROLE_INTERN = 'role_intern';
    public const ROLE_VOLUNTEER = 'role_volunteer';

    protected $table = 'extracurricular_schedule';
    protected $fillable = ['abroad_application_id', 'name', 'address', 'start_at', 'end_at', 'link','category', 'status','role'];
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }
    public function extracurricularStudent()
    {
        return $this->hasMany(ExtracurricularStudent::class, 'extracurricular_id', 'id');
    }
    public static function getByAbroadApplication($id)
    {
        $extracurricularSchedules = self::where('abroad_application_id', $id)->get();
        return $extracurricularSchedules;
    }
    public static function getAllCategory()
    {
        return [
            self::CATEGORY_CONTEST_AWARD_TITLE,
            self::CATEGORY_RESEARCH,
            self::CATEGORY_INTERN,
            self::CATEGORY_PROJECT,
            self::CATEGORY_TRIP,
            self::CATEGORY_GIFTED,
            self::CATEGORY_STUDENT_CLUB
        ];
    }
    public static function getAllRole()
    {
        return [
            self::ROLE_LEADER,
            self::ROLE_INTERN,
            self::ROLE_VOLUNTEER,
        ];
    }
    public function updateExtracurricularSchedule($request)
    {

        // Begin transaction
        DB::beginTransaction();

        try {
            $this->role = $request->role;
            $this->category = $request->category;
            $this->extracurricular_id = $request->extracurricularId;

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
    public static function createCreateExtracurricularSchedule($request)
    {
        // Xử lý dữ liệu từ request để tạo link mạng xã hội
        $extracurricularSchedule = new ExtracurricularSchedule();
        
        $extracurricularSchedule->extracurricular_id = $request->extracurricularId;
        $extracurricularSchedule->abroad_application_id = $request->id;
        $extracurricularSchedule->name = $request->name;
        $extracurricularSchedule->address = $request->address;
        $extracurricularSchedule->start_at = $request->start_at;
        $extracurricularSchedule->category = $request->category;
        $extracurricularSchedule->end_at = $request->end_at;
        $extracurricularSchedule->link = $request->link;
        $extracurricularSchedule->role = $request->role;

        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $extracurricularSchedule->save();

        return $extracurricularSchedule;
    }

    public function updateActiveExtracurricularSchedule()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('extracurricular_schedule')
                ->update(['status' => self::STATUS_ACTIVE]);


            DB::commit();

            // Return the number of updated rows
            return $updated;
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
    }
    public function updateDraftExtracurricularSchedule()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('extracurricular_schedule')
                ->update(['status' => self::STATUS_DRAFT]);
            DB::commit();
            // Return the number of updated rows
            return $updated;
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
    }
    public function countStudents()
    {
        return $this->extracurricularStudent()->count();
    }
    public static function isCheckFill($abroad_application_id){
        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query) {
            $query->whereNotNull('extracurricular_id');
        })->exists();
    }
}
