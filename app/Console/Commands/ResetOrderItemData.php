<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

class ResetOrderItemData extends Command
{
    private $errors = [];
    private $warnings = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-order-item-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::FIX_DATA_ORDER_ITEM_ABROAD_SHEET, 6);
        $currId = null;
        $currOrder = null;
        $count = 0;

        foreach($datas as $key => $data) {
            echo("\n");
            echo("\n");
            echo("\033[1m\033[32m---------------------------------------------- ROW: " . $key + 6 . "\033[0m\n");

            $position = strpos($data[0], 'fix_');

            if ($position !== false) {
                $newOrder = $this->addOrder($key + 6, $data);

                if ($newOrder) {
                    $newOrderItem = $this->addOrderItem($key + 6, $newOrder, $data);
                    
                    if ($newOrderItem) {
                        $count++;
                        echo("DATA: \033[1m\033[33m" . $data[0] . "\033[0m ----> IMPORTED: \033[1m\033[32m" . $newOrderItem->import_id . " count(" . $count . ")\033[0m\n");
                    }

                    $newOrder->duyethopdong();

                    if ($data[32]) {
                        $staffInstance = Account::where('name', $data[32])->first();

                        if ($staffInstance) {
                            $abroadApplication = AbroadApplication::where('order_item_id', $newOrderItem->id)->first();
                            $abroadApplication->assignToAbroadApplicatonTTSK($staffInstance->id);
                        }
                    }

                    if ($data[33]) {
                        $staffInstance = Account::where('name', $data[33])->first();

                        if ($staffInstance) {
                            $abroadApplication = AbroadApplication::where('order_item_id', $newOrderItem->id)->first();
                            $abroadApplication->assignToAbroadApplicatonTVCL($staffInstance->id);
                        }
                    }
                } else {
                    echo("  \033[1m\033[31mERROR\033[0m  : Lỗi không thể tạo item!\n");
                }
            }
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

        if ($failCheck) {
            echo("  \033[1m\033[31mERROR\033[0m  : LỖI: Không thể tạo hợp đồng\n");
            return false;
        }

        $contactRequest = ContactRequest::first();

        $newOrder = Order::create([
            'import_id' => $id,
            'contact_id' => $contacts->first()->id,
            'student_id' => $contacts->first()->id,
            'type' => Order::TYPE_ABROAD,
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
            // echo("----------------" . $id . " | " . $newOrder->import_id . "----------------");
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

        return $newOrder;
    }


    /**
     * Add order item for order per loop
     */
    public function addOrderItem($rowNumber, $order, $data)
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

        $price = 100000;

            if ($price == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu giá hợp đồng!\n");
                $this->addError($rowNumber, " Không có dữ liệu giá hợp đồng!", $data);
                $failCheck = true;
            }

            $priceConverted = 0;
           
            if ($apply_time == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu thời điểm apply!\n");
                $this->addError($rowNumber, " Không có dữ liệu thời điểm apply!", $data);
                $failCheck = true;
            } else {
                $apply_time = \Carbon\Carbon::createFromFormat('d/m/Y', $apply_time)->setTime(0, 0, 0);
            }

            if ($estimated_enrollment_time == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu thời điểm dự kiến nhập học!\n");
                $this->addError($rowNumber, " Không có dữ liệu thời điểm dự kiến nhập học!", $data);
                $failCheck = true;
            } else {
                $estimated_enrollment_time = \Carbon\Carbon::createFromFormat('d/m/Y', $estimated_enrollment_time)->setTime(0, 0, 0);
            }

            if ($financial_capability == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD)!\n");
                $this->addError($rowNumber, " Không có dữ liệu Khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD)!", $data);
                $failCheck = true;
            }

            if ($plan_apply_program_id == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu chương trình dự kiến apply!\n");
                $this->addError($rowNumber, " Không có dữ liệu chương trình dự kiến apply!", $data);
                $failCheck = true;
            }

            if ($plan_apply_program_id == 'Đại học') {
                $plan_apply_program_id = 'Cử nhân';
            }
           
            $planApplyProgram = PlanApplyProgram::where('name', $plan_apply_program_id)->first();

            if ($abroad_branch == '') {
                echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu chi nhánh!\n");
                $this->addError($rowNumber, " Không có dữ liệu chi nhánh!", $data);
                $failCheck = true;
            }

            if ($failCheck) {
                return;
            }
            
            $newOrderItem = OrderItem::create([
                'import_id' => $order->import_id, 
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

            $dups = OrderItem::whereHas('order', function($q) use ($order) {
                        $q->where('type', Order::TYPE_ABROAD)
                          ->where('contact_id', $order->contact_id);
                    })
                    ->where('id', '!=', $newOrderItem->id)
                    ->where('type', Order::TYPE_ABROAD)
                    ->where('price', $newOrderItem->price)
                    ->where('apply_time', $newOrderItem->apply_time)
                    ->where('plan_apply_program_id', $newOrderItem->plan_apply_program_id)
                    ->where('std_score', $newOrderItem->std_score)
                    ->where('eng_score', $newOrderItem->eng_score)
                    ->where('financial_capability', $newOrderItem->financial_capability)
                    ->where('estimated_enrollment_time', $newOrderItem->estimated_enrollment_time)
                    ->where('abroad_branch', $newOrderItem->abroad_branch)
                    ->where('status', Order::STATUS_ACTIVE)
                    ->get();

            if ($dups->count()) {
                echo("  \033[1m\033[31mERROR\033[0m  : DATA bị trùng dữ liệu: " . $newOrderItem->import_id . " count (" . $dups->count() . ")" . "!\n");
            }

            return $newOrderItem;
    }

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
        $filePath = storage_path('logs/loi_reset_abroad_item_data.txt');
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
