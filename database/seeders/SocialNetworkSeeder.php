<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;

class SocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = Contact::all(); // Lấy danh sách tất cả các contacts

        foreach ($contacts as $contact) {
            // Tạo 2 mạng xã hội ngẫu nhiên cho mỗi contact, một có link và một không có link
            for ($i = 0; $i < 2; $i++) {
                $name = $this->getRandomSocialNetworkName();
                $link = null; // Mặc định không có link

                // Random để quyết định có link hay không
                if (rand(0, 1) == 1) {
                    $link = 'https://example.com/' . strtolower($name);
                }

                DB::table('social_network')->insert([
                    'contact_id' => $contact->id,
                    'name' => $name,
                    'link' => $link,
                ]);
            }
        }
    }
    /**
     * Phương thức để trả về một tên mạng xã hội ngẫu nhiên
     */
    private function getRandomSocialNetworkName(): string
    {
        $socialNetworks = ['Facebook', 'Twitter', 'Instagram', 'LinkedIn']; // Thêm các mạng xã hội khác nếu cần
        return $socialNetworks[array_rand($socialNetworks)];
    }
}
