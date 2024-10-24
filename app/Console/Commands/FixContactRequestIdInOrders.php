<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Order;
use \App\Models\OrderItem;
use \App\Models\Contact;
use \App\Models\ContactRequest;

class FixContactRequestIdInOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-contact-request-id-in-orders';

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
        $orders = Order::where('import_id', '!=', null)->where('contact_request_id', 265968)->get();

        foreach($orders as $order) {
            $contactId = $order->contact_id;
            $contact = Contact::find($contactId);

            if ($contact) {
                $contactRequest = ContactRequest::where('contact_id', $contact->id)->first();

                if ($contactRequest) {
                    $oldContactRequestId = $order->contact_request_id;
                    $order->contact_request_id = $contactRequest->id;
                    $order->save();
                    echo("\033[1m\033[32mCHUYỂN ĐỔI CONTACT_REQUEST_ID " . $oldContactRequestId . " ---> " . $order->contact_request_id . "\033[0m\n");
                } else {
                    echo("\n Contact request not found! contactId: " . $contact->id . " \n");
                }
            }
        }

        echo("\n");
        echo("\n");
        echo("\033[1m\033[32mCập nhật lại Branch cho abroad items\033[0m\n");

        OrderItem::where('abroad_branch', 'HCM')->update(['abroad_branch' => 'SG']);

        echo("\033[1m\033[32mĐÃ CẬP NHẬT LẠI TOÀN BỘ BRANCH [HCM ---> SG] CHO ABROAD ITEMS \033[0m\n");
        echo("\n");
        echo("\n");
    }
}
