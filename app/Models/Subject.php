<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public const EDU_TYPE = 'Academic';
    public const KID_TYPE = 'Kid';

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public static function getAllTypes()
    {
        return [
            self::EDU_TYPE, 
            self::KID_TYPE,
        ];
    }

    public static function getAllSubjectsInUnique()
    {
        $subjects = self::all();
        
        $sortedSubjects = $subjects->unique('name');
        $sortedSubjects = $sortedSubjects->values();

        return $sortedSubjects;
    }
    
    public static function getSubjectsByType($type)
    {
        $subjects = self::where('type', $type)->distinct('name')->get();
        
        $sortedSubjects = $subjects->unique('name');
        $sortedSubjects = $sortedSubjects->values();

        return $sortedSubjects;
    }

    public static function getLevelsBySubjectName($name)
    {
        return self::where('name', $name)->distinct()->pluck('level');
    }

    /**
     * Get all subject for selector with uniq values
     */
    public static function getUniqueRecords()
    {
        $subquery = self::selectRaw('MIN(id) as id')->groupBy('name');
        $uniqueRecords = self::joinSub($subquery, 'sub', function ($join) {
            $join->on('subjects.id', '=', 'sub.id');
        })->get();
    
        return $uniqueRecords;
    }
    
    public static function getLevels()
    {
        $levels = self::pluck('level')->toArray(); 
        $levels = array_filter($levels);

        return $levels;
    }

    public static function getAllSubjectTypes()
    {
        $types = self::pluck('type')->toArray();
        $types = array_filter($types);

        return array_unique($types);
    }

    public static function getTypesByLevel($level)
    {
        $types = self::where('level', $level)
                   ->pluck('type')
                   ->unique()
                   ->toArray();
        $types = array_filter($types);

        return $types;
    }

    public function getCode()
    {
        $nameNormalized = \App\Helpers\Functions::normalizeString($this->name);
        $nameNormalizedUpper = strtoupper($nameNormalized);
        $pattern = '/[^a-zA-Z0-9\s]/';
        $nameNormalizedUpper = preg_replace($pattern, '', $nameNormalizedUpper);
        $code = $nameNormalizedUpper . str_pad((string) $this->id, 3, '0', STR_PAD_LEFT);
        return $code;
    }

    public function scopeHasName($query, $name)
    {
        $query->where('name', $name);
    }

    public function scopeHasLevel($query, $level)
    {
        $query->where('level', $level);
    }
}
