<?php

use App\Http\Controllers\System\AccountController;
use App\Http\Controllers\System\AccountGroupController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\StaffController;
use App\Http\Controllers\System\StaffGroupController;
use App\Http\Controllers\System\TeacherController;
use App\Http\Controllers\System\DemandController;
use App\Http\Controllers\System\BackupController;

Route::middleware('auth', 'system', 'check.password.change')->group(function () {
    // Staffs
    Route::get('system/staffs', [StaffController::class, 'index']);
    Route::get('system/staffs/list', [StaffController::class, 'list']);
    Route::delete('system/staffs', [StaffController::class, 'delete']);
    Route::delete('system/staffs/delete-all', [StaffController::class, 'deleteAll']);
    Route::get('system/staffs/create', [StaffController::class, 'create']);
    Route::post('system/staffs/store', [StaffController::class, 'store']);
    Route::get('system/staffs/{id}/show', [StaffController::class, 'show']);
    Route::get('system/staffs/{id}/class', [StaffController::class, 'class']);
    Route::get('system/staffs/{id}/classList', [StaffController::class, 'classList']);
    Route::get('system/staffs/{id}/calendar', [StaffController::class, 'calendar']);
    Route::get('system/staffs/{id}/teachingSchedule', [StaffController::class, 'teachingSchedule']);
    Route::get('system/staffs/{id}/teachingScheduleList', [StaffController::class, 'teachingScheduleList']);
    Route::get('system/staffs/{id}/salarySheet', [StaffController::class, 'salarySheet']);
    Route::get('system/staffs/{id}/salarySheetList', [StaffController::class, 'salarySheetList']);
    Route::get('system/staffs/{id}/expenseHistory', [StaffController::class, 'expenseHistory']);

    // Staff groups
    Route::get('system/staff-groups', [StaffGroupController::class, 'index']);
    Route::get('system/staffs-groups/list', [StaffGroupController::class, 'list']);
    Route::delete('system/staffs-groups', [StaffGroupController::class, 'destroy']);
    Route::delete('system/staffs-groups/delete-all', [StaffGroupController::class, 'deleteAll']);
    Route::get('system/staffs-groups/create', [StaffGroupController::class, 'create']);
    Route::post('system/staffs-groups/store', [StaffGroupController::class, 'store']);
    Route::post('system/staffs-groups/edit', [StaffGroupController::class, 'edit']);

    // Accounts
    Route::get('system/accounts/delete-accounts', [AccountController::class, 'deleteAccounts']);
    Route::delete('system/accounts/action-delete-system/accounts', [AccountController::class, 'actionDeleteAccounts']);
    Route::get('system/accounts/{id}/edit', [AccountController::class, 'edit']);
    Route::put('system/accounts/{id}', [AccountController::class, 'update']);
    Route::delete('system/accounts/{id}', [AccountController::class, 'destroy']);
    Route::post('system/accounts', [AccountController::class, 'store']);
    Route::get('system/accounts/create', [AccountController::class, 'create']);
    Route::get('system/accounts/list', [AccountController::class, 'list']);
    Route::get('system/accounts', [AccountController::class, 'index']);
    Route::get('system/accounts/select2', [AccountController::class, 'select2']);
    Route::get('system/account/get-manager/{id}', [AccountController::class, 'getManager']);

    //User
    // Route::get('system/users/login-back', [UserController::class, 'loginBack']);
    // Route::get('system/users/log-out-redirect', [UserController::class, 'logoutAndRedirect']);
    Route::get('system/users/{id}/login-as', [UserController::class, 'loginAs']);
    // Route::post('system/users/list-columns/save', [UserController::class, 'saveListColumns']);
    Route::get('system/users/delete-users', [UserController::class, 'deleteUsers']);
    Route::delete('system/users/action-delete-users', [UserController::class, 'actionDeleteUsers']);
    Route::get('system/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('system/users/{id}', [UserController::class, 'update']);
    Route::delete('system/users/{id}', [UserController::class, 'destroy']);
    Route::post('system/users', [UserController::class, 'store']);
    Route::get('system/users/create', [UserController::class, 'create']);
    Route::get('system/users/list', [UserController::class, 'list']);
    Route::get('system/users', [UserController::class, 'index']);
    Route::get('system/users/checkAbroadApplications/{id}', [UserController::class, 'checkAbroadApplications']);
    // Route::delete('system/users/{id}', [UserController::class, 'destroy']);
    // Route::post('system/users/{id}/out-of-job', [UserController::class, 'outOfJobUser']);
    // Route::get('system/users/{id}/out-of-job', [UserController::class, 'outOfJobUser']);

    //Role
    Route::get('system/roles', [RoleController::class, 'index']);
    Route::get('system/roles/list', [RoleController::class, 'list']);
    Route::get('system/roles/create', [RoleController::class, 'create']);
    Route::post('system/roles', [RoleController::class, 'store']);
    Route::delete('system/roles/{id}', [RoleController::class, 'destroy']);
    Route::get('system/roles/{id}', [RoleController::class, 'edit']);
    Route::put('system/roles/{id}', [RoleController::class, 'update']);

    //AccountGroup
    Route::get('system/account-group', [AccountGroupController::class, 'index']);
    Route::get('system/account-group/list', [AccountGroupController::class, 'list']);
    Route::get('system/account-group/{id}/edit', [AccountGroupController::class, 'edit']);
    Route::put('system/account-group/{id}', [AccountGroupController::class, 'update']);
    Route::delete('system/account-group/{id}', [AccountGroupController::class, 'destroy']);
    Route::post('system/account-group', [AccountGroupController::class, 'store']);
    Route::get('system/account-group/create', [AccountGroupController::class, 'create']);
    Route::get('system/account-group/select2', [AccountGroupController::class, 'select2']);
    Route::get('system/account-group/delete-account-group', [AccountGroupController::class, 'deleteAccountGroups']);
    Route::delete('system/account-group/action-delete-account-group', [AccountGroupController::class, 'actionDeleteAccountGroups']);


     // Teacher
     Route::get('system/teachers', [TeacherController::class, 'index']);
     Route::get('system/teachers/list', [TeacherController::class, 'list']);
     Route::delete('system/teachers', [TeacherController::class, 'delete']);
     Route::delete('system/teachers/delete-all', [TeacherController::class, 'deleteAll']);
     Route::get('system/teachers/create', [TeacherController::class, 'create']);
     Route::post('system/teachers/store', [TeacherController::class, 'store']);
     Route::get('system/teachers/{id}/show', [TeacherController::class, 'show']);
     Route::get('system/teachers/{id}/busy-schedule', [TeacherController::class, 'busySchedule']);
     Route::get('system/teachers/{id}/show-schedule', [TeacherController::class, 'showSchedule']);
     Route::get('system/teachers/{id}/edit-busy-schedule', [TeacherController::class, 'editBusySchedule']);
     Route::put('system/teachers/{id}/update-busy-schedule', [TeacherController::class, 'updateBusySchedule']);
     Route::delete('system/teachers/{id}/delete-busy-schedule', [TeacherController::class, 'deleteFreeTime']);
     Route::get('system/teachers/{id}/show-free-time-schedule', [TeacherController::class, 'showFreeTimeSchedule']);
     Route::put('system/teachers/{id}/save-busy-schedule', [TeacherController::class, 'saveBusySchedule']);
     Route::get('system/teachers/{id}/class', [TeacherController::class, 'class']);
     Route::get('system/teachers/{id}/classList', [TeacherController::class, 'classList']);
     Route::get('system/teachers/{id}/calendar', [TeacherController::class, 'calendar']);
     Route::get('system/teachers/{id}/teachingSchedule', [TeacherController::class, 'teachingSchedule']);
     Route::get('system/teachers/{id}/teachingScheduleList', [TeacherController::class, 'teachingScheduleList']);
     Route::get('system/teachers/{id}/salarySheet', [TeacherController::class, 'salarySheet']);
     Route::get('system/teachers/{id}/salarySheetList', [TeacherController::class, 'salarySheetList']);
     Route::get('system/teachers/{id}/expenseHistory', [TeacherController::class, 'expenseHistory']);
     Route::get('system/teachers/{id}/edit', [TeacherController::class, 'edit']);
     Route::put('system/teachers/{id}/edit', [TeacherController::class, 'update']);
     Route::delete('system/teachers/{id}/delete', [TeacherController::class, 'destroy']);

     // Backup
    Route::post('system/backup/save', [BackupController::class, 'save']);
    Route::get('system/backup', [BackupController::class, 'index']);

    // Setting
    Route::get('system/demands', [DemandController::class, 'index']);
    Route::get('system/demands-list', [DemandController::class, 'list']);
    Route::get('system/demands/create', [DemandController::class, 'create']);
    Route::post('system/demands', [DemandController::class, 'store']);
    Route::get('system/demands/{id}/edit', [DemandController::class, 'edit']);
    Route::post('system/demands/{id}/update', [DemandController::class, 'update']);
    Route::delete('system/demands/{id}/delete', [DemandController::class, 'destroy']);
    Route::post('system/demands/delete-all', [DemandController::class, 'destroyAll']);


});
Route::get('system/accounts/select2', [AccountController::class, 'select2']);
