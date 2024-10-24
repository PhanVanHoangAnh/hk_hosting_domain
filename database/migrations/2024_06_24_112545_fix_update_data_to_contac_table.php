<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExcelData;
use App\Models\Contact;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $excelFile = new ExcelData();
        $staffData = $excelFile->getDataFromSheet(ExcelData::STAFF_SHEET_CONTACT_REQUEST, 3);

        foreach ($staffData as $data) {
            $this->updateContact($data);
        }
    }
    public function updateContact($data)
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
            $existingContact->email = trim($email);
            $existingContact->phone = trim($phone);
            $existingContact->name = $name;
            $existingContact->save();
            echo("  \033[1m\033[33mWARNING\033[0m: Contact Request đã tồn tại".$existingContact->name ."\n \n" );
            return;
        }

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact', function (Blueprint $table) {
            //
        });
    }
};
