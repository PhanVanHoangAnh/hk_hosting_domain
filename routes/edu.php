<?php

use App\Http\Controllers\Edu\Report\StudentHourReportController;
use App\Http\Controllers\Edu\Report\StudentSectionReportController;
use App\Http\Controllers\Edu\AttendanceController;
use App\Http\Controllers\Edu\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Edu\DashboardController;
use App\Http\Controllers\Edu\RefundRequestController;
use App\Http\Controllers\Edu\SectionReportsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Edu\CourseController;
use App\Http\Controllers\Edu\SectionController;
use App\Http\Controllers\Edu\StaffController;
use App\Http\Controllers\Edu\StudentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Edu\ClassAssignmentsController;
use App\Http\Controllers\Edu\Report\TeacherHourReportController;
use App\Http\Controllers\Edu\ReserveController;

Route::middleware('auth', 'edu', 'check.password.change')->group(function () {
    // Courses
    Route::get('edu/courses/index', [CourseController::class, 'index']);
    Route::get('edu/courses/list', [CourseController::class, 'list']);
    Route::delete('edu/courses/delete', [CourseController::class, 'delete']);
    Route::get('edu/courses/edit', [CourseController::class, 'edit']);
    Route::get('edu/courses/edit-calendar', [CourseController::class, 'editCalendar']);
    Route::put('edu/courses/update/{id}', [CourseController::class, 'update']);
    Route::put('edu/courses/update-calendar/{id}', [CourseController::class, 'updateCalendar']);
    Route::delete('edu/courses/delete-all', [CourseController::class, 'deleteAll']);
    Route::match(['post', 'get'], 'edu/courses/add', [CourseController::class, 'add']);
    Route::match(['post', 'put'], 'edu/courses/create', [CourseController::class, 'create']);
    Route::get('edu/courses/add-schedule', [CourseController::class, 'addSchedule']);
    Route::get('edu/courses/edit-schedule', [CourseController::class, 'editSchedule']);
    Route::get('edu/courses/{id}/showDetail', [CourseController::class, 'showDetail']);
    Route::get('edu/courses/{id}/students', [CourseController::class, 'students']);
    Route::get('edu/courses/{id}/studentList', [CourseController::class, 'studentList']);
    Route::get('edu/courses/{id}/schedule', [CourseController::class, 'schedule']);
    Route::get('edu/courses/{id}/sections', [CourseController::class, 'sections']);
    Route::get('edu/courses/{id}/sectionList', [CourseController::class, 'sectionList']);
    Route::get('edu/courses/{id}/attendancePopup', [CourseController::class, 'attendancePopup']);
    Route::post('edu/courses/{id}/saveAttendancePopup', [CourseController::class, 'saveAttendancePopup']);
    Route::get('edu/courses/{id}/reschedulePopup', [CourseController::class, 'reschedulePopup']);
    Route::put('edu/courses/{id}', [CourseController::class, 'updateSchedulePopup']);
    Route::post('edu/schedule-items/create-schedule-item', [CourseController::class, 'createScheduleItem']);
    Route::post('edu/schedule-items/edit-week-schedule-item', [CourseController::class, 'editWeekScheduleItem']);
    Route::get('edu/courses/course-stopped', [CourseController::class, 'courseStopped']);
    Route::post('edu/courses/done-course-stopped', [CourseController::class, 'doneCourseStopped']);
    Route::get('edu/courses/suggest_teacher/', [CourseController::class, 'suggestTeacher']);
    Route::get('edu/courses/getPayrateTeachers', [CourseController::class, 'getPayrateTeachers']);
    Route::get('edu/courses/getSubjects', [CourseController::class, 'getSubjects']);
    Route::get('edu/courses/get-zoom-meeting-link', [CourseController::class, 'getZoomMeetingLink']);
    Route::get('edu/courses/{id}/copy', [CourseController::class, 'copy']);
    Route::get('edu/courses/export', [CourseController::class, 'export']);
    // Assignmnment Student to class
    Route::get('edu/courses/assign-student-to-class', [CourseController::class, 'assignStudentToClass']);
    Route::post('edu/courses/done-assign-student-to-class', [CourseController::class, 'doneAssignStudentToClass']);

    // Calendar
    Route::get('edu/schedule-items/edit-event-in-calendar', [CalendarController::class, 'editEventInCalendar']);
    Route::get('edu/courses/add-event-in-calendar', [CalendarController::class, 'addEventInCalendar']);
    Route::post('edu/courses/upate-event-in-calendar', [CalendarController::class, 'updateEventInCalendar']);
    Route::post('edu/schedule-items/create-event-in-calendar', [CalendarController::class, 'createEventInCalendar']);
    Route::post('edu/courses/calendar', [CalendarController::class, 'getCalendar']);
    Route::post('edu/courses/sections-list', [CalendarController::class, 'getSectionsList']);
    Route::post('edu/courses/dashboard-calendar', [CalendarController::class, 'getDashboardCalendar']);

    // Report Section
    Route::get('edu/courses/{id}/reportSection', [SectionReportsController::class, 'reportSection']);
    Route::get('edu/courses/getStudents', [SectionReportsController::class, 'getStudents']);
    Route::get('edu/courses/getSectionReportData', [SectionReportsController::class, 'getSectionReportData']);
    Route::post('edu/courses/{id}/create/', [SectionReportsController::class, 'saveReportSectionInCourse']);
    Route::delete('edu/courses/destroy/{section_id}/{contact_id}', [SectionReportsController::class, 'destroy']);
    Route::get('edu/sections/{id}/create/{contact_id}', [SectionReportsController::class, 'create']);
    Route::post('edu/sections/{id}/create/{contact_id}', [SectionReportsController::class, 'saveReportSection']);
    Route::get('edu/report_sections/{id}/edit/{contact_id}', [SectionReportsController::class, 'edit']);
    Route::post('edu/report_sections/{id}/reportSection/{contact_id}', [SectionReportsController::class, 'updateReportSection']);
    Route::get('edu/report_sections/{id}/report-section-popup/{course_id}', [SectionReportsController::class, 'reportSectionPopup']);
    Route::get('edu/report_sections/{id}/report-section-popup/{course_id}/create', [SectionReportsController::class, 'createReportSectionPopup']);
    Route::post('edu/courses/{id}/reportSection/{contact_id}', [SectionReportsController::class, 'saveReportSectionPopup']);

    // Staffs
    Route::get('edu/staffs', [StaffController::class, 'index']);
    Route::get('edu/staffs/list', [StaffController::class, 'list']);
    Route::delete('edu/staffs', [StaffController::class, 'delete']);
    Route::delete('edu/staffs/delete-all', [StaffController::class, 'deleteAll']);
    Route::get('edu/staffs/create', [StaffController::class, 'create']);
    Route::post('edu/staffs/store', [StaffController::class, 'store']);
    Route::get('edu/staffs/{id}/show', [StaffController::class, 'show']);
    Route::get('edu/staffs/{id}/busy-schedule', [StaffController::class, 'busySchedule']);
    Route::get('edu/staffs/{id}/show-schedule', [StaffController::class, 'showSchedule']);
    Route::get('edu/staffs/{id}/edit-busy-schedule', [StaffController::class, 'editBusySchedule']);
    Route::put('edu/staffs/{id}/update-busy-schedule', [StaffController::class, 'updateBusySchedule']);
    Route::delete('edu/staffs/{id}/delete-busy-schedule', [StaffController::class, 'deleteFreeTime']);
    Route::get('edu/staffs/{id}/show-free-time-schedule', [StaffController::class, 'showFreeTimeSchedule']);
    Route::put('edu/staffs/{id}/save-busy-schedule', [StaffController::class, 'saveBusySchedule']);
    Route::get('edu/staffs/{id}/class', [StaffController::class, 'class']);
    Route::get('edu/staffs/{id}/classList', [StaffController::class, 'classList']);
    Route::get('edu/staffs/{id}/calendar', [StaffController::class, 'calendar']);
    Route::get('edu/staffs/{id}/teachingSchedule', [StaffController::class, 'teachingSchedule']);
    Route::get('edu/staffs/{id}/teachingScheduleList', [StaffController::class, 'teachingScheduleList']);
    Route::get('edu/staffs/{id}/salarySheet', [StaffController::class, 'salarySheet']);
    Route::get('edu/staffs/{id}/salarySheetList', [StaffController::class, 'salarySheetList']);
    Route::get('edu/staffs/{id}/expenseHistory', [StaffController::class, 'expenseHistory']);
    Route::get('edu/teachers/get-home-room-by-area/{area}', [StaffController::class, 'getHomeRoomByArea']);
    Route::get('edu/teachers/export', [StaffController::class, 'export']);

    // Class Assignment
    Route::get('edu/class/assignments', [ClassAssignmentsController::class, 'index']);
    Route::get('edu/class/assignments/list', [ClassAssignmentsController::class, 'list']);
    Route::get('edu/class/assignments/assign-to-class', [ClassAssignmentsController::class, 'assignToClass']);

    // Students
    Route::get('edu/students/note-logs-popup/{id}', [StudentController::class, 'noteLogsPopup']);
    Route::get('edu/students/show-free-time-schedule/{id}', [StudentController::class, 'showFreeTimeSchedule']);
    Route::post('edu/students/{id}/save', [StudentController::class, 'save']);
    Route::get('edu/students/select2', [StudentController::class, 'select2']);
    Route::get('edu/students/{id}/update-history', [StudentController::class, 'updateHistory']);
    Route::get('edu/students/{id}/note-logs', [StudentController::class, 'noteLog']);
    Route::get('edu/students/note-logs-list/{id}', [StudentController::class, 'noteLogList']);
    Route::get('edu/students/{id}/show', [StudentController::class, 'show']);
    Route::get('edu/students/{id}/class', [StudentController::class, 'class']);
    Route::get('edu/students/{id}/classList', [StudentController::class, 'classList']);
    Route::get('edu/students/{id}/section', [StudentController::class, 'section']);
    Route::get('edu/students/{id}/sectionList', [StudentController::class, 'sectionList']);
    Route::get('edu/students/{id}/schedule', [StudentController::class, 'schedule']);
    Route::get('edu/students/{id}/refund', [StudentController::class, 'refund']);
    Route::get('edu/students/{id}/refundList', [StudentController::class, 'refundList']);
    Route::get('edu/students/{id}/reserve/student/detail', [StudentController::class, 'reserveStudentDetail']);
    Route::get('edu/students/{id}/reserveList', [StudentController::class, 'reserveList']);
    Route::get('edu/students/{id}/transfer/student/detail', [StudentController::class, 'transferStudentDetail']);
    Route::get('edu/students/{id}/transferList', [StudentController::class, 'transferList']);
    Route::get('edu/students/{id}/calendar', [StudentController::class, 'calendar']);
    Route::get('edu/students/{id}/contract', [StudentController::class, 'contract']);
    Route::get('edu/students/{id}/contract-list', [StudentController::class, 'contractList']);
    Route::get('edu/students/{id}/extra-activity', [StudentController::class, 'extraActivity']);
    Route::get('edu/students/{id}/kid-tech', [StudentController::class, 'kidTech']);
    Route::get('edu/students/{id}/edit', [StudentController::class, 'edit']);
    Route::put('edu/students/{id}', [StudentController::class, 'update']);
    Route::delete('edu/students/{id}', [StudentController::class, 'destroy']);
    Route::post('edu/students', [StudentController::class, 'store']);
    Route::get('edu/students/create', [StudentController::class, 'create']);
    Route::get('edu/students/list', [StudentController::class, 'list']);
    Route::get('edu/students', [StudentController::class, 'index']);
    Route::get('edu/students/{id}/request-contact', [StudentController::class, 'requestContact']);
    Route::get('edu/students/{id}/request-contact-list', [StudentController::class, 'requestContactList']);
    Route::get('edu/students/assign-to-class', [StudentController::class, 'assignToClass']);
    Route::get('edu/students/order-form', [StudentController::class, 'orderForm']);
    Route::get('edu/students/order-item-form', [StudentController::class, 'orderItemForm']);
    Route::get('edu/students/edu-items-form', [StudentController::class, 'eduItemsForm']);
    Route::get('edu/students/course-form', [StudentController::class, 'courseForm']);
    Route::post('edu/students/done-assign-to-class', [StudentController::class, 'doneAssignToClass']);
    Route::get('edu/students/study-partner', [StudentController::class, 'studyPartner']);
    Route::get('edu/students/section-form', [StudentController::class, 'sectionForm']);
    Route::get('edu/students/course-student-form', [StudentController::class, 'courseStudentForm']);
    Route::get('edu/students/course-partner', [StudentController::class, 'coursePartner']);
    Route::get('edu/students/section-student', [StudentController::class, 'sectionStudent']);
    Route::post('edu/students/done-study-partner', [StudentController::class, 'doneStudyPartner']);
    Route::get('edu/students/transfer-class', [StudentController::class, 'transferClass']);
    Route::get('edu/students/course-transfer-student-form', [StudentController::class, 'courseTransferStudentForm']);
    Route::get('edu/students/course-transfer-form', [StudentController::class, 'courseTransfer']);
    Route::post('edu/students/done-transfer-class', [StudentController::class, 'doneTransferClass']);
    Route::get('edu/students/reserve', [StudentController::class, 'reserve']);
    Route::get('edu/students/order-item-reserve-form', [StudentController::class, 'orderItemReserveForm']);
    Route::get('edu/students/course-reserve-form', [StudentController::class, 'courseReserveForm']);
    Route::post('edu/students/done-reserve', [StudentController::class, 'doneReserve']);
    Route::get('edu/students/refund-request', [StudentController::class, 'refundRequest']);
    Route::get('edu/students/course-refund-request-form', [StudentController::class, 'courseRefundRequestForm']);
    Route::get('edu/students/order-item-refund-request-form', [StudentController::class, 'orderItemRefundRequestForm']);
    Route::post('edu/students/done-refund-request', [StudentController::class, 'doneRefundRequest']);
    Route::get('edu/students/assign-to-class-request-demo', [StudentController::class, 'assignToClassRequestDemo']);
    Route::get('edu/students/order-form-request-demo', [StudentController::class, 'orderFormRequestDemo']);
    Route::get('edu/students/order-item-form-request-demo', [StudentController::class, 'orderItemFormRequestDemo']);
    Route::get('edu/students/course-form-request-demo', [StudentController::class, 'courseFormRequestDemo']);
    Route::get('edu/students/section-form-request-demo', [StudentController::class, 'sectionFormRequestDemo']);
    Route::post('edu/students/done-assign-to-class-request-demo', [StudentController::class, 'doneAssignToClassRequestDemo']);
    Route::get('edu/students/show-freetime-schedule/{id}', [StudentController::class, 'showFreeTimeScheduleOfStudent']);
    Route::get('edu/students/{id}/create-freetime-schedule', [StudentController::class, 'createFreetimeSchedule']);
    Route::post('edu/students/{id}/save-freetime-schedule', [StudentController::class, 'saveFreetimeSchedule']);
    Route::get('edu/students/{id}/edit-freetime-schedule', [StudentController::class, 'editFreetimeSchedule']);
    Route::put('edu/students/{id}/update-freetime-schedule', [StudentController::class, 'updateFreetimeSchedule']);
    Route::delete('edu/students/{id}/delete-busy-schedule', [StudentController::class, 'deleteFreeTime']);
    // transfer
    Route::get('edu/students/transfer', [StudentController::class, 'transfer']);
    Route::post('edu/students/transfer/save-transfer', [StudentController::class, 'transferSave']);
    Route::get('edu/students/transfer/order-item/select', [StudentController::class, 'transferOrderItemSelect']);
    Route::get('edu/students/transfer/form-detail', [StudentController::class, 'transferFormDetail']);
    // exit class
    Route::get('edu/students/exit-class', [StudentController::class, 'exitClass']);
    Route::post('edu/students/done-exit-class', [StudentController::class, 'doneExitClass']);

    // Sections
    Route::get('edu/sections/calendar/content', [SectionController::class, 'eduCalendarContent']);
    Route::get('edu/sections/calendar', [SectionController::class, 'calendar']);
    Route::get('edu/sections/index', [SectionController::class, 'index']);
    Route::get('edu/sections/list', [SectionController::class, 'list']);
    Route::delete('edu/sections/destroy', [SectionController::class, 'destroy']);
    Route::delete('edu/sections/delete-all', [SectionController::class, 'deleteAll']);
    Route::post('edu/sections/{id}/saveAttendancePopup', [SectionController::class, 'saveAttendancePopup']);
    Route::get('edu/sections/{id}/changeTeacherPopup', [SectionController::class, 'changeTeacherPopup']);
    Route::put('edu/sections/{id}/changeTeacherPopup', [SectionController::class, 'saveChangeTeacherPopup']);
    Route::get('edu/sections/{id}/shiftPopup', [SectionController::class, 'shiftPopup']);
    Route::post('edu/sections/{id}/saveShift', [SectionController::class, 'saveShift']);
    Route::get('edu/sections/{id}/show-zoom-start-links', [SectionController::class, 'showZoomStartLinks']);
    Route::get('edu/sections/{id}/show-zoom-join-links', [SectionController::class, 'showZoomJoinLinks']);
    Route::get('edu/sections/{id}/update-zoom-links-popup', [SectionController::class, 'updateZoomLinksPopup']);
    Route::get('edu/sections/{id}/create-zoom-links-for-offline-section-popup', [SectionController::class, 'createZoomLinksForOfflineSectionPopup']);
    Route::post('edu/sections/{id}/update-zoom-links', [SectionController::class, 'updateZoomLinks']);
    Route::post('edu/sections/{id}/create-zoom-links-for-offline-section', [SectionController::class, 'createZoomLinksForOfflineSection']);

    // Reserve
    Route::get('edu/reserve/index', [ReserveController::class, 'index']);
    Route::get('edu/reserve/list', [ReserveController::class, 'list']);
    Route::get('edu/reserve/reserve-student', [ReserveController::class, 'reserveStudent']);
    Route::get('edu/reserve/reserve-extend', [ReserveController::class, 'reserveExtend']);
    Route::post('edu/reserve/done-reserve-extend', [ReserveController::class, 'doneReserveExtend']);
    Route::get('edu/reserve/reserve-cancelled', [ReserveController::class, 'reserveCancelled']);
    Route::post('edu/reserve/done-reserve-cancelled', [ReserveController::class, 'doneReserveCancelled']);

    // Report Teacher
    Route::get('edu/teacher_hour_report', [TeacherHourReportController::class, 'index']);
    Route::get('edu/teacher_hour_report/list', [TeacherHourReportController::class, 'list']);
    Route::get('edu/teacher_hour_report/{id}/list-details-teacher', [TeacherHourReportController::class, 'listDetailTeacher']);
    
    //Report Student
    Route::get('edu/student_hour_report', [StudentHourReportController::class, 'index']);
    Route::get('edu/student_hour_report/list', [StudentHourReportController::class, 'list']);
    Route::get('edu/student_hour_report/{id}/list-details-student', [StudentHourReportController::class, 'listDetailStudent']);
    Route::get('edu/student_hour_report/export', [StudentHourReportController::class, 'export']);


    //Student Section
    Route::get('edu/student_section_report', [StudentSectionReportController::class, 'index']);
    Route::get('edu/student_section_report/list', [StudentSectionReportController::class, 'list']);
    Route::get('edu/student-section-report/export', [StudentSectionReportController::class, 'export']);


    //  Dashboard
    Route::get('edu/dashboard/', [DashboardController::class, 'index']);
    Route::get('edu/dashboard/{interval}', [DashboardController::class, 'updateInterval']);

    //Refund_request
    Route::get('edu/refund_requests', [RefundRequestController::class, 'index']);
    Route::get('edu/refund_requests/list', [RefundRequestController::class, 'list']);
    Route::get('edu/refund_requests/{id}/showRequest', [RefundRequestController::class, 'showRequest']);

    //Excel Student
    // Route::post('student/exportRun', [StudentController::class, 'exportRun']);
    // Route::get('student/exportDownload', [StudentController::class, 'exportDownload']);
    Route::get('student/export', [StudentController::class, 'export']);

});

