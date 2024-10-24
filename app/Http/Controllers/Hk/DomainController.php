<?php

namespace App\Http\Controllers\hk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        return view('hk.domain.index');
    }

    public function searchDomain(Request $request)
    {
        // Trimming và kiểm tra tên miền
        $value = trim($request->input('value'));
    
        // Kiểm tra xem $value có hợp lệ hay không
        if (empty($value)) {
            return response()->json([
                'message' => "Tên miền không hợp lệ!",
                'status' => 400
            ], 400);
        }
    
        // Kiểm tra tên miền đã tồn tại hay chưa
        $isDomainExisting = Domain::checkDomainIsExisting($value);
    
        if ($isDomainExisting) {
            return response()->json([
                'message' => "Domain đã tồn tại!",
                'status' => 409 // 409 Conflict
            ], 409);
        }
    
        return response()->json([
            'message' => "Domain hợp lệ!",
            'status' => 200
        ], 200);
    }
}
