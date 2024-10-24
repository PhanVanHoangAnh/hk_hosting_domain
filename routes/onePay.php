<?php

use App\Http\Controllers\Student\OnePayController;


use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/ipn', [OnePayController::class, 'handleIPN']);
Route::match(['get', 'post'], '/onepay/process', [OnePayController::class, 'process']);


