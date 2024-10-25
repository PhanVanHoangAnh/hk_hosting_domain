<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingLocation;


class TrainingLocationController extends Controller
{
    public function getTrainingLocationsByBranch(Request $request)
    {
        return TrainingLocation::getLocationsByBranch($request->branch);
    }
}
