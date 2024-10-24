<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Abroad\AbroadController;
use App\Http\Controllers\Abroad\CourseController;
use App\Http\Controllers\Abroad\AbroadApplicationController;
use App\Http\Controllers\Abroad\Report\StudentHourReportController;
use App\Http\Controllers\Abroad\RefundRequestController;
use App\Http\Controllers\Abroad\SectionReportsController;
use App\Http\Controllers\Abroad\SectionController;
use App\Http\Controllers\Abroad\StaffController;
use App\Http\Controllers\Abroad\StudentController;
use App\Http\Controllers\Abroad\CalendarController;
use App\Http\Controllers\Abroad\ClassAssignmentsController;
use App\Http\Controllers\Abroad\Report\TeacherHourReportController;
use App\Http\Controllers\Abroad\ReserveController;
use App\Http\Controllers\Abroad\NoteLogController;
use App\Http\Controllers\Abroad\PaymentRecordController;
use App\Http\Controllers\Abroad\LoTrinhChienLuocController;
use App\Http\Controllers\Abroad\LoTrinhHoatDongNgoaiKhoaController;
use App\Http\Controllers\Abroad\AbroadApplicationFinishDayController;
use App\Http\Controllers\Abroad\AbroadApplicationStatusController;
use App\Http\Controllers\Abroad\Report\HonorsThesisReportController;
use App\Http\Controllers\Abroad\Report\UpsellReportController;
use App\Http\Controllers\Abroad\ExtracurricularController;
use App\Http\Controllers\Abroad\OrderItemController;


