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
                @if ($abroadApplication->contact->account)
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
                            data-url="javascript:;">
                                <span inline-control="data" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                                    @if ($abroadApplication->contact->account)
                                        {{ $abroadApplication->contact->account->name }}
                                        
                                        
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
                                                        {{ $abroadApplication->contact->account_id == $account->id ? 'selected' : '' }}
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
                    <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $abroadApplication->contact->name }}</a>
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
                        </i>{{ $abroadApplication->contact->address }}</a>
                    <a class="d-flex align-items-center text-gray-600 text-hover-primary mb-2">
                        <i class="ki-duotone ki-sms fs-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ $abroadApplication->contact->email }}</a>
                </div>
                <!--end::Info-->
            </div>
            <!--end::User-->
            <!--begin::Actions-->
            <div class="d-flex my-4 ms-15">
                <div class="">
                    <a data-action="under-construction"href="javascript:;"
                        class="btn btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Hồ sơ hoàn thiện 
                        <i class="ki-duotone ki-down fs-5 ms-1 d-none"></i></a>
                    <!--begin::Menu-->
                    
                    <!--end::Menu-->
                </div>
                <!--begin::Menu-->

                <!--end::Menu-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Title-->
        <!--begin::Stats-->
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <!--begin::Stats-->
                <div class="d-block">
                    <div class="row d-flex justify-content-between">
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Ngày sinh:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    
                                    <div>{{ date('d/m/Y', strtotime($abroadApplication->orderItem->order->contacts->birthday)) }}</div>
                                </div>
                            </div>
                        
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Số điện thoại:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $abroadApplication->orderItem->order->contacts->phone }}</div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Số hợp đồng:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div>{{ $abroadApplication->orderItem->order->code }}</div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Thời gian dự kiến nhập học:</span>
                                    </label>
                                </div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <div>{{ date('d/m/Y', strtotime($abroadApplication->orderItem->estimated_enrollment_time)) }}</div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Loại dịch vụ:</span>
                                    </label>
                                </div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <div>{{ $abroadApplication->orderItem->abroadService ? $abroadApplication->orderItem->abroadService->name : '--' }}</div>

                                    
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Chương trình dự kiến:</span>
                                    </label>
                                </div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <div>
                                        {{ $abroadApplication->orderItem->plan_apply}}
                                    </div>
                                </div>
                            </div>
                            
                        </div>



                    </div>
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