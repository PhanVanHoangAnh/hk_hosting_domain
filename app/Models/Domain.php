<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    public static function checkDomainIsExisting($domain): bool
    {
        // Kiểm tra tính hợp lệ của tên miền
        if (!filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return false; // Tên miền không hợp lệ
        }

        // Thực hiện lệnh whois
        $output = shell_exec("whois " . escapeshellarg($domain));
        
        // Kiểm tra kết quả từ lệnh whois
        if (strpos($output, 'No match for') !== false || strpos($output, 'NOT FOUND') !== false) {
            return false; // Tên miền chưa được đăng ký
        }

        return true; // Tên miền đã được đăng ký
    }
}
