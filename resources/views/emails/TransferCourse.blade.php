<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" /> -->
    <style>
        .material-symbols-rounded {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }

        .large-dot {
            width: 5.8px;
            height: 5.8px;
            background-color: black;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .info {
            font-size: 13px
        }

        .content {
            font-size: 15px
        }

   
        .container {
    width: 100%;
    max-width: 1200px; 
    margin: 0 auto;
    padding: 20px;
}


.row {
    margin-bottom: 10px;
    overflow: hidden;
}

/* Column styles */
.col-xl-3,
.col-lg-3,
.col-md-3,
.col-sm-3,
.col-xs-3,
.col-3 {
    float: left;
    width: 25%; /* Adjust as needed */
}

.col-xl-4,
.col-lg-4,
.col-md-4,
.col-sm-4,
.col-xs-4,
.col-4 {
    width: 33.333%; /* 4-column layout */
    float: left;
}

.col-xl-8,
.col-lg-8,
.col-md-8,
.col-sm-8,
.col-xs-8,
.col-8 {
    width: 66.667%; /* 8-column layout */
    float: left;
}
.col-xl-9,
.col-lg-9,
.col-md-9,
.col-sm-9,
.col-xs-9,
.col-9 {
    float: left;
    width: 75%; /* Adjust as needed */
}

/* Column styles */
.col-xl-12,
.col-lg-12,
.col-md-12,
.col-sm-12,
.col-xs-12,
.col-12 {
    width: 100%; 
}
 


.fw-bold {
    font-weight: bold;  
}

.info {
    color: #666;  
}
 
.info span {
    display: block;  
    padding: 5px 0; 
} 

.text-center {
    text-align: center; 
}
 
.row {
    margin-bottom: 3px;  
}


 
.text-dark {
    color: #333; 
}

.fw-bold {
    font-weight: bold; 
}


span.content {
    padding: 5px 0; 
} 


 


.fw-bold {
    font-weight: bold; 
}

.text-center {
    text-align: center; 
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
th {
    background-color: #f2f2f2;
}
.online {
    background-color: #e6f7ff;
}
.offline {
    background-color: #fff7e6;
}
    </style>

</head>

<body
    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">

    <table class="wrapper" width="120%" cellpadding="0" cellspacing="0" role="presentation"
        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;">
        <tr>
            <td align="center"
                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <table class="content" width="120%" cellpadding="0" cellspacing="0" role="presentation"
                    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
                    <tr>
                        <td class="header"
                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; padding: 25px 0; text-align: center;">
                            <a href="http://localhost"
                                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
                                <img src="{{ url('/media/logos/asms_logo.png') }}" class="logo" alt="Laravel Logo"
                                    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100%; border: none; height: 150px; max-height: 150px; width: 200px;">
                            </a>
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="120%" cellpadding="0" cellspacing="0"
                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%; border: hidden !important;">
                            <table class="inner-body" align="center" width="1200" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 800px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 800px;">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell"
                                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 300vw; padding: 32px;">

                                        
                            
                                        <!-- Table header -->
                                        
                                        <!-- Table body -->
                                        <div class="row mb-3">
                                            <!-- Part 1 -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 my-3">
                                                <p class="notification-header">Kính gửi Quý Phụ huynh và học viên
                                                    Trung tâm American Study xin thông báo về thông tin chuyển lớp của học viên {{$orderItem->order->student->name}} như sau</p>
                                               
                                                <div class="row mb-3">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                                <span class="fw-bold text-dark fs-7">Mã lớp học cũ: {{$currentCourse->code}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                                <span class="fw-bold text-dark fs-7">1. THÔNG TIN LỚP HỌC</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table>
                                                    <tr>
                                                        <th>Lớp học</th>
                                                        <th>Giáo viên chủ nhiệm</th>
                                                        <th>Môn học</th>
                                                        <th>Ngày bắt đầu học</th>
                                                        <th>Hình thức</th>
                                                        <th>Địa điểm học</th>
                                                    </tr>
                                                    <tr class="online">
                                                        <td> {{$courseTransfer->code}}</td>
                                                        <td>{{$courseTransfer->teacher->name}}</td>
                                                        <td>{{$courseTransfer->subject->name}}</td>
                                                       
                                                        <td> {{ date('d/m/Y', strtotime($courseTransfer->getStartStudyStudent($orderItem)->end_at)) }}</td>
                                                        <td>{{$courseTransfer->study_method}}</td>

                                                        <td>
                                                            @if($courseTransfer->zoom_join_link)
                                                                <a href="{{ $courseTransfer->zoom_join_link }}">Link Zoom</a>
                                                            @else
                                                           {{$courseTransfer->trainingLocation->address }}, {{$courseTransfer->trainingLocation->name }}, {{$courseTransfer->trainingLocation->branch }}  
                                                            @endif
                                                        </td>
                                                        
                                                    </tr>
                                                   
                                                </table>
                                                <p class="notification-header">2. Đường link nhận báo cáo học tập:</p>
                                                <p>Quý Phụ huynh/ Học viên truy cập vào đường link sau để theo dõi toàn bộ thời khóa biểu, tình học tập của học viên:</p>
                                                <p><a href="{{ action([App\Http\Controllers\Student\SectionController::class, 'calendar']) }}" class="report-link">Link</a></p>
                                                <p>Trong trường hợp Quý Phụ huynh/ Học viên có bất kì thắc mắc gì, vui lòng liên hệ chủ nhiệm của lớp <strong>{{$courseTransfer->code}}</strong>:</p>
                                                <p>Chủ nhiệm: <strong>{{$courseTransfer->teacher->name}}</strong></p>
                                                <p>Số điện thoại: <strong>{{$courseTransfer->teacher->phone}}</strong></p>
                                                <p>Email: <strong>{{$courseTransfer->teacher->email}}</strong></p>
                                                <p>Chúc Quý học viên có buổi học hiệu quả!</p>
                                                <p>Trân trọng.</p>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 800px; margin: 0 auto; padding: 0; text-align: center; width: 800px;">
                                <tr>
                                    <td class="content-cell" align="center"
                                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100vw; padding: 32px;">
                                        <p
                                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">
                                            © 2024 ASMS. All rights reserved.</p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
<style>


</style>

</html>
<!-- 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script> -->