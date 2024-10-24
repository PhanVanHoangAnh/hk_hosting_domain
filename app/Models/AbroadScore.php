<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbroadScore extends Model
{
    use HasFactory;
   

    protected $table = 'abroad_score';
    protected $fillable = ['test_day', 'ielts_score','sat_score' ,'abroad_application_id'];
   
    public function updateScore($request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->test_day = $request->date;
            $this->ielts_score = $request->score;
            $this->sat_score = $request->sat_score;
            $this->exam_times = $request->exam_times;
            

            $this->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        // commit
        DB::commit();
    }
    public static function createScore($request)
    {
     
            $abroadScore = new AbroadScore();
            $abroadScore->test_day = $request->date;
            $abroadScore->ielts_score = $request->score;
            $abroadScore->sat_score = $request->sat_score;
            $abroadScore->abroad_application_id = $request->abroad_application_id;
            $abroadScore->exam_times = $request->exam_times;
            
            // Lưu link mạng xã hội vào cơ sở dữ liệu
            $abroadScore->save();
       
        
        return true;
    }
    

}
