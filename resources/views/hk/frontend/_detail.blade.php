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
                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border-4 border-body h-20px w-20px">
            </div>
        </div>
    </div>
    <!--end::Pic-->

    <!--begin::Info-->
    <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
            <!--begin::User-->
            <div id="ContactsInformation" class="col-lg-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-1 text-muted">Họ tên</label>
                    <input class="col-lg-3">

                    <label class="col-lg-1 text-muted" >Mật khẩu</label>
                    <input class="col-lg-3" placeholder="Dùng để đăng nhập">
                </div>
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-1 text-muted">Công ty</label>
                    <input class="col-lg-3">

                    <div class="col-lg-4 d-flex justify-content-end">
                        <a href="" class="text-primary text-decoration-underline">Đổi mật khẩu</a>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-1 text-muted">Điện thoại:</label>
                    <input class="col-lg-3">

                    <label class="col-lg-1 text-muted">Email</label>
                    <input class="col-lg-3" placeholder="Dùng để đăng nhập">
                </div>
                <div class="row mb-7">
                    <label class="col-lg-1 text-muted">Địa chỉ</label>
                    <input class="col-lg-3">
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Info-->
</div>
