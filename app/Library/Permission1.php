<?php

namespace App\Library;

class Permission1
{
 
    public const STUDENT_GENERAL = 'student.general';

    // Permissions SYSTEM
    public const SYSTEM_ADMIN = 'system.admin';

    public const TEACHER_GENERAL = 'teacher.general';
    public const TEACHING_ASSISTANT_GENERAL = 'teaching_assistant.general';

    public const CONTACT_MANAGE_USER_ACCOUNT = 'contact.manage_user_account';
    public const TEACHER_MANAGE_USER_ACCOUNT = 'teacher.manage_user_account';

    // Permissions MARKETING
    public const MARKETING_CUSTOMER = 'marketing.customer';
    public const MARKETING_CONTACT_REQUEST_ADD = 'marketing.contact_request.add';
    public const MARKETING_CONTACT_REQUEST_UPDATE = 'marketing.contact_request.update';

    
    
    // Permissions SALES
    public const SALES_DASHBOARD_GENERAL = 'sales.dashboard.general';
    public const SALES_DASHBOARD_ALL = 'sales.dashboard.all';
    public const SALES_DASHBOARD_BRANCH = 'sales.dashboard.branch';
    public const SALES_DASHBOARD_BRANCH_ALL = 'sales.dashboard.branch.all';
    public const SALES_DASHBOARD_MANAGER = 'sales.dashboard.manager';
    public const SALES_DASHBOARD_MENTOR = 'sales.dashboard.mentor';
    
    public const SALES_CONTACT_REQUEST_ADD = 'sales.contact_request.add';
    public const SALES_CONTACT_REQUEST_UPDATE = 'sales.contact_request.update';
    public const SALES_CONTACT_REQUEST_DELETE = 'sales.contact_request.delete';
    public const SALES_CONTACT_REQUEST_LIST = 'sales.contact_request.list';
    public const SALES_CONTACT_REQUEST_EXCEL = 'sales.contact_request.excel';
    
    public const SALES_CONTACT_ALL = 'sales.contact.all';
    public const SALES_CONTACT_ADD = 'sales.contact.add';
    public const SALES_CONTACT_UPDATE = 'sales.contact.update';
    public const SALES_CONTACT_LIST = 'sales.contact.list';
    public const SALES_CONTACT_EXCEL = 'sales.contact.excel';
    public const SALES_CUSTOMER = 'sales.customer';
    public const SALES_CUSTOMER_LIST = 'sales.customer.list';
    public const SALES_CUSTOMER_UPDATE = 'sales.customer.update';
    
    public const SALES_ORDER_ALL = 'sales.order.all';
    public const SALES_ORDER_ADD = 'sales.order.add';
    public const SALES_ORDER_UPDATE = 'sales.order.update';
    public const SALES_ORDER_DELETE = 'sales.order.delete';
    public const SALES_ORDER_LIST = 'sales.order.list';
    
    public const SALES_NOTELOG_ALL = 'sales.notelog.all';
    public const SALES_NOTELOG_LIST = 'sales.notelog.list';
    public const SALES_NOTELOG_ADD = 'sales.notelog.add';
    public const SALES_NOTELOG_UPDATE = 'sales.notelog.update';
    public const SALES_NOTELOG_DELETE = 'sales.notelog.delete';
    
    public const SALES_REPORT_ALL = 'sales.report.all';
    public const SALES_REPORT_LIST = 'sales.report.list';
    public const SALES_REPORT_EXCEL = 'sales.report.excel';
    
    public const SALES_ACCOUNT_KPI_NOTE_ALL = 'sales.account.kpi.note.all';
    public const SALES_ACCOUNT_KPI_NOTE_LIST = 'sales.account.kpi.note.list';
    public const SALES_ACCOUNT_KPI_NOTE_ADD = 'sales.account.kpi.note.add';
    public const SALES_ACCOUNT_KPI_NOTE_UPDATE = 'sales.account.kpi.note.update';
    public const SALES_ACCOUNT_KPI_NOTE_DELETE = 'sales.account.kpi.note.delete';

