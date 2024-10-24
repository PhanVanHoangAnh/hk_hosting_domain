<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class FlyingStudent extends Model
{
    use HasFactory;

    protected $fillable =[
        'abroad_application_id',
        'air',
        'flight_date',
        'flight_time',
    ];

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->get();
    }

    public function saveFlyingStudent($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'abroad_application_id' => 'required',
            'air' => 'required',
            'flight_date' => 'required',
            'flight_time' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();

        return $validator->errors();

    }

    public static function newDefault()
    {
        $flyingStudent = new self();
        return $flyingStudent;
    }

    public function updateFlyingStudent($request)
    {
        
        // Begin transaction
        DB::beginTransaction();

        try {
            $flyingStudent = FlyingStudent::findOrFail($request->id);
            
            $flyingStudent->air = $request->air;
            $flyingStudent->flight_date = $request->flight_date;
            $flyingStudent->flight_time = $request->flight_time;
    

            $flyingStudent->save();
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

    public function scopeLeft14Days($query, $days = 14)
    {
        return $query->whereDate('flight_date', '=', now()->addDays($days));
    }
    public function scopeLeft2Days($query, $days = 2)
    {
        return $query->whereDate('flight_date', '=', now()->addDays($days));
    }
}
