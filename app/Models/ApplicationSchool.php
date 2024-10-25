<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ApplicationSchool extends Model
{
    use HasFactory;
    public const TYPE_DREAM_SCHOOL = 'dream_school';
    public const TYPE_MATCH_SCHOOL = 'match_school';
    public const TYPE_SAFE_SCHOOL = 'safe_school';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';

    public const STATUS_STUDY = 'studied';

    protected $table = 'application_school';
    protected $fillable = ['abroad_application_id', 'school_id', 'apply_date', 'type', 'requirement','status','file_study_abroad_application'];
    
    public static function getAllType()
    {
        return [
            self::TYPE_DREAM_SCHOOL,
            self::TYPE_MATCH_SCHOOL,
            self::TYPE_SAFE_SCHOOL,
        ];
    }

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function scopeStudy($query)
    {
        return $query->where('study', self::STATUS_STUDY);
    }

    public static function getByAbroadApplication($id)
    {
        return self::where('abroad_application_id', $id)->get();
    }

    public function updateApplicationSchool($request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->school_id = $request->school;
            $this->apply_date = $request->apply_date;
            $this->type = $request->type_school;
            $this->requirement = $request->requirement;

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

    public static function createApplicationSchool($request)
    {
        // Xử lý dữ liệu từ request để tạo link mạng xã hội
        $applicationSchool = new ApplicationSchool();
        $applicationSchool->abroad_application_id = $request->id;
        $applicationSchool->school_id = $request->school;
        $applicationSchool->apply_date = $request->apply_date;
        $applicationSchool->type = $request->type_school;
        $applicationSchool->requirement = $request->requirement;

        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $applicationSchool->save();

        return $applicationSchool;
    }

    public function updateActiveApplicationSchool()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('application_school')->update(['status' => self::STATUS_ACTIVE]);

            DB::commit();

            // Return the number of updated rows
            return $updated;
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
    }

    public function uploadConfirmationFileFromRequest($request)
    {
        $file = $request->file('file_confirmation');

        if (!$file) {
            return 'No file uploaded';
        }

        $applicationSchool = ApplicationSchool::find($request->id);

        if (!$applicationSchool) {
            return 'Application school not found';
        }

        try {
            $this->uploadConfirmationFile($file);
           
            return ''; // Return empty string if successful
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function uploadConfirmationFile($file)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_CONFIRMATION_FILE_URL;
    
        if (!$file) {
            throw new \Exception('File upload not found!');
        }
    
        $extension = $file->getClientOriginalName();
        $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;
    
        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    
        // Save file
        $file->move($path, $fileName);
    
        // Set the file name in the model attribute
        $this->file_confirmation = $fileName;
    
        // Save the model to update the database
        $this->save();
    }

    public function deleteFileComfirmationFromRequest()
    {
        $this->deleteFileComfirmationFile($this->file_confirmation);
        $this->file_confirmation = null;
        $this->save();
    }

    public function deleteFileComfirmationFile($fileName)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_CONFIRMATION_FILE_URL;
        $path = public_path(AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl);
        $filePath = $path . '/' . $fileName;
         
        unlink($filePath);
    }
     
    public function uploadFeePaidFileFromRequest($request)
    {
        $file = $request->file('file_fee_paid');

        if (!$file) {
            return 'No file uploaded';
        }

        $applicationSchool = ApplicationSchool::find($request->id);

        if (!$applicationSchool) {
            return 'Application school not found';
        }

        try {
            $this->uploadFeePaidFile($file);
           
            return ''; 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function uploadFeePaidFile($file)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_FEE_FILE_URL;
    
        if (!$file) {
            throw new \Exception('File upload not found!');
        }
    
        $extension = $file->getClientOriginalName();
        $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;
    
        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    
        // Save file
        $file->move($path, $fileName);
    
        // Set the file name in the model attribute
        $this->file_fee_paid = $fileName;
    
        // Save the model to update the database
        $this->save();
    }

    public function deleteFileFeePaidFromRequest()
    {
        $this->deleteFileFeePaid($this->file_fee_paid);
        $this->file_fee_paid = null;
        $this->save();
    }

    public function deleteFileFeePaid($fileName)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_FEE_FILE_URL;
        $path = public_path(AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl);
        $filePath = $path . '/' . $fileName;
         
        unlink($filePath);
    }

    public function getPathOfConfimationFile()
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_CONFIRMATION_FILE_URL;
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->file_confirmation;

        if (!is_dir($mediaPath)) {
            return $mediaPath;
        }

        return $mediaPath;
    }

    public function getPathOfFeePaidFile()
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_APPLICATION_FEE_FILE_URL;
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->file_fee_paid;

        if (!is_dir($mediaPath)) {
            return $mediaPath;
        }

        return $mediaPath;
    }

    public function getPathOfScholarshipFile()
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_SCHOLARSHIP_FILE_URL;
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->scholarship_file;

        if (!is_dir($mediaPath)) {
            return $mediaPath;
        }

        return $mediaPath;
    }

    public function deleteScholarshipFile()
    {
        $this->deleteFileScholarship($this->scholarship_file);
        $this->scholarship_file = null;
        $this->save();
    }

    public function deleteFileScholarship($fileName)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_SCHOLARSHIP_FILE_URL;
        $path = public_path(AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl);
        $filePath = $path . '/' . $fileName;
         
        unlink($filePath);
    }
    
    public function uploadScholarshipFileFromRequest($request)
    {
        $file = $request->file('scholarship_file');

        if (!$file) {
            return 'No file uploaded';
        }

        $applicationSchool = ApplicationSchool::find($request->id);

        if (!$applicationSchool) {
            return 'Application school not found';
        }

        try {
            $this->uploadScholarshipFile($file);
           
            return ''; 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function uploadScholarshipFile($file)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_SCHOLARSHIP_FILE_URL;
    
        if (!$file) {
            throw new \Exception('File upload not found!');
        }
    
        $extension = $file->getClientOriginalName();
        $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;
    
        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    
        // Save file
        $file->move($path, $fileName);
    
        // Set the file name in the model attribute
        $this->scholarship_file = $fileName;
    
        // Save the model to update the database
        $this->save();
    }

    public function doneCreateRecruitmentResults($request)
    {
        $this->study = $request->study;
        $this->result = $request->result;
        $this->scholarship = str_replace(',', '', $request->scholarship);

        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $this->save();

        return $this;
    }
    
    public function updateActiveRecruitmentResults()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('application_school')
                ->update(['status_recruitment_results' => self::STATUS_ACTIVE]);


            DB::commit();

            // Return the number of updated rows
            return $updated;
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
    }

