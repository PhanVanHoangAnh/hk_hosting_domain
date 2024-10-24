<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExcelData;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $excelFile = new ExcelData();
        $datas = $excelFile->getDataFromSheet(ExcelData::ORDER_SHEET_CONTACT_REQUEST, 6);
        $currId = null;
        $currOrder = null;
        $times = [];

        foreach ($datas as $data) {
            echo("  [CURRENT DATA]    import_id:" . $data[0] . "    apply_time data: " . $data[34] . "\n");

            if ($currId == $data[0]) {
                if (!$currOrder) {
                    $currId = null;
                    $currOrder = null;
                } else {
                    $time = null;

                    if ($data[34] != '') {
                        $applyTime = trim($data[34]);

                        try {
                            $parsedApplyTime = Carbon::createFromFormat('d/m/Y', $applyTime)->setTime(0, 0, 0);
                        } catch (\Exception $e) {
                            echo("  \033[1m\033[31mERROR\033[0m  : [import_id:" . $data[0] . "    apply_time data: " . $data[34] . "] - Định dạng ngày: " . $applyTime . " không hợp lệ! - BỎ QUA\n");
                            continue;
                        }

                        $time = [
                            $data[0],
                            $parsedApplyTime
                        ];
                    } else {
                        $time = [
                            $data[0],
                            null
                        ];
                    }

                    $times[] = $time;
                }
            } else {
                if ($currOrder && count($times)) {
                    foreach ($times as $key => $time) {
                        $orderItems = OrderItem::where('import_id', $time[0])->get();

                        if ($orderItems->count() > $key) {
                            $orderItem = $orderItems[$key];
                        
                            if ($orderItem) {
                                $orderItem->apply_time = $time[1];
                                echo("  \033[1m\033[32mSUCCESS\033[0m: (1)      import_id:" . $time[0] . "    apply_time data: " . $time[1] . "\n");
                                $orderItem->save();
                            }
                        }
                    }

                    $times = [];
                }

                if ($currOrder && count($times) == 0) {
                    if ($data[34] != '') {
                        $applyTime = trim($data[34]);

                        try {
                            $parsedApplyTime = Carbon::createFromFormat('d/m/Y', $applyTime)->setTime(0, 0, 0);
                        } catch (\Exception $e) {
                            echo("  \033[1m\033[31mERROR\033[0m  : [import_id:" . $data[0] . "    apply_time data: " . $data[34] . "] - Định dạng ngày: " . $applyTime . " không hợp lệ! - BỎ QUA\n");
                            continue;
                        }

                        $orderItem = OrderItem::where('import_id', $data[0])->first();
                        if ($orderItem) {
                            $orderItem->apply_time = $parsedApplyTime;
                            echo("  \033[1m\033[32mSUCCESS\033[0m: (3)      import_id:" . $data[0] . "    apply_time data: " . $applyTime . "    APPLY TIME CONVERTED: " . $parsedApplyTime . "\n");
                            $orderItem->save();
                        }
                    }
                }

                $currId = $data[0];
                $currOrder = Order::where('import_id', $currId)->first();
            }
        }

        if ($currOrder && count($times)) {
            foreach ($times as $key => $time) {
                $orderItems = OrderItem::where('import_id', $time[0])->get();

                if ($orderItems->count() > $key) {
                    $orderItem = $orderItems[$key];
                
                    if ($orderItem) {
                        $orderItem->apply_time = $time[1];
                        echo("  \033[1m\033[32mSUCCESS\033[0m: (2)      import_id:" . $time[0] . "    apply_time data: " . $time[1] . "\n");
                        $orderItem->save();
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
};
