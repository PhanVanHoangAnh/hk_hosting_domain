@extends('layouts.main.popup')

@section('title')
    Mạng xã hội và kênh truyền thông
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
                                        Các trang mạng xã hội
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Link trang mạng xã hội
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <input type="hidden" name="socialNetworks" value="{{ $socialNetworks }}">
                        @foreach ($socialNetworks as $socialNetwork)
                            <tr list-control="item">
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $socialNetwork->name }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    <a href="{{ $socialNetwork->link }}">
                                        {{ $socialNetwork->link }}
                                    </a>
                                </td>
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
                                            <a row-action="update-socialNetwork"
                                                class="menu-link px-3"
                                                href="{{ action(
                                                    [App\Http\Controllers\Student\AbroadController::class, 'updateSocialNetwork'],
                                                    [
                                                        'id' => $socialNetwork->id,
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
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>

                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'createSocialNetwork'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                            row-action="create-social-network">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Thêm mạng xã hội
                        </a>
                    </div>
                    <div class="p-2 bd-highlight">
                        <button type="reset" id="kt_modal_add_customer_cancel"
                            class="btn btn-info btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px"
                            data-bs-dismiss="modal">Lưu tạm</button>
                    </div>
                    <div class="p-2 bd-highlight">
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'updateActiveSocialNetwork'],
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
            SocialNetwork.init();
            //Update node-log
            UpdateSocialNetworkPopup.init();
            CreateSocialNetworkPopup.init()
        });

        var UpdateSocialNetworkPopup = (function() {
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


        var SocialNetwork = (function() {
            var listContent;

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="update-socialNetwork"]');
            }

            function getCreateBtn() {
                return document.querySelectorAll('[row-action="create-social-network"]');
            }

            function getUpdateStatusActive() {
                return document.querySelectorAll('[row-action="update-status-active"]');
            }

            function checkSocialNetworks() {
                var socialNetworks = document.querySelector('[name="socialNetworks"]').value;
                var socialNetworksArray = JSON.parse(socialNetworks);

                return Array.isArray(socialNetworksArray) && socialNetworksArray.length > 0;
            }


            submit = (btnUrl) => {
                var url = btnUrl;
                if (checkSocialNetworks()) {
                    // Nếu có chứng chỉ, tiếp tục thực hiện hành động
                    $.ajax({
                        url: url,
                        method: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                    }).done(response => {
                        socialNetworkPopup.getPopup().hide();

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
                                UpdateSocialNetworkPopup.updateUrl(btnUrl);
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
