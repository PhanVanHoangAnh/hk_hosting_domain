@extends('layouts.main.popup')

@section('title')
{{ !isset($orderItem) ? 'Thêm: Dịch vụ ngoại khóa' : 'Sửa: Dịch vụ ngoại khóa' }}
@endsection

@php
    $createExtraOrderItemPopupUniqid = 'createExtraOrderItemPopupUniqid_' . uniqid();
@endphp

@section('content')
<form id="{{ $createExtraOrderItemPopupUniqid }}" method="POST" tabindex="-1">
    @csrf
    <input class="type-input" type="hidden" name="type" value="{{ App\Models\Order::TYPE_EXTRACURRICULAR }}">

    <div class="scroll-y px-7 py-10 px-lg-17">
        <div class="row">
            @php
                $extraDiscountPercentManagerUniqId = 'S' . uniqid();
            @endphp

            <div class="mb-2">
                Giảm giá: <span class="fw-bold" data-form="discountPercent_{{ $extraDiscountPercentManagerUniqId }}"></span> %
                <input type="hidden" name="discount_percent" value="">
                <script>
                    var discountPercent = 0;
                    discountPercent = extraPriceManager.getDiscountPercentInputValue();
                    
                    document.querySelector('[data-form="discountPercent_{{ $extraDiscountPercentManagerUniqId }}"]').innerText = discountPercent;
                    document.querySelector('[name="discount_percent"]').value = discountPercent;
                </script>
            </div>
        </div>

        {{-- CONTENT --}}
        @include('sales.orders._extracurricularManager', [
            'orderItem' => isset($orderItem) ? $orderItem : null
        ])

        @php
            $revenueFormUniqId = 'revenue_form_uniq_id_' . uniqid();
        @endphp

        {{-- Revenue sharing FORM --}}
        <div class="row" data-form-include="{{ $revenueFormUniqId }}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-8 mt-8">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xs-12 mb-2">
                        <input type="checkbox" name="is_share" {{ isset($orderItem) && $orderItem->is_share ? 'checked' : '' }}>
                        <label class="fs-6 fw-semibold mb-2">Chia doanh thu</label>
                    </div>
                </div>

                <div data-content="body">
                    {{-- Load revenue form here --}}
                </div>
            </div>
        </div>

        {{-- Revenue sharing JS --}}
        <script>
            $(() => {
                new RevenueToolForm({
                    container: () => {
                        return $('[data-form-include="{{ $revenueFormUniqId }}"]');
                    }
                })
            })

            var RevenueToolForm = class {
                constructor(options) {
                    this.container = options.container;
                    
                    this.toggle();
                    this.load();
                    this.events();
                }

                getCheckBox() {
                    return this.container().find('[name="is_share"]');
                }

                getBody() {
                    return this.container().find('[data-content="body"]');
                }

                load() {
                    const data = {
                        _token: "{{ csrf_token() }}",
                        parentId: "{{ $createExtraOrderItemPopupUniqid }}",
                        defaultSaleId: {{ $defaultSaleId }},
                        totalPrice: "{{ isset($orderItem) ? $orderItem->price : '' }}",
                        revenueDistributions: "{{ isset($revenueData) ? $revenueData : json_encode( isset($orderItem) && $orderItem->revenueDistributions->count() > 0 ? $orderItem->revenueDistributions : \App\Helpers\RevenueDistribution::getRevenueDataWithDefault($defaultSaleId) ) }}",
                    }

                    $.ajax({
                        url: "{!! action([App\Http\Controllers\SaleRevenueController::class, 'getRevenueForm']) !!}",
                        method: "POST",
                        data: data
                    }).done(res => {
                        this.container().find('[data-content="body"]').html(res);
                        initJs(this.container().find('[data-content="body"]')[0]);
                    }).fail(res => {
                        throw {
                            info: "custom error alert",
                            file: "sales/orders/createExtraItem.blade.php",
                            message: "ajax fail, cannot get revenue form from server!",
                            originError: {
                                file: res.responseJSON.file,
                                line: res.responseJSON.line,
                                message: res.responseJSON.message,
                            }
                        }
                    })
                }

                toggle() {
                    const _this = this;

                    if ($(_this.getCheckBox()).is(':checked')) {
                        _this.getBody().show();
                    } else {
                        _this.getBody().hide();
                    }
                }

                events() {
                    const _this = this;

                    this.getCheckBox().change(function() {
                        _this.toggle();
                    });
                }
            }
        </script>

        <x-input-error :messages="$errors->get('custom_validate_revenue_distribution')" class="mt-2 text-center"/>
        
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="save_{{ $createExtraOrderItemPopupUniqid }}" class="btn btn-primary">
                <span class="indicator-label">Lưu thông tin dịch vụ</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </div>
</form>

<script>
    var createExtraItemFrom;
    var priceInlineEdit;
    
    $(() => {
        createExtraItemFrom = new CreateExtraItemFrom({
            container: document.querySelector('#{{ $createExtraOrderItemPopupUniqid }}')
        })
    })

    var CreateExtraItemFrom = class {
        constructor(options) {
            this.container = options.container;
            this.inputImask;

            this.init();
            this.events();
        }

        getPriceInput() {
            return this.container.querySelector('[name="price"]');
        }

        init() {
            this.createExtraItemForm = new OrderForm({
                form: $("#{{ $createExtraOrderItemPopupUniqid }}"),
                submitBtnId: 'save_{{ $createExtraOrderItemPopupUniqid }}',
                popup: AddExtraItemPopup.getPopup(),
                orderItemId: "{{ !isset($orderItem) ? null : $orderItemId }}",
            }); 
        }

        events() {
            const _this = this;
        
            $(_this.getPriceInput()).on('change', function(e) {
                e.preventDefault() 
            })
        }
    }
</script>
@endsection