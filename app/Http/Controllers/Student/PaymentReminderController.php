<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentReminder;

class PaymentReminderController extends Controller
{
    public function index(Request $request)
    {
        // Hiển thị danh sách các nhắc nhở thanh toán
       
        $contact = $request->user()->getStudent();
        $reminds = $contact->paymentRemindersOfStudent();
        $reminds = $reminds->reachingDueDate()->checkIsNotPaid();
        return view('student.payment_reminders.index', [
            'status' => $request->status,
            'reminds'=>$reminds->get(),
            'columns' => [
                ['id' => 'code', 'title' => trans('messages.payment_reminders.code'), 'checked' => true],
                // ['id' => 'id', 'title' => trans('messages.contact.id'), 'checked' => true],
                // ['id' => 'contact_id', 'title' => trans('messages.payment_reminders.contact_id'), 'checked' => true],
                ['id' => 'debt_in_progress', 'title' => trans('messages.payment_reminders.debt_in_progress'), 'checked' => true],
                ['id' => 'paid_in_progress', 'title' => trans('messages.payment_reminders.paid_in_progress'), 'checked' => true],
                ['id' => 'amount', 'title' => trans('messages.payment_reminders.amount'), 'checked' => true],
                ['id' => 'due_date', 'title' => trans('messages.payment_reminders.due_date'), 'checked' => true],
                ['id' => 'cache_total', 'title' => trans('messages.payment_reminders.cache_total'), 'checked' => true],
                ['id' => 'paid', 'title' => trans('messages.payment_reminders.paid'), 'checked' => true],
                ['id' => 'remain_amount', 'title' => trans('messages.payment_reminders.remain_amount'), 'checked' => true],
                ['id' => 'last_due_date', 'title' => trans('messages.payment_reminders.last_due_date'), 'checked' => true],
                // ['id' => 'total_debt', 'title' => trans('messages.payment_reminders.total_debt'), 'checked' => true],
                ['id' => 'phone', 'title' => trans('messages.payment_reminders.phone'), 'checked' => false],
                ['id' => 'email', 'title' => trans('messages.payment_reminders.email'), 'checked' => false],
                ['id' => 'cache_total', 'title' => trans('messages.payment_reminders.cache_total'), 'checked' => true],
                ['id' => 'status', 'title' => trans('messages.payment_reminders.status'), 'checked' => true],
                ['id' => 'progress', 'title' => trans('messages.payment_reminders.progress'), 'checked' => true],
            ],
        ]);
    }

    public function list(Request $request)
    {
        
        $contact = $request->user()->getStudent();
        $query = $contact->paymentRemindersOfStudent();


        $sortColumn = $request->sort_by ?? 'due_date';
        $sortDirection = $request->sort_direction ?? 'asc';



        if ($request->keyword) {
            $query = $query->search($request->keyword);
        }

        if ($request->contact) {
            $query = $query->filterByContact($request->contact);
        }

        if ($request->student_id) {
            $query = $query->filterByStudentId($request->student_id);
        }

        if ($request->industries) {
            $query = $query->filterByIndustries($request->industries);
        }

        if ($request->orderTypes) {
            $query = $query->filterByOrderTypes($request->orderTypes);
        }

        if ($request->types) {
            $query = $query->filterByTypes($request->types);
        }

        if ($request->sales) {
            $query = $query->filterBySales($request->sales);
        }

        if ($request->saleSups) {
            $query = $query->filterBySaleSups($request->saleSups);
        }
        if ($request->progressTypes) {
            $query = $query->filterByProgressTypes($request->progressTypes);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }


        if ($request->has('due_date_from') && $request->has('due_date_to')) {
            $due_date_from = $request->input('due_date_from');
            $due_date_to = $request->input('due_date_to');
            $query = $query->filterByDueDate($due_date_from,  $due_date_to);
        }




        $query = $query
            ->rightJoin('orders as order', 'payment_reminder.order_id', '=', 'order.id')
            ->select('payment_reminder.*', 'order.status as order_status');



        if ($sortColumn == 'amount') {
            $query = $query->orderBy('payment_reminder.amount', $sortDirection);
        } elseif ($sortColumn == 'due_date') {
            $query = $query->orderBy('payment_reminder.due_date', $sortDirection);
        } elseif ($sortColumn == 'progress') {
            $query = $query->orderBy('payment_reminder.progress', $sortDirection);
        } else {
            $query = $query->orderBy("order.{$sortColumn}", $sortDirection);
        }
        // filter status

        if ($request->status) {
            switch ($request->status) {
                case PaymentReminder::STATUS_REACHING_DUE_DATE:
                    $query = $query->reachingDueDate()->checkIsNotPaid();
                    break;
                case PaymentReminder::STATUS_IS_PAID:
                    $query = $query->checkIsPaid();
                    break;
                case PaymentReminder::STATUS_OVER_DUE_DATE:
                    $query = $query->overDueDate()->checkIsNotPaid();
                    break;
                case PaymentReminder::STATUS_PART_PAID:
                    $query = $query->partPaid()->checkIsNotPaid();

                    break;
                case 'all':
                    break;

                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }

        $paymentRemindersPaid = clone $query;
        $paymentRemindersPaidCount = $paymentRemindersPaid->checkIsPaid()->count();
        $paymentRemindersPaidSumAmount = $paymentRemindersPaid->checkIsPaid()->sum('payment_reminder.amount');

        $reachingDueDateReminders = clone $query;
        $paymentRemindersReachingDueDateCount = $reachingDueDateReminders->checkIsNotPaid()->reachingDueDate()->count();
        $paymentRemindersReachingDueDateSumAmount = $reachingDueDateReminders->checkIsNotPaid()->sum('payment_reminder.amount');

        $outdatedReminders = clone $query;
        $paymentRemindersOutDateCount = $outdatedReminders->checkIsNotPaid()->overDueDate()->count();
        $paymentRemindersOutDueDateSumAmount = $outdatedReminders->checkIsNotPaid()->sum('payment_reminder.amount');

        // Paginate
        $paymentReminders = $query->paginate($request->perpage ?? 20);

        return view('student.payment_reminders.list', [
            'paymentReminders' => $paymentReminders,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'paymentRemindersReachingDueDateCount' => $paymentRemindersReachingDueDateCount,
            'paymentRemindersReachingDueDateSumAmount' => $paymentRemindersReachingDueDateSumAmount,
            'paymentRemindersOutDateCount' => $paymentRemindersOutDateCount,
            'paymentRemindersOutDueDateSumAmount' => $paymentRemindersOutDueDateSumAmount,
            'paymentRemindersPaidCount' => $paymentRemindersPaidCount,
            'paymentRemindersPaidSumAmount' => $paymentRemindersPaidSumAmount,



        ]);
    }
}
