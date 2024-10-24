<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountKpiNote extends Model
{
    use HasFactory;
    
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAIL = 'fail';
    public const STATUS_RECEICED = 'received';
    protected $fillable = ['contact_id', 'account_id', 'note', 'amount', 'estimated_payment_date','subject_id', 'status', 'service_type', 'extracurricular_type'];
    protected $dates = ['estimated_payment_date'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public static function newDefault()
    {
        $account_kpi_notes = new self();
        return $account_kpi_notes;
    }
    public function scopeOverDueDate($query, $days = 1)
    {
        $query ->where('estimated_payment_date', '<', now()->subDays($days));
    }
    public static function scopePending($query)
    {
        $query = $query->where('status', self::STATUS_PENDING);
    }

    public static function getAllTypeVariable()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_FAIL,
            self::STATUS_RECEICED,
           
        ];
    }
    public static function scopeSearch($query, $key)
    {
        $query->where(function ($subquery) use ($key) {
            $subquery->orWhere('note', 'LIKE', "%{$key}%")
                ->orWhereHas('contact', function ($contactsSubquery) use ($key) {
                    $contactsSubquery->where('name', 'LIKE', "%{$key}%");
                })
                ->orWhereHas('account', function ($accountsSubquery) use ($key) {
                    $accountsSubquery->where('name', 'LIKE', "%{$key}%");
                });
        });
    }

    public function saveFromRequest($request)
    {
        $this->account_id = auth()->id();

        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',
            'service_type' => 'required',
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();

        return $validator->errors();
    }

    public static function scopeFilterByContactIds($query, $contactIds)
    {
        if (in_array('all', $contactIds)) {
            return $query;
        } else {
            return $query->whereIn('contact_id', $contactIds);
        } 
    }

    public static function scopeFilterByPaymentDate($query, $estimated_payment_date_from, $estimated_payment_date_to)
    {
        if (!empty($estimated_payment_date_from) && !empty($estimated_payment_date_to)) {
            return $query->whereBetween('created_at', [$estimated_payment_date_from, \Carbon\Carbon::parse($estimated_payment_date_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeDeleteListAcountKpiNotes($query, $noteIds)
    {
        AccountKpiNote::whereIn('id', $noteIds)->delete();
        return null;
    }

    public static function scopeInTimeRange($query, $startAt, $endAt)
    {
        $query->whereBetween('estimated_payment_date', [
            Carbon::parse($startAt)->startOfDay(),
            Carbon::parse($endAt)->endOfDay(),
        ]);
    }
    
    public function scopeInDateRangeForContact($query, $contactId, $startDate, $endDate)
    {
        return $query->where('contact_id', $contactId)
                     ->whereBetween('estimated_payment_date', [$startDate, $endDate]);
    }

    public function getWeeksInRange($start, $end)
    {
        $weeks = [];
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        // Tạo một khoảng thời gian từ ngày bắt đầu đến ngày kết thúc
        $period = CarbonPeriod::create($startDate, $endDate);

        // Duyệt qua mỗi tuần trong khoảng thời gian
        foreach ($period as $date) {
            
            // Lấy số thứ tự của tuần trong tháng
            $weekNumber = $date->weekOfMonth;

            // Thêm thông tin về tuần vào mảng
            $key = $date->startOfWeek()->format('Y-m-d') . '-' . $date->endOfWeek()->format('Y-m-d');

            // Thêm thông tin về tuần vào mảng nếu khóa chưa tồn tại
            if (!isset($uniqueWeeks[$key])) {
                $uniqueWeeks[$key] = [
                    'start' => $date->startOfWeek()->format('Y-m-d'),
                    'end' => $date->endOfWeek()->format('Y-m-d'),
                    'week_number' => $weekNumber,
                ];
            }
        }
        
        return $uniqueWeeks;
    }
    public static function scopeByBranch($query, $branch)
    {
        return $query->whereHas('account', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->where('branch', $branch);
            }
        });
    }
}