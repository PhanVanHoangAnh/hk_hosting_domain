<?php

use App\Http\Controllers\Edu\ReserveController;

use App\Http\Controllers\TrainingLocationController;
use App\Http\Controllers\AbroadServiceController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\NoteLogController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'check.password.change')->group(function () {
   
    Route::get('note-log/marketting/{id}/contact-request', [NoteLogController::class, 'MarketingContactRequest']);
    Route::get('note-log/marketting/add-note-log/{id}', [NoteLogController::class, 'addNoteLogMarketingContactRequest']);
    Route::post('note-log/marketting/add-notelog/{id}', [NoteLogController::class, 'doneAddNoteLogMarketingContactRequest']);
    Route::get('note-log/marketting/{id}/edit', [NoteLogController::class, 'edit']);
    // Route::get('sales/note-logs', [NoteLogController::class, 'index']);
    // Route::get('sales/note-logs/list', [NoteLogController::class, 'list']);
    
    Route::post('note-log/{id}', [NoteLogController::class, 'update']);
    // Route::delete('sales/note-logs/{id}', [NoteLogController::class, 'destroy']);
    // Route::delete('sales/note-logs', [NoteLogController::class, 'destroyAll']);
    // Route::get('sales/note-logs/create', [NoteLogController::class, 'create']);
   
    // Route::get('sales/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'createNoteLogCustomer']);
    // Route::post('sales/note-logs/create-notelog-customer/{id}', [NoteLogController::class, 'storeNoteLogCustomer']);
    // Route::post('sales/note-logs', [NoteLogController::class, 'store']);
 
 
});