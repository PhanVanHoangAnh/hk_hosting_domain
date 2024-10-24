<?php

namespace App\Providers;

use App\Events\ApproveHSDT;
use App\Events\UpdateStrategicLearningCurriculum;
use App\Events\ConfirmReceiptFromSale;
use App\Events\ConfirmRefundRequest;
use App\Listeners\SendRejectHSDTNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\ContactRequestsAssigned;
use App\Listeners\SendContactRequestsAssignedNotification;
use App\Listeners\AddContactRequestsAssignedNoteLog;

use App\Events\SingleContactRequestAssigned;
use App\Listeners\SendSingleContactRequestAssignedNotification;
use App\Listeners\AddSingleContactRequestAssignedNoteLog;

use App\Events\OrderApprovalRequested;
use App\Listeners\SendOrderApprovalRequestedNotification;

use App\Events\OrderCreated;
use App\Listeners\OrderCreatedUpdateLeadStatus;

use App\Events\OrderApproved;
use App\Listeners\OrderApprovedUpdateLeadStatus;
use App\Listeners\OrderApprovedUpdateReminders;
use App\Listeners\AddOrderApprovedContactNoteLog;
use App\Listeners\ReceivedContractEduFromAccounting;
use App\Listeners\SendOrderApprovedToSigner;
use App\Listeners\SendOrderApprovedToManager;

use App\Events\AttendanceProcessed;
use App\Events\RequestConfirmReceiptFromSale;
use App\Listeners\AttendanceTaken;

use App\Events\NewContactRequestCreated;
use App\Listeners\SendCreateNewContactRequestNotification;
use App\Listeners\AddCreateNewContactRequestNotelog;
use App\Listeners\NotificationToAllSalesWhoWorkedWithContact;

use App\Events\NewOrderCreated;
use App\Listeners\SendCreateNewOrderNotification;
use App\Listeners\AddCreateNewOrderNotelog;

use App\Events\OrderRejected;
use App\Listeners\AddOrderRejectedContactNoteLog;

use App\Events\NewCourseCreated;
use App\Listeners\SendCreateNewCourseNotification;
use App\Listeners\AddCreateNewCourseNotelog;

use App\Events\NewAbroadCourseCreated;
use App\Listeners\SendCreateNewAbroadCourseNotification;
use App\Listeners\AddCreateNewAbroadCourseNotelog;

use App\Events\NewUserCreated;
use App\Listeners\SendCreateNewUserNotification;
use App\Listeners\AddCreateNewUserNotelog;
use App\Listeners\SendRefundConfirmationNotification;

use App\Events\PayrateUpdate;
use App\Listeners\RequestConfirmReceiptFromSaleListener;
use App\Listeners\ReceivedContractExtracurricularFromAccounting;
use App\Listeners\SendUpdatePayrateNotification;

use App\Events\AssigmentClass;
use App\Events\NewExtracurricularCreated;
use App\Events\RejectHSDT;
use App\Listeners\ConfirmReceiptFromSaleListener;
use App\Listeners\SendAssigmentClassNotification;

use App\Events\TransferCourse;
use App\Events\UpdateApplicationSchool;
use App\Events\UpdateCompleteFile;
use App\Events\UpdateCreateCertification;
use App\Events\UpdateEssayResult;
use App\Events\UpdateFinancialDocument;
use App\Events\UpdateRecommendationLetter;
use App\Events\UpdateScanOfInformation;
use App\Listeners\SendTransferCourseNotification;

use App\Events\UpdateSchedule;
use App\Events\UpdateStudentCV;
use App\Listeners\SendUpdateApplicationSchool;
use App\Listeners\SendUpdateCompleteFile;
use App\Listeners\SendUpdateCreateCertification;
use App\Listeners\SendUpdateEssayResult;
use App\Listeners\SendUpdateFinancialDocument;
use App\Listeners\SendUpdateRecommendationLetter;
use App\Listeners\SendUpdateScanOfInformation;
use App\Listeners\SendUpdateScheduleNotification;
use App\Listeners\SendUpdateStrategicLearningCurriculum;
use App\Listeners\SendUpdateStudentCV;

use App\Events\StudentAssignedToTTSK;
use App\Events\StudentAssignedToTVCL;
use App\Events\UpdateExtracurricularPlan;
use App\Listeners\SendApproveHSDTNotification;
use App\Listeners\SendNewExtracurricularNotification;
use App\Listeners\StudentAssignedToTVCLNotificationListener;
use App\Listeners\TTSKStaffAboutAssignmentListener;

