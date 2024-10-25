<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extracurricular;
use App\Models\OrderItem;

class ExtracurricularController extends Controller
{
    public function select2(Request $request)
    {
        return response()->json(Extracurricular::byBranch(\App\Library\Branch::getCurrentBranch())->notFinished()->select2($request));
    }

    public function getExtra(Request $request)
    {
        if (!isset($request->id)) {
            throw new \Exception("invalid id!");
        }

        $extracurricular = Extracurricular::find($request->id);

        if (!$extracurricular) {
            throw new \Exception("Exracurricular not found!");
        }

        return response()->view('sales.orders._extraTable', [
            'extracurricular' => $extracurricular,
            'orderItem' => isset($request->orderItemId) ? OrderItem::find($request->orderItemId) : null,
            'priceReturn' => $request->priceReturn
        ]);
    }

    public function save(Request $request)
    {
        $extra = Extracurricular::find($request->id);

        if ($request->has('price')) {
            $extra->savePriceInline($request->price);
        } else {
            throw new \Exception("Not found price input!");
        }

        return response()->json([
            'price' => $extra->price ? $extra->price : '<span class="text-gray-500">Chưa có giá</span>',
        ]);
    }
}
