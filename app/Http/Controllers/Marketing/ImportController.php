<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function index()
    {
        return view('marketing.import.index');
    }

    public function resetGoogleSheetImporter(Request $request)
    {
        $importer = new \App\Library\GoogleSheetImporter($request->sheet_id);
        $importer->resetLineCounter();

        return redirect()->back();
    }

    public function runGoogleSheetImporter(Request $request)
    {
        $importer = new \App\Library\GoogleSheetImporter($request->sheet_id);
        $importer->run(true);

        return redirect()->back();
    }

    public function startGoogleSheetImporter(Request $request)
    {
        $importer = new \App\Library\GoogleSheetImporter($request->sheet_id);
        $importer->start();

        return redirect()->back();
    }

    public function pauseGoogleSheetImporter (Request $request)
    {
        $importer = new \App\Library\GoogleSheetImporter($request->sheet_id);
        $importer->pause();

        return redirect()->back();
    }
}