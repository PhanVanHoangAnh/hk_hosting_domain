<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class StudyAbroadApplication extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    protected $fillable = [
        'abroad_application_id',
        'name',
        'status',
        'path',
    ];

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
    
    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->get();
    }
    public function active()
    { 
        $this->status = self::STATUS_ACTIVE;
        
        return $this->save();
    }
    
    public static function newDefault()
    {
        $essayResult = new self();
        return $essayResult;
    }
    public function saveFromRequest($request)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_STUDY_ABROAD_APPLICATION_FILE_URL;
        $this->fill($request->all());
        
        $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'path' => 'mimes:pdf,docx,doc,txt',
            
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
    
            
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
    
            
            $file->move(public_path($path), $fileName);
            
            
            $this->path = $fileName;
        }
        $this->status = self::STATUS_DRAFT ;
        $this->save();

        return $validator->errors();
    }

    public function getPath()
    {
    
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_STUDY_ABROAD_APPLICATION_FILE_URL;
    
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->path;

        if (!is_dir($mediaPath)) {
            return $mediaPath;
        }

        return $mediaPath;
    }
    public static function isCheckFill($abroad_application_id){
        return ApplicationSchool::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query) {
            $query->whereNotNull('study_abroad_application');
               
        })
        ->exists();
    }
}
