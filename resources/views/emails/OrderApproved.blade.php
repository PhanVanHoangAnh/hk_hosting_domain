<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans');
    </style>

    <!-- Invoice styling -->
    <style>
        * {
            font-family: 'Noto Sans', sans-serif !important;
            font-weight: normal!important;
            font-style: normal!important;
        }
    </style>

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

        /* Default row styles */
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
            width: 100%; /* Full width on extra small screens */
        }

        .col-xl-4,
        .col-lg-4,
        .col-md-4,
        .col-sm-4,
        .col-xs-4,
        .col-4 {
            float: left;
            width: 50%; /* 2-column layout on small screens */
        }

        .col-xl-8,
        .col-lg-8,
        .col-md-8,
        .col-sm-8,
        .col-xs-8,
        .col-8 {
            float: left;
            width: 50%; /* 2-column layout on small screens */
        }

        .col-xl-9,
        .col-lg-9,
        .col-md-9,
        .col-sm-9,
        .col-xs-9,
        .col-9 {
            float: left;
            width: 100%; /* Full width on small screens */
        }

    /* Large screens */
    @media (min-width: 992px) {
        .col-xl-3,
        .col-lg-3,
        .col-md-3 {
            width: 25%; /* 4-column layout on large screens */
        }
        
        .col-xl-4,
        .col-lg-4,
        .col-md-4 {
            width: 33.333%; /* 3-column layout on large screens */
        }

        .col-xl-8,
        .col-lg-8,
        .col-md-8 {
            width: 66.667%; /* 8-column layout on large screens */
        }

        .col-xl-9,
        .col-lg-9,
        .col-md-9 {
            width: 75%; /* 9-column layout on large screens */
        }
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

                                        <div class="">
                                            <div class="row mb-4">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                    <div class="row mb-2">
                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-3">
                                                            <span class="text-dark fw-bold info">Tên công ty</span>
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-9">
                                                            <span class="info">Công ty Cổ phần Giáo dục American Study</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-3">
                                                            <span class="text-dark fw-bold info">Địa chỉ</span>
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-9">
                                                            <span class="info"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-3">
                                                            <span class="text-dark fw-bold info">Mã số thuế</span>
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-9">
                                                            <span class="info">0108413933</span>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div> 
                                        
                                        <div class="row mb-5" style="margin-top: 40px">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 text-center text-dark fw-bold">
                                                <span class="text-center text-dark fw-bold">BIÊN BẢN THỎA THUẬN KHÓA HỌC</span>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 text-center text-dark fw-bold">
                                                <span class="text-center text-dark fw-bold">(KIÊM BIÊN BẢN BÀN GIAO HỌC SINH)</span>
                                            </div>
                                        </div>
                                        <!-- Table header -->
                                        <div class="row mb-3" style="margin-top: 20px">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                <div class="row mb-2">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
                                                        <span class="text-dark fw-bold content">Ngày bàn giao</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{!! $order->contactRequest->assigned_at !!}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
                                                        <span class="text-dark fw-bold content">Ngày đóng phí</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ !is_null($order->getLastPaymentDate()) ? $order->getLastPaymentDate()->payment_date : "Chưa thu" }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
                                                        <span class="text-dark fw-bold content">Mã số</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->code }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
                                                        <span class="text-dark fw-bold content">Tổng giá trị</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ number_format($order->getTotalPriceOfItems(), 0, '.', ',') }} đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Table body -->
                                        <div class="row mb-3" style="margin-top: 30px">
                                            <!-- Part 1 -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 my-3">
                                                <div class="row mb-3">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                                <span class="fw-bold text-dark fs-7">1. THÔNG TIN HỌC SINH</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Mã học viên:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contacts->code }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Mã cũ học viên:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contacts->import_id }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Họ và tên:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contacts->name }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Ngày sinh:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">
                                                            {{ $order->contacts->birthday ? date('d/m/Y', strtotime($order->contacts->birthday)) : '--' }}
                                                        </span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Số điện thoại:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contactRequest->phone }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                            <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Email:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contacts->email }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Lớp/Trường:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contactRequest->school }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Địa chỉ nhà:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contactRequest->address }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Lưu ý về học sinh:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ $order->contactRequest->demand }}</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-dark content">Nhân viên tư vấn:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content">{{ \App\Models\Account::find($order->sale)->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- signer is student -->
                                            @if ($order->student_id == $order->contact_id)
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 my-3" style="margin-top: 30px">
                                                    <div class="row mb-3">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                                    <span class="fw-bold text-dark fs-7">Học viên là người ký hợp đồng</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Part 2 -->
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 my-3" style="margin-top: 30px">
                                                    <div class="row mb-3">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                                    <span class="fw-bold text-dark fs-7">2. THÔNG TIN VỀ PHỤ HUYNH</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="row mb-3">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                            <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <span class="text-dark content">Họ và tên:</span>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                            <span class="content">{{ \App\Models\Contact::find($order->contact_id)->name }}</span>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="row mb-3">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                            <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <span class="text-dark content">Số điện thoại:</span>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                            <span class="content"></span>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="row mb-3">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                            <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <span class="text-dark content">Email:</span>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                            <span class="content">{{ \App\Models\Contact::find($order->contact_id)->email }}</span>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="row mb-3">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                            <span class="large-dot"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <span class="text-dark content">Note thông tin:</span>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                            <span class="content">{{ \App\Models\Contact::find($order->contact_id)->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                    
                                            <!-- Part 3 -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 my-3" style="margin-top: 30px">
                                                <div class="row mb-3">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                                                                <span class="fw-bold text-dark fs-7">3. THÔNG TIN KHÓA HỌC</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3" style="margin-top: 20px">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="text-dark content" style="font-weight: bold">Thời gian học dự kiến:</span>
                                                    </div>
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                                                        <span class="content"></span>
                                                    </div>
                                                </div>
                                    
                                                <hr>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="text-dark content">Môn học</span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="text-dark content">Trình độ</span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="text-dark content">Chi tiết khóa học</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class=""></span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class=""></span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class=""></span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="">Math</span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="">S</span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="">ABC</span>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="">Môn học</span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="">Literature</span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 d-flex align-items-center">
                                                        <span class="">XYZ</span>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">
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
</html>