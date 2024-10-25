<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\HubSpotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\AccountKpiNoteController;
use App\Http\Controllers\KpiTargetController;
use App\Http\Controllers\BranchController;

use Illuminate\Support\Facades\Session;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// public
Route::get('/under-construction', [Controller::class, 'underConstruction']);

// hk
require __DIR__ . '/hk.php';


Route::get('/notification/check', [NotificationController::class, 'check']);
Route::get('/notification/set-pushed', [NotificationController::class, 'setPushed']);

Route::middleware('auth')->group(function () {
    // Notidication
    Route::get('/notification/top-bar', [NotificationController::class, 'topBar']);
    Route::post('/notification/unread-all', [NotificationController::class, 'unreadAll']);
    // Route::get('/notification/set-pushed', [NotificationController::class, 'setPushed']);
    // Route::get('/notification/check', [NotificationController::class, 'check']);

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword']);
    Route::get('/profile/notification', [ProfileController::class, 'notification']);
});

Route::middleware('auth', 'check.password.change')->group(function () {
    // public home modules
    Route::get('/', function () {
        return view('modules');
    })->name('root');

    Route::get('/user-type  ', function () {
        return view('users');
    });

    // profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/activities', [ProfileController::class, 'activities']);
    
    //Account
    Route::get('accounts/delete-accounts', [AccountController::class, 'deleteAccounts']);
    Route::delete('accounts/action-delete-accounts', [AccountController::class, 'actionDeleteAccounts']);
    Route::get('accounts/{id}/edit', [AccountController::class, 'edit']);
    Route::put('accounts/{id}', [AccountController::class, 'update']);
    Route::delete('accounts/{id}', [AccountController::class, 'destroy']);
    Route::post('accounts', [AccountController::class, 'store']);
    Route::get('accounts/create', [AccountController::class, 'create']);
    Route::get('accounts/list', [AccountController::class, 'list']);
    Route::get('accounts', [AccountController::class, 'index']);
    Route::get('accounts/select2', [AccountController::class, 'select2']);
    Route::get('accounts/{id}/get-sale-sup-by-sale', [AccountController::class, 'getSaleSupBySale']);

    //HubSportsa
    Route::get('/hubspot', [HubSpotController::class, 'index']);
    Route::get('/hubspot/percentage', [HubSpotController::class, 'percentage']);
    Route::get('/hubspot/preview', [HubSpotController::class, 'preview']);
    Route::post('/hubspot/import', [HubSpotController::class, 'import']);
    Route::post('/hubspot/progress-handler', [HubSpotController::class, 'progressHandler']);
    Route::match(['post', 'get'], 'hubspot/import-hubspot-running', [HubSpotController::class, 'importHubSpotRunning']);

    //User
    Route::get('users/login-back', [UserController::class, 'loginBack']);
    Route::get('users/log-out-redirect', [UserController::class, 'logoutAndRedirect']);
    Route::post('users/list-columns/save', [UserController::class, 'saveListColumns']);
    // Route::get('users/delete-users', [UserController::class, 'deleteUsers']);
    // Route::delete('users/action-delete-users', [UserController::class, 'actionDeleteUsers']);
    // Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    // Route::put('/users/{id}', [UserController::class, 'update']);
    // Route::delete('/users/{id}', [UserController::class, 'destroy']);
    // Route::post('/users', [UserController::class, 'store']);
    // Route::get('/users/create', [UserController::class, 'create']);
    // Route::get('users/list', [UserController::class, 'list']);
    // Route::get('/users', [UserController::class, 'index']);

    Route::post('/update-profile-picture/{id}', [UserController::class, 'updateAvatar']);
    //Role
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/list', [RoleController::class, 'list']);
    Route::get('/roles/create', [RoleController::class, 'create']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    Route::get('/roles/{id}', [RoleController::class, 'edit']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);

    // Relationship
    Route::post('relationships/{contact_id}/{to_contact_id}/save', [RelationshipController::class, 'save']);
    Route::get('relationships/{contact_id}/{to_contact_id}/box', [RelationshipController::class, 'box']);

    // AccountKpiNote
    Route::get('/account-kpi-note', [AccountKpiNoteController::class, 'index']);
    Route::get('/account-kpi-note/list', [AccountKpiNoteController::class, 'list']);
    Route::get('/account-kpi-note/create/{id?}', [AccountKpiNoteController::class, 'create']);
    Route::post('/account-kpi-note', [AccountKpiNoteController::class, 'store']);
    Route::get('/account-kpi-note/{id}/edit', [AccountKpiNoteController::class, 'edit']);
    Route::put('/account-kpi-note/{id}', [AccountKpiNoteController::class, 'update']);
    Route::delete('/account-kpi-note/{id}', [AccountKpiNoteController::class, 'destroy']);
    Route::delete('/account-kpi-note', [AccountKpiNoteController::class, 'destroyAll']);

    // KpiTarget
    Route::get('/kpi-target', [KpiTargetController::class, 'index']);
    Route::get('/kpi-target/list', [KpiTargetController::class, 'list']);
    Route::get('/kpi-target/create', [KpiTargetController::class, 'create']);
    Route::post('/kpi-target', [KpiTargetController::class, 'store']);
    Route::get('/kpi-target/{id}/edit', [KpiTargetController::class, 'edit']);
    Route::post('/kpi-target/{id}/update', [KpiTargetController::class, 'update']);
    Route::post('/kpi-target/{id}/delete', [KpiTargetController::class, 'delete']);
    Route::post('/kpi-target/delete-all', [KpiTargetController::class, 'deleteAll']);
    Route::get('/kpi-target/import/download-template', [KpiTargetController::class, 'importDownloadTemplate']);
    Route::match(['get', 'post'], '/kpi-target/import/upload', [KpiTargetController::class, 'importUpload']);
    Route::get('/kpi-target/import/preview/{path}', [KpiTargetController::class, 'importPreview']);
    Route::post('/kpi-target/import/run/{path}', [KpiTargetController::class, 'importRun']);

    //AccountGroup
    Route::get('/account-group', [AccountGroupController::class, 'index']);
    Route::get('/account-group/list', [AccountGroupController::class, 'list']);
    Route::get('/account-group/{id}/edit', [AccountGroupController::class, 'edit']);
    Route::put('/account-group/{id}', [AccountGroupController::class, 'update']);
    Route::delete('/account-group/{id}', [AccountGroupController::class, 'destroy']);
    Route::post('/account-group', [AccountGroupController::class, 'store']);
    Route::get('/account-group/create', [AccountGroupController::class, 'create']);
    Route::get('/account-group/select2', [AccountGroupController::class, 'select2']);
    Route::get('/account-group/delete-account-group', [AccountGroupController::class, 'deleteAccountGroups']);
    Route::delete('/account-group/action-delete-account-group', [AccountGroupController::class, 'actionDeleteAccountGroups']);

    // Contact
    Route::match(['get', 'post'], 'contact/{id}/account', [\App\Http\Controllers\ContactController::class, 'account']);
    Route::get('contact/json', [\App\Http\Controllers\ContactController::class, 'json']);

    // Teacher
    Route::match(['get', 'post'], 'teacher/{id}/account', [\App\Http\Controllers\TeacherController::class, 'account']);

    // Branch
    Route::post('/branch/set-branch', [BranchController::class, 'setBranch']);
});

Route::get('/city/list', function () {
    $cities = config('cities');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('setLocale');