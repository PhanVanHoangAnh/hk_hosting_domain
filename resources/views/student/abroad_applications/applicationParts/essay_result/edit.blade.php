@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa kết quả chấm luận
@endsection

@php
    $editEssayResultPopup = 'editEssayResultPopup_' . uniqid();
@endphp

@section('content')
<div>
    <form id="{{ $editEssayResultPopup }}" method="POST" tabindex="-1" enctype="multipart/form-data" 
        action="{{ action([App\Http\Controllers\Student\AbroadController::class, 'updateEssayResult'], ['id' => $essayResult->id]) }}">
        @csrf   
        <div class="pe-7 py-5   px-lg-17">
            <div class="row py-3">
                <div class="col-md-6 fv-row"> 
                    <input type="hidden" name="abroad_application_id" value="{{ $essayResult->abroad_application_id }}"/>
                    <label class="required fs-6 fw-semibold mb-2">Trường</label>
                    <select class="form-select form-control mb-7 " data-placeholder="Chọn trường"
                     data-control="select2" name="school_id"  data-dropdown-parent ="#{{ $editEssayResultPopup }}" required >
                        <option value="">Chọn trường </option> 
                            @foreach($abroadApplication->applicationSchools as $applicationSchool)
                            <option value="{{ $applicationSchool->school_id }}" {{ isset($essayResult) && $essayResult->school_id == $applicationSchool->school_id  ? 'selected' : ''}}>
                                {{ $applicationSchool->school->name }}
                            </option>
                        @endforeach

                        </select>
                    <x-input-error :messages="$errors->get('school_id')" class="mt-2" />

                    <label class="required fs-6 fw-semibold mb-2">Nội dung bài luận</label>        
                    <input type="amount" class="form-control mb-7  @if ($errors->has('content')) is-invalid @endif"
                        placeholder="" name="content" value="{{ isset($essayResult->content) ? $essayResult->content : '' }}" />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />


                    <label class="required fs-6 fw-semibold mb-2">Số từ</label>
                    <input type="amount" class="form-control mb-7  @if ($errors->has('word_count')) is-invalid @endif"
                        placeholder="" name="word_count" value="{{ isset($essayResult->word_count) ? $essayResult->word_count : '' }}" />
                    
                    <x-input-error :messages="$errors->get('word_count')" class="mt-2" />

                    <label class="required fs-6 fw-semibold mb-2">Phân loại</label>
                    
                    <select class="form-select form-control mb-7 " data-placeholder="Phân loại" data-control="select2" name="classification" required >
                        <option value="">Phân loại</option>
                        <option value="primary" {{ isset($essayResult) && $essayResult->classification == 'primary' ? 'selected' : '' }}>Chính</option>  
                        <option value="secondary" {{ isset($essayResult) && $essayResult->classification == 'secondary' ? 'selected' : '' }}>Phụ</option>  
                    </select>
                    <x-input-error :messages="$errors->get('classification')" class="mt-2" />

                </div>

                <div class="col-md-6 fv-row">
                    <label class="required fs-6 fw-semibold mb-2">Quality of Content </label>
                    
                    <select class="form-select form-control mb-7 " data-placeholder="Quality of Content" data-control="select2" name="quality_of_content" required >
                        <option value="">Quality of Content</option>
                        <option value="Exceptional" {{ isset($essayResult) && $essayResult->quality_of_content == 'Exceptional' ? 'selected' : '' }}>Exceptional</option>  
                        <option value="Strong" {{ isset($essayResult) && $essayResult->quality_of_content == 'Strong' ? 'selected' : '' }}>Strong</option>  
                        <option value="Promising" {{ isset($essayResult) && $essayResult->quality_of_content == 'Promising' ? 'selected' : '' }}>Promising</option>  
                        <option value="Developing" {{ isset($essayResult) && $essayResult->quality_of_content == 'Developing' ? 'selected' : '' }}>Developing</option>  
                    </select>
                    <x-input-error :messages="$errors->get('quality_of_content')" class="mt-2" />

                    <label class="required fs-6 fw-semibold mb-2">Execution </label>
                    
                    <select class="form-select form-control mb-7 " data-placeholder="Execution" data-control="select2" name="execution" required >
                        <option value="">Execution</option>
                        <option value="Exceptional" {{ isset($essayResult) && $essayResult->execution == 'Exceptional' ? 'selected' : '' }}>Exceptional</option>  
                        <option value="Strong" {{ isset($essayResult) && $essayResult->execution == 'Strong' ? 'selected' : '' }}>Strong</option>  
                        <option value="Promising" {{ isset($essayResult) && $essayResult->execution == 'Promising' ? 'selected' : '' }}>Promising</option>  
                        <option value="Developing" {{ isset($essayResult) && $essayResult->execution == 'Developing' ? 'selected' : '' }}>Developing</option>  
                    </select>
                    <x-input-error :messages="$errors->get('execution')" class="mt-2" />

                    <label class="required fs-6 fw-semibold mb-2">Personal Voice </label>
                
                    <select class="form-select form-control mb-7 " data-placeholder="Personal Voice " data-control="select2" name="personal_voice" required >
                        <option value="">Personal Voice </option>
                        <option value="Exceptional" {{ isset($essayResult) && $essayResult->personal_voice == 'Exceptional' ? 'selected' : '' }}>Exceptional</option>  
                        <option value="Strong" {{ isset($essayResult) && $essayResult->personal_voice == 'Strong' ? 'selected' : '' }}>Strong</option>  
                        <option value="Promising" {{ isset($essayResult) && $essayResult->personal_voice == 'Promising' ? 'selected' : '' }}>Promising</option>  
                        <option value="Developing" {{ isset($essayResult) && $essayResult->personal_voice == 'Developing' ? 'selected' : '' }}>Developing</option>  
                    </select>
                    <x-input-error :messages="$errors->get('personal_voice')" class="mt-2" />

                    <label class="required fs-6 fw-semibold mb-2">Overall </label>
            
                    <select class="form-select form-control mb-7 " data-placeholder="Overall" data-control="select2" name="overall" required >
                        <option value="">Overall</option>
                        <option value="Exceptional" {{ isset($essayResult) && $essayResult->overall == 'Exceptional' ? 'selected' : '' }}>Exceptional</option>  
                        <option value="Strong" {{ isset($essayResult) && $essayResult->overall == 'Strong' ? 'selected' : '' }}>Strong</option>  
                        <option value="Promising" {{ isset($essayResult) && $essayResult->overall == 'Promising' ? 'selected' : '' }}>Promising</option>  
                        <option value="Developing" {{ isset($essayResult) && $essayResult->overall == 'Developing' ? 'selected' : '' }}>Developing</option>  
                    </select>
                    <x-input-error :messages="$errors->get('overall')" class="mt-2" />

                        
                </div>
                <div>
                    @if (isset($essayResult->path))
                    Nhấn<a href="{{ $essayResult->getPath() }}" download="{{  basename($essayResult->path) }}" class="fw-bold">
                        vào đây
                    </a> để tải tập tin bài luận.
                    @endif
                    <label for="" class="required form-label">Chọn tập tin bài luận</label>
                    <input type="file" class="form-control test-input-file" name="path"  accept=".pdf, .docx, .doc, .txt"/>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    <!--begin::Hint-->
                    <p class="form-text fs-6 small mt-2 mb-0">Dung lượng tối đa của tập tin là <strong>{{ ini_get('upload_max_filesize') }}</strong>.</p>
                    <!--end::Hint-->
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center pb-5 py-7">
            <!--begin::Button-->
            <button data-action="save-edit-btn"  type="submit" class="btn btn-primary me-2">
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

