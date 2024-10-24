<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    public static function scopeByPermission($query, $action)
    {
        $query = $query->where('permission', '=', $action);
    }
}
