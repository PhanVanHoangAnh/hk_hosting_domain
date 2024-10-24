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
                    <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $teacher->name }}</a>
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
                        </i>Giáo viên {{ trans('messages.role.' . $teacher->type) }}</a>
                   
                </div>
                <!--end::Info-->
            </div>
            <!--end::User-->
            <!--begin::Actions-->
            <div class="d-flex my-4 ms-15 d-none">
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
                                href="{{ action('App\Http\Controllers\Sales\ContactController@edit', ['id' => $teacher->id]) }}"
                                class="menu-link px-3">Chỉnh sửa</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a  row-action="delete" id="buttonDeleteCustom"
                            data-customer-id="{{ $teacher->id }}"
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
                <div class="d-flex flex-wrap d-none">
                    
                    @if ($courses->isNotEmpty())
                        @foreach($courses as $course)
                            <div class="border border-gray-300 border-dashed rounded min-w-200px py-5 me-3 mb-3 profile-stat-box"
                                href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'studyAbroad'], ['id' => $course->id]) }}">
                                
                                <a class=" px-5 rotate collapsible collapsed">
                                    <div class="card-title d-flex flex-column">
                                        <div class="d-flex align-items-center w-200px">
                                            <span class="fs-2 text-uppercase text-gray-800 lh-1 ls-n2 d-inline-block text-truncate">{{$course->code}}</span>             
                                            
                                        </div>
                                        
                                    </div>
                                </a>

                                @php
                                    $totalStudyHours = $course->getTotalStudyHoursForCourse();
                                    $progressBarWidth = ($totalStudyHours != 0)
                                        ? number_format(($course->getStudiedHoursForCourse() / $totalStudyHours) * 100, 1) . '%'
                                        : '0%';
                                @endphp
                                <div class="d-flex align-items-end pt-0 px-5">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column w-100">
                                        <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                            <span class="fw-bolder fs-6 text-dark ">Giờ dạy</span>
                                            <span class="fw-bold fs-6 text-gray-400 "> 
                                                {{ number_format($course->getStudiedHoursForCourse())}} / {{number_format($course->getTotalStudyHoursForCourse())}} Giờ
                                            </span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                            <div class="bg-warning rounded h-8px" role="progressbar" style="width: {{$progressBarWidth  }};"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        
                                       <div id="kt_toggle_block" class="collapse w-100" id="detail">
                                        <hr color="blue" class="w-100"/>
                                        <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                            <span class="fw-bolder fs-6 text-dark ">Giờ học</span>
                                            <span class="fw-bold fs-6 text-gray-400 ">40%</span>
                                        </div>
                                        <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                            <span class="fw-bolder fs-6 text-dark ">Giờ học</span>
                                            <span class="fw-bold fs-6 text-gray-400 ">40%</span>
                                        </div>
                                        <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                            <span class="fw-bolder fs-6 text-dark ">Giờ học</span>
                                            <span class="fw-bold fs-6 text-gray-400 ">40%</span>
                                        </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @elseif ($sectionCourses->isNotEmpty())
                            @foreach($sectionCourses as $sectionCourse)
                                <div class="border border-gray-300 border-dashed rounded min-w-200px py-5 me-3 mb-3 profile-stat-box"
                                >
                                    
                                    <a class=" px-5 rotate collapsible collapsed">
                                        <div class="card-title d-flex flex-column">
                                            <div class="d-flex align-items-center w-200px">
                                                <span class="fs-2 text-uppercase text-gray-800 lh-1 ls-n2 d-inline-block text-truncate">{{$sectionCourse->course->code}}</span>             
                                                
                                            </div>
                                            
                                        </div>
                                    </a>

                                    @php
                                        $totalStudyHours = $sectionCourse->course->getTotalStudyHoursForCourse();
                                        $progressBarWidth = ($totalStudyHours != 0)
                                            ? number_format(($sectionCourse->course->getStudiedHoursForCourse() / $totalStudyHours) * 100, 1) . '%'
                                            : '0%';
                                    @endphp
                                    <div class="d-flex align-items-end pt-0 px-5">
                                        <!--begin::Progress-->
                                        <div class="d-flex align-items-center flex-column w-100">
                                            <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                                <span class="fw-bolder fs-6 text-dark ">Giờ dạy</span>
                                                <span class="fw-bold fs-6 text-gray-400 "> 
                                                    {{ number_format($sectionCourse->course->getStudiedHoursForCourse())}} / {{number_format($sectionCourse->course->getTotalStudyHoursForCourse())}} Giờ
                                                </span>
                                            </div>
                                            <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                                <div class="bg-warning rounded h-8px" role="progressbar" style="width: {{$progressBarWidth  }};"
                                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            
                                        <div id="kt_toggle_block" class="collapse w-100" id="detail">
                                            <hr color="blue" class="w-100"/>
                                            <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                                <span class="fw-bolder fs-6 text-dark ">Giờ học</span>
                                                <span class="fw-bold fs-6 text-gray-400 ">40%</span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                                <span class="fw-bolder fs-6 text-dark ">Giờ học</span>
                                                <span class="fw-bold fs-6 text-gray-400 ">40%</span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100 mt-5 mb-2">
                                                <span class="fw-bolder fs-6 text-dark ">Giờ học</span>
                                                <span class="fw-bold fs-6 text-gray-400 ">40%</span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    
                                </div>
                        @endforeach
                        
                        @else
                            <span class="fs-6 text-gray-800 me-2">
                                Chưa có lớp học
                            </span>
                        @endif
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
        CustomerEditInline.init();
    });

    var CustomerEditInline = function() {
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