@extends('layouts.main.popup')

@section('title')
    Đóng phí hồ sơ
@endsection
@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')

    <form id="{{ $formId}}" method="POST" tabindex="-1" enctype="multipart/form-data" 
        action="{{ action(
            [App\Http\Controllers\Abroad\AbroadController::class, 'doneCreateApplicationFee'],
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
                        @foreach(\App\Models\School::all()  as $school)
                            <option value="{{ $school->id }}"> {{ $school->name }} </option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                </div>
            </div>
            <div class="row py-3">
                <div class="col-md-6 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Deadline</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input data-control="input"  name="deadline" placeholder="=asas" type="date"
                    class="form-control" placeholder="" value="" required />
                    <span data-control="clear" class="material-symbols-rounded clear-button"
                        style="display:none;">close</span>
                </div>
                <x-input-error :messages="$errors->get('deadline')" class="mt-2" />

                <div class="col-md-6 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Số tiền</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="amount" id="amount-input" class="form-control "
                        placeholder="" name="amount" value="" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />

                </div>
            </div>
            <div >
                <label for="" class=" form-label">Chọn tập tin bài luận</label>
                <input type="file" class="form-control test-input-file" name="path"  accept=".pdf, .docx, .doc, .txt"/>
                <x-input-error :messages="$errors->get('path')" class="mt-2" />
                <!--begin::Hint-->
                <p class="form-text fs-6 small mt-2 mb-0">Dung lượng tối đa của tập tin là <strong>{{ ini_get('upload_max_filesize') }}</strong>.</p>
                <!--end::Hint-->
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
        CreateApplicationFee.init();
    })

    var CreateApplicationFee = function() {
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
            const input = $(form).find('input[type=file]')[0];
            const file = input.files[0]; 
            formData.append('_token', csrfToken);

            if (file) {
                formData.append('path', file);
            }

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
                        applicationFee.load();
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