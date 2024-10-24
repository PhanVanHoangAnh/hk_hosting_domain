<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\ImportContactJob;
use Illuminate\Support\Facades\Cache;
use App\Library\ImportContact;

class ContactImportController extends Controller
{
    public function uploadAndRun(Request $request)
    {
        $file = $request->file('file');
        $fileName = 'contact_import.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('import', $fileName);
        $fullPath = storage_path('app/' . $path);

        // make sure file permission
        chmod(storage_path('app/import'), 0775);

        // run job
        ImportContactJob::dispatch($fullPath)->onQueue('long-running');

        return response()->json([
            'progressUrl' => action([self::class, 'progress']),
        ]);
    }

    public function progress(Request $request)
    {
        return view('marketing.contact_import.progress');
    }
    
    public function progressBar(Request $request)
    {
        $progress = ImportContact::checkProgress();

        return response()->json([
            'percent' => $progress['percent'],
            'html' => view('marketing.contact_import.progressBar', [
                'progress' => $progress,
                'isDone' => ImportContact::isDone(),
            ])->render(),
        ]);
    }

    public function finish(Request $request)
    {
        ImportContact::clearProgress();
    }
}