Route::middleware('auth', 'abroad', 'check.password.change')->group(function () {
    // Courses
    Route::get('abroad/courses/index', [CourseController::class, 'index']);
    Route::get('abroad/courses/list', [CourseController::class, 'list']);
    Route::delete('abroad/courses/delete', [CourseController::class, 'delete']);
    Route::get('abroad/courses/edit', [CourseController::class, 'edit']);
    Route::get('abroad/courses/edit-calendar', [CourseController::class, 'editCalendar']);
    Route::put('abroad/courses/update/{id}', [CourseController::class, 'update']);
    Route::put('abroad/courses/update-calendar/{id}', [CourseController::class, 'updateCalendar']);
    Route::delete('abroad/courses/delete-all', [CourseController::class, 'deleteAll']);
    Route::match(['post', 'get'], 'abroad/courses/add', [CourseController::class, 'add']);
    Route::post('abroad/courses/calendar', [CalendarController::class, 'getCalendar']);
    Route::post('abroad/courses/sections-list', [CalendarController::class, 'getSectionsList']);
    Route::post('abroad/courses/dashboard-calendar', [CalendarController::class, 'getDashboardCalendar']);
    Route::match(['post', 'put'], 'abroad/courses/create', [CourseController::class, 'create']);
    Route::get('abroad/courses/add-schedule', [CourseController::class, 'addSchedule']);
    Route::get('abroad/courses/edit-schedule', [CourseController::class, 'editSchedule']);
    Route::get('abroad/courses/{id}/showDetail', [CourseController::class, 'showDetail']);
    Route::get('abroad/courses/{id}/students', [CourseController::class, 'students']);
    Route::get('abroad/courses/{id}/studentList', [CourseController::class, 'studentList']);
    Route::get('abroad/courses/{id}/schedule', [CourseController::class, 'schedule']);
    Route::get('abroad/courses/{id}/sections', [CourseController::class, 'sections']);
    Route::get('abroad/courses/{id}/sectionList', [CourseController::class, 'sectionList']);
    Route::get('abroad/courses/{id}/attendancePopup', [CourseController::class, 'attendancePopup']);
    Route::post('abroad/courses/{id}/saveAttendancePopup', [CourseController::class, 'saveAttendancePopup']);
    Route::get('abroad/courses/{id}/reschedulePopup', [CourseController::class, 'reschedulePopup']);
    Route::put('abroad/courses/{id}', [CourseController::class, 'updateSchedulePopup']);
    Route::post('abroad/schedule-items/create-schedule-item', [CourseController::class, 'createScheduleItem']);
    Route::post('abroad/schedule-items/edit-week-schedule-item', [CourseController::class, 'editWeekScheduleItem']);
    Route::get('abroad/courses/course-stopped', [CourseController::class, 'courseStopped']);
    Route::post('abroad/courses/done-course-stopped', [CourseController::class, 'doneCourseStopped']);
    Route::get('abroad/courses/suggest_teacher/', [CourseController::class, 'suggestTeacher']);
    Route::get('abroad/courses/getPayrateTeachers', [CourseController::class, 'getPayrateTeachers']);
    Route::get('abroad/courses/getSubjects', [CourseController::class, 'getSubjects']);
    Route::get('abroad/courses/get-zoom-meeting-link', [CourseController::class, 'getZoomMeetingLink']);
    Route::get('abroad/courses/{id}/copy', [CourseController::class, 'copy']);
    Route::get('abroad/teachers/get-home-room-by-area/{area}', [StaffController::class, 'getHomeRoomByArea']);

    //Assignmnment Student to class
    Route::get('abroad/courses/assign-student-to-class', [CourseController::class, 'assignStudentToClass']);
    Route::post('abroad/courses/done-assign-student-to-class', [CourseController::class, 'doneAssignStudentToClass']);

    Route::get('abroad/{id}/handover', [ExtracurricularController::class, 'handover']);
    //Calendar
    Route::get('abroad/schedule-items/edit-event-in-calendar', [CalendarController::class, 'editEventInCalendar']);
    Route::get('abroad/courses/add-event-in-calendar', [CalendarController::class, 'addEventInCalendar']);
    Route::post('abroad/courses/upate-event-in-calendar', [CalendarController::class, 'updateEventInCalendar']);
    Route::post('abroad/schedule-items/create-event-in-calendar', [CalendarController::class, 'createEventInCalendar']);
    Route::get('abroad/financial-capability-/select2', [AbroadController::class, 'financialCapabilitySelect2']);

    //Report Section
    Route::get('abroad/courses/{id}/reportSection', [SectionReportsController::class, 'reportSection']);
    Route::get('abroad/courses/getStudents', [SectionReportsController::class, 'getStudents']);
    Route::get('abroad/courses/getSectionReportData', [SectionReportsController::class, 'getSectionReportData']);
    Route::post('abroad/courses/{id}/create/', [SectionReportsController::class, 'saveReportSectionInCourse']);
    Route::delete('abroad/courses/destroy/{section_id}/{contact_id}', [SectionReportsController::class, 'destroy']);
    Route::get('abroad/sections/{id}/create/{contact_id}', [SectionReportsController::class, 'create']);
    Route::post('abroad/sections/{id}/create/{contact_id}', [SectionReportsController::class, 'saveReportSection']);
    Route::get('abroad/report_sections/{id}/edit/{contact_id}', [SectionReportsController::class, 'edit']);
    Route::post('abroad/report_sections/{id}/reportSection/{contact_id}', [SectionReportsController::class, 'updateReportSection']);
    Route::get('abroad/report_sections/{id}/report-section-popup/{course_id}', [SectionReportsController::class, 'reportSectionPopup']);
    Route::get('abroad/report_sections/{id}/report-section-popup/{course_id}/create', [SectionReportsController::class, 'createReportSectionPopup']);
    Route::post('abroad/courses/{id}/reportSection/{contact_id}', [SectionReportsController::class, 'saveReportSectionPopup']);

    // Staffs
    Route::get('abroad/staffs', [StaffController::class, 'index']);
    Route::get('abroad/staffs/list', [StaffController::class, 'list']);
    Route::delete('abroad/staffs', [StaffController::class, 'delete']);
    Route::delete('abroad/staffs/delete-all', [StaffController::class, 'deleteAll']);
    Route::get('abroad/staffs/create', [StaffController::class, 'create']);
    Route::post('abroad/staffs/store', [StaffController::class, 'store']);
    Route::get('abroad/staffs/{id}/show', [StaffController::class, 'show']);
    Route::get('abroad/staffs/{id}/busy-schedule', [StaffController::class, 'busySchedule']);
    Route::put('abroad/staffs/{id}/save-busy-schedule', [StaffController::class, 'saveBusySchedule']);
    Route::get('abroad/staffs/{id}/class', [StaffController::class, 'class']);
    Route::get('abroad/staffs/{id}/classList', [StaffController::class, 'classList']);
    Route::get('abroad/staffs/{id}/calendar', [StaffController::class, 'calendar']);
    Route::get('abroad/staffs/{id}/teachingSchedule', [StaffController::class, 'teachingSchedule']);
    Route::get('abroad/staffs/{id}/teachingScheduleList', [StaffController::class, 'teachingScheduleList']);
    Route::get('abroad/staffs/{id}/salarySheet', [StaffController::class, 'salarySheet']);
    Route::get('abroad/staffs/{id}/salarySheetList', [StaffController::class, 'salarySheetList']);
    Route::get('abroad/staffs/{id}/expenseHistory', [StaffController::class, 'expenseHistory']);

    // Class Assignment
    Route::get('abroad/class/assignments', [ClassAssignmentsController::class, 'index']);
    Route::get('abroad/class/assignments/list', [ClassAssignmentsController::class, 'list']);
    Route::get('abroad/class/assignments/list', [ClassAssignmentsController::class, 'list']);
    Route::get('abroad/class/assignments/assign-to-class', [ClassAssignmentsController::class, 'assignToClass']);

    // Students
    Route::get('abroad/students/note-logs-popup/{id}', [StudentController::class, 'noteLogsPopup']);
    Route::post('abroad/students/{id}/save', [StudentController::class, 'save']);
    Route::get('abroad/students/select2', [StudentController::class, 'select2']);
    Route::get('abroad/students/{id}/update-history', [StudentController::class, 'updateHistory']);
    Route::get('abroad/students/{id}/note-logs', [StudentController::class, 'noteLog']);
    Route::get('abroad/students/note-logs-list/{id}', [StudentController::class, 'noteLogList']);
    Route::get('abroad/students/{id}/show', [StudentController::class, 'show']);
    Route::get('abroad/students/{id}/class', [StudentController::class, 'class']);
    Route::get('abroad/students/{id}/classList', [StudentController::class, 'classList']);
    Route::get('abroad/students/{id}/section', [StudentController::class, 'section']);
    Route::get('abroad/students/{id}/sectionList', [StudentController::class, 'sectionList']);
    Route::get('abroad/students/{id}/schedule', [StudentController::class, 'schedule']);
    Route::get('abroad/students/{id}/refund', [StudentController::class, 'refund']);
    Route::get('abroad/students/{id}/refundList', [StudentController::class, 'refundList']);
    Route::get('abroad/students/{id}/reserve/student/detail', [StudentController::class, 'reserveStudentDetail']);
    Route::get('abroad/students/{id}/reserveList', [StudentController::class, 'reserveList']);
    Route::get('abroad/students/{id}/transfer/student/detail', [StudentController::class, 'transferStudentDetail']);
    Route::get('abroad/students/{id}/transferList', [StudentController::class, 'transferList']);

    Route::get('abroad/students/{id}/calendar', [StudentController::class, 'calendar']);
    Route::get('abroad/students/{id}/contract', [StudentController::class, 'contract']);
    Route::get('abroad/students/{id}/contract-list', [StudentController::class, 'contractList']);
    Route::get('abroad/students/{id}/extra-activity', [StudentController::class, 'extraActivity']);
    Route::get('abroad/students/{id}/kid-tech', [StudentController::class, 'kidTech']);
    Route::get('abroad/students/{id}/edit', [StudentController::class, 'edit']);
    Route::put('abroad/students/{id}', [StudentController::class, 'update']);
    Route::delete('abroad/students/{id}', [StudentController::class, 'destroy']);
    Route::post('abroad/students', [StudentController::class, 'store']);
    Route::get('abroad/students/create', [StudentController::class, 'create']);
    Route::get('abroad/students/list', [StudentController::class, 'list']);
    Route::get('abroad/students', [StudentController::class, 'index']);
    Route::get('abroad/students/{id}/request-contact', [StudentController::class, 'requestContact']);
    Route::get('abroad/students/{id}/request-contact-list', [StudentController::class, 'requestContactList']);
    Route::get('abroad/students/assign-to-class', [StudentController::class, 'assignToClass']);
    Route::get('abroad/students/order-form', [StudentController::class, 'orderForm']);
    Route::get('abroad/students/order-item-form', [StudentController::class, 'orderItemForm']);
    Route::get('abroad/students/course-form', [StudentController::class, 'courseForm']);
    Route::post('abroad/students/done-assign-to-class', [StudentController::class, 'doneAssignToClass']);
    Route::get('abroad/students/study-partner', [StudentController::class, 'studyPartner']);
    Route::get('abroad/students/section-form', [StudentController::class, 'sectionForm']);
    Route::get('abroad/students/course-student-form', [StudentController::class, 'courseStudentForm']);
    Route::get('abroad/students/course-partner', [StudentController::class, 'coursePartner']);
    Route::get('abroad/students/section-student', [StudentController::class, 'sectionStudent']);
    Route::post('abroad/students/done-study-partner', [StudentController::class, 'doneStudyPartner']);

    Route::get('abroad/students/transfer-class', [StudentController::class, 'transferClass']);
    Route::get('abroad/students/course-transfer-student-form', [StudentController::class, 'courseTransferStudentForm']);
    Route::get('abroad/students/course-transfer-form', [StudentController::class, 'courseTransfer']);
    Route::post('abroad/students/done-transfer-class', [StudentController::class, 'doneTransferClass']);

    Route::get('abroad/students/reserve', [StudentController::class, 'reserve']);

    Route::get('abroad/students/order-item-reserve-form', [StudentController::class, 'orderItemReserveForm']);
    Route::get('abroad/students/course-reserve-form', [StudentController::class, 'courseReserveForm']);
    Route::post('abroad/students/done-reserve', [StudentController::class, 'doneReserve']);

    Route::get('abroad/students/refund-request', [StudentController::class, 'refundRequest']);
    Route::get('abroad/students/course-refund-request-form', [StudentController::class, 'courseRefundRequestForm']);
    Route::get('abroad/students/order-item-refund-request-form', [StudentController::class, 'orderItemRefundRequestForm']);
    Route::post('abroad/students/done-refund-request', [StudentController::class, 'doneRefundRequest']);

    Route::get('abroad/students/assign-to-class-request-demo', [StudentController::class, 'assignToClassRequestDemo']);
    Route::get('abroad/students/order-form-request-demo', [StudentController::class, 'orderFormRequestDemo']);
    Route::get('abroad/students/order-item-form-request-demo', [StudentController::class, 'orderItemFormRequestDemo']);
    Route::get('abroad/students/course-form-request-demo', [StudentController::class, 'courseFormRequestDemo']);
    Route::get('abroad/students/section-form-request-demo', [StudentController::class, 'sectionFormRequestDemo']);
    Route::post('abroad/students/done-assign-to-class-request-demo', [StudentController::class, 'doneAssignToClassRequestDemo']);

    // transfer
    Route::get('abroad/students/transfer', [StudentController::class, 'transfer']);
    Route::post('abroad/students/transfer/save-transfer', [StudentController::class, 'transferSave']);
    Route::get('abroad/students/transfer/order-item/select', [StudentController::class, 'transferOrderItemSelect']);
    Route::get('abroad/students/transfer/form-detail', [StudentController::class, 'transferFormDetail']);

    //exit class
    Route::get('abroad/students/exit-class', [StudentController::class, 'exitClass']);
    Route::post('abroad/students/done-exit-class', [StudentController::class, 'doneExitClass']);

    // Sections
    Route::get('abroad/sections/calendar/content', [SectionController::class, 'abroadCalendarContent']);
    Route::get('abroad/sections/calendar', [SectionController::class, 'calendar']);
    Route::get('abroad/sections/index', [SectionController::class, 'index']);
    Route::get('abroad/sections/list', [SectionController::class, 'list']);
    Route::delete('abroad/sections/destroy', [SectionController::class, 'destroy']);
    Route::delete('abroad/sections/delete-all', [SectionController::class, 'deleteAll']);
    Route::post('abroad/sections/{id}/saveAttendancePopup', [SectionController::class, 'saveAttendancePopup']);
    Route::get('abroad/sections/{id}/changeTeacherPopup', [SectionController::class, 'changeTeacherPopup']);
    Route::put('abroad/sections/{id}/changeTeacherPopup', [SectionController::class, 'saveChangeTeacherPopup']);
    Route::get('abroad/sections/{id}/shiftPopup', [SectionController::class, 'shiftPopup']);
    Route::post('abroad/sections/{id}/saveShift', [SectionController::class, 'saveShift']);
    Route::get('abroad/sections/{id}/show-zoom-join-links', [SectionController::class, 'showZoomJoinLinks']);
    Route::get('abroad/sections/{id}/update-zoom-links-popup', [SectionController::class, 'updateZoomLinksPopup']);
    Route::post('abroad/sections/{id}/update-zoom-links', [SectionController::class, 'updateZoomLinks']);

    //Reserve
    Route::get('abroad/reserve/index', [ReserveController::class, 'index']);
    Route::get('abroad/reserve/list', [ReserveController::class, 'list']);
    Route::get('abroad/reserve/reserve-student', [ReserveController::class, 'reserveStudent']);
    Route::get('abroad/reserve/reserve-extend', [ReserveController::class, 'reserveExtend']);
    Route::post('abroad/reserve/done-reserve-extend', [ReserveController::class, 'doneReserveExtend']);
    Route::get('abroad/reserve/reserve-cancelled', [ReserveController::class, 'reserveCancelled']);
    Route::post('abroad/reserve/done-reserve-cancelled', [ReserveController::class, 'doneReserveCancelled']);

    //Report
    Route::get('abroad/teacher_hour_report', [TeacherHourReportController::class, 'index']);
    Route::get('abroad/teacher_hour_report/list', [TeacherHourReportController::class, 'list']);
    Route::get('abroad/student_hour_report', [StudentHourReportController::class, 'index']);
    Route::get('abroad/student_hour_report/list', [StudentHourReportController::class, 'list']);
    Route::get('abroad/student_hour_report/{id}/list-details-student', [StudentHourReportController::class, 'listDetailStudent']);

    //Refund_request
    Route::get('abroad/refund_requests', [RefundRequestController::class, 'index']);
    Route::get('abroad/refund_requests/list', [RefundRequestController::class, 'list']);
    Route::get('abroad/refund_requests/{id}/showRequest', [RefundRequestController::class, 'showRequest']);

    // Order
    Route::get('abroad/abroad-application', [AbroadController::class, 'index']);
    Route::get('abroad/abroad-application/list', [AbroadController::class, 'list']);
    Route::delete('abroad/abroad-application/delete-all', [AbroadController::class, 'deleteAll']);
    Route::get('abroad/services/get-services-by-type', [AbroadController::class, 'getServicesByType']);
    Route::get('abroad/abroad-application/{id}/general', [AbroadController::class, 'general']);
    Route::get('abroad/abroad-application/{id}/essay', [AbroadController::class, 'essay']);

    //IV 1 Lộ trình học thuật chiến lược
    Route::get('abroad/abroad-application/{id}/strategic-learning-curriculum', [AbroadController::class, 'strategicLearningCurriculum']);
    Route::get('abroad/abroad-application/{id}/strategic-learning-curriculum/declare', [AbroadController::class, 'declareStrategicLearningCurriculum']);
    Route::get('abroad/abroad-application/{id}/strategic-learning-curriculum/view_declaration', [AbroadController::class, 'viewStrategicLearningCurriculum']);
    
    // IV.2 Extracurricular plan
    Route::get('abroad/abroad-application/{id}/extracurricular-plan', [AbroadController::class, 'extracurricularPlan']);
    Route::get('abroad/abroad-application/{id}/extracurricular-plan/declare', [AbroadController::class, 'declareExtracurricularPlan']);
    Route::get('abroad/abroad-application/{id}/extracurricular-plan/view_declaration', [AbroadController::class, 'viewExtracurricularPlanDeclaration']);

    // IV.7 Recommendation letter
    Route::get('abroad/abroad-application/{id}/recommendation-letter', [AbroadController::class, 'recommendationLetter']);
    Route::get('abroad/abroad-application/{id}/show', [AbroadController::class, 'showDetailRecommendationLetter']);
    Route::get('abroad/abroad-application/{id}/recommendation-letter/create', [AbroadController::class, 'createRecommendationLetter']);
    Route::get('abroad/abroad-application/recommendation-letter/{id}/edit', [AbroadController::class, 'editRecommendationLetter']);
    Route::post('abroad/abroad-application/recommendation-letter/{id}/update', [AbroadController::class, 'updateRecommendationLetter']);
    Route::post('abroad/abroad-application/{id}/recommendation-letter/delete', [AbroadController::class, 'deleteRecommendationLetter']);
    Route::post('abroad/abroad-application/{id}/recommendation-letter/store', [AbroadController::class, 'storeRecommendationLetter']);
    Route::put('abroad/abroad-application/recommendation-letter/{id}/complete', [AbroadController::class, 'completeRecommendationLetter']);

    // IV.8 essay result 
    Route::get('abroad/abroad-application/{id}/essay-result', [AbroadController::class, 'essayResult']);
    Route::get('abroad/abroad-application/{id}/essay-result/create', [AbroadController::class, 'createEssayResult']);
    Route::post('abroad/abroad-application/{id}/essay-result/store', [AbroadController::class, 'storeEssayResult']);
    Route::get('abroad/abroad-application/{id}/essay-result/show', [AbroadController::class, 'showEssayResult']);
    Route::delete('abroad/abroad-application/{id}/essay-result/delete', [AbroadController::class, 'deleteEssayResult']);
    Route::get('abroad/abroad-application/essay-result/{id}/edit', [AbroadController::class, 'editEssayResult']);
    Route::post('abroad/abroad-application/essay-result/{id}/update', [AbroadController::class, 'updateEssayResult']);
    Route::post('abroad/abroad-application/{id}/essay-result-file/delete', [AbroadController::class, 'deleteEssayResultFile']);

    // IV.8 Mạng xã hội 
    Route::get('abroad/abroad-application/{id}/social-network', [AbroadController::class, 'socialNetwork']);
    Route::get('abroad/abroad-application/{id}/update-social-network', [AbroadController::class, 'updateSocialNetwork']);
    Route::put('abroad/abroad-application/{id}/done-update-social-network', [AbroadController::class, 'doneUpdateSocialNetwork']);
    Route::get('abroad/abroad-application/{id}/create-social-network', [AbroadController::class, 'createSocialNetwork']);
    Route::put('abroad/abroad-application/{id}/done-create-social-network', [AbroadController::class, 'doneCreateSocialNetwork']);
    Route::get('abroad/abroad-application/{id}/social-network-declaration', [AbroadController::class, 'socialNetworkDeclaration']);
    Route::put('abroad/abroad-application/update-active-social-network', [AbroadController::class, 'updateActiveSocialNetwork']);
    Route::get('abroad/abroad-application/{id}/social-network-show', [AbroadController::class, 'socialNetworkShow']);

    // IV.10 Study Abroad Application   
    Route::get('abroad/abroad-application/{id}/study-abroad-application', [AbroadController::class, 'studyAbroadApplication']);
    Route::get('abroad/abroad-application/{id}/create-study-abroad-application', [AbroadController::class, 'createStudyAbroadApplication']);
    Route::get('abroad/abroad-application/{id}/create-study-abroad-application-popup', [AbroadController::class, 'createStudyAbroadApplicationPopup']);
    Route::post('abroad/abroad-application/{id}/done-create-study-abroad-application', [AbroadController::class, 'saveStudyAbroadApplication']);
    Route::put('abroad/abroad-application/{id}/update-status-study-abroad-application-all', [AbroadController::class, 'updateStatusStudyAbroadApplicationAll']);
    Route::get('abroad/abroad-application/{id}/edit-study-abroad-application-popup', [AbroadController::class, 'editStudyAbroadApplicationPopup']);
    Route::post('abroad/abroad-application/{id}/update-study-abroad-application-popup', [AbroadController::class, 'updateStudyAbroadApplication']);
    Route::put('abroad/abroad-application/{id}/update-status-study-abroad-application', [AbroadController::class, 'completeStatusActive']);
    Route::get('abroad/abroad-application/{id}/show-study-abroad-application', [AbroadController::class, 'showStudyAbroadApplication']);


    Route::post('abroad/abroad-application/{id}/file-study-abroad-application/store', [AbroadController::class, 'storeFileStudyAbroadApplication']);
    Route::post('abroad/abroad-application/{id}/file-study-abroad-application/delete', [AbroadController::class, 'deleteFileStudyAbroadApplication']);

    // IV.11 Student CV
    Route::get('abroad/abroad-application/{id}/student-cv', [AbroadController::class, 'studentCV']);
    Route::post('abroad/abroad-application/{id}/cv/store', [AbroadController::class, 'storeCV']);
    Route::post('abroad/abroad-application/{id}/cv/delete', [AbroadController::class, 'deleteCV']);

    // V.1 Honor thesis
    Route::get('abroad/abroad-application/{id}/honor-thesis', [AbroadController::class, 'honorThesis']);

    // V.2 Edit thesis/Sửa Luận
    Route::get('abroad/abroad-application/{id}/edit-thesis', [AbroadController::class, 'editThesis']);

    // V.5 Interview Practice/ Luyện phỏng vấn
    Route::get('abroad/abroad-application/{id}/interview-practice', [AbroadController::class, 'interviewPractice']);

    // V.2 Application fee
    Route::get('abroad/abroad-application/{id}/application-fee', [AbroadController::class, 'applicationFee']);
    Route::get('abroad/abroad-application/{id}/create-application-fee', [AbroadController::class, 'createApplicationFee']);
    Route::post('abroad/abroad-application/{id}/done-create-application-fee', [AbroadController::class, 'doneCreateApplicationFee']);
    Route::get('abroad/abroad-application/{id}/edit-application-fee', [AbroadController::class, 'editApplicationFee']);
    Route::post('abroad/abroad-application/{id}/update-application-fee', [AbroadController::class, 'updateApplicationFee']);

    Route::get('abroad/abroad-application/{id}/pay-and-confirm', [AbroadController::class, 'payAndConfirm']);
    Route::get('abroad/abroad-application/{id}/show-pay-and-confirm', [AbroadController::class, 'showPayAndConfirm']);
    Route::post('abroad/abroad-application/{id}/file-confirmation/store', [AbroadController::class, 'storeFileConfirmation']);
    Route::post('abroad/abroad-application/{id}/file-confirmation/delete', [AbroadController::class, 'deleteFileComfirmation']);
    Route::post('abroad/abroad-application/{id}/file-fee-paid/store', [AbroadController::class, 'storeFileFeePaid']);
    Route::post('abroad/abroad-application/{id}/file-fee-paid/delete', [AbroadController::class, 'deleteFileFeePaid']);

    // V.3 Submit application
    Route::get('abroad/abroad-application/{id}/application-submission', [AbroadController::class, 'applicationSubmission']);
    Route::get('abroad/abroad-application/{id}/create-application-submission', [AbroadController::class, 'createApplicationSubmission']);
    Route::post('abroad/abroad-application/{id}/done-application-submission', [AbroadController::class, 'doneApplicationSubmission']);
    Route::get('abroad/abroad-application/{id}/edit-application-submission', [AbroadController::class, 'editApplicationSubmission']);
    Route::post('abroad/abroad-application/{id}/update-application-submission', [AbroadController::class, 'updateApplicationSubmission']);

    // V.5 School Selected Result
    Route::get('abroad/abroad-application/{id}/application-admitted-school', [AbroadController::class, 'applicationAdmittedSchool']);
    Route::get('abroad/abroad-application/{id}/create-application-admitted-school', [AbroadController::class, 'createApplicationAdmittedSchool']);
    Route::post('abroad/abroad-application/{id}/done-application-admitted-school', [AbroadController::class, 'doneApplicationAdmittedSchool']);
    Route::post('abroad/abroad-application/{id}/save-school-selected', [AbroadController::class, 'saveSchoolSelected']);
    Route::get('abroad/abroad-application/{id}/edit-application-admitted-school', [AbroadController::class, 'editApplicationAdmittedSchool']);
    Route::post('abroad/abroad-application/{id}/update-application-admitted-school', [AbroadController::class, 'updateApplicationAdmittedSchool']);

    // V.6 Deposit tuition fee
    Route::get('abroad/abroad-application/{id}/deposit-tuition-fee', [AbroadController::class, 'depositTuitionFee']);
    Route::post('abroad/abroad-application/{id}/deposit-data/update', [AbroadController::class, 'updateDepositData']);
    Route::post('abroad/abroad-application/{id}/deposit-file/store', [AbroadController::class, 'storeDepositFile']);
    Route::post('abroad/abroad-application/{id}/deposit-file/delete', [AbroadController::class, 'deleteDepositFile']);

    // V.7 Deposit for school
    Route::get('abroad/abroad-application/{id}/deposit-for-school', [AbroadController::class, 'depositForSchool']);
    
    Route::post('abroad/abroad-application/{id}/deposit-for-school/update', [AbroadController::class, 'updateDepositForSchool']);
    Route::post('abroad/abroad-application/{id}/deposit-for-school/store', [AbroadController::class, 'storeDepositForSchool']);
    Route::post('abroad/abroad-application/{id}/deposit-for-school/delete', [AbroadController::class, 'deleteDepositForSchool']);
  

    // V.9 Cultural Orientations
    Route::get('abroad/abroad-application/{id}/cultural-orientations', [AbroadController::class, 'culturalOrientations']);
    Route::get('abroad/abroad-application/{id}/update-cultural-orientation', [AbroadController::class, 'updateCulturalOrientation']);
    Route::put('abroad/abroad-application/{id}/done-update-cultural-orientation', [AbroadController::class, 'doneUpdateCulturalOrientation']);
    Route::get('abroad/abroad-application/{id}/create-cultural-orientation', [AbroadController::class, 'createCulturalOrientation']);
    Route::put('abroad/abroad-application/{id}/done-create-cultural-orientation', [AbroadController::class, 'doneCreateCulturalOrientation']);

    // V.10 Support Activities
    Route::get('abroad/abroad-application/{id}/support-activities', [AbroadController::class, 'supportActivities']);
    Route::get('abroad/abroad-application/{id}/update-support-activity', [AbroadController::class, 'updateSupportActivity']);
    Route::put('abroad/abroad-application/{id}/done-update-support-activity', [AbroadController::class, 'doneUpdateSupportActivity']);
    Route::get('abroad/abroad-application/{id}/create-support-activity', [AbroadController::class, 'createSupportActivity']);
    Route::put('abroad/abroad-application/{id}/done-create-support-activity', [AbroadController::class, 'doneCreateSupportActivity']);

    // VI.6 Flying Student/ Thời điểm học sinh lên đường
    Route::get('abroad/abroad-application/{id}/flying-student', [AbroadController::class, 'flyingStudent']);
    Route::get('abroad/abroad-application/{id}/create-flying-student', [AbroadController::class, 'createFlyingStudent']);
    Route::post('abroad/abroad-application/{id}/done-create-flying-student', [AbroadController::class, 'doneCreateFlyingStudent']);
    Route::get('abroad/abroad-application/{id}/update-flying-student', [AbroadController::class, 'updateFlyingStudent']);
    Route::post('abroad/abroad-application/{id}/done-update-flying-student', [AbroadController::class, 'doneUpdateFlyingStudent']);
    
    // VI.7 Complete application
    Route::get('abroad/abroad-application/{id}/complete-application', [AbroadController::class, 'completeApplication']);
    Route::post('abroad/abroad-application/{id}/request-approval-complete-application', [AbroadController::class, 'requestApprovalCompleteApplication']);
    Route::post('abroad/abroad-application/{id}/approval-complete-application', [AbroadController::class, 'approveCompleteApplication']);
    Route::post('abroad/abroad-application/{id}/reject-complete-application', [AbroadController::class, 'rejectCompleteApplication']);

    // Kết quả dự tuyển
    Route::get('abroad/abroad-application/{id}/admissionLetter', [AbroadController::class, 'admissionLetter']);
    Route::post('abroad/abroad-application/{id}/admission-letter/store-admission-letter', [AbroadController::class, 'storeAdmissionLetter']);
    Route::post('abroad/abroad-application/{id}/admission-letter/delete-admission-letter', [AbroadController::class, 'deleteAdmissionLetter']);
    Route::get('abroad/abroad-application/{id}/create-admission-letter', [AbroadController::class, 'createAdmissionLetter']);

   
    Route::post('abroad/abroad-application/{id}/admission-letter/store', [AbroadController::class, 'storeScholarshipFile']);
    Route::post('abroad/abroad-application/{id}/admission-letter/delete', [AbroadController::class, 'deleteScholarshipFile']);

    Route::put('abroad/abroad-application/{id}/done-create-recruitment-results', [AbroadController::class, 'doneCreateRecruitmentResults']);
    Route::put('abroad/abroad-application/update-active-recruitment-results', [AbroadController::class, 'updateActiveRecruitmentResults']);

    // Route::get('abroad/abroad-application/{id}/create-study-abroad-application-popup', [AbroadController::class, 'createStudyAbroadApplicationPopup']);
    // Route::post('abroad/abroad-application/{id}/done-create-study-abroad-application', [AbroadController::class, 'saveStudyAbroadApplication']);
    // Route::put('abroad/abroad-application/{id}/update-status-study-abroad-application-all', [AbroadController::class, 'updateStatusStudyAbroadApplicationAll']);
    // Route::get('abroad/abroad-application/{id}/edit-study-abroad-application-popup', [AbroadController::class, 'editStudyAbroadApplicationPopup']);
    // Route::post('abroad/abroad-application/{id}/update-study-abroad-application-popup', [AbroadController::class, 'updateStudyAbroadApplication']);
    // Route::put('abroad/abroad-application/{id}/update-status-study-abroad-application', [AbroadController::class, 'completeStatusActive']);
    Route::get('abroad/abroad-application/{id}/show-recruitment-results', [AbroadController::class, 'showRecruitmentResults']);

    // Hồ sơ tài chính
    Route::get('abroad/abroad-application/{id}/financial-document', [AbroadController::class, 'financialDocument']);
    Route::post('abroad/abroad-application/{id}/financial-document/store-financial-document', [AbroadController::class, 'storeFinancialDocument']);
    Route::post('abroad/abroad-application/{id}/financial-document/delete-financial-document', [AbroadController::class, 'deleteFinancialDocument']);

    //Hồ sơ dự tuyển
    Route::get('abroad/abroad-application/{id}/hsdt', [AbroadController::class, 'hsdt']);
    Route::post('abroad/abroad-application/{id}/request-approval-hsdt', [AbroadController::class, 'requestApprovalHSDT']);
    Route::post('abroad/abroad-application/{id}/approval-hsdt', [AbroadController::class, 'approveHSDT']);
    Route::post('abroad/abroad-application/{id}/reject-hsdt', [AbroadController::class, 'rejectHSDT']);

    // Hồ sơ hoàn chỉnh
    Route::get('abroad/abroad-application/{id}/complete-file', [AbroadController::class, 'completeFile']);
    Route::post('abroad/abroad-application/{id}/complete-file/store-complete-file', [AbroadController::class, 'storeCompleteFile']);
    Route::post('abroad/abroad-application/{id}/complete-file/delete-complete-file', [AbroadController::class, 'deleteCompleteFile']);

    //15 Bản scan thông tin các nhân
    Route::get('abroad/abroad-application/{id}/scan-of-information', [AbroadController::class, 'scanOfInformation']);
    Route::post('abroad/abroad-application/{id}/scan-of-information/store-scan-of-information', [AbroadController::class, 'storeScanOfInformation']);
    Route::post('abroad/abroad-application/{id}/scan-of-information/delete-scan-of-information', [AbroadController::class, 'deleteScanOfInformation']);

    // Kế hoạch ngoại khoá
    Route::get('abroad/abroad-application/{id}/create-extracurricular-schedule', [AbroadController::class, 'createExtracurricularSchedule']);
    Route::put('abroad/abroad-application/{id}/done-create-extracurricular-schedule', [AbroadController::class, 'doneCreateExtracurricularSchedule']);
    Route::get('abroad/abroad-application/{id}/update-extracurricular-schedule', [AbroadController::class, 'updateExtracurricularSchedule']);
    Route::put('abroad/abroad-application/{id}/done-update-extracurricular-schedule', [AbroadController::class, 'doneUpdateExtracurricularSchedule']);
    Route::get('abroad/abroad-application/{id}/extracurricular-schedule-declaration', [AbroadController::class, 'extracurricularScheduleDeclaration']);
    Route::get('abroad/abroad-application/{id}/extracurricular-schedule-show', [AbroadController::class, 'extracurricularScheduleShow']);
    Route::put('abroad/abroad-application/update-active-extracurricular-schedule', [AbroadController::class, 'updateActiveExtracurricularSchedule']);
    Route::put('abroad/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularSchedule']);

    // Chứng chỉ
    Route::get('abroad/abroad-application/{id}/certifications', [AbroadController::class, 'certifications']);
    Route::get('abroad/abroad-application/{id}/update-certification', [AbroadController::class, 'updateCertification']);
    Route::put('abroad/abroad-application/{id}/done-update-certification', [AbroadController::class, 'doneCreateCertification']);
    Route::get('abroad/abroad-application/{id}/create-certifications', [AbroadController::class, 'createCertifications']);
    Route::put('abroad/abroad-application/{id}/done-create-certifications', [AbroadController::class, 'doneUpdateCertification']);
    Route::get('abroad/abroad-application/{id}/certification-declaration', [AbroadController::class, 'certificationDeclaration']);
    Route::get('abroad/abroad-application/{id}/certification-show', [AbroadController::class, 'certificationShow']);
    Route::put('abroad/abroad-application/update-active-certification', [AbroadController::class, 'updateActiveCertification']);
    Route::put('abroad/abroad-application/update-draft-certification', [AbroadController::class, 'updateDraftCertification']);

    // Hoạt động ngoại khoá
    Route::get('abroad/abroad-application/{id}/extracurricular-activity', [AbroadController::class, 'extracurricularActivity']);
    Route::get('abroad/abroad-application/{id}/create-extracurricular-activity', [AbroadController::class, 'createExtracurricularActivity']);
    Route::put('abroad/abroad-application/{id}/done-create-extracurricular-activity', [AbroadController::class, 'doneCreateExtracurricularActivity']);
    Route::get('abroad/abroad-application/{id}/update-extracurricular-activity', [AbroadController::class, 'updateExtracurricularActivity']);
    Route::put('abroad/abroad-application/{id}/done-update-extracurricular-activity', [AbroadController::class, 'doneUpdateExtracurricularActivity']);
    Route::get('abroad/abroad-application/{id}/extracurricular-activity-declaration', [AbroadController::class, 'extracurricularActivityDeclaration']);
    Route::get('abroad/abroad-application/{id}/extracurricular-activity-show', [AbroadController::class, 'extracurricularActivityShow']);
    Route::put('abroad/abroad-application/update-active-extracurricular-activity', [AbroadController::class, 'updateActiveExtracurricularActivity']);
    Route::put('abroad/abroad-application/update-draft-extracurricular-schedule', [AbroadController::class, 'updateDraftExtracurricularActivity']);
    Route::get('abroad/abroad-application/{id}/upload-image-extracurricular-activity', [AbroadController::class, 'uploadImageExtracurricularActivity']);
    Route::post('abroad/abroad-application/{id}/upload-image-extracurricular-activity/store-image-extracurricular-activity', [AbroadController::class, 'storeUploadImageExtracurricularActivity']);
    Route::post('abroad/abroad-application/{id}/upload-image-extracurricular-activity/delete-image-extracurricular-activity', [AbroadController::class, 'deleteUploadImageExtracurricularActivity']);

    // Danh sách trường yêu cầu tuyển sinh
    Route::get('abroad/abroad-application/{id}/application-school', [AbroadController::class, 'applicationSchool']);
    Route::get('abroad/abroad-application/{id}/application-school-declaration', [AbroadController::class, 'applicationSchoolDeclaration']);
    Route::get('abroad/abroad-application/{id}/update-application-school', [AbroadController::class, 'updateApplicationSchool']);
    Route::get('abroad/abroad-application/{id}/create-application-school', [AbroadController::class, 'createApplicationSchool']);
    Route::put('abroad/abroad-application/{id}/done-create-application-school', [AbroadController::class, 'doneCreateApplicationSchool']);
    Route::put('abroad/abroad-application/{id}/done-update-application-school', [AbroadController::class, 'doneUpdateApplicationSchool']);
    Route::put('abroad/abroad-application/update-active-application-school', [AbroadController::class, 'updateActiveApplicationSchool']);
    

    // I20 Application
    Route::get('abroad/abroad-application/{id}/i20-application', [AbroadController::class, 'i20Application']);
    Route::post('abroad/abroad-application/{id}/i20-application-data/update', [AbroadController::class, 'updateI20ApplicationData']);
    Route::post('abroad/abroad-application/{id}/i20-application-file/store', [AbroadController::class, 'storeI20ApplicationFile']);
    Route::post('abroad/abroad-application/{id}/i20-application-file/delete', [AbroadController::class, 'deleteI20ApplicationFile']);

    // Visa cho học sinh
    Route::get('abroad/abroad-application/{id}/student-visa', [AbroadController::class, 'studentVisa']);
    Route::post('abroad/abroad-application/{id}/student-visa-data/update', [AbroadController::class, 'updateStudentVisaData']);
    Route::post('abroad/abroad-application/{id}/student-visa-file/store', [AbroadController::class, 'storeStudentVisaFile']);
    Route::post('abroad/abroad-application/{id}/student-visa-file/delete', [AbroadController::class, 'deleteStudentVisaFile']);

    // Abroad Application
    Route::get('abroad/abroad-application/{id}/details', [AbroadApplicationController::class, 'details']);
    Route::get('abroad/abroad-application/select2', [AbroadApplicationController::class, 'select2']);
    Route::get('abroad/abroad-application/select2-abroad', [AbroadApplicationController::class, 'select2ForAbroad']);
    Route::get('abroad/abroad-application/select2-extra', [AbroadApplicationController::class, 'select2ForExtracurricular']);
    Route::get('abroad/abroad-application/{id}/update-status-abroad-application', [AbroadController::class, 'updateStatusAbroadApplication']);
    Route::put('abroad/abroad-application/{id}/done-update-status-abroad-application', [AbroadController::class, 'doneAssignmentAbroadApplication']);
    Route::get('abroad/abroad-application/abroad-application-index', [AbroadApplicationController::class, 'abroadApplicationIndex']);
    Route::get('abroad/abroad-application/{id}/cancel', [AbroadController::class, 'cancel']);
    Route::post('abroad/abroad-application/{id}/cancel', [AbroadController::class, 'cancel']);

    Route::get('abroad/abroad-application/{id}/reserve', [AbroadController::class, 'reserve']);
    Route::post('abroad/abroad-application/{id}/reserve', [AbroadController::class, 'reserve']);
    Route::get('abroad/abroad-application/{id}/unreserve', [AbroadController::class, 'unreserve']);
    Route::post('abroad/abroad-application/{id}/unreserve', [AbroadController::class, 'unreserve']);


    
    // LoTrinhHocThuatChienLuoc
    Route::put('abroad/lo-trinh-hoc-thuat-chien-luoc/save', [LoTrinhChienLuocController::class, 'createLoTrinhHocThuatChienLuoc']);
    Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/showIeltsScore', [LoTrinhChienLuocController::class, 'showIeltsScore']);
    Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/createIeltsScore', [LoTrinhChienLuocController::class, 'createIeltsScore']);
    Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneCreateIeltsScore', [LoTrinhChienLuocController::class, 'doneCreateIeltsScore']);
    Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/editIeltsScore', [LoTrinhChienLuocController::class, 'editIeltsScore']);
    Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneEditIeltsScore', [LoTrinhChienLuocController::class, 'doneEditIeltsScore']);
    
    Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/showSatScore', [LoTrinhChienLuocController::class, 'showSatScore']);
    Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/createSatScore', [LoTrinhChienLuocController::class, 'createSatScore']);
    Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneCreateSatScore', [LoTrinhChienLuocController::class, 'doneCreateSatScore']);
    Route::get('abroad/lo-trinh-hoc-thuat-chien-luoc/editSatScore', [LoTrinhChienLuocController::class, 'editSatScore']);
    Route::post('abroad/lo-trinh-hoc-thuat-chien-luoc/doneEditSatScore', [LoTrinhChienLuocController::class, 'doneEditSatScore']);
    
    // Lộ trình hoạt dộng ngoại khoá
    Route::put('abroad/lo-trinh-hoat-dong-ngoai-khoa/save', [LoTrinhHoatDongNgoaiKhoaController::class, 'createLoTrinhHoatDongNgoaiKhoa']);


    // Report
    Route::get('abroad/report/upsell', [UpsellReportController::class, 'index']);
    Route::get('abroad/report/upsell/list', [UpsellReportController::class, 'list']);

    Route::get('abroad/report/honors-thesis', [HonorsThesisReportController::class, 'index']);
    Route::get('abroad/report/honors-thesis/list', [HonorsThesisReportController::class, 'list']);

    

    // Note logs
    Route::get('abroad/note-logs', [NoteLogController::class, 'index']);
    Route::get('abroad/note-logs/list', [NoteLogController::class, 'list']);
    Route::get('abroad/note-logs/{id}/edit', [NoteLogController::class, 'edit']);
    Route::put('abroad/note-logs/{id}', [NoteLogController::class, 'update']);
    Route::delete('abroad/note-logs/{id}', [NoteLogController::class, 'destroy']);
    Route::delete('abroad/note-logs', [NoteLogController::class, 'destroyAll']);
    Route::get('abroad/note-logs/create', [NoteLogController::class, 'create']);
    Route::post('abroad/note-logs/add-notelog/{id}', [NoteLogController::class, 'storeNoteLog']);
    Route::get('abroad/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'createNoteLogCustomer']);
    Route::post('abroad/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'storeNoteLogCustomer']);
    Route::post('abroad/note-logs', [NoteLogController::class, 'store']);
    Route::get('abroad/note-logs/note-logs-popup/{id}', [NoteLogController::class, 'noteLogsPopup']);
    Route::get('abroad/note-logs/add-notelog-contact/{id}', [NoteLogController::class, 'addNoteLog']);

    //Payments
    Route::get('abroad/payments/create-receipt-contact', [PaymentRecordController::class, 'createReceiptContact']);
    Route::post('abroad/payments/store-receipt-contact/{id}', [PaymentRecordController::class, 'storeReceiptContact']);
    Route::get('extracurricular/orders/order-items/select2', [OrderItemController::class, 'select2']);
    

});


    // Thời điểm haonf thành
    Route::put('abroad/abroad-application-finish-day/update', [AbroadApplicationFinishDayController::class, 'updateFinishDay']);

    // Hoàn thành các bước
    Route::put('abroad/abroad-application-done/update', [AbroadApplicationStatusController::class, 'updateDoneAbroadApplication']);

    Route::get('abroad/abroad-application/{id}/extracurricular-schedule', [AbroadController::class, 'extracurricularSchedule']);
    Route::get('abroad/abroad-application/{id}/application-school-show', [AbroadController::class, 'applicationSchoolShow']);

    // Order item -> abroad
    Route::get('abroad/order-items/edit/{id}', [AbroadController:: class, 'editAbroadItem']);
    Route::post('abroad/order-items/save', [AbroadController:: class, 'saveAbroadItemData']);