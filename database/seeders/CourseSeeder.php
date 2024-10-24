<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use App\Models\Order;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TrainingLocation;

class CourseSeeder extends Seeder
{
    // Generate unique code per section in loop;
    public function generateUiqueCode() 
    {
        $timestamp = time();
        $randomPart = subStr(str_shuffle(str_repeat('1341241212bb4bu44u1u14iu1414u12i412u12ufwi1i14124124121234i', 5)), 0, 5);
        $uniqueCode = base_convert($timestamp, 10, 36) . $randomPart;

        return $uniqueCode;
    }

    public function getRandomWeekScheduleInWeek() 
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // get random quantity of elements (3 or 4)
        $numberOfElements = rand(3, 4);

        // Shuffle array
        shuffle($daysOfWeek);

        // Pick elements follow by random quantity
        $randomDays = array_slice($daysOfWeek, 0, $numberOfElements);

        return $randomDays;
    }

    public function getRandomWeekScheduleInArray()
    {
        $array1 = ["Friday", "Saturday", "Wednesday", "Thursday"];
        $array2 = ["Sunday", "Monday", "Tuesday", "Thursday"];
        $randomIndex = rand(0, 1);

        // Pick random array
        $selectedArray = ($randomIndex === 0) ? $array1 : $array2;

        return $selectedArray;
    }

    public function getRandomAssistants()
    {
        // Retrieve a list of all teachers with the type TYPE_ASSISTANT.
        $teachers = Teacher::where('type', Teacher::TYPE_ASSISTANT)->get();

        // Use the random function to retrieve 1, 2, or 3 teachers randomly.
        $randomTeachers = $teachers->random(rand(1, 3));

        // Convert the result to an array.
        $randomTeachersArray = $randomTeachers->toArray();

        return $randomTeachersArray;
    }

    public function run(): void
    {
        Course::query()->delete();
        $servicesSytem = config('constractServices');
        $statuses = Course::getAllStatus();
        $levels = config('levels');

        $filterServicesByItemKey = function ($object) {
            return $object['itemKey'] === Order::TYPE_EDU;
        };

        $filterTypeByItemKey = function ($object) {
            return $object['itemKey'] === 'academic';
        };
        
        $eduServices = array_filter($servicesSytem, $filterServicesByItemKey)[0]['values'];
        $academicTypes = array_filter($eduServices, $filterTypeByItemKey)[0]['values'];
        $courses = [];

        foreach ($academicTypes as $type) {
            if (is_string($type)) {
                $courses[] = $type;
            } elseif (is_array($type) && array_key_exists('name', $type)) {
                $courses[] = $type['name'];
            }
        };

        $beginDateRangeStart = strtotime('2024-01-01');
        $beginDateRangeFinish = strtotime('2024-01-31');
        $endDateRangeStart = strtotime('2024-03-01');
        $endDateRangeFinish = strtotime('2024-03-31');

        $classTypes = Course::getAllClassTypes();

        $rooms = ['Phòng 101', 'Phòng 102', 'Phòng 103', 'Phòng 104', 'Phòng 105'];

        foreach ($courses as $course) {
            $randomTotalHours = mt_rand(3, 7);
            $classTypeRandomIndex = mt_rand(0, 1);
            $maxStudents = rand(30, 40);
            $minStudents = rand(10, 15);
            $startAt = date('Y-m-d H:i:s', mt_rand($beginDateRangeStart, $beginDateRangeFinish));
            $endAt = date('Y-m-d H:i:s', mt_rand($endDateRangeStart, $endDateRangeFinish));
            $subject = Subject::inRandomOrder()->first();
            $courseTotalHours = intval(fake()->numberBetween($min = 100, $max = 200));

            $courseData = [
                'subject_id' => $subject->id,
                'type' => $subject->type,
                'study_method' => Course::STUDY_METHOD_OFFLINE,
                'level' => $levels[rand(0, count($levels) - 1)],
                'status' => $statuses[rand(0, count($statuses) - 1)],
                'start_at' => $startAt,
                'end_at' => $endAt,
                'teacher_id' => Teacher::inRandomOrder()->first()->id,
                'max_students' => $maxStudents,
                'min_students' => $minStudents,
                'joined_students' => rand(0, $maxStudents),
                'total_hours' => $courseTotalHours,
                'class_type' => $classTypes[$classTypeRandomIndex],
                'training_location_id' => TrainingLocation::inRandomOrder()->first()->id,
                'module' => Course::MODULE_EDU
            ];

            $createdCourse = Course::create($courseData);
            $createdCourse->generateCodeName();

            // Start generate sections
            $randomWeekScheduleOfCourse = self::getRandomWeekScheduleInWeek();
            $startDateTime = new \DateTime($startAt);
            $endDateTime = new \DateTime($endAt);
            $weekdaysArray = self::getRandomWeekScheduleInArray();
            $currentDateTime = clone $startDateTime;
            $sections = [];
            $dates = [];

            while ($currentDateTime <= $endDateTime) {
                $currentDate = $currentDateTime->format('Y-m-d');
                $currentDayOfWeek = $currentDateTime->format('l');

                if (in_array($currentDayOfWeek, $randomWeekScheduleOfCourse)) {
                    $dates[] = $currentDate;
                }

                $currentDateTime->modify('+1 day');
            }

            $durationPerSection = floatval(sprintf("%.2f", $courseTotalHours / count($dates)));
            $numOfSectionsIntDivision = count($dates) - 1;
            
            for ($i = 0; $i < $numOfSectionsIntDivision; $i++) {
                $section = [
                    'date' => $dates[$i],
                    'duration' => $durationPerSection
                ];

                $sections[] = $section;
            }

            if (floatval(sprintf("%.2f", $durationPerSection)) < floatval(sprintf("%.2f", $courseTotalHours / count($dates)))) {
                $remainDuration = floatval(sprintf("%.2f", $courseTotalHours % count($dates)));

                $section = [
                    'date' => $dates[count($dates) - 1],
                    'duration' => $remainDuration
                ];

                $sections[] = $section;
            }

            $assistantsRandom = self::getRandomAssistants();

            foreach ($sections as $key => $section) {
                $startHour = rand(7, 10);
                $startMinute = rand(0, 59);
                $startTimeInit = sprintf('%02d:%02d', $startHour, $startMinute);

                $totalRandomVnTeacherTimes = rand(($section['duration'] * 0.1) * 100, ($section['duration'] / 2) * 100) / 100;
                $totalRandomForeignTeacherTimes = rand((($section['duration'] - $totalRandomVnTeacherTimes) * 0.1) * 100, (($section['duration'] - $totalRandomVnTeacherTimes) / 2) * 100) / 100;
                $totalRandomTutorTimes = $section['duration'] - $totalRandomVnTeacherTimes - $totalRandomForeignTeacherTimes;
            
                $startTime = strtotime($startTimeInit);
                $endTime = $startTime + $section['duration'] * 3600;

                $vnTeacherFromTime = $startTime;
                $vnTeacherToTime = $startTime + $totalRandomVnTeacherTimes * 3600;

                $foreignTeacherFromTime = $vnTeacherToTime;
                $foreignTeacherToTime = $foreignTeacherFromTime + $totalRandomForeignTeacherTimes * 3600;

                $tutorFromTime = $foreignTeacherToTime;
                $tutorToTime = $tutorFromTime + $totalRandomTutorTimes * 3600;

                $assistantFromTime = $vnTeacherFromTime;
                $assistantToTime = $foreignTeacherToTime;
            
                $studyDateStart = strtotime($courseData['start_at']);
                $studyDateEnd = strtotime($courseData['end_at']);
                
                $studyDate = (new \DateTime($section['date']))->format("Y-m-d");
                
                $startAt = $studyDate . ' ' . date('H:i', $startTime);
                $endAt = $studyDate . ' ' . date('H:i', $endTime);
                
                $vnTeacherFrom = date('H:i', $vnTeacherFromTime);
                $vnTeacherTo = date('H:i', $vnTeacherToTime);

                $foreignTeacherFrom = date('H:i', $foreignTeacherFromTime);
                $foreignTeacherTo = date('H:i', $foreignTeacherToTime);

                $tutorFrom = date('H:i', $tutorFromTime);
                $tutorTo = date('H:i', $tutorToTime);

                $assistantFrom = date('H:i', $assistantFromTime);
                $assistantTo = date('H:i', $assistantToTime);

                $sectionData = [
                    'course_id' => $createdCourse->id,
                    'status' => Section::STATUS_ACTIVE,
                    'study_date' => $studyDate,
                    'start_at' => $startAt,
                    'end_at' => $endAt,
                    'is_vn_teacher_check' => 'checked',
                    'is_foreign_teacher_check' => 'checked',
                    'is_tutor_check' => 'checked',
                    'is_assistant_check' => 'checked',
                    'vn_teacher_id' => Teacher::where('type', Teacher::TYPE_VIETNAM)->inRandomOrder()->first()->id,
                    'foreign_teacher_id' => Teacher::where('type', Teacher::TYPE_FOREIGN)->inRandomOrder()->first()->id,
                    'tutor_id' => Teacher::where('type', Teacher::TYPE_TUTOR)->inRandomOrder()->first()->id,
                    'assistant_id' => $assistantsRandom[array_rand($assistantsRandom)]['id'],
                    'vn_teacher_from' => $vnTeacherFrom,
                    'vn_teacher_to' => $vnTeacherTo,
                    'foreign_teacher_from' => $foreignTeacherFrom,
                    'foreign_teacher_to' => $foreignTeacherTo,
                    'tutor_from' => $tutorFrom,
                    'tutor_to' => $tutorTo,
                    'assistant_from' => $assistantFrom,
                    'assistant_to' => $assistantTo,
                    'code' => self::generateUiqueCode(),
                    'type' => Section::TYPE_GENERAL,
                    'order_number' => $key + 1,
                ];
            
                Section::create($sectionData);
            }
        }
    }
}
