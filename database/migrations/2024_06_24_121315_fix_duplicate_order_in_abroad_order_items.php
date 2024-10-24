<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ExcelData;
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

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // $dupOrderIdCount = [
        //     [
        //         "order_id" => 6130,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6138,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6140,
        //         "item_count" => 12,
        //     ],
        //     [
        //         "order_id" => 6146,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6152,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6155,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6160,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6163,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6166,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6169,
        //         "item_count" => 16,
        //     ],
        //     [
        //         "order_id" => 6176,
        //         "item_count" => 6,
        //     ],
        //     [
        //         "order_id" => 6181,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6185,
        //         "item_count" => 12,
        //     ],
        //     [
        //         "order_id" => 6188,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6190,
        //         "item_count" => 19,
        //     ],
        //     [
        //         "order_id" => 6193,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6207,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6212,
        //         "item_count" => 12,
        //     ],
        //     [
        //         "order_id" => 6223,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6229,
        //         "item_count" => 12,
        //     ],
        //     [
        //         "order_id" => 6233,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6236,
        //         "item_count" => 15,
        //     ],
        //     [
        //         "order_id" => 6238,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6244,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6246,
        //         "item_count" => 15,
        //     ],
        //     [
        //         "order_id" => 6250,
        //         "item_count" => 11,
        //     ],
        //     [
        //         "order_id" => 6256,
        //         "item_count" => 19,
        //     ],
        //     [
        //         "order_id" => 6258,
        //         "item_count" => 13,
        //     ],
        //     [
        //         "order_id" => 6260,
        //         "item_count" => 6,
        //     ],
        //     [
        //         "order_id" => 6262,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6265,
        //         "item_count" => 13,
        //     ],
        //     [
        //         "order_id" => 6267,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6269,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6271,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6276,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6282,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6284,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6286,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6288,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6295,
        //         "item_count" => 15,
        //     ],
        //     [
        //         "order_id" => 6297,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6299,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6302,
        //         "item_count" => 18,
        //     ],
        //     [
        //         "order_id" => 6304,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6308,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6310,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6312,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6316,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6318,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6322,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6324,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6326,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6332,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6334,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6338,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6343,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6345,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6350,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6378,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6380,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6382,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6392,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6398,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6402,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6404,
        //         "item_count" => 26,
        //     ],
        //     [
        //         "order_id" => 6406,
        //         "item_count" => 20,
        //     ],
        //     [
        //         "order_id" => 6408,
        //         "item_count" => 20,
        //     ],
        //     [
        //         "order_id" => 6415,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6425,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6427,
        //         "item_count" => 11,
        //     ],
        //     [
        //         "order_id" => 6429,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6431,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6435,
        //         "item_count" => 7,
        //     ],
        //     [
        //         "order_id" => 6437,
        //         "item_count" => 19,
        //     ],
        //     [
        //         "order_id" => 6441,
        //         "item_count" => 15,
        //     ],
        //     [
        //         "order_id" => 6453,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6462,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6464,
        //         "item_count" => 17,
        //     ],
        //     [
        //         "order_id" => 6466,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6468,
        //         "item_count" => 11,
        //     ],
        //     [
        //         "order_id" => 6470,
        //         "item_count" => 20,
        //     ],
        //     [
        //         "order_id" => 6472,
        //         "item_count" => 9,
        //     ],
        //     [
        //         "order_id" => 6475,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6477,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6481,
        //         "item_count" => 15,
        //     ],
        //     [
        //         "order_id" => 6488,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6490,
        //         "item_count" => 28,
        //     ],
        //     [
        //         "order_id" => 6497,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6499,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6501,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6507,
        //         "item_count" => 22,
        //     ],
        //     [
        //         "order_id" => 6509,
        //         "item_count" => 19,
        //     ],
        //     [
        //         "order_id" => 6517,
        //         "item_count" => 10,
        //     ],
        //     [
        //         "order_id" => 6519,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6522,
        //         "item_count" => 16,
        //     ],
        //     [
        //         "order_id" => 6525,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6535,
        //         "item_count" => 26,
        //     ],
        //     [
        //         "order_id" => 6538,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6540,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6543,
        //         "item_count" => 18,
        //     ],
        //     [
        //         "order_id" => 6545,
        //         "item_count" => 4,
        //     ],
        //     [
        //         "order_id" => 6550,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6558,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6563,
        //         "item_count" => 16,
        //     ],
        //     [
        //         "order_id" => 6567,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6585,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6596,
        //         "item_count" => 5,
        //     ],
        //     [
        //         "order_id" => 6600,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6623,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6625,
        //         "item_count" => 6,
        //     ],
        //     [
        //         "order_id" => 6627,
        //         "item_count" => 3,
        //     ],
        //     [
        //         "order_id" => 6635,
        //         "item_count" => 2,
        //     ],
        //     [
        //         "order_id" => 6650,
        //         "item_count" => 8,
        //     ],
        //     [
        //         "order_id" => 6653,
        //         "item_count" => 3,
        //     ],
        // ];

        // $excelFile = new ExcelData();
        // $datas = $excelFile->getDataFromSheet(ExcelData::ORDER_SHEET_CONTACT_REQUEST, 6);
        // $levels = $excelFile->getDataFromSheet(ExcelData::LEVEL_SHEET_NAME, 2);

        // $errorData = [];

        // foreach($dupOrderIdCount as $orderData) {
        //     $order = Order::find($orderData['order_id']);

        //     $addData = [];
        //     $addData['order_id'] = $orderData['order_id'];
        //     $addData['item_count'] = $orderData['item_count'];
        //     $addData['items'] = [];

        //     $orderItems = $order->orderItems()->get();

        //     foreach($orderItems as $item) {
        //         $addData['items'][] = $item->id;
        //     }

        //     $errorData[] = $addData;
        // }

        // foreach($errorData as $data) {
        // }

        // foreach($datas as $data) {
        //         echo($data[1] . " - " . $data[2] . " - " . $data[34] . " - " . $data[35] . "\n");
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abroad_order_items', function (Blueprint $table) {
            //
        });
    }
};