    // Permissions ACCOUNTING
    public const ACCOUNTING_GENERAL = 'accounting.order';
    public const ACCOUNTING_ALL = 'accounting.all';
    public const ACCOUNTING_BRANCH = 'accounting.branch';
    public const ACCOUNTING_BRANCH_ALL = 'accounting.branch.all';
    public const ACCOUNTING_MANAGER = 'accounting.manager';
    public const ACCOUNTING_MENTOR = 'accounting.mentor';
    public const ACCOUNTING_ORDER_ALL = 'accounting.order.all';
    public const ACCOUNTING_ORDER_HISTORY_REJECTED = 'accounting.order.history_rejected';
    public const ACCOUNTING_ORDER_SHOW_CONTRACT = 'accounting.order.show_contract';
    public const ACCOUNTING_ORDER_REJECT = 'accounting.order.reject';
    public const ACCOUNTING_ORDER_LIST = 'accounting.order.list';
    public const ACCOUNTING_ORDER_APPROVE = 'accounting.order.approve';
    public const ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT = 'accounting.order.create_receipt_contact';

    public const ACCOUNTING_REFUND_REQUESTS_ALL = 'accounting.refund_requests.all';
    public const ACCOUNTING_REFUND_REQUESTS_LIST = 'accounting.refund_requests.list';
    public const ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST = 'accounting.refund_requests.show_request';
    public const ACCOUNTING_REFUND_REQUESTS_APPROVE = 'accounting.refund_requests.approve';
    public const ACCOUNTING_REFUND_REQUESTS_REJECT = 'accounting.refund_requests.reject';

    public const ACCOUNTING_KPI_TARGET_ALL = 'accounting.kpi_target.all';
    public const ACCOUNTING_KPI_TARGET_ADD = 'accounting.kpi_target.add';
    public const ACCOUNTING_KPI_TARGET_IMPORT_EXCEL = 'accounting.kpi_target.import_excel';
    public const ACCOUNTING_KPI_TARGET_UPDATE = 'accounting.kpi_target.update';
    public const ACCOUNTING_KPI_TARGET_DELETE = 'accounting.kpi_target.delete';
    public const ACCOUNTING_KPI_TARGET_LIST = 'accounting.kpi_target.list';

    public const ACCOUNTING_PAYMENT_REMINDERS_ALL = 'accounting.payment_reminders.all';
    public const ACCOUNTING_PAYMENT_REMINDERS_LIST = 'accounting.payment_reminders.list';
    public const ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT = 'accounting.payment_reminders.create_receipt_contact';

    public const ACCOUNTING_PAYMENTS_ALL = 'accounting.payments.all';
    public const ACCOUNTING_PAYMENTS_LIST = 'accounting.payments.list';
    public const ACCOUNTING_PAYMENTS_EXPORT_PDF = 'accounting.payments.exportPDF';
    public const ACCOUNTING_PAYMENTS_SHOW_PAYMENT = 'accounting.payments.show_payment';
    public const ACCOUNTING_PAYMENTS_DELETE = 'accounting.payments.delete';
    public const ACCOUNTING_PAYMENTS_ADD = 'accounting.payments.add';
    public const ACCOUNTING_PAYMENTS_APPROVE = 'accounting.payments.approve';
    public const ACCOUNTING_PAYMENTS_REJECT = 'accounting.payments.reject';

    public const ACCOUNTING_ACCOUNT_GROUPS_ALL = 'accounting.account_groups.all';
    public const ACCOUNTING_ACCOUNT_GROUPS_LIST = 'accounting.account_groups.list';
    public const ACCOUNTING_ACCOUNT_GROUPS_UPDATE = 'accounting.account_groups.update';

