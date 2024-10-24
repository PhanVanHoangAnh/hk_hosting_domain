<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SupportActivity extends Model
{
    use HasFactory; 
     
    protected $fillable = [
        'abroad_application_id',
        'airport_pickup_person',
        'guardian_person',
        'address',
    ];

    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->get(); 
    }

    public function updateSupportActivity($request)
    {
        
        // Begin transaction
        DB::beginTransaction();

        try {
            $supportActivity = SupportActivity::findOrFail($request->id);
            
            $supportActivity->airport_pickup_person = $request->airport_pickup_person;
            $supportActivity->guardian_person = $request->guardian_person;
            $supportActivity->address = $request->address;
    

            $supportActivity->save();
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
    public static function createSupportActivity($request)
    { 
        
        $supportActivity = new SupportActivity();
        $supportActivity->abroad_application_id = $request->id;
        $supportActivity->airport_pickup_person = $request->airport_pickup_person;
        $supportActivity->guardian_person = $request->guardian_person;
        $supportActivity->address = $request->address;

        
        $supportActivity->save();

        return $supportActivity;
    }

}
