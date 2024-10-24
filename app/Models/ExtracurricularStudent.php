<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

class ExtracurricularStudent extends Model
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    protected $table = 'extracurricular_students';
    protected $fillable = ['student_id', 'extracurricular_id', 'amount', 'received_date', 'account_id', 'note'];

    // scan of information
    private const SUFFIX_SAVE_IMAGE_OF_EXTRACURRICULAR_STUDENT_URL = 'image_extracurricular_student/';
    public const PREFIX_SAVE_FILE_URL = 'uploads/app/abroad/extracurricular/';
    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        if (
            $sortColumn === 'name' ||
            $sortColumn === 'email' ||
            $sortColumn === 'father_id' ||
            $sortColumn === 'mother_id'
        ) {
            return $query
                ->join('order_items', 'order_items.id', '=', 'abroad_applications.order_item_id')
                ->join('orders', 'orders.id', '=', 'order_items.id')
                ->join('contacts', 'orders.contact_id', '=', 'contacts.id')
                ->select('abroad_applications.*')
                ->orderBy('contacts.' . $sortColumn, $sortDirection);
        }

        if ($sortColumn === 'code') {
            return $query
                ->join('order_items', 'order_items.id', '=', 'abroad_applications.order_item_id')
                ->join('orders', 'orders.id', '=', 'order_items.id')
                ->select('abroad_applications.*')
                ->orderBy('orders.' . $sortColumn, $sortDirection);
        }

        return $query->orderBy('abroad_applications.' . $sortColumn, $sortDirection);
    }

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id', 'id');
    }

    public function orderItems()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id', 'id');
    }

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public static function getByExtracurricularId($id)
    {
        return self::where('extracurricular_id', $id)->get();
    }

    public static function saveExtracurricularStudent($request)
    {
        // Xử lý dữ liệu từ request để tạo link mạng xã hội
        $extracurricularStudent = new ExtracurricularStudent();
        $extracurricularStudent->student_id = $request->contact_id;
        $extracurricularStudent->extracurricular_id = $request->extracurricularId;
        $extracurricularStudent->account_id = $request->account_id;
        $extracurricularStudent->amount = $request->amount;
        $extracurricularStudent->received_date = $request->payment_date;
        $extracurricularStudent->note = $request->description;
        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $extracurricularStudent->save();

        return $extracurricularStudent;
    }

    public static function getByContact($id)
    {
        $extracurricularStudents = self::where('student_id', $id)->get();

        return $extracurricularStudents;
    }

    public static function scopeFilterByStudent($query, $student)
    {
        $query->whereHas('student', function ($q) use ($student) {
            $q->where('id', $student->id);
        });
    }
    public function uploadImageExtracurricularStudentFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadImageExtracurricularStudent($request->file('file'));

        return $validator->errors();
    }

    public function uploadImageExtracurricularStudent($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_IMAGE_OF_EXTRACURRICULAR_STUDENT_URL;

        if (!$file) {
            throw new \Exception('CV upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        } 

        // Save file
        $file->move($path, $fileName);
    }
    
    public function getAllImageExtracurricularStudent()
    {
        $suffixUrl = self::SUFFIX_SAVE_IMAGE_OF_EXTRACURRICULAR_STUDENT_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);
            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function deleteImageExtracurricularStudentFile($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteImageExtracurricularStudentDone($request->fileName);

        return $validator->errors();
    }
    public function deleteImageExtracurricularStudentDone($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_IMAGE_OF_EXTRACURRICULAR_STUDENT_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('CV file not found!');
        }

        // Remove file
        unlink($filePath);
    }
}
