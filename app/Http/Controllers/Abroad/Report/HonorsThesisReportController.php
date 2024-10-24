<?php

namespace App\Http\Controllers\Abroad\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HonorsThesisReportController extends Controller
{
    public function index(){
        return view('abroad.reports.honorsThesis.index');
    }

    public function list(Request $request)
    {
       

        return view('abroad.reports.honorsThesis.list', [
           
         ] );
           
    }
}
