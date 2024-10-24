@extends('layouts.main.popup')

@section('title')
    Xem chi tiết thư giới thiệu
@endsection

@section('content')
<div data-form="create-letter-form">
    <div class="scroll-y px-7 py-10 px-lg-17">
        <div class="row p-5 mb-6" style="background-color: #F9F9F9; border: 1px solid var(--bs-gray-300)">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Tên thư giới thiệu:</label>
                    <label class="fs-6 ps-3">{{ $recommendationLetter->name }}</label>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Tên học viên:</label>
                    <label class="fs-6 ps-3">{{ $recommendationLetter->abroadApplication->student->name }}</label>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Mã hồ sơ:</label>
                    <label class="fs-6 ps-3 fw-semibold">{{ $recommendationLetter->abroadApplication->code }}</span></label>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Mã học viên:</label>
                    <label class="fs-6 ps-3">{{ $recommendationLetter->abroadApplication->contact->code }}</label>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Mã cũ học viên:</label>
                    <label class="fs-6 ps-3">{{ $recommendationLetter->abroadApplication->contact->import_id }}</label>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Ngày tạo thư:</label>
                    <label class="fs-6 ps-3">{{ $recommendationLetter->date }}</label>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Mã hợp đồng:</label>
                    <label class="fs-6 ps-3 fw-semibold">{{ $recommendationLetter->abroadApplication->orderItem->order->code }}</label>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    @php
                        $colorClass = 'danger';

                        if ($recommendationLetter->status == \App\Models\RecommendationLetter::STATUS_ACTIVE) {
                            $colorClass = 'success';
                        }
                    @endphp
                    <label class="fs-6 fw-semibold mb-8">File thư hiện tại&nbsp;&nbsp;&nbsp;<span class="fs-6 ps-3 badge badge-{{ $colorClass }}">{{ trans('messages.recommendation_letter.' . $recommendationLetter->status) }}</label>
                    <br>
                    <img style="width:40px; height:40px" src="{{ url('/core/assets/media/logos/word.png') }}" alt="Word Icon">
                    @php
                        $path = $recommendationLetter->path;
                        $filename = basename($path);
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);
                        $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
    
                    @endphp
                    <span>{{ $filename }}</span>
                    <a class="fw-bold" href="/{{ $recommendationLetter->path }}" download="{{ $filename }}">
                        Tải xuống
                        <span class="material-symbols-rounded pt-2">
                            arrow_downward
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-8">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold">Email học viên:</label>
                    <label class="fs-6 ps-3">{{ $recommendationLetter->abroadApplication->contact->email }}</label>
                </div>
            </div>
        </div>

        {{-- Need to deploy the website to a hosting service with a publicly accessible URL in order to use Google to preview files. --}}
        {{-- <iframe src='https://docs.google.com/viewer?url=http://localhost/{{ $recommendationLetter->path }}&embedded=true' frameborder='0'></iframe> --}}

        <div class="d-flex justify-content-center">
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Đóng</button>
        </div>
    </div>
</div>

@endsection