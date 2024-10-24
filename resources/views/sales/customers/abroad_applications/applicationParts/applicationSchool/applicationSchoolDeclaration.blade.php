@extends('layouts.main.popup')

@section('title')
    Danh sách trường yêu cầu tuyển sinh
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp
@section('content')
    <!--begin::Card body-->

    <form id="popupCreateAbroadUniqId" tabindex="-1">
        @csrf
       <div class="pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phân loại
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên trường
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm nộp hồ sơ
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Yêu cầu tuyển sinh
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <input type="hidden" name="applicationSchools" value="{{$applicationSchools}}">
                        <!-- Lặp qua từng loại trường -->
                        @foreach (\App\Models\ApplicationSchool::getAllType() as $type)
                            <!-- Dòng đầu tiên của mỗi loại trường -->
                            <tr>
                                <td rowspan="{{ count($applicationSchools->where('type', $type)) + 1 }}" class="text-left mb-1 text-nowrap"> {{ trans('messages.application_school.type.' . $type) }}</td>
                            </tr>
                            <!-- Lặp qua danh sách các trường trong mỗi loại -->
                            @foreach ($applicationSchools->where('type', $type) as $applicationSchool)
                                <tr list-control="item">
                                    <!-- Cột tên trường -->
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->school ? $applicationSchool->school->name :'--'  }}</td>
                                    <!-- Cột thời điểm nộp hồ sơ -->
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->apply_date }}</td>
                                    <!-- Cột yêu cầu tuyển sinh -->
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->school->requirement }}</td>
                                    <!-- Cột thao tác -->
                                    <td class="text-left">
                                        <a href="#" class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="margin-left: 0px">
                                            Thao tác
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a  row-action="update-application-school" class="menu-link px-3"
                                                    href="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'updateApplicationSchool'], ['id' => $applicationSchool->id,]) }}">
                                                    Chỉnh sửa
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                
                

                <!--end::Table-->
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>

                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight d-none">
                        <a href="{{ action(
                            [App\Http\Controllers\Sales\AbroadController::class, 'createApplicationSchool'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                            row-action="create-extracurricular-schedule">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Thêm mới
                        </a>
                    </div>
                    <div class="p-2 bd-highlight">
                        <button type="reset" id="kt_modal_add_customer_cancel"
                            class="btn btn-info btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px"
                            data-bs-dismiss="modal">Lưu tạm</button>
                    </div>
                    <div class="p-2 bd-highlight">
                        <a href="{{ action(
                            [App\Http\Controllers\Sales\AbroadController::class, 'updateActiveApplicationSchool'],
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
                {{-- <div class="d-flex justify-content-start align-items-center mt-3">
                    <span>
                        <!--begin::Button-->
                       
                        <!--end::Button-->
                    </span>
                    <span class="d-flex justify-content-end align-items-center">
                        <!--begin::Button-->
                        
                        <!--end::Button-->
                    </span>
                </div> --}}


            </div>
        </div>
    </form>
    <!--end::Card body-->

    <script>
        $(() => {
            ApplicationSchool.init();
            //Update node-log
            UpdateApplicationSchoolPopup.init();
            CreateApplicationSchoolPopup.init()
        });

        var UpdateApplicationSchoolPopup = (function() {
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
        var CreateApplicationSchoolPopup = (function() {
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


        var ApplicationSchool = (function() {
            var listContent;

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="update-application-school"]');
            }

            function getCreateBtn() {
                return document.querySelectorAll('[row-action="create-extracurricular-schedule"]');
            }

            function getUpdateStatusActive() {
                return document.querySelectorAll('[row-action="update-status-active"]');
            }

            function checkApplicationSchools() {
                var applicationSchools = document.querySelector('[name="applicationSchools"]').value;
                var applicationSchoolsArray = JSON.parse(applicationSchools);

                return Array.isArray(applicationSchoolsArray) && applicationSchoolsArray.length > 0;
            }


            submit = (btnUrl) => {
                var url = btnUrl;
                if (checkApplicationSchools()) {
                    // Nếu có chứng chỉ, tiếp tục thực hiện hành động
                    $.ajax({
                        url: url,
                        method: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                    }).done(response => {
                        applicationSchoolPopup.getPopup().hide();
                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                applicationSchoolManager.load();
                            }
                        });

                    }).fail(message => {
                        // UpdatePopup.getUpdatePopup().setContent(message.responseText);
                        removeSubmitEffect();
                    });
                } else {
                    const errorContainer = document.getElementById('error-message');
                    errorContainer.textContent =
                        'Tạo ít nhất một trường để hoàn thành';
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
                                UpdateApplicationSchoolPopup.updateUrl(btnUrl);
                            });
                        });
                        getCreateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreateApplicationSchoolPopup.updateUrl(btnUrl);
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
