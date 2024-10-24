<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\AbroadService;
use App\Models\AbroadApplication;
use App\Models\SocialNetwork;
use App\Models\Certifications;

use App\Models\Account;
use App\Models\AbroadApplicationFinishDay;
use Illuminate\Http\Request;

class AbroadApplicationFinishDayController extends Controller
{
    public function updateFinishDay(Request $request)
    {
        $abroadApplicationFinishDay = new AbroadApplicationFinishDay();
        $errors = $abroadApplicationFinishDay->updateAbroadApplicationFinishDay($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới lớp học ngoại khóa thành công!'
        ]);
    }
}
