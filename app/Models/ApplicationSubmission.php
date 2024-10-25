<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ApplicationSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'abroad_application_id',
        'school_id',
        'deadline',
        'completion_time',
        'path'
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
    public function saveApplicationSubmission($request)
    {   
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_SUBMISSION_FILE_URL;
        
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'abroad_application_id' => 'required',
            'school_id' => 'required',
            'deadline' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($request->hasFile('path')) {

            $file = $request->file('path');
            
            $extension = $file->getClientOriginalName();
            $abroadApplicationId = $request->input('abroad_application_id'); 
            $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $abroadApplicationId . '/' . $suffixUrl;
            $fileName = time() . '.' . $extension;
            $filePath = $path . '/' . $fileName;
    
            // Kiểm tra và xóa tệp đã tồn tại
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
    
            $file->move(public_path($path), $fileName);
            
            
            $this->path = $fileName;
            $this->completion_time = now();
        }

        $this->save();

        return $validator->errors();
    }

    public function getPath()
    {
    
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_SUBMISSION_FILE_URL;
    
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->path;

        if (!is_dir($mediaPath)) {
            return $mediaPath;
        }

        return $mediaPath;
    }
}
