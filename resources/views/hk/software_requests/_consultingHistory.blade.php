<form>
    @csrf
    <div class="card-body toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7">
        <h3 class="fw-bold m-0 d-flex">Lịch sử tư vấn</h3>
        <div class="justify-content-end align-items-end d-flex">
            <button class="btn btn-primary me-1" id="buttonCreateNoteLog" row-action="create-note-log">
                Thêm Lịch Sử
            </button>
        </div>
    </div>
    @php
        $uniqFormConsult = 'uniq_form_consult_' . uniqId();
    @endphp
    <div id="{{ $uniqFormConsult }}" class="card-body pt-0 mt-5" id="kt_post">
        <div class="table-responsive table-head-sticky">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Mã yêu cầu
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Thời gian
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Trạng thái tư vấn
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Thời gian liên hệ tiếp
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Nội dung trao đổi
                                </span>
                            </span>
                        </th>
                        <th class="fs-8 min-w-100px" width="1%">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($softwareRequestNotes as $softwareRequestNote)
                        <tr list-control="item">
                            <td class="text-left">
                                {{ $softwareRequestNote->id }}
                            </td>
                            <td class="text-left">
                                {{ $softwareRequestNote->created_at }}
                            </td>
                            <td class="text-left">
                                {{ $softwareRequestNote->status }}
                            </td>
                            <td class="text-left">
                                {{ $softwareRequestNote->contact_time }}
                            </td>
                            <td class="text-left">
                                {{ $softwareRequestNote->content }}
                            </td>
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
                                    <div class="menu-item px-3">
                                        <a row-action="update" method="PUT"
                                            href="{{ action(
                                                [App\Http\Controllers\Hk\SoftwareRequestNoteController::class, 'edit'],
                                                [
                                                    'id' => $softwareRequestNote->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Chỉnh sửa</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="delete" method="DELETE"
                                            href="{{ action(
                                                [App\Http\Controllers\Hk\SoftwareRequestNoteController::class, 'destroy'],
                                                [
                                                    'id' => $softwareRequestNote->id,
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
    </div>
</form>
<script>
    $(function() {
        //
        ConsultingHistory.init();
    });

    var ConsultingHistory = function() {
        return {
            init: function() {
                CreateNotePopup.init();
                UpdateNoteLog.init();

                // CreateNoteLogPopup.init();

                AddNoteLog.init();
                DeletePopup.init();
                UpdateNotelogPopup.init();


            }
        };
    }();

    var DeletePopup = function() {
        var deleteItem = (deleteUrl) => {
            ASTool.confirm({
                message: "Bạn có chắc muốn xóa ghi chú này không?",
                ok: function() {
                    ASTool.addPageLoadingEffect();

                    $.ajax({
                        url: deleteUrl,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        }
                    }).done(response => {
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                location.reload();
                            }
                        })
                    }).fail(function() {

                    }).always(function() {
                        ASTool.removePageLoadingEffect();
                    })
                }
            })

        };
        return {
            init: () => {
                var deleteButtons = document.querySelectorAll('[row-action="delete"]');
                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var deleteUrl = this.getAttribute('href');
                        deleteItem(deleteUrl);
                    });
                });
            }
        }
    }();

    const CreateNotePopup = function() {
        let createPopup;

        return {
            init: () => {
                createPopup = new Popup();
            },
            updateUrl: newUrl => {
                createPopup.url = newUrl;
                createPopup.load();
            },
            getCreatePopup: () => {
                return createPopup;
            }
        }
    }();

    var UpdateNotelogPopup = function() {
        var updatePopup;

        return {
            init: () => {
                updatePopup = new Popup();
            },
            updateUrl: newUrl => {
                updatePopup.url = newUrl;
                updatePopup.load();
            },
            getUpdatePopup: () => {
                return updatePopup;
            },
            getPopup: () => {
                return updatePopup;
            }
        }
    }();

    var UpdateNoteLog = function() {

        return {
            init: () => {
                var buttonsUpdateNoteLog = document.querySelectorAll('[row-action="update"]'); // Lựa chọn tất cả nút chỉnh sửa
                buttonsUpdateNoteLog.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var editUrl = this.getAttribute('href');
                        UpdateNotelogPopup.updateUrl(editUrl);
                    });
                });
            },
            getUpdatePopup: () => {
                return updatePopups;
            },
        };
    }();

    var AddNoteLog = function() {
        return {
            init: function() {
                document.querySelector('#buttonCreateNoteLog').addEventListener('click', e => {
                    e.preventDefault();
                    CreateNotePopup.updateUrl(
                        "{{ action('App\Http\Controllers\Hk\SoftwareRequestNoteController@create', ['id' => $softwareRequest->id]) }}"
                    );
                });

            }
        }
    }();

    var SoftwareRequetList = function() {
        var list;

        return {
            init: function() {
                list = new DataList({
                    url: "{{ action('App\Http\Controllers\Hk\SoftwareRequestController@show', ['id' => $softwareRequest->id]) }}",
                    container: document.querySelector('#{{ $uniqFormConsult }}'),

                });

                list.load();
            },

            getList: function() {
                location.reload();
                return list;
            },
        }
    }();

    var DataList = class {
        constructor(options) {
            // throw exception make sure there is a url
            if (!options.url) {
                throw new Error('Bug: list url not found!');
            }

            this.initUrl = options.url;
            this.url = options.url;
            this.container = options.container;
        }

        setUrl(newUrl) {
            this.url = newUrl;
        };

        getUrl() {
            return this.url;
        };


        loadContent(content) {
            $(this.container).html(content);
            initJs(this.container);
        }

        load() {
            console.log(load)
            this.listXhr = $.ajax({
                url: this.url,
            }).done((content) => {
                this.loadContent(content);
                this.initEvents();
            }).fail(function() {

            });
        }
    }
</script>
