<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::query()->delete();
        $trainProducts = config('trainProducts');
        $abroadProducts = config('abroadProducts');
        $levels = config('levels');
        $classTypes = config('classTypes');
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

        for ($i = 1; $i < 100; $i++) {

            $orderType = fake()->randomElement([Order::TYPE_EDU]);
            $orderItemData = [
                'order_id' => Order::inRandomOrder()->first()->id,
                "subject_id" => Subject::inRandomOrder()->first()->id,
                'train_product' => null,
                'abroad_product' => null,
                'price' => null,
                'currency_code' => null,
                'exchange' => 24000,
                'discount_code' => null,
                'level' => null,
                'class_type' => null,
                'num_of_student' => null,
                'study_type' => true,
                'branch' => null,
                'vietnam_teacher' => true,
                'foreign_teacher' => true,
                'tutor_teacher' => true,
                'target' => null,
                'home_room' => null,
                'duration' => null,
                'unit' => null,
                'train_hours' => null,
                'demo_hours' => null,

                'apply_time' => null,
                'gender' => null,
                'GPA' => null,
                'std_score' => null,
                'eng_score' => null,
                'plan_apply' => null,
                'intended_major' => null,
                'postgraduate_plan' => null,
                'personality' => null,
                'subject_preference' => null,
                'language_culture' => null,
                'research_info' => null,
                'aim' => null,
                'essay_writing_skill' => null,
                'personal_countling_need' => null,
                'other_need_note' => null,
                'parent_job' => null,
                'parent_highest_academic' => null,
                'is_parent_studied_abroad' => null,
                'parent_income' => null,
                'parent_familiarity_abroad' => null,
                'is_parent_family_studied_abroad' => null,
                'parent_time_spend_with_child' => null,
                'financial_capability' => null,
                'estimated_enrollment_time' => null,
            ];

            $orderItemData['type'] = $orderType;

            if ($orderType == Order::TYPE_EDU) {
                $orderItemData['subject_id'] = Subject::inRandomOrder()->first()->id;
                $orderItemData['train_product'] = $trainProducts[rand(0, count($trainProducts) - 1)];
                $orderItemData['price'] = fake()->numberBetween($min = 50000000, $max = 1000000000);
                $orderItemData['discount_code'] = fake()->numberBetween($min = 0, $max = 100);
                $orderItemData['level'] = $levels[rand(0, count($levels) - 1)];
                $orderItemData['class_type'] = $classTypes[rand(0, count($classTypes) - 1)];
                $orderItemData['currency_code'] = 'VND';
                $orderItemData['num_of_student'] = fake()->randomElement([1, 2, 3, 5]);
                $orderItemData['study_type'] = $studyTypes[rand(0, count($studyTypes) - 1)];
                $orderItemData['branch'] = $branchs[rand(0, count($branchs) - 1)];
                $orderItemData['vietnam_teacher'] = fake()->numberBetween($min = 10, $max = 10000);
                $orderItemData['foreign_teacher'] = fake()->numberBetween($min = 10, $max = 10000);
                $orderItemData['tutor_teacher'] = fake()->numberBetween($min = 10, $max = 10000);
                $orderItemData['target'] = fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10);
                $orderItemData['home_room'] = $homeRooms[rand(0, count($homeRooms) - 1)];
                $orderItemData['duration'] = fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10);
                $orderItemData['unit'] = $units[rand(0, count($units) - 1)];
                $orderItemData['train_hours'] = fake()->numberBetween($min = 10, $max = 1000);
                $orderItemData['demo_hours'] = fake()->numberBetween($min = 10, $max = 1000);

                $orderItemData['num_of_vn_teacher_sections'] = rand(10, 25);
                $orderItemData['num_of_foreign_teacher_sections'] = rand(10, 25);
                $orderItemData['num_of_tutor_sections'] = rand(10, 25);
                $orderItemData['vietnam_teacher_minutes_per_section'] = rand(120, 350);
                $orderItemData['foreign_teacher_minutes_per_section'] = rand(120, 350);
                $orderItemData['tutor_minutes_per_section'] = rand(120, 350);
            } else {
                $orderItemData['train_product'] = $trainProducts[rand(0, count($trainProducts) - 1)];
                $orderItemData['price'] = fake()->numberBetween($min = 50000000, $max = 1000000000);
                $orderItemData['discount_code'] = fake()->numberBetween($min = 0, $max = 100);
                $orderItemData['abroad_product'] = $abroadProducts[rand(0, count($abroadProducts) - 1)];
                $orderItemData['apply_time'] = fake()->date();
                $orderItemData['gender'] = $genders[rand(0, count($genders) - 1)];
                $orderItemData['GPA'] = fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10);
                $orderItemData['std_score'] = fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10);
                $orderItemData['eng_score'] = fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10);
                $orderItemData['plan_apply'] = fake()->text(20);
                $orderItemData['intended_major'] = fake()->text(20);
                $orderItemData['academic_award'] = $academicAwards[rand(0, count($academicAwards) - 1)];
                $orderItemData['postgraduate_plan'] = $postgraduatePlans[rand(0, count($postgraduatePlans) - 1)];
                $orderItemData['personality'] = $personalities[rand(0, count($personalities) - 1)];
                $orderItemData['subject_preference'] = $subjectPreferences[rand(0, count($subjectPreferences) - 1)];
                $orderItemData['language_culture'] = $languageAndCultures[rand(0, count($languageAndCultures) - 1)];
                $orderItemData['research_info'] = $researchInfos[rand(0, count($researchInfos) - 1)];
                $orderItemData['aim'] = $aims[rand(0, count($aims) - 1)];
                $orderItemData['essay_writing_skill'] = $essayWritingSkills[rand(0, count($essayWritingSkills) - 1)];
                $orderItemData['extra_activity'] = $extraActivities[rand(0, count($extraActivities) - 1)];
                $orderItemData['personal_countling_need'] = $personalCounselingNeeds[rand(0, count($personalCounselingNeeds) - 1)];
                $orderItemData['other_need_note'] = implode("\n", fake()->sentences());
                $orderItemData['parent_job'] = $parentJobs[rand(0, count($parentJobs) - 1)];
                $orderItemData['parent_highest_academic'] = fake()->text(20);
                $orderItemData['is_parent_studied_abroad'] = $isParentStudiedAbroadOptions[rand(0, count($isParentStudiedAbroadOptions) - 1)];
                $orderItemData['parent_income'] = $parentIncomes[rand(0, count($parentIncomes) - 1)];
                $orderItemData['parent_familiarity_abroad'] = $parentFamiliarAbroad[rand(0, count($parentFamiliarAbroad) - 1)];
                $orderItemData['is_parent_family_studied_abroad'] = fake()->randomElement([true, false]);
                $orderItemData['parent_time_spend_with_child'] = $parentTimeSpendWithChilds[rand(0, count($parentTimeSpendWithChilds) - 1)];
                $orderItemData['financial_capability'] = fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1000000);
                $orderItemData['estimated_enrollment_time'] = fake()->date();
            }

            OrderItem::create($orderItemData);
        }
    }
}
