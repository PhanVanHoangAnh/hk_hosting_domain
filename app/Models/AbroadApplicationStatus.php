<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExtracurricularController;
use App\Helpers\Functions;

class AbroadApplicationStatus extends Model
{
    use HasFactory;
    public const STATUS_DONE = 'done';
    public const STATUS_ACTIVE = 'active';
    
    protected $table = 'abroad_application_status';
    protected $fillable = ['lo_trinh_ht_cl', 'lo_trinh_hd_nk', 'application_school', 'extracurricular_schedule', 'certificate', 'extracurricular_activity',
     'recommendation_letters','essay_results','social_network','financial_document','student_cv','study_abroad_applications','hsdt','complete_file','admission_letter','scan_of_information','application_fees','abroad_application_id','deposit_for_school','cultural_orientation','support_activity','complete_application'];
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
   
    
    public function updateFinishDay($request)
    {
        // Begin transaction
        DB::beginTransaction();
        try {
            if($request->updateFinishDay == "lo_trinh_ht_cl"){
                $this->lo_trinh_ht_cl = self::STATUS_DONE;
            }
            if($request->updateFinishDay == "lo_trinh_hd_nk"){
                $this->lo_trinh_hd_nk  = self::STATUS_DONE;
            } if($request->updateFinishDay == "application_school"){
                $this->application_school = self::STATUS_DONE;
            } if($request->updateFinishDay == "extracurricular_schedule"){
                $this->extracurricular_schedule = self::STATUS_DONE;
            } if($request->updateFinishDay == "certificate"){
                $this->certificate = self::STATUS_DONE;
            } if($request->updateFinishDay == "extracurricular_activity"){
                $this->extracurricular_activity = self::STATUS_DONE;
            } if($request->updateFinishDay == "recommendation_letters"){
                $this->recommendation_letters = self::STATUS_DONE;
            } if($request->updateFinishDay == "essay_results"){
                $this->essay_results = self::STATUS_DONE;
            } if($request->updateFinishDay == "social_network"){
                $this->social_network = self::STATUS_DONE;
            } if($request->updateFinishDay == "financial_document"){
                $this->financial_document = self::STATUS_DONE;
            } if($request->updateFinishDay == "student_cv"){
                $this->student_cv = self::STATUS_DONE;
            } if($request->updateFinishDay == "study_abroad_applications"){
                $this->study_abroad_applications = self::STATUS_DONE;
            } if($request->updateFinishDay == "complete_file"){
                $this->complete_file = self::STATUS_DONE;
            } if($request->updateFinishDay == "admission_letter"){
                $this->admission_letter = self::STATUS_DONE;
            } if($request->updateFinishDay == "scan_of_information"){
                $this->scan_of_information = self::STATUS_DONE;
            } if($request->updateFinishDay == "application_fees"){
                $this->application_fees = self::STATUS_DONE;
            }  if($request->updateFinishDay == "hsdt"){
                $this->hsdt = self::STATUS_DONE;
            } if($request->updateFinishDay == "deposit_for_school"){
                $this->deposit_for_school = self::STATUS_DONE;
            } if($request->updateFinishDay == "cultural_orientation"){
                $this->cultural_orientation = self::STATUS_DONE;
            }
            if($request->updateFinishDay == "support_activity"){
                $this->support_activity = self::STATUS_DONE;
            }
            if($request->updateFinishDay == "complete_application"){
                $this->complete_application = self::STATUS_DONE;
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
        $extracurricular = new AbroadApplicationStatus();

        if($request->updateFinishDay == "lo_trinh_ht_cl"){
            $extracurricular->lo_trinh_ht_cl = self::STATUS_DONE;
        }

        if($request->updateFinishDay == "lo_trinh_hd_nk"){
            $extracurricular->lo_trinh_hd_nk  = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "application_school"){
            $extracurricular->application_school = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "extracurricular_schedule"){
            $extracurricular->extracurricular_schedule = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "certificate"){
            $extracurricular->certificate = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "extracurricular_activity"){
            $extracurricular->extracurricular_activity = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "recommendation_letters"){
            $extracurricular->recommendation_letters = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "essay_results"){
            $extracurricular->essay_results = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "social_network"){
            $extracurricular->social_network = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "financial_document"){
            $extracurricular->financial_document = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "student_cv"){
            $extracurricular->student_cv = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "study_abroad_applications"){
            $extracurricular->study_abroad_applications = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "complete_file"){
            $extracurricular->complete_file = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "admission_letter"){
            $extracurricular->admission_letter = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "scan_of_information"){
            $extracurricular->scan_of_information = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "application_fees"){
            $extracurricular->application_fees = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "hsdt"){
            $extracurricular->hsdt = self::STATUS_DONE;
        }
        
        if($request->updateFinishDay == "deposit_for_school"){
            $extracurricular->deposit_for_school = self::STATUS_DONE;
        } 
        
        if($request->updateFinishDay == "cultural_orientation"){
            $extracurricular->cultural_orientation = self::STATUS_DONE;
        }

        if($request->updateFinishDay == "support_activity"){
            $extracurricular->support_activity = self::STATUS_DONE;
        }

        if($request->updateFinishDay == "complete_application"){
            $extracurricular->complete_application = self::STATUS_DONE;
        }
       
        $extracurricular->abroad_application_id =$request->abroadApplicationId;
        $extracurricular->save();

        return $extracurricular;
    }

    
    public function updateDoneAbroadApplication($request)
    {
        $abroadApplicationStatus = AbroadApplicationStatus::where('abroad_application_id',$request->abroadApplicationId)->first();

        if($abroadApplicationStatus){
            $abroadApplicationStatus->updateFinishDay($request);
        }else{
            self::createFinishDay($request);
        }
    }
}
