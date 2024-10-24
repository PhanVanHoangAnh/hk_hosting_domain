<?php

use App\Http\Controllers\Teacher\AuthController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\AccountController;
use App\Http\Controllers\Teacher\ProfileController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\SectionReportsController;
use App\Http\Controllers\Teacher\StudentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Teacher\PasswordController;
use App\Http\Controllers\Teacher\SectionController;
use App\Http\Controllers\Teacher\TeacherController;

Route::get('teacher/account/create-teacher', [AccountController::class, 'createNewTeacher'])
  ->name('register.create.teacher');

Route::middleware('guest')->group(function () {
    Route::get('teacher/login', [AuthController::class, 'login'])->name('teacher.login');
    Route::post('teacher/login/save', [AuthController::class, 'loginSave'])->name('teacher.login.save');
});

Route::middleware('auth')->group(function () {
  Route::get('teacher/account/setup-teacher', [AccountController::class, 'setupTeacher']);
  Route::post('teacher/account/setup-teacher-save', [AccountController::class, 'setupTeacherSave']);
  Route::post('teacher/logout', [AccountController::class, 'logout'])
    ->name('teacher.logout');
});

    Route::post('teacher/courses/calendar', [CalendarController::class, 'getCalendar']);
    Route::post('teacher/courses/sections-list', [CalendarController::class, 'getSectionsList']);
    Route::post('teacher/courses/dashboard-calendar', [CalendarController::class, 'getDashboardCalendar']);


Route::middleware('teacher.auth', 'user_has_teacher')->group(function () {
    Route::get('teacher/profile/update-password', [ProfileController::class, 'updatePassword']);

    // Password
   Route::put('teacher/password', [PasswordController::class, 'update'])->name('teacher.password.update');
});

