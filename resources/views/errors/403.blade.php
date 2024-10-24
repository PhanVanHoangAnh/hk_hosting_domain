<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.main._head')

    @yield('head')
</head>
<body>
    <!-- Error 404 Template 1 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="text-center">
                <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
                <span class="display-1 fw-bold">4</span>
                <span class="display-1 fw-bold">0</span>
                <span class="display-1 fw-bold">3</span>
                </h2>
                <h3 class="h2 mb-2">{{ __('Forbidden') }}</h3>
                <p class="mb-5">Bạn không có quyền truy xuất trang này.</p>
                <a class="btn btn-info me-3 rounded" href="#!">Quay trờ lại</a>
            </div>
            </div>
        </div>
        </div>
    </section>

    @include('layouts.main._footer')

    @yield('footer')
</body>
</html>