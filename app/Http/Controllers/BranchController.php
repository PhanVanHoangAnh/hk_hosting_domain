<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Branch;

class BranchController extends Controller
{
    public function setBranch(Request $request)
    {
        $errors = Branch::setBranchFromRequest($request);

        // if (!$errors->isEmpty()) {
        //     return response()->json([
        //         'status' => 'fail',
        //         'message' => 'Set current branch fail!'
        //     ], 400);
        // }

        return response()->json([
            'status' => 'OK',
            'message' => 'Set current branch successfully!'
        ], 200);
    }
}