use App\Events\UpdateReserve;
use App\Listeners\SendReserveEmail;

use App\Events\TheStudentWasHandedOverForAbroadStaff;
use App\Listeners\SendNotificationAboutStudentWasHandedOverForAbroadStaff;
use App\Listeners\AddNoteLogAboutStudentWasHandedOverForAbroadStaff;

use App\Events\TheStudentWasHandedOverForExtraStaff;
use App\Listeners\SendNotificationAboutTheStudentWasHandedOverForExtraStaff;
use App\Listeners\AddNoteLogAboutStudentWasHandedOverForExtraStaff;

use App\Events\UpdateReschedule;
use App\Events\UpdateSocialNetwork;
use App\Listeners\SendRescheduleEmail;
use App\Listeners\SendUpdateExtracurricularPlan;
use App\Listeners\SendUpdateSocialNetwork;

use App\Events\WeeklyUpSellReportCheck;
use App\Listeners\SendNotificationWeeklyUpsellReportCheck;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Mail\Events\MessageSending;
use App\Listeners\LogSentMessage;
use App\Listeners\LogSendingMessage;

use App\Events\NewPaymentRecordCreated;
use App\Listeners\NotificationWhenCreateNewPaymentRecord;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Email send
        MessageSent::class => [
            LogSentMessage::class,
        ],
        MessageSending::class => [
            LogSendingMessage::class,
        ],

        // Khi assign nhiều contact request cho nhân viên kinh doanh
        ContactRequestsAssigned::class => [
            SendContactRequestsAssignedNotification::class,
            AddContactRequestsAssignedNoteLog::class,
        ],

        // Khi assign 1 contact request cho nhân viên kinh doanh
        SingleContactRequestAssigned::class => [
            SendSingleContactRequestAssignedNotification::class,
            AddSingleContactRequestAssignedNoteLog::class,
        ],

        // Khi hợp đồng được tạo mới
        OrderCreated::class => [
            // Chuyển trạng thái contact request thành đang làm hợp đồng LS_MAKEING_CONSTRACT
            OrderCreatedUpdateLeadStatus::class,
        ],

        // Khi hợp đồng được yêu cầu kiểm duyệt
        OrderApprovalRequested::class => [
            SendOrderApprovalRequestedNotification::class,
        ],

        // Khi hợp đồng bị từ chối duyệt
        OrderRejected::class => [
            AddOrderRejectedContactNoteLog::class,
        ],

        // Khi hợp đồng được duyệt hoàn thành
        OrderApproved::class => [
            OrderApprovedUpdateLeadStatus::class,
            OrderApprovedUpdateReminders::class,
            AddOrderApprovedContactNoteLog::class,
            ReceivedContractEduFromAccounting::class,
            ReceivedContractExtracurricularFromAccounting::class,
            SendOrderApprovedToSigner::class,
            SendOrderApprovedToManager::class
        ],

        // Khi chốt ca xong
        AttendanceProcessed::class => [
            AttendanceTaken::class
        ],

        // Create new contact request
        NewContactRequestCreated::class => [
            SendCreateNewContactRequestNotification::class,
            AddCreateNewContactRequestNotelog::class,
            NotificationToAllSalesWhoWorkedWithContact::class,
        ],

        // Create new order
        NewOrderCreated::class => [
            SendCreateNewOrderNotification::class,
            AddCreateNewOrderNotelog::class
        ],

        // Create new course (edu & abroad)
        NewCourseCreated::class => [
            SendCreateNewCourseNotification::class,
            // AddCreateNewCourseNotelog::class
        ],

        // Create new Abroad course (only abroad)
        NewAbroadCourseCreated::class => [
            SendCreateNewAbroadCourseNotification::class,
            AddCreateNewAbroadCourseNotelog::class
        ],

        // When account create new student(contact)
        NewUserCreated::class => [
            SendCreateNewUserNotification::class,
            AddCreateNewUserNotelog::class
        ],

        // Khi yêu cầu hoàn phí
        ConfirmRefundRequest::class => [
            SendRefundConfirmationNotification::class,
        ],

        //Khi thay đổi bậc lương
        PayrateUpdate::class => [
            SendUpdatePayrateNotification::class,
        ],

        //Khi xếp lớp
        AssigmentClass::class => [
            SendAssigmentClassNotification::class,
        ],

        //Khi chuyển lớp
        TransferCourse::class => [
            SendTransferCourseNotification::class,
        ],

        // Yêu cầu xác nhận phiếu thu (trong trường hợp phiếu thu do sale tạo)
        RequestConfirmReceiptFromSale::class => [
            RequestConfirmReceiptFromSaleListener::class,
        ],

        // Xác nhận phiếu thu (trong trường hợp phiếu thu do sale tạo)
        ConfirmReceiptFromSale::class => [
            ConfirmReceiptFromSaleListener::class,
        ],

         //Khi thay đổi thời khoá biểu
         UpdateSchedule::class => [
            SendUpdateScheduleNotification::class,
        ],

        //Khi cập nhật lộ trình học thuật chiến lược
        UpdateStrategicLearningCurriculum::class => [
            SendUpdateStrategicLearningCurriculum::class,
        ],

        //Khi cập nhật danh sách trường yêu cầu chuyển sinh
        UpdateApplicationSchool::class => [
            SendUpdateApplicationSchool::class,
        ],

        //Khi cập nhật thư giới thiệu
        UpdateRecommendationLetter::class => [
            SendUpdateRecommendationLetter::class,
        ],

        //Khi cập nhật Kết quả chấm luận
        UpdateEssayResult::class => [
            SendUpdateEssayResult::class,
        ],

        //Khi cập nhật hồ sơ tài chính
        UpdateFinancialDocument::class => [
            SendUpdateFinancialDocument::class,
        ],

        //Khi cập nhật CV học viên
        UpdateStudentCV::class => [
            SendUpdateStudentCV::class,
        ],

        //Khi cập nhật Bản Scan thông tin cá nhân
        UpdateScanOfInformation::class => [
            SendUpdateScanOfInformation::class,
        ],

        //Khi cập nhật hồ sơ hoàn chỉnh
        UpdateCompleteFile::class => [
            SendUpdateCompleteFile::class,
        ],

        //Khi cập nhật chứng chỉ
        UpdateCreateCertification::class => [
            SendUpdateCreateCertification::class,
        ],

        // Bàn giao học viên cho nhân viên TTSK
        StudentAssignedToTTSK::class =>[
            TTSKStaffAboutAssignmentListener::class,
        ],

        // Bàn giao học viên cho nhân viên TVCL
        StudentAssignedToTVCL::class =>[
            StudentAssignedToTVCLNotificationListener::class,
        ],
        
        // hoạt động Ngoại khóa mới
        NewExtracurricularCreated::class =>[
            SendNewExtracurricularNotification::class,
        ],

        // duyệt hồ sơ dự tuyển
        ApproveHSDT::class => [
            SendApproveHSDTNotification::class
        ],

        // từ chối hồ sơ dự tuyển
        RejectHSDT::class => [
            SendRejectHSDTNotification::class
        ],

         // Khi bảo lưu
         UpdateReserve::class => [
            SendReserveEmail::class,
        ],

        // Học viên được bàn giao cho cán bộ du học
        TheStudentWasHandedOverForAbroadStaff::class => [
            SendNotificationAboutStudentWasHandedOverForAbroadStaff::class,
            AddNoteLogAboutStudentWasHandedOverForAbroadStaff::class
        ],

        // Học viên được bàn giao cho cán bộ ngoại khóa
        TheStudentWasHandedOverForExtraStaff::class => [
            SendNotificationAboutTheStudentWasHandedOverForExtraStaff::class,
            AddNoteLogAboutStudentWasHandedOverForExtraStaff::class
        ],

         // Khi chuyển buổi học
         UpdateReschedule::class => [
            SendRescheduleEmail::class,
        ],

        // cập nhật "Mạng xã hội và kênh truyền thông"
        UpdateSocialNetwork::class =>[
            SendUpdateSocialNetwork::class,
        ],

        // cập nhật "Lộ trình hoạt động ngoại khóa"
        UpdateExtracurricularPlan::class => [
            SendUpdateExtracurricularPlan::class,
        ],

        // Thông báo kiểm tra báo cáo upsell đào tạo sáng thứ 2 hàng tuần
        WeeklyUpSellReportCheck::class => [
            SendNotificationWeeklyUpsellReportCheck::class
        ],

        // Thông báo cho sale và học viên khi có phiếu thu được tạo
        NewPaymentRecordCreated::class => [
            NotificationWhenCreateNewPaymentRecord::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
