<?php
namespace App\Http\Controllers\Abroad;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Calendar;
use App\Models\LoTrinhHoatDongNgoaiKhoa;

class LoTrinhHoatDongNgoaiKhoaController extends Controller
{
    public function createLoTrinhHoatDongNgoaiKhoa(Request $request)
    {
        LoTrinhHoatDongNgoaiKhoa::createLoTrinhHoatDongNgoaiKhoa($request);

        return response()->json([
            'message' => 'Kê khai lộ trình hoạt động ngoại khoá thành công'
        ]);
    }
}
