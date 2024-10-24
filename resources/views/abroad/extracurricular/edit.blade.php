@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa kế hoạch ngoại khoá
@endsection
@php
    $editExtracurricularSchedule = 'editExtracurricularSchedule_' . uniqid();
@endphp
@section('content')
    <form id="{{ $editExtracurricularSchedule }}"
        action="{{ action(
            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'update'],
            [
                'id' => $extracurricular->id,
            ],
        ) }}">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
            <div class="fv-row mb-7">
                <div class="row  {{$extracurricular->isFinished() ? 'pe-none' : ''}}" >
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 required">
                            <span class="">Tên hoạt động ngoại khoá</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control" value="{{ $extracurricular->name }}" name="name" placeholder="Nhập tên hoạt động ngoại khoá!" type="text" required>
                        <!--end::Input-->

                    </div>
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2" required>
                            <span class="">Loại chương trình</span>
                        </label>
                        <!--end::Label-->
                        
                        <!--begin::Input-->
                        <select list-action="marketing-type-select" class="form-select" data-control="select2" required
                            data-kt-select2="true" data-placeholder="Chọn" name="type_extracurricular">
                            <option value="">Chọn loại chương trình</option>
                            @foreach(config('typeExtracurricular') as $type)
                                {{-- <option value="{{ $type }}" >{{ $type }}</option> --}}
                                <option value="{{ $type }}" {{ isset($extracurricular) && $extracurricular->type == $type? 'selected' : '' }}> {{$type}} </option>  
                            @endforeach
                        </select>
                        
                        <!--end::Input-->

                    </div>
                    
                </div>

                <div class="row  {{$extracurricular->isFinished() ? 'pe-none' : ''}}" >
                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required" >
                            <span class="">Thời điểm bắt đầu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ $extracurricular->start_at }}" name="start_at" id="start_at" required
                                placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required" >
                            <span class="">Thời điểm kết thúc</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ $extracurricular->end_at }}" name="end_at" id="end_at"
                                placeholder="=asas" type="date" class="form-control" required>
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-3">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required" >
                            <span class="">Số giờ dành ra trong tuần</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number"  value="{{$extracurricular->hours_per_week}}" class="form-control " list-action='format-number' name="hours_per_week"  placeholder="Số giờ"
                        required />
                        <!--end::Input-->
                    </div>
                    <div class="col-md-3">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required" >
                            <span class="">Số tuần danh ra trong năm</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number"  value="{{$extracurricular->weeks_per_year}}" class="form-control " list-action='format-number' name="weeks_per_year"  placeholder="Số tuần" required
                        required />
                        <!--end::Input-->
                    </div>
                </div>
                <div class="row  {{$extracurricular->isFinished() ? 'pe-none' : ''}}" >
                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required" >
                            <span class="">Người điều phối</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                       
                        <div class="form-outline">
                            <select name="coordinator" class="form-select form-control" data-placeholder="Chọn nhân viên" required
                                data-allow-clear="false" data-control="select2"  data-dropdown-parent="#{{$editExtracurricularSchedule}}"  >
                                <option value="">Chọn nhân viên</option>
                                @foreach(App\Models\User::byBranch(\App\Library\Branch::getCurrentBranch())->byModule(\App\Library\Module::EXTRACURRICULAR)->get() as $user)
                                    <option value="{{ $user->account->id }}" {{ isset($extracurricular) && $extracurricular->coordinator == $user->account->id? 'selected' : '' }}>{{ $user->account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-3">
                        <label class="required fs-6 fw-semibold mb-2 mt-4" for="study-type-select">Hình thức</label>
                        <select id="study-type-select" class="form-select form-control" name="study_type" required
                            data-control="select2" data-dropdown-parent="#{{ $editExtracurricularSchedule }}" data-placeholder="Chọn hình thức" data-allow-clear="false">
                            <option value="">Chọn hình thức</option>
                            @foreach(config('studyTypes') as $type)
                            <option value="{{ $type }}" {{ isset($extracurricular) && $extracurricular->study_method == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required">
                            <span class="">Số lượng học viên tối đa</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" value="{{$extracurricular->max_student}}"  class="form-control"  list-action='format-number' name="max_student" placeholder="Số lượng học viên tối đa"
                        required />
                    </div>
                    <div class="col-md-3">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required">
                            <span class="">Số lượng học viên tối thiểu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" value="{{$extracurricular->min_student}}" class="form-control"  list-action='format-number' name="min_student" placeholder="Số lượng học viên tối thiểu"
                        required />
                        <!--end::Input-->
                    </div>
                    
                </div>
                <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="required">Địa điểm</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea {{$extracurricular->isFinished() ? 'readonly' : ''}} class="form-control  " name="address" placeholder="Địa điểm ngoại khoá!" rows="2" cols="40" required>{{$extracurricular->address}}</textarea>
                <!--end::Input-->
                <div class="row">
                    <div class="col-md-4">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required">
                            <span class="">Giá gốc</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input  {{$extracurricular->isFinished() ? 'readonly' : ''}} type="text" value="{{$extracurricular->price}}" class="form-control price-input "  list-action='format-number' required name="price" placeholder="Giá gốc"
                        required />
                    </div>
                    <div class="col-md-4">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4 required">
                            <span class="">Chi phí dự kiến</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input  {{$extracurricular->isFinished() ? 'readonly' : ''}} type="text"  value="{{$extracurricular->expected_costs}}" class="form-control price-input" list-action='format-number' name="expected_costs" required placeholder="Giá gốc"
                         />
                        <!--end::Input-->
                    </div>
                    <div class="col-md-4">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="required">Chi phí thực tế</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input {{$extracurricular->isFinished() ? '' : 'readonly'}} type="text"  class="form-control price-input "  value="{{$extracurricular->actual_costs}}" list-action='format-number' name="actual_costs" placeholder="Giá gốc" 
                        />
                        <!--end::Input-->
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Link ảnh</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input {{$extracurricular->isFinished() ? '' : 'readonly'}} class="form-control" name="image_link" value="{{$extracurricular->image_link}}"  placeholder="Nhập link ảnh hoạt động ngoại khoá!" type="text">
                        <!--end::Input-->

                    </div>
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4" >
                            <span class="">Link tài liệu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input {{$extracurricular->isFinished() ? '' : 'readonly'}} class="form-control" name="document_link" value="{{$extracurricular->document_link}}"  placeholder="Nhập link tài liệu hoạt động ngoại khoá!" type="text">
                        <!--end::Input-->

                    </div>
                    
                </div>

                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="">Mô tả</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" value="{{$extracurricular->describe}}" name="describe" placeholder="Mô tả ngoại khoá!" rows="1" cols="40"></textarea>
                <!--end::Input-->

                 <!--begin::Label-->
                 <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="">Link Proposal</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="proposal_link" placeholder="Link Proposal!" rows="1" cols="40">{{ $extracurricular->proposal_link }}</textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('proposal_link')" class="mt-2"/>
               

                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
            
            <div id="error-message-name" class="error-message text-danger" style="display: none;"></div>

        </div>
        <!--end::Scroll-->
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="EditExtracurricularScheduleButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
        $(() => {
            editExtracurricularSchedule.init();
            initializePriceInput();
        })

        function initializePriceInput() {
            const priceInputs = $('.price-input');

            if (priceInputs.length) {
                priceInputs.each(function() {
                    const mask = new IMask(this, {
                        mask: Number,
                        scale: 0,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                    });
                });
            }
        }

        var editExtracurricularSchedule = function() {
            let form;
            let submitBtn;

            function hasInputEditName() {
                const inputPage = form.querySelector('[name="name"]').value;

                return inputPage == '';
            }
            function hasSelectType() {
                const selectType = form.querySelector('[name="type_extracurricular"]').value;
                return selectType == '';
               
            }
            function hasSelectStartAt() {
                const selectType = form.querySelector('[name="start_at"]').value;
                return selectType == '';
               
            }
            function hasSelectEndtAt() {
                const selectType = form.querySelector('[name="end_at"]').value;
                return selectType == '';
               
            }
            function hasSelectCoordinater() {
                const selectType = form.querySelector('[name="coordinator"]').value;
                return selectType == '';
               
            }
            function hasSelectStudyType() {
                const selectType = form.querySelector('[name="study_type"]').value;
                return selectType == '';
               
            }
            function hasSelectAddress() {
                const selectType = document.querySelector('[name="address"]').value;
                return selectType == '';
               
            }
            const handleFormSubmitEdit = () => {
                
                form.addEventListener('submit', e => {
                   
                    e.preventDefault();
                    
                    submit();
                })
            }

            submit = () => {
               
                const formData = $(form).serialize();
                var url = form.getAttribute('action');
                

                if (hasInputEditName()) {
                    const errorContainer = form.querySelector('#error-message-name');
                    if (errorContainer) {
                        errorContainer.textContent = 'Vui lòng điền tên ngoại khoá!';
                        errorContainer.style.display = 'block';
                    }
                    return;
                }

                if (hasSelectType()) {
                    const errorContainer = form.querySelector('#error-message-name');
                    if (errorContainer) {
                        errorContainer.textContent = 'Vui lòng chọn loại chương trình!';
                        errorContainer.style.display = 'block';
                    }
                    return;
                }

                if (hasSelectStartAt()) {
                    const errorContainer = form.querySelector('#error-message-name');
                    if (errorContainer) {
                        errorContainer.textContent = 'Vui lòng chọn thời điểm bắt đầu!';
                        errorContainer.style.display = 'block';
                    }
                    return;
                }

                if (hasSelectEndtAt()) {
                    const errorContainer = form.querySelector('#error-message-name');
                    if (errorContainer) {
                        errorContainer.textContent = 'Vui lòng chọn thời điểm kết thúc!';
                        errorContainer.style.display = 'block';
                    }
                    return;
                }

                if (hasSelectCoordinater()) {
                    const errorContainer = form.querySelector('#error-message-name');
                    if (errorContainer) {
                        errorContainer.textContent = 'Vui lòng chọn người điều phối!';
                        errorContainer.style.display = 'block';
                    }
                    return;
                }

                if (hasSelectStudyType()) {
                    const errorContainer = form.querySelector('#error-message-name');
                    if (errorContainer) {
                        errorContainer.textContent = 'Vui lòng chọn hình thức!';
                        errorContainer.style.display = 'block';
                    }
                    return;
                }
                if (hasSelectAddress()) {
                    const errorContainer = document.getElementById('error-message-name');
                    errorContainer.textContent =
                        'Vui lòng nhập địa chỉ ngoại khóa!';
                    errorContainer.style.display = 'block';
                    return;
                }

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {

                    UpdateExtracurricularPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload();
                            // UpdateStatusActive.getUpdatePopup().load();
                            abroadApplicationsList.getList().load();
                        }
                    });

                }).fail(message => {
                    // UpdatePopup.getUpdatePopup().setContent(message.responseText);
                    removeSubmitEffect();
                })
            }

            addSubmitEffect = () => {

                // btn effect
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {

                // btn effect
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.removeAttribute('disabled');
            }

            deleteUpdatePopup = () => {
                form.removeEventListener('submit', submit);

                editExtracurricularSchedule = null;
            }

            return {
                init: () => {

                    form = document.querySelector('#{{ $editExtracurricularSchedule }}');
                    
                    submitBtn = document.querySelector("#EditExtracurricularScheduleButton");
                  
                    handleFormSubmitEdit();
                }
            }
        }();
    </script>
@endsection
