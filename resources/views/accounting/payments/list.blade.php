<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($payments->count())
        <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>
                        {{-- @if (in_array('id', $columns) || in_array('all', $columns))
                            <th sort-by="id"
                                sort-direction="{{ $sortColumn == 'id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8 d-none" data-column="id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số phiếu thu
                                    </span>
                                    
                                </span>
                            </th>
                        @endif --}}
                        @if (in_array('order_id', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="order_id"
                                sort-direction="{{ $sortColumn == 'order_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="order_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã hợp đồng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'code' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('contact_id', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contact_id"
                                sort-direction="{{ $sortColumn == 'contact_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="contact_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã khách hàng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contact_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('contact_name', $columns) || in_array('all', $columns))
                            <th  list-action="sort" sort-by="contacts.name"
                                sort-direction="{{ $sortColumn == 'contacts.name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="contact_name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Khách hàng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('industry', $columns) || in_array('all', $columns))
                            <th  sort-by="industry"
                                sort-direction="{{ $sortColumn == 'industry' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="industry">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Dịch vụ
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        @if (in_array('type', $columns) || in_array('all', $columns))
                            <th sort-by="type"
                                sort-direction="{{ $sortColumn == 'type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Loại
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        @if (in_array('amount', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="amount"
                                sort-direction="{{ $sortColumn == 'amount' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="amount">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số tiền
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'amount' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('description', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="description"
                                sort-direction="{{ $sortColumn == 'description' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="description">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ghi chú
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'description' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('account_id', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="account_id"
                                sort-direction="{{ $sortColumn == 'account_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="account_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Người tạo
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'account_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('payment_date', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="payment_date"
                                sort-direction="{{ $sortColumn == 'payment_date' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="payment_date">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày thanh toán
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'created_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('updated_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="updated_at"
                                sort-direction="{{ $sortColumn == 'updated_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="updated_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày cập nhật
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'updated_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('created_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="created_at"
                                sort-direction="{{ $sortColumn == 'created_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left fs-8" data-column="created_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày tạo
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'created_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        <th class="min-w-125px ">Thao tác</th>
                    </tr>
                </thead>


                <tbody class="text-gray-600">
                    @foreach ($payments as $payment)
                        <tr list-control="item">
                            <td class="text-center ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $payment->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            @if (in_array('id', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="order_id">
                                        {{ $payment->id }}
                                </td>
                            @endif
                            @if (in_array('order_id', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="order_id">
                                  
                                    {{ optional($payment->orders)->code ?: '--' }}

                                    
                                </td>
                            @endif
                            @if (in_array('industry', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="industry"> 
                                        
                                        {{ optional($payment->orders)->industry ?: '--' }}
                                </td>
                            @endif
                            @if (in_array('type', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="type">
                                    @php
                                        $bgs = [
                                            App\Models\PaymentRecord::TYPE_RECEIVED => 'secondary',
                                            App\Models\PaymentRecord::TYPE_REFUND => 'warning text-white',
                                        ];
                                    @endphp
                                    
                                        <span class="badge bg-{{ $bgs[$payment->type] ?? 'info text-white' }}"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                            data-bs-placement="right">
                                            
                                            {{ trans('messages.payments.status.' . $payment->type) }}

                                        </span>
                                        
                                    
                                </td>
                            @endif
                            @if (in_array('contact_id', $columns) || in_array('all', $columns))
                            <td data-column="contact_id" class="text-left mb-1 text-nowrap">
                                {{ App\Models\PaymentRecord::find($payment->id)->contact->code }}


                            </td>
                            @endif
                            @if (in_array('contact_name', $columns) || in_array('all', $columns))
                                <td data-column="contact_name" class="text-left mb-1 text-nowrap">
                                    {{ App\Models\PaymentRecord::find($payment->id)->contact->name }}
                                </td>
                            @endif



                            @if (in_array('amount', $columns) || in_array('all', $columns))
                                <td class="text-left" data-filter="mastercard" data-column="amount">

                                    {!! number_format($payment->amount) !!}đ
                                </td>
                            @endif

                            @if (in_array('description', $columns) || in_array('all', $columns))
                                <td class="text-left" data-filter="mastercard" data-column="description">
                                    {!! $payment->description !!}
                                </td>
                            @endif

                            @if (in_array('account_id', $columns) || in_array('all', $columns))
                                <td class="text-left" data-filter="mastercard" data-column="account_id">
                                    {{ $payment->account ? $payment->account->name : '--' }}
                                </td>
                            @endif

                            @if (in_array('payment_date', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="payment_date">
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                                   
                                </td>
                            @endif

                            @if (in_array('updated_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="updated_at">
                                    {{ $payment->updated_at->format('d/m/Y ') }}
                                </td>
                            @endif

                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="created_at">
                                    {{ $payment->created_at->format('d/m/Y ') }}
                                </td>
                            @endif


                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    style="margin-left: 0px">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    @if ($payment->status == App\Models\PaymentRecord::STATUS_PAID )
                                       
                                        <div class="menu-item px-3 ">
                                            <a row-action="download"
                                                href="{{ action(
                                                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'exportPDF'],
                                                    [
                                                        'id' => $payment->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Xuất PDF</a>
                                        </div>
                                    @endif
                                    <div class="menu-item px-3 ">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'showPayment'],
                                                [
                                                    'id' => $payment->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xem chi tiết</a>
                                    </div>
                                    @if ($payment->status == App\Models\PaymentRecord::STATUS_PENDING )
                                        
                                        <div class="menu-item px-3 ">
                                            <a row-action="approval"
                                                href="{{ action(
                                                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'approval'],
                                                    [
                                                        'id' => $payment->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Duyệt phiếu thu</a>
                                        </div>
                                    @endif
                                    @if ($payment->status == App\Models\PaymentRecord::STATUS_PENDING )
                                        
                                        <div class="menu-item px-3 ">
                                            <a row-action="reject"
                                                href="{{ action(
                                                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'reject'],
                                                    [
                                                        'id' => $payment->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Từ chối xác nhận</a>
                                        </div>
                                    @endif
                                    <div class="menu-item px-3">
                                        <a row-action="delete"
                                            href="{{ action(
                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'destroy'],
                                                [
                                                    'id' => $payment->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xóa</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Table-->
        <div class="mt-5">
            {{ $payments->links() }}
        </div>
    @else
        <div class="py-15">
            <div class="text-center mb-7">
                <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                    <g style="isolation:isolate">
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="layer1">
                                <path
                                    d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                    style="fill:#cdcdcd" />
                                <path
                                    d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                    style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                    style="fill:#f5f5f5" />
                                <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                    style="fill:#dbdbdb" />
                                <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                    style="fill:#f5f5f5" />
                                <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                    transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                <path
                                    d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                    style="fill:#f8a11f" />
                                <path
                                    d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                    style="fill:#253f8e" />
                                <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                    style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                <path
                                    d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                    style="fill:#dbdbdb" />
                                <path
                                    d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                    style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <p class="fs-4 text-center mb-5">
                Không có phiếu thu nào!
            </p>
            <p class="text-center">
                <a href="javascript:;" data-list-action="create-receipt" class="btn btn-outline btn-outline-default">
                    <span class="material-symbols-rounded me-2">
                        add
                    </span>
                    Thêm mới
                </a>
            </p>


        </div>
    @endif
</div>

<script>
     $(() => {
        if (document.querySelector('[data-list-action="create-receipt"]') !== null) {
            AddReceipt.init();

        }
        Approval.init();
        Reject.init();
    });

    var AddReceipt = function() {
        return {
            init: function() {
                var btnSubmit = document.querySelector('[data-list-action="create-receipt"]');

                if (btnSubmit) {
                    btnSubmit.addEventListener('click', function(e) {
                        e.preventDefault(); // Prevent the default link behavior

                        CreateReceiptPopup.updateUrl(
                            "{{ action('\App\Http\Controllers\Accounting\PaymentRecordController@create') }}"
                        );
                    });
                }
            }
        };
    }();
    var Approval = function() {
        var list;
        var links;

        var request = function(url) {
            ASTool.addPageLoadingEffect();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                }
            }).done((response) => {
                ASTool.alert({
                    message: response.message,
                    ok: function() {
                        list.load();
                    }
                });

                list.load();
            }).fail(function(response) {
                ASTool.alert({
                    message: response.responseText,
                    ok: function() {
                        list.load();
                    }
                });
            }).always(function() {
                ASTool.removePageLoadingEffect();
            });
        }

        return {
            init: function() {
                list = ReceiptList.getList();
                links = list.container.querySelectorAll('[row-action="approval"]');

                // events
                links.forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        let url = link.getAttribute('href');

                        ASTool.confirm({
                            message: 'Bạn có chắc chắn duyệt phiếu thu này không?',
                            ok: function() {
                                request(url);
                            }
                        });
                    });
                });
            },
        };
    }();
    var Reject = function() {
        var list;
        var links;

        var request = function(url) {
            ASTool.addPageLoadingEffect();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                }
            }).done((response) => {
                ASTool.alert({
                    message: response.message,
                    ok: function() {
                        list.load();
                    }
                });

                list.load();
            }).fail(function(response) {
                ASTool.alert({
                    message: response.responseText,
                    ok: function() {
                        list.load();
                    }
                });
            }).always(function() {
                ASTool.removePageLoadingEffect();
            });
        }

        return {
            init: function() {
                list = ReceiptList.getList();
                links = list.container.querySelectorAll('[row-action="reject"]');

                // events
                links.forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        let url = link.getAttribute('href');

                        ASTool.confirm({
                            message: 'Bạn có chắc chắn từ chối phiếu thu này không?',
                            ok: function() {
                                request(url);
                            }
                        });
                    });
                });
            },
        };
    }();
    
</script>
