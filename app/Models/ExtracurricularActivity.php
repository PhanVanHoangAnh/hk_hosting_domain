<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExtracurricularActivity extends Model
{
    use HasFactory;
    protected $table = 'extracurricular_activity';
    protected $fillable = ['abroad_application_id', 'name', 'address', 'execution_date', 'link'];

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
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public static function getByAbroadApplication($id)
    {
        $extracurricularActivitys = self::where('abroad_application_id', $id)->get();
        return $extracurricularActivitys;
    }

    public function updateExtracurricularActivity($request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->name = $request->name;
            $this->address = $request->address;
            $this->start_at = $request->start_at;
            $this->end_at = $request->end_at;
            $this->category = $request->category;
            $this->link_document = $request->link_document;
            $this->link_file = $request->link_file;
            $this->role = $request->role;
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
    
    public static function createExtracurricularActivity($request)
    {
        // Xử lý dữ liệu từ request để tạo link mạng xã hội
         $extracurricularActivity = new ExtracurricularActivity();
        $extracurricularActivity->abroad_application_id = $request->id;
        $extracurricularActivity->name = $request->name;
        $extracurricularActivity->address = $request->address;
        $extracurricularActivity->start_at = $request->start_at;
        $extracurricularActivity->category = $request->category;
        $extracurricularActivity->end_at = $request->end_at;
        
        $extracurricularActivity->role = $request->role;
        $extracurricularActivity->link_document = $request->link_document;
        $extracurricularActivity->link_file = $request->link_file;


        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $extracurricularActivity->save();

        return $extracurricularActivity;
    }
    public function updateActiveExtracurricularActivity()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('extracurricular_activity')
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
}