Route::middleware('teacher.auth', 'user_has_teacher', 'check.password.change.teacher')->group(function () {
    //  Dashboard
    Route::get('teacher', [DashboardController::class, 'index'])->name('teacher.index');

     // profile
     Route::get('teacher/profile', [ProfileController::class, 'edit'])->name('teacher.profile.edit');
     Route::patch('teacher/profile', [ProfileController::class, 'update'])->name('teacher.profile.update');
     Route::delete('teacher/profile', [ProfileController::class, 'destroy'])->name('teacher.profile.destroy');
     Route::get('teacher/profile/freetimes', [ProfileController::class, 'freetimes']);
     Route::get('teacher/profile/create-freetimes', [ProfileController::class, 'createFreetime']);
     Route::put('teacher/profile/{id}/save-busy-schedule', [ProfileController::class, 'saveBusySchedule']);
     
     // Sections
    Route::get('teacher/sections/calendar/content', [SectionController::class, 'eduCalendarContent']);
    Route::get('teacher/sections/calendar', [SectionController::class, 'calendar']);
    Route::get('teacher/sections/index', [SectionController::class, 'index']);
    Route::get('teacher/sections/list', [SectionController::class, 'list']);
    Route::delete('teacher/sections/destroy', [SectionController::class, 'destroy']);
    Route::delete('teacher/sections/delete-all', [SectionController::class, 'deleteAll']);
    Route::post('teacher/sections/{id}/saveAttendancePopup', [SectionController::class, 'saveAttendancePopup']);
    Route::get('teacher/sections/{id}/changeTeacherPopup', [SectionController::class, 'changeTeacherPopup']);
    Route::put('teacher/sections/{id}/changeTeacherPopup', [SectionController::class, 'saveChangeTeacherPopup']);
    Route::get('teacher/sections/{id}/shiftPopup', [SectionController::class, 'shiftPopup']);
    Route::post('teacher/sections/{id}/saveShift', [SectionController::class, 'saveShift']);
    Route::get('teacher/sections/{id}/request-absent', [SectionController::class, 'requestAbsent']);
    Route::post('teacher/sections/{id}/save-request-absent', [SectionController::class, 'saveRequestAbsent']);

    // Teachers
    Route::get('teacher/calendar/note-logs-popup/{id}', [TeacherController::class, 'noteLogsPopup']);
    Route::get('teacher/calendar/show-free-time-schedule/{id}', [TeacherController::class, 'showFreeTimeSchedule']);
    Route::post('teacher/calendar/{id}/save', [TeacherController::class, 'save']);
    Route::get('teacher/calendar/select2', [TeacherController::class, 'select2']);
    Route::get('teacher/calendar/{id}/update-history', [TeacherController::class, 'updateHistory']);
    Route::get('teacher/calendar/{id}/note-logs', [TeacherController::class, 'noteLog']);
    Route::get('teacher/calendar/note-logs-list/{id}', [TeacherController::class, 'noteLogList']);
    Route::get('teacher/calendar/{id}/show', [TeacherController::class, 'show']);
    Route::get('teacher/calendar/{id}/class', [TeacherController::class, 'class']);
    Route::get('teacher/calendar/{id}/classList', [TeacherController::class, 'classList']);
    Route::get('teacher/calendar/{id}/section', [TeacherController::class, 'section']);
    Route::get('teacher/calendar/{id}/sectionList', [TeacherController::class, 'sectionList']);
    Route::get('teacher/calendar/{id}/schedule', [TeacherController::class, 'schedule']);
    Route::get('teacher/calendar/{id}/refund', [TeacherController::class, 'refund']);
    Route::get('teacher/calendar/{id}/refundList', [TeacherController::class, 'refundList']);
    Route::get('teacher/calendar/{id}/reserve/student/detail', [TeacherController::class, 'reserveStudentDetail']);
    Route::get('teacher/calendar/{id}/reserveList', [TeacherController::class, 'reserveList']);
    Route::get('teacher/calendar/{id}/transfer/student/detail', [TeacherController::class, 'transferStudentDetail']);
    Route::get('teacher/calendar/{id}/transferList', [TeacherController::class, 'transferList']);
    Route::get('teacher/calendar/{id}/calendar', [TeacherController::class, 'calendar']);
    Route::get('teacher/calendar/{id}/contract', [TeacherController::class, 'contract']);
    Route::get('teacher/calendar/{id}/contract-list', [TeacherController::class, 'contractList']);
    Route::get('teacher/calendar/{id}/extra-activity', [TeacherController::class, 'extraActivity']);
    Route::get('teacher/calendar/{id}/kid-tech', [TeacherController::class, 'kidTech']);
    Route::get('teacher/calendar/{id}/edit', [TeacherController::class, 'edit']);
    Route::put('teacher/calendar/{id}', [TeacherController::class, 'update']);
    Route::delete('teacher/calendar/{id}', [TeacherController::class, 'destroy']);
    Route::post('teacher/calendar', [TeacherController::class, 'store']);
    Route::get('teacher/calendar/create', [TeacherController::class, 'create']);
    Route::get('teacher/calendar/list', [TeacherController::class, 'list']);
    Route::get('teacher/calendar', [TeacherController::class, 'index']);
    Route::get('teacher/calendar/{id}/request-contact', [TeacherController::class, 'requestContact']);
    Route::get('teacher/calendar/{id}/request-contact-list', [TeacherController::class, 'requestContactList']);
    Route::get('teacher/calendar/assign-to-class', [TeacherController::class, 'assignToClass']);
    Route::get('teacher/calendar/order-form', [TeacherController::class, 'orderForm']);
    Route::get('teacher/calendar/order-item-form', [TeacherController::class, 'orderItemForm']);
    Route::get('teacher/calendar/course-form', [TeacherController::class, 'courseForm']);
    Route::post('teacher/calendar/done-assign-to-class', [TeacherController::class, 'doneAssignToClass']);
    Route::get('teacher/calendar/study-partner', [TeacherController::class, 'studyPartner']);
    Route::get('teacher/calendar/section-form', [TeacherController::class, 'sectionForm']);
    Route::get('teacher/calendar/course-student-form', [TeacherController::class, 'courseStudentForm']);
    Route::get('teacher/calendar/course-partner', [TeacherController::class, 'coursePartner']);
    Route::get('teacher/calendar/section-student', [TeacherController::class, 'sectionStudent']);
    Route::post('teacher/calendar/done-study-partner', [TeacherController::class, 'doneStudyPartner']);
    Route::get('teacher/calendar/transfer-class', [TeacherController::class, 'transferClass']);
    Route::get('teacher/calendar/course-transfer-student-form', [TeacherController::class, 'courseTransferStudentForm']);
    Route::get('teacher/calendar/course-transfer-form', [TeacherController::class, 'courseTransfer']);
    Route::post('teacher/calendar/done-transfer-class', [TeacherController::class, 'doneTransferClass']);
    Route::get('teacher/calendar/reserve', [TeacherController::class, 'reserve']);
    Route::get('teacher/calendar/order-item-reserve-form', [TeacherController::class, 'orderItemReserveForm']);
    Route::get('teacher/calendar/course-reserve-form', [TeacherController::class, 'courseReserveForm']);
    Route::post('teacher/calendar/done-reserve', [TeacherController::class, 'doneReserve']);
    Route::get('teacher/calendar/refund-request', [TeacherController::class, 'refundRequest']);
    Route::get('teacher/calendar/course-refund-request-form', [TeacherController::class, 'courseRefundRequestForm']);
    Route::get('teacher/calendar/order-item-refund-request-form', [TeacherController::class, 'orderItemRefundRequestForm']);
    Route::post('teacher/calendar/done-refund-request', [TeacherController::class, 'doneRefundRequest']);
    Route::get('teacher/calendar/assign-to-class-request-demo', [TeacherController::class, 'assignToClassRequestDemo']);
    Route::get('teacher/calendar/order-form-request-demo', [TeacherController::class, 'orderFormRequestDemo']);
    Route::get('teacher/calendar/order-item-form-request-demo', [TeacherController::class, 'orderItemFormRequestDemo']);
    Route::get('teacher/calendar/course-form-request-demo', [TeacherController::class, 'courseFormRequestDemo']);
    Route::get('teacher/calendar/section-form-request-demo', [TeacherController::class, 'sectionFormRequestDemo']);
    Route::post('teacher/calendar/done-assign-to-class-request-demo', [TeacherController::class, 'doneAssignToClassRequestDemo']);

    // transfer
    Route::get('teacher/calendar/transfer', [TeacherController::class, 'transfer']);
    Route::post('teacher/calendar/transfer/save-transfer', [TeacherController::class, 'transferSave']);
    Route::get('teacher/calendar/transfer/order-item/select', [TeacherController::class, 'transferOrderItemSelect']);
    Route::get('teacher/calendar/transfer/form-detail', [TeacherController::class, 'transferFormDetail']);

    // exit class
    Route::get('teacher/calendar/exit-class', [TeacherController::class, 'exitClass']);
    Route::post('teacher/calendar/done-exit-class', [TeacherController::class, 'doneExitClass']);

    //Report Section
    Route::get('teacher/courses/{id}/reportSection', [SectionReportsController::class, 'reportSection']);
    Route::get('teacher/courses/getStudents', [SectionReportsController::class, 'getStudents']);
    Route::get('teacher/courses/getSectionReportData', [SectionReportsController::class, 'getSectionReportData']);
    Route::post('teacher/courses/{id}/create/', [SectionReportsController::class, 'saveReportSectionInCourse']);
    Route::delete('teacher/courses/destroy/{section_id}/{contact_id}', [SectionReportsController::class, 'destroy']);
    Route::get('teacher/sections/{id}/create/{contact_id}', [SectionReportsController::class, 'create']);
    Route::post('teacher/sections/{id}/create/{contact_id}', [SectionReportsController::class, 'saveReportSection']);
    Route::get('teacher/report_sections/{id}/edit/{contact_id}', [SectionReportsController::class, 'edit']);
    Route::post('teacher/report_sections/{id}/reportSection/{contact_id}', [SectionReportsController::class, 'updateReportSection']);
    Route::get('teacher/report_sections/{id}/report-section-popup/{course_id}', [SectionReportsController::class, 'reportSectionPopup']);
    Route::get('teacher/report_sections/{id}/report-section-popup/{course_id}/create', [SectionReportsController::class, 'createReportSectionPopup']);
    Route::post('teacher/courses/{id}/reportSection/{contact_id}', [SectionReportsController::class, 'saveReportSectionPopup']);

     // Courses
    Route::get('teacher/courses/index', [CourseController::class, 'index']);
    Route::get('teacher/courses/list', [CourseController::class, 'list']);
    Route::delete('teacher/courses/delete', [CourseController::class, 'delete']);
    Route::get('teacher/courses/edit', [CourseController::class, 'edit']);
    Route::get('teacher/courses/edit-calendar', [CourseController::class, 'editCalendar']);
    Route::put('teacher/courses/update/{id}', [CourseController::class, 'update']);
    Route::put('teacher/courses/update-calendar/{id}', [CourseController::class, 'updateCalendar']);
    Route::delete('teacher/courses/delete-all', [CourseController::class, 'deleteAll']);
    Route::match(['post', 'get'], 'teacher/courses/add', [CourseController::class, 'add']);
    
    Route::match(['post', 'put'], 'teacher/courses/create', [CourseController::class, 'create']);
    Route::get('teacher/courses/add-schedule', [CourseController::class, 'addSchedule']);
    Route::get('teacher/courses/edit-schedule', [CourseController::class, 'editSchedule']);
    Route::get('teacher/courses/{id}/showDetail', [CourseController::class, 'showDetail']);

    Route::get('teacher/courses/{id}/students', [CourseController::class, 'students']);
    Route::get('teacher/courses/{id}/studentList', [CourseController::class, 'studentList']);
    Route::get('teacher/courses/{id}/schedule', [CourseController::class, 'schedule']);
    Route::get('teacher/courses/{id}/sections', [CourseController::class, 'sections']);
    Route::get('teacher/courses/{id}/sectionList', [CourseController::class, 'sectionList']);
    Route::get('teacher/courses/{id}/attendancePopup', [CourseController::class, 'attendancePopup']);
    Route::post('teacher/courses/{id}/saveAttendancePopup', [CourseController::class, 'saveAttendancePopup']);
    Route::get('teacher/courses/{id}/reschedulePopup', [CourseController::class, 'reschedulePopup']);
    Route::put('teacher/courses/{id}', [CourseController::class, 'updateSchedulePopup']);
    Route::post('teacher/schedule-items/create-schedule-item', [CourseController::class, 'createScheduleItem']);
    Route::post('teacher/schedule-items/edit-week-schedule-item', [CourseController::class, 'editWeekScheduleItem']);
    Route::get('teacher/courses/course-stopped', [CourseController::class, 'courseStopped']);
    Route::post('teacher/courses/done-course-stopped', [CourseController::class, 'doneCourseStopped']);
    Route::get('teacher/courses/suggest_teacher/', [CourseController::class, 'suggestTeacher']);
    Route::get('teacher/courses/getPayrateTeachers', [CourseController::class, 'getPayrateTeachers']);
    Route::get('teacher/courses/getSubjects', [CourseController::class, 'getSubjects']);
    Route::get('teacher/courses/get-zoom-meeting-link', [CourseController::class, 'getZoomMeetingLink']);
    Route::get('teacher/courses/{id}/copy', [CourseController::class, 'copy']);



    // Students
   
 
   // Students
   Route::get('teacher/students/note-logs-popup/{id}', [StudentController::class, 'noteLogsPopup']);
   Route::get('teacher/students/show-free-time-schedule/{id}', [StudentController::class, 'showFreeTimeSchedule']);
   Route::post('teacher/students/{id}/save', [StudentController::class, 'save']);
   Route::get('teacher/students/select2', [StudentController::class, 'select2']);
   Route::get('teacher/students/{id}/update-history', [StudentController::class, 'updateHistory']);
   Route::get('teacher/students/{id}/note-logs', [StudentController::class, 'noteLog']);
   Route::get('teacher/students/note-logs-list/{id}', [StudentController::class, 'noteLogList']);
   Route::get('teacher/students/{id}/show', [StudentController::class, 'show']);
   Route::get('teacher/students/{id}/class', [StudentController::class, 'class']);
   Route::get('teacher/students/{id}/classList', [StudentController::class, 'classList']);
   Route::get('teacher/students/{id}/section', [StudentController::class, 'section']);
   Route::get('teacher/students/{id}/sectionList', [StudentController::class, 'sectionList']);
   Route::get('teacher/students/{id}/schedule', [StudentController::class, 'schedule']);
   Route::get('teacher/students/{id}/refund', [StudentController::class, 'refund']);
   Route::get('teacher/students/{id}/refundList', [StudentController::class, 'refundList']);
   Route::get('teacher/students/{id}/reserve/student/detail', [StudentController::class, 'reserveStudentDetail']);
   Route::get('teacher/students/{id}/reserveList', [StudentController::class, 'reserveList']);
   Route::get('teacher/students/{id}/transfer/student/detail', [StudentController::class, 'transferStudentDetail']);
   Route::get('teacher/students/{id}/transferList', [StudentController::class, 'transferList']);
   Route::get('teacher/students/{id}/calendar', [StudentController::class, 'calendar']);
   Route::get('teacher/students/{id}/contract', [StudentController::class, 'contract']);
   Route::get('teacher/students/{id}/contract-list', [StudentController::class, 'contractList']);
   Route::get('teacher/students/{id}/extra-activity', [StudentController::class, 'extraActivity']);
   Route::get('teacher/students/{id}/kid-tech', [StudentController::class, 'kidTech']);
   Route::get('teacher/students/{id}/edit', [StudentController::class, 'edit']);
   Route::put('teacher/students/{id}', [StudentController::class, 'update']);
   Route::delete('teacher/students/{id}', [StudentController::class, 'destroy']);
   Route::post('teacher/students', [StudentController::class, 'store']);
   Route::get('teacher/students/create', [StudentController::class, 'create']);
   Route::get('teacher/students/list', [StudentController::class, 'list']);
   Route::get('teacher/students', [StudentController::class, 'index']);
   Route::get('teacher/students/{id}/request-contact', [StudentController::class, 'requestContact']);
   Route::get('teacher/students/{id}/request-contact-list', [StudentController::class, 'requestContactList']);
   Route::get('teacher/students/assign-to-class', [StudentController::class, 'assignToClass']);
   Route::get('teacher/students/order-form', [StudentController::class, 'orderForm']);
   Route::get('teacher/students/order-item-form', [StudentController::class, 'orderItemForm']);
   Route::get('teacher/students/edu-items-form', [StudentController::class, 'eduItemsForm']);
   Route::get('teacher/students/course-form', [StudentController::class, 'courseForm']);
   Route::post('teacher/students/done-assign-to-class', [StudentController::class, 'doneAssignToClass']);
   Route::get('teacher/students/study-partner', [StudentController::class, 'studyPartner']);
   Route::get('teacher/students/section-form', [StudentController::class, 'sectionForm']);
   Route::get('teacher/students/course-student-form', [StudentController::class, 'courseStudentForm']);
   Route::get('teacher/students/course-partner', [StudentController::class, 'coursePartner']);
   Route::get('teacher/students/section-student', [StudentController::class, 'sectionStudent']);
   Route::post('teacher/students/done-study-partner', [StudentController::class, 'doneStudyPartner']);
   Route::get('teacher/students/transfer-class', [StudentController::class, 'transferClass']);
   Route::get('teacher/students/course-transfer-student-form', [StudentController::class, 'courseTransferStudentForm']);
   Route::get('teacher/students/course-transfer-form', [StudentController::class, 'courseTransfer']);
   Route::post('teacher/students/done-transfer-class', [StudentController::class, 'doneTransferClass']);
   Route::get('teacher/students/reserve', [StudentController::class, 'reserve']);
   Route::get('teacher/students/order-item-reserve-form', [StudentController::class, 'orderItemReserveForm']);
   Route::get('teacher/students/course-reserve-form', [StudentController::class, 'courseReserveForm']);
   Route::post('teacher/students/done-reserve', [StudentController::class, 'doneReserve']);
   Route::get('teacher/students/refund-request', [StudentController::class, 'refundRequest']);
   Route::get('teacher/students/course-refund-request-form', [StudentController::class, 'courseRefundRequestForm']);
   Route::get('teacher/students/order-item-refund-request-form', [StudentController::class, 'orderItemRefundRequestForm']);
   Route::post('teacher/students/done-refund-request', [StudentController::class, 'doneRefundRequest']);
   Route::get('teacher/students/assign-to-class-request-demo', [StudentController::class, 'assignToClassRequestDemo']);
   Route::get('teacher/students/order-form-request-demo', [StudentController::class, 'orderFormRequestDemo']);
   Route::get('teacher/students/order-item-form-request-demo', [StudentController::class, 'orderItemFormRequestDemo']);
   Route::get('teacher/students/course-form-request-demo', [StudentController::class, 'courseFormRequestDemo']);
   Route::get('teacher/students/section-form-request-demo', [StudentController::class, 'sectionFormRequestDemo']);
   Route::post('teacher/students/done-assign-to-class-request-demo', [StudentController::class, 'doneAssignToClassRequestDemo']);
   Route::get('teacher/students/show-freetime-schedule/{id}', [StudentController::class, 'showFreeTimeScheduleOfStudent']);
   Route::get('teacher/students/{id}/create-freetime-schedule', [StudentController::class, 'createFreetimeSchedule']);
   Route::post('teacher/students/{id}/save-freetime-schedule', [StudentController::class, 'saveFreetimeSchedule']);
   Route::get('teacher/students/{id}/edit-freetime-schedule', [StudentController::class, 'editFreetimeSchedule']);
   Route::put('teacher/students/{id}/update-freetime-schedule', [StudentController::class, 'updateFreetimeSchedule']);
   Route::delete('teacher/students/{id}/delete-busy-schedule', [StudentController::class, 'deleteFreeTime']);
   // transfer
   Route::get('teacher/students/transfer', [StudentController::class, 'transfer']);
   Route::post('teacher/students/transfer/save-transfer', [StudentController::class, 'transferSave']);
   Route::get('teacher/students/transfer/order-item/select', [StudentController::class, 'transferOrderItemSelect']);
   Route::get('teacher/students/transfer/form-detail', [StudentController::class, 'transferFormDetail']);
   // exit class
   Route::get('teacher/students/exit-class', [StudentController::class, 'exitClass']);
   Route::post('teacher/students/done-exit-class', [StudentController::class, 'doneExitClass']);
   

    
});