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

class ChangeTmpOrderItemImportId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-tmp-order-item-import-id';

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
        $tmpOrderItems = OrderItem::where('import_id', 'LIKE', 'TMP_%')->get();
        $count = 0;
        $idExisting = [];

        foreach($datas as $data) {
            $position = strpos($data[0], 'FIX_NA');
            
            if ($position !== false || $data == '') {
                echo("\n");
                echo("\n");
                $contact = Contact::where('import_id', $data[1])->first();
                $account2 = Account::where('name', $data[32])->first();
                $account1 = Account::where('name', $data[33])->first();

                if ($account1 || $account2) {
                    $abroadApplication = AbroadApplication::where('student_id', $contact->id)->first();
                    $orderItem = null;

                    if ($abroadApplication) {
                        $orderItem = OrderItem::where('type', Order::TYPE_ABROAD)
                                                ->where('import_id', 'LIKE', 'TMP_%')
                                                ->whereHas('order', function($q) use ($contact) {
                                                    $q->where('contact_id', $contact->id);
                                                })->get();

                        if ($orderItem->first()) {
                            $orderItemGetted = $orderItem->first();

                            if (in_array($orderItemGetted->id, $idExisting)) {
                                echo("\033[1m\033[31mĐÃ TỒN TẠI\033[0m");
                            } else {
                                echo($orderItemGetted->id . " - " . $orderItemGetted->import_id . "\n");
                            }
                            
                            $orderGetted = $orderItemGetted->order;
                            $orderItemGetted->import_id = trim($data[0]);
                            $orderGetted->import_id = trim($data[0]);
                            $orderItemGetted->save();
                            $orderGetted->save();
                            $count++;
                            $idExisting[] = $orderItemGetted->id;
                            echo($orderItem->count() 
                                . " - " 
                                . $contact->import_id 
                                . " -- " 
                                . $data[1] 
                                . " - " 
                                . $orderItemGetted->import_id 
                                . " - " 
                                . $data[0] 
                                . " - " 
                                . (trim($contact->import_id) == trim($data[1]) ? "\033[1m\033[32mTRUE\033[0m" : "\033[1m\033[31mFALSE\033[0m") 
                                // . " - " 
                                // . ($account1 ? $account1->name : 'NONE') 
                                // . " - " 
                                // . ($account2 ? $account2->name : 'NONE') 
                                // . " | " 
                                // . $data[33] 
                                // . " - " 
                                // . $data[32] 
                                // . "   --   " 
                                // . (trim($account1 ? $account1->name : 'NONE') == trim($data[33]) ? 'TRUEE' : "\033[1m\033[31mFALSE\033[0m") 
                                // . " - " 
                                // . (trim($account2 ? $account2->name : 'NONE') == trim($data[32]) ? 'TRUEE' : "\033[1m\033[31mFALSE\033[0m")
                            );
                        } else {
                            echo($data[0] . " - NOT FOUND!\n");
                        }
                    } else {
                        echo("abroadApplication not found!\n");
                    }
                } else {
                    echo("NO STAFF " . $data[32] . "-" . $data[33] . " \n");
                    $orderItem = OrderItem::where('type', Order::TYPE_ABROAD)
                    ->where('import_id', 'LIKE', 'TMP_%')
                    ->whereHas('order', function($q) use ($contact) {
                        $q->where('contact_id', $contact->id);
                    })->get();

                    if ($orderItem->first()) {
                        $orderItemGetted = $orderItem->first();

                        if (in_array($orderItemGetted->id, $idExisting)) {
                            echo("\033[1m\033[31mĐÃ TỒN TẠI\033[0m");
                        } else {
                            echo($orderItemGetted->id . " - " . $orderItemGetted->import_id . "\n");
                        }

                        $orderGetted = $orderItemGetted->order;
                        $orderItemGetted->import_id = trim($data[0]);
                        $orderGetted->import_id = trim($data[0]);
                        $orderItemGetted->save();
                        $orderGetted->save();
                        $count++;
                        $idExisting[] = $orderItemGetted->id;
                        echo($orderItem->count() 
                            . " - " 
                            . $contact->import_id 
                            . " -- " 
                            . $data[1] 
                            . " - " 
                            . $orderItemGetted->import_id 
                            . " - " 
                            . $data[0] 
                            . " - " 
                            . (trim($contact->import_id) == trim($data[1]) ? "\033[1m\033[32mTRUE\033[0m" : "\033[1m\033[31mFALSE\033[0m") 
                            // . " - " 
                            // . ($account1 ? $account1->name : 'NONE') 
                            // . " - " 
                            // . ($account2 ? $account2->name : 'NONE') 
                            // . " | " 
                            // . $data[33] 
                            // . " - " 
                            // . $data[32] 
                            // . "   --   " 
                            // . (trim($account1 ? $account1->name : 'NONE') == trim($data[33]) ? 'TRUEE' : "\033[1m\033[31mFALSE\033[0m") 
                            // . " - " 
                            // . (trim($account2 ? $account2->name : 'NONE') == trim($data[32]) ? 'TRUEE' : "\033[1m\033[31mFALSE\033[0m")
                        );
                    } else {
                        echo($data[0] . " - NOT FOUND!\n");
                    }
                }
            }
        }

        echo("\nCOUNT: " . $count . "\n");
    }
}
