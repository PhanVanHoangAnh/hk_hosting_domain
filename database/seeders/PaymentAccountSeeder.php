<?php

namespace Database\Seeders;

use App\Models\AccountGroup;
use App\Models\PaymentAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class PaymentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentAccount::query()->delete();
    
        $firstNames = [
            ['Huy', 'Khang', 'Bảo', 'Minh', 'Phúc', 'Anh', 'Khoa', 'Phát', 'Đạt', 'Khôi', 'Long' ],
            ['Nam', 'Duy', 'Quân', 'Kiệt', 'Thịnh', 'Tuấn', 'Hưng', 'Hoàng', 'Hiếu'],
            ['Anh', 'Trang', 'Linh', 'Phương', 'Hương', 'Thảo', 'Hà', 'Huyền', 'Ngọc', 'Hằng' ],
            ['Giang', 'Nhung', 'Yến', 'Nga', 'Mai', 'Thu', 'Hạnh', 'Vân', 'Hoa', 'Hiền']
        ];
        $lastNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Vũ', 'Võ', 'Phan', 'Trương', 'Bùi', 'Đặng', 'Đỗ', 'Ngô', 'Hồ', 'Dương', 'Đinh', 'Lý', 'Châu', 'Cao', 'Lã', 'Hưng', 'Mạc', 'Phúc'];   
       
        for ($i = 1; $i <= 15; $i++) {

            $numberOfWords = rand(2, 4);
                $selectedFirstNames = $firstNames[$numberOfWords - 2];            
                $lastNameRand = $lastNames[array_rand($lastNames)];
                $fullnameParts = [$lastNameRand];

                for ($j = 0; $j < $numberOfWords - 1; $j++) {
                    $randomFirstName = $selectedFirstNames[array_rand($selectedFirstNames)];
                    $fullnameParts[] = $randomFirstName;
                }

                $fullname = implode(' ', $fullnameParts);

            PaymentAccount::create([
                
                
                'bank' => fake()->randomElement(['Agribank', 'BIDV', 'BIDV', 'VietinBank', 'Vietcombank', 'VPBank', 'MB', 'Techcombank']),
                'account_name' => $fullname,
                'account_number' => fake()->bankAccountNumber,
                'description' => fake()->sentence,
                'status' => fake()->randomElement(['active']),
                // 'account_group_id' => '',


            ]);
        }
        
    }
}
