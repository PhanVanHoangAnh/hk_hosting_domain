<?php

use App\Http\Controllers\Edu\ReserveController;

use App\Http\Controllers\TrainingLocationController;
use App\Http\Controllers\AbroadServiceController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaleRevenueController;
use App\Http\Controllers\ZoomMeetingController;
use App\Http\Controllers\SourceDataManagerController;

Route::middleware('auth', 'check.password.change')->group(function () {
    Route::get('training-location/get-training-location-by-branch', [TrainingLocationController::class, 'getTrainingLocationsByBranch']);
    
    // AbroadService
    Route::post('abroad-services/load-services-by-type', [AbroadServiceController::class, 'loadAbroadServiceOptionsByType']);
    Route::get('abroad-services/select2', [AbroadServiceController::class, 'select2']);
    
    // Extracurricular
    Route::get('extracurricular/select2', [ExtracurricularController::class, 'select2']);
    Route::get('extracurricular/getExtra', [ExtracurricularController::class, 'getExtra']);
    Route::post('extracurricular/save', [ExtracurricularController::class, 'save']);

    // Subject
    Route::post('subjects/get-subjects-by-type', [SubjectController::class, 'getSubjectsByType']);
    Route::post('subjects/{subjectId}/get-level-by-subject', [SubjectController::class, 'getLevelsBySubject']);
    Route::post('subjects/get-type-box-by-level', [SubjectController::class, 'getTypeBoxByLevel']);
    Route::post('subjects/get-subject-box-by-type', [SubjectController::class, 'getSubjectBoxByType']);
    Route::post('subjects/get-subject-form-by-type', [SubjectController::class, 'getSubjectsFormByType']);
    Route::post('subjects/get-levels-form-by-subject-id', [SubjectController::class, 'getLevelsFormBySubject']);

    // Teacher
    Route::post('teachers/get-teacher-select-options-by-subject-id', [TeacherController::class, 'getTeacherSelectOptionsBySubjectId']);

    // Sale revenue
    Route::post('sale-revenue/get-revenue-form', [SaleRevenueController::class, 'getRevenueForm']);
    Route::post('sale-revenue/get-distribute-list', [SaleRevenueController::class, 'getDistributeList']);

    // Zoom meeting
    Route::post('zoom-meeting/get-available-zoom-user-ids-by-sections', [ZoomMeetingController::class, 'getAvailableZoomUserIdsBySections']);
    Route::post('zoom-meeting/get-zoom-user-select-options-by-ids', [ZoomMeetingController::class, 'getZoomUserSelectOptionsByIds']);
    Route::post('helpers/get-init-source-data', [SourceDataManagerController::class, 'getInitSourceData']);
    Route::post('helpers/get-auto-load-form-by-sub-channel', [SourceDataManagerController::class, 'getAutoLoadFormBySubChannel']);
});