@extends('layouts.main.popup')

@section('title')
    Thêm trường đỗ
@endsection
@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')

    <form id="{{ $formId}}"  method="POST" tabindex="-1" enctype="multipart/form-data" 
        action="{{ action(
            [App\Http\Controllers\Abroad\AbroadController::class, 'doneApplicationAdmittedSchool'],
            [
                'id' => $abroadApplication->id,
            ],
        ) }}">
       @csrf   
        <div class="pe-7 py-5   px-lg-17">
            <input type="hidden" name="abroad_application_id" value="{{ $abroadApplication->id }}">
            <div class="row py-3">
                <div class="col-md-12 fv-row ">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Trường học</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select form-control " data-placeholder="Chọn trường"
                    data-allow-clear="true" data-control="select2" name="school_id"  data-dropdown-parent ="#{{ $formId }}" required >
                    <option value="">Chọn trường </option>
                        @foreach($abroadApplication->applicationSchools as $applicationSchool)
                            <option value="{{ $applicationSchool->school_id }}"> {{ $applicationSchool->school->name }} </option>
                        @endforeach
                
                    </select>
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                </div>
            </div>
            <div class="row py-3">
               

                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Học bổng</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input  placeholder="Nhập học bổng đạt được!" class="form-control "
                        placeholder="" name="scholarship" value="" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('scholarship')" class="mt-2" />

                </div>
            </div>
           
            
        </div>

        <div class="d-flex justify-content-center pb-5 py-7">
            <!--begin::Button-->
            <button data-action="save-create-btn"  type="submit" class="btn btn-primary me-2">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>


    </form>


<script>
    $(() => {
        CreateApplicationAdmittedSchool.init();
    })

    var CreateApplicationAdmittedSchool = function() {
        let form;
        let submitBtn;

        const handleFormSubmit = () => {

            form.addEventListener('submit', e => {

                e.preventDefault();

                submit();
            })
        }
        

        submit = () => {
            var formData = new FormData(form); 
            const csrfToken = '{{ csrf_token() }}';
            
            formData.append('_token', csrfToken);

            var url = form.getAttribute('action');
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false
            }).done(response => {
                UpdatePopup.getUpdatePopup().hide();
                // success alert
                ASTool.alert({
                    message: response.message,
                    ok: function() {
                        applicationAdmittedSchool.load();
                    }
                });
            }).fail(message => {
                removeSubmitEffect();
            });
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

        

        return {
            init: () => {

                form = document.querySelector("#{{$formId}}");
                submitBtn = document.querySelector("[data-action='save-create-btn']");

                handleFormSubmit();
            }
        }
    }();
</script>
@endsection