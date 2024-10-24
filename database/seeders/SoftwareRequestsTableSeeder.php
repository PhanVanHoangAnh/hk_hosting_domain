<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Contact;
use App\Models\SoftwareRequest;
use App\Models\Account;

class SoftwareRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $statuses = [
            SoftwareRequest::STATUS_NEW,
            SoftwareRequest::STATUS_CARE,
            SoftwareRequest::STATUS_DELIVERED,
        ];
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

        $companySizes = [
            '1 - 15 nhân sự',
            '16 - 50 nhân sự',
            '51 - 100 nhân sự',
            '101 - 300 nhân sự',
            '301 - 500 nhân sự',
            '501 - 1000 nhân sự',
            'Trên 1000 nhân sự',
        ];

        $randomDomain = ['@gmail.com', '@bap.jp', '@hoangkhang.com.vn', '@yahoo.com.vn', '@yahoo.com', '@ptit.vn', '@outlook.com', '@mail.com', '@sv.ut.edu.vn', '@pttc.edu.vn'];

        for ($i = 0; $i < 10; $i++) {
            $accountId = [Account::sales()->inRandomOrder()->first()->id, null][rand(0, 1)];

            $numberOfWords = rand(2, 4);
            $selectedFirstNames = $firstNames[$numberOfWords - 2];
            $lastNameRand = $lastNames[array_rand($lastNames)];
            $fullnameParts = [$lastNameRand];

            $randomNumber = rand(10, 999);
            $randomFirstPartPhone = $firstPart[array_rand($firstPart)];
            $randomSecondPart = rand(1000, 9999);
            $randomThirdPart = rand(100, 999);

            for ($j = 0; $j < $numberOfWords - 1; $j++) {
                $randomFirstName = $selectedFirstNames[array_rand($selectedFirstNames)];
                $fullnameParts[] = $randomFirstName;
            }

            $fullname = implode(' ', $fullnameParts);
            $randomEmail = \Illuminate\Support\Str::slug($fullname, '');
            $randomUniqueStr = strval($uniqueNumber); 
            $randomNumber = rand(10, 999);
            $contact = Contact::create([
                'account_id' => $accountId,
                'name' => $fullname = implode(' ', $fullnameParts),
                'email' => $randomEmail . $randomUniqueStr. $randomNumber . $randomDomain[array_rand($randomDomain)],
                'phone' => $randomFirstPartPhone . $randomSecondPart . $randomThirdPart,
                'address' => fake()->streetAddress(),
                'status' => Contact::STATUS_ACTIVE,
                
            ]);
            $softwareRequest = $contact->addSoftwareRequest([
                'account_id' => $accountId,
                
                'company_name' => fake()->company,
                'company_size' => fake()->randomElement($companySizes),
                'company_branch' => fake()->numberBetween(1, 5), 
                'line_of_business' => fake()->catchPhrase,
                'note' => fake()->sentence,
                'status' => fake()->randomElement($statuses),
                'estimated_cost' => $this->getRandomEstimatedCost(),
                
                
            ]);
           
        }
    }
    private function getRandomEstimatedCost()
    {
        return mt_rand(500000000, 3000000000) + mt_rand() / mt_getrandmax();
    }
}
