<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\ContactRequest;
use App\Models\ContactList;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::query()->delete();
        // Tạo danh sách các giá trị cho source_type

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
                    'email' => $randomEmail . $randomUniqueStr. $randomNumber . $randomDomain[array_rand($randomDomain)],
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
    }
}
