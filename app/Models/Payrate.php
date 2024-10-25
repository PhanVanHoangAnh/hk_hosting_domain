<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Payrate extends Model
{
    use HasFactory;

    public const CURRENCY_TYPE_USD = 'USD';
    public const CURRENCY_TYPE_VND = 'VND';
    
    protected $fillable = [
        'amount',                    
        'effective_date',      
        'subject_id',      
        'teacher_id',            
        'type',                    
        'training_location_id',
        'study_method',
        'class_status',
        'class_size',
        'currency'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public static function getAllCurrencyTypes()
    {
        return [
            self::CURRENCY_TYPE_USD,
            self::CURRENCY_TYPE_VND,
        ];
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->where('type', 'LIKE', "%{$keyword}%")
                ->orWhereHas('subject', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('teacher', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
        });
    }
    
    public static function newDefault()
    {
        $salarySheet = new self();
        return $salarySheet;
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'training_location_id' => 'required',
            'study_method' => 'required',
            'class_status' => 'required',
            'class_size' => 'required',
            'currency' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();

        return $validator->errors();
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('payrates.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }
    
        return $query;
    }
    
    public static function scopeFilterByEffectiveDate($query, $effective_date_from, $effective_date_to)
    {
        if (!empty($effective_date_from) && !empty($effective_date_to)) {
            return $query->whereBetween('payrates.effective_date', [$effective_date_from, \Carbon\Carbon::parse($effective_date_to)->endOfDay()]);
        }
    
        return $query;
    }

    public static function scopeFilterByTeachers($query, $teachers)
    {
        $query = $query->whereHas('teacher', function ($query) use ($teachers) {
            $query->whereIn('id', $teachers);
        });
    }

    public static function scopeFilterBySubjects($query, $subjects)
    {
        $query = $query->whereHas('subject', function ($query) use ($subjects) {
            $query->whereIn('id', $subjects);
        });
    }

    public static function scopeFilterByTypes($query, $types)
    {
        return $query->whereIn('type', (array) $types);
    }

    public function getSelect2Text()
    {
        return $this->name;
    }

    public static function scopeSelect2($query, $request)
    {
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // pagination
        $records = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'text' => $record->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $records->lastPage() != $request->page,
            ],
        ];
    }

    public function scopeSubjectTeachers($query, $subjectId)
    {
        return $query
            ->where('subject_id', $subjectId)
            ->whereHas('teacher', function ($teacherQuery) {
                $teacherQuery->whereNotIn('type', [Teacher::TYPE_HOMEROOM, Teacher::TYPE_ASSISTANT]);
            });
    }

    public static function exportToExcel($templatePath, $filteredPayrates)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filteredPayrates as $index => $payrate) {
            $rowData = [
                $index+1,
                $payrate->teacher->name,
                $payrate->subject->name,
                $payrate->type,
                $payrate->amount,
                $payrate->effective_date,
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public static function scopeByBranch($query, $branch)
    {
        return $query->whereHas('teacher', function ($q2) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $q2->byBranch($branch);
            }
        });
    }
}
