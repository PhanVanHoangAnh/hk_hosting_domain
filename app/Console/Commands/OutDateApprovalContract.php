<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class OutDateApprovalContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'out_date_approval_contract:cron';

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
        info("The contract approval is out of date");

        $outDateOrderRequestApprovals = Order::outdatedApproval()->get();
        
        echo $outDateOrderRequestApprovals;

        foreach($outDateOrderRequestApprovals as $order) {
            $date =  date('d/m/Y', strtotime($order->order_date)) ;  
            $users = \App\Models\User::withPermission(\App\Library\Permission::ACCOUNTING_GENERAL)->get();

            // Add notelog
            if ($order) {
                $order->contacts->addNoteLog($order->salesperson, "Hợp đồng " . trans('messages.order.type.' . $order->type) . "  số <strong>{$order->getCode()}</strong> ngày {$date}  của nhân viên tư vấn {$order->salesperson->name}.");
            } 

            foreach ($users as $user) {
                if ($order) {
                    // Send notification to customers
                    $user->notify(new \App\Notifications\SendOrderOutDatedApprovalRequestedNotification($order)); 
                }  
            }

            if ($order) {
                $order->outdatedApprovalNotified();
            }
        }
    }
}
