<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingLocation extends Model
{
    use HasFactory;

    // Activity status
    public const STATUS_ACTIVE = '1';

    protected $fillable = [
        'branch',
        'name',
        'address',
        'status',
    ];

    public static function getBranchs()
    {
        return self::all()->pluck('branch')->unique();
    }

    public static function getLocationsByBranch($branch)
    {
        return self::where('branch', $branch)->get();
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public static function scopeByBranch($query, $branch)
    {
        if ($branch != \App\Library\Branch::BRANCH_ALL) {
            $query->where('branch', $branch);
        }
    }
}
