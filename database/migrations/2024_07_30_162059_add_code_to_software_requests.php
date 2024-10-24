<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('software_requests', function (Blueprint $table) {
            $table->string('code')->nullable(); // Thêm cột code
            $table->unique('code'); // Tạo chỉ mục unique cho cột code
        });

        // Đảm bảo dữ liệu hiện có trong bảng có giá trị code tự động
        $requests = DB::table('software_requests')->get();

        foreach ($requests as $request) {
            // Lấy ba ký tự đầu tiên của tên
            $nameParts = explode(' ', $request->company_name); // Tách tên thành các phần
            $namePrefix = '';
            
            foreach ($nameParts as $part) {
                if (!empty($part)) {
                    $namePrefix .= strtoupper(substr($part, 0, 1)); // Lấy chữ cái đầu của mỗi phần
                }
            }

            // Tạo giá trị code với số tăng dần
            $lastCode = DB::table('software_requests')
                          ->where('code', 'like', "{$namePrefix}%")
                          ->orderBy('code', 'desc')
                          ->first();
            
            $nextNumber = $lastCode ? intval(substr($lastCode->code, -4)) + 1 : 1;
            $code = $namePrefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Cập nhật bản ghi với giá trị code tự động
            DB::table('software_requests')
                ->where('id', $request->id)
                ->update(['code' => $code]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('software_requests', function (Blueprint $table) {
            
        });
    }
};
