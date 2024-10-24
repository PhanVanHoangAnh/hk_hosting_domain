<?php

namespace App\Library;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use App\Helpers\Functions;
use App\Library\GoogleSheetService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class SalespersonUpdater
{
    public $logger;
    public $sheetId;
    public $lastImportLineKey;
    public $lastImportAtKey;
    public $lastErrorKey;
    public $statusKey;
    public $nameKey;
    public $addFrom;
    public $log;
    public $assignSale;
    public $dateFormat;
    public $service;

    public $updateContactRequest;

    public const STATUS_PAUSED = 'paused';
    public const STATUS_ACTIVE = 'active';

    public function __construct($sheetId, $dateFormat = 'Y-m-d H:i:s')
    {
        // sheet id
        $this->sheetId = $sheetId;
        $this->lastImportLineKey = 'google_sheet_last_import_line_' . $this->sheetId;
        $this->lastImportAtKey = 'google_sheet_last_import_at_' . $this->sheetId;
        $this->lastErrorKey = 'google_sheet_last_error_' . $this->sheetId;
        $this->statusKey = 'google_sheet_status_' . $this->sheetId;
        $this->nameKey = 'google_sheet_name_' . $this->sheetId;

        // options
        $this->updateContactRequest = false;
        $this->addFrom = Contact::ADDED_FROM_GOOGLE_SHEET;
        $this->log = 'file';
        $this->assignSale = false;

        // service
        $this->service = new GoogleSheetService($this->sheetId);

        if ($dateFormat) {
            $this->dateFormat = $dateFormat;
        }

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
            echo $message . "\n";
        } else {
            $this->logger->info($message);
        }
    }

    public function logError($message)
    {
        if ($this->log == 'console') {
            echo "ERROR!!!!! " . $message . "\n";
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

        foreach (self::getAllSheetIds() as $sheet) {
            $all->push(new self($sheet['sheet_id'], $sheet['date_format']));
        }

        return $all;
    }

    public static function find($id)
    {
        foreach (self::getAll() as $importer) {
            if ($importer->sheetId == $id) {
                return $importer;
            }
        }

        return null;
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

    public function getName()
    {
        return \App\Models\Setting::get($this->nameKey, null);
    }

    public function setName($name)
    {
        \App\Models\Setting::set($this->nameKey, $name);
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

    public function getRowLog($row)
    {
        $data = [
            'phone' => $row['phone_new'] ?? '',
            'demand' => $row['demand'] ?? '',
            'sub_channel' => $row['sub_channel'] ?? '',
            'date' => $row['google_form_submit_date'] ?? '',
            'name' => $row['name'] ?? '',
        ];

        return "phone: #{$data['phone']}, demand: #{$data['demand']}, sub_channel: #{$data['sub_channel']}, date: #{$data['date']}, name: #{$data['name']}";
    }

    // Đồng bộ contact từ Google Sheet
    public function run($force = false)
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

            // update name
            $this->setName($this->service->getName());

            // Kết nố với Google Sheet file và lấy data
            $data = $this->service->readContactSyncSheet('Sheet1!A' . $lastImportedLine . ':AZ300000');

            // headers
            $headers = [
                "FormSubmitDate", // A
                "AssignedDate", // B
                "sub_channel", // C
                "School", // D
                "EFC", // E
                "name", // F
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

                "age", // U
                "time_to_call", // V
                "country", // W
                "city", // X
                "ward", // Y
                "district", // Z
                "address", // AA
                "target", // AB
                "list", // AC
                "source_type", // AD
                "channel", // AE
                "sub_channel2", // AF
                "placement", // AG
                "term", // AH
                "type_match", // AI
                "fbcid", // AJ
                "gclid", // AK
                "lifecycle_stage", // AL
                'EFC', // AM
                'SystemID', // AN
                'FatherPhone', // AO
                'MotherPhone', // AP
                'FatherName', // AQ
                'MotherName', // AR
                'birthday', // AS
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
            $this->setLastImportLine($lastImportedLine + $count);
        } catch (\Throwable $e) {
            // logging
            $this->logError("Không thể connect và lấy data từ Google Sheet: " . $e->getMessage());

            //
            $this->setLastError("Không thể connect và lấy data từ Google Sheet: " . $e->getMessage());

            return;
        }

        // try {
            // logging
            $this->logInfo("GET DATA FROM LINE #" . ($lastImportedLine + 1) . " TO #" . ($lastImportedLine + $count));

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
        $datas = array_map(function ($row) use ($headers) {
            //
            $dateFormat =  $this->dateFormat;

            // converting
            try {
                $assigned_date = !isset($row[array_search('AssignedDate', $headers)]) ? '' : (!empty($row[array_search('AssignedDate', $headers)]) ?
                    Carbon::createFromFormat($dateFormat, $row[array_search('AssignedDate', $headers)])
                    : null);
            } catch (\Throwable $e) {
                $this->logError("Can not format AssignedDate: ". $this->getRowLog($row));
                $assigned_date = null;
            }

            // Get date
            try {
                $google_form_submit_date = Carbon::createFromFormat($dateFormat, $row[array_search('FormSubmitDate', $headers)]);
            } catch (\Throwable $e) {
                try {
                    $google_form_submit_date = !isset($row[array_search('FormSubmitDate', $headers)]) ? null : Carbon::createFromFormat('d/m/Y', $row[array_search('FormSubmitDate', $headers)]);
                } catch (\Throwable $e) {
                    $this->logError("Can not format FormSubmitDate: ". $this->getRowLog($row));
                    $google_form_submit_date = \Carbon\Carbon::parse('2000-01-01');
                }
            }

            // Birthday
            try {
                $birthday = !isset($row[array_search('birthday', $headers)]) ? null : (!empty($row[array_search('birthday', $headers)]) ?
                    Carbon::createFromFormat($dateFormat, $row[array_search('birthday', $headers)])
                    : null);
            } catch (\Throwable $e) {
                $this->logError("Can not format birthday: ". $this->getRowLog($row));
                $birthday = null;
            }

            return [
                'name' => !isset($row[array_search('name', $headers)]) ? '' : (trim($row[array_search('name', $headers)] != null ? Functions::processVarchar250Input($row[array_search('name', $headers)]) : '')),
                'phone' => !isset($row[array_search('PhoneNumber', $headers)]) ? '' : ($row[array_search('PhoneNumber', $headers)] == null ? null : trim(\App\Library\Tool::extractPhoneNumberLegacy(Functions::processVarchar250Input($row[array_search('PhoneNumber', $headers)])))),
                'phone_raw' => !isset($row[array_search('PhoneNumber', $headers)]) ? '' : ($row[array_search('PhoneNumber', $headers)] == null ? null : Functions::processVarchar250Input($row[array_search('PhoneNumber', $headers)])),
                'phone_new' => !isset($row[array_search('PhoneNumber', $headers)]) ? '' : ($row[array_search('PhoneNumber', $headers)] == null ? null : \App\Library\Tool::extractPhoneNumber2(Functions::processVarchar250Input($row[array_search('PhoneNumber', $headers)]))),
                'email' => !isset($row[array_search('Email', $headers)]) ? '' : Functions::processVarchar250Input(trim($row[array_search('Email', $headers)] ?? '')),
                'demand' => !isset($row[array_search('Demand', $headers)]) ? '' : Functions::processVarchar250Input(trim($row[array_search('Demand', $headers)] ?? '')),
                'school' => !isset($row[array_search('School', $headers)]) ? '' : trim($row[array_search('School', $headers)] != null ? Functions::processVarchar250Input($row[array_search('School', $headers)]) : ''),
                'efc' => !isset($row[array_search('EFC', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('EFC', $headers)]),
                'sub_channel' => !isset($row[array_search('sub_channel', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('sub_channel', $headers)]),
                'campaign' => !isset($row[array_search('CampiagnAdId', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('CampiagnAdId', $headers)]),
                'adset' => !isset($row[array_search('KeywordAdset', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('KeywordAdset', $headers)]),
                'ads' => !isset($row[array_search('AdName', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('AdName', $headers)]),
                'last_url' => !isset($row[array_search('Url', $headers)]) ? '' : $row[array_search('Url', $headers)],
                'contact_owner' => !isset($row[array_search('ContactOwner', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('ContactOwner', $headers)]),
                'lead_status' => !isset($row[array_search('LeadStatus', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('LeadStatus', $headers)]),
                'note_sales' => !isset($row[array_search('Note', $headers)]) ? '' : Functions::processVarchar250Input($row[array_search('Note', $headers)]),

                'age' => !isset($row[array_search('age', $headers)]) ? '' : 
                    (trim($row[array_search('age', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('age', $headers)]) : '')
                    ),
                'time_to_call' => !isset($row[array_search('time_to_call', $headers)]) ? '' : 
                    (trim($row[array_search('time_to_call', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('time_to_call', $headers)]) : '')
                    ),
                'country' => !isset($row[array_search('country', $headers)]) ? '' : 
                    (trim($row[array_search('country', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('country', $headers)]) : '')
                    ),
                'city' => !isset($row[array_search('city', $headers)]) ? '' : 
                    (trim($row[array_search('city', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('city', $headers)]) : '')
                    ),
                'ward' => !isset($row[array_search('ward', $headers)]) ? '' : 
                    (trim($row[array_search('ward', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('ward', $headers)]) : '')
                    ),
                'address' => !isset($row[array_search('address', $headers)]) ? '' : 
                    (trim($row[array_search('address', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('address', $headers)]) : '')
                    ),
                'target' => !isset($row[array_search('target', $headers)]) ? '' : 
                    (trim($row[array_search('target', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('target', $headers)]) : '')
                    ),
                'list' => !isset($row[array_search('list', $headers)]) ? '' : 
                    (trim($row[array_search('list', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('list', $headers)]) : '')
                    ),
                'source_type' => !isset($row[array_search('source_type', $headers)]) ? '' : 
                    (trim($row[array_search('source_type', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('source_type', $headers)]) : '')
                    ),
                'channel' => !isset($row[array_search('channel', $headers)]) ? '' : 
                    (trim($row[array_search('channel', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('channel', $headers)]) : '')
                    ),
                'placement' => !isset($row[array_search('placement', $headers)]) ? '' : 
                    (trim($row[array_search('placement', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('placement', $headers)]) : '')
                    ),
                'term' => !isset($row[array_search('term', $headers)]) ? '' : 
                    (trim($row[array_search('term', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('term', $headers)]) : '')
                    ),
                'type_match' => !isset($row[array_search('type_match', $headers)]) ? '' : 
                    (trim($row[array_search('type_match', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('type_match', $headers)]) : '')
                    ),
                'fbcid' => !isset($row[array_search('fbcid', $headers)]) ? '' : 
                    (trim($row[array_search('fbcid', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('fbcid', $headers)]) : '')
                    ),
                'gclid' => !isset($row[array_search('gclid', $headers)]) ? '' : 
                    (trim($row[array_search('gclid', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('gclid', $headers)]) : '')
                    ),
                'lifecycle_stage' => !isset($row[array_search('lifecycle_stage', $headers)]) ? '' : 
                    (trim($row[array_search('lifecycle_stage', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('lifecycle_stage', $headers)]) : '')
                    ),
                'EFC' => !isset($row[array_search('EFC', $headers)]) ? '' : 
                    (trim($row[array_search('EFC', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('EFC', $headers)]) : '')
                    ),
                'SystemID' => !isset($row[array_search('SystemID', $headers)]) ? '' : 
                    (trim($row[array_search('SystemID', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('SystemID', $headers)]) : '')
                    ), // AN
                'FatherPhone' => !isset($row[array_search('FatherPhone', $headers)]) ? '' : ($row[array_search('FatherPhone', $headers)] == null ? null : \App\Library\Tool::extractPhoneNumber(Functions::processVarchar250Input($row[array_search('FatherPhone', $headers)]))),
                'MotherPhone' => !isset($row[array_search('MotherPhone', $headers)]) ? '' : ($row[array_search('MotherPhone', $headers)] == null ? null : \App\Library\Tool::extractPhoneNumber(Functions::processVarchar250Input($row[array_search('MotherPhone', $headers)]))),
                'FatherName' => !isset($row[array_search('FatherName', $headers)]) ? '' : 
                    (trim($row[array_search('FatherName', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('FatherName', $headers)]) : '')
                    ), // AQ
                'MotherName' => !isset($row[array_search('MotherName', $headers)]) ? '' : 
                    (trim($row[array_search('MotherName', $headers)] != null ?
                        Functions::processVarchar250Input($row[array_search('MotherName', $headers)]) : '')
                    ), // AR
                'birthday' => $birthday,

                'google_form_submit_date' => $google_form_submit_date,
                'assigned_date' => $assigned_date,
            ];
        }, $rows);

        // Vòng lặp tất cả các dòng dữ liệu
        foreach ($datas as $index => $data) {
            // logging
            $this->logInfo("\n\nPROCESSING DATA: " . $this->getRowLog($data));

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
        if ($this->log == 'console') {
            $this->logInfo("## $index : {$this->sheetId}");
        }

        // Google Sheet: phone và 
        if (empty($data['phone'])) {
            // logging
            $this->logInfo("PHONE MISSING=> ignore. " . $this->getRowLog($data));

            return;
        }

        // Create/Update contact
        list($contact, $isNew) = $this->createUpdateContact($data);

        // update created_at if contact is new
        if ($isNew) {
            if ($data['google_form_submit_date']) {
                $contact->created_at = $data['google_form_submit_date'];
                $contact->updated_at = $data['google_form_submit_date'];
                $contact->save();
            }
        }
        
        // multi demands
        if (strpos($data['demand'], ';') !== false) {
            $demands = $this->getDemandsFromString($data['demand']);
            
            foreach ($demands as $demand) {
                $data['demand'] = $demand;
                
                //
                $this->createUpdateContactRequest($contact, $data);
            }
        }
        
        // Single demand
        else {
            $this->createUpdateContactRequest($contact, $data);
        }

        // Kiểm tra contact request đã có trong db chưa
        
    }

    public function createUpdateContact($data)
    {
        // Mother
        $mother = null;
        if (isset($data['MotherPhone']) && strlen(trim($data['MotherPhone'])) > 3) {
            // logging
            $this->logInfo("HAS MOTHER => process mother {$data['MotherPhone']} - {$data['MotherName']}");

            list($mother, $newMother) = $this->createUpdateContact([
                'name' => $data['MotherName'],
                'phone' => $data['MotherPhone'],
                'phone_raw' => $data['MotherPhone'],
                'phone_new' => $data['MotherPhone'],
                'email' => null,
                'demand' => null,
                'school' => null,
                'efc' => null,
                'sub_channel' => $data['sub_channel'],
                'campaign' => null,
                'adset' => null,
                'ads' => null,
                'last_url' => null,
                'contact_owner' => null,
                'lead_status' => null,
                'note_sales' => null,

                'age' => null,
                'time_to_call' => null,
                'country' => null,
                'city' => null,
                'ward' => null,
                'address' => null,
                'target' => null,
                'list' => null,
                'source_type' => $data['source_type'],
                'channel' => $data['channel'],
                'placement' => null,
                'term' => null,
                'type_match' => null,
                'fbcid' => null,
                'gclid' => null,
                'lifecycle_stage' => null,
                'EFC' => null,
                'SystemID' => null,
                'FatherPhone' => null,
                'MotherPhone' => null,
                'FatherName' => null,
                'MotherName' => null,
                'birthday' => null,

                'google_form_submit_date' => $data['google_form_submit_date'],
                'assigned_date' => null,
            ]);
        }

        // Father
        $father = null;
        if (isset($data['FatherPhone']) && strlen(trim($data['FatherPhone'])) > 3) {
            // logging
            $this->logInfo("HAS FATHER => process father {$data['FatherPhone']} - {$data['FatherName']}");

            list($father, $newFather) = $this->createUpdateContact([
                'name' => $data['FatherName'],
                'phone' => $data['FatherPhone'],
                'phone_raw' => $data['FatherPhone'],
                'phone_new' => $data['FatherPhone'],
                'email' => null,
                'demand' => null,
                'school' => null,
                'efc' => null,
                'sub_channel' => $data['sub_channel'],
                'campaign' => null,
                'adset' => null,
                'ads' => null,
                'last_url' => null,
                'contact_owner' => null,
                'lead_status' => null,
                'note_sales' => null,

                'age' => null,
                'time_to_call' => null,
                'country' => null,
                'city' => null,
                'ward' => null,
                'address' => null,
                'target' => null,
                'list' => null,
                'source_type' => $data['source_type'],
                'channel' => $data['channel'],
                'placement' => null,
                'term' => null,
                'type_match' => null,
                'fbcid' => null,
                'gclid' => null,
                'lifecycle_stage' => null,
                'EFC' => null,
                'SystemID' => null,
                'FatherPhone' => null,
                'MotherPhone' => null,
                'FatherName' => null,
                'MotherName' => null,
                'birthday' => null,

                'google_form_submit_date' => $data['google_form_submit_date'],
                'assigned_date' => null,
            ]);
        }

        // Kiểm tra có contact nào trùng số phone không
        $contact = Contact::active()
            ->relatedContactsByPhone($data['phone_raw'])
            ->first();

        // Chưa có contact trùng phone thì tạo mới contact
        if (!$contact) {
            // logging
            $this->logInfo("NEW CONTACT => create contact " . $this->getRowLog($data));

            // New default contact
            $contact = Contact::newDefault();
            $contact->added_from = $this->addFrom;
            $contact->google_sheet_id = $this->sheetId;

            $isNew = true;
        } else {
            // logging
            $this->logInfo("EXIST CONTACT => get contact " . $this->getRowLog($data));

            $isNew = true;
        }

        // Fill from data
        $contact->name = $data['name'];
        $contact->phone = $data['phone_new'];
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
        $contact->lead_status = \App\Helpers\Functions::leadStatusMapping($data['lead_status']);
        $contact->note_sales = $data['note_sales'];

        $contact->age = $data['age'];
        $contact->time_to_call = $data['time_to_call'];
        $contact->country = $data['country'];
        $contact->city = $data['city'];
        $contact->ward = $data['ward'];
        $contact->address = $data['address'];
        $contact->target = $data['target'];
        $contact->list = $data['list'];
        $contact->source_type = $data['source_type'];
        $contact->channel = $data['channel'];
        $contact->placement = $data['placement'];
        $contact->term = $data['term'];
        $contact->type_match = $data['type_match'];
        $contact->fbcid = $data['fbcid'];
        $contact->gclid = $data['gclid'];
        $contact->lifecycle_stage = $data['lifecycle_stage'];

        $contact->birthday = $data['birthday'];

        $contact->google_form_submit_date = $data['google_form_submit_date'];
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

        // mother
        if ($mother) {
            $contact->mother_id = $mother->id;
        }

        // father
        if ($father) {
            $contact->father_id = $father->id;
        }

        $contact->save();

        // generate code
        if (!$contact->code) {
            $contact->generateCode();
        }

        return [$contact, $isNew];
    }

    public function createUpdateContactRequest($contact, $data)
    {
        $contactRequest = \App\Models\ContactRequest::active()
            ->relatedContactsByPhoneAndDemandAndSubChannel($data['phone_raw'], $data['demand'], $data['sub_channel'])
            ->first();

        // Nếu chưa có request thì tạo mới
        if (!$contactRequest) {
            // logging
            $this->logInfo("NEW REQUEST ==> add new one : " . $this->getRowLog($data));
            
            // Tạo contact request cho contact
            $contactRequest = $contact->addContactRequest(array_merge($contact->getAttributes(), [
                'added_from' => $this->addFrom,
                'google_sheet_id' => $this->sheetId,
                'demand' => $data['demand'], // multi demands case
            ]));

            // bàn giao nhân viên sale
            if ($data['contact_owner']) {
                $this->assignSalespersonFromRaw($contactRequest, $data['contact_owner'], $data['assigned_date']);
            }

            // Trường hợp không có contact_owner thì tìm latest salesperson
            else {
                // chưa có account thì try to find the latest salesperson
                if (!$contactRequest->account) {
                    $this->logInfo("NO CONTACT_OWNER ==> TRY TO FIND LATEST SALESPERSON");
                    $latestSalesperson = $contact->getLatestSalesperson();
                    
                    if ($latestSalesperson) {
                        // log
                        $this->logInfo("LATEST SALESPERSON FOUND ==> assign to #{$latestSalesperson->name}");

                        // assign to latest salesperson
                        $this->assignAccount($contactRequest, $latestSalesperson, $data['assigned_date']);
                    }

                    else {
                        // log
                        $this->logInfo("LATEST SALESPERSON NOT FOUND ==> do nothing");
                    }
                } else {
                    $this->logInfo("ACCOUNT ASSIGNED BEFORE ==> do nothing : CURRENT => #{$contactRequest->account->name}");
                }
            }

            // update created_at
            if ($data['google_form_submit_date']) {
                $contactRequest->created_at = $data['google_form_submit_date'];
                $contactRequest->updated_at = $data['google_form_submit_date'];
                $contactRequest->save();
            }
        }

        // Nếu có request trong db rồi thì update
        else {
            // nếu option update lại contact request
            if ($this->updateContactRequest) {
                // logging
                $this->logInfo("EXIST REQUEST ==> updated : " . $this->getRowLog($data));

                $contactRequest->google_form_submit_date = $data['google_form_submit_date'];
                $contactRequest->latest_activity_date = $data['google_form_submit_date'];
                $contactRequest->added_from = $this->addFrom;

                // Fill from data
                if (!$contactRequest->name) {
                    $contactRequest->name = $data['name'];
                }
                if (!$contactRequest->phone) {
                    $contactRequest->phone = $data['phone_new'];
                }
                if (!$contactRequest->email) {
                    $contactRequest->email = $data['email'];
                }
                if (!$contactRequest->demand) {
                    $contactRequest->demand = $data['demand'];
                }
                if (!$contactRequest->school) {
                    $contactRequest->school = $data['school'];
                }
                if (!$contactRequest->efc) {
                    $contactRequest->efc = $data['efc'];
                }
                if (!$contactRequest->sub_channel) {
                    $contactRequest->sub_channel = $data['sub_channel'];
                } else {
                    $contactRequest->latest_sub_channel = $data['sub_channel'];
                }
                if (!$contactRequest->campaign) {
                    $contactRequest->campaign = $data['campaign'];
                }
                if (!$contactRequest->ads) {
                    $contactRequest->ads = $data['ads'];
                }
                if (!$contactRequest->last_url) {
                    $contactRequest->last_url = $data['last_url'];
                }
                if (!$contactRequest->adset) {
                    $contactRequest->adset = $data['adset'];
                }
                if (!$contactRequest->contact_owner) {
                    $contactRequest->contact_owner = $data['contact_owner'];
                }
                if (!$contactRequest->lead_status) {
                    $contactRequest->lead_status = \App\Helpers\Functions::leadStatusMapping($data['lead_status']);
                }
                if (!$contactRequest->note_sales) {
                    $contactRequest->note_sales = $data['note_sales'];
                }
                if (!$contactRequest->age) {
                    $contactRequest->age = $data['age'];
                }
                if (!$contactRequest->time_to_call) {
                    $contactRequest->time_to_call = $data['time_to_call'];
                }
                if (!$contactRequest->country) {
                    $contactRequest->country = $data['country'];
                }
                if (!$contactRequest->city) {
                    $contactRequest->city = $data['city'];
                }
                if (!$contactRequest->ward) {
                    $contactRequest->ward = $data['ward'];
                }
                if (!$contactRequest->address) {
                    $contactRequest->address = $data['address'];
                }
                if (!$contactRequest->target) {
                    $contactRequest->target = $data['target'];
                }
                if (!$contactRequest->list) {
                    $contactRequest->list = $data['list'];
                }
                if (!$contactRequest->source_type) {
                    $contactRequest->source_type = $data['source_type'];
                }
                if (!$contactRequest->channel) {
                    $contactRequest->channel = $data['channel'];
                }
                if (!$contactRequest->placement) {
                    $contactRequest->placement = $data['placement'];
                }
                if (!$contactRequest->term) {
                    $contactRequest->term = $data['term'];
                }
                if (!$contactRequest->type_match) {
                    $contactRequest->type_match = $data['type_match'];
                }
                if (!$contactRequest->fbcid) {
                    $contactRequest->fbcid = $data['fbcid'];
                }
                if (!$contactRequest->gclid) {
                    $contactRequest->gclid = $data['gclid'];
                }
                if (!$contactRequest->lifecycle_stage) {
                    $contactRequest->lifecycle_stage = $data['lifecycle_stage'];
                }
                if (!$contactRequest->birthday && $data['birthday']) {
                    $contactRequest->birthday = $data['birthday']->format('Y-m-d');
                }

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

                // // update created_at
                // if ($data['google_form_submit_date']) {
                //     $contactRequest->created_at = $data['google_form_submit_date'];
                //     $contactRequest->updated_at = $data['google_form_submit_date'];
                //     $contactRequest->save();
                // }

                // bàn giao nhân viên sale
                if ($data['contact_owner']) {
                    // logging
                    $this->logInfo("ASSIGNE OLD REQUEST ==> : {$data['contact_owner']} : " . $this->getRowLog($data));

                    if (!$contactRequest->account) {
                        $this->assignSalespersonFromRaw($contactRequest, $data['contact_owner'], $data['assigned_date']);
                    } else {
                        $this->logInfo("ACCOUNT ASSIGNED BEFORE ==> do nothing : CURRENT => #{$contactRequest->account->name} NEW : {$data['contact_owner']}");
                    }
                }

                // Trường hợp không có contact_owner thì tìm latest salesperson
                else {
                    // chưa có account thì try to find the latest salesperson
                    if (!$contactRequest->account) {
                        $this->logInfo("NO CONTACT_OWNER ==> TRY TO FIND LATEST SALESPERSON");
                        $latestSalesperson = $contact->getLatestSalesperson();
                        
                        if ($latestSalesperson) {
                            // log
                            $this->logInfo("LATEST SALESPERSON FOUND ==> assign to #{$latestSalesperson->name}");

                            // assign to latest salesperson
                            $this->assignAccount($contactRequest, $latestSalesperson, $data['assigned_date']);
                        }

                        else {
                            // log
                            $this->logInfo("LATEST SALESPERSON NOT FOUND ==> do nothing");
                        }
                    } else {
                        $this->logInfo("ACCOUNT ASSIGNED BEFORE ==> do nothing : CURRENT => #{$contactRequest->account->name}");
                    }
                }
            } else {
                // logging
                $this->logInfo("EXIST REQUEST ==> ignore : " . $this->getRowLog($data));
            }
        }
    }

    public function getDemandsFromString($string)
    {
        // Split the string by semicolon
        $splitArray = explode(';', $string);

        // Trim each element in the array and remove empty elements
        $demands = array_filter(array_map('trim', $splitArray), function($value) {
            return $value !== '';
        });

        return $demands;
    }

    public function assignSalespersonFromRaw($contactRequest, $contactOnwer, $assignedDate)
    {
        // không có contact_owner data
        if (!$contactOnwer) {
            // logging
            throw new \Exception("CONTACT OWNER EMPTY ==> do nothing #{$contactOnwer}");
            return;
        }

        // Đã có owner
        if ($contactRequest->account) {
            // logging
            throw new \Exception("SALESPERSON ASSIGNED BEFORE:  CURRENT => #{$contactRequest->account->name}; NEW : #{$contactOnwer} ==> do nothing");
            return;
        }

        // Find account by name
        $account = Account::where('name', $contactOnwer)->first();

        // Nếu không tìm thấy account thì không làm gì hết
        if (!$account) {
            // logging
            $this->logInfo("ACCOUNT NOT FOUND ==> do nothing #{$contactOnwer}");
            return;
        }

        // assign to account
        $this->assignAccount($contactRequest, $account, $assignedDate);
    }

    public function assignAccount($contactRequest, $account, $assignedDate)
    {
        // không có contact_owner data
        if (!$account) {
            // logging
            throw new \Exception("ACCOUNT EMPTY ==> do nothing #{$account->name}");
            return;
        }

        // không có contact_owner data
        if ($contactRequest->account) {
            // logging
            throw new \Exception("ACCOUNT ASSIGNED ==> do nothing : CURRENT => #{$contactRequest->account->name} : NEW => #{$account->name}");
            return;
        }

        // Nếu tìm thấy account thì assign contact request mới cho account đó luôn
        // logging
        $this->logInfo("ASSIGN ACCOUNT ==> assign request #{$contactRequest->name} - {$contactRequest->phone} to #{$account->name}");

        // assign to account
        $contactRequest->assignToAccount($account, $assignedDate);

        // event
        \App\Events\SingleContactRequestAssigned::dispatch($account, $contactRequest, User::getSystemUser());
    }
}
