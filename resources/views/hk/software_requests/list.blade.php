<!--begin::Card body-->

<div class="card-body pt-0 mt-5">
    @if ($requests->count())
        <div class="table-responsive table-head-sticky freeze-column" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom">
                                <input list-action="check-all" class="form-check-input" email="checkbox" />
                            </div>
                        </th>

                        @if (in_array('name', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="name"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('email', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="email"
                                sort-direction="{{ $sortColumn == 'email' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="email">
                                <span class="d-flex align-items-center ">
                                    <span>
                                        Email
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'email' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('phone', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="phone" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'phone' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left bg-info" data-column="phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'phone' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('company_name', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="company_name"
                                sort-direction="{{ $sortColumn == 'company_name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="company_name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên công ty
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'company_name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        
                        @if (in_array('company_size', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="company_size"
                                sort-direction="{{ $sortColumn == 'company_size' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="company_size">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quy mô công ty
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'company_size' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('company_branch', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="company_branch"
                                sort-direction="{{ $sortColumn == 'company_branch' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="company_branch">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng chi nhánh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'company_branch' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('line_of_business', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="line_of_business"
                                sort-direction="{{ $sortColumn == 'line_of_business' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="line_of_business">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngành nghề hoạt động
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'line_of_business' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('note', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="note"
                                sort-direction="{{ $sortColumn == 'note' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="note">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nội dung yêu cầu
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'note' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('account', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="account" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'account' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left bg-info" data-column="account">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nhân viên tư vấn
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'account' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('status', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="status"
                                sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trạng thái
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'status' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        
                        <th class="fs-8 min-w-100px" width="1%">Thao tác</th>

                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($requests as $request)
                        <tr list-control="item">
                            <td class="ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input list-action="check-item" name="checkbox-delete" class="form-check-input"
                                        type="checkbox" value="{{ $request->id }}" />
                                </div>
                            </td>
                            @if (in_array('name', $columns) || in_array('all', $columns))
                                <td data-column="name" class="text-left" data-filter="mastercard" data-control="freeze-column" >
                                    {{ $request->contact->name }}
                                </td>
                            @endif
                          
                            @if (in_array('phone', $columns) || in_array('all', $columns))
                                <td data-column="phone" class="text-left text-nowrap" data-filter="mastercard">
                                    {{ $request->contact->phone }}
                                </td>
                            @endif

                            @if (in_array('email', $columns) || in_array('all', $columns))
                                <td data-column="email" class="text-left text-nowrap" data-filter="mastercard">
                                    {{ $request->contact->email }}
                                </td>
                            @endif
                            @if (in_array('company_name', $columns) || in_array('all', $columns))
                                <td data-column="company_name" class="text-left" data-filter="mastercard"> 
                                    {{ $request->company_name }}
                                    
                                </td>
                            @endif
                            @if (in_array('company_size', $columns) || in_array('all', $columns))
                                <td data-column="company_size" class="text-left" data-filter="mastercard"> 
                                    {{ $request->company_size }}
                                    
                                </td>
                            @endif
                            @if (in_array('company_branch', $columns) || in_array('all', $columns))
                                <td data-column="company_branch" class="text-left" data-filter="mastercard"> 
                                    {{ $request->company_branch }}
                                    
                                </td>
                            @endif
                            @if (in_array('line_of_business', $columns) || in_array('all', $columns))
                                <td data-column="line_of_business" class="text-left" data-filter="mastercard"> 
                                    {{ $request->line_of_business }}
                                    
                                </td>
                            @endif
                            @if (in_array('note', $columns) || in_array('all', $columns))
                                <td data-column="note" class="text-left" data-filter="mastercard"> 
                                    {{ $request->note }}
                                    
                                </td>
                            @endif
                            @if (in_array('account', $columns) || in_array('all', $columns))
                                <td data-column="account" class="text-left text-nowrap" data-filter="mastercard">
                                    {{ $request->account ? $request->account->name : '' }}
                                </td>
                            @endif
                            @if (in_array('status', $columns) || in_array('all', $columns))
                            <td data-column="status" class="text-left" data-filter="mastercard"> 
                                {{  trans('messages.hk.software_requests.status.' . $request->status) ?? 'None' }}
                                
                            </td>
                           
                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    style="margin-left: 0px">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a row-action="updateStatusAbroadApplication"
                                            href="{{ action(
                                                [App\Http\Controllers\Hk\SoftwareRequestController::class, 'assignedDetail'],
                                                [
                                                    'id' => $request->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xem chi tiết</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a 
                                            href="{{ action(
                                                [App\Http\Controllers\Hk\SoftwareRequestController::class, 'show'],
                                                [
                                                    'id' => $request->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xem và cập nhật</a>
                                    </div>
                                    @if (!$request->account_id)
                                        <div class="menu-item px-3 text-start">
                                            <a row-action="assign-acount"
                                                href="{{ action(
                                                    [App\Http\Controllers\Hk\SoftwareRequestController::class, 'assignAccount'],
                                                    [
                                                        'id' => $request->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Bàn giao nhân viên</a>
                                        </div>
                                    @endif
                                    @if ($request->account_id)
                                        <div class="menu-item px-3 text-start">
                                            <a row-action="assign-acount"
                                                href="{{ action(
                                                    [App\Http\Controllers\Hk\SoftwareRequestController::class, 'updateStatus'],
                                                    [
                                                        'id' => $request->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Cập nhật trạng thái yêu cầu</a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>

        <div class="mt-5">
            {{ $requests->links() }}
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
                Chưa có thông tin yêu cầu!
            </p>
           
        </div>
    @endif
</div>
<!--end::Card body-->
</div>
<script>
   $(() => {
            HorizonScrollFix.init();

            UpdateNotelogPopup.init();
        });

        var HorizonScrollFix = function() {
          

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="assign-acount"]');
            }

            return {
                init: function() {
                    getUpdateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdateNotelogPopup.updateUrl(btnUrl);
                        });
                    });
                }
            }
        }();

        var UpdateNotelogPopup = (function() {
            var updatePopup;

            return {
                init: function() {
                    updatePopup = new Popup();
                },
                updateUrl: function(newUrl) {
                    updatePopup.url = newUrl;
                    updatePopup.load();
                },
                getUpdatePopup: function() {
                    return updatePopup;
                }
            };
        })();
</script>
