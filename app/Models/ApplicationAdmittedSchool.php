<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ApplicationAdmittedSchool extends Model
{
    use HasFactory;
    protected $table = 'application_admitted_schools';
    protected $fillable = [
        'abroad_application_id',
        'school_id',
        'selected',
        'scholarship',
        
    ];

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->get();
    }
    public static function newDefault()
    {
        $applicationFee = new self();
        return $applicationFee;
    }
    public function saveApplicationAdmittedSchool($request)
    {   
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'abroad_application_id' => 'required',
            'school_id' => 'required',
           
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->save();

        return $validator->errors();
    }
    
    public function updateSchoolSelected($selected)
    {
        $otherRecords = $this->where('abroad_application_id', $this->abroad_application_id)->get();

        
        foreach ($otherRecords as $record) {
            $record->selected = false;
            $record->save();
        }
        $this->selected = $selected;
        $this->save();
    }
}
