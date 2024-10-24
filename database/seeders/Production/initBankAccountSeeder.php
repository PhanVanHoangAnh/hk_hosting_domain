<?php

namespace Database\Seeders\Production;

use App\Models\Account;
use App\Models\AccountGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExcelData;
use App\Models\PaymentAccount;

class initBankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentAccount::query()->delete();

        $excelFile = new ExcelData();
        $accountData = $excelFile->getDataFromSheet(ExcelData::PAYMENT_ACCOUNT_SHEET_NAME, 3);

        foreach($accountData as $data) 
        {
            $this->add($data);
        }
    }

    public function add($data)
    {
        [$accountGroupName, $role, $branch, $stkAbroad, $accountNameAbroad, $bankAbroad, $stkEdu, $accountNameEdu, $bankEdu, $stkExtra, $accountNameExtra, $bankExtra] = $data;
       
        $accountGroupName = trim($accountGroupName);
        $stkAbroad = trim($stkAbroad);
        $accountNameAbroad = trim($accountNameAbroad);
        $bankAbroad = trim($bankAbroad);

        $stkEdu = trim($stkEdu);
        $accountNameEdu = trim($accountNameEdu);
        $bankEdu = trim($bankEdu);

        $stkExtra = trim($stkExtra);
        $accountNameExtra = trim($accountNameExtra);
        $bankExtra = trim($bankExtra);

        $accountSup = Account::where('name', $accountGroupName)->first();
        
        // Kiểm tra nếu accountGroup không tồn tại
        if (!$accountSup) { 
            echo "Không tìm thấy nhân viên cho $accountGroupName. \n";
            return;
        }
        if ($accountSup->account_group_id == null) { 
            echo "Không tìm thấy hoặc tạo được AccountGroup cho $accountGroupName. \n";
            return;
        }
     
        $accountGroupId = $accountSup->account_group_id;
    
        // Tạo hoặc lấy các tài khoản thanh toán 
        $abroadPaymentAccount = $this->addOrGetPaymentAccount($accountGroupId, $stkAbroad, $accountNameAbroad, $bankAbroad);
        $eduPaymentAccount = $this->addOrGetPaymentAccount($accountGroupId, $stkEdu, $accountNameEdu, $bankEdu);
        $extraPaymentAccount = $this->addOrGetPaymentAccount($accountGroupId, $stkExtra, $accountNameExtra, $bankExtra);
    
        $accountGroup = $accountSup->accountGroup()->first(); 
        $accountGroup->abroad_payment_account_id = $abroadPaymentAccount->id ;
        $accountGroup->edu_payment_account_id = $eduPaymentAccount->id ;
        $accountGroup->extracurricular_payment_account_id = $extraPaymentAccount->id ;
        $accountGroup->save();
    }
    
    public function addOrGetPaymentAccount($accountGroupId, $stk, $accountName, $bank)
    {
        $existingPaymentAccount = PaymentAccount::where('account_name', $accountName)
                                                ->where('account_number', $stk)
                                                ->where('bank', $bank)
                                                ->first();
    
        if ($existingPaymentAccount) {
            echo("  \033[1m\033[31mERROR\033[0m: Tài khoản thanh toán với số tài khoản $stk đã tồn tại.\n");
            return $existingPaymentAccount;
        }
    
        $paymentAccount = new PaymentAccount();
        $paymentAccount->bank = $bank;
        $paymentAccount->account_name = $accountName;
        $paymentAccount->account_number = $stk; 
        $paymentAccount->status = PaymentAccount::STATUS_ACTIVE;
        $paymentAccount->save();
    
        echo("  \033[1m\033[32mSUCCESS\033[0m: Tạo thành công tài khoản thanh toán với ID: $paymentAccount->id \n");
    
        return $paymentAccount;
    }

   
}
