<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Validator;

class Order extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const CURRENCY_CODE_VND = 'VND';
    public const CURRENCY_CODE_USD = 'USD';

    // const phục vụ cho lọc này kia thôi
    public const TYPE_GENERAL = 'general';

    // DB values: lưu trong db
    public const TYPE_REQUEST_DEMO = 'request-demo';
    public const TYPE_EDU = 'edu';
    public const TYPE_ABROAD = 'abroad';
    public const TYPE_EXTRACURRICULAR = 'extracurricular';

    //
    public const TYPE_KIDS = 'KIDs';

    public const STATUS_REACHING_DUE_DATE = 'Tới hạn thanh toán';
    public const STATUS_PART_PAID = 'Đã thu 1 phần';
    public const STATUS_PAID = 'Đã thu';
    public const STATUS_OVER_DUE_DATE = 'Quá hạn';

    protected $fillable = [
        'type',
        'contact_id',
        'student_id',
        'sale',
        'sale_sup',
        'fullname',
        'birthday',
        'phone',
        'email',
        'current_school',
        'parent_note',
        'industry',
        'type',
        'status',
        'price',
        'is_pay_all',
        'currency_code',
        'schedule_items',
        'discount_code',
        'exchange',
        'order_date',
        'status',
        'debt_due_date',
        'debt_allow',
        'import_id',
        'contact_request_id'
    ];

    public function getAllStatus()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PENDING,
            self::STATUS_APPROVED,
            self::STATUS_REJECTED,
        ];
    }

    public function getAllCurrencyCode()
    {
        return [
            self::CURRENCY_CODE_VND,
            self::CURRENCY_CODE_USD,
        ];
    }

    public function updateReminders()
    {
        // remove all current reminders
        $this->paymentReminders()->delete();

        $reminders = [];
        $total = $this->getTotal();

        // Trường hợp thanh toán 1 lần
        if ($this->is_pay_all == 'on') {
            if ($this->debt_allow == 'on') {
                $due_date = $this->debt_due_date;
            } else {
                $due_date = $this->created_at;
            }
            $reminders[] = [
                'order_id' => $this->id,
                'tracking_amount' => $this->getTotal(),
                'amount' => $this->getTotal(),
                'due_date' => $due_date,
            ];
        } else {
            //Trường thanh toán nhiều lần
            $scheduleItems = json_decode($this->schedule_items, true) ?? [];

            // Sắp xếp theo due_date
            usort($scheduleItems, function ($a, $b) {
                return strtotime(json_decode($a, true)['date']) - strtotime(json_decode($b, true)['date']);
            });

            //
            $total = $this->getTotal();
            $trackingAmount = 0;

            foreach ($scheduleItems as $progress => $item) {
                // HOÀN PHÍ: trong trường hợp hoàn phí thì order total sẽ bị giàm đi so với cấu hình lúc đầu
                // khi đó các đợt thanh toán sẽ bị dư
                // ==> đợt nào dư thì ko tại reminder đến khi đu thì thôi
                $scheduleItem = json_decode($item, true);

                if ($trackingAmount + $scheduleItem['price'] > $total) { // vượt số total của order
                    $reminderAmount = $total - $trackingAmount; // lấy số chưa thanh toán còn lại
                } else {
                    $reminderAmount = $scheduleItem['price'];
                }

                // tạo reminder
                $reminders[] = [
                    'order_id' => $this->id,
                    'amount' => $reminderAmount,
                    'tracking_amount' => $trackingAmount,
                    'due_date' => $scheduleItem['date'],
                    'progress' => $progress + 1,
                ];

                // 
                $trackingAmount += $reminderAmount;

                // break nếu đã đủ total
                if ($trackingAmount == $total) {
                    break;
                }
            }
        }

        if (!empty($reminders)) {
            foreach ($reminders as $reminder) {
                PaymentReminder::create($reminder);
            }
        }
    }

    public static function getAllTypeVariable()
    {
        return [
            self::TYPE_REQUEST_DEMO,
            self::TYPE_EDU,
            self::TYPE_ABROAD,
            // self::TYPE_KIDS,
            // self::TYPE_EXTRACURRICULAR,
        ];
    }

    public function scopeDeleted($query)
    {
        $query = $query->where('orders.status', self::STATUS_DELETED);
    }

    public function scopeNotDeleted($query)
    {
        $query = $query->whereNot('orders.status', self::STATUS_DELETED);
    }

    public function scopeActive($query)
    {
        $query = $query->where('orders.status', self::STATUS_ACTIVE);
    }

    public function scopeApproved($query)
    {
        $query = $query->where('orders.status', self::STATUS_APPROVED);
    }

    public function contacts()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id', 'id');
    }

    public static function studentIsSigners()
    {
        return self::whereColumn('student_id', '=', 'contact_id');
    }

    public static function parentIsSigners()
    {
        return self::whereColumn('student_id', '<>', 'contact_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function contactRequest()
    {
        return $this->belongsTo(ContactRequest::class);
    }

    public function salesperson()
    {
        return $this->belongsTo(Account::class, 'sale');
    }
    
    public function supersalesperson()
    {
        return $this->belongsTo(Account::class, 'sale_sup');
    }

    public function rejections()
    {
        return $this->hasMany(OrderRejection::class);
    }

    public static function newDefault()
    {
        $order = new self();
        $order->status = self::STATUS_DRAFT;
        $order->discount_code = 0;
        return $order;
    }

    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        return $query->orderBy($sortColumn, $sortDirection);
        // ->join('contacts as students', 'students.id', '=', 'orders.student_id')
        // ->orderBy($sortColumn, $sortDirection);
        return $query;

        if (false && $sortColumn === 'price') {
            return $query->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select('orders.*', DB::raw('SUM(order_items.price) as total_price'))
                ->groupBy(
                    'orders.id',
                    'orders.created_at',
                    'orders.updated_at',
                    'orders.contact_id',
                    'orders.birthday',
                    'orders.sale',
                    'orders.sale_sup',
                    'orders.fullname',
                    'orders.phone',
                    'orders.email',
                    'orders.current_school',
                    'orders.parent_note',
                    'orders.industry',
                    'orders.type',
                )
                ->orderBy('total_price', $sortDirection);
        } else {

            return $query->select('orders.*', 'students.name as student_name')
                ->join('contacts as students', 'students.id', '=', 'orders.student_id')
                ->orderBy($sortColumn, $sortDirection);
        }
    }

    public static function scopeFilterByContact($query, $contact)
    {
        return $query->where('contact_id', $contact);
    }

    public static function scopeFilterByStudentId($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public static function scopeFilterByIndustries($query, $industries)
    {
        return $query->whereIn('industry', $industries);
    }

    public static function scopeFilterByOrderTypes($query, $orderTypes)
    {
        return $query->whereIn('type', $orderTypes);
    }

    public static function scopeFilterByTypes($query, $types)
    {
        return $query->whereIn('type', $types);
    }

    public static function scopeFilterBySales($query, $sales)
    {
        return $query->whereIn('sale', $sales);
    }

    public static function scopeFilterBySaleSups($query, $saleSups)
    {
        return $query->whereIn('sale_sup', $saleSups);
    }

    public static function scopeFilterByScreenType($query, $screenType)
    {
        if ($screenType == self::TYPE_REQUEST_DEMO) {
            return $query->where('orders.type', self::TYPE_REQUEST_DEMO);
        }

        return $query;
    }
    public static function scopeFilterByTypeSubjects($query, $types)
    {
        return $query->whereHas('orderItems.subject', function ($query) use ($types) {
            $query->whereIn('type', $types);
        });
    }

    public static function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->whereRaw("fullname LIKE ?", ["%{$keyword}%"]);
            })
                ->orWhereHas('contacts', function ($q2) use ($keyword) {
                    $q2->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('student', function ($q3) use ($keyword) {
                    $q3->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
                })
                ->orWhere('orders.id', 'LIKE', "%{$keyword}%")
                ->orWhere('orders.birthday', 'LIKE', "%{$keyword}%")
                ->orWhere('orders.phone', 'LIKE', "%{$keyword}%")
                ->orWhere('orders.email', 'LIKE', "%{$keyword}%")
                ->orWhere('orders.current_school', 'LIKE', "%{$keyword}%")
                ->orWhere('orders.parent_note', 'LIKE', "%{$keyword}%")
                ->orWhere('orders.code', 'LIKE', "%{$keyword}%");
        });
    }


    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('orders.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('orders.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByOrderDate($query, $order_date_from, $order_date_to)
    {
        if (!empty($order_date_from) && !empty($order_date_to)) {
            return $query->whereBetween('orders.order_date', [$order_date_from, \Carbon\Carbon::parse($order_date_to)->endOfDay()]);
        }

        return $query;
    }

    public function isRequestDemo()
    {
        return $this->type == self::TYPE_REQUEST_DEMO;
    }

    public static function scopeNotRequestDemo($query)
    {
        $query->whereNot('type', self::TYPE_REQUEST_DEMO);
    }

    public function saveOrderCustomerInfoFromRequest($request)
    {
        // rules
        $rules = [
            'contact_id' => 'required',
            'type' => 'required',
        ];

        // fill
        $this->type = $request->type;
        $this->contact_id = $request->contact_id;
        $this->student_id = $request->student_id;
        $this->order_date = Carbon::now();
        $this->contact_request_id = $request->contact_request_id;

        // nếu liên hệ là học viên:
        if ($request->signer_is_student) {
            $this->student_id = $request->contact_id;
        } else {
            $rules['student_id'] = 'required';
        }

        // validate
        $validator = Validator::make($request->all(), $rules);

        // fails
        if ($validator->fails()) {
            return $validator->errors();
        }

        // if (true || !$this->isRequestDemo()) {
        //     // validate custom
        //     // Contact có contact requests chưa có hợp đồng nhưng không chọn hợp đồng nào
        //     $hasNewRequests = ContactRequest::whereIn('contact_id', [$this->contact_id, $this->student_id])
        //         ->doesntHaveNewOrder()
        //         ->count();

            // Hợp đồng phải có đơn hàng tương ứng
            if (
                !$this->contact_request_id // && $hasNewRequests
            ) {
                $validator->errors()->add('contact_request_id', 'Chưa chọn thông tin đơn hàng cho hợp đồng');
                return $validator->errors();
            }
        // }

        // contact request ko phải của học viên hay liên hệ
        $contactRequest = ContactRequest::find($this->contact_request_id);
        if ($contactRequest->contact_id != $this->contact_id && $contactRequest->contact_id != $this->student_id) {
            $validator->errors()->add('contact_request_id', 'LỖI: Đơn hàng không phải từ liên hệ!');
            return $validator->errors();
        }

        // save
        $this->save();

        // order code
        $this->generateCode();

        // update order cache total
        $this->updateCacheTotal();

        return $validator->errors();
    }

    public function generateCode()
    {
        if($this->type == self::TYPE_EDU){
            $this->generateCodeEdu();
        }

        if($this->type == self::TYPE_ABROAD){
            $this->generateCodeAbroad();
        }

        if($this->type == self::TYPE_EXTRACURRICULAR){
            $this->generateCodeExtracurricular();
        }
    }

    public function generateTemporaryImportIdForWrongImportIdOrder()
    {
        $this->import_id = $this->getTemporaryImportId();
        $this->save();
    }

    public function getTemporaryImportId()
    {
        $prefix = null;

        switch ($this->type) {
            case self::TYPE_EDU:
                $prefix = 'TMP_EDU_';
                break;
            case self::TYPE_ABROAD:
                $prefix = 'TMP_ABROAD_';
                break;
            case self::TYPE_EXTRACURRICULAR:
                $prefix = 'TMP_EXTRA_';
                break;
            case self::TYPE_REQUEST_DEMO:
                $prefix = 'TMP_DEMO_';
                break;
            default:
                throw new \Exception("Order type not defined!");
        }

        $suffix = $this->generateTemporarySuffixCodeName();

        return $prefix . $suffix;
    }

    public function generateTemporarySuffixCodeName()
    {
        return uniqId();   
    }

    public function generateCodeEdu()
    {
        // Lấy năm và tháng hiện tại
        $orderYear = $this->created_at->format('y'); // Lấy 2 chữ số cuối của năm
        $orderMonth = $this->created_at->format('m'); // Lấy 2 chữ số của tháng

        // Kết hợp năm và tháng
        $yearMonth = $orderYear . $orderMonth;

        // Lấy mã cuối cùng tạo trong cùng năm và tháng
        $lastCode = self::where('code', 'like', "HDDT/{$yearMonth}/%")
                        ->orderBy('code', 'desc')
                        ->first();

        // Xác định số mã tiếp theo
        if ($lastCode) {
            // Phân tích cú pháp số từ mã cuối cùng
            $lastNumber = (int)substr($lastCode->code, -4);
            $codeNumber = $lastNumber + 1;
        } else {
            $codeNumber = 1; // Bắt đầu từ 0001 nếu không có mã nào trước đó
        }

        // Tạo mã mới
        $this->code = sprintf('HDDT/%s/%04d', $yearMonth, $codeNumber);
     
        // Lưu thay đổi
        $this->save();
        
        // Làm mới mã nếu cần thiết (tùy thuộc vào triển khai của bạn)
        // $this->refreshCode();
    }

    public function generateCodeExtracurricular()
    {
        // Lấy năm và tháng hiện tại
        $orderYear = $this->created_at->format('y'); // Lấy 2 chữ số cuối của năm
        $orderMonth = $this->created_at->format('m'); // Lấy 2 chữ số của tháng

        // Kết hợp năm và tháng
        $yearMonth = $orderYear . $orderMonth;

        // Lấy mã cuối cùng tạo trong cùng năm và tháng
        $lastCode = self::where('code', 'like', "HDK/{$yearMonth}/%")
                        ->orderBy('code', 'desc')
                        ->first();

        // Xác định số mã tiếp theo
        if ($lastCode) {
            // Phân tích cú pháp số từ mã cuối cùng
            $lastNumber = (int)substr($lastCode->code, -4);
            $codeNumber = $lastNumber + 1;
        } else {
            $codeNumber = 1; // Bắt đầu từ 0001 nếu không có mã nào trước đó
        }

        // Tạo mã mới
        $this->code = sprintf('HDK/%s/%04d', $yearMonth, $codeNumber);
     
        // Lưu thay đổi
        $this->save();
        
        // Làm mới mã nếu cần thiết (tùy thuộc vào triển khai của bạn)
        // $this->refreshCode();
    }

    public function generateCodeAbroad()
    {
        // Lấy năm và tháng hiện tại
        $orderYear = $this->created_at->format('y'); // Lấy 2 chữ số cuối của năm
        $orderMonth = $this->created_at->format('m'); // Lấy 2 chữ số của tháng

        // Kết hợp năm và tháng
        $yearMonth = $orderYear . $orderMonth;

        // Lấy mã cuối cùng tạo trong cùng năm và tháng
        $lastCode = self::where('code', 'like', "HDDH/{$yearMonth}/%")
                        ->orderBy('code', 'desc')
                        ->first();

        // Xác định số mã tiếp theo
        if ($lastCode) {
            // Phân tích cú pháp số từ mã cuối cùng
            $lastNumber = (int)substr($lastCode->code, -4);
            $codeNumber = $lastNumber + 1;
        } else {
            $codeNumber = 1; // Bắt đầu từ 0001 nếu không có mã nào trước đó
        }

        // Tạo mã mới
        $this->code = sprintf('HDDH/%s/%04d', $yearMonth, $codeNumber);
     
        // Lưu thay đổi
        $this->save();
        
        // Làm mới mã nếu cần thiết (tùy thuộc vào triển khai của bạn)
        // $this->refreshCode();
    }


    public function refreshCode()
    {
        $this->code = $this->getCode();
        $this->save();
    }

    public function getScheduleItemsTotal()
    {
        $scheduleItems = $this->schedule_items;
        $decodedScheduleItems = [];

        if ($scheduleItems) {
            foreach ($scheduleItems as $scheduleItem) {
                $decodedScheduleItems[] = json_decode($scheduleItem);
            }

            $total = array_sum(array_column($decodedScheduleItems, 'price'));

            return $total;
        } else {
            return 0;
        }
    }

    /**
     * Temporary save order data
     * run when user click temporary save data btn in create order screen 
     * 
     * @param request
     * @return validator->errors()
     */
    public function temporarySaveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), []);

        $validator->after(function ($validator) {
            if ($this->type != self::TYPE_REQUEST_DEMO) {
                // if (request('price') <= 0) {
                //     $validator->errors()->add('price', 'Giá hợp đồng không được nhỏ hơn hoặc bằng 0');
                // }
    
                if (is_null(request('is_pay_all'))) {
                    $schedulesTotal = $this->getScheduleItemsTotal();
    
                    if ($schedulesTotal != (int)str_replace(',', '', request('price'))) {
                        $validator->errors()->add('total_schedules', 'Tổng giá trị các tiến độ không bằng giá trị hợp đồng!');
                    }
    
                    $this->is_pay_all = 'off';
                }
            }

            if (request('sale') <= 0) {
                $validator->errors()->add('sale', 'Vui lòng chọn sale!');
            }
        });

        if (is_null($request->debt_allow)) {
            $this->debt_allow = 'off';
        }

        if (is_null($request->schedule_items)) {
            $this->schedule_items = null;
        }

        if (is_null($request->debt_due_date)) {
            $this->debt_due_date = null;
        }

        $this->price = str_replace(',', '', $request->price);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();
        $this->checkRevenueDistributions();

        // update order cache total
        $this->updateCacheTotal();

        return $validator->errors();
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $this->price = str_replace(',', '', $request->price);

        $validator = Validator::make($request->all(), [
            // 'contact_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();

        // update order cache total
        $this->updateCacheTotal();

        return $validator->errors();
    }

    public function getCode()
    {
        return sprintf("%04s", $this->code_number) . "/" . $this->code_year;
    }

    public static function scopeDraft($query)
    {
        $query = $query->where('orders.status', self::STATUS_DRAFT);
    }

    public static function scopePending($query)
    {
        $query = $query->where('orders.status', self::STATUS_PENDING);
    }

    public static function scopeIsActive($query)
    {
        $query = $query->where('orders.status', self::STATUS_ACTIVE);
    }

    public static function scopeRejected($query)
    {
        $query = $query->where('orders.status', self::STATUS_REJECTED);
    }

    public static function scopeNotDraft($query)
    {
        $query = $query->whereNot('orders.status', self::STATUS_DRAFT);
    }

    public static function scopeNotDemo($query)
    {
        $query = $query->whereNot('orders.type', self::TYPE_REQUEST_DEMO);
    }

    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function requestApproval()
    {
        $this->status = self::STATUS_PENDING;
        $this->approval_requested_at = Carbon::now();
        $this->save();
    }

    public function confirmRequestDemo()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }

    public function approve()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }

    public function duyetHopDong()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            // set trạng thái cho order là approved
            $this->approve();

            // Check if it's a study abroad contract
            if ($this->type == self::TYPE_ABROAD) {
                $abroadItems = $this->orderItems;
                
                // Find all items of the contract and create a corresponding study abroad file for each item
                foreach ($abroadItems as $item) {
                    $item->createAbroadApplication();
                }
            }

            // cập nhật lại reminders
            $this->updateReminders();

            // nếu hợp đồng là ngoại khóa thì cho học viên vào ngoại khóa luôn
            if ($this->isExtracurricular()) {
                $exist = false;

                foreach ($this->orderItems as $item) {
                    if ($item->extracurricular) {
                        $item->extracurricular->addStudent($this->student,$item->id);

                        if (!$exist) $exist = true;
                    }
                }

                if (!$exist) throw new \Exception("Không tồn tại hoạt động ngoại khóa nào trong hợp đồng này!");
            }

            // commit
            DB::commit();
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
    }

    public function reject($reason)
    {

        $this->status = self::STATUS_REJECTED;
        $this->rejected_reason = $reason;

        OrderRejection::create([
            'order_id' => $this->id,
            'reason' => $this->rejected_reason,
        ]);

        $this->save();
    }

    public function getPriceWithoutDiscount()
    {
        $price = is_null($this->price) ? 0 : (float)str_replace(',', '', str_replace('.', '', $this->price));
        $discount = floatval($this->discount_code);
        $exchange = is_null($this->exchange) ? 1 : (float)str_replace(',', '', str_replace('.', '', $this->exchange));
        $currency = $this->currency_code;
        $priceWithoutDiscount = $price * ($currency == self::CURRENCY_CODE_USD ? $exchange : 1);

        return $priceWithoutDiscount;
    }

    public function getTotalPriceOfItems()
    {
        $items = OrderItem::whereHas('order', function($q) {
            $q->where('id', $this->id);
        })->get();

        if ($items->count() == 0) {
            return 0;
        }

        $total = 0;

        foreach ($items as $item) {
            if ($this->type == self::TYPE_EDU) {
                $total += $item->getTotalPriceOfEdu();
            } else {
                $total += $item->price;
            }
        }

        return $total;
    }

    /*
    Lưu ý:
    Phải luôn tuân thủ theo concept:
     **** Hàm getTotal() trả về giá sau giảm giá
     **** Hàm getPriceBeforeDiscount() trả về giá gốc trước giảm giá
    */

    /**
     * (A LUÂN)
     * Giá trị thật, công nợ, tính lợi nhuận, doanh số
     * (lúc này đang lưu trong db là giá sau khuyến mãi)
     */
    // public function getTotal()
    // {
    //     return $this->getTotalPriceOfOrderItems();
    // }

    /**
     * (Hoàng Anh sửa lại hàm theo ý chị Hiền)
     * lưu trong db là giá gốc(trước khuyến mãi)
     * 
     * Trả về giá sau khuyến mãi
     */
    public function getTotal()
    {
        $discountPercent = floatval($this->discount_code);
        $itemsPrice = $this->getTotalPriceOfOrderItems(); 
        
        return $itemsPrice - ($itemsPrice / 100 * $discountPercent);
    }

    /**
     * (A LUÂN)
     * giá trước khi giảm, thường show lúc tạo hợp đồng, PDF, in đơn hàng
     * (lúc này đang lưu trong db là giá sau khuyến mãi)
     */
    // public function getPriceBeforeDiscount()
    // {
    //     return $this->convertToPriceAfterDiscount($this->getTotalPriceOfOrderItems());
    // }

    /**
     * (Hoàng Anh sửa lại theo ý chị Hiền)
     * lưu trong db là giá gốc(trước khuyến mãi)
     * 
     * Trả về giá gốc
     */
    public function getPriceBeforeDiscount()
    {
        return $this->getTotalPriceOfOrderItems();
    }

    public function getPriceAfterDiscount()
    {
        $totalOrderItemsPrice = $this->getTotalPriceOfOrderItems();
        $discountPercent = $this->discount_code;

        return $totalOrderItemsPrice - ($totalOrderItemsPrice / 100 * $discountPercent);
    }

    // public function getTotal()
    // {
    //     // init
    //     $price = is_null($this->price) || !isset($this->price) ? 0 : (float)str_replace(',', '', str_replace('.', '', $this->price));
    //     $discount = floatval($this->discount_code);
    //     $exchange = is_null($this->exchange) ? 1 : (float)str_replace(',', '', str_replace('.', '', $this->exchange));
    //     $currency = $this->currency_code;
        
    //     // 
    //     $total = $price * (1 - $discount / 100) * ($currency == self::CURRENCY_CODE_USD ? $exchange : 1);
        
    //     // 
    //     $total = $this->orderItems->where('status', '=', OrderItem::STATUS_ACTIVE)
    //             ->reduce(function ($total, $orderItem) {
    //                 return $total + \App\Helpers\Functions::convertStringPriceToNumber($orderItem->price);
    //             }, 0) + floatval($total);
            
    //     // Hoàn phí, - tất cả payment_records mà tó TYPE = refund;
    //     // $total = $total ---- (tổng của các refund hoàn phí)
    //     // ... update lại khúc update remibders

    //     $refundTotal = $this->paymentRecords()
    //         ->refund()
    //         ->sum('amount');

    //     // trừ refund 
    //     $total -= $refundTotal;

    //     return $total;
    // }

    public function updateCacheTotal()
    {
        $this->cache_total = intval($this->getTotal());
        $this->save();
    }

    public function getTotalWithoutDiscount()
    {
        return $this->orderItems
            ->filter(function ($orderItem) {
                return $orderItem->is_by_more !== null;
            })
            ->reduce(function ($total, $orderItem) {
                return $total + $orderItem->getTotalWithoutDiscount();
            }, 0) + floatval($this->getPriceWithoutDiscount());
    }

    public function getDiscountAmount()
    {
        $total = $this->getTotal();
        $totalWithoutDiscount = $this->getTotalWithoutDiscount();
        $discountAmount = $totalWithoutDiscount - $total;

        return $discountAmount;
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class, 'order_id', 'id')->paid();
    }

    public static function scopeSelect2($query, $request, $orders)
    {
        // Keyword search
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // Pagination
        $contacts = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $contacts->map(function ($contact) {
                return [
                    'id' => $contact->contacts->id,
                    'text' => '<strong>' . $contact->contacts->name . '</strong><div>'  . $contact->contacts->email . '</div>' . $contact->contacts->phone . '</div>',
                    // 'order' => $order, 
                ];
            })->toArray(),
            "pagination" => [
                "more" => $contacts->lastPage() != $request->page,
            ],
        ];
    }

    public function scopeIsEdu()
    {
        return $this->type == self::TYPE_EDU;
    }

    public function scopeIsAbroad()
    {
        return $this->type == self::TYPE_ABROAD;
    }

    public function scopeIsKids()
    {
        return $this->type == self::TYPE_KIDS;
    }

    public function scopeIsExtra()
    {
        return $this->type == self::TYPE_EXTRACURRICULAR;
    }

    public function scopeExtracurriculars($query)
    {
        $query = $query->where('type', self::TYPE_EXTRACURRICULAR);
    }

    public function getRelationshipName()
    {
        switch ($this->relationship) {
            case 'father':
                return 'Cha';
            case 'mother':
                return 'Mẹ';
            default:
                return $this->relationship_other;
        }
    }

    public function scopeGetRequestDemo($query)
    {
        return $query->where('orders.type', $this::TYPE_REQUEST_DEMO);
    }

    public function scopeGetGeneral($query)
    {
        return $query->where('orders.type', '!=', $this::TYPE_REQUEST_DEMO);
    }

    public static function scopeDeleteAll($query, $orderIds)
    {
        $orders = self::whereIn('id', $orderIds)->get();

        foreach ($orders as $order) {
            $order->update(['status' => self::STATUS_DELETED]);
        }
    }

    public function deleteOrder()
    {
        $this->status = self::STATUS_DELETED;
        $this->contactRequest->rollbackStatus();
        $this->save();
    }

    public static function getDemoItemsByContactId($contactId)
    {
        return OrderItem::whereHas('orders', function ($q) use ($contactId) {
            $q->where('contact_id', $contactId);
        })
            ->where('type', self::TYPE_REQUEST_DEMO)
            ->get();
    }

    public function scopeSumAmountPaid($query)
    {
        return $this->paymentRecords()->received()->paid()->sum('amount');
    }

    public function scopeReachingDueDate($query, $days = 30)
    {
        return $query->whereHas('paymentReminders', function ($subquery) use ($days) {
            $subquery->whereNotNull('due_date')
                ->where('due_date', '<', now()->addDays($days));
        });
    }

    public function scopeOverDueDate($query, $days = 1)
    {
        return $query->whereHas('paymentReminders', function ($subquery) use ($days) {
            $subquery->whereNotNull('due_date')
                ->where('due_date', '<', now()->subDays($days));
        });
    }

    public function scopePartPaid($query)
    {
        return $query->whereExists(function ($subquery) {
            $subquery->select(DB::raw(1))
                ->from('payment_records')
                ->whereColumn('order_id', 'orders.id');
        });
    }
    
    public function paymentReminders()
    {
        return $this->hasMany(PaymentReminder::class, 'order_id');
    }

    public function scopeCheckIsPaid($query)
    {
        return $query->where('cache_total', '<=', function ($subquery) {
            $subquery->select(DB::raw('COALESCE(SUM(amount), 0)'))
                ->from('payment_records')
                ->whereColumn('order_id', 'orders.id');
        });
    }

    public function scopeCheckIsNotPaid($query)
    {
        return $query->whereHas('paymentReminders', function ($subquery) {
            $subquery->whereColumn('tracking_amount', '>', DB::raw('(SELECT COALESCE(SUM(amount), 0) FROM payment_records WHERE payment_records.order_id = payment_reminder.order_id)'));
        });
    }

    public function getPaymentStatus()
    {
        if ($this->isPaid()) {
            return 'paid';
        }

        if ($this->isPartPaid()) {
            return 'part_paid';
        }

        return 'unpaid';
    }

    public function isPartPaid()
    {
        $paymentRecordsCount = $this->paymentRecords->count();

        return $paymentRecordsCount > 0 && $this->getTotal() > $this->getPaidAmount();
    }

    public function isPaid()
    {
        return $this->getTotal() <= $this->getPaidAmount();
    }
    
    public function getPaidAmount()
    {
        return $this->paymentRecords->sum('amount');
    }
    
    public function getRemainAmount()
    {
        return $this->getTotal() - $this->getPaidAmount();
    }

    public function paymentCount()
    {
        return 'Lần ' . $this->paymentRecords()->count();
    }

    public function getPaymentType()
    {
        if ($this->is_pay_all == 'on') {
            return 'Thanh toán 1 lần';
        } else {
            return 'Thanh toán nhiều lần' . ' - ' . $this->paymentCount();
        }
    }

    public static function getAllPaymentOrderStatus()
    {
        return self::pluck('is_pay_all')->map(function ($status) {
            return [
                'value' => $status,
                'label' => $status === 'on' ? 'Thanh toán 1 lần' : 'Thanh toán nhiều lần',
            ];
        })->unique()->values();
    }

    public static function scopeFilterByPaymentOrderStatus($query, $paymentOrderStatus)
    {
        return $query->whereIn('is_pay_all', $paymentOrderStatus);
    }

    public static function exportToExcelStatusReport($templatePath, $filteredOrders)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filteredOrders as $order) {
            // Date formatting
            $updated_at = $order['updated_at'] ? Carbon::parse($order['updated_at'])->format('d/m/Y') : null;

            $rowData = [
                $order['code'],
                $updated_at,
                $order->contacts->name,
                $order['industry'],
                $order['status'],
                $order->salesperson->name,
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public static function exportToExcelSalesReport($templatePath, $filteredOrders)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        // $iteration = 1;

        foreach ($filteredOrders as $order) {
            $latestPaymentRecord = PaymentRecord::latestForOrderAndStudent($order->id, $order->student_id);

            // Date formatting
            $payment_date = $latestPaymentRecord['payment_date'] ? Carbon::parse($latestPaymentRecord['payment_date'])->format('d/m/Y') : null;
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $rowData = [
                // $iteration,
                $payment_date,
                $order->contacts->code ?? 'N/A',
                $order->student->name ?? 'N/A',
                $orderItem->subject->name ?? '',
                $latestPaymentRecord->description,
                Functions::formatNumber($latestPaymentRecord->amount) . 'đ',
                '',
                '',
                $latestPaymentRecord->method,
                $latestPaymentRecord->account->code,
                $order->salesperson->name,
                $order->getSaleSupName(),
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            // $iteration++;
        }
    }

    public static function exportToExcelPaymentReport($templatePath, $filteredOrders)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 3;

        foreach ($filteredOrders as $order) {
            // Date formatting
            $sale = Account::find($order->sale) ? Account::find($order->sale)->name : '';
            $sale_sup = Account::find($order->sale_sup) ? Account::find($order->sale_sup)->name : '';

            $amount1 = PaymentReminder::where('order_id', $order->id)
                ->where(function ($query) {
                    $query->whereNull('progress')
                        ->orWhere('progress', 0)
                        ->orWhere('progress', 1)
                        ->orWhere('progress', '');
                })
                ->pluck('amount')
                ->first();

            $dueDate1 = PaymentReminder::where('order_id', $order->id)
                ->where(function ($query) {
                    $query->whereNull('progress')
                        ->orWhere('progress', 0)
                        ->orWhere('progress', 1)
                        ->orWhere('progress', '');
                })
                ->orderBy('due_date', 'asc')
                ->value('due_date');
            $formattedDueDate1 = $dueDate1 ? date('d/m/Y', strtotime($dueDate1)) : 'N/A';

            $amount2 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  2)
                ->value('amount');
            $dueDate2 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  2)
                ->orderBy('due_date', 'asc')
                ->value('due_date');
            $formattedDueDate2 = $dueDate2 ? date('d/m/Y', strtotime($dueDate2)) : 'N/A';

            $amount3 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  3)
                ->value('amount');
            $dueDate3 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  3)
                ->orderBy('due_date', 'asc')
                ->value('due_date');
            $formattedDueDate3 = $dueDate3 ? date('d/m/Y', strtotime($dueDate3)) : 'N/A';

            $amount4 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  4)
                ->value('amount');
            $dueDate4 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  4)
                ->orderBy('due_date', 'asc')
                ->value('due_date');
            $formattedDueDate4 = $dueDate4 ? date('d/m/Y', strtotime($dueDate4)) : 'N/A';

            $amount5 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  5)
                ->value('amount');
            $dueDate5 = PaymentReminder::where('order_id', $order->id)
                ->where('progress',  5)
                ->orderBy('due_date', 'asc')
                ->value('due_date');

            $formattedDueDate5 = $dueDate5 ? date('d/m/Y', strtotime($dueDate5)) : 'N/A';

            $rowData = [
                $order->contacts->code ?? 'N/A',
                Order::find($order->id)->contacts->name,
                $order['code'],
                $order->type,
                $sale,
                $sale_sup,
                Functions::formatNumber($order->getTotal()) . 'đ',
                number_format($order->sumAmountPaid(), 0, '.', ',') . 'đ',
                number_format(max($order->getTotal() - $order->sumAmountPaid(), 0), 0, '.', ',') . 'đ',
                is_null($amount1) || $amount1 == 0 ? 'N/A' : number_format($amount1, 0, '.', ','),
                $formattedDueDate1,

                $amount2 == 0 ? 'N/A' : number_format($amount2, 0, '.', ','),
                $formattedDueDate2,

                $amount3 == 0 ? 'N/A' : number_format($amount3, 0, '.', ','),
                $formattedDueDate3,

                $amount4 == 0 ? 'N/A' : number_format($amount4, 0, '.', ','),
                $formattedDueDate4,

                $amount5 == 0 ? 'N/A' : number_format($amount5, 0, '.', ','),
                $formattedDueDate5,
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public function getTotalPriceOfOrderItems()
    {
        $price;

        if ($this->type == self::TYPE_EDU) {
            $price = $this->getTotalPriceOfEduItems();
        } else if ($this->type == self::TYPE_ABROAD) {
            $price = $this->getTotalPriceOfAbroadItems();
        } else if ($this->type == self::TYPE_EXTRACURRICULAR) {
            $price = $this->getTotalPriceOfExtraItems();
        } else {
            $price = 0;
        }

        return $price;
    }

    public function convertToPriceAfterDiscount($price)
    {
        if (!isset($this->discount_code)) {
            return $price;
        }

        $rate = (1 - ($this->discount_code / 100));

        return $rate == 0 ? 0 : $price / $rate;
    }

    public function getTotalPriceOfEduItems()
    {
        $items = OrderItem::isEdu()->whereHas('order', function($q) {
            $q->where('id', $this->id);
        })->get();

        if ($items->count() == 0) {
            return 0;
        }

        $total = 0;

        foreach ($items as $item) {
            $total += $item->getTotalPriceOfEdu();
        }

        return $total;
    }

    public function getTotalPriceOfAbroadItems()
    {
        $items = OrderItem::abroad()->whereHas('order', function($q) {
            $q->where('id', $this->id);
        })->get();

        if ($items->count() == 0) {
            return 0;
        }

        $total = 0;

        foreach ($items as $item) {
            $total += Functions::convertStringPriceToNumber($item->price);
        }

        return $total;
    }

    public function getTotalPriceOfExtraItems()
    {
        $items = OrderItem::extra()->whereHas('order', function($q) {
            $q->where('id', $this->id);
        })->get();

        if ($items->count() == 0) {
            return 0;
        }

        $total = 0;

        foreach ($items as $item) {
            $total += Functions::convertStringPriceToNumber($item->price);
        }

        return $total;
    }

    public function copyFrom($fromOrder)
    {
        $this->sale = $fromOrder->sale;
        $this->sale_sup = $fromOrder->sale_sup;
        $this->fullname = $fromOrder->fullname;
        $this->birthday = $fromOrder->birthday;
        $this->phone = \App\Library\Tool::extractPhoneNumber($fromOrder->phone);
        $this->email = $fromOrder->email;
        $this->current_school = $fromOrder->current_school;
        $this->parent_note = $fromOrder->parent_note;
        $this->industry = $fromOrder->industry;
        // $this->currency_code = $fromOrder->currency_code;
        // $this->exchange = $fromOrder->exchange;
        // $this->discount_code = $fromOrder->discount_code;
        // $this->is_pay_all = $fromOrder->is_pay_all;
        // $this->schedule_items = $fromOrder->schedule_items;
        // $this->debt_allow = $fromOrder->debt_allow;
        // $this->debt_due_date = $fromOrder->debt_due_date;
        $this->save();

        foreach ($fromOrder->orderItems as $orderItem) {
            $ot = new OrderItem();
            $ot->status = 'active';
            $ot->order_id = $this->id;
            $ot->type = $orderItem->type;
            $ot->order_type = $orderItem->order_type;
            $ot->price = $orderItem->price;
            // $ot->currency_code = $orderItem->currency_code;
            $ot->level = $orderItem->level;
            $ot->class_type = $orderItem->class_type; 
            $ot->num_of_student = $orderItem->num_of_student;
            $ot->study_type = $orderItem->study_type;
            $ot->vietnam_teacher_minutes_per_section = $orderItem->vietnam_teacher_minutes_per_section;
            $ot->foreign_teacher_minutes_per_section = $orderItem->foreign_teacher_minutes_per_section;
            $ot->tutor_minutes_per_section = $orderItem->tutor_minutes_per_section;
            $ot->target = $orderItem->target;
            $ot->home_room = $orderItem->home_room;
            $ot->apply_time = $orderItem->apply_time;
            $ot->top_school = $orderItem->top_school;
            $ot->current_program_id = $orderItem->current_program_id;
            $ot->std_score = $orderItem->std_score;
            $ot->eng_score = $orderItem->eng_score;
            $ot->plan_apply_program_id = $orderItem->plan_apply_program_id;
            $ot->intended_major_id = $orderItem->intended_major_id;
            $ot->academic_award_1 = $orderItem->academic_award_1;
            $ot->academic_award_2 = $orderItem->academic_award_2;
            $ot->academic_award_3 = $orderItem->academic_award_3;
            $ot->academic_award_4 = $orderItem->academic_award_4;
            $ot->academic_award_5 = $orderItem->academic_award_5;
            $ot->academic_award_6 = $orderItem->academic_award_6;
            $ot->academic_award_7 = $orderItem->academic_award_7;
            $ot->academic_award_8 = $orderItem->academic_award_8;
            $ot->academic_award_9 = $orderItem->academic_award_9;
            $ot->academic_award_10 = $orderItem->academic_award_10;
            $ot->academic_award_text_1 = $orderItem->academic_award_text_1;
            $ot->academic_award_text_2 = $orderItem->academic_award_text_2;
            $ot->academic_award_text_3 = $orderItem->academic_award_text_3;
            $ot->academic_award_text_4 = $orderItem->academic_award_text_4;
            $ot->academic_award_text_5 = $orderItem->academic_award_text_5;
            $ot->academic_award_text_6 = $orderItem->academic_award_text_6;
            $ot->academic_award_text_7 = $orderItem->academic_award_text_7;
            $ot->academic_award_text_8 = $orderItem->academic_award_text_8;
            $ot->academic_award_text_9 = $orderItem->academic_award_text_9;
            $ot->academic_award_text_10 = $orderItem->academic_award_text_10;
            $ot->grade_1 = $orderItem->grade_1;
            $ot->grade_2 = $orderItem->grade_2;
            $ot->grade_3 = $orderItem->grade_3;
            $ot->grade_4 = $orderItem->grade_4;
            $ot->point_1 = $orderItem->point_1;
            $ot->point_2 = $orderItem->point_2;
            $ot->point_3 = $orderItem->point_3;
            $ot->point_4 = $orderItem->point_4;
            $ot->postgraduate_plan = $orderItem->postgraduate_plan;
            $ot->personality = $orderItem->personality;
            $ot->subject_preference = $orderItem->subject_preference;
            $ot->language_culture = $orderItem->language_culture;
            $ot->research_info = $orderItem->research_info;
            $ot->aim = $orderItem->aim;
            $ot->essay_writing_skill = $orderItem->essay_writing_skill;
            $ot->extra_activity_1 = $orderItem->extra_activity_1;
            $ot->extra_activity_2 = $orderItem->extra_activity_2;
            $ot->extra_activity_3 = $orderItem->extra_activity_3;
            $ot->extra_activity_4 = $orderItem->extra_activity_4;
            $ot->extra_activity_5 = $orderItem->extra_activity_5;
            $ot->extra_activity_text_1 = $orderItem->extra_activity_text_1;
            $ot->extra_activity_text_2 = $orderItem->extra_activity_text_2;
            $ot->extra_activity_text_3 = $orderItem->extra_activity_text_3;
            $ot->extra_activity_text_4 = $orderItem->extra_activity_text_4;
            $ot->extra_activity_text_5 = $orderItem->extra_activity_text_5;
            $ot->personal_countling_need = $orderItem->personal_countling_need;
            $ot->other_need_note = $orderItem->other_need_note;
            $ot->parent_job = $orderItem->parent_job;
            $ot->parent_highest_academic = $orderItem->parent_highest_academic;
            $ot->is_parent_studied_abroad = $orderItem->is_parent_studied_abroad;
            $ot->parent_income = $orderItem->parent_income;
            $ot->parent_familiarity_abroad = $orderItem->parent_familiarity_abroad;
            $ot->is_parent_family_studied_abroad = $orderItem->is_parent_family_studied_abroad;
            $ot->parent_time_spend_with_child = $orderItem->parent_time_spend_with_child;
            $ot->financial_capability = $orderItem->financial_capability;
            $ot->schedule_items = $orderItem->schedule_items;
            // $ot->created_at = $orderItem->created_at;
            // $ot->updated_at = $orderItem->updated_at;
            $ot->estimated_enrollment_time = $orderItem->estimated_enrollment_time;
            $ot->subject_id = $orderItem->subject_id;
            $ot->num_of_vn_teacher_sections = $orderItem->num_of_vn_teacher_sections;
            $ot->num_of_foreign_teacher_sections = $orderItem->num_of_foreign_teacher_sections;
            $ot->num_of_tutor_sections = $orderItem->num_of_tutor_sections;
            $ot->training_location_id = $orderItem->training_location_id;
            $ot->vn_teacher_price = $orderItem->vn_teacher_price;
            $ot->foreign_teacher_price = $orderItem->foreign_teacher_price;
            $ot->tutor_price = $orderItem->tutor_price;

            $ot->save();
        }

        return $this;
    }

    public static function scopeOrdersInTimeRange($query, $startAt, $endAt)
    {
        return Order::where('start_at', '>', Carbon::parse($startAt)->startOfDay())
            ->where('end_at', '<', Carbon::parse($endAt)->endOfDay());
    }

    public function getSaleSup()
    {
        $saleGroupId = Account::find($this->sale)->account_group_id;
        $group = AccountGroup::find($saleGroupId);
        
        if (!$group) {
            return null;
        }
        
        $saleSup = Account::find($group->manager_id);

        return $saleSup;
    }

    public function getSaleSupName()
    {
        $saleSub = $this->getSaleSup();

        return $saleSub ? $saleSub->name : '--';
    }

    public static function scopeHasContactRequest($query)
    {
        $query->whereNotNull('contact_request_id');
    }

    public function getContactRequestCode()
    {
        return $this->contactRequest ? $this->contactRequest->code : '--';
    }

    public function getNearestReminder()
    {
        return $this->paymentReminders()
            ->reachingDueDate()
            ->checkIsNotPaid()
            ->orderBy('due_date', 'asc')
            ->first();
    }

    public function getLastReminder()
    {
        return $this->paymentReminders()
            ->reachingDueDate()
            ->checkIsNotPaid()
            ->orderBy('due_date', 'desc')
            ->first();
    }

    public function getNearestDueDate()
    {
        $re = $this->getNearestReminder();

        if ($re) {
            return \Carbon\Carbon::parse($re->due_date)->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function getNearestRemainAmount()
    {
        $re = $this->getNearestReminder();

        if ($re) {
            return $re->getRemainAmount();
        } else {
            return 0;
        }
    }

    public function getLastDueDate()
    {
        $re = $this->getLastReminder();

        if ($re) {
            return \Carbon\Carbon::parse($re->due_date)->format('d/m/Y');
        } else {
            return '--';
        }
    }

    public function getLastRemainAmount()
    {
        $re = $this->getLastReminder();

        if ($re) {
            return $re->getRemainAmount();
        } else {
            return 0;
        }
    }

    public static function scopeEdu($request)
    {
        $request = $request->where('type', self::TYPE_EDU);
    }

    public static function scopeAbroad($request)
    {
        $request = $request->where('type', self::TYPE_ABROAD);
    }

    public static function exportToExcelDebtReport($templatePath, $filteredOrders)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        $iteration = 1;

        foreach ($filteredOrders as $order) {
            // Date formatting
            // $updated_at = $order['updated_at'] ? Carbon::parse($order['updated_at'])->format('d/m/Y') : null;
            // $orderItem =  OrderItem::where('order_id', $order->id)->get();
            $rowData = [
                $iteration,
                $order->updated_at->format('d/m/Y'),
                $order->getContactRequestCode(),
                $order->code ?? 'N/A',
                Order::find($order->id)->contacts->name,
                $order->contacts->code ?? 'N/A',
                Order::find($order->id)->contacts->name,
                Functions::formatNumber($order->cache_total). 'đ',
                Functions::formatNumber($order->sumAmountPaid()). '₫',
                Functions::formatNumber($order->getTotal() - $order->sumAmountPaid()). '₫',
                Functions::formatNumber($order->getLastRemainAmount()). 'đ',
                $order->getLastDueDate(),
                $order->getNearestDueDate(),
                Functions::formatNumber($order->getNearestRemainAmount()),
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            $iteration++;
        }
    }

    public static function exportToExcelAccountingSalesReport($templatePath, $filteredOrders)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        $iteration = 1;

        foreach ($filteredOrders as $order) {
            $subjectName = [];
            // Date formatting
            foreach (OrderItem::where('order_id', $order->id)->get() as $orderItem){
                $subjectName[] = $orderItem->subject->name ?? '';
            }
       
            $latestPaymentRecord = PaymentRecord::latestForOrderAndStudent($order->id, $order->student_id);
            // $orderItem = OrderItem::where('order_id', $order->id)->get();
            // $subjectName = $orderItem ? $orderItem->subject->name : '';
            // $branch = OrderItem::where('order_id', $order->id)->first()->branch ?? 'N/A';
            $rowData = [
                $iteration,
                $order->contacts->code,
                Carbon::parse($latestPaymentRecord->updated_at)->format('d/m/Y') ,
                $order->student->name,
                $order->type,
                $order->type,
                implode(PHP_EOL, $subjectName),
                Functions::formatNumber($latestPaymentRecord->amount). 'đ',
                Functions::formatNumber($order->sumAmountPaid()). '₫',
                Functions::formatNumber($order->getTotal()). '₫',
                $latestPaymentRecord->description,
                $order->parent_note,
                $latestPaymentRecord->account->code,
                $order->salesperson->name,
                $order->getSaleSup()->name,
                $order->contactRequest->source_type ?? 'N/A',
                OrderItem::where('order_id', $order->id)->first()->training_location->branch ?? 'N/A'
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            $iteration++;
        }
    }

    public static function hasSubjectByContact($subjectId, $contactId)
    {
        return self::whereHas('orderItems', function ($q) use ($subjectId){
            $q->where('subject_id', $subjectId);
        })->where('contact_id', $contactId)->get();
    }

    public function getLastPaymentDate()
    {
        $latestPaymentRecord = $this->paymentRecords()->orderBy('payment_date', 'desc')->first();

        return $latestPaymentRecord;
    }

    public function isExtracurricular()
    {
        return $this->type == self::TYPE_EXTRACURRICULAR;
    }

    public static function scopeByBranch($query, $branch)
    {
        return $query->whereHas('salesperson', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->where('branch', $branch);
            }
        });
    }

    public function scopeOutdatedApproval($query, $hours = 1) 
    {
        $query = $query->pending()->where('orders.approval_requested_at', '<',  \Carbon\Carbon::now()->subHours($hours));
    }

    public function outdatedApprovalNotified()
    {
        $this->approval_requested_at = Carbon::now();
        $this->save();
    }

    public function createPendingPaymentRecord($amount) {
        $paymentRecord = new PaymentRecord();
        $paymentRecord->amount = $amount;
        $paymentRecord->order_id = $this->id;
        $paymentRecord->contact_id = $this->contacts->id;
        $paymentRecord->account_id = $this->salesperson->id;
        $paymentRecord->method = PaymentRecord::METHOD_ONE_PAY;
        $paymentRecord->status = PaymentRecord::STATUS_PENDING_ONEPAY;
        $paymentRecord->type = PaymentRecord::TYPE_RECEIVED;
        $paymentRecord->save();
        return $paymentRecord;
    }

    /**
     * Check the revenueDistributions of the order items of an order
     * 
     *      - Check if each order item of this order has revenue distributions with duplicate account_ids. 
     *        If duplicates exist, consolidate the amount values of the duplicate account_id revenue distributions into the first revenue distribution.
     * 
     *      - Verify if the account_id of the primary revenue distribution matches the current sale of this order. 
     *        If it does not match, update the account_id of the primary revenue distribution to the current sale's id of the order. 
     * 
     * @return void
     */
    public function checkRevenueDistributions() 
    {
        $orderItems = $this->orderItems;
        $sale = $this->salesperson;

        foreach($orderItems as $orderItem) {
            $revenueDistributions = $orderItem->revenueDistributions;

            // Merge revenueDistributions entries with duplicate account_id
            $groupedDistributions = $revenueDistributions->groupBy('account_id');
            
            foreach ($groupedDistributions as $accountId => $distributions) {
                if ($distributions->count() > 1) {
                    $primary = $distributions->filter(function ($item) {
                        return $item->is_primary == 1;
                    })->first();
                    
                    // If there are revenueDistributions with account_id matching the primary
                    if ($primary) {
                        $totalAmount = $distributions->sum('amount');
                        $primary->amount = $totalAmount;
                        $primary->save();

                        // Delete non-primary records
                        $distributions->where('id', '!=', $primary->id)->each(function ($item) {
                            $item->delete();
                        });

                        // If there are records with duplicate account_id that do not match the primary account_id
                    } else {
                        $first = $distributions->first();
                        $totalAmount = $distributions->sum('amount');
                        $first->amount = $totalAmount;
                        $first->save();

                        // Delete non-first records
                        $distributions->where('id', '!=', $first->id)->each(function ($item) {
                            $item->delete();
                        });
                    }
                }
            }

            // Ensure the account_id of the primary is the sale person of this Order
            $primary = $revenueDistributions->filter(function ($item) {
                return $item->is_primary == 1;
            })->first();

            if ($primary) {
                $primary->account_id = $sale->id;
                $primary->save();
            }
        }
    }

    public function checkOrderItemsDiscountPercent()
    {
        // Check in case edu item (VN, foreign, tutor, ...)
        if ($this->type = self::TYPE_EDU) {
            $discountPercent = floatval($this->discount_code);

            foreach($this->orderItems as $item) {
                $totalPrice = Functions::convertStringPriceToNumber($item->vn_teacher_price) 
                            + Functions::convertStringPriceToNumber($item->foreign_teacher_price) 
                            + Functions::convertStringPriceToNumber($item->tutor_price); 

                $totalPriceAfterDiscount = $totalPrice - ($totalPrice / 100 * $discountPercent); // Price after discount;
                
                $revenueDistributions = $item->revenueDistributions;
                $totalRevenuesAmount = 0;

                foreach ($revenueDistributions as $revenue) {
                    $totalRevenuesAmount += Functions::convertStringPriceToNumber($item->amount);
                }
            }

        }
    }

    public static function scopeByAccountKpiNote($query, $accountKpiNote)
    {
        if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU')) {
            $query->whereHas('orderItems', function ($q) use ($accountKpiNote) {
                $q->where('subject_id', $accountKpiNote->subject_id);
            });
        } elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_ABROAD')) {
            $query->where('type', 'abroad');
        } elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR')) {
            $query->where('type', 'extracurricular')
                ->whereHas('orderItems', function ($q) use ($accountKpiNote) {
                    $q->whereHas('extracurricular', function ($q2) use ($accountKpiNote) {
                        $q2->where('type', $accountKpiNote->extracurricular_type);
                    });
                });
        }
    }

    public function canRequestApprove()
    {
        return $this->orderItems->count();
        // && $this->getTotal();
    }

    public function isImported()
    {
        return $this->import_id != null;
    }

    public static function exportSalesOrder($templatePath, $filterOrders)
    {
        // $filterOrders = $filterOrders;
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filterOrders as $order) {
            $rowData = [
                $order->student ? $order->student->name : '--', //Tên học viên
                $order->code, // Mã
                $order->import_id, // Mã hợp đồng cũ
                trans('messages.order.type.' . $order->type), //Loại
                $order->contacts->code, //Mã khách hàng
                $order->contacts->name, //Người ký hợp đồng
                $order->student->code, //Mã học viên
                $order->contacts->phone, //Số điện thoại
                $order->contacts->email, //Email
                number_format($order->getTotal(), 0, '.', ','), //Giá trị
                Functions::formatNumber($order->sumAmountPaid()), //Đã thanh toán
                Functions::formatNumber(max($order->getTotal() - $order->sumAmountPaid(), 0), 0, '.', ','), //Còn lại
                $order->getPaymentType(), // Tình trạng hợp đồng
                trans('messages.payment_reminders.status.' . $order->getPaymentStatus()), //Trạng thái thanh toán
                $order->getPaymentType(), // trạng thái hợp đồng
                date("d/m/Y", strtotime($order->order_date)), // ngày hợp đồng
                $order->updated_at->format('d/m/Y'), // ngày chỉnh sửa
                Account::find($order->sale) ? Account::find($order->sale)->name : '', //Sale
                Account::find($order->sale_sup) ? Account::find($order->sale_sup)->name : '', //Sale Sup
                $order->parent_note, //Ghi chú của sale
                $order->current_school, //trường đang học
                $order->industry, //loại dịch vụ
                $order->rejected_reason, //Lý do từ chối
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

}
