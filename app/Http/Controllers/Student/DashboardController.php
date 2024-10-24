<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\PaymentRecord;
use App\Models\Section;
use App\Models\StudentSection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    // public function index(Request $request, $interval = 'week')
    // {
    //     //module1
    //     $endDate = Carbon::now();
    //     $startDate = Carbon::now()->subWeek();
    //     $hourOrderItemTotalChart = $this->getHourOrderItemTotalChart( $startDate, $endDate, $interval);
    //     $courseTotalHours = $this->getHourCourseTotalChart( $startDate, $endDate, $interval);
    //     $trainingCount = $this->getTrainingStatusCounts();
    //     $courseCounts = Course::byBranch(\App\Library\Branch::getCurrentBranch())->countCoursesBySubject()->whereDate('end_at', '>', now())->get();
    //     $sections = Section::byBranch(\App\Library\Branch::getCurrentBranch())->incoming()->get()->take(5);

    //     return view('student.dashboard.index', [
    //         //module 1
    //         'hourOrderItemTotalChart' => $hourOrderItemTotalChart,
    //         'courseTotalHours' =>$courseTotalHours,
            
    //         //module 2
    //         'trainingCount' => $trainingCount,

    //         //module 7
    //         'sections' => $sections,

    //         //module 8
    //         'courseCounts' => $courseCounts,
    //     ]);
    // }

    public function index(Request $request, $interval = 'week')
    {
        $contact = $request->user()->getStudent();
        $trainingCount = $this->getTrainingStatusCounts($contact->id);

        $sectionStudents = StudentSection::where('student_id', $contact->id)->get();
        $sectionIds = $sectionStudents->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $sectionIds)->get();
        $sectionsInComing = $sections->filter->incoming()->take(5);
        
        return view('student.dashboard.index',[ 
           'contact' => $contact,
           'trainingCount' => $trainingCount,
           'sectionsInComing' => $sectionsInComing,
           'sections' => $sections,
        ]);
    }

    private function processChartData($data, $startDate, $endDate, $interval)
    {
        $chartData = [];
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        if ($interval === 'month' ) {
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $chartData[$currentDate->format('j')] = 0;
                $currentDate->addDay();
            }

        } elseif ($interval === 'year') {
            $currentMonth = $startDate->format('M');
            if($currentMonth ==='Jan') $currentMonth = 'T1';
            if($currentMonth ==='Feb') $currentMonth = 'T2';
            if($currentMonth ==='Mar') $currentMonth = 'T3';
            if($currentMonth ==='Apr') $currentMonth = 'T4';
            if($currentMonth ==='May') $currentMonth = 'T5';
            if($currentMonth ==='Jun') $currentMonth = 'T6';
            if($currentMonth ==='Jul') $currentMonth = 'T7';
            if($currentMonth ==='Aug') $currentMonth = 'T8';
            if($currentMonth ==='Sep') $currentMonth = 'T9';
            if($currentMonth ==='Oct') $currentMonth = 'T10';
            if($currentMonth ==='Nov') $currentMonth = 'T11';
            if($currentMonth ==='Dec') $currentMonth = 'T12';

            $monthsOfYear = [
                'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'
            ];
            $currentMonthIndex = array_search($currentMonth, $monthsOfYear);
                for ($i = $currentMonthIndex; $i <= $currentMonthIndex + 11; $i++) {
                $chartData[$monthsOfYear[$i % 12]] = 0;
            }
        }elseif ($interval === 'custom') {
            $currentDate = $startDate->copy();
            
            while ($currentDate->lte($endDate)) {
                $chartData[$currentDate->format('d')] = 0;
                $currentDate->addDay();
            }
        } else {
            $currentDayOfWeek = $startDate->dayOfWeek;
            $daysOfWeek = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'];
            $daysOfWeek = array_merge(array_slice($daysOfWeek, $currentDayOfWeek), array_slice($daysOfWeek, 0, $currentDayOfWeek));
            
            foreach ($daysOfWeek as $day) {
                $chartData[$day] = 0;
            }
        }

        foreach ($data as $createdAt => $total_hours) {
            $date = \Carbon\Carbon::parse($createdAt);

            if ($interval === 'month') {

                $day = $date->format('j');
                
            } elseif ($interval === 'year') {
                $day = $date->format('M');
                if($day ==='Jan') $day = 'T1';
                if($day ==='Feb') $day = 'T2';
                if($day ==='Mar') $day = 'T3';
                if($day ==='Apr') $day = 'T4';
                if($day ==='May') $day = 'T5';
                if($day ==='Jun') $day = 'T6';
                if($day ==='Jul') $day = 'T7';
                if($day ==='Aug') $day = 'T8';
                if($day ==='Sep') $day = 'T9';
                if($day ==='Oct') $day = 'T10';
                if($day ==='Nov') $day = 'T11';
                if($day ==='Dec') $day = 'T12';
            }elseif ($interval === 'custom') {
                $day = $date->format('d');
            } else {
                $day = $date->format('D');
                if($day === 'Mon') $day = 'Thứ 2';
                if($day === 'Tue') $day = 'Thứ 3';
                if($day === 'Wed') $day = 'Thứ 4';
                if($day === 'Thu') $day = 'Thứ 5';
                if($day === 'Fri') $day = 'Thứ 6';
                if($day === 'Sat') $day = 'Thứ 7';
                if($day === 'Sun') $day = 'CN';
            }

            if (array_key_exists($day, $chartData)) {
                $chartData[$day]+= $total_hours;
            }
        }

        return $chartData;
    }

    public function updateInterval(Request $request, $interval)
    {
        // get account
        $endDate = Carbon::now()->endOfDay();
        $dateRange = $this->getDateRangeForInterval($request, $interval, $endDate);
        $hourOrderItemTotalChart = $this->getHourOrderItemTotalChart( $dateRange['startDate'], $dateRange['endDate'], $interval);
        $courseTotalHours = $this->getHourCourseTotalChart( $dateRange['startDate'], $dateRange['endDate'], $interval);
        $data = [
            'xAxisData' => array_keys($courseTotalHours),
            'hourOrderItemTotalChart' => array_values($hourOrderItemTotalChart),
            'courseTotalHours' => array_values($courseTotalHours),
            
        ];

        return response()->json($data);
    }

    private function getDateRangeForInterval($request, $interval, $endDate)
    {
        $startDate = $endDate->copy();

        if ($interval === 'week') {
            $startDate->subDays(7)->endOfDay();
        } elseif ($interval === 'month') {
            $startDate->subDays(30);
        } elseif ($interval === 'year') {
            $startDate->subMonths(11);
        }elseif ($interval === 'custom') {
            $customStartDate = Carbon::parse($request->input('custom_date_from'));
            $customEndDate = Carbon::parse($request->input('custom_date_to'));
            $startDate = $customStartDate;
            $endDate = Carbon::parse($customEndDate);
        }

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

    private function getHourOrderItemTotalChart( $startDate, $endDate, $interval)
    {
        $orders = Order::byBranch(\App\Library\Branch::getCurrentBranch())->approved()
            ->whereBetween('order_date', [$startDate, $endDate])
            ->with('orderItems') 
            ->get();

        $totalHourByDate = $orders->groupBy('order_date')->map(function ($group) {
            return $group->sum(function ($order) {
                return $order->orderItems->sum('train_hours');
            });
        });

        $order = $this->processChartData($totalHourByDate, $startDate, $endDate, $interval);

        return $order;
    }

    private function getHourCourseTotalChart( $startDate, $endDate, $interval)
    {
        $courses = Course::byBranch(\App\Library\Branch::getCurrentBranch());
        $courses = $courses->whereBetween('created_at', [$startDate, $endDate])->get();
        $totalHours = $courses->groupBy('created_at')->map(function ($group) {
            return $group->sum('total_hours');
        });
        $courseTotalHours = $this->processChartData($totalHours, $startDate, $endDate, $interval);

        return $courseTotalHours;
    }

    private function getTrainingStatusCounts()
    {
        $trainingCount = [];

        $statuses = [StudentSection::STATUS_PRESENT, StudentSection::STATUS_EXCUSED_ABSENCE, StudentSection::STATUS_UNEXCUSED_ABSENCE];

        foreach ($statuses as $status) {
            $count = StudentSection::byBranch(\App\Library\Branch::getCurrentBranch())->countByStatusAndDate($status)->count();
            $trainingCount[$status] = $count;
        }
        return $trainingCount;
    }
}
