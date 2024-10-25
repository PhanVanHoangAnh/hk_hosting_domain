<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExtracurricularController;
use App\Helpers\Functions;

class AbroadApplicationFinishDay extends Model
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    
    protected $table = 'abroad_application_finish_day';
    protected $fillable = ['lo_trinh_ht_cl', 'lo_trinh_hd_nk', 'application_school', 'extracurricular_schedule', 'certificate', 'extracurricular_activity', 'recommendation_letters','essay_results','social_network','financial_document','student_cv','study_abroad_applications','complete_file','admission_letter','scan_of_information','application_fees','abroad_application_id'];
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
   
    
    public function updateFinishDay($request)
    {
        // Begin transaction
        DB::beginTransaction();
        try {
            if($request->lo_trinh_ht_cl !== null){
                $this->lo_trinh_ht_cl = $request->lo_trinh_ht_cl;
            }
            if($request->lo_trinh_hd_nk !== null){
                $this->lo_trinh_hd_nk = $request->lo_trinh_hd_nk ;
            }if($request->application_school !== null){
                $this->application_school = $request->application_school ;
            }if($request->extracurricular_schedule !== null){
                $this->extracurricular_schedule = $request->extracurricular_schedule ;
            }if($request->certificate !== null){
                $this->certificate = $request->certificate ?? $this->certificate;
            }if($request->extracurricular_activity !== null){
                $this->extracurricular_activity = $request->extracurricular_activity;
            }if($request->recommendation_letters !== null){
                $this->recommendation_letters = $request->recommendation_letters;
            }if($request->essay_results !== null){
                $this->essay_results = $request->essay_results ;
            }if($request->social_network !== null){
                $this->social_network = $request->social_network ;
            }if($request->financial_document !== null){
                $this->financial_document = $request->financial_document;
            }if($request->student_cv !== null){
                $this->student_cv = $request->student_cv ?? $this->student_cv;
            }if($request->study_abroad_applications !== null){
                $this->study_abroad_applications = $request->study_abroad_applications;
            }if($request->complete_file !== null){
                $this->complete_file = $request->complete_file;
            }if($request->admission_letter !== null){
                $this->admission_letter = $request->admission_letter;
            }
            if($request->scan_of_information !== null){
                $this->scan_of_information = $request->scan_of_information;
            }
            if($request->application_fees !== null){
                $this->application_fees = $request->application_fees ;
            }
         
            
           

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
    public static function createFinishDay($request)
    {
        $extracurricular = new AbroadApplicationFinishDay();
        $extracurricular->lo_trinh_ht_cl = $request->lo_trinh_ht_cl;
        $extracurricular->lo_trinh_hd_nk  = $request->lo_trinh_hd_nk;
        $extracurricular->application_school = $request->application_school;
        $extracurricular->extracurricular_schedule = $request->extracurricular_schedule;


        $extracurricular->certificate = $request->certificate;
        $extracurricular->extracurricular_activity = $request->extracurricular_activity;
        $extracurricular->recommendation_letters = $request->recommendation_letters;
        $extracurricular->essay_results = $request->essay_results;
        $extracurricular->social_network = $request->social_network;

        $extracurricular->financial_document = $request->financial_document;
        $extracurricular->student_cv = $request->student_cv;
        $extracurricular->study_abroad_applications = $request->study_abroad_applications;
        $extracurricular->complete_file = $request->complete_file;
        $extracurricular->admission_letter = $request->admission_letter;

        $extracurricular->scan_of_information = $request->scan_of_information;
        $extracurricular->application_fees = $request->application_fees;
        $extracurricular->abroad_application_id = $request->abroadApplicationId;    

        $extracurricular->save();

        return $extracurricular;
    }

    
    public function updateAbroadApplicationFinishDay($request)
    {
        $abroadApplicationFinishDay = AbroadApplicationFinishDay::where('abroad_application_id',$request->abroadApplicationId)->first();

      if($abroadApplicationFinishDay){
        $abroadApplicationFinishDay->updateFinishDay($request);
        
      }else{
        self::createFinishDay($request);
      }
        // Begin transaction
      
    }
}
