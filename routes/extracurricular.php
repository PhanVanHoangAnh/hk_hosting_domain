<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Abroad\ExtracurricularController;
use App\Http\Controllers\Abroad\ExtracurricularStudentController;
use App\Http\Controllers\Abroad\ContactController;
use App\Http\Controllers\Abroad\ContactRequestController;
use App\Http\Controllers\Abroad\OrderItemController;
use App\Http\Controllers\Abroad\OrderController;
use App\Http\Controllers\Abroad\RevenueDistributionController;
use App\Http\Controllers\Abroad\AbroadController;
use App\Http\Controllers\Abroad\AbroadApplicationFinishDayController;
use App\Http\Controllers\Abroad\AbroadApplicationStatusController;
use App\Http\Controllers\Abroad\AbroadApplicationController;
use App\Http\Controllers\Abroad\LoTrinhChienLuocController;
use App\Http\Controllers\Abroad\LoTrinhHoatDongNgoaiKhoaController;

Route::middleware('auth', 'extracurricular', 'check.password.change')->group(function () {


    Route::put('extracurricular/{id}/done-update-status-abroad-application', [ExtracurricularController::class, 'doneAssignmentAbroadApplication']);

    // Extracurricular
    Route::get('extracurricular/index/{id?}', [ExtracurricularController::class, 'index']);
    Route::get('extracurricular/list', [ExtracurricularController::class, 'list']);
    Route::get('extracurricular/create', [ExtracurricularController::class, 'create']);
    Route::put('extracurricular/save', [ExtracurricularController::class, 'save']);
    Route::get('extracurricular/{id}/edit', [ExtracurricularController::class, 'edit']);
    Route::put('extracurricular/{id}/save', [ExtracurricularController::class, 'update']);
    Route::delete('extracurricular/{id}/delete', [ExtracurricularController::class, 'delete']);
    Route::get('extracurricular/{id}/details', [ExtracurricularController::class, 'details']);
    Route::get('extracurricular/management', [ExtracurricularController::class, 'management']);
    Route::get('extracurricular/{id}/extracurricular-plan', [ExtracurricularController::class, 'extracurricularPlan']);
    Route::get('extracurricular/{id}/extracurricular-activity', [ExtracurricularController::class, 'extracurricularActivity']);
    Route::get('extracurricular/{id}/extracurricular-schedule', [ExtracurricularController::class, 'extracurricularSchedule']);
    Route::get('extracurricular/{id}/certifications', [ExtracurricularController::class, 'certifications']);
    Route::get('extracurricular/approval', [ExtracurricularController::class, 'approval']);
    Route::get('extracurricular/approval-list', [ExtracurricularController::class, 'approvalList']);
    Route::get('extracurricular/{id}/handover', [ExtracurricularController::class, 'handover']);
    Route::get('extracurricular/{id}/strategic-learning-curriculum', [ExtracurricularController::class, 'strategicLearningCurriculum']);
    Route::get('extracurricular/{id}/strategic-learning-curriculum/view_declaration', [ExtracurricularController::class, 'viewStrategicLearningCurriculum']);
    Route::get('extracurricular/{id}/application-school-show', [ExtracurricularController::class, 'applicationSchoolShow']);
    Route::get('extracurricular/{id}/application-school', [ExtracurricularController::class, 'applicationSchool']);

    // Extracurricular Student
    Route::get('extracurricular-student/index/{id}', [ExtracurricularStudentController::class, 'index']);
    Route::get('extracurricular-student/list', [ExtracurricularStudentController::class, 'list']);
    Route::get('extracurricular-student/{id}/create', [ExtracurricularStudentController::class, 'create']);
    Route::put('extracurricular-student/save', [ExtracurricularStudentController::class, 'save']);
    Route::get('extracurricular-student/select2', [ExtracurricularStudentController::class, 'select2']);
    Route::get('extracurricular-student/{id}/edit', [ExtracurricularStudentController::class, 'edit']);
    Route::get('extracurricular-student/indexShow/{id}', [ExtracurricularStudentController::class, 'indexShow']);

    //Contact Request
    Route::get('extracurricular/contact_requests/show-freetime-schedule/{id}', [ContactRequestController::class, 'showFreeTimeSchedule']);
    Route::get('extracurricular/contact_requests/{id}/create-freetime-schedule', [ContactRequestController::class, 'createFreetimeSchedule']);
    Route::post('extracurricular/contact_requests/{id}/save-freetime-schedule', [ContactRequestController::class, 'saveFreetimeSchedule']);
    Route::get('extracurricular/contact_requests/{id}/edit-freetime-schedule', [ContactRequestController::class, 'editFreetimeSchedule']);
    Route::put('extracurricular/contact_requests/{id}/update-freetime-schedule', [ContactRequestController::class, 'updateFreetimeSchedule']);

    Route::post('extracurricular/contact_requests/{id}/save', [ContactRequestController::class, 'save']);
    Route::get('extracurricular/contact_requests/select2', [ContactRequestController::class, 'select2']);
    Route::get('extracurricular/contact_requests/add-tags', [ContactRequestController::class, 'addTags']);
    Route::get('extracurricular/contact_requests/delete-tags', [ContactRequestController::class, 'deleteTags']);
    Route::get('extracurricular/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulk']);
    Route::put('extracurricular/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulkSave']);
    Route::delete('extracurricular/contact_requests/action-delete-tags', [ContactRequestController::class, 'actionDeleteTags']);
    Route::get('extracurricular/contact_requests/handover/{id}', [ContactRequestController::class, 'addHandover']);
    Route::put('extracurricular/contact_requests/handover/{id}', [ContactRequestController::class, 'saveHandover']);
    Route::get('extracurricular/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulk']);
    Route::put('extracurricular/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulkSave']);
    Route::get('extracurricular/contact_requests/{id}/update-history', [ContactRequestController::class, 'updateHistory']);
    Route::get('extracurricular/contact_requests/{id}/extra-activity', [ContactRequestController::class, 'extraActivity']);
    Route::get('extracurricular/contact_requests/{id}/kid-tech', [ContactRequestController::class, 'kidTech']);
    Route::get('extracurricular/contact_requests/{id}/study-abroad', [ContactRequestController::class, 'studyAbroad']);
    Route::get('extracurricular/contact_requests/{id}/debt', [ContactRequestController::class, 'debt']);
    Route::get('extracurricular/contact_requests/{id}/education', [ContactRequestController::class, 'education']);
    Route::get('extracurricular/contact_requests/{id}/contract', [ContactRequestController::class, 'contract']);
    
    Route::get('extracurricular/contact_requests/{id}/show', [ContactRequestController::class, 'show']);
    Route::get('extracurricular/contact_requests/{id}/edit', [ContactRequestController::class, 'edit']);
    Route::put('extracurricular/contact_requests/{id}', [ContactRequestController::class, 'update']);
    Route::post('extracurricular/contact_requests/import/hubspot/run', [ContactRequestController::class, 'importHubspotRun']);
    Route::get('extracurricular/contact_requests/import/hubspot', [ContactRequestController::class, 'importHubspot']);
    Route::get('extracurricular/contact_requests/import/excel', [ContactRequestController::class, 'importExcel']);
    Route::post('extracurricular/contact_requests/import/excel', [ContactRequestController::class, 'importExcelShow']);
    Route::post('extracurricular/contact_requests/import/excel/run', [ContactRequestController::class, 'importExcelRunning']);
    Route::post('extracurricular/contact_requests/import/excel/test-results', [ContactRequestController::class, 'testImportDone']);
    Route::get('extracurricular/contact_requests/import/excel/download-log', [ContactRequestController::class, 'downloadLog']);
    Route::delete('extracurricular/contact_requests/{id}', [ContactRequestController::class, 'destroy']);
    Route::post('extracurricular/contact_requests', [ContactRequestController::class, 'store']);
    Route::get('extracurricular/contact_requests/create', [ContactRequestController::class, 'create']);
    Route::get('extracurricular/contact_requests/list', [ContactRequestController::class, 'list']);
    Route::get('extracurricular/contact_requests', [ContactRequestController::class, 'index']);
    Route::get('extracurricular/contact_requests/export-filter', [ContactRequestController::class, 'showFilterForm']);
    Route::post('extracurricular/contact_requests/exportRun', [ContactRequestController::class, 'exportRun']);
    Route::get('extracurricular/contact_requests/exportDownload', [ContactRequestController::class, 'exportDownload']);
    Route::get('extracurricular/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelected']);
    Route::post('extracurricular/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelectedRun']);
    Route::get('extracurricular/contact_requests/export-contact-selected/run', [ContactRequestController::class, 'exportContactRequestSelectedDownload']);
    Route::post('extracurricular/contact_requests/delete-all', [ContactRequestController::class, 'deleteAll']);

    Route::get('extracurricular/contact_requests/{id}/create-freetime-schedule', [ContactRequestController::class, 'createFreetimeSchedule']);
    Route::post('extracurricular/contact_requests/{id}/save-freetime-schedule', [ContactRequestController::class, 'saveFreetimeSchedule']);
    Route::get('extracurricular/contact_requests/{id}/edit-freetime-schedule', [ContactRequestController::class, 'editFreetimeSchedule']);
    Route::put('extracurricular/contact_requests/{id}/update-freetime-schedule', [ContactRequestController::class, 'updateFreetimeSchedule']);
    Route::delete('extracurricular/contact_requests/{id}/delete-busy-schedule', [ContactRequestController::class, 'deleteFreeTime']);


    // Orders
    Route::get('extracurricular/orders/relationship-form', [OrderController::class, 'relationshipForm']);
    Route::get('extracurricular/orders', [OrderController::class, 'index']);
    Route::get('extracurricular/orders/list', [OrderController::class, 'list']);
    Route::get('extracurricular/orders/showConstract', [OrderController::class, 'showConstract']);
    Route::get('extracurricular/orders/contact/pick', [OrderController::class, 'pickContact']);
    Route::get('extracurricular/orders/contact/request/pick', [OrderController::class, 'pickContactRequest']);
    Route::get('extracurricular/orders/contactForRequestDemo', [OrderController::class, 'pickContactForRequestDemo']);
    Route::post('extracurricular/orders/constract', [OrderController::class, 'createConstract']);
    Route::post('extracurricular/orders/save-order-item', [OrderController::class, 'saveOrderItemData']);
    // Route::post('extracurricular/orders/save-extra-item', [OrderController::class, 'saveExtraItem']);
    Route::post('extracurricular/orders/save-constract/temp', [OrderController::class, 'saveConstractData']);
    Route::post('extracurricular/orders/save-constract', [OrderController::class, 'doneCreateConstractData']);
    Route::get('extracurricular/orders/delete-constract/{orderId}', [OrderController::class, 'showFormDeleteConstract']);
    Route::delete('extracurricular/orders/delete', [OrderController::class, 'delete']);
    Route::delete('extracurricular/orders/order-item', [OrderItemController::class, 'delete']);
    Route::get('extracurricular/orders/create-constract/{orderId}/{actionType}', [OrderController::class, 'showFormCreateConstract']);
    Route::get('extracurricular/orders/{orderId/create/train', [OrderController::class, 'createTrainOrder']);
    Route::get('extracurricular/orders/create/extra', [OrderController::class, 'showCreateExtraPopup']);
    Route::get('extracurricular/orders/create/abroad', [OrderController::class, 'createAbroadOrder']);
    Route::get('extracurricular/orders/create/demo', [OrderController::class, 'createDemoOrder']);
    Route::post('extracurricular/orders/{id}/request-approval', [OrderController::class, 'requestApproval']);
    Route::get('extracurricular/order-item/{id}/copy', [OrderItemController::class, 'copy']);
    Route::post('extracurricular/orders/delete-all', [OrderController::class, 'deleteAll']);
    Route::post('extracurricular/orders/get-total-price-of-items', [OrderController::class, 'getTotalPriceOfItems']);
    route::get('extracurricular/orders/get-sale-sup/{orderId}', [OrderController::class, 'getSaleSup']);
    Route::post('extracurricular/orders/{id}/confirm-request-demo', [OrderController::class, 'confirmRequestDemo']);
    Route::get('extracurricular/orders/{id}/showQrCode', [OrderController::class, 'showQrCode']);
    Route::get('extracurricular/orders/{id}/history-rejected', [OrderController::class, 'historyRejected']);
    // Route::get('extracurricular/orders/order-items/select2', [OrderItemController::class, 'select2']);
    Route::post('extracurricular/orders/save-sale/', [OrderController::class, 'saveSale']);
    
    // Contact
    Route::get('extracurricular/contacts/related-contacts-box', [ContactController::class, 'relatedContactsBox']);
    Route::get('extracurricular/contacts/{id}/info-box', [ContactController::class, 'infoBox']);
    Route::get('extracurricular/contacts/note-logs-popup/{id}', [ContactController::class, 'noteLogsPopup']);
    Route::post('extracurricular/contacts/{id}/save', [ContactController::class, 'save']);
    Route::get('extracurricular/contacts/select2', [ContactController::class, 'select2']);
    Route::get('extracurricular/contacts/add-tags', [ContactController::class, 'addTags']);
    Route::get('extracurricular/contacts/delete-tags', [ContactController::class, 'deleteTags']);
    Route::get('extracurricular/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulk']);
    Route::put('extracurricular/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulkSave']);
    Route::delete('extracurricular/contacts/action-delete-tags', [ContactController::class, 'actionDeleteTags']);
    Route::get('extracurricular/contacts/{id}/update-history', [ContactController::class, 'updateHistory']);
    Route::get('extracurricular/contacts/{id}/note-logs', [ContactController::class, 'noteLog']);
    Route::get('extracurricular/contacts/note-logs-list/{id}', [ContactController::class, 'noteLogList']);
    Route::get('extracurricular/contacts/{id}/study-abroad', [ContactController::class, 'studyAbroad']);
    Route::get('extracurricular/contacts/{id}/extra-activity', [ContactController::class, 'extraActivity']);
    Route::get('extracurricular/contacts/{id}/kid-tech', [ContactController::class, 'kidTech']);
    Route::get('extracurricular/contacts/{id}/debt', [ContactController::class, 'debt']);
    Route::get('extracurricular/contacts/{id}/education', [ContactController::class, 'education']);
    Route::get('extracurricular/contacts/{id}/contract', [ContactController::class, 'contract']);
    Route::get('extracurricular/contacts/{id}/show', [ContactController::class, 'show']);
    Route::get('extracurricular/contacts/{id}/edit', [ContactController::class, 'edit']);
    Route::put('extracurricular/contacts/{id}', [ContactController::class, 'update']);
    Route::post('extracurricular/contacts/import/hubspot/run', [ContactController::class, 'importHubspotRun']);
    Route::get('extracurricular/contacts/import/hubspot', [ContactController::class, 'importHubspot']);
    Route::get('extracurricular/contacts/import/excel', [ContactController::class, 'importExcel']);
    Route::post('extracurricular/contacts/import/excel', [ContactController::class, 'importExcelShow']);
    Route::post('extracurricular/contacts/import/excel/run', [ContactController::class, 'importExcelRunning']);
    Route::post('extracurricular/contacts/import/excel/test-results', [ContactController::class, 'testImportDone']);
    Route::get('extracurricular/contacts/import/excel/download-log', [ContactController::class, 'downloadLog']);
    Route::delete('extracurricular/contacts/{id}', [ContactController::class, 'destroy']);
    Route::post('extracurricular/contacts', [ContactController::class, 'store']);
    Route::get('extracurricular/contacts/create', [ContactController::class, 'create']);
    Route::get('extracurricular/contacts/list', [ContactController::class, 'list']);
    Route::get('extracurricular/contacts', [ContactController::class, 'index']);
    Route::post('extracurricular/contacts/delete-all', [ContactController::class, 'deleteAll']);
    // Route::get('abroad/{id}/get-sale-sup-by-sale', [AccountController::class, 'getSaleSupBySale']);

    Route::get('extracurricular/contacts/export', [ContactController::class, 'showFilterForm']);
    Route::post('extracurricular/contacts/exportRun', [ContactController::class, 'exportRun']);
    Route::get('extracurricular/contacts/exportDownload', [ContactController::class, 'exportDownload']);

    // Route::post('extracurricular/contacts', [ContactController::class, 'storeNoteLogs']);

    Route::get('extracurricular/contacts/add-notelog-contact/{id}', [ContactController::class, 'addNoteLogContact']);
    // Route::post('extracurricular/contacts/add-notelog-contact/{id}', [ContactController::class, 'storeNoteLogContact']);

    // OrderItem
    // Route::get('extracurricular/orders/order-items/select2', [OrderItemController::class, 'select2']);

    // Revenue distribution
    Route::post('extracurricular/revenue-distribution/edu/get-sales-revenued-list', [RevenueDistributionController::class, 'getSalesRevenuedList']);


    Route::get('extracurricular/abroad-application/{id}/details', [AbroadApplicationController::class, 'detailsExtra']);



    Route::get('abroad/abroad-application/{id}/extracurricular-plan/declare', [AbroadController::class, 'declareExtracurricularPlan']);
    Route::put('abroad/abroad-application-done/update', [AbroadApplicationStatusController::class, 'updateDoneAbroadApplication']);
    
    Route::get('abroad/abroad-application/select2-extra', [AbroadApplicationController::class, 'select2ForExtracurricular']);
    // LoTrinhHocThuatChienLuoc
    // Route::put('abroad/lo-trinh-hoc-thuat-chien-luoc/save', [LoTrinhChienLuocController::class, 'createLoTrinhHocThuatChienLuoc']);
    // Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/showIeltsScore', [LoTrinhChienLuocController::class, 'showIeltsScore']);
    // Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/createIeltsScore', [LoTrinhChienLuocController::class, 'createIeltsScore']);
    // Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneCreateIeltsScore', [LoTrinhChienLuocController::class, 'doneCreateIeltsScore']);
    // Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/editIeltsScore', [LoTrinhChienLuocController::class, 'editIeltsScore']);
    // Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneEditIeltsScore', [LoTrinhChienLuocController::class, 'doneEditIeltsScore']);
    
    // Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/showSatScore', [LoTrinhChienLuocController::class, 'showSatScore']);
    // Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/createSatScore', [LoTrinhChienLuocController::class, 'createSatScore']);
    // Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneCreateSatScore', [LoTrinhChienLuocController::class, 'doneCreateSatScore']);
    // Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/editSatScore', [LoTrinhChienLuocController::class, 'editSatScore']);
    // Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneEditSatScore', [LoTrinhChienLuocController::class, 'doneEditSatScore']);
    // Lộ trình hoạt dộng ngoại khoá
    Route::put('abroad/lo-trinh-hoat-dong-ngoai-khoa/save', [LoTrinhHoatDongNgoaiKhoaController::class, 'createLoTrinhHoatDongNgoaiKhoa']);
    // Danh sách trường yêu cầu tuyển sinh
    
    
    // Kế hoạch ngoại khoá
    Route::get('abroad/abroad-application/{id}/create-extracurricular-schedule', [AbroadController::class, 'createExtracurricularSchedule']);
    Route::put('abroad/abroad-application/{id}/done-create-extracurricular-schedule', [AbroadController::class, 'doneCreateExtracurricularSchedule']);
    Route::get('abroad/abroad-application/{id}/update-extracurricular-schedule', [AbroadController::class, 'updateExtracurricularSchedule']);
    Route::put('abroad/abroad-application/{id}/done-update-extracurricular-schedule', [AbroadController::class, 'doneUpdateExtracurricularSchedule']);
    Route::get('abroad/abroad-application/{id}/extracurricular-schedule-declaration', [AbroadController::class, 'extracurricularScheduleDeclaration']);
    Route::put('abroad/abroad-application/update-active-extracurricular-schedule', [AbroadController::class, 'updateActiveExtracurricularSchedule']);
    Route::put('abroad/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularSchedule']);
    
    
    
    //Hoạt động ngoại khoá
    // Order item -> abroad
    // Route::get('abroad/order-items/edit/{id}', [AbroadController:: class, 'editAbroadItem']);
    // Route::post('abroad/order-items/save', [AbroadController:: class, 'saveAbroadItemData']);
    
    // Chứng chỉ
    //  Route::get('abroad/abroad-application/{id}/certifications', [AbroadController::class, 'certifications']);
    //  Route::get('abroad/abroad-application/{id}/update-certification', [AbroadController::class, 'updateCertification']);
    //  Route::put('abroad/abroad-application/{id}/done-update-certification', [AbroadController::class, 'doneCreateCertification']);
    //  Route::get('abroad/abroad-application/{id}/create-certifications', [AbroadController::class, 'createCertifications']);
    //  Route::put('abroad/abroad-application/{id}/done-create-certifications', [AbroadController::class, 'doneUpdateCertification']);
    //  Route::get('abroad/abroad-application/{id}/certification-declaration', [AbroadController::class, 'certificationDeclaration']);
    //  Route::put('abroad/abroad-application/update-active-certification', [AbroadController::class, 'updateActiveCertification']);
    //  Route::put('abroad/abroad-application/update-draft-certification', [AbroadController::class, 'updateDraftCertification']);
    
    Route::get('abroad/abroad-application/{id}/detailsExtra', [AbroadApplicationController::class, 'detailsExtra']);
    
});
Route::get('abroad/abroad-application/{id}/extracurricular-activity-show', [AbroadController::class, 'extracurricularActivityShow']);
Route::get('abroad/abroad-application/{id}/certification-show', [AbroadController::class, 'certificationShow']);
Route::get('abroad/abroad-application/{id}/extracurricular-schedule', [AbroadController::class, 'extracurricularSchedule']);
Route::get('abroad/abroad-application/{id}/extracurricular-schedule-show', [AbroadController::class, 'extracurricularScheduleShow']);
Route::get('abroad/abroad-application/{id}/extracurricular-plan/view_declaration', [AbroadController::class, 'viewExtracurricularPlanDeclaration']);
Route::get('abroad/abroad-application/{id}/strategic-learning-curriculum/view_declaration', [AbroadController::class, 'viewStrategicLearningCurriculum']);

// Thời điểm haonf thành
Route::put('abroad/abroad-application-finish-day/update', [AbroadApplicationFinishDayController::class, 'updateFinishDay']);
// Hoàn thành các bước
Route::put('abroad/abroad-application-done/update', [AbroadApplicationStatusController::class, 'updateDoneAbroadApplication']);

Route::get('abroad/abroad-application/{id}/application-school-show', [AbroadController::class, 'applicationSchoolShow']);