<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\OrderItem;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Account;
use App\Models\ContactRequest;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::query()->delete();
        Order::query()->delete();
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
            $sale = Account::sales()->inRandomOrder()->first();

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
                'sale_sup' => isset($sale->accountGroup->manager_id) ? $sale->accountGroup->manager_id : null,
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
                $order->contactRequest->save();
            }

            // update cache total
            $order->updateCacheTotal();

            // generate order code
            $order->generateCode();

            // Create order items
            $trainProducts = config('trainProducts');
            $abroadProducts = config('abroadProducts');
            $levels = config('levels');
            $classTypes = Course::getAllClassTypes();
            $homeRooms = config('homeRooms');
            $topSchools = config('topSchools');
            $postgraduatePlans = config('postgraduatePlans');
            $personalities = config('personalities');
            $subjectPreferences = config('subjectPreferences');
            $languageAndCultures = config('languageAndCultures');
            $researchInfos = config('researchInfos');
            $aims = config('aims');
            $essayWritingSkills = config('essayWritingSkills');
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
            $subject = Subject::inRandomOrder()->first();

            if ($order->type === Order::TYPE_EDU) {
                $price = $orderTotalAmount;
                $priceVN = round($orderTotalAmount * 0.4, -3);
                $priceNN = round($orderTotalAmount * 0.3, -3);
                $priceTutor = $price - $priceVN - $priceNN;

                $orderItemData = [
                    'status' => 'active',
                    'type' => Order::TYPE_EDU,
                    'order_id' => $order->id,
                    "subject_id" => $subject->id,
                    "order_type" => $subject->type,
                    'price' => $price,
                    'currency_code' => 'VND',
                    'level' => $levels[rand(0, count($levels) - 1)],
                    'class_type' => $classTypes[rand(0, count($classTypes) - 1)],
                    'num_of_student' => fake()->randomElement([1, 2, 3, 5]),
                    'study_type' => $studyTypes[rand(0, count($studyTypes) - 1)],
                    'target' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'home_room' => Teacher::inRandomOrder()->first()->id,
                    'num_of_vn_teacher_sections' => rand(10, 25),
                    'num_of_foreign_teacher_sections' => rand(10, 25),
                    'num_of_tutor_sections' => rand(10, 25),
                    'vietnam_teacher_minutes_per_section' => rand(120, 350),
                    'foreign_teacher_minutes_per_section' => rand(120, 350),
                    'tutor_minutes_per_section' => rand(120, 350),
                    'vn_teacher_price' => $priceVN,
                    'foreign_teacher_price' => $priceNN,
                    'tutor_price' => $priceTutor,
                ];

                OrderItem::create($orderItemData);
            }

            if ($order->type === Order::TYPE_ABROAD) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'status' => 'active',
                    'type' => Order::TYPE_ABROAD,
                    'price' => fake()->numberBetween($min = 50000000, $max = 1000000000),
                    'apply_time' => fake()->date(),
                    'std_score' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'eng_score' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'postgraduate_plan' => $postgraduatePlans[rand(0, count($postgraduatePlans) - 1)],
                    'personality' => $personalities[rand(0, count($personalities) - 1)],
                    'subject_preference' => $subjectPreferences[rand(0, count($subjectPreferences) - 1)],
                    'language_culture' => $languageAndCultures[rand(0, count($languageAndCultures) - 1)],
                    'research_info' => $researchInfos[rand(0, count($researchInfos) - 1)],
                    'aim' => $aims[rand(0, count($aims) - 1)],
                    'essay_writing_skill' => $essayWritingSkills[rand(0, count($essayWritingSkills) - 1)],
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
                    "subject_id" => $subject->id,
                    "order_type" => $subject->type,
                    'level' => $levels[rand(0, count($levels) - 1)],
                    'class_type' => $classTypes[rand(0, count($classTypes) - 1)],
                    'num_of_student' => fake()->randomElement([1, 2, 3, 5]),
                    'study_type' => $studyTypes[rand(0, count($studyTypes) - 1)],
                    'target' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
                    'home_room' => Teacher::isHomeRoom()->inRandomOrder()->first()->id,
                    'num_of_vn_teacher_sections' => rand(10, 25),
                    'num_of_foreign_teacher_sections' => rand(10, 25),
                    'num_of_tutor_sections' => rand(10, 25),
                    'vietnam_teacher_minutes_per_section' => rand(120, 350),
                    'foreign_teacher_minutes_per_section' => rand(120, 350),
                    'tutor_minutes_per_section' => rand(120, 350),
                ];

                OrderItem::create($orderItemData);
            }
        }
    }
}
