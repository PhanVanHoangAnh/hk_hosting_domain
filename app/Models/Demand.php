<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Demand extends Model
{
    use HasFactory;

    const STATUS_DELETED = 'deleted';
    const STATUS_ACTIVE = 'active';

    protected $fillable = [
        'name', 'creator_id', 'status',
    ];

    public static function newDefault($demandName)
    {
        $demand = new self();
        $demand->status = self::STATUS_ACTIVE;
        $demand->name = $demandName;

        return $demand;
    }

    public static function findOrCreate($demandName)
    {
        $demand = self::findByName($demandName);

        if (!$demand) {
            $demand = self::newDefault($demandName);
            $demand->save();
        }

        return $demand;
    }

    public function scopeActive($query)
    {
        return $query->where('demands.status', self::STATUS_ACTIVE);
    }

    public function scopeDeleted($query)
    {
        return $query->where('demands.status', self::STATUS_DELETED);
    }

    public static function findByName($demandName)
    {
        return self::where('name', $demandName)->first();
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function saveFromRequest($request)
    {
        $this->creator_id = auth()->id();
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();

        return $validator->errors();
    }

    public static function scopeSearch($query, $keyword)
    {
        $query->where(function ($subquery) use ($keyword) {
            $subquery->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhereHas('account', function ($accountsSubquery) use ($keyword) {
                    $accountsSubquery->where('name', 'LIKE', "%{$keyword}%");
                });
        });
    }

    public function deleteDemand()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public static function scopeDeleteListDemand($query, $ids)
    {
        $demands = self::whereIn('id', $ids)->get();
        foreach ($demands as $demand) {
            $demand->update(['status' => self::STATUS_DELETED]);
        }
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            $query->whereBetween('demands.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            $query->whereBetween('demands.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }
    }

    public static function scopeByAccountIds($query, $accountIds)
    {
        $query = $query->whereIn('creator_id', $accountIds);
    }

    public static function scopeFilterByStatuses($query, $status)
    {   
        $query = $query->whereIn('demands.status', $status);
    }

    public static function getAllStatus() 
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_DELETED
        ];
    }
}
