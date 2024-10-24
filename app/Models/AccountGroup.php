<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AccountGroup extends Model
{
    use HasFactory;

    public const TYPE_STUDY_ABROAD = 'study_abroad';
    public const TYPE_TRAINING = 'training';
    public const TYPE_EXTRACURRICULAR = 'extracurricular';
    public const TYPE_TECHNOLOGY = 'technology';

    public const TYPE_SALES = 'sales';

    public const GROUP_TYPE_SALE_A = 'sale_a';
    public const GROUP_TYPE_SALE_B = 'sale_b';
    public const GROUP_TYPE_SALE_C = 'sale_c';
    public const GROUP_TYPE_MARKETING = 'marketing';
    public const GROUP_TYPE_ACCOUNTING = 'accounting';
    public const GROUP_TYPE_TVCL = 'tvcl';
    public const GROUP_TYPE_TTSK = 'ttsk';

    public const GROUP_TYPE_EDU = 'edu';

    protected $fillable = ['name', 'type', 'abroad_payment_account_id', 'edu_payment_account_id', 'extracurricular_payment_account_id', 'teach_payment_account_id', 'manager_id'];

    // public static function getAllType()
    // {
    //     return [
    //         self::TYPE_STUDY_ABROAD,
    //         self::TYPE_TRAINING,
    //         self::TYPE_EXTRACURRICULAR,
    //         self::TYPE_TECHNOLOGY
    //     ];
    // }

    public static function getAllGroupType()
    {
        return [
            self::GROUP_TYPE_SALE_A,
            self::GROUP_TYPE_SALE_B,
            self::GROUP_TYPE_SALE_C,
            self::GROUP_TYPE_MARKETING,
            self::GROUP_TYPE_ACCOUNTING,
            self::GROUP_TYPE_EDU
        ];
    }

    public function account()
    {
        return $this->hasMany(Account::class, 'account_group_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function manager()
    {
        return $this->belongsTo(Account::class, 'manager_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(Account::class);
    }

    public function paymentAccountAbroad()
    {
        return $this->belongsTo(PaymentAccount::class, 'abroad_payment_account_id');
    }
    public function paymentAccountEdu()
    {
        return $this->belongsTo(PaymentAccount::class, 'edu_payment_account_id');
    }
    public function paymentAccountExtracurricular()
    {
        return $this->belongsTo(PaymentAccount::class, 'extracurricular_payment_account_id');
    }
    public function paymentAccountTeach()
    {
        return $this->belongsTo(PaymentAccount::class, 'teach_payment_account_id');
    }
    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'LIKE', "%{$keyword}%");
    }

    public static function newDefault()
    {
        // Tạo một thể hiện mới của mô hình
        $accountGroup = new self();
        return $accountGroup;
    }

    public function saveFromRequest($request)
    {
        if (!$request->has('type')) {
            $request->merge(['type' => self::GROUP_TYPE_EDU]);
        }
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

    // public static function scopeDeleteAll($query, $ids)
    // {
    //     $accountGroups = self::whereIn('id', $ids)->get();

    //     foreach ($accountGroups as $accountGroup) {
    //         $accountGroup->delete();
    //     }
    // }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('account_groups.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('account_groups.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
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
    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('manager', function ($subquery) use ($branch) {
            $subquery->byBranch($branch);
        });
    }
 
    public function scopeSalesGroup($query, $branch)
    {
        return $query->whereNotNull('name')
                    ->where('name', '!=', '')
                    ->when($branch !== 'all', function ($query) use ($branch) {
                        $query->byBranch($branch);
                    })
                    ->whereHas('account', function ($accountQuery) {
                        $accountQuery->sales();
                    });
    }

    public function getAllAccountAndManagerIds()
    {
        return $this->members->pluck('id')->push($this->id);
    }

}
