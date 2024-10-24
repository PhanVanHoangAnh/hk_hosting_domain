<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function delete(Request $request)
    {
        $orderItem = OrderItem::find($request->id);

        $orderItem->delete();

        return response()->json([
            'status' => "OK",
            'message' => "Xóa đơn hàng thành công!"
        ]);
    }

    public function showAbroadItemDataPopup(Request $request)
    {
        return view('accounting.orders.abroadItemDataPopup', [
            'orderItem' => OrderItem::find($request->id)
        ]);
    }
}
