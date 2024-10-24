<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function delete(Request $request)
    {
        $orderItem = OrderItem::find($request->id);
        $order = Order::find($orderItem->order_id);
        $orderItem->delete();
        $orderItems = OrderItem::where('order_id', $orderItem->order_id)->get();

        return response()->view('student.orders.createConstract', [
            "orderId" => Order::find($order->id),
            "order" => $order,
            "orderItems" => $orderItems,
            "contactId" => $order->contacts->id
        ], 200);
    }

    public function copy(Request $request)
    {
        $orderItem = OrderItem::find($request->id);

        if($orderItem) {
            $newOrderItem = $orderItem->copyFromRequest($orderItem);
            $order = Order::find($orderItem->order_id);
            $orderItems = OrderItem::where('order_id', $orderItem->order_id)->get();
            $revenueDistributions = collect($orderItem->revenueDistributions, true)->toArray();

            return response()->view('student.orders.createConstract', [
                "orderId" => Order::find($order->id),
                'sales_revenued_list' => $revenueDistributions,
                "order" => $order,
                "orderItems" => $orderItems,
                "contactId" => $order->contacts->id,
                "newOrderItemId" => $newOrderItem->id,
                "type" => $newOrderItem->type
            ], 200);
        } else {
            return response()->json([
                'messages' => 'Sao chép dịch vụ thất bại!',
                'status' => 'fail'
            ], 500);
        }
    }

    public function select2(Request $request)
    {
        $request->merge(['type' => 'abroad']);
        return response()->json(OrderItem::select2($request));
    }

    public function showAbroadItemDataPopup(Request $request)
    {
        return view('student.orders.abroadItemDataPopup', [
            'orderItem' => OrderItem::find($request->id)
        ]);
    }
}
