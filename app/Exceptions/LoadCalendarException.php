<?php

namespace App\Exceptions;

use Exception;

class LoadCalendarException extends Exception
{
    public function report()
    {
        \Log::debug('Load calendar data fail!');
    }

    public function render($request)
    {
        return response()->view('errors.loadCalendar');
    }
}
