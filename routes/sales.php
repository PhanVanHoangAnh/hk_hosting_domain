<?php

use App\Http\Controllers\Sales\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Sales\AbroadController;
use App\Http\Controllers\Sales\PaymentRecordController;
use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\ContactController;
use App\Http\Controllers\Sales\ContactRequestController;
use App\Http\Controllers\Sales\OrderController;
use App\Http\Controllers\Sales\RevenueDistributionController;
use App\Http\Controllers\Sales\CourseController;
use App\Http\Controllers\Sales\OrderItemController;
use App\Http\Controllers\Sales\NoteLogController;
use App\Http\Controllers\Sales\ReportController;
use App\Http\Controllers\Sales\DashboardController;
use App\Http\Controllers\Sales\Report\ContractStatusController;
use App\Http\Controllers\Sales\Report\KPIReportController;
use App\Http\Controllers\Sales\Report\SalesReportController;
use App\Http\Controllers\Sales\Report\ConversionRateReportController;
use App\Http\Controllers\Sales\Report\PaymentReportController;
use App\Http\Controllers\Sales\Report\RevenueReportController;
use App\Http\Controllers\Sales\Report\UpsellReportController;
use App\Http\Controllers\Sales\RefundRequestController;
use App\Http\Controllers\Sales\StudentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Sales\OnePayController;


