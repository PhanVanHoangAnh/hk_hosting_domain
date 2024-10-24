@extends('hk.site.layouts.main.app', [
    'menu' => 'internal',
])

@section('content')
<div class="container my-5">
    <div class="row text-center mb-5">
        <div class="col-md-12 mb-5">
            <h2 class="display-5 text-primary text-uppercase fw-bold letter-spacing">Kiểm Tra Và Đăng Ký Tên Miền Ngay Hôm Nay</h2>
            <p class="text-muted fs-5 fst-italic mb-0">Tìm tên miền hoàn hảo cho doanh nghiệp hoặc thương hiệu cá nhân của bạn</p>
        </div>

        <div class="col-md-8 mx-auto" data-form="search-domain">
            <div class="row py-3">
                <div class="col-md-12">
                    <input type="search" data-action="search-input" class="form-control py-4" placeholder="Nhập tên miền bạn cần tại đây" />
                </div>
            </div>

            <div data-form="validation">
                {{-- VALID --}}
                <div data-control="valid-form" class="">
                    <span class="fw-bold text-success">Tuyệt vời! Bạn có thể đăng ký với tên miền này</span>
                    <div class="row d-flex justify-content-between mt-3 align-items-center">
                        <div class="col-md-3">
                            <span style="font-weight: bold">phanhoanganh.net</span>
                        </div>
                        
                        <div class="col-md-3">
                            <span>1 năm</span>
                        </div>
                
                        <div class="col-md-3">
                            <span>249.000 vnđ</span>
                        </div>
                
                        <div class="col-md-3">
                            <button class="btn btn-success">Chọn mua</button>
                        </div>
                    </div>
                </div>
    
                {{-- INVALID --}}
                <div data-control="invalid-form">
                    <span class="fw-bold text-danger" data-control="error-text">Domain đã được đăng ký</span>
                </div>
            </div>

            <hr>

            <div style="padding: 20px">
                <style>
                    .row-separator {
                        border-bottom: 1px solid #dee2e6;
                        padding: 10px 0;
                    }
                
                    .row-separator:not(:last-child) {
                        border-bottom: 1px solid #dee2e6;
                    }
                </style>

                <div class="mt-2">
                    <div class="row mb-3">
                        <span class="fw-bold text-dark fs-3" style="font-weight: bold">Gợi ý dành cho bạn:</span>
                    </div>

                    <div class="row d-flex justify-content-between my-auto align-items-center row-separator">
                        <div class="col-md-3">
                            <span style="font-weight: bold">phanhoanganh.net</span>
                        </div>
                        
                        <div class="col-md-3">
                            <span>1 năm</span>
                        </div>
                
                        <div class="col-md-3">
                            <span>249.000 vnđ</span>
                        </div>
                
                        <div class="col-md-3">
                            <button class="btn btn-info">Chọn mua</button>
                        </div>
                    </div>
                
                    <div class="row d-flex justify-content-between my-auto align-items-center row-separator">
                        <div class="col-md-3">
                            <span style="font-weight: bold">exampledomain.com</span>
                        </div>
                        
                        <div class="col-md-3">
                            <span>2 năm</span>
                        </div>
                
                        <div class="col-md-3">
                            <span>299.000 vnđ</span>
                        </div>
                
                        <div class="col-md-3">
                            <button class="btn btn-info">Chọn mua</button>
                        </div>
                    </div>
                
                    <div class="row d-flex justify-content-between my-auto align-items-center row-separator">
                        <div class="col-md-3">
                            <span style="font-weight: bold">anotherdomain.com</span>
                        </div>
                        
                        <div class="col-md-3">
                            <span>3 năm</span>
                        </div>
                
                        <div class="col-md-3">
                            <span>399.000 vnđ</span>
                        </div>
                
                        <div class="col-md-3">
                            <button class="btn btn-info">Chọn mua</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(() => {
                new DomainSearchManager({
                    container: $('[data-form="search-domain"]')
                });
            });

            var ValidationBox = class {
                constructor(options) {
                    this.container = options.container;
                }

                hideAll() {
                    this.hideValidForm();
                    this.hideInvalidForm();
                }

                getValidForm() {
                    return this.container.find('[data-control="valid-form"]')
                }

                getInvalidForm() {
                    return this.container.find('[data-control="invalid-form"]')
                }

                getErrorTextForm() {
                    return this.getInvalidForm().find('[data-control="error-text"]');
                }

                setErrorText(text) {
                    this.getErrorTextForm().html(text);
                }

                hideValidForm() {
                    this.getValidForm().hide();
                }

                showValidForm() {
                    this.getValidForm().show();
                }

                hideInvalidForm() {
                    this.getInvalidForm().hide();
                }

                showInValidForm() {
                    this.getInvalidForm().show();
                }

                handleValid() {
                    this.hideInvalidForm();
                    this.showValidForm();
                }

                handleInvalid() {
                    this.hideValidForm();
                    this.showInValidForm();
                }
            }
        
            var DomainSearchManager = class {
                constructor(options) {
                    this.container = options.container;
                    this.validationBox = new ValidationBox({
                        container: $('[data-form="validation"]')
                    });

                    this.validationBox.hideAll();
                    this.events();
                }

                getSearchInput() {
                    return this.container.find('[data-action="search-input"]');
                }
        
                getSearchValue() {
                    return this.getSearchInput().val();
                }
        
                debounce(func, delay) {
                    let timeout;
                    return function (...args) {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(this, args), delay);
                    };
                }

                search() {
                    const value = this.getSearchValue();

                    if (value == "") {
                        this.validationBox.setErrorText("")
                        this.validationBox.hideAll();
                    } else {
                        $.ajax({
                            url: "{{ action([App\Http\Controllers\Hk\DomainController::class, 'searchDomain']) }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                value: value
                            }
                        }).done(res => {    
                            this.validationBox.handleValid();
                        }).fail(res => {
                            const errorText = JSON.parse(res.responseText).message;
                            this.validationBox.setErrorText(errorText)
                            this.validationBox.handleInvalid();
                        })
                    }
                }
        
                events() {
                    const debouncedLog = this.debounce((value) => {
                        this.search();
                    }, 500);
        
                    this.getSearchInput().on('input', e => {
                        e.preventDefault();
                        const value = this.getSearchValue();
                        debouncedLog(value);
                    });
                }
            }
        </script>

        <div class="col-md-12 mt-5">
            <div class="row d-flex justify-content-around">
                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.vn</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.com</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.net</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.org</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.edu</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.au</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.ha</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>

                <button class="btn btn-outline-secondary text-dark fw-semibold col-md-2 mx-4 my-2 badge badge-info border-0 py-2">
                    <span class="badge badge-info fw-bold" style="font-size: 15px">.us</span>&nbsp;
                    <span class="text-white badge badge-info fw-bold" style="font-size: 15px">500.000 VND</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Support, Easy Management, Quality Commitment -->
    <div class="row text-center my-5">
        <div class="col-md-4">
            <div class="card shadow-sm py-4 border-0 rounded">
                <div class="card-body">
                    <i class="bi bi-headset fs-1 text-primary"></i>
                    <h3 class="fw-bold mt-3">Hỗ Trợ 24/7</h3>
                    <p class="text-muted">Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm py-4 border-0 rounded">
                <div class="card-body">
                    <i class="bi bi-gear fs-1 text-primary"></i>
                    <h3 class="fw-bold mt-3">Quản Lý Dễ Dàng</h3>
                    <p class="text-muted">Quản lý tên miền với giao diện đơn giản và trực quan.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm py-4 border-0 rounded">
                <div class="card-body">
                    <i class="bi bi-patch-check fs-1 text-primary"></i>
                    <h3 class="fw-bold mt-3">Cam Kết Chất Lượng</h3>
                    <p class="text-muted">Chúng tôi đảm bảo tên miền của bạn luôn hoạt động ổn định.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Domain Name Tips Section -->
    <div class="row my-5">
        <div class="col-md-6">
            <h4 class="text-primary fw-bold">Cách Chọn Tên Miền Phù Hợp</h4>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Chọn tên dễ nhớ, dễ đọc.</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Chọn tên phù hợp với thương hiệu.</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Giữ cho tên miền ngắn gọn.</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Chỉ bao gồm chữ cái và số.</li>
            </ul>
        </div>
        <div class="col-md-6">
            <img src="/hk/site/assets/img/domain/choose_domain.png" class="img-fluid rounded shadow-sm" alt="Domain Name Tips Image">
        </div>
    </div>

    <!-- Website Building Form Section -->
    <div class="row my-5 align-items-center">
        <div class="col-md-6">
            <img src="/hk/site/assets/img/domain/buid_web.svg" class="img-fluid rounded shadow-sm" alt="Website Building Image">
        </div>
        <div class="col-md-6">
            <h4 class="text-primary fw-bold">Bạn Cần Xây Dựng Website?</h4>
            <p class="text-muted">Đội ngũ thiết kế sẽ giúp bạn xây dựng website hiệu quả và tiết kiệm chi phí.</p>
            <form class="shadow-sm p-4 bg-light rounded">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Họ tên" />
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="SĐT" />
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email" />
                </div>
                <button type="submit" class="btn btn-warning w-100">Gửi Thông Tin</button>
            </form>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row my-5">
        <div class="col-md-12">
            <h4 class="text-primary fw-bold">Câu Hỏi Thường Gặp</h4>
            <ul class="list-group">
                <li class="list-group-item">Tên miền do ai quản lý?</li>
                <li class="list-group-item">Ai có thể đăng ký tên miền?</li>
                <li class="list-group-item">Thông tin tên miền của tôi sẽ được công khai?</li>
                <li class="list-group-item">Tôi có thể chia sẻ tên miền khác sau khi đã đăng ký?</li>
                <li class="list-group-item">Phải làm gì khi tên miền đã định đăng ký đã có người đăng ký trước?</li>
            </ul>
        </div>
    </div>
</div>
@endsection