    public const ACCOUNTING_PAYRATES_ALL = 'accounting.payrates.all';
    public const ACCOUNTING_PAYRATES_ADD = 'accounting.payrates.add';
    public const ACCOUNTING_PAYRATES_UPDATE = 'accounting.payrates.update';
    public const ACCOUNTING_PAYRATES_DELETE = 'accounting.payrates.delete';
    public const ACCOUNTING_PAYRATES_EXCEL = 'accounting.payrates.excel';

    public const ACCOUNTING_REPORT_ALL = 'accounting.report.all';
    public const ACCOUNTING_REPORT_LIST = 'accounting.report.list';
    public const ACCOUNTING_REPORT_EXCEL = 'accounting.report.excel';
    
    // Permissions EDU
    public const EDU_GENERAL = 'edu.general';
    
    // Permissions ABROAD
    public const ABROAD_GENERAL = 'abroad.general';
    public const ABROAD_MANAGE_ALL = 'abroad.manage.all';
    public const ABROAD_APPLICATION_ALL = 'abroad.abroad_application.all';
    public const ABROAD_APPLICATION_HANDOVER = 'abroad.abroad_application.handover';
    public const ABROAD_APPLICATION_LIST = 'abroad.abroad_application.list';
    public const ABROAD_APPLICATION_WAITING = 'abroad.abroad_application.waiting';
    public const ABROAD_APPLICATION_ASSIGNED_ACCOUNT = 'abroad.abroad_application.assigned_account';
    public const ABROAD_APPLICATION_WAIT_FOR_APPROVAL = 'abroad.abroad_application.wait_for_approval';
    public const ABROAD_APPLICATION_APPROVED = 'abroad.abroad_application.approved';
    public const ABROAD_APPLICATION_DONE = 'abroad.abroad_application.done';

    public const ABROAD_STUDENT_PROFILE = 'abroad.student_profile';

    public const ABROAD_COURSES_ALL = 'abroad.courses.all';
    public const ABROAD_COURSES_ADD = 'abroad.courses.add';
    public const ABROAD_COURSES_UPDATE = 'abroad.courses.update';
    public const ABROAD_COURSES_DELETE = 'abroad.courses.delete';
    public const ABROAD_COURSES_LIST = 'abroad.courses.list';

    public const ABROAD_SECTIONS_CALENDAR_ALL = 'abroad.sections.calendar.all';
    public const ABROAD_SECTIONS_CALENDAR_LIST = 'abroad.sections.calendar.list';
    public const ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE = 'abroad.sections.calendar.not_active';
    public const ABROAD_SECTIONS_CALENDAR_ACTIVE = 'abroad.sections.calendar.active';
    public const ABROAD_SECTIONS_CALENDAR_DONE = 'abroad.sections.calendar.done';
    public const ABROAD_SECTIONS_CALENDAR_DESTROY = 'abroad.sections.calendar.destroy';

    public const ABROAD_REPORT_ALL = 'abroad.report.all';
    public const ABROAD_REPORT_LIST = 'abroad.report.list';
    public const ABROAD_REPORT_EXCEL = 'abroad.report.excel';

    // Permissions EXTRACURRICULAR
    
    public const EXTRACURRICULAR_GENERAL = 'extracurricular.general';
    public const EXTRACURRICULAR_MANAGE_ALL = 'extracurricular.manage.all';
    public const EXTRACURRICULAR_ALL = 'extracurricular.all';
    public const EXTRACURRICULAR_HANDOVER = 'extracurricular.handover';
    public const EXTRACURRICULAR_DETAIL = 'extracurricular.detail';
    public const EXTRACURRICULAR_LIST_APPROVAL_WAITING = 'extracurricular.list.approval.waiting';
    public const EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT = 'extracurricular.list.approval.assigned_account';
    public const EXTRACURRICULAR_LIST = 'extracurricular.list';

    
    public const EXTRACURRICULAR_MANAGE_LIST = 'extracurricular.manage.list';
    public const EXTRACURRICULAR_MANAGE_ADD = 'extracurricular.manage.add';
    public const EXTRACURRICULAR_MANAGE_UPDATE = 'extracurricular.manage.update';
    public const EXTRACURRICULAR_MANAGE_DELETE = 'extracurricular.manage.delete';
    public const EXTRACURRICULAR_MANAGE_STUDENT = 'extracurricular.manage.student';
    public const EXTRACURRICULAR_MANAGE_STUDENT_ADD = 'extracurricular.manage.student.add';
    public const EXTRACURRICULAR_MANAGE_STUDENT_UPDATE = 'extracurricular.manage.student.update';

