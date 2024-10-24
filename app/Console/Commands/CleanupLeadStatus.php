<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupLeadStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-lead-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Có nhu cầu nhưng không tiềm năng
        \App\Models\ContactRequest::where('lead_status', 'Có nhu cầu nhưng không tiềm năng')->update(['lead_status' => \App\Models\ContactRequest::LS_NOT_POTENTIAL]);

        // Không nghe máy nhiều lần
        \App\Models\ContactRequest::where('lead_status', 'Không nghe máy nhiều lần')->update(['lead_status' => \App\Models\ContactRequest::LS_NOT_PICK_UP_MANY_TIMES]);

        // Sai số, không có nhu cầu
        \App\Models\ContactRequest::where('lead_status', 'Sai số/ Không có nhu cầu ')->update(['lead_status' => \App\Models\ContactRequest::LS_ERROR]);

        // Khách hàng
        \App\Models\ContactRequest::where('lead_status', 'Khách hàng ')->update(['lead_status' => \App\Models\ContactRequest::LS_HAS_CONSTRACT]);

        // Trùng data
        \App\Models\ContactRequest::where('lead_status', 'Trùng data')->update(['lead_status' => \App\Models\ContactRequest::LS_DUPLICATE_DATA]);

        // Chia lại (Không tiềm năng)
        \App\Models\ContactRequest::where('lead_status', 'Chia lại (Không tiềm năng)')->update(['lead_status' => \App\Models\ContactRequest::LS_NOT_POTENTIAL]);

        // Không có nhu cầu
        \App\Models\ContactRequest::where('lead_status', 'Không có nhu cầu')->update(['lead_status' => \App\Models\ContactRequest::LS_ERROR]);

        // Chưa gọi
        \App\Models\ContactRequest::where('lead_status', 'Chưa gọi')->update(['lead_status' => null]);

        // Có nhu cầu, cần khai thác thêm
        \App\Models\ContactRequest::where('lead_status', 'Có nhu cầu, cần khai thác thêm')->update(['lead_status' => \App\Models\ContactRequest::LS_HAS_REQUEST]);

        // ễn Thị Thanh Bình
        \App\Models\ContactRequest::where('lead_status', 'ễn Thị Thanh Bình')->update(['lead_status' => \App\Models\ContactRequest::LS_ERROR]);

        // Không có đơn hàng
        \App\Models\ContactRequest::where('lead_status', 'Không có đơn hàng')->update(['lead_status' => \App\Models\ContactRequest::LS_ERROR]);

        // T-KNM nhiều lần
        \App\Models\ContactRequest::where('lead_status', 'T-KNM nhiều lần')->update(['lead_status' => \App\Models\ContactRequest::LS_NOT_PICK_UP_MANY_TIMES]);

        // Có nhu cầu nhưng không tiềm năng
        \App\Models\ContactRequest::where('lead_status', 'Có nhu cầu nhưng không tiềm năng')->update(['lead_status' => \App\Models\ContactRequest::LS_NOT_POTENTIAL]);

        // Có nhu cầu, khai thác thêm
        \App\Models\ContactRequest::where('lead_status', 'Có nhu cầu, khai thác thêm')->update(['lead_status' => \App\Models\ContactRequest::LS_HAS_REQUEST]);

        // Follow dài
        \App\Models\ContactRequest::where('lead_status', 'Follow dài')->update(['lead_status' => \App\Models\ContactRequest::LS_FOLLOW]);

        // Không nghe máy, gọi lại sau
        \App\Models\ContactRequest::where('lead_status', 'Không nghe máy, gọi lại sau')->update(['lead_status' => \App\Models\ContactRequest::LS_NOT_PICK_UP]);

        // Liên hệ
        \App\Models\ContactRequest::where('lead_status', 'Liên hệ')->update(['lead_status' => \App\Models\ContactRequest::LS_HAS_REQUEST]);

        // Tiềm năng
        \App\Models\ContactRequest::where('lead_status', 'Tiềm năng')->update(['lead_status' => \App\Models\ContactRequest::LS_POTENTIAL]);
    }
}
