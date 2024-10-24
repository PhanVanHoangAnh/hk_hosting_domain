<?php

namespace App\Http\Controllers\Hk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('hk.main.index', [
            
        ]);
    }
}
