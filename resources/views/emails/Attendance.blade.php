<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .notification {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
        }

        .notification-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .notification p {
            margin: 10px 0;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="notification">
        <p class="notification-header">Kính gửi Quý Phụ huynh và học viên,</p>
        <p>Trung tâm American Study xin thông báo về kết quả học tập của học viên <strong>{{$sectionReport->student->name}}</strong>:</p>

        <p>Lớp học <strong>{{$studentSection->section->course->code}}</strong></p>

        <p>Học viên vào lớp lúc <strong>{{$studentSection->start_at}}</strong> và kết thúc lớp học lúc <strong>{{$studentSection->end_at}}</strong></p>

        <p>Nội dung buổi học: <strong>{{$sectionReport->content}}</strong></p>

        <p>Nhận xét của giáo viên theo thang điểm 5: 
            <strong>
                Tính đúng giờ: {{$sectionReport->tinh_dung_gio}}<br>
                Mức độ tập trung: {{$sectionReport->muc_do_tap_trung}}<br>
                Mức độ hiểu bài: {{$sectionReport->muc_do_hieu_bai}}<br>
                Mức độ tương tác: {{$sectionReport->muc_do_tuong_tac}}<br>
                Tự học và giải quyết vấn đề: {{$sectionReport->tu_hoc_va_giai_quyet_van_de}}<br>
                Tự tin trách nhiệm: {{$sectionReport->tu_tin_trach_nhiem}}<br>
                Trung thực kỷ luật:{{$sectionReport->trung_thuc_ky_luat}} <br>
                Kết quả trên lớp: {{$sectionReport->ket_qua_tren_lop}}<br>
            </strong>
        </p>
        

        <p>Trong trường hợp Quý Phụ huynh/ Học viên có bất kì thắc mắc gì, vui lòng liên hệ chủ nhiệm của lớp <strong>{{$studentSection->section->course->code}}</strong>:</p>

        <p>Chủ nhiệm: <strong>{{$studentSection->section->course->teacher->name}}</strong></p>

        <p>Số điện thoại: <strong>{{$studentSection->section->course->teacher->phone}}</strong></p>

        <p>Email: <strong>{{$studentSection->section->course->teacher->email}}</strong></p>
        <p>Trân trọng.</p>
    </div>
</body>
</html>
