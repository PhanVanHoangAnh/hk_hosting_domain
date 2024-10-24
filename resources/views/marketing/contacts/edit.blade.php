@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thông tin liên hệ
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}"
        action="{{ action(
            [App\Http\Controllers\Marketing\ContactController::class, 'update'],
            [
                'id' => $contact->id,
            ],
        ) }}">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7 py-10 px-lg-17">
            <!--begin::Input group-->
            <input type="hidden" name="contact_id" value="{{ $contact->id }}" />

            @include('marketing.contacts._form', [
                'formId' => $formId,
            ])

        </div>
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
            ContactsUpdate.init();
        });

        var ContactsUpdate = function() {
            var form;
            var btnSubmit;
            // const marketingSourceSubValue = "{{ $contact->sub_channel }}";

            // const loadSourceSubs = () => {
            //     let marketingSourceElement = document.getElementById('channel');
            //     let marketingSourceSubElement = document.getElementById('sub_channel');
            //     let marketingSourceSubs = @json(config('marketingSourceSubs'));
            //     let marketingSourceSelected = marketingSourceElement.value;

            //     while (marketingSourceSubElement.options.length > 1) {
            //         marketingSourceSubElement.remove(1);
            //     };

            //     if (marketingSourceSelected) {
            //         marketingSourceSubs[marketingSourceSelected].forEach(value => {
            //             let option = document.createElement('option');
            //             option.value = value;
            //             option.textContent = value;

            //             if (marketingSourceSubValue && marketingSourceSubValue == value) {
            //                 marketingSourceSubElement.options.forEach(optionVal => {
            //                     if (optionVal.selected == true) {
            //                         !optionVal.selected;
            //                     };
            //                 });

            //                 option.selected = true;
            //             };

            //             marketingSourceSubElement.appendChild(option);
            //         });
            //     };

            // };

            // loadSourceSubs();

            var handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    submit();
                });
            };

            // $('[list-action="marketing-source-select"]').on('change', function() {
            //     loadSourceSubs();
            // });

            var submit = () => {
                var contactIdInput = form.querySelector('input[name="contact_id"]');
                var contactId = contactIdInput.value;
                var data = $(form).serialize();
                var url = form.getAttribute('action');
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    // UpdateContactPopup.getPopup().hide();
                    // popupEditContact

                    if (typeof(UpdateContactPopup) !== 'undefined') {
                        UpdateContactPopup.getPopup().hide();
                    }

                    removeSubmitEffect();
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            if (typeof ContactsList !== 'undefined') {
                                ContactsList.getList().load();
                            }

                            // success callback
                            if (typeof(ContactsUpdate.success) !== 'undefined') {
                                ContactsUpdate.success(response);
                            }

                        }
                    });
                    // UpdateContactPopup.getPopup().show();
                }).fail(function(response) {
                    if (typeof(UpdateContactPopup) !== 'undefined') {
                        UpdateContactPopup.getPopup().setContent(response.responseText);
                    }
                    // removeSubmitEffect();
                    // fail callback
                    if (typeof(ContactsUpdate.fail) !== 'undefined') {
                        ContactsUpdate.fail(response);
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

            function reloadShowView(contactId) {
                var data = $(form).serialize();
                $.ajax({
                    url: "{{ action('App\Http\Controllers\Marketing\ContactController@show', ['id' => $contact->id]) }}",
                    method: 'GET',
                    data: data,
                }).done(function(refresh) {
                    var newData = $("#ContactsInformation", data)
                    $("#ContactsInformation").html(newData);
                    location.reload();
                }).fail(function(response) {
                    // Handle the error
                    throw new Error("sdfsed")
                });
            }

            return {
                init: function() {
                    form = document.getElementById('{{ $formId }}');
                    btnSubmit = form.querySelector('[form-control="save"]');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
