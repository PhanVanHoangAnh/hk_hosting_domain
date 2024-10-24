<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

class FindDuplicateAbroadItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:find-duplicate-abroad-item';

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
        $importAbroadItems = OrderItem::where('import_id', '!=', null)->where('type', 'abroad')->get();

        // ['price',
        // 'apply_time',
        // 'plan_apply_program_id',
        // 'std_score',
        // 'eng_score',
        // 'financial_capability',
        // 'estimated_enrollment_time',
        // 'abroad_branch',
        // 'status'];

        $duplicates = DB::table('order_items')
            ->select('price', 'apply_time', 'plan_apply_program_id', 'std_score', 'eng_score', 'financial_capability', 'estimated_enrollment_time', 'abroad_branch', 'status', DB::raw('COUNT(*) as count'))
            ->where('import_id', '!=', null)
            ->where('type', 'abroad')
            ->groupBy('price', 'apply_time', 'plan_apply_program_id', 'std_score', 'eng_score', 'financial_capability', 'estimated_enrollment_time', 'abroad_branch', 'status')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $duplicateItems = OrderItem::where('import_id', '!=', null)
            ->where('type', 'abroad')
            ->whereIn(DB::raw('(price, apply_time, plan_apply_program_id, std_score, eng_score, financial_capability, estimated_enrollment_time, abroad_branch, status)'), function ($query) {
                $query->select('price', 'apply_time', 'plan_apply_program_id', 'std_score', 'eng_score', 'financial_capability', 'estimated_enrollment_time', 'abroad_branch', 'status')
                    ->from('order_items')
                    ->where('import_id', '!=', null)
                    ->where('type', 'abroad')
                    ->groupBy('price', 'apply_time', 'plan_apply_program_id', 'std_score', 'eng_score', 'financial_capability', 'estimated_enrollment_time', 'abroad_branch', 'status')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->get();

        foreach ($duplicateItems as $item) {
            echo($item->import_id . "\n");
        }
    }
}
