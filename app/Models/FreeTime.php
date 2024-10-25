<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_date',
        'to_date',
        'teacher_id',
        'contact_id'
    ];

    public function freeTimeRecords()
    {
        return $this->hasMany(FreeTimeRecord::class);
    }

    public function freeTimeRecordsByWeek()
    {
        $scheduleByWeek = [];

        foreach ($this->freeTimeRecords as $record) {
            $dayOfWeek = $record->day_of_week;

            $timeFrom = Carbon::createFromFormat('H:i:s', $record->from)->format('H:i');
            $timeTo = Carbon::createFromFormat('H:i:s', $record->to)->format('H:i');
            $timeRange = $timeFrom . ' - ' . $timeTo;
            
            if (!isset($scheduleByWeek[$dayOfWeek])) {
                $scheduleByWeek[$dayOfWeek] = [];
            }
            
            $scheduleByWeek[$dayOfWeek][] = $timeRange;
        }

        return $scheduleByWeek;
    }
}
