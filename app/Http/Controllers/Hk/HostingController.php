<?php

namespace App\Http\Controllers\hk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index(Request $request)
    {


        return view('hk.hosting.index', [
            
            
        ]);
    }
}