    public const EXTRACURRICULAR_STUDENT_PROFILE = 'extracurricular.student_profile';

    public const EXTRACURRICULAR_ORDER_ALL = 'extracurricular.order.all';
    public const EXTRACURRICULAR_ORDER_ADD = 'extracurricular.order.add';
    public const EXTRACURRICULAR_ORDER_DELETE = 'extracurricular.order.delete';
    public const EXTRACURRICULAR_ORDER_LIST = 'extracurricular.order.list';
    public const EXTRACURRICULAR_ORDER_SHOW_CONTRACT = 'extracurricular.order.show_contract';
    public const EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT = 'extracurricular.order.create_receipt_contract';


    
    // Permissions TEACHER
    public const TEACHER_SHIFT_ASSIGNMENT = 'teacher.shiftAssignment';
    public const TEACHER_REPORT_SECTION = 'teacher.reportSection';
    public const TEACHER_SECTION = 'teacher.section';


    

    public static function getAllTeachers()
    {
        return [
            'general' => [
                self::TEACHER_GENERAL,
            ],
            'shift_assignment' => [
                self::TEACHER_SHIFT_ASSIGNMENT,
            ], 
            'report_section' => [
                self::TEACHER_REPORT_SECTION,
            ], 
            'section' => [
                self::TEACHER_SECTION,
            ], 
        ];
    }

    public static function getAllMarketings()
    {
        return [
            'general' => [
                self::MARKETING_CUSTOMER,
            ],
            'contact_request' => [
                self::MARKETING_CONTACT_REQUEST_ADD,
                self::MARKETING_CONTACT_REQUEST_UPDATE, 
            ], 
           
        ];
    }

    public static function getAllSales()
    {
        return [
            'general' => [
                self::SALES_CUSTOMER,
            ],
            'dashboard' => [ 
                self::SALES_DASHBOARD_GENERAL,
                self::SALES_DASHBOARD_BRANCH,
                self::SALES_DASHBOARD_BRANCH_ALL,
                self::SALES_DASHBOARD_MANAGER,
                self::SALES_DASHBOARD_MENTOR
            ],
            'contact_request' => [
                self::SALES_CONTACT_REQUEST_ADD,
                self::SALES_CONTACT_REQUEST_UPDATE,
                self::SALES_CONTACT_REQUEST_DELETE,
                self::SALES_CONTACT_REQUEST_LIST,
                self::SALES_CONTACT_REQUEST_EXCEL
            ],
            'contact' => [
                self::SALES_CONTACT_ALL,
                self::SALES_CONTACT_ADD,
                self::SALES_CONTACT_UPDATE,
                self::SALES_CONTACT_LIST,
                self::SALES_CONTACT_EXCEL
            ],
            'customer' => [
                self::SALES_CUSTOMER_LIST,
                self::SALES_CUSTOMER_UPDATE,
            ],
            'order' => [
                self::SALES_ORDER_ALL,
                self::SALES_ORDER_ADD,
                self::SALES_ORDER_UPDATE,
                self::SALES_ORDER_DELETE,
                self::SALES_ORDER_LIST
            ],
            'notelog' => [
                self::SALES_NOTELOG_ALL,
                self::SALES_NOTELOG_LIST,
                self::SALES_NOTELOG_ADD,
                self::SALES_NOTELOG_UPDATE,
                self::SALES_NOTELOG_DELETE
            ],
            'report' => [
                self::SALES_REPORT_ALL,
                self::SALES_REPORT_LIST,
                self::SALES_REPORT_EXCEL
            ],
            'account_kpi_note' => [
                self::SALES_ACCOUNT_KPI_NOTE_ALL,
                self::SALES_ACCOUNT_KPI_NOTE_LIST,
                self::SALES_ACCOUNT_KPI_NOTE_ADD,
                self::SALES_ACCOUNT_KPI_NOTE_UPDATE,
                self::SALES_ACCOUNT_KPI_NOTE_DELETE
            ],
        ];
    }

