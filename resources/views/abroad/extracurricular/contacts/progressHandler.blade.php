<div id="percentage-bar">
    <div id="progress" class="progress-bar"></div>
    <div id="percentage-label" class="fw-bold my-2">0%</div>

    <div class="mt-3 ">
        <div class="mb-2 form-label">Đã xử lý:<span id="total-label"></span></div>
        <div class="mb-2 form-label">Cập nhật thành công:<span id="updated-contacts-count"
                class="d-none">{{ $updatedContactsCount }}
            </span>
        </div>

        <div class="mb-2 form-label">Thêm mới thành công: <span id="new-contacts-count"
                class="d-none">{{ $newContactsCount }}
            </span>
        </div>

        <div class="mb-2 form-label">Lỗi:<span id="error-count" class="d-none">{{ $errorsCount }}
            </span></div>
    </div>
    <div class="d-flex justify-content-end">
        <button class="me-3 btn btn-primary" id="btn-cancel">Hủy</button>
        <button class="btn btn-primary" id="btn-close">Đóng</button>
    </div>

</div>



<style>
    #percentage-bar {
        height: 30px;
        width: 100%;
        background-color: #c3c3c3;
        position: relative;
    }

    #progress {
        width: 0;
        height: 100%;
        background-color: #253F8E;
    }

    #percentage-label {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        line-height: 20px;
    }
</style>
<script>
    var intervalId;

    function updatePercentage() {
        var closeButton = $('#btn-close');
        var cancelButton = $('#btn-cancel');
        // Biến để lưu trữ ID của interval

        var progressBar = $('#progress');
        var percentageLabel = $('#percentage-label');
        var handlePercentage100 = () => {
            $('#updated-contacts-count').removeClass('d-none');
            $('#new-contacts-count').removeClass('d-none');
            $('#error-count').removeClass('d-none');
            cancelButton.addClass('d-none');
            // Thay đổi màu nền của thanh tiến trình thành màu đỏ
            progressBar.css('background-color', '#67E330');
            // Dừng setInterval nếu giá trị đạt 100
            clearInterval(intervalId);
            ContactsList.getList().load();
        }


        // Gửi yêu cầu AJAX để lấy giá trị $percentage từ controller
        $.ajax({
            url: "{{ action([App\Http\Controllers\HubSpotController::class, 'percentage']) }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                const percentage = response.percentage;
                const total = response.total;

                // Cập nhật nội dung của thẻ <span> có id "total-label" với giá trị của biến total
                $('#total-label').text(total);
                progressBar.width(percentage + '%');
                percentageLabel.text(Math.round(percentage) + '%');

                // Kiểm tra nếu giá trị $percentage đạt 100
                if (percentage >= 100) {
                    handlePercentage100();
                }
            },
            error: function(error) {
                throw new Error('Lỗi: ', error);
            }
        });

        closeButton.click(function(e) {
            e.preventDefault(); // Ngăn chặn sự kiện mặc định của nút "Đóng"
            AddContactsHubspot.getPopup().hide();
        });


        cancelButton.click(function(e) {
            e.preventDefault();
            clearInterval(intervalId);
            AddContactsHubspot.getPopup().hide();
        })
    }



    // Bắt đầu interval và lưu ID của interval vào biến intervalId 
    // Gọi hàm updatePercentage để bắt đầu cập nhật giá trị mỗi giây
    intervalId = setInterval(updatePercentage, 1000);
</script>
