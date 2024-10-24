<?php

use App\Http\Controllers\Student\AbroadApplicationController;
use App\Http\Controllers\Student\AbroadController;
use App\Http\Controllers\Student\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Student\CustomerController;
use App\Http\Controllers\Student\ContactController;
use App\Http\Controllers\Student\ContactRequestController;
use App\Http\Controllers\Student\OrderController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\OrderItemController;
use App\Http\Controllers\Student\NoteLogController;
use App\Http\Controllers\Student\ReportController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\PaymentReminderController;
use App\Http\Controllers\Student\SectionController;
use App\Http\Controllers\Student\OnePayController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\AuthController;
use App\Http\Controllers\Student\Report\TeacherHourReportController;
use App\Http\Controllers\Student\ReserveController;
use App\Http\Controllers\Student\RefundRequestController;
use App\Http\Controllers\Student\Report\StudentHourReportController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\AccountController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Student\PasswordController;
use App\Http\Controllers\Student\CourseController2;
use App\Http\Controllers\Student\AbroadApplicationStatusController;
use App\Http\Controllers\Student\AbroadApplicationFinishDayController;
use App\Http\Controllers\Student\SectionReportsController;
use App\Http\Controllers\Student\ExtracurricularController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Student\PaymentRecordController;


use Illuminate\Support\Facades\Route;

Route::get('create-new-student', [RegisteredUserController::class, 'createNewStudent'])
  ->name('register.create.student');

Route::middleware('guest')->group(function () {
    Route::get('student/login', [AuthController::class, 'login'])->name('student.login');
    Route::post('student/login/save', [AuthController::class, 'loginSave'])->name('student.login.save');
});

Route::middleware('auth')->group(function () {
  Route::get('student/account/setup-student', [AccountController::class, 'setupStudent']);
  Route::post('student/account/setup-student-save', [AccountController::class, 'setupStudentSave']);
  Route::post('student/logout', [AccountController::class, 'logout'])
    ->name('student.logout');
});

    Route::post('student/courses/calendar', [CalendarController::class, 'getCalendar']);
    Route::post('student/courses/sections-list', [CalendarController::class, 'getSectionsList']);
    Route::post('student/courses/dashboard-calendar', [CalendarController::class, 'getDashboardCalendar']);

Route::middleware('student.auth', 'user_has_contact')->group(function () {
    // Password
    Route::get('student/profile/update-password', [ProfileController::class, 'updatePassword']);
    Route::put('student/password', [PasswordController::class, 'update'])->name('student.password.update');
});

