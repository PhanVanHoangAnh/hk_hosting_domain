<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupCourseCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-course-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dups = \App\Models\Course::select('code', \DB::raw('count(*) as total'))
            ->groupBy('code')
            ->having('total', '>', 1)
            ->get();

        foreach ($dups as $dup) {
            $courses = \App\Models\Course::whereCode($dup->code)->get();

            $dupCourses = $courses->slice(1);

            foreach ($dupCourses as $course) {
                // clear code
                $course->code = null;
                $course->save();

                // update code
                $course->generateCodeName();

                echo "{$courses->first()->code} -- {$course->code} \n";
            }
        }
    }
}
