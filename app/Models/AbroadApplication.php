<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbroadApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'order_item_id',
        'account_1',
        'account_2',

        // Order item fields
        'apply_time',
        'std_score',
        'eng_score',
        'postgraduate_plan',
        'personality',
        'subject_preference',
        'language_culture',
        'research_info',
        'aim',
        'essay_writing_skill',
        'personal_countling_need',
        'other_need_note',
        'parent_job',
        'parent_highest_academic',
        'is_parent_studied_abroad',
        'parent_income',
        'parent_familiarity_abroad',
        'is_parent_family_studied_abroad',
        'parent_time_spend_with_child',
        'financial_capability',
        'top_school',
        'estimated_enrollment_time',
        'current_program_id',
        'plan_apply_program_id',
        'intended_major_id',

        'academic_award_1',
        'academic_award_2',
        'academic_award_3',
        'academic_award_4',
        'academic_award_5',
        'academic_award_6',
        'academic_award_7',
        'academic_award_8',
        'academic_award_9',
        'academic_award_10',
        'academic_award_text_1',
        'academic_award_text_2',
        'academic_award_text_3',
        'academic_award_text_4',
        'academic_award_text_5',
        'academic_award_text_6',
        'academic_award_text_7',
        'academic_award_text_8',
        'academic_award_text_9',
        'academic_award_text_10',

        'extra_activity_1',
        'extra_activity_2',
        'extra_activity_3',
        'extra_activity_4',
        'extra_activity_5',
        'extra_activity_text_1',
        'extra_activity_text_2',
        'extra_activity_text_3',
        'extra_activity_text_4',
        'extra_activity_text_5',

        'grade_1',
        'grade_2',
        'grade_3',
        'grade_4',
        'point_1',
        'point_2',
        'point_3',
        'point_4',
    ];

    public const STATUS_DEPOSIT_SUCCESS = 'deposit_success';
    public const STATUS_DEPOSIT_WAITING = 'deposit_waiting';

     //status
     public const STATUS_NEW = 'new';
     public const STATUS_WAIT_FOR_APPROVAL = 'wait_for_approval';
     public const STATUS_APPROVED = 'approved';
     public const STATUS_REJECTED = 'rejected';
     public const STATUS_CANCEL = 'cancel';
     public const STATUS_RESERVE = 'reserve';
     public const STATUS_UNRESERVE = 'unreserve';


    //hsdt
    public const STATUS_HSDT_NEW = 'new';
    public const STATUS_HSDT_WAIT_FOR_APPROVAL = 'wait_for_approval';
    public const STATUS_HSDT_APPROVED = 'approved';
    public const STATUS_HSDT_REJECTED = 'rejected';

    // I20 application
    public const STATUS_I20_APPLICATION_PASS = 'i20_application_pass';
    public const STATUS_I20_APPLICATION_SLIP = 'i20_application_slip';
    public const STATUS_I20_APPLICATION_WAIT = 'i20_application_wait';

    // visa
    public const STATUS_VISA_PASS = 'visa_pass';
    public const STATUS_VISA_SLIP = 'visa_slip';
    public const STATUS_VISA_WAIT = 'visa_wait';

    public const PREFIX_SAVE_FILE_URL = 'uploads/app/abroad/abroad_application/';

    // Recommendation letter
    private const SUFFIX_SAVE_DRAFT_LETTER_URL = 'recommendation_letters/draft/';
    private const SUFFIX_SAVE_ACTIVE_LETTER_URL = 'recommendation_letters/active/';

    // essay result file
    public const SUFFIX_SAVE_ESSAY_RESULT_FILE_URL = 'essay_result_files';

    // application fee file
    public const SUFFIX_SAVE_APPLICATION_CONFIRMATION_FILE_URL = 'application_comfirmation_files';
    // application fee file
    public const SUFFIX_SAVE_APPLICATION_FEE_FILE_URL = 'application_fee_files';

     // application scholarship file
     public const SUFFIX_SAVE_SCHOLARSHIP_FILE_URL = 'application_scholarship_files';

    // application submission file
    public const SUFFIX_SAVE_APPLICATION_SUBMISSION_FILE_URL = 'application_submission_files';

    // CV
    private const SUFFIX_SAVE_CV_URL = 'cvs/';

    // study abroad application
    public const SUFFIX_SAVE_STUDY_ABROAD_APPLICATION_FILE_URL = 'study_abroad_application';

    // financialDocument
    private const SUFFIX_SAVE_FINANCIAL_DOCUMENT_URL = 'financial_documents/';

    // completeFile
    private const SUFFIX_SAVE_COMPLETE_FILE_URL = 'complete_file/';

    // completeFile
    private const SUFFIX_SAVE_ADMISSION_LETTER_URL = 'admission_letter/';

    // scan of information
    private const SUFFIX_SAVE_SCAN_OF_INFORMATION_URL = 'scan_of_information/';

    // I20 application
    private const SUFFIX_SAVE_I20_APPLICATION_URL = 'i20_application/';
    
    // student visa
    private const SUFFIX_SAVE_STUDENT_VISA_URL = 'student_visa/';

    // Deposit file
    private const SUFFIX_SAVE_DEPOSIT_FILE_URL = 'deposit_files/';

    // Deposit file
    public const SUFFIX_SAVE_DEPOSIT_SCHOOL_URL = 'deposit_schools/';

    public function recommendationLetters()
    {
        return $this->hasMany(RecommendationLetter::class);
    }

    public function studentCvs()
    {
        return $this->hasMany(StudentCv::class);
    }

    public function extracurricularSchedules()
    {
        return $this->hasMany(ExtracurricularSchedule::class);
    }

    public function extracurricularActivity()
    {
        return $this->hasMany(ExtracurricularActivity::class);
    }

    public function certification()
    {
        return $this->hasMany(Certifications::class);
    }

    public function applicationSchool()
    {
        return $this->hasMany(ApplicationSchool::class);
    }

    public function socialNetwork()
    {
        return $this->hasMany(SocialNetwork::class);
    }

    public function studyAbroadApplications()
    {
        return $this->hasMany(StudyAbroadApplication::class);
    }

    public function applicationSchools()
    {
        return $this->hasMany(ApplicationSchool::class);
    }

    public static function newDefault()
    {
        $abroadApplication = new self();
        return $abroadApplication;
    }

    public function account1()
    {
        return $this->belongsTo(Account::class, 'account_1');
    }

    public function account2()
    {
        return $this->belongsTo(Account::class, 'account_2');
    }
    public function managerExtracurricular()
    {
        return $this->belongsTo(Account::class, 'account_manager_extracurricular_id');
    }
    public function managerAbroad()
    {
        return $this->belongsTo(Account::class, 'account_manager_abroad_id');
    }
    public function cancel(){
        $this->status = self::STATUS_CANCEL;
        $this->save();
    }
    public function reserve(){
        $this->status = self::STATUS_RESERVE;
        $this->save();
    }
    public function unreserve(){
        $this->status = self::STATUS_UNRESERVE;
        $this->save();
    }
    // Code format exp: 00019/2024
    public function generateCode()
    {
        $currYear = Carbon::now()->year;
        $id = $this->id;

        // Instruct to set the number to always be 5 digits
        $formattedNumber = str_pad($id, 5, '0', STR_PAD_LEFT);

        $this->code = "{$formattedNumber}/{$currYear}";
        $this->save();
    }

    public function savefromRequest($request)
    {
        $this->fill($request->all());

        $validatorRules = [
            'order_id' => 'required',
            'apply_time' => 'required',
            'plan_apply_program_id' => 'required',
            'std_score' => 'nullable|numeric',
            'eng_score' => 'nullable|numeric',
            'financial_capability' => 'required',
            'estimated_enrollment_time' => 'required',
        ];

        $validator = Validator::make($request->all(), $validatorRules);

        if (!$request->has('academic_award_1')) {
            $this->academic_award_1 = 0;
            $this->academic_award_text_1 = null;
        }
        
        if (!$request->has('academic_award_2')) {
            $this->academic_award_2 = 0;
            $this->academic_award_text_2 = null;
        }

        if (!$request->has('academic_award_3')) {
            $this->academic_award_3 = 0;
            $this->academic_award_text_3 = null;
        }

        if (!$request->has('academic_award_4')) {
            $this->academic_award_4 = 0;
            $this->academic_award_text_4 = null;
        }

        if (!$request->has('academic_award_5')) {
            $this->academic_award_5 = 0;
            $this->academic_award_text_5 = null;
        }

        if (!$request->has('academic_award_6')) {
            $this->academic_award_6 = 0;
            $this->academic_award_text_6 = null;
        }

        if (!$request->has('academic_award_7')) {
            $this->academic_award_7 = 0;
            $this->academic_award_text_7 = null;
        }

        if (!$request->has('academic_award_8')) {
            $this->academic_award_8 = 0;
            $this->academic_award_text_8 = null;
        }

        if (!$request->has('academic_award_9')) {
            $this->academic_award_9 = 0;
            $this->academic_award_text_9 = null;
        }

        if (!$request->has('academic_award_10')) {
            $this->academic_award_10 = 0;
            $this->academic_award_text_10 = null;
        }

        // Extra Activities
        if (!$request->has('extra_activity_1')) {
            $this->extra_activity_1 = 0;
            $this->extra_activity_text_1 = null;
        }
        
        if (!$request->has('extra_activity_2')) {
            $this->extra_activity_2 = 0;
            $this->extra_activity_text_2 = null;
        }

        if (!$request->has('extra_activity_3')) {
            $this->extra_activity_3 = 0;
            $this->extra_activity_text_3 = null;
        }

        if (!$request->has('extra_activity_4')) {
            $this->extra_activity_4 = 0;
            $this->extra_activity_text_4 = null;
        }

        if (!$request->has('extra_activity_5')) {
            $this->extra_activity_5 = 0;
            $this->extra_activity_text_5 = null;
        }

        // GPA
        if (!$request->has('grade_1')) {
            $this->grade_1 = 0;
            $this->grade_1 = null;
        }
        
        if (!$request->has('grade_2')) {
            $this->grade_2 = 0;
            $this->point_2 = null;
        }

        if (!$request->has('grade_3')) {
            $this->grade_3 = 0;
            $this->point_3 = null;
        }

        if (!$request->has('grade_4')) {
            $this->grade_4 = 0;
            $this->point_4 = null;
        }

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();

        return $validator->errors();
    }

    public function isNewHSDT()
    {
        return $this->hsdt_status === self::STATUS_HSDT_NEW;
    }

    public function isWaiForApprovalHSDT()
    {
        return $this->hsdt_status === self::STATUS_HSDT_WAIT_FOR_APPROVAL;
    }

    public function requestApproval()
    {
        $this->hsdt_status = self::STATUS_HSDT_WAIT_FOR_APPROVAL;
        $this->save();
    }
    
    public function duyetHoSoDuTuyen()
    {
        $this->hsdt_status = self::STATUS_HSDT_APPROVED;
        $this->save();
    }

    public function rejectHSDT()
    { 
        $this->hsdt_status = self::STATUS_HSDT_REJECTED; 
        $this->save();
    }

    public function requestApprovalCompleteApplication()
    {
        $this->status = self::STATUS_WAIT_FOR_APPROVAL;
        $this->save();
    }
    
    public function approveCompleteApplication()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }

    public function rejectCompleteApplication()
    { 
        $this->status = self::STATUS_REJECTED; 
        $this->save();
    }

    public function isNewCompleteApplication()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isWaiForApprovalCompleteApplication()
    {
        return $this->status === self::STATUS_WAIT_FOR_APPROVAL;
    }

    /**
     * This function is used to assign the 'new' status to each new abroadApplication created
     */
    public function assignNew()
    {
        $abroadStatusNew = AbroadStatus::new();

        if (!$abroadStatusNew) {
            throw new \Exception('Not existing abroad status new!');
        }

        // $existingRecord = AbroadApplicationStatus::where('abroad_application_id', $this->id)
        //     ->where('abroad_status_id', $abroadStatusNew->id)
        //     ->first();

        // Check to see if the data field exists
        // if ($existingRecord) {
        //     throw new \Exception('A similar AbroadApplicationStatus already exists!');
        // }

        // AbroadApplicationStatus::create([
        //     'abroad_application_id' => $this->id,
        //     'abroad_status_id' => $abroadStatusNew->id
        // ]);
    }

    public function fillFromOrderItem($orderItem)
    {
        $this->apply_time = $orderItem->apply_time;
        $this->std_score = $orderItem->std_score;
        $this->eng_score = $orderItem->eng_score;
        $this->postgraduate_plan = $orderItem->postgraduate_plan;
        $this->personality = $orderItem->personality;
        $this->subject_preference = $orderItem->subject_preference;
        $this->language_culture = $orderItem->language_culture;
        $this->research_info = $orderItem->research_info;
        $this->aim = $orderItem->aim;
        $this->essay_writing_skill = $orderItem->essay_writing_skill;
        $this->personal_countling_need = $orderItem->personal_countling_need;
        $this->other_need_note = $orderItem->other_need_note;
        $this->parent_job = $orderItem->parent_job;
        $this->parent_highest_academic = $orderItem->parent_highest_academic;
        $this->is_parent_studied_abroad = $orderItem->is_parent_studied_abroad;
        $this->parent_income = $orderItem->parent_income;
        $this->parent_familiarity_abroad = $orderItem->parent_familiarity_abroad;
        $this->is_parent_family_studied_abroad = $orderItem->is_parent_family_studied_abroad;
        $this->parent_time_spend_with_child = $orderItem->parent_time_spend_with_child;
        $this->financial_capability = $orderItem->financial_capability;
        $this->top_school = $orderItem->top_school;
        $this->estimated_enrollment_time = $orderItem->estimated_enrollment_time;
        $this->current_program_id = $orderItem->current_program_id;
        $this->plan_apply_program_id = $orderItem->plan_apply_program_id;
        $this->intended_major_id = $orderItem->intended_major_id;
        $this->academic_award_1 = $orderItem->academic_award_1;
        $this->academic_award_2 = $orderItem->academic_award_2;
        $this->academic_award_3 = $orderItem->academic_award_3;
        $this->academic_award_4 = $orderItem->academic_award_4;
        $this->academic_award_5 = $orderItem->academic_award_5;
        $this->academic_award_6 = $orderItem->academic_award_6;
        $this->academic_award_7 = $orderItem->academic_award_7;
        $this->academic_award_8 = $orderItem->academic_award_8;
        $this->academic_award_9 = $orderItem->academic_award_9;
        $this->academic_award_10 = $orderItem->academic_award_10;
        $this->academic_award_text_1 = $orderItem->academic_award_text_1;
        $this->academic_award_text_2 = $orderItem->academic_award_text_2;
        $this->academic_award_text_3 = $orderItem->academic_award_text_3;
        $this->academic_award_text_4 = $orderItem->academic_award_text_4;
        $this->academic_award_text_5 = $orderItem->academic_award_text_5;
        $this->academic_award_text_6 = $orderItem->academic_award_text_6;
        $this->academic_award_text_7 = $orderItem->academic_award_text_7;
        $this->academic_award_text_8 = $orderItem->academic_award_text_8;
        $this->academic_award_text_9 = $orderItem->academic_award_text_9;
        $this->academic_award_text_10 = $orderItem->academic_award_text_10;
        $this->extra_activity_1 = $orderItem->extra_activity_1;
        $this->extra_activity_2 = $orderItem->extra_activity_2;
        $this->extra_activity_3 = $orderItem->extra_activity_3;
        $this->extra_activity_4 = $orderItem->extra_activity_4;
        $this->extra_activity_5 = $orderItem->extra_activity_5;
        $this->extra_activity_text_1 = $orderItem->extra_activity_text_1;
        $this->extra_activity_text_2 = $orderItem->extra_activity_text_2;
        $this->extra_activity_text_3 = $orderItem->extra_activity_text_3;
        $this->extra_activity_text_4 = $orderItem->extra_activity_text_4;
        $this->extra_activity_text_5 = $orderItem->extra_activity_text_5;
        $this->grade_1 = $orderItem->grade_1;
        $this->grade_2 = $orderItem->grade_2;
        $this->grade_3 = $orderItem->grade_3;
        $this->grade_4 = $orderItem->grade_4;
        $this->point_1 = $orderItem->point_1;
        $this->point_2 = $orderItem->point_2;
        $this->point_3 = $orderItem->point_3;
        $this->point_4 = $orderItem->point_4;

        $this->save();
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class, 'order_item_id', 'order_item_id');
    }

    public function applicationFees()
    {
        return $this->hasMany(ApplicationFee::class, 'abroad_application_id');
    }

    public function flyingStudents()
    {
        return $this->hasMany(ApplicationFee::class, 'abroad_application_id');
    }
    // This - AbroadApplicationStatus (1 - n)
    // public function abroadApplicationStatuses()
    // {
    //     return $this->hasMany(AbroadApplicationStatus::class, 'abroad_application_id', 'id');
    // }

    // public function scopeByStatus($query, $statusName)
    // {
    //     return $query->whereHas('abroadApplicationStatuses', function ($q) use ($statusName) {
    //         $q->whereHas('abroadStatus', function ($q2) use ($statusName) {
    //             $q2->where('name', $statusName);
    //         });
    //     });
    // }
    public static function scopeFilterByAccount1($query, $account1)
    {
        return $query->whereIn('account_1', $account1);
    }

    public static function scopeFilterByAccount2($query, $account2)
    {
        return $query->whereIn('account_2', $account2);
    }

    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        if (
            $sortColumn === 'name' ||
            $sortColumn === 'email' ||
            $sortColumn === 'father_id' ||
            $sortColumn === 'mother_id'
        ) {
            return $query
                ->join('order_items', 'order_items.id', '=', 'abroad_applications.order_item_id')
                ->join('orders', 'orders.id', '=', 'order_items.id')
                ->join('contacts', 'abroad_applications.contact_id', '=', 'contacts.id')
                ->select('abroad_applications.*')
                ->orderBy('contacts.' . $sortColumn, $sortDirection);
        }

        if ($sortColumn === 'code') {
            return $query
                ->join('order_items', 'order_items.id', '=', 'abroad_applications.order_item_id')
                ->join('orders', 'orders.id', '=', 'order_items.id')
                ->select('abroad_applications.*')
                ->orderBy('orders.' . $sortColumn, $sortDirection);
        }

        return $query->orderBy('abroad_applications.' . $sortColumn, $sortDirection);
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('abroad_applications.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }
    public static function scopeFilterByCreatedAtFrom($query, $created_at_from)
    {
        if (!empty($created_at_from)) {
            return $query->where('abroad_applications.created_at', '>=', $created_at_from);
        }

        return $query;
    }
    public static function scopeFilterByCreatedAtTo($query, $created_at_to)
    {
        if (!empty($created_at_to)) {
            return $query->where('abroad_applications.created_at', '<=', $created_at_to);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('abroad_applications.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }
    public static function scopeFilterByUpdatedAtFrom($query, $updated_at_from)
    {
        if (!empty($updated_at_from) ) {
            return $query->where('abroad_applications.updated_at', '>=', $updated_at_from );
        }

        return $query;
    }
    public static function scopeFilterByUpdatedAtTo($query, $updated_at_to)
    {
        if (!empty($updated_at_to) ) {
            return $query->where('abroad_applications.updated_at', '<=', $updated_at_to );
        }

        return $query;
    }
    public static function scopeFilterBySalespersonIds($query, $salesPersonIds)
    {
        // nếu mà trong salesperson ids có 'none' thì filter array loại cái none ra. 2 trường hợp
        //   1. nếu chỉ có mỗi none thôi thì where account_id = null
        //   2. vừa có none vừa có 1 hoặc nhiều salesperson khác
        //   3. không có none
        //   4. mảng rỗng luôn
        // $abroadApplication->orderItem->order->salesperson->id

        return $query->where(function ($q) use ($salesPersonIds) {
            $ids = array_filter($salesPersonIds, function ($id) {
                return $id !== 'none';
            });
    
            if (!empty($ids)) {
                $q->whereHas('orderItem.order.salesperson', function ($q2) use ($ids) {
                    $q2->whereIn('id', $ids);
                });
            }
    
            if (in_array('none', $salesPersonIds)) {
                $q->orWhereDoesntHave('orderItem.order.salesperson');
            }
        });
    }



    public static function scopeFilterByAbroadStatus($query, $abroadStatuses)
    {
        return $query->whereHas('abroadApplicationStatuses', function ($q) use ($abroadStatuses) {
            $q->whereHas('abroadStatus', function ($q2) use ($abroadStatuses) {
                $q2->where('name', $abroadStatuses);
            });
        });
    }

    public static function scopeFilterByStatusAbroad($query, $abroadStatuses)
    {
        return $query->whereIn('hsdt_status', $abroadStatuses);
    }

    public static function scopeFilterByAssignedAcount($query)
    {
        return $query->whereNotNull('account_1');
                    // ->whereNotNull('account_2');
    }

    public static function scopeFilterByAssignedAcountExtracurricular($query)
    {
        return $query->whereNotNull('account_2');
                    // ->whereNotNull('account_2');
    }
    public static function scopeFilterByAssignedAcountManagerExtracurricular($query)
    {
        return $query->whereNotNull('account_manager_extracurricular_id')->orWhereNotNull('account_2');
    }
    public static function scopeFilterByNotAssignedAcountManagerExtracurricular($query)
    {
        return $query->whereNull('account_manager_extracurricular_id')->whereNull('account_2'); 
    }
    public static function scopeFilterByNotAssignedAcountManagerAbroad($query)
    {
        return $query->whereNull('account_manager_abroad_id')->whereNull('account_1')->where('status','!=',self::STATUS_CANCEL); 
    }
    public static function scopeFilterByAssignedAcountManagerAbroad($query)
    {
        return $query->whereNotNull('account_manager_abroad_id')->orWhereNotNull('account_1');
    }
    public static function scopeFilterByAssignedAcountAbroad($query)
    {
        return $query->whereNotNull('account_1');
                    // ->whereNotNull('account_2');
    }
    public static function scopeFilterByWaiting($query){
        return $query->filterByAssignedAcountManagerAbroad()->whereNull('account_1');
    }

    public static function scopeFilterByWaitingExtracurricular($query){
        return $query->filterByAssignedAcountManagerExtracurricular()->whereNull('account_2');
    }

    public static function scopeFilterByWaitForApproval($query){
        return $query->filterByAssignedAcountManagerExtracurricular()->where('hsdt_status', self::STATUS_HSDT_WAIT_FOR_APPROVAL);
    }

    public static function scopeFilterByDone($query){
        return $query->filterByAssignedAcountManagerExtracurricular()->filterByAssignedAcount()->where('hsdt_status', self::STATUS_HSDT_APPROVED);
    }
    
    public static function scopeFilterByApproved($query)
    {
       return $query->where('hsdt_status', self::STATUS_HSDT_APPROVED);
    }
    public static function scopeFilterByCancel($query)
    {
       return $query->where('status', self::STATUS_CANCEL);
    }
    public static function scopeFilterByReserve($query)
    {
       return $query->where('status', self::STATUS_RESERVE);
    }
    public static function scopeFilterByUnreserve($query)
    {
       return $query->where('status', self::STATUS_UNRESERVE);
    }
    
    
    public static function scopeSearch($query, $keyword)
    {
        $query
            ->where('abroad_applications.created_at', 'LIKE', "%{$keyword}%")
            ->orWhere('abroad_applications.updated_at', 'LIKE', "%{$keyword}%")
            ->orWhere('abroad_applications.code', 'LIKE', "%{$keyword}%")
            ->orWhereHas('contact', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->where('name', $keyword)
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%");
            })
            ->orWhereHas('orderItem', function ($q2) use ($keyword) {
                $q2->whereHas('order', function ($q3) use ($keyword) {
                    $q3->where('code', 'like', "%{$keyword}%");
                });
            });
    }

    public static function scopeDestroyAll($query, $items)
    {
        self::whereIn('id', $items)->delete();
    }

    public static function scopeSelect2($query, $request)
    {
        // Thực hiện tìm kiếm dựa trên trường name trong bảng contacts
        if ($request->has('search')) {
            $query->whereHas('contact', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        // Thực hiện phân trang
        $applications = $query->paginate($request->per_page ?? 10);
    
        return [
            "results" => $applications->map(function ($app) {
                return [
                    'id' => $app->id,
                    'text' => $app->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $applications->lastPage() != $request->page,
            ],
        ];
    }
    
    public function getSelect2Text()
    {
        return '<strong>' . 'Mã hồ sơ: ' . $this->code . '</strong><div>' . $this->contact->name . '</div><div>' . $this->contact->email . '</div>';
    }

    public function countRecommendationLettersNotDeleted()
    {
        return RecommendationLetter::where('abroad_application_id', $this->id)
            ->where('status', '!=', RecommendationLetter::STATUS_DELETE)
            ->count();
    }

    public function getAllRecommendationLetterFiles($status)
    {
        $suffixUrl = '';

        if ($status == RecommendationLetter::STATUS_DRAFT) {
            $suffixUrl = self::SUFFIX_SAVE_DRAFT_LETTER_URL;
        } elseif ($status == RecommendationLetter::STATUS_ACTIVE) {
            $suffixUrl = self::SUFFIX_SAVE_ACTIVE_LETTER_URL;
        } else {
            throw new \Exception('Invalid status of recommendation letter file!');
        }

        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);

            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    // Save letter file
    public function uploadLetterFile($file, $status)
    {
        $suffixUrl = '';

        if ($status == RecommendationLetter::STATUS_DRAFT) {
            $suffixUrl = self::SUFFIX_SAVE_DRAFT_LETTER_URL;
        } elseif ($status == RecommendationLetter::STATUS_ACTIVE) {
            $suffixUrl = self::SUFFIX_SAVE_ACTIVE_LETTER_URL;
        } else {
            throw new \Exception('Invalid status of recommendation letter file!');
        }

        if (!$file) {
            throw new \Exception('file upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    // Delete letter file
    public function deleteRecommendationLetterFile($fileName, $status)
    {
        $suffixUrl = '';

        if ($status == RecommendationLetter::STATUS_DRAFT) {
            $suffixUrl = self::SUFFIX_SAVE_DRAFT_LETTER_URL;
        } elseif ($status == RecommendationLetter::STATUS_ACTIVE) {
            $suffixUrl = self::SUFFIX_SAVE_ACTIVE_LETTER_URL;
        } else {
            throw new \Exception('Invalid status of recommendation letter file!');
        }

        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('File not found!');
        }

        // Remove file
        unlink($filePath);
    }

    public function uploadRecommendationLetterFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'file' => 'required|mimes:docx,doc,pdf,txt'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadLetterFile($request->file('file'), $request->status);

        return $validator->errors();
    }

    public function deleteRecommendationLetterFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteRecommendationLetterFile($request->fileName, $request->status);

        return $validator->errors();
    }

    public function getAllCVFiles()
    {
        $suffixUrl = self::SUFFIX_SAVE_CV_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);
            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function getAllEssayResultFiles()
    {
        $suffixUrl = self::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);

            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    // Save CV file
    public function uploadCVFile($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_CV_URL;

        if (!$file) {
            throw new \Exception('CV upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    // Delete letter file
    public function deleteCVFile($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_CV_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('CV file not found!');
        }

        // Remove file
        unlink($filePath);
    }

    public function uploadCVFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadCVFile($request->file('file'));

        return $validator->errors();
    }

    public function deleteCVFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteCVFile($request->fileName);

        return $validator->errors();
    }

    public static function getAllDepositFeeStatus()
    {
        return [
            self::STATUS_DEPOSIT_SUCCESS,
            self::STATUS_DEPOSIT_WAITING
        ];
    }

    public static function getAllI20ApplicationStatus()
    {
        return [
            self::STATUS_I20_APPLICATION_WAIT,
            self::STATUS_I20_APPLICATION_PASS,
            self::STATUS_I20_APPLICATION_SLIP,
        ];
    }

    public static function getAllStudentVisaFeeStatus()
    {
        return [
            self::STATUS_VISA_WAIT,
            self::STATUS_VISA_PASS,
            self::STATUS_VISA_SLIP,
        ];
    }

    public function getAllDepositFiles()
    {
        $suffixUrl = self::SUFFIX_SAVE_DEPOSIT_FILE_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);

            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    // Save deposit file
    public function uploadDepositFile($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_DEPOSIT_FILE_URL;

        if (!$file) {
            throw new \Exception('File upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    // Delete deposit file
    public function deleteDepositFile($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_DEPOSIT_FILE_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('File not found!');
        }

        // Remove file
        unlink($filePath);
    }

    public function uploadDepositFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadDepositFile($request->file('file'));

        return $validator->errors();
    }

    public function deleteDepositFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteDepositFile($request->fileName);

        return $validator->errors();
    }

    public function saveDepositDataFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'deposit_cost' => 'nullable',
        ]);

        $cost = $request->deposit_cost;

        // Check if the input string contains alphabetic characters or non-numeric characters, if so, return an error.
        $validator->after(function ($validator) use ($cost, $request) {
            if ($request->deposit_status && $request->deposit_status == self::STATUS_DEPOSIT_SUCCESS) {
                if (!preg_match('/^[0-9,.]+$/', $cost)) {
                    $validator->errors()->add('deposit_cost', 'Phải có giá tiền và giá tiền phải là 1 số!');
                }

                if (intval(str_replace(array(".", ","), "", $cost)) == 0) {
                    $validator->errors()->add('deposit_cost', 'Giá tiền phải lớn hơn 0!');
                }
            } elseif (!$request->deposit_status || $request->deposit_status == self::STATUS_DEPOSIT_WAITING) {
                if (!empty($cost) && !preg_match('/^[0-9,.]+$/', $cost)) {
                    $validator->errors()->add('deposit_cost', 'Giá tiền không hợp lệ!');
                }
            }
        });

        if ($validator->fails()) {
            return $validator->errors();
        }

        $costRerendered = str_replace(array(".", ","), "", $cost);

        if ($request->has('deposit_cost')) {
            if (intval($costRerendered) == 0) {
                $this->deposit_cost = null;
            }

            $this->deposit_cost = intval($costRerendered);
        }

        if ($request->has('deposit_status')) {
            $this->deposit_status = $request->deposit_status;
        }

        $this->save();

        return $validator->errors();
    }

    public function getAllDepositSchools()
    {
        $suffixUrl = self::SUFFIX_SAVE_DEPOSIT_SCHOOL_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);

            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    // Save deposit file
    public function uploadDepositSchool($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_DEPOSIT_SCHOOL_URL;

        if (!$file) {
            throw new \Exception('File upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    // Delete deposit file
    public function deleteDepositSchool($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_DEPOSIT_SCHOOL_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('File not found!');
        }

        // Remove file
        unlink($filePath);
    }

    public function uploadDepositForSchoolFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadDepositSchool($request->file('file'));

        return $validator->errors();
    }

    public function deleteDepositForSchoolFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteDepositSchool($request->fileName);

        return $validator->errors();
    }

    public function saveDepositForSchoolFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'deposit_school_cost' => 'nullable',
        ]);

        $cost = $request->deposit_school_cost;

        if ($request->deposit_school_cost) {
            if (!preg_match('/^[0-9,.]+$/', $cost)) {
                $validator->errors()->add('deposit_school_cost', 'Phải có giá tiền và giá tiền phải là 1 số!');
            }

            if (intval(str_replace(array(".", ","), "", $cost)) == 0) {
                $validator->errors()->add('deposit_school_cost', 'Giá tiền phải lớn hơn 0!');
            }
        } 

        if ($validator->fails()) {
            return $validator->errors();
        }

        $costRerendered = str_replace(array(".", ","), "", $cost);

        if ($request->has('deposit_school_cost')) {
            if (intval($costRerendered) == 0) {
                $this->deposit_school_cost = null;
            }

            $this->deposit_school_cost = intval($costRerendered);
        }

        if ($request->has('deposit_school_date')) {
            $this->deposit_school_date = $request->deposit_school_date;
        }

        $this->save();

        return $validator->errors();
    }
    // public function isDoneExtracurricularSchedule()
    // {
    //     $activeSchedules = $this->extracurricularSchedules()->where('status', ExtracurricularSchedule::STATUS_ACTIVE)->count();

    //     // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
    //     return $activeSchedules > 0;
    // }
    // public function isDoneExtracurricularActivity()
    // {
    //     $activeActivitys = $this->extracurricularActivity()->where('status', ExtracurricularActivity::STATUS_ACTIVE)->count();

    //     // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
    //     return $activeActivitys > 0;
    // }

    // public function isDoneEssayResult()
    // {
    //     $suffixUrl = self::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;
    //     $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;

    //     if (!File::exists($path)) {
    //         return false;
    //     }

    //     $filesInFolder = File::files($path);
    //     $fileCount = count($filesInFolder);

    //     return $fileCount > 0;
    // }
    // public function isDoneApplicationFee()
    // {
    //     $fees = $this->applicationFees;

    //     if ($fees->isEmpty()) {
    //         return false;
    //     }

    //     foreach ($fees as $fee) {
    //         if (!$fee->completion_time) {
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    public function isDoneFlyingStudent()
    {
        $flyings = $this->flyingStudents;
    
        if ($flyings->isEmpty()) {
            return false;
        }
    
        foreach ($flyings as $flying) {
            if (!$flying->flight_date) {
                return false;
            }
        }
    
        return true;
    }
    
     // Hồ sơ tài chính
     public function deleteFinancialDocument($request)
     {
         $validator = Validator::make($request->all(), [
             'fileName' => 'required',
         ]);
 
         if ($validator->fails()) {
             return $validator->errors();
         }
 
         $this->deleteFinancialDocumentDone($request->fileName);
 
         return $validator->errors();
     }

     public function uploadFinancialDocument($file)
     {
         $suffixUrl = self::SUFFIX_SAVE_FINANCIAL_DOCUMENT_URL;
 
         if (!$file) {
             throw new \Exception('CV upload not found!');
         }
 
         $extension = $file->getClientOriginalName();
         $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
         $fileName = time() . '.' . $extension;
         $filePath = $path . '/' . $fileName;
 
         // Check & delete existing file
         if (File::exists($filePath)) {
             File::delete($filePath);
         }
 
         // Save file
         $file->move($path, $fileName);
     }

     public function getAllFinancialDocuments()
     {
         $suffixUrl = self::SUFFIX_SAVE_FINANCIAL_DOCUMENT_URL;
         $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
         $mediaPath = public_path() . $path;
 
         if (!is_dir($mediaPath)) {
             return [];
         }
 
         $filesInFolder = File::allFiles($mediaPath);
         $allPath = [];
 
         foreach ($filesInFolder as $path) {
             $fullPath = $path->getRealPath();
             $relativePath = str_replace(public_path(), '', $fullPath);
 
             $allPath[] = $relativePath;
         }
 
         return $allPath;
     }

     public function deleteFinancialDocumentDone($fileName)
     {
         $suffixUrl = self::SUFFIX_SAVE_FINANCIAL_DOCUMENT_URL;
         $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
         $filePath = public_path($path . $fileName);
 
         if (!file_exists($filePath)) {
             throw new \Exception('CV file not found!');
         }
 
         // Remove file
         unlink($filePath);
     }

     public function uploadFinancialDocumentFromRequest($request)
     {
         $validator = Validator::make($request->all(), [
             'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
         ]);
 
         if ($validator->fails()) {
             return $validator->errors();
         }
 
         $this->uploadFinancialDocument($request->file('file'));
 
         return $validator->errors();
     }

    // Hồ sơ hoàn chỉnh
    public function deleteCompleteFile($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteCompleteFileDone($request->fileName);

        return $validator->errors();
    }

    public function uploadCompleteFile($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_COMPLETE_FILE_URL;

        if (!$file) {
            throw new \Exception('CV upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    public function getAllCompleteFiles()
    {
        $suffixUrl = self::SUFFIX_SAVE_COMPLETE_FILE_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);

            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function deleteCompleteFileDone($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_COMPLETE_FILE_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('CV file not found!');
        }

        // Remove file
        unlink($filePath);
    }

    public function uploadCompleteFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadCompleteFile($request->file('file'));

        return $validator->errors();
    }

    // Hồ sơ hoàn chỉnh
    public function isDoneAdmissionLetter()
    {
        $suffixUrl = self::SUFFIX_SAVE_ADMISSION_LETTER_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;

        if (!File::exists($path)) {
            return false;
        }

        $filesInFolder = File::files($path);
        $fileCount = count($filesInFolder);

        return $fileCount > 0;
    }

    public function deleteAdmissionLetterFile($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteAdmissionLetterDone($request->fileName);

        return $validator->errors();
    }

    public function uploadAdmissionLetterFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadAdmissionLetter($request->file('file'));

        return $validator->errors();
    }

    public function uploadAdmissionLetter($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_ADMISSION_LETTER_URL;

        if (!$file) {
            throw new \Exception('CV upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    public function getAllAdmissionLetters()
    {
        $suffixUrl = self::SUFFIX_SAVE_ADMISSION_LETTER_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);
            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function deleteAdmissionLetterDone($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_ADMISSION_LETTER_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('CV file not found!');
        }

        // Remove file
        unlink($filePath);
    }


    // Bản scan thông tin cá nhân
    public function deleteScanOfInformationFile($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteScanOfInformationDone($request->fileName);

        return $validator->errors();
    }

    public function uploadScanOfInformationFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadScanOfInformation($request->file('file'));

        return $validator->errors();
    }

    public function uploadScanOfInformation($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_SCAN_OF_INFORMATION_URL;

        if (!$file) {
            throw new \Exception('CV upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    public function getAllScanOfInformation()
    {
        $suffixUrl = self::SUFFIX_SAVE_SCAN_OF_INFORMATION_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);
            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function deleteScanOfInformationDone($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_SCAN_OF_INFORMATION_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('CV file not found!');
        }

        // Remove file
        unlink($filePath);
    }

    // I20 application
    public function getAllI20ApplicationFiles()
    {
        $suffixUrl = self::SUFFIX_SAVE_I20_APPLICATION_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);
            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function saveI20ApplicationDataFromRequest($request)
    {
        if ($request->i20_application_status) {
            $this->i20_application_status = $request->i20_application_status;
        }

        $this->save();
    }

    public function uploadI20ApplicationFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadI20ApplicationFile($request->file('file'));

        return $validator->errors();
    }

    public function uploadI20ApplicationFile($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_I20_APPLICATION_URL;

        if (!$file) {
            throw new \Exception('File upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    public function deleteI20ApplicationFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteI20ApplicationFile($request->fileName);

        return $validator->errors();
    }

    public function deleteI20ApplicationFile($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_I20_APPLICATION_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('File not found!');
        }

        // Remove file
        unlink($filePath);
    }

    // visa student
    public function getAllStudentVisaFiles()
    {
        $suffixUrl = self::SUFFIX_SAVE_STUDENT_VISA_URL;
        $path = '/' . self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $mediaPath = public_path() . $path;

        if (!is_dir($mediaPath)) {
            return [];
        }

        $filesInFolder = File::allFiles($mediaPath);
        $allPath = [];

        foreach ($filesInFolder as $path) {
            $fullPath = $path->getRealPath();
            $relativePath = str_replace(public_path(), '', $fullPath);
            $allPath[] = $relativePath;
        }

        return $allPath;
    }

    public function saveVisaStudentDataFromRequest($request)
    {
        if ($request->student_visa_status) {
            $this->student_visa_status = $request->student_visa_status;
        }

        $this->save();
    }

    public function uploadStudentVisaFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:docx,doc,pdf,txt,jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadStudentVisaFile($request->file('file'));

        return $validator->errors();
    }

    public function uploadStudentVisaFile($file)
    {
        $suffixUrl = self::SUFFIX_SAVE_STUDENT_VISA_URL;

        if (!$file) {
            throw new \Exception('File upload not found!');
        }

        $extension = $file->getClientOriginalName();
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $fileName = time() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Check & delete existing file
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save file
        $file->move($path, $fileName);
    }

    public function deleteStudentVisaFileFromRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->deleteStudentVisaFile($request->fileName);

        return $validator->errors();
    }

    public function deleteStudentVisaFile($fileName)
    {
        $suffixUrl = self::SUFFIX_SAVE_STUDENT_VISA_URL;
        $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
        $filePath = public_path($path . $fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('File not found!');
        }

        // Remove file
        unlink($filePath);
    }

    public function assignToAbroadApplicatonTVCL($accountId)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->account_1 = $accountId;
            $this->save();
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    public function assignToAbroadApplicatonTTSK($accountId)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->account_2 = $accountId;
            $this->save();
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }

    //Danh sách trường yêu cầu tuyển sinh 
    public function doneAssignmentAbroadApplication($request)
    {
         // Begin transaction
         DB::beginTransaction();

         try {
            if(isset($request->account_id_1)){
                $this->account_1 = $request->account_id_1;
            }
            if(isset($request->account_id_2)){
                $this->account_2 = $request->account_id_2;
            }
            if(isset($request->account_manager_extracurricular_id)){
                $this->account_manager_extracurricular_id = $request->account_manager_extracurricular_id;
            }
            if(isset($request->account_manager_abroad_id)){
                $this->account_manager_abroad_id = $request->account_manager_abroad_id;
            }
            if(isset($request->account_manager_abroad_id)){
                if (isset($request->account_id_1)) {
                    throw new \Exception('Chỉ được chọn 1');
                }
            }
            
            $this->save();
         } catch (\Exception $e) {
             // Something went wrong, rollback the transaction
             DB::rollback();
 
             // Handle the exception or log the error
             // For example, you might throw the exception again to let it propagate
             throw $e;
         }
 
         // commit
         DB::commit();
    }
   
    public function getCoursesWithAbroadService($abroadServiceName)
    {
        return $this->courseStudents()
            ->whereHas('course', function ($query) use ($abroadServiceName) {
                $query->withAbroadService($abroadServiceName);
            })
            ->with('course')
            ->get()
            ->pluck('course');
    }

    ///Status 
    public function isDoneLoTrinhHTCL()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $loTrinhHTCL = $status->lo_trinh_ht_cl;

            if($loTrinhHTCL == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        }

        return false;
    }

    public function isDoneLoTrinhHDNK()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $loTrinhHDNK = $status->lo_trinh_hd_nk;

            if($loTrinhHDNK == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        }

        return false;
    }

    public function isDoneApplicationSchool()
    {
        $activeSchedules = $this->applicationSchool()->where('status', Certifications::STATUS_ACTIVE)->count();

        if( $activeSchedules > 0){
            return $activeSchedules > 0;
        } else {
            $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

            if ($status !== null) {
                $applicationSchool = $status->application_school;
                if($applicationSchool == AbroadApplicationStatus::STATUS_DONE){
                    return true;
                }
            }    
        }
        
        return false;
    }

    public function isDoneExtracurricularSchedule()
    {
        $activeSchedules = $this->extracurricularSchedules()->where('status', ExtracurricularSchedule::STATUS_ACTIVE)->count();
        if( $activeSchedules > 0){
            // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
            return $activeSchedules > 0;
        } else {
            $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

            if ($status !== null) {
                $extracurricularSchedule = $status->extracurricular_schedule;

                if($extracurricularSchedule == AbroadApplicationStatus::STATUS_DONE){
                    return true;
                }
            }    
        }

        return false;
    }

    public function isDoneCertification()
    {
        $activeSchedules = $this->certification()->where('status', Certifications::STATUS_ACTIVE)->count();
        // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
        if($activeSchedules > 0){
            return $activeSchedules > 0;
        } else {
            $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

            if ($status !== null) {
                $certification = $status->certificate;
                if($certification == AbroadApplicationStatus::STATUS_DONE){
                    return true;
                }
            }    

        }

        return false;
    }

    public function isDoneExtracurricularActivity()
    {
        $activeActivitys = $this->extracurricularActivity()->where('status', ExtracurricularActivity::STATUS_ACTIVE)->count();

        // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
        if( $activeActivitys > 0){
            return $activeActivitys > 0;

        }else {
            $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

            if ($status !== null) {
                $extracurricularActivity = $status->extracurricular_activity;
                if($extracurricularActivity == AbroadApplicationStatus::STATUS_DONE){
                    return true;
                }
            }    
        }

        return false;
    }

    public function isDoneRecommendationLetter()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $recommendationLetters = $status->recommendation_letters;

            if($recommendationLetters == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $suffixUrl = self::SUFFIX_SAVE_ACTIVE_LETTER_URL;
            $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
    
            if (!File::exists($path)) {
                return false;
            }
    
            $filesInFolder = File::files($path);
            $fileCount = count($filesInFolder);
    
            return $fileCount > 0;
        }
    }

    public function isDoneEssayResult()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $essayResults = $status->essay_results;
            if($essayResults == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $suffixUrl = self::SUFFIX_SAVE_ESSAY_RESULT_FILE_URL;
            $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;

            if (!File::exists($path)) {
                return false;
            }

            $filesInFolder = File::files($path);
            $fileCount = count($filesInFolder);

            return $fileCount > 0;
        }
    }

    public function isDoneSocialNetwork()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $socialNetwork = $status->social_network;

            if($socialNetwork == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $activeSchedules = $this->socialNetwork()->where('status', SocialNetwork::STATUS_ACTIVE)->count();

            // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
            return $activeSchedules > 0;
        }
    }

    public function isDoneFinancialDocument()
     {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $financialDocument = $status->financial_document;

            if($financialDocument == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $suffixUrl = self::SUFFIX_SAVE_FINANCIAL_DOCUMENT_URL;
            $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
    
            if (!File::exists($path)) {
                return false;
            }
    
            $filesInFolder = File::files($path);
            $fileCount = count($filesInFolder);
    
            return $fileCount > 0;
        }
     }

     public function isDoneCV()
     {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $studentCv = $status->student_cv;

            if($studentCv == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $suffixUrl = self::SUFFIX_SAVE_CV_URL;
            $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;
    
            if (!File::exists($path)) {
                return false;
            }
    
            $filesInFolder = File::files($path);
            $fileCount = count($filesInFolder);
    
            return $fileCount > 0;
        }
    }

    public function isDoneStudyAbroadApplication()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $studyAbroadApplications = $status->study_abroad_applications;

            if($studyAbroadApplications == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $activeSchedules = $this->studyAbroadApplications()->where('status', StudyAbroadApplication::STATUS_ACTIVE)->count();

            // Nếu có ít nhất một lịch trình ngoại khóa đang active, trả về true
            return $activeSchedules > 0;
        }
    }

    public function isDonecompleteFile()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $completeFile = $status->complete_file;

            if($completeFile == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $suffixUrl = self::SUFFIX_SAVE_COMPLETE_FILE_URL;
            $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;

            if (!File::exists($path)) {
                return false;
            }

            $filesInFolder = File::files($path);
            $fileCount = count($filesInFolder);

            return $fileCount > 0;
        }
    }
    public function isDoneRecruitmentResults()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $admissionLetter = $status->admission_letter;

            if($admissionLetter == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $activeSchedules = $this->applicationSchool()->where('status_recruitment_results', ApplicationSchool::STATUS_ACTIVE)->count();
            
            return $activeSchedules > 0;
        }
    }

    public function isDoneScanOfInformation()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $scanOfInformation = $status->scan_of_information;

            if($scanOfInformation == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $suffixUrl = self::SUFFIX_SAVE_SCAN_OF_INFORMATION_URL;
            $path = self::PREFIX_SAVE_FILE_URL . $this->id . '/' . $suffixUrl;

            if (!File::exists($path)) {
                return false;
            }

            $filesInFolder = File::files($path);
            $fileCount = count($filesInFolder);

            return $fileCount > 0;
        }
    }

    public function isDoneApplicationFee()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $applicationFees = $status->application_fees;

            if($applicationFees == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        } else {
            $fees = $this->applicationFees;

            if ($fees->isEmpty()) {
                return false;
            }

            foreach ($fees as $fee) {
                if (!$fee->completion_time) {
                    return false;
                }
            }

            return true;
        }
    }

    public function isDoneDepositForSchool()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $depositForSchool = $status->deposit_for_school;

            if($depositForSchool == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        }

        return false;
    }

    public function isDoneCulturalOrientation()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $culturalOrientation = $status->cultural_orientation;

            if($culturalOrientation == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        }

        return false;
    }

    public function isDoneSupportActivity()
    {
        $status = AbroadApplicationStatus::where('abroad_application_id', $this->id)->first();

        if ($status !== null) {
            $supportActivity = $status->support_activity;

            if($supportActivity == AbroadApplicationStatus::STATUS_DONE){
                return true;
            }
        }

        return false;
    }

    public function isCheckStatus()
    {
        if( !$this->isDoneLoTrinhHTCL() ){
            return false;
        } 

        if( !$this->isDoneLoTrinhHDNK() ){
            return false;
        }  

        if( !$this->isDoneApplicationSchool() ){
            return false;
        }  

        if( !$this->isDoneExtracurricularSchedule() ){
            return false;
        }  

        if( !$this->isDoneCertification() ){
            return false;
        }  

        if( !$this->isDoneExtracurricularActivity() ){
            return false;
        }  

        if( !$this->isDoneRecommendationLetter() ){
            return false;
        }  

        if( !$this->isDoneEssayResult() ){
            return false;
        }  

        if( !$this->isDoneSocialNetwork() ){
            return false;
        }  

        if( !$this->isDoneFinancialDocument() ){
            return false;
        }  

        if( !$this->isDoneCV() ){
            return false;
        }  

        if( !$this->isDoneStudyAbroadApplication() ){
            return false;
        }  

        if( !$this->isDonecompleteFile() ){
            return false;
        }  

        if( !$this->isDoneRecruitmentResults() ){
            return false;
        }  

        if( !$this->isDoneScanOfInformation() ){
            return false;
        }  

        if( !$this->isDoneApplicationFee() ){
            return false;
        }  

        if( !$this->isDoneDepositForSchool() ){
            return false;
        }  

        if( !$this->isDoneSupportActivity() ){
            return false;
        } 
        
        if( !$this->isDoneCulturalOrientation() ){
            return false;
        } 

        if( $this->hsdt_status !== self::STATUS_HSDT_APPROVED ){
            return false;
        } 
         
        return true;
    }

    public function isCheckStatusHSDT()
    {
        if( !$this->isDoneLoTrinhHTCL() ){
            return false;
        } 

        if( !$this->isDoneLoTrinhHDNK() ){
            return false;
        }  

        if( !$this->isDoneApplicationSchool() ){
            return false;
        }  

        if( !$this->isDoneExtracurricularSchedule() ){
            return false;
        }  

        if( !$this->isDoneCertification() ){
            return false;
        }  

        if( !$this->isDoneExtracurricularActivity() ){
            return false;
        }  

        if( !$this->isDoneRecommendationLetter() ){
            return false;
        }  

        if( !$this->isDoneEssayResult() ){
            return false;
        }  

        if( !$this->isDoneSocialNetwork() ){
            return false;
        }  

        if( !$this->isDoneFinancialDocument() ){
            return false;
        }  

        if( !$this->isDoneCV() ){
            return false;
        }  

        if( !$this->isDoneStudyAbroadApplication() ){
            return false;
        }  
         
        return true;
    }
   
    public function progress($number)
    {
        if($number == 4){
            $progress = 0;

            if( $this->isDoneLoTrinhHTCL() ){
                 $progress += 6.25;
            } 
            
            if( $this->isDoneLoTrinhHDNK() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneApplicationSchool() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneExtracurricularSchedule() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneCertification() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneExtracurricularActivity() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneRecommendationLetter() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneEssayResult() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneSocialNetwork() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneFinancialDocument() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneCV() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneStudyAbroadApplication() ){
                 $progress += 6.25;
            }  

            if( $this->isDonecompleteFile() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneApplicationFee() ){
                 $progress += 6.25;
            }  

            if( $this->isDoneScanOfInformation() ){
                 $progress += 6.25;
            }
            
            if( $this->hsdt_status == self::STATUS_HSDT_APPROVED ){
                $progress += 6.25;
            } 
           
            return $progress;
        }

        if($number == 5){
            $progress = 0;

            if( $this->isDoneRecruitmentResults() ){
                 $progress += 100;
            } 
            
            return $progress;
        }

        if($number == 6){
            $progress = 0;

            if(  $this->deposit_status = self::STATUS_DEPOSIT_SUCCESS ){
                 $progress += 16.67;
            } 

            if(  $this->isDoneDepositForSchool() ){
                $progress += 16.67;
            }
            
            if(  $this->student_visa_status = self::STATUS_VISA_PASS ){
                $progress += 16.67;
            }

            if(  $this->isDoneSupportActivity() ){
                $progress += 16.67;
            }

            if(  $this->isDoneCulturalOrientation() ){
                $progress += 16.66;
            }

            if( $this->status == self::STATUS_APPROVED ){
                $progress += 16.66;
           } 

            return $progress;
        }
       
        return 0;
    }

    public function getOrderCode(){
        return $this->orderItem->order->getCode();
    }

    public function grades()
    {
        $grades = [
            isset($this->grade_1) ? ['gpa' => Gpa::find($this->grade_1), 'point' => $this->point_1] : null,
            isset($this->grade_2) ? ['gpa' => Gpa::find($this->grade_2), 'point' => $this->point_2] : null,
            isset($this->grade_3) ? ['gpa' => Gpa::find($this->grade_3), 'point' => $this->point_3] : null,
            isset($this->grade_4) ? ['gpa' => Gpa::find($this->grade_4), 'point' => $this->point_4] : null,
        ];

        $grades = array_filter($grades);
        $result = array_filter($grades, fn ($grade) => !is_null($grade['gpa']));
        
        return $result;
    }   

    public function academicAwards()
    {
        $academicAwards = [
            isset($this->academic_award_1) && $this->academic_award_1 ? ['academicAward' => AcademicAward::find($this->academic_award_1), 'academicAwardText' => $this->academic_award_text_1] : null,
            isset($this->academic_award_2) && $this->academic_award_2 ? ['academicAward' => AcademicAward::find($this->academic_award_2), 'academicAwardText' => $this->academic_award_text_2] : null,
            isset($this->academic_award_3) && $this->academic_award_3 ? ['academicAward' => AcademicAward::find($this->academic_award_3), 'academicAwardText' => $this->academic_award_text_3] : null,
            isset($this->academic_award_4) && $this->academic_award_4 ? ['academicAward' => AcademicAward::find($this->academic_award_4), 'academicAwardText' => $this->academic_award_text_4] : null,
            isset($this->academic_award_5) && $this->academic_award_5 ? ['academicAward' => AcademicAward::find($this->academic_award_5), 'academicAwardText' => $this->academic_award_text_5] : null,
            isset($this->academic_award_6) && $this->academic_award_6 ? ['academicAward' => AcademicAward::find($this->academic_award_6), 'academicAwardText' => $this->academic_award_text_6] : null,
            isset($this->academic_award_7) && $this->academic_award_7 ? ['academicAward' => AcademicAward::find($this->academic_award_7), 'academicAwardText' => $this->academic_award_text_7] : null,
            isset($this->academic_award_8) && $this->academic_award_8 ? ['academicAward' => AcademicAward::find($this->academic_award_8), 'academicAwardText' => $this->academic_award_text_8] : null,
            isset($this->academic_award_9) && $this->academic_award_9 ? ['academicAward' => AcademicAward::find($this->academic_award_9), 'academicAwardText' => $this->academic_award_text_9] : null,
            isset($this->academic_award_10) && $this->academic_award_10 ? ['academicAward' => AcademicAward::find($this->academic_award_10), 'academicAwardText' => $this->academic_award_text_10] : null,
        ];

        $academicAwards = array_filter($academicAwards);
        $result = array_filter($academicAwards, fn ($academic) => !is_null($academic['academicAward']));
        
        return $result; 
    }

    public function extraActivities()
    {
        $activities = [
            isset($this->extra_activity_1) && $this->extra_activity_1 ? ['extraActivity' => ExtraActivity::find($this->extra_activity_1), 'extraActivityText' => $this->extra_activity_text_1] : null, 
            isset($this->extra_activity_2) && $this->extra_activity_2 ? ['extraActivity' => ExtraActivity::find($this->extra_activity_2), 'extraActivityText' => $this->extra_activity_text_2] : null, 
            isset($this->extra_activity_3) && $this->extra_activity_3 ? ['extraActivity' => ExtraActivity::find($this->extra_activity_3), 'extraActivityText' => $this->extra_activity_text_3] : null, 
            isset($this->extra_activity_4) && $this->extra_activity_4 ? ['extraActivity' => ExtraActivity::find($this->extra_activity_4), 'extraActivityText' => $this->extra_activity_text_4] : null, 
            isset($this->extra_activity_5) && $this->extra_activity_5 ? ['extraActivity' => ExtraActivity::find($this->extra_activity_5), 'extraActivityText' => $this->extra_activity_text_5] : null, 
        ];

        $activities = array_filter($activities);
        $result = array_filter($activities, fn ($activity) => !is_null($activity['extraActivity']));

        return $result;
    }

    public function intendedMajor()
    {
        return $this->belongsTo(IntendedMajor::class);
    }

    public function currentProgram()
    {
        return $this->belongsTo(CurrentProgram::class);
    }

    public function planApplyProgram()
    {
        return $this->belongsTo(PlanApplyProgram::class);
    }

    public function getOrder(){
        return $this->orderItem->order;
    }
    public static function scopeByBranch($query, $branch)
    {
        $query =  $query->whereHas('orderItem', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->where('abroad_branch', $branch);
            }
        });
        return $query;
    }

    public static function getStatusAbroad()
    {
        return self::pluck('hsdt_status')->map(function ($abroadStatus) {
            $label = '';
            switch ($abroadStatus) {
                case 'new':
                    $label = 'Chưa hoàn thành';
                    break;
                case 'wait_for_approval':
                    $label = 'Chờ duyệt';
                    break;
                case 'approved':
                    $label = 'Hoàn thành';
                    break;
                case 'rejected':
                    $label = 'Từ chối duyệt';
                    break;
            }
    
            return [
                'value' => $abroadStatus,
                'label' => $label,
            ];
        })->unique()->values();
    }

    public function scopeByFinancialCapabilitys($query, array $financialCapabilitys)
    {
        $query = $query->whereIn('abroad_applications.financial_capability', $financialCapabilitys);
    }
    
    public static function financialCapabilitySelect2($request)
    {
        $query = self::whereNot('financial_capability', null)->whereNot('financial_capability', '')->groupBy('financial_capability');
        // search
        if ($request->search) {
            $query = self::where(function($q) use ($request) {
                $q->where('financial_capability', 'LIKE', "%$request->search%");
            });
        }

        // pagination
        $records = $query->select('financial_capability')->paginate($request->per_page ?? '10');

        return [
            "results" => $records->map(function ($record) {
                return [
                    'id' => $record->financial_capability,
                    'text' => $record->financial_capability,
                ];
            })->toArray(),
            "pagination" => [
                "more" => $records->lastPage() != $request->page,
            ],
        ];
    }

    public function scopeThesisPort($query)
    {
        $query->whereHas('orderItem', function($q) {
            $q->where('type', Order::TYPE_ABROAD)
              ->where('is_thesis_port', true);
        });
    }

    public function scopeExtraPort($query)
    {
        $query->whereHas('orderItem', function($q) {
            $q->where('type', Order::TYPE_ABROAD)
              ->where('is_extra_port', true);
        });
    }
}
