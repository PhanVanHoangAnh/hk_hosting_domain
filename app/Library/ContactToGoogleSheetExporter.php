<?php

namespace App\Library;

use App\Library\GoogleSheetService;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class ContactToGoogleSheetExporter
{
    public $sheetId;
    public $tabName;
    public $service;
    public $contactRequests;

    public function __construct($sheetId, $tabName, $contactRequests)
    {
        $this->sheetId = $sheetId;
        $this->tabName = $tabName;
        $this->contactRequests = $contactRequests;

        // Kết nố với Google Sheet file và lấy data
        $this->service = new GoogleSheetService($this->sheetId);
    }

    public function addHeader()
    {
        // range
        $range = $this->tabName . '!A1:ZZ1';

        $values =[\App\Models\ContactRequest::getExportHeaders()];

        $this->service->writeData($range, $values);
    }

    public function run()
    {
        // create table name
        $this->service->createSheet($this->tabName);

        // clear all
        $this->clearAll();

        //
        $this->addHeader();
        
        // range
        $range = $this->tabName . '!A2:ZZ' . (count($this->contactRequests)+1);
        $values = [];

        foreach ($this->contactRequests as $index => $contactRequest) {
            $values[] = array_map(function($value) {
                return $value ?? '';
            }, $contactRequest->getExportRowData());
        }

        // write data
        $this->service->writeData($range, $values);

        // // decorate header row
        // $color = [
        //     'red' => 1.0, // Red component (0.0 - 1.0)
        //     'green' => 0.8, // Green component (0.0 - 1.0)
        //     'blue' => 0.4 // Blue component (0.0 - 1.0)
        // ];
        // $this->service->setRowBackgroundColor($this->getTabId(), 0, $color);
    }

    public function clearAll()
    {
        $rowCount = $this->service->getRowCount(0);
        if ($rowCount < 3) {
            return;
        }
        $this->service->deleteRows($this->tabName, 2, 999999);
    }

    public function getTabId()
    {
        return $this->service->getSheetIdByTabName($this->tabName);
    }
}
