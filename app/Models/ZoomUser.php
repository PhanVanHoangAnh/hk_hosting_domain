<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'display_name',
        'email',
        'type',
        'pmi',
        'timezone',
        'verified',
        'dept',
        'record_created_at',
        'last_login_time',
        'pic_url',
        'language',
        'status',
        'role_id',
        'user_created_at',
    ];
}
