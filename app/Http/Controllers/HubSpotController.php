<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Account;
use Illuminate\Http\Response;
use function Laravel\Prompts\alert;

class HubSpotController extends Controller
{
    public function index()
    {
        return view('marketing.import.hubspot.importHubspot');
    }
    
    public function findRelatedContactsImportFromExcel($email, $phone)
    {
        $relatedContacts = Contact::findRelatedContacts2([
            'email' => $email,
            'phone' => $phone,
        ]);

        return $relatedContacts;
    }
    // public function preview(Request $request)
    // {
    //     // token HubSpot 
    //     $token = $request->all()['token'];
    //     $accounts = Account::all();

    //     $datas = Contact::getTokenAPI($token);
    //     $existingContacts = [];
    //     foreach ($datas as $data) {
    //         // Tìm contact đã tồn tại dựa trên dữ liệu từ $datas
    //         $existing = $this->findRelatedContactsImportFromExcel($data['email'], $data['phone']);
    //         if ($existing->isNotEmpty()) {
    //             $existingContacts[] = $existing->toArray();
    //         } else {
    //             $existingContacts[] = [];
    //         }
    //     }

    //     //Return the view displaying the contacts
    //     return view('marketing.import.hubspot.showHubspotData', ['datas' => $datas, 'accounts' => $accounts, 'token' => $token, 'existingContacts' => $existingContacts]);
    // }
    public function preview(Request $request)
    {
        // token HubSpot 
        $token = $request->all()['token'];
        $accounts = Account::all();

        $datas = Contact::getTokenAPI($token);
        $existingContacts = [];
        foreach ($datas as $data) {
            // Tìm contact đã tồn tại dựa trên dữ liệu từ $datas
            $existing = $this->findRelatedContactsImportFromExcel($data['email'], $data['phone']);
            if ($existing->isNotEmpty()) {
                $existingContacts[] = $existing->toArray();
            } else {
                $existingContacts[] = [];
            }
        }

        //Return the view displaying the contacts
        return view('marketing.import.hubspot.showHubspotData', ['datas' => $datas, 'accounts' => $accounts, 'token' => $token, 'existingContacts' => $existingContacts]);
    }
    public function import(Request $request)
    {
        $token = $request->all()['token'];
        $account_id = $request->input('account_id');
        $customers = Contact::getTokenAPI($token);

        $result = Contact::getSaveContactsHubspot($customers, $account_id);

        // Lấy giá trị newCustomersCount từ biến $result
        $newContactsCount = $result['newCustomersCount'];

        // Lấy giá trị   $updatedCustomersCount từ biến $result
        $updatedContactsCount = $result['updatedCustomersCount'];
        $errorsCount = 0;

        // Xoá giá trị của session 'percentage'
        $request->session()->forget('percentage');



        // Bạn có thể trả về một phản hồi hoặc chuyển hướng đến trang khác sau khi nhập khẩu
        return view(
            'marketing.import.hubspot.loadSaveHubSpot',
            ['newContactsCount' => $newContactsCount, 'updatedContactsCount' => $updatedContactsCount, 'errorsCount' => $errorsCount]
        );
    }


    public function importHubSpotRunning(Request $request)
    {
        // $datas = json_decode($request->getContent(), true);

        // $excelDatas = $datas['excelDatas'];

        // $accountId = $datas['accountId'];

        Contact::importFromHubspot();
        $request->session()->forget('percentage');
        return view('marketing.import.hubspot.loadSaveHubSpot', [
            // "status" => $importStatus
        ]);
    }



    public function percentage(Request $request)
    {

        // Kiểm tra xem biến session 'percentage' đã được tạo chưa
        if (!$request->session()->has('percentage')) {
            $percentage = 0; // Nếu chưa có, thiết lập giá trị ban đầu là 0
            $total = 0;
        } else {
            // Nếu đã có, tăng giá trị lên 5 đơn vị
            $percentage = $request->session()->get('percentage') + 10;
            $total = $request->session()->get('percentage') + 5;
        }

        // Đảm bảo giá trị không vượt quá 100
        if ($percentage > 100) {
            $percentage = 100;
        }

        // Lưu giá trị $percentage vào biến session
        $request->session()->put('percentage', $percentage);
        // Trả về giá trị $percentage
        return response()->json(['percentage' => $percentage, 'total' => $total,]);
    }
}
