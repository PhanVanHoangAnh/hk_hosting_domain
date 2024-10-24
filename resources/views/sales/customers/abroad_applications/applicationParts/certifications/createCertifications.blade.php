@extends('layouts.main.popup')

@section('title')
    Thêm mới chứng chỉ
@endsection
@php
    $createCertifications = 'createCertifications_' . uniqid();
@endphp
@section('content')
    <form id="{{ $createCertifications }}"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneCreateCertification'],
            [
                'id' => $id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7 py-10 px-lg-17" >

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Chứng chỉ cần có</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select form-control" data-control="select2" name="certification" id="certification">
                    <option value="">Chọn</option>
                    @foreach(config('certificates') as $certificate)   
                        <option value="{{ $certificate }}">{{ $certificate }}</option>
                    @endforeach
                    <option value="other">Khác</option>
                </select>
                
                <div class="row d-none" data-control="other-certificate" >
                    <div class="col-md-12">
                 
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                                <span class="">Nhập chứng chỉ khác</span>
                            </label>
                        <input class="form-control" name="other_certificate"  id="other_certificate" placeholder="Nhập tên chứng chỉ!" type="text">
                    </div>
                </div>
                
              
                <!--end::Input-->
                <div class="row">
                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Thời điểm cần có</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ date('Y-m-d') }}" name="due_date" id="execution_date"
                                placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Số điểm cần đạt</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control" name="min_score" placeholder="Nhập số điểm cần đạt!" type="number">
                        <!--end::Input-->
                    </div>

                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Số điểm thực tế</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control" name="actual_score" placeholder="Nhập số điểm thực tế!" type="number">
                        <!--end::Input-->
                    </div>

                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Thời điểm có chứng chỉ thực tế</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ date('Y-m-d') }}" name="certified_date"
                                id="execution_date" placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>


                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="">Link tài liệu</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="link" placeholder="Nhập link tài liệu!" rows="1" cols="40"></textarea>
                <!--end::Input-->

                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
            <!--end::Input group-->
            <div id="error-message-certification" class="error-message text-danger" style="display: none;"></div>

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateCertificationsButton" type="submit" class="btn btn-primary">
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
        createCertifications.init();
    })
      

        var createCertifications = function() {
            let form;
            let submitBtn;

            function hasInputCertification() {
                const inputCertification = document.querySelector('[name="certification"]').value;
                if (inputCertification == '') {
                    return inputCertification == '';
                }
                
                if (inputCertification === 'other') {
                    const otherCertificateInput = document.getElementById('other_certificate').value;

                    return otherCertificateInput  =='';
                }
            }

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {
                if (hasInputCertification()) {
                    const errorContainer = document.getElementById('error-message-certification');

                    errorContainer.textContent =
                        'Vui lòng điền tên chứng chỉ cần có!';
                    errorContainer.style.display = 'block';

                    return;
                }

                const formData = $(form).serialize();
                var url = form.getAttribute('action');

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {
                    // success alert
                    CreateCertificationPopup.getUpdatePopup().hide();
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload();
                            certificationsPopup.getPopup().hide();
                            certificationsManager.load();
                        }
                    });

                }).fail(message => {
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

                createCertifications = null;
            }
          
            return {
                init: () => {

                        form = document.querySelector('#{{ $createCertifications }}');
                        submitBtn = document.querySelector("#CreateCertificationsButton");
                    
                        $('[name="certification"]').on('change', function(event) {
                            const selectedValue = $(this).val();
                            
                            if (selectedValue === 'other') {
                                $('[data-control="other-certificate"]').removeClass('d-none');
                            } else {
                                $('[data-control="other-certificate"]').addClass('d-none');
                            }
                        });

                        handleFormSubmit();
                    }
                }
        }();
    </script>
@endsection
