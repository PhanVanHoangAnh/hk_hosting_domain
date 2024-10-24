<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">7</span>
            </div>
            <div class="fw-semibold">
                Thời điểm học sinh lên đường
                <div class="mt-1">
                    {{-- <span class="badge badge-{{ $abroadApplication->isDoneFlyingStudent() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneFlyingStudent() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span> --}}
                    {{-- <span class="badge badge-{{ isset($flyingStudents) ? 'success' : 'primary' }}">
                        {{ isset($flyingStudents) ? 'Hoàn thành' : 'Chưa hoàn thành' }}
                    </span> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="">

            <!--begin::Card body-->
            <form id="tableFlyingStudent" tabindex="-1">
                @csrf
                <div class="table-responsive">

                    @if (!$flyingStudents->isEmpty())
                        <table class="table align-middle table-row-dashed fs-6 gy-5 border"
                            id="dtHorizontalVerticalOrder">
                            <thead>
                                <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                                Ngày khởi hành trên vé máy bay
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                                Giờ bay
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                                Hãng hàng không
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach ($flyingStudents as $flyingStudent)
                                    <tr>
                                        <td class="text-left mb-1 text-nowrap">
                                            {{ \Carbon\Carbon::parse($flyingStudent->flight_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-left mb-1 text-nowrap">
                                            {{ $flyingStudent->flight_time }}
                                        </td>
                                        <td class="text-left mb-1 text-nowrap">
                                            {{ $flyingStudent->air }}
                                        </td>

                                        <td class="min-w-125px text-left">
                                            <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                                <a row-action="update-flying-student"
                                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                    href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'updateFlyingStudent'],
                                                        [
                                                            'id' => $flyingStudent->id,
                                                        ],
                                                    ) }}">Chỉnh
                                                    sửa</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endif
                    {{-- @if (!$flyingStudents) --}}
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <!--begin::Button-->
                            <a href="{{ action(
                                [App\Http\Controllers\Abroad\AbroadController::class, 'createFlyingStudent'],
                                [
                                    'id' => $abroadApplication->id,
                                ],
                            ) }}"
                                class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                                row-action="create-flying-student">
                                <span class="material-symbols-rounded me-2">
                                    add
                                </span>
                                Thêm mới
                            </a>
                            <!--end::Button-->
                    {{-- @endif --}}

                </div>

        </div>

        </form>
        <!--end::Card body-->
    </div>
</div>
</div>

<script>
    $(() => {
        FlyingStudent.init();

        UpdatePopup.init();
    });

    var UpdatePopup = (function() {
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

    var FlyingStudent = (function() {
        var listContent;

        function getUpdateBtn() {
            return document.querySelectorAll('[row-action="update-flying-student"]');
        }

        function getCreateBtn() {
            return document.querySelectorAll('[row-action="create-flying-student"]');
        }

        return {
            init: function() {
                listContent = document.querySelector('#tableFlyingStudent');
                if (listContent) {
                    getUpdateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopup.updateUrl(btnUrl);
                        });
                    });
                    getCreateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopup.updateUrl(btnUrl);
                        });
                    });
                } else {
                    throw new Error("listContent is undefined or null.");
                }
            }
        };
    })();
</script>
