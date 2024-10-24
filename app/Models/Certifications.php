<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Certifications extends Model
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    protected $table = 'certifications';
    protected $fillable = ['abroad_application_id', 'due_date', 'certified_date', 'min_score', 'type', 'actual_score'];
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
    public static function getByAbroadApplication($id)
    {
        $certifications = self::where('abroad_application_id', $id)->get();
        return $certifications;
    }
    public static function createCertification($request)
    {
        // Xử lý dữ liệu từ request để tạo link mạng xã hội
        $createCertification = new Certifications();
        $createCertification->abroad_application_id = $request->id;
        $createCertification->due_date = $request->due_date;
        $createCertification->certified_date = $request->certified_date;
        $createCertification->min_score = $request->min_score;
        $createCertification->actual_score = $request->actual_score;
        if($request->certification == 'other') {
            $createCertification->type = $request->other_certificate;
        } else {
            $createCertification->type = $request->certification;
        } 
        $createCertification->link = $request->link;

        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $createCertification->save();

        return $createCertification;
    }
    public function updateCertification($request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->due_date = $request->due_date;
            $this->certified_date = $request->certified_date;
            $this->min_score = $request->min_score;
            $this->actual_score = $request->actual_score;
            if($request->certification == 'other') {
                $this->type = $request->other_certificate;
            } else {
                $this->type = $request->certification;
            } 
            $this->link = $request->link;

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
    public function updateActiveCertification()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('certifications')
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
    public static function isCheckFill($abroad_application_id){
        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query){
            $query->whereNotNull('type');
        })->exists();
    }
}
