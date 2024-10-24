@extends('layouts.main.popup')

@section('title')
    Chứng chỉ cần có
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
                                        Chứng chỉ cần có
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm cần có
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điểm cần đạt
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điểm thực tế
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm có chứng chỉ thực tế
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Link file đính kèm
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($certifications as $certification)
                            <tr list-control="item">
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $certification->type }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $certification->due_date ? date('d/m/Y', strtotime($certification->due_date)) : '' }}

                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $certification->min_score }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $certification->actual_score }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $certification->certified_date ? date('d/m/Y', strtotime($certification->certified_date)) : '' }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $certification->link }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!--end::Table-->





            </div>
        </div>
    </form>
    <!--end::Card body-->
@endsection
