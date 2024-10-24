@extends('layouts.main.popup')

@section('title')
Thêm khách hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\Hk\ContactController::class, 'store']) }}"
        method="post"  enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        @include('hk.contacts._form', [
            'formId' => $formId,
        ])
        
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button form-control="save" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
        
    $(function() {
        ContactsCreate.init();
    });

    var ContactsCreate = function() {
        var form;
        var btnSubmit;
        var popup;
        // var $marketingSourceSub = $('#sub_channel');

        // let marketingSourceElement = document.getElementById('channel');
        // let marketingSourceSubElement = document.getElementById('sub_channel');
        // const marketingSourceSubValue = "{{ $contact->sub_channel }}";

        // const loadSourceSubs = () => {
        //     let marketingSourceSubs = @json(config('marketingSourceSubs'));
        //     let marketingSourceSelected = marketingSourceElement.value; 

        //     while(marketingSourceSubElement.options.length > 1) {
        //         marketingSourceSubElement.remove(1);
        //     };

        //     if(marketingSourceSelected) {
        //         marketingSourceSubs[marketingSourceSelected].forEach(value => {
        //             let option = document.createElement('option');
        //             option.value = value;
        //             option.textContent = value;

        //             if(marketingSourceSubValue && marketingSourceSubValue == value) {
        //                 option.selected = true;
        //             };
                    
        //             marketingSourceSubElement.appendChild(option);
        //         });
        //     };
        // };

        // loadSourceSubs();

        var handleFormSubmit = () => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                submit();
            });
        }

        // $('[list-action="marketing-source-select"]').on('change', function() {
        //     loadSourceSubs();
        //     });

        var submit = () => {
            // Lấy dữ liệu từ biểu mẫu.
            var data = $(form).serialize();
            var url = form.getAttribute('action');
            // Thêm hiệu ứng
            addSubmitEffect();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,

            }).done(function(response) {
                // hide popup
                popup.hide();

                removeSubmitEffect();
                
                // success alert
                ASTool.alert({
                    message: response.message,
                    ok: function() {
                        if (typeof(ContactsList) !== 'undefined') {
                            // reload list
                            ContactsList.getList().load();
                        }
                    }
                });

                // success callback
                if (typeof(popup.success) !== 'undefined') {
                    popup.success(response);
                }
            }).fail(function(response) {
                popup.setContent(response.responseText);

                // fail callback
                if (typeof(popup.fail) !== 'undefined') {
                    popup.fail(response);
                }
            });
        }

        var addSubmitEffect = () => {
            // btn effect
            btnSubmit.setAttribute('data-kt-indicator', 'on');
            btnSubmit.setAttribute('disabled', true);
        }

        var removeSubmitEffect = () => {
            // btn effect
            btnSubmit.removeAttribute('data-kt-indicator');
            btnSubmit.removeAttribute('disabled');
        }

        return {
            init: function() {
                form = document.getElementById('{{ $formId }}');
                btnSubmit = form.querySelector('[form-control="save"]');
                popup = window.popups[$(form).closest('.modal').attr('id')];

                handleFormSubmit();
            }
        }
    }();
    </script>
@endsection