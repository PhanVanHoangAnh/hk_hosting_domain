<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Facades\Cache;
use App\Models\Account;

class ContactRequest extends Model
{
    use HasFactory;

    const STATUS_DELETED = 'deleted';
    const STATUS_ACTIVE = 'active';
    const LS_NO_NEED = 'Không có nhu cầu';

    const LS_ERROR = 'ls_error';  //Sai số, không có nhu cầu
    const LS_NOT_PICK_UP = 'ls_not_pick_up';      //Không nghe máy, gọi lại sau
    const LS_NOT_PICK_UP_MANY_TIMES = 'ls_not_pick_up_many_times';  // Không nghe máy nhiều lần 
    const LS_DUPLICATE_DATA = 'ls_duplicate_data';      //Trùng data
    const LS_NOT_POTENTIAL = 'ls_not_potential';       //Có nhu cầu nhưng không tiềm năng
    const LS_HAS_REQUEST = 'ls_has_request';       //Có nhu cầu, cần khai thác thêm

    const LS_FOLLOW = 'ls_follow';     //Follow dài
    const LS_POTENTIAL = 'ls_potential';                //Tiềm năng
    
    const LS_HAS_CONSTRACT = 'ls_customer';        //Khách hàng
    const LS_MAKING_CONSTRACT = 'ls_making_contract';

    const LS_CONTACT = 'Liên hệ';
    const LS_NOT_CALL_YET = 'Chưa gọi';
    const LS_NO_REQUEST = 'Không có đơn hàng';
    const LS_DEPOSITED = 'Đã đặt cọc';
    const LS_HAS_CONSTRACT_OUTSIDE_SYSTEM = 'Hợp đồng (ngoài hệ thống)';
    // const LS_HAS_CONSTRACT = 'Khách hàng';
    const ADDED_FROM_SYSTEM = 'system';
    // const LS_IS_REFERRER = 'Khách giới thiệu khách hàng khác';

    const LS_NA = 'N/A';

    protected $fillable = [
        'contact_id',
        'name',
        'email',
        'phone',
        'address',
        'demand',
        'country',
        'city',
        'district',
        'ward',
        'school',
        'efc',
        'list',
        'target',
        'campaign',
        'adset',
        'ads',
        'device',
        'placement',
        'term',
        'first_url',
        'last_url',
        'contact_owner',
        'source_type',
        'channel',
        'sub_channel',
        'fbcid',
        'gclid',
        'birthday',
        'age',
        'time_to_call',
        'type_match',
        'lead_status',
        'previous_lead_status',
        'lifecycle_stage',
        'status',
        'schedule_freetime',
        'hubspot_id',
        'hubspot_modified_at',
        'hubspot_created_at',
        'hs_latest_source_timestamp',
        'out_date_notified',
        'unfulfilled_over_hours',
        'google_form_submit_date',
        'added_from',
        'google_sheet_id',
        'last_time_update_status',
        'latest_activity_date',
        'latest_sub_channel',
        'note_sales',
    ];

