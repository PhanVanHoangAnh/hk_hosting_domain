<?php

namespace App\Library;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Log;
use App\Library\GoogleSheetService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class GoogleSheetHubspotImporter2
{
    public $logger;
    public $sheetId;
    public $lastImportLineKey;
    public $lastImportAtKey;
    public $lastErrorKey;
    public $statusKey;
    public $addFrom;
    public $log;
    public $assignSale;

    public $updateContactRequest;

    public const STATUS_PAUSED = 'paused';
    public const STATUS_ACTIVE = 'active';

    public function __construct($sheetId)
    {
        // sheet id
        $this->sheetId = $sheetId;
        $this->lastImportLineKey = 'google_sheet_last_import_line_' . $this->sheetId;
        $this->lastImportAtKey = 'google_sheet_last_import_at_' . $this->sheetId;
        $this->lastErrorKey = 'google_sheet_last_error_' . $this->sheetId;
        $this->statusKey = 'google_sheet_status_' . $this->sheetId;

        // options
        $this->updateContactRequest = false;
        $this->addFrom = Contact::ADDED_FROM_GOOGLE_SHEET;
        $this->log = 'file';
        $this->assignSale = false;

        // Import logic...
        $logFileName = 'google_sheet_sync_' . $this->sheetId . '.log';
        $logFilePath = storage_path('logs/' . $logFileName);

        // Create a new Logger instance
        $logger = new Logger('google_sheet_sync');
        $logger->pushHandler(new StreamHandler($logFilePath));
        $this->logger = $logger;
    }

    public function logInfo($message)
    {
        if ($this->log == 'console') {
            // echo $message . "\n";
        } else {
            $this->logger->info($message);
        }
    }

    public function logError($message)
    {
        if ($this->log == 'console') {
            // echo $message . "\n";
        } else {
            $this->logger->error($message);
        }
    }

    public static function getAllSheetIds()
    {
        return config('google_sheets');
    }

    public static function getAll()
    {
        $all = collect([]);

        foreach (self::getAllSheetIds() as $sheetId)
        {
            $all->push(new self($sheetId));
        }

        return $all;
    }

    public function setLastImportLine($line)
    {
        \App\Models\Setting::set($this->lastImportLineKey, $line);
    }

    public function getLastImportLine()
    {
        return (int) \App\Models\Setting::get($this->lastImportLineKey, 1);
    }

    public function setLastImportAt($datetime)
    {
        \App\Models\Setting::set($this->lastImportAtKey, $datetime);
    }

    public function getLastImportAt()
    {
        $at = \App\Models\Setting::get($this->lastImportAtKey, null);

        if ($at) {
            return \Carbon\Carbon::parse($at)->timezone('7');
        }
    }

    public function getLastError()
    {
        return \App\Models\Setting::get($this->lastErrorKey, null);
    }

    public function setLastError($error)
    {
        \App\Models\Setting::set($this->lastErrorKey, $error);
    }

    public function resetLineCounter()
    {
        $this->setLastImportLine(1);
        $this->setLastImportAt(null);

        //
        $this->setLastError(null);
    }

    public function setStatus($status)
    {
        \App\Models\Setting::set($this->statusKey, $status);
    }

    public function getStatus()
    {
        return \App\Models\Setting::get($this->statusKey, self::STATUS_PAUSED);
    }

    public function isActive()
    {
        return $this->getStatus() == self::STATUS_ACTIVE;
    }

    public function isPaused()
    {
        return $this->getStatus() == self::STATUS_PAUSED;
    }

    public function start()
    {
        $this->setStatus(self::STATUS_ACTIVE);
    }

    public function pause()
    {
        $this->setStatus(self::STATUS_PAUSED);
    }

    // Đồng bộ contact từ Google Sheet
    public function run($force=false)
    {
        // paused just return
        if ($this->isPaused() && !$force) {
            // logging
            $this->logInfo("PAUSED, DO NOTHING");
            return;
        }

        //
        $this->setLastError(null);

        try {
            // Save last import line
            $lastImportedLine = $this->getLastImportLine();

            // Kết nố với Google Sheet file và lấy data
            $service = new GoogleSheetService($this->sheetId);
            $data = $service->readContactSyncSheet('Sheet1!A'.$lastImportedLine.':Z300000');

            // headers
            $headers = [
                "FormSubmitDate", // A
                "AssignedDate", // B
                "SubChannel", // C
                "School", // D
                "EFC", // E
                "Name", // F
                "PhoneNumber", // G
                "Email", // H
                "Demand", // I
                "CampiagnAdId", // J
                "KeywordAdset", // K
                "AdName", // L
                "Url", // M
                "TF", // N
                "SQL", // O
                "ContactOwner", // P
                "ContactOwner2", // Q
                "SustemJoinConfirmed", // R
                "LeadStatus", // S
                "Note", // T
                "HubSpotId", // U
            ];

            // always skip last import line, just get new rows
            $rows = array_slice($data, 1);

            // count new rows
            $count = count($rows);

            // no new line
            if ($count == 0) {
                // logging
                // $this->logInfo("NOTHING TO IMPORT, LAST LINE: #$lastImportedLine");
                return;
            }
            
            // set next import line
            $this->setLastImportLine($lastImportedLine+$count);
        } catch (\Throwable $e) {
            // logging
            $this->logError("Không thể connect và lấy data từ Google Sheet: " . $e->getMessage());

            //
            $this->setLastError("Không thể connect và lấy data từ Google Sheet: " . $e->getMessage());

            return;
        }
            
        // try {
            // logging
            $this->logInfo("GET DATA FROM LINE #" . ($lastImportedLine+1) . " TO #" . ($lastImportedLine+$count));

            // Start import
            $this->processDatas($headers, $rows);

            // Set last import at
            $this->setLastImportAt(\Carbon\Carbon::now());
        // } catch (\Throwable $e) {
        //     // logging
        //     $this->logError("Không thể xử lý data từ Google Sheet: " . $e->getMessage());

        //     //
        //     $this->setLastError("Không thể xử lý data từ Google Sheet: " . $e->getMessage());
        // }
    }

    // Xử lý datas lấy từ Google Sheet
    public function processDatas($headers, $rows)
    {
        // logging
        $this->logInfo("==== START IMPORT ====");

        // data mapping
        $datas = array_map(function($row) use ($headers) {
            //
            $dateForm = 'Y-m-d H:i';

            // converting
            try {
                $assigned_date = !isset($row[array_search('Name', $headers)]) ? '' : (!empty($row[array_search('AssignedDate', $headers)]) && strtotime($row[array_search('AssignedDate', $headers)]) !== false ?
                    Carbon::createFromFormat($dateForm, $row[array_search('AssignedDate', $headers)])->startOfDay()
                    : null);
            } catch (\Throwable $e) {
                $this->logError("Can not format AssignedDate: " . json_encode($row));
                $assigned_date = '';
            }

            // try {
                $google_form_submit_date = !isset($row[array_search('Name', $headers)]) ? '' : (!empty($row[array_search('FormSubmitDate', $headers)]) && strtotime($row[array_search('FormSubmitDate', $headers)]) !== false ?
                    Carbon::createFromFormat($dateForm, $row[array_search('FormSubmitDate', $headers)])->startOfDay()
                    : null);
            // } catch (\Throwable $e) {
            //     $this->logError("Can not format AssignedDate: " . json_encode($row));
            //     $google_form_submit_date = null;
            // }

            return [
                'name' => !isset($row[array_search('Name', $headers)]) ? '' : 
                    (trim($row[array_search('Name', $headers)] != null ? Functions::processVarchar250Input($row[array_search('Name', $headers)]) : '')),
                'phone' => !isset($row[array_search('PhoneNumber', $headers)]) ? '' :
                    ($row[array_search('PhoneNumber', $headers)] == null ? null : trim(\App\Library\Tool::extractPhoneNumberLegacy(Functions::processVarchar250Input($row[array_search('PhoneNumber', $headers)])))),
                'phone_raw' => !isset($row[array_search('PhoneNumber', $headers)]) ? '' :
                    ($row[array_search('PhoneNumber', $headers)] == null ? null : Functions::processVarchar250Input($row[array_search('PhoneNumber', $headers)])),
                'phone_new' => !isset($row[array_search('PhoneNumber', $headers)]) ? '' :
                    ($row[array_search('PhoneNumber', $headers)] == null ? null : \App\Library\Tool::extractPhoneNumber2(Functions::processVarchar250Input($row[array_search('PhoneNumber', $headers)]))),
                'email' => !isset($row[array_search('Email', $headers)]) ? '' : Functions::processVarchar250Input(trim($row[array_search('Email', $headers)] ?? '')),
                'demand' => !isset($row[array_search('Demand', $headers)]) ? '' : Functions::processVarchar250Input(trim($row[array_search('Demand', $headers)] ?? '')),
                'school' => !isset($row[array_search('School', $headers)]) ? '' : trim($row[array_search('School', $headers)] != null ? Functions::processVarchar250Input($row[array_search('School', $headers)]) : ''),
                'efc' => !isset($row[array_search('EFC', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('EFC', $headers)]),
                'sub_channel' => !isset($row[array_search('SubChannel', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('SubChannel', $headers)]),
                'campaign' => !isset($row[array_search('CampiagnAdId', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('CampiagnAdId', $headers)]),
                'adset' => !isset($row[array_search('KeywordAdset', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('KeywordAdset', $headers)]),
                'ads' => !isset($row[array_search('AdName', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('AdName', $headers)]),
                'last_url' => !isset($row[array_search('Url', $headers)]) ? '' : $row[array_search('Url', $headers)],
                'contact_owner' => !isset($row[array_search('ContactOwner', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('ContactOwner', $headers)]),
                'lead_status' => !isset($row[array_search('LeadStatus', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('LeadStatus', $headers)]),
                'note_sales' => !isset($row[array_search('Note', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('Note', $headers)]),
                'google_form_submit_date' => $google_form_submit_date,
                'assigned_date' => $assigned_date,
                'hubspot_id' => isset($row[array_search('HubSpotId', $headers)]) ? trim($row[array_search('HubSpotId', $headers)]) : null,
            ];
        }, $rows);

        // Vòng lặp tất cả các dòng dữ liệu
        foreach ($datas as $index => $data) {
            // logging
            $this->logInfo("PROCESSING DATA: # {$data['name']} - {$data['phone']} " . json_encode($data));

            // try {
                // import từng dòng dữ liệu
                $this->processData($data, $index);
            // } catch (\Throwable $e) {
            //     // logging
            //     $this->logError($e->getMessage());

            //     //
            //     $this->setLastError("Lỗi: " . $e->getMessage());
            // }
        }
    }

    // Xử lý từng dòng data lấy từ Google Sheet
    public function processData($data, $index)
    {
        // Nếu Google Sheet là dữ liệu excel
        if ($this->addFrom == Contact::ADDED_FROM_EXCEL) {
            // Google Sheet: phone và 
            if (empty($data['phone'])) {
                // logging
                $this->logInfo("PHONE MISSING=> ignore. " . json_encode($data));

                return;
            }
        }

        else if ($this->addFrom == Contact::ADDED_FROM_HUBSPOT) {
            // Google Sheet: phone và 
            if (empty($data['phone'])) {
                // logging
                $this->logInfo("PHONE MISSING => ignore. " . json_encode($data));

                return;
            }
        }

        else {
            // Google Sheet: phone và 
            if (empty($data['phone']) && empty($data['email'])) {
                // logging
                $this->logInfo("PHONE & EMAIL MISSING => ignore. " . json_encode($data));

                return;
            }
        }
            

        // Kiểm tra có contact nào trùng số phone không
        $contact = Contact::active()
            ->relatedContactsByPhoneAndDemandAndSubChannel($data['phone_raw'])
            ->first();

        // Chưa có contact trùng phone thì tạo mới contact
        if (!$contact) {
            if ($this->log == 'console') {
                echo "$index : new : " .\Illuminate\Support\Str::limit(json_encode([
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'note_sales' => $data['note_sales'],
                ]), 100). "\n";
            }

            // logging
            $this->logInfo("NEW CONTACT => create contact {$data['name']} - {$data['phone']}");

            // New default contact
            $contact = Contact::newDefault();
            $contact->added_from = $this->addFrom;
            $contact->google_sheet_id = $this->sheetId;
        } else {
            if ($this->log == 'console') {
                echo "$index : exists : " .\Illuminate\Support\Str::limit(json_encode([
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'note_sales' => $data['note_sales'],
                ]), 100). "\n";
            }

            // logging
            $this->logInfo("EXIST CONTACT => create contact {$data['name']} - {$data['phone']}");
        }

        // Fill from data
        $contact->name = $data['name'];
        $contact->phone = $data['phone'] == null ? null : \App\Library\Tool::extractPhoneNumberLegacy($data['phone']);
        $contact->email = $data['email'];
        $contact->demand = $data['demand'];
        $contact->school = $data['school'];
        $contact->efc = $data['efc'];
        $contact->sub_channel = $data['sub_channel'];
        $contact->campaign = $data['campaign'];
        $contact->ads = $data['ads'];
        $contact->adset = $data['adset'];
        $contact->last_url = $data['last_url'] ??  '';
        $contact->contact_owner = $data['contact_owner'];
        $contact->lead_status = $data['lead_status'];
        $contact->note_sales = $data['note_sales'];
        $contact->google_form_submit_date = $data['google_form_submit_date'];
        $contact->hubspot_id = $data['hubspot_id'];
        $contact->latest_activity_date = $data['google_form_submit_date'];

        // url cols
        $urlParams = Functions::getParamsFromUrl($contact->last_url);

        // source_type-channel by sub-channel
        if ($contact->sub_channel) {
            try {
                $contact->channel = Functions::getChannelBySubChannel($contact->sub_channel)['channel'];
                $contact->source_type = Functions::getChannelBySubChannel($contact->sub_channel)['source_type'];
            } catch (\Throwable $e) {
                // logging
                $this->logError("CAN NOT FIND SOURCE_TYPE/CHANNEL FROM SUB-CHANNEL $contact->sub_channel: " . $e->getMessage() . " ==> skipped #{$data['name']} - {$data['phone']}");
            }
        }

        $contact->save();

        // Kiểm tra contact request đã có trong db chưa
        $contactRequest = $contact->contactRequests()->active()
            ->relatedContactsByPhoneAndDemandAndSubChannel($data['phone_raw'], $data['demand'])
            ->first();
        
        // Nếu chưa có request thì tạo mới
        if(!$contactRequest){
            if ($this->log == 'console') {
                echo "$index : c new : " .\Illuminate\Support\Str::limit(json_encode([
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'note_sales' => $data['note_sales'],
                ]), 100). "\n";
            }

            // Tạo contact request cho contact
            $contactRequest = $contact->addContactRequest(array_merge($contact->getAttributes(), [
                'added_from' => $this->addFrom,
                'google_sheet_id' => $this->sheetId,
            ]));

            if ($this->assignSale) {
                // KHÔNG CẦN BÀN GIAO. COMMENT KHÚC CHECK ACCOUNT & ASSIGN
                // Kiểm tra xem có account nào cùng tên với trong google sheet cột contact_owner
                $account = Account::where('name', $contactRequest->contact_owner)->first();

                // Nếu không tìm thấy account thì không làm gì hết
                if (!$account) {
                    // logging
                    $this->logInfo("CONTACT OWNER NOT FOUND ==> do nothing #{$contactRequest->contact_owner}");
                }
                
                // Nếu tìm thấy account thì assign contact request mới cho account đó luôn
                else {
                    // logging
                    $this->logInfo("CONTACT OWNER FOUND ==> assign request #{$data['name']} - {$data['phone']} to #{$contactRequest->contact_owner}");

                    // assign to account
                    $contactRequest->assignToAccount($account, $data['assigned_date']);

                    // event
                    // \App\Events\SingleContactRequestAssigned::dispatch($account, $contactRequest, User::getSystemUser());
                }
            }

            // logging
            $this->logInfo("NEW REQUEST ==> add new one for #{$data['name']} - {$data['phone']}");
        }
        
        // Nếu có request trong db rồi thì update
        else {
            if ($this->log == 'console') {
                echo "$index : c exist : " .\Illuminate\Support\Str::limit(json_encode([
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'note_sales' => $data['note_sales'],
                ]), 100). "\n";
            }

            // nếu option update lại contact request
            if ($this->updateContactRequest) {
                // Fill from data
                $contactRequest->name = $data['name'];
                $contactRequest->phone = $data['phone'] == null ? null : \App\Library\Tool::extractPhoneNumberLegacy($data['phone']);
                $contactRequest->email = $data['email'];
                $contactRequest->demand = $data['demand'];
                $contactRequest->school = $data['school'];
                $contactRequest->efc = $data['efc'];
                $contactRequest->sub_channel = $data['sub_channel'];
                $contactRequest->campaign = $data['campaign'];
                $contactRequest->ads = $data['ads'];
                $contactRequest->adset = $data['adset'];
                $contactRequest->last_url = $data['last_url'] ??  '';
                $contactRequest->contact_owner = $data['contact_owner'];
                $contactRequest->lead_status = $data['lead_status'];
                $contactRequest->note_sales = $data['note_sales'];
                $contactRequest->google_form_submit_date = $data['google_form_submit_date'];
                $contactRequest->hubspot_id = $data['hubspot_id'];
                
                // source_type-channel by sub-channel
                if ($contactRequest->sub_channel) {
                    try {
                        $contactRequest->channel = Functions::getChannelBySubChannel($contactRequest->sub_channel)['channel'];
                        $contactRequest->source_type = Functions::getChannelBySubChannel($contactRequest->sub_channel)['source_type'];
                    } catch (\Throwable $e) {
                        // logging
                        $this->logError("CAN NOT FIND SOURCE_TYPE/CHANNEL FROM SUB-CHANNEL $contactRequest->sub_channel: " . $e->getMessage() . " ==> skipped #{$data['name']} - {$data['phone']}");
                    }
                }

                $contactRequest->save();
            

                // logging
                $this->logInfo("EXIST REQUEST ==> updated #{$data['name']} - {$data['phone']}");
            } else {
                // logging
                $this->logInfo("EXIST REQUEST ==> ignore #{$data['name']} - {$data['phone']}");
            }
        }
    }
}

