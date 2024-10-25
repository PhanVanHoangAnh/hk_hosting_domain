<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LoTrinhHocThuatChienLuoc extends Model
{
    use HasFactory;
   

    protected $table = 'lo_trinh_ht_cl';
    protected $fillable = ['type', 'content', 'intend_time', 'taget', 'note','abroad_application_id', 'frequency'];
   
    public function updateStrategicLearningCurriculum($request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->school_id = $request->school;
            $this->apply_date = $request->apply_date;
            $this->type = $request->type_school;
            $this->requirement = $request->requirement;
            $this->frequency = $request->frequency;
            

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
    public static function createLoTrinhHocThuatChienLuoc($request)
    {
        $loTrinhHocThuatChienLuocDB = LoTrinhHocThuatChienLuoc::where('type',$request->type)->where('abroad_application_id',$request->abroadApplicationId)->where('content',$request->content)->first();
        
        if($loTrinhHocThuatChienLuocDB) {
            $loTrinhHocThuatChienLuocDB->type = $request->type;
            $loTrinhHocThuatChienLuocDB->content = $request->content;
            $loTrinhHocThuatChienLuocDB->intend_time = $request->intend_time;
            $loTrinhHocThuatChienLuocDB->taget = $request->taget;
            $loTrinhHocThuatChienLuocDB->note = $request->note;
            $loTrinhHocThuatChienLuocDB->abroad_application_id = $request->abroadApplicationId;
            $loTrinhHocThuatChienLuocDB->frequency = $request->frequency;
            $loTrinhHocThuatChienLuocDB->save();
        } else {
            // Xử lý khi $loTrinhHocThuatChienLuocDB không tồn tại
            // Xử lý dữ liệu từ request để tạo link mạng xã hội
            $loTrinhHocThuatChienLuoc = new LoTrinhHocThuatChienLuoc();
            $loTrinhHocThuatChienLuoc->type = $request->type;
            $loTrinhHocThuatChienLuoc->content = $request->content;
            $loTrinhHocThuatChienLuoc->intend_time = $request->intend_time;
            $loTrinhHocThuatChienLuoc->taget = $request->taget;
            $loTrinhHocThuatChienLuoc->note = $request->note;
            $loTrinhHocThuatChienLuoc->abroad_application_id = $request->abroadApplicationId;
            $loTrinhHocThuatChienLuoc->frequency = $request->frequency;
        
            // Lưu link mạng xã hội vào cơ sở dữ liệu
            $loTrinhHocThuatChienLuoc->save();
        }
        
        return true;
    }
    public static function isCheckFill($abroad_application_id){
        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query) {
            $query->whereNotNull('intend_time')
                ->orWhereNotNull('taget')
                ->orWhereNotNull('note')
                ->orWhereNotNull('frequency');
        })
        ->exists();
    }
    
    
   
    

}
