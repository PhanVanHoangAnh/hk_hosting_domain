<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CulturalOrientation extends Model
{
    use HasFactory;

    protected $fillable = ['abroad_application_id', 'need_open_bank_account', 'need_buy_sim', 'american_cultural_education_status'];

    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->first();
    }
    
    public function updateCulturalOrientation($request)
    {
        
        // Begin transaction
        DB::beginTransaction();

        try {
            $culturalOrientation = CulturalOrientation::findOrFail($request->id);
          
            $culturalOrientation->need_open_bank_account = $request->need_open_bank_account;
            $culturalOrientation->need_buy_sim = $request->need_buy_sim;
            $culturalOrientation->american_cultural_education_status = $request->american_cultural_education_status;

            $culturalOrientation->save();
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
    public static function createCulturalOrientation($request)
    { 
        
        $culturalOrientation = new CulturalOrientation();
        $culturalOrientation->abroad_application_id = $request->id;
        $culturalOrientation->need_open_bank_account = $request->need_open_bank_account;
        $culturalOrientation->need_buy_sim = $request->need_buy_sim;
        $culturalOrientation->american_cultural_education_status = $request->american_cultural_education_status;

        
        $culturalOrientation->save();

        return $culturalOrientation;
    }
}
