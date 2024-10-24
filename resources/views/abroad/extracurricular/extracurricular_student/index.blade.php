@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Quản lý học viên
@endsection
@php
    $createExtracurricular = 'createExtracurricular_' . uniqid();
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
                                        Tên học viên
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số tiền
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày thu
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Cán bộ phụ trách
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ghi chú
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left d-none">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <input type="hidden" name="extracurricularStudents" value="{{ $extracurricularStudents }}">
                        @foreach ($extracurricularStudents as $extracurricularStudent)
                            <tr list-control="item">
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->student->name }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->student->email }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->student->phone }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->amount }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->received_date }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{-- {{ $extracurricularStudent->account->name }} --}}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->note }}
                                </td>
                                <td class="text-left d-none">
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
                                            <a data-action="under-construction" row-action="update-extracurricular"
                                                class="menu-link px-3" href="{{ action(
                                                    [App\Http\Controllers\Abroad\ExtracurricularStudentController::class, 'edit'],
                                                    [
                                                        'id' => $extracurricularStudent->id,
                                                    ],
                                                ) }}">
                                                Chỉnh sửa
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!--end::Table-->
                <!--end::Table-->
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>

                




            </div>


            <div class="d-flex bd-highlight d-none">
                <div class="p-2 flex-grow-1 bd-highlight">
                    <a href="{{ action(
                        [App\Http\Controllers\Abroad\ExtracurricularStudentController::class, 'create'],
                        [
                            'id' => $extracurricularId,
                        ],
                    ) }}"
                        class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                        row-action="create-extracurricular">
                        <span class="material-symbols-rounded me-2">
                            add
                        </span>
                        Thêm học viên
                    </a>
                </div>


            </div>
        </div>
    </form>
    <!--end::Card body-->

    <script>
        $(() => {
            Extracurricular.init();
            //Update node-log
            UpdateExtracurricularStudentPopup.init();
            CreateExtracurricularPopup.init()
        });

        var UpdateExtracurricularStudentPopup = (function() {
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
        var CreateExtracurricularPopup = (function() {
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


        var Extracurricular = (function() {
            var listContent;

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="update-extracurricular"]');
            }

            function getCreateBtn() {
                return document.querySelectorAll('[row-action="create-extracurricular"]');
            }

            function getUpdateStatusActive() {
                return document.querySelectorAll('[row-action="update-status-active"]');
            }

            function checkExtracurriculars() {
                var extracurriculars = document.querySelector('[name="extracurriculars"]').value;
                var extracurricularsArray = JSON.parse(extracurriculars);

                return Array.isArray(extracurricularsArray) && extracurricularsArray.length > 0;
            }


            submit = (btnUrl) => {
                var url = btnUrl;
                if (checkExtracurriculars()) {
                    // Nếu có chứng chỉ, tiếp tục thực hiện hành động
                    $.ajax({
                        url: url,
                        method: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                    }).done(response => {
                        UpdateStatusActive.getUpdatePopup().hide();
                        UpdateExtracurricularStudentPopups.getUpdatePopup().hide();

                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                networkSocialManager.load();
                            }
                        });

                    }).fail(message => {
                        // UpdatePopup.getUpdatePopup().setContent(message.responseText);
                        removeSubmitEffect();
                    });
                } else {
                    const errorContainer = document.getElementById('error-message');
                    errorContainer.textContent =
                        'Tạo ít nhất một Mạng xã hội và truyền thông để hoàn thành';
                    errorContainer.style.display = 'block';
                    return;
                }
            }
            return {
                init: function() {
                    listContent = document.querySelector('.table-responsive'); // Define listContent here
                    if (listContent) {
                        getUpdateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                UpdateExtracurricularStudentPopup.updateUrl(btnUrl);
                            });
                        });
                        getCreateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreateExtracurricularPopup.updateUrl(btnUrl);
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
