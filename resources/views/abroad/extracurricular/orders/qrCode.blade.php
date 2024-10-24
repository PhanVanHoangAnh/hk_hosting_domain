@extends('layouts.main.popup')

@section('title')
    Mã thanh toán cho {{$order->student->name}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center ">
            <div class="col-md-6">
                <span class="vdh_bank_item">
                    <img class="img_qr_code img-fluid" src="https://img.vietqr.io/image/{{$paymentAccount->bank}}-{{$paymentAccount->account_number}}-print.jpg?amount={{$order->getRemainAmount()}}&addInfo= Mã  dịch vụ: {{$order->id}}&accountName={{$paymentAccount->account_name}}" alt="QR Code">
                </span>
            </div>
        </div>

       
    </div>


@endsection