@extends('layouts.main.popup')
@if ($section->canShowZoomLinkInformations())
    @section('title')
        Thông tin phòng học ZOOM
    @endsection

    @php
        $formId = 'show_join_link_' . uniqid();
    @endphp

    @section('content')
        <div class="scroll-y px-7 py-10 px-lg-17" id="{{ $formId }}" class="mb-4 mt-4">
                @if ($hostInformation)
                    <div class="row mb-4">
                        <div class="form-outline">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 ms-4 mb-4">
                                <p class="d-inline-flex gap-1">
                                    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#host-information" aria-expanded="false" aria-controls="host-information">
                                        <label class="fs-6 fw-semibold">Thông tin chủ phòng</label>
                                    </button>
                                </p>
                                <div class="collapse" id="host-information">
                                    <section class="w-100 py-5" >
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <div class="card" style="border-radius: 15px;">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{ $hostInformation['pic_url'] }}"
                                                                alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h3 class="mb-1">{{ isset($hostInformation['display_name']) ? $hostInformation['display_name'] : '--' }} ({{ isset($hostInformation['role_name']) ? $hostInformation['role_name'] : '--' }}) - Quản lý: {{ isset($hostInformation['manager']) ? $hostInformation['manager'] : '--' }}</h3>
                                                                <p class="mb-2 fs-4 pb-1">{{ $hostInformation['email'] ? $hostInformation['email'] : '--' }}</p>
                                                                <p class="mb-2 fs-4 pb-1">{{ $hostInformation['job_title'] ? $hostInformation['job_title'] : '--' }} - {{ $hostInformation['dept'] ? $hostInformation['dept'] : '--' }}</p>
                                                                <p class="mb-2 fs-4 pb-1">{{ $hostInformation['location'] ? $hostInformation['location'] : '--' }}</p>
                                                                <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mb-4">
                    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 ms-4 mb-4">
                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-4 d-flex justify-content-start align-items-center">
                                <label class="fs-6 fw-semibold text-left mb-2">Link mở lớp</label>
                            </div>
                
                            <div class="col-lg-10 col-xl-10 col-md-10 col-sm-10 col-10 mb-4">
                                <a style="border-radius: 12px;" class="border-0 form-control text-info text-truncate d-block" href="{{ $section->zoom_start_link }}" target="_blank"><u>{{ $section->zoom_start_link }}</u></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-4 d-flex justify-content-start align-items-center">
                                <label class="fs-6 fw-semibold text-left mb-2">Link tham gia lớp</label>
                            </div>
                
                            <div class="col-lg-10 col-xl-10 col-md-10 col-sm-10 col-10 mb-4">
                                <a style="border-radius: 12px;" class="border-0 form-control text-info text-truncate d-block" href="{{ $section->zoom_join_link }}" target="_blank"><u>{{ $section->zoom_join_link }}</u></a>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-4 d-flex justify-content-start align-items-center">
                                <label class="fs-6 fw-semibold text-left mb-2">Password</label>
                            </div>
                
                            <div class="col-lg-10 col-xl-10 col-md-10 col-sm-10 col-10 mb-4">
                                <input type="text" style="border-radius: 12px;" class="border-0 form-control" value="{{ $section->zoom_password }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endsection
@else
    @section('title')
        <div class="form-outline py-5 d-flex justify-content-center w-100">
            <label class="fs-2 fw-semibold text-center w-100 m-auto mb-2">Buổi học này không có phòng học ZOOM!!</label>
        </div>
    @endsection
@endif