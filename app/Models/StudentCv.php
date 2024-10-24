<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class StudentCv extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_DELETED = 'deleted';

    protected $fillable = [
        'abroad_application_id',
        'path',
        'date'
    ];

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public static function newDefault()
    {
        $cv = new self();
        $cv->status = self::STATUS_NEW;

        return $cv;
    }

    public function saveFromRequest()
    {
        $this->date = $request->date;
        $this->abroad_application_id = $request->abroad_application_id;

        $validator = Validator::make($request->all(), [
            'abroad_application_id' => 'required',
            'date' => 'required',
            'file' => 'required|mimes:pdf,docx,doc,txt'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $path = 'upload/abroad/student_cvs/';
            $fileName = time() . '.' . $extension;
            $file->move($path, $fileName);
        }

        $this->path = $path.$fileName;
        $this->save();

        return $validator->errors();
    }

    public function remove()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }
}
