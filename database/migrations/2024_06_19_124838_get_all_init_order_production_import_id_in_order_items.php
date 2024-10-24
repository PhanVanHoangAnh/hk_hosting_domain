<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $orderItems = Order::all();
        $importIds = [];

        foreach($orderItems as $item) {
            $importIds[] = $item->import_id;
        }

        $this->exportErrorsAndWarnings($importIds);
    }

    private function exportErrorsAndWarnings($importIds)
    {
        $filePath = storage_path('logs/order_item_import_ids.txt');
        $fileContent = "order_item_import_ids:\n";

        foreach ($importIds as $id) {
            $fileContent .= $id . "\n";
        }

        File::put($filePath, $fileContent);
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
