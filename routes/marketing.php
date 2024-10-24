<?php

use App\Http\Controllers\Marketing\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Marketing\ContactController;
use App\Http\Controllers\Marketing\ContactRequestController;
use App\Http\Controllers\Marketing\TagController;
use App\Http\Controllers\Marketing\ContactListController;
use App\Http\Controllers\Marketing\ReportController;
use App\Http\Controllers\Marketing\ImportController;
use App\Http\Controllers\Marketing\ExportController;
use App\Http\Controllers\Marketing\DashboardController;
use App\Http\Controllers\Marketing\NoteLogController;
use App\Http\Controllers\Marketing\ContactImportController;

Route::middleware('auth', 'marketing', 'check.password.change')->group(function () {
    // Note logs
    Route::get('marketing/note-logs', [NoteLogController::class, 'index']);
    Route::get('marketing/note-logs/list', [NoteLogController::class, 'list']);
    Route::get('marketing/note-logs/{id}/edit', [NoteLogController::class, 'edit']);
    Route::put('marketing/note-logs/{id}', [NoteLogController::class, 'update']);
    Route::post('marketing/note-logs/{id}', [NoteLogController::class, 'update']);
    Route::delete('marketing/note-logs/{id}', [NoteLogController::class, 'destroy']);
    Route::delete('marketing/note-logs', [NoteLogController::class, 'destroyAll']);
    Route::get('marketing/note-logs/create', [NoteLogController::class, 'create']);
    Route::post('marketing/note-logs/add-notelog/{id}', [NoteLogController::class, 'storeNoteLog']);
    Route::get('marketing/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'createNoteLogCustomer']);
    Route::post('marketing/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'storeNoteLogCustomer']);
    Route::post('marketing/note-logs', [NoteLogController::class, 'store']);
    Route::get('marketing/note-logs/note-logs-popup/{id}', [NoteLogController::class, 'noteLogsPopup']);
    Route::get('marketing/note-logs/add-notelog-contact/{id}', [NoteLogController::class, 'addNoteLog']);
    // Contact Request
    Route::post('marketing/contact_requests/export/google-sheet', [ContactRequestController::class, 'exportToGoogleSheet']);
    Route::post('marketing/contact_requests/{id}/save', [ContactRequestController::class, 'save']);
    Route::get('marketing/contact_requests/select2', [ContactRequestController::class, 'select2']);
    Route::get('marketing/contact_requests/add-tags', [ContactRequestController::class, 'addTags']);
    Route::get('marketing/contact_requests/delete-tags', [ContactRequestController::class, 'deleteTags']);
    Route::get('marketing/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulk']);
    Route::put('marketing/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulkSave']);
    Route::delete('marketing/contact_requests/action-delete-tags', [ContactRequestController::class, 'actionDeleteTags']);
    Route::get('marketing/contact_requests/handover/{id}', [ContactRequestController::class, 'addHandover']);
    Route::put('marketing/contact_requests/handover/{id}', [ContactRequestController::class, 'saveHandover']);
    Route::get('marketing/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulk']);
    Route::put('marketing/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulkSave']);
    Route::get('marketing/contact_requests/{id}/update-history', [ContactRequestController::class, 'updateHistory']);
    Route::get('marketing/contact_requests/{id}/extra-activity', [ContactRequestController::class, 'extraActivity']);
    Route::get('marketing/contact_requests/{id}/kid-tech', [ContactRequestController::class, 'kidTech']);
    Route::get('marketing/contact_requests/{id}/study-abroad', [ContactRequestController::class, 'studyAbroad']);
    Route::get('marketing/contact_requests/{id}/debt', [ContactRequestController::class, 'debt']);
    Route::get('marketing/contact_requests/{id}/education', [ContactRequestController::class, 'education']);
    Route::get('marketing/contact_requests/{id}/contract', [ContactRequestController::class, 'contract']);
    Route::get('marketing/contact_requests/{id}/show', [ContactRequestController::class, 'show']);
    Route::get('marketing/contact_requests/{id}/edit', [ContactRequestController::class, 'edit']);
    Route::put('marketing/contact_requests/{id}', [ContactRequestController::class, 'update']);
    Route::post('marketing/contact_requests/import/hubspot/run', [ContactRequestController::class, 'importHubspotRun']);
    Route::get('marketing/contact_requests/import/hubspot', [ContactRequestController::class, 'importHubspot']);
    Route::get('marketing/contact_requests/import/excel', [ContactRequestController::class, 'importExcel']);
    Route::post('marketing/contact_requests/import/excel', [ContactRequestController::class, 'importExcelShow']);
    Route::post('marketing/contact_requests/import/excel/run', [ContactRequestController::class, 'importExcelRunning']);
    Route::post('marketing/contact_requests/import/excel/test-results', [ContactRequestController::class, 'testImportDone']);
    Route::get('marketing/contact_requests/import/excel/download-log', [ContactRequestController::class, 'downloadLog']);
    Route::delete('marketing/contact_requests/{id}', [ContactRequestController::class, 'destroy']);
    Route::post('marketing/contact_requests', [ContactRequestController::class, 'store']);
    Route::get('marketing/contact_requests/create', [ContactRequestController::class, 'create']);
    Route::get('marketing/contact_requests/list', [ContactRequestController::class, 'list']);
    Route::get('marketing/contact_requests', [ContactRequestController::class, 'index']);
    Route::get('marketing/contact_requests/export-filter', [ContactRequestController::class, 'showFilterForm']);
    Route::post('marketing/contact_requests/exportRun', [ContactRequestController::class, 'exportRun']);
    Route::get('marketing/contact_requests/exportDownload', [ContactRequestController::class, 'exportDownload']);
    Route::get('marketing/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelected']);
    Route::post('marketing/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelectedRun']);
    Route::get('marketing/contact_requests/export-contact-selected/run', [ContactRequestController::class, 'exportContactRequestSelectedDownload']);
    Route::post('marketing/contact_requests/delete-all', [ContactRequestController::class, 'deleteAll']);

    Route::get('marketing/contact_requests/show-freetime-schedule/{id}', [ContactRequestController::class, 'showFreeTimeSchedule']);
    Route::get('marketing/contact_requests/{id}/create-freetime-schedule', [ContactRequestController::class, 'createFreetimeSchedule']);
    Route::post('marketing/contact_requests/{id}/save-freetime-schedule', [ContactRequestController::class, 'saveFreetimeSchedule']);
    Route::get('marketing/contact_requests/{id}/edit-freetime-schedule', [ContactRequestController::class, 'editFreetimeSchedule']);
    Route::put('marketing/contact_requests/{id}/update-freetime-schedule', [ContactRequestController::class, 'updateFreetimeSchedule']);
    Route::get('marketing/contact_requests/{id}/contact-request', [ContactRequestController::class, 'contactRquestPopup']);
    Route::get('marketing/contact_requests/school/select2', [ContactRequestController::class, 'schoolSelect2']);
    // Contact

    Route::get('marketings/contacts/related-contacts-box', [ContactController::class, 'relatedContactsBox']);
    Route::match(['get', 'put', 'delete'], 'marketings/contacts/find-related-contacts-import-from-excel', [ContactController::class, 'findRelatedContactsImportFromExcel']);

    Route::post('marketing/contacts/{id}/save', [ContactController::class, 'save']);
    Route::get('marketing/contacts/select2', [ContactController::class, 'select2']);
    Route::get('marketing/contacts/add-tags', [ContactController::class, 'addTags']);
    Route::get('marketing/contacts/delete-tags', [ContactController::class, 'deleteTags']);
    Route::get('marketing/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulk']);
    Route::put('marketing/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulkSave']);
    Route::delete('marketing/contacts/action-delete-tags', [ContactController::class, 'actionDeleteTags']);
    Route::post('marketing/contacts/delete-all', [ContactController::class, 'deleteAll']);
    Route::get('marketing/contacts/{id}/update-history', [ContactController::class, 'updateHistory']);
    Route::get('marketing/contacts/{id}/extra-activity', [ContactController::class, 'extraActivity']);
    Route::get('marketing/contacts/{id}/kid-tech', [ContactController::class, 'kidTech']);
    Route::get('marketing/contacts/{id}/study-abroad', [ContactController::class, 'studyAbroad']);
    Route::get('marketing/contacts/{id}/debt', [ContactController::class, 'debt']);
    Route::get('marketing/contacts/{id}/education', [ContactController::class, 'education']);
    Route::get('marketing/contacts/{id}/contract', [ContactController::class, 'contract']);
    Route::get('marketing/contacts/{id}/show', [ContactController::class, 'show']);
    Route::get('marketing/contacts/{id}/edit', [ContactController::class, 'edit']);
    Route::put('marketing/contacts/{id}', [ContactController::class, 'update']);
    Route::post('marketing/contacts/import/hubspot/run', [ContactController::class, 'importHubspotRun']);
    Route::get('marketing/contacts/import/hubspot', [ContactController::class, 'importHubspot']);
    Route::get('marketing/contacts/import/excel', [ContactController::class, 'importExcel']);
    Route::post('marketing/contacts/import/excel/upload', [ContactController::class, 'importExcelUpload']);
    Route::get('marketing/contacts/import/excel/show', [ContactController::class, 'importExcelShow']);
    // Route::post('marketing/contacts/import/excel/run', [ContactController::class, 'importExcelRunning']);
    Route::match(['post', 'get'], 'marketing/contacts/import/excel/run', [ContactController::class, 'importExcelRunning']);
    Route::get('marketing/contact/download-file-export-logsImport', [ContactController::class, 'downloadFileExportLogsImport']);


    Route::post('marketing/contacts/import/excel/test-results', [ContactController::class, 'testImportDone']);
    Route::get('marketing/contacts/import/excel/download-log', [ContactController::class, 'downloadLog']);
    Route::delete('marketing/contacts/{id}', [ContactController::class, 'destroy']);
    Route::post('marketing/contacts', [ContactController::class, 'store']);
    Route::get('marketing/contacts/create', [ContactController::class, 'create']);
    Route::get('marketing/contacts/list', [ContactController::class, 'list']);
    Route::get('marketing/contacts', [ContactController::class, 'index']);
    Route::get('marketing/contacts/export-filter', [ContactController::class, 'showFilterForm']);
    Route::post('marketing/contacts/exportRun', [ContactController::class, 'exportRun']);
    Route::get('marketing/contacts/exportDownload', [ContactController::class, 'exportDownload']);
    Route::get('marketing/contacts/export-contact-selected', [ContactController::class, 'exportContactSelected']);
    Route::post('marketing/contacts/export-contact-selected', [ContactController::class, 'exportContactSelectedRun']);
    Route::get('marketing/contacts/export-contact-selected/run', [ContactController::class, 'exportContactSelectedDownload']);





    //tags
    Route::get('marketing/tags/delete-tags', [TagController::class, 'deleteTags']);
    Route::delete('marketing/tags/action-delete-tags', [TagController::class, 'actionDeleteTags']);
    Route::get('marketing/tags/{id}/show', [TagController::class, 'show']);
    Route::get('marketing/tags/{id}/edit', [TagController::class, 'edit']);
    Route::put('marketing/tags/{id}', [TagController::class, 'update']);
    Route::delete('marketing/tags/{id}', [TagController::class, 'destroy']);
    Route::post('marketing/tags', [TagController::class, 'store']);
    Route::get('marketing/tags/create', [TagController::class, 'create']);
    Route::get('marketing/tags/list', [TagController::class, 'list']);
    Route::get('marketing/tags', [TagController::class, 'index']);

    //Contact List
    // Route để hiển thị danh sách hợp đồng
    Route::post('marketing/contact-lists', [ContactListController::class, 'store']);
    Route::get('marketing/contact-lists/create', [ContactListController::class, 'create']);
    Route::get('marketing/contact-lists/list', [ContactListController::class, 'list']);
    Route::get('marketing/contact-lists', [ContactListController::class, 'index']);
    Route::get('marketing/contact-lists/{id}/edit', [ContactListController::class, 'edit']);
    Route::put('marketing/contact-lists/{id}', [ContactListController::class, 'update']);
    Route::delete('marketing/contact-lists/{id}', [ContactListController::class, 'destroy']);

    // Report
    Route::get('marketing/reports', [ReportController::class, 'index']);
    Route::post('marketing/reports/result', [ReportController::class, 'result']);
    Route::post('marketing/reports/add-view', [ReportController::class, 'addView']);
    Route::post('marketing/reports/remove-view', [ReportController::class, 'removeView']);
    Route::get('marketing/reports/create-button-name', [ReportController::class, 'createButtonName']);
    Route::get('marketing/reports/view-buttons', [ReportController::class, 'viewButtons']);
    Route::post('marketing/reports/set-view-secsion', [ReportController::class, 'loadView']);
    Route::post('marketing/reports/download-excel-report', [ReportController::class, 'downloadExcelReport']);
    Route::get('marketing/reports/export-download', [ReportController::class, 'exportDownload']);


    //Import
    Route::get('marketing/import', [ImportController::class, 'index']);
    Route::post('marketing/import/google-sheet/reset-counter', [ImportController::class, 'resetGoogleSheetImporter']);
    Route::post('marketing/import/google-sheet/run', [ImportController::class, 'runGoogleSheetImporter']);
    Route::post('marketing/import/google-sheet/start', [ImportController::class, 'startGoogleSheetImporter']);
    Route::post('marketing/import/google-sheet/paused', [ImportController::class, 'pauseGoogleSheetImporter']);

    //Export
    Route::get('marketing/export', [ExportController::class, 'index']);



    //Dashboard 
    Route::get('marketing/dashboard/conversion-rate', [DashboardController::class, 'conversionRate']);
    Route::get('marketing/dashboard/module1', [DashboardController::class, 'module1']);
    Route::get('marketing/dashboard/module2', [DashboardController::class, 'module2']);
    Route::get('marketing/dashboard/module3', [DashboardController::class, 'module3']);
    Route::get('marketing/dashboard/module4', [DashboardController::class, 'module4']);
    Route::get('marketing/dashboard/', [DashboardController::class, 'index']);
    Route::get('marketing/dashboard/{interval}', [DashboardController::class, 'updateInterval']);

    // Contact Import Controller
    Route::post('marketing/contact/finish', [ContactImportController::class, 'finish']);
    Route::post('marketing/contact/import', [ContactImportController::class, 'uploadAndRun']);
    Route::get('marketing/contact/progress', [ContactImportController::class, 'progress']);
    Route::get('marketing/contact/progress/bar', [ContactImportController::class, 'progressBar']);
});
