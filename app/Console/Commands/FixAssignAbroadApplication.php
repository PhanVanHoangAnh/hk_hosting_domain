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

class FixAssignAbroadApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-assign-abroad-application';

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
        $datas = $excelFile->getDataFromSheet(ExcelData::ORDER_SHEET_CONTACT_REQUEST, 6);
        $levels = $excelFile->getDataFromSheet(ExcelData::LEVEL_SHEET_NAME, 2);

        $count = 0;

        foreach($datas as $data) {
            $student = Contact::where('import_id', $data[1])->first();
            $account2 = Account::where('name', $data[32])->first();
            $account1 = Account::where('name', $data[33])->first();

            if ($account1 || $account2) {
                if (AbroadApplication::where('student_id', $student->id)->first()) {
                    $abroadApplication = AbroadApplication::where('student_id', $student->id)->first();
                    echo($student->import_id . " - " . $abroadApplication->student->import_id . ($account1 ? $account1->name : "-----NA----") . " - " . ($account2 ? $account2->name : "----NA--------") . "\n");
                    echo($data[1] . " - " . $data[32] . " - " . $data[33] . "\n");
                    echo("\n");
                    echo("\n");

                    if ($account1) $abroadApplication->account_1 = $account1->id;
                    if ($account2) $abroadApplication->account_2 = $account2->id;

                    $abroadApplication->save();
                } else {
                    $count++;
                    echo("BUGGGGG \n");
                }
            }
        }

        echo("\n");
        echo("\n");
        echo($count);
    }
}
