<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class RecommendationLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'abroad_application_id',
        'account_id',
        'name',
        'path',
        'date',
        'status'
    ];

    public const STATUS_DELETE = 'deleted';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';

    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public static function newDefault()
    {
        $recommendationLetter = new self();

        return $recommendationLetter;
    }

    public function saveFromRequest($request)
    {
        $this->abroad_application_id = $request->abroad_application_id;
        $this->account_id = $request->account_id;
        $this->name = $request->name;
        $this->date = $request->date;
        $this->status = self::STATUS_DRAFT;

        $validator = Validator::make($request->all(), [
            'abroad_application_id' => 'required',
            'account_id' => 'required',
            'name' => 'required',
            'date' => 'required',
            'file' => 'required|mimes:docx',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if (File::exists($this->path)) {
            File::delete($this->path);
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $path = 'uploads/abroad/recommendation_letters/';
            $fileName = time() . '.' . $extension;
            $file->move($path, $fileName);
        }

        $this->path = $path.$fileName;
        $this->save();

        return $validator->errors();
    }

    public function complete()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }

    public function remove()
    {
        $this->status = self::STATUS_DELETE;
        $this->save();
    }
}
