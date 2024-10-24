<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
      .column {
        width: 50%;
        float: left;
        padding: 0 5px;
        box-sizing: border-box;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        border-bottom: 1px solid #666;
        padding-top: 10px; /* Adjust padding as needed */
    }
    
    .text-info {
        color: #253f8e !important;
        --bs-text-opacity: 1;
    }

    .fw-bold {
        font-weight: bold;
    }

    table{
        font-size: 13px;
    }
    .row{
        padding-inline:10px;
    }
    .section2 {
        clear: both;
        margin-top: 20px;
    }
    


    </style>
    </head>
    <body>
        <div class="row" id="export" > 
            <div class="form-control">
                <h2 class="text-info text-nowrap mt-5 mb-5">
                    Thông tin chung    
                    </span>
                    
                </h2>
                
                <div class="row">
                    <div class="column">
                        <table class="custom-table">
                            <tr>
                                <td ><span class="fw-bold">Ngày:</span></td>
                                <td>{{ $paymentRecord->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold" >Số hợp đồng:</span></td>
                                <td >{{ $order->code }}</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold" >Phương thức thanh toán:</span></td>
                                <td >{{ $paymentRecord->method }}</td>
                            </tr>
                            @if ($paymentRecord->method === \App\Models\PaymentRecord::METHOD_BANK_TRANSFER)
                            <tr>
                                <td><span class="fw-bold" >Tài khoản:</span></td>
                                <td >{{ $paymentRecord->paymentAccount->account_name }}</td>
                        
                            
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="column">
                        <table class="custom-table">
                            <tr>
                                <td><span class="fw-bold" >Nhân viên phu trách:</span></td>
                                <td >{{ $paymentRecord->account ? $paymentRecord->account->name : '--' }}</td>
                            </tr>
                    
                            <tr>
                                <td><span class="fw-bold" >Số tiền:</span></td>
                                <td >{!! number_format($paymentRecord->amount) !!}đ</td>
                            </tr>
                            <tr> 
                                @if ($paymentRecord->method === \App\Models\PaymentRecord::METHOD_BANK_TRANSFER) 
                                    <td><span class="fw-bold" >Ngân hàng:</span></td>
                                    <td >{{ $paymentRecord->paymentAccount->bank }}</td> 
                                @endif
                            </tr>
                            <tr> 
                                    @if ($paymentRecord->method === \App\Models\PaymentRecord::METHOD_BANK_TRANSFER)
                                    <td><span class="fw-bold" >Số tài khoản:</span></td>
                                    <td >{{ $paymentRecord->paymentAccount->account_number }}</td>
                                    @endif
                            </tr>
                        </table>
                    </div>
                
                </div>
            
                <div class="section2"> 
                    <div class="column">
                        <h2 class="text-info text-nowrap mt-10 mb-3">
                            Học viên
                        </h2>
                        <table class="custom-table">
                            <tr>
                                <td><span class="fw-bold">Họ và tên:</span></td>
                                <td>{{ $order->contacts->name }}</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold">Ngày tháng năm sinh:</span></td>
                                <td>{{ $order->contacts->birthday ? date('d/m/Y', strtotime($order->contacts->birthday)) : '--' }}</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold">Số điện thoại:</span></td>
                                <td>{{ $order->contacts->phone }}</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold">Email:</span></td>
                                <td>{{ $order->contacts->email }}</td> 
                            </tr> 
                        </table> 
                    </div>
                </div>
                 
                <div class="section2"> 
                    <h2 class="text-info text-nowrap mt-10 mb-3">
                        Ghi chú
                    </h2> 
                    
                    <div class="text-left mb-10">
                        <label class="fs-4" style="font-size: 14px;">
                            {{ !empty($paymentRecord->description) ? $paymentRecord->description : 'Chưa có ghi chú' }}
                        </label>
                    </div>
                </div>


                
            </div>
        </div>
    
    
    </body>
</html>
