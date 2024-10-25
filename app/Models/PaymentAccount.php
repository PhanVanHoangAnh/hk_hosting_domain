<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PaymentAccount extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_DELETED = 'deleted';
    public const STATUS_PAUSE = 'pause';

    protected $fillable = ['name', 'bank', 'account_name', 'account_number', 'description', 'status', 'account_group_id'];

    public static function scopeSearch($query, $key)
    {
        $query->where(function ($subquery) use ($key) {
            $subquery->orWhere('description', 'LIKE', "%{$key}%")
            ->orWhere('bank', 'LIKE', "%{$key}%")
            ->orWhere('account_name', 'LIKE', "%{$key}%")
            ->orWhere('account_number', 'LIKE', "%{$key}%")
                ->orWhereHas('contact', function ($contactsSubquery) use ($key) {
                    $contactsSubquery->where('name', 'LIKE', "%{$key}%");
                });
                
        });
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'name', 'id');
    }

    public function staffGroups()
    {
        return $this->hasMany(StaffGroup::class);
    }

    public function account_group()
    {
        return $this->belongsTo(AccountGroup::class, 'account_group_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public static function newDefault()
    {
        $account = new self();
        $account->status = self::STATUS_ACTIVE;
        return $account;
    }


    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
           
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();

        return $validator->errors();
    }

    public static function scopeActive($query)
    {
        $query = $query->where('payment_accounts.status', self::STATUS_ACTIVE);
    }

    public static function scopeIsPause($query)
    {
        $query = $query->where('payment_accounts.status', self::STATUS_PAUSE);
    }
    public static function scopeInactive($query)
    {
        $query = $query->where('payment_accounts.status', self::STATUS_INACTIVE);
    }

    public static function scopeDeleted($query)
    {
        return $query->where('payment_accounts.status', self::STATUS_DELETED);
    }

    public function deletePaymentAccount()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
    public function isInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }
    public function isDeleted()
    {
        return $this->status === self::STATUS_DELETED;
    }

    public function pause()
    {
        $this->status = self::STATUS_PAUSE;
        $this->save();
    }

}
