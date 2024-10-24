@if (date('y-m-d', strtotime($calendar->getActiveYear() . '-' . $calendar->getActiveMonth() . '-' . $date . ' -' . 0 . ' day')) == date('y-m-d', strtotime($event[0])))
    <div style="position: relative;" data-item="event" data-code="{{ $event[5] }}">
        <div list-data="event" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
            title=
                '
                    <div class="tooltip-content" style="position: relative;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 text-bold text-info d-flex justify-content-start fs-3 mb-2">
                                @if(isset($isShowCode) && $isShowCode)
                                    <div class="row px-3 fw-bold text-dark">
                                        {{ $event[22] }}
                                    </div>&nbsp;&nbsp;({{ substr($event[1], 11, 5) }} - {{ substr($event[2], 11, 5) }})
                                @else
                                {{ substr($event[1], 11, 5) }} - {{ substr($event[2], 11, 5) }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                {{ Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) }} phút | 
                                {{ number_format(Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) / 60, 1) }} giờ
                            </div>

                            @if($event[6] && $event[6] !== '' && $event[6] !== 'false' && $event[6] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Giáo viên Việt Nam:&nbsp;</span> {{ $event[7] ? App\Models\Teacher::find($event[7])->name : "" }} ({{ $event[8] }} - {{ $event[9] }})
                                </div>
                            @endif

                            @if($event[10] && $event[10] !== '' && $event[10] !== 'false' && $event[10] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Giáo viên nước ngoài:&nbsp;</span> {{ $event[11] ? App\Models\Teacher::find($event[11])->name : "" }} ({{ $event[12] }} - {{ $event[13] }})
                                </div>
                            @endif

                            @if($event[14] && $event[14] !== '' && $event[14] !== 'false' && $event[14] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Gia sư:&nbsp;</span> {{ $event[15] ? App\Models\Teacher::find($event[15])->name : "" }} ({{ $event[16] }} - {{ $event[17] }})
                                </div>
                            @endif

                            @if($event[18] && $event[18] !== '' && $event[18] !== 'false' && $event[18] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Trợ giảng:&nbsp;</span> {{ $event[19] ? App\Models\Teacher::find($event[19])->name : "" }} ({{ $event[20] }} - {{ $event[21] }})
                                </div>
                            @endif
                        </div>
                    </div>
                '
            class="event {{ $event[24] === App\Models\Section::TYPE_TEST ? 'red' : 'blue' }} mt-2 p-2 fw-500 fs-14 rounded-1 text-light"
            >
            <div class="row px-3 fs-8 fw-bold" style="color: #ede7fa">
                {{ substr($event[1], 11, 5) }} - {{ substr($event[2], 11, 5) }}
            </div>
        </div>
        <div class="d-none p-6" action-control="event-action" style="position: absolute; bottom: 20%; right: -20%; width: 50px; height: 40px; transition: transform 0.3s ease; z-index: 1000"
            onmouseover="this.style.transform='scale(1.2)'"
            onmouseout="this.style.transform='scale(1)'"
        >
        </div>
    </div>
@endif