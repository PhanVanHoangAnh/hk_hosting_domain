<?php

namespace App\Models;

use App\Events\UpdateExtracurricularPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LoTrinhHoatDongNgoaiKhoa extends Model
{
    use HasFactory;

    protected $table = 'lo_trinh_hd_nk';
    protected $fillable = ['category', 'activity', 'intend_time', 'note','abroad_application_id'];
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
    public static function createLoTrinhHoatDongNgoaiKhoa($request)
    {
        $loTrinhHocThuatChienLuocDB = LoTrinhHoatDongNgoaiKhoa::where('category',$request->category)->where('abroad_application_id',$request->abroadApplicationId)->where('activity',$request->activity)->first();
        if($loTrinhHocThuatChienLuocDB) {
            $loTrinhHocThuatChienLuocDB->category = $request->category;
            $loTrinhHocThuatChienLuocDB->activity = $request->activity;
            $loTrinhHocThuatChienLuocDB->intend_time = $request->intend_time;
            $loTrinhHocThuatChienLuocDB->note = $request->note;
            $loTrinhHocThuatChienLuocDB->abroad_application_id = $request->abroadApplicationId;
            $loTrinhHocThuatChienLuocDB->save();
            UpdateExtracurricularPlan::dispatch($loTrinhHocThuatChienLuocDB);
        } else {
            // Xử lý khi $loTrinhHocThuatChienLuocDB không tồn tại
            // Xử lý dữ liệu từ request để tạo link mạng xã hội
            $loTrinhHocThuatChienLuoc = new LoTrinhHoatDongNgoaiKhoa();
            $loTrinhHocThuatChienLuoc->category = $request->category;
            $loTrinhHocThuatChienLuoc->activity = $request->activity;
            $loTrinhHocThuatChienLuoc->intend_time = $request->intend_time;
            $loTrinhHocThuatChienLuoc->note = $request->note;
            $loTrinhHocThuatChienLuoc->abroad_application_id = $request->abroadApplicationId;

            // Lưu link mạng xã hội vào cơ sở dữ liệu
            $loTrinhHocThuatChienLuoc->save();
            UpdateExtracurricularPlan::dispatch($loTrinhHocThuatChienLuoc);
        }
        
        return true;
    }
    public static function isCheckFill($abroad_application_id){
        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query) {
            $query->whereNotNull('intend_time')
                ->orWhereNotNull('note');
        })
        ->exists();
    }
    

}
