<?php

use App\Http\Controllers\Hk\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hk\SoftwareRequestController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Hk\SoftwareRequestNoteController;
use App\Http\Controllers\Hk\HostingController;
use App\Http\Controllers\Hk\DomainController;
use App\Http\Controllers\Hk\MainPageController;

Route::middleware('guest')->group(function () {
    // software requests
    Route::get('hk', [SoftwareRequestController::class, 'requestForm'])->name('hk.index'); 
    Route::post('hk/software-requests/save', [SoftwareRequestController::class, 'requestFormSave'])->name('request.store');
    Route::get('hk/software-requests/list', [SoftwareRequestController::class, 'list']);
    Route::get('hk/software-requests', [SoftwareRequestController::class, 'index']);
    Route::get('hk/success', function () {
        return view('hk.software_requests.success');
    })->name('success');    

    Route::get('hk/create-user', [RegisteredUserController::class, 'create'])
    ->name('register.create');
    Route::get('hk/login', [AuthenticatedSessionController::class, 'create'])->name('contact.login'); 
    Route::post('hk/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('hk/store-registration', [RegisteredUserController::class, 'store'])
    ->name('register.store');
    //ContactsController
    // Route::get('hk/contacts/{id}/show', [ContactController::class, 'show']); 
    
    Route::get('hk/assignedIndex/assignedList', [SoftwareRequestController::class, 'assignedList']);
    Route::get('hk/assignedIndex', [SoftwareRequestController::class, 'assignedIndex']);
    Route::get('hk/assignedIndex/{id}/assignAccount', [SoftwareRequestController::class, 'assignAccount']);
    Route::get('hk/system/accounts/selectHK', [AccountController::class, 'selectHK']);
    Route::put('hk/assignedIndex/{id}/doneAssignAccount', [SoftwareRequestController::class, 'doneAssignAccount']);
    
    
    /////
    Route::get('hk/frontend/show', [ContactController::class, 'show']);
    Route::get('hk/software_requests/{id}/show', [SoftwareRequestController::class, 'show']);
    Route::post('hk/software_requests/{id}/update', [SoftwareRequestController::class, 'update']);



    // contacts
    Route::get('hk/contacts/index', [ContactController::class, 'index']); 
    Route::get('hk/contacts/list', [ContactController::class, 'list']); 
    Route::get('hk/contacts/{id}/edit', [ContactController::class, 'edit']); 
    Route::put('hk/contacts/{id}', [ContactController::class, 'update']);
    Route::delete('hk/contacts/{id}/destroy', [ContactController::class, 'destroy']);
    Route::post('hk/contacts/delete-all', [ContactController::class, 'deleteAll']); 
    Route::post('hk/contacts/{id}/save', [ContactController::class, 'save']); 
    Route::get('hk/contacts/create', [ContactController::class, 'create']);
    Route::post('hk/contacts', [ContactController::class, 'store']);
    Route::get('hk/contacts/select2', [ContactController::class, 'select2']);
    Route::get('hk/contacts/related-contacts-box', [ContactController::class, 'relatedContactsBox']);

    Route::get('hk/software-requests-notes/{id}/create', [SoftwareRequestNoteController::class, 'create']);
    Route::post('hk/software-requests-notes/create/{id}', [SoftwareRequestNoteController::class, 'store']);
    Route::delete('hk/software-requests-notes/{id}/destroy', [SoftwareRequestNoteController::class, 'destroy']);
    Route::get('hk/software-requests-notes/{id}/edit', [SoftwareRequestNoteController::class, 'edit']); 
    Route::post('hk/software-requests-notes/{id}/update', [SoftwareRequestNoteController::class, 'update']);

    // assignments
    Route::get('hk/assignedIndex/assignedList', [SoftwareRequestController::class, 'assignedList']);
    Route::get('hk/assignedIndex', [SoftwareRequestController::class, 'assignedIndex']);
    Route::get('hk/assignedIndex/{id}/detail', [SoftwareRequestController::class, 'assignedDetail']);


    Route::get('hk/assignedIndex/{id}/updateStatus', [SoftwareRequestController::class, 'updateStatus']);
    Route::put('hk/assignedIndex/{id}/doneUpdateStatus', [SoftwareRequestController::class, 'doneUpdateStatus']);
    Route::get('/select-status', [SoftwareRequestController::class, 'selectStatus']);


    // Hosting
    Route::get('hk/hosting', [HostingController::class, 'index']); 

    // Domain
    Route::get('hk/domain', [DomainController::class, 'index']); 
    Route::post('hk/search-domain', [DomainController::class, 'searchDomain']);

    //MainPage
    Route::get('hk/main', [MainPageController::class, 'index']); 
});

