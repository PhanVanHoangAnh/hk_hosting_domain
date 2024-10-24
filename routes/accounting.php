<?php

use App\Http\Controllers\Accounting\AccountGroupController;
use App\Http\Controllers\Accounting\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Accounting\DashboardController;
use App\Http\Controllers\Accounting\PaymentReminderController;
use App\Http\Controllers\Accounting\PayrateController;
use App\Http\Controllers\Accounting\RefundRequestController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Accounting\OrderController;
use App\Http\Controllers\Accounting\OrderItemController;
use App\Http\Controllers\Accounting\PaymentAccountController;
use App\Http\Controllers\Accounting\PaymentRecordController;
use App\Http\Controllers\Accounting\Report\DebtReportController;
use App\Http\Controllers\Accounting\Report\DemoReportController;
use App\Http\Controllers\Accounting\Report\FeeCollectionReportController;
use App\Http\Controllers\Accounting\Report\KPIReportController;
use App\Http\Controllers\Accounting\Report\RefundReportController;
use App\Http\Controllers\Accounting\Report\SalesReportController;
use App\Http\Controllers\Accounting\Report\StudentHourReportController;
use App\Http\Controllers\Accounting\Report\TeacherHourReportController;
use App\Http\Controllers\Accounting\OnePayController;

Route::middleware('auth', 'accounting', 'check.password.change')->group(function () {
    // Orders
    Route::get('accounting/orders', [OrderController::class, 'index']);
    Route::get('accounting/orders/list', [OrderController::class, 'list']);
    Route::get('accounting/orders/showConstract', [OrderController::class, 'showConstract']);
    Route::get('accounting/orders/contact', [OrderController::class, 'pickContact']);
    Route::post('accounting/orders/constract', [OrderController::class, 'createConstract']);
    Route::post('accounting/orders/save-order-item', [OrderController::class, 'saveOrderItemData']);
    Route::post('accounting/orders/save-constract', [OrderController::class, 'saveConstractData']);
    Route::get('accounting/orders/delete-constract/{orderId}', [OrderController::class, 'showFormDeleteConstract']);
    Route::delete('accounting/orders/delete', [OrderController::class, 'delete']);
    Route::delete('accounting/orders/order-item', [OrderItemController::class, 'delete']);
    Route::get('accounting/orders/create-constract/{orderId}/{actionType}', [OrderController::class, 'showFormCreateConstract']);
    Route::get('accounting/orders/create/train', [OrderController::class, 'createTrainOrder']);
    Route::get('accounting/orders/create/abroad', [OrderController::class, 'createAbroadOrder']);
    Route::post('accounting/orders/{id}/request-approval', [OrderController::class, 'requestApproval']);
    Route::post('accounting/orders/{id}/approve', [OrderController::class, 'approve']);
    Route::get('accounting/orders/{id}/approve', [OrderController::class, 'approve']);
    Route::get('accounting/orders/{id}/reject', [OrderController::class, 'reject']);
    Route::post('accounting/orders/{id}/reject', [OrderController::class, 'reject']);
    Route::get('accounting/orders/{id}/history-rejected', [OrderController::class, 'historyRejected']);
    Route::get('accounting/orders/{id}/export-order', [OrderController::class, 'exportOrder']);

    //Payment
    Route::post('accounting/payments/storeReceipt/{id}', [PaymentRecordController::class, 'storeReceipt']);
    Route::get('accounting/payments/createReceipt/{id}', [PaymentRecordController::class, 'createReceipt']);
    Route::get('accounting/payments/createReceiptContact', [PaymentRecordController::class, 'createReceiptContact']);
    Route::post('accounting/payments/storeReceiptContact/{id}', [PaymentRecordController::class, 'storeReceiptContact']);
    Route::get('accounting/payments/progress-order', [PaymentRecordController::class, 'getProgressOrder']);
    Route::post('accounting/payments/{id}/approval-payment', [PaymentRecordController::class, 'approval']);
    Route::post('accounting/payments/{id}/reject-payment', [PaymentRecordController::class, 'reject']);
    Route::get('accounting/payments', [PaymentRecordController::class, 'index']);
    Route::get('accounting/payments/list', [PaymentRecordController::class, 'list']);
    Route::delete('accounting/payments/{id}', [PaymentRecordController::class, 'destroy']);
    Route::get('accounting/payments/create', [PaymentRecordController::class, 'create']);
    Route::post('accounting/payments', [PaymentRecordController::class, 'store']);
    Route::get('accounting/payments/{id}/showPayment', [PaymentRecordController::class, 'showPayment']);
    Route::get('accounting/payments/{id}/exportPDF', [PaymentRecordController::class, 'exportPDF']);
    Route::put('accounting/payments/{id}', [PaymentRecordController::class, 'update']);
    Route::get('accounting/payments/select2', [PaymentRecordController::class, 'select2']);
    Route::get('accounting/payments/{id}/payment-list-popup/', [PaymentRecordController::class, 'paymentListPopup']);
    Route::get('accounting/payments/getOrders', [PaymentRecordController::class, 'getOrders']);
    Route::get('accounting/payments/getPaymentAccount', [PaymentRecordController::class, 'getPaymentAccount']);

    //PaymentAccount
    Route::get('accounting/payment_accounts', [PaymentAccountController::class, 'index']);
    Route::get('accounting/payment_accounts/list', [PaymentAccountController::class, 'list']);
    Route::get('accounting/payment_accounts/create', [PaymentAccountController::class, 'create']);
    Route::post('accounting/payment_accounts', [PaymentAccountController::class, 'store']);
    Route::delete('accounting/payment_accounts/{id}', [PaymentAccountController::class, 'destroy']);
    Route::get('accounting/payment_accounts/{id}/edit', [PaymentAccountController::class, 'edit']);
    Route::put('accounting/payment_accounts/{id}', [PaymentAccountController::class, 'update']);
    Route::post('accounting/payment_accounts/{id}/pause-payment-account', [PaymentAccountController::class, 'pausePaymentAccount']);
    Route::get('accounting/payment_accounts/{id}/pause-payment-account', [PaymentAccountController::class, 'pausePaymentAccount']);

    //PaymentReminder
    Route::get('accounting/payment_reminders', [PaymentReminderController::class, 'index']);
    Route::get('accounting/payment_reminders/list', [PaymentReminderController::class, 'list']);

    //Report
    Route::get('accounting/demo_report',[DemoReportController::class, 'index']);
    Route::get('accounting/demo_report/list', [DemoReportController::class,'list']);
    Route::get('accounting/demo_report/export-filter', [DemoReportController::class, 'showFilterForm']);
    Route::post('accounting/demo_report/exportRun', [DemoReportController::class, 'exportRun']);
    Route::get('accounting/demo_report/exportDownload', [DemoReportController::class, 'exportDownload']);
    Route::get('accounting/fee_collection_report', [FeeCollectionReportController::class,'index']);
    Route::get('accounting/fee_collection_report/list', [FeeCollectionReportController::class,'list']);
    Route::get('accounting/fee_collection_report/export-filter', [FeeCollectionReportController::class, 'showFilterForm']);
    Route::post('accounting/fee_collection_report/exportRun', [FeeCollectionReportController::class, 'exportRun']);
    Route::get('accounting/fee_collection_report/exportDownload', [FeeCollectionReportController::class, 'exportDownload']);
    Route::get('accounting/debt_report',[DebtReportController::class,'index']);
    Route::get('accoungting/debt_report/list',[DebtReportController::class,'list']);
    Route::get('accounting/debt_report/export-filter', [DebtReportController::class, 'showFilterForm']);
    Route::post('accounting/debt_report/exportRun', [DebtReportController::class, 'exportRun']);
    Route::get('accounting/debt_report/exportDownload', [DebtReportController::class, 'exportDownload']);
    Route::get('accounting/refund_report',[RefundReportController::class,'index']);
    Route::get('accounting/refund_report/list',[RefundReportController::class,'list']);
    Route::get('accounting/refund_report/{id}/showRequest', [RefundReportController::class, 'showRequest']);
    Route::get('accounting/refund_report/export-filter', [RefundReportController::class, 'showFilterForm']);
    Route::post('accounting/refund_report/exportRun', [RefundReportController::class, 'exportRun']);
    Route::get('accounting/refund_report/exportDownload', [RefundReportController::class, 'exportDownload']);
    Route::get('accounting/teacher_hour_report',[TeacherHourReportController::class,'index']);
    Route::get('accounting/teacher_hour_report/list',[TeacherHourReportController::class,'list']);
    Route::get('accounting/teacher_hour_report/export-filter', [TeacherHourReportController::class, 'showFilterForm']);
    Route::post('accounting/teacher_hour_report/exportRun', [TeacherHourReportController::class, 'exportRun']);
    Route::get('accounting/teacher_hour_report/exportDownload', [TeacherHourReportController::class, 'exportDownload']);
    Route::get('accounting/student_hour_report',[StudentHourReportController::class,'index']);
    Route::get('accounting/student_hour_report/list',[StudentHourReportController::class,'list']);
    Route::get('accounting/student_hour_report/{id}/list-details-student',[StudentHourReportController::class,'listDetailStudent']);
    Route::get('accounting/sales_report',[SalesReportController::class,'index']);
    Route::get('accouting/sales_report/list',[SalesReportController::class,'list']);
    Route::get('accounting/sales_report/export-filter', [SalesReportController::class, 'showFilterForm']);
    Route::post('accounting/sales_report/exportRun', [SalesReportController::class, 'exportRun']);
    Route::get('accounting/sales_report/exportDownload', [SalesReportController::class, 'exportDownload']);
    Route::get('accounting/daily-kpi-report', [KPIReportController::class, 'indexDailyKPIReport']);
    Route::get('accounting/daily-kpi-report/list', [KPIReportController::class, 'listDailyKPIReport']);
    Route::get('accounting/daily-kpi-report/export-filter', [KPIReportController::class, 'showFilterForm']);
    Route::post('accounting/daily-kpi-report/exportRun', [KPIReportController::class,'exportRun']);
    Route::get('accounting/daily-kpi-report/exportDownload', [KPIReportController::class, 'exportDownload']);
    Route::get('accounting/monthly-kpi-report', [KPIReportController::class, 'indexMonthlyKPIReport']);
    Route::get('accounting/monthly-kpi-report/list', [KPIReportController::class, 'listMonthlyKPIReport']);

    //  Dashboard
    Route::get('accounting/dashboard/', [DashboardController::class, 'index']);
    Route::get('accounting/dashboard/{interval}', [DashboardController::class, 'updateInterval']);

    //Salaries
    Route::get('accounting/payrates', [PayrateController::class, 'index']);
    Route::get('accounting/payrates/list', [PayrateController::class, 'list']);
    Route::get('accounting/payrates/{id}/edit', [PayrateController::class, 'edit']);
    Route::put('accounting/payrates/{id}', [PayrateController::class, 'update']);
    Route::delete('accounting/payrates/{id}', [PayrateController::class, 'destroy']);
    Route::post('accounting/payrates/store/', [PayrateController::class, 'store']);
    Route::get('accounting/payrates/create/', [PayrateController::class, 'create']);
    Route::get('accounting/payrates/select2', [PayrateController::class, 'select2']);
    Route::get('sales/payrates/export', [PayrateController::class, 'export']);
    Route::post('sales/payrates/exportRun', [PayrateController::class, 'exportRun']);
    Route::get('sales/payrates/exportDownload', [PayrateController::class, 'exportDownload']);

    //Refund_request
    Route::get('accounting/refund_requests',[RefundRequestController::class,'index']);
    Route::get('accounting/refund_requests/list',[RefundRequestController::class,'list']);
    Route::get('accounting/refund_requests/{id}/showRequest',[RefundRequestController::class,'showRequest']);
    Route::get('accounting/refund_requests/reject_refund_request/{id}', [RefundRequestController::class, 'rejectRefundRequest']);
    Route::post('accounting/refund_requests/{id}/reject', [RefundRequestController::class, 'reject']);
    Route::post('accounting/refund_requests/{id}/saveRefund', [RefundRequestController::class, 'saveRefund']);
    Route::post('accounting/refund_requests/{id}/cancelRequest', [RefundRequestController::class, 'cancelRequest']);
    Route::get('accounting/refund_requests/{id}/cancelRequest', [RefundRequestController::class, 'cancelRequest']);


    Route::get('accounting/account_groups',[AccountGroupController::class,'index']);
    Route::get('accounting/account_groups/list',[AccountGroupController::class,'list']);
    Route::get('accounting/account-group/{id}/edit', [AccountGroupController::class, 'edit']);
    Route::put('accounting/account-group/{id}', [AccountGroupController::class, 'update']);
    Route::delete('accounting/account-group/{id}', [AccountGroupController::class, 'destroy']);
    Route::post('accounting/account-group', [AccountGroupController::class, 'store']);
    Route::get('accounting/account-group/create', [AccountGroupController::class, 'create']);
    Route::get('accounting/account-group/select2', [AccountGroupController::class, 'select2']);
    Route::get('accounting/account-group/delete-account-group', [AccountGroupController::class, 'deleteAccountGroups']);
    Route::delete('accounting/account-group/action-delete-account-group', [AccountGroupController::class, 'actionDeleteAccountGroups']);

    //One pay
    Route::get('accounting/payments/onepay/createReceipt/{id}', [OnePayController::class, 'createReceipt']);
    Route::get('accounting/payments/onepay/showLink', [OnePayController::class, 'showLink']);
    Route::get('accounting/payment_reminders/one-pay/{amount}', [OnePayController::class, 'onepayPayment']);
    Route::match(['get', 'post'], '/ipn', [OnePayController::class, 'handleIPN']);

    //One pay Installment
    Route::get('accounting/payments/onepay-installment/createReceipt/{id}', [OnePayController::class, 'createReceiptInstallment']);
    Route::get('accounting/payments/onepay-installment/showLink', [OnePayController::class, 'showLink']);
    Route::get('accounting/payment_reminders/onepay-installment/{amount}', [OnePayController::class, 'onepayPaymentInstallment']);
    Route::match(['get', 'post'], '/ipn', [OnePayController::class, 'handleIPN']);

    Route::get('accounting/order-items/{id}/show-abroad-item-data-popup', [OrderItemController::class, 'showAbroadItemDataPopup']);
});

Route::match(['get', 'post'], 'accounting/onepay/process', [OnePayController::class, 'process']);
Route::match(['get', 'post'], 'accounting/onepay-installment/process', [OnePayController::class, 'processInstallment']);



