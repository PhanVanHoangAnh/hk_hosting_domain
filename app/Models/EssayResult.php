<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class EssayResult extends Model
{
    use HasFactory;

    
    // essay result file
    private const SUFFIX_SAVE_ESSAY_RESULT_FILE_URL = 'essay_result_files';

    protected $fillable = [
        'abroad_application_id',
        'school_id',
        'content',
        'word_count',
        'classification',
        'quality_of_content',
        'execution',
        'personal_voice',
        'overall',
        'url',
        'path'
    ];
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
    
    public static function getByAbroadApplicationId( $id)
    {
        return self::where('abroad_application_id', $id)->get();
    }
    
    public static function newDefault()
    {
        $essayResult = new self();
        return $essayResult;
    }
    public function saveFromRequest($request)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;
        $this->fill($request->all());
        
        $validator = Validator::make($request->all(), [
            'school_id' => 'required',
            'content'  => 'required',
            'word_count' => 'required',
            'classification' => 'required',
            'quality_of_content' => 'required',
            'execution' => 'required',
            'personal_voice' => 'required',
            'overall' => 'required',
            'path' => 'required|mimes:pdf,docx,doc,txt',
            
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
        }

        $this->save();

        return $validator->errors();
    }
    public function updateFromRequest($request)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;
        $oldPath = $this->path;
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'school_id' => 'required',
            'content'  => 'required',
            'word_count' => 'required',
            'classification' => 'required',
            'quality_of_content' => 'required',
            'execution' => 'required',
            'personal_voice' => 'required',
            'overall' => 'required',
            'path' => 'mimes:pdf,docx,doc,txt',
        ]);
    
        if ($validator->fails()) {
            return $validator->errors();
        }
    
        if ($this->path && $request->hasFile('path')) {
            $filePath = public_path($this->path);
            // Kiểm tra và xóa tệp đã tồn tại
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $extension = $file->getClientOriginalName();
            $abroadApplicationId = $request->input('abroad_application_id');

            $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $abroadApplicationId . '/' . $suffixUrl;

            if (isset($oldPath)) { 
                unlink(public_path($path . '/' . $oldPath));
            }
           
            
            
            $fileName = time() . '.' . $extension;
            $filePath = $path . '/' . $fileName;
    
            $file->move(public_path($path), $fileName);
    
            $this->path = $fileName;
        }
    
        $this->save();
    
        return $validator->errors();
    }
    
    public function deleteWithFile()
    {
      
       if (isset($this->path)) { 
        $this->deleteFile();
    }
        $this->delete();
    }
    public function deleteFile()
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;

        $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $filePath = public_path($path . '/' . $this->path);

        if (!file_exists($filePath)) {
            throw new \Exception('File not found!');
        }
        unlink($filePath);
        $this->path = null;
        $this->save();
    }

    public function getPath()
    {
    
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;
    
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->path;

        if (!is_dir($mediaPath)) {
            return $mediaPath;
        }

        return $mediaPath;
    }
    public static function isCheckFill($abroad_application_id){
        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query){
            $query->whereNotNull('school_id');
        })->exists();
    }

}
