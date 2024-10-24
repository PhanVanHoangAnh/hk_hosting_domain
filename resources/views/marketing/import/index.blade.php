@extends('layouts.main.app', [
    'menu' => 'marketing',
])

@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'importExport',
        'sidebar' => 'import',
    ])
@endsection


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Nhập dữ liệu</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->

        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1 d-none">
            <!--begin::Button-->
            <button class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px">

                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Xuất file excel
            </button>



            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <div id="" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="row g-6 g-xl-9">
            <!--begin::Col-->
            <div class="col-md-6 col-xl-4 ">

                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-9">
                        <!--begin::Card Title-->
                        <div class="card-title m-0">
                            <!--begin::Avatar-->
                            <div class="symbol symbol symbol-70px w-70p">
                                <img src="{{ url('/core/assets/media/avatars/excel.png') }}" alt="image" class="p-3">
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::Car Title-->
                    </div>
                    <!--end:: Card header-->

                    <!--begin:: Card body-->
                    <div class="card-body p-9">
                        <!--begin::Name-->
                        <div class="fs-3 fw-bold text-dark">NHẬP TỪ FILE EXCEL</div>
                        <!--end::Name-->

                        @if (App\Library\ImportContact::isRunning())
                            <a href="{{ url('/templates/contact-import-template.xlsx') }}">
                                <span class="d-flex align-items-center">
                                    <span class="material-symbols-rounded me-1">
                                        article
                                    </span>
                                    <span>
                                        Tải mẫu dữ liệu
                                    </span>
                                </span>
                            </a>
                        @else
                            <div class="">
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">Nhập dữ liệu từ excel theo mẫu từ hệ thống ASMS
                                </p>
                                <!--end::Description-->
                                <div class="d-none">
                                    <p class="mb-10">Nhấn
                                        <a href="{{ url('/templates/contact-import-template.xlsx') }}" class="fw-bold">
                                            vào đây
                                        </a> để tải tập tin mẫu về máy
                                    </p>
                                </div>
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
    
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
    
                                {{-- <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    aria-label="This project 50% completed" data-bs-original-title="This project 50% completed"
                                    data-kt-initialized="1">
                                    <div class="bg-dark rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow=" 50"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress--> --}}
    
                                @if (!App\Library\ImportContact::isRunning())
                                    <button list-action='import-excel' class="btn btn-secondary d-none" data-bs-toggle="modal" data-action="under-construction"
                                        data-bs-target="#kt_modal_create_project">Bắt đầu nhập</button>
                                @endif
                                <span class="">
                                    <a href="{{ url('/templates/contact-import-template.xlsx') }}" list-action="export-contact" class="btn btn-light">
                                        <span class="d-flex align-items-center">
                                            <span class="material-symbols-rounded me-1">
                                                article
                                            </span>
                                            <span>
                                                Tải mẫu dữ liệu
                                            </span>
                                        </span>
                                    </a>
                                </span>
                                <!--end::Users-->
                            </div>
                        @endif
                    </div>
                    <!--end:: Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-6 col-xl-4 ">

                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-9">
                        <!--begin::Card Title-->
                        <div class="card-title m-0">
                            <!--begin::Avatar-->
                            <div class="symbol symbol symbol-70px w-70p">
                                <img src="{{ url('/core/assets/media/avatars/hubspot.jpg') }}" alt="image"
                                    class="p-3">
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::Car Title-->
                    </div>
                    <!--end:: Card header-->

                    <!--begin:: Card body-->
                    <div class="card-body p-9">
                        <!--begin::Name-->
                        <div class="fs-3 fw-bold text-dark">NHẬP TỪ HUBSPOT</div>
                        <!--end::Name-->

                        <!--begin::Description-->
                        <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">Nhập dữ liệu liên hệ từ HubSpot</p>
                        <!--end::Description-->

                        <!--begin::Info-->
                        <div class="d-flex flex-wrap mb-5">
                            <!--begin::Due-->

                            <!--end::Budget-->
                        </div>
                        <!--end::Info-->

                        {{-- <!--begin::Progress-->
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                            aria-label="This project 30% completed" data-bs-original-title="This project 30% completed"
                            data-kt-initialized="1">
                            <div class="bg-dark rounded h-4px" role="progressbar" style="width: 30%" aria-valuenow=" 30"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress--> --}}
                        {{-- <div>
                            <p class="mb-20">
                            </p>
                        </div> --}}
                        <!--begin::Users-->
                        <button list-action='import-hubspot' class="btn btn-secondary d-none" data-bs-toggle="modal" 
                            data-bs-target="#kt_modal_create_project">Bắt đầu nhập</button>

                        @if (!\App\Models\Setting::get('hubspot.auto_update'))
                            <div class="alert alert-warning mb-0 d-flex align-items-center">
                                <span class="material-symbols-rounded me-2 text-dark">
                                    timer_pause
                                </span>
                                    <span class="text-dark">Đang tạm dừng</span>
                            </div>
                        @else
                            <div class="alert alert-info mb-0 d-flex align-items-center">
                                <div>
                                    <div data-control="importing-spinner" class="spinner-border text-info me-4" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <span>ASMS tự động cập nhật đơn hàng/liên hệ mới từ HubSpot mỗi phút/lần</span>
                            </div>
                        @endif
                        
                        <!--end::Users-->
                    </div>
                    <!--end:: Card body-->

                    
                </div>
                <!--end::Card-->
            </div>

            <!--begin::Col-->
            <div class="col-md-6 col-xl-8">

                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-9">
                        <!--begin::Card Title-->
                        <div class="card-title m-0">
                            <!--begin::Avatar-->
                            <div class="symbol symbol symbol-70px w-70p p-3 me-5">
                                <svg style="height:51px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 88">
                                    <path d="M 42,0 64,22 53,24 42,22 40,11 Z" fill="#188038"/>
                                    <path d="M 42,22 V 0 H 6 C 2.685,0 0,2.685 0,6 v 76 c 0,3.315 2.685,6 6,6 h 52 c 3.315,0 6,-2.685 6,-6 V 22 Z" fill="#34a853"/>
                                    <path d="M 12,34 V 63 H 52 V 34 Z M 29.5,58 H 17 v -7 h 12.5 z m 0,-12 H 17 V 39 H 29.5 Z M 47,58 H 34.5 V 51 H 47 Z M 47,46 H 34.5 V 39 H 47 Z" fill="#fff"/>
                                </svg>
                            </div>
                            <!--end::Avatar-->
                            <div>
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">NHẬP TỪ GOOGLE SHEET</div>
                                <!--end::Name-->

                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-0">Nhập dữ liệu liên hệ từ hệ Google Sheet</p>
                                <!--end::Description-->
                            </div>
                        </div>
                        <!--end::Car Title-->
                    </div>
                    <!--end:: Card header-->

                    <!--begin:: Card body-->
                    <div class="card-body p-9 pt-5">
                        <div class="alert alert-info mb-0 d-flex align-items-center mb-7">
                            <div>
                                <div data-control="importing-spinner" class="spinner-border text-info me-4" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <span>ASMS tự động cập nhật đơn hàng/liên hệ mới từ Google Sheet mỗi 1 phút/lần</span>
                            <div class="ms-auto">
                                <a data-control="google-refresh" href="{{ action([\App\Http\Controllers\Marketing\ImportController::class, 'index']) }}" class="btn btn-light py-2">
                                    Kiểm tra
                                </a>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr class="bg-info text-light">
                                    <th>Sheet ID</th>
                                    <th>Imported #Line</th>
                                    <th>Last Imported</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Library\GoogleSheetImporter::getAll() as $importer)
                                    <tr>
                                        <td>
                                            <p class="fw-bold mb-1">{{ $importer->getName() }}</p>
                                            <a href="https://docs.google.com/spreadsheets/d/{{ $importer->sheetId }}" target="_blank">
                                                {{ $importer->sheetId }}
                                            </a>
                                        </td>
                                        <td dynamic-label="last-line-{{ $importer->sheetId }}">
                                            #{{ $importer->getLastImportLine() }}
                                        </td>
                                        <td dynamic-label="last-import-{{ $importer->sheetId }}">
                                            {{ $importer->getLastImportAt() }}
                                        </td>
                                        <td>
                                            @if ($importer->isActive())
                                                <span class="badge bg-{{ $importer->isActive() ? 'success' : 'secondary' }}">
                                                    {{ $importer->getStatus() }}
                                                </span>
                                            @else
                                                <span class="badge bg-{{ $importer->isActive() ? 'success' : 'secondary' }}">{{ $importer->getStatus() }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if ($importer->isPaused())
                                                <form method="POST" action="{{ action([\App\Http\Controllers\Marketing\ImportController::class, 'startGoogleSheetImporter'], [
                                                    'sheet_id' => $importer->sheetId
                                                ]) }}" class="d-inline-block me-1">
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-info text-nowrap px-2 py-2 rounded text-nowrap xtooltip"
                                                        title="Bật tự động cập nhật"
                                                        data-control="one-click-loading">
                                                        <span class="indicator-label d-flex align-items-center">
                                                            <span class="material-symbols-rounded">
                                                                slow_motion_video
                                                            </span></span>
                                                        <span class="indicator-progress">Đang xử lý...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($importer->isActive())
                                                <form method="POST" action="{{ action([\App\Http\Controllers\Marketing\ImportController::class, 'pauseGoogleSheetImporter'], [
                                                    'sheet_id' => $importer->sheetId
                                                ]) }}" class="d-inline-block me-1">
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-light text-nowrap px-2 py-2 rounded text-nowrap xtooltip"
                                                        title="Tắt tự động cập nhật" data-control="one-click-loading">
                                                        <span class="indicator-label d-flex align-items-center">
                                                            <span class="material-symbols-rounded">
                                                            pause
                                                            </span></span>
                                                        <span class="indicator-progress">Đang xử lý...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ action([\App\Http\Controllers\Marketing\ImportController::class, 'runGoogleSheetImporter'], [
                                                'sheet_id' => $importer->sheetId
                                            ]) }}" class="d-inline-block me-1">
                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-light text-nowrap px-2 py-2 rounded text-nowrap xtooltip"
                                                        title="Cập nhật ngay" data-control="one-click-loading">
                                                    <span class="indicator-label d-flex align-items-center">
                                                        <span class="material-symbols-rounded">
                                                            play_arrow
                                                        </span></span>
                                                    <span class="indicator-progress">Đang xử lý...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ action([\App\Http\Controllers\Marketing\ImportController::class, 'resetGoogleSheetImporter'], [
                                                'sheet_id' => $importer->sheetId
                                            ]) }}" class="d-inline-block d-none">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger text-nowrap px-2 py-2 rounded text-nowrap"
                                                        title="Nhập lại từ dòng đầu tiên" data-control="one-click-loading">
                                                    <span class="indicator-label d-flex align-items-center">
                                                        <span class="material-symbols-rounded">
                                                        restart_alt
                                                        </span></span>
                                                    <span class="indicator-progress">Đang xử lý...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @if ($importer->getLastError())
                                        <tr class="bg-light-danger">
                                            <td colspan="5" class="text-danger">
                                                {{  $importer->getLastError() }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!--end::Users-->
                    </div>
                    <!--end:: Card body-->
                </div>
                <!--end::Card-->
            </div>

        </div>
        <!--end::Card header-->


    </div>

    <script>
        $(function() {
            //
            ImportIndex.init();

            //
            $('[data-action="import-progress"]').on('click', function(e) {
                e.preventDefault();

                ExcelPopup.getPopup().url = $(this).attr('href');
                ExcelPopup.getPopup().load();
            });

            // auto refresh data
            new GoogleSheetRefresh({
                labels: $('[dynamic-label]'),
                refreshButton: $('[data-control="google-refresh"]'),
            });
        });

        var GoogleSheetRefresh = class {
            constructor(options) {
                this.labels = options.labels;
                this.refreshButton = options.refreshButton;

                // 
                this.run();

                this.events();
            }

            events() {
                var _this = this;
                this.refreshButton.on('click', function(e) {
                    _this.refresh();
                    e.preventDefault();
                });
            }

            run() {
                var _this = this;

                this.refresh(function() {
                    setTimeout(() => {
                        _this.refresh();
                    }, 10000);
                });
            }

            refresh(callback) {
                var _this = this;
                // 
                $.ajax({
                    method: 'GET',
                    url: '',
                }).done(function(response) {
                    var div = $('<div>').html(response);

                    var news = div.find('[dynamic-label]');

                    news.each(function() {
                        //
                        var key = $(this).attr('dynamic-label');
                        var value = $(this).html();
                        var label = $('[dynamic-label="' + key + '"]');

                        label.html(value);
                    });

                    if (typeof(callback) !== 'undefined') {
                        callback();
                    }
                }).fail(function() {

                });
            }
        }

        //
        var ImportIndex = function() {
            return {
                init: function() {
                    //Excel
                    ExcelPopup.init();
                    excelHandle.init();
                    //HubSpot
                    HubSpotPopup.init();
                }
            };
        }();

        var HubSpotPopup = function() {
            var popupHubSpot;
            var buttonHubSpot;
            var handleHubSpot = function() {
                buttonHubSpot.addEventListener('click', (e) => {
                    e.preventDefault();
                    popupHubSpot.load();
                })
            }

            return {
                init: function() {
                    popupHubSpot = new Popup({
                        url: "{{ action('\App\Http\Controllers\HubSpotController@index') }}",
                    });
                    buttonHubSpot = document.querySelector("button[list-action='import-hubspot']");
                    handleHubSpot();
                },
                getPopup: function() {
                    return popupHubSpot;
                }
            }
        }();

        var ExcelPopup = function() {
            var popupExcelImport;
            var buttonExcelImport;
            var showExcelImportModal = function() {
                popupExcelImport.load();
            };

            return {
                init: function() {
                    excelPopup = new Popup();
                },
                updateUrl: (newUrl, method, token, data) => {

                    excelPopup.url = newUrl;
                    excelPopup.method = !method ? null : method;
                    excelPopup.header = !token ? null : {
                        'X-CSRF-TOKEN': token
                    };

                    excelPopup.data = !data ? null : data;
                    excelPopup.load();
                },
                updateUrlImportFile: (newUrl, method, token, data) => {

                    excelPopup.url = newUrl;
                    excelPopup.method = !method ? null : method;
                    excelPopup.header = !token ? null : {
                        'X-CSRF-TOKEN': token
                    };
                    excelPopup.data = !data ? null : data;
                    excelPopup.loadExcelFile();
                },
                updateUrlSaveDatas: (newUrl, method, token, data) => {

                    excelPopup.url = newUrl;
                    excelPopup.method = !method ? null : method;
                    excelPopup.header = !token ? null : {
                        'X-CSRF-TOKEN': token
                    };
                    excelPopup.data = !data ? null : data;
                    excelPopup.loadJsonData();
                    // ContactsList.getList().load();
                },
                getPopup: function() {
                    return excelPopup;
                },
                hidePopup: () => {
                    excelPopup.hide();
                }
            };
        }();

        const excelHandle = function() {
            let buttonExcelImport;
            let importExcelDataForm;

            return {
                init: () => {
                    const importExcelButton = document.querySelector("button[list-action='import-excel']");
                    if (importExcelButton) {
                        importExcelButton.addEventListener('click', e => {
                            e.preventDefault();



                            ExcelPopup.updateUrl(
                                "{{ action('\App\Http\Controllers\Marketing\ContactController@importExcel') }}"
                            );

                        });
                    }
                }
            };
        }();
    </script>
@endsection
