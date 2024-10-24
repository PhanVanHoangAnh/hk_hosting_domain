<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Helpers\Functions;

use Validator;

class OrderItem extends Model
{
    use HasFactory;

    public const TYPE_EDU = 'edu';
    public const TYPE_DEMO = 'demo';
    public const TYPE_EXTRACURRICULAR = 'extracurricular';
    public const ENROLLED = 'Đã xếp lớp';
    public const NOTENROLLED = 'Chờ xếp lớp';
    public const TYPE_ABROAD = 'abroad';

    public const STATUS_TRANSFER = 'transfer';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_REFUND = 'refund';

    // Class type
    public const ORDER_ITEM_TYPE_ONE_ONE = '1:1';
    public const ORDER_ITEM_TYPE_GROUP = 'Nhóm';

    public const ABROAD_BRANCH_HN = 'hn';
    public const ABROAD_BRANCH_SG = 'sg';

    public const PORT_TYPE_THESIS = 'thesis';
    public const PORT_TYPE_EXTRA = 'extracurricular';

    protected $fillable = [
        'order_id',
        'subject_id',
        'type',
        'order_type',
        'price',
        'level',
        'class_type',
        'num_of_student',
        'study_type',
        'vietnam_teacher',
        'foreign_teacher',
        'tutor_teacher',
        'vietnam_teacher_minutes_per_section',
        'foreign_teacher_minutes_per_section',
        'tutor_minutes_per_section',
        'num_of_vn_teacher_sections',
        'num_of_foreign_teacher_sections',
        'num_of_tutor_sections',
        'target',
        'home_room',
        'training_location_id',

        'abroad_service_id',
        'apply_time',
        'current_program',
        'GPA',
        'std_score',
        'eng_score',
        'intended_major',
        'academic_award',
        'postgraduate_plan',
        'personality',
        'subject_preference',
        'language_culture',
        'research_info',
        'aim',
        'essay_writing_skill',
        'extra_activity',
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
        'estimated_enrollment_time',
        'top_school',
        'vn_teacher_price',
        'foreign_teacher_price',
        'tutor_price',
        'status',
        'extracurricular_id',
        'current_program_id',
        'plan_apply_program_id',
        'intended_major_id',

        'is_share',

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
        'abroad_branch',
        'import_id',
        'real_top_school_deal',
        'is_thesis_port',
        'is_extra_port',
    ];

    // public function __construct(array $attributes = [])
    // {
    //     $excelFile = new ExcelData();
    //     $datas = $excelFile->getDataFromSheet(ExcelData::ACADEMIC_AWARDS_SHEET_NAME, 2);

    //     parent::__construct($attributes);

    //     $this->addFillableFields($datas);
    // }

    // private function addFillableFields($fields)
    // {
    //     $this->fillable = array_merge($this->fillable, $fields);
    // }

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
    public function revenues()
    {
        return $this->hasMany(RevenueDistribution::class, 'order_item_id');
    }

