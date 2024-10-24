<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;
use App\Models\AccountGroup;
use App\Models\Contact;
use App\Models\Role;
use App\Models\ExcelData;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ContactRequest;

class InitContactAndContactRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contact::query()->delete();
        // ContactRequest::query()->delete();

        $excelFile = new ExcelData();
        $staffData = $excelFile->getDataFromSheet(ExcelData::STAFF_SHEET_CONTACT_REQUEST, 3);

        foreach ($staffData as $data) {
            $this->addContact($data);
        }
    }

    public function addContact($data)
    {
        [$contactRequest_id,$contact_id ,$name, $email, $phone, $user_account, $address, $source_type,$demand, $country, $district,$city, $school, $efc, $list, $target,$channel,$sub_channel, $campaign, $adset, $ads, $device, $placement, $term, $first_url, $contact_owner, $lifecycle_stage, $lead_status, $pic, $hubspot_id ,$fbcid, $gclid, $birthday, $age, $time_to_call, $ward, $type_match, $last_url, $assigned_at, $status] = $data;

        if (is_null($name)) {
            echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu tên!\n");
            return;
        }
        if(is_null($email)&&is_null($phone)&&is_null($name)){
            return;
        }

        if (is_null($email)) {
            // echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu email!\n");
            $email = '-';
        }

        if (is_null($phone)) {
            // echo("  \033[1m\033[31mERROR\033[0m  : Không có dữ liệu số điện thoại!\n");
            $phone = '0';
        }

        // Kiểm tra xem contact_id đã tồn tại chưa
        $existingContact = Contact::where('import_id', $contact_id )->first();
        // Nếu contact_id đã tồn tại, thoát khỏi hàm
        if ($existingContact) {
            // Nếu contact_id đã tồn tại, không thêm vào cơ sở dữ liệu
            echo("  \033[1m\033[33mWARNING\033[0m: Contact đã tồn tại import_id = ". $existingContact->import_id ."\n" );

            return;
        }

        // Nếu contact_id chưa tồn tại, tạo mới contact
         // Bỏ khoảng trắng
        $email = trim($email);
        $phone = \App\Library\Tool::extractPhoneNumber(trim($phone));
        $contact = Contact::newDefault();
        $contact->importContactFromExcelSeeder($contactRequest_id,$contact_id ,$name, $email, $phone,$user_account, $address, $source_type,$demand, $country, $district,$city, $school, $efc, $list, $target,$channel,$sub_channel, $campaign, $adset, $ads, $device, $placement, $term, $first_url, $contact_owner, $lifecycle_stage, $lead_status, $pic, $hubspot_id ,$fbcid, $gclid, $birthday, $age, $time_to_call, $ward, $type_match, $last_url, $assigned_at, $status);
    }
}
