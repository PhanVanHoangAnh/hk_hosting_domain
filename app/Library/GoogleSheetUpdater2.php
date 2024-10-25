<?php

namespace App\Library;

use Carbon\Carbon;
use App\Helpers\Functions;
use App\Library\GoogleSheetService;

class GoogleSheetUpdater2
{
    public $sheetId;
    public $service;
    public $headers;
    public $datas;

    public function __construct($sheetId)
    {
        $this->sheetId = $sheetId;

        // Kết nố với Google Sheet file và lấy data
        $this->service = new GoogleSheetService($this->sheetId);
        $this->datas = $this->service->readContactSyncSheet('Sheet1!A2:Z300000');

        // headers
        $this->headers = [
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

        $this->datas = array_map(function($row) {
            //
            $headers = $this->headers;
            $dateForm = 'Y-m-d H:i:s';

            // converting
            try {
                $assigned_date = !isset($row[array_search('AssignedDate', $headers)]) ? '' : (!empty($row[array_search('AssignedDate', $headers)]) ?
                    Carbon::createFromFormat('Y-m-d H:i', $row[array_search('AssignedDate', $headers)])->startOfDay()
                    : null);
            } catch (\Throwable $e) {
                $this->logError("Can not format AssignedDate: " . json_encode($row));
                $assigned_date = null;
            }

            try {
                $google_form_submit_date = !isset($row[array_search('FormSubmitDate', $headers)]) ? '' : (!empty($row[array_search('FormSubmitDate', $headers)]) ?
                    Carbon::createFromFormat('Y-m-d H:i', $row[array_search('FormSubmitDate', $headers)])->startOfDay()
                    : null);
            } catch (\Throwable $e) {
                $this->logError("Can not format AssignedDate: " . json_encode($row));
                $google_form_submit_date = null;
            }

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
        }, $this->datas);
    }

    public function run()
    {
        foreach ($this->datas as $index => $data) {
            $contactRequests = \App\Models\ContactRequest::active()
                ->relatedContactsByPhoneAndDemandAndSubChannel($data['phone_raw'], $data['demand'])
                ->get();

            // not found log
            if ($contactRequests->count() == 0) {
                $this->logInfo("NOT FOUND!! {$contactRequests->count()} : $index : " . json_encode([
                    'phone_raw' => $data['phone_raw'],
                    'phone_new' => $data['phone_new'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'sub_channel' => $data['sub_channel'],
                    'demand' => $data['demand'],
                ]));
            }

            foreach ($contactRequests as $contactRequest) {
                // update phone raw
                $contactRequest->phone = $data['phone_new'];
                if ($data['google_form_submit_date']) {
                    $contactRequest->created_at = $data['google_form_submit_date'];
                    $contactRequest->updated_at = $data['google_form_submit_date'];
                }
                $contactRequest->save();

                // log
                $this->logInfo("$index : {$contactRequest->id} : " . json_encode([
                    'phone_raw' => $data['phone_raw'],
                    'phone_new' => $data['phone_new'],
                    'phone' => $contactRequest->phone,
                    'email' => $contactRequest->email,
                    'name' => $contactRequest->name,
                    'created_at' => $contactRequest->created_at,
                ]));

                // update contact
                $contact = $contactRequest->contact;
                // update phone raw
                $contact->phone = $data['phone_new'];
                if ($data['google_form_submit_date']) {
                    $contact->created_at = $contact->contactRequests()->orderBy('created_at', 'asc')->first()->created_at;
                    $contact->updated_at = $contact->contactRequests()->orderBy('created_at', 'desc')->first()->created_at;
                }
                $contact->save();
            }
        }
    }

    public function logInfo($message)
    {
        echo $message . "\n";
    }

    public function logError($message)
    {
        echo $message . "\n";
    }
}

