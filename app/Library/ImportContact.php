<?php

namespace App\Library;

use Illuminate\Support\Facades\Cache;
use App\Models\Contact;

class ImportContact
{
    public static function importFromFile($filePath)
    {
        self::updateProgress([
            'total' => 0,
            'processed' => 0,
            'percent' => 0,
            'success' => 0,
            'failed' => 0,
        ]);

        Contact::importFromExcelFile($filePath, function ($total, $processed, $success, $failed) {
            self::updateProgress([
                'total' => $total,
                'processed' => $processed,
                'percent' => ($processed/$total)*100,
                'success' => $success,
                'failed' => $failed,
            ]);
        }, function ($total, $processed, $success, $failed) {
            self::updateProgress([
                'total' => $total,
                'processed' => $total,
                'percent' => 100,
                'success' => $success,
                'failed' => $failed,
            ]);
        });
    }
   
    public static function checkProgress()
    {
        return Cache::get('import_progress') ?? [
            'total' => 0,
            'processed' => 0,
            'percent' => 0,
            'success' => 0,
            'failed' => 0,
        ];
    }

    public static function updateProgress($progress)
    {
        Cache::put('import_progress', $progress);
    }
    
    public static function clearProgress()
    {
        Cache::forget('import_progress');
    }

    public static function isRunning()
    {
        return Cache::get('import_progress') || \DB::table('jobs')->where('payload', 'like', '%ImportContactJob%')->count();
    }

    public static function isDone()
    {
        return self::isRunning() && self::checkProgress()['percent'] == 100;
    }
}