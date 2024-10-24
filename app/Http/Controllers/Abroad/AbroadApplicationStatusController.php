<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\AbroadService;
use App\Models\AbroadApplication;
use App\Models\SocialNetwork;
use App\Models\Certifications;

use App\Models\Account;
use App\Models\AbroadApplicationStatus;
use Illuminate\Http\Request;

class AbroadApplicationStatusController extends Controller
{
    public function updateDoneAbroadApplication(Request $request)
    {
        $abroadApplicationDone = new AbroadApplicationStatus();
        $errors = $abroadApplicationDone->updateDoneAbroadApplication($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới lớp học ngoại khóa thành công!'
        ]);
    }
}