Route::middleware('auth', 'sales', 'check.password.change')->group(function () {
    // Contact Request
    Route::get('sales/contact_requests/show-freetime-schedule/{id}', [ContactRequestController::class, 'showFreeTimeSchedule']);
    Route::get('sales/contact_requests/{id}/create-freetime-schedule', [ContactRequestController::class, 'createFreetimeSchedule']);
    Route::post('sales/contact_requests/{id}/save-freetime-schedule', [ContactRequestController::class, 'saveFreetimeSchedule']);
    Route::get('sales/contact_requests/{id}/edit-freetime-schedule', [ContactRequestController::class, 'editFreetimeSchedule']);
    Route::put('sales/contact_requests/{id}/update-freetime-schedule', [ContactRequestController::class, 'updateFreetimeSchedule']);

    Route::post('sales/contact_requests/{id}/save', [ContactRequestController::class, 'save']);
    Route::get('sales/contact_requests/select2', [ContactRequestController::class, 'select2']);
    Route::get('sales/contact_requests/add-tags', [ContactRequestController::class, 'addTags']);
    Route::get('sales/contact_requests/delete-tags', [ContactRequestController::class, 'deleteTags']);
    Route::get('sales/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulk']);
    Route::put('sales/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulkSave']);
    Route::delete('sales/contact_requests/action-delete-tags', [ContactRequestController::class, 'actionDeleteTags']);
    Route::get('sales/contact_requests/handover/{id}', [ContactRequestController::class, 'addHandover']);
    Route::put('sales/contact_requests/handover/{id}', [ContactRequestController::class, 'saveHandover']);
    Route::get('sales/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulk']);
    Route::put('sales/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulkSave']);
    Route::get('sales/contact_requests/{id}/update-history', [ContactRequestController::class, 'updateHistory']);
    Route::get('sales/contact_requests/{id}/extra-activity', [ContactRequestController::class, 'extraActivity']);
    Route::get('sales/contact_requests/{id}/kid-tech', [ContactRequestController::class, 'kidTech']);
    Route::get('sales/contact_requests/{id}/study-abroad', [ContactRequestController::class, 'studyAbroad']);
    Route::get('sales/contact_requests/{id}/debt', [ContactRequestController::class, 'debt']);
    Route::get('sales/contact_requests/{id}/education', [ContactRequestController::class, 'education']);
    Route::get('sales/contact_requests/{id}/contract', [ContactRequestController::class, 'contract']);
    
    Route::get('sales/contact_requests/{id}/show', [ContactRequestController::class, 'show']);
    Route::get('sales/contact_requests/{id}/edit', [ContactRequestController::class, 'edit']);
    Route::put('sales/contact_requests/{id}', [ContactRequestController::class, 'update']);
    Route::post('sales/contact_requests/import/hubspot/run', [ContactRequestController::class, 'importHubspotRun']);
    Route::get('sales/contact_requests/import/hubspot', [ContactRequestController::class, 'importHubspot']);
    Route::get('sales/contact_requests/import/excel', [ContactRequestController::class, 'importExcel']);
    Route::post('sales/contact_requests/import/excel', [ContactRequestController::class, 'importExcelShow']);
    Route::post('sales/contact_requests/import/excel/run', [ContactRequestController::class, 'importExcelRunning']);
    Route::post('sales/contact_requests/import/excel/test-results', [ContactRequestController::class, 'testImportDone']);
    Route::get('sales/contact_requests/import/excel/download-log', [ContactRequestController::class, 'downloadLog']);
    Route::delete('sales/contact_requests/{id}', [ContactRequestController::class, 'destroy']);
    Route::post('sales/contact_requests', [ContactRequestController::class, 'store']);
    Route::get('sales/contact_requests/create', [ContactRequestController::class, 'create']);
    Route::get('sales/contact_requests/list', [ContactRequestController::class, 'list']);
    Route::get('sales/contact_requests', [ContactRequestController::class, 'index']);
    Route::get('sales/contact_requests/export-filter', [ContactRequestController::class, 'showFilterForm']);
    Route::post('sales/contact_requests/exportRun', [ContactRequestController::class, 'exportRun']);
    Route::get('sales/contact_requests/exportDownload', [ContactRequestController::class, 'exportDownload']);
    Route::get('sales/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelected']);
    Route::post('sales/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelectedRun']);
    Route::get('sales/contact_requests/export-contact-selected/run', [ContactRequestController::class, 'exportContactRequestSelectedDownload']);
    Route::post('sales/contact_requests/delete-all', [ContactRequestController::class, 'deleteAll']);

    Route::get('sales/contact_requests/{id}/create-freetime-schedule', [ContactRequestController::class, 'createFreetimeSchedule']);
    Route::post('sales/contact_requests/{id}/save-freetime-schedule', [ContactRequestController::class, 'saveFreetimeSchedule']);
    Route::get('sales/contact_requests/{id}/edit-freetime-schedule', [ContactRequestController::class, 'editFreetimeSchedule']);
    Route::put('sales/contact_requests/{id}/update-freetime-schedule', [ContactRequestController::class, 'updateFreetimeSchedule']);
    Route::delete('sales/contact_requests/{id}/delete-busy-schedule', [ContactRequestController::class, 'deleteFreeTime']);

    // Contact
    Route::get('sales/contacts/related-contacts-box', [ContactController::class, 'relatedContactsBox']);
    Route::get('sales/contacts/{id}/info-box', [ContactController::class, 'infoBox']);
    Route::get('sales/contacts/note-logs-popup/{id}', [ContactController::class, 'noteLogsPopup']);
    Route::post('sales/contacts/{id}/save', [ContactController::class, 'save']);
    Route::get('sales/contacts/select2', [ContactController::class, 'select2']);
    Route::get('sales/contacts/add-tags', [ContactController::class, 'addTags']);
    Route::get('sales/contacts/delete-tags', [ContactController::class, 'deleteTags']);
    Route::get('sales/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulk']);
    Route::put('sales/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulkSave']);
    Route::delete('sales/contacts/action-delete-tags', [ContactController::class, 'actionDeleteTags']);
    Route::get('sales/contacts/{id}/update-history', [ContactController::class, 'updateHistory']);
    Route::get('sales/contacts/{id}/note-logs', [ContactController::class, 'noteLog']);
    Route::get('sales/contacts/note-logs-list/{id}', [ContactController::class, 'noteLogList']);
    Route::get('sales/contacts/{id}/study-abroad', [ContactController::class, 'studyAbroad']);
    Route::get('sales/contacts/{id}/extra-activity', [ContactController::class, 'extraActivity']);
    Route::get('sales/contacts/{id}/kid-tech', [ContactController::class, 'kidTech']);
    Route::get('sales/contacts/{id}/debt', [ContactController::class, 'debt']);
    Route::get('sales/contacts/{id}/education', [ContactController::class, 'education']);
    Route::get('sales/contacts/{id}/contract', [ContactController::class, 'contract']);
    Route::get('sales/contacts/{id}/show', [ContactController::class, 'show']);
    Route::get('sales/contacts/{id}/edit', [ContactController::class, 'edit']);
    Route::put('sales/contacts/{id}', [ContactController::class, 'update']);
    Route::post('sales/contacts/import/hubspot/run', [ContactController::class, 'importHubspotRun']);
    Route::get('sales/contacts/import/hubspot', [ContactController::class, 'importHubspot']);
    Route::get('sales/contacts/import/excel', [ContactController::class, 'importExcel']);
    Route::post('sales/contacts/import/excel', [ContactController::class, 'importExcelShow']);
    Route::post('sales/contacts/import/excel/run', [ContactController::class, 'importExcelRunning']);
    Route::post('sales/contacts/import/excel/test-results', [ContactController::class, 'testImportDone']);
    Route::get('sales/contacts/import/excel/download-log', [ContactController::class, 'downloadLog']);
    Route::delete('sales/contacts/{id}', [ContactController::class, 'destroy']);
    Route::post('sales/contacts', [ContactController::class, 'store']);
    Route::get('sales/contacts/create', [ContactController::class, 'create']);
    Route::get('sales/contacts/list', [ContactController::class, 'list']);
    Route::get('sales/contacts', [ContactController::class, 'index']);
    Route::post('sales/contacts/delete-all', [ContactController::class, 'deleteAll']);
    Route::get('sales/{id}/get-sale-sup-by-sale', [AccountController::class, 'getSaleSupBySale']);

    Route::get('sales/contacts/export', [ContactController::class, 'showFilterForm']);
    Route::post('sales/contacts/exportRun', [ContactController::class, 'exportRun']);
    Route::get('sales/contacts/exportDownload', [ContactController::class, 'exportDownload']);

    // Route::post('sales/contacts', [ContactController::class, 'storeNoteLogs']);

    Route::get('sales/contacts/add-notelog-contact/{id}', [NoteLogController::class, 'addNoteLogForContact']);
    // Route::post('sales/contacts/add-notelog-contact/{id}', [ContactController::class, 'storeNoteLogContact']);
    Route::get('sales/contacts/note-logs-popup/{id}', [NoteLogController::class, 'noteLogsPopupForContact']);
    // Customer
    Route::get('sales/customers/note-logs-popup/{id}', [CustomerController::class, 'noteLogsPopup']);

    Route::post('sales/customers/{id}/save', [CustomerController::class, 'save']);
    Route::get('sales/customers/select2', [CustomerController::class, 'select2']);
    Route::get('sales/customers/add-tags', [CustomerController::class, 'addTags']);
    Route::get('sales/customers/delete-tags', [CustomerController::class, 'deleteTags']);
    Route::get('sales/customers/add-tags/bulk', [CustomerController::class, 'addTagsBulk']);
    Route::put('sales/customers/add-tags/bulk', [CustomerController::class, 'addTagsBulkSave']);
    Route::delete('sales/customers/action-delete-tags', [CustomerController::class, 'actionDeleteTags']);
    Route::get('sales/customers/{id}/update-history', [CustomerController::class, 'updateHistory']);
    Route::get('sales/customers/{id}/note-logs', [CustomerController::class, 'noteLog']);
    Route::get('sales/customers/note-logs-list/{id}', [CustomerController::class, 'noteLogList']);
    Route::get('sales/customers/{id}/study-abroad', [CustomerController::class, 'studyAbroad']);
    Route::get('sales/customers/{id}/extra-activity', [CustomerController::class, 'extraActivity']);
    Route::get('sales/customers/{id}/kid-tech', [CustomerController::class, 'kidTech']);
    Route::get('sales/customers/{id}/debt', [CustomerController::class, 'debt']);
    Route::get('sales/customers/{id}/education', [CustomerController::class, 'education']);
    Route::get('sales/customers/{id}/contract', [CustomerController::class, 'contract']);
    Route::get('sales/customers/{id}/contract-list', [CustomerController::class, 'contractList']);
    Route::get('sales/customers/{id}/payment-list', [CustomerController::class, 'paymentList']);
    Route::get('sales/customers/{id}/show', [CustomerController::class, 'show']);
    Route::get('sales/customers/{id}/edit', [CustomerController::class, 'edit']);
    Route::put('sales/customers/{id}', [CustomerController::class, 'update']);
    Route::post('sales/customers/import/hubspot/run', [CustomerController::class, 'importHubspotRun']);
    Route::get('sales/customers/import/hubspot', [CustomerController::class, 'importHubspot']);
    Route::get('sales/customers/import/excel', [CustomerController::class, 'importExcel']);
    Route::post('sales/customers/import/excel', [CustomerController::class, 'importExcelShow']);
    Route::post('sales/customers/import/excel/run', [CustomerController::class, 'importExcelRunning']);
    Route::post('sales/customers/import/excel/test-results', [CustomerController::class, 'testImportDone']);
    Route::get('sales/customers/import/excel/download-log', [CustomerController::class, 'downloadLog']);
    Route::delete('sales/customers/{id}', [CustomerController::class, 'destroy']);
    Route::post('sales/customers', [CustomerController::class, 'store']);
    Route::get('sales/customers/create', [CustomerController::class, 'create']);
    Route::get('sales/customers/list', [CustomerController::class, 'list']);
    Route::get('sales/customers', [CustomerController::class, 'index']);

    Route::get('sales/customers/{id}/request-contact', [CustomerController::class, 'requestContact']);
    Route::get('sales/contacts/{id}/request-contact-list', [CustomerController::class, 'requestContactList']);

    Route::get('sales/customers/export', [CustomerController::class, 'export']);


    // Orders
    Route::get('sales/orders/relationship-form', [OrderController::class, 'relationshipForm']);
    Route::get('sales/orders', [OrderController::class, 'index']);
    Route::get('sales/orders/list', [OrderController::class, 'list']);
    Route::get('sales/orders/showConstract', [OrderController::class, 'showConstract']);
    Route::get('sales/orders/contact/pick', [OrderController::class, 'pickContact']);
    Route::get('sales/orders/contact/request/pick', [OrderController::class, 'pickContactRequest']);
    Route::get('sales/orders/contactForRequestDemo', [OrderController::class, 'pickContactForRequestDemo']);
    Route::post('sales/orders/constract', [OrderController::class, 'createConstract']);
    Route::post('sales/orders/save-order-item', [OrderController::class, 'saveOrderItemData']);
    // Route::post('sales/orders/save-extra-item', [OrderController::class, 'saveExtraItem']);
    Route::post('sales/orders/save-constract/temp', [OrderController::class, 'saveConstractData']);
    Route::post('sales/orders/save-constract', [OrderController::class, 'doneCreateConstractData']);
    Route::get('sales/orders/delete-constract/{orderId}', [OrderController::class, 'showFormDeleteConstract']);
    Route::delete('sales/orders/delete', [OrderController::class, 'delete']);
    Route::get('sales/orders/create-constract/{orderId}/{actionType}', [OrderController::class, 'showFormCreateConstract']);
    Route::get('sales/orders/create/train', [OrderController::class, 'createTrainOrder']);
    Route::get('sales/orders/create/extra', [OrderController::class, 'showCreateExtraPopup']);
    Route::get('sales/orders/create/abroad', [OrderController::class, 'createAbroadOrder']);
    Route::get('sales/orders/create/demo', [OrderController::class, 'createDemoOrder']);
    Route::post('sales/orders/{id}/request-approval', [OrderController::class, 'requestApproval']);
    Route::post('sales/orders/delete-all', [OrderController::class, 'deleteAll']);
    Route::post('sales/orders/get-total-price-of-items', [OrderController::class, 'getTotalPriceOfItems']);
    route::get('sales/orders/get-sale-sup/{orderId}', [OrderController::class, 'getSaleSup']);
    Route::post('sales/orders/{id}/confirm-request-demo', [OrderController::class, 'confirmRequestDemo']);
    Route::get('sales/orders/{id}/showQrCode', [OrderController::class, 'showQrCode']);
    Route::get('sales/orders/{id}/history-rejected', [OrderController::class, 'historyRejected']);
    Route::post('sales/orders/save-sale/', [OrderController::class, 'saveSale']);
    Route::get('sales/orders/{id}/export-order', [OrderController::class, 'exportOrder']);
    Route::get('sales/orders/export', [OrderController::class, 'export']);
    
    Route::get('sales/orders/order-items/select2', [OrderItemController::class, 'select2']);
    Route::get('sales/order-item/{id}/copy', [OrderItemController::class, 'copy']);
    Route::delete('sales/orders/order-item', [OrderItemController::class, 'delete']);
    Route::get('sales/order-items/{id}/show-abroad-item-data-popup', [OrderItemController::class, 'showAbroadItemDataPopup']);

    // Revenue distribution
    Route::post('sales/revenue-distribution/edu/get-sales-revenued-list', [RevenueDistributionController::class, 'getSalesRevenuedList']);

    // Courses
    Route::get('sales/courses', [CourseController::class, 'index']);

    // Note logs
    Route::get('sales/note-logs', [NoteLogController::class, 'index']);
    Route::get('sales/note-logs/list', [NoteLogController::class, 'list']);
    Route::get('sales/note-logs/{id}/edit', [NoteLogController::class, 'edit']);
    Route::put('sales/note-logs/{id}', [NoteLogController::class, 'update']);
    Route::post('sales/note-logs/{id}', [NoteLogController::class, 'update']);
    Route::delete('sales/note-logs/{id}', [NoteLogController::class, 'destroy']);
    Route::delete('sales/note-logs', [NoteLogController::class, 'destroyAll']);
    Route::get('sales/note-logs/create', [NoteLogController::class, 'create']);
    Route::post('sales/note-logs/add-notelog/{id}', [NoteLogController::class, 'storeNoteLog']);
    Route::get('sales/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'createNoteLogCustomer']);
    Route::post('sales/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'storeNoteLogCustomer']);
    Route::post('sales/note-logs', [NoteLogController::class, 'store']);
    Route::get('sales/note-logs/note-logs-popup/{id}', [NoteLogController::class, 'noteLogsPopup']);
    Route::get('sales/note-logs/add-notelog-contact/{id}', [NoteLogController::class, 'addNoteLog']);

    //Report
    // Route::get('sales/monthly-kpi-report', [KPIReportController::class, 'indexMonthlyKPIReport']);
    // Route::get('sales/monthly-kpi-report/list', [KPIReportController::class, 'listMonthlyKPIReport']);

    Route::get('sales/daily-kpi-report', [KPIReportController::class, 'indexDailyKPIReportIndex']);
    Route::get('sales/daily-kpi-report/list', [KPIReportController::class, 'listDailyKPIReport']);
    Route::get('sales/daily-kpi-report/export-filter', [KPIReportController::class, 'showFilterForm']);
    Route::post('sales/daily-kpi-report/exportRun', [KPIReportController::class,'exportRun']);
    Route::get('sales/daily-kpi-report/exportDownload', [KPIReportController::class, 'exportDownload']);

    Route::get('sales/contract-status-report', [ContractStatusController::class, 'index']);
    Route::get('sales/contract-status-report/list', [ContractStatusController::class, 'list']);
    Route::get('sales/contract-status-report/export-filter', [ContractStatusController::class, 'showFilterForm']);
    Route::post('sales/contract-status-report/exportRun', [ContractStatusController::class,'exportRun']);
    Route::get('sales/contract-status-report/exportDownload', [ContractStatusController::class, 'exportDownload']);

    Route::get('sales/sales-report', [SalesReportController::class, 'index']);
    Route::get('sales/sales-report/list', [SalesReportController::class, 'list']);
    Route::get('sales/sales-report/export-filter', [SalesReportController::class, 'showFilterForm']);
    Route::post('sales/sales-report/exportRun', [SalesReportController::class, 'exportRun']);
    Route::get('sales/sales-report/exportDownload', [SalesReportController::class, 'exportDownload']);

    Route::get('sales/upsell-report', [UpsellReportController::class, 'index']);
    Route::get('sales/upsell-report/list', [UpsellReportController::class, 'list']);
    Route::get('sales/upsell-report/export-filter', [UpsellReportController::class, 'showFilterForm']);
    Route::post('sales/upsell-report/exportRun', [UpsellReportController::class, 'exportRun']);
    Route::get('sales/upsell-report/exportDownload', [UpsellReportController::class, 'exportDownload']);

    Route::get('sales/payment-report', [PaymentReportController::class, 'index']);
    Route::get('sales/payment-report/list', [PaymentReportController::class, 'list']);
    Route::get('sales/payment-report/export-filter', [PaymentReportController::class, 'showFilterForm']);
    Route::post('sales/payment-report/exportRun', [PaymentReportController::class, 'exportRun']);
    Route::get('sales/payment-report/exportDownload', [PaymentReportController::class, 'exportDownload']);

    Route::get('sales/revenue-report', [RevenueReportController::class, 'index']);
    Route::get('sales/revenue-report/list', [RevenueReportController::class, 'list']);

    Route::get('sales/conversion-rate', [ConversionRateReportController::class, 'index']);
    Route::get('sales/conversion-rate/list', [ConversionRateReportController::class, 'list']);
    Route::get('sales/conversion-rate/export-filter', [ConversionRateReportController::class, 'showFilterForm']);
    Route::post('sales/conversion-rate/exportRun', [ConversionRateReportController::class, 'exportRun']);
    Route::get('sales/conversion-rate/exportDownload', [ConversionRateReportController::class, 'exportDownload']);
    
    //Dashboard 
    Route::get('sales/dashboard/', [DashboardController::class, 'index']);
    Route::get('sales/dashboard/{interval}', [DashboardController::class, 'updateInterval']);

    // Education
    Route::get('sales/customers/{id}/calendar', [CustomerController::class, 'calendar']);
    Route::get('sales/customers/{id}/sectionList', [CustomerController::class, 'sectionList']);
    Route::get('sales/customers/{id}/section', [CustomerController::class, 'section']);
    Route::get('sales/customers/show-free-time-schedule/{id}', [CustomerController::class, 'showFreeTimeSchedule']);
    Route::get('sales/customers/{id}/class', [CustomerController::class, 'class']);
    Route::get('sales/customers/{id}/classList', [CustomerController::class, 'classList']);

    //Payments
    Route::get('sales/payments/create-receipt-contact', [PaymentRecordController::class, 'createReceiptContact']);
    Route::post('sales/payments/store-receipt-contact/{id}', [PaymentRecordController::class, 'storeReceiptContact']);


    //Refund_request
    Route::get('sales/refund_requests', [RefundRequestController::class, 'index']);
    Route::get('sales/refund_requests/list', [RefundRequestController::class, 'list']);
    Route::get('sales/refund_requests/{id}/showRequest', [RefundRequestController::class, 'showRequest']);

    //Hoàn phí
    Route::get('sales/students/refund-request', [StudentController::class, 'refundRequest']);
    Route::get('sales/students/course-refund-request-form', [StudentController::class, 'courseRefundRequestForm']);
    Route::get('sales/students/order-item-refund-request-form', [StudentController::class, 'orderItemRefundRequestForm']);
    Route::post('sales/students/done-refund-request', [StudentController::class, 'doneRefundRequest']);
    Route::get('sales/students/select2', [StudentController::class, 'select2']);



    Route::get('sales/abroad-application', [AbroadController::class, 'index']);
    Route::get('sales/abroad-application/list', [AbroadController::class, 'list']);
    Route::delete('sales/abroad-application/delete-all', [AbroadController::class, 'deleteAll']);
    Route::get('abroad/services/get-services-by-type', [AbroadController::class, 'getServicesByType']);
    Route::get('sales/abroad-application/{id}/general', [AbroadController::class, 'general']);
    Route::get('sales/abroad-application/{id}/essay', [AbroadController::class, 'essay']);

    //IV 1 Lộ trình học thuật chiến lược
    Route::get('sales/abroad-application/{id}/strategic-learning-curriculum', [AbroadController::class, 'strategicLearningCurriculum']);
    Route::get('sales/abroad-application/{id}/strategic-learning-curriculum/declare', [AbroadController::class, 'declareStrategicLearningCurriculum']);
    Route::get('sales/abroad-application/{id}/strategic-learning-curriculum/view_declaration', [AbroadController::class, 'viewStrategicLearningCurriculum']);
    
    // IV.2 Extracurricular plan
    Route::get('sales/abroad-application/{id}/extracurricular-plan', [AbroadController::class, 'extracurricularPlan']);
    Route::get('sales/abroad-application/{id}/extracurricular-plan/declare', [AbroadController::class, 'declareExtracurricularPlan']);
    Route::get('sales/abroad-application/{id}/extracurricular-plan/view_declaration', [AbroadController::class, 'viewExtracurricularPlanDeclaration']);

    // IV.7 Recommendation letter
    Route::get('sales/abroad-application/{id}/recommendation-letter', [AbroadController::class, 'recommendationLetter']);
    Route::get('sales/abroad-application/{id}/show', [AbroadController::class, 'showDetailRecommendationLetter']);
    Route::get('sales/abroad-application/{id}/recommendation-letter/create', [AbroadController::class, 'createRecommendationLetter']);
    Route::get('sales/abroad-application/recommendation-letter/{id}/edit', [AbroadController::class, 'editRecommendationLetter']);
    Route::post('sales/abroad-application/recommendation-letter/{id}/update', [AbroadController::class, 'updateRecommendationLetter']);
    Route::post('sales/abroad-application/{id}/recommendation-letter/delete', [AbroadController::class, 'deleteRecommendationLetter']);
    Route::post('sales/abroad-application/{id}/recommendation-letter/store', [AbroadController::class, 'storeRecommendationLetter']);
    Route::put('sales/abroad-application/recommendation-letter/{id}/complete', [AbroadController::class, 'completeRecommendationLetter']);

    // IV.8 essay result 
    Route::get('sales/abroad-application/{id}/essay-result', [AbroadController::class, 'essayResult']);
    Route::get('sales/abroad-application/{id}/essay-result/create', [AbroadController::class, 'createEssayResult']);
    Route::post('sales/abroad-application/{id}/essay-result/store', [AbroadController::class, 'storeEssayResult']);
    Route::get('sales/abroad-application/{id}/essay-result/show', [AbroadController::class, 'showEssayResult']);
    Route::delete('sales/abroad-application/{id}/essay-result/delete', [AbroadController::class, 'deleteEssayResult']);
    Route::get('sales/abroad-application/essay-result/{id}/edit', [AbroadController::class, 'editEssayResult']);
    Route::post('sales/abroad-application/essay-result/{id}/update', [AbroadController::class, 'updateEssayResult']);
    Route::post('sales/abroad-application/{id}/essay-result-file/delete', [AbroadController::class, 'deleteEssayResultFile']);

    // IV.8 Mạng xã hội 
    Route::get('sales/abroad-application/{id}/social-network', [AbroadController::class, 'socialNetwork']);
    Route::get('sales/abroad-application/{id}/update-social-network', [AbroadController::class, 'updateSocialNetwork']);
    Route::put('sales/abroad-application/{id}/done-update-social-network', [AbroadController::class, 'doneUpdateSocialNetwork']);
    Route::get('sales/abroad-application/{id}/create-social-network', [AbroadController::class, 'createSocialNetwork']);
    Route::put('sales/abroad-application/{id}/done-create-social-network', [AbroadController::class, 'doneCreateSocialNetwork']);
    Route::get('sales/abroad-application/{id}/social-network-declaration', [AbroadController::class, 'socialNetworkDeclaration']);
    Route::put('sales/abroad-application/update-active-social-network', [AbroadController::class, 'updateActiveSocialNetwork']);
    Route::get('sales/abroad-application/{id}/social-network-show', [AbroadController::class, 'socialNetworkShow']);

    // IV.10 Study Abroad Application   
    Route::get('sales/abroad-application/{id}/study-abroad-application', [AbroadController::class, 'studyAbroadApplication']);
    Route::get('sales/abroad-application/{id}/create-study-abroad-application', [AbroadController::class, 'createStudyAbroadApplication']);
    Route::get('sales/abroad-application/{id}/create-study-abroad-application-popup', [AbroadController::class, 'createStudyAbroadApplicationPopup']);
    Route::post('sales/abroad-application/{id}/done-create-study-abroad-application', [AbroadController::class, 'saveStudyAbroadApplication']);
    Route::put('sales/abroad-application/{id}/update-status-study-abroad-application-all', [AbroadController::class, 'updateStatusStudyAbroadApplicationAll']);
    Route::get('sales/abroad-application/{id}/edit-study-abroad-application-popup', [AbroadController::class, 'editStudyAbroadApplicationPopup']);
    Route::post('sales/abroad-application/{id}/update-study-abroad-application-popup', [AbroadController::class, 'updateStudyAbroadApplication']);
    Route::put('sales/abroad-application/{id}/update-status-study-abroad-application', [AbroadController::class, 'completeStatusActive']);
    Route::get('sales/abroad-application/{id}/show-study-abroad-application', [AbroadController::class, 'showStudyAbroadApplication']);
    Route::post('sales/abroad-application/{id}/file-study-abroad-application/store', [AbroadController::class, 'storeFileStudyAbroadApplication']);
    Route::post('sales/abroad-application/{id}/file-study-abroad-application/delete', [AbroadController::class, 'deleteFileStudyAbroadApplication']);

    // IV.11 Student CV
    Route::get('sales/abroad-application/{id}/student-cv', [AbroadController::class, 'studentCV']);
    Route::post('sales/abroad-application/{id}/cv/store', [AbroadController::class, 'storeCV']);
    Route::post('sales/abroad-application/{id}/cv/delete', [AbroadController::class, 'deleteCV']);

    // V.1 Honor thesis
    Route::get('sales/abroad-application/{id}/honor-thesis', [AbroadController::class, 'honorThesis']);

    // V.2 Edit thesis/Sửa Luận
    Route::get('sales/abroad-application/{id}/edit-thesis', [AbroadController::class, 'editThesis']);

    // V.5 Interview Practice/ Luyện phỏng vấn
    Route::get('sales/abroad-application/{id}/interview-practice', [AbroadController::class, 'interviewPractice']);

    // V.2 Application fee
    Route::get('sales/abroad-application/{id}/application-fee', [AbroadController::class, 'applicationFee']);
    Route::get('sales/abroad-application/{id}/create-application-fee', [AbroadController::class, 'createApplicationFee']);
    Route::post('sales/abroad-application/{id}/done-create-application-fee', [AbroadController::class, 'doneCreateApplicationFee']);
    Route::get('sales/abroad-application/{id}/edit-application-fee', [AbroadController::class, 'editApplicationFee']);
    Route::post('sales/abroad-application/{id}/update-application-fee', [AbroadController::class, 'updateApplicationFee']);
    Route::get('sales/abroad-application/{id}/pay-and-confirm', [AbroadController::class, 'payAndConfirm']);
    Route::get('sales/abroad-application/{id}/show-pay-and-confirm', [AbroadController::class, 'showPayAndConfirm']);
    Route::post('sales/abroad-application/{id}/file-confirmation/store', [AbroadController::class, 'storeFileConfirmation']);
    Route::post('sales/abroad-application/{id}/file-confirmation/delete', [AbroadController::class, 'deleteFileComfirmation']);
    Route::post('sales/abroad-application/{id}/file-fee-paid/store', [AbroadController::class, 'storeFileFeePaid']);
    Route::post('sales/abroad-application/{id}/file-fee-paid/delete', [AbroadController::class, 'deleteFileFeePaid']);

    // V.3 Submit application
    Route::get('sales/abroad-application/{id}/application-submission', [AbroadController::class, 'applicationSubmission']);
    Route::get('sales/abroad-application/{id}/create-application-submission', [AbroadController::class, 'createApplicationSubmission']);
    Route::post('sales/abroad-application/{id}/done-application-submission', [AbroadController::class, 'doneApplicationSubmission']);
    Route::get('sales/abroad-application/{id}/edit-application-submission', [AbroadController::class, 'editApplicationSubmission']);
    Route::post('sales/abroad-application/{id}/update-application-submission', [AbroadController::class, 'updateApplicationSubmission']);

    // V.5 School Selected Result
    Route::get('sales/abroad-application/{id}/application-admitted-school', [AbroadController::class, 'applicationAdmittedSchool']);
    Route::get('sales/abroad-application/{id}/create-application-admitted-school', [AbroadController::class, 'createApplicationAdmittedSchool']);
    Route::post('sales/abroad-application/{id}/done-application-admitted-school', [AbroadController::class, 'doneApplicationAdmittedSchool']);
    Route::post('sales/abroad-application/{id}/save-school-selected', [AbroadController::class, 'saveSchoolSelected']);
    Route::get('sales/abroad-application/{id}/edit-application-admitted-school', [AbroadController::class, 'editApplicationAdmittedSchool']);
    Route::post('sales/abroad-application/{id}/update-application-admitted-school', [AbroadController::class, 'updateApplicationAdmittedSchool']);

    // V.6 Deposit tuition fee
    Route::get('sales/abroad-application/{id}/deposit-tuition-fee', [AbroadController::class, 'depositTuitionFee']);
    Route::post('sales/abroad-application/{id}/deposit-data/update', [AbroadController::class, 'updateDepositData']);
    Route::post('sales/abroad-application/{id}/deposit-file/store', [AbroadController::class, 'storeDepositFile']);
    Route::post('sales/abroad-application/{id}/deposit-file/delete', [AbroadController::class, 'deleteDepositFile']);

    // V.7 Deposit for school
    Route::get('sales/abroad-application/{id}/deposit-for-school', [AbroadController::class, 'depositForSchool']);
    Route::post('sales/abroad-application/{id}/deposit-for-school/update', [AbroadController::class, 'updateDepositForSchool']);
    Route::post('sales/abroad-application/{id}/deposit-for-school/store', [AbroadController::class, 'storeDepositForSchool']);
    Route::post('sales/abroad-application/{id}/deposit-for-school/delete', [AbroadController::class, 'deleteDepositForSchool']);
  
    // V.9 Cultural Orientations
    Route::get('sales/abroad-application/{id}/cultural-orientations', [AbroadController::class, 'culturalOrientations']);
    Route::get('sales/abroad-application/{id}/update-cultural-orientation', [AbroadController::class, 'updateCulturalOrientation']);
    Route::put('sales/abroad-application/{id}/done-update-cultural-orientation', [AbroadController::class, 'doneUpdateCulturalOrientation']);
    Route::get('sales/abroad-application/{id}/create-cultural-orientation', [AbroadController::class, 'createCulturalOrientation']);
    Route::put('sales/abroad-application/{id}/done-create-cultural-orientation', [AbroadController::class, 'doneCreateCulturalOrientation']);

    // V.10 Support Activities
    Route::get('sales/abroad-application/{id}/support-activities', [AbroadController::class, 'supportActivities']);
    Route::get('sales/abroad-application/{id}/update-support-activity', [AbroadController::class, 'updateSupportActivity']);
    Route::put('sales/abroad-application/{id}/done-update-support-activity', [AbroadController::class, 'doneUpdateSupportActivity']);
    Route::get('sales/abroad-application/{id}/create-support-activity', [AbroadController::class, 'createSupportActivity']);
    Route::put('sales/abroad-application/{id}/done-create-support-activity', [AbroadController::class, 'doneCreateSupportActivity']);

    // VI.6 Flying sales/ Thời điểm học sinh lên đường
    Route::get('sales/abroad-application/{id}/flying-student', [AbroadController::class, 'flyingStudent']);
    Route::get('sales/abroad-application/{id}/create-flying-student', [AbroadController::class, 'createFlyingStudent']);
    Route::post('sales/abroad-application/{id}/done-create-flying-student', [AbroadController::class, 'doneCreateFlyingStudent']);
    Route::get('sales/abroad-application/{id}/update-flying-student', [AbroadController::class, 'updateFlyingStudent']);
    Route::post('sales/abroad-application/{id}/done-update-flying-student', [AbroadController::class, 'doneUpdateFlyingStudent']);
    
    // VI.7 Complete application
    Route::get('sales/abroad-application/{id}/complete-application', [AbroadController::class, 'completeApplication']);
    Route::post('sales/abroad-application/{id}/request-approval-complete-application', [AbroadController::class, 'requestApprovalCompleteApplication']);
    Route::post('sales/abroad-application/{id}/approval-complete-application', [AbroadController::class, 'approveCompleteApplication']);
    Route::post('sales/abroad-application/{id}/reject-complete-application', [AbroadController::class, 'rejectCompleteApplication']);

    // Kết quả dự tuyển
    Route::get('sales/abroad-application/{id}/admissionLetter', [AbroadController::class, 'admissionLetter']);
    Route::post('sales/abroad-application/{id}/admission-letter/store-admission-letter', [AbroadController::class, 'storeAdmissionLetter']);
    Route::post('sales/abroad-application/{id}/admission-letter/delete-admission-letter', [AbroadController::class, 'deleteAdmissionLetter']);
    Route::get('sales/abroad-application/{id}/create-admission-letter', [AbroadController::class, 'createAdmissionLetter']);
    Route::post('sales/abroad-application/{id}/admission-letter/store', [AbroadController::class, 'storeScholarshipFile']);
    Route::post('sales/abroad-application/{id}/admission-letter/delete', [AbroadController::class, 'deleteScholarshipFile']);
    Route::put('sales/abroad-application/{id}/done-create-recruitment-results', [AbroadController::class, 'doneCreateRecruitmentResults']);
    Route::put('sales/abroad-application/update-active-recruitment-results', [AbroadController::class, 'updateActiveRecruitmentResults']);
    // Route::get('sales/abroad-application/{id}/create-study-abroad-application-popup', [AbroadController::class, 'createStudyAbroadApplicationPopup']);
    // Route::post('sales/abroad-application/{id}/done-create-study-abroad-application', [AbroadController::class, 'saveStudyAbroadApplication']);
    // Route::put('sales/abroad-application/{id}/update-status-study-abroad-application-all', [AbroadController::class, 'updateStatusStudyAbroadApplicationAll']);
    // Route::get('sales/abroad-application/{id}/edit-study-abroad-application-popup', [AbroadController::class, 'editStudyAbroadApplicationPopup']);
    // Route::post('sales/abroad-application/{id}/update-study-abroad-application-popup', [AbroadController::class, 'updateStudyAbroadApplication']);
    // Route::put('sales/abroad-application/{id}/update-status-study-abroad-application', [AbroadController::class, 'completeStatusActive']);
    Route::get('sales/abroad-application/{id}/show-recruitment-results', [AbroadController::class, 'showRecruitmentResults']);

    // Hồ sơ tài chính
    Route::get('sales/abroad-application/{id}/financial-document', [AbroadController::class, 'financialDocument']);
    Route::post('sales/abroad-application/{id}/financial-document/store-financial-document', [AbroadController::class, 'storeFinancialDocument']);
    Route::post('sales/abroad-application/{id}/financial-document/delete-financial-document', [AbroadController::class, 'deleteFinancialDocument']);

    // Hồ sơ dự tuyển
    Route::get('sales/abroad-application/{id}/hsdt', [AbroadController::class, 'hsdt']);
    Route::post('sales/abroad-application/{id}/request-approval-hsdt', [AbroadController::class, 'requestApprovalHSDT']);
    Route::post('sales/abroad-application/{id}/approval-hsdt', [AbroadController::class, 'approveHSDT']);
    Route::post('sales/abroad-application/{id}/reject-hsdt', [AbroadController::class, 'rejectHSDT']);

    // Hồ sơ hoàn chỉnh
    Route::get('sales/abroad-application/{id}/complete-file', [AbroadController::class, 'completeFile']);
    Route::post('sales/abroad-application/{id}/complete-file/store-complete-file', [AbroadController::class, 'storeCompleteFile']);
    Route::post('sales/abroad-application/{id}/complete-file/delete-complete-file', [AbroadController::class, 'deleteCompleteFile']);

    // 15 Bản scan thông tin các nhân
    Route::get('sales/abroad-application/{id}/scan-of-information', [AbroadController::class, 'scanOfInformation']);
    Route::post('sales/abroad-application/{id}/scan-of-information/store-scan-of-information', [AbroadController::class, 'storeScanOfInformation']);
    Route::post('sales/abroad-application/{id}/scan-of-information/delete-scan-of-information', [AbroadController::class, 'deleteScanOfInformation']);

    // Kế hoạch ngoại khoá
    Route::get('sales/abroad-application/{id}/extracurricular-schedule', [AbroadController::class, 'extracurricularSchedule']);
    Route::get('sales/abroad-application/{id}/create-extracurricular-schedule', [AbroadController::class, 'createExtracurricularSchedule']);
    Route::put('sales/abroad-application/{id}/done-create-extracurricular-schedule', [AbroadController::class, 'doneCreateExtracurricularSchedule']);
    Route::get('sales/abroad-application/{id}/update-extracurricular-schedule', [AbroadController::class, 'updateExtracurricularSchedule']);
    Route::put('sales/abroad-application/{id}/done-update-extracurricular-schedule', [AbroadController::class, 'doneUpdateExtracurricularSchedule']);
    Route::get('sales/abroad-application/{id}/extracurricular-schedule-declaration', [AbroadController::class, 'extracurricularScheduleDeclaration']);
    Route::get('sales/abroad-application/{id}/extracurricular-schedule-show', [AbroadController::class, 'extracurricularScheduleShow']);
    Route::put('sales/abroad-application/update-active-extracurricular-schedule', [AbroadController::class, 'updateActiveExtracurricularSchedule']);
    Route::put('sales/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularSchedule']);

    // Chứng chỉ
    Route::get('sales/abroad-application/{id}/certifications', [AbroadController::class, 'certifications']);
    Route::get('sales/abroad-application/{id}/update-certification', [AbroadController::class, 'updateCertification']);
    Route::put('sales/abroad-application/{id}/done-update-certification', [AbroadController::class, 'doneCreateCertification']);
    Route::get('sales/abroad-application/{id}/create-certifications', [AbroadController::class, 'createCertifications']);
    Route::put('sales/abroad-application/{id}/done-create-certifications', [AbroadController::class, 'doneUpdateCertification']);
    Route::get('sales/abroad-application/{id}/certification-declaration', [AbroadController::class, 'certificationDeclaration']);
    Route::get('sales/abroad-application/{id}/certification-show', [AbroadController::class, 'certificationShow']);
    Route::put('sales/abroad-application/update-active-certification', [AbroadController::class, 'updateActiveCertification']);
    Route::put('sales/abroad-application/update-draft-certification', [AbroadController::class, 'updateDraftCertification']);

    // Hoạt động ngoại khoá
    Route::get('sales/abroad-application/{id}/extracurricular-activity', [AbroadController::class, 'extracurricularActivity']);
    Route::get('sales/abroad-application/{id}/create-extracurricular-activity', [AbroadController::class, 'createExtracurricularActivity']);
    Route::put('sales/abroad-application/{id}/done-create-extracurricular-activity', [AbroadController::class, 'doneCreateExtracurricularActivity']);
    Route::get('sales/abroad-application/{id}/update-extracurricular-activity', [AbroadController::class, 'updateExtracurricularActivity']);
    Route::put('sales/abroad-application/{id}/done-update-extracurricular-activity', [AbroadController::class, 'doneUpdateExtracurricularActivity']);
    Route::get('sales/abroad-application/{id}/extracurricular-activity-declaration', [AbroadController::class, 'extracurricularActivityDeclaration']);
    Route::get('sales/abroad-application/{id}/extracurricular-activity-show', [AbroadController::class, 'extracurricularActivityShow']);
    Route::put('sales/abroad-application/update-active-extracurricular-activity', [AbroadController::class, 'updateActiveExtracurricularActivity']);
    Route::put('sales/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularActivity']);

    // Danh sách trường yêu cầu tuyển sinh
    Route::get('sales/abroad-application/{id}/application-school', [AbroadController::class, 'applicationSchool']);
    Route::get('sales/abroad-application/{id}/application-school-declaration', [AbroadController::class, 'applicationSchoolDeclaration']);
    Route::get('sales/abroad-application/{id}/update-application-school', [AbroadController::class, 'updateApplicationSchool']);
    Route::get('sales/abroad-application/{id}/create-application-school', [AbroadController::class, 'createApplicationSchool']);
    Route::put('sales/abroad-application/{id}/done-create-application-school', [AbroadController::class, 'doneCreateApplicationSchool']);
    Route::put('sales/abroad-application/{id}/done-update-application-school', [AbroadController::class, 'doneUpdateApplicationSchool']);
    Route::put('sales/abroad-application/update-active-application-school', [AbroadController::class, 'updateActiveApplicationSchool']);
    Route::get('sales/abroad-application/{id}/application-school-show', [AbroadController::class, 'applicationSchoolShow']);

    // Visa cho học sinh
    Route::get('sales/abroad-application/{id}/student-visa', [AbroadController::class, 'studentVisa']);
    Route::post('sales/abroad-application/{id}/student-visa-data/update', [AbroadController::class, 'updateStudentVisaData']);
    Route::post('sales/abroad-application/{id}/student-visa-file/store', [AbroadController::class, 'storeStudentVisaFile']);
    Route::post('sales/abroad-application/{id}/student-visa-file/delete', [AbroadController::class, 'deleteStudentVisaFile']);

    // Abroad Application
    Route::get('sales/abroad-application/{id}/details', [AbroadApplicationController::class, 'details']);
    Route::get('sales/abroad-application/select2', [AbroadApplicationController::class, 'select2']);
    Route::get('sales/abroad-application/{id}/update-status-abroad-application', [AbroadController::class, 'updateStatusAbroadApplication']);
    Route::put('sales/abroad-application/{id}/done-update-status-abroad-application', [AbroadController::class, 'doneAssignmentAbroadApplication']);


    //One pay
    Route::get('sales/payments/createReceipt/{id}', [OnePayController::class, 'createReceipt']);
    Route::get('sales/payments/showLink', [OnePayController::class, 'showLink']);
    Route::get('sales/payment_reminders/one-pay/{amount}', [OnePayController::class, 'onepayPayment']);
    Route::match(['get', 'post'], '/ipn', [OnePayController::class, 'handleIPN']);
});
Route::match(['get', 'post'], '/onepay/process', [OnePayController::class, 'process']);

