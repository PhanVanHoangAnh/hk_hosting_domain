@extends('hk.site.layouts.main.app', [
    'menu' => 'internal',
])
@section('content')
    <!-- Hero Section -->
    <div class="container my-5">
        <div class="row text-center mb-2">
            <div class="col-md-12 mb-5">
                <h2 class="display-5 font-weight-bold text-uppercase letter-spacing">Lưu trữ chuyên nghiệp</h2>
                <p class="fs-5 fst-italic fw-bolder mb-0">Lựa chọn dịch vụ phù hợp với doanh nghiệp bạn</p>
            </div>
        </div>

        <!-- Support, Easy Management, Quality Commitment -->
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card shadow-sm py-4 border border-dark rounded">
                    <div class="card-body">
                        <a href="{{ action([App\Http\Controllers\Hk\HostingController::class, 'index']) }}" style="text-decoration: none;">
                            <i class="bi bi-headset fs-1 text-primary"></i>
                            <h3 class="fw-bold mt-3 text-primary">Web Hosting</h3>
                            <p class="fw-bold text-dark">Phù hợp lưu trữ website.</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm py-4 border border-dark rounded">
                    <div class="card-body">
                        <a href="{{ action([App\Http\Controllers\Hk\HostingController::class, 'index']) }}" style="text-decoration: none;">
                            <i class="bi bi-gear fs-1 text-primary"></i>
                            <h3 class="fw-bold mt-3 text-primary">Cloud Hosting</h3>
                            <p class="fw-bold text-dark">Phù hợp cho sự án vừa và lớn.</p>
                        </a>                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm py-4 border border-dark rounded">
                    <div class="card-body">
                        <i class="bi bi-patch-check fs-1 text-primary"></i>
                        <h3 class="fw-bold mt-3 text-primary">VPS</h3>
                        <p class="fw-bold text-dark">Môi trường riêng biệt.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 my-5">
            <div class="row d-flex justify-content-around g-0">
                <div class="col-md-4 col-sm-4 mb-2">
                    <button class="btn btn-warning w-100">Đội Ngũ Chuyên Nghiệp</button>
                </div>
                <div class="col-md-4 col-sm-4 mb-2">
                    <button class="btn btn-warning w-100">Hỗ trợ 24/7</button>
                </div>
                <div class="col-md-4 col-sm-4 mb-2">
                    <button class="btn btn-warning w-100">Cam kết 99,9% Online</button>
                </div>
                <div class="col-md-4 col-sm-4 mb-2">
                    <button class="btn btn-warning w-100">Sử dụng phần mềm bản quyền</button>
                </div>
                <div class="col-md-4 col-sm-4 mb-2">
                    <button class="btn btn-warning w-100">Ổ cứng SSD 100%</button>
                </div>
                <div class="col-md-4 col-sm-4 mb-2">
                    <button class="btn btn-warning w-100">Bảo mật cao</button>
                </div>
            </div>
        </div>
        <style>
            .custom-container {
                background-color: #003366;
                /* Màu nền giống như trong hình */
                color: white;
                /* Màu chữ */
                padding: 20px;
                /* Padding xung quanh */
                border-radius: 8px;
                /* Bo góc */
                text-align: center;
                /* Căn giữa chữ */
            }

            .custom-button {
                background-color: #003366;
                /* Màu của nút */
                color: white;
                /* Màu chữ trên nút */
                border: 2px solid white;
                /* Viền màu trắng */
                border-radius: 20px;
                /* Bo góc nút */
                padding: 10px 20px;
                /* Padding cho nút */
                font-weight: bold;
                /* Chữ đậm */
                cursor: pointer;
                /* Hiển thị con trỏ khi hover */
                text-decoration: none;
                /* Xóa gạch chân */
                transition: background-color 0.3s;
                /* Hiệu ứng chuyển đổi màu nền */
            }

            .custom-button:hover {
                background-color: #0056b3;
                /* Màu khi hover */
            }
        </style>

        <!-- Call to Action -->
        <div class="container">
            <div class="custom-container d-flex justify-content-between align-items-center">
                <h3 class="display-6 mb-0">Chúng Tôi Sẽ Giúp Bạn Chọn Gói Phù Hợp Nhất</h3>
                <button class="custom-button" onclick="alert('Đang tư vấn ngay!')">Tư Vấn Ngay</button>
                <!-- Thay <a> bằng <button> -->
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="container my-5">
            <div class="col-md-12">
                <h4 class=" font-weight-bold">Câu Hỏi Thường Gặp</h4>
                <ul class="list-group">
                    <li class="list-group-item">Trung tâm dữ liệu của bạn có an toàn không ?</li>
                    <li class="list-group-item">Tôi có thể nâng cấp gói cao hơn không ?</li>
                    <li class="list-group-item">Dịch vụ có thể chuyển dữ liệu từ server cũ qua không ?</li>
                    <li class="list-group-item">Tôi phải làm gì nếu cần trợ giúp ?</li>
                </ul>
            </div>
        </div>

        <style>
            .custom-bg {
                background-color: #d2effc; /* Màu nền mong muốn */
                font-size: 16px;
                font-style: italic;
            }
        </style>
        <div class="consultation-section bg-light py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="font-weight-bold">BẠN CẦN THIẾT KẾ WEBSITE?</h4>
                        <p class="fst-italic"><em>Đội ngũ chuyên gia của chúng tôi sẽ tư vấn và xây dựng website trọn gói dành cho bạn</em></p>
                        <ul class="list-unstyled">
                            <li class="mb-2">- Miễn phí hosting và tên miền.</li>
                            <li class="mb-2">- Giao diện và chức năng tùy chỉnh.</li>
                            <li class="mb-2">- Dễ dàng quản lý và sử dụng.</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 custom-bg bg-opacity-10 rounded shadow-sm">
                            <p>Vui lòng điền thông tin của bạn để được tư vấn miễn phí.</p>
                            <form>
                                <div class="mb-3">
                                    <input type="text" class="form-control rounded-pill px-3" placeholder="Họ tên" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control rounded-pill px-3" placeholder="SĐT" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control rounded-pill px-3" placeholder="Email" required>
                                </div>
                                <button type="submit" class="btn btn-danger rounded-pill w-100">Tư Vấn Cho Tôi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

@endsection
