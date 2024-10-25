<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PaymentRecord extends Model
{
    use HasFactory;

    const STATUS_DELETED = 'deleted';
    const STATUS_ACTIVE = 'active';

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_REJECT = 'reject';
    const STATUS_PENDING_ONEPAY = 'pendingOnepay';

    const TYPE_REFUND = 'refund';
    const TYPE_RECEIVED = 'received';
    const TYPE_RECEIPT = 'receipt';

    const METHOD_CASH = 'Tiền mặt';
    const METHOD_BANK_TRANSFER = 'Chuyển khoản ngân hàng';
    const METHOD_POS = 'Thanh toán POS';
    const METHOD_ONE_PAY = 'Thanh toán OnePay';
    protected $fillable = ['contact_id', 'description', 'account_id', 'payment_date', 'order_id', 'order_item_id', 'amount', 'payment_account_id', 'method'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class, 'payment_account_id', 'id');
    }

    public static function newDefault()
    {
        $paymentRecord = new self();
        $paymentRecord->status = self::STATUS_PAID;
        return $paymentRecord;
    }

    public function approval()
    {
        $this->status = self::STATUS_PAID;
        $this->save();
    }
    public function reject()
    {
        $this->status = self::STATUS_REJECT;
        $this->save();
    }
    public function generateCode(){
        if($this->code){
            throw new \Exception('Payment remaider code exit!!!');
        }
        $currentYear = (new \DateTime($this->payment_date))->format('Y');
   
        $currentMonth = (new \DateTime($this->payment_date))->format('m');
        $currentDay = (new \DateTime($this->payment_date))->format('d');

        
        if($this->method == self::METHOD_CASH){
            $this->code_name = 'TM';
        }if($this->method == self::METHOD_BANK_TRANSFER){
            $this->code_name = 'CK';
        }if($this->method == self::METHOD_POS || $this->method == self::METHOD_ONE_PAY){
            $this->code_name = 'QT';
        }
        $codeName = $this->code_name;
        $maxCode = self::where('code_year', $currentYear)
        ->where('code_month', $currentMonth)
        ->where('code_day', $currentDay)
        ->where('code_name', $codeName)
        ->max('code_number');
        $codeNumber = $maxCode ? ($maxCode + 1) : 1;
        $this->code_year = $currentYear;
        $this->code_month = $currentMonth;
        $this->code_day = $currentDay;
        $this->code_number = $codeNumber;
        $this->code = $this->getCode();
        $this->save();
    }
    public function getCode()
    {
        $prefix = $this->code_name;
        $year = substr($this->code_year, 2, 2);
        $month = sprintf("%02s", $this->code_month);
        $day = sprintf("%02s", $this->code_day);

        if ($this->code_number > 9999) {
            $number = sprintf("%06s", $this->code_number);
        } else {
            $number = sprintf("%04s", $this->code_number);
        }
        
        return "{$prefix}{$year}{$month}{$day}{$number}";
    }

    public static function scopeSearch($query, $key)
    {
        $query->where(function ($subquery) use ($key) {
            $subquery->orWhere('description', 'LIKE', "%{$key}%") 
                ->orWhere('payment_records.id', $key)
                ->orWhere('amount', 'LIKE', "%{$key}%")
                ->orWhereHas('contact', function ($contactsSubquery) use ($key) {
                    $contactsSubquery->where('name', 'LIKE', "%{$key}%");
                })
                ->orWhereHas('account', function ($accountsSubquery) use ($key) {
                    $accountsSubquery->where('name', 'LIKE', "%{$key}%");
                })
                ->orWhereHas('orders', function ($contactsSubquery) use ($key) {
                    $contactsSubquery->where('code', 'LIKE', "%{$key}%");
                });
        });
    }
    public static function scopeFilterByContactIds($query, $contactIds)
    {
        if (in_array('all', $contactIds)) {
            return $query;
        } else {
            return $query->whereIn('contact_id', $contactIds);
        }
        ;
    }

    public static function scopeFilterByAccountId($query, $accountId)
    {
        $query = $query->where('account_id', $accountId);
    }
    public static function scopeFilterByOrderId($query, $orderId)
    {
        $query = $query->where('order_id', $orderId);
    }
    public static function scopeFilterByPaymentDate($query, $payment_date_from, $payment_date_to)
    {
        if (!empty($payment_date_from) && !empty($payment_date_to)) {
            return $query->whereBetween('payment_date', [$payment_date_from, \Carbon\Carbon::parse($payment_date_to)->endOfDay()]);
        }

        return $query;
    }
    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('payment_records.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }
    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('payment_records.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public function storeFromRequest($request)
    {
        // $this->account_id = auth()->id();
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',
            'method' => 'required',
            'order_id' => 'required',
            'payment_date' => 'required',
            'amount' => 'required|numeric',
        ]);

        $this->type = self::TYPE_RECEIVED;

        $this->order_id = $request->order_id;
        $order = Order::find($this->order_id );

        $this->account_id = $order->sale;
        
        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->generateCode();
    
        $this->save();
    
        return $validator->errors();
    }
    
    public function validateCacheTotal($validator)
    {
        
    }

    public function saveFromRequest($request)
    {
        // $this->account_id = auth()->id();
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required|gt:0',
            
        ]);

        $this->type = self::TYPE_RECEIVED;

        $this->order_id = $request->order_id;
        $order = Order::find($this->order_id );

        $this->account_id = $order->sale;
        if (intval($order->getTotal())<= intval($order->getPaidAmount())) {
            $validator->errors()->add('amount', 'Hợp đồng đã thanh toán');
            return $validator->errors();
        }
        $this->amount = $request->amount;
        $maxAllowedAmount = intval($order->getTotal()) - intval($order->getPaidAmount());

        if ($this->amount > $maxAllowedAmount) {
            $validator->errors()->add('amount', 'Số tiền lớn hơn dư nợ');
            return $validator->errors();
        }  
        
        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->generateCode();
        $this->save();
    
        return $validator->errors();
    }
    public function saveRefundPayment($request)
    {
        $this->account_id = auth()->id();
        
        $attributes = is_array($request->all()) ? $request->all() : $request->all()->toArray();

        $this->fill($attributes);
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',
            'amount' => 'required|numeric|gt:0', 
            'payment_account_id' => 'required',
        ]);

        $this->order_id = $request->order_id;
        $order = Order::find($this->order_id ); 
        $this->amount = $request->amount;
       
        if ($this->amount > $order->getPaidAmount()) {
            $validator->errors()->add('amount', 'Số tiền lớn hơn số tiền đã thu');
            return $validator->errors();
        }  

        $this->type = self::TYPE_REFUND;

        if ($validator->fails()) {
            return $validator->errors();
        }


        $this->save();

        return $validator->errors();
    }


    public function scopePaid($query)
    {
        $query =  $query->where('payment_records.status', self::STATUS_PAID);
    }
    public function scopePending($query)
    {
        $query =  $query->where('payment_records.status', self::STATUS_PENDING);
    }

    public function scopeIsDeleted($query)
    {
        $query = $query->where('payment_records.status', self::STATUS_DELETED);
    }

    public function scopeReceived($query)
    {
        $query =  $query->where('payment_records.type', self::TYPE_RECEIVED);
    }
    public function scopeRejected($query)
    {
        $query =  $query->where('payment_records.status', self::STATUS_REJECT);
    }
    public function scopeRefund($query)
    {
        $query =  $query->where('payment_records.type', self::TYPE_REFUND);
    }
    public function deletedPaymentRecords()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public static function exportToExcelFeeCollectionReport($templatePath, $filteredpaymentRecord)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        $iteration = 1;

        foreach ($filteredpaymentRecord as $paymentRecord) {
            // Date formatting
            $payment_date = $paymentRecord['payment_date'] ? Carbon::parse($paymentRecord['payment_date'])->format('d/m/Y') : null;

            $rowData = [
                $iteration,
                $payment_date,
                $paymentRecord->orders->id ?? 'N/A',
                '--',
                $paymentRecord->orders->code ?? 'N/A',
                $paymentRecord->contact->id,
                $paymentRecord->contact->name,
                $paymentRecord->orders->industry ?? 'N/A',
                number_format($paymentRecord->amount),
                '--',
                '--',
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            $iteration++;
        }
    }

    public static function getAmountForRefundRequest($orderItemId, $studentId)
    {
        return self::where('order_item_id', $orderItemId)
                    ->where('contact_id', $studentId)
                    ->sum('amount');
    }

    public static function latestForOrderAndStudent($orderId, $studentId)
    {
        return self::received()->paid()->where('order_id', $orderId)
                    ->where('contact_id', $studentId)->latest('created_at')
            ->first();
    }

    public static function sumReceivedAmountForContact($contactId)
    {
        return self::received()->paid()->where('contact_id', $contactId)->sum('amount');
    }
    public static function sumAmountRefundThisMonth($query)
    {
        return $query->refund()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
    }

    public static function sumAmountReceivedThisMonth($query)
    {
        return $query->received()->paid()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
    }


    public function scopeByOrderBranch($query, $branch)
    {
        $query = $query->whereHas('order', function ($q) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $q->byBranch($branch);
            }
        });
        return $query;
    }

    public function isPaid(){
        return $this->status == self::STATUS_PAID;
    }

    public function isPending(){
        return $this->status == self::STATUS_PENDING;
    }
    public function isPendingOnepay(){
        return $this->status == self::STATUS_PENDING_ONEPAY;
    }

    public function setPaid(){
        $this->status = self::STATUS_PAID;
        $this->save();
    }

    public function setPending(){
        $this->status = self::STATUS_PENDING;
        $this->save();
    }


    public function scopeCurrentMonth($query)
    {
        return $query->whereYear('payment_date', Carbon::now()->year)
                     ->whereMonth('payment_date', Carbon::now()->month);
    }
    public function scopePreviousMonth($query)
    {
        return $query->whereYear('payment_date', Carbon::now()->subMonth()->year)
                     ->whereMonth('payment_date', Carbon::now()->subMonth()->month);
    }
    

    public function scopeWeekOfMonth($query)
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $startOfWeek = $firstDayOfMonth->copy()->addWeeks(1 - 1)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        return $query->whereBetween('payment_date', [$startOfWeek, $endOfWeek]);
    }
    
}