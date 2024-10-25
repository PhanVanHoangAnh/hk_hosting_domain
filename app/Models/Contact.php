<?php

namespace App\Models;

use App\Events\ConfirmRefundRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\ContactRequest;
use App\Models\Account;
use App\Models\SoftwareRequest;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Events\TransferCourse;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Log;

class Contact extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    const LEARNING = 'learning';
    const FINISHED = 'finished';
    const NOTENROLLED = 'notenrolled';

    // Added from
    const ADDED_FROM_SYSTEM = 'system';
    const ADDED_FROM_HUBSPOT = 'hubspot';
    const ADDED_FROM_EXCEL = 'excel';
    const ADDED_FROM_GOOGLE_SHEET = 'google_sheet';

    //Gender
    const FEMALE = 'female';
    const MALE = 'male';

    protected $fillable = [
        'name',
        'company_name',
        'type_of_business',
        'tax_identification_number',
        'email',
        'phone',
        'identity_id',
        'address',
        'demand',
        'country',
        'city',
        'district',
        'ward',
        'birthday',
        'age',
        'status',
    ];

    public function scopeActive($query)
    {
        $query = $query->where('contacts.status', self::STATUS_ACTIVE);
    }

    public function scopeDeleted($query)
    {
        $query = $query->where('contacts.status', self::STATUS_DELETED);
    }

    public static function scopeIsDeleted($query)
    {
        return $query->where('contacts.status', self::STATUS_DELETED);
    }

    public function scopeSearch($query, $keyword)
    {
        $query = $query->where(function ($query) use ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->whereRaw("name LIKE ?", ["%{$keyword}%"]);
            })
                ->orWhere('phone', 'LIKE', "%{$keyword}%")
                ->orWhere('code', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('school', 'LIKE', "%{$keyword}%");
        });
    }
    
    public static function scopefilterByClassRoom($query, $classRoom)
    {
        $query->whereHas('orders.orderItems.courseStudent.course', function ($q) use ($classRoom) {
            $q->whereIn('code', $classRoom);
        });
    }

    public function scopeFindByIds($query, $ids)
    {
        return $query->whereIn('id', $ids);
    }

    public static function newDefault($addedFrom=null)
    {
        $contact = new self();
        $contact->status = self::STATUS_ACTIVE;

        if (!$addedFrom) {
            $contact->added_from = self::ADDED_FROM_SYSTEM;
        }

        return $contact;
    }

    public function softwareRequests()
    {
        return $this->hasMany(SoftwareRequest::class);
    }

    public function addSoftwareRequest($attributes)
    {
        return $this->softwareRequests()->create($attributes);
    }

    public function softwareRequestNotes()
    {
        return $this->hasMany(NoteLog::class);
    }
    
    public function generateCode($force=false)
    {
        if ($this->code && !$force) {
            throw new \Exception("Contact code exists!");
        }
        
        $currentYear = $this->created_at->format('Y'); // Lấy 2 chữ số cuối của năm
        $currentMonth = $this->created_at->format('m'); // Lấy 2 chữ số của tháng
        $maxCode = self::where('code_year', $currentYear)
            ->where('code_month', $currentMonth)
            ->lockForUpdate()
            ->max('code_number');
        $codeNumber = $maxCode ? ($maxCode + 1) : 1;

        $this->code_year = $currentYear;
        $this->code_month = $currentMonth;
        $this->code_number = $codeNumber;
        $this->code = $this->getCode();

        $this->save();
    }

    public function extracurricularStudent()
    {
        return $this->hasMany(ExtracurricularStudent::class, 'student_id', 'id');
    }

    public function displayName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'id', 'student_id');
    }

    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class, 'student_id');
    }

    public function refundRequest()
    {
        return $this->hasMany(RefundRequest::class, 'student_id');
    }

    public function reserve()
    {
        return $this->hasMany(Reserve::class, 'student_id');
    }

    public function studentSections()
    {
        return $this->hasMany(StudentSection::class, 'student_id');
    }

    public function freeTimes()
    {
        return $this->hasMany(FreeTime::class);
    }

    public static function scopeFilterBySubjectName($query, $subjectName)
    {
        if (is_array($subjectName) && in_array('all', $subjectName)) {
            return $query;
        } else {
            $query = $query->whereHas('orders.orderItems.subject', function ($q) use ($subjectName) {
                $q->where('name', $subjectName);
            });

            return $query;
        }
    }

    public static function scopeFilterByHomeRoom($query, $homeRoom)
    {
        if (is_array($homeRoom) && in_array('all', $homeRoom)) {
            return $query;
        } else {
            $query = $query->whereHas('courseStudents', function ($q) use ($homeRoom) {
                $q->whereHas('orderItems', function ($innerQuery) use ($homeRoom) {
                    $innerQuery->whereIn('home_room', $homeRoom);
                });
            });

            return $query;
        }
    }

    public static function scopeFilterByStudent($query, $student)
    {
        if (is_array($student) && in_array('all', $student)) {
            return $query;
        } else {
            return $query->whereIn('name', (array) $student);
        }
    }

    public static function scopeFilterByMarketingType($query, $marketingType)
    {
        if (is_array($marketingType) && in_array('all', $marketingType)) {
            return $query;
        } else {
            return $query->whereIn('source_type', (array) $marketingType);
        }
    }

    public static function scopeFilterByMarketingSource($query, $marketingSource)
    {
        if (is_array($marketingSource) && in_array('all', $marketingSource)) {
            return $query;
        } else {
            return $query->whereIn('channel', (array) $marketingSource);
        }
    }

    public static function scopeFilterByMarketingSourceSub($query, $marketingSourceSub)
    {
        if (is_array($marketingSourceSub) && in_array('all', $marketingSourceSub)) {
            return $query;
        } else {
            return $query->whereIn('sub_channel', (array) $marketingSourceSub);
        }
    }

    public static function scopeFilterByLifecycleStage($query, $lifecycleStage)
    {
        if (is_array($lifecycleStage) && in_array('all', $lifecycleStage)) {
            return $query;
        } else {
            return $query->whereIn('lifecycle_stage', (array) $lifecycleStage);
        }
    }

    public static function scopeFilterByLeadStatus($query, $leadStatus)
    {
        if (is_array($leadStatus) && in_array('all', $leadStatus)) {
            return $query;
        } else {
            return $query->whereIn('lead_status', (array) $leadStatus);
        }
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('contacts.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('contacts.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
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
                $q->whereIn('account_id', $ids);
            }

            if (in_array('none', $salesPersonIds)) {
                $q->orWhereNull('account_id');
            }
        });
    }

    public function fillAttributes($params)
    {
        $this->fill($params);
        
        if (!is_null($this->email)) {
            $this->email = trim(strtolower($this->email)); // format email before save
        }
        
        if (!is_null($this->phone)) {
            $this->phone = \App\Library\Tool::extractPhoneNumber(trim(strtolower($this->phone))); // format phone before save
        }

        if (!is_null($this->deman)) {
            $this->demand = trim($this->demand);
        }
        
        try {
            $this->birthday = $params['birthday'] ? $params['birthday'] : null;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        if (isset($params['import_id'])) {
            $this->import_id =  $params['import_id'];
        }
    }

    public function saveFromRequest($request)
    {
        $this->fillAttributes($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email|unique:contacts,email,' . $this->id,
            'phone' => 'nullable|numeric|min:10|unique:contacts,phone,' . $this->id,
            'country' => 'nullable',
            'source_type' => 'nullable',
            'channel' => 'nullable',
            'sub_channel' => 'nullable',
            'lead_status' => 'nullable',
            'lifecycle_stage' => 'nullable'
        ]);

        // failed
        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->gender = $request->gender;
        $this->school = $request->school;
        $this->save();
        // save contact
        $this->save();

        if (is_null($this->code)) {
            $this->generateCode();
        }

        // save father
        if ($request->father_id) {
            $this->updateFather(self::find($request->father_id));

            // remove father if mother_id is not present
        } else {
            $this->removeFather();
        }

        // save mother
        if ($request->mother_id) {
            $this->updateMother(self::find($request->mother_id));

            // remove mother if mother_id is not present
        } else {
            $this->removeMother();
        }

        return $validator->errors();
    }

    public function saveAndAddContactRequestFromRequest($request)
    {
        $this->fillAttributes($request->all());
        $contactRequest = $this->newContactRequest();
        $contactRequest->fillAttributes($request->all());
        $contactRequest->fillInformationsFromContact($this);

        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',
            'demand' => 'required',
            'source_type' => 'required',
        ]);

        $phone = $this->phone;
        
        if ($phone && $request->sub_channel) {
            $validator->after(function($validator) use ($request, $phone, $contactRequest) {
                $overlapContactRequests = ContactRequest::query()
                    ->relatedContactsByPhoneAndDemandAndSubChannel($phone, $request->demand, $request->sub_channel)
                    ->where('id', '!=', $contactRequest->id)->get();
                if ($overlapContactRequests->count()) {
                    $validator->errors()->add("overlap_contact_requests", "Liên hệ này đã có đơn hàng với nhu cầu và sub channel tương tự trước đây!");
                }
            });
        }

        if ($validator->fails()) {
            return [$contactRequest, $validator->errors()];
        }

        // add request
        $contactRequest = $this->addContactRequest($request->all());

        return [$contactRequest, $validator->errors()];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function father()
    {
        return $this->belongsTo(Contact::class, 'father_id', 'id');
    }

    public function mother()
    {
        return $this->belongsTo(Contact::class, 'mother_id', 'id');
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

        $contacts = [];

        foreach ($data as $row) {
            $contact = new Contact();
            $contact->name = $row[0];
            $contact->phone = \App\Library\Tool::extractPhoneNumber($row[1]);
            $contact->email = $row[2];
            $contact->demand = $row[3];
            $contact->school = $row[4];
            $contact->birthday = date('Y-m-d', strtotime($row[5]));
            $contact->time_to_call = $row[6];
            $contact->country = $row[7];
            $contact->city = $row[8];
            $contact->district = $row[9];
            $contact->ward = $row[10];
            $contact->address = $row[11];
            $contact->efc = $row[12];
            $contact->target = $row[13];
            $contact->list = $row[14];
            $contact->date = $row[15];
            $contact->source_type = $row[16];
            $contact->channel = $row[17];
            $contact->sub_channel = $row[18];
            $contact->campaign = $row[19];
            $contact->adset = $row[20];
            $contact->ads = $row[21];
            $contact->device = $row[22];
            $contact->placement = $row[23];
            $contact->term = $row[24];
            $contact->type_match = $row[25];
            $contact->fbclid = $row[26];
            $contact->gclid = $row[27];
            $contact->first_url = $row[28];
            $contact->last_url = $row[29];
            $contact->contact_owner = $row[30];
            $contact->lifecycle_stage = $row[31];
            $contact->lead_status = $row[32];
            $contact->note_sales = $row[33];
            $contact->account_id = null; // Default is null
            $contact->status = Contact::STATUS_ACTIVE;
            $contacts[] = $contact;
        }

        return $contacts;
    }
    public static function importFromExcelFile($filePath, $progress, $done)
    {
        // echo "reading file...\n";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $excelDatas = [];
        $batchSize = 73; // Số hàng mỗi batch
        $rowCount = 0;

        $total = ($worksheet->getHighestRow());
        $success = 0;
        $failed = 0;

        // logs
        $logs = [
            'description' => [],
            'dataLogs' => [],
            'status' => [],
            'accountLogs' => [],
        ];

    
        // Lặp qua từng hàng
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }

            // try {
                $date = !isset($rowData[15]) ? '' : (!empty($rowData[15]) && strtotime($rowData[15]) !== false ?
                    Carbon::createFromFormat('m/d/Y', $rowData[15])
                    : null);
            // } catch (\Throwable $e) {
            //     $this->logError("Can not format FormSubmitDate: " . json_encode($row));
            //     $google_form_submit_date = null;
            // }

            // Xử lý dữ liệu từng hàng
            $obj = [
                'name' => trim($rowData[0] != null ? Functions::processVarchar250Input($rowData[0]) : ''),
                'phone' => $rowData[1] == null ? null : trim(\App\Library\Tool::extractPhoneNumber($rowData[1])),
                'email' => Functions::processVarchar250Input(trim($rowData[2] ?? '')),
                'demand' => Functions::processVarchar250Input(trim($rowData[3]?? '')),
                'school' => trim($rowData[4] != null ? Functions::processVarchar250Input($rowData[4]) : ''),
                'birthday' => !empty($rowData[5]) && strtotime($rowData[5]) !== false ? Carbon::parse($rowData[5])->format('d/m/Y') : null,
                'address' => Functions::processVarchar250Input($rowData[11]),
                'ward' => Functions::processVarchar250Input($rowData[10]),
                'district' => Functions::processVarchar250Input($rowData[9]),
                'city' => Functions::processVarchar250Input($rowData[8]),
                'country' => Functions::processVarchar250Input($rowData[7]),
                'time_to_call' => Functions::processVarchar250Input($rowData[6]),
                'efc' => Functions::processVarchar250Input($rowData[12]),
                'target' => Functions::processVarchar250Input($rowData[13]),
                'list' => Functions::processVarchar250Input($rowData[14]),
                'date' => Functions::processVarchar250Input($rowData[15]),
                'source_type' => Functions::processVarchar250Input($rowData[16]),
                'channel' => Functions::processVarchar250Input($rowData[17]),
                'sub_channel' => Functions::processVarchar250Input($rowData[18]),
                'campaign' => Functions::processVarchar250Input($rowData[19]),
                'adset' => Functions::processVarchar250Input($rowData[20]),
                'ads' => Functions::processVarchar250Input($rowData[21]),
                'device' => Functions::processVarchar250Input($rowData[22]),
                'placement' => Functions::processVarchar250Input($rowData[23]),
                'term' => Functions::processVarchar250Input($rowData[24]),
                'type_match' => Functions::processVarchar250Input($rowData[25]),
                'fbclid' => Functions::processVarchar250Input($rowData[26]),
                'gclid' => Functions::processVarchar250Input($rowData[27]),
                'first_url' => $rowData[28],
                'last_url' => $rowData[29],
                'contact_owner' => Functions::processVarchar250Input($rowData[30]),
                'lifecycle_stage' => Functions::processVarchar250Input($rowData[31]),
                'lead_status' => Functions::processVarchar250Input($rowData[32]),
                'note_sales' => Functions::processVarchar250Input($rowData[33]),
                'selectedValue' => 'save',
                'latest_activity_date' => $date,
            ];
            
            $excelDatas[] = $obj;
            $rowCount++;

            // Nếu đạt đến kích thước batch hoặc hết dữ liệu, xử lý batch và giải phóng bộ nhớ
            if ($rowCount % $batchSize == 0 || $rowCount >= $total) {
                $accountId=null;
                $page=1;
                $totalPage=1;

                // echo "Import " . count($excelDatas) . "/" .$total. "\n";
                $result = self::saveExcelDatasFromFile( $excelDatas, $accountId, $page, $totalPage);
                $excelDatas = []; // Giải phóng bộ nhớ
                
                $success += (int) ($result['totalRowsSuccess']);
                $failed += (int) $result['totalRowsFailure'];

                // add logs
                $logs['description'] = array_merge($logs['description'], $result['logs']['description']);
                $logs['dataLogs'] = array_merge($logs['dataLogs'], $result['logs']['dataLogs']);
                $logs['status'] = array_merge($logs['status'], $result['logs']['status']);
                $logs['accountLogs'] = array_merge($logs['accountLogs'], $result['logs']['accountLogs']);

                // callback processing
                $progress($total, $rowCount, $success, $failed);
            }
        }

        // callback done
        $done($total, $rowCount, $success, $failed);

        // write logs
        self::exportLogsImport($logs['description'], $logs['dataLogs'], $logs['status'], $logs['accountLogs']);

        // Trả về một mảng rỗng do không có dữ liệu trả về từ hàm này
        return [];
    }
    

    public static function saveExcelDatasFromFile($excelDatas, $accountId, $page=1, $totalPage=1)
    {
        $logFileName = 'contact_logs.txt';
        $totalRowsProcessed = 0;
        $totalRowsSuccess = 0;
        $totalRowsFailure = 0;
        $totalRowsDuplicate = 0;

        // logging
        if ($page == 1) {
            // Serialize the array data
            $data = serialize([
                'description' => [],
                'dataLogs' => [],
                'status' => [],
                'accountLogs' => [],
            ]);

            // Write serialized data to a file
            Storage::disk('logs')->put($logFileName, $data);
        }

        $logContent = '';
        $description = [];
        $dataLogs = [];
        $status = [];
        $accountLogs = [];
        $addedRows = [];
        
       
        foreach ($excelDatas as $data) {
            // Default save status is ERROR
            $saveStatus = 'ERROR';
            $contact = null;

            if (!$data['phone']) {
                continue;
            }
    
            try {
                $UpdateContact = self::relatedContactsByPhone($data['phone'])->first();
              
                if ($UpdateContact) {
                    $UpdateContact->fillAttributes($data);

                    $UpdateContact->save();
                   
                    try {
                        $saveStatus = 'SUCCESS';
                        $totalRowsDuplicate++;
                        $totalRowsSuccess++;

                        $relatedContacts = ContactRequest::relatedContactsByPhoneAndDemand($UpdateContact->phone, $UpdateContact->demand);
                    
                        if(!($relatedContacts->exists())){
                              // create contact request
                            // $account_id = Account::where('name', trim($data['contact_owner']))->first()?->id ?? null;
                            $account_id = null;
                            if (isset($data['contact_owner'])) {
                                $trimmedContactOwner = trim($data['contact_owner']);
                                $account = Account::where('name', $trimmedContactOwner)->first();
                                $account_id = $account ? $account->id : null;
                            }
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'contact_id' => $UpdateContact->id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales'],
                                'added_from' => self::ADDED_FROM_EXCEL,
                            ], $data);
                            $contactRequest = $UpdateContact->addContactRequest($crData);
                            // generate order code
                            $contactRequest->generateCode();

                            // dates
                            if ($data['latest_activity_date']) {
                                $contactRequest->created_at = $data['latest_activity_date'];
                                $contactRequest->updated_at = $data['latest_activity_date'];
                                $contactRequest->save();
                            }

                            $logContent .= "Description: Không trùng | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $description[] = "Description: Không trùng 2 | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $status[] = "Thành công 2";
                        }else{
                            $contactOwner = $data['contact_owner'] ?? '';
                            $account_id = Account::where('name', trim($contactOwner))->first()?->id ?? null;
                            
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales']
                            ], $data);
                            $contactRequest = $relatedContacts->first();
                            $contactRequest->fill(array_filter($crData));
                            $sourceTypeImport = config('sourceTypeImport');
                            $channelMapping = [];

                            foreach ($sourceTypeImport as $sourceType => $channels) {
                                
                                foreach ($channels as $channel => $subChannels) {
                                
                                    foreach ($subChannels as $subChannel => $channelMappinggs) {
                                        foreach ($channelMappinggs as $channelMappingg){
                                            $channelMapping[$channelMappingg] = [
                                                'channel' => $subChannel,
                                                'source_type' => $channel
                                            ];
                                        }
                                        
                                    }
                                }
                            }
                        
                            // Kiểm tra nếu sub_channel tồn tại và có ánh xạ trong mảng
                            if (!is_null($contactRequest->sub_channel) && isset($channelMapping[trim($contactRequest->sub_channel)])){
                                
                                $mapping = $channelMapping[trim($contactRequest->sub_channel)];
                            
                                $contactRequest->channel = $mapping['channel'];
                                $contactRequest->source_type = $mapping['source_type'];
                            }
                            $contactRequest->generateCode();
                            $contactRequest->save();

                            // dates
                            if ($data['latest_activity_date']) {
                                $contactRequest->updated_at = $data['latest_activity_date'];
                                $contactRequest->latest_activity_date = $data['latest_activity_date'];
                                $contactRequest->save();
                            }

                            $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                            $status[] = "Cập nhật thành công đơn hàng đã tồn tại trước đó 1";
                            $logContent .= "Description: cập nhật thành công đơn hàng của {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                         }

                        
                    } catch (\Exception $e) {
                        $totalRowsFailure++;
                        $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> {$UpdateContact->demand} Cập nhật thông tin từ theo người dùng thất bại". $e->getMessage();
                        $status[] = "Thất bại 1";
                        $logContent .= "Description: Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thất bại. Error: " . $e->getMessage();
                    }
                }else if (isset($data['phone'])) {
                    $isDuplicate = in_array($data, $addedRows);
              
                  
                    if (!$isDuplicate) {
                        $contact = new Contact();
                        $contact->status = Contact::STATUS_ACTIVE;
                        $contact->fillAttributes($data);

                        // $contact->pic = $data['pic'];
                        if (($accountId)) {
                            $contact->account_id = $accountId;
                        } else {
                            $accountId= null;
                        }

                        try {
                            $contact->save();
                            $contact->generateCode();

                            $saveStatus = 'SUCCESS';
                            $totalRowsProcessed++;

                            $totalRowsSuccess++;
                            // create contact request
                            $account_id = Account::where('name', $data['contact_owner'])->first()?->id ?? null;
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'contact_id' => $contact->id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales'],
                                'added_from' => self::ADDED_FROM_EXCEL,
                            ], $data);
                            $contactRequest = $contact->addContactRequest($crData);

                            // dates
                            if ($data['latest_activity_date']) {
                                $contactRequest->created_at = $data['latest_activity_date'];
                                $contactRequest->updated_at = $data['latest_activity_date'];
                                $contactRequest->save();
                            }

                            $logContent .= "Description: Không trùng | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $description[] = "Description: Không trùng 4| Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $status[] = "Thành công 3";

                           
                        } catch (\Exception $e) {
                            $totalRowsFailure++;
                            $description[] = "Lỗi định dạng: " . self::errorMessage($e->getMessage());
                            $status[] = "Thất bại 4". $e->getMessage();
                            $logContent .= "Description: Không trùng | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thất bại. Error: " . $e->getMessage();
                        }
                    } else {
                        $totalRowsFailure++;
                        $description[] = $logContent .= "Description: Data đã tồn tại trong mảng addedRows : [{$data['email']}][{$data['phone']}] Không xử lý gì ỡ đây";
                        $status[] = "Thất bại 5";
                        $logContent .= "Description: Data đã tồn tại trong mảng addedRows : [{$data['email']}][{$data['phone']}] Không xử lý gì ỡ đây";
                    }
                } else {
                    $logContent .= "Trường hợp không tồn tại name trong data";
                    $description[] = "Trường hợp không tồn tại name trong data";
                    $status[] = "Thất bại 6";
                    $totalRowsFailure++;
                }

            } catch (\Throwable $e) {
                $logContent .= "Lỗi không xác định.";
                $description[] = "Error: " . $e->getMessage();
                $status[] = "Thất bại 7";
                $totalRowsFailure++;
            }
            

            $dataLogs[] = $data;
            $addedRows[] = $data;
            $logContent .= "Time: " . now() . "\n";
            $logContent .= "Log Level: Info\n";
            $logContent .= "Save Status: $saveStatus\n";

            if ($contact !== null) {
                $logContent .= "Saved contact: '{$contact->name}', email: '{$contact->email}', ID: '{$contact->id}'\n";
            }
            $logContent .= "Request IP: " . request()->ip() . "\n";
            $logContent .= "HTTP Method: " . request()->method() . "\n";
            $logContent .= "URL: " . request()->fullUrl() . "\n";
            $logContent .= "Headers: " . json_encode(request()->header()) . "\n";
            $logContent .= "User: " . (auth()->user() ? auth()->user()->name : 'N/A') . "\n";
            $accountLogs[] = (auth()->user() ? auth()->user()->name : 'N/A');
            $logContent .= "Processing Time: " . (microtime(true) - LARAVEL_START) . " seconds\n";
            $logContent .= "\n ------------------------------ \n";
        }

        // Append log
        $logs = Storage::disk('logs')->get($logFileName);
        // Unserialize the data to get back the original array
        $logs = unserialize($logs);
        $logs = [
            'description' => array_merge($logs['description'], $description),
            'dataLogs' => array_merge($logs['dataLogs'], $dataLogs),
            'status' => array_merge($logs['status'], $status),
            'accountLogs' => array_merge($logs['accountLogs'], $accountLogs),
        ];
        $data = serialize($logs);
        // Write serialized data to a file
        Storage::disk('logs')->put($logFileName, $data);

        // convert to excel
        // self::exportLogsImport($logs['description'], $logs['dataLogs'], $logs['status'], $logs['accountLogs']);

        return [
            'totalRowsProcessed' => $totalRowsProcessed,
            'totalRowsSuccess' => $totalRowsSuccess,
            'totalRowsFailure' => $totalRowsFailure,
            'totalRowsDuplicate' => $totalRowsDuplicate,

            'logs' => [
                'description' => $logs['description'],
                'dataLogs' => $logs['dataLogs'],
                'status' => $logs['status'],
                'accountLogs' => $logs['accountLogs'],
            ]
        ];
    }








    public static function scopeSaveExcelDatas($request, $excelDatas, $accountId, $type, $page=1, $totalPage=1)
    {
      
        $logFileName = 'contact_logs.txt';
        $totalRowsProcessed = 0;
        $totalRowsSuccess = 0;
        $totalRowsFailure = 0;
        $totalRowsDuplicate = 0;

        // logging
        if ($page == 1) {
            // Serialize the array data
            $data = serialize([
                'description' => [],
                'dataLogs' => [],
                'status' => [],
                'accountLogs' => [],
            ]);

            // Write serialized data to a file
            Storage::disk('logs')->put($logFileName, $data);
        }

        $logContent = '';
        $description = [];
        $dataLogs = [];
        $status = [];
        $accountLogs = [];
        $addedRows = [];
        

        foreach ($excelDatas as $data) {
            // Default save status is ERROR
            $saveStatus = 'ERROR';
            $contact = null;
            
            if (isset($data['selectedValue']) && ($data['selectedValue'] == 'all' || $data['selectedValue'] == 'isCoincide')) {
                // Check if email or phone exists in the data
                // if (isset($data['email']) || isset($data['phone'])) {
                // Find contact by email or phone
             
                $UpdateContact = self::findRelatedContacts2([
                    // 'email' => $data['email'],
                    'phone' => $data['phone'],
                ])->first();
                
                if ($UpdateContact && ($type == 'saveAllData')) {
                   
                    $UpdateContact->fillAttributes($data);
                    $UpdateContact->account_id = $accountId ? $accountId : null;
                   
                    $UpdateContact->save();

                    try {
                        $saveStatus = 'SUCCESS';
                        $totalRowsDuplicate++;
                        $totalRowsSuccess++;

                        $relatedContacts = ContactRequest::findRelatedContactRequest([
                            'phone' =>  $UpdateContact->phone,
                            'demand' => $UpdateContact->demand,
                            
                        ]);
                    
                        if(!($relatedContacts->exists())){
                            // create contact request
                            $account_id = Account::where('name', trim($data['contact_owner']))->first()?->id ?? null;
                            
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'contact_id' => $UpdateContact->id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales'],
                                'added_from' => self::ADDED_FROM_EXCEL,
                            ], $data);
                            $contactRequest = $UpdateContact->addContactRequest($crData);
                            // generate order code
                            $contactRequest->generateCode();
                            $logContent .= "Description: Không trùng | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $description[] = "Description: Không trùng 2 | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $status[] = "Thành công 2";
                        }else{
                            $account_id = Account::where('name', trim($data['contact_owner']))->first()?->id ?? null;
                            
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales']
                            ], $data);
                            $contactRequest = $relatedContacts->first();
                            $contactRequest->fill(array_filter($crData));
                            $sourceTypeImport = config('sourceTypeImport');
      
                            $channelMapping = [];

                            foreach ($sourceTypeImport as $sourceType => $channels) {
                                
                                foreach ($channels as $channel => $subChannels) {
                                
                                    foreach ($subChannels as $subChannel => $channelMappinggs) {
                                        foreach ($channelMappinggs as $channelMappingg){
                                            $channelMapping[$channelMappingg] = [
                                                'channel' => $subChannel,
                                                'source_type' => $channel
                                            ];
                                        }
                                        
                                    }
                                }
                            }
                        
                            // Kiểm tra nếu sub_channel tồn tại và có ánh xạ trong mảng
                            if (!is_null($contactRequest->sub_channel) && isset($channelMapping[trim($contactRequest->sub_channel)])){
                                
                                $mapping = $channelMapping[trim($contactRequest->sub_channel)];
                            
                                $contactRequest->channel = $mapping['channel'];
                                $contactRequest->source_type = $mapping['source_type'];
                            }
                            $contactRequest->generateCode();
                            $contactRequest->save();
                            $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                            $status[] = "Cập nhật thành công đơn hàng đã tồn tại trước đó";
                            $logContent .= "Description: cập nhật thành công đơn hàng của {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                        }
                        
                       


                        
                    } catch (\Exception $e) {
                        $totalRowsFailure++;
                        $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> {$UpdateContact->demand} Cập nhật thông tin từ theo người dùng thất bại". $e->getMessage();
                        $status[] = "Thất bại 1";
                        $logContent .= "Description: Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thất bại. Error: " . $e->getMessage();
                    }
                } else  if ($UpdateContact && ($type == 'updateData')) {
                    $UpdateContact->fillAttributes($data);
                    $UpdateContact->account_id = $accountId ? $accountId : null;
                   
                    $UpdateContact->save();
                   
                    try {
                        $saveStatus = 'SUCCESS';
                        $totalRowsDuplicate++;
                        $totalRowsSuccess++;

                        $relatedContacts = ContactRequest::findRelatedContactRequest([
                            'phone' =>  $UpdateContact->phone,
                            'demand' => $UpdateContact->demand,
                            
                        ]);
                    
                        if(!($relatedContacts->exists())){
                            $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                            $status[] = "Không tạo mới";
                            $logContent .= "Description: Chỉ cập nhật không tạo mới.";
                        }else{
                            $account_id = Account::where('name', trim($data['contact_owner']))->first()?->id ?? null;
                            
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales']
                            ], $data);
                            $contactRequest = $relatedContacts->first();
                            $contactRequest->fill(array_filter($crData));
                            $sourceTypeImport = config('sourceTypeImport');
      
                            $channelMapping = [];

                            foreach ($sourceTypeImport as $sourceType => $channels) {
                                
                                foreach ($channels as $channel => $subChannels) {
                                
                                    foreach ($subChannels as $subChannel => $channelMappinggs) {
                                        foreach ($channelMappinggs as $channelMappingg){
                                            $channelMapping[$channelMappingg] = [
                                                'channel' => $subChannel,
                                                'source_type' => $channel
                                            ];
                                        }
                                        
                                    }
                                }
                            }
                        
                            // Kiểm tra nếu sub_channel tồn tại và có ánh xạ trong mảng
                            if (!is_null($contactRequest->sub_channel) && isset($channelMapping[trim($contactRequest->sub_channel)])){
                                
                                $mapping = $channelMapping[trim($contactRequest->sub_channel)];
                            
                                $contactRequest->channel = $mapping['channel'];
                                $contactRequest->source_type = $mapping['source_type'];
                            }
                            if(!is_null($contactRequest->account_id)){
                                $noteSale = NoteLog::find('contact_request_id', $contactRequest->id);
                                $noteSale->account_id = $contactRequest->account_id;
                                $noteSale->save();
                                // self::UpdateNoteSale($contactRequest->contact_id,$contactRequest->id,$contactRequest->note_sale, $contactRequest->account_id);
                            }
                            $contactRequest->generateCode();
                            $contactRequest->save();
                            $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                            $status[] = "Cập nhật thành công đơn hàng đã tồn tại trước đó";
                            $logContent .= "Description: cập nhật thành công đơn hàng của {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                        }

                        
                    } catch (\Exception $e) {
                        $totalRowsFailure++;
                        $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> {$UpdateContact->demand} Cập nhật thông tin từ theo người dùng thất bại". $e->getMessage();
                        $status[] = "Thất bại 1";
                        $logContent .= "Description: Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thất bại. Error: " . $e->getMessage();
                    }
                }
                else if($UpdateContact && ($type == 'saveAllData' || $type == 'justCreateNew')){
                    try {
                        $saveStatus = 'SUCCESS';
                        $totalRowsDuplicate++;
                        $totalRowsSuccess++;

                        $relatedContacts = ContactRequest::findRelatedContactRequest([
                            'phone' =>  $UpdateContact->phone,
                            'demand' => $UpdateContact->demand
                            
                        ]);
                    if(!($relatedContacts->exists())){
                        // create contact request
                        $account_id = Account::where('name', trim($data['contact_owner']))->first()?->id ?? null;
                        $crData = array_merge([
                            'account_id' => $account_id,
                            'contact_id' => $UpdateContact->id,
                            'status' => ContactRequest::STATUS_ACTIVE,
                            'note_sale'=> $data['note_sales'],
                            'added_from' => self::ADDED_FROM_EXCEL,
                        ], $data);
                        $contactRequest = $UpdateContact->addContactRequest($crData);

                        // generate order code
                        $contactRequest->generateCode();
                      
                    }
                       
                    $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";
                    $status[] = "Thành công 00";
                    $logContent .= "Description: Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thành công.";


                        
                    } catch (\Exception $e) {
                        $totalRowsFailure++;
                        $description[] = "Liên hệ trùng với {$UpdateContact->name} ==> {$UpdateContact->demand} Cập nhật thông tin từ theo người dùng thất bại". $e->getMessage();
                        $status[] = "Thất bại 1";
                        $logContent .= "Description: Liên hệ trùng với {$UpdateContact->name} ==> Cập nhật thông tin từ theo người dùng thất bại. Error: " . $e->getMessage();
                    }
                    // $totalRowsFailure++; // Missing email or phone to identify contact
                    // $description[] = "Không tìm thấy liên hệ [{$data['email']}][{$data['phone']}].Lỗi dữ liệu server";
                    // $status[] = "Thất bại 2";
                    // $logContent .= "Description: Không tìm thấy liên hệ [{$data['email']}][{$data['phone']}]. Sao bước trước lại thấy trùng.";
                }
                // }
            } else if (isset($data['selectedValue']) && $data['selectedValue'] == 'isCoincide') {
                
                $totalRowsFailure++;
                $description[] = "Trùng đơn hàng đã có trước đó.";
                $status[] = "Thất bại 3";
                $logContent .= "Trùng đơn hàng đã có trước đó: [{$data['email']}][{$data['phone']}]. Lưu thất bại. Error: ";
                
            } else if (isset($data['name']) && !empty($data['name']) && ($type == 'saveAllData' || $type == 'justCreateNew')) {
                    $isDuplicate = in_array($data, $addedRows);
              
                  
                    if (!$isDuplicate) {
                        $contact = new Contact();
                        $contact->status = Contact::STATUS_ACTIVE;
                        $contact->fillAttributes($data);

                        // $contact->pic = $data['pic'];
                        if (($accountId)) {
                            $contact->account_id = $accountId;
                        } else {
                            $accountId= null;
                        }

                        try {
                            $contact->save();
                            $contact->generateCode();
                            $saveStatus = 'SUCCESS';
                            $totalRowsProcessed++;

                            $totalRowsSuccess++;
                            // create contact request
                            $account_id = Account::where('name', $data['contact_owner'])->first()?->id ?? null;
                            $crData = array_merge([
                                'account_id' => $account_id,
                                'contact_id' => $contact->id,
                                'status' => ContactRequest::STATUS_ACTIVE,
                                'note_sale'=> $data['note_sales'],
                                'added_from' => self::ADDED_FROM_EXCEL,
                            ], $data);
                            $contactRequest = $contact->addContactRequest($crData);

                            $logContent .= "Description: Không trùng | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $description[] = "Description: Không trùng 4| Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thành công.";
                            $status[] = "Thành công 2";

                           
                        } catch (\Exception $e) {
                            $totalRowsFailure++;
                            $description[] = "Lỗi định dạng: " . self::errorMessage($e->getMessage());
                            $status[] = "Thất bại 4". $e->getMessage();
                            $logContent .= "Description: Không trùng | Người dùng chọn là liên hệ khác: [{$data['email']}][{$data['phone']}]. Lưu thất bại. Error: " . $e->getMessage();
                        }
                    } else {

                        $description[] = $logContent .= "Description: Data đã tồn tại trong mảng addedRows : [{$data['email']}][{$data['phone']}] Không xử lý gì ỡ đây";
                        $status[] = "Thất bại 5";
                        $logContent .= "Description: Data đã tồn tại trong mảng addedRows : [{$data['email']}][{$data['phone']}] Không xử lý gì ỡ đây";
                    }
                } else {
                    $logContent .= "Trường hợp không tồn tại name trong data";
                    $description[] = ["Trường hợp không tồn tại name trong data"];
                    $status[] = "Thất bại 6";
                    $totalRowsFailure++;
                }
            

            $dataLogs[] = $data;
            $addedRows[] = $data;
            $logContent .= "Time: " . now() . "\n";
            $logContent .= "Log Level: Info\n";
            $logContent .= "Save Status: $saveStatus\n";

            if ($contact !== null) {
                $logContent .= "Saved contact: '{$contact->name}', email: '{$contact->email}', ID: '{$contact->id}'\n";
            }
            $logContent .= "Request IP: " . request()->ip() . "\n";
            $logContent .= "HTTP Method: " . request()->method() . "\n";
            $logContent .= "URL: " . request()->fullUrl() . "\n";
            $logContent .= "Headers: " . json_encode(request()->header()) . "\n";
            $logContent .= "User: " . (auth()->user() ? auth()->user()->name : 'N/A') . "\n";
            $accountLogs[] = (auth()->user() ? auth()->user()->name : 'N/A');
            $logContent .= "Processing Time: " . (microtime(true) - LARAVEL_START) . " seconds\n";
            $logContent .= "\n ------------------------------ \n";
        }
      
       
        $result = [
            'totalRowsProcessed' => $totalRowsProcessed,
            'totalRowsSuccess' => $totalRowsSuccess,
            'totalRowsFailure' => $totalRowsFailure,
            'totalRowsDuplicate' => $totalRowsDuplicate,
        ];

        // Append log
        $logs = Storage::disk('logs')->get($logFileName);
        // Unserialize the data to get back the original array
        $logs = unserialize($logs);
        $logs = [
            'description' => array_merge($logs['description'], $description),
            'dataLogs' => array_merge($logs['dataLogs'], $dataLogs),
            'status' => array_merge($logs['status'], $status),
            'accountLogs' => array_merge($logs['accountLogs'], $accountLogs),
        ];
        $data = serialize($logs);
        // Write serialized data to a file
        Storage::disk('logs')->put($logFileName, $data);

        // convert to excel
        self::exportLogsImport($logs['description'], $logs['dataLogs'], $logs['status'], $logs['accountLogs']);
       
        return $result;
    }

    public static function errorMessage($errorMessage)
    {
        $errorMessageMain = '';
        // Tìm vị trí của "Incorrect date value:" trong chuỗi
        $posIncorrectDate = strpos($errorMessage, 'Incorrect date value:');
        if ($posIncorrectDate !== false) {
            // Trích xuất phần sau "Incorrect date value:"
            $errorSubstring = substr($errorMessage, $posIncorrectDate + strlen('Incorrect date value:'));

            // Tìm vị trí của dấu nháy đơn ' trong chuỗi còn lại
            $posSingleQuote = strpos($errorSubstring, "'");
            if ($posSingleQuote !== false) {
                // Trích xuất phần giữa hai dấu nháy đơn
                $errorMessageMain = substr($errorSubstring, $posSingleQuote + 1);
                $posEndQuote = strpos($errorMessageMain, "'");
                if ($posEndQuote !== false) {
                    $errorMessageMain = substr($errorMessageMain, 0, $posEndQuote);
                }
            }
        }

        return $errorMessageMain;
    }

    public static function exportLogsImport($description, $dataLogs, $status,  $accountLogs)
    {
        $templatePath = public_path('templates/logs-import.xlsx');
        $templateSpreadsheet = IOFactory::load($templatePath);
        $filteredLogs = $description;

        self::exportLogsImportToExcel($templateSpreadsheet, $filteredLogs, $dataLogs, $status, $accountLogs);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'logs-import.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public static function exportLogsImportToExcel($templatePath,  $filteredLogs, $dataLogs, $status, $accountLogs)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filteredLogs as $key =>  $contact) {
            // Date formatting
            
            $rowData = [
                $status[$key],
                $contact,
                $accountLogs[$key],
                $dataLogs[$key]['name'],
                $dataLogs[$key]['phone'],
                $dataLogs[$key]['email'],
                $dataLogs[$key]['demand'],
                $dataLogs[$key]['school'],
                // $dataLogs[$key]['birthday'],
                $dataLogs[$key]['time_to_call'],
                $dataLogs[$key]['country'],
                $dataLogs[$key]['city'],
                $dataLogs[$key]['district'],
                $dataLogs[$key]['ward'],
                $dataLogs[$key]['address'],
                $dataLogs[$key]['efc'],
                $dataLogs[$key]['target'],
                $dataLogs[$key]['list'],
                $dataLogs[$key]['date'],
                $dataLogs[$key]['source_type'],
                $dataLogs[$key]['channel'],
                $dataLogs[$key]['sub_channel'],
                $dataLogs[$key]['campaign'],
                $dataLogs[$key]['adset'],
                $dataLogs[$key]['ads'],
                $dataLogs[$key]['device'],
                $dataLogs[$key]['placement'],
                $dataLogs[$key]['term'],
                $dataLogs[$key]['type_match'],
                $dataLogs[$key]['fbclid'],
                $dataLogs[$key]['gclid'],
                $dataLogs[$key]['first_url'],
                $dataLogs[$key]['last_url'],
                $dataLogs[$key]['contact_owner'],
                $dataLogs[$key]['lifecycle_stage'],
                $dataLogs[$key]['lead_status'],
                $dataLogs[$key]['note_sales'],
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }

        foreach ($filteredLogs as $key => $FilteredLog) {
            break;
            // Kiểm tra nếu phần tử hiện tại là một mảng thông tin người dùng
            // Tạo một mảng mới để lưu trữ thông tin người dùng từ $FilteredLog
            $rowData = [
                $FilteredLog,
                'pppp' // Mô tả
            ];

            // Thêm mảng $rowData vào mảng cuối cùng $rowDataArray
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public static function scopeIsAssigned($query)
    {
        $query = $query->active()->whereNotNull('account_id');
    }

    public static function scopeNoActionYet($query)
    {
        $query = $query->isAssigned()->whereNull('lead_status');
    }

    public static function scopeHasAction($query)
    {
        $query = $query->isAssigned()
            ->whereNotNull('lead_status')
            ->whereHas('noteLogs', function ($q) {
                $q->whereNotNull('id');
            });
    }

    public static function scopeIsNew($query)
    {
        $query = $query->active()->whereNull('account_id');
    }

    public static function scopehaveNotCalled($query)
    {
        return $query->active()->where('lead_status', 'LIKE', "%Chưa gọi%");
    }

    public static function scopeIsKNMGLS($query)
    {
        return $query->active()->where('lead_status', 'LIKE', "%KNM/GLS");
    }

    public static function scopeIsError($query)
    {
        return $query->active()->where('lead_status', 'LIKE', "%Sai số%");
    }

    public static function scopeIsKCNC($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%KCNC%");
    }

    public static function scopeIsDemand($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%Có đơn hàng%");
    }

    public static function scopeIsFollow($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%Follow dài%");
    }

    public static function scopeIsPotential($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%Tiềm năng%");
    }

    public static function scopeIsAgreement($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%Đang làm hợp đồng%");
    }

    public static function scopeIsASAgreement($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%hợp đồng AS%");
    }

    public static function scopeIsReferrer($query)
    {
        return $query->active()->where('lead_status', 'LiKE', "%Khách giới thiệu khách hàng khác%");
    }

    public static function scopeIsMarketingQualifiedLead($query)
    {
        return $query->active()->where('lifecycle_stage', 'LIKE', "%Marketing Qualified Lead%");
    }

    public static function scopeIsSaleQualifiedLead($query)
    {
        return $query->active()->where('lifecycle_stage', 'LIKE', "%Sale Qualified Lead%");
    }

    public static function scopeLifecycleStageIsCustomer($query)
    {
        return $query->active()->where('lifecycle_stage', '=', "Customer");
    }

    public static function scopeIsVIPCustomer($query)
    {
        return $query->active()->where('lifecycle_stage', 'LIKE', "%VIP Customer%");
    }

    public static function getLeadStatusMenu($query, $lead_status_menu)
    {
        if ($lead_status_menu == 'have_not_called') {
            return $query->where('lead_status', 'LIKE', "%Chưa gọi%");
        } else if ($lead_status_menu == 'knm_gls') {
            return $query->where('lead_status', 'LIKE', "%KNM/GLS");
        } else if ($lead_status_menu == 'is_error') {
            return $query->where('lead_status', 'LIKE', "%Sai số%");
        } else if ($lead_status_menu == 'kcnc') {
            return $query->where('lead_status', 'LiKE', "%KCNC%");
        } else if ($lead_status_menu == 'demand') {
            return $query->where('lead_status', 'LiKE', "%Có đơn hàng%");
        } else if ($lead_status_menu == 'follow') {
            return $query->where('lead_status', 'LiKE', "%Follow dài%");
        } else if ($lead_status_menu == 'potential') {
            return $query->where('lead_status', 'LiKE', "%Tiềm năng%");
        } else if ($lead_status_menu == 'agreement') {
            return $query->where('lead_status', 'LiKE', "%Đang làm hợp đồng%");
        } else if ($lead_status_menu == 'as-agreement') {
            return $query->where('lead_status', 'LiKE', "%hợp đồng AS%");
        } else if ($lead_status_menu == 'referrer') {
            return $query->where('lead_status', 'LiKE', "%Khách giới thiệu khách hàng khác%");
        }
    }

    public static function getLifecycleStageMenu($query, $lifecycle_stage_menu)
    {
        if ($lifecycle_stage_menu == 'marketing-qualified-lead') {
            return $query->where('lifecycle_stage', 'LIKE', "%Marketing Qualified Lead%");
        } elseif ($lifecycle_stage_menu == 'sale-qualified-lead') {
            return $query->where('lifecycle_stage', 'LIKE', "%Sale Qualified Lead%");
        } elseif ($lifecycle_stage_menu == 'customer') {
            return $query->where('lifecycle_stage', '=', "Customer");
        } elseif ($lifecycle_stage_menu == 'vip-customer') {
            return $query->where('lifecycle_stage', 'LIKE', "%VIP Customer%");
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
        }
    }

    public static function importFromHubspot($totalPages=100, $perPage = 100)
    {
        //
        $count = 0;
        $timestamp = \Carbon\Carbon::now()->timezone('0')->format('Y-m-d\TH:i:s.u\Z');

        for ($page = 1; $page <= $totalPages; $page++) {
            if (!$timestamp) {
                continue;
            }

            [$timestamp, $total] = self::getTokenAPILocal($timestamp, $perPage, $count);

            if ($total == 0) {
                continue;
            }

            sleep(5);
        }
    }

    //Lấy contact thông qua Token hubspot
    public static function getTokenAPI($page, $perPage, &$count)
    {
        $token = env('HUBSPOT_API_TOKEN');
        
        //
        $offset = ($page-1)*$perPage;

        // Tạo một HTTP client
        $client = new Client();

        // Gửi yêu cầu API HubSpot
        // Gửi yêu cầu API HubSpot với kiểm tra chứng chỉ SSL tắt
        // Hiển thị các properties https://api.hubapi.com/crm/v3/objects/contacts/properties
        $response = $client->get('https://api.hubapi.com/crm/v3/objects/contacts?limit='.$perPage.'&offset='.$offset.'&properties=address,email,firstname,lastname,phone,school,deman,ward,district,city,country,tuoi,time_to_call,efc,target,list', [
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
                'hubspot_id' => $customer["id"],
                'address' => $properties["address"] ?? '',
                'email' => $properties["email"] ?? '',
                'name' => $properties["firstname"] ?? '',
                'lastname' => $properties["lastname"] ?? '',
                'phone' => $properties["phone"] ?? '',
                'school' => $properties["school"] ?? '',
                'demand' => $properties["deman"] ?? '',
                'ward' => $properties["ward"] ?? '',
                // 'birthday' => $properties["Ngày sinh"],
                'age' => $properties["tuoi"] ?? '',
                'time_to_call' => $properties["time_to_call"] ?? '',
                'country' => $properties["country"] ?? '',
                'city' => $properties["city"] ?? '',
                'district' => $properties["district"] ?? '',
                'efc' => $properties["efc"] ?? '',
                'target' => $properties["target"] ?? '',
                'list' => $properties["list"] ?? '',
                'account_id' => null,
            ];

            $count += 1;
        }

        return $selectedAttributes;
    }

    //Lấy contact thông qua Token hubspot
    public static function getTokenAPILocal($timestamp, $perPage, &$count)
    {
        //
        // $offset = ($page-1)*$perPage;

        // Tạo một HTTP client
        $client = new Client();
        $token=env('HUBSPOT_API_TOKEN');
     
        // Define the date range for May 20, 2024
        // $startDate = '2024-05-26T17:00:00.000Z';
        // $endDate = '2024-05-27T16:59:59.000Z';


        $response = $client->post('https://api.hubapi.com/crm/v3/objects/contacts/search', [
            'json' => [
                'filters' => [
                    [
                        'propertyName' => 'hs_latest_source_timestamp',
                        'operator' => 'LT',
                        'value' => $timestamp
                    ],
                    // [
                    //     'propertyName' => 'hs_latest_source_timestamp',
                    //     'operator' => 'LT',
                    //     'value' => $endDate
                    // ],
                    // [
                    //     'propertyName' => 'hs_latest_source_timestamp',
                    //     'operator' => 'GT',
                    //     'value' => $startDate
                    // ],
                    // [
                    //     'propertyName' => 'hs_latest_source_timestamp',
                    //     'operator' => 'LT',
                    //     'value' => $endDate
                    // ],
                ],
                // 'filters' => [
                //     [
                //         'propertyName' => 'hs_latest_source_timestamp',
                //         'operator' => 'GT',
                //         'value' => $startDate
                //     ],
                //     [
                //         'propertyName' => 'hs_latest_source_timestamp',
                //         'operator' => 'LT',
                //         'value' => $endDate
                //     ]
                // ],
                'sorts' => [
                    [
                        'propertyName' => 'hs_latest_source_timestamp',
                        'direction' => 'DESCENDING'
                    ]
                ],
                'limit' => $perPage,
                // 'after' => $offset,
                'properties'=> [
                    'address',
                    'email',
                    'firstname',
                    'lastname',
                    'phone',
                    'name',
                    'school',
                    'nhucau',
                    'ward',
                    'district',
                    'city',
                    'country',
                    'tuoi',
                    'time_to_call',
                    'efc',
                    'target',
                    'list',
                    'lastmodifieddate',
                    'createdate',
                    'hs_latest_source_timestamp'
                ]
            ],
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
            'verify' => false, // Vô hiệu hóa kiểm tra chứng chỉ SSL
        ]);
       
        // Lấy dữ liệu từ response
        $data = json_decode($response->getBody(), true);
        $customers = $data["results"];
        $totalRecords = count($customers);
        $lastTimestamp = $timestamp;

        // Kiểm tra nếu API return customers = [] / Nghĩa là hình như page này không có contacts
        
        $selectedAttributes = [];
        // Duyệt qua danh sách khách hàng và lấy các thuộc tính cần
        foreach ($customers as $customer) {
            
            $properties = $customer["properties"];
           
            $selectedAttributes[] = [
                'hubspot_id' => $customer["id"],
                // 'address' => $properties["address"],
                'name' => $properties["name"] ?? '' . $properties["firstname"] ?? '' . $properties["lastname"] ?? '',
                'email' => $properties["email"] ?? '',
                'phone' => $properties["phone"] ?? '',
                'demand' => $properties["nhucau"] ?? '',
                'school' => $properties["school"] ?? '',
                'city' => $properties["city"] ?? '',
                'efc' => $properties["efc"] ?? '',
                'date' => $properties["createdate"] ?? '',
                'source_type' => $properties["hs_latest_source"] ?? '',
                // 'source' => $properties["nguon"] ?? '',
                'fbcid' => $properties["hs_facebook_click_id"] ?? '',
                'gclid' => $properties["hs_google_click_id"] ?? '',
                'lifecycle_stage' => $properties["lifecyclestage"] ?? '',
                'lead_status' => $properties["hs_lead_status"] ?? '',
                // 'note_sales' => $properties["hs_lead_status"] ?? '',
                'hubspot_modified_at' => $properties["lastmodifieddate"] ? Carbon::parse($properties["lastmodifieddate"]) : null,
                'hubspot_created_at' => $properties["createdate"] ? Carbon::parse($properties["createdate"]) : null,
                'hs_latest_source_timestamp' => $properties["hs_latest_source_timestamp"] ? Carbon::parse($properties["hs_latest_source_timestamp"]) : null,

    
                'account_id' => null,
            ];

            //
            $lastTimestamp = $properties["hs_latest_source_timestamp"];
        }

        $updatedCustomersCount = 0;
        $newCustomersCount = 0;

        foreach ($selectedAttributes as $data) {
            // Kiểm tra xem có tối thiểu một trong các trường name, email hoặc phone được cung cấp
            // if (empty($data['name']) && empty($data['email']) && empty($data['phone'])) {
            if (empty($data['phone'])) {
                continue; // Bỏ qua dữ liệu nếu không có tối thiểu một trong các trường name, email hoặc phone
            }
            
            // Kiểm tra xem có hợp đồng với cùng HubSpot ID đã tồn tại chưa
            $contact = Contact::where('hubspot_id', $data["hubspot_id"])->first();

            if ($contact) {
                // Nếu đã tồn tại hợp đồng với cùng HubSpot ID, thực hiện cập nhật
                $contact->hubspot_id = $data["hubspot_id"];
                $contact->name = $data["name"] ?? 'N/A';
                $contact->email = $data['email'] ?? 'N/A';
                $contact->phone = \App\Library\Tool::extractPhoneNumber(substr($data['phone'], 0, 20)) ?? 'N/A';
                $contact->demand = $data["demand"] ?? '';
                $contact->school = $data["school"] ?? '';
                $contact->city = $data["city"] ?? '';
                $contact->efc = $data["efc"] ?? '';
                $contact->time_to_call = $data["date"] ?? '';
                $contact->source_type = $data["source_type"] ;
                // $contact->source = $data["source"] ?? '';
                $contact->fbcid = $data["fbcid"] ?? '';
                $contact->gclid = $data["gclid"] ?? '';
                $contact->lifecycle_stage = $data["lifecycle_stage"] ?? '';
                $contact->lead_status = $data["lead_status"] ?? '';
                $contact->hubspot_modified_at = $data["hubspot_modified_at"] ?? null;
                $contact->hubspot_created_at = $data["hubspot_created_at"] ?? null;
                $contact->hs_latest_source_timestamp = $data["hs_latest_source_timestamp"] ?? null;
                
                // $contact->note_sales = $data["note_sales"] ;
                $updatedCustomersCount++;

                // Kiểm tra contact request trùng dựa vào hubspot id và hs_latest_source_timestamp
                $contactRequest = ContactRequest::where('hubspot_id', $data["hubspot_id"])
                    ->where('hs_latest_source_timestamp', $data["hs_latest_source_timestamp"])
                    ->where('contact_id', $contact->id)->first();
                
                if(!$contactRequest){
                    $params = $contact->getAttributes();
                    $params['added_from'] = self::ADDED_FROM_HUBSPOT;
                    $contact->addContactRequest($params);
                } else {
                    // Log::info("Trùng ngày source date: " . $data["hs_latest_source_timestamp"]);
                }

                $contact->save();
            } else {
                // Kiểm tra email và phone có trùng không
                // $existing = Contact::where('email', $data['email'])
                //                    ->where('phone', $data['phone'])
                //                    ->first();

                $existing = Contact::where('phone', $data['phone'])
                                   ->first();

                if ($existing) {
                    $existing->hubspot_id = $data["hubspot_id"];
                    $existing->name = $data["name"] ?? 'N/A';
                    $existing->email = $data['email'] ?? 'N/A';
                    $existing->phone = \App\Library\Tool::extractPhoneNumber(substr($data['phone'], 0, 20)) ?? 'N/A';
                    $existing->demand = $data["demand"] ?? '';
                    $existing->school = $data["school"] ?? '';
                    $existing->city = $data["city"] ?? '';
                    $existing->efc = $data["efc"] ?? '';
                    $existing->time_to_call = $data["date"] ?? '';
                    // $existing->source_type = $data["hs_latest_source"] ?? '';
                    $existing->source_type = $data["source_type"] ?? '';
                    // $existing->source = $data["source"] ?? '';
                    $existing->fbcid = $data["fbcid"] ?? '';
                    $existing->gclid = $data["gclid"] ?? '';
                    $existing->lifecycle_stage = $data["lifecycle_stage"] ?? '';
                    $existing->lead_status = $data["lead_status"] ?? '';
                    // $existing->note_sales = $data["note_sales"] ?? '';
                    $existing->hubspot_modified_at = $data["hubspot_modified_at"] ?? null;
                    $existing->hubspot_created_at = $data["hubspot_created_at"] ?? null;
                    $existing->hs_latest_source_timestamp = $data["hs_latest_source_timestamp"] ?? null;
                    $existing->save();

                    // Kiểm tra contact request trùng dựa vào hubspot id và hs_latest_source_timestamp
                    $contactRequest = ContactRequest::where('hubspot_id', $data["hubspot_id"])
                        ->where('hs_latest_source_timestamp', $data["hs_latest_source_timestamp"])
                        ->where('contact_id', $existing->id)->first();
                    
                    if(!$contactRequest){
                        $params = $existing->getAttributes();
                        $params['added_from'] = self::ADDED_FROM_HUBSPOT;
                        $existing->addContactRequest($params);
                    }

                    $updatedCustomersCount++;
                } else {
                    // Nếu không có hợp đồng nào với cùng HubSpot ID tồn tại, tạo một hợp đồng mới
                    $contact = Contact::newDefault();
                    $contact->added_from = self::ADDED_FROM_HUBSPOT;
                    $contact->hubspot_id = $data["hubspot_id"];
                    $contact->name = $data["name"] ?? 'N/A';
                    $contact->email = $data['email'] ?? 'N/A';
                    $contact->phone = \App\Library\Tool::extractPhoneNumber(substr($data['phone'], 0, 20)) ?? 'N/A';
                    $contact->demand = $data["demand"] ?? '';
                    $contact->school = $data["school"] ?? '';
                    $contact->city = $data["city"] ?? '';
                    $contact->efc = $data["efc"] ?? '';
                    $contact->time_to_call = $data["date"] ?? '';
                    // $contact->source_type = $data["hs_latest_source"] ?? '';
                    $contact->source_type = $data["source_type"] ?? '';
                    $contact->fbcid = $data["fbcid"] ?? '';
                    $contact->gclid = $data["gclid"] ?? '';
                    $contact->lifecycle_stage = $data["lifecycle_stage"] ?? '';
                    $contact->lead_status = $data["lead_status"] ?? '';
                    // $contact->note_sales = $data["hs_lead_status"] ?? '';
                    $contact->hubspot_modified_at = $data["hubspot_modified_at"] ?? null;
                    $contact->hubspot_created_at = $data["hubspot_created_at"] ?? null;
                    $contact->hs_latest_source_timestamp = $data["hs_latest_source_timestamp"] ?? null;
                        
                    $contact->save();
                    
                    $params = $contact->getAttributes();
                    $params['added_from'] = self::ADDED_FROM_HUBSPOT;
                    $contact->addContactRequest($params);
                    $newCustomersCount++;
                }
            }

            $count += 1;
        }
       
        return [$lastTimestamp, $totalRecords];
    }

    public function findRelatedContactsImportFromExcel($email, $phone)
    {
        $relatedContacts = Contact::findRelatedContacts2([
            'email' => $email,
            'phone' => $phone,
        ]);

        return $relatedContacts;
    }

    //Lưu contacts vào database
    public static function getSaveContactsHubspot($customers, $account_id)
    {
        $newCustomersCount = 0;
        $updatedCustomersCount = 0;

        foreach ($customers as $data) {
            // Kiểm tra xem có hợp đồng với cùng HubSpot ID đã tồn tại chưa
            $contact = Contact::where('hubspot_id', $data["hubspot_id"])->first();

            if ($contact) {
                // Nếu đã tồn tại hợp đồng với cùng HubSpot ID, thực hiện cập nhật
                $contact->email = $data['email'];
                $contact->phone = \App\Library\Tool::extractPhoneNumber($data['phone']);
                $contact->account_id = $account_id;
                $updatedCustomersCount++;

                $contact->save();
            } else {
                // Nếu không có hợp đồng nào với cùng HubSpot ID tồn tại, tạo một hợp đồng mới
                $contact = Contact::newDefault();
                $contact->added_from = self::ADDED_FROM_HUBSPOT;
                $contact->name = $data['lastname'];
                $contact->hubspot_id = $data['hubspot_id'];
                $contact->email = $data['email'];
                $contact->phone = \App\Library\Tool::extractPhoneNumber($data['phone']);
                $contact->account_id = $account_id;
                $contact->save();
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

    ////
    public static function importContacts($updateProgress)
    {
        $total = 100;

        for ($i = 1; $i <= $total; $i++) {
            sleep(1);

            $updateProgress([
                'status' => 'running',
                'total' => $total,
                'sucess' => $i,
                'failed' => 0,
            ]);
        }
    }

    public function scopeOutdated($query)
    {
        $query = $query->whereNotNull('assigned_expired_at')
            ->where('assigned_at', '<', \Carbon\Carbon::now());
    }

    public function getDeadlineCountDownInMinutes($hours = 2)
    {
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

    public function contactRequests()
    {
        return $this->hasMany(ContactRequest::class);
    }

    public function paymentAccounts()
    {
        return $this->hasMany(PaymentAccount::class);
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function studentOrders()
    {
        return $this->hasMany(Order::class, 'student_id');
    }

    public function noteLogs()
    {
        return $this->hasMany(NoteLog::class);
    }

    public function relationships()
    {
        return $this->hasMany(Relationship::class);
    }
    public function accountKpiNotes()
    {
        return $this->hasMany(AccountKpiNote::class, 'contact_id');
    }
    public function reverseRelationships()
    {
        return $this->hasMany(Relationship::class, 'to_contact_id');
    }

    public function scopeIsCustomer($query)
    {
        $query->where(function($q) {
            $q->whereHas('studentOrders', function ($query) {
                $query->whereNotNull('id')
                    ->where('status', Order::STATUS_APPROVED);
            })->orWhereHas('orders', function ($query) {
                $query->whereNotNull('id')
                    ->where('status', Order::STATUS_APPROVED);
            });
        });
    }

    public function scopeIsStudent($query)
    {
        $query->where(function($q) {
            $q->whereHas('studentOrders', function ($query) {
                $query->whereNotNull('id')
                    ->where('status', Order::STATUS_APPROVED);
            });
        });
    }

    public function scopeIsNotCustomer($query)
    {
        $query = $query->whereDoesntHave('studentOrders', function ($query) {
            $query->whereNotNull('id')
                ->where('status', Order::STATUS_APPROVED);
        })->whereDoesntHave('orders', function ($query) {
            $query->whereNotNull('id')
                ->where('status', Order::STATUS_APPROVED);
        });
    }

    public function hasOrders()
    {
        return $this->orders()->exists();
    }

    public function hasContactRequests()
    {
        return $this->contactRequests()->exists();
    }

    public static function exportToExcel($templatePath, $filteredContacts)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filteredContacts as $contact) {
            // Date formatting
            $created_at = $contact['created_at'] ? Carbon::parse($contact['created_at'])->format('d/m/Y') : null;
            $birthday = $contact['birthday'] ? Carbon::parse($contact['birthday'])->format('d/m/Y') : null;
            $identity_date = $contact['identity_date'] ? Carbon::parse($contact['identity_date'])->format('d/m/Y') : null;
            $fatherName = $contact->father_id ? $contact->father->name : '';
            $motherName = $contact->mother_id ? $contact->mother->name : '';
            $rowData = [
                $contact['name'],
                $contact['phone'],
                $contact['email'],
                $birthday,
                $contact['age'],
                $contact['identity_id'],
                $contact['identity_place'],
                $identity_date,
                $contact['time_to_call'],
                $contact['city'],
                $contact['district'],
                $contact['ward'],
                $contact['address'],
                $fatherName,
                $motherName
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public static function scopeSelect2RefundRequest($query, $request)
    {
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // Get students in contacts
        if (isset($request->type) && $request->type === 'student') {
            $query = $query->whereHas('studentOrders');
        }

        // Get students with abroad order items in contacts
        if (isset($request->type) && $request->type === 'abroad_student') {
            $query = $query->whereHas('orders', function ($q) {
                $q->whereHas('orderItems', function ($q2) {
                    $q2->where('type', Order::TYPE_ABROAD);
                });
            });
        }
        $query = $query->whereHas('contactRequests', function ($q) {
            $q->where('account_id', auth()->id());
        });
        // pagination
        $contacts = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $contacts->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'text' => $contact->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $contacts->lastPage() != $request->page,
            ],
        ];
    }

    public static function scopeSelect2($query, $request, $canViewPhone=true)
    {
        // keyword
        if ($request->search ) {
            $query = $query->search($request->search);
            // $keyword = trim($request->search);
            // $query = $query->where(function($q) use ($keyword) {
            //     $q->where('email', $keyword)
            //         ->orWhere('name', $keyword)
            //         ->orWhere('phone', $keyword);
            // });
        } else {
            $query = $query->where('id', 0);
        }

        // Get students in contacts
        if (isset($request->type) && $request->type === 'student') {
            $query = $query->whereHas('studentOrders');
        }

        // Get students with abroad order items in contacts
        if (isset($request->type) && $request->type === 'abroad_student') {
            $query = $query->whereHas('orders', function ($q) {
                $q->whereHas('orderItems', function ($q2) {
                    $q2->where('type', Order::TYPE_ABROAD);
                });
            });
        } 
        // pagination
        $contacts = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $contacts->map(function ($contact) use ($canViewPhone) {
                return [
                    'id' => $contact->id,
                    'text' => $contact->getSelect2Text($canViewPhone),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $contacts->lastPage() != $request->page,
            ],
        ];
    }

    public function getSelect2Text($canViewPhone=true)
    {
        if (!$canViewPhone) {
            $phone = \App\Helpers\Functions::hidePhoneNumber($this->phone);
        } else {
            $phone = $this->phone;
        }
        
        return '<strong>' . $this->name . '</strong><div>' . $this->email . '</div><div>' . $phone . '</div>';
    }

    public function addNoteLog($account, $content)
    {
        $this->noteLogs()->create([
            'content' => $content,  
            'account_id' => $account->id,
            'status' => self::STATUS_ACTIVE,
            'system_add' => true,
        ]);
    }

    public static function getNewContactsCount($xType, $yType, $xColumns, $yColumns, $request)
    {
        $data = [];
        $columnTotals = [];
        $data['tổng Columnx']['tổng Columny'] = 0;
        foreach ($xColumns as $xColumn) {
            $data[$xColumn]['tổng Columny'] = 0;
            foreach ($yColumns as $yColumn) {
                // 
                $contacts = self::query();
                // X
                if ($xType == 'lead_status') {
                    $contacts = $contacts->where('lead_status', $xColumn);
                } else if ($xType == 'channel') {
                    $contacts = $contacts->where('channel', $xColumn);
                } else if ($xType == 'sales') {
                    $account = Account::where('name', $xColumn)->first();
                    $accountId = $account->id;
                    $contacts = $contacts->where('account_id', $accountId);
                }
                // Y
                if ($yType == 'lead_status') {
                    $contacts = $contacts->where('lead_status', $yColumn);
                } else if ($yType == 'channel') {
                    $contacts = $contacts->where('channel', $yColumn);
                } else if ($yType == 'sales') {
                    $account = Account::where('name', $yColumn)->first();
                    $accountId = $account->id;
                    $contacts = $contacts->where('account_id', $accountId);
                }
                // fitlers by create_at
                if ($request->has('created_at_from') && $request->has('created_at_to')) {
                    $created_at_from = $request->input('created_at_from');
                    $created_at_to = $request->input('created_at_to');
                    $contacts  = $contacts->filterByCreatedAt($created_at_from, $created_at_to);
                }
                // Filter by updated_at
                if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
                    $updated_at_from = $request->input('updated_at_from');
                    $updated_at_to = $request->input('updated_at_to');
                    $contacts  = $contacts->filterByUpdatedAt($updated_at_from, $updated_at_to);
                }
                if (isset($request->selectedMarketingSource)) {
                    $contacts = $contacts->where('channel', $request->input('selectedMarketingSource'));
                }
                if (isset($request->selectedMarketingSubChannel)) {
                    $contacts = $contacts->where('sub_channel', $request->input('selectedMarketingSubChannel'));
                }
                if (isset($request->selectedLifecycleSource)) {
                    $contacts = $contacts->where('lifecycle_stage', $request->input('selectedLifecycleSource'));
                }
                if (isset($request->selectedLifecycleSubChannel)) {
                    $contacts = $contacts->where('lead_status', $request->input('selectedLifecycleSubChannel'));
                }
                $result = $contacts->count();
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

    public static function getNewCustomersCount($xType, $yType, $xColumns, $yColumns, $request)
    {
        $data = [];
        $columnTotals = [];
        $data['tổng Columnx']['tổng Columny'] = 0;
        foreach ($xColumns as $xColumn) {
            $data[$xColumn]['tổng Columny'] = 0;
            foreach ($yColumns as $yColumn) {
                // 

                $orders = self::select('contacts.*')
                    ->selectSub(function ($query) {
                        $query->select('created_at')
                            ->from('orders')
                            ->whereColumn('contact_id', 'contacts.id')
                            ->orderBy('created_at', 'asc')
                            ->limit(1);
                    }, 'first_order_created_at')
                    ->whereHas('orders');

                // X
                if ($xType == 'lead_status') {
                    $orders = $orders->where('lead_status', $xColumn);
                } else if ($xType == 'channel') {
                    $orders = $orders->where('channel', $xColumn);
                } else if ($xType == 'sales') {
                    $account = Account::where('name', $xColumn)->first();
                    $accountId = $account->id;
                    $orders = $orders->where('account_id', $accountId);
                }

                // Y
                if ($yType == 'lead_status') {
                    $orders = $orders->where('lead_status', $yColumn);
                } else if ($yType == 'channel') {
                    $orders = $orders->where('channel', $yColumn);
                } else if ($yType == 'sales') {
                    $account = Account::where('name', $yColumn)->first();
                    $accountId = $account->id;
                    $orders = $orders->where('account_id', $accountId);
                }

                // fitlers by create_at
                if ($request->has('created_at_from') && $request->has('created_at_to')) {
                    $created_at_from = $request->input('created_at_from');
                    $created_at_to = $request->input('created_at_to');
                    $orders  = $orders->filterByCreatedAt($created_at_from, $created_at_to);
                }

                // Filter by updated_at
                if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
                    $updated_at_from = $request->input('updated_at_from');
                    $updated_at_to = $request->input('updated_at_to');
                    $orders  = $orders->filterByUpdatedAt($updated_at_from, $updated_at_to);
                }

                if (isset($request->selectedMarketingSource)) {
                    $orders = $orders->where('channel', $request->input('selectedMarketingSource'));
                }

                if (isset($request->selectedMarketingSubChannel)) {
                    $orders = $orders->where('sub_channel', $request->input('selectedMarketingSubChannel'));
                }

                if (isset($request->selectedLifecycleSource)) {
                    $orders = $orders->where('lifecycle_stage', $request->input('selectedLifecycleSource'));
                }

                if (isset($request->selectedLifecycleSubChannel)) {
                    $orders = $orders->where('lead_status', $request->input('selectedLifecycleSubChannel'));
                }

                $result = $orders->count();
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

    public static function getReports($xType, $yType, $xColumns, $yColumns, $dataType, $request)
    {
        $data = [];
        $rowTotals = [];
        $columnTotals = [];
        $data['tổng Columnx']['tổng Columny'] = 0;

        if ($dataType == 'new_contact') {
            $data = self::getNewContactsCount($xType, $yType, $xColumns, $yColumns, $request);
        } else if ($dataType == 'new_customer') {
            $dataNewContacts = self::getNewContactsCount($xType, $yType, $xColumns, $yColumns, $request);
            $dataNewCustomers = self::getNewCustomersCount($xType, $yType, $xColumns, $yColumns, $request);

            // Tính tỷ lệ và gán vào data
            foreach ($xColumns as $xColumn) {
                foreach ($yColumns as $yColumn) {
                    if (!isset($data[$xColumn])) {
                        $data[$xColumn] = [];
                    }

                    if ($dataNewContacts[$xColumn][$yColumn] != 0) {
                        $ratio = $dataNewCustomers[$xColumn][$yColumn] / $dataNewContacts[$xColumn][$yColumn] * 100;
                        $data[$xColumn][$yColumn] = round($ratio, 2);
                    } else {
                        $data[$xColumn][$yColumn] = 0; // Tránh chia cho 0
                    }

                    // Cập nhật tổng cột
                    if (!isset($columnTotals[$yColumn])) {
                        $columnTotals[$yColumn] = 0;
                    }
                    $columnTotals[$yColumn] += $data[$xColumn][$yColumn];
                }

                // Cập nhật tổng hàng
                $rowTotal = array_sum($data[$xColumn]);
                $data[$xColumn]['tổng Columny'] = $rowTotal;
                $rowTotals[$xColumn] = $rowTotal;
            }

            // Cập nhật tổng cột
            foreach ($yColumns as $yColumn) {
                $columnTotal = 0;
                foreach ($xColumns as $xColumn) {
                    $columnTotal += $data[$xColumn][$yColumn];
                }
                $data['tổng Columnx'][$yColumn] = $columnTotal;
                $columnTotals[$yColumn] = $columnTotal;
            }

            // Cập nhật tổng hàng cột
            $data['tổng Columnx']['tổng Columny'] = array_sum($rowTotals);
        }

        return $data;
    }

    public function newContactRequest()
    {
        $contactRequest = new ContactRequest();
        $contactRequest->contact_id = $this->id;
        $contactRequest->status = ContactRequest::STATUS_ACTIVE;
        return $contactRequest;
    }

    public function addContactRequest($params)
    {
        unset($params['id']);
        $contactRequest = $this->newContactRequest();
        $contactRequest->fillAttributes($params);
        
        // update back to contact
        if( !is_null( $contactRequest->email) ){
            $contactRequest->email = trim(($contactRequest->email));
            $this->email = $contactRequest->email;
        }
        if( !is_null( $contactRequest->phone) ){
            $contactRequest->phone = \App\Library\Tool::extractPhoneNumber(trim(($contactRequest->phone)));
            $this->phone = $contactRequest->phone;
        }
        if( !is_null($contactRequest->name) ){
            $contactRequest->name = trim($contactRequest->name);
        }
        if( !is_null( $contactRequest->demand) ){
            $contactRequest->demand = trim($contactRequest->demand);
            $this->demand = $contactRequest->demand;
        }

        // save
        $contactRequest->save();

        // update code
        $contactRequest->generateCode();

        // 
        $this->save();

        //
        $this->latest_activity_date = $contactRequest->created_at;
        $this->save();

        return $contactRequest;
    }

    public function getLastNoteLog()
    {
        return $this->noteLogs()->orderBy('created_at', 'desc')->first();
    }

    public function getFullAddress()
    {
        return "{$this->address}, {$this->ward}, {$this->district}, {$this->city}";
    }

    public function updateFather($contact)
    {
        $contact->updateRelationship($this, Relationship::TYPE_FATHER);
    }

    public function updateMother($contact)
    {
        $contact->updateRelationship($this, Relationship::TYPE_MOTHER);
    }

    public function updateRelationship($toContact, $type, $other = null)
    {
        $validator = \Validator::make([], []);

        // other type without other
        if ($type == Relationship::TYPE_OTHER && !$other) {
            $validator->errors()->add('relationship_other', 'Điền quan hệ khác');
            return $validator->errors();
        }

        // validate
        try {
            Relationship::validate($this, $toContact, $type, $other);
        } catch (\Throwable $e) {
            $validator->errors()->add('relationship_validate', $e->getMessage());
            return $validator->errors();
        }

        // xóa quan hệ hiện tại nếu có
        $existRelationship = $this->findRelationshipTo($toContact);
        if ($existRelationship) {
            $existRelationship->delete();
        }

        // thêm quan hệ
        Relationship::add($this, $toContact, $type, $other);

        return $validator->errors();
    }

    public function findRelationshipTo($toContact)
    {
        return $this->relationships()
            ->where('to_contact_id', $toContact->id)
            ->first();
    }

    public static function findRelatedContacts($fields)
    {
        // return [] if no valid fields
        if (!\App\Helpers\Functions::isValidPhoneNumber($fields['phone']) && !\App\Helpers\Functions::isValidEmail($fields['email'])) {
            return collect([]);
        }

        $query = self::query();

        // exclude the current contact
        if (isset($fields['contact_id']) && $fields['contact_id']) {
            $query = $query->whereNot('id', $fields['contact_id']);
        }

        // query email or phone
        $query = $query->where(function ($q) use ($fields) {
            // find by email
            if (\App\Helpers\Functions::isValidEmail($fields['email'])) {
                $q = $q->orWhereRaw('LOWER(email) = ?', [trim(strtolower($fields['email']))]);
            }
            // find by phone
            if (\App\Helpers\Functions::isValidPhoneNumber($fields['phone'])) {
                $q = $q->orWhereRaw('LOWER(phone) = ?', [trim(strtolower($fields['phone']))]);
            }
        });

        return $query->get();
    }

    public static function findRelatedContacts2($fields)
    {
        $query = self::query();
    
        // query email or phone
        $query = $query->where(function ($q) use ($fields) {
            if (isset($fields['phone']) && !is_null($fields['phone'])) {
                $phone = \App\Library\Tool::extractPhoneNumber(trim(strtolower($fields['phone'])));
                $q->orWhere('phone', '=', $phone);
            }
        });

        return $query->get();
    }
    
    public function findFatherRelationship()
    {
        return $this->reverseRelationships()
            ->father()
            ->first();
    }

    public function getFatherLegacy()
    {
        $relationship = $this->findFatherRelationship();

        if (!$relationship) {
            return null;
        }

        return $relationship->contact;
    }

    public function getFather()
    {
        return $this->father;
    }

    public function findMotherRelationship()
    {
        return $this->reverseRelationships()
            ->mother()
            ->first();
    }

    public function getMother()
    {
        return $this->mother;
    }

    public function getMotherLegacy()
    {
        $relationship = $this->findMotherRelationship();

        if (!$relationship) {
            return null;
        }

        return $relationship->contact;
    }

    public function removeFather()
    {
        $relationship = $this->findFatherRelationship();

        if ($relationship) {
            $relationship->delete();
        }
    }

    public function removeMother()
    {
        $relationship = $this->findMotherRelationship();

        if ($relationship) {
            $relationship->delete();
        }
    }

    public function infoFromKeyword($keyword)
    {
        if (\App\Helpers\Functions::isValidPhoneNumber(trim($keyword))) {
            $this->phone = \App\Library\Tool::extractPhoneNumber($keyword);
        } else if (\App\Helpers\Functions::isValidEmail(trim($keyword))) {
            $this->email = $keyword;
        }
    }

    public function deleteContact()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public static function scopeDeleteAll($query, $contactIds)
    {
        $contacts = self::whereIn('id', $contactIds)->get();

        foreach ($contacts as $contact) {
            $contact->update(['status' => self::STATUS_DELETED]);
        }
    }

    public static function scopeLearning($query)
    {
        $query->whereHas('courseStudents', function ($q) {
            $q->whereHas('student', function ($q2) {
                $q2->whereDoesntHave('studentSections', function ($q3) {
                    $q3->whereIn('status', ['refund', 'reserve']);
                });
            });
            $q->whereHas('course', function ($q2) {
                // Điều kiện cột 'start_at' nhỏ hơn ngày hiện tại
                $q2->where('start_at', '<', now());
            });
        });
    }

    public static function scopeWaiting($query)
    {
        $query->whereHas('courseStudents', function ($q) {
            $q->whereHas('student', function ($q2) {
                $q2->whereDoesntHave('studentSections', function ($q3) {
                    $q3->whereIn('status', ['refund', 'reserve']);
                });
            });
            $q->whereHas('course', function ($q2) {
                // Điều kiện cột 'start_at' nhỏ hơn ngày hiện tại
                $q2->where('start_at', '>', now());
            });
        });
    }

    public static function scopeNotenrolled($query)
    {
        $query->whereHas('orders', function ($query) {
            $query->whereHas('orderItems', function ($q) {
                $q->whereIn('type', [Order::TYPE_EDU, Order::TYPE_REQUEST_DEMO])
                    ->whereDoesntHave('courseStudents', function ($q2) {
                        $q2->whereColumn('order_item_id', 'order_items.id');
                    })
                    ->whereDoesntHave('refundRequest', function ($q2) {
                        $q2->whereColumn('order_item_id', 'order_items.id');
                    })
                    ->whereHas('orders', function ($q3) {
                        $q3->where('status', Order::STATUS_APPROVED);
                    });
            });
        });
    }

    public static function scopeEnrolled($query)
    {
        $query->whereHas('courseStudents');
    }

    public static function scopeFinished($query)
    {
        $query->whereHas('courseStudents', function ($q) {
            $q->whereHas('course', function ($q2) {
                $q2->where('end_at', '<', now());
            });
        });
    }

    public static function scopeReserveOrderItem($query)
    {
        $query->whereHas('reserve', function ($q) {
            $q->where('status', '=', 'pending');
        });
    }

    public static function scopeRefund($query)
    {
        $query->whereHas('refundRequest', function ($q) {
            $q->where('status', '=', 'approved');
        });
    }

    public static function scopeRejected($query)
    {
        $query->whereHas('refundRequest', function ($q) {
            $q->where('status', '=', 'rejected');
        });
    }

    public static function scopeRequestRefund($query)
    {
        $query->whereHas('refundRequest', function ($q) {
            $q->where('status', '=', 'pending');
        });
    }

    public function reserveCourses()
    {
        return $this->courseStudents()->whereHas('section', function ($q) {
            $q->where('status', '=', 'reserve');
        });
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id');
    }

    public function getReserveCoursesCount()
    {
        return $this->courses()->whereHas('sections', function ($q) {
            $q->whereHas('studentSections', function ($q) {
                $q->where('status', '=', 'reserve');
            });
        })->count();
    }

    public static function students()
    {
        $students = self::whereHas('studentOrders', function ($query) {
            $query->whereHas('orderItems', function ($subQuery) {
                $subQuery->whereIn('type', [Order::TYPE_EDU, Order::TYPE_REQUEST_DEMO])
                    ->whereHas('orders', function ($q2) {
                        $q2->where('status', Order::STATUS_APPROVED);
                    });
            });
        });

        return $students;
    }
    
    public static function scopeStudent($query)
    {
        $query->whereHas('studentOrders', function ($query) {
            $query->whereHas('orderItems', function ($subQuery) {
                $subQuery->whereIn('type', [Order::TYPE_EDU, Order::TYPE_REQUEST_DEMO])
                    ->whereHas('orders', function ($q2) {
                        $q2->where('status', Order::STATUS_APPROVED);
                    });
            });
        });

    }

    public static function whichHasCousrse($studentID)
    {
        $count = DB::table('course_student')
            ->where('student_id', $studentID)
            ->whereNotNull('order_item_id')
            ->count();

        return $count;
    }

    public static function whichHaDoesntCousrse($studentID)
    {
        // $orders = self::findOrFail($studentID)->orders;
        // $orderItem = new OrderItem();
        // $courseOrderItems = $orderItem->whereIn('order_id', $orders->pluck('id'))->whereDoesntHave('refundRequest')->where('type', Order::TYPE_EDU);
        // return $courseOrderItems->count();

        // Hoang Anh fix temporary
        $array = Order::where('contact_id', $studentID)->where('status', Order::STATUS_APPROVED)->get()->pluck('id');
        $orderItems = OrderItem::whereIn('order_id', $array)
            ->where('type', OrderItem::TYPE_EDU)
            ->whereDoesntHave('refundRequest')
            ->get();

        return $orderItems->count();
    }

    public static function studentsAssignmented()
    {
        $students =   self::whereHas('courseStudents');

        return $students;
    }

    // Assign course to student
    public function assignCourse(Course $course, OrderItem $orderItem,$assignment_date)
    {
        // Nghiệo vụ: subject phải giống nhau
        // if ($orderItem->subject_id !== $course->subject_id) {
        //     throw new \Exception("Môn học của lớp học [" . $course->subject->name . "] và hợp đồng [" . $orderItem->subject->name . "] không giống nhau");
        // }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Xếp lớp cho học viên đó
            $coursStudent = CourseStudent::create([
                'order_item_id' => $orderItem->id,
                'student_id' => $this->id,
                'course_id' => $course->id,
            ]);

            // Thêm tất cả buổi học chưa học của lớp học đó vào student section của học viên
            $sections = $course->sections()->isNotOverDayStart($assignment_date)->get();
            $sumMinutesForeignTeacher = 0;
            $sumMinutesTutor = 0;
            $sumMinutesVNTeacher = 0;

            foreach ($sections as $section) {
                $foreignTeacherStartAt = Carbon::parse($section->foreign_teacher_from);
                $foreignTeacherEndAt = Carbon::parse($section->foreign_teacher_to);
                $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
                $sumMinutesForeignTeacher += $minutesForeignTeacher;

                $tutorStartAt = Carbon::parse($section->tutor_from);
                $tutorEndAt = Carbon::parse($section->tutor_to);
                $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
                $sumMinutesTutor += $minutesTutor;

                $VNTeacherStartAt = Carbon::parse($section->vn_teacher_from);
                $VnTeacherEndAt = Carbon::parse($section->vn_teacher_to);
                $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
                $sumMinutesVNTeacher += $minutesVNTeacher;

                if ($sumMinutesVNTeacher > $orderItem->getTotalVnMinutes() || $sumMinutesForeignTeacher > $orderItem->getTotalForeignMinutes() || $sumMinutesTutor > $orderItem->getTotalTutorMinutes()) {
                    break;
                }

                StudentSection::create([
                    'section_id' => $section->id,
                    'student_id' => $this->id,
                    'status' => StudentSection::STATUS_NEW,
                ]);
            }
           
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    // Chuyển lởp
    public function transferCourse(Course $currentCourse, Course $courseTransfer, OrderItem $orderItem, $request)
    {
      

        // Begin transaction
        DB::beginTransaction();

        try {
            // Xoá tất cả những section chưa học của học viên đó thuộc lớp hiện tại
            // $this->studentSections()
            //     ->byCourse($currentCourse)
            //     ->isNotOver()
            //     ->delete(); // kiểm tra kỹ lại cái besiness
           
            StudentSection::where('student_id', $this->id)
                ->whereHas('section', function ($query) use ($currentCourse) {
                    $query->where('course_id', $currentCourse->id);
                })
                ->where('status', '=', StudentSection::STATUS_NEW)
                ->delete();
               
              

                
            CourseStudent::where('student_id', $this->id)
                ->where('course_id',  $currentCourse->id)
                ->delete();

                $assignment_date = new DateTime('now');
                
            // Thêm tất cả section chưa học của lớp mới vào lịch của học viện
            $this->assignCourse($courseTransfer, $orderItem,$assignment_date );


            // TransferCourse::dispatch($currentCourse,$courseTransfer,$orderItem, $request->user());
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        DB::commit();
    }

    public function reserveCourse($currentCourses, $reserveStartAt)
    {
        // Nghiệo vụ: subject phải giống nhau
        // if ($currentCourse->subject_id !== $courseTransfer->subject_id) {
        //     throw new \Exception("Môn học của lớp học hiện tại [" . $currentCourse->subject->name . "] và lớp học chuyển tới [" . $courseTransfer->subject->name . "] không giống nhau");
        // }

        // Begin transaction
        DB::beginTransaction();

        try {
            foreach ($currentCourses as $currentCourse) {
                $sections = StudentSection::where('student_id', $this->id)
                    ->whereHas('section', function ($query) use ($currentCourse, $reserveStartAt) {
                        $query->where('course_id', $currentCourse)
                            ->where('start_at', '>', Carbon::parse($reserveStartAt));
                    })
                    ->where('status', '=', StudentSection::STATUS_NEW)
                    ->get();
                // Thêm tất cả buổi học cha học của lớp học đó vào student section của học viên

                foreach ($sections as $section) {
                    $section->setSkipped();
                }
            }
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function doneRefundRequest($orderItemIds, $reserveStartAt, $reason)
    {
        // Nghiệp vụ: subject phải giống nhau

        // Begin transaction
        DB::beginTransaction();

        try {
            foreach ($orderItemIds as $orderItemId) {
                RefundRequest::create([
                    'student_id' => $this->id,
                    'refund_date' => $reserveStartAt,
                    'status' => RefundRequest::STATUS_PENDING,
                    'order_item_id' => $orderItemId,
                    'reason' => $reason,
                    'course_id' => 12
                ]);
            }

            // event
            ConfirmRefundRequest::dispatch($orderItemIds);

        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function checkRefundRequest($courseId)
    {
        $refundReques = RefundRequest::where('student_id', $this->id)
            ->where('course_id',  $courseId)->where('status', '!=', RefundRequest::STATUS_REJECTED)->count();

        if ($refundReques === 0) {
            return true;
        }

        return false;
    }

    public function checkReserve($courseId)
    {
        $refundReques = StudentSection::where('student_id', $this->id)
            ->whereHas('section', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })->where('status', '!=', StudentSection::STATUS_RESERVE)->count();

        if ($refundReques === 0) {
            return false;
        }

        return true;
    }

    public function getStudentSectionStatus($section)
    {
        return StudentSection::where('student_id', $this->id)->where('section_id', $section->id)->first()->status;
    }

    public function getStatusClass($course)
    {
        if ($course->isStopped()) {
            return 'Dừng lớp';
        }

        $reserveClass = StudentSection::where('student_id', $this->id)
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->where('status', StudentSection::STATUS_RESERVE)
            ->first();

        $exitClass = StudentSection::where('student_id', $this->id)
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->where('status', StudentSection::STATUS_EXIT)
            ->first();

        if ($exitClass !== null && $exitClass->status ==  StudentSection::STATUS_EXIT) {
            $statusClass = 'Đã thoát lớp';
        } else if ($reserveClass !== null && $reserveClass->status ==  StudentSection::STATUS_RESERVE) {
            $statusClass = 'Bảo lưu';
        } else {
            $statusClass = 'Đã xếp lớp';
        }

        return $statusClass;
    }

    public function getStatusStudent($course)
    {
      
        $reserveClass = StudentSection::where('student_id', $this->id)
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->where('status', StudentSection::STATUS_RESERVE)
            ->first();

        $exitClass = StudentSection::where('student_id', $this->id)
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->where('status', StudentSection::STATUS_EXIT)
            ->first();
        $refund = StudentSection::where('student_id', $this->id)
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->where('status', StudentSection::STATUS_REFUND)
            ->first();

        if ($exitClass !== null && $exitClass->status ==  StudentSection::STATUS_EXIT) {
            $statusClass = 'Đã thoát lớp';
        } else if ($reserveClass !== null && $reserveClass->status ==  StudentSection::STATUS_RESERVE) {
            $statusClass = 'Bảo lưu';
        }else if ($refund !== null && $refund->status ==  StudentSection::STATUS_REFUND) {
            $statusClass = 'Hoàn phí';
        }else {
            $statusClass = 'Đang học';
        }

        return $statusClass;
    }

    public function checkHourSectionsChecked($sections, $orderItem)
    {
        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesVNTeacher = 0;

        foreach ($sections as $section) {
            $sectionChecked = Section::find($section);
            $foreignTeacherStartAt = Carbon::parse($sectionChecked->foreign_teacher_from);
            $foreignTeacherEndAt = Carbon::parse($sectionChecked->foreign_teacher_to);
            $minutesForeignTeacher = $foreignTeacherEndAt->diffInMinutes($foreignTeacherStartAt);
            $sumMinutesForeignTeacher += $minutesForeignTeacher;

            $tutorStartAt = Carbon::parse($sectionChecked->tutor_from);
            $tutorEndAt = Carbon::parse($sectionChecked->tutor_to);
            $minutesTutor = $tutorStartAt->diffInMinutes($tutorEndAt);
            $sumMinutesTutor += $minutesTutor;

            $VNTeacherStartAt = Carbon::parse($sectionChecked->vn_teacher_from);
            $VnTeacherEndAt = Carbon::parse($sectionChecked->vn_teacher_to);
            $minutesVNTeacher = $VNTeacherStartAt->diffInMinutes($VnTeacherEndAt);
            $sumMinutesVNTeacher += $minutesVNTeacher;
        }

        if ($sumMinutesVNTeacher > $orderItem->getTotalVnMinutes()) {
            $hoursSection = floor($sumMinutesVNTeacher / 60);
            $minutesSection = $sumMinutesVNTeacher % 60;
            $hoursOrderItem = floor($orderItem->getTotalVnMinutes() / 60);
            $minutesOrderIteam = $orderItem->getTotalVnMinutes() % 60;

            throw new \Exception("Số giờ của giáo viên Việt Nam  (" . $hoursSection  . "Giờ " . $minutesSection . "phút ) lớn hơn số giờ dịch vụ (" . $hoursOrderItem . "Giờ " . $minutesOrderIteam . "phút )");
        }

        if ($sumMinutesForeignTeacher > $orderItem->getTotalForeignMinutes()) {
            $hoursSection = floor($sumMinutesForeignTeacher / 60);
            $minutesSection = $sumMinutesForeignTeacher % 60;
            $hoursOrderItem = floor($orderItem->getTotalForeignMinutes() / 60);
            $minutesOrderIteam = $orderItem->getTotalForeignMinutes() % 60;

            throw new \Exception("Số giờ của giáo viên nước ngoài  (" . $hoursSection  . "Giờ " . $minutesSection . "phút ) lớn hơn số giờ dịch vụ (" . $hoursOrderItem . "Giờ " . $minutesOrderIteam . "phút )");
        }

        if ($sumMinutesTutor > $orderItem->getTotalTutorMinutes()) {
            $hoursSection = floor($sumMinutesTutor / 60);
            $minutesSection = $sumMinutesTutor % 60;
            $hoursOrderItem = floor($orderItem->getTotalTutorMinutes() / 60);
            $minutesOrderIteam = $orderItem->getTotalTutorMinutes() % 60;

            throw new \Exception("Số giờ của Gia sư  (" . $hoursSection  . "Giờ " . $minutesSection . "phút ) lớn hơn số giờ dịch vụ (" . $hoursOrderItem . "Giờ " . $minutesOrderIteam . "phút )");
        }
    }

    public function assignToClassRequestDemo(Course $course, OrderItem $orderItem, $sections)
    {
        // Nghiệo vụ: subject phải giống nhau
        if ($orderItem->subject_id !== $course->subject_id) {
            throw new \Exception("Môn học của lớp học [" . $course->subject->name . "] và hợp đồng [" . $orderItem->subject->name . "] không giống nhau");
        }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Xếp lớp cho học viên đó
            CourseStudent::create([
                'order_item_id' => $orderItem->id,
                'student_id' => $this->id,
                'course_id' => $course->id,
            ]);
            foreach ($sections as $section) {
                StudentSection::create([
                    'section_id' => $section,
                    'student_id' => $this->id,
                    'status' => StudentSection::STATUS_NEW,
                ]);
            }
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function doneReserve($orderItemIds, $reserveStartAt, $reserveEndAt, $reason)
    {
        // Nghiệp vụ: subject phải giống nhau

        // Begin transaction
        DB::beginTransaction();

        try {
            foreach ($orderItemIds as $orderItemId) {
                $orderItem = OrderItem::find($orderItemId);
                $orderItem->status = OrderItem::STATUS_RESERVED;
                $orderItem->save();
                Reserve::create([
                    'student_id' => $this->id,
                    'start_at' => $reserveStartAt,
                    'end_at' => $reserveEndAt,
                    'status' => Reserve::STATUS_ACTIVE,
                    'order_item_id' => $orderItemId,
                    'reason' => $reason,
                ]);
            }
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function chuyenPhi($orderItem, $startAt, $reason, $request)
    {
        // 
        $currentCourses = $this->courses()
            ->whereHas('courseStudents', function ($q) use ($orderItem) {
                $q->where('order_item_id', $orderItem->id);
            });

        // lấy toàn bộ student sections mà học viên đó đang học
        $studentSections = $this->studentSections()->whereHas('section', function ($q) use ($currentCourses, $startAt) {
            $q->whereHas('course', function ($q2) use ($currentCourses) {
                $q2->whereIn('course_id', $currentCourses->pluck('courses.id'));
            })
                ->where('study_date', '>', $startAt);
        });

        // set trang thái là transferred cho toàn bộ student sections
        foreach ($studentSections->get() as $studentSection) {
            $studentSection->setStatusTransferred();
        }
        $orderItem->reason_transfer =  $request->reason;
        $orderItem->status = OrderItem::STATUS_TRANSFER;
        $orderItem->save();

        //
        if (($request->num_of_vn_teacher_sections > 0) && $request->vietnam_teacher_minutes_per_section == 0
        ) {
            throw new \Exception("Chưa nhập đủ thông tin của giáo viên Việt Nam!");
        }

        if (
            ($request->num_of_vn_teacher_sections == 0) && ($request->vietnam_teacher_minutes_per_section > 0)
        ) {
            throw new \Exception("Chưa nhập đủ thông tin của giáo viên Việt Nam!");
        }

        // Foreign teacher
        if (($request->num_of_foreign_teacher_sections > 0) && $request->foreign_teacher_minutes_per_section == 0
        ) {
            throw new \Exception("Chưa nhập đủ thông tin của giáo viên nước ngoài!");
        }

        if (
            $request->num_of_foreign_teacher_sections == 0 && $request->foreign_teacher_minutes_per_section > 0
        ) {
            throw new \Exception("Chưa nhập đủ thông tin của giáo viên nước ngoài!");
        }

        // Tutor
        if (
            $request->num_of_tutor_sections > 0 && $request->tutor_minutes_per_section == 0
        ) {
            throw new \Exception("Chưa nhập đủ thông tin của giáo viên gia sư!");
        }

        if (
            $request->num_of_tutor_sections == 0 && $request->tutor_minutes_per_section > 0
        ) {
            throw new \Exception("Chưa nhập đủ thông tin của gia sư!");
        }

        ////
        $newOrderItem = OrderItem::newDefault();
        $newOrderItem->status =  OrderItem::STATUS_ACTIVE;
        $newOrderItem->order_id = $orderItem->order_id;
        $newOrderItem->type = $orderItem->type;
        $newOrderItem->order_type = $request->order_type;
        $newOrderItem->price = $orderItem->price;
        // $newOrderItem->currency_code = $orderItem->currency_code;
        $newOrderItem->level = $request->level_create_select;
        $newOrderItem->class_type = $request->class_type;
        $newOrderItem->num_of_student = $request->student_nums_input;
        $newOrderItem->study_type = $request->study_type_select;
        $newOrderItem->vietnam_teacher_minutes_per_section = $request->vietnam_teacher_minutes_per_section;
        $newOrderItem->foreign_teacher_minutes_per_section = $request->foreign_teacher_minutes_per_section;
        $newOrderItem->tutor_minutes_per_section = $request->tutor_minutes_per_section;
        $newOrderItem->target = $request->target_input;
        $newOrderItem->home_room = $request->home_room_teacher_select;
        $newOrderItem->apply_time = $orderItem->apply_time;
        $newOrderItem->top_school = $orderItem->top_school;
        $newOrderItem->current_program_id = $orderItem->current_program_id;
        $newOrderItem->std_score = $orderItem->std_score;
        $newOrderItem->eng_score = $orderItem->eng_score;
        $newOrderItem->plan_apply_program_id = $orderItem->plan_apply_program_id;
        $newOrderItem->intended_major_id = $orderItem->intended_major_id;
        $newOrderItem->academic_award_1 = $orderItem->academic_award_1;
        $newOrderItem->academic_award_2 = $orderItem->academic_award_2;
        $newOrderItem->academic_award_3 = $orderItem->academic_award_3;
        $newOrderItem->academic_award_4 = $orderItem->academic_award_4;
        $newOrderItem->academic_award_5 = $orderItem->academic_award_5;
        $newOrderItem->academic_award_6 = $orderItem->academic_award_6;
        $newOrderItem->academic_award_7 = $orderItem->academic_award_7;
        $newOrderItem->academic_award_8 = $orderItem->academic_award_8;
        $newOrderItem->academic_award_9 = $orderItem->academic_award_9;
        $newOrderItem->academic_award_10 = $orderItem->academic_award_10;
        $newOrderItem->academic_award_text_1 = $orderItem->academic_award_text_1;
        $newOrderItem->academic_award_text_2 = $orderItem->academic_award_text_2;
        $newOrderItem->academic_award_text_3 = $orderItem->academic_award_text_3;
        $newOrderItem->academic_award_text_4 = $orderItem->academic_award_text_4;
        $newOrderItem->academic_award_text_5 = $orderItem->academic_award_text_5;
        $newOrderItem->academic_award_text_6 = $orderItem->academic_award_text_6;
        $newOrderItem->academic_award_text_7 = $orderItem->academic_award_text_7;
        $newOrderItem->academic_award_text_8 = $orderItem->academic_award_text_8;
        $newOrderItem->academic_award_text_9 = $orderItem->academic_award_text_9;
        $newOrderItem->academic_award_text_10 = $orderItem->academic_award_text_10;
        $newOrderItem->grade_1 = $orderItem->grade_1;
        $newOrderItem->grade_2 = $orderItem->grade_2;
        $newOrderItem->grade_3 = $orderItem->grade_3;
        $newOrderItem->grade_4 = $orderItem->grade_4;
        $newOrderItem->point_1 = $orderItem->point_1;
        $newOrderItem->point_2 = $orderItem->point_2;
        $newOrderItem->point_3 = $orderItem->point_3;
        $newOrderItem->point_4 = $orderItem->point_4;
        $newOrderItem->postgraduate_plan = $orderItem->postgraduate_plan;
        $newOrderItem->personality = $orderItem->personality;
        $newOrderItem->subject_preference = $orderItem->subject_preference;
        $newOrderItem->language_culture = $orderItem->language_culture;
        $newOrderItem->research_info = $orderItem->research_info;
        $newOrderItem->aim = $orderItem->aim;
        $newOrderItem->essay_writing_skill = $orderItem->essay_writing_skill;
        $newOrderItem->extra_activity_1 = $orderItem->extra_activity_1;
        $newOrderItem->extra_activity_2 = $orderItem->extra_activity_2;
        $newOrderItem->extra_activity_3 = $orderItem->extra_activity_3;
        $newOrderItem->extra_activity_4 = $orderItem->extra_activity_4;
        $newOrderItem->extra_activity_5 = $orderItem->extra_activity_5;
        $newOrderItem->extra_activity_text_1 = $orderItem->extra_activity_text_1;
        $newOrderItem->extra_activity_text_2 = $orderItem->extra_activity_text_2;
        $newOrderItem->extra_activity_text_3 = $orderItem->extra_activity_text_3;
        $newOrderItem->extra_activity_text_4 = $orderItem->extra_activity_text_4;
        $newOrderItem->extra_activity_text_5 = $orderItem->extra_activity_text_5;
        $newOrderItem->personal_countling_need = $orderItem->personal_countling_need;
        $newOrderItem->other_need_note = $orderItem->other_need_note;
        $newOrderItem->parent_job = $orderItem->parent_job;
        $newOrderItem->parent_highest_academic = $orderItem->parent_highest_academic;
        $newOrderItem->is_parent_studied_abroad = $orderItem->is_parent_studied_abroad;
        $newOrderItem->parent_income = $orderItem->parent_income;
        $newOrderItem->parent_familiarity_abroad = $orderItem->parent_familiarity_abroad;
        $newOrderItem->is_parent_family_studied_abroad = $orderItem->is_parent_family_studied_abroad;
        $newOrderItem->parent_time_spend_with_child = $orderItem->parent_time_spend_with_child;
        $newOrderItem->financial_capability = $orderItem->financial_capability;
        $newOrderItem->schedule_items = $orderItem->schedule_items;
        // $newOrderItem->created_at = $orderItem->created_at;
        // $newOrderItem->updated_at = $orderItem->updated_at;
        $newOrderItem->estimated_enrollment_time = $orderItem->estimated_enrollment_time;
        $newOrderItem->subject_id = $request->subject;
        $newOrderItem->num_of_vn_teacher_sections = $request->num_of_vn_teacher_sections;
        $newOrderItem->num_of_foreign_teacher_sections = $request->num_of_foreign_teacher_sections;
        $newOrderItem->num_of_tutor_sections = $request->num_of_tutor_sections;
        $newOrderItem->training_location_id = $request->training_location;
      
        $newOrderItem->transfer_order_item_id =  $orderItem->id;

        if (!empty($request->vn_teacher_price) && is_numeric(str_replace(',', '', $request->vn_teacher_price))) {
            $newOrderItem->vn_teacher_price = floatval(str_replace(',', '', $request->vn_teacher_price));
        } else {
            $newOrderItem->vn_teacher_price = 0;
        }
       
        if (!empty($request->foreign_teacher_price) && is_numeric(str_replace(',', '', $request->foreign_teacher_price))) {
            $newOrderItem->foreign_teacher_price = floatval(str_replace(',', '', $request->foreign_teacher_price));
        } else {
            $newOrderItem->foreign_teacher_price = 0;
        }

        if (!empty($request->tutor_price) && is_numeric(str_replace(',', '', $request->tutor_price))) {
            $newOrderItem->tutor_price = floatval(str_replace(',', '', $request->tutor_price));
        } else {
            $newOrderItem->tutor_price = 0;
        }
       
        // branch_select
        // training_location

        $newOrderItem->save();

        //Cập nhật lại remaider
        $orderItem->orders->updateReminders();
        // $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent($this->order_item_id, $this->student_id);
        // $courseIds = $courseStudents->pluck('course_id')->toArray();

        // // Tạo phiếu chi
        // $errors = $paymentRecord->saveRefundPayment($request);

        // if (!$errors->isEmpty()) {
        //     return $errors;
        // }


        // $sections = collect();

        // foreach ($courseIds as $courseId) {
        //     $sections = $sections->merge(StudentSection::getSectionsRefund($refundRequest->student_id, $courseId, $refundRequest->refund_date));
        // }
        // $sections->each(function ($section) {
        //     $section->setStatusRefund();
        // });

        // // bedign tranction
        // DB::beginTransaction();

        // try {
        //     // 
        // } catch (\Exception $e) {
        //     // Something went wrong, rollback the transaction
        //     DB::rollback();

        //     // Handle the exception or log the error
        //     // For example, you might throw the exception again to let it propagate
        //     throw $e;
        // }

        // // commit
        // DB::commit();
    }

    public function getCode()
    {
        $prefix = 'HS';
        $year = substr($this->code_year, 2, 2);
        $month = sprintf("%02s", $this->code_month);

        if ($this->code_number > 9999) {
            $number = sprintf("%06s", $this->code_number);
        } else {
            $number = sprintf("%04s", $this->code_number);
        }
        
        return "{$prefix}{$year}{$month}{$number}";
    }

    public function doneExitClass($course, $orderItem)
    {
        // Nghiệo vụ: subject phải giống nhau
        // if ($currentCourse->subject_id !== $courseTransfer->subject_id) {
        //     throw new \Exception("Môn học của lớp học hiện tại [" . $currentCourse->subject->name . "] và lớp học chuyển tới [" . $courseTransfer->subject->name . "] không giống nhau");
        // }

        // Begin transaction
        DB::beginTransaction();

        try {

            $studentSections = StudentSection::where('student_id', $this->id)
                ->whereHas('section', function ($query) use ($course) {
                    $query->where('course_id', $course->id)->where('start_at', '>', Carbon::parse(now()));
                })
                ->where('status', '=', StudentSection::STATUS_NEW)
                ->get();
            // Thêm tất cả buổi học cha học của lớp học đó vào student section của học viên

            foreach ($studentSections as $studentSection) {
                $studentSection->setExit();
            }
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function getNotesInDateRange($startDate, $endDate)
    {
        return AccountKpiNote::inDateRangeForContact($this->id, $startDate, $endDate)->get();
    }

    public function scopeAccountKpiNotesInDateRange($query, $startDate, $endDate)
    {
        return $this->accountKpiNotes()
            ->whereBetween('estimated_payment_date', [$startDate, $endDate])->get();
    }

    public function getNotes()
    {
        return AccountKpiNote::where('contact_id', $this->id)->get();
    }

    public function checkExitClass($course)
    {
        $exitClass = $this->studentSections()
            ->where('status', StudentSection::STATUS_EXIT)
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->count();
        if ($exitClass == 0) {
            return true;
        }

        return false;
    }

    public function signedOrStudentOfOrders()
    {
        return Order::where(function ($q) {
            $q->where('contact_id', $this->id)
                ->orWhere('student_id', $this->id);
        });
    }

    public function whichCourseFinish($contactId)
    {
        return Course::whereHas('courseStudents', function ($query) use ($contactId) {
            $query->where('student_id', $contactId);
        })->finished();
    }

    public function calculateTotalCacheForContact()
    {
        return Order::where('contact_id', $this->id)->approved()->sum('cache_total');
    }

    public function calculateReceivedAmount()
    {
        return $this->paymentRecords()
            ->where('type', PaymentRecord::TYPE_RECEIVED)
            ->sum('amount');
    }

    public function calculateRefundAmount()
    {
        return $this->paymentRecords()
            ->where('type', PaymentRecord::TYPE_REFUND)
            ->sum('amount');
    }
    
    public function calculateRemainForContact()
    {
        $totalCache = $this->calculateTotalCacheForContact();
        $receivedAmount = $this->calculateReceivedAmount();

        return $totalCache - $receivedAmount;
    }

    public function getEduOrderItems()
    {
        return OrderItem::whereHas('order', function ($query) {
            $query->where('status', Order::STATUS_APPROVED);
        })->where('type', Order::TYPE_EDU)
            ->whereIn('order_id', $this->orders()->pluck('id'))
            ->get();
    }

    public function scopeEduStudents($query) {
        $query->whereHas('orders', function($q) {
            $q->where('type', Order::TYPE_EDU);
        });
    }

    public function scopeFilterEduStudentsByBranchs($query, $branchs) 
    {
        $query->eduStudents()
              ->whereHas('courseStudents', function($q) use ($branchs) {
                $q->whereHas('course', function($q2) use ($branchs) {
                    $q2->whereHas('TrainingLocation', function ($q3) use ($branchs) {
                        $q3->whereIn('branch', $branchs);
                    });
                });
              });
    }

    public function getAttributesExcel($contactRequest_id,$contact_id ,$name, $email, $phone,$user_account, $address, $source_type,$demand, $country, $district,$city, $school, $efc, $list, $target,$channel,$sub_channel, $campaign, $adset, $ads, $device, $placement, $term, $first_url, $contact_owner, $lifecycle_stage, $lead_status, $pic, $hubspot_id ,$fbcid, $gclid, $birthday, $age, $time_to_call, $ward, $type_match, $last_url, $assigned_at, $status)
    {
        return [
            // 'contactRequest_id' => $contactRequest_id,
            'contact_id' =>  $contact_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'source_type' => $source_type,
            'demand' => $demand,
            'country' => $country,
            'district' => $district,
            'city' => $city,
            'school' => $school,
            'efc' => $efc,
            'list' => $list,
            'target' => $target,
            'channel' => $channel,
            'sub_channel' => $sub_channel,
            'campaign' => $campaign,
            'adset' => $adset,
            'ads' => $ads,
            'device' => $device,
            'placement' => $placement,
            'term' => $term,
            'first_url' => $first_url,
            'contact_owner' => $contact_owner,
            'lifecycle_stage' => $lifecycle_stage,
            'lead_status' => $lead_status,
            'pic' => $pic,
            'hubspot_id' => $hubspot_id,
            'fbcid' => $fbcid,
            'gclid' => $gclid,
            'birthday' => $birthday,
            'age' => $age,
            'time_to_call' => $time_to_call,
            'ward' => $ward,
            'type_match' => $type_match,
            'last_url' => $last_url,
            'assigned_at' => $assigned_at,
            'status' => $status,
        ];
    }
    
    public static function importFromExcelSeeder($contactRequest_id,$contact_id ,$name, $email, $phone, $user_account, $address, $source_type,$demand, $country, $district,$city, $school, $efc, $list, $target,$channel,$sub_channel, $campaign, $adset, $ads, $device, $placement, $term, $first_url, $contact_owner, $lifecycle_stage, $lead_status, $pic, $hubspot_id ,$fbcid, $gclid, $birthday, $age, $time_to_call, $ward, $type_match, $last_url, $assigned_at, $status)
    {
        $contact = self::newDefault();
        $contact->import_id = $contact_id;
        $contact->name = $name;
        $contact->phone = \App\Library\Tool::extractPhoneNumber($phone);
        $contact->email = $email;
        $contact->demand = $demand;
        $contact->school = \App\Helpers\Functions::processVarchar250Input($school);
        $contact->birthday = date('Y-m-d', strtotime($birthday));
        $contact->time_to_call = $time_to_call;
        $contact->country = \App\Helpers\Functions::processVarchar250Input($country);
        $contact->city = \App\Helpers\Functions::processVarchar250Input($city);
        $contact->district = \App\Helpers\Functions::processVarchar250Input($district);
        $contact->ward = \App\Helpers\Functions::processVarchar250Input($ward);
        $contact->address = \App\Helpers\Functions::processVarchar250Input($address);
        $contact->efc = \App\Helpers\Functions::processVarchar250Input($efc);
        $contact->target = \App\Helpers\Functions::processVarchar250Input($target);
        $contact->list = \App\Helpers\Functions::processVarchar250Input($list);
        $contact->source_type = \App\Helpers\Functions::processVarchar250Input($source_type);
        $contact->channel = \App\Helpers\Functions::processVarchar250Input($channel);
        $contact->sub_channel = \App\Helpers\Functions::processVarchar250Input($sub_channel);
        $contact->campaign = \App\Helpers\Functions::processVarchar250Input($campaign);
        $contact->adset = \App\Helpers\Functions::processVarchar250Input($adset);
        $contact->ads = \App\Helpers\Functions::processVarchar250Input($ads);
        $contact->device = \App\Helpers\Functions::processVarchar250Input($device);
        $contact->placement = \App\Helpers\Functions::processVarchar250Input($placement);
        $contact->term = \App\Helpers\Functions::processVarchar250Input($term);
        $contact->type_match = \App\Helpers\Functions::processVarchar250Input($type_match);
        $contact->fbcid = \App\Helpers\Functions::processVarchar250Input($fbcid);
        $contact->gclid = \App\Helpers\Functions::processVarchar250Input($gclid);
        $contact->first_url = \App\Helpers\Functions::processVarchar250Input($first_url);
        $contact->last_url = \App\Helpers\Functions::processVarchar250Input($last_url);
        $contact->contact_owner = \App\Helpers\Functions::processVarchar250Input($contact_owner);
        $contact->lifecycle_stage = \App\Helpers\Functions::processVarchar250Input($lifecycle_stage);
        $contact->lead_status = \App\Helpers\Functions::processVarchar250Input($lead_status);
        $contact->hubspot_id = $hubspot_id;
        $contact->pic = $pic;
        if ($assigned_at) {
            $contact->assigned_at = $assigned_at;
        }
        $contact->status = self::STATUS_ACTIVE;
        $contact->import_id=$contact_id;
        
        $contact->save();

        $contact->generateCode();

        echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công Contact - import_id: " . $contact->import_id . "\n");

        $contactRequest = ContactRequest::where('demand', $demand)->where('contact_id', $contact->id)->first();
        
        if(!$contactRequest){
            $params = $contact->getAttributes();

            $params['added_from'] = self::ADDED_FROM_EXCEL;
            $contact->addContactRequest($params);
            echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công ContactRequest - import_id: " . $contact->import_id . "\n \n");

            return;
        }else{
            echo("  \033[1m\033[33mWARNING\033[0m: Đơn hàng đã tồn tại". $contact->import_id ."\n" );

            return;
        }

        return;
    }
    public static function importContactFromExcelSeeder($contactRequest_id,$contact_id ,$name, $email, $phone, $user_account, $address, $source_type,$demand, $country, $district,$city, $school, $efc, $list, $target,$channel,$sub_channel, $campaign, $adset, $ads, $device, $placement, $term, $first_url, $contact_owner, $lifecycle_stage, $lead_status, $pic, $hubspot_id ,$fbcid, $gclid, $birthday, $age, $time_to_call, $ward, $type_match, $last_url, $assigned_at, $status)
    {
        $contact = self::newDefault();
        $contact->import_id = $contact_id;
        $contact->name = $name;
        $contact->phone = \App\Library\Tool::extractPhoneNumber($phone);
        $contact->email = $email;
        $contact->demand = $demand;
        $contact->school = \App\Helpers\Functions::processVarchar250Input($school);
        $contact->birthday = date('Y-m-d', strtotime($birthday));
        $contact->time_to_call = $time_to_call;
        $contact->country = \App\Helpers\Functions::processVarchar250Input($country);
        $contact->city = \App\Helpers\Functions::processVarchar250Input($city);
        $contact->district = \App\Helpers\Functions::processVarchar250Input($district);
        $contact->ward = \App\Helpers\Functions::processVarchar250Input($ward);
        $contact->address = \App\Helpers\Functions::processVarchar250Input($address);
        $contact->efc = \App\Helpers\Functions::processVarchar250Input($efc);
        $contact->target = \App\Helpers\Functions::processVarchar250Input($target);
        $contact->list = \App\Helpers\Functions::processVarchar250Input($list);
        $contact->source_type = \App\Helpers\Functions::processVarchar250Input($source_type);
        $contact->channel = \App\Helpers\Functions::processVarchar250Input($channel);
        $contact->sub_channel = \App\Helpers\Functions::processVarchar250Input($sub_channel);
        $contact->campaign = \App\Helpers\Functions::processVarchar250Input($campaign);
        $contact->adset = \App\Helpers\Functions::processVarchar250Input($adset);
        $contact->ads = \App\Helpers\Functions::processVarchar250Input($ads);
        $contact->device = \App\Helpers\Functions::processVarchar250Input($device);
        $contact->placement = \App\Helpers\Functions::processVarchar250Input($placement);
        $contact->term = \App\Helpers\Functions::processVarchar250Input($term);
        $contact->type_match = \App\Helpers\Functions::processVarchar250Input($type_match);
        $contact->fbcid = \App\Helpers\Functions::processVarchar250Input($fbcid);
        $contact->gclid = \App\Helpers\Functions::processVarchar250Input($gclid);
        $contact->first_url = \App\Helpers\Functions::processVarchar250Input($first_url);
        $contact->last_url = \App\Helpers\Functions::processVarchar250Input($last_url);
        $contact->contact_owner = \App\Helpers\Functions::processVarchar250Input($contact_owner);
        $contact->lifecycle_stage = \App\Helpers\Functions::processVarchar250Input($lifecycle_stage);
        $contact->lead_status = \App\Helpers\Functions::processVarchar250Input($lead_status);
        $contact->hubspot_id = $hubspot_id;
        $contact->pic = $pic;
        if ($assigned_at) {
            $contact->assigned_at = $assigned_at;
        }
        $contact->status = self::STATUS_ACTIVE;
        $contact->import_id=$contact_id;
        $contact->generateCode();
        $contact->save();

        echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công Contact - import_id: " . $contact->import_id . "\n");

        // $contactRequest = ContactRequest::where('demand', $demand)->where('contact_id', $contact->id)->first();
        
        // if(!$contactRequest){
        //     $params = $contact->getAttributes();

        //     $params['added_from'] = self::ADDED_FROM_EXCEL;
        //     $contact->addContactRequest($params);
        //     echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo mới thành công ContactRequest - import_id: " . $contact->import_id . "\n \n");

        //     return;
        // }else{
        //     echo("  \033[1m\033[33mWARNING\033[0m: Đơn hàng đã tồn tại". $contact->import_id ."\n" );

        //     return;
        // }

        return;
    }

    public function getAbroadApplication()
    {
        return AbroadApplication::where(function ($q) {
            $q->where('contact_id', $this->id);
        });
    }

    public function abroadApplications()
    {
        return $this->hasMany(AbroadApplication::class);
    }

    public function paymentReminders()
    {
        return PaymentReminder::whereIn('order_id', $this->signedOrStudentOfOrders()->pluck('id'));
    }

    public function paymentRemindersOfStudent()
    {
        return PaymentReminder::whereIn('order_id', $this->signedOrStudentOfOrders()->approved()->pluck('id'));
    }

    /**
     * Get all free time section of student
     * 
     * @return array
     */
    // public function getFreeTimeSections(): array
    // {
    //     $result = [];
    //     $contactRequests = $this->contactRequests()->get();
        
    //     foreach($contactRequests as $contactRequest) {
    //         $result = array_merge($result, $contactRequest->getFreeTimeSections());
    //     }

    //     return $result;
    // }
     /**
      * Get the free time sections for the teacher
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

    public function getLast20NoteLogs()
    {
        return $this->noteLogs()->noteLogFromSystem()->orderBy('created_at', 'desc')->limit(20)->get();
    }

    public static function scopeByBranch($query, $branch)
    {
        return $query->whereHas('account', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->where('branch', $branch);
            }
        })->orWhereNull('account_id');
    }
    public function getFreeTimeStudent(): array
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
                          'day_of_week' => $dayOfWeek,
                         'study_date' => $date->format('Y-m-d'),
                         'start_at' => $date->format('Y-m-d') . ' ' . $record->from,
                         'end_at' => $date->format('Y-m-d') . ' ' . $record->to,
                     ];
                 }
             }
         }
 
         return $result;

    }

    public function findOrNewUser()
    {
        $user = User::where('email', '=', $this->email)->first();

        if (!$user) {
            $user = new User([
                'name' => $this->name,
                'email' => $this->email,
                'branch' => $this->account && $this->account->branch ? $this->account->branch : \App\Library\Branch::getDefaultBranch(),
            ]);
        }

        return $user;
    }

    public function saveUserAccountFromRequest($request)
    {
        $user = $this->findOrNewUser();

        $errors = $user->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return [$user, $errors];
        }

        // update contact email address
        $this->email = $user->email;
        $this->save();

        return [$user, collect([])];
    }

    public static function scopeAddedFrom($query, $addedFrom)
    {
        $query->where('contacts.added_from', $addedFrom);
    }

    public function scopeRelatedContactsByPhone($query, $phone)
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
            });
    }

    public function scopeRelatedContactsByPhoneMotherPhoneFatherPhone($query, $phone, $motherPhone, $fatherPhone)
    {
        //
        $query = $query->active();

        // phone exist
        if (!empty(\App\Library\Tool::extractPhoneNumber2($phone))) {
            $phoneLegacy = \App\Library\Tool::extractPhoneNumberLegacy($phone);
            $phoneFormatted  = \App\Library\Tool::extractPhoneNumber2($phone);

            // Chỉ cần trùng số điện thoại là 1 contact
            $query = $query->where(function($q) use ($phone, $phoneLegacy, $phoneFormatted) {
                    $q->where('phone', $phone)
                        ->orWhere('phone', $phoneLegacy)
                        ->orWhere('phone', $phoneFormatted);
                });
        }


        // only have mother phone
        else if (!empty(\App\Library\Tool::extractPhoneNumber2($motherPhone)) && empty(\App\Library\Tool::extractPhoneNumber2($fatherPhone))) {
            $query = $query->byMotherPhone($motherPhone);
        }

        // only have father phone
        else if (empty(\App\Library\Tool::extractPhoneNumber2($motherPhone)) && !empty(\App\Library\Tool::extractPhoneNumber2($fatherPhone))) {
            $query = $query->byFatherPhone($fatherPhone);
        }

        // have both father and mother phone
        else if (!empty(\App\Library\Tool::extractPhoneNumber2($motherPhone)) && !empty(\App\Library\Tool::extractPhoneNumber2($fatherPhone))) {
            $query = $query->where(function($q) use ($motherPhone, $fatherPhone) {
                $q->byFatherPhone($fatherPhone)
                ->orWhere(function($q) use ($motherPhone) {
                    $q->byMotherPhone($motherPhone);
                });
            });

        // not found!
        } else {
            $query = $query->where('id', -1);
        }
    }

    public static function scopeByFatherPhone($query, $phone)
    {
        $phoneLegacy = \App\Library\Tool::extractPhoneNumberLegacy($phone);
        $phoneFormatted  = \App\Library\Tool::extractPhoneNumber2($phone);

        // Chỉ cần trùng số điện thoại là 1 contact
        $query = $query->whereHas('father', function($q) use ($phone, $phoneLegacy, $phoneFormatted) {
            $q->where('phone', $phone)
                ->orWhere('phone', $phoneLegacy)
                ->orWhere('phone', $phoneFormatted);
        });
    }

    public static function scopeByMotherPhone($query, $phone)
    {
        $phoneLegacy = \App\Library\Tool::extractPhoneNumberLegacy($phone);
        $phoneFormatted  = \App\Library\Tool::extractPhoneNumber2($phone);

        // Chỉ cần trùng số điện thoại là 1 contact
        $query = $query->whereHas('mother', function($q) use ($phone, $phoneLegacy, $phoneFormatted) {
            $q->where('phone', $phone)
                ->orWhere('phone', $phoneLegacy)
                ->orWhere('phone', $phoneFormatted);
        });
    }

    public function getContactRequestsHadBeenAssigned()
    {
        $contactRequests = $this->contactRequests->where('account_id', '!=', null)->all();
        return $contactRequests;
    }

    public function getContactRequestsHadBeenAssignedForSale($saleAccount)
    {
        $contactRequests = $this->contactRequests->where('account_id', $saleAccount->id)->all();
        return $contactRequests;
    }

    public function getAllSalesRelatedToAllContactRequestsOfThisContact()
    {
        $contactRequests = $this->getContactRequestsHadBeenAssigned();

        $accountIds = array_map(function($contactRequest) {
            return $contactRequest['account_id'];
        }, $contactRequests);
        
        $uniqAccountIds = array_unique($accountIds);
        $sales = Account::whereIn('id', $uniqAccountIds)->get();

        return $sales;
    }

    public function getLatestSalesperson()
    {
        $lastestRequest = $this->contactRequests()->whereNotNull('account_id')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$lastestRequest) {
            return null;
        }

        return $lastestRequest->account;
    }

    public static function exportStudent($templatePath, $filterStudents)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filterStudents as $student) {
            $demands = $student->contactRequests->pluck('demand')->filter()->toArray();

            $rowData = [
                $student['name'], //Tên học viên
                $student['code'], //Mã học viên
                $student['import_id'], //Mã cũ học viên
                $student['phone'] ? $student->phone  : 'Chưa có số điện thoại',//Điện thoại
                $student['email'] ? $student->email : 'Chưa có email', //Email
                Contact::whichHasCousrse($student->id),  //Lớp học
                $student->whichHaDoesntCousrse($student->id), //Đợi xếp lớp
                $student->getReserveCoursesCount(), // Bảo lưu
                $student->updated_at->format('d/m/Y'), //Ngày cập nhật
                implode(', ', $demands), //Đơn hàng
                $student['school'], //Trường
                $student->getFather() ? $student->getFather()->name : '', //Cha
                $student->getMother() ? $student->getMother()->name : '', //Mẹ
                $student->birthday ? date('d/m/Y', strtotime($student->birthday)) : '', //Ngày sinh
                $student['age'], //Độ tuổi học viên
                $student['country'], //Quốc gia
                $student['city'], //Thành phố
                $student['district'], //Quận/Huyện
                $student['ward'], //Phường
                $student['address'], //Địa chỉ
                $student['list'], //List
                $student->created_at->format('d/m/Y'),
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }
    
    public function assignToAccount($account, $assignedAt=null)
    {
        if (!$assignedAt) {
            $assignedAt = \Carbon\Carbon::now();
        }

        $this->account_id = $account->id;
        $this->assigned_at = $assignedAt ;

        $this->save();
    }

    public static function exportCustomer($templatePath, $filterCustomers)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filterCustomers as $contact) {
            $efcValue  = isset($contact->efc) ? $contact->efc . ' $' : '';
            $content = DB::table('note_logs')
                        ->where('contact_id', $contact->id)
                        ->where('status', 'active')
                        ->where('system_add', 'false')
                        ->orderBy('updated_at', 'desc')
                        ->value('content');
            //
            $fatherInfo = '';
            if ($contact->getFather()) {
                $fatherInfo .= $contact->getFather()->name;
                if ($contact->getFather()->phone) {
                    $fatherInfo .= ' (📱 ' . $contact->getFather()->phone . ')';
                }
                if ($contact->getFather()->email) {
                    $fatherInfo .= ' (📧 ' . $contact->getFather()->email . ')';
                }
            }
            //
            $motherInfo = '';
            if ($contact->getMother()) {
                $motherInfo .= $contact->getMother()->name;
                if ($contact->getMother()->phone) {
                    $motherInfo .= ' (📱 ' . $contact->getMother()->phone . ')';
                }
                if ($contact->getMother()->email) {
                    $motherInfo .= ' (📧 '. $contact->getMother()->email . ')';
                }
            }
            //
            $types = $contact->studentOrders->pluck('type')->filter()->unique()->map(function ($type) {
                return trans('messages.order.type.' . $type);
            });
            //
            $father = $contact->getFather();
            $note_log_father = '';
            if ($father) {
                $note_log_father = DB::table('note_logs')
                    ->where('contact_id', $father->id)
                    ->where('status', 'active') 
                    ->where('system_add','false')
                    ->orderBy('updated_at', 'desc')
                    ->value('content');
            }
            //
            $mother = $contact->getMother();
            $note_log_mother = '';
            if ($mother) {
                $note_log_mother = DB::table('note_logs')
                    ->where('contact_id', $mother->id)
                    ->where('status', 'active') 
                    ->where('system_add','false')
                    ->orderBy('updated_at', 'desc')
                    ->value('content');
            }

            $rowData = [
                $contact->name, // HỌ TÊN HỌC VIÊN
                $contact->code, // MÃ HỌC VIÊN
                $contact->import_id, // MÃ CŨ HỌC VIÊN
                $contact['phone'] ? $contact->phone  : 'Chưa có số điện thoại',//SĐT HỌC VIÊN
                $contact['email'] ? $contact->email : 'Chưa có email', //EMAIL HỌC VIÊN
                $content, //GHI CHÚ CỦA LIÊN HỆ HỌC VIÊN
                $contact->demand, //ĐƠN HÀNG
                $contact->school, //TRƯỜNG HỌC CỦA HỌC VIÊN
                $fatherInfo, //Cha
                $motherInfo, //Mẹ
                $contact->birthday ? date('d/m/Y', strtotime($contact->birthday)) : '', //NGÀY SINH HỌC VIÊN
                $contact->age, //ĐỘ TUỔI HỌC SINH
                $contact->time_to_call, //THỜI GIAN PHÙ HỢP
                $contact->country, //Quốc gia
                $contact->city, //Thành phố
                $contact->district, //Quận/Huyện
                $contact->ward, //Phưòng
                $contact->address, //ĐỊA CHỈ HỌC VIÊN
                $efcValue, //EFC
                $contact->list, //List
                $contact->target, //target
                $contact->pic, // PIC
                $contact->studentOrders->pluck('salesperson.name')->filter()->unique()->implode('<br>') ?? '--', //SALESPERSON
                $contact->studentOrders->pluck('salesperson.accountGroup.manager.name')->filter()->unique()->implode('<br>') ?? '--', //SALE SUP
                $contact->gender ?  trans('messages.contact.gender.' . $contact->gender)  : '--', //Giới tính
                $contact->contactRequests()->pluck('source_type')->filter()->unique()->implode('<br>') ?? '--', // NGUỒN ĐƠN HÀNG
                $types->implode('<br>') ?? '--', //Các dịch vụ đã đăng ký
                $contact->created_at->format('d/m/Y'), //ngày tạo
                $note_log_father, //GHI CHÚ CỦA CHA
                $note_log_mother, //GHI CHÚ CỦA MẸ
                
                // $contact->getFather() ? $contact->getFather()->name : '', //cha
                // $contact->getMother() ? $contact->getMother()->name : '', //mẹ
                // $contact->updated_at->format('d/m/Y'), //ngày cập nhậtS
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public function getSections()
    {
        $sectionStudents = StudentSection::where('student_id', $this->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds);
        
        return $sections;
    }

    public function displayPhoneNumberByUser($user)
    {
        if (!$user->can('viewPhoneNumber', self::class)) {
            return \App\Helpers\Functions::hidePhoneNumber($this->phone);
        } else {
            return $this->phone;
        }
    }

    public function newSoftwareRequest()
    {
        $softwareRequest = new SoftwareRequest();
        $softwareRequest->contact_id = $this->id;
        $softwareRequest->status = SoftwareRequest::STATUS_NEW;
        return $softwareRequest;
    }

    public function saveAndAddSoftwareRequestFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        DB::beginTransaction();

        try {
            $this->save();
        
            $softwareRequest = $this->newSoftwareRequest();
            $softwareRequest->fill([
                'company_name' => $request->input('company_name'),
                'company_size' => $request->input('company_size'),
                'company_branch' => $request->input('company_branch'),
                'line_of_business' => $request->input('line_of_business'),
                'note' => $request->input('note'),
                'status' => SoftwareRequest::STATUS_NEW,
            ]);
            
            $softwareRequest->save();
            $this->save();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra tạo mới contact và software request!'
            ]);
        }

        DB::commit();

        return $validator->errors();
    }
}

