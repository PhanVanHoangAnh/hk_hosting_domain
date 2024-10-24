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
                                        Các trang mạng xã hội
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Link trang mạng xã hội
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <input type="hidden" name="socialNetworks" value="{{ $socialNetworks }}">
                        @foreach ($socialNetworks as $socialNetwork)
                            <tr list-control="item">
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $socialNetwork->name }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    <a href="{{ $socialNetwork->link }}">
                                        {{ $socialNetwork->link }}
                                    </a>
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
