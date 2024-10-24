@php
    $controlId = uniqid();
@endphp
<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($paymentAccounts->count())
    <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>
                       
                            
                           
                        <th list-action="sort" sort-by="bank"
                            sort-direction="{{ $sortColumn == 'bank' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="bank">
                            <span class="d-flex align-items-center ">
                                <span>
                                    Ngân hàng
                                </span>
                                <span
                                    class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'bank' ? '' : 'text-muted' }}">
                                    sort
                                </span>
                            </span>
                        </th>
                    
                        <th list-action="sort" sort-by="account_name"
                            sort-direction="{{ $sortColumn == 'account_name' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="created_at">
                            <span>
                                Tên tài khoản
                            </span>
                            <span
                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'account_name' ? '' : 'text-muted' }}">
                                sort
                            </span>
                        </th>
                        
                        <th list-action="sort" sort-by="account_number"
                            sort-direction="{{ $sortColumn == 'account_number' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="account_number">
                            <span>
                                Số tài khoản
                            </span>
                            <span
                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'account_number' ? '' : 'text-muted' }}">
                                sort
                            </span>
                        </th>
                        {{-- <th list-action="sort" sort-by="account_group_id"
                            sort-direction="{{ $sortColumn == 'account_group_id' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="account_group_id">
                            <span>
                                Nhóm tài khoản
                            </span>
                            <span
                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'account_group_id' ? '' : 'text-muted' }}">
                                sort
                            </span>
                        </th> --}}
                        <th  sort-by="description"
                            sort-direction="{{ $sortColumn == 'description' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="description">
                            <span>
                                Mô tả
                            </span>
                          
                        </th>
                        <th list-action="sort" sort-by="created_at"
                            sort-direction="{{ $sortColumn == 'created_at' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="created_at">
                            <span>
                                Ngày tạo
                            </span>
                            <span
                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'created_at' ? '' : 'text-muted' }}">
                                sort
                            </span>
                        </th>
                        <th  sort-by="status"
                            sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-100px fs-8" data-column="status">
                            <span>
                                Trạng thái
                            </span>
                            
                        </th>
                       
                        <th class="min-w-70px fs-8">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($paymentAccounts as $paymentAccount)
                        <tr list-control="item">
                            <td>
                                <div class="form-check form-check-sm form-check-custom">
                                    <input list-action="check-item" class="form-check-input" type="checkbox"
                                        value="1" />
                                </div>
                            </td>
                            
                            <td data-filter="mastercard" data-column="bank">
                                {{ $paymentAccount->bank}}
                            </td>
                            
                            <td data-filter="mastercard" data-column="account_name">
                                {{ $paymentAccount->account_name }}
                            </td>
                            
                            <td data-filter="mastercard" data-column="account_number">
                                {{ $paymentAccount->account_number }}
                            </td>
                            {{-- <td data-filter="mastercard" data-column="account_number">
                                {{ $paymentAccount->account_group->name ?? '--'}}
                            </td> --}}
                            <td data-filter="mastercard" data-column="description">
                                {{ $paymentAccount->description }}
                            </td>
                            <td data-filter="mastercard" data-column="created_at">
                                {{ $paymentAccount->created_at->format('d/m/Y ') }}
                            </td>
                            <td data-filter="mastercard" data-column="status">
                                @php
                                    $bgs = [
                                        App\Models\PaymentAccount::STATUS_PAUSE => 'secondary text-white',
                                    
                                        App\Models\PaymentAccount::STATUS_ACTIVE => 'success',

                                        App\Models\PaymentAccount::STATUS_DELETED => 'warning',
                                    ];
                                @endphp
                            
                                <span title=""
                                    class="badge bg-{{ $bgs[$paymentAccount->status] ?? 'info' }}"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                    data-bs-dismiss="click" data-bs-placement="right"
                                >
                                    {{ trans('messages.payment_accounts.status.' . $paymentAccount->status) }}
                                </span>
                            
                            </td>

                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="margin-left: 0px">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'edit'],
                                                [
                                                    'id' => $paymentAccount->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Chỉnh sửa</a>
                                    </div>
                                    <!--end::Menu item-->
                                     <!--begin::Menu item-->
                                     <div class="menu-item px-3">
                                        <a class="menu-link px-3"   row-action="payment-list"
                                            href="{{ action(
                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'paymentListPopup'],
                                                [
                                                    'id' => $paymentAccount->id,
                                                ],
                                            ) }}">Lịch sử thu/chi</a>
                                    </div>
                                    
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 d-none" >
                                        <a row-action="delete"
                                            href="{{ action(
                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'destroy'],
                                                [
                                                    'id' => $paymentAccount->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xóa</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    @if ($paymentAccount->status == App\Models\PaymentAccount::STATUS_ACTIVE)
                                        <div class="menu-item px-3">
                                            <a row-action="request-pause"
                                                href="{{ action([App\Http\Controllers\Accounting\PaymentAccountController::class, 'pausePaymentAccount'], [
                                                    'id' => $paymentAccount->id,
                                                ]) }}" class="menu-link px-3"
                                            >Ngưng tài khoản</a>
                                        </div>
                                    @endif
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
            <!--end::Card body-->
        </div>
        <div class="mt-5">
            {{ $paymentAccounts->links() }}
        </div>
        <!--end::Card-->
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
                                <rect x="31.7" y="44.7" width="33.7" height="34.51"
                                    style="fill:#dbdbdb" />
                                <rect x="73.6" y="44.7" width="33.7" height="34.51"
                                    style="fill:#dbdbdb" />
                                <rect x="115.5" y="44.7" width="33.7" height="34.51"
                                    style="fill:#dbdbdb" />
                                <rect x="31.7" y="84.1" width="33.7" height="34.51"
                                    style="fill:#dbdbdb" />
                                <rect x="73.6" y="84.1" width="33.7" height="34.51"
                                    style="fill:#dbdbdb" />
                                <rect x="115.5" y="84.1" width="33.7" height="34.51"
                                    style="fill:#dbdbdb" />
                                <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                    style="fill:#dbdbdb" />
                                <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                    style="fill:#f5f5f5" />
                                <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                <rect x="32.1" y="29.8" width="116.6" height="3.85"
                                    style="fill:#dbdbdb" />
                                <rect x="32.1" y="36.7" width="116.6" height="3.85"
                                    style="fill:#dbdbdb" />
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
                Không có tài khoản!
            </p>
            <p class="text-center">
                <a class="btn btn-outline btn-outline-default" row-action="request-add-payment-account" id="addPaymentAccountSearch-{{ $controlId }}">
                    <i class="ki-duotone ki-abstract-10">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Thêm tài khoản mới
                </a>
            </p>
        </div>
    @endif
</div>


<script>
    $(() => {

            //Pause
            Pause.init();
            if (document.getElementById('addPaymentAccountSearch-{{ $controlId }}') !== null) {
                AddPaymentAccount.init();
            }
            
        
    });
    var AddPaymentAccount = function() {
        return {
            init: function() {
                btnSubmit = document.getElementById('addPaymentAccountSearch-{{ $controlId }}').addEventListener('click', function() {
                    CreatePaymentAccountPopup.getPopup().load();
                    
                })
            }
        }
    }();

   var Pause = function() {
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
            })
        }

        return {
            init: function() {
                list = AccountsList.getList();
                links = list.container.querySelectorAll('[row-action="request-pause"]');

                //events
                links.forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        let url = link.getAttribute('href');

                        ASTool.confirm({
                            message: 'Bạn muốn ngưng tài khoản này?',
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