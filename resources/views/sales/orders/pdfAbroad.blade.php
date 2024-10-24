<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biên Bản Bàn Giao Học Sinh Du Học</title>
    <style>
        body {
            line-height: 1.2;
            margin: 20px;
            font-size: 11px; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }


        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            padding: 10px 0;
        }
        .border-none, .border-none th, .border-none td {
            border: none;
            background-color: unset;
            margin-top: 10px;
        }
        .info-table th {
            text-align: left; 
            width: 40%; 
            
        }
        
    </style>
</head>

<body>

    <table class='border-none'>
        <h2 style="text-align: center;">BIÊN BẢN BÀN GIAO HỌC SINH DU HỌC	 </h2>
    
    
    <p><strong>Ngày bàn giao:</strong>
        {{ date("d/m/Y", strtotime($order->created_at)) }}
    </p>
    <p><strong>Ngày đóng phí:</strong> 
        {{ optional($order->paymentRecords->first())->payment_date ? date("d/m/Y", strtotime($order->paymentRecords->first()->payment_date)) : '--' }}
    </p>
    <p><strong>Mã số:</strong> {{$order->code}}</p>
    <p><strong>Tổng giá trị:</strong>  {{ number_format($order->getTotal(), 0, '.', ',') }} </p>

    </table>

    <h3>1. THÔNG TIN PHỤ HUYNH</h3>
    <table class="info-table">
        <tr>
            <th>Họ và tên</th>
            
            <td>
                @if ($order->student->getFather())
                    {{ $order->student->getFather() ? $order->student->getFather()->name : '' }}
                @elseif ($order->student->getMother())
                    {{ $order->student->getMother() ? $order->student->getMother()->name : '' }}
                @else
                    --
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
                @else
                    --
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
                @else
                    --
                @endif 
            </td>
        </tr>
        <tr>
            <th>Nghề nghiệp</th>
            <td>{{ $order->orderItems()->first()->parent_job ?? '--' }}</td>
        </tr>
        <tr>
            
            <th>Khả năng tài chính tối đa/ năm du học cho con</th>
            <td>{{ $order->orderItems()->first()->financial_capability?? '--' }}</td>
        </tr>
    </table>

    <h3>2. THÔNG TIN HỌC SINH</h3>
    <table class="info-table">
        @foreach($order->orderItems()->get() as $orderItem)
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
                <td>{{$order->student->phone ?? '--'}}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{$order->student->email ?? '--'}}</td>
            </tr>
            <tr>
                <th>Lớp/ Trường</th>
                <td>{{$order->student->school ?? '--'}}</td>
            </tr>
            <tr>
                <th>Giới tính</th>
                <td>
                    {!! $order->student->gender ?  trans('messages.contact.gender.' . $order->student->gender)  : '--' !!}
                </td>
            </tr>
            <tr>
                <th>Điểm GPA Lớp 9-10-11-12</th>
                <td>
                    <li style="margin-left: 8px;">Lớp 9: {{$orderItem->point_1}}</li>
                    <li style="margin-left: 8px;">Lớp 10: {{$orderItem->point_2}}</li>
                    <li style="margin-left: 8px;">Lớp 11: {{$orderItem->point_3}}</li>
                    <li style="margin-left: 8px;">Lớp 12: {{$orderItem->point_4}}</li>
                </td>
            </tr>
            <tr>
                <th>Điểm thi chuẩn hóa</th>
                <td>{{$orderItem->std_score }}</td>
            </tr>
            {{-- <tr>
                <th>IELTS</th>
                <td>{{$orderItem->eng_score }}</td>
            </tr> --}}
{{--          
            <tr>
                <th>Các điểm khác: AP/ IB/ A LEVEL/ IGCSE</th>
                <td></td>
            </tr> --}}
            <tr>
                <th>Giải quốc gia/ quốc tế</th>
                <td>
                    @if ($orderItem->academic_award_1)
                        <li style="margin-left: 8px;">Có giải học thuật quốc tế đẳng cấp (olympic học thuật quốc tế): {{$orderItem->academic_award_text_1}}</li>
                    @endif 
                    @if ($orderItem->academic_award_2)
                        <li style="margin-left: 8px;">Có giải cấp quốc gia: {{$orderItem->academic_award_text_2}}</li>
                    @endif
                    @if ($orderItem->academic_award_3)
                        <li style="margin-left: 8px;">Giải quốc tế uy tín (World Scholar's Cup, etc.): {{$orderItem->academic_award_text_3}}</li>
                    @endif
                    @if ($orderItem->academic_award_4)
                        <li style="margin-left: 8px;">Có giải cấp tỉnh: {{$orderItem->academic_award_text_4}}</li>
                    @endif
                    @if ($orderItem->academic_award_5)
                        <li style="margin-left: 8px;">Giải nước ngoài: {{$orderItem->academic_award_text_5}}</li>
                    @endif
                    @if ($orderItem->academic_award_6)
                        <li style="margin-left: 8px;">Giải khoa học ở quy mô nhỏ, vừa: {{$orderItem->academic_award_text_6}}</li>
                    @endif
                    @if ($orderItem->academic_award_7)
                        <li style="margin-left: 8px;">Có giải cấp trường: {{$orderItem->academic_award_text_7}}</li>
                    @endif
                    @if ($orderItem->academic_award_8)
                        <li style="margin-left: 8px;">Có giải cấp câu lạc bộ: {{$orderItem->academic_award_text_8}}</li>
                    @endif
                    @if ($orderItem->academic_award_9)
                        <li style="margin-left: 8px;">Có giải trong nước: {{$orderItem->academic_award_text_9}}</li>
                    @endif
                    @if ($orderItem->academic_award_10)
                        <li style="margin-left: 8px;">Chưa có giải thưởng gì: {{$orderItem->academic_award_text_10}}</li>
                    @endif
                </td>academic_award_text_8
            </tr>
            <tr>
                <th>
                    Hoạt động ngoại khoá
                    Từ thiện, tình nguyện
                    Hoạt động chuyên ngành
                    Tài lẻ, năng khiếu
                    Sở thích, đam mê
                    Porfolio
                </th>
                <td>
                    @if ($orderItem->extra_activity_1)
                        <li style="margin-left: 8px;">Nhiều, đa dạng, có vai trò lãnh đạo, các tổ chức có uy tín hoặc nhiều tâm huyết: {{$orderItem->extra_activity_text_1}}</li>
                    @endif 
                    @if ($orderItem->extra_activity_2)
                        <li style="margin-left: 8px;">Nhiều, đa dạng, có vai trò lãnh đạo tuy nhiên các hoạt động theo mẫu: {{$orderItem->extra_activity_text_2}}</li>
                    @endif
                    @if ($orderItem->extra_activity_3)
                        <li style="margin-left: 8px;">Nhiều, đa dạng, nhưng còn yếu trong thể hiện vai trò lãnh đạo: {{$orderItem->extra_activity_text_3}}</li>
                    @endif
                    @if ($orderItem->extra_activity_4)
                        <li style="margin-left: 8px;">Ít, đơn điệu, cần xây dựng thêm nhiều: {{$orderItem->extra_activity_text_4}}</li>
                    @endif
                    @if ($orderItem->extra_activity_5)
                        <li style="margin-left: 8px;">Gần như chưa có hoạt động gì: {{$orderItem->extra_activity_text_5}}</li>
                    @endif
                  
                </td>
            </tr>
            <tr>
                <th>Ngành học dự kiến apply</th>
                <td>{{ $orderItem->intendedMajor ? $orderItem->intendedMajor->name : '' }}</td> 
            </tr>
            <tr>
                <th>Thời điểm apply</th>
                <td>
                    {{  date('d/m/Y', strtotime($orderItem->apply_time)) }} 
                </td>
            </tr>
            <tr>
                <th>Dự kiến thời gian nhập học</th>
                <td>
                    {{  date('d/m/Y', strtotime($orderItem->estimated_enrollment_time)) }} 
                </td>
            </tr>
            <tr>
                <th>Gói du học đã ký</th>
                <td>
                    @foreach ($orderItem->getTopSchool() ?? [] as $topSchoolItem)
                        <div>
                            <li style="margin-left: 8px;"> {{ $topSchoolItem['num_of_school_from'] ? $topSchoolItem['num_of_school_from'] . " trường" : '' }} {{ $topSchoolItem['top_school_from'] ? "TOP " . $topSchoolItem['top_school_from'] : '' }} {{ $topSchoolItem['country'] ? " tại " . $topSchoolItem['country'] : '' }}</li>
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Các thông tin lưu ý khác</th>
                <td></td>
            </tr>
        @endforeach
    </table>
    
    <table class="border-none">
        <tr>
            <th>PHÒNG TƯ VẤN</th>
            <th>PHÒNG KẾ TOÁN</th>
            <th>PHÒNG DU HỌC</th>
            <th>PHÒNG NGOẠI KHÓA</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>

</html>