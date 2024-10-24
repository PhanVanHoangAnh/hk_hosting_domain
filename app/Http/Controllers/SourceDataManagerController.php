<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Functions;
use App\Helpers\SourceDataFunctions;
use App\Models\ContactRequest;

class SourceDataManagerController extends Controller
{
    public function getInitSourceData(Request $request)
    {
        $datas = Functions::getJsSourceTypes();
        return response()->json($datas);
    }

    public function getAutoLoadFormBySubChannel(Request $request) 
    {
        $subChannel = $request->subChannel;
        $channel = $subChannel ? SourceDataFunctions::getChannelBySubChannel($request->subChannel) : null;
        $sourceType = $subChannel ? SourceDataFunctions::getSourceTypeByChannel($channel) : null;
        $subData = isset($reuqest->subData) ? json_decode($reuqest->subData) : null;

        return response()->view('generals.contact_requests._auto_form', [
            'channel' => $channel,
            'sourceType' => $sourceType,
            'contactRequestData' => $request->contactRequestData ? $request->contactRequestData : null
        ]);
    }
}