    public static function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->whereHas('orders.contacts', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%");
            })
                ->orWhereHas('subject', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })

                ->orWhere('home_room', 'LIKE', "%{$keyword}%");
        });
    }

    public function demoItemSubtracts()
    {
        return $this->hasMany(OrderItemDemo::class, 'demo_order_item_id');
    }

    public function trainItemSubtracts()
    {
        return $this->hasMany(OrderItemDemo::class, 'order_item_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function homeRoom()
    {
        return $this->belongsTo(Teacher::class, 'home_room');
    }

    public function abroadService()
    {
        return $this->belongsTo(AbroadService::class, 'abroad_service_id');
    }

    public function course()
    {
        return $this->hasOne(Course::class);
    }

    public static function scopeFilterByOrderType($query, $orderType)
    {
        $query = $query->whereIn('order_type', $orderType);
    }

    public static function scopeFilterByHomeRoom($query, $homeRoom)
    {
        $query = $query->whereIn('home_room', $homeRoom);
    }

    public static function scopefilterByClassRoom($query, $classRoom)
    {
        $query->whereHas('courseStudent.course', function ($q) use ($classRoom) {
            $q->whereIn('code', $classRoom);
        });
    }

    public static function scopeFilterByBranchName($query, $branchName)
    {
        $query->whereHas('training_location', function ($q) use ($branchName) {
            $q->where('branch', $branchName);
        });
    }

    public static function scopeFilterByLocationName($query, $locationName)
    {
        $query->whereHas('training_location', function ($q) use ($locationName) {
            $q->where('name', $locationName);
        });
    }

    public static function scopeFilterBySubjectName($query, $subjectName)
    {
        return $query->whereIn('subject_id', function ($subQuery) use ($subjectName) {
            $subQuery->select('id')
                ->from('subjects')
                ->whereIn('name', $subjectName);
        });
    }

    public static function scopeFilterByLevel($query, $level)
    {
        $query = $query->whereIn('level', $level);
    }

    public static function scopeFilterByStudent($query, $student)
    {
        $query->whereHas('orders.contacts', function ($q) use ($student) {
            $q->whereIn('name', $student);
        });
    }

    public static function  scopeFilterBySuitableClassLess($query)
    {
        $query->where(function ($q) use ($query) {

            foreach ($query->get() as $orderItem) {
                $courseCount = Course::getCoursesBySubjects($orderItem->subject->name, $orderItem->getStudent()->id, $orderItem)->count();
                if ($courseCount > 0) {
                    $q->where('order_items.id', '!=', $orderItem->id);
                }
            }
        });
    }

    public static function  scopeFilterBySuitableClassGreater($query)
    {
        $query->where(function ($q) use ($query) {

            foreach ($query->get() as $orderItem) {
                $courseCount = Course::getCoursesBySubjects($orderItem->subject->name, $orderItem->getStudent()->id, $orderItem)->count();
                if ($courseCount <= 0) {
                    $q->where('order_items.id', '!=', $orderItem->id);
                }
            }
        });
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from)) {
            $query->where('order_items.created_at', '>=', \Carbon\Carbon::parse($created_at_from)->startOfDay());
        }

        if (!empty($created_at_to)) {
            $query->where('order_items.created_at', '<=', \Carbon\Carbon::parse($created_at_to)->endOfDay());
        }

        return $query;
    }

    public function reserve()
    {
        return $this->hasMany(Reserve::class, 'order_item_id');
    }

    public static function scopeGetAllOrderTypeEdu()
    {
        $orderType = \App\Models\ContactRequest::pluck('list')->toArray();
        $orderType = array_unique($orderType);
        $orderType = array_values($orderType);
        $orderType = array_filter($orderType, function ($item) {
            return $item !== null;
        });

        return $orderType;
    }

    public static function findListClass()
    {
        $query = self::query();
        return $query;
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function training_location()
    {
        return $this->belongsTo(TrainingLocation::class, 'training_location_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public static function newDefault()
    {
        $orderItem = new self();

        return $orderItem;
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());
        $this->price = isset($this->price) ? preg_replace('/[^0-9]/', '', $request->price) : null;
        $this->status = 'active';
        
        // if ($request->type == Order::TYPE_EDU) {
        //     if ($request->level) {
        //         $currentSubject = Subject::find($request->subject_id);

        //         if (!$currentSubject) throw new \Exception("Cannot find subject with id = " . $request->subject_id . "!");

        //         $subject = Subject::query()->hasName($currentSubject->name)->hasLevel($request->level)->first();

        //         if (!$subject) throw new \Exception("Cannot find subject with name = " . $currentSubject->name . " and level = " . $request->level . "!");

        //         $this->subject_id = $subject->id;
        //     }
        // }

        DB::beginTransaction();

        try {
            // Validator rule for edu item
            $validatorRules = [
                'order_id' => 'required',
                'class_type' => 'required',
                'num_of_student' => ['required', 'numeric', 'min:1'],
                'vietnam_teacher' => ['nullable', 'integer', 'min:1'],
                'foreign_teacher' => ['nullable', 'integer', 'min:1'],
                'tutor_teacher' => ['nullable', 'integer', 'min:1'],
                'study_type' => 'required',
                'training_location_id' => 'required',
                'subject_type' => 'required',
            ];

            // Validator rule for abroad item
            $abroadValidatorRules = [
                'order_id' => 'required',
                'apply_time' => 'required',
                'plan_apply_program_id' => 'required',
                'std_score' => 'nullable|numeric',
                'eng_score' => 'nullable|numeric',
                'financial_capability' => 'required',
                'estimated_enrollment_time' => 'required',
                'price' => 'required',
                'abroad_branch' => 'required',
            ];

            $extraValidatorRules = [
                'order_id' => 'required',
                'extracurricular_id' => 'required',
                'price' => 'required',
            ];

            if ($request->type == Order::TYPE_EDU) {
                $validatorRules['subject_id'] = 'required';
                $validatorRules['num_of_vn_teacher_sections'] = 'nullable|integer|min:0';
                $validatorRules['num_of_foreign_teacher_sections'] = 'nullable|integer|min:0';
                $validatorRules['num_of_tutor_sections'] = 'nullable|integer|min:0';
                $validatorRules['vietnam_teacher_minutes_per_section'] = 'nullable|integer|min:0';
                $validatorRules['foreign_teacher_minutes_per_section'] = 'nullable|integer|min:0';
                $validatorRules['tutor_minutes_per_section'] = 'nullable|integer|min:0';
            } elseif ($request->type == Order::TYPE_ABROAD) {
                $validatorRules = $abroadValidatorRules;
            } elseif ($request->type == Order::TYPE_EXTRACURRICULAR) {
                $validatorRules = $extraValidatorRules;
            } else {
                $validatorRules['num_of_student'] = 'nullable';
            }

            $validator = Validator::make($request->all(), $validatorRules);

            // Validate time & price table in case train item
            if ($request->type == Order::TYPE_EDU) {
                $validator->after(function ($validator) use ($request) {
                    if ($request->vn_teacher_price !== "") {
                        $vnPrice = preg_replace('/[^0-9]/', '', $request->vn_teacher_price);

                        if (intval($vnPrice) < 0 && $request->vn_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên Việt Nam không được bé hơn 0!");
                        }

                        if (intval($vnPrice) > 1000000000 && $request->vn_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên Việt Nam quá lớn, không hợp lý!");
                        }

                        if (!is_numeric(intval($vnPrice)) && $request->vn_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên Việt Nam không hợp lệ!");
                        }

                        if (
                            intval($vnPrice) > 0 &&
                            (is_null($request->num_of_vn_teacher_sections) ||
                                is_null($request->vietnam_teacher_minutes_per_section) ||
                                intval($request->num_of_vn_teacher_sections) === 0 ||
                                intval($request->vietnam_teacher_minutes_per_section) === 0)
                        ) {
                            $validator->errors()->add('custom_validate_price_staff', "Có giá dịch vụ của giáo viên Việt Nam nhưng chưa điền đủ thông tin!");
                        }

                        $this->vn_teacher_price = intval($vnPrice);
                    }

                    if ($request->foreign_teacher_price !== "") {
                        $foreignPrice = preg_replace('/[^0-9]/', '', $request->foreign_teacher_price);

                        if (intval($foreignPrice) < 0 && $request->foreign_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên nước ngoài không được bé hơn 0!");
                        }

                        if (!is_numeric(intval($foreignPrice)) && $request->foreign_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên nước ngoài không hợp lệ!");
                        }

                        if (
                            intval($foreignPrice) > 0 &&
                            (is_null($request->num_of_foreign_teacher_sections) ||
                                is_null($request->foreign_teacher_minutes_per_section) ||
                                intval($request->num_of_foreign_teacher_sections) === 0 ||
                                intval($request->foreign_teacher_minutes_per_section) === 0)
                        ) {
                            $validator->errors()->add('custom_validate_price_staff', "Có giá dịch vụ của giáo viên nước ngoài nhưng chưa điền đủ thông tin!");
                        }

                        $this->foreign_teacher_price = intval($foreignPrice);
                    }

                    if ($request->tutor_price !== "") {
                        $tutorPrice = preg_replace('/[^0-9]/', '', $request->tutor_price);

                        if (intval($tutorPrice) < 0 && $request->tutor_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của gia sư không được bé hơn 0!");
                        }

                        if (!is_numeric(intval($tutorPrice)) && $request->tutor_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của gia sư không hợp lệ!");
                        }

                        if (
                            intval($tutorPrice) > 0 &&
                            (is_null($request->num_of_tutor_sections) ||
                                is_null($request->tutor_minutes_per_section) ||
                                intval($request->num_of_tutor_sections) === 0 ||
                                intval($request->tutor_minutes_per_section) === 0)
                        ) {
                            $validator->errors()->add('custom_validate_price_staff', "Có giá dịch vụ của gia sư nhưng chưa điền đủ thông tin!");
                        }

                        $this->tutor_price = intval($tutorPrice);
                    }
                });
            }

            if ($request->type == Order::TYPE_REQUEST_DEMO) {
                $validator->after(function ($validator) use ($request) {
                    if ($request->vn_teacher_price !== "") {
                        $vnPrice = preg_replace('/[^0-9]/', '', $request->vn_teacher_price);

                        if (intval($vnPrice) < 0 && $request->vn_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên Việt Nam không được bé hơn 0!");
                        }

                        if (intval($vnPrice) > 1000000000 && $request->vn_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên Việt Nam quá lớn, không hợp lý!");
                        }

                        if (!is_numeric(intval($vnPrice)) && $request->vn_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên Việt Nam không hợp lệ!");
                        }

                        if (
                            intval($vnPrice) > 0 &&
                            (is_null($request->num_of_vn_teacher_sections) ||
                             is_null($request->vietnam_teacher_minutes_per_section) ||
                             intval($request->num_of_vn_teacher_sections) === 0 ||
                             intval($request->vietnam_teacher_minutes_per_section) === 0)
                        ) {
                            $validator->errors()->add('custom_validate_price_staff', "Có giá dịch vụ của giáo viên Việt Nam nhưng chưa điền đủ thông tin!");
                        }

                        $this->vn_teacher_price = intval($vnPrice);
                    }

                    if ($request->foreign_teacher_price !== "") {
                        $foreignPrice = preg_replace('/[^0-9]/', '', $request->foreign_teacher_price);

                        if (intval($foreignPrice) < 0 && $request->foreign_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên nước ngoài không được bé hơn 0!");
                        }

                        if (!is_numeric(intval($foreignPrice)) && $request->foreign_teacher_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của giáo viên nước ngoài không hợp lệ!");
                        }

                        if (
                            intval($foreignPrice) > 0 &&
                            (is_null($request->num_of_foreign_teacher_sections) ||
                             is_null($request->foreign_teacher_minutes_per_section) ||
                             intval($request->num_of_foreign_teacher_sections) === 0 ||
                             intval($request->foreign_teacher_minutes_per_section) === 0)
                        ) {
                            $validator->errors()->add('custom_validate_price_staff', "Có giá dịch vụ của giáo viên nước ngoài nhưng chưa điền đủ thông tin!");
                        }

                        $this->foreign_teacher_price = intval($foreignPrice);
                    }

                    if ($request->tutor_price !== "") {
                        $tutorPrice = preg_replace('/[^0-9]/', '', $request->tutor_price);

                        if (intval($tutorPrice) < 0 && $request->tutor_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của gia sư không được bé hơn 0!");
                        }

                        if (!is_numeric(intval($tutorPrice)) && $request->tutor_price !== "") {
                            $validator->errors()->add('custom_validate_price_staff', "Tiền lương của gia sư không hợp lệ!");
                        }

                        if (
                            intval($tutorPrice) > 0 &&
                            (is_null($request->num_of_tutor_sections) ||
                             is_null($request->tutor_minutes_per_section) ||
                             intval($request->num_of_tutor_sections) === 0 ||
                             intval($request->tutor_minutes_per_section) === 0)
                        ) {
                            $validator->errors()->add('custom_validate_price_staff', "Có giá dịch vụ của gia sư nhưng chưa điền đủ thông tin!");
                        }

                        $this->tutor_price = intval($tutorPrice);
                    }
                });
            }

            if ($request->type == Order::TYPE_EXTRACURRICULAR) {
                $validator->after(function ($validator) use ($request) {
                    if (!self::convertStringPriceToNumber($request->price)) {
                        $validator->errors()->add('price', "Giá tiền dịch vụ không hợp lệ!");
                    }

                    if (!Extracurricular::find($request->extracurricular_id)) {
                        $validator->errors()->add('extracurricular_id', "Có lỗi xảy ra, hoạt động ngoại khóa không hợp lệ!");
                    }
                });

                $this->price = \App\Helpers\Functions::convertStringPriceToNumber($request->price);
            }

            // Validate time & price table in case demo item
            if ($request->type == Order::TYPE_REQUEST_DEMO) {
                $validator->after(function ($validator) use ($request) {
                    // Vn teacher
                    if ((!is_null($request->num_of_vn_teacher_sections) || intval($request->num_of_vn_teacher_sections) > 0) && is_null($request->vietnam_teacher_minutes_per_section)) {
                        $validator->errors()->add('custom_validate_price_staff', "Chưa nhập đủ thông tin của giáo viên Việt Nam!");
                    }

                    if (is_null($request->num_of_vn_teacher_sections) && (!is_null($request->vietnam_teacher_minutes_per_section) || intval($request->vietnam_teacher_minutes_per_section) > 0)) {
                        $validator->errors()->add('custom_validate_price_staff', "Chưa nhập đủ thông tin của giáo viên Việt Nam!");
                    }

                    // Foreign teacher
                    if ((!is_null($request->num_of_foreign_teacher_sections) || intval($request->num_of_foreign_teacher_sections) > 0) && is_null($request->foreign_teacher_minutes_per_section)) {
                        $validator->errors()->add('custom_validate_price_staff', "Chưa nhập đủ thông tin của giáo viên nước ngoài!");
                    }

                    if (is_null($request->num_of_foreign_teacher_sections) && (!is_null($request->foreign_teacher_minutes_per_section) || intval($request->foreign_teacher_minutes_per_section) > 0)) {
                        $validator->errors()->add('custom_validate_price_staff', "Chưa nhập đủ thông tin của giáo viên nước ngoài!");
                    }

                    // Tutor
                    if ((!is_null($request->num_of_tutor_sections) || intval($request->num_of_tutor_sections) > 0) && is_null($request->tutor_minutes_per_section)) {
                        $validator->errors()->add('custom_validate_price_staff', "Chưa nhập đủ thông tin của giáo viên gia sư!");
                    }

                    if (is_null($request->num_of_tutor_sections) && (!is_null($request->tutor_minutes_per_section) || intval($request->tutor_minutes_per_section) > 0)) {
                        $validator->errors()->add('custom_validate_price_staff', "Chưa nhập đủ thông tin của gia sư!");
                    }
                });
            }

            if ($request->type == Order::TYPE_ABROAD) {
                // Academic Awards
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

                if (isset($request->port_type)) {
                    $isThesis = in_array(self::PORT_TYPE_THESIS, $request->port_type);
                    $isExtra = in_array(self::PORT_TYPE_EXTRA, $request->port_type);

                    $this->is_thesis_port = $isThesis;
                    $this->is_extra_port = $isExtra;
                }
            }

            $validator->after(function ($validator) use ($request) {
                if ($request->type == Order::TYPE_ABROAD) {
                    if (!isset($request->port_type)) {
                        $validator->errors()->add('port_type', "Chưa chọn phân hệ hỗ trợ!");
                    }
                }

                if ($request->is_share) {
                    if ($request->has('sales_revenued_list')) {
                        $items = json_decode($request->sales_revenued_list, true);
                        $totalPrice = null;

                        $discountPercent = floatval($request->discount_percent);

                        if ($request->type == Order::TYPE_EDU) {
                            // EDU
                            $totalPrice = Functions::convertStringPriceToNumber($request->vn_teacher_price)
                                        + Functions::convertStringPriceToNumber($request->foreign_teacher_price)
                                        + Functions::convertStringPriceToNumber($request->tutor_price);
                        } else {
                            // ABROAD + EXTRACURRICULAR
                            $totalPrice = \App\Helpers\Functions::convertStringPriceToNumber($request->price);
                        }

                        $totalPrice = $totalPrice - ($totalPrice / 100 * $discountPercent);

                        if ($items && !is_null($totalPrice)) {
                            $totalAmount = 0;

                            foreach ($items as $key => $item) {
                                $isError = false;

                                if (is_null($item['account_id']) || $item['account_id'] == "") {
                                    $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("Hàng <span class='fw-bold'>" . $key + 1 . "</span> chưa chọn sale!"));
                                    $isError = true;
                                }

                                if (self::convertStringPriceToNumber($item['amount']) <= 0) {
                                    $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("Hàng <span class='fw-bold'>" . $key + 1 . "</span> chưa nhập số tiền!"));
                                    $isError = true;
                                }

                                if ($isError) {
                                    $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("<br>"));
                                }

                                $totalAmount += self::convertStringPriceToNumber($item['amount']);
                            }

                            if ((int)$totalAmount != (int)$totalPrice) {
                                $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("<br>"));
                                $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("Số tiền của dịch vụ: <span class='fw-bold'>" . Functions::formatNumber($totalPrice) . "đ</span>!"));
                                $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("Tổng tiền của các sale: <span class='fw-bold'>" . Functions::formatNumber($totalAmount) . "đ</span>!"));
                                $validator->errors()->add('custom_validate_revenue_distribution', new \Illuminate\Support\HtmlString("<span class='fw-bold'> Chênh lệch: " . Functions::formatNumber($totalAmount - $totalPrice) . "đ </span>"));
                            }
                        }
                    }
                }
            });

            if ($validator->fails()) {
                return $validator->errors();
            }

            if ($request->is_share) {
                $this->is_share = true;
            } else {
                $this->is_share = false;
            }

            // Done all validate before (must) -> save
            $this->save();
            $this->updateStatusActive();

            if ($request->type == Order::TYPE_EDU) {
                // Save demo with this train item
                $demoIds = $request->subtract_demo;

                // Delete all old records before creating new ones
                OrderItemDemo::where('order_item_id', $this->id)->delete();

                if (!is_null($demoIds) && is_array($demoIds)) {
                    foreach ($demoIds as $id) {
                        OrderItemDemo::create([
                            'order_item_id' => $this->id,
                            'demo_order_item_id' => intval($id)
                        ]);
                    }
                }
            }

            // If the user selects revenue sharing
            if ($request->is_share) {
                if ($request->has('sales_revenued_list')) {
                    $items = json_decode($request->sales_revenued_list, true);

                    // Check and merge revenueDistributions with duplicate account_id
                    $groupedItems = [];

                    foreach ($items as $item) {
                        if (is_null($item['account_id']) || self::convertStringPriceToNumber($item['amount']) <= 0) {
                            throw new \Exception("RevenueDistribution values are invalid for saving!");
                        }

                        $accountId = $item['account_id'];
                        $amount = self::convertStringPriceToNumber($item['amount']);

                        if (isset($groupedItems[$accountId])) {
                            $groupedItems[$accountId]['amount'] += $amount;

                            if ($item['is_primary']) {
                                $groupedItems[$accountId]['is_primary'] = true;
                            }
                        } else {
                            $item['amount'] = $amount;
                            $groupedItems[$accountId] = $item;
                        }
                    }

                    // Delete old revenue distribution data of this order item
                    RevenueDistribution::where('order_item_id', $this->id)->delete();

                    $saveItems = array_map(function($item) {
                        return [
                            'order_item_id' => $this->id,
                            'account_id' => $item['account_id'],
                            'is_primary' => $item['is_primary'] ? true : false,
                            'amount' => $item['amount'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                    }, $groupedItems);

                    // Batch insert the new revenue distributions
                    RevenueDistribution::insert($saveItems);
                }
            }

            // update order cache total
            $this->orders->updateCacheTotal();

            DB::commit();

            return $validator->errors();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public static function convertStringPriceToNumber($strPrice)
    {
        if (is_numeric($strPrice) && floatval($strPrice) > 0) {
            return floatval($strPrice);
        }

        if (!is_string($strPrice)) return 0;

        $cleanStr = str_replace(array(',', '.'), '', $strPrice);
        $floatNum = floatval($cleanStr);

        return $floatNum;
    }

    // Remove all character not number & convert string to integer
    private function replaceStringPriceCharacter($price)
    {
        $stringPrice = (string) $price; // Convert to string first, regardless of whatever input is a number or a string

        return intval(preg_replace("/[^0-9]/", "", $stringPrice));
    }

    public function getTotal()
    {
        $price = is_null($this->price) ? 0 : (float)str_replace(',', '', str_replace('.', '', $this->price));
        $discount = floatval($this->discount_code);
        $exchange = is_null($this->exchange) ? 1 : (float)str_replace(',', '', str_replace('.', '', $this->exchange));
        $currency = $this->currency_code;
        $total = $price * (1 - $discount / 100) * ($currency == "{!! \App\Models\Order::CURRENCY_CODE_USD !!}" ? $exchange : 1);

        return $total;
    }

    public function getTotalWithoutDiscount()
    {
        $price = is_null($this->price) ? 0 : (float)str_replace(',', '', str_replace('.', '', $this->price));
        $discount = floatval($this->discount_code);
        $exchange = is_null($this->exchange) ? 1 : (float)str_replace(',', '', str_replace('.', '', $this->exchange));
        $currency = $this->currency_code;
        $total = $price * ($currency == "{!! \App\Models\Order::CURRENCY_CODE_USD !!}" ? $exchange : 1);

        return $total;
    }


    public static function getEduItemsByOrderIdRequestDemo($request)
    {
        // $orderIds = is_array($request->order_ids) ? $request->order_ids : [$request->order_ids];


        // $eduItemsByOrderId = self::orderIsActiveRequestDemo()
        //     ->whereDoesntHave('courseStudents')
        //     ->whereIn('order_id', $orderIds)
        //     ->get();

        // return $eduItemsByOrderId;

        $orderIds = is_array($request->order_ids) ? $request->order_ids : [$request->order_ids];

        $eduItemsByOrderIds = self::orderIsActiveRequestDemo()
            ->whereIn('order_id', $orderIds)
            ->get();

        // $orderItems = $eduItemsByOrderIds->filter(function ($eduItemsByOrderId) {
        //     $contact = $eduItemsByOrderId->orders->student;

        //     $checkEduItemsByOrderId = $eduItemsByOrderId->checkremainHours($contact, $eduItemsByOrderId);
        //     $contact
        //     return $checkEduItemsByOrderId;
        // });

        return $eduItemsByOrderIds;
    }

    public static function getEduItems()
    {
        $eduItemsByOrderId = self::orderIsActive()
            ->whereDoesntHave('courseStudents')
            ->get();
        return $eduItemsByOrderId;
    }

    public static function getLearning()
    {
        $eduItemsByOrderId = self::orderIsActive()
            ->whereHas('courseStudents', function ($query) {
                $query->whereHas('course', function ($subQuery) {
                    // Điều kiện cột 'created_at' nhỏ hơn ngày hiện tại
                    $subQuery->where('start_at', '<', now());
                });
            })
            ->get();
        return $eduItemsByOrderId;
    }

    public static function getFinishedLearning()
    {
        $eduItemsByOrderId = self::orderIsActive()
            ->whereHas('courseStudents', function ($query) {
                $query->whereHas('course', function ($subQuery) {

                    $subQuery->where('end_at', '<', now());
                });
            })
            ->get();

        return $eduItemsByOrderId;
    }
    public static function scopeFinishedLearning($query)
    {
        return $query->isActive()
            ->whereHas('courseStudents', function ($q1) {
                $q1->whereHas('course', function ($q2) {
                    $q2->where('end_at', '<', now());
                });
            });

    }

    public static function getSubjectsByOrderId($request)
    {
        $orderItems = self::getEduItemsByOrderId($request);
        $subjects = [];

        foreach ($orderItems as $orderItem) {
            $subjects[] = $orderItem->subject->name;
        };

        return $subjects;
    }

    public static function getSubjectsByOrderItemId($request)
    {
        $orderItems = self::getEduItemsByOrderItemId($request);
        $subjects = [];

        foreach ($orderItems as $orderItem) {
            $subjects[] = $orderItem->subject->name;
        };

        return $subjects;
    }

    public static function getSubjectsByOrderItemIdRequestDemo($request)
    {
        $orderItems = self::getEduItemsByOrderItemIdRequestDemo($request);
        $subjects = [];

        foreach ($orderItems as $orderItem) {
            $subjects[] = $orderItem->subject->name;
        };

        return $subjects;
    }

    public static function getEduItemsByOrderItemIdRequestDemo($request)
    {
        $orderIds = is_array($request->order_item_ids) ? $request->order_item_ids : [$request->order_item_ids];

        if (!empty($orderIds)) {
            $eduItemsByOrderItemId = self::orderIsActiveRequestDemo()
                ->whereDoesntHave('courseStudents')
                ->whereIn('id', $orderIds)
                ->get();

            return $eduItemsByOrderItemId;
        } else {
            // Xử lý khi không có order_item_ids được gửi
            return []; // Hoặc thông báo lỗi, tùy thuộc vào logic của bạn
        }
    }

    public static function getEduItemsByOrderItemId($request)
    {
        $orderIds = is_array($request->order_item_ids) ? $request->order_item_ids : [$request->order_item_ids];

        if (!empty($orderIds)) {

            $eduItemsByOrderItemId = self::orderIsActive()
                ->whereIn('id', $orderIds)
                ->get();
            return $eduItemsByOrderItemId;
        } else {
            // Xử lý khi không có order_item_ids được gửi
            return []; // Hoặc thông báo lỗi, tùy thuộc vào logic của bạn
        }
    }

    public function scopeEdu()
    {
        $order_items = self::query();
        $order_items = self::orderIsActive();
        return $order_items;
    }

    public function scopeOrderIsActiveAssignment($query)
    {
        return $query->whereNotNull('order_id')
            ->whereHas('orders', function ($query) {
                $query->where('status', 'approved');
            });
    }

    public static function orderIsActive()
    {
        $edu_items = self::whereNotNull('order_id')
            ->where('order_items.type', Order::TYPE_EDU)
            ->whereHas('orders', function ($query) {
                $query->where('status', 'approved');
            });

        return $edu_items;
    }

    public static function scopeIsActive($query)
    {
        $query->whereNotNull('order_id')
            ->where('order_items.type', Order::TYPE_EDU)
            ->whereHas('orders', function ($query) {
                $query->where('status', 'approved');
            });
    }

    public static function orderIsActiveRequestDemo()
    {
        $edu_items = self::whereNotNull('order_id')
            ->where('order_items.type', Order::TYPE_REQUEST_DEMO)
            ->whereHas('orders', function ($query) {
                $query->where('status', 'approved');
            });

        return $edu_items;
    }

    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class, 'order_item_id');
    }

    public function refundRequest()
    {
        return $this->hasMany(RefundRequest::class, 'order_item_id');
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    public function getStatus()
    {
        if (count($this->courseStudents) !== 0) {
            return self::ENROLLED;
        } else {
            return self::NOTENROLLED;
        }
    }

    public function getStudent()
    {
        $courseStudent = $this->orders;
        if ($courseStudent) {
            // Nếu tồn tại thông tin CourseStudent
            $student = $courseStudent->student;
            return $student;
        } else {
            return null;
        }
    }

    public function getOrderStudent()
    {
        $courseStudent = $this->orders;
        return $courseStudent;

        if ($courseStudent) {
            $orderStudent = $courseStudent->orderItems->orders;
            return $orderStudent;
        } else {
            return null;
        }
    }

    public static function scopeWhichHasCousrse($query)
    {
        return $query->orderIsActiveAssignment()
            ->whereHas('courseStudents', function ($q) {
                $q->whereHas('student', function ($q2) {
                    $q2->whereDoesntHave('studentSections', function ($q3) {
                        $q3->whereIn('status', ['refund', 'reserve']);
                    });
                });
            });
    }

    public static function scopeHasCousrse($query)
    {
        $query->orderIsActiveAssignment()
            ->whereHas('courseStudents', function ($q) {
                $q->whereHas('student', function ($q2) {
                    $q2->whereDoesntHave('studentSections', function ($q3) {
                        $q3->whereIn('status', ['refund', 'reserve']);
                    });
                });
            });
    }

    public static function scopeWhichHasCousrseByType($query, $type)
    {
        return $query->orderIsActiveAssignment()->whereHas('courseStudents')
            ->where('order_items.type', '=', $type);
    }

    public static function scopeTypeEdu($query)
    {
        $query->orderIsActiveAssignment()->where('order_items.type', '=', Order::TYPE_EDU)->where('order_items.status', '=', self::STATUS_ACTIVE);
    }

    public static function scopeTypeRequestDemo($query)
    {
        $query->orderIsActiveAssignment()->where('order_items.type', '=', Order::TYPE_REQUEST_DEMO)->where('order_items.status', '=', self::STATUS_ACTIVE);
    }


    public static function scopeWhichDoesntHasCousrse($query, $type)
    {
        if($type == Order::TYPE_REQUEST_DEMO){
            $eduItemsByOrderIds = self::orderIsActiveRequestDemo()->get();
        }else if($type == Order::TYPE_EDU){
            $eduItemsByOrderIds = self::orderIsActive()->get();
        }



        $orderItems = $eduItemsByOrderIds->filter(function ($eduItemsByOrderId) {
            $contact = $eduItemsByOrderId->orders->student;
            $checkEduItemsByOrderId = $eduItemsByOrderId->checkremainHours($contact, $eduItemsByOrderId);
            return $checkEduItemsByOrderId;
        });
        $orderItemIds = $orderItems->pluck('id')->toArray();

        return $query->orderIsActiveAssignment()->where('order_items.type', '=', $type)
            ->whereIn('order_items.id', $orderItemIds)->where('order_items.status', '=', self::STATUS_ACTIVE)
            ->whereDoesntHave('reserve', function ($q) {
                $q->where('status', Reserve::STATUS_ACTIVE);
            });
    }

    public static function scopeWhichDoesntHasCousrseCount($query, $type)
    {
        if($type == Order::TYPE_REQUEST_DEMO){
            $eduItemsByOrderIds = self::orderIsActiveRequestDemo()->get();
        }else if($type == Order::TYPE_EDU){
            $eduItemsByOrderIds = self::orderIsActive()->get();
        }
        $orderItems = $eduItemsByOrderIds->filter(function ($eduItemsByOrderId) {
            $contact = $eduItemsByOrderId->orders->student;
            $checkEduItemsByOrderId = $eduItemsByOrderId->checkremainHours($contact, $eduItemsByOrderId);
            return $checkEduItemsByOrderId;
        });

        // todo: không có thì cho false luôn

        if (!$orderItems->count()) {
            return collect([]);
        }
        $orderItemIds = $orderItems->pluck('id')->toArray();

        return $query->orderIsActiveAssignment()->where('order_items.type', '=', $type)
            ->whereIn('order_items.id', $orderItemIds)->where('order_items.status', '=', self::STATUS_ACTIVE)
            ->whereDoesntHave('reserve', function ($q) {
                $q->where('status', Reserve::STATUS_ACTIVE);
            })->get();
    }

    public static function scopeEduCount()
    {
        $order_items = self::query();
        $order_items = self::orderIsActive();
        return $order_items;
    }

    public function scopeCourseCount($query, $subjectName)
    {

        return Course::countCoursesBySubjects($subjectName)->count();
    }

    public function getAmount()
    {
        return $this->getPayrate()->value('amount');
    }

    public function getCost()
    {
        $vietnamTeacher = $this->vietnam_teacher ?? 0;
        $foreignTeacher = $this->foreign_teacher ?? 0;
        $tutorTeacher = $this->tutor_teacher ?? 0;

        return $this->getAmount() * ($vietnamTeacher + $foreignTeacher + $tutorTeacher) / 60;
    }

    public function getPayrate()
    {
        return Payrate::where('type', $this->class_type)
            ->where('subject_id', $this->subject_id);
    }

    public function getRemain()
    {
        return $this->getTotal() - $this->getCost();
    }

    public function scopeFindByContactAndSubject($query, $contactId, $subjectId)
    {
        return $query->whereHas('orders', function ($subquery) use ($contactId) {
            $subquery->where('student_id', $contactId);
        })
            ->where('subject_id', $subjectId);
    }

    // public static function countAssignments($type)
    // {
    //     return self::where('order_items.type', $type)->orderIsActiveAssignment()->count();
    // }
    public function scopeCountAssignments($query, $type)
    {
        return $query->where('order_items.type', $type)->orderIsActiveAssignment();
    }


    public function getTotalVnMinutes()
    {
        $sections = (!is_null($this->num_of_vn_teacher_sections) && $this->num_of_vn_teacher_sections > 0) ? $this->num_of_vn_teacher_sections : 0;
        $minutesPerSections = (!is_null($this->vietnam_teacher_minutes_per_section) && $this->vietnam_teacher_minutes_per_section > 0) ? $this->vietnam_teacher_minutes_per_section : 0;

        return $sections * $minutesPerSections;
    }

    public function getTotalForeignMinutes()
    {
        $sections = (!is_null($this->num_of_foreign_teacher_sections) && $this->num_of_foreign_teacher_sections > 0) ? $this->num_of_foreign_teacher_sections : 0;
        $minutesPerSections = (!is_null($this->foreign_teacher_minutes_per_section) && $this->foreign_teacher_minutes_per_section > 0) ? $this->foreign_teacher_minutes_per_section : 0;

        return $sections * $minutesPerSections;
    }

    public function getTotalTutorMinutes()
    {
        $sections = (!is_null($this->num_of_tutor_sections) && $this->num_of_tutor_sections > 0) ? $this->num_of_tutor_sections : 0;
        $minutesPerSections = (!is_null($this->tutor_minutes_per_section) && $this->tutor_minutes_per_section > 0) ? $this->tutor_minutes_per_section : 0;

        return $sections * $minutesPerSections;
    }

    public function getTotalMinutes()
    {
        return $this->getTotalVnMinutes() + $this->getTotalForeignMinutes() + $this->getTotalTutorMinutes();
    }

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'id', 'order_item_id');
    }

    public static function scopeReserveCount($query)
    {
        $query->TypeEdu();

        $query->whereHas('courseStudents', function ($q) {
            $q->whereHas('student', function ($q2) {
                $q2->whereHas('studentSections', function ($q3) {
                    $q3->where('status', '=', 'reserve');
                });
            });
        });
    }

    public static function scopeRefund($query)
    {
        $query->whereHas('courseStudents', function ($q) {
            $q->whereHas('student', function ($q2) {
                $q2->whereHas('studentSections', function ($q3) {
                    $q3->where('status', '=', 'refund');
                });
            });
        });
    }
    public static function scopeTransfer($query)
    {
        $query->orderIsActiveAssignment()->where('order_items.status', '=', self::STATUS_TRANSFER);
    }

    public function studyHours($orderItem, $contact)
    {

        $courseStudents = $orderItem->courseStudents;

        $allSections = [];
        foreach ($courseStudents as $courseStudent) {
            $sections = $courseStudent->course->sections;
            $allSections = array_merge($allSections, $sections->toArray());
        }
        $studentSection = new StudentSection();
        $remainingHours = $studentSection->studyHours($contact, $allSections);
        return $remainingHours;
    }

    public function checkremainHours($contact, $orderItem)
    {
        $studyHours = self::studyHours($orderItem, $contact);

        if ($studyHours['sumMinutesVNTeacher'] < $orderItem->getTotalVnMinutes()) {
            return true;
        }
        if ($studyHours['sumMinutesForeignTeacher'] < $orderItem->getTotalForeignMinutes()) {
            return true;
        }
        if ($studyHours['sumMinutesTutor'] < $orderItem->getTotalTutorMinutes()) {
            return true;
        }
        return false;
    }

    /**
     * HOANG ANH fix bug assign student to class
     */
    public static function getEduItemsByOrderIds($orderIds)
    {
        $eduItemsByOrderIds = self::orderIsActive()
            ->whereIn('order_id', $orderIds)
            ->where('order_items.status', '=', self::STATUS_ACTIVE)
            ->get();

        $orderItems = $eduItemsByOrderIds->filter(function ($q) {
            $contact = $q->orders->student;
            $result = $q->checkremainHours($contact, $q);

            return $result;
        });

        return $orderItems;
    }

    public static function getEduItemsDemoByOrderIds($orderIds)
    {
        $eduItemsByOrderIds = self::orderIsActiveRequestDemo()
            ->whereIn('order_id', $orderIds)
            ->where('order_items.status', '=', self::STATUS_ACTIVE)
            ->get();

        // $orderItems = $eduItemsByOrderIds->filter(function ($q) {
        //     $contact = $q->orders->student;
        //     $result = $q->checkremainHours($contact, $q);

        //     return $result;
        // });

        return $eduItemsByOrderIds;
    }

    public static function getEduItemsByOrderId($request)
    {
       
        $orderIds = is_array($request->order_ids) ? $request->order_ids : [$request->order_ids];
        $eduItemsByOrderIds = self::orderIsActive()
            ->whereIn('order_id', $orderIds)
            ->where('order_items.status', '=', self::STATUS_ACTIVE)
            ->get();
        $orderItems = $eduItemsByOrderIds->filter(function ($eduItemsByOrderId) {
            $contact = $eduItemsByOrderId->orders->student;
            $checkEduItemsByOrderId = $eduItemsByOrderId->checkremainHours($contact, $eduItemsByOrderId);

            return $checkEduItemsByOrderId;
        });

        return $orderItems;
    }

    public function courseList()
    {
        $courseList = Course::whereHas('courseStudents', function ($q) {
            $q->where('order_item_id', $this->id);
        })->get();

        return $courseList;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('order_items.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function exportToExcelStatusReport($templatePath, $filteredOrderItems)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;

        foreach ($filteredOrderItems as $orderItem) {
            // Date formatting
            $updated_at = $orderItem['updated_at'] ? Carbon::parse($orderItem['updated_at'])->format('d/m/Y') : null;
            $statusTrain = $orderItem->orders->isApproved() ?  $orderItem->getStatus() : (isset($statusMapping[$orderItem->orders->status])
                ? $statusMapping[$orderItem->orders->status]
                : $orderItem->orders->status);
            $statusAbroad = $orderItem->orders->isApproved() ? (rand(0, 1) == 0 ? 'Đã tiếp nhận' : 'Từ chối duyệt') : (isset($statusMapping[$orderItem->orders->status])
                ? $statusMapping[$orderItem->orders->status]
                : $orderItem->orders->status);
            $statusMapping = [
                'approved' => 'Đã duyệt',
                'draft' => 'Đang soạn',
                'pending' => 'Chờ duyệt',
                'rejected' => 'Từ chối duyệt',
                'deleted' => 'Đã xóa',
            ];

            // Translate order status if applicable
            $translatedStatus = isset($statusMapping[$orderItem->order['status']]) ? $statusMapping[$orderItem->order['status']] : $orderItem->order['status'];
            $rowData = [
                $orderItem->orders->code,
                $updated_at,
                $orderItem->order->contacts->name,
                $orderItem->order['type'],
                $translatedStatus,
                $translatedStatus,
                $statusTrain,
                $statusAbroad,
                $orderItem->order->salesperson->name,
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public static function getOrderItemByOrder($orders)
    {
        return self::whereIn('order_id', $orders->pluck('id'))
            ->where('status', '=', self::STATUS_ACTIVE)
            ->whereDoesntHave('reserve')
            ->where('type', '=', 'edu')
            ->get();
    }

    public static function getOrderItemByOrderRefundRequest($orders)
    {
        return self::whereIn('order_id', $orders->pluck('id'))
            ->whereDoesntHave('refundRequest', function ($query) {
                $query->whereIn('status', [RefundRequest::STATUS_PENDING, RefundRequest::STATUS_REJECTED]);
            })
            ->where('status', '!=', self::STATUS_TRANSFER)
            ->where('type', '=', 'edu')

            ->whereHas('order', function ($query) {
                $query->where('status', [Order::STATUS_APPROVED]);
            })

            ->get();
    }

    public static function scopeIsEdu($query)
    {
        $query = $query->where('type', Order::TYPE_EDU);
    }

    public static function scopeAbroad($query)
    {
        $query = $query->where('type', Order::TYPE_ABROAD);
    }

    public static function scopeExtra($query)
    {
        $query = $query->where('type', Order::TYPE_EXTRACURRICULAR);
    }

    public static function scopeIsDemo($query)
    {
        $query = $query->where('type', Order::TYPE_REQUEST_DEMO);
    }

    public function getPriceVnTeacherHour()
    {
        $totalVnMinutes = $this->getTotalVnMinutes() / 60;

        if ($totalVnMinutes > 0) {
            return $this->vn_teacher_price * 60 / $this->getTotalVnMinutes();
        } else {

            return 0;
        }
    }

    public function getPriceForeignTeacherHour()
    {
        $totalForeignMinutes = $this->getTotalForeignMinutes();

        if ($totalForeignMinutes > 0) {
            return $this->foreign_teacher_price * 60 / $this->getTotalForeignMinutes();
        } else {
            return 0;
        }
    }

    public function getPriceTutorHour()
    {
        $totalTutorMinutes = $this->getTotalTutorMinutes();

        if ($totalTutorMinutes > 0) {
            return $this->tutor_price * 60 / $this->getTotalTutorMinutes();
        } else {
            return 0;
        }
    }

    public function getTotalPriceOfEdu()
    {
        $total = 0;

        if (!is_null($this->vn_teacher_price)) {
            $total += intval($this->vn_teacher_price);
        }

        if (!is_null($this->foreign_teacher_price)) {
            $total += intval($this->foreign_teacher_price);
        }

        if (!is_null($this->tutor_price)) {
            $total += intval($this->tutor_price);
        }

        return $total;
    }

    public function getTotalPriceOfAbroad()
    {
        return \App\Helpers\Functions::convertStringPriceToNumber($this->price);
    }

    public function getTotalPriceOfExtra()
    {
        return \App\Helpers\Functions::convertStringPriceToNumber($this->price);
    }

    public function getTotalPriceAfterDiscountOfEdu()
    {
        $discountPercent = $this->order->discount_code;
        $totalPrice = $this->getTotalPriceOfEdu();

        return $totalPrice - ($totalPrice / 100 * $discountPercent);
    }

    public function getTotalPriceAfterDiscountOfAbroad()
    {
        $discountPercent = $this->order->discount_code;
        $totalPrice = $this->getTotalPriceOfAbroad();

        return $totalPrice - ($totalPrice / 100 * $discountPercent);
    }

    public function getTotalPriceAfterDiscountOfExtra()
    {
        $discountPercent = $this->order->discount_code;
        $totalPrice = $this->getTotalPriceOfExtra();

        return $totalPrice - ($totalPrice / 100 * $discountPercent);
    }

    public function getTotalPriceOfEduBeforeDiscount()
    {
        return  $this->getTotalPriceOfEdu() / (1 - $this->order->discount_code / 100);
    }

    public static function exportToExcelUpsellReport($templatePath, $filteredOrderItems)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        $sortedItems = $filteredOrderItems->map(function ($item) {
            $student = \App\Models\Order::find($item->order_id)->student;
            $orderItemId = $item->id;
            $courseStudents = \App\Models\CourseStudent::where('student_id', $student->id)
                ->where('order_item_id', $orderItemId)
                ->get();
            $total = 0;

            foreach ($courseStudents as $i) {
                $total += \App\Models\StudentSection::calculateTotalHoursStudied($student->id, $i->course_id);
            }

            $item->remain_time = $item->getTotalMinutes() / 60 - $total;

            return $item;
        });

        $items = $sortedItems->sortBy('remain_time')->reverse();
        $subjectTotalHoursStudied = 0;

        foreach ($filteredOrderItems as $orderItem) {
            // Date formatting
            $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent($orderItem->id, $orderItem->orders->student_id);
            $courseCodes = ($courseStudents->count() > 0) ? $courseStudents->pluck('course.code')->implode(', ') : 'N/A';

            $groupedCourseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent($orderItem->id, $orderItem->orders->student_id)->groupBy('subject_id');
            $subjectTotalHoursStudied = 0;

            // Calculate total hours studied for each subject
            foreach ($groupedCourseStudents as $subjectId => $group) {
                $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($orderItem) {
                    // Access the correct property 'course_id' on each individual CourseStudent model
                    return \App\Models\StudentSection::calculateTotalHoursStudied($orderItem->orders->student->id, $courseStudent->course_id);
                });
            }

            $studentSections = ($courseStudents->count() > 0) ? StudentSection::endAtForCourse($orderItem->orders->student->id, $courseStudents->first()->course_id) : 'Chưa xếp lớp';

            $sale = Account::find($orderItem->orders->sale)->name ?? '';
            $sale_sup = Account::find($orderItem->orders->sale_sup)->name ?? '';

            $rowData = [
                $orderItem->orders->contacts->code ?? 'N/A',
                $orderItem->orders->student->name ?? 'N/A',
                $orderItem->subject->name ?? 'N/A',
                $courseCodes,
                number_format($orderItem->getTotalMinutes() / 60, 2) . 'Giờ',
                $subjectTotalHoursStudied . ' giờ' ?? '0 giờ',
                number_format($orderItem->remain_time, 2) . 'Giờ',
                $studentSections,
                $sale,
                $sale_sup,
                // Add other fields as needed
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public function getSubjectName()
    {
        return $this->subject ? $this->subject->name : '--';
    }

    public static function getOrderItemByOrderTransfer($orders)
    {
        return self::whereIn('order_id', $orders->pluck('id'))
            ->whereDoesntHave('refundRequest')
            ->whereDoesntHave('reserve', function ($q) {
                $q->where('reserve.status', Reserve::STATUS_ACTIVE);
            })
            ->where('type', '=', self::TYPE_EDU)
            ->where('status', '=', self::STATUS_ACTIVE)
            ->get();
    }

    public function calculateTotalStudiedAmount()
    {
        $studentSection = new StudentSection;
        $courseStudents = CourseStudent::getCourseStudentsByOrderItemAndStudent(
            $this->id,
            $this->orders->student_id
        );

        $totalHoursStudiedOfTutor = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfTutor($courseStudents, $this);
        $totalHoursStudiedOfForeignTeacher = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfForeignTeacher($courseStudents, $this);
        $totalHoursStudiedOfVnTeacher = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfVnTeacher($courseStudents, $this);

        $totalRefundAmount = (
            $this->getPriceTutorHour() * $totalHoursStudiedOfTutor +
            $this->getPriceForeignTeacherHour() * $totalHoursStudiedOfForeignTeacher +
            $this->getPriceVnTeacherHour() * $totalHoursStudiedOfVnTeacher
        );

        return $totalRefundAmount;
    }

    public function revenueDistributions()
    {
        return $this->hasMany(RevenueDistribution::class, 'order_item_id', 'id');
    }

    public function updateStatusRefund()
    {
        $this->status = self::STATUS_REFUND;
        $this->save();
    }

    public static function scopeGetOrderItemTransferListByContact($query, $student)
    {
        $query->where('status', '=', self::STATUS_TRANSFER)
            ->whereHas('orders.contacts', function ($q) use ($student) {
                $q->where('id', $student);
            });
    }

    public function updateStatusActive()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }

    public function getAbroadServices()
    {
        if ($this->type === self::TYPE_ABROAD) {
            return AbroadService::where('id', $this->abroad_service_id)->get();
        } else {
            return null;
        }
    }

    public static function getDemoItemsByContactId($contactId)
    {
        return self::whereHas('order', function ($q) use ($contactId) {
            $q->where('contact_id', $contactId);
        })
            ->where('type', Order::TYPE_REQUEST_DEMO)
            ->whereDoesntHave('demoItemSubtracts', function ($q2) {
                $q2->whereRaw('order_items.id = order_item_demos.demo_order_item_id');
            })
            ->get();
    }

    /**
     * Retrieve all order items of type demo that haven't been selected for hour subtraction
     * or have been selected for hour subtraction but belong to the train item currently invoking the function.
     */
    public function getSubtractedAndNotSubtractedDemoItems()
    {
        return self::whereHas('order', function ($q) {
            $q->where('contact_id', $this->order->contact_id);
        })
            ->where('type', Order::TYPE_REQUEST_DEMO)
            ->where(function ($q1) {
                $q1->doesntHave('demoItemSubtracts')
                    ->orWhereHas('demoItemSubtracts', function ($q2) {
                        $q2->where('order_item_id', $this->id);
                    });
            })
            ->get();
    }
    public function getSubtractedDemoItems()
    {
        return $this->trainItemSubtracts()->get();
    }
    public function getTotalMinutesForSubtractedDemoItems()
    {
        $items = $this->getSubtractedDemoItems();

        $totalMinutes = $items->sum(function ($item) {
            return $item->OrderItem->getTotalMinutes();
        });

        return $totalMinutes;
    }

    public function createAbroadApplication()
    {
        $contactId = $this->order->contact_id;
        $orderItemId = $this->id;

        // Check to see if there is any record existing with the given contact_id and order_item_id values
        $existingRecord = AbroadApplication::where('contact_id', $contactId)
            ->where('order_item_id', $orderItemId)
            ->first();

        // If a record already exists
        if ($existingRecord) {
            throw new \Exception('A similar AbroadApplication already exists!');
        }

        // If there are no duplicate records, create a new record
        $abroadApplication = AbroadApplication::newDefault();

        $abroadApplication->contact_id = $contactId;
        $abroadApplication->student_id = $this->order->student_id;
        $abroadApplication->order_item_id = $orderItemId;
        $abroadApplication->save();
        $abroadApplication->generateCode();
        // $abroadApplication->assignNew();
        $abroadApplication->fillFromOrderItem($this);
    }

    /**
     * Used to add a field remain_time to the item.
     */
    public function addRemainTime()
    {
        $student = $this->order->student;
        $courseStudents = CourseStudent::where('student_id', $student->id)->where('order_item_id', $this->id)->get();
        $total = 0;

        foreach ($courseStudents as $i) {
            $total += StudentSection::calculateTotalHoursStudied($student->id, $i->course_id);
        }

        $this->remain_time = $this->getTotalMinutes() / 60 - $total;
    }

    /**
     * Retrieve all sections that the student is enrolled in based on a specific class
     * @param studentId The ID of the student who registered for that service
     * @param courseId The ID of the contract containing that service
     */
    public static function getStudentSections($studentId, $courseId)
    {
        $studentSections = StudentSection::where('student_id', $studentId)
            ->whereHas('section', function ($q) use ($courseId) {
                $q->where('course_id', $courseId)
                    ->whereNotNull('end_at');
            })
            ->whereIn('student_section.status', [StudentSection::STATUS_NEW, StudentSection::STATUS_PRESENT, StudentSection::STATUS_STUDY_PARTNER])
            ->get();

        if ($studentSections->isEmpty()) {
            return null;
        }

        return $studentSections;
    }

    /**
     * Retrieve the start date of course
     * @param studentId The ID of the student who registered for that service
     * @param courseId The ID of the contract containing that service
     */
    public static function startAtForCourse($studentId, $courseId)
    {
        // Find the class session that the student is attending in the current class
        $studentSections = self::getStudentSections($studentId, $courseId);

        if (!$studentSections) {
            return null;
        }

        $startAt = $studentSections->min(function ($studentSection) {
            return $studentSection->section->end_at;
        });

        return \Carbon\Carbon::parse($startAt)->format('d/m/Y');
    }

    /**
     * Calculate the total teacher salary cost of the demo order item per course
     * @param course
     */
    public function caculateStaffExpensesPerCourse($course)
    {
        $demoHours = $this->getTotalMinutes() / 60;
        $teacherId = $course->teacher->id;
        $subjectId = $this->subject->id;
        $studentId = $this->order->contacts->id;
        $startDate = self::startAtForCourse($studentId, $course->id);

        if (is_null($startDate)) {
            return 0;
        }

        // Convert date format from DD/MM/YYYY -> YYYY/MM/DD
        $date = strtotime(str_replace('/', '-', $startDate));
        $formatedDate = date('Y/m/d', $date);

        $payrates = Payrate::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->where('effective_date', '<', $formatedDate)
            ->get();

        $maxEffevtiveDate = null;
        $maxItem = null;

        // Loop through all payrates found to identify the nearest final payrate
        foreach ($payrates as $item) {
            $currentEffectiveDate = strtotime($item['effective_date']);
            if ($currentEffectiveDate !== false && ($maxEffevtiveDate === null || $currentEffectiveDate > $maxEffevtiveDate)) {
                $maxEffevtiveDate = $currentEffectiveDate;
                $maxItem = $item;
            }
        }

        if ($maxItem) {
            return $demoHours * $maxItem->amount;
        }

        return 0;
    }

    /**
     * Calculate the total cost of the teachers for that demo order item across all courses
     */
    public function caculateTotalStaffExpenses()
    {
        $expenses = 0;
        $courses = $this->courseList();

        // Find all courses where the service is registered
        // then calculate the teacher's cost for each course and sum them up
        foreach ($courses as $course) {
            $expenses += $this->caculateStaffExpensesPerCourse($course);
        }

        return $expenses;
    }

    public function getSections()
    {
        $courseStudents = CourseStudent::where('order_item_id', $this->id);
        $courseIds = $courseStudents->pluck('course_id')->toArray();
        $courses = Course::whereIn('id', $courseIds)->get();
        $allSections = new Collection();

        foreach ($courses as $course) {
            $sections = $course->sections;
            $allSections = $allSections->merge($sections);
        }

        return $allSections;
    }

    public static function caculateTotalHours($sections, $date)
    {
        $hours = 0;
        $sectionsBeforeDate = Section::beforeDate($sections, $date);

        foreach ($sectionsBeforeDate as $section) {
            $hours += $section->calculateDurationSection();
        }

        return $hours;
    }

    public function caculateTotalHoursBeforeDate($date)
    {
        if (is_null($date)) {
            return 0;
        }

        $sections = $this->getSections();
        $sectionsBeforeDate = Section::beforeDate($sections, $date);
        $totalHours = self::caculateTotalHours($sectionsBeforeDate, $date);

        return $totalHours;
    }

    public function getHomeRoomName()
    {
        return $this->homeRoom ? $this->homeRoom->name : '--';
    }

    public function getTeachers()
    {
        $currentDate = now();

        $teacherIds = Payrate::where('subject_id', $this->subject_id)
            ->where('type', $this->class_type)
            ->where('effective_date', '<=', $currentDate)
            ->groupBy('teacher_id')
            ->pluck('teacher_id')
            ->unique();

        if ($teacherIds->count() > 0) {
            return Teacher::whereIn('id', $teacherIds)->get();
        } else {
            return collect();
        }
    }

    public function getForeignTeachers()
    {
        return $this->getTeachers()->filter(function ($teacher) {
            return $teacher->type === Teacher::TYPE_FOREIGN;
        });
    }

    public function getVietnameseTeachers()
    {
        return $this->getTeachers()->filter(function ($teacher) {
            return $teacher->type === Teacher::TYPE_VIETNAM;
        });
    }

    public function getTutorTeachers()
    {
        return $this->getTeachers()->filter(function ($teacher) {
            return $teacher->type === Teacher::TYPE_TUTOR;
        });
    }

    public static function exportToExcelDemoReport($templatePath, $filteredOrderItems)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;
        $iteration = 1;

        foreach ($filteredOrderItems as $orderItem) {
            // Date formatting
            $order_date = Carbon::parse($orderItem->orders->order_date)->format('d/m/Y');

            // Formatting total minutes as hours
            $totalHours = number_format($orderItem->getTotalMinutes() / 60, 2) . ' Giờ';

            // Formatting currency
            $totalStaffExpenses = number_format($orderItem->caculateTotalStaffExpenses(), 0, '.', '.') . 'đ';

            $courseList = $orderItem->courseList();
            $studentSectionStarts = self::startAtForCourse($orderItem->getStudent()->id, $courseList->id);
            $studentSectionEnds = StudentSection::endAtForCourse($orderItem->getStudent()->id, $courseList->id);

            $rowData = [
                $iteration,
                $order_date,
                $orderItem->order->contacts->code,
                $orderItem->order->contacts->name,
                $orderItem->orders->salesperson->name,
                $orderItem->orders->code,
                $courseList->code,
                $totalHours,
                trans('messages.courses.class_type.' . $orderItem->class_type),
                $orderItem->getStatus(),
                $orderItem->subject->name ?? 'N/A',
                $courseList->teacher->name,
                $totalStaffExpenses,
                $studentSectionStarts ?? '--',
                $studentSectionEnds ?? '--',
                // Add other fields as needed
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            $iteration++;
        }
    }

    public static function scopeSelect2($query, $request)
    {
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // Get students in contacts
        if (isset($request->type) && $request->type === 'abroad') {
            $query = $query->where('type', Order::TYPE_ABROAD);
        }

        // pagination
        $orderItems = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $orderItems->map(function ($orderItem) {
                return [
                    'id' => $orderItem->id,
                    'text' => $orderItem->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $orderItems->lastPage() != $request->page,
            ],
        ];
    }

    public function getSelect2Text()
    {
        return
            '<strong>'
            . 'Mã hợp đồng: ' . $this->order->code
            . '</strong>

                <div>'
            . 'Loại: ' . trans('messages.order_item.' . $this->type)
            . '</div>

                <div>'
            . 'Tên học viên: ' . $this->order->student->name
            . '</div>';
    }

    //Kiểm tra giờ rảnh của học viên và lớp học
    public static function checkDay($course, $student_free_times,$day_map, $studentId)
    {

        $weekSchedules = json_decode($course->week_schedules, true);
        $sections = $course->sections()->get();
        $courseSections = [];
        $lessons = StudentSection::getLessonsByStudentId($studentId);
        if (empty($student_free_times)) {
            // Nếu freeTimes rỗng, coi như sinh viên luôn rảnh
            $student_free_times = [["start_at" => "1970-01-01 00:00:00", "end_at" => "9999-12-31 23:59:59"]];
        }
        $student_free_times = self::excludeLessonsFromFreeTime($student_free_times, $lessons);
        foreach ($sections as $section) {
            $courseSections[] = $section->getAttributes();
        }

        // foreach ($weekSchedules as $item) {
        //     $day = $item['name'];
        //     $dayNumber = $day_map[$day];
        //     $uniqueDaysOfWeeks = [];
        //     foreach ($student_free_times as $student_free_time) {
        //         if (!in_array($student_free_time['day_of_week'], $uniqueDaysOfWeeks)) {
        //             $uniqueDaysOfWeeks[] = $student_free_time['day_of_week'];
        //         }
        //     }
        //     if (!in_array($dayNumber, $uniqueDaysOfWeeks)) {
        //     return false;
        //     }
        // }

        foreach($courseSections as $courseSection) {
            // $study_date = Carbon::parse($courseSection['study_date'])->startOfDay();
            // $free_date = Carbon::parse($student_free_time['study_date'])->startOfDay();
            $courseStart = strtotime($courseSection["start_at"]);
            $courseEnd = strtotime($courseSection["end_at"]);
            $checkDuplicates = false;
            foreach ($student_free_times as $student_free_time) {
                $freeTimeStart = strtotime($student_free_time["start_at"]);
                $freeTimeEnd = strtotime($student_free_time["end_at"]);

                // Kiểm tra nếu thời gian bắt đầu hoặc kết thúc của buổi học nằm trong thời gian rảnh
                if (($freeTimeStart <= $courseStart && $courseStart <= $freeTimeEnd) && ($freeTimeStart <= $courseEnd && $courseEnd <= $freeTimeEnd)) {
                    $checkDuplicates = true;
                }
            }

            if(!$checkDuplicates) {
                return false;
            }
        }

        return true;
    }


    // Hàm để loại trừ thời gian của buổi học khỏi khoảng thời gian rảnh
    public static function excludeLessonsFromFreeTime($freeTimes, $lessons)
    {
        $result = [];

        foreach ($freeTimes as $freeTime) {
            $freeTimeStart = strtotime($freeTime["start_at"]);
            $freeTimeEnd = strtotime($freeTime["end_at"]);

            foreach ($lessons as $lesson) {
                $lessonStart = strtotime($lesson["start_at"]);
                $lessonEnd = strtotime($lesson["end_at"]);

                // Nếu thời gian rảnh và thời gian học không trùng nhau, giữ nguyên khoảng thời gian rảnh
                if ($lessonEnd <= $freeTimeStart || $lessonStart >= $freeTimeEnd) {
                    continue;
                }

                // Nếu thời gian học nằm trong khoảng thời gian rảnh
                if ($lessonStart > $freeTimeStart && $lessonEnd < $freeTimeEnd) {
                    $result[] = ["start_at" => date("Y-m-d H:i:s", $freeTimeStart), "end_at" => date("Y-m-d H:i:s", $lessonStart)];
                    $freeTimeStart = $lessonEnd;
                }
                // Nếu thời gian học bắt đầu trước hoặc trùng với thời gian rảnh và kết thúc trong hoặc sau thời gian rảnh
                else if ($lessonStart <= $freeTimeStart && $lessonEnd < $freeTimeEnd) {
                    $freeTimeStart = $lessonEnd;
                }
                // Nếu thời gian học bắt đầu trong hoặc sau thời gian rảnh và kết thúc sau thời gian rảnh
                else if ($lessonStart > $freeTimeStart && $lessonEnd >= $freeTimeEnd) {
                    $result[] = ["start_at" => date("Y-m-d H:i:s", $freeTimeStart), "end_at" => date("Y-m-d H:i:s", $lessonStart)];
                    $freeTimeEnd = $lessonStart;
                }
                // Nếu thời gian học bao trùm toàn bộ khoảng thời gian rảnh
                else if ($lessonStart <= $freeTimeStart && $lessonEnd >= $freeTimeEnd) {
                    $freeTimeStart = $freeTimeEnd;
                }
            }

            // Nếu sau khi loại trừ buổi học, vẫn còn khoảng thời gian rảnh
            if ($freeTimeStart < $freeTimeEnd) {
                $result[] = ["start_at" => date("Y-m-d H:i:s", $freeTimeStart), "end_at" => date("Y-m-d H:i:s", $freeTimeEnd)];
            }
        }

        return $result;
    }


    public static function getOrderItemByCourse($course)
    {

        if($course->level){
            $orderItems = self::where('subject_id', $course->subject_id)
                ->where('status', self::STATUS_ACTIVE)
                ->where('class_type', $course->class_type)
                ->where('level', $course->level)
                ->where('study_type', $course->study_method)
                ->whereHas('order', function ($query) {
                    $query->where('status', [Order::STATUS_APPROVED]);
                })
                ->whereDoesntHave('courseStudent', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->get();
        }else{
            $orderItems = self::where('subject_id', $course->subject_id)
                ->where('status', self::STATUS_ACTIVE)
                ->where('class_type', $course->class_type)
                ->where('study_type', $course->study_method)
                ->whereHas('order', function ($query) {
                    $query->where('status', [Order::STATUS_APPROVED]);
                })
                ->whereDoesntHave('courseStudent', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->get();
        }

        if ($course->study_method != 'Online') {
            $orderItems = $orderItems->where('training_location_id', $course->training_location_id);
        }
        $filteredOrderItems = [];
        $day_map = [
            'sun'=>1,
            'mon'=>2,
            'tue'=>3,
            'wed'=>4,
            'thu'=>5,
            'fri'=>6,
            'sat'=>7
        ];
        $remainStudyHoursForCourseOfForeignTeacher = $course->getRemainStudyHoursForCourseOfForeignTeacher()*60;
        $remainStudyHoursForCourseOfvnTeacher = $course->getRemainStudyHoursForCourseOfvnTeacher()*60;
        foreach ($orderItems as $key => $orderItem) {
            // Lấy danh sách thời gian rảnh của học viên từ OrderItem hiện tại
            $isOverLap = true;
            $sumMinutesForeignTeacher = $orderItem->getTotalForeignMinutes() - $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesForeignTeacher'];
            $sumMinutesVNTeacher = $orderItem->getTotalVnMinutes() - $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesVNTeacher'];
            
            
            if($sumMinutesForeignTeacher > 0 && $sumMinutesVNTeacher > 0){
                if($remainStudyHoursForCourseOfForeignTeacher <= 0 && $remainStudyHoursForCourseOfvnTeacher <= 0){
                    $isOverLap = false; 
                }
            }
           
            if($sumMinutesForeignTeacher > 0 && $sumMinutesVNTeacher < 0){
                if($remainStudyHoursForCourseOfForeignTeacher <= 0){
                    $isOverLap = false; 
                }
            }
           
            if($sumMinutesVNTeacher > 0 && $sumMinutesForeignTeacher < 0){
               
                if($remainStudyHoursForCourseOfvnTeacher <= 0){
                    $isOverLap = false; 
                }
            }


            $student_free_times = $orderItem->order->contacts->getFreeTimeStudent();
            $studentId = $orderItem->order->contacts->id;
            $checkday = self::checkDay($course, $student_free_times, $day_map, $studentId);
            if (!$checkday) {
                $isOverLap = false;
            }
            if (!$isOverLap) {
                unset($orderItems[$key]);
            }
        }

        // return $orderItems;
        $filteredOrderItems = [];

        foreach ($orderItems as $key => $orderItem) {
            // Thực hiện kiểm tra xem OrderItem còn giờ học không
            $contact = $orderItem->orders->student;
            $checkRemainHours = $orderItem->checkremainHours($contact, $orderItem);

            // Nếu OrderItem còn giờ học, thêm vào danh sách lọc
            if ($checkRemainHours) {
                $filteredOrderItems[] = $orderItem;
            }
        }

        return $filteredOrderItems;
    }

    public function calculateTotalHoursStudiedForCourseStudents()
    {
        $totalHoursStudied = 0;

        foreach ($this->courseStudents as $courseStudent) {
            $totalHoursStudied += StudentSection::calculateTotalHoursStudied($this->orders->contacts->id, $courseStudent->course_id);
        }

        return $totalHoursStudied;
    }

    /**
     * Used to calculate the total price regardless of the item type
     */
    public function getTotalPriceRegardlessType()
    {
        $discountPercent = floatval($this->order->discount_code);
        $price = $this->getTotalPriceRegardlessTypeBeforeDiscount();

        return \App\Helpers\Functions::convertStringPriceToNumber($price - ($price / 100 * $discountPercent));
    }

    public function getTotalPriceRegardlessTypeBeforeDiscount()
    {
        if ($this->order->type == Order::TYPE_EDU) {
            return $this->getEduPrice();
        } else {
            return \App\Helpers\Functions::convertStringPriceToNumber($this->price);
        }
    }

    public function getEduPrice()
    {
        $vnTeacherPrice = \App\Helpers\Functions::convertStringPriceToNumber($this->vn_teacher_price);
        $foreignTeacherPrice = \App\Helpers\Functions::convertStringPriceToNumber($this->foreign_teacher_price);
        $tutorPrice = \App\Helpers\Functions::convertStringPriceToNumber($this->tutor_price);

        return $vnTeacherPrice + $foreignTeacherPrice + $tutorPrice;
    }

    // This function is used to caculate for edu only ??
    // Giá trị của cả khoá
    public function getTotalPrice()
    {
        $vn_teacher_price = $this->vn_teacher_price;
        $foreign_teacher_price = $this->foreign_teacher_price;
        $tutor_price = $this->tutor_price;
        $totalPrice = $vn_teacher_price + $foreign_teacher_price + $tutor_price;

        return $totalPrice;
    }

    // Giờ luỹ kế tổng
    public function getTotalHourLuyKe($updated_at_to)
    {
        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesTotal'];
        $HourLuyKe = $remainingHours;

        return $HourLuyKe;
    }

    // Giờ luỹ kế VN
    public function getVNHourLuyKe($updated_at_to)
    {
        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesVNTeacher'];
        $HourLuyKe = $remainingHours;

        return $HourLuyKe;
    }

    // Giờ luỹ kế Foreign
    public function getForeignHourLuyKe($updated_at_to)
    {
        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesForeignTeacher'];
        $HourLuyKe = $remainingHours;

        return $HourLuyKe;
    }

    // Giờ luỹ kế Gia sư
    public function getTutorHourLuyKe($updated_at_to)
    {
        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesTutor'];
        $HourLuyKe = $remainingHours;

        return $HourLuyKe;
    }

    public function studyHoursByDay($orderItem, $contact, $day)
    {
        $courseStudents = $orderItem->courseStudents;
        $allSections = [];

        foreach ($courseStudents as $courseStudent) {
            $sections = $courseStudent->course->sections;
            $allSections = array_merge($allSections, $sections->toArray());
        }

        $studentSection = new StudentSection();
        $remainingHours = $studentSection->studyHoursByDay($contact, $allSections, $day);

        return $remainingHours;
    }

    //Số giờ khóa học   
    public function getPriceTotalHoursByKhoaHoc($updated_at_from)
    {
        $orderItem =
            $courseStudents = $this->courseStudents;
        $allSections = [];

        foreach ($courseStudents as $courseStudent) {
            $sections = $courseStudent->course->sections;
            $allSections = array_merge($allSections, $sections->toArray());
        }

        return $allSections;
    }

    // BÁO CÁO GIỜ TỒN
    //Số giờ khóa học
    public function calculateTotalHoursStudiedForOrderItem($updated_at_from)
    {
        $sumMinutes = 0;
        $sumMinutesVnTeacher = 0;
        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesAssistant = 0;

        if ($this->orders->contacts) {
            foreach ($this->courseStudents as $courseStudent) {
                if ($courseStudent) {
                    if ($courseStudent->course_id ) {
                        $minutesStudied = \App\Models\StudentSection::calculateTotalHoursStudiedWithCondition($this->orders->contacts->id, $courseStudent->course_id, $updated_at_from);

                        $sumMinutes += $minutesStudied['sum_minutes'];
                        $sumMinutesVnTeacher += $minutesStudied['vn_teacher_minutes'];
                        $sumMinutesForeignTeacher += $minutesStudied['foreign_teacher_minutes'];
                        $sumMinutesTutor += $minutesStudied['tutor_minutes'];
                        $sumMinutesAssistant += $minutesStudied['assistant_minutes'];
                    }
                }
            }
        }
        return [
            'sum_minutes' => $sumMinutes,
            'vn_teacher_minutes' => $sumMinutesVnTeacher,
            'foreign_teacher_minutes' => $sumMinutesForeignTeacher,
            'tutor_minutes' => $sumMinutesTutor,
            'assistant_minutes' => $sumMinutesAssistant,
        ];
    }

    public function calculatePriceTotalHoursStudiedForOrderItem($updated_at_from)
    {
        return $this->calculatePriceTotalHoursStudiedOfVNTeacherForOrderItem($updated_at_from) + $this->calculatePriceTotalHoursStudiedOfForeignTeacherForOrderItem($updated_at_from) + $this->calculatePriceTotalHoursStudiedOfTutorForOrderItem($updated_at_from);
    }

    public function calculatePriceTotalHoursStudiedOfVNTeacherForOrderItem($updated_at_from)
    {
        if ($this->getTotalVnMinutes() > 0) {
            return $this->vn_teacher_price / $this->getTotalVnMinutes() * $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['vn_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfForeignTeacherForOrderItem($updated_at_from)
    {
        if ($this->getTotalForeignMinutes() > 0) {
            return $this->foreign_teacher_price / $this->getTotalForeignMinutes() * $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['foreign_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfTutorForOrderItem($updated_at_from)
    {
        if ($this->getTotalTutorMinutes() > 0) {
            return $this->tutor_price / $this->getTotalTutorMinutes() * $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['tutor_minutes'];
        } else {
            return 0;
        }
    }

    // Lũy kế
    public function calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)
    {
        $sumMinutes = 0;
        $sumMinutesVnTeacher = 0;
        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesAssistant = 0;

        if ($this->orders->contacts) {
            foreach ($this->courseStudents as $courseStudent) {
                if ($courseStudent) {
                    if ($courseStudent->course_id ) {
                        $minutesStudied = \App\Models\StudentSection::calculateTotalHoursStudiedWithCondition($this->orders->contacts->id, $courseStudent->course_id, $updated_at_to);

                        $sumMinutes += $minutesStudied['sum_minutes'];
                        $sumMinutesVnTeacher += $minutesStudied['vn_teacher_minutes'];
                        $sumMinutesForeignTeacher += $minutesStudied['foreign_teacher_minutes'];
                        $sumMinutesTutor += $minutesStudied['tutor_minutes'];
                        $sumMinutesAssistant += $minutesStudied['assistant_minutes'];
                    }
                }
            }
        }

        return [
            'sum_minutes' => $sumMinutes,
            'vn_teacher_minutes' => $sumMinutesVnTeacher,
            'foreign_teacher_minutes' => $sumMinutesForeignTeacher,
            'tutor_minutes' => $sumMinutesTutor,
            'assistant_minutes' => $sumMinutesAssistant,
        ];
    }

    public function calculatePriceTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)
    {
        return $this->calculatePriceTotalHoursStudiedOfVNTeacherByLuyKeForOrderItem($updated_at_to) + $this->calculatePriceTotalHoursStudiedOfForeignTeacherByLuyKeForOrderItem($updated_at_to) + $this->calculatePriceTotalHoursStudiedOfTutorByLuyKeForOrderItem($updated_at_to);
    }

    public function calculatePriceTotalHoursStudiedOfVNTeacherByLuyKeForOrderItem($updated_at_to)
    {
        if ($this->getTotalVnMinutes() > 0) {
            return $this->vn_teacher_price / $this->getTotalVnMinutes() * $this->calculateTotalHoursStudiedForOrderItem($updated_at_to)['vn_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfForeignTeacherByLuyKeForOrderItem($updated_at_to)
    {
        if ($this->getTotalForeignMinutes() > 0) {
            return $this->foreign_teacher_price / $this->getTotalForeignMinutes() * $this->calculateTotalHoursStudiedForOrderItem($updated_at_to)['foreign_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfTutorByLuyKeForOrderItem($updated_at_to)
    {
        if ($this->getTotalTutorMinutes() > 0) {
            return $this->tutor_price / $this->getTotalTutorMinutes() * $this->calculateTotalHoursStudiedForOrderItem($updated_at_to)['tutor_minutes'];
        } else {
            return 0;
        }
    }

    // Đầu kỳ
    public function calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_from)
    {
        $sumMinutes = $this->getTotalMinutes() - $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['sum_minutes'];
        $sumMinutesVnTeacher = $this->getTotalVnMinutes() - $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['vn_teacher_minutes'];
        $sumMinutesForeignTeacher = $this->getTotalForeignMinutes() - $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['foreign_teacher_minutes'];
        $sumMinutesTutor = $this->getTotalTutorMinutes() - $this->calculateTotalHoursStudiedForOrderItem($updated_at_from)['tutor_minutes'];

        return [
            'sum_minutes' => $sumMinutes,
            'vn_teacher_minutes' => $sumMinutesVnTeacher,
            'foreign_teacher_minutes' => $sumMinutesForeignTeacher,
            'tutor_minutes' => $sumMinutesTutor,
        ];
    }

    public function calculatePriceTotalHoursStudiedByDauKyForOrderItem($updated_at_from)
    {
        return $this->calculatePriceTotalHoursStudiedOfVNTeacherByDauKyForOrderItem($updated_at_from) + $this->calculatePriceTotalHoursStudiedOfForeignTeacherByDauKyForOrderItem($updated_at_from) + $this->calculatePriceTotalHoursStudiedOfTutorByDauKyForOrderItem($updated_at_from);
    }

    public function calculatePriceTotalHoursStudiedOfVNTeacherByDauKyForOrderItem($updated_at_from)
    {
        if ($this->getTotalVnMinutes() > 0) {
            return $this->vn_teacher_price / $this->getTotalVnMinutes() * $this->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_from)['vn_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfForeignTeacherByDauKyForOrderItem($updated_at_from)
    {
        if ($this->getTotalForeignMinutes() > 0) {
            return $this->foreign_teacher_price / $this->getTotalForeignMinutes() * $this->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_from)['foreign_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfTutorByDauKyForOrderItem($updated_at_from)
    {
        if ($this->getTotalTutorMinutes() > 0) {
            return $this->tutor_price / $this->getTotalTutorMinutes() * $this->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_from)['tutor_minutes'];
        } else {
            return 0;
        }
    }

    // Trong kỳ
    public function calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)
    {
        $sumMinutes = 0;
        $sumMinutesVnTeacher = 0;
        $sumMinutesForeignTeacher = 0;
        $sumMinutesTutor = 0;
        $sumMinutesAssistant = 0;

        if ($this->orders->contacts) {
            foreach ($this->courseStudents as $courseStudent) {
                if ($courseStudent) {
                    if ($courseStudent->course_id ) {
                        $minutesStudied = \App\Models\StudentSection::calculateTotalHoursStudiedWithCondition($this->orders->contacts->id, $courseStudent->course_id, $updated_at_from, $updated_at_to);

                        $sumMinutes += $minutesStudied['sum_minutes'];
                        $sumMinutesVnTeacher += $minutesStudied['vn_teacher_minutes'];
                        $sumMinutesForeignTeacher += $minutesStudied['foreign_teacher_minutes'];
                        $sumMinutesTutor += $minutesStudied['tutor_minutes'];
                        $sumMinutesAssistant += $minutesStudied['assistant_minutes'];
                    }
                }
            }
        }

        return [
            'sum_minutes' => $sumMinutes,
            'vn_teacher_minutes' => $sumMinutesVnTeacher,
            'foreign_teacher_minutes' => $sumMinutesForeignTeacher,
            'tutor_minutes' => $sumMinutesTutor,
            'assistant_minutes' => $sumMinutesAssistant,
        ];
    }

    public function calculatePriceTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)
    {
        return $this->calculatePriceTotalHoursStudiedOfVNTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to) + $this->calculatePriceTotalHoursStudiedOfForeignTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to) + $this->calculatePriceTotalHoursStudiedOfTutorByTrongKyForOrderItem($updated_at_from, $updated_at_to);
    }

    public function calculatePriceTotalHoursStudiedOfVNTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to)
    {
        if ($this->getTotalVnMinutes() > 0) {
            return $this->vn_teacher_price / $this->getTotalVnMinutes() * $this->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['vn_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfForeignTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to)
    {
        if ($this->getTotalForeignMinutes() > 0) {
            return $this->foreign_teacher_price / $this->getTotalForeignMinutes() * $this->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['foreign_teacher_minutes'];
        } else {
            return 0;
        }
    }

    public function calculatePriceTotalHoursStudiedOfTutorByTrongKyForOrderItem($updated_at_from, $updated_at_to)
    {
        if ($this->getTotalTutorMinutes() > 0) {
            return $this->tutor_price / $this->getTotalTutorMinutes() * $this->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['tutor_minutes'];
        } else {
            return 0;
        }
    }

    // Cuối kỳ  
    public function calculatePriceTotalHoursStudiedByCuoiKyForOrderItem($updated_at_from, $updated_at_to)
    {
        return $this->calculatePriceTotalHoursStudiedByDauKyForOrderItem($updated_at_from) - $this->calculatePriceTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to);
    }

    public function calculatePriceTotalHoursStudiedOfVNTeacherByCuoiKyForOrderItem($updated_at_from, $updated_at_to)
    {
        return $this->calculatePriceTotalHoursStudiedOfVNTeacherByDauKyForOrderItem($updated_at_from) - $this->calculatePriceTotalHoursStudiedOfVNTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to);
    }

    public function calculatePriceTotalHoursStudiedOfForeignTeacherByCuoiKyForOrderItem($updated_at_from, $updated_at_to)
    {
        return $this->calculatePriceTotalHoursStudiedOfForeignTeacherByDauKyForOrderItem($updated_at_from) - $this->calculatePriceTotalHoursStudiedOfForeignTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to);
    }

    public function calculatePriceTotalHoursStudiedOfTutorByCuoiKyForOrderItem($updated_at_from, $updated_at_to)
    {
        return $this->calculatePriceTotalHoursStudiedOfTutorByDauKyForOrderItem($updated_at_from) - $this->calculatePriceTotalHoursStudiedOfTutorByTrongKyForOrderItem($updated_at_from, $updated_at_to);
    }

    // Giá trị số giờ đã học luỹ kế
    public function getPriceTotalHoursByLuyKe( $updated_at_to)
    {
        $priceTotalHoursByLuyKe= $this->getPriceVnHoursByLuyKe( $updated_at_to) + $this->getPriceForeignHoursByLuyKe( $updated_at_to)+ $this->getPriceTutorHoursByLuyKe( $updated_at_to);

        return $priceTotalHoursByLuyKe;
    }

    // Giá trị số giờ GVVN đã học luỹ kế
    public function getPriceVnHoursByLuyKe($updated_at_to)
    {
        $priceVnHoursByLuyKe = $this->getPriceVnTeacherHour() *  $this->getVNHourLuyKe($updated_at_to);

        return $priceVnHoursByLuyKe;
    }

    // Giá trị số giờ GVNN đã học luỹ kế
    public function getPriceForeignHoursByLuyKe($updated_at_to)
    {
        $priceForeignHoursByLuyKe = $this->getPriceForeignTeacherHour() *  $this->getForeignHourLuyKe($updated_at_to);

        return $priceForeignHoursByLuyKe;
    }

    // Giá trị số giờ Gia sư đã học luỹ kế
    public function getPriceTutorHoursByLuyKe($updated_at_to)
    {
        $priceForeignHoursByLuyKe = $this->getPriceTutorHour() *  $this->getTutorHourLuyKe($updated_at_to);

        return $priceForeignHoursByLuyKe;
    }

    // Số giờ đầu kỳ
    // Giờ tồn đầu kỳ tổng
    public function getTotalHourDauKy($updated_at_from)
    {
        // Trừ đi 1 ngày
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');

        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->getTotalMinutes() - $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_from)['sumMinutesTotal'];
        $HourDauKy = $remainingHours;

        return $HourDauKy;
    }

    // Giờ tồn đầu kỳ VN
    public function getVNHourDauKy($updated_at_from)
    {
        // Trừ đi 1 ngày
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $remainingHours = $this->getTotalVnMinutes() - $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_from)['sumMinutesVNTeacher'];
        $HourDauKy = $remainingHours;

        return $HourDauKy;
    }

    // Giờ tồn đầu kỳ Foreign
    public function getForeignHourDauKy($updated_at_from)
    {
        // Trừ đi 1 ngày
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $remainingHours = $this->getTotalForeignMinutes() - $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_from)['sumMinutesForeignTeacher'];
        $HourDauKy = $remainingHours;

        return $HourDauKy;
    }

    //Giờ tồn đầu kỳ Gia sư
    public function getTutorHourDauKy($updated_at_from)
    {
        // Trừ đi 1 ngày
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $remainingHours = $this->getTotalTutorMinutes() - $this->studyHoursByDay($this, $this->orders->contacts, $updated_at_from)['sumMinutesTutor'];
        $HourDauKy = $remainingHours;

        return $HourDauKy;
    }

    //Giá trị số giờ đã học đầu kỳ
    public function getPriceTotalHoursByDauKy($updated_at_from)
    {
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $priceTotalHoursByDauKy = $this->getPriceVnHoursByDauKy($updated_at_from) + $this->getPriceForeignHoursByDauKy($updated_at_from) + $this->getPriceTutorHoursByDauKy($updated_at_from);

        return $priceTotalHoursByDauKy;
    }

    //Giá trị số giờ GVVN đã học đầu kỳ
    public function getPriceVnHoursByDauKy($updated_at_from)
    {
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $priceVnHoursByDauKy = $this->getPriceVnTeacherHour() *  $this->getVNHourDauKy($updated_at_from) / 60;

        return $priceVnHoursByDauKy;
    }

    //Giá trị số giờ GVNN đã học đầu kỳ
    public function getPriceForeignHoursByDauKy($updated_at_from)
    {
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $priceForeignHoursByDauKy = $this->getPriceForeignTeacherHour() *  $this->getForeignHourDauKy($updated_at_from) / 60;

        return $priceForeignHoursByDauKy;
    }

    //Giá trị số giờ Gia sư đã học đầu kỳ
    public function getPriceTutorHoursByDauKy($updated_at_from)
    {
        $updated_at_from = Carbon::parse($updated_at_from);
        $updated_at_from->subDay();
        $updated_at_from = $updated_at_from->format('Y-m-d');
        $priceForeignHoursByDauKy = $this->getPriceTutorHour() *  $this->getTutorHourDauKy($updated_at_from) / 60;

        return $priceForeignHoursByDauKy;
    }

    //Số giờ trong kỳ
    //Giờ đã học trong kỳ tổng
    public function getTotalHourTrongKy($updated_at_from, $updated_at_to)
    {
        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->studyHoursByTrongKy($this, $this->orders->contacts, $updated_at_from, $updated_at_to)['sumMinutesTotal'];
        $HourTrongKy = $remainingHours;

        return $HourTrongKy;
    }

    //Giờ đã học trong kỳ VN
    public function getVNHourTrongKy($updated_at_from, $updated_at_to)
    {
        $remainingHours = $this->studyHoursByTrongKy($this, $this->orders->contacts, $updated_at_from, $updated_at_to)['sumMinutesVNTeacher'];
        $HourTrongKy = $remainingHours;

        return $HourTrongKy;
    }

    //Giờ đã học trong kỳ Foreign
    public function getForeignHourTrongKy($updated_at_from, $updated_at_to)
    {
        $remainingHours = $this->studyHoursByTrongKy($this, $this->orders->contacts, $updated_at_from, $updated_at_to)['sumMinutesForeignTeacher'];
        $HourTrongKy = $remainingHours;

        return $HourTrongKy;
    }

    //Giờ đã học trong kỳ Gia sư
    public function getTutorHourTrongKy($updated_at_from, $updated_at_to)
    {
        $remainingHours = $this->studyHoursByTrongKy($this, $this->orders->contacts, $updated_at_from, $updated_at_to)['sumMinutesTutor'];
        $HourTrongKy = $remainingHours;

        return $HourTrongKy;
    }

    //Giá trị số giờ đã học trong kỳ
    public function getPriceTotalHoursByTrongKy($updated_at_from, $updated_at_to)
    {
        $priceTotalHoursByTrongKy = $this->getPriceVnHoursByTrongKy($updated_at_from, $updated_at_to) + $this->getPriceForeignHoursByTrongKy($updated_at_from, $updated_at_to) + $this->getPriceTutorHoursByTrongKy($updated_at_from, $updated_at_to);

        return $priceTotalHoursByTrongKy;
    }

    //Giá trị số giờ GVVN đã học trong kỳ
    public function getPriceVnHoursByTrongKy($updated_at_from, $updated_at_to)
    {
        $priceVnHoursByTrongKy = $this->getPriceVnTeacherHour() *  $this->getVNHourTrongKy($updated_at_from, $updated_at_to) / 60;

        return $priceVnHoursByTrongKy;
    }

    //Giá trị số giờ GVNN đã học trong kỳ
    public function getPriceForeignHoursByTrongKy($updated_at_from, $updated_at_to)
    {
        $priceForeignHoursByTrongKy = $this->getPriceForeignTeacherHour() *  $this->getForeignHourTrongKy($updated_at_from, $updated_at_to) / 60;

        return $priceForeignHoursByTrongKy;
    }

    //Giá trị số giờ Gia sư đã học trong kỳ
    public function getPriceTutorHoursByTrongKy($updated_at_from, $updated_at_to)
    {
        $priceForeignHoursByTrongKy = $this->getPriceTutorHour() *  $this->getTutorHourTrongKy($updated_at_from, $updated_at_to) / 60;

        return $priceForeignHoursByTrongKy;
    }

    public function studyHoursByTrongKy($orderItem, $contact, $updated_at_from, $updated_at_to)
    {
        $courseStudents = $orderItem->courseStudents;
        $allSections = [];

        foreach ($courseStudents as $courseStudent) {
            $sections = $courseStudent->course->sections;
            $allSections = array_merge($allSections, $sections->toArray());
        }

        $studentSection = new StudentSection();
        $remainingHours = $studentSection->studyHoursByTrongKy($contact, $allSections, $updated_at_from, $updated_at_to);

        return $remainingHours;
    }

    //Số giờ cuối kỳ
    //Giờ tồn cuối kỳ tổng
    public function getTotalHourCuoiKy($updated_at_to)
    {
        // Trừ đi 1 ngày
        // $totalHourse = $this->getTotalMinutes(); 
        $remainingHours = $this->getTotalMinutes() - $this->studyHoursByEndDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesTotal'];
        $HourCuoiKy = $remainingHours;

        return $HourCuoiKy;
    }

    //Giờ tồn cuối kỳ VN
    public function getVNHourCuoiKy($updated_at_to)
    {
        // Trừ đi 1 ngày
        $updated_at_to = Carbon::parse($updated_at_to);
        $updated_at_to->addDay();
        $updated_at_to = $updated_at_to->format('Y-m-d');

        $remainingHours = $this->getTotalVnMinutes() - $this->studyHoursByEndDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesVNTeacher'];
        $HourCuoiKy = $remainingHours;

        return $HourCuoiKy;
    }

    //Giờ tồn cuối kỳ Foreign
    public function getForeignHourCuoiKy($updated_at_to)
    {
        // Trừ đi 1 ngày
        $remainingHours = $this->getTotalForeignMinutes() - $this->studyHoursByEndDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesForeignTeacher'];
        $HourCuoiKy = $remainingHours;

        return $HourCuoiKy;
    }

    //Giờ tồn cuối kỳ Gia sư
    public function getTutorHourCuoiKy($updated_at_to)
    {
        // Trừ đi 1 ngày
        $remainingHours = $this->getTotalTutorMinutes() - $this->studyHoursByEndDay($this, $this->orders->contacts, $updated_at_to)['sumMinutesTutor'];
        $HourCuoiKy = $remainingHours;

        return $HourCuoiKy;
    }

    //Giá trị số giờ đã học cuối kỳ
    public function getPriceTotalHoursByCuoiKy($updated_at_to)
    {
        $priceTotalHoursByCuoiKy = $this->getPriceVnHoursByCuoiKy($updated_at_to) + $this->getPriceForeignHoursByCuoiKy($updated_at_to) + $this->getPriceTutorHoursByCuoiKy($updated_at_to);

        return $priceTotalHoursByCuoiKy;
    }

    //Giá trị số giờ GVVN đã học cuối kỳ
    public function getPriceVnHoursByCuoiKy($updated_at_to)
    {
        $priceVnHoursByCuoiKy = $this->getPriceVnTeacherHour() *  $this->getVNHourCuoiKy($updated_at_to) / 60;

        return $priceVnHoursByCuoiKy;
    }

    //Giá trị số giờ GVNN đã học cuối kỳ
    public function getPriceForeignHoursByCuoiKy($updated_at_to)
    {
        $priceForeignHoursByCuoiKy = $this->getPriceForeignTeacherHour() *  $this->getForeignHourCuoiKy($updated_at_to) / 60;

        return $priceForeignHoursByCuoiKy;
    }

    //Giá trị số giờ Gia sư đã học cuối kỳ
    public function getPriceTutorHoursByCuoiKy($updated_at_to)
    {
        $priceForeignHoursByCuoiKy = $this->getPriceTutorHour() *  $this->getTutorHourCuoiKy($updated_at_to) / 60;

        return $priceForeignHoursByCuoiKy;
    }

    public function studyHoursByEndDay($orderItem, $contact, $day)
    {
        $courseStudents = $orderItem->courseStudents;
        $allSections = [];

        foreach ($courseStudents as $courseStudent) {
            $sections = $courseStudent->course->sections;
            $allSections = array_merge($allSections, $sections->toArray());
        }

        $studentSection = new StudentSection();
        $remainingHours = $studentSection->studyHoursByEndDay($contact, $allSections, $day);

        return $remainingHours;
    }

    public function copyFromRequest($orderItem)
    {
        DB::beginTransaction();

        try {
            $newOrderItem = new OrderItem();

            $newOrderItem->status = 'active';
            $newOrderItem->order_id = $orderItem->order_id;
            $newOrderItem->type = $orderItem->type;
            $newOrderItem->order_type = $orderItem->order_type;
            $newOrderItem->price = $orderItem->price;
            // $newOrderItem->currency_code = $orderItem->currency_code;
            $newOrderItem->level = $orderItem->level;
            $newOrderItem->class_type = $orderItem->class_type;
            $newOrderItem->num_of_student = $orderItem->num_of_student;
            $newOrderItem->study_type = $orderItem->study_type;
            $newOrderItem->vietnam_teacher_minutes_per_section = $orderItem->vietnam_teacher_minutes_per_section;
            $newOrderItem->foreign_teacher_minutes_per_section = $orderItem->foreign_teacher_minutes_per_section;
            $newOrderItem->tutor_minutes_per_section = $orderItem->tutor_minutes_per_section;
            $newOrderItem->target = $orderItem->target;
            $newOrderItem->home_room = $orderItem->home_room;
            $newOrderItem->apply_time = $orderItem->apply_time;
            $newOrderItem->top_school = $orderItem->top_school;
            $newOrderItem->current_program_id = $orderItem->current_program_id;
            $newOrderItem->std_score = $orderItem->std_score;
            $newOrderItem->eng_score = $orderItem->eng_score;
            $newOrderItem->plan_apply_program_id = $orderItem->plan_apply_program_id;
            $newOrderItem->intended_major_id = $orderItem->intended_major_id;
            $newOrderItem->academic_award_1 = $orderItem->academic_award_1;
            $newOrderItem->academic_award_2 = $orderItem->academic_award_2;
            $newOrderItem->academic_award_3 = $orderItem->academic_award_3;
            $newOrderItem->academic_award_4 = $orderItem->academic_award_4;
            $newOrderItem->academic_award_5 = $orderItem->academic_award_5;
            $newOrderItem->academic_award_6 = $orderItem->academic_award_6;
            $newOrderItem->academic_award_7 = $orderItem->academic_award_7;
            $newOrderItem->academic_award_8 = $orderItem->academic_award_8;
            $newOrderItem->academic_award_9 = $orderItem->academic_award_9;
            $newOrderItem->academic_award_10 = $orderItem->academic_award_10;
            $newOrderItem->academic_award_text_1 = $orderItem->academic_award_text_1;
            $newOrderItem->academic_award_text_2 = $orderItem->academic_award_text_2;
            $newOrderItem->academic_award_text_3 = $orderItem->academic_award_text_3;
            $newOrderItem->academic_award_text_4 = $orderItem->academic_award_text_4;
            $newOrderItem->academic_award_text_5 = $orderItem->academic_award_text_5;
            $newOrderItem->academic_award_text_6 = $orderItem->academic_award_text_6;
            $newOrderItem->academic_award_text_7 = $orderItem->academic_award_text_7;
            $newOrderItem->academic_award_text_8 = $orderItem->academic_award_text_8;
            $newOrderItem->academic_award_text_9 = $orderItem->academic_award_text_9;
            $newOrderItem->academic_award_text_10 = $orderItem->academic_award_text_10;
            $newOrderItem->grade_1 = $orderItem->grade_1;
            $newOrderItem->grade_2 = $orderItem->grade_2;
            $newOrderItem->grade_3 = $orderItem->grade_3;
            $newOrderItem->grade_4 = $orderItem->grade_4;
            $newOrderItem->point_1 = $orderItem->point_1;
            $newOrderItem->point_2 = $orderItem->point_2;
            $newOrderItem->point_3 = $orderItem->point_3;
            $newOrderItem->point_4 = $orderItem->point_4;
            $newOrderItem->postgraduate_plan = $orderItem->postgraduate_plan;
            $newOrderItem->personality = $orderItem->personality;
            $newOrderItem->subject_preference = $orderItem->subject_preference;
            $newOrderItem->language_culture = $orderItem->language_culture;
            $newOrderItem->research_info = $orderItem->research_info;
            $newOrderItem->aim = $orderItem->aim;
            $newOrderItem->essay_writing_skill = $orderItem->essay_writing_skill;
            $newOrderItem->extra_activity_1 = $orderItem->extra_activity_1;
            $newOrderItem->extra_activity_2 = $orderItem->extra_activity_2;
            $newOrderItem->extra_activity_3 = $orderItem->extra_activity_3;
            $newOrderItem->extra_activity_4 = $orderItem->extra_activity_4;
            $newOrderItem->extra_activity_5 = $orderItem->extra_activity_5;
            $newOrderItem->extra_activity_text_1 = $orderItem->extra_activity_text_1;
            $newOrderItem->extra_activity_text_2 = $orderItem->extra_activity_text_2;
            $newOrderItem->extra_activity_text_3 = $orderItem->extra_activity_text_3;
            $newOrderItem->extra_activity_text_4 = $orderItem->extra_activity_text_4;
            $newOrderItem->extra_activity_text_5 = $orderItem->extra_activity_text_5;
            $newOrderItem->personal_countling_need = $orderItem->personal_countling_need;
            $newOrderItem->other_need_note = $orderItem->other_need_note;
            $newOrderItem->parent_job = $orderItem->parent_job;
            $newOrderItem->parent_highest_academic = $orderItem->parent_highest_academic;
            $newOrderItem->is_parent_studied_abroad = $orderItem->is_parent_studied_abroad;
            $newOrderItem->parent_income = $orderItem->parent_income;
            $newOrderItem->parent_familiarity_abroad = $orderItem->parent_familiarity_abroad;
            $newOrderItem->is_parent_family_studied_abroad = $orderItem->is_parent_family_studied_abroad;
            $newOrderItem->parent_time_spend_with_child = $orderItem->parent_time_spend_with_child;
            $newOrderItem->financial_capability = $orderItem->financial_capability;
            $newOrderItem->schedule_items = $orderItem->schedule_items;
            // $newOrderItem->created_at = $orderItem->created_at;
            // $newOrderItem->updated_at = $orderItem->updated_at;
            $newOrderItem->estimated_enrollment_time = $orderItem->estimated_enrollment_time;
            $newOrderItem->subject_id = $orderItem->subject_id;
            $newOrderItem->num_of_vn_teacher_sections = $orderItem->num_of_vn_teacher_sections;
            $newOrderItem->num_of_foreign_teacher_sections = $orderItem->num_of_foreign_teacher_sections;
            $newOrderItem->num_of_tutor_sections = $orderItem->num_of_tutor_sections;
            $newOrderItem->training_location_id = $orderItem->training_location_id;
            $newOrderItem->vn_teacher_price = $orderItem->vn_teacher_price;
            $newOrderItem->foreign_teacher_price = $orderItem->foreign_teacher_price;
            $newOrderItem->tutor_price = $orderItem->tutor_price;

            $newOrderItem->save();

            $revenueDistributions = $orderItem->revenueDistributions()->get();

            // Copy revenue distributions
            if ($revenueDistributions->count() > 0) {
                foreach($revenueDistributions as $revenueDistribution) {
                    RevenueDistribution::create([
                        'order_item_id' => $newOrderItem->id,
                        'account_id' => $revenueDistribution->account_id,
                        'amount' => $revenueDistribution->amount,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $newOrderItem;
    }

    public function trainingLocation()
    {
        return $this->belongsTo(TrainingLocation::class);
    }

    public function abroadApplications()
    {
        return $this->hasMany(AbroadApplication::class);
    }

    public function getLocationBranch()
    {
        $this->trainingLocation ? $this->trainingLocation->branch : '';
    }

    public function getLocationName()
    {
        $this->trainingLocation ? $this->trainingLocation->name : '';
    }

    public function getTrainingLocationBranch()
    {
        return $this->trainingLocation ? $this->trainingLocation->branch : '';
    }

    public function getTrainingLocationName()
    {
        return $this->trainingLocation ? $this->trainingLocation->name : '';
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

    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('order', function ($q1) use ($branch) {
            $q1->byBranch($branch);
        });
    }
    public function scopeByBranchEdu($query, $branch)
    {
        return $query->whereHas('training_location', function ($q1) use ($branch) {
            $q1->byBranch($branch); 
        });
    }
    
    public function scopeOrderIsApproved($query)
    {
        return $query->whereNotNull('order_id')
            ->whereHas('orders', function ($query) {
                $query->where('status', 'approved');
            });
    }

    public function getUserSale()
    {
        $user = $this->order->salesperson->users()->get();

        return $user;
    }

    public function getUserStudent()
    {
        $account =  Account::where('student_id', $this->order->contact_id)->first();

        if ($account) {
            $user = User::where('account_id', $account->id)->first();
            return $user;
        }

        return null;
    }

    public static function  scopeFilterOrderApproved($query)
    {

        $query->whereHas('order', function ($query) {
            $query->where('status', [Order::STATUS_APPROVED]);
        });
    }

    public function getTopSchool()
    {
        $topSchoolArray = json_decode($this->top_school, true);

        if (is_null($topSchoolArray) || empty($topSchoolArray)) {
            return [];
        }

        return $topSchoolArray;
    }

    public static function getAbroadBranchs()
    {
        return [
            self::ABROAD_BRANCH_HN,
            self::ABROAD_BRANCH_SG,
        ];
    }

    public function calculateEduPriceKPINote($order, $accountKpiNote)
    {
        if ($this->subject_id === $accountKpiNote->subject_id) {
            $price = ($this->getTotalPriceOfEdu() / $order->getTotalPriceOfItems()) * $order->sumAmountPaid();

            return $price;
        }

        return null;
    }

    public function isThesisSupport()
    {
        return $this->is_thesis_port;
    }

    public function isExtraSupport()
    {
        return $this->is_extra_port;
    }

    public function scopeThesisSupport($query)
    {
        $query->where('type', Order::TYPE_ABROAD)
            ->where('is_thesis_port', true);
    }

    public function scopeExtraSupport($query)
    {
        $query->where('type', Order::TYPE_ABROAD)
            ->where('is_extra_port', true);
    }

    public static function exportStudentReport($templatePath, $filterStudentReport, $updated_at_to, $updated_at_from)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 2;



        foreach ($filterStudentReport as $orderItem) {
            $courseList = $orderItem->courseList();
            if ($courseList->isNotEmpty()) {
                $codes = [];
                foreach ($courseList as $course) {
                    $codes[] = $course->code;
                }
                $code = implode(' ', $codes);  // Khoảng trắng
            } else {
                $code = 'Chưa xếp lớp';
            }
            //Khóa học
            $totalKhoaHoc = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['sum_minutes'];
            $hoursTotalKhoaHoc = floor($totalKhoaHoc / 60);
            $minutesTotalKhoaHoc = $totalKhoaHoc % 60;

            $totalKhoaHocOfForeign = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['foreign_teacher_minutes'];
            $hourKhoaHocOfForeignTeacher = floor($totalKhoaHocOfForeign / 60);
            $minutesKhoaHocOfForeignTeacher = $totalKhoaHocOfForeign % 60;

            $totalKhoaHocOfVNTeacher = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['vn_teacher_minutes'];
            $hourKhoaHocOfVNTeacher = floor($totalKhoaHocOfVNTeacher / 60);
            $minutesKhoaHocOfVNTeacher = $totalKhoaHocOfVNTeacher % 60;

            $totalKhoaHocOfTutor = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['tutor_minutes'];
            $hourKhoaHocOfTutor = floor($totalKhoaHocOfTutor / 60);
            $minutesKhoaHocOfTutor = $totalKhoaHocOfTutor % 60;


            //Lũy kế
            $totaLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['sum_minutes'];
            $hourTotalLuyKe = floor($totaLuyKe / 60);
            $minutesTotalLuyKe = $totaLuyKe % 60;

            $vnTeacherLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['vn_teacher_minutes'];
            $hourVnLuyKe = floor($vnTeacherLuyKe / 60);
            $minutesVnLuyKe =  $vnTeacherLuyKe % 60;

            $foreignTeacherLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['foreign_teacher_minutes'];
            $hourForeignLuyKe = floor($foreignTeacherLuyKe / 60);
            $minutesForeignLuyKe = $foreignTeacherLuyKe % 60;

            $tutorLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['tutor_minutes'];
            $hourTutorLuyKe = floor($tutorLuyKe / 60);
            $minutesTutorLuyKe = $tutorLuyKe % 60;

            // Đầu kỳ
            $totaDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['sum_minutes'];
            $hourTotalDauKy = floor($totaDauKy / 60);
            $minutesTotalDauKy = $totaDauKy % 60;

            $vnTeacherDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['vn_teacher_minutes'];
            $hourVnDauKy = floor($vnTeacherDauKy / 60);
            $minutesVnDauKy =  $vnTeacherDauKy % 60;

            $foreignTeacherDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['foreign_teacher_minutes'];
            $hourForeignDauKy = floor($foreignTeacherDauKy / 60);
            $minutesForeignDauKy = $foreignTeacherDauKy % 60;

            $tutorDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['tutor_minutes'];
            $hourTutorDauKy = floor($tutorDauKy / 60);
            $minutesTutorDauKy = $tutorDauKy % 60;


            // Trong kỳ
            $totaTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['sum_minutes'];
            $hourTotalTrongKy = floor($totaTrongKy / 60);
            $minutesTotalTrongKy = $totaTrongKy % 60;

            $vnTeacherTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['vn_teacher_minutes'];
            $hourVnTrongKy = floor($vnTeacherTrongKy / 60);
            $minutesVnTrongKy =  $vnTeacherTrongKy % 60;

            $foreignTeacherTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['foreign_teacher_minutes'];
            $hourForeignTrongKy = floor($foreignTeacherTrongKy / 60);
            $minutesForeignTrongKy = $foreignTeacherTrongKy % 60;

            $tutorTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['tutor_minutes'];
            $hourTutorTrongKy = floor($tutorTrongKy / 60);
            $minutesTutorTrongKy = $tutorTrongKy % 60;

            // Cuối kỳ
            $totalHoursCuoiKy = $totaDauKy - $totaTrongKy;
            $hourTotalCuoiKy = floor($totalHoursCuoiKy / 60);
            $minutesTotalCuoiKy = $totalHoursCuoiKy % 60;

            $vnHoursCuoiKy = $vnTeacherDauKy - $vnTeacherTrongKy;
            $hourVnCuoiKy = floor($vnHoursCuoiKy / 60);
            $minutesVnCuoiKy = $vnHoursCuoiKy % 60;

            $foreignHoursCuoiKy = $foreignTeacherDauKy - $foreignTeacherTrongKy;
            $hourForeignCuoiKy = floor($foreignHoursCuoiKy / 60);
            $minutesForeignCuoiKy = $foreignHoursCuoiKy % 60;

            $tutorHoursCuoiKy = $tutorDauKy - $tutorTrongKy;
            $hourTutorCuoiKy = floor($tutorHoursCuoiKy / 60);
            $minutesTutorCuoiKy = $tutorHoursCuoiKy % 60;

            $rowData = [
                $orderItem->orders->contacts->code, // Mã học viên
                $orderItem->orders->contacts->import_id, // Mã cũ học viên
                $orderItem->orders->student->name, // Tên học viên
                $orderItem->subject->name, // Môn học
                $code, // Lớp
                $orderItem->level, //trình độ
                'Tổng',
                $hoursTotalKhoaHoc . 'giờ' . $minutesTotalKhoaHoc . 'phút', // Số giờ khóa học
                $hourTotalLuyKe . 'giờ' . $minutesTotalLuyKe . 'phút', // Số giờ đã học lũy kế
                $hourTotalDauKy . 'giờ' . $minutesTotalDauKy . 'phút', //Số giờ đầu kỳ
                $hourTotalTrongKy . 'giờ' . $minutesTotalTrongKy . 'phút', // Số giờ trong kỳ
                $hourTotalCuoiKy . 'giờ' . $minutesTotalCuoiKy . 'phút', // Số giờ cuối kỳ
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;

            // Xuất dữ liệu giáo viên nước ngoài
            $rowData = [
                '', // Mã học viên
                '', // Mã cũ học viên
                '', // Tên học viên
                '', // Môn học
                '', // Lớp
                '', // Trình độ
                'Giáo viên nước ngoài',
                $hourKhoaHocOfForeignTeacher . 'giờ' . $minutesKhoaHocOfForeignTeacher . 'phút', // Số giờ khóa học của giáo viên nước ngoài
                $hourForeignLuyKe . 'giờ' . $minutesForeignLuyKe . 'phút', // Số giờ đã học lũy kế
                $hourForeignDauKy . 'giờ' . $minutesForeignDauKy . 'phút', // Số giờ đầu kỳ
                $hourForeignTrongKy . 'giờ' . $minutesForeignTrongKy . 'phút', // Số giờ trong kỳ
                $hourForeignCuoiKy . 'giờ' . $minutesForeignCuoiKy . 'phút', // Số giờ cuối kỳ
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;

            // Xuất dữ Gia sư
            $rowData = [
                '', // Mã học viên
                '', // Mã cũ học viên
                '', // Tên học viên
                '', // Môn học
                '', // Lớp
                '', // Trình độ
                'Gia sư',
                $hourKhoaHocOfTutor . 'giờ' . $minutesKhoaHocOfTutor . 'phút', // Số giờ khóa học của giáo viên gia sư
                $hourTutorLuyKe . 'giờ' . $minutesTutorLuyKe . 'phút', // Số giờ đã học lũy kế
                $hourTutorDauKy . 'giờ' . $minutesTutorDauKy . 'phút', // Số giờ đầu kỳ
                $hourTutorTrongKy . 'giờ' . $minutesTutorTrongKy . 'phút', // Số giờ trong kỳ
                $hourTutorCuoiKy . 'giờ' . $minutesTutorCuoiKy . 'phút', // Số giờ cuối kỳ
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;

            // Giáo viên Việt Nam
            $rowData = [
                '', // Mã học viên
                '', // Mã cũ học viên
                '', // Tên học viên
                '', // Môn học
                '', // Lớp
                '', // Trình độ
                'Giáo viên Việt Nam',
                $hourKhoaHocOfVNTeacher . 'giờ' . $minutesKhoaHocOfVNTeacher . 'phút', // Số giờ khóa học của giáo viên VN
                $hourVnLuyKe . 'giờ' . $minutesVnLuyKe . 'phút', // Số giờ đã học lũy kế
                $hourVnDauKy . 'giờ' . $minutesVnDauKy . 'phút', // Số giờ đầu kỳ
                $hourVnTrongKy . 'giờ' . $minutesVnTrongKy . 'phút', // Số giờ trong kỳ
                $hourVnCuoiKy . 'giờ' . $minutesVnCuoiKy . 'phút', // Số giờ cuối kỳ
            ];
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }
}
