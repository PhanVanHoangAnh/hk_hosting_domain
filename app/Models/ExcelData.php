<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Library\GoogleSheetService;

class ExcelData extends Model
{
    use HasFactory;

    protected $spreadsheet;

    public const PAYMENT_ACCOUNT_SHEET_NAME = 'Tài khoản';
    public const STAFF_SHEET_NAME = 'Nhân Viên';
    public const USER_TEST_SHEET_NAME = 'Tài khoản người dùng (test)';
    public const TEACHER_SHEET_NAME = 'Nhân sự (Giàn Viêng, Trợ Giảng)';
    public const HOMEROOM_SHEET_NAME = 'Chủ Nhiệm';
    public const STAFF_SHEET_CONTACT_REQUEST = 'Nhu Cầu/Liên Hệ/Khách hàng/Học viên';
    public const STAFF_SHEET_SECTION = 'Buổi học';
    public const ORDER_SHEET_CONTACT_REQUEST = 'Hợp đồng';
    public const LEVEL_SHEET_NAME = 'Trình độ';
    public const SUBJECT_SHEET_NAME = 'Môn học';
    public const COURSE_SHEET_NAME = 'Lớp học';
    public const TRAINING_LOCATION_SHEET_NAME = 'Địa Điểm Đào Tạo';
    public const BRANCH_SHEET_NAME = 'Chi Nhánh';
    public const PAYRATE_SHEET_NAME = 'Cấu Hình Rate Lương';
    public const SERVICE_SHEET_NAME = "Dịch Vụ";
    public const ACADEMIC_AWARDS_SHEET_NAME = "Giải Thường Học Thuật";
    public const EXTRA_ACTIVITIES_SHEET_NAME = "Hoạt Động Ngoại Khóa";
    public const GPA_SHEET_NAME = "GPA";
    public const CURRENT_PROGRAM_SHEET_NAME = "Chương trình đang học";
    public const PLAN_APPLY_PROGRAM_SHEET_NAME = "Chương trình dự kiến apply";
    public const INTENDED_MAJOR_SHEET_NAME = "Ngành học dự kiến apply";
    public const ABROAD_SERVICES_SHEET_NAME = "Dịch Vụ Du Học";
    public const ORDER_ITEM_FIXED_DATA_SHEET_NAME = "order_fixed_data";
    public const FIX_DATA_ORDER_ITEM_ABROAD_SHEET = 'fix_hd';
    public const ADD_DATA_ORDER_ITEM_SHEET = 'Hợp đồng đợt 2';
    public const DATA_TOP_SCHOOL_SHEET = 'Số trường, top trường, quốc gia';

    public function __construct()
    {
        ini_set("memory_limit", "-1");
    }

    /** 
     * Retrieve data from any sheet.
     * 
     * @param sheet Sheet to retrieve data from
     * @param rowFrom Row to start retrieving data from
     * @return array array data
     */
    public function getDataFromSheet($sheetName, $rowFrom): array
    {
        // Kết nố với Google Sheet file và lấy data
        $service = new GoogleSheetService(env('GOOGLE_SHEETS_INIT_DATA_ID'));
        $data = $service->readContactSyncSheet($sheetName . '!A'.$rowFrom.':CZ10000');

        $data = array_filter($data, function($row) {
            foreach ($row as $cell) {
                if ($cell) return true;
            }
        });

        $data = array_map(function($row) {
            for ($i = 0; $i <= 104; $i++) {
                if (!isset($row[$i])) {
                    $row[$i] = null;
                }
            }
            return $row;
        }, $data);

        return $data;
    }

    public function isEmptyRow($row): bool
    {
        foreach ($row as $cell) {
            if (null !== $cell) return false;
        }

        return true;
    }
}
