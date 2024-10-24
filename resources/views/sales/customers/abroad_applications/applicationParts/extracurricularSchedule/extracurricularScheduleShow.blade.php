@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Kế hoạch ngoại khoá
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp
@section('content')
    <!--begin::Card body-->

    <form id="popupCreateAbroadUniqId" tabindex="-1">
        @csrf
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                 <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hạng mục
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                         Tên hoạt động ngoại khoá
                                    </span>
                                </span>
                            </th>
                            
                            <th class="min-w-125px text-left d-none">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm bắt đầu
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left d-none">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm kết thúc
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left d-none">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Link tài liệu chương trình
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left d-none">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa điểm
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Vai trò
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">

                        @foreach (\App\Models\ExtracurricularSchedule::getAllCategory() as $category)
                            @php
                                $categorySchedules = $extracurricularSchedules->where('category', $category);
                            @endphp
                            <!-- Kiểm tra nếu có dữ liệu cho hạng mục -->
                            @if ($categorySchedules->isNotEmpty())
                                <!-- Dòng đầu tiên của mỗi loại trường -->
                                <tr>
                                    <td rowspan="{{ $categorySchedules->count() + 1 }}" class="text-left mb-1 text-nowrap">
                                        {{ trans('messages.extracurricular_schedule.category.' . $category) }}
                                    </td>
                                </tr>
                                <!-- Lặp qua danh sách các trường trong mỗi loại -->
                                @foreach ($categorySchedules as $extracurricularSchedule)
                                    <tr list-control="item">
                                        <!-- Các cột thông tin -->
                                        <td class="text-left mb-1 text-nowrap">{{ $extracurricularSchedule->extracurricular->name }}</td>
                                        <td class="text-left mb-1 text-nowrap d-none">
                                            {{ $extracurricularSchedule->start_at ? date('d/m/Y', strtotime($extracurricularSchedule->start_at)) : '' }}
                                        </td>
                                        <td class="text-left mb-1 text-nowrap d-none">
                                            {{ $extracurricularSchedule->end_at ? date('d/m/Y', strtotime($extracurricularSchedule->end_at)) : '' }}
                                        </td>
                                        <td class="text-left mb-1 text-nowrap d-none">{{ $extracurricularSchedule->link }}</td>
                                        <td class="text-left mb-1 text-nowrap d-none">{{ $extracurricularSchedule->address }}</td>
                                        <td class="text-left mb-1 text-nowrap">{{ trans('messages.extracurricular_schedule.role.' . $extracurricularSchedule->role) }}</td>
                                        <!-- Cột thao tác -->
                                        
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach


                    </tbody>
                </table>

            </div>
            
        </div>
    </form>
    <!--end::Card body-->

    
@endsection
