@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
   Hoạt động ngoại khoá
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp
@section('content')
    <!--begin::Card body-->



    <form id="popupCreateAbroadUniqId" tabindex="-1">
        @csrf
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                 <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hạng mục
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                         Tên hoạt động ngoại khoá
                                    </span>
                                </span>
                            </th>
                            
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm bắt đầu
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm kết thúc
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Link tài liệu chương trình
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa điểm
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Vai trò
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Link file
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">

                        @foreach (\App\Models\ExtracurricularActivity::getAllCategory() as $category)
                            @php
                                $categoryActivitys = $extracurricularActivitys->where('category', $category);
                            @endphp
                            <!-- Kiểm tra nếu có dữ liệu cho hạng mục -->
                            @if ($categoryActivitys->isNotEmpty())
                                <!-- Dòng đầu tiên của mỗi loại trường -->
                                <tr>
                                    <td rowspan="{{ $categoryActivitys->count() + 1 }}" class="text-left mb-1 text-nowrap">
                                        {{ trans('messages.extracurricular_activity.category.' . $category) }}
                                    </td>
                                </tr>
                                <!-- Lặp qua danh sách các trường trong mỗi loại -->
                                @foreach ($categoryActivitys as $extracurricularActivity)
                                    <tr list-control="item">
                                        <!-- Các cột thông tin -->
                                        <td class="text-left mb-1 text-nowrap">{{ $extracurricularActivity->name }}</td>
                                        <td class="text-left mb-1 text-nowrap">
                                            {{ $extracurricularActivity->start_at ? date('d/m/Y', strtotime($extracurricularActivity->start_at)) : '' }}
                                        </td>
                                        <td class="text-left mb-1 text-nowrap">
                                            {{ $extracurricularActivity->end_at ? date('d/m/Y', strtotime($extracurricularActivity->end_at)) : '' }}
                                        </td>
                                        <td class="text-left mb-1 text-nowrap">{{ $extracurricularActivity->link_document }}</td>
                                        <td class="text-left mb-1 text-nowrap">{{ $extracurricularActivity->address }}</td>
                                        <td class="text-left mb-1 text-nowrap">{{ trans('messages.extracurricular_activity.role.' . $extracurricularActivity->role) }}</td>
                                        <td class="text-left mb-1 text-nowrap">{{ $extracurricularActivity->link_file }}</td>
                                        <!-- Cột thao tác -->
                                        <td class="text-left">
                                            <a href="#"
                                                class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                style="margin-left: 0px">
                                                Thao tác
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <a row-action="update-extracurricular-activity"
                                                        class="menu-link px-3"
                                                        href="{{ action(
                                                            [App\Http\Controllers\Abroad\AbroadController::class, 'updateExtracurricularActivity'],
                                                            ['id' => $extracurricularActivity->id]
                                                        ) }}">
                                                        Chỉnh sửa
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach


                    </tbody>
                </table>
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                <!--end::Table-->





            </div>
            <div class="d-flex bd-highlight">
                <div class="p-2 flex-grow-1 bd-highlight">
                    <a href="{{ action(
                        [App\Http\Controllers\Abroad\AbroadController::class, 'createExtracurricularActivity'],
                        [
                            'id' => $abroadApplication->id,
                        ],
                    ) }}"
                        class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                        row-action="create-extracurricular-activity">
                        <span class="material-symbols-rounded me-2">
                            add
                        </span>
                        Thêm kế hoạch
                    </a>
                </div>
                <div class="p-2 bd-highlight">
                    <button type="reset" id="kt_modal_add_customer_cancel"
                        class="btn btn-info btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px"
                        data-bs-dismiss="modal">Lưu tạm</button>
                </div>
                <div class="p-2 bd-highlight">
                    <a href="{{ action(
                        [App\Http\Controllers\Abroad\AbroadController::class, 'updateActiveExtracurricularActivity'],
                        [
                            'id' => $abroadApplication->id,
                        ],
                    ) }}"
                        class="btn btn-info btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px"
                        row-action="update-status-active">
                        Hoàn thành
                    </a>
                </div>
            </div>
        </div>
    </form>
    <!--end::Card body-->

    <script>
        $(() => {
            ExtracurricularActivity.init();
            //Update node-log
            CreateSocialNetworkPopup.init();

        });
        var CreateSocialNetworkPopup = (function() {
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

        var ExtracurricularActivity = (function() {
            var listContent;

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="update-extracurricular-activity"]');
            }

            function getCreateBtn() {
                return document.querySelectorAll('[row-action="create-extracurricular-activity"]');
            }

            function getUpdateStatusActive() {
                return document.querySelectorAll('[row-action="update-status-active"]');
            }
            
            submit = (btnUrl) => {
                var url = btnUrl
                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                }).done(response => {
                    extracurricularActivityPopup.getPopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            extracurricularActivityManager.load();
                        }
                    });

                }).fail(message => {
                    removeSubmitEffect();
                })
            }

            return {
                init: function() {
                    listContent = document.querySelector('.table-responsive'); // Define listContent here
                    
                    if (listContent) {
                        getUpdateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreateSocialNetworkPopup.updateUrl(btnUrl);
                            });
                        });

                        getCreateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreateSocialNetworkPopup.updateUrl(btnUrl);
                            });
                        });

                        getUpdateStatusActive().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();

                                var btnUrl = btn.getAttribute('href');
                                
                                submit(btnUrl);
                            });
                        });
                        
                    } else {
                        throw new Error("listContent is undefined or null.");
                    }
                }
            };
        })();
    </script>
@endsection
