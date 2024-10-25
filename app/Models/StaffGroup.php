<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class StaffGroup extends Model
{
    use HasFactory;

    public const TYPE_EDU = 'edu';
    public const TYPE_MARKETING = 'marketing';
    public const TYPE_SALE = 'sale';
    public const TYPE_ACCOUNTING = 'accounting';

    protected $fillable = ['name', 'type', 'group_manager_id', 'default_payment_account_id'];

    public static function getAllType() 
    {
        return [
            self::TYPE_EDU,
            self::TYPE_MARKETING,
            self::TYPE_SALE,
            self::TYPE_ACCOUNTING
        ];
    }

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class, 'default_payment_account_id', 'id');
    }

    public static function newDefault()
    {
        $staffGroup = new self();
        return $staffGroup;
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'group_manager_id' => 'required',
            'type' => 'required',
            'default_payment_account_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();

        return $validator->errors();
    }

    public static function scopeSearch($query, $keyword) 
    {   
        $query = $query->where('staff_groups.name', 'LIKE', "%{$keyword}%")
                ->orWhere('staff_groups.type', 'LIKE', "%{$keyword}%");
    }

    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        return $query->orderBy($sortColumn, $sortDirection);
    }

    public static function scopeFilterByTypes($query, $types)
    {
        $query = $query->whereIn('staff_groups.type', $types);
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('staff_groups.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('staff_groups.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeDeleteAll($query, $items)
    {
        StaffGroup::whereIn('id', $items)->delete();
    }
}
