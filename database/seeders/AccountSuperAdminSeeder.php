<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TrainingLocation;
use App\Models\User;

class AccountSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Tìm vai trò "Super Admin"
        $superAdminRole = Role::where('name', 'Super Admin')->first();
    
        // Kiểm tra nếu vai trò "Super Admin" không tồn tại, bạn có thể tạo mới ở đây
        if (!$superAdminRole) {
            $superAdminRole = Role::create([
                'name' => 'Super Admin',
            ]);
        }
    
        // Lấy tất cả người dùng
        $users = User::all();
    
        // Lặp qua mỗi người dùng và gắn vai trò "Super Admin" cho họ
        foreach ($users as $user) {
            // Xóa tất cả các vai trò hiện có của người dùng
            $user->roles()->detach();
    
            // Gắn vai trò "Super Admin" vào người dùng
            $user->roles()->attach($superAdminRole);
        }
    }
    
}