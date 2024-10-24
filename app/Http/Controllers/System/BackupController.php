<?php

namespace App\Http\Controllers\System;

use App\Models\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class BackupController extends Controller
{
    public function index()
    {
        return view('system.backup.index');
    }

    public function save(Request $request)
    {
        if ($request->backup_server_times) {
            Setting::set('backup.server.times', $request->backup_server_times);
        }

        if ($request->backup_cloud_times) {
            Setting::set('backup.cloud.times', $request->backup_cloud_times);
        }

        return redirect()->action([\App\Http\Controllers\System\BackupController::class, 'index']);
    }
}
