<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ExcelData;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Course;
use App\Models\PlanApplyProgram;
use Carbon\Carbon;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TrainingLocation;
use App\Models\ContactRequest;
use App\Models\AbroadApplication;
use Illuminate\Support\Facades\File;

class InitOrderProductionSeeder extends Seeder
{
    private $errors = [];
    private $warnings = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::query()->delete();
        OrderItem::query()->delete();

        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::ORDER_SHEET_CONTACT_REQUEST, 6);
        $levels = $excelFile->getDataFromSheet(ExcelData::LEVEL_SHEET_NAME, 2);
        $currId = null;
        $currOrder = null;
        
        $count = 0;

        foreach($datas as $key => $data) 
        {
            $count++;
            echo("\033[1m\033[32m---------------------------------------------- ROW: " . $key + 6 . "(count: ". $count .")\033[0m\n");

            if ($currId != $data[0]) {
                $currId = $data[0];

                //
                if ($currOrder) {
                    $oldOrder = $currOrder;
                    $oldOrder->duyethopdong();
                    // Handle assign abroad application here if type is abroad
                    if ($oldOrder->type == Order::TYPE_ABROAD) {
                        if ($data[32]) {
                            $staffInstance = Account::where('name', $data[32])->first();

                            if ($staffInstance) {
                                $orderItems = $oldOrder->orderItems;

                                foreach($orderItems as $orderItem) {
                                    $abroadApplication = AbroadApplication::where('order_item_id', $orderItem->id)->first();
                                    $abroadApplication->assignToAbroadApplicatonTTSK($staffInstance->id);
                                }
                            }
                        }

                        if ($data[33]) {
                            $staffInstance = Account::where('name', $data[33])->first();

                            if ($staffInstance) {
                                $orderItems = $oldOrder->orderItems;

                                foreach($orderItems as $orderItem) {
                                    $abroadApplication = AbroadApplication::where('order_item_id', $orderItem->id)->first();
                                    $abroadApplication->assignToAbroadApplicatonTVCL($staffInstance->id);
                                }
                            }
                        }
                    }
                }

                $currOrder = $this->addOrder($key + 6, $data);

                if ($currOrder) {
                    $this->addOrderItem($key + 6, $currOrder, $data, $levels);
                } else {
                    $currId = null;
                    $currOrder = null;
                }
            } elseif ($currOrder) {
                $this->addOrderItem($key + 6, $currOrder, $data, $levels);
            }

            echo("\n");
            echo("\n");
            echo("\n");
        }

        $this->exportErrorsAndWarnings();
    }

    public function addOrder($rowNumber, $data)
    {
        [
            $id, $contact_id, $sale, $sale_sup,
            $type, $status, $price, $currency_code,
            $discount_code, $is_pay_all, $schedule_items,
            $contact_request_id, $order_date, $debt_due_date,
            $order_type, $level, $class_type, $num_of_student,
            $study_type, $vietnam_teacher_minutes_per_section,
            $foreign_teacher_minutes_per_section, $tutor_minutes_per_section,
            $target, $subject_id, $num_of_vn_teacher_sections, $num_of_foreign_teacher_sections,
            $num_of_tutor_sections, $home_room, $vn_teacher_price, $foreign_teacher_price, 
            $tutor_price, $training_location_id, $extracurricular_staff, $abroad_staff, 
            $apply_time, $estimated_enrollment_time, $std_score, $eng_score, 
            $postgraduate_plan, $personality, $subject_preference, $language_culture, 
            $research_info, $aim, $essay_writing_skill, $personal_countling_need,
            $other_need_note, $parent_job, $parent_highest_academic, $is_parent_studied_abroad, 
            $parent_income, $parent_familiarity_abroad, $is_parent_family_studied_abroad, 
            $parent_time_spend_with_child, $financial_capability, $num_of_school_from, $top_school, 
            $country, $academic_award_1, $academic_award_text_1, $academic_award_2, 
            $academic_award_text_2, $academic_award_3, $academic_award_text_3, $academic_award_4, 
            $academic_award_text_4, $academic_award_5, $academic_award_text_5, $academic_award_6, 
            $academic_award_text_6, $academic_award_7, $academic_award_text_7, $academic_award_8, 
            $academic_award_text_8, $academic_award_9, $academic_award_text_9, $academic_award_10, 
            $academic_award_text_10, $extra_activity_1, $extra_activity_text_1, $extra_activity_2, 
            $extra_activity_text_2, $extra_activity_3, $extra_activity_text_3, $extra_activity_4, 
            $extra_activity_text_4, $extra_activity_5, $extra_activity_text_5, $grade_1, $point_1, 
            $grade_2, $point_2, $grade_3, $point_3, $grade_4, $point_4, $current_program_id, 
            $plan_apply_program_id, $intended_major_id, $abroad_branch
        ] = $data;

        // Order data
        $id = trim($id);
        $contact_id = trim($contact_id);
        $sale = trim($sale);
        $sale_sup = trim($sale_sup);
        $type = trim($type);
        $status = trim($status);
        $price = trim($price);
        $currency_code = trim($currency_code);
        $discount_code = trim($discount_code);
        $is_pay_all = trim($is_pay_all);
        $schedule_items = trim($schedule_items);
        $contact_request_id = trim($contact_request_id);
        $order_date = trim($order_date);
        $debt_due_date = trim($debt_due_date);

        $failCheck = false;

        // Check contacts
        if (!Contact::count()) {
            echo("  \033[1m\033[31mERROR\033[0m  : Hiện tại DB không có dữ liệu khách hàng (contact) nào!\n");
            $this->addError($rowNumber, "Hiện tại DB không có dữ liệu khách hàng (contact) nào!", $data);
            // return;
            $failCheck = true;
        }

        if (!Subject::count()) {
            echo("  \033[1m\033[31mERROR\033[0m  : Hiện tại DB không có dữ liệu môn học (subject) nào!\n");
            $this->addError($rowNumber, "Hiện tại DB không có dữ liệu môn học (subject) nào!", $data);
            // return;
            $failCheck = true;
        }

        if (!ContactRequest::count()) {
            echo("  \033[1m\033[31mERROR\033[0m  : Hiện tại DB không có dữ liệu đơn hàng (contact request) nào!\n");
            $this->addError($rowNumber, "Hiện tại DB không có dữ liệu đơn hàng (contact request) nào!", $data);
            // return;
            $failCheck = true;
        }

        // if ($id == '') {
        //     echo("  \033[1m\033[31mERROR\033[0m  : Id: " . $id . " không hợp lệ!\n");
        //     $this->addError($rowNumber, "Id: " . $id . " không hợp lệ!", $data);
        //     // return;
        //     $failCheck = true;
        // }

        // if ($id == '#N/A') {
        //     echo("  \033[1m\033[31mERROR\033[0m  : Id: " . $id . " không hợp lệ!\n");
        //     $this->addError($rowNumber, "Id: " . $id . " không hợp lệ!", $data);
        //     // return;
        //     $failCheck = true;
        // }

        if ($id == '') {
            $id = null;
        }

        if ($id == '#N/A') {
            $id = null;
        }

        // Validate contact id
        if ($contact_id === '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có contact_id!\n");
            $this->addError($rowNumber, "Không có contact_id!", $data);
            // return;
            $failCheck = true;
        }

        $contacts;
        
        // Temporary
        if (Contact::count()) {
            $contacts = Contact::where('import_id', $contact_id)->get();

            if ($contacts->count() > 1) {
                echo("  \033[1m\033[31mERROR\033[0m  : Đang có nhiều hơn 1 contact trùng import_id: " . $contact_id . " - Kiểm tra lại!\n");
                $this->addError($rowNumber, "Đang có nhiều hơn 1 contact trùng import_id: " . $contact_id . " - Kiểm tra lại!", $data);
            }
    
            if ($contacts->count() == 0) {
                echo("  \033[1m\033[31mERROR\033[0m  : Không thể tạo hợp đồng do không tìm thấy contact có import_id: " . $contact_id . "\n");
                $this->addError($rowNumber, "Không thể tạo hợp đồng do không tìm thấy contact có import_id: " . $contact_id . "!" .$id, $data);
                // return;
                $failCheck = true;
            }
        } else {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có contact nào trong dữ liệu!\n");
            $this->addError($rowNumber, "Không có contact nào trong dữ liệu!", $data);
            // return;
            $failCheck = true;
        }

        if ($schedule_items == '') {
            $schedule_items = null;
        } else {
            $tmp = json_encode($schedule_items);
            $schedule_items = $tmp;
        }

        // Validate order type
        if ($type === '') {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có type!\n");
            $this->addError($rowNumber, "Không có type!", $data);
            // return;
            $failCheck = true;
        }

        $typeAccept;

        switch($type) {
            case "Đào tạo": 
                $typeAccept = Order::TYPE_EDU;
                break;
            case "Du học":
                $typeAccept = Order::TYPE_ABROAD;
                break;
            case "Ngại khóa":
                $typeAccept = Order::TYPE_EXTRACURRICULAR;
                break;
            case "Demo":
                $typeAccept = Order::TYPE_REQUEST_DEMO;
                break;
            default:
                $typeAccept = null;
        }

        if (!$typeAccept) {
            echo("  \033[1m\033[31mERROR\033[0m  : Loại hợp đồng " . $type . " không hợp lệ!\n");
            $this->addError($rowNumber, "Loại hợp đồng " . $type . " không hợp lệ!", $data);
            // return;
            $failCheck = true;
        }

        // Validate order status
        if ($status === '') {
            $status = 'Đã được duyệt';
        }

        $statusAccept;

        switch($status) {
            case "Nháp": 
                $statusAccept = Order::STATUS_DRAFT;
                break;
            case "Đang chờ":
                $statusAccept = Order::STATUS_PENDING;
                break;
            case "Đã được duyệt":
                $statusAccept = Order::STATUS_APPROVED;
                break;
            case "Từ chối duyệt":
                $statusAccept = Order::STATUS_REJECTED;
                break;
            default:
                $statusAccept = null;
        }

        if (!$statusAccept) {
            echo("  \033[1m\033[31mERROR\033[0m  : Trạng thái hợp đồng (status): " . $status . " không hợp lệ!\n");
            $this->addError($rowNumber, "Trạng thái hợp đồng (status): " . $status . " không hợp lệ!", $data);
            // return;
            $failCheck = true;
        }

        $priceConverted = 0;

        if ($price != '') {
            $priceConverted = $this->convertStringPriceToNumber($price);
    
            if (!$priceConverted) {
                echo("  \033[1m\033[31mERROR\033[0m  : Giá: " . $price . " không hợp lệ!\n");
                $this->addError($rowNumber, "Giá: " . $price . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            } 
        }

        $discount_code = 0;

        if ($discount_code !== '') {
            $discountedPercentConverted = $this->convertStringPriceToNumber($discount_code);
    
            if ($discountedPercentConverted !== 0 && !$discountedPercentConverted) {
                echo("  \033[1m\033[31mERROR\033[0m  : Mã giảm giá: " . $discountedPercentConverted . " không hợp lệ!\n");
                $this->addError($rowNumber, "Mã giảm giá: " . $discountedPercentConverted . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            } 
        }

        if ($currency_code === '') {
            $curreny_code = Order::CURRENCY_CODE_VND;
        } else {
            if (!in_array($currency_code, Order::getAllCurrencyCode())) {
                echo("  \033[1m\033[31mERROR\033[0m  : Đơn vị tiền: " . $currency_code . " không hợp lệ! (Nên là: " . Order::getAllCurrencyCode()[0] . " hoặc " . Order::getAllCurrencyCode()[1] . ")\n");
                $this->addError($rowNumber, "Đơn vị tiền: " . $currency_code . " không hợp lệ! (Nên là: " . Order::getAllCurrencyCode()[0] . " hoặc " . Order::getAllCurrencyCode()[1] . ")!", $data);
                // return;
                $failCheck = true;
            }
        }

        if ($failCheck) {
            return;
        }

        if (empty($order_date) ) {
            $order_date = '2024-06-01';
        } else {
            $order_date = \Carbon\Carbon::parse($order_date);
        }

        if ($debt_due_date !== '') {
            if (!boolval(filter_var($debt_due_date, FILTER_VALIDATE_INT))) {
                echo("  \033[1m\033[31mERROR\033[0m  : Ngày thanh toán " . $debt_due_date . " không hợp lệ\n");
                $this->addError($rowNumber, "Ngày thanh toán " . $debt_due_date . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }
         
            $formattedDebtDueDate = \Carbon\Carbon::parse($debt_due_date);
            $debt_due_date = $formattedDebtDueDate;
        }

        $contactRequest = ContactRequest::first();

        $newOrder = Order::create([
            'import_id' => $id,
            'contact_id' => $contacts->first()->id,
            'student_id' => $contacts->first()->id,
            'type' => $typeAccept,
            'status' => $statusAccept,
            'price' => $priceConverted,
            'currency_code' => $currency_code,
            'discount_code' => $discountedPercentConverted,
            'is_pay_all' => $is_pay_all,
            'schedule_items' => $schedule_items,
            'contact_request_id' => $contactRequest->id,
            'order_date' => $order_date,
            'debt_due_date' => $debt_due_date != '' ? $debt_due_date : null,
        ]);

        if ($sale && $sale != '') {
            $saleInstance = Account::where('name', $sale)->first();

            if ($saleInstance) {
                $sale = $saleInstance;
                } else {
                $sale = Account::getDefaultSalesAccount();
            }

            $newOrder->sale = $sale->id;
        }

        if ($sale_sup && $sale_sup != '') {
            $saleSupInstance = Account::where('name', $sale_sup)->first();

            if ($saleSupInstance) {
                $sale_sup = $saleSupInstance;
            } else {
                $sale_sup = Account::getDefaultSalesAccount();
            }

            $newOrder->sale_sup = $sale_sup->id;
        }

        $newOrder->save();

        if (is_null($newOrder->import_id)) {
            $newOrder->generateTemporaryImportIdForWrongImportIdOrder();
            echo("Đã tạo dữ liệu IMPORT_ID tạm thời cho hợp đồng này: \033[1m\033[33m" . $newOrder->import_id . "" . "\033[0m\n");
        }

        $newOrder->generateCode();
        
        // update contact request status + sales
        $contactRequest->account_id = $newOrder->sale;
        $contactRequest->previous_lead_status = $contactRequest->lead_status;
        $contactRequest->lead_status = ContactRequest::LS_HAS_CONSTRACT;
        $contactRequest->last_time_update_status = Carbon::now();
        $contactRequest->save();

        echo("order_date: \033[1m\033[33m" . $order_date . "\033[0m ----> IMPORTED: \033[1m\033[32m" . \Carbon\Carbon::parse($newOrder->order_date) . "\033[0m\n");
        return $newOrder;
    }

    /**
     * Add order item for order per loop
     */
    public function addOrderItem($rowNumber, $order, $data, $levels)
    {
        [
            $id, $contact_id, $sale, $sale_sup,
            $type, $status, $price, $currency_code,
            $discount_code, $is_pay_all, $schedule_items,
            $contact_request_id, $order_date, $debt_due_date,
            $order_type, $level, $class_type, $num_of_student,
            $study_type, $vietnam_teacher_minutes_per_section,
            $foreign_teacher_minutes_per_section, $tutor_minutes_per_section,
            $target, $subject_id, $num_of_vn_teacher_sections, $num_of_foreign_teacher_sections,
            $num_of_tutor_sections, $home_room, $vn_teacher_price, $foreign_teacher_price, 
            $tutor_price, $training_location_id, $extracurricular_staff, $abroad_staff, 
            $apply_time, $estimated_enrollment_time, $std_score, $eng_score, 
            $postgraduate_plan, $personality, $subject_preference, $language_culture, 
            $research_info, $aim, $essay_writing_skill, $personal_countling_need,
            $other_need_note, $parent_job, $parent_highest_academic, $is_parent_studied_abroad, 
            $parent_income, $parent_familiarity_abroad, $is_parent_family_studied_abroad, 
            $parent_time_spend_with_child, $financial_capability, $num_of_school_from, $top_school, 
            $country, $academic_award_1, $academic_award_text_1, $academic_award_2, 
            $academic_award_text_2, $academic_award_3, $academic_award_text_3, $academic_award_4, 
            $academic_award_text_4, $academic_award_5, $academic_award_text_5, $academic_award_6, 
            $academic_award_text_6, $academic_award_7, $academic_award_text_7, $academic_award_8, 
            $academic_award_text_8, $academic_award_9, $academic_award_text_9, $academic_award_10, 
            $academic_award_text_10, $extra_activity_1, $extra_activity_text_1, $extra_activity_2, 
            $extra_activity_text_2, $extra_activity_3, $extra_activity_text_3, $extra_activity_4, 
            $extra_activity_text_4, $extra_activity_5, $extra_activity_text_5, $grade_1, $point_1, 
            $grade_2, $point_2, $grade_3, $point_3, $grade_4, $point_4, $current_program_id, 
            $plan_apply_program_id, $intended_major_id, $abroad_branch
        ] = $data;

        // Order item data
        $order_type = trim($order_type); // can ignore -> use subject_id
        $level = trim($level);
        $class_type = trim($class_type);
        $num_of_student = trim($num_of_student);
        $study_type = trim($study_type);
        $vietnam_teacher_minutes_per_section = trim($vietnam_teacher_minutes_per_section);
        $foreign_teacher_minutes_per_section = trim($foreign_teacher_minutes_per_section);
        $tutor_minutes_per_section = trim($tutor_minutes_per_section);
        $target = trim($target);
        $subject_id = trim($subject_id);
        $num_of_vn_teacher_sections = trim($num_of_vn_teacher_sections);
        $num_of_foreign_teacher_sections = trim($num_of_foreign_teacher_sections);
        $num_of_tutor_sections = trim($num_of_tutor_sections);
        $home_room = trim($home_room);
        $vn_teacher_price = trim($vn_teacher_price);
        $foreign_teacher_price = trim($foreign_teacher_price);
        $tutor_price = trim($tutor_price);
        $training_location_id = trim($training_location_id);
        $extracurricular_staff = trim($extracurricular_staff);
        $abroad_staff = trim($abroad_staff);

        $failCheck = false;

        if ($order->type == ORDER::TYPE_EDU || $order->type == ORDER::TYPE_REQUEST_DEMO) {
            // Handle
            // Validate subject
            if ($subject_id == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu môn học\n");
                $this->addError($rowNumber, "Không có dữ liệu môn học!", $data);
                // return;
                $failCheck = true;
            }
    
            $subject = Subject::where('name', $subject_id)->first();
    
            if (!$subject) {
                echo("  \033[1m\033[31mERROR\033[0m  : Môn học: " . $subject_id . " không tồn tại!\n");
                $this->addError($rowNumber, "Môn học: " . $subject_id . " không tồn tại!", $data);
                // return;
                $failCheck = true;
            }

            // Validate level
            // if ($level == '') {
                // echo("  \033[1m\033[33mWARNING\033[0m: Chưa có dữ liệu trình độ cho dịch vụ\n");
                // $this->addError($rowNumber, "Chưa có dữ liệu trình độ cho dịch vụ!", $data);
            // }

            $levelNames = [];

            foreach ($levels as $item) {
                $levelNames[] = $item[0];
            }

            if ($level != '' && !in_array($level, $levelNames)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Trình độ:" . $level . " không hợp lệ cho dịch vụ!\n");
                $this->addError($rowNumber, "Trình độ:" . $level . " không hợp lệ cho dịch vụ!", $data);
                // return;
                $failCheck = true;
            }

            if ($class_type == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu loại hình lớp học cho dịch vụ!\n");
                $this->addError($rowNumber, "Không có dữ liệu loại hình lớp học cho dịch vụ!", $data);
                // return;
                $failCheck = true;
            }

            // Validate class type
            $classType = null;
            
            if (!$classType && $class_type !== '') {
                $groupKeys = array('óm', 'group', 'ó', 'om', 'nhom', 'nhóm', 'Nhóm', 'oup', 'team');
                
                foreach($groupKeys as $key) {
                    if (str_contains($class_type, $key)) {
                        $classType = 'Nhóm';
                        break;
                    }
                }
            }

            if (!$classType && $class_type !== '') {
                $oneOneKeys = array('1:1', '1-1', 'Một', 'một', 'ột', ':', '1', 'ô');
                
                foreach($oneOneKeys as $key) {
                    if (str_contains($class_type, $key)) {
                        $classType = '1:1';
                        break;
                    }
                }
            }

            if (!$classType) {
                echo("  \033[1m\033[31mERROR\033[0m  : Dữ liệu class type:" . $class_type . " không hợp lệ!\n");
                $this->addError($rowNumber, "Dữ liệu class type:" . $class_type . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            $numOfStudents = $num_of_student;

            if ($num_of_student == '') {
                $numOfStudents = 0; 
            }

            if ($num_of_student !== '' && !filter_var($num_of_student, FILTER_VALIDATE_INT)) {
                $numOfStudents = 0;
            } else {
                $numOfStudents = intval($num_of_student);
            }

            if ($study_type == '') {
                $study_type = Course::STUDY_METHOD_ONLINE;
            }

            if ($study_type != '' && !in_array(strtolower($study_type), array_map('strtolower', config('studyTypes')))) {
                echo("  \033[1m\033[31mERROR\033[0m  : Dữ liệu study_type:" . $study_type . " không hợp lệ!\n");
                $this->addError($rowNumber, "Dữ liệu study_type:" . $study_type . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            if ($vietnam_teacher_minutes_per_section !== '' && intval($vietnam_teacher_minutes_per_section) > 0 && !filter_var($vietnam_teacher_minutes_per_section, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : số phút mỗi buổi của giáo viên Việt Nam: " . $vietnam_teacher_minutes_per_section . " không hợp lệ!\n");
                $this->addError($rowNumber, "số phút mỗi buổi của giáo viên Việt Nam: " . $vietnam_teacher_minutes_per_section . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }
            
            if ($foreign_teacher_minutes_per_section !== '' && intval($foreign_teacher_minutes_per_section) > 0 && !filter_var($foreign_teacher_minutes_per_section, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : số phút mỗi buổi của giáo viên nước ngoài: " . $foreign_teacher_minutes_per_section . " không hợp lệ!\n");
                $this->addError($rowNumber, "số phút mỗi buổi của giáo viên nước ngoài: " . $foreign_teacher_minutes_per_section . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            if ($tutor_minutes_per_section !== '' && intval($tutor_minutes_per_section) > 0 && !filter_var($tutor_minutes_per_section, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : số phút mỗi buổi của gia sư: " . $tutor_minutes_per_section . " không hợp lệ!\n");
                $this->addError($rowNumber, "số phút mỗi buổi của gia sư: " . $tutor_minutes_per_section . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            if ($target !== '' && !filter_var($target, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : target: " . $target . " không hợp lệ!\n");
                $this->addError($rowNumber, "target: " . $target . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            // Kiểm tra số buổi của giáo viên Việt Nam
            if ($num_of_vn_teacher_sections !== '' && !is_numeric($num_of_vn_teacher_sections)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Tổng số buổi của giáo viên Việt Nam: " . $num_of_vn_teacher_sections . " không hợp lệ!\n");
                $this->addError($rowNumber, "Tổng số buổi của giáo viên Việt Nam: " . $num_of_vn_teacher_sections . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            // $num_vn = floatval($num_of_vn_teacher_sections);
            // if ($num_vn <= 0) {
            //     echo("  \033[1m\033[31mERROR\033[0m  : Tổng số buổi của giáo viên Việt Nam phải là một số lớn hơn 0! " . $num_of_vn_teacher_sections . " \n");
            //     $this->addError($rowNumber, "Tổng số buổi của giáo viên Việt Nam phải là một số lớn hơn 0!", $data);
                // return;
                // $failCheck = true;
            // }

            // Kiểm tra số buổi của giáo viên nước ngoài
            if ($num_of_foreign_teacher_sections !== '' && !is_numeric($num_of_foreign_teacher_sections)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Tổng số buổi của giáo viên nước ngoài: " . $num_of_foreign_teacher_sections . " không hợp lệ!\n");
                $this->addError($rowNumber, "Tổng số buổi của giáo viên nước ngoài: " . $num_of_foreign_teacher_sections . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            // $num_foreign = floatval($num_of_foreign_teacher_sections);
            // if ($num_foreign <= 0) {
            //     echo("  \033[1m\033[31mERROR\033[0m  : Tổng số buổi của giáo viên nước ngoài phải là một số lớn hơn 0!\n");
            //     $this->addError($rowNumber, "Tổng số buổi của giáo viên nước ngoài phải là một số lớn hơn 0!", $data);
                // return;
                // $failCheck = true;
            // }

            // Kiểm tra số buổi của gia sư
            if ($num_of_tutor_sections !== '' && !is_numeric($num_of_tutor_sections)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Tổng số buổi của gia sư: " . $num_of_tutor_sections . " không hợp lệ!\n");
                $this->addError($rowNumber, "Tổng số buổi của gia sư: " . $num_of_tutor_sections . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            // $num_tutor = floatval($num_of_tutor_sections);
            // if ($num_tutor <= 0) {
            //     echo("  \033[1m\033[31mERROR\033[0m  : Tổng số buổi của gia sư phải là một số lớn hơn 0!\n");
            //     $this->addError($rowNumber, "Tổng số buổi của gia sư phải là một số lớn hơn 0!", $data);
                // return;
                // $failCheck = true;
            // }

            // if ($home_room == '') {
            //     echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu chủ nhiệm!\n");
            //     $this->addError($rowNumber, "Không có dữ liệu chủ nhiệm!", $data);
                // return;
                // $failCheck = true;
            // }

            // $homeRoom = Teacher::where('type', Teacher::TYPE_HOMEROOM)->where('name', $home_room)->first();

            // if (!$homeRoom) {
            //     echo("  \033[1m\033[31mERROR\033[0m  : Giáo viên chủ nhiệm này không tồn tại!\n");
            //     $this->addError($rowNumber, "Giáo viên chủ nhiệm này không tồn tại!", $data);
                // return;
                // $failCheck = true;
            // }

            if ($vn_teacher_price !== '' && !filter_var($vn_teacher_price, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Lương giáo viên Việt Nam: " . $vn_teacher_price . " không hợp lệ!\n");
                $this->addError($rowNumber, "Lương giáo viên Việt Nam: " . $vn_teacher_price . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            if ($foreign_teacher_price !== '' && !filter_var($foreign_teacher_price, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Lương giáo viên nước ngoài: " . $foreign_teacher_price . " không hợp lệ!\n");
                $this->addError($rowNumber, "Lương giáo viên nước ngoài: " . $foreign_teacher_price . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }

            if ($tutor_price !== '' && !filter_var($tutor_price, FILTER_VALIDATE_INT)) {
                echo("  \033[1m\033[31mERROR\033[0m  : Lương giáo viên gia sư: " . $tutor_price . " không hợp lệ!\n");
                $this->addError($rowNumber, "Lương giáo viên gia sư: " . $tutor_price . " không hợp lệ!", $data);
                // return;
                $failCheck = true;
            }
            
            if ($training_location_id == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu địa điểm đào tạo!\n");
                $this->addError($rowNumber, " Không có dữ liệu địa điểm đào tạo!", $data);
                // return;
                $failCheck = true;
            }

            $trainingLocation = TrainingLocation::where('import_id', $training_location_id)->first();

            if (!$trainingLocation) {
                echo("  \033[1m\033[31mERROR\033[0m  : Không tồn tại địa điểm đào tạo: " . $training_location_id . "\n");
                $this->addError($rowNumber, "Không tồn tại địa điểm đào tạo: " . $training_location_id . "!", $data);
                // return;
                $failCheck = true;
            }

            if ($failCheck) {
                return;
            }

            $newOrderItem = OrderItem::create([
                'import_id' => $order->import_id, // Temporary import 1 order include only 1 order item edu => order item import_id = order import id 
                'order_id' => $order->id,
                'type' => Order::TYPE_EDU,
                'order_type' => $subject->type,
                'num_of_student' => $numOfStudents ? $numOfStudents : 0,
                'study_type' => $study_type,
                'class_type' => $classType,
                'vietnam_teacher_minutes_per_section' => $vietnam_teacher_minutes_per_section !== '' ? $vietnam_teacher_minutes_per_section : 0,
                'foreign_teacher_minutes_per_section' => $foreign_teacher_minutes_per_section !== '' ? $foreign_teacher_minutes_per_section : 0,
                'tutor_minutes_per_section' => $tutor_minutes_per_section !== '' ? $tutor_minutes_per_section : 0,
                'target' => $target != '' && intval($target) > 0 && filter_var($target, FILTER_VALIDATE_INT) ? intval($target) : 0,
                'subject_id' => $subject->id,
                'num_of_vn_teacher_sections' => $num_of_vn_teacher_sections != '' ? $num_of_vn_teacher_sections : 0,
                'num_of_foreign_teacher_sections' => $num_of_foreign_teacher_sections != '' ? $num_of_foreign_teacher_sections : 0,
                'num_of_tutor_sections' => $num_of_tutor_sections != '' ? $num_of_tutor_sections : 0,
                // 'home_room' => $homeRoom->id,
                'vn_teacher_price' => $vn_teacher_price ? $vn_teacher_price : null,
                'foreign_teacher_price' => $foreign_teacher_price ? $foreign_teacher_price : null,
                'tutor_price' => $tutor_price ? $tutor_price : null,
                'training_location_id' => $trainingLocation->id,
                'status' => Order::STATUS_ACTIVE
            ]);

            echo("DATA: \033[1m\033[33m" . $data[0] . "\033[0m ----> IMPORTED: \033[1m\033[32m" . $newOrderItem->import_id . "\033[0m\n");
        } elseif ($order->type == ORDER::TYPE_ABROAD) {
            $price = 100000;

            if ($price == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu giá hợp đồng!\n");
                $this->addError($rowNumber, " Không có dữ liệu giá hợp đồng!", $data);
                // return;
                $failCheck = true;
            }

            $priceConverted = 0;
           
            if ($apply_time == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu thời điểm apply!\n");
                $this->addError($rowNumber, " Không có dữ liệu thời điểm apply!", $data);
                // return;
                $failCheck = true;
            } else {
                $apply_time = \Carbon\Carbon::createFromFormat('d/m/Y', $apply_time)->setTime(0, 0, 0);
            }

            if ($estimated_enrollment_time == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu thời điểm dự kiến nhập học!\n");
                $this->addError($rowNumber, " Không có dữ liệu thời điểm dự kiến nhập học!", $data);
                // return;
                $failCheck = true;
            } else {
                $estimated_enrollment_time = \Carbon\Carbon::createFromFormat('d/m/Y', $estimated_enrollment_time)->setTime(0, 0, 0);
            }

            if ($financial_capability == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD)!\n");
                $this->addError($rowNumber, " Không có dữ liệu Khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD)!", $data);
                // return;
                $failCheck = true;
            }

            if ($plan_apply_program_id == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu chương trình dự kiến apply!\n");
                $this->addError($rowNumber, " Không có dữ liệu chương trình dự kiến apply!", $data);
                // return;
                $failCheck = true;
            }

            if ($plan_apply_program_id == 'Đại học') {
                $plan_apply_program_id = 'Cử nhân';
            }
           
            $planApplyProgram = PlanApplyProgram::where('name', $plan_apply_program_id)->first();

            if ($abroad_branch == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu chi nhánh!\n");
                $this->addError($rowNumber, " Không có dữ liệu chi nhánh!", $data);
                // return;
                $failCheck = true;
            }

            if ($failCheck) {
                return;
            }
            
            $newOrderItem = OrderItem::create([
                'import_id' => $order->import_id, // Temporary import 1 order include only 1 order item edu => order item import_id = order import id 
                'order_id' => $order->id,
                'type' => Order::TYPE_ABROAD,
                'price'=> $price,
                'apply_time' => $apply_time,
                'plan_apply_program_id' => $planApplyProgram->id,
                'std_score' => $std_score,
                'eng_score' => $eng_score,
                'financial_capability' => $financial_capability,
                'estimated_enrollment_time' => $estimated_enrollment_time,
                'abroad_branch' => $abroad_branch,
                'status' => Order::STATUS_ACTIVE
            ]);

            echo("apply_time: \033[1m\033[33m" . $apply_time . "\033[0m ----> IMPORTED: \033[1m\033[32m" . \Carbon\Carbon::parse($newOrderItem->apply_time) . "\033[0m\n");
            echo("DATA: \033[1m\033[33m" . $data[0] . "\033[0m ----> IMPORTED: \033[1m\033[32m" . $newOrderItem->import_id . "\033[0m\n");
        } elseif ($order->type == ORDER::TYPE_EXTRACURRICULAR) {
            echo("  \033[1m\033[31mERROR\033[0m  : Hiện tại chưa thể thêm dịch vụ ngoại khóa!\n");
            $this->addError($rowNumber, "Hiện tại chưa thể thêm dịch vụ ngoại khóa!", $data);
            return;
        }
    }

    /**
     * Convert price in string format to float
     */
    public function convertStringPriceToNumber($strPrice)
    {
        if (is_numeric($strPrice) && floatval($strPrice) > 0) {
            return floatval($strPrice);
        }
    
        if (!is_string($strPrice)) return 0;
    
        $cleanStr = str_replace(array(',', '.'), '', $strPrice);
        $floatNum = floatval($cleanStr);
    
        return $floatNum;
    }

    private function addError($rowNumber, $message, $data)
    {
        $this->errors[] = [
            'message' => $message . " tại dòng " . $rowNumber,
            'data' => $data
        ];
    }

    private function addWarning($message, $data)
    {
        $this->warnings[] = [
            'message' => $message,
            'data' => $data
        ];
    }

    private function exportErrorsAndWarnings()
    {
        $filePath = storage_path('logs/loi_hopdong.txt');
        $fileContent = "LỖI:\n";

        foreach ($this->errors as $error) {
            $fileContent .= $error['message'] . "\n";
        }

        $fileContent .= "\CẢNH BÁO:\n";

        foreach ($this->warnings as $warning) {
            $fileContent .= $warning['message'] . "\n";
        }

        File::put($filePath, $fileContent);

        echo("  \033[1m\033[34mINFO\033[0m: Course data errors and warnings have been exported to " . $filePath . "\n");
    }
}
