@extends('layouts.main.popup')

@section('title')
    Xóa tags của đơn hàng đã chọn
@endsection

@section('content')
    <form id="DeleteTagsForm">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_contact_header"
            data-kt-scroll-wrappers="#kt_modal_add_contact_scroll" data-kt-scroll-offset="300px">
            <!--begin::Input group-->
            <!--end::Input group-->
            <div class="fv-row ">
                <label class="fs-6 fw-semibold mb-2 ">Danh sách đơn hàng </label>
                <div class="table-responsive">
                    <table class="table  table-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Tên đơn hàng</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactRequests as $contactRequest)
                                <input type="hidden" name="contact_request_id[]" value="{{ $contactRequest->id }}">
                                <tr>
                                    <td> {{ $contactRequest->contact->name }}</td>
                                    <td>{{ $contactRequest->contact->email }}</td>
                                    <td>{{ $contactRequest->contact->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="DeleteTagsSubmitButton" type="submit" class="btn btn-danger">
                <span class="indicator-label">Xóa tags</span>
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
            DeleteTags.init();
        });

        var DeleteTags = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var data = $(form).serialize();
                addSubmitEffect();

                $.ajax({
                    url: '/sales/contact_requests/action-delete-tags',
                    method: 'DELETE',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    // hide popup
                    DeleteTagsPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                        }
                    });

                }).fail(function(response) {


                    // 
                    // hide popup
                    DeleteTagsPopup.getPopup().hide();
                    removeSubmitEffect();
                });
            }

            addSubmitEffect = () => {
                // btn effect
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                // btn effect
                btnSubmit.removeAttribute('data-kt-indicator');
                btnSubmit.removeAttribute('disabled');
            }

            return {
                init: function() {
                    form = document.getElementById('DeleteTagsForm');
                    btnSubmit = document.getElementById('DeleteTagsSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
