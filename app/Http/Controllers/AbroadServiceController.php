<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbroadService;

class AbroadServiceController extends Controller
{
    public function loadAbroadServiceOptionsByType(Request $request)
    {
        $type = $request->type;

        if (!in_array($type, AbroadService::types()->toArray())) {
            throw new \Exception("Invalid abroad services type, this type is not in the type array!");
        }   

        $services = AbroadService::getServiceByType($type);

        return response()->view('servicesByType', [
            'services' => $services,
            'selectedValue' => isset($request->serviceSelectedId) ? $request->serviceSelectedId : null 
        ]);
    }

    public function select2(Request $request)
    {
        return response()->json(AbroadService::select2($request));
    }
}
