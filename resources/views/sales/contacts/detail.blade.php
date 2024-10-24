@section('footer')
    <!--begin::Custom Javascript(used for this page only)-->

    <script src="{{ url('core/assets/js/custom/apps/projects/list/list.js') }}"></script>
    <script src="{{ url('core/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ url('core/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ url('core/assets/js/custom/apps/chat/chat.js') }}"></script>
    <!--end::Custom Javascript-->
@endsection
<div class="d-flex flex-wrap flex-sm-nowrap">
    <!--begin: Pic-->
    <div class="me-7 mb-4">
        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
            <img src="{{ url('/core/assets/media/avatars/blank.png') }}" alt="image" />
            <div
                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle  border-4 border-body h-20px w-20px">
            </div>
        </div>
        <div class="mt-10">
            <div class="d-flex align-items-center">
                <!--begin::Symbol-->
                @if ($contact->account)
                    <div class="symbol symbol-35px me-4">
                        <div class="symbol symbol-35px">
                            <div class="symbol-label fs-2 fw-semibold bg-success text-inverse-success">
                                N</div>
                        </div>
                    </div>
                @else
                    <div class="symbol symbol-35px me-4">
                        <div class="symbol symbol-35px">
                            <div class="symbol-label fs-2 fw-semibold bg-default text-inverse-default">
                            </div>
                        </div>
                    </div>
                @endif
                <!--end::Symbol-->
                <!--begin::Title-->
                <div class="mb-0 me-2">
                    <a href="javascript:;">
                        <div inline-control="form" >
                            <div class="d-flex align-items-center" data-column="sale_person" list-control="salepersion-inline-edit"
                            data-url="{{ action('\App\Http\Controllers\Sales\ContactController@save', [
                                'id' => $contact->id,
                            ]) }}">
                                <span inline-control="data" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                                    @if ($contact->account)
                                        {{ $contact->account->name }}
                                        
                                        
                                    @else
                                        <span class="text-gray-500">Chưa bàn giao</span>
                                    @endif
                                    <a href="javascript:;" inline-control="edit-button">
                                        <span class="material-symbols-rounded fs-6 inline-edit-button">
                                            edit
                                        </span>
                                    </a>
                                </span>
                                
    
                                    <div inline-control="form" style="display:none;">
                                        <div class="d-flex align-items-center">
                                            <select inline-control="input" class="form-select"
                                                data-control="select2" data-placeholder="Select an option">
                                                <option value="unassign">Chưa bàn giao</option>
                                                @foreach ($accounts as $account)
                                                    <option
                                                        {{ $contact->account_id == $account->id ? 'selected' : '' }}
                                                        value="{{ $account->id }}">{{ $account->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button inline-control="close" type="button"
                                                class="btn btn-icon">
                                                <span class="material-symbols-rounded">
                                                    close
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-gray-600 fs-6">Nhân viên phụ trách</span><div>
                            </div>
                        </div>
                    </a>
                </div>
                <!--end::Title-->
            </div>
        </div>
    </div>
    <!--end::Pic-->
    <!--begin::Info-->
    <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
            <!--begin::User-->
            <div class="d-flex flex-column">
                <!--begin::Name-->
                <div class="d-flex align-items-center mb-2">
                    <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $contact->name }}</a>
                    <a>
                        <i class="ki-duotone ki-verify fs-1 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </div>
                <!--end::Name-->
                <!--begin::Info-->
                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                    <a class="d-flex align-items-center text-gray-600 text-hover-primary me-5 mb-2">
                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>Người dùng</a>
                    <a class="d-flex align-items-center text-gray-600 text-hover-primary me-5 mb-2">
                        <i class="ki-duotone ki-geolocation fs-4 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>{{ $contact->address }}</a>
                    <a class="d-flex align-items-center text-gray-600 text-hover-primary mb-2">
                        <i class="ki-duotone ki-sms fs-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ $contact->email }}</a>
                </div>
                <!--end::Info-->
            </div>
            <!--end::User-->
            <!--begin::Actions-->
            <div class="d-flex my-4 ms-15">
                <div class="">
                    <a href="javascript:;"
                        class="btn btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Thao tác
                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4 w-250px"
                        data-kt-menu="true">

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a  row-action="update-contact" 
                                href="{{ action('App\Http\Controllers\Sales\ContactController@edit', ['id' => $contact->id]) }}"
                                class="menu-link px-3">Chỉnh sửa</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a  row-action="delete" id="buttonDeleteCustom"
                            data-contact-id="{{ $contact->id }}"
                                class="menu-link px-3">Xóa</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--begin::Menu-->

                <!--end::Menu-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Title-->
        <!--begin::Stats-->
        <div class="d-flex flex-wrap flex-stack">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-grow-1 pe-8">
                <!--begin::Stats-->
                <div class="d-flex flex-nowrap">
                    <!--begin::Stat-->
                    <a class="border border-gray-300 border-dashed rounded min-w-125px py-3 me-3 mb-3 profile-stat-box"
                        data-action="under-construction"
                        href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'education'], ['id' => $contact->id]) }}">
                        <!--begin::Header-->
                        <div class="card-header pt-5 border-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">

                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">8</span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Khóa học</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <!--begin::Chart-->
                            <div class="d-flex flex-center me-5 pt-2">
                                <div id="kt_card_widget_4_chart" style="min-width: 70px; min-height: 70px"
                                    data-kt-size="70" data-kt-line="11"></div>
                            </div>
                            <!--end::Chart-->
                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-60">
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1  w-70px">Đã hoàn thành</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">2</div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1  w-70px">Đang học</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">4</div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-6px rounded-2 me-3" style="background-color: #E4E6EF">
                                    </div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1  w-70px">Chờ</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">2</div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </a>
                    <!--end::Stat-->
                    <!--begin::Stat-->
                    <a class="border border-gray-300 border-dashed rounded min-w-125px py-3 me-3 mb-3 profile-stat-box"
                        data-action="under-construction"
                        href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'studyAbroad'], ['id' => $contact->id]) }}">
                        <!--begin::Header-->
                        <div class="card-header pt-5 border-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">5</span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Du học</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-end pt-0">
                            <!--begin::Progress-->
                            <div class="d-flex align-items-center flex-column mt-3 w-125">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                    <span class="fw-bolder fs-6 text-dark py-5">Tiến độ</span>
                                    <span class="fw-bold fs-6 text-gray-400 py-5 px-7">40%</span>
                                </div>
                                <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                    <div class="bg-success rounded h-8px" role="progressbar" style="width: 40%;"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <!--end::Progress-->
                        </div>
                        <!--end::Card body-->

                    </a>
                    <!--end::Stat-->
                    <!--begin::Stat-->
                    <a class="border border-gray-300 border-dashed rounded min-w-125px py-3 me-3 mb-3 profile-stat-box"
                        data-action="under-construction"
                        href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'debt'], ['id' => $contact->id]) }}">
                        <!--begin::Header-->
                        <div class="card-header pt-5 border-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                    <!--end::Currency-->
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">3,315</span>
                                    <!--end::Amount-->
                                    <!--begin::Badge-->
                                    <span class="badge badge-light-success fs-base">
                                        <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>2.1%</span>
                                    <!--end::Badge-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Doanh số</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-end px-0 pb-0">
                            <!--begin::Chart-->
                            <div id="kt_card_widget_6_chart" class="w-100" style="height: 80px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Card body-->
                    </a>
                    <!--end::Stat-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Wrapper-->

        </div>
        <!--end::Stats-->
    </div>
    <!--end::Info-->
