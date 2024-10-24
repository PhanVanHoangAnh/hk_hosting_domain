<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanApplyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_id',
        'name'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function abroadApplications()
    {
        return $this->hasMany(AbroadApplication::class);
    }
}
