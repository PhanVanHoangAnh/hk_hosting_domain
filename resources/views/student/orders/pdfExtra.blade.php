<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bản Thỏa Thuận Khóa Học</title>
    <style>
        body {
            /* font-family: Arial, sans-serif; */
            line-height: 1.2;
            margin: 20px;
            font-size: 12px;
        
        }
        .company-info {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .info-table th, .info-table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .note {
            font-style: italic;
            margin-top: 10px;
        }
        .note th {
            text-align: center; 
        }
        .note td {
            text-align: center; 
        }
        .info-table th {
            text-align: left; 
            width: 30%; 
            
        }

        
    </style>
</head>
<body>
    <div class="company-info">
        <p><strong>Tên công ty:</strong> Công ty Cổ phần Giáo dục American Study</p>
        <p><strong>Địa chỉ:</strong> Tòa nhà Viettel Complex 285 Cách Mạng Tháng 8, P. 12, Q.10, Tp. Hồ Chí Minh, Việt Nam</p>
        <p><strong>Mã số thuế:</strong> 0108413933</p>
    </div>
    
    <h2 style="text-align: center;">BẢN THỎA THUẬN KHÓA HỌC </h2>
    <h2 style="text-align: center;">(KIÊM BIÊN BẢN BÀN GIAO HỌC SINH) </h2>
    
    <p><strong>Ngày bàn giao:</strong> {{$order->order_date}}</p>
    <p><strong>Ngày đóng phí:</strong> --</p>
    <p><strong>Mã số:</strong> HDDT/05/484</p>
    <p><strong>Tổng giá trị:</strong>  {{ number_format($order->getTotal(), 0, '.', ',') }} </p>

    <div class="section-title">1. THÔNG TIN VỀ HỌC SINH</div>
    <table class="info-table">
        <tr>
            <th>Mã học viên</th>
            <td>{{$order->student->code}}</td>
        </tr>
        <tr>
            <th>Họ và tên</th>
            <td>{{$order->student->name}}</td>
        </tr>
        <tr>
            <th>Ngày sinh</th>
            <td>
                {{ $order->student->birthday ? date('d/m/Y', strtotime($order->student->birthday)) : '--' }}
                </td>
        </tr>
        <tr>
            <th>Số điện thoại</th>
            <td>{{$order->student->phone ?? ''}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{$order->student->email}}</td>
        </tr>
        <tr>
            <th>Lớp/ Trường</th>
            <td>{{$order->student->school}}</td>
        </tr>
        <tr>
            <th>Địa chỉ nhà</th>
            <td>{{$order->student->address}}</td>
        </tr>
        <tr>
            <th>Lưu ý về học sinh</th>
            <td></td>
        </tr>
        <tr>
            <th>Nhân viên tư vấn</th>
            <td>{{$order->salesperson->name}}</td>
        </tr>
    </table>

    <div class="section-title">2. THÔNG TIN VỀ PHỤ HUYNH</div>
    <table class="info-table">
        <tr>
            <th>Họ và tên</th>
            
            <td>
                @if ($order->student->getFather())
                    {{ $order->student->getFather() ? $order->student->getFather()->name : '' }}
                @elseif ($order->student->getMother())
                    {{ $order->student->getMother() ? $order->student->getMother()->name : '' }}
                @endif 
            </td>
           
        </tr>
        <tr>
            <th>SĐT</th>
            <td>
                @if ($order->student->getFather())
                    {{ $order->student->getFather() ? $order->student->getFather()->phone : '' }}
                @elseif ($order->student->getMother())
                    {{ $order->student->getMother() ? $order->student->getMother()->phone : '' }}
                @endif 
            </td>
        </tr>
        <tr>
            <th>Email</th>
            <td>
                @if ($order->student->getFather())
                    {{ $order->student->getFather() ? $order->student->getFather()->email : '' }}
                @elseif ($order->student->getMother())
                    {{ $order->student->getMother() ? $order->student->getMother()->email : '' }}
                @endif 
            </td>
        </tr>
        <tr>
            <th>Note thông tin</th>
            <td></td>
        </tr>
    </table>

    <div class="section-title">3. THÔNG TIN KHOÁ HỌC</div>
    <table class="info-table">
        {{-- <tr>
            <th>Thời gian học dự kiến</th>
            <td>Dự kiến khai giảng 05/06/2024</td>
        </tr> --}}
        <tr>
            <th>Tên chương trình</th>
            <th>Loại chương trình</th>
            <th>Địa điểm</th>
        </tr>
        @foreach($order->orderItems()->get() as $orderItem)
        <tr>
            <td>{{$orderItem->extracurricular->name}}</td>
            
            <td>{{$orderItem->extracurricular->type}}</td>
            <td>{{$orderItem->extracurricular->address}}</td>
        </tr>
        @endforeach
       
    </table>

    <div class="note">
        
        <table class="info-table">
            <tr>
                <th colspan="1" style="border: none; text-align: center;">ĐẠI DIỆN HỌC VIÊN</th>
                <th colspan="3" style="border: none; text-align: center;">ĐẠI DIỆN CÔNG TY</th>
            </tr>
            <tr>
                <th style="border: none;"></th>
                <th style="border: none; text-align: center;">PHÒNG KẾ TOÁN</th>
                <th style="border: none; text-align: center;">PHÒNG BÀN GIAO</th>
                <th style="border: none; text-align: center;">PHÒNG NHẬN BÀN GIAO</th>
            </tr>
        </table>
        
        
    </div>
    
</body>
</html>
