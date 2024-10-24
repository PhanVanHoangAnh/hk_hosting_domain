@extends('layouts.main.popup')

@section('title')
Báo cáo học tập
@endsection

@php
$formId = 'F' . uniqid();
@endphp

@section('content')
<form method="POST" id="{{ $formId }}" action="{{ action([App\Http\Controllers\Edu\SectionReportsController::class, 'saveReportSection'], ['id' => $section->id, 'contact_id' => $contact->id]) }}">
    @csrf
    <!--begin::Scroll-->
    <div class="pe-7 py-5   px-lg-17">
        @include('edu.report_sections._form', [
                'formId' => $formId,
            ])

    </div>


    <!--end::Scroll-->
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

<script>
    $(function() {
        
        ReportSection.init();
        
    });

    var ReportSection = function() {
        var form;
        var btnSubmit;

        var handleFormSubmit = () => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                submit();
            });
        };

        var submit = () => {
            var data = $(form).serialize();
            var url = form.getAttribute('action');
            addSubmitEffect();

            $.ajax({
                url: url
                , method: 'POST'
                , data: data
            , }).done(function(response) {
               
                removeSubmitEffect();
                ASTool.alert({
                    message: response.message
                    , ok: function() {
                        
                        if (typeof AttendancePopup !== 'undefined') {
                            AttendancePopup.reload();
                        }
                        if (typeof UpdateReportsStudentPopup !== 'undefined') {
                            UpdateReportsStudentPopup.getPopup().hide();
                        }
                        SectionList.getList().load();
                    }
                });

            }).fail(function(response) {
                

                AttendancePopup.getPopup().setContent(response.responseText);
                removeSubmitEffect();

            });
        };

        var addSubmitEffect = () => {
            // btn effect
            btnSubmit.setAttribute('data-kt-indicator', 'on');
            btnSubmit.setAttribute('disabled', true);
        };

        var removeSubmitEffect = () => {
            // btn effect
            btnSubmit.removeAttribute('data-kt-indicator');
            btnSubmit.removeAttribute('disabled');
        };

        return {
            init: function() {
                form = document.getElementById('{{ $formId }}');
                btnSubmit = document.querySelector('[data-action="save-edit-btn"]');
                handleFormSubmit();
            }
        };
    }();

</script>

@endsection

