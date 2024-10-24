<?php

namespace App\Http\Controllers\Abroad\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpsellReportController extends Controller
{
    public function index(){
        return view('abroad.reports.upsell.index');
    }

    public function list(Request $request)
    {
       

        return view('abroad.reports.upsell.list', [
           
         ] );
           
    }
}
