<div class="ms-2">
    <div>
        <p class="fs-2 fw-bold fw-semibold">
            <input name="cancelled" value="{{ \App\Models\Section::STATUS_CANCELLED }}" list-action="check-item"
                class="form-check-input mt-1 me-2 deselect-on-cancelled" type="radio" />Có kế hoạch
        </p>
        <p class="fs-2 ms-9">Lớp có kế hoạch nghỉ, không điểm danh, không tính giờ giảng viên còn báo muộn thì điểm danh,
            tính giờ giảng viên. Tự động bổ sung 1 buổi tương tự … dồn vào cuối khóa
        </p>
        <p class="fs-2 fw-bold fw-semibold ">
            <input name="cancelled" list-action="check-item" class="form-check-input mt-1 me-2 deselect-on-cancelled"
                value="{{ \App\Models\Section::STATUS_UNPLANNED_CANCELLED }}" type="radio" />Không kế hoạch
        </p>
        <p class="fs-2 ms-9">Lớp có kế hoạch nghỉ, không điểm danh, không tính giờ giảng viên còn báo muộn thì điểm
            danh,tính giờ giảng viên. Tự động bổ sung 1 buổi tương tự … dồn vào cuối khóa
        </p>
    </div>
    <div class="ms-8 d-none" id="reasonCancelled">
        <p class="fs-2 fw-bold fw-semibold ">
            <input name="unplannedCancelled" value="{{ \App\Models\Section::LATE_CANCELLED_STUDENT }}"
                list-action="check-item" class="form-check-input mt-1 me-2 deselect-on-cancelled unchecked"
                type="radio" />Do
            học viên (trừ giờ học viên)
        </p>
        <p class="fs-2 ms-9">Nghỉ do học viên không tham gia không thể mở buổi học. Không tính lương buổi đó cho giảng
            viên; Nhưng tính late cancel cho giảng viên.
        </p>
        <p class="fs-2 fw-bold fw-semibold ">
            <input name="unplannedCancelled" list-action="check-item"
                class="form-check-input mt-1 me-2 deselect-on-cancelled unchecked"
                value="{{ \App\Models\Section::LATE_CANCELLED_TEACHER }}" type="radio" />Do giảng viên (không tính giờ
            giảng
            viên)

        </p>
        <p class="fs-2 ms-9">Nghỉ do giảng viên không tham gia không thể mở buổi học. Không tính giờ cho học viên và cả
            giảng viên
        </p>

        <label class=" fs-2 fw-bold fw-semibold">
            <span class="">Ghi chú/Lý do</span>
        </label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control delete-on-note" name="note" placeholder="Nhập ghi chú/lý do!" rows="5"
            cols="40"></textarea>
    </div>

</div>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi radio button thay đổi
        $('input[name="cancelled"]').change(function() {
            // Lấy giá trị của radio button được chọn
            var cancelledValue = $(this).val();

            // Ẩn/hiện phần nội dung và thay đổi id tương ứng
            if (cancelledValue === "{{ \App\Models\Section::STATUS_UNPLANNED_CANCELLED }}") {

                $("#reasonCancelled").removeClass("d-none");
            } else {
                $('.unchecked').prop('checked', false);
                $('.delete-on-note').val('');
                $("#reasonCancelled").addClass("d-none");
            }
        });
    });
</script>
