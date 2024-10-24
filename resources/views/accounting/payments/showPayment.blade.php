@if(!isset($exportPdf) || !$exportPdf)
    @extends('layouts.main.popup')
        @section('title')
            Thông tin phiếu
        @endsection
@endif
@section('content')
    
<style type="text/css">  
    @media print {
        body {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 100%;   
        }
        div {
            display: block;
        }
        .modal-header{
            display: none
        }
        .fv-row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: nowrap;
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));
        }

        .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x)* .5);
            padding-left: calc(var(--bs-gutter-x)* .5); 
        }

        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: nowrap; 
            margin-right: calc(-.5* var(--bs-gutter-x));
            margin-left: calc(-.5* var(--bs-gutter-x));
        }

        @media (min-width: 1200px) {
            .col-xl-12 {
                flex: 0 0 auto;
                width: 100%;
            }

            .col-xl-7 {
                flex: 0 0 auto;
                width: 58.33333333%;
            }

            .col-xl-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-xl-5 {
                flex: 0 0 auto;
                width: 41.66666667%;
            }

            .col-xl-4 {
                flex: 0 0 auto;
                width: 33.33333333%;
            }
        }


        @media (min-width: 992px) {
            .col-lg-12 {
                flex: 0 0 auto;
                width: 100%;
            }

            .col-lg-7 {
                flex: 0 0 auto;
                width: 58.33333333%;
            }

            .col-lg-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-lg-5 {
                flex: 0 0 auto;
                width: 41.66666667%;
            }

            .col-lg-4 {
                flex: 0 0 auto;
                width: 33.33333333%;
            }
        }

        @media (min-width: 768px) {
            .col-md-12 {
                flex: 0 0 auto;
                width: 100%;
            }

            .col-md-7 {
                flex: 0 0 auto;
                width: 58.33333333%;
            }

            .col-md-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-md-5 {
                flex: 0 0 auto;
                width: 41.66666667%;
            }

            .col-md-4 {
                flex: 0 0 auto;
                width: 33.33333333%;
            }
        }

        @media (min-width: 576px) {
            .col-sm-12 {
                flex: 0 0 auto;
                width: 100%;
            }

            .col-sm-7 {
                flex: 0 0 auto;
                width: 58.33333333%;
            }

            .col-sm-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-sm-5 {
                flex: 0 0 auto;
                width: 41.66666667%;
            }

            .col-sm-4 {
                flex: 0 0 auto;
                width: 33.33333333%;
            }
        }

        .col-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        .col-7 {
            flex: 0 0 auto;
            width: 58.33333333%;
        }

        .col-6 {
            flex: 0 0 auto;
            width: 50%;
        }

        .col-5 {
            flex: 0 0 auto;
            width: 41.66666667%;
        }

        .col-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }


        .form-control {
            display: block;
            width: 100%;
            color: var(--bs-gray-700);
            background-color: var(--bs-body-bg);
            background-clip: padding-box;
            border: 1px solid var(--bs-gray-300); 
            border-radius: 0.475rem; 
        }

        .text-info {
            color: #253f8e !important;
            --bs-text-opacity: 1;
        }
        .text-nowrap {
            white-space: nowrap !important;
        } 

        h2 {
            display: block; 
            margin-block-start: 0.83em;
            margin-block-end: 0.83em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;

        } 

        .justify-content-between {
            justify-content: space-between !important;
        }

        .d-flex {
            display: flex !important;
        }

        .border-bottom {
                border-bottom: 1px solid #dee2e6;
                margin-bottom: 10px;
                
        }

        .align-items-center {
            align-items: center !important;
        }

        .fw-bold {
            font-weight: 600 !important;
            display: inline-block;
        }

        .fw-semibold {
            font-weight: 500 !important;
            display: inline-block;
        }

        label {
            display: inline-block;
        }
    }
</style>
<div id="UpdateReceiptForm">
    @csrf
    <!--begin::Scroll-->
    <div class="pe-7  pb-10 px-lg-17 mb-20" >
        <div class="row">
            <div class="col-md-6">
                
            </div>
            <div class="col-md-6">
                @if(!isset($exportPdf) || !$exportPdf)
                    <div class="modal-body flex-end px-0 d-flex justify-content-end">
                    
                        <a row-action="download" data-action="under-construction" class="btn btn-light"
                        href="{{ action(
                                        [App\Http\Controllers\Accounting\PaymentRecordController::class, 'exportPDF'],
                                        [
                                            'id' => $paymentRecord->id,
                                        ],
                                    ) }}">
                            <span class="indicator-label fw-bold">Xuất PDF</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="row" id="export" >
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="form-control">
                    <h2 class="text-info text-nowrap mt-5 mb-5">
                        Thông tin chung    <span title="{{ $order->rejected_reason }}" class="badge bg-warning"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            
                            {{ trans('messages.payments.status.' . $paymentRecord->type) }}
                        </span>
                        
                    </h2>
                    
                    <div class="row d-flex justify-content-between" >
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">                                
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Ngày:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $paymentRecord->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Số hợp đồng:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $order->code }}</div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Phương thức thanh toán:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $paymentRecord->method }}</div>
                                </div>
                            </div>
                            @if ($paymentRecord->method === \App\Models\PaymentRecord::METHOD_BANK_TRANSFER)
                            
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Ngân hàng:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $paymentRecord->paymentAccount->bank }}</div>
                                    </div>
                                </div>
                                                            
                                
                            
                            @endif

                            
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Nhân viên phụ trách:</span>
                                    </label>
                                </div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <div>
                                        {{ $paymentRecord->account ? $paymentRecord->account->name : '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Số tiền:</span>
                                    </label>
                                </div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <div>
                                        {!! number_format($paymentRecord->amount) !!}đ
                                    </div>
                                </div>
                            </div>
                            @if ($paymentRecord->method === \App\Models\PaymentRecord::METHOD_BANK_TRANSFER)
                            
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Tài khoản:</span>
                                        </label>
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                        <div>{{ $paymentRecord->paymentAccount->account_name }}</div>
                                    </div>
                                </div>  
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Số tài khoản:</span>
                                        </label>
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                        <div>{{ $paymentRecord->paymentAccount->account_number }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                    </div>

                    <h2 class="text-info text-nowrap mt-10 mb-3">
                        Học viên
                    </h2>

                    <div class="row d-flex justify-content-between mt-3">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Họ và tên:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $order->contacts->name }}</div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Ngày tháng năm sinh:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div> 
                                        {{ $order->contacts->birthday ? date('d/m/Y', strtotime($order->contacts->birthday)) : '--' }}
                                        </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Số điện thoại:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $order->contacts->phone }}</div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Email:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $order->contacts->email }}</div>
                                </div>
                            </div>

                            @if ($order->contact_id != $order->student_id)
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Quan hệ với học viên:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->getRelationshipName() }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h2 class="text-info text-nowrap mt-10 mb-3">
                        Ghi chú
                    </h2>
                    <div class="text-left mb-10">
                        <label class="fs-4">
                            {{ !empty($paymentRecord->description) ? $paymentRecord->description : 'Chưa có ghi chú' }}

                        </label>
                    </div>

                    

                    
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
