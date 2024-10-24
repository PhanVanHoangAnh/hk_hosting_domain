<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->timestamps();
        });

        // insert init values
        $demandNames = [
            "Tài Liệu Luận Ivy",
            "Ebook Chiến Lược SAT",
            "Ebook 15 Bài Luận",
            "Debate",
            "AP",
            "Creative Writing",
            "SAT",
            "Trại hè MIT",
            "DHM",
            "Leadership",
            "Ebook",
            "Đại học quốc tế",
            "IELTS",
            "Webinar",
            "Thi Thử SAT",
            "Ebook SAT",
            "DHM Viết Luận",
            "Trại Tết",
            "Hội Thảo Offline",
            "Ebook Danh Sách Học Bổng",
            "CC",
            "Kid",
            "Hội Thảo Nguyễn Siêu",
            "Vin",
            "Trại Los",
            "Video Recap",
            "Đại Học Quốc Tế",
            "Trại Anh",
            "Trại Úc",
            "DHC",
            "Trại Chung",
            "Workshop",
            "Webinar Lâm Hà",
            "Trại Sing-Malay",
            "Combo SAT",
            "Trại Việt Nam",
            "SAT Test",
            "World Scholarship",
            "Infographic DHM",
            "Ebook Tuyển Sinh",
            "Ebook Hướng Dẫn Viết Luận",
            "Học Thử SAT",
            "Speakout",
            "Chưa xác định",
            "Du học các nước khác",
            "Webinar SAT",
            "Webinar Viết Luận",
            "Webinar Chiến lược trúng tuyển",
        ];

        //
        foreach ($demandNames as $demandName) {
            \App\Models\Demand::findOrCreate($demandName);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};
