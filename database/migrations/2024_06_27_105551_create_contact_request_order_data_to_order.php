<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\ContactRequest;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        // Bước 1: Tìm các contact_request_id có nhiều hơn một order
        $duplicateContactRequestIds = Order::select('contact_request_id')
            ->whereNotNull('contact_request_id')
            ->groupBy('contact_request_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('contact_request_id');

        // Bước 2: Lấy các đơn hàng với contact_request_id nằm trong danh sách trên,
        // nhưng không phải là đơn hàng đầu tiên của mỗi contact_request_id
        $orders = Order::whereNull('contact_request_id')
                    ->orWhere(function($query) use ($duplicateContactRequestIds) {
                        $query->whereIn('contact_request_id', $duplicateContactRequestIds)
                            ->whereNotIn('id', function($subQuery) {
                                $subQuery->select(\DB::raw('MIN(id)'))
                                        ->from('orders')
                                        ->whereNotNull('contact_request_id')
                                        ->groupBy('contact_request_id');
                            });
                    })
                    ->whereNotNull('import_id')
                    ->get();

                    
        foreach ($orders as $order) {
            $this->updateContactRequest($order);
        }
    }
    public function updateContactRequest($order)
    {
        if($order->contact_id){
            if($order->contactRequest()->exists()){
                    $contactRequestTemplate = $order->contactRequest()->first();
                    $contactRequest = $contactRequestTemplate->replicate();
                    $contactRequest->account_id = $order->sale;
                    $contactRequest->save();
                    $order->contact_request_id = $contactRequest->id;
                    $order->save();
            }else{
                $contactRequestTemplate = ContactRequest::where('contact_id',$order->contact_id)->first();
                if($contactRequestTemplate){
                    $contactRequest = $contactRequestTemplate->replicate();
                    $contactRequest->account_id = $order->sale;
                    $contactRequest->save();
                    $order->contact_request_id = $contactRequest->id;
                    $order->save();
                }else{
                    $params = $order->contacts->getAttributes();
                    $contactRequest = $order->contacts->addContactRequest($params);
                    $contactRequest->account_id = $order->sale;
                    $contactRequest->save();
                    $order->contact_request_id = $contactRequest->id;
                    $order->save();
                }
            }
        }

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