</div>

<script>
     $().ready(() => {
        EditEssayResult.init();
        // UpdatePopupEssayResult.init();
    });

    // var UpdatePopupEssayResult = (function() {
    //     var updatePopup;

    //     return {
    //         init: function() {
    //             updatePopup = new Popup();
    //         },
    //         updateUrl: function(newUrl) {
    //             updatePopup.url = newUrl;
    //             updatePopup.load();
    //         },
    //         getUpdatePopup: function() {
    //             return updatePopup;
    //         }
    //     };
    // })();

    var EditEssayResult = function() {
        let form;
        let submitBtn;

        const handleFormSubmit = () => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                submit();
            });
        };

        const submit = () => {
            var formData = new FormData(form); 
            var input = $(form).find('input[type=file]'); 
            var file = input[0].files[0]; 
 
            if (file) {
                formData.append('path', file); 
            }

            var url = form.getAttribute('action');
            
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
            }).done(response => {
                    
                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        UpdatePopupEssayResult.getUpdatePopup().hide();
                        UpdatePopupEssay.getUpdatePopup().load();
                    }
                });
            }).fail(message => {
                removeSubmitEffect();
            });
        };

        const addSubmitEffect = () => {
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.setAttribute('disabled', true);
        };

        const removeSubmitEffect = () => {
            submitBtn.removeAttribute('data-kt-indicator');
            submitBtn.removeAttribute('disabled');
        };

        return {
            init: () => {
                form = document.querySelector("#{{$editEssayResultPopup}}");
                submitBtn = document.querySelector('[data-action="save-edit-btn"]');
                handleFormSubmit();
            }
        };
    }();
</script>
@endsection