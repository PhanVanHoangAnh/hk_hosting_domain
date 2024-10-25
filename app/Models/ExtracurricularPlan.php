<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'content',
        'abroad_application_id',
        'status'
    ];

    public const STATUS_TEMPORARY = 'temporary';
    public const STATUS_DONE = 'done';
}