//Hồ sơ du học
    public function uploadStudyAbroadApplicationFile($request)
    {
        $file = $request->file('study_abroad_application');

        if (!$file) {
            return 'No file uploaded';
        }

        $applicationSchool = ApplicationSchool::find($request->id);

        if (!$applicationSchool) {
            return 'Application school not found';
        }

        try {
            $this->uploadFileStudyAbroadApplication($file);
           
            return ''; // Return empty string if successful
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function uploadFileStudyAbroadApplication($file)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_STUDY_ABROAD_APPLICATION_FILE_URL;
    
        if (!$file) {
            throw new \Exception('File upload not found!');
        }
    
        $extension = $file->getClientOriginalName();
        $path = AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;
    
        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    
        // Save file
        $file->move($path, $fileName);
    
        // Set the file name in the model attribute
        $this->study_abroad_application = $fileName;
    
        // Save the model to update the database
        $this->save();
    }

    public function deleteFileStudyAbroadApplication()
    {
        
        $this->deleteStudyAbroadApplicationFile($this->study_abroad_application);
        $this->study_abroad_application = null;
        $this->save();
    }

    public function deleteStudyAbroadApplicationFile($fileName)
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_STUDY_ABROAD_APPLICATION_FILE_URL;
        $path = public_path(AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl);
        $filePath = $path . '/' . $fileName;
         
        unlink($filePath);
    }

    public function getPathOfStudyFile()
    {
        $suffixUrl = AbroadApplication::SUFFIX_SAVE_STUDY_ABROAD_APPLICATION_FILE_URL;
        $path = '/' . AbroadApplication::PREFIX_SAVE_FILE_URL . $this->abroad_application_id . '/' . $suffixUrl;
        $mediaPath =  $path. '/' . $this->study_abroad_application;

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
    public static function isCheckFillKQDT($abroad_application_id){
        

        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query) {
            $query->whereNotNull('scholarship')
                ->orWhereNotNull('result')
                ->orWhereNotNull('study')
                ->orWhereNotNull('file_confirmation')

                ->orWhereNotNull('scholarship_file')
                ->orWhereNotNull('scholarship_file');
        })
        ->exists();
    }
    public static function isCheckFillApplicationFee($abroad_application_id){

        return self::where('abroad_application_id', $abroad_application_id)
        ->where(function ($query) {
            $query->whereNotNull('file_confirmation')
                ->orWhereNotNull('file_fee_paid');
                
        })
        ->exists();
    }

}