    public function scopeSearch($query, $keyword)
    {
        $query = $query->where(function ($query) use ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->whereRaw("contacts.name LIKE ?", ["%{$keyword}%"]);
            })
            // ->orWhereHas('contact', function($q) use ($keyword) {
            //     $q->whereHas('mother', function($q) use ($keyword) {
            //         $q->where('phone', 'LIKE', "%{$keyword}%");
            //     })
            //     ->orWhereHas('father', function($q) use ($keyword) {
            //         $q->where('phone', 'LIKE', "%{$keyword}%");
            //     });
            // })
            ->orWhere('contacts.phone', 'LIKE', "%{$keyword}%")
            ->orWhere('contacts.code', 'LIKE', "%{$keyword}%")
            ->orWhere('contacts.email', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.demand', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.code', 'LIKE', "%{$keyword}%")
            // ->orWhere('country', 'LIKE', "%{$keyword}%")
            // ->orWhere('district', 'LIKE', "%{$keyword}%")
            // ->orWhere('ward', 'LIKE', "%{$keyword}%")
            // ->orWhere('city', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.school', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.efc', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.code', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.list', 'LIKE', "%{$keyword}%")
            ->orWhere('contact_requests.campaign', 'LIKE', "%{$keyword}%");
            // ->orWhere('adset', 'LIKE', "%{$keyword}%")
            // ->orWhere('ads', 'LIKE', "%{$keyword}%")
            // ->orWhere('device', 'LIKE', "%{$keyword}%")
            // ->orWhere('placement', 'LIKE', "%{$keyword}%")
            // ->orWhere('term', 'LIKE', "%{$keyword}%")
            // ->orWhere('fbcid', 'LIKE', "%{$keyword}%")
            // ->orWhere('gclid', 'LIKE', "%{$keyword}%")
            // ->orWhere('first_url', 'LIKE', "%{$keyword}%")
            // ->orWhere('last_url', 'LIKE', "%{$keyword}%")
            // ->orWhere('time_to_call', 'LIKE', "%{$keyword}%");
        });
    }

    public function scopeFindByIds($query, $ids)
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeActive($query)
    {
        $query = $query->where('contact_requests.status', self::STATUS_ACTIVE);
    }

    public function scopeDeleted($query)
    {
        $query = $query->where('contact_requests.status', self::STATUS_DELETED);
    }

    public function scopeNotDeleted($query)
    {
        $query = $query->where('contact_requests.status', '<>',  self::STATUS_DELETED);
    }

    // public static function isDeleted() 
    // {
    //     return self::where('status', self::STATUS_DELETED)->get();
    // }

    public function scopeIsDeleted($query)
    {
        return $query->where('contact_requests.status', self::STATUS_DELETED);
    }
    public function scopeIsExtracurricular($query)
    {
        return $query->where('contact_requests.demand', 'Ngoai khóa');
    }

    public static function newDefault()
    {
        $contactRequest = new self();
        $contactRequest->status = self::STATUS_ACTIVE;
        $contactRequest->added_from = self::ADDED_FROM_SYSTEM;

        return $contactRequest;
    }

    public function displayName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function deleteContactRequest()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public static function scopeFilterByMarketingType($query, $marketingType)
    {
        if (is_array($marketingType) && in_array('all', $marketingType)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.source_type', (array) $marketingType);
        }
    }

    public static function scopeFilterByMarketingList($query, $marketingList)
    {
        if (is_array($marketingList) && in_array('all', $marketingList)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.list', (array) $marketingList);
        }
    }

    public static function scopeFilterByMarketingSource($query, $marketingSource)
    {
        if (is_array($marketingSource) && in_array('all', $marketingSource)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.channel', (array) $marketingSource);
        }
    }

    public static function scopeFilterByMarketingSourceSub($query, $marketingSourceSub)
    {
        if (is_array($marketingSourceSub) && in_array('all', $marketingSourceSub)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.sub_channel', (array) $marketingSourceSub);
        }
    }

    public static function scopeFilterByLifecycleStage($query, $lifecycleStage)
    {
        if (is_array($lifecycleStage) && in_array('all', $lifecycleStage)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.lifecycle_stage', (array) $lifecycleStage);
        }
    }

    public static function scopeFilterByLeadStatus($query, $leadStatus)
    {
        if (is_array($leadStatus) && in_array('all', $leadStatus)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.lead_status', (array) $leadStatus);
        }
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('contact_requests.created_at', [\Carbon\Carbon::parse($created_at_from)->startOfDay(), \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('contact_requests.updated_at', [\Carbon\Carbon::parse($updated_at_from)->startOfDay(), \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByHsLatestSourceDate($query, $from, $to)
    {
        if (!empty($from) && !empty($to)) {
            return $query->whereBetween('contact_requests.hs_latest_source_timestamp', [
                \Carbon\Carbon::parse($from)->startOfDay()->timezone('0'),
                \Carbon\Carbon::parse($to)->endOfDay()->timezone('0')]
            );
        }

        return $query;
    }
    public static function scopeFilterBySchool($query, $school)
    {
        if (is_array($school) && in_array('all', $school)) {
            return $query;
        } else {
            return $query->whereIn('contact_requests.school', (array) $school);
        }
    }

    public static function scopeFilterBySalespersonIds($query, $salesPersonIds)
    {
        // nếu mà trong salesperson ids có 'none' thì filter array loại cái none ra. 2 trường hợp
        //   1. nếu chỉ có mỗi none thôi thì where account_id = null
        //   2. vừa có none vừa có 1 hoặc nhiều salesperson khác
        //   3. không có none
        //   4. mảng rỗng luôn

        return $query->where(function ($q) use ($salesPersonIds) {
            $ids = array_filter($salesPersonIds, function ($id) {
                return $id !== 'none';
            });

            if (!empty($ids)) {
                $q->whereIn('contact_requests.account_id', $ids);
            }

            if (in_array('none', $salesPersonIds)) {
                $q->orWhereNull('contact_requests.account_id');
            }
        });
    }

    public static function scopeFilterByContactId($query, $contactId)
    {
        if (!empty($contactId)) {
            return $query->where('contact_id', $contactId);
        }

        return $query;
    }

    public function fillAttributes($params)
    {
        $this->fill($params);

        if (\Auth::user() && \Auth::user()->can('updateLeadStatus', $this)) {
            $this->lead_status = $params['lead_status'] ?? null;
            $this->last_time_update_status = Carbon::now();

            if (isset($params['lead_status']) && $params['lead_status']) {
                $this->setPreviousLeadStatus($params['lead_status']);
            }
        }
    }
    
    public function importFillAttributes($params)
    {
        // Logic để điền các thuộc tính từ $params vào mô hình ContactRequest
        $this->fill($params);
        $this->email = trim(strtolower($this->email)); // Format email trước khi lưu
        $this->phone = \App\Library\Tool::extractPhoneNumber(trim(strtolower($this->phone))); // Format số điện thoại trước khi lưu

        try {
            $this->birthday = $params['birthday'] ?? null; // Sử dụng null coalescing operator để tránh lỗi khi 'age' không tồn tại trong $params
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function saveFromRequest($request)
    {
        $this->fillAttributes($request->all());

        $validator = Validator::make($request->all(), [
            // 'contact_id' => 'required',
            'demand' => 'required',
            'source_type' => 'required',
        ]);

        $validator->after(function($validator) use ($request) {
            if (!$request->contact_id) {
                $validator->errors()->add("contact_id", "Chưa chọn khách hàng/liên hệ!");
            }
        });

        if ($request->contact_id) {
            $contact = Contact::find($request->contact_id);
    
            if (!$contact) {
                throw new \Exception("Contact with id = " . $request->contact_id . " not found!");
            }
    
            $phone = $contact->phone;
            
            if ($phone && $request->sub_channel) {
                $validator->after(function($validator) use ($request, $phone) {
                    $overlapContactRequests = ContactRequest::query()->relatedContactsByPhoneAndDemandAndSubChannel($phone, $request->demand, $request->sub_channel)->get();
                    
                    if ($overlapContactRequests->count()) {
                        $validator->errors()->add("overlap_contact_requests", "Liên hệ này đã có đơn hàng với nhu cầu và sub channel tương tự trước đây!");
                    }
                });
            }
        }

        if ($validator->fails()) {
            return $validator->errors();
        }

        // fill before save
        $this->fillInformationsFromContact($contact);

        // save
        $this->save();
        
        // order code
        if (!$this->code) {
            $this->generateCode();
        }

        return $validator->errors();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public static function importFromExcel($path_to_excel)
    {
        $spreadsheet = IOFactory::load($path_to_excel);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        $data = array_filter($data, function ($row) {
            return !empty($row[0]) || !empty($row[1]) || !empty($row[2]);
        }); // Delete empty rows

        array_shift($data); // Ignore the first row in Excel data which is header of table 

        $contactRequestRequests = [];

        foreach ($data as $row) {
            $contactRequest = new self();

            $contactRequest->name = $row[0];
            $contactRequest->phone = \App\Library\Tool::extractPhoneNumber($row[1]);
            $contactRequest->email = $row[2];
            $contactRequest->demand = $row[3];
            $contactRequest->school = $row[4];
            $contactRequest->birthday = $row[5];
            $contactRequest->timeToCall = $row[6];
            $contactRequest->country = $row[7];
            $contactRequest->city = $row[8];
            $contactRequest->district = $row[9];
            $contactRequest->ward = $row[10];
            $contactRequest->address = $row[11];
            $contactRequest->efc = $row[12];
            $contactRequest->target = $row[13];
            $contactRequest->list = $row[14];
            $contactRequest->date = $row[15];
            $contactRequest->source_type = $row[16];
            $contactRequest->channel = $row[17];
            $contactRequest->sub_channel = $row[18];
            $contactRequest->campaign = $row[19];
            $contactRequest->adset = $row[20];
            $contactRequest->ads = $row[21];
            $contactRequest->device = $row[22];
            $contactRequest->placement = $row[23];
            $contactRequest->term = $row[24];
            $contactRequest->type_match = $row[25];
            $contactRequest->fbclid = $row[26];
            $contactRequest->gclid = $row[27];
            $contactRequest->first_url = $row[28];
            $contactRequest->last_url = $row[29];
            $contactRequest->contact_owner = $row[30];
            $contactRequest->lifecycle_stage = $row[31];
            $contactRequest->previous_lead_status = $contactRequest->lead_status;
            $contactRequest->lead_status = $row[32];
            $contactRequest->last_time_update_status = Carbon::now();
            $contactRequest->note_sales = $row[33];
            $contactRequest->account_id = null; // Default is null

            $contactRequestRequests[] = $contactRequest;
        }

        return $contactRequestRequests;
    }

    public static function scopeSaveExcelDatas($request, $excelDatas, $accountId)
    {
        $logFileName = 'contact_logs.txt';
        $totalRowsProcessed = 0;
        $totalRowsSuccess = 0;
        $totalRowsFailure = 0;
        $totalRowsDuplicate = 0;

        Storage::disk('logs')->delete($logFileName);

        $logContent = '';
        $addedRows = [];

        foreach ($excelDatas as $data) {
            // Default save status is ERROR
            $saveStatus = 'ERROR';
            $contactRequest = null;

            // Validate "name" field  
            if (isset($data['name']) && !empty($data['name'])) {
                $isDuplicate = in_array($data, $addedRows);

                if (!$isDuplicate) {
                    $contactRequest = new self();
                    $contactRequest->name = $data['name'];
                    $contactRequest->email = $data['email'];
                    $contactRequest->phone = \App\Library\Tool::extractPhoneNumber($data['phone']);
                    $contactRequest->demand = $data['demand'];
                    $contactRequest->school = $data['school'];
                    $contactRequest->birthday = $data['birthday'];
                    $contactRequest->time_to_call = $data['timeToCall'];
                    $contactRequest->country = $data['country'];
                    $contactRequest->city = $data['city'];
                    $contactRequest->district = $data['district'];
                    $contactRequest->address = $data['address'];
                    $contactRequest->efc = $data['efc'];
                    $contactRequest->target = $data['target'];
                    $contactRequest->list = $data['list'];
                    // $contactRequest->created_at = $data['date'];
                    $contactRequest->source_type = $data['source_type'];
                    $contactRequest->channel = $data['channel'];
                    $contactRequest->sub_channel = $data['sub_channel'];
                    $contactRequest->campaign = $data['campaign'];
                    $contactRequest->adset = $data['adset'];
                    $contactRequest->ads = $data['ads'];
                    $contactRequest->device = $data['device'];
                    $contactRequest->placement = $data['placement'];
                    $contactRequest->term = $data['term'];
                    // $contactRequest->first_url = $data['first_url'];
                    $contactRequest->contact_owner = $data['contact_owner'];
                    $contactRequest->lifecycle_stage = $data['lifecycle_stage'];
                    $contactRequest->previous_lead_status = $contactRequest->lead_status;
                    $contactRequest->lead_status = $data['lead_status'];
                    $contactRequest->last_time_update_status = Carbon::now();
                    // $contactRequest->pic = $data['pic'];
                    $contactRequest->account_id = $accountId;

                    if ($contactRequest->save()) {
                        $saveStatus = 'SUCCESS';
                        $totalRowsSuccess++;
                    }
                } else {
                    $totalRowsDuplicate++;
                }
            } else {
                $totalRowsFailure++;
            }

            $totalRowsProcessed++;

            $addedRows[] = $data;

            $logContent .= "Time: " . now() . "\n";
            $logContent .= "Log Level: Info\n";
            $logContent .= "Save Status: $saveStatus\n";
            if ($contactRequest !== null) {
                $logContent .= "Saved contact: '{$contactRequest->name}', email: '{$contactRequest->email}', ID: '{$contactRequest->id}'\n";
            }
            $logContent .= "Request IP: " . request()->ip() . "\n";
            $logContent .= "HTTP Method: " . request()->method() . "\n";
            $logContent .= "URL: " . request()->fullUrl() . "\n";
            $logContent .= "Headers: " . json_encode(request()->header()) . "\n";
            // $logContent .= "Request Body: " . request()->getContent() . "\n";
            $logContent .= "User: " . (auth()->user() ? auth()->user()->name : 'N/A') . "\n";
            $logContent .= "Explanation: Data saved successfully\n";
            $logContent .= "Processing Time: " . (microtime(true) - LARAVEL_START) . " seconds\n";
            $logContent .= "\n ------------------------------ \n";
        }

        $result = [
            'totalRowsProcessed' => $totalRowsProcessed,
            'totalRowsSuccess' => $totalRowsSuccess,
            'totalRowsFailure' => $totalRowsFailure,
            'totalRowsDuplicate' => $totalRowsDuplicate,
        ];

        Storage::disk('logs')->put($logFileName, $logContent);

        return $result;
    }


    public static function importFromHubSpot()
    {
        // hard code api or token....
        // foreach từng dòng
        // create contact with attributes associated eith excel headers:

        // FIRST_NAME => $contactRequest->first_name
        // LAST_NAME => $contactRequest->last_name
        // EMAIL => $contactRequest->email
        // PHONE => $contactRequest->phone
        // ADDRESS => $contactRequest->address
    }

    public static function scopeIsAssigned($query)
    {
        $query = $query->active()->whereNotNull('contact_requests.account_id');
    }

    public static function scopeNoActionYet($query)
    {
        $query = $query->isAssigned()
            ->where(function ($q) {
                $q->whereNull('contact_requests.lead_status')
                    ->orWhere('contact_requests.lead_status', '');
            });
    }

    public static function scopeHasAction($query)
    {
        $query = $query->isAssigned()
            ->where(function ($q) {
                $q->whereNotNull('contact_requests.lead_status')
                    ->whereNot('contact_requests.lead_status', '');
            });
    }

    public static function scopeIsNew($query)
    {
        $query = $query->active()->whereNull('contact_requests.account_id');
    }

    public static function scopehaveNotCalled($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LIKE', "%Chưa gọi%");
    }

    public static function scopeIsKNMGLS($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LIKE', "%KNM/GLS");
    }


    public static function scopeIsKCNC($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LiKE', "%KCNC%");
    }

    public static function scopeIsDemand($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LiKE', "%Có đơn hàng%");
    }

    public static function scopeIsASAgreement($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LiKE', "%hợp đồng AS%");
    }
    public static function scopeIsASAgreementOutsideSystem($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LiKE', "%Hợp đồng (ngoài hệ thống)%");
    }

    public static function scopeIsReferrer($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LiKE', "%Khách giới thiệu khách hàng khác%");
    }

    public static function scopeIsKhachHang($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LIKE', "%Khách hàng%");
    }

    public static function scopeIsDeposits($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', 'LIKE', "%Đã đặt cọc%");
    }

    public static function scopeIsMarketingQualifiedLead($query)
    {
        $query =  $query->active()->where('contact_requests.lifecycle_stage', 'LIKE', "%Marketing Qualified Lead%");
    }

    public static function scopeIsSaleQualifiedLead($query)
    {
        $query =  $query->active()->where('contact_requests.lifecycle_stage', 'LIKE', "%Sale Qualified Lead%");
    }

    public static function scopeLifecycleStageIsCustomer($query)
    {
        $query =  $query->active()->where('contact_requests.lifecycle_stage', '=', "Customer");
    }

    public static function scopeIsVIPCustomer($query)
    {
        $query =  $query->active()->where('contact_requests.lifecycle_stage', 'LIKE', "%VIP Customer%");
    }

    public static function scopeIsLead($query)
    {
        $query =  $query->active()->where('contact_requests.lifecycle_stage', 'LIKE', "%Lead%");
    }
    public static function scopeIsError($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_ERROR);
    }
    public static function scopeIsNotPickup($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_NOT_PICK_UP);
    }
    public static function scopeIsNotPickupManyTimes($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_NOT_PICK_UP_MANY_TIMES);
    }
    public static function scopeIsDuplicateData($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_DUPLICATE_DATA);
    }
    public static function scopeIsNotPotential($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_NOT_POTENTIAL);
    }
    public static function scopeIsHasRequest($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_HAS_REQUEST);
    }
    public static function scopeIsFollow($query)
    {
        $query = $query->active()->where('contact_requests.lead_status', self::LS_FOLLOW);
    }
    public static function scopeIsPotential($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_POTENTIAL);
    }
    public static function scopeIsAgreement($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_MAKING_CONSTRACT);
    }

    public static function scopeIsHasContract($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_HAS_CONSTRACT);
    }

    public static function scopeIsNA($query)
    {
        $query =  $query->active()->where('contact_requests.lead_status', self::LS_NA);
    }
    // public static function getLeadStatusMenu($query, $lead_status_menu)
    // {
    //     if ($lead_status_menu == 'have_not_called') {
    //         return $query->where('contact_requests.lead_status', 'LIKE', "%Chưa gọi%");
    //     } else if ($lead_status_menu == 'knm_gls') {
    //         return $query->where('contact_requests.lead_status', 'LIKE', "%KNM/GLS");
    //     } else if ($lead_status_menu == 'ls_error') {
    //         return $query->where('contact_requests.lead_status', 'LIKE', "%Sai số%");
    //     } else if ($lead_status_menu == 'kcnc') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%KCNC%");
    //     } else if ($lead_status_menu == 'demand') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%Có đơn hàng%");
    //     } else if ($lead_status_menu == 'follow') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%Follow dài%");
    //     } else if ($lead_status_menu == 'potential') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%Tiềm năng%");
    //     } else if ($lead_status_menu == 'agreement') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%Đang làm hợp đồng%");
    //     } else if ($lead_status_menu == 'as-agreement') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%hợp đồng AS%");
    //     } else if ($lead_status_menu == 'referrer') {
    //         return $query->where('contact_requests.lead_status', 'LiKE', "%Khách giới thiệu khách hàng khác%");
    //     }else if ($lead_status_menu == 'khach_hang') {
    //         return $query->where('contact_requests.lead_status', 'LIKE', "%Khách hàng%");
    //     }else if ($lead_status_menu == 'deposits') {
    //         return $query->where('contact_requests.lead_status', 'LIKE', "%Đã đặt cọc%");
    //     }else if ($lead_status_menu == 'as-agreement-outside-system') {
    //         return $query->where('contact_requests.lead_status', 'LIKE', "%Hợp đồng (ngoài hệ thống)%");
    //     }
    // }
    public static function getLeadStatusMenu($query, $lead_status_menu)
    {
        if ($lead_status_menu == 'have_not_called') {
            return $query->where('contact_requests.lead_status', 'LIKE', "%Chưa gọi%");
        } else if ($lead_status_menu == self::LS_ERROR) {
            return $query->where('contact_requests.lead_status', self::LS_ERROR);
        } else if ($lead_status_menu == self::LS_NOT_PICK_UP) {
            return $query->where('contact_requests.lead_status', self::LS_NOT_PICK_UP);
        } else if ($lead_status_menu == self::LS_NOT_PICK_UP_MANY_TIMES) {
            return $query->where('contact_requests.lead_status', self::LS_NOT_PICK_UP_MANY_TIMES);
        } else if ($lead_status_menu == self::LS_DUPLICATE_DATA) {
            return $query->where('contact_requests.lead_status', self::LS_DUPLICATE_DATA);
        } else if ($lead_status_menu == self::LS_NOT_POTENTIAL) {
            return $query->where('contact_requests.lead_status', self::LS_NOT_POTENTIAL);
        } else if ($lead_status_menu == self::LS_HAS_REQUEST) {
            return $query->where('contact_requests.lead_status', self::LS_HAS_REQUEST);
        } else if ($lead_status_menu == self::LS_FOLLOW) {
            return $query->where('contact_requests.lead_status', self::LS_FOLLOW);
        } else if ($lead_status_menu == self::LS_POTENTIAL) {
            return $query->where('contact_requests.lead_status', self::LS_POTENTIAL);
        } else if ($lead_status_menu == self::LS_HAS_CONSTRACT) {
            return $query->where('contact_requests.lead_status', self::LS_HAS_CONSTRACT);
        } else if ($lead_status_menu == self::LS_MAKING_CONSTRACT) {
            return $query->where('contact_requests.lead_status', self::LS_MAKING_CONSTRACT);
        }
        // else if ($lead_status_menu == 'kcnc') {
        //     return $query->where('contact_requests.lead_status', 'LiKE', "%KCNC%");
        // } else if ($lead_status_menu == 'demand') {
        //     return $query->where('contact_requests.lead_status', 'LiKE', "%Có đơn hàng%");
        // }  else if ($lead_status_menu == 'potential') {
        //     return $query->where('contact_requests.lead_status', 'LiKE', "%Tiềm năng%");
        // } else if ($lead_status_menu == 'agreement') {
        //     return $query->where('contact_requests.lead_status', 'LiKE', "%Đang làm hợp đồng%");
        // } else if ($lead_status_menu == 'as-agreement') {
        //     return $query->where('contact_requests.lead_status', 'LiKE', "%hợp đồng AS%");
        // } else if ($lead_status_menu == 'referrer') {
        //     return $query->where('contact_requests.lead_status', 'LiKE', "%Khách giới thiệu khách hàng khác%");
        // }else if ($lead_status_menu == 'khach_hang') {
        //     return $query->where('contact_requests.lead_status', 'LIKE', "%Khách hàng%");
        // }else if ($lead_status_menu == 'deposits') {
        //     return $query->where('contact_requests.lead_status', 'LIKE', "%Đã đặt cọc%");
        // }else if ($lead_status_menu == 'as-agreement-outside-system') {
        //     return $query->where('contact_requests.lead_status', 'LIKE', "%Hợp đồng (ngoài hệ thống)%");
        // }
    }

    public static function getLifecycleStageMenu($query, $lifecycle_stage_menu)
    {
        if ($lifecycle_stage_menu == 'marketing-qualified-lead') {
            return $query->where('contact_requests.lifecycle_stage', 'LIKE', "%Marketing Qualified Lead%");
        } elseif ($lifecycle_stage_menu == 'sale-qualified-lead') {
            return $query->where('contact_requests.lifecycle_stage', 'LIKE', "%Sale Qualified Lead%");
        } elseif ($lifecycle_stage_menu == 'customer') {
            return $query->where('contact_requests.lifecycle_stage', '=', "Customer");
        } elseif ($lifecycle_stage_menu == 'vip-customer') {
            return $query->where('contact_requests.lifecycle_stage', 'LIKE', "%VIP Customer%");
        } elseif ($lifecycle_stage_menu == 'lead') {
            return $query->where('contact_requests.lifecycle_stage', 'LIKE', "%Lead%");
        }
    }

    public static function getLeadStatusName($lead_status_menu)
    {
        if ($lead_status_menu == 'have_not_called') {
            return 'Chưa gọi';
        } else if ($lead_status_menu == 'knm_gls') {
            return 'KNM/GLS';
        } else if ($lead_status_menu == 'is_error') {
            return 'Sai số';
        } else if ($lead_status_menu == 'kcnc') {
            return 'KCNC';
        } else if ($lead_status_menu == 'demand') {
            return 'Có đơn hàng';
        } else if ($lead_status_menu == 'follow') {
            return 'Follow dài';
        } else if ($lead_status_menu == 'potential') {
            return 'Tiềm năng';
        } else if ($lead_status_menu == 'agreement') {
            return 'Đang làm hợp đồng';
        } else if ($lead_status_menu == 'as-agreement') {
            return 'hợp đồng AS';
        } else if ($lead_status_menu == 'referrer') {
            return 'Khách giới thiệu khách hàng khác';
        }else if ($lead_status_menu == 'khach_hang') {
            return 'Khách hàng';
        }else if ($lead_status_menu == 'deposits') {
            return 'Đã đặt cọc';
        }
    }

    public static function getLifecycleStageName($lifecycle_stage_menu)
    {
        if ($lifecycle_stage_menu == 'marketing-qualified-lead') {
            return 'Marketing Qualified Lead';
        } elseif ($lifecycle_stage_menu == 'sale-qualified-lead') {
            return 'Sale Qualified Lead';
        } elseif ($lifecycle_stage_menu == 'customer') {
            return 'Customer';
        } elseif ($lifecycle_stage_menu == 'vip-customer') {
            return 'VIP Customer';
        } elseif ($lifecycle_stage_menu == 'lead') {
            return 'Lead';
        }
    }

    // Lấy contact thông qua Token hubspot
    public static function getTokenAPI($token)
    {
        // Tạo một HTTP client
        $client = new Client();

        // Gửi yêu cầu API HubSpot
        // Gửi yêu cầu API HubSpot với kiểm tra chứng chỉ SSL tắt
        // Hiển thị các properties https://api.hubapi.com/crm/v3/objects/contacts/properties
        $response = $client->get('https://api.hubapi.com/crm/v3/objects/contacts?properties=address,email,firstname,lastname,phone,school', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
            'verify' => false,
            // Vô hiệu hóa kiểm tra chứng chỉ SSL
        ]);

        // Lấy dữ liệu từ response
        $data = json_decode($response->getBody(), true);
        $customers = $data["results"];
        $selectedAttributes = [];

        // Duyệt qua danh sách khách hàng và lấy các thuộc tính cần
        foreach ($customers as $customer) {
            $properties = $customer["properties"];
            $selectedAttributes[] = [
                'hubstop_id' => $customer["id"],
                'address' => $properties["address"],
                'email' => $properties["email"],
                'firstname' => $properties["firstname"],
                'lastname' => $properties["lastname"],
                'phone' => $properties["phone"],
                'school' => $properties["school"],
            ];
        }

        return $selectedAttributes;
    }

    // Lưu contacts vào database
    public static function getSaveContactRequestsHubspot($customers, $account_id)
    {
        $newCustomersCount = 0;
        $updatedCustomersCount = 0;

        foreach ($customers as $data) {
            // Kiểm tra xem có hợp đồng với cùng HubSpot ID đã tồn tại chưa
            $contactRequest = self::where('hubspot_id', $data["hubstop_id"])->first();

            if ($contactRequest) {
                // Nếu đã tồn tại hợp đồng với cùng HubSpot ID, thực hiện cập nhật
                $contactRequest->email = $data['email'];
                $contactRequest->phone = \App\Library\Tool::extractPhoneNumber($data['phone']);
                $contactRequest->account_id = $account_id;
                $updatedCustomersCount++;

                $contactRequest->save();
            } else {
                // Nếu không có hợp đồng nào với cùng HubSpot ID tồn tại, tạo một hợp đồng mới
                $contactRequest = self::newDefault();
                $contactRequest->name = $data['lastname'];
                $contactRequest->hubspot_id = $data['hubstop_id'];
                $contactRequest->email = $data['email'];
                $contactRequest->phone = \App\Library\Tool::extractPhoneNumber($data['phone']);
                $contactRequest->account_id = $account_id;
                $contactRequest->save();
                $newCustomersCount++;
                try {
                } catch (\Exception $e) {
                    // \Log::error('Lỗi khi lưu hợp đồng: ' . $e->getMessage());
                    return response()->json(['message' => $e->getMessage()]);
                    // Nếu bạn muốn xử lý lỗi khác ở đây, bạn có thể thêm mã xử lý lỗi tùy chỉnh.
                }
            }
        }
        return [
            'newCustomersCount' => $newCustomersCount,
            'updatedCustomersCount' => $updatedCustomersCount,
        ];
    }

    public static function importContactRequests($updateProgress)
    {
        $total = 100;

        for ($i = 1; $i <= $total; $i++) {

            echo $i;
            sleep(1);

            $updateProgress([
                'status' => 'running',
                'total' => $total,
                'sucess' => $i,
                'failed' => 0,
            ]);
        }
    }

    public function assignToAccount($account, $assignedAt=null)
    {
        if (!$assignedAt) {
            $assignedAt = \Carbon\Carbon::now();
        }

        $this->account_id = $account->id;
        $this->assigned_at = $assignedAt ;

        //
        $this->assigned_expired_at = \App\Helpers\Functions::calculateExpiredAt($this->assigned_at);

        $this->save();

        // Contact the same
        $this->contact->account_id = $account->id;
        $this->contact->assigned_at = $assignedAt ;

        //
        $this->contact->assigned_expired_at = \App\Helpers\Functions::calculateExpiredAt($this->contact->assigned_at);

        $this->contact->save();
    }

    public function scopeOutdated($query)
    {
        $query = $query->whereNotNull('contact_requests.assigned_at')
            ->noActionYet()
            ->where('contact_requests.assigned_expired_at', '<', \Carbon\Carbon::now());
    }

    public function hasActionAlready()
    {
        return $this->lead_status;
    }

    public function getDeadlineCountDownInMinutes()
    {
        if ($this->hasActionAlready()) {
            return "--";
        }
        // return $this->assigned_at;
        $deadline = \Carbon\Carbon::parse($this->assigned_expired_at);
        $seconds = \Carbon\Carbon::now()->diffInSeconds($deadline, false);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        if ($seconds > 0) {
            return "Còn $hours:$minutes phút";
        } else {
            $hours = abs($hours);
            $minutes = abs($minutes);
            return "Trễ $hours:$minutes phút";
        }
    }

    public function isOutdated()
    {
        $deadline = \Carbon\Carbon::parse($this->assigned_expired_at);

        return $deadline->lessThan(\Carbon\Carbon::now());
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function noteLogs()
    {
        return $this->hasMany(NoteLog::class);
    }

    public function scopeIsCustomer($query)
    {
        $query = $query->whereHas('orders', function ($query) {
            $query->whereNotNull('id');
        });
    }

    public static function getExportHeaders()
    {
        return [
            'Ngày Khách Điền Form', // A
            'Ngày Chia Data', // B
            'Sub-Chanel', // C
            'School', // D
            'EFC', // E
            'Name', // F
            'Phone Number', // G
            'Email', // H
            'Demand', // I
            'Campaign', // J
            'Adset', // K
            'Ad', // L
            'Conversion URL', // M
            'T/F', // N
            'SQL', // O
            'Contact Owner', // P
            'Contact Owner 2', // Q
            'Xác nhận tham gia HT', // R
            'Lead Status', // S
            'Note', // T
            'Độ tuổi học sinh', // U
            'Thời gian phù hợp', // V
            'Country', // W
            'City', // X
            'District', // Y
            'Ward', // Z
            'Address', // AA
            'Target', // AB
            'List', // AC
            'Source Type', // AD
            'Channel', // AE
            'Device', // AF
            'Placement', // AG
            'Term', // AH
            'Type Match', // AI
            'Fbclid', // AJ
            'Gclid', // AK
            'Lifecycle Stage', // AL
            'EFC', // AM
            'SystemID', // AN
            'FatherPhone', // AO
            'MotherPhone', // AP
            'FatherName', // AQ
            'MotherName', // AR
            'Birthday', // AS
        ];
    }

    public function getExportRowData()
    {
        return [
            $this->created_at->format('Y-m-d'), // Ngày khách điền from [A]
            \Carbon\Carbon::parse($this->assigned_at)->format('Y-m-d'), //Ngày chia data [B]
            $this['sub_channel'], // Sub-Chanel [C]
            $this['school'], // School [D]
            $this['efc'], // EFC [E]
            $this->name, // Name [F]
            $this->phone, // Phone number [G]
            $this->email, // Email [H]
            $this['demand'],// Demand [I]
            $this['campaign'],// Campaign [J]
            $this['adset'], // Adset [K]
            $this['ads'], // Ad [L]
            $this['last_url'], // Conversion URL [M]
            '', // T/F [N]
            '', // SQL [O]
            $this->account ? $this->account->name : '', //Contact Owner [P]
            '', // Contact Owner 2 [Q]
            '', // Xác nhận tham gia HT [R]
            trans('messages.contact_request.lead_status.' . $this['lead_status']), // Lead Status [S]
            // $this->getMarketingLatestNoteLog() ?
            //     strip_tags($this->getMarketingLatestNoteLog()->content) : $this->note_sales, // Note [T]
            $this->getMarketingNoteLogsContent(),

            $this['age'], // Độ tuổi học sinh [U]
            $this['time_to_call'], //Thời gian phù hợp [V]
            $this['country'], // Country [W]
            $this['city'], //City [X]
            $this['district'], //District [Y]
            $this['ward'], // Ward [Z]
            $this['address'], // Address [AA]
            $this['target'], // Target [AB]
            $this['list'], // List [AC]
            $this['source_type'], // Source Type (Phân loại nguồn) [AD]
            $this['channel'], // Channel [AE]
            $this['device'], // Device [AF]
            $this['placement'], // Placement [AG]
            $this['term'], // Term [AG]
            $this['type_match'],// Type Match [AI]
            $this['fbcid'], // Fbclid [AJ]
            $this['gclid'], // Gclid [AK]
            $this['lifecycle_stage'], //Lifecycle Stage [AL]
            $this['efc'], // EFC [AM]
            $this->id, // System ID [AN]

            $this->father_id ? $this->father->phone : '', // father phone [AO]
            $this->mother_id ? $this->mother->phone : '', // mother phone [AP]
            $this->father_id ? $this->father->name : '', // father name [AQ]
            $this->mother_id ? $this->mother->name : '', // mother name [AR]

            $this->birthday, // birthday [AS]
        ];
    }

    public static function exportToExcel($templatePath, $filteredContactRequests)
    {
        $filteredContactRequests = $filteredContactRequests;
        // $contactRequestRequests = self::orderBy('updated_at', 'desc')->get()->toArray();
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        // $rowIndex = 2;

        foreach ($filteredContactRequests as $contactRequest) {
            // Date formatting
            $created_at = $contactRequest['created_at'] ? Carbon::parse($contactRequest['created_at'])->format('d/m/Y') : null;
            $birthday = $contactRequest->contact->birthday ? Carbon::parse($contactRequest->contact->birthday)->format('d/m/Y') : null;

            // $notelog = NoteLog::where('contact_id', $contactRequest['id'])->first();
            // if ($notelog) {
            //     $notelogContent = $notelog->content;
            // } else {
            $notelogContent = '';
            // }

            $rowData = $contactRequest->getExportRowData();

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public static function scopeSelect2($query, $request)
    {
        // keyword
        if ($request->search ) {
            // $query = $query->search($request->search);
            $keyword = trim($request->search);
            $query = $query->where(function($q) use ($keyword) {
                $q->where('email', $keyword)
                    ->orWhere('name', $keyword)
                    ->orWhere('phone', $keyword);
            });
        } else {
            $query = $query->where('id', 0);
        }

        // pagination
        $contactRequestRequests = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $contactRequestRequests->map(function ($contactRequest) {
                return [
                    'id' => $contactRequest->id,
                    'text' => '<strong>' . $contactRequest->name . '</strong><div>' . $contactRequest->email . '</div>' . $contactRequest->phone . '</div>',
                ];
            })->toArray(),
            "pagination" => [
                "more" => $contactRequestRequests->lastPage() != $request->page,
            ],
        ];
    }

    public static function schoolSelect2($request)
    {
        $query = self::whereNot('school', null)->whereNot('school', '')->groupBy('school');
        // search
        if ($request->search) {
            $query = self::where(function($q) use ($request) {
                $q->where('school', 'LIKE', "%$request->search%");
            });
        }

        // pagination
        $records = $query->select('school')->paginate($request->per_page ?? '10');

        return [
            "results" => $records->map(function ($record) {
                return [
                    'id' => $record->school,
                    'text' => $record->school,
                ];
            })->toArray(),
            "pagination" => [
                "more" => $records->lastPage() != $request->page,
            ],
        ];
    }

    public function addNoteLog($account, $content, $systemAdd=false)
    {
        return $this->noteLogs()->create([
            'contact_id' => $this->contact_id,
            'content' => $content,
            'account_id' => $account->id,
            'status' => NoteLog::STATUS_ACTIVE,
            'system_add' => $systemAdd,
        ]);
    }

    public static function getReports($xType, $yType, $xColumns, $yColumns, $dataType, $request)
    {
        $data = [];
        $columnTotals = [];
        $columnxTotals = [];
        $data['tổng Columnx']['tổng Columny'] = 0;

        foreach ($xColumns as $xColumn) {
            $data[$xColumn]['tổng Columny'] = 0;

            foreach ($yColumns as $yColumn) {
                // 
                if ($dataType == 'new_contact') {
                    $contactRequestRequests = self::query();
                } elseif ($dataType == 'new_customer') {
                    $contactRequestRequests = self::select('contacts.*')
                        ->selectSub(function ($query) {
                            $query->select('created_at')
                                ->from('orders')
                                ->whereColumn('contact_id', 'contacts.id')
                                ->orderBy('created_at', 'asc')
                                ->limit(1);
                        }, 'first_order_created_at')
                        ->whereHas('orders');
                }

                // X
                if ($xType == 'lead_status') {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.lead_status', $xColumn);
                } else if ($xType == 'channel') {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.channel', $xColumn);
                } else if ($xType == 'sales') {
                    $account = Account::where('accounts.name', $xColumn)->first();
                    $accountId = $account->id;
                    $contactRequestRequests = $contactRequestRequests->where('account_id', $accountId);
                }

                // Y
                if ($yType == 'lead_status') {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.lead_status', $yColumn);
                } else if ($yType == 'channel') {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.channel', $yColumn);
                } else if ($yType == 'sales') {
                    $account = Account::where('accounts.name', $yColumn)->first();
                    $accountId = $account->id;
                    $contactRequestRequests = $contactRequestRequests->where('account_id', $accountId);
                }

                // fitlers by create_at
                if ($request->has('created_at_from') && $request->has('created_at_to')) {
                    $created_at_from = $request->input('created_at_from');
                    $created_at_to = $request->input('created_at_to');
                    $contactRequestRequests  = $contactRequestRequests->filterByCreatedAt($created_at_from, $created_at_to);
                }

                // Filter by updated_at
                if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
                    $updated_at_from = $request->input('updated_at_from');
                    $updated_at_to = $request->input('updated_at_to');
                    $contactRequestRequests  = $contactRequestRequests->filterByUpdatedAt($updated_at_from, $updated_at_to);
                }

                if (isset($request->selectedMarketingSource)) {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.channel', $request->input('selectedMarketingSource'));
                }

                if (isset($request->selectedMarketingSubChannel)) {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.sub_channel', $request->input('selectedMarketingSubChannel'));
                }

                if (isset($request->selectedLifecycleSource)) {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.lifecycle_stage', $request->input('selectedLifecycleSource'));
                }

                if (isset($request->selectedLifecycleSubChannel)) {
                    $contactRequestRequests = $contactRequestRequests->where('contact_requests.lead_status', $request->input('selectedLifecycleSubChannel'));
                }

                $result = $contactRequestRequests->count();
                $data[$xColumn]['tổng Columny'] += $result;
                $data[$xColumn][$yColumn] = $result;

                // Tính tổng cho cột $xColumn
                if (!isset($columnTotals[$xColumn])) {
                    $columnTotals[$xColumn] = 0;
                }

                $columnTotals[$xColumn] += $result;
            }
        }

        foreach ($yColumns as $yColumn) {
            $columnTotal = 0;
        
            foreach ($xColumns as $xColumn) {
                $columnTotal += $data[$xColumn][$yColumn];
            }

            $data['tổng Columnx'][$yColumn] = $columnTotal;
            // Update the total column
            $data['tổng Columnx']['tổng Columny'] += $columnTotal;
        }

        return $data;
    }

    public static function scopeDoesntHaveNewOrder($query)
    {
        $query->whereDoesntHave('orders', function ($q) {
            $q->notDeleted();
        });
    }

    public function hasOrders()
    {
        return $this->orders()->notDeleted()->exists();
    }
    public function scopeWithOrders($query)
    {
        return $query->whereHas('orders', function ($q) {
            $q->notDeleted(); 
        });
    }
    public function scopeWithoutOrders($query)
    {
        return $query->whereDoesntHave('orders');
    }
    public static function scopeDoesntHaveOrder($query)
    {
        $query->whereDoesntHave('orders', function ($q) {
            $q->notDeleted();
        });
    }
    public static function scopeHaveReminder($query)
    {
        $query->whereNotNull('contact_requests.reminder');
        
    }

    public function getOrder()
    {
        return $this->orders()->notDeleted()->first();
    }

    public static function scopeHaveOrderIsDraft($query)
    {
        $query = $query->whereHas('orders', function ($q) {
            $q->notDeleted()->where('orders.status', Order::STATUS_DRAFT);
        });
    }

    public function setLeadStatus($status)
    {
        if (!in_array($status, config('leadStatuses'))) {
            throw new \Exception("Trạng thái $status không có trong bộ trạng thái của lead statuses (config('leadsStatuses'))");
        }

        $this->lead_status = $status;
        $this->last_time_update_status = Carbon::now();
        $this->save();
    }

    public function setPreviousLeadStatus($status)
    {
        $this->previous_lead_status = $status;
        // $this->save();
    }

    public function generateCode($force=false)
    {
        if ($this->code && !$force) {
            throw new \Exception("Contact Request code exists!");
        }

        $orderYear = $this->created_at->year;
        $maxCode = self::where('code_year', $orderYear)->lockForUpdate()->max('code_number');
        $codeNumber = $maxCode ? ($maxCode + 1) : 1;

        $this->code_year = $orderYear;
        $this->code_number = $codeNumber;
        $this->save();

        // refresh code
        $this->refreshCode();
    }

    public function refreshCode()
    {
        $this->code = 'NC' . sprintf("%04s", $this->code_number) . "/" . $this->code_year;
        $this->save();
    }

    public function getFullAddress()
    {
        return "{$this->address}, {$this->ward}, {$this->district}, {$this->city}";
    }

    public static function scopeDeleteAll($query, $contactRequestIds)
    {
        $contactRequests = self::whereIn('id', $contactRequestIds)->get();

        foreach ($contactRequests as $contactRequest) {
            $contactRequest->update(['status' => self::STATUS_DELETED]);
        }
    }

    public function updateLeadStatus($leadStatus)
    {
        $this->lead_status = $leadStatus;
        $this->last_time_update_status = Carbon::now();
        $this->lifecycle_stage = self::getLifecycleStageByLeadStatus($this->lead_status);
        $this->save();
    }

    public function updateLifecycleStage($lifecycleStage)
    {
        $this->lifecycle_stage = $lifecycleStage;
        $this->save();
    }

    public function rollbackStatus() {
        $this->lead_status = $this->previous_lead_status;
        $this->last_time_update_status = Carbon::now();
        $this->save();
    }

    public static function  getLifecycleStageByLeadStatus($leadStatus)
    {
        return config('leadStatusValues')[$leadStatus];
    }
    
    public static function findRelatedContacts3($fields)
    {
        $query = self::query();
        $query = $query->where(function ($q) use ($fields) {
            $q = $q->whereRaw('LOWER(phone) = ?', [trim(strtolower($fields['phone']))]);
        });

        return $query->get();
    }

    /**
      * Get the free time sections for the contact request
      * 
      * @return array
      */
      public function getFreeTimeSections(): array
      {
         $freeTimes = $this->freeTimes()->get();
         $result = [];

         foreach($freeTimes as $freeTime) {
             // Count num of days
             $startDate = new DateTime($freeTime->from_date);
             $endDate = new DateTime($freeTime->to_date);
             $interval = new DateInterval('P1D');
             $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));
 
             // Loop per day in the period
             foreach($period as $date) {
                 $dayOfWeek = $date->format('N');
 
                 if ($dayOfWeek == 7) {
                     $dayOfWeek = 1; // Change number 7 -> 1 (Sunday)
                 } else {
                     $dayOfWeek += 1; // Upgrade +1 to every day
                 }
 
                 // Get the timestamps in the day from free_time_records
                 $freeTimeRecords = $freeTime->freeTimeRecords()
                                             ->where('day_of_week', $dayOfWeek)
                                             ->get();

                 // Loop per timestamps and push into result[]
                 foreach($freeTimeRecords as $record) {
                     $result[] = [
                         'study_date' => $date->format('Y-m-d'),
                         'start_at' => $date->format('Y-m-d') . ' ' . $record->from,
                         'end_at' => $date->format('Y-m-d') . ' ' . $record->to,
                         // Additional fields with default values
                         "code" => "",
                         "type" => "",
                         "is_vn_teacher_check" => false,
                         "vn_teacher_id" => null,
                         "vn_teacher_from" => "",
                         "vn_teacher_to" => "",
                         "is_foreign_teacher_check" => false,
                         "foreign_teacher_id" => null,
                         "foreign_teacher_from" => "",
                         "foreign_teacher_to" => "",
                         "is_tutor_check" => false,
                         "tutor_id" => null,
                         "tutor_from" => "",
                         "tutor_to" => "",
                         "is_assistant_check" => false,
                         "assistant_id" => null,
                         "assistant_from" => "",
                         "assistant_to" => "",
                         "order_number" => 1,
                         "viewer" => 'freetime',
                     ];
                 }
             }
         }
 
         return $result;
      }
     
    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('account', function ($q) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $q->where('branch', $branch);
            }
        });
    }

    public function assignOutDateNotified()
    {
        $this->out_date_notified = true;
        $this->save();
    }

    public function assignUnfulfilledOverHoursNotified()
    {
        $this->unfulfilled_over_hours = true;
        $this->save();
    }

    public function scopeOutdatedUnNotified($query)
    {
        $query = $query->whereNotNull('contact_requests.assigned_at')
                ->where('out_date_notified', false) // Flag: unnotificate
                ->where('contact_requests.assigned_expired_at', '<', \Carbon\Carbon::now());
    }
    public function scopeReminderUnNotified($query)
    {
        $query = $query->whereNotNull('contact_requests.reminder')
                ->where('reminder_notified', false) // Flag: unnotificate
                ->where('contact_requests.reminder', '<=', Carbon::now()->addHours(2));
    }
    public function reminderNotified()
    {
        $this->reminder_notified = true;
        $this->save();
    }
    /**
     * Retrieve contact requests overdue by 2 hours but still pending processing.
     */
    public function scopeUnfulfilledOver2Hours($query)
    {
        $query = $query->whereNotNull('contact_requests.assigned_at') // Assigned
                        ->where('contact_requests.assigned_expired_at', '<', \Carbon\Carbon::now())
                        ->where('unfulfilled_over_hours', false) // Flag: unnotificate
                        ->where('contact_requests.lead_status', null); // Unfulfill
    }

    public static function getEditableLeadStatuses()
    {
        return array_diff(config('leadStatuses'), [
            self::LS_MAKING_CONSTRACT,
            self::LS_HAS_CONSTRACT,
        ]);
    }

    public static function importFromExcelFile($filePath) 
    {
        // đọc từ filePath, lấy 1 lúc 60k dòng luôn
        $datas = []; // .... mapping data sao cho giống với data từ form như cái của hiện tại, option thứ mấy... là update cái có sẵn, tạo mới nếu chưa.....
        
        // gọi làm hàm hiện tại
        self::saveExcelDatas($datas, $accountId);
     }
     
    // public static function findRelatedContactRequest($fields)
    // {
    //     $query = self::query();
    //     $query = $query->where(function ($q) use ($fields) {
    //         $q = $q->whereRaw('LOWER(phone) = ?', [trim(strtolower($fields['phone']))]);
    //         $q = $q->whereRaw('LOWER(demand) = ?', [trim(strtolower($fields['demand']))]);
    //     });

    //     return $query;
    // }

    public static function findRelatedContactRequest($fields)
    {
        $query = self::query();

        $query = $query->where(function ($q) use ($fields) {
            if (isset($fields['phone']) && !is_null($fields['phone'])) {
                $phone = \App\Library\Tool::extractPhoneNumber(trim(strtolower($fields['phone'])));
                $q->where('phone', '=', $phone);
            }
            
            if (isset($fields['demand']) && !is_null($fields['demand'])) {
                $demand = trim(($fields['demand']));
                $q->where('demand', '=', $demand);
            }
        });

        return $query;
    }
    
    public function getAllContactRequestsByContact()
    {
        return $this->contact->contactRequests()->active();
    }

    public static function scopeAddedFrom($query, $addedFrom)
    {
        $query->where('contact_requests.added_from', $addedFrom);
    }

    public static function scopeByGoogleSheetId($query, $googleSheetId)
    {
        $query->where('contact_requests.google_sheet_id', $googleSheetId);
    }

    public function isLongUnExploited($numOfDays)
    {
        $lastUpdateLeadStatusTime = Carbon::parse($this->last_time_update_status);

        return Carbon::now()->diffInDays($lastUpdateLeadStatusTime) >= $numOfDays;
    }

    public function scopeLongUnExploitedContactRequests($query)
    {
        $query = $query->where(function($q) {
            $numOfDays = 1; // Temporary

            return $q->isLongUnExploited($numOfDays);
        });
    }

    public function scopeBySchools($query, array $schools)
    {
        $query = $query->whereIn('contact_requests.school', $schools);
    }

    public function scopeRelatedContactsByPhoneAndDemand($query, $phone, $demand)
    {
        if (empty($phone)) {
            return $query->where('id', -1);
        }

        $phoneLegacy = \App\Library\Tool::extractPhoneNumberLegacy($phone);
        $phoneFormatted  = \App\Library\Tool::extractPhoneNumber2($phone);

        // Chỉ cần trùng số điện thoại là 1 contact
        $query->active()
            ->where(function($q) use ($phone, $phoneLegacy, $phoneFormatted) {
                $q->where('phone', $phone)
                    ->orWhere('phone', $phoneLegacy)
                    ->orWhere('phone', $phoneFormatted);
            })
            ->where('demand', $demand);
    }

    public function fillInformationsFromContact($contact)
    {
        if ( !is_null($contact->phone)){
            $this->phone = $contact->phone;
        }

        if ( !is_null($contact->email)){
            $this->email = trim($contact->email);
        }

        if ( !is_null($contact->address)){
            $this->address = trim($contact->address);
        }

        if ( !is_null($contact->country)){
            $this->country = trim($contact->country);
        }

        if ( !is_null($contact->district)){
            $this->district = trim($contact->district);
        }

        if ( !is_null($contact->school)){
            $this->school = trim($contact->school);
        }

        if ( !is_null($contact->birthday)){
            $this->birthday = trim($contact->birthday);
        }

        if ( !is_null($contact->age)){
            $this->age = trim($contact->age);
        }
    }

    public function scopeRelatedContactsByPhoneAndDemandAndSubChannel($query, $phone, $demand, $subChannel)
    {
        if (empty($phone)) {
            return $query->where('id', -1);
        }

        $phoneLegacy = \App\Library\Tool::extractPhoneNumberLegacy($phone);
        $phoneFormatted  = \App\Library\Tool::extractPhoneNumber2($phone);

        // 
        $query->active()
            ->whereHas('contact', function($q) use ($phone, $phoneLegacy, $phoneFormatted) {
                $q->where('phone', $phone)
                    ->orWhere('phone', $phoneLegacy)
                    ->orWhere('phone', $phoneFormatted);
            })
            ->where('sub_channel', $subChannel)
            ->where('demand', $demand);
    }

    public function scopeRelatedContactsByPhoneMotherPhoneFatherPhoneAndDemandAndSubChannel($query, $phone, $motherPhone, $fatherPhone, $demand, $subChannel)
    {
        // 
        $query->active()
            ->whereHas('contact', function($q) use ($phone, $motherPhone, $fatherPhone) {
                $q->relatedContactsByPhoneMotherPhoneFatherPhone($phone, $motherPhone, $fatherPhone);
            })
            ->where('sub_channel', $subChannel)
            ->where('demand', $demand);
    }

    public function fillChannelSourceType()
    {
        if ($this->sub_channel) {
            // try {
                $this->channel = \App\Helpers\Functions::getChannelBySubChannel($this->sub_channel)['channel'];
                $this->source_type = \App\Helpers\Functions::getChannelBySubChannel($this->sub_channel)['source_type'];
            // } catch (\Throwable $e) {
            //     // logging
            //     // $this->logError("CAN NOT FIND SOURCE_TYPE/CHANNEL FROM SUB-CHANNEL $this->sub_channel: " . $e->getMessage() . " ==> skipped #{$data['name']} - {$data['phone']}");
            // }
        }
    }

    public function selfUpdateChannelSourceType()
    {
        $this->fillChannelSourceType();
        $this->save();
    }

    public function getMarketingNoteLogsContent()
    {
        $noteLogs = $this->getMarketingNoteLogs();
        $contentString = '';
    
        foreach ($noteLogs as $index => $noteLog) {
            $contentString .= strip_tags($noteLog->content);
            if ($index < count($noteLogs) - 1) {
                $contentString .= '; '; // Ngăn cách bằng dấu chấm phẩy và khoảng trắng
            }
        }
        if (!empty($this->note_sales)) {
            if (!empty($contentString)) {
                $contentString .= '; ';
            }
            $contentString .= '(I) ' . strip_tags($this->note_sales);
        }
    
    
    
        return $contentString;
    }

    public function getMarketingNoteLogs()
    {
        return NoteLog::where('status', 'active')
            ->where(function ($query) {
                $query->where('contact_id', $this->contact->id)
                    ->whereNull('contact_request_id');
            })
            ->orWhere(function ($query) {
                $query->where('contact_id', $this->contact->id)
                    ->where('contact_request_id', $this->id);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
    }
    public function getMarketingLatestNoteLog()
    {
        return NoteLog::where('status', 'active')
            ->where(function ($query) {
                $query->where('contact_id', $this->contact->id)
                    ->whereNull('contact_request_id');
            })
            ->orWhere(function ($query) {
                $query->where('contact_id', $this->contact->id)
                    ->where('contact_request_id', $this->id);
            })
            ->orderBy('updated_at', 'desc')->first();
    }

    public static function scopeOfAContact($query, $contact)
    {
        $query->whereHas('contact_id', $contact->id);
    }

    public static function scopeOfAContactAssignedForSale($query, $contact, $saleAccount)
    {
        $query->ofAContact($contact)->where('account_id', $saleAccount->id);
    }

    public function getAllSalesRelatedToThisContact()
    {
        $contact = $this->contact;
    }

    public static function scopeHadAssignedToAccounts($query, $accounts)
    {
        $query->whereHas('account', function($q) use ($accounts) {
            $q->whereIn('id', $accounts->pluck('id'));
        });
    }

    public static function scopeBySourceTypes($query, $sourceTypes)
    {
        $query->whereIn('source_type', $sourceTypes);
    }

    public function displayPhoneNumberByUser($user)
    {
        if (!$user->can('viewPhoneNumber', Contact::class)) {
            return \App\Helpers\Functions::hidePhoneNumber($this->phone);
        } else {
            return $this->phone;
        }
    }

    public static function activeCount($cache=true)
    {
        $query = self::active();

        if ($cache) {
            return Cache::remember('contact_request_active_count', now()->addMinutes(1), function () use ($query) {
                return $query->count();
            });
        } else {
            return $query->count();
        }
    }

    public static function isAssignedCount($cache=true)
    {
        $query = self::isAssigned();

        if ($cache) {
            return Cache::remember('contact_request_isAssigned_count', now()->addMinutes(1), function () use ($query) {
                return $query->count();
            });
        } else {
            return $query->count();
        }
    }

    public static function hasActionCount($cache=true)
    {
        $query = self::hasAction();

        if ($cache) {
            return Cache::remember('contact_request_hasAction_count', now()->addMinutes(1), function () use ($query) {
                return $query->count();
            });
        } else {
            return $query->count();
        }
    }
}
