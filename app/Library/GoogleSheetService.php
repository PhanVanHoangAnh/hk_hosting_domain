<?php

namespace App\Library;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_Request;

class GoogleSheetService
{
    protected $client;
    protected $service;
    protected $apiKey;
    protected $contactSyncSheetId;

    public function __construct($sheetId)
    {
        $this->apiKey = config('services.google.sheets.api_key');
        $this->contactSyncSheetId = $sheetId;// config('services.google.sheets.contact_sync_sheet_id');

        // Client
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Google Sheets');
        $this->client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setAuthConfig(storage_path('google_credentials.json'));
        $this->client->setAccessType('offline');

        // Service
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function readSheet($spreadsheetId, $range)
    {
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }

    public function readContactSyncSheet($range='Sheet1!A1:T100000')
    {
        $sheetId = $this->contactSyncSheetId;

        return $this->readSheet($sheetId, $range);

    }

    public function writeData($range, $values)
    {
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS'
        ];
        $result = $this->service->spreadsheets_values->append($this->contactSyncSheetId, $range, $body, $params);
        
        return $result;
    }

    public function deleteRows($tabName, $startIndex, $endIndex)
    {
        $requests = [
            new \Google_Service_Sheets_Request([
                'deleteDimension' => [
                    'range' => [
                        'sheetId' => $this->getSheetIdByTabName($tabName),
                        'dimension' => 'ROWS',
                        'startIndex' => $startIndex,
                        'endIndex' => $endIndex  // Assuming a very large number to ensure deletion till the end
                    ]
                ]
            ])
        ];

        $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $response = $this->service->spreadsheets->batchUpdate($this->contactSyncSheetId, $batchUpdateRequest);
        return $response;
    }

    public function getRowCount($sheetId)
    {
        $response = $this->service->spreadsheets->get($this->contactSyncSheetId, ['includeGridData' => true]);
        $sheet = $response->getSheets()[0];
        $rowCount = $sheet->getProperties()->getGridProperties()->getRowCount();
        return $rowCount;
    }

    public function createSheet($sheetName)
    {
        $requests = [
            new \Google_Service_Sheets_Request([
                'addSheet' => [
                    'properties' => new \Google_Service_Sheets_SheetProperties([
                        'title' => $sheetName
                    ])
                ]
            ])
        ];

        $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        try {
            $response = $this->service->spreadsheets->batchUpdate($this->contactSyncSheetId, $batchUpdateRequest);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getSheetIdByTabName($tabName)
    {
        $spreadsheet = $this->service->spreadsheets->get($this->contactSyncSheetId);
        $sheets = $spreadsheet->getSheets();

        foreach ($sheets as $sheet) {
            /** @var Google_Service_Sheets_Sheet $sheet */
            if ($sheet->getProperties()->getTitle() === $tabName) {
                return $sheet->getProperties()->getSheetId();
            }
        }

        return null; // Return null if tab name not found
    }

    public function setRowBackgroundColor($sheetId, $rowIndex, $color)
    {
        // Define the range for the entire row
        $range = [
            'sheetId' => $sheetId,
            'startRowIndex' => $rowIndex,
            'endRowIndex' => $rowIndex + 1
        ];

        // Create a color object
        $backgroundColor = new \Google_Service_Sheets_Color();
        $backgroundColor->setRed($color['red'] ?? 1.0); // Red component (0.0 - 1.0)
        $backgroundColor->setGreen($color['green'] ?? 1.0); // Green component (0.0 - 1.0)
        $backgroundColor->setBlue($color['blue'] ?? 1.0); // Blue component (0.0 - 1.0)

        // Create a cell format object with background color
        $cellFormat = new \Google_Service_Sheets_CellFormat();
        $cellFormat->setBackgroundColor($backgroundColor);

        // Create the cell data with the cell format
        $cellData = new \Google_Service_Sheets_CellData();
        $cellData->setUserEnteredFormat($cellFormat);

        // Create the row data with cell data
        $rowData = new \Google_Service_Sheets_RowData();
        $rowData->setValues([$cellData]);

        // Create the update cells request
        $request = new \Google_Service_Sheets_UpdateCellsRequest([
            'rows' => [$rowData],
            'fields' => 'userEnteredFormat.backgroundColor',
            'range' => $range
        ]);

        // Prepare batch update request
        $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => [
                'updateCells' => $request
            ]
        ]);

        try {
            // Execute batch update
            $response = $this->service->spreadsheets->batchUpdate($this->contactSyncSheetId, $batchUpdateRequest);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getName()
    {
        $spreadsheet = $this->service->spreadsheets->get($this->contactSyncSheetId);
        return $spreadsheet->getProperties()->getTitle();
    }
}