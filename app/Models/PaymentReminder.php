<?php

namespace App\Models;

use App\Helpers\Functions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class PaymentReminder extends Model
{

    public const STATUS_PAID = 'paid';
    public const STATUS_UNPAID = 'unpaid';

    public const STATUS_APPROVED = 'approved';
    protected $table = 'payment_reminder'; // Đặt tên bảng tại đây

    public const STATUS_IS_PAID = 'Đã thanh toán';
    public const STATUS_REACHING_DUE_DATE = 'Tới hạn thanh toán';
    public const STATUS_PART_PAID = 'Đã thu 1 phần';
    public const STATUS_OVER_DUE_DATE = 'Quá hạn';

    public const STATUS_IS_UNPAID = 'Chưa thanh toán';

    protected $fillable = ['order_id', 'tracking_amount', 'amount', 'due_date', 'progress'];

    public function contacts()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public static function scopeSearch($query, $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            $query->orWhereHas('order.contacts', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%");
            })

                ->orWhereHas('order', function ($query) use ($keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                });
        });
    }
    public static function getAllProgressesOptions()
    {
        // 
        $progressesOptions = self::pluck('progress')->toArray();
        $progressesOptions = array_unique($progressesOptions);
        $progressesOptions = array_values($progressesOptions);

        // Duyệt qua mảng và gán 'Thanh toán 1 lần' cho các giá trị null
        foreach ($progressesOptions as $key => $value) {
            if ($value === null) {
                $progressesOptions[$key] = 'Thanh toán 1 lần';
            }
        }
        $key = array_search('Thanh toán 1 lần', $progressesOptions);
        if ($key !== false) {
            unset($progressesOptions[$key]);
            array_unshift($progressesOptions, 'Thanh toán 1 lần');
        }

        return $progressesOptions;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id'); // 'order_id' là tên cột khóa ngoại trong bảng 'payment_reminder'
    }
    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class, 'order_id', 'order_id');
    }
    public function scopeActive($query)
    {
        return $query->whereHas('order', function ($q) {
            $q->notDeleted();
        });
    }
    public function scopeApproved($query)
    {
        $query->whereHas('order', function ($query) {
            $query->where('status', self::STATUS_APPROVED);
        });
    }

    public function scopePartPaid($query)
    {
        return $query
            ->select('payment_reminder.*')
            ->whereIn('payment_reminder.order_id', function ($subquery) {
                $subquery->select('order_id')
                    ->from('payment_records');
            });
    }


    public function isPaid()
    {
        return $this->getDebtAmountInProgress() <= 0;
    }
    public function scopeReachingDueDate($query, $days = 30)
    {
        return $query->whereNotNull('due_date')
        ->whereBetween('payment_reminder.due_date', [now(), now()->addDays($days)]);
    }

    public function scopeOverDueDate($query, $days = 1)
    {
        $query->whereNotNull('due_date')
            ->where('payment_reminder.due_date', '<', now()->subDays($days));
    }

    public function scopePaid($query)
    {
        return $query->get()->filter(function ($reminder) {
            return $reminder->getStatusProgress() === self::STATUS_PAID;
        });
    }

    public function scopeCheckIsPaid($query)
    {
        return $query->where('tracking_amount', '<=', function ($subquery) {
            $subquery->select(DB::raw('COALESCE(SUM(amount), 0)'))
                ->from('payment_records')
                ->whereColumn('order_id', 'payment_reminder.order_id');
        });
    }

    public function scopeCheckIsNotPaid($query)
    {
        return $query->where('tracking_amount', '>', function ($subquery) {
            $subquery->select(DB::raw('COALESCE(SUM(amount), 0)'))
                ->from('payment_records')
                ->whereColumn('order_id', 'payment_reminder.order_id');
        });
    }



    public function getReceivableAmount()
    {
        return max($this->amount - $this->getPaidAmount(), 0);
    }

    public function getAmount()
    {
        return $this->tracking_amount - $this->getPaidAmount();
    }
    public function getPaidAmountInProgress()
    {
        // $amount = $this->getAmount();
        // $previousTrackingAmount = $this->getPreviousProgressTrackingAmount($this->order_id, $this->progress);

        // if ($previousTrackingAmount === 0) {
        //     return $this->tracking_amount > $this->getPaidAmount() ? $this->getPaidAmount() : $this->amount;
        // }

        // if ($this->tracking_amount <= $this->getPaidAmount()) {
        //     return $this->amount;
        // }

        // return ($amount < 0 || $previousTrackingAmount > $this->getPaidAmount())
        //     ? 0
        //     : $this->getPaidAmount() - $this->getPreviousProgressAmount($this->order_id, $this->progress);
        // return $this->order->paymen?
        if($this->order->is_pay_all ==='on'){
            return $this->getPaidAmount();
        }
        else{
        $result = $this->amount -$this->getDebtAmountInProgress();
                return $result < 0 ? 0 : $this->amount -$this->getDebtAmountInProgress();
        }
        
    }

    public function getDebtAmountInProgress()
    {
        // $previousTrackingAmount = $this->getPreviousProgressAmount($this->order_id, $this->progress);

        // if ($previousTrackingAmount === 0) {
        //     return $this->tracking_amount - $this->getPaidAmount() < 0 ? 0 : $this->tracking_amount - $this->getPaidAmount();
        // }

        // if ($this->getPaidAmountInProgress() === 0) {
        //     return $this->amount;
        // }
        if ($this->order->is_pay_all === 'on') {
            return $this->order->getTotal() - $this->getPaidAmount() < 0 ? 0 : $this->order->getTotal() - $this->getPaidAmount();
        } 
      
        $result = $this->amount + $this->tracking_amount - $this->getPaidAmount();
        return $result < 0 ? 0 : $result;
        

    }
    public function scopeGetPreviousProgressAmount($query, $order_id, $progressValue)
    {
        if ($progressValue > 2) {
            $sumAmount = $query->where('order_id', $order_id)
                ->where('progress', '<', $progressValue)
                ->orderBy('due_date', 'desc')
                ->sum('amount');

            return $sumAmount;
        }

        return 0;
    }
    public function getPaidAmount()
    {
        return $this->paymentRecords->where('status', PaymentRecord::STATUS_PAID)->sum('amount');
    }
    public function getStatus()
    {
        return $this->isPaid() ? self::STATUS_PAID : self::STATUS_UNPAID;
    }
    public function getStatusProgress()
    {
        if ($this->order->is_pay_all == 'on') {
            return $this->getSumAmountPaid() >= $this->order->getTotal() ? self::STATUS_PAID : self::STATUS_UNPAID;
        } else {
            
            return $this->getDebtAmountInProgress() <=0 ? self::STATUS_PAID : self::STATUS_UNPAID;
        }
    }
    


    public function getSumAmountPaid()
    {
        return $this->order->paymentRecords()->sum('amount');
    }
    public function scopeLastDueDate($query, $orderId)
    {
        return $query->where('payment_reminder.order_id', $orderId)
            ->orderBy('payment_reminder.due_date', 'desc')
            ->limit(1);
    }

    public function isHavePreviousProgress($order_id, $progressValue)
    {
        $previousProgress = $progressValue - 1;

        return $this->where('payment_reminder.order_id', $order_id)
            ->where('payment_reminder.progress', $previousProgress)
            ->exists();
    }

    public function scopeGetPreviousProgressTrackingAmount($query, $order_id, $progressValue)
    {
        $previousProgress = $progressValue - 1;

        $tracking_amount = $query->where('order_id', $order_id)
            ->where('progress', $previousProgress)
            ->value('tracking_amount');

        return ($progressValue  === null || $progressValue  == 1) ? 0 : $tracking_amount;
    }


    // public function paid()
    // {
    //     $this->status = self::STATUS_PAID;
    //     $this->save();
    // }

    public static function scopeFilterByContact($query, $contact)
    {
        return $query->where('order.contact_id', $contact);
    }

    public static function scopeFilterByStudentId($query, $studentId)
    {
        return $query->where('order.student_id', $studentId);
    }

    public static function scopeFilterByIndustries($query, $industries)
    {
        return $query->whereIn('order.industry', $industries);
    }

    public static function scopeFilterByOrderTypes($query, $orderTypes)
    {
        return $query->whereIn('order.type', $orderTypes);
    }

    public static function scopeFilterByTypes($query, $types)
    {
        return $query->whereIn('order.type', $types);
    }

    public static function scopeFilterBySales($query, $sales)
    {
        return $query->whereIn('order.sale', $sales);
    }

    public static function scopeFilterBySaleSups($query, $saleSups)
    {
        return $query->whereIn('order.sale_sup', $saleSups);
    }
    public static function scopeFilterByProgressTypes($query, $progressTypes)
    {
        if (in_array("Thanh toán 1 lần", $progressTypes)) {

            return $query->whereNull('payment_reminder.progress');
        }

        $progressTypes = array_map('intval', $progressTypes);
        return $query->whereIn('payment_reminder.progress', $progressTypes);
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('payment_reminder.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('order.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByDueDate($query, $due_date_from, $due_date_to)
    {
        if (!empty($due_date_from) && !empty($due_date_to)) {
            return $query->whereBetween('payment_reminder.due_date', [$due_date_from, \Carbon\Carbon::parse($due_date_to)->endOfDay()]);
        }

        return $query;
    }

    public function progressStatusNotCompleted()
    {
        return $this->progress
            ? self::where('order_id', $this->order_id)
            ->where('progress', '<', $this->progress)
            ->exists()
            : false;
    }

    public function isNotPaidAndProgressNotCompleted()
    {
        return $this->checkIsNotPaid() && $this->progressStatusNotCompleted();
    }


    public function getProgressName()
    {
        return $this->attributes['progress']
            ? 'Đợt ' . $this->attributes['progress']
            : 'Thanh toán 1 lần';
    }

    public function getRemainAmount()
    {
        return $this->tracking_amount - $this->order->getPaidAmount();
    }
    public function scopeByOrderBranch($query, $branch)
    {
        return $query->whereHas('order', function ($q) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $q->byBranch($branch);
            }
        });
    }
    public static function sumAmountReachingDueDateNotPaid($query)
    {
        return $query->reachingDueDate()
            ->checkIsNotPaid()
            ->sum('amount');
    }
    

    public static function sumAmountOutDueDateNotPaid($query)
    {
        return $query->overDueDate()
            ->checkIsNotPaid()
            ->sum('amount');
    }

    public static function getPaidRemindersByBranch($branch)
    {
        $paidReminders = static::approved()
                            ->byOrderBranch($branch)
                            ->get()
                            ->filter(function ($paymentReminder) {
                                return $paymentReminder->getStatusProgress() === self::STATUS_PAID;
                            });

        return $paidReminders;
    }

    public static function getPartPaidRemindersByBranch($branch)
    {
        $paidReminders = static::approved()->partPaid()
                            ->byOrderBranch($branch)
                            ->get()
                            ->filter(function ($paymentReminder) {
                                return $paymentReminder->getStatusProgress() === self::STATUS_UNPAID;
                            });

        return $paidReminders;
    }

    public static function getOverDueRemindersByBranch($branch)
    {
        
        $paidReminders = static::approved()->overDueDate()
                                ->byOrderBranch($branch)
                            ->get()
                            ->filter(function ($paymentReminder) {
                                return $paymentReminder->getStatusProgress() === self::STATUS_UNPAID;
                            });

        return $paidReminders;
    }

    public static function getReachingDueDateRemindersByBranch($branch)
    {
        
        $paidReminders = static::approved()->reachingDueDate()
                            ->byOrderBranch($branch)
                            ->get()
                            ->filter(function ($paymentReminder) {
                                return $paymentReminder->getStatusProgress() === self::STATUS_UNPAID;
                            });

        
        return $paidReminders;
    }

    public static function sumAmountFromReminders($reminders)
    { 
        $sum = 0;
 
        foreach ($reminders as $paymentReminder) {
            $sum += $paymentReminder->amount;
        }

        return $sum;
    }
    // public static function getPaidRemindersPaid()
    // {
        
    //     $paidReminders = static::all()->filter(function ($paymentReminder) {
    //         return $paymentReminder->getStatusProgress() === self::STATUS_PAID;
    //     });

        
    //     return $paidReminders;
    // }

    public static function countPaidReminders($query)
    {
        return $query->get()->filter(function ($paymentReminder) {
            return $paymentReminder->getStatusProgress() === PaymentReminder::STATUS_PAID;
        })->count();
    }

    public static function sumPaidRemindersAmount($query)
    { 
        return $query->checkIsPaid()->sum('payment_reminder.amount');
    }

    public static function countReachingDueDateReminders($query)
    { 
        return $query->checkIsNotPaid()->reachingDueDate()->count();
    }

    public static function sumReachingDueDateRemindersAmount($query)
    { 
        return $query->checkIsNotPaid()->reachingDueDate()->sum('payment_reminder.amount');
    }

    public static function countOutdatedReminders($query)
    {
        return $query->checkIsNotPaid()->overDueDate()->count();
    }

    public static function sumOutdatedRemindersAmount($query)
    {
        return $query->checkIsNotPaid()->overDueDate()->sum('payment_reminder.amount');
    }

    public function scopeByBranch($query, $branch)
    {
        $query =  $query->whereHas('order', function ($q) use ($branch) {
            $q->byBranch($branch);
        });
        return $query;
    }

    public function scopeReachingDueDate30DaysNotification($query) { 
        $query = $query->with('order')->approved()->reachingDueDate()->checkIsNotPaid();
    }
  
    public function scopeReachingDueDate14DaysNotification($query, $days = 14) { 
        $query = $query->with('order')->approved()->whereNotNull('due_date')
            ->where('payment_reminder.due_date', '<', now()->addDays($days))->checkIsNotPaid();
    }

    public function scopeOverdueNotification($query) { 
        $query = $query->with('order')->approved()->overDueDate()->checkIsNotPaid();
    }
   
    public static function getFirstUnpaidReminder(Collection $schedulePayments)
    {
        $unpaidReminders = $schedulePayments->filter(function ($paymentReminder) {
            return $paymentReminder->getStatusProgress() === 'unpaid';
        });
        $total=0;
        $firstUnpaidReminder = $unpaidReminders->first();
      
        foreach ($unpaidReminders as $unpaidReminder) {
            $dueDate =  $unpaidReminder->due_date;
            if ($dueDate <=  Carbon::now()) {
                $total = $unpaidReminder->getDebtAmountInProgress();
            }   
        }
       
        return $total;
    
    }
    public static function getDebtAmountForOrder($order, Collection $schedulePayments)
    {
        if ($order->is_pay_all == 'off') {
            return self::getFirstUnpaidReminder($schedulePayments);
        } else {
            return max(0, $order->getTotal() - $order->sumAmountPaid());
        }
    }
    
}
