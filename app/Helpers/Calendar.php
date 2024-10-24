<?php

namespace App\Helpers;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Section;

class Calendar {
    private $activeYear, $activeMonth, $activeDay;
    private $events = [];
    private $daysMap = [
        'Sun' => 'CN',
        'Mon' => 'Thứ 2',
        'Tue' => 'Thứ 3',
        'Wed' => 'Thứ 4',
        'Thu' => 'Thứ 5',
        'Fri' => 'Thứ 6',
        'Sat' => 'Thứ 7',
    ];

    private $monthsMap = [
        'January' => 'Tháng 1',
        'February' => 'Tháng 2',
        'March' => 'Tháng 3',
        'April' => 'Tháng 4',
        'May' => 'Tháng 5',
        'June' => 'Tháng 6',
        'July' => 'Tháng 7',
        'August' => 'Tháng 8',
        'September' => 'Tháng 9',
        'October' => 'Tháng 10',
        'November' => 'Tháng 11',
        'December' => 'Tháng 12',
    ];

    public static function newDefault()
    {
        $calendar = new self();
        return $calendar;
    } 

    public function getData($date = null) 
    {
        $this->activeYear = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->activeMonth = $date != null ? date('m', strtotime($date)) : date('m');
        $this->activeDay = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function addEvents(
                                $date,
                                $startAt,
                                $endAt,
                                $color = '',
                                $isAddLater,
                                $code,

                                $is_vn_teacher_check,
                                $vn_teacher_id,
                                $vn_teacher_from,
                                $vn_teacher_to,

                                $is_foreign_teacher_check,
                                $foreign_teacher_id,
                                $foreign_teacher_from,
                                $foreign_teacher_to,

                                $is_tutor_check,
                                $tutor_id,
                                $tutor_from,
                                $tutor_to,

                                $is_assistant_check,
                                $assistant_id,
                                $assistant_from,
                                $assistant_to,

                                $codeName,
                                $is_modified,
                                $type,
                                $viewer,

                                $status,
                                $order_number,

                                $zoom_start_link, 
                                $zoom_join_link,
                                $zoom_password,
                                $courseId
                            )
    {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [
            $date,
            $startAt,
            $endAt,
            $color,
            $isAddLater,
            $code,

            $is_vn_teacher_check, // 6
            $vn_teacher_id, // 7 
            $vn_teacher_from, // 8
            $vn_teacher_to, // 9

            $is_foreign_teacher_check, // 10
            $foreign_teacher_id, // 11
            $foreign_teacher_from, // 12
            $foreign_teacher_to, // 13

            $is_tutor_check, // 14
            $tutor_id, // 15
            $tutor_from, // 16
            $tutor_to, // 17

            $is_assistant_check, // 18
            $assistant_id, // 19
            $assistant_from, // 20
            $assistant_to, // 21
            
            $codeName, // 22
            $is_modified, // 23
            $type, // 24
            $viewer, // 25

            $status, // 26
            $order_number, // 27

            $zoom_start_link, // 28
            $zoom_join_link, // 29
            $zoom_password, // 30
            $courseId, // 31
        ];
    }

    public function loadData($request)
    {
        $this->getData($request->date);
        if (json_decode($request->events, true)) {
            foreach (json_decode($request->events, true) as $event) {
                try {
                    $this->addEvents(
                        $event['study_date'], 
                        $event['start_at'], 
                        $event['end_at'], 
                        isset($event['color']) ? $event['color'] : 'blue', 
                        isset($event['is_add_later']) ? 'true' : 'false',
                        $event['code'],

                        isset($event['is_vn_teacher_check']) && $event['is_vn_teacher_check'] && $event['is_vn_teacher_check'] !== "" && $event['is_vn_teacher_check'] !== "0" ? $event['is_vn_teacher_check'] : null,
                        isset($event['vn_teacher_id']) && $event['vn_teacher_id'] && $event['vn_teacher_id'] !== "" && $event['vn_teacher_id'] !== "0" ? $event['vn_teacher_id'] : null,
                        isset($event['vn_teacher_from']) && $event['vn_teacher_from'] && $event['vn_teacher_from'] !== "" && $event['vn_teacher_from'] !== "0" ? $event['vn_teacher_from'] : null,
                        isset($event['vn_teacher_to']) && $event['vn_teacher_to'] && $event['vn_teacher_to'] !== "" && $event['vn_teacher_to'] !== "0" ? $event['vn_teacher_to'] : null,

                        isset($event['is_foreign_teacher_check']) && $event['is_foreign_teacher_check'] && $event['is_foreign_teacher_check'] !== "" && $event['is_foreign_teacher_check'] !== "0" ? $event['is_foreign_teacher_check'] : null,
                        isset($event['foreign_teacher_id']) && $event['foreign_teacher_id'] && $event['foreign_teacher_id'] !== "" && $event['foreign_teacher_id'] !== "0" ? $event['foreign_teacher_id'] : null,
                        isset($event['foreign_teacher_from']) && $event['foreign_teacher_from'] && $event['foreign_teacher_from'] !== "" && $event['foreign_teacher_from'] !== "0" ? $event['foreign_teacher_from'] : null,
                        isset($event['foreign_teacher_to']) && $event['foreign_teacher_to'] && $event['foreign_teacher_to'] !== "" && $event['foreign_teacher_to'] !== "0" ? $event['foreign_teacher_to'] : null,

                        isset($event['is_tutor_check']) && $event['is_tutor_check'] && $event['is_tutor_check'] !== "" && $event['is_tutor_check'] !== "0" ? $event['is_tutor_check'] : null,
                        isset($event['tutor_id']) && $event['tutor_id'] && $event['tutor_id'] !== "" && $event['tutor_id'] !== "0" ? $event['tutor_id'] : null,
                        isset($event['tutor_from']) && $event['tutor_from'] && $event['tutor_from'] !== "" && $event['tutor_from'] !== "0" ? $event['tutor_from'] : null,
                        isset($event['tutor_to']) && $event['tutor_to'] && $event['tutor_to'] !== "" && $event['tutor_to'] !== "0" ? $event['tutor_to'] : null,

                        isset($event['is_assistant_check']) && $event['is_assistant_check'] && $event['is_assistant_check'] !== "" && $event['is_assistant_check'] !== "0" ? $event['is_assistant_check'] : null,
                        isset($event['assistant_id']) && $event['assistant_id'] && $event['assistant_id'] !== "" && $event['assistant_id'] !== "0" ? $event['assistant_id'] : null,
                        isset($event['assistant_from']) && $event['assistant_from'] && $event['assistant_from'] !== "" && $event['assistant_from'] !== "0" ? $event['assistant_from'] : null,
                        isset($event['assistant_to']) && $event['assistant_to'] && $event['assistant_to'] !== "" && $event['assistant_to'] !== "0" ? $event['assistant_to'] : null,

                        isset($event['id']) && $event['id'] && Section::find($event['id']) ? Section::find($event['id'])->course->code : null,
                        isset($event['is_modified']) && $event['is_modified'] ? true : false,

                        isset($event['type']) && $event['type'] ? $event['type'] : null,
                        isset($event['viewer']) && $event['viewer'] ? $event['viewer'] : 'all',

                        isset($event['status']) && $event['status'] ? $event['status'] : \App\Models\StudentSection::STATUS_NEW,
                        isset($event['order_number']) && $event['order_number'] ? $event['order_number'] : 0,

                        isset($event['zoom_start_link']) && $event['zoom_start_link'] ? $event['zoom_start_link'] : null,
                        isset($event['zoom_join_link']) && $event['zoom_join_link'] ? $event['zoom_join_link'] : null,
                        isset($event['zoom_password']) && $event['zoom_password'] ? $event['zoom_password'] : null,

                        isset($event['course_id']) && $event['course_id'] ? $event['course_id'] : null,
                    );
                } catch(LoadCalendarException $exception) {
                    throw $exception;
                }
            }
    
            return $this;
        }
    }

    public function getActiveYear()
    {
        return $this->activeYear;
    }

    public function getActiveMonth()
    {
        return $this->activeMonth;
    }

    public function getActiveDay()
    {
        return $this->activeDay;
    }

    public function getNumDays()
    {
        return date('t', strtotime($this->activeDay . '-' . $this->activeMonth . '-' . $this->activeYear));
    }

    public function getNumDaysLastMonth()
    {
        return date('j', strtotime('last day of previous month', strtotime($this->activeDay . '-' . $this->activeMonth . '-' . $this->activeYear)));
    }

    public function getDays()
    {
        return [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
    }

    public function getFirstDayOfWeek()
    {
        return array_search(date('D', strtotime($this->activeYear . '-' . $this->activeMonth . '-1')), $this->getDays());
    }

    public function getEvents()
    {
        return $this->events;
    }
    
    public function getMonthName($month)
    {
        return $this->monthsMap[$month] ?? $month;
    }

    public function getHeaderContent()
    {
        $monthName = $this->getMonthName(date('F', strtotime($this->getActiveYear() . '-' . $this->getActiveMonth() . '-1')));
        return $monthName . ' ' . $this->getActiveYear();
    }

    public function getDayName($day)
    {
        return $this->daysMap[$day] ?? $day;
    }

    public function getToday()
    {
        return 'Tháng ' . $this->getActiveMonth() . ', năm ' . $this->getActiveYear();
    }

    public function getDateString($date)
    {
        $currentDate = Carbon::create($this->getActiveYear(), $this->getActiveMonth(), $date);
        $formattedDate = $currentDate->format('Y-m-d');
        return $formattedDate;
    }

    public static function hasDayPassAlready($date) {
        $dateTime = Carbon::parse($date);
        $currentDate = Carbon::now();

        return $dateTime->lessThan($currentDate);
    }

    public static function haveTheClassBeenCompleted($event) {
        $date = Carbon::parse($event[1]);
        $currentDate = Carbon::now();

        return $date->lessThan($currentDate);
    }

    public static function validateToLoadCalendar($request)
    {
        $sections = json_decode($request->events);
        $totalHoursInputInMinutes = floatval($request->totalHours) * 60;

        // Ignore sections which where add in calendar (which have is_add_later -> true)
        $sectionsApplyFromWeekSchedule = array_filter($sections, function ($section) {
            return !isset($section->is_add_later);
        });

        $totalSectionHours = Section::getTotalHoursOfSections($sectionsApplyFromWeekSchedule);

        if ($request->totalHours 
            && isset($request->isApplyFromSchedule) 
            && $request->isApplyFromSchedule 
            && $totalSectionHours > $totalHoursInputInMinutes) {
            throw new \Exception('Cấu hình thời khóa biểu hiện tại sau khi áp dụng thì tổng số giờ của các buổi học lớn hơn so với tổng số giờ cần học! Tổng số giờ hiện tại: ' . floatval($totalSectionHours / 60) . '/' . floatval($totalHoursInputInMinutes / 60) . ' giờ');
        }
    }
}