    public static function getAllEdus()
    {
        return [
            'general' => [
                self::EDU_GENERAL,
            ],
            
           
        ];
    }
    public static function getAllAccountings()
    {
        return [
            'general' => [
                self::ACCOUNTING_GENERAL,
                
            ],
            'order' => [
                self::ACCOUNTING_ORDER_ALL,
                self::ACCOUNTING_ORDER_HISTORY_REJECTED,
                self::ACCOUNTING_ORDER_SHOW_CONTRACT,
                self::ACCOUNTING_ORDER_REJECT,
                self::ACCOUNTING_ORDER_LIST,
                self::ACCOUNTING_ORDER_APPROVE,
                self::ACCOUNTING_ORDER_CREATE_RECEIPT_CONTACT,
            ],
            'rerfund_request' => [
                self::ACCOUNTING_REFUND_REQUESTS_ALL,
                self::ACCOUNTING_REFUND_REQUESTS_LIST,
                self::ACCOUNTING_REFUND_REQUESTS_SHOW_REQUEST,
                self::ACCOUNTING_REFUND_REQUESTS_APPROVE,
                self::ACCOUNTING_REFUND_REQUESTS_REJECT,
            ],
            'account_kpi_target' => [
                self::ACCOUNTING_KPI_TARGET_ALL,
                self::ACCOUNTING_KPI_TARGET_ADD,
                self::ACCOUNTING_KPI_TARGET_IMPORT_EXCEL,
                self::ACCOUNTING_KPI_TARGET_UPDATE,
                self::ACCOUNTING_KPI_TARGET_DELETE,
                self::ACCOUNTING_KPI_TARGET_LIST,
            ],
            'payment_reminder' => [
                self::ACCOUNTING_PAYMENT_REMINDERS_ALL,
                self::ACCOUNTING_PAYMENT_REMINDERS_LIST,
                self::ACCOUNTING_PAYMENT_REMINDERS_CREATE_RECEIPT_CONTACT,
            ],
            'payments' => [
                self::ACCOUNTING_PAYMENTS_ALL,
                self::ACCOUNTING_PAYMENTS_LIST,
                self::ACCOUNTING_PAYMENTS_EXPORT_PDF,
                self::ACCOUNTING_PAYMENTS_SHOW_PAYMENT,
                self::ACCOUNTING_PAYMENTS_DELETE,
                self::ACCOUNTING_PAYMENTS_ADD,
                self::ACCOUNTING_PAYMENTS_APPROVE,
                self::ACCOUNTING_PAYMENTS_REJECT,
            ],
            'account_groups' => [
                self::ACCOUNTING_ACCOUNT_GROUPS_ALL,
                self::ACCOUNTING_ACCOUNT_GROUPS_LIST,
                self::ACCOUNTING_ACCOUNT_GROUPS_UPDATE,
            ],
            'payrate' => [
                self::ACCOUNTING_PAYRATES_ALL,
                self::ACCOUNTING_PAYRATES_ADD,
                self::ACCOUNTING_PAYRATES_UPDATE,
                self::ACCOUNTING_PAYRATES_DELETE,
                self::ACCOUNTING_PAYRATES_EXCEL,
            ],
            'report' => [
                self::ACCOUNTING_REPORT_ALL,
                self::ACCOUNTING_REPORT_LIST,
                self::ACCOUNTING_REPORT_EXCEL,
            ],
            ];
    }
    public static function getAllAbroads()
    {
        return [
            'general' => [
                self::ABROAD_GENERAL,
                
            ],
            'approval_and_handover' => [
                self::ABROAD_APPLICATION_ALL,
                self::ABROAD_APPLICATION_HANDOVER,
                self::ABROAD_APPLICATION_LIST,
                self::ABROAD_APPLICATION_WAITING,
                self::ABROAD_APPLICATION_ASSIGNED_ACCOUNT,
                self::ABROAD_APPLICATION_WAIT_FOR_APPROVAL,
                self::ABROAD_APPLICATION_APPROVED,
                self::ABROAD_APPLICATION_DONE,
            ],
            'student_management' => [
                self::ABROAD_STUDENT_PROFILE,
            ],
            'course_management' => [
                self::ABROAD_COURSES_ALL,
                self::ABROAD_COURSES_ADD,
                self::ABROAD_COURSES_UPDATE,
                self::ABROAD_COURSES_DELETE,
                self::ABROAD_COURSES_LIST,
            ],
            'calendar_management' => [
                self::ABROAD_SECTIONS_CALENDAR_ALL,
                self::ABROAD_SECTIONS_CALENDAR_LIST,
                self::ABROAD_SECTIONS_CALENDAR_NOT_ACTIVE,
                self::ABROAD_SECTIONS_CALENDAR_ACTIVE,
                self::ABROAD_SECTIONS_CALENDAR_DONE,
                self::ABROAD_SECTIONS_CALENDAR_DESTROY,
            ],
            'report' => [
                self::ABROAD_REPORT_ALL,
                self::ABROAD_REPORT_LIST,
                self::ABROAD_REPORT_EXCEL,
            ],
        ];
    }

