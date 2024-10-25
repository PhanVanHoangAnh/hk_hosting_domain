<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class DepositForSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'abroad_application_id',
        'amount',
        'date',
        'deposit_receipt_link',
    ];

    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->get(); 
    }

    public function updateDepositForSchool($request)
    {
        
        // Begin transaction
        DB::beginTransaction();

        try {
            $depositForSchool = DepositForSchool::findOrFail($request->id);
            
            $depositForSchool->amount = str_replace(',', '', $request->amount);
            $depositForSchool->date = $request->date;
            $depositForSchool->deposit_receipt_link = $request->deposit_receipt_link;
    

            $depositForSchool->save();
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
    public static function createDepositForSchool($request)
    {  
        $depositForSchool = new DepositForSchool();
        $depositForSchool->abroad_application_id = $request->id;
        $depositForSchool->amount = str_replace(',', '', $request->amount);
        $depositForSchool->date = $request->date;
        $depositForSchool->deposit_receipt_link = $request->deposit_receipt_link;

        
        $depositForSchool->save();

        return $depositForSchool;
    }
}