</div>


<script>
     
       
    $(function() { // document ready
            //
            ContactEditInline.init();


            
    });
    

    var ContactEditInline = function() {
        return {
            init: function() {
                // salesperson inline edit
                document.querySelectorAll('[list-control="salepersion-inline-edit"]').forEach(control => {
                    var url = control.getAttribute('data-url');
                    var salespersonInlineEdit = new SalespersonInlineEdit({
                        container: control,
                        url: url,
                    });
                });

                
            }
        };
    }();

    
    var SalespersonInlineEdit = class {
        constructor(options) {
            this.container = options.container;
            this.saveUrl = options.url;

            //
            this.events();
        }

        getEditButton() {
            return this.container.querySelector('[inline-control="edit-button"]');
        }

        showFormBox() {
            this.getFormBox().style.display = 'inline-block';
        }

        hideFormBox() {
            this.getFormBox().style.display = 'none';
        }

        getFormBox() {
            return this.container.querySelector('[inline-control="form"]');
        }

        getDataContainer() {
            return this.container.querySelector('[inline-control="data"]')
        }

        hideDataContainer() {
            this.getDataContainer().style.display = 'none';
        }

        showDataContainer() {
            this.getDataContainer().style.display = 'inline-block';
        }

        updateDataBox(salepersone_name) {
            this.getDataContainer().innerHTML = salepersone_name;
        }

        getInputControl() {
            return this.container.querySelector('[inline-control="input"]');
        }

        getSaleperSonid() {
            return this.getInputControl().value;
        }

        hideEditButton() {
            this.getEditButton().style.display = 'none';
        }

        showEditButton() {
            this.getEditButton().style.display = 'inline-block';
        }

        getCloseButton() {
            return this.container.querySelector('[ inline-control="close"]');
        }

        save(afterSave) {
            var _this = this;
            // const that = this;
            $.ajax({
                method: 'POST',
                url: this.saveUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                    salesperson_id: this.getSaleperSonid(),
                },
            }).done(function(response) {
                _this.updateDataBox(response.salepersone_name);

                // afterSave
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }).fail(function() {

            });
        }

        setEditMode() {
            this.showFormBox();
            this.hideDataContainer();
            this.hideEditButton();
        }

        closeEditMode() {
            this.hideFormBox();
            this.showDataContainer();
            this.showEditButton();
        }

        events() {
            var _this = this;

            //click
            this.getEditButton().addEventListener('click', (e) => {
                this.setEditMode();
            })

            // close
            this.getCloseButton().addEventListener('click', (e) => {
                this.closeEditMode();
            });

            // Click để lưu thay đổi
            $(this.getInputControl()).on('change', (e) => {
                this.save(function() {
                    //
                    ASTool.alert({
                        message: 'Đã cập nhật nhân viên sales thành công!',
                        ok: function() {
                            // close box
                            _this.closeEditMode();

                            
                            location.reload();

                        }
                    });
                });
            });
        }
    };
</script>