Route::middleware('student.auth', 'user_has_contact', 'check.password.change.student')->group(function () {
    //  Dashboard
    Route::get('student', [DashboardController::class, 'index'])->name('student.index');

    // Edu
    Route::get('student/index', [CourseController::class, 'index']);
    Route::get('student/student/class', [CourseController2::class, 'class']);
    Route::get('student/student/{id}/classList', [CourseController2::class, 'classList']);
    Route::get('student/student/refund', [CourseController2::class, 'refund']);
    Route::get('student/student/{id}/refundList', [CourseController2::class, 'refundList']);
    Route::get('student/student/reserveListStudent', [CourseController2::class, 'reserveStudent']);
    Route::get('student/student/{id}/reserveList', [CourseController2::class, 'reserveList']);
    Route::get('student/student/transfer', [CourseController2::class, 'transfer']);
    Route::get('student/student/{id}/transferList', [CourseController2::class, 'transferList']);
    Route::get('student/student/reportsection', [CourseController2::class, 'reportsection']);
    // Route::get('student/student/{id}/transferList', [CourseController2::class, 'reportsectionList']);

     // Orders
     Route::get('student/orders/relationship-form', [OrderController::class, 'relationshipForm']);
     Route::get('student/orders', [OrderController::class, 'index']);
     Route::get('student/orders/list', [OrderController::class, 'list']);
     Route::get('student/orders/showConstract', [OrderController::class, 'showConstract']);
     Route::get('student/orders/contact/pick', [OrderController::class, 'pickContact']);
     Route::get('student/orders/contact/request/pick', [OrderController::class, 'pickContactRequest']);
     Route::get('student/orders/contactForRequestDemo', [OrderController::class, 'pickContactForRequestDemo']);
     Route::post('student/orders/constract', [OrderController::class, 'createConstract']);
     Route::post('student/orders/save-order-item', [OrderController::class, 'saveOrderItemData']);
     // Route::post('student/orders/save-extra-item', [OrderController::class, 'saveExtraItem']);
     Route::post('student/orders/save-constract/temp', [OrderController::class, 'saveConstractData']);
     Route::post('student/orders/save-constract', [OrderController::class, 'doneCreateConstractData']);
     Route::get('student/orders/delete-constract/{orderId}', [OrderController::class, 'showFormDeleteConstract']);
     Route::delete('student/orders/delete', [OrderController::class, 'delete']);
     Route::get('student/orders/create-constract/{orderId}/{actionType}', [OrderController::class, 'showFormCreateConstract']);
     Route::get('student/orders/create/train', [OrderController::class, 'createTrainOrder']);
     Route::get('student/orders/create/extra', [OrderController::class, 'showCreateExtraPopup']);
     Route::get('student/orders/create/abroad', [OrderController::class, 'createAbroadOrder']);
     Route::get('student/orders/create/demo', [OrderController::class, 'createDemoOrder']);
     Route::post('student/orders/{id}/request-approval', [OrderController::class, 'requestApproval']);
     Route::post('student/orders/delete-all', [OrderController::class, 'deleteAll']);
     Route::post('student/orders/get-total-price-of-items', [OrderController::class, 'getTotalPriceOfItems']);
     route::get('student/orders/get-sale-sup/{orderId}', [OrderController::class, 'getSaleSup']);
     Route::post('student/orders/{id}/confirm-request-demo', [OrderController::class, 'confirmRequestDemo']);
     Route::get('student/orders/{id}/showQrCode', [OrderController::class, 'showQrCode']);
     Route::get('student/orders/{id}/history-rejected', [OrderController::class, 'historyRejected']);
     Route::post('student/orders/save-sale/', [OrderController::class, 'saveSale']);
     Route::get('student/orders/{id}/export-order', [OrderController::class, 'exportOrder']);
     Route::get('student/orders/export', [OrderController::class, 'export']);
     
     Route::get('student/orders/order-items/select2', [OrderItemController::class, 'select2']);
     Route::get('student/order-item/{id}/copy', [OrderItemController::class, 'copy']);
     Route::delete('student/orders/order-item', [OrderItemController::class, 'delete']);
     Route::get('student/order-items/{id}/show-abroad-item-data-popup', [OrderItemController::class, 'showAbroadItemDataPopup']);

    // Sections
    Route::get('student/sections/calendar/content', [SectionController::class, 'eduCalendarContent']);
    Route::get('student/sections/calendar', [SectionController::class, 'calendar']);
    Route::get('student/sections/index', [SectionController::class, 'index']);
    Route::get('student/sections/list', [SectionController::class, 'list']);
    Route::delete('student/sections/destroy', [SectionController::class, 'destroy']);
    Route::delete('student/sections/delete-all', [SectionController::class, 'deleteAll']);
    Route::post('student/sections/{id}/saveAttendancePopup', [SectionController::class, 'saveAttendancePopup']);
    Route::get('student/sections/{id}/changeTeacherPopup', [SectionController::class, 'changeTeacherPopup']);
    Route::put('student/sections/{id}/changeTeacherPopup', [SectionController::class, 'saveChangeTeacherPopup']);
    Route::get('student/sections/{id}/shiftPopup', [SectionController::class, 'shiftPopup']);
    Route::post('student/sections/{id}/saveShift', [SectionController::class, 'saveShift']);
    Route::get('student/sections/{id}/request-absent', [SectionController::class, 'requestAbsent']);
    Route::post('student/sections/{id}/save-request-absent', [SectionController::class, 'saveRequestAbsent']);


     // Abroad Application
     Route::get('student/abroad-application/detail', [AbroadApplicationController::class, 'detail']);
     // Order
    Route::get('student/abroad-application', [AbroadController::class, 'index']);
    Route::get('student/abroad-application/list', [AbroadController::class, 'list']);
    Route::delete('student/abroad-application/delete-all', [AbroadController::class, 'deleteAll']);
    Route::get('abroad/services/get-services-by-type', [AbroadController::class, 'getServicesByType']);
    Route::get('student/abroad-application/{id}/general', [AbroadController::class, 'general']);
    Route::get('student/abroad-application/{id}/essay', [AbroadController::class, 'essay']);

    //IV 1 Lộ trình học thuật chiến lược
    Route::get('student/abroad-application/{id}/strategic-learning-curriculum', [AbroadController::class, 'strategicLearningCurriculum']);
    Route::get('student/abroad-application/{id}/strategic-learning-curriculum/declare', [AbroadController::class, 'declareStrategicLearningCurriculum']);
    Route::get('student/abroad-application/{id}/strategic-learning-curriculum/view_declaration', [AbroadController::class, 'viewStrategicLearningCurriculum']);
    
    // IV.2 Extracurricular plan
    Route::get('student/abroad-application/{id}/extracurricular-plan', [AbroadController::class, 'extracurricularPlan']);
    Route::get('student/abroad-application/{id}/extracurricular-plan/declare', [AbroadController::class, 'declareExtracurricularPlan']);
    Route::get('student/abroad-application/{id}/extracurricular-plan/view_declaration', [AbroadController::class, 'viewExtracurricularPlanDeclaration']);

    // IV.7 Recommendation letter
    Route::get('student/abroad-application/{id}/recommendation-letter', [AbroadController::class, 'recommendationLetter']);
    Route::get('student/abroad-application/{id}/show', [AbroadController::class, 'showDetailRecommendationLetter']);
    Route::get('student/abroad-application/{id}/recommendation-letter/create', [AbroadController::class, 'createRecommendationLetter']);
    Route::get('student/abroad-application/recommendation-letter/{id}/edit', [AbroadController::class, 'editRecommendationLetter']);
    Route::post('student/abroad-application/recommendation-letter/{id}/update', [AbroadController::class, 'updateRecommendationLetter']);
    Route::post('student/abroad-application/{id}/recommendation-letter/delete', [AbroadController::class, 'deleteRecommendationLetter']);
    Route::post('student/abroad-application/{id}/recommendation-letter/store', [AbroadController::class, 'storeRecommendationLetter']);
    Route::put('student/abroad-application/recommendation-letter/{id}/complete', [AbroadController::class, 'completeRecommendationLetter']);

    // IV.8 essay result 
    Route::get('student/abroad-application/{id}/essay-result', [AbroadController::class, 'essayResult']);
    Route::get('student/abroad-application/{id}/essay-result/create', [AbroadController::class, 'createEssayResult']);
    Route::post('student/abroad-application/{id}/essay-result/store', [AbroadController::class, 'storeEssayResult']);
    Route::get('student/abroad-application/{id}/essay-result/show', [AbroadController::class, 'showEssayResult']);
    Route::delete('student/abroad-application/{id}/essay-result/delete', [AbroadController::class, 'deleteEssayResult']);
    Route::get('student/abroad-application/essay-result/{id}/edit', [AbroadController::class, 'editEssayResult']);
    Route::post('student/abroad-application/essay-result/{id}/update', [AbroadController::class, 'updateEssayResult']);
    Route::post('student/abroad-application/{id}/essay-result-file/delete', [AbroadController::class, 'deleteEssayResultFile']);

    // IV.8 Mạng xã hội 
    Route::get('student/abroad-application/{id}/social-network', [AbroadController::class, 'socialNetwork']);
    Route::get('student/abroad-application/{id}/update-social-network', [AbroadController::class, 'updateSocialNetwork']);
    Route::put('student/abroad-application/{id}/done-update-social-network', [AbroadController::class, 'doneUpdateSocialNetwork']);
    Route::get('student/abroad-application/{id}/create-social-network', [AbroadController::class, 'createSocialNetwork']);
    Route::put('student/abroad-application/{id}/done-create-social-network', [AbroadController::class, 'doneCreateSocialNetwork']);
    Route::get('student/abroad-application/{id}/social-network-declaration', [AbroadController::class, 'socialNetworkDeclaration']);
    Route::put('student/abroad-application/update-active-social-network', [AbroadController::class, 'updateActiveSocialNetwork']);
    Route::get('student/abroad-application/{id}/social-network-show', [AbroadController::class, 'socialNetworkShow']);

    // IV.10 Study Abroad Application   
    Route::get('student/abroad-application/{id}/study-abroad-application', [AbroadController::class, 'studyAbroadApplication']);
    Route::get('student/abroad-application/{id}/create-study-abroad-application', [AbroadController::class, 'createStudyAbroadApplication']);
    Route::get('student/abroad-application/{id}/create-study-abroad-application-popup', [AbroadController::class, 'createStudyAbroadApplicationPopup']);
    Route::post('student/abroad-application/{id}/done-create-study-abroad-application', [AbroadController::class, 'saveStudyAbroadApplication']);
    Route::put('student/abroad-application/{id}/update-status-study-abroad-application-all', [AbroadController::class, 'updateStatusStudyAbroadApplicationAll']);
    Route::get('student/abroad-application/{id}/edit-study-abroad-application-popup', [AbroadController::class, 'editStudyAbroadApplicationPopup']);
    Route::post('student/abroad-application/{id}/update-study-abroad-application-popup', [AbroadController::class, 'updateStudyAbroadApplication']);
    Route::put('student/abroad-application/{id}/update-status-study-abroad-application', [AbroadController::class, 'completeStatusActive']);
    Route::get('student/abroad-application/{id}/show-study-abroad-application', [AbroadController::class, 'showStudyAbroadApplication']);
    Route::post('student/abroad-application/{id}/file-study-abroad-application/store', [AbroadController::class, 'storeFileStudyAbroadApplication']);
    Route::post('student/abroad-application/{id}/file-study-abroad-application/delete', [AbroadController::class, 'deleteFileStudyAbroadApplication']);

    // IV.11 Student CV
    Route::get('student/abroad-application/{id}/student-cv', [AbroadController::class, 'studentCV']);
    Route::post('student/abroad-application/{id}/cv/store', [AbroadController::class, 'storeCV']);
    Route::post('student/abroad-application/{id}/cv/delete', [AbroadController::class, 'deleteCV']);

    // V.1 Honor thesis
    Route::get('student/abroad-application/{id}/honor-thesis', [AbroadController::class, 'honorThesis']);

    // V.2 Edit thesis/Sửa Luận
    Route::get('student/abroad-application/{id}/edit-thesis', [AbroadController::class, 'editThesis']);

    // V.5 Interview Practice/ Luyện phỏng vấn
    Route::get('student/abroad-application/{id}/interview-practice', [AbroadController::class, 'interviewPractice']);

    // V.2 Application fee
    Route::get('student/abroad-application/{id}/application-fee', [AbroadController::class, 'applicationFee']);
    Route::get('student/abroad-application/{id}/create-application-fee', [AbroadController::class, 'createApplicationFee']);
    Route::post('student/abroad-application/{id}/done-create-application-fee', [AbroadController::class, 'doneCreateApplicationFee']);
    Route::get('student/abroad-application/{id}/edit-application-fee', [AbroadController::class, 'editApplicationFee']);
    Route::post('student/abroad-application/{id}/update-application-fee', [AbroadController::class, 'updateApplicationFee']);
    Route::get('student/abroad-application/{id}/pay-and-confirm', [AbroadController::class, 'payAndConfirm']);
    Route::get('student/abroad-application/{id}/show-pay-and-confirm', [AbroadController::class, 'showPayAndConfirm']);
    Route::post('student/abroad-application/{id}/file-confirmation/store', [AbroadController::class, 'storeFileConfirmation']);
    Route::post('student/abroad-application/{id}/file-confirmation/delete', [AbroadController::class, 'deleteFileComfirmation']);
    Route::post('student/abroad-application/{id}/file-fee-paid/store', [AbroadController::class, 'storeFileFeePaid']);
    Route::post('student/abroad-application/{id}/file-fee-paid/delete', [AbroadController::class, 'deleteFileFeePaid']);

    // V.3 Submit application
    Route::get('student/abroad-application/{id}/application-submission', [AbroadController::class, 'applicationSubmission']);
    Route::get('student/abroad-application/{id}/create-application-submission', [AbroadController::class, 'createApplicationSubmission']);
    Route::post('student/abroad-application/{id}/done-application-submission', [AbroadController::class, 'doneApplicationSubmission']);
    Route::get('student/abroad-application/{id}/edit-application-submission', [AbroadController::class, 'editApplicationSubmission']);
    Route::post('student/abroad-application/{id}/update-application-submission', [AbroadController::class, 'updateApplicationSubmission']);

    // V.5 School Selected Result
    Route::get('student/abroad-application/{id}/application-admitted-school', [AbroadController::class, 'applicationAdmittedSchool']);
    Route::get('student/abroad-application/{id}/create-application-admitted-school', [AbroadController::class, 'createApplicationAdmittedSchool']);
    Route::post('student/abroad-application/{id}/done-application-admitted-school', [AbroadController::class, 'doneApplicationAdmittedSchool']);
    Route::post('student/abroad-application/{id}/save-school-selected', [AbroadController::class, 'saveSchoolSelected']);
    Route::get('student/abroad-application/{id}/edit-application-admitted-school', [AbroadController::class, 'editApplicationAdmittedSchool']);
    Route::post('student/abroad-application/{id}/update-application-admitted-school', [AbroadController::class, 'updateApplicationAdmittedSchool']);

    // V.6 Deposit tuition fee
    Route::get('student/abroad-application/{id}/deposit-tuition-fee', [AbroadController::class, 'depositTuitionFee']);
    Route::post('student/abroad-application/{id}/deposit-data/update', [AbroadController::class, 'updateDepositData']);
    Route::post('student/abroad-application/{id}/deposit-file/store', [AbroadController::class, 'storeDepositFile']);
    Route::post('student/abroad-application/{id}/deposit-file/delete', [AbroadController::class, 'deleteDepositFile']);

    // V.7 Deposit for school
    Route::get('student/abroad-application/{id}/deposit-for-school', [AbroadController::class, 'depositForSchool']);
    Route::post('student/abroad-application/{id}/deposit-for-school/update', [AbroadController::class, 'updateDepositForSchool']);
    Route::post('student/abroad-application/{id}/deposit-for-school/store', [AbroadController::class, 'storeDepositForSchool']);
    Route::post('student/abroad-application/{id}/deposit-for-school/delete', [AbroadController::class, 'deleteDepositForSchool']);
  
    // V.9 Cultural Orientations
    Route::get('student/abroad-application/{id}/cultural-orientations', [AbroadController::class, 'culturalOrientations']);
    Route::get('student/abroad-application/{id}/update-cultural-orientation', [AbroadController::class, 'updateCulturalOrientation']);
    Route::put('student/abroad-application/{id}/done-update-cultural-orientation', [AbroadController::class, 'doneUpdateCulturalOrientation']);
    Route::get('student/abroad-application/{id}/create-cultural-orientation', [AbroadController::class, 'createCulturalOrientation']);
    Route::put('student/abroad-application/{id}/done-create-cultural-orientation', [AbroadController::class, 'doneCreateCulturalOrientation']);

    // V.10 Support Activities
    Route::get('student/abroad-application/{id}/support-activities', [AbroadController::class, 'supportActivities']);
    Route::get('student/abroad-application/{id}/update-support-activity', [AbroadController::class, 'updateSupportActivity']);
    Route::put('student/abroad-application/{id}/done-update-support-activity', [AbroadController::class, 'doneUpdateSupportActivity']);
    Route::get('student/abroad-application/{id}/create-support-activity', [AbroadController::class, 'createSupportActivity']);
    Route::put('student/abroad-application/{id}/done-create-support-activity', [AbroadController::class, 'doneCreateSupportActivity']);

    // VI.6 Flying Student/ Thời điểm học sinh lên đường
    Route::get('student/abroad-application/{id}/flying-student', [AbroadController::class, 'flyingStudent']);
    Route::get('student/abroad-application/{id}/create-flying-student', [AbroadController::class, 'createFlyingStudent']);
    Route::post('student/abroad-application/{id}/done-create-flying-student', [AbroadController::class, 'doneCreateFlyingStudent']);
    Route::get('student/abroad-application/{id}/update-flying-student', [AbroadController::class, 'updateFlyingStudent']);
    Route::post('student/abroad-application/{id}/done-update-flying-student', [AbroadController::class, 'doneUpdateFlyingStudent']);
    
    // VI.7 Complete application
    Route::get('student/abroad-application/{id}/complete-application', [AbroadController::class, 'completeApplication']);
    Route::post('student/abroad-application/{id}/request-approval-complete-application', [AbroadController::class, 'requestApprovalCompleteApplication']);
    Route::post('student/abroad-application/{id}/approval-complete-application', [AbroadController::class, 'approveCompleteApplication']);
    Route::post('student/abroad-application/{id}/reject-complete-application', [AbroadController::class, 'rejectCompleteApplication']);

    // Kết quả dự tuyển
    Route::get('student/abroad-application/{id}/admissionLetter', [AbroadController::class, 'admissionLetter']);
    Route::post('student/abroad-application/{id}/admission-letter/store-admission-letter', [AbroadController::class, 'storeAdmissionLetter']);
    Route::post('student/abroad-application/{id}/admission-letter/delete-admission-letter', [AbroadController::class, 'deleteAdmissionLetter']);
    Route::get('student/abroad-application/{id}/create-admission-letter', [AbroadController::class, 'createAdmissionLetter']);
    Route::post('student/abroad-application/{id}/admission-letter/store', [AbroadController::class, 'storeScholarshipFile']);
    Route::post('student/abroad-application/{id}/admission-letter/delete', [AbroadController::class, 'deleteScholarshipFile']);
    Route::put('student/abroad-application/{id}/done-create-recruitment-results', [AbroadController::class, 'doneCreateRecruitmentResults']);
    Route::put('student/abroad-application/update-active-recruitment-results', [AbroadController::class, 'updateActiveRecruitmentResults']);
    // Route::get('student/abroad-application/{id}/create-study-abroad-application-popup', [AbroadController::class, 'createStudyAbroadApplicationPopup']);
    // Route::post('student/abroad-application/{id}/done-create-study-abroad-application', [AbroadController::class, 'saveStudyAbroadApplication']);
    // Route::put('student/abroad-application/{id}/update-status-study-abroad-application-all', [AbroadController::class, 'updateStatusStudyAbroadApplicationAll']);
    // Route::get('student/abroad-application/{id}/edit-study-abroad-application-popup', [AbroadController::class, 'editStudyAbroadApplicationPopup']);
    // Route::post('student/abroad-application/{id}/update-study-abroad-application-popup', [AbroadController::class, 'updateStudyAbroadApplication']);
    // Route::put('student/abroad-application/{id}/update-status-study-abroad-application', [AbroadController::class, 'completeStatusActive']);
    Route::get('student/abroad-application/{id}/show-recruitment-results', [AbroadController::class, 'showRecruitmentResults']);

    // Hồ sơ tài chính
    Route::get('student/abroad-application/{id}/financial-document', [AbroadController::class, 'financialDocument']);
    Route::post('student/abroad-application/{id}/financial-document/store-financial-document', [AbroadController::class, 'storeFinancialDocument']);
    Route::post('student/abroad-application/{id}/financial-document/delete-financial-document', [AbroadController::class, 'deleteFinancialDocument']);

    // Hồ sơ dự tuyển
    Route::get('student/abroad-application/{id}/hsdt', [AbroadController::class, 'hsdt']);
    Route::post('student/abroad-application/{id}/request-approval-hsdt', [AbroadController::class, 'requestApprovalHSDT']);
    Route::post('student/abroad-application/{id}/approval-hsdt', [AbroadController::class, 'approveHSDT']);
    Route::post('student/abroad-application/{id}/reject-hsdt', [AbroadController::class, 'rejectHSDT']);

    // Hồ sơ hoàn chỉnh
    Route::get('student/abroad-application/{id}/complete-file', [AbroadController::class, 'completeFile']);
    Route::post('student/abroad-application/{id}/complete-file/store-complete-file', [AbroadController::class, 'storeCompleteFile']);
    Route::post('student/abroad-application/{id}/complete-file/delete-complete-file', [AbroadController::class, 'deleteCompleteFile']);

    // 15 Bản scan thông tin các nhân
    Route::get('student/abroad-application/{id}/scan-of-information', [AbroadController::class, 'scanOfInformation']);
    Route::post('student/abroad-application/{id}/scan-of-information/store-scan-of-information', [AbroadController::class, 'storeScanOfInformation']);
    Route::post('student/abroad-application/{id}/scan-of-information/delete-scan-of-information', [AbroadController::class, 'deleteScanOfInformation']);

    // Kế hoạch ngoại khoá
    Route::get('student/abroad-application/{id}/extracurricular-schedule', [AbroadController::class, 'extracurricularSchedule']);
    Route::get('student/abroad-application/{id}/create-extracurricular-schedule', [AbroadController::class, 'createExtracurricularSchedule']);
    Route::put('student/abroad-application/{id}/done-create-extracurricular-schedule', [AbroadController::class, 'doneCreateExtracurricularSchedule']);
    Route::get('student/abroad-application/{id}/update-extracurricular-schedule', [AbroadController::class, 'updateExtracurricularSchedule']);
    Route::put('student/abroad-application/{id}/done-update-extracurricular-schedule', [AbroadController::class, 'doneUpdateExtracurricularSchedule']);
    Route::get('student/abroad-application/{id}/extracurricular-schedule-declaration', [AbroadController::class, 'extracurricularScheduleDeclaration']);
    Route::get('student/abroad-application/{id}/extracurricular-schedule-show', [AbroadController::class, 'extracurricularScheduleShow']);
    Route::put('student/abroad-application/update-active-extracurricular-schedule', [AbroadController::class, 'updateActiveExtracurricularSchedule']);
    Route::put('student/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularSchedule']);

    // Chứng chỉ
    Route::get('student/abroad-application/{id}/certifications', [AbroadController::class, 'certifications']);
    Route::get('student/abroad-application/{id}/update-certification', [AbroadController::class, 'updateCertification']);
    Route::put('student/abroad-application/{id}/done-update-certification', [AbroadController::class, 'doneCreateCertification']);
    Route::get('student/abroad-application/{id}/create-certifications', [AbroadController::class, 'createCertifications']);
    Route::put('student/abroad-application/{id}/done-create-certifications', [AbroadController::class, 'doneUpdateCertification']);
    Route::get('student/abroad-application/{id}/certification-declaration', [AbroadController::class, 'certificationDeclaration']);
    Route::get('student/abroad-application/{id}/certification-show', [AbroadController::class, 'certificationShow']);
    Route::put('student/abroad-application/update-active-certification', [AbroadController::class, 'updateActiveCertification']);
    Route::put('student/abroad-application/update-draft-certification', [AbroadController::class, 'updateDraftCertification']);

    // Hoạt động ngoại khoá
    Route::get('student/abroad-application/{id}/extracurricular-activity', [AbroadController::class, 'extracurricularActivity']);
    Route::get('student/abroad-application/{id}/create-extracurricular-activity', [AbroadController::class, 'createExtracurricularActivity']);
    Route::put('student/abroad-application/{id}/done-create-extracurricular-activity', [AbroadController::class, 'doneCreateExtracurricularActivity']);
    Route::get('student/abroad-application/{id}/update-extracurricular-activity', [AbroadController::class, 'updateExtracurricularActivity']);
    Route::put('student/abroad-application/{id}/done-update-extracurricular-activity', [AbroadController::class, 'doneUpdateExtracurricularActivity']);
    Route::get('student/abroad-application/{id}/extracurricular-activity-declaration', [AbroadController::class, 'extracurricularActivityDeclaration']);
    Route::get('student/abroad-application/{id}/extracurricular-activity-show', [AbroadController::class, 'extracurricularActivityShow']);
    Route::put('student/abroad-application/update-active-extracurricular-activity', [AbroadController::class, 'updateActiveExtracurricularActivity']);
    Route::put('student/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularActivity']);

    // Danh sách trường yêu cầu tuyển sinh
    Route::get('student/abroad-application/{id}/application-school', [AbroadController::class, 'applicationSchool']);
    Route::get('student/abroad-application/{id}/application-school-declaration', [AbroadController::class, 'applicationSchoolDeclaration']);
    Route::get('student/abroad-application/{id}/update-application-school', [AbroadController::class, 'updateApplicationSchool']);
    Route::get('student/abroad-application/{id}/create-application-school', [AbroadController::class, 'createApplicationSchool']);
    Route::put('student/abroad-application/{id}/done-create-application-school', [AbroadController::class, 'doneCreateApplicationSchool']);
    Route::put('student/abroad-application/{id}/done-update-application-school', [AbroadController::class, 'doneUpdateApplicationSchool']);
    Route::put('student/abroad-application/update-active-application-school', [AbroadController::class, 'updateActiveApplicationSchool']);
    Route::get('student/abroad-application/{id}/application-school-show', [AbroadController::class, 'applicationSchoolShow']);

    // Visa cho học sinh
    Route::get('student/abroad-application/{id}/student-visa', [AbroadController::class, 'studentVisa']);
    Route::post('student/abroad-application/{id}/student-visa-data/update', [AbroadController::class, 'updateStudentVisaData']);
    Route::post('student/abroad-application/{id}/student-visa-file/store', [AbroadController::class, 'storeStudentVisaFile']);
    Route::post('student/abroad-application/{id}/student-visa-file/delete', [AbroadController::class, 'deleteStudentVisaFile']);

    // Abroad Application
    Route::get('student/abroad-application/{id}/details', [AbroadApplicationController::class, 'details']);
    Route::get('student/abroad-application/select2', [AbroadApplicationController::class, 'select2']);
    Route::get('student/abroad-application/{id}/update-status-abroad-application', [AbroadController::class, 'updateStatusAbroadApplication']);
    Route::put('student/abroad-application/{id}/done-update-status-abroad-application', [AbroadController::class, 'doneAssignmentAbroadApplication']);
    Route::get('student/abroad-application/abroad-application-index', [AbroadApplicationController::class, 'abroadApplicationIndex']);

    // Thời điểm haonf thành
    Route::put('student/abroad-application-finish-day/update', [AbroadApplicationFinishDayController::class, 'updateFinishDay']);

    // Hoàn thành các bước
    Route::put('student/abroad-application-done/update', [AbroadApplicationStatusController::class, 'updateDoneAbroadApplication']);

    // Payment Remider
    Route::get('student/payment_reminders', [PaymentReminderController::class, 'index']);
    Route::get('student/payment_reminders/list', [PaymentReminderController::class, 'list']);
    
    // Contact Request
    Route::post('student/contact_requests/{id}/save', [ContactRequestController::class, 'save']);
    Route::get('student/contact_requests/select2', [ContactRequestController::class, 'select2']);
    Route::get('student/contact_requests/add-tags', [ContactRequestController::class, 'addTags']);
    Route::get('student/contact_requests/delete-tags', [ContactRequestController::class, 'deleteTags']);
    Route::get('student/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulk']);
    Route::put('student/contact_requests/add-tags/bulk', [ContactRequestController::class, 'addTagsBulkSave']);
    Route::delete('student/contact_requests/action-delete-tags', [ContactRequestController::class, 'actionDeleteTags']);
    Route::get('student/contact_requests/handover/{id}', [ContactRequestController::class, 'addHandover']);
    Route::put('student/contact_requests/handover/{id}', [ContactRequestController::class, 'saveHandover']);
    Route::get('student/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulk']);
    Route::put('student/contact_requests/add-handover-bulk', [ContactRequestController::class, 'addHandoverBulkSave']);
    Route::get('student/contact_requests/{id}/update-history', [ContactRequestController::class, 'updateHistory']);
    Route::get('student/contact_requests/{id}/extra-activity', [ContactRequestController::class, 'extraActivity']);
    Route::get('student/contact_requests/{id}/kid-tech', [ContactRequestController::class, 'kidTech']);
    Route::get('student/contact_requests/{id}/study-abroad', [ContactRequestController::class, 'studyAbroad']);
    Route::get('student/contact_requests/{id}/debt', [ContactRequestController::class, 'debt']);
    Route::get('student/contact_requests/{id}/education', [ContactRequestController::class, 'education']);
    Route::get('student/contact_requests/{id}/contract', [ContactRequestController::class, 'contract']);
    Route::get('student/contact_requests/{id}/show', [ContactRequestController::class, 'show']);
    Route::get('student/contact_requests/{id}/edit', [ContactRequestController::class, 'edit']);
    Route::put('student/contact_requests/{id}', [ContactRequestController::class, 'update']);
    Route::post('student/contact_requests/import/hubspot/run', [ContactRequestController::class, 'importHubspotRun']);
    Route::get('student/contact_requests/import/hubspot', [ContactRequestController::class, 'importHubspot']);
    Route::get('student/contact_requests/import/excel', [ContactRequestController::class, 'importExcel']);
    Route::post('student/contact_requests/import/excel', [ContactRequestController::class, 'importExcelShow']);
    Route::post('student/contact_requests/import/excel/run', [ContactRequestController::class, 'importExcelRunning']);
    Route::post('student/contact_requests/import/excel/test-results', [ContactRequestController::class, 'testImportDone']);
    Route::get('student/contact_requests/import/excel/download-log', [ContactRequestController::class, 'downloadLog']);
    Route::delete('student/contact_requests/{id}', [ContactRequestController::class, 'destroy']);
    Route::post('student/contact_requests', [ContactRequestController::class, 'store']);
    Route::get('student/contact_requests/create', [ContactRequestController::class, 'create']);
    Route::get('student/contact_requests/list', [ContactRequestController::class, 'list']);
    Route::get('student/contact_requests', [ContactRequestController::class, 'index']);
    Route::get('student/contact_requests/export-filter', [ContactRequestController::class, 'showFilterForm']);
    Route::post('student/contact_requests/exportRun', [ContactRequestController::class, 'exportRun']);
    Route::get('student/contact_requests/exportDownload', [ContactRequestController::class, 'exportDownload']);
    Route::get('student/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelected']);
    Route::post('student/contact_requests/export-contact-selected', [ContactRequestController::class, 'exportContactRequestSelectedRun']);
    Route::get('student/contact_requests/export-contact-selected/run', [ContactRequestController::class, 'exportContactRequestSelectedDownload']);
    Route::post('student/contact_requests/delete-all', [ContactRequestController::class, 'deleteAll']);

    // Contact
    Route::get('student/contacts/related-contacts-box', [ContactController::class, 'relatedContactsBox']);
    Route::get('student/contacts/{id}/info-box', [ContactController::class, 'infoBox']);
    Route::get('student/contacts/note-logs-popup/{id}', [ContactController::class, 'noteLogsPopup']);
    Route::post('student/contacts/{id}/save', [ContactController::class, 'save']);
    Route::get('student/contacts/select2', [ContactController::class, 'select2']);
    Route::get('student/contacts/add-tags', [ContactController::class, 'addTags']);
    Route::get('student/contacts/delete-tags', [ContactController::class, 'deleteTags']);
    Route::get('student/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulk']);
    Route::put('student/contacts/add-tags/bulk', [ContactController::class, 'addTagsBulkSave']);
    Route::delete('student/contacts/action-delete-tags', [ContactController::class, 'actionDeleteTags']);
    Route::get('student/contacts/{id}/update-history', [ContactController::class, 'updateHistory']);
    Route::get('student/contacts/{id}/note-logs', [ContactController::class, 'noteLog']);
    Route::get('student/contacts/note-logs-list/{id}', [ContactController::class, 'noteLogList']);
    Route::get('student/contacts/{id}/study-abroad', [ContactController::class, 'studyAbroad']);
    Route::get('student/contacts/{id}/extra-activity', [ContactController::class, 'extraActivity']);
    Route::get('student/contacts/{id}/kid-tech', [ContactController::class, 'kidTech']);
    Route::get('student/contacts/{id}/debt', [ContactController::class, 'debt']);
    Route::get('student/contacts/{id}/education', [ContactController::class, 'education']);
    Route::get('student/contacts/{id}/contract', [ContactController::class, 'contract']);
    Route::get('student/contacts/{id}/show', [ContactController::class, 'show']);
    Route::get('student/contacts/{id}/edit', [ContactController::class, 'edit']);
    Route::put('student/contacts/{id}', [ContactController::class, 'update']);
    Route::post('student/contacts/import/hubspot/run', [ContactController::class, 'importHubspotRun']);
    Route::get('student/contacts/import/hubspot', [ContactController::class, 'importHubspot']);
    Route::get('student/contacts/import/excel', [ContactController::class, 'importExcel']);
    Route::post('student/contacts/import/excel', [ContactController::class, 'importExcelShow']);
    Route::post('student/contacts/import/excel/run', [ContactController::class, 'importExcelRunning']);
    Route::post('student/contacts/import/excel/test-results', [ContactController::class, 'testImportDone']);
    Route::get('student/contacts/import/excel/download-log', [ContactController::class, 'downloadLog']);
    Route::delete('student/contacts/{id}', [ContactController::class, 'destroy']);
    Route::post('student/contacts', [ContactController::class, 'store']);
    Route::get('student/contacts/create', [ContactController::class, 'create']);
    Route::get('student/contacts/list', [ContactController::class, 'list']);
    Route::get('student/contacts', [ContactController::class, 'index']);
    Route::post('student/contacts/delete-all', [ContactController::class, 'deleteAll']);
    Route::get('student/contacts/export', [ContactController::class, 'showFilterForm']);
    Route::post('student/contacts/exportRun', [ContactController::class, 'exportRun']);
    Route::get('student/contacts/exportDownload', [ContactController::class, 'exportDownload']);
    // Route::post('student/contacts', [ContactController::class, 'storeNoteLogs']);
    Route::get('student/contacts/add-notelog-contact/{id}', [ContactController::class, 'addNoteLogContact']);
    // Route::post('student/contacts/add-notelog-contact/{id}', [ContactController::class, 'storeNoteLogContact']);

    // Customer
    Route::get('student/customers/note-logs-popup/{id}', [CustomerController::class, 'noteLogsPopup']);
    Route::post('student/customers/{id}/save', [CustomerController::class, 'save']);
    Route::get('student/customers/select2', [CustomerController::class, 'select2']);
    Route::get('student/customers/add-tags', [CustomerController::class, 'addTags']);
    Route::get('student/customers/delete-tags', [CustomerController::class, 'deleteTags']);
    Route::get('student/customers/add-tags/bulk', [CustomerController::class, 'addTagsBulk']);
    Route::put('student/customers/add-tags/bulk', [CustomerController::class, 'addTagsBulkSave']);
    Route::delete('student/customers/action-delete-tags', [CustomerController::class, 'actionDeleteTags']);
    Route::get('student/customers/{id}/update-history', [CustomerController::class, 'updateHistory']);
    Route::get('student/customers/{id}/note-logs', [CustomerController::class, 'noteLog']);
    Route::get('student/customers/note-logs-list/{id}', [CustomerController::class, 'noteLogList']);
    Route::get('student/customers/{id}/study-abroad', [CustomerController::class, 'studyAbroad']);
    Route::get('student/customers/{id}/extra-activity', [CustomerController::class, 'extraActivity']);
    Route::get('student/customers/{id}/kid-tech', [CustomerController::class, 'kidTech']);
    Route::get('student/customers/{id}/debt', [CustomerController::class, 'debt']);
    Route::get('student/customers/{id}/education', [CustomerController::class, 'education']);
    Route::get('student/customers/{id}/contract', [CustomerController::class, 'contract']);
    Route::get('student/customers/{id}/contract-list', [CustomerController::class, 'contractList']);
    Route::get('student/customers/{id}/payment-list', [CustomerController::class, 'paymentList']);
    Route::get('student/customers/{id}/show', [CustomerController::class, 'show']);
    Route::get('student/customers/{id}/edit', [CustomerController::class, 'edit']);
    Route::put('student/customers/{id}', [CustomerController::class, 'update']);
    Route::post('student/customers/import/hubspot/run', [CustomerController::class, 'importHubspotRun']);
    Route::get('student/customers/import/hubspot', [CustomerController::class, 'importHubspot']);
    Route::get('student/customers/import/excel', [CustomerController::class, 'importExcel']);
    Route::post('student/customers/import/excel', [CustomerController::class, 'importExcelShow']);
    Route::post('student/customers/import/excel/run', [CustomerController::class, 'importExcelRunning']);
    Route::post('student/customers/import/excel/test-results', [CustomerController::class, 'testImportDone']);
    Route::get('student/customers/import/excel/download-log', [CustomerController::class, 'downloadLog']);
    Route::delete('student/customers/{id}', [CustomerController::class, 'destroy']);
    Route::post('student/customers', [CustomerController::class, 'store']);
    Route::get('student/customers/create', [CustomerController::class, 'create']);
    Route::get('student/customers/list', [CustomerController::class, 'list']);
    Route::get('student/customers', [CustomerController::class, 'index']);
    Route::get('student/customers/{id}/request-contact', [CustomerController::class, 'requestContact']);
    Route::get('student/contacts/{id}/request-contact-list', [CustomerController::class, 'requestContactList']);

    // Courses
    Route::get('student/courses', [CourseController::class, 'index']);

    // Note logs
    Route::get('student/note-logs', [NoteLogController::class, 'index']);
    Route::get('student/note-logs/list', [NoteLogController::class, 'list']);
    Route::get('student/note-logs/{id}/edit', [NoteLogController::class, 'edit']);
    Route::put('student/note-logs/{id}', [NoteLogController::class, 'update']);
    Route::delete('student/note-logs/{id}', [NoteLogController::class, 'destroy']);
    Route::delete('student/note-logs', [NoteLogController::class, 'destroyAll']);
    Route::get('student/note-logs/create', [NoteLogController::class, 'create']);
    Route::post('student/note-logs/add-notelog/{id}', [NoteLogController::class, 'storeNoteLog']);
    Route::get('student/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'createNoteLogCustomer']);
    Route::post('student/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'storeNoteLogCustomer']);
    Route::post('student/note-logs', [NoteLogController::class, 'store']);
    Route::get('student/note-logs/note-logs-popup/{id}', [NoteLogController::class, 'noteLogsPopup']);
    Route::get('student/note-logs/add-notelog-contact/{id}', [NoteLogController::class, 'addNoteLog']);

    // Report
    // Route::get('student/monthly-kpi-report', [KPIReportController::class, 'indexMonthlyKPIReport']);
    // Route::get('student/monthly-kpi-report/list', [KPIReportController::class, 'listMonthlyKPIReport']);

    // Route::get('student/daily-kpi-report', [KPIReportController::class, 'indexDailyKPIReportIndex']);
    // Route::get('student/daily-kpi-report/list', [KPIReportController::class, 'listDailyKPIReport']);
    // Route::get('student/daily-kpi-report/export-filter', [KPIReportController::class, 'showFilterForm']);
    // Route::post('student/daily-kpi-report/exportRun', [KPIReportController::class,'exportRun']);
    // Route::get('student/daily-kpi-report/exportDownload', [KPIReportController::class, 'exportDownload']);

    // Route::get('student/contract-status-report', [ContractStatusController::class, 'index']);
    // Route::get('student/contract-status-report/list', [ContractStatusController::class, 'list']);
    // Route::get('student/contract-status-report/export-filter', [ContractStatusController::class, 'showFilterForm']);
    // Route::post('student/contract-status-report/exportRun', [ContractStatusController::class,'exportRun']);
    // Route::get('student/contract-status-report/exportDownload', [ContractStatusController::class, 'exportDownload']);

    // Route::get('student/sales-report', [SalesReportController::class, 'index']);
    // Route::get('student/sales-report/list', [SalesReportController::class, 'list']);
    // Route::get('student/sales-report/export-filter', [SalesReportController::class, 'showFilterForm']);
    // Route::post('student/sales-report/exportRun', [SalesReportController::class, 'exportRun']);
    // Route::get('student/sales-report/exportDownload', [SalesReportController::class, 'exportDownload']);

    // Route::get('student/upsell-report', [UpsellReportController::class, 'index']);
    // Route::get('student/upsell-report/list', [UpsellReportController::class, 'list']);
    // Route::get('student/upsell-report/export-filter', [UpsellReportController::class, 'showFilterForm']);
    // Route::post('student/upsell-report/exportRun', [UpsellReportController::class, 'exportRun']);
    // Route::get('student/upsell-report/exportDownload', [UpsellReportController::class, 'exportDownload']);
    
    // Route::get('student/payment-report', [PaymentReportController::class, 'index']);
    // Route::get('student/payment-report/list', [PaymentReportController::class, 'list']);
    // Route::get('student/payment-report/export-filter', [PaymentReportController::class, 'showFilterForm']);
    // Route::post('student/payment-report/exportRun', [PaymentReportController::class, 'exportRun']);
    // Route::get('student/payment-report/exportDownload', [PaymentReportController::class, 'exportDownload']);
    // Route::get('student/revenue-report', [RevenueReportController::class, 'index']);
    // Route::get('student/revenue-report/list', [RevenueReportController::class, 'list']);
    // Route::get('student/conversion-rate', [ConversionRateReportController::class, 'index']);
    // Route::get('student/conversion-rate/list', [ConversionRateReportController::class, 'list']);
    // Route::get('student/conversion-rate/export-filter', [ConversionRateReportController::class, 'showFilterForm']);
    // Route::post('student/conversion-rate/exportRun', [ConversionRateReportController::class, 'exportRun']);
    // Route::get('student/conversion-rate/exportDownload', [ConversionRateReportController::class, 'exportDownload']);
    
    // profile
    Route::get('student/profile', [ProfileController::class, 'edit'])->name('student.profile.edit');
    Route::patch('student/profile', [ProfileController::class, 'update'])->name('student.profile.update');
    Route::delete('student/profile', [ProfileController::class, 'destroy'])->name('student.profile.destroy');
    Route::get('student/profile/activities', [ProfileController::class, 'activities']);
    Route::get('student/profile/notelogs', [ProfileController::class, 'notelogs']);

    // Report Teacher
    Route::get('student/teacher_hour_report', [TeacherHourReportController::class, 'index']);
    Route::get('student/teacher_hour_report/list', [TeacherHourReportController::class, 'list']);
    Route::get('student/teacher_hour_report/{id}/list-details-teacher', [TeacherHourReportController::class, 'listDetailTeacher']);
    
    // Report Student
    Route::get('student/student_hour_report', [StudentHourReportController::class, 'index']);
    Route::get('student/student_hour_report/list', [StudentHourReportController::class, 'list']);
    Route::get('student/student_hour_report/{id}/list-details-student', [StudentHourReportController::class, 'listDetailStudent']);

    // Dashboard
    Route::get('student/dashboard/{interval}', [DashboardController::class, 'updateInterval']);

    //Refund_request
    Route::get('student/refund_requests', [RefundRequestController::class, 'index']);
    Route::get('student/refund_requests/list', [RefundRequestController::class, 'list']);
    Route::get('student/refund_requests/{id}/showRequest', [RefundRequestController::class, 'showRequest']);

    // Reserve
    Route::get('student/reserve/index', [ReserveController::class, 'index']);
    Route::get('student/reserve/list', [ReserveController::class, 'list']);
    Route::get('student/reserve/reserve-student', [ReserveController::class, 'reserveStudent']);
    Route::get('student/reserve/reserve-extend', [ReserveController::class, 'reserveExtend']);
    Route::post('student/reserve/done-reserve-extend', [ReserveController::class, 'doneReserveExtend']);
    Route::get('student/reserve/reserve-cancelled', [ReserveController::class, 'reserveCancelled']);
    Route::post('student/reserve/done-reserve-cancelled', [ReserveController::class, 'doneReserveCancelled']);

    // Refund_request
    Route::get('student/refund_requests', [RefundRequestController::class, 'index']);
    Route::get('student/refund_requests/list', [RefundRequestController::class, 'list']);
    Route::get('student/refund_requests/{id}/showRequest', [RefundRequestController::class, 'showRequest']);

    // Students
    Route::get('student/students/note-logs-popup/{id}', [StudentController::class, 'noteLogsPopup']);
    Route::get('student/students/show-free-time-schedule/{id}', [StudentController::class, 'showFreeTimeSchedule']);
    Route::post('student/students/{id}/save', [StudentController::class, 'save']);
    Route::get('student/students/select2', [StudentController::class, 'select2']);
    Route::get('student/students/{id}/update-history', [StudentController::class, 'updateHistory']);
    Route::get('student/students/{id}/note-logs', [StudentController::class, 'noteLog']);
    Route::get('student/students/note-logs-list/{id}', [StudentController::class, 'noteLogList']);
    Route::get('student/students/{id}/show', [StudentController::class, 'show']);
    Route::get('student/students/{id}/class', [StudentController::class, 'class']);
    Route::get('student/students/{id}/classList', [StudentController::class, 'classList']);
    Route::get('student/students/{id}/section', [StudentController::class, 'section']);
    Route::get('student/students/{id}/sectionList', [StudentController::class, 'sectionList']);
    Route::get('student/students/{id}/schedule', [StudentController::class, 'schedule']);
    Route::get('student/students/{id}/refund', [StudentController::class, 'refund']);
    Route::get('student/students/{id}/refundList', [StudentController::class, 'refundList']);
    Route::get('student/students/{id}/reserve/student/detail', [StudentController::class, 'reserveStudentDetail']);
    Route::get('student/students/{id}/reserveList', [StudentController::class, 'reserveList']);
    Route::get('student/students/{id}/transfer/student/detail', [StudentController::class, 'transferStudentDetail']);
    Route::get('student/students/{id}/transferList', [StudentController::class, 'transferList']);
    Route::get('student/students/{id}/calendar', [StudentController::class, 'calendar']);
    Route::get('student/students/{id}/contract', [StudentController::class, 'contract']);
    Route::get('student/students/{id}/contract-list', [StudentController::class, 'contractList']);
    Route::get('student/students/{id}/extra-activity', [StudentController::class, 'extraActivity']);
    Route::get('student/students/{id}/kid-tech', [StudentController::class, 'kidTech']);
    Route::get('student/students/{id}/edit', [StudentController::class, 'edit']);
    Route::put('student/students/{id}', [StudentController::class, 'update']);
    Route::delete('student/students/{id}', [StudentController::class, 'destroy']);
    Route::post('student/students', [StudentController::class, 'store']);
    Route::get('student/students/create', [StudentController::class, 'create']);
    Route::get('student/students/list', [StudentController::class, 'list']);
    Route::get('student/students', [StudentController::class, 'index']);
    Route::get('student/students/{id}/request-contact', [StudentController::class, 'requestContact']);
    Route::get('student/students/{id}/request-contact-list', [StudentController::class, 'requestContactList']);
    Route::get('student/students/assign-to-class', [StudentController::class, 'assignToClass']);
    Route::get('student/students/order-form', [StudentController::class, 'orderForm']);
    Route::get('student/students/order-item-form', [StudentController::class, 'orderItemForm']);
    Route::get('student/students/course-form', [StudentController::class, 'courseForm']);
    Route::post('student/students/done-assign-to-class', [StudentController::class, 'doneAssignToClass']);
    Route::get('student/students/study-partner', [StudentController::class, 'studyPartner']);
    Route::get('student/students/section-form', [StudentController::class, 'sectionForm']);
    Route::get('student/students/course-student-form', [StudentController::class, 'courseStudentForm']);
    Route::get('student/students/course-partner', [StudentController::class, 'coursePartner']);
    Route::get('student/students/section-student', [StudentController::class, 'sectionStudent']);
    Route::post('student/students/done-study-partner', [StudentController::class, 'doneStudyPartner']);
    Route::get('student/students/transfer-class', [StudentController::class, 'transferClass']);
    Route::get('student/students/course-transfer-student-form', [StudentController::class, 'courseTransferStudentForm']);
    Route::get('student/students/course-transfer-form', [StudentController::class, 'courseTransfer']);
    Route::post('student/students/done-transfer-class', [StudentController::class, 'doneTransferClass']);
    Route::get('student/students/reserve', [StudentController::class, 'reserve']);
    Route::get('student/students/order-item-reserve-form', [StudentController::class, 'orderItemReserveForm']);
    Route::get('student/students/course-reserve-form', [StudentController::class, 'courseReserveForm']);
    Route::post('student/students/done-reserve', [StudentController::class, 'doneReserve']);
    Route::get('student/students/refund-request', [StudentController::class, 'refundRequest']);
    Route::get('student/students/course-refund-request-form', [StudentController::class, 'courseRefundRequestForm']);
    Route::get('student/students/order-item-refund-request-form', [StudentController::class, 'orderItemRefundRequestForm']);
    Route::post('student/students/done-refund-request', [StudentController::class, 'doneRefundRequest']);
    Route::get('student/students/assign-to-class-request-demo', [StudentController::class, 'assignToClassRequestDemo']);
    Route::get('student/students/order-form-request-demo', [StudentController::class, 'orderFormRequestDemo']);
    Route::get('student/students/order-item-form-request-demo', [StudentController::class, 'orderItemFormRequestDemo']);
    Route::get('student/students/course-form-request-demo', [StudentController::class, 'courseFormRequestDemo']);
    Route::get('student/students/section-form-request-demo', [StudentController::class, 'sectionFormRequestDemo']);
    Route::post('student/students/done-assign-to-class-request-demo', [StudentController::class, 'doneAssignToClassRequestDemo']);

    // transfer
    Route::get('student/students/transfer', [StudentController::class, 'transfer']);
    Route::post('student/students/transfer/save-transfer', [StudentController::class, 'transferSave']);
    Route::get('student/students/transfer/order-item/select', [StudentController::class, 'transferOrderItemSelect']);
    Route::get('student/students/transfer/form-detail', [StudentController::class, 'transferFormDetail']);

    // exit class
    Route::get('student/students/exit-class', [StudentController::class, 'exitClass']);
    Route::post('student/students/done-exit-class', [StudentController::class, 'doneExitClass']);
    Route::get('student/courses/{id}/reschedulePopup', [CourseController::class, 'reschedulePopup']);

    // Báo cáo học tập
    Route::get('student/report_sections/{id}/report-section-popup/{course_id}', [SectionReportsController::class, 'reportSectionPopup']);

    // Extracurricular
    Route::get('student/extracurricular/index', [ExtracurricularController::class, 'index']);
    Route::get('student/extracurricular/list', [ExtracurricularController::class, 'list']);
    Route::post('student/extracurricular/delete-all', [ExtracurricularController::class, 'deleteAll']);

    //Payments
    Route::get('student/payments/create-receipt-contact', [PaymentRecordController::class, 'createReceiptContact']);
    Route::post('student/payments/store-receipt-contact/{id}', [PaymentRecordController::class, 'storeReceiptContact']);

    //One pay
    Route::get('student/payments/createReceipt/{id}', [OnePayController::class, 'createReceipt']);
    Route::get('student/payments/showLink', [OnePayController::class, 'showLink']);
    Route::get('student/payment_reminders/one-pay/{amount}', [OnePayController::class, 'onepayPayment']);
    Route::match(['get', 'post'], '/ipn', [OnePayController::class, 'handleIPN']);
});
Route::match(['get', 'post'], '/onepay/process', [OnePayController::class, 'process']);