    public static function getAllExtracurriculars()
    {
        return [
            'general' => [
                self::EXTRACURRICULAR_GENERAL,
                
            ],
            'approval_and_handover' => [
                self::EXTRACURRICULAR_ALL,
                self::EXTRACURRICULAR_HANDOVER,
                self::EXTRACURRICULAR_DETAIL,
                self::EXTRACURRICULAR_LIST_APPROVAL_WAITING,
                self::EXTRACURRICULAR_LIST_APPROVAL_ASSIGNED_ACCOUNT,
                self::EXTRACURRICULAR_LIST,
            ],
            'manage_extracurricular_activities' => [
                self::EXTRACURRICULAR_MANAGE_ALL,
                self::EXTRACURRICULAR_MANAGE_LIST,
                self::EXTRACURRICULAR_MANAGE_ADD,
                self::EXTRACURRICULAR_MANAGE_UPDATE,
                self::EXTRACURRICULAR_MANAGE_DELETE,
                self::EXTRACURRICULAR_MANAGE_STUDENT,
                self::EXTRACURRICULAR_MANAGE_STUDENT_ADD,
                self::EXTRACURRICULAR_MANAGE_STUDENT_UPDATE,
            ],
            'student_management' => [
                self::EXTRACURRICULAR_STUDENT_PROFILE,
            ],
            'extracurricular_services' => [
                self::EXTRACURRICULAR_ORDER_ALL,
                self::EXTRACURRICULAR_ORDER_ADD,
                self::EXTRACURRICULAR_ORDER_DELETE,
                self::EXTRACURRICULAR_ORDER_LIST,
                self::EXTRACURRICULAR_ORDER_SHOW_CONTRACT,
                self::EXTRACURRICULAR_ORDER_CREATE_RECEIPT_CONTRACT,
            ],
        ];
    }

    public static function getAllSystems()
    {
        return [
            'general' => [
                self::SYSTEM_ADMIN,
            ],
            
           
        ];
    }
}

// user->can('salesDashboardReport', $branch)



// BranchPolicy
//     salesDashboardReport(Usr, branch)
//         user->hasPermission sales.dashboard.branch && user->account->branch = $branch