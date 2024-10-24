<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupAbroadApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-abroad-application';

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
        $abroadApplications = \App\Models\AbroadApplication::whereHas('orderItem', function($q) { $q->where('import_id', 'LIKE', 'TMP_%'); })
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($abroadApplications as $abroadApplication) {
            if (!\App\Models\AbroadApplication::where('id', $abroadApplication->id)->count()) {
                continue;
            }
            
            $dups = \App\Models\AbroadApplication::whereHas('orderItem', function($q) use ($abroadApplication) {
                $q->where('import_id', $abroadApplication->orderItem->import_id);
            })
            ->orderBy('updated_at', 'desc')
            ->where('id', '!=', $abroadApplication->id)
            ->get();


            echo "\n\n #{$abroadApplication->id} - {$abroadApplication->orderItem->import_id} - {$dups->count()} - {$dups->count()} \n";
            foreach ($dups as $dup) {
                if (!\App\Models\AbroadApplication::where('id', $dup->id)->count()) {
                    continue;
                }

                echo "{$dup->orderItem->import_id} \n";

                // merge duplicate
                $this->mergeDup($abroadApplication, $dup);
            }
            
        }
    }

    public function mergeDup($abroadApplication, $dup)
    {
        if (!\App\Models\AbroadApplication::where('id', $dup->id)->count()) {
            return;
        }

        $orderItem = $abroadApplication->orderItem;
        $dupOrderItem = $dup->orderItem;

        if (!$abroadApplication->account_1 && $dup->account_1) {
            $abroadApplication->account_1 = $dup->account_1;
        }

        if (!$abroadApplication->account_2 && $dup->account_2) {
            $abroadApplication->account_2 = $dup->account_2;
        }

        if (!$abroadApplication->deposit_cost && $dup->deposit_cost) {
            $abroadApplication->deposit_cost = $dup->deposit_cost;
        }

        if (!$abroadApplication->deposit_status && $dup->deposit_status) {
            $abroadApplication->deposit_status = $dup->deposit_status;
        }

        if (!$abroadApplication->student_visa_status && $dup->student_visa_status) {
            $abroadApplication->student_visa_status = $dup->student_visa_status;
        }

        if (!$abroadApplication->hsdt_status && $dup->hsdt_status) {
            $abroadApplication->hsdt_status = $dup->hsdt_status;
        }

        if (!$abroadApplication->status && $dup->status) {
            $abroadApplication->status = $dup->status;
        }

        if (!$abroadApplication->deposit_school_cost && $dup->deposit_school_cost) {
            $abroadApplication->deposit_school_cost = $dup->deposit_school_cost;
        }

        if (!$abroadApplication->deposit_school_date && $dup->deposit_school_date) {
            $abroadApplication->deposit_school_date = $dup->deposit_school_date;
        }

        if (!$abroadApplication->i20_application_status && $dup->i20_application_status) {
            $abroadApplication->i20_application_status = $dup->i20_application_status;
        }

        if (!$abroadApplication->i20_application_status && $dup->i20_application_status) {
            $abroadApplication->i20_application_status = $dup->i20_application_status;
        }

        if (!$abroadApplication->apply_time && $dup->apply_time) {
            $abroadApplication->apply_time = $dup->apply_time;
        }

        if (!$abroadApplication->std_score && $dup->std_score) {
            $abroadApplication->std_score = $dup->std_score;
        }

        if (!$abroadApplication->eng_score && $dup->eng_score) {
            $abroadApplication->eng_score = $dup->eng_score;
        }

        if (!$abroadApplication->hsdt_status && $dup->hsdt_status) {
            $abroadApplication->hsdt_status = $dup->hsdt_status;
        }

        // - abroad_application_statuses
        $records = \DB::table('abroad_application_statuses')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move abroad_application_statuses ------ : " . $records->count() . "\n";

        // - essays
        $records = \DB::table('essays')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move essays ------ : " . $records->count() . "\n";

        // - social_network
        $records = \DB::table('social_network')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move social_network ------ : " . $records->count() . "\n";

        // - certifications
        $records = \DB::table('certifications')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move certifications ------ : " . $records->count() . "\n";

        // - recommendation_letters
        $records = \DB::table('recommendation_letters')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move recommendation_letters ------ : " . $records->count() . "\n";

        // - cultural_orientations
        $records = \DB::table('cultural_orientations')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move cultural_orientations ------ : " . $records->count() . "\n";

        // - extracurricular_schedule
        $records = \DB::table('extracurricular_schedule')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move extracurricular_schedule ------ : " . $records->count() . "\n";

        // - support_activities
        $records = \DB::table('support_activities')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move support_activities ------ : " . $records->count() . "\n";

        // - extracurricular_activity
        $records = \DB::table('extracurricular_activity')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move extracurricular_activity ------ : " . $records->count() . "\n";

        // - deposit_for_schools
        $records = \DB::table('deposit_for_schools')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move deposit_for_schools ------ : " . $records->count() . "\n";

        // - application_school
        $records = \DB::table('application_school')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move application_school ------ : " . $records->count() . "\n";

        // - student_cvs
        $records = \DB::table('student_cvs')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move student_cvs ------ : " . $records->count() . "\n";

        // - essay_results
        $records = \DB::table('essay_results')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move essay_results ------ : " . $records->count() . "\n";

        // - extracurricular_plans
        $records = \DB::table('extracurricular_plans')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move extracurricular_plans ------ : " . $records->count() . "\n";

        // - application_submissions
        $records = \DB::table('application_submissions')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move application_submissions ------ : " . $records->count() . "\n";

        // - application_fees
        $records = \DB::table('application_fees')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move application_fees ------ : " . $records->count() . "\n";


        // - application_admitted_schools
        $records = \DB::table('application_admitted_schools')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move application_admitted_schools ------ : " . $records->count() . "\n";

        // - study_abroad_applications
        $records = \DB::table('study_abroad_applications')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move study_abroad_applications ------ : " . $records->count() . "\n";

        // - application_school
        $records = \DB::table('application_school')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move application_school ------ : " . $records->count() . "\n";

        // - flying_students
        $records = \DB::table('flying_students')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move flying_students ------ : " . $records->count() . "\n";

        // - lo_trinh_ht_cl
        $records = \DB::table('lo_trinh_ht_cl')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move lo_trinh_ht_cl ------ : " . $records->count() . "\n";

        // - lo_trinh_hd_nk
        $records = \DB::table('lo_trinh_hd_nk')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move lo_trinh_hd_nk ------ : " . $records->count() . "\n";

        // - abroad_application_finish_day
        $records = \DB::table('abroad_application_finish_day')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move abroad_application_finish_day ------ : " . $records->count() . "\n";

        // - abroad_application_done
        $records = \DB::table('abroad_application_done')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move abroad_application_done ------ : " . $records->count() . "\n";

        // - abroad_application_status
        $records = \DB::table('abroad_application_status')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move abroad_application_status ------ : " . $records->count() . "\n";

        // - abroad_score
        $records = \DB::table('abroad_score')
            ->where('abroad_application_id', $dup->id);
        $records->update(['abroad_application_id' => $abroadApplication->id]);
        echo "---------- move abroad_score ------ : " . $records->count() . "\n";

        // save
        $abroadApplication->save();

        // merge order item
        $this->mergeOrderItem($orderItem, $dupOrderItem);
        
        $dup->delete();
    }

    public function mergeOrderItem($orderItem, $dupOrderItem)
    {
        if (!\App\Models\OrderItem::where('id', $dupOrderItem->id)->count()) {
            return;
        }

        // - course_student
        $records = \DB::table('course_student')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move course_student ------ : " . $records->count() . "\n";

        // - reserve
        $records = \DB::table('reserve')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move reserve ------ : " . $records->count() . "\n";

        // - refund_requests
        $records = \DB::table('refund_requests')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move refund_requests ------ : " . $records->count() . "\n";

        // - payment_records
        $records = \DB::table('payment_records')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move payment_records ------ : " . $records->count() . "\n";

        // - revenue_distributions
        $records = \DB::table('revenue_distributions')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move revenue_distributions ------ : " . $records->count() . "\n";

        // - order_item_demos
        $records = \DB::table('order_item_demos')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move order_item_demos ------ : " . $records->count() . "\n";

        // - abroad_applications
        $records = \DB::table('abroad_applications')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move abroad_applications ------ : " . $records->count() . "\n";

        // - extracurricular_students
        $records = \DB::table('extracurricular_students')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move extracurricular_students ------ : " . $records->count() . "\n";

        // - courses
        $records = \DB::table('courses')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move courses ------ : " . $records->count() . "\n";

        // - course_student
        $records = \DB::table('course_student')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move course_student ------ : " . $records->count() . "\n";

        // - course_student
        $records = \DB::table('course_student')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move course_student ------ : " . $records->count() . "\n";

        // - course_student
        $records = \DB::table('course_student')
            ->where('order_item_id', $dupOrderItem->id);
        $records->update(['order_item_id' => $orderItem->id]);
        echo "---------- move course_student ------ : " . $records->count() . "\n";

        $orderItem->save();

        //
        $dupOrderItem->delete();
        
    }
}
