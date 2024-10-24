@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Danh sách học viên
@endsection
@php
    $createExtracurricular = 'createExtracurricular_' . uniqid();
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
                                        Tên học viên
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số tiền
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày thu
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Cán bộ phụ trách
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ghi chú
                                    </span>
                                </span>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <input type="hidden" name="extracurricularStudents" value="{{ $extracurricularStudents }}">
                        @foreach ($extracurricularStudents as $extracurricularStudent)
                            <tr list-control="item">
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->student->name }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->student->email }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->student->phone }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->amount }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->received_date }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{-- {{ $extracurricularStudent->account->name }} --}}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $extracurricularStudent->note }}
                                </td>
                                
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!--end::Table-->
                <!--end::Table-->
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>

                




            </div>


            <div class="d-flex bd-highlight">
                


            </div>
        </div>
    </form>
    <!--end::Card body-->

    
@endsection
