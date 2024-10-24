<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\ContactRequest;
use App\Models\ContactList;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use App\Models\Order;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TrainingLocation;
use App\Models\OrderItem;


class AssignmentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

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
        //Contact và contact Request
        $marketingTypes = config('marketingTypes');
        $marketingSources = config('marketingSources');
        $marketingSourceSubs = config('marketingSourceSubs');
        $lifecycleStages = config('lifecycleStages');
        $leadStatuses = config('leadStatuses');

        $firstNames = [
            ['Tuấn', 'Minh'],
            ['Thư', 'Kiệt', 'Phong'],
            ['Trinh', 'Thảo', 'Sang', 'Dương'],
            ['Thu', 'Hải', 'Ngọc', 'Bích']
        ];
        $lastNames = ['Nguyễn', 'Lê', 'Trần', 'Phạm', 'Huỳnh', 'Võ', 'Đinh', 'Bùi', 'Đặng', 'Lý', 'Phan', 'Vũ', 'Trương', 'Châu', 'Cao', 'Quyền', 'Lã', 'Hưng', 'Mạc', 'Phúc'];
        $randomDomain = ['@gmail.com', '@bap.jp', '@hoangkhang.com.vn', '@yahoo.com.vn', '@yahoo.com', '@ptit.vn', '@outlook.com', '@mail.com', '@sv.ut.edu.vn', '@pttc.edu.vn'];
        $firstPart = ['091', '094', '088', '083', '084', '085', '081', '082', '086', '096', '097', '098', '039', '038', '037', '036', '035', '034', '033', '032', '070', '079', '077', '076', '078', '089', '090', '093'];
        $uniqueNumber = 0;

        for ($i = 1; $i <= 6; $i++) {
            foreach ($marketingSources as $source) {
                $numberOfWords = rand(2, 4);
                $selectedFirstNames = $firstNames[$numberOfWords - 2];
                $lastNameRand = $lastNames[array_rand($lastNames)];
                $fullnameParts = [$lastNameRand];

                for ($j = 0; $j < $numberOfWords - 1; $j++) {
                    $randomFirstName = $selectedFirstNames[array_rand($selectedFirstNames)];
                    $fullnameParts[] = $randomFirstName;
                }

                $fullname = implode(' ', $fullnameParts);
                $randomEmail = \Illuminate\Support\Str::slug($fullname, '');
                $randomUniqueStr = strval($uniqueNumber); // Configure the email seeder for each customer to ensure uniqueness and avoid duplication
                $randomNumber = rand(10, 999);
                $randomFirstPartPhone = $firstPart[array_rand($firstPart)];
                $randomSecondPart = rand(1000, 9999);
                $randomThirdPart = rand(100, 999);
                $accountId = [Account::sales()->inRandomOrder()->first()->id, null][rand(0, 1)];
                $assignedAt = $accountId ? \Carbon\Carbon::now()->subMinutes(rand(0, 40)) : null;
                $cities = config('cities');
                $city = $cities[rand(0, count($cities) - 1)];
                $cityName = $city['Name'];
                $district = $city['Districts'][rand(0, count($city['Districts']) - 1)];
                $districtName = $district['Name'];

                try {
                    $wardName = $district['Wards'][rand(0, count($district['Wards']) - 1)]['Name'];
                } catch (\Exception $e) {
                    $wardName = null;
                }

                $contact = Contact::create([
                    'account_id' => $accountId,
                    'name' => $fullname,
                    'email' => $randomEmail . $randomUniqueStr . $randomNumber . $randomDomain[array_rand($randomDomain)],
                    'phone' => $randomFirstPartPhone . $randomSecondPart . $randomThirdPart,
                    'address' => fake()->streetAddress(),
                    'district' => $districtName,
                    'city' => $cityName,
                    'ward' => $wardName,
                    'birthday' => fake()->date(),
                    'list' => ContactList::inRandomOrder()->first()->name,
                    'status' => Contact::STATUS_ACTIVE,
                ]);

                $contact->generateCode();

                $contact->update(['age' => Carbon::parse($contact->birthday)->diffInYears(Carbon::now())]);
                $contactRequest = $contact->addContactRequest([
                    'account_id' => $accountId,
                    'contact_id' => $contact->id,
                    'demand' => fake()->sentence(),
                    'school' => fake()->company(),
                    'efc' => '',
                    'target' => '',
                    'source_type' => fake()->randomElement($marketingTypes),
                    'channel' => $source,
                    'sub_channel' => fake()->randomElement($marketingSourceSubs[$source]),
                    'campaign' => fake()->sentence(),
                    'adset' => fake()->sentence(),
                    'ads' => fake()->word(),
                    'device' => fake()->randomElement(['Desktop', 'Mobile', 'Tablet']),
                    'placement' => fake()->country(),
                    'term' => fake()->word(),
                    'first_url' => fake()->url(),
                    'contact_owner' => fake()->unique()->e164PhoneNumber(),
                    'lifecycle_stage' => fake()->randomElement($lifecycleStages),
                    'lead_status' => null,
                    'pic' => 'PIC Value',
                    'gclid' => Uuid::uuid4()->toString(),
                    'fbcid' => Uuid::uuid4()->toString(),
                    'time_to_call' => fake()->time(),
                    'type_match' => fake()->text(50),
                    'last_url' => fake()->url(),
                    'assigned_at' => $assignedAt,
                    'address' => fake()->streetAddress(),
                    'district' => $districtName,
                    'city' => $cityName,
                    'ward' => $wardName,
                    'status' => ContactRequest::STATUS_ACTIVE,
                    'schedule_freetime' => '[[{"day":"1","time":"00:00","endTime":"23:59"},{"day":"2","time":"00:00","endTime":"23:59"},{"day":"3","time":"00:00","endTime":"23:59"},{"day":"4","time":"00:00","endTime":"23:59"},{"day":"5","time":"00:00","endTime":"23:59"},{"day":"6","time":"00:00","endTime":"23:59"},{"day":"7","time":"00:00","endTime":"23:59"}]]'
                ]);

                // generate order code
                $contactRequest->generateCode();

                $uniqueNumber++;
            }
        }

        // Gắn contact cho user
        $contact = Contact::skip(0)->take(1)->first();
        $contact->email = 'hoan@gmail.com';
        $contact->save();

        $contact = Contact::skip(0)->take(1)->first();
        $contact->email = 'hoanganhstudent@gmail.com';
        $contact->save();

        $contact = Contact::skip(10)->take(1)->first();
        $contact->email = 'phong@gmail.com';
        $contact->save();

        // Tạo lớp học class
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
        $endDateRangeFinish = strtotime('2024-04-31');

        $classTypes = Course::getAllClassTypes();

        $rooms = ['Phòng 101', 'Phòng 102', 'Phòng 103', 'Phòng 104', 'Phòng 105'];

        foreach ($courses as $course) {
            $randomTotalHours = mt_rand(3, 7);
            $classTypeRandomIndex = mt_rand(0, 1);
            $maxStudents = rand(30, 40);
            $minStudents = rand(10, 15);
            $startAt = date('Y-m-d H:i:s', mt_rand($beginDateRangeStart, $beginDateRangeFinish));
            $endAt = date('Y-m-d H:i:s', mt_rand($endDateRangeStart, $endDateRangeFinish));
            $subject = Subject::orderBy('id')->first();
            $courseTotalHours = intval(fake()->numberBetween($min = 100, $max = 200));

            $courseData = [
                'subject_id' => rand(1, 5),
                'type' => $subject->type,
                'study_method' => Course::STUDY_METHOD_OFFLINE,
                'level' => 'Advanced',
                'status' => $statuses[rand(0, count($statuses) - 1)],
                'start_at' => $startAt,
                'end_at' => $endAt,
                'teacher_id' => Teacher::inRandomOrder()->first()->id,
                'max_students' => $maxStudents,
                'min_students' => $minStudents,
                'vn_teacher_duration' => 4,
                'foreign_teacher_duration' => 0,
                'tutor_duration' => 0,
                'assistant_duration' => 0,
                'joined_students' => null,
                'week_schedules' => '[
                    {
                        "name": "mon",
                        "schedules": [
                            {
                                "id": "ltznbcttq9ros",
                                "code": "ltznbctscix8i",
                                "type": "general",
                                "end_at": "18:13",
                                "start_at": "17:13",
                                "tutor_id": null,
                                "tutor_to": null,
                                "tutor_from": null,
                                "assistant_id": null,
                                "assistant_to": null,
                                "vn_teacher_id": "1",
                                "vn_teacher_to": "18:13",
                                "assistant_from": null,
                                "is_tutor_check": false,
                                "vn_teacher_from": "17:13",
                                "foreign_teacher_id": null,
                                "foreign_teacher_to": null,
                                "is_assistant_check": false,
                                "is_vn_teacher_check": true,
                                "foreign_teacher_from": null,
                                "is_foreign_teacher_check": false
                            }
                        ]
                    }
                ]',
                'test_hours'=>'0.00',
                'total_hours' => $courseTotalHours,
                'class_type' => 'class',
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
                    'is_foreign_teacher_check' => null,
                    
                    'is_tutor_check' => null,
                    'is_assistant_check' => 'checked',
                    'vn_teacher_id' => Teacher::where('type', Teacher::TYPE_VIETNAM)->inRandomOrder()->first()->id,
                    'foreign_teacher_id' => null,
                    'tutor_id' => null,
                    'assistant_id' => $assistantsRandom[array_rand($assistantsRandom)]['id'],
                    'vn_teacher_from' => $vnTeacherFrom,
                    'vn_teacher_to' => $vnTeacherTo,
                    'foreign_teacher_from' => null,
                    'foreign_teacher_to' => null,
                    'tutor_from' => null,
                    'tutor_to' => null,
                    'assistant_from' => $assistantFrom,
                    'assistant_to' => $assistantTo,
                    'code' => self::generateUiqueCode(),
                    'type' => Section::TYPE_GENERAL,
                    'order_number' => $key + 1,
                ];

                Section::create($sectionData);
            }
        }

        // Order Item
        $types = Order::getAllTypeVariable();
        $industries = config('industries');

        $firstNames = [
            ['Hoa', 'Minh'],
            ['Hùng', 'Phương', 'Tâm'],
            ['Thành', 'Linh', 'Anh', 'Nam'],
            ['Thu', 'Hải', 'Ngọc', 'Bích']
        ];
        $lastNames = ['Nguyễn', 'Lê', 'Trần', 'Phạm', 'Huỳnh', 'Võ', 'Đinh', 'Bùi', 'Đặng', 'Lý', 'Phan', 'Vũ', 'Trương'];
        $firstPart = ['091', '094', '088', '083', '084', '085', '081', '082', '086', '096', '097', '098', '039', '038', '037', '036', '035', '034', '033', '032', '070', '079', '077', '076', '078', '089', '090', '093'];
        $randomDomain = ['@gmail.com', '@bap.jp', '@hoangkhang.com.vn', '@yahoo.com.vn', '@yahoo.com', '@ptit.vn'];

        $statuses = [
            Order::STATUS_DRAFT,
            Order::STATUS_PENDING,
            Order::STATUS_APPROVED,
            Order::STATUS_REJECTED,
        ];

        for ($i = 1; $i < 300; $i++) {
            $numberOfWords = rand(2, 4);
            $selectedFirstNames = $firstNames[$numberOfWords - 2];
            $lastNameRand = $lastNames[array_rand($lastNames)];
            $fullnameParts = [$lastNameRand];
            $parentFullnameParts = [$lastNameRand];
            $is_pay_all = 'on'; // rand(0, 1) ? 'on' : 'off';

            // Tạo dữ liệu giả lập cho trường `schedule_items`
            if ($is_pay_all === 'on') {
                $debt_allow = rand(0, 1) ? 'on' : 'off';
                $schedule_items = null;
            } else {
                // Tạo dữ liệu giả lập cho trường `schedule_items`
                $debt_allow = 'off';
                $scheduleItems = [];
                $numberOfScheduleItems = rand(1, 3);
                for ($j = 0; $j < $numberOfScheduleItems; $j++) {
                    $scheduleItems[] = [
                        'amount' => fake()->numberBetween($min = 5000000, $max = 10000000),
                        'due_date' => fake()->dateTimeBetween($startDate = '-30 days', $endDate = '+30 days')->format('Y-m-d'),
                    ];
                }
                $schedule_items = json_encode($scheduleItems);
            }

            if ($debt_allow === 'on') {
                $debt_due_date = fake()->date($format = 'Y-m-d', $max = '2029-12-31', $min = '2022-12-31');
            } else {
                $debt_due_date = null;
            }

            for ($j = 0; $j < $numberOfWords - 1; $j++) {
                $randomFirstName = $selectedFirstNames[array_rand($selectedFirstNames)];
                $fullnameParts[] = $randomFirstName;
            }

            for ($j = 0; $j < $numberOfWords - 1; $j++) {
                $randomFirstName = $selectedFirstNames[array_rand($selectedFirstNames)];
                $parentFullnameParts[] = $randomFirstName;
            }

            $fullname = implode(' ', $fullnameParts);
            $parentFullname = implode(' ', $parentFullnameParts);
            $randomFirstPartPhone = $firstPart[array_rand($firstPart)];
            $randomParentFirstPartPhone = $firstPart[array_rand($firstPart)];
            $randomSecondPart = rand(1000, 9999);
            $randomThirdPart = rand(100, 999);
            $randomVietnameseName = \Illuminate\Support\Str::slug($fullname, '');
            $randomParentVietnameseName = \Illuminate\Support\Str::slug($parentFullname, '');
            $randomNumber = rand(1000, 9999);
            $status = $statuses[array_rand($statuses)];
            $rejectedReason = $status == Order::STATUS_REJECTED ? "Lý do: " . fake()->sentence() : null;
            $contact = Contact::inRandomOrder()->first();
            $sale = Account::inRandomOrder()->first();

            // random contact request with order
            $contactRequests = $contact->contactRequests()->doesntHaveOrder();

            if ($contactRequests->count()) {
                $contactRequest = $contactRequests->inRandomOrder()->first();
                $contactRequestId = $contactRequest->id;
            } else {
                $contactRequestId = null;
            }

            $orderTotalAmount = round(fake()->numberBetween($min = 50000000, $max = 100000000), -3);

            //
            $orderType = $types[rand(0, count($types) - 1)];
            if ($orderType == Order::TYPE_REQUEST_DEMO) {
                $statuses = [
                    Order::STATUS_DRAFT,
                    Order::STATUS_APPROVED,
                ];
                $status = $statuses[array_rand($statuses)];
            }

            $order = Order::create([
                'contact_id' => $contact->id,
                'contact_request_id' => $contactRequestId,
                'sale' => $sale->id,
                'sale_sup' => $sale->accountGroup->manager_id,
                'fullname' => $fullname,
                'birthday' => fake()->date($format = 'Y-m-d', $max = '2020-12-31'),
                'phone' => $randomFirstPartPhone . $randomSecondPart . $randomThirdPart,
                'email' => $randomVietnameseName . $randomNumber . $randomDomain[array_rand($randomDomain)],
                'current_school' => fake()->name() . ' school',
                'parent_note' => fake()->sentence(),
                'industry' => $industries[rand(0, count($industries) - 1)],
                'type' => $orderType,
                'status' => $status,
                'rejected_reason' => $rejectedReason,
                'price' => $orderTotalAmount,
                'discount_code' => fake()->numberBetween($min = 0, $max = 100),
                'currency_code' => 'VND',
                'student_id' => $contact->id,
                'order_date' => fake()->dateTimeBetween('2023-10-01', '2023-12-31'),
                'schedule_items' => $schedule_items,
                'is_pay_all' => $is_pay_all,
                'debt_due_date' => $debt_due_date,
                'debt_allow' => $debt_allow
            ]);

            if ($order->contactRequest) {
                $order->contactRequest->setLeadStatus(ContactRequest::LS_HAS_CONSTRACT);
                $order->contactRequest->setPreviousLeadStatus(ContactRequest::LS_HAS_CONSTRACT);
            }

            // update cache total
            $order->updateCacheTotal();

            // generate order code
            $order->generateCode();

            // Create order items
            $trainProducts = config('trainProducts');
            $abroadProducts = config('abroadProducts');

            $classTypes = Course::getAllClassTypes();
            $homeRooms = config('homeRooms');
            $topSchools = config('topSchools');
            $academicAwards = config('academicAwards');
            $postgraduatePlans = config('postgraduatePlans');
            $personalities = config('personalities');
            $subjectPreferences = config('subjectPreferences');
            $languageAndCultures = config('languageAndCultures');
            $researchInfos = config('researchInfos');
            $aims = config('aims');
            $essayWritingSkills = config('essayWritingSkills');
            $extraActivities = config('extraActivities');
            $personalCounselingNeeds = config('personalCounselingNeeds');
            $parentJobs = config('parentJobs');
            $isParentStudiedAbroadOptions = config('isParentStudiedAbroadOptions');
            $parentIncomes = config('parentIncomes');
            $parentFamiliarAbroad = config('parentFamiliarAbroad');
            $parentTimeSpendWithChilds = config('parentTimeSpendWithChilds');
            $branchs = config('branchs');
            $studyTypes = config('studyTypes');
            $teachers = config('teacherTypes');
            $units = config('units');
            $genders = config('genders');
            $currencies = config('currencies');
            $subject = Subject::orderBy('id')->first();

            if ($order->type === Order::TYPE_EDU) {
                $price = $orderTotalAmount;
                $priceVN = round($orderTotalAmount * 0.4, -3);
                $priceNN = round($orderTotalAmount * 0.3, -3);
                $priceTutor = $price - $priceVN - $priceNN;

                $orderItemData = [
                    'status' => 'active',
                    'type' => Order::TYPE_EDU,
                    'order_id' => $order->id,
                    "subject_id" => rand(1, 5),
                    "order_type" => $subject->type,
                    'price' => $price,
                    'currency_code' => 'VND',
                    'exchange' => 24000,
                    'discount_code' => fake()->numberBetween($min = 0, $max = 100),
                    'level' => 'Advanced',
                    'class_type' => 'class',
                    'num_of_student' => fake()->randomElement([1, 2, 3, 5]),
                    'study_type' => Course::STUDY_METHOD_OFFLINE,
                    'target' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'home_room' => Teacher::inRandomOrder()->first()->id,
                    'duration' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'unit' => $units[rand(0, count($units) - 1)],
                    'num_of_vn_teacher_sections' => rand(10, 25),
                    'num_of_foreign_teacher_sections' => 0,
                    'num_of_tutor_sections' => 0,
                    'vietnam_teacher_minutes_per_section' => rand(120, 350),
                    'foreign_teacher_minutes_per_section' => 0,
                    'tutor_minutes_per_section' => 0,
                    'vn_teacher_price' => $priceVN,
                    'foreign_teacher_price' => $priceNN,
                    'tutor_price' => $priceTutor,
                ];

                OrderItem::create($orderItemData);
            }

            if ($order->type = Order::TYPE_ABROAD) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'status' => 'active',
                    'type' => Order::TYPE_ABROAD,
                    'train_product' => $trainProducts[rand(0, count($trainProducts) - 1)],
                    'price' => fake()->numberBetween($min = 50000000, $max = 1000000000),
                    'discount_code' => fake()->numberBetween($min = 0, $max = 100),
                    'abroad_product' => $abroadProducts[rand(0, count($abroadProducts) - 1)],
                    'apply_time' => fake()->date(),
                    'gender' => $genders[rand(0, count($genders) - 1)],
                    'GPA' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'std_score' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'eng_score' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'plan_apply' => fake()->text(20),
                    'intended_major' => fake()->text(20),
                    'academic_award' => $academicAwards[rand(0, count($academicAwards) - 1)],
                    'postgraduate_plan' => $postgraduatePlans[rand(0, count($postgraduatePlans) - 1)],
                    'personality' => $personalities[rand(0, count($personalities) - 1)],
                    'subject_preference' => $subjectPreferences[rand(0, count($subjectPreferences) - 1)],
                    'language_culture' => $languageAndCultures[rand(0, count($languageAndCultures) - 1)],
                    'research_info' => $researchInfos[rand(0, count($researchInfos) - 1)],
                    'aim' => $aims[rand(0, count($aims) - 1)],
                    'essay_writing_skill' => $essayWritingSkills[rand(0, count($essayWritingSkills) - 1)],
                    'extra_activity' => $extraActivities[rand(0, count($extraActivities) - 1)],
                    'personal_countling_need' => $personalCounselingNeeds[rand(0, count($personalCounselingNeeds) - 1)],
                    'other_need_note' => implode("\n", fake()->sentences()),
                    'parent_job' => $parentJobs[rand(0, count($parentJobs) - 1)],
                    'parent_highest_academic' => fake()->text(20),
                    'is_parent_studied_abroad' => $isParentStudiedAbroadOptions[rand(0, count($isParentStudiedAbroadOptions) - 1)],
                    'parent_income' => $parentIncomes[rand(0, count($parentIncomes) - 1)],
                    'parent_familiarity_abroad' => $parentFamiliarAbroad[rand(0, count($parentFamiliarAbroad) - 1)],
                    'is_parent_family_studied_abroad' => fake()->randomElement([true, false]),
                    'parent_time_spend_with_child' => $parentTimeSpendWithChilds[rand(0, count($parentTimeSpendWithChilds) - 1)],
                    'financial_capability' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1000000),
                    'estimated_enrollment_time' => fake()->date(),
                ];

                $orderItem = OrderItem::create($orderItemData);

                // If the contract is a study abroad contract and has been approved, it will create a study abroad profile.
                if ($order->status = Order::STATUS_APPROVED) {
                    $orderItem->createAbroadApplication();
                }
            }

            if ($order->type === Order::TYPE_REQUEST_DEMO) {
                $orderItemData = [
                    'status' => 'active',
                    'type' => Order::TYPE_REQUEST_DEMO,
                    'order_id' => $order->id,
                    "subject_id" => rand(1, 5),
                    "order_type" => $subject->type,
                    'level' => 'Advanced',
                    'class_type' => 'class',
                    'num_of_student' => fake()->randomElement([1, 2, 3, 5]),
                    'study_type' => $studyTypes[rand(0, count($studyTypes) - 1)],
                    'branch' => $branchs[rand(0, count($branchs) - 1)],
                    'target' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'home_room' => Teacher::isHomeRoom()->inRandomOrder()->first()->id,
                    'duration' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'unit' => $units[rand(0, count($units) - 1)],
                    'num_of_vn_teacher_sections' => rand(10, 25),
                    'num_of_foreign_teacher_sections' => 0,
                    'num_of_tutor_sections' => 0,
                    'vietnam_teacher_minutes_per_section' => rand(120, 350),
                    'foreign_teacher_minutes_per_section' => 0,
                    'tutor_minutes_per_section' => 0,
                ];

                OrderItem::create($orderItemData);
            }
        }
    }
}
