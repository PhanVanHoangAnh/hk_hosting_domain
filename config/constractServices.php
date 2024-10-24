<?php

use App\Models\Order;

    $data = [];

    $ieltsLevels = [
        "itemType" => "level",
        "name" => "IELTS",
        "itemKey" => "ielts",
        "values" => [
            "Destination-Foundation",
            "Pre ielts-mindset 1",
            "Pre inter-mindset 2",
            "Inter-mindset 3",
            "Upper inter-official",
            "Advanced"
        ]
    ];

    $satLevels = [
        "itemType" => "level",
        "name" => "SAT",
        "itemKey" => "sat",
        "values" => [
            "Pre",
            "Ultimate",
            "Advanced"
        ]
    ];

    $academicServices = [
        "itemType" => "service",
        "name" => "Học thuật",
        "itemKey" => "academic",
        "values" => [
            "A Level Biology",
            "A Level Chemistry",
            "A Level Maths",
            "ACT",
            "American Culture",
            "American Literature",
            "AMERICAN READING",
            "AP",
            "AP BIO",
            "AP Calculus",
            "AP Chemistry",
            "AP CS",
            "AP History",
            "AP Human Geography",
            "AP Macro",
            "AP Micro",
            "AP Physics",
            "AP Statistics",
            "Business Analysis",
            "Computer Science",
            "Creative Writing",
            "Debate",
            "ELA",
            "ESL",
            "FCE",
            "Financial Accounting",
            "GLOBAL ENGLISH & SCIENCE 6",
            "Gmat",
            "Grammar",
            "IB",
            "IB Chemistry",
            "IB Economics",
            "IB Math",
            "IGCSE ESL",
            "IGCSE Math",
            "IGCSE Science",
            "IGCSE Spanish",
            "Literature",
            "Math",
            "Persuasive writing",
            "PET",
            "Reading",
            "Reading & Writing",
            "Reading Literature",
            "SCIENCE",
            "Social Issues",
            "Spanish",
            "Speak Out",
            "Speaking",
            "SSAT",
            "SSAT Math",
            "SSAT Verbal",
            "Tiếng Việt",
            "TOEFL",
            "TOEIC",
            "Tutor DH",
            "Vocab IELTS+ GMAT",
            "Writing",
            "Writing & Present",
            "WSC"
        ]
    ];

    $kidServices = [
        "itemType" => "service",
        "name" => "Kids",
        "itemKey" => "kid",
        "values" => [
            "English In Motion",
            "Flyers",
            "IPA",
            "KET",
            "Kid's Box",
            "Leadership",
            "Market Leader",
            "Math & Science",
            "MOVERS",
            "Ollie",
            "Story Telling",
            "Presentation"
        ]
    ];

    $kiteServices = [
        "itemType" => "service",
        "name" => "Kite",
        "itemKey" => "kite",
        "values" => [
            "Coding",
            "Lập trình",
            "Roblox"
        ]
    ];

    $basicPackage = [
        "itemType" => "package",
        "name" => "Cơ bản",
        "itemKey" => "basic",
        "values" => []
    ];

    $intermediate1Package = [
        "itemType" => "package",
        "name" => "Nâng cao 1",
        "itemKey" => "intermediate1",
        "values" => [
            "Các khóa tiếng anh"
        ]
    ];

    $intermediate2Package = [
        "itemType" => "package",
        "name" => "nâng cao 2",
        "itemKey" => "intermediate2",
        "values" => []
    ];

    $advancePackage = [
        "itemType" => "package",
        "name" => "Cao cấp",
        "itemKey" => "advance",
        "values" => [
            "Đào tạo tiếng Anh",
            "Đào tạo tin học"
        ]
    ];
    
    $thesisPackageServices = [
        "itemType" => "service",
        "itemKey" => "thesis",
        "name" => "Gói luận kèm HDDH",
        "values" => [
            "CAE",
            "College writing",
            "Edits",
            "ESSAY",
            "Interview",
            "Luận",
            "Supp essay"
        ]
    ];

    $abroadConsultationServices = [
        "itemType" => "service",
        "itemKey" => "abroadConsultation",
        "name" => "Gói tư vấn du học",
        "values" => [
            "GÓI APPLY 10-12 TRƯỜNG ĐẠI HỌC MỸ TOP 30-100 $8.000 (HOẶC CÁC TRƯỜNG ĐẠI HỌC QUỐC TẾ TẠI VN NHƯ VIN UNI, BUV, RMIT, FULL BRIGHT,...)",
            "GÓI APPLY 15-18 TRƯỜNG ĐẠI HỌC MỸ TOP 30-100 - $10.000",
            "GÓI APPLY 3 TRƯỜNG ĐH MỸ TOP 10-20 VÀ 10 TRƯỜNG TOP 100 - $15.000",
            "GÓI APPLY 6 TRƯỜNG ĐH MỸ TOP 10-20 VÀ 10 TRƯỜNG TOP 30-50 - $20.000",
            "GÓI APPLY 10 TRƯỜNG ĐẠI HỌC MỸ TOP 10 VÀ 5 TRƯỜNG TOP 30-50 - $30.000",
            "GÓI APPLY 7-10 TRƯỜNG THPT MỸ - $7.000",
            "GÓI APPLY 12-15 TRƯỜNG THPT MỸ- $10.000"
        ]
    ];

    $extraAcademicServices = [
        "itemType" => "service",
        "itemKey" => "educational",
        "name" => "Academic",
        "values" => [
            "Inova",
            "Viết báo",
            "Sản phẩm công nghệ"
        ]
    ];

    $eventServices = [
        "itemType" => "service",
        "itemKey" => "event",
        "name" => "Event/CLB",
        "values" => [
            "Từ thiện",
            "Trải nghiệm văn hóa",
            "Phát triển bản thân"
        ]
    ];

    $artServices = [
        "itemType" => "service",
        "itemKey" => "art",
        "name" => "Nghệ thuật",
        "values" => [
            "Chụp ảnh",
            "Thiết kế",
            "Vẽ chì",
            "Vẽ màu nước",
            "Vẽ màu Acrylic",
            "Vẽ màu tổng hợp",
            "Hát",
            "Múa",
            "Nhảy",
            "Đàn tính",
            "Guitar",
            "Piano",
            "Violin",
            "Múa mâm",
            "Nhạc cụ đàn tranh",
            "Nhạc cụ khèn",
            "Portfolio"
        ]
    ];

    $eduType = [
        "itemType" => "type",
        "itemKey" => Order::TYPE_EDU,
        "name" => Order::TYPE_EDU,
        "values" => []
    ];

    $demoType = [
        "itemType" => "type",
        "itemKey" => Order::TYPE_REQUEST_DEMO,
        "name" => Order::TYPE_REQUEST_DEMO,
        "values" => []
    ];


    $techType = [
        "itemType" => "type",
        "itemKey" => "tech",
        "name" => "Công nghệ",
        "values" => []
    ];

    $extraType = [
        "itemType" => "type",
        "itemKey" => "extra",
        "name" => "Ngoại khóa",
        "values" => []
    ];

    $abroadType = [
        "itemType" => "type",
        "itemKey" => Order::TYPE_ABROAD,
        "name" => Order::TYPE_ABROAD,
        "values" => []
    ];

    $academicServices["values"][] = $ieltsLevels;
    $academicServices["values"][] = $satLevels;

    $basicPackage["values"][] = $thesisPackageServices;
    $basicPackage["values"][] = $abroadConsultationServices;

    $intermediate1Package["values"][] = $thesisPackageServices;
    $intermediate1Package["values"][] = $abroadConsultationServices;

    $intermediate2Package["values"][] = $thesisPackageServices;
    $intermediate2Package["values"][] = $abroadConsultationServices;
    $intermediate2Package["values"][] = $academicServices;
    $intermediate2Package["values"][] = $eventServices;
    $intermediate2Package["values"][] = $artServices;

    $advancePackage["values"][] = $thesisPackageServices;
    $advancePackage["values"][] = $abroadConsultationServices;
    $advancePackage["values"][] = $academicServices;
    $advancePackage["values"][] = $eventServices;
    $advancePackage["values"][] = $artServices;

    $eduType["values"][] = $academicServices;
    $eduType["values"][] = $kidServices;

    $demoType["values"][] = $academicServices;
    $demoType["values"][] = $kidServices;

    $techType["values"][] = $kiteServices;

    $extraType["values"][] = $extraAcademicServices;
    $extraType["values"][] = $eventServices;
    $extraType["values"][] = $artServices;

    $abroadType["values"][] = $basicPackage;
    $abroadType["values"][] = $intermediate1Package;
    $abroadType["values"][] = $intermediate2Package;
    $abroadType["values"][] = $advancePackage;

    $data[] = $eduType;
    $data[] = $demoType;
    $data[] = $techType;
    $data[] = $abroadType;
    $data[] = $extraType;

    return $data;
?>