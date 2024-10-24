@extends('layouts.main.popup')

@section('title')
    Lịch rảnh của {{$contact->name}} 
@endsection
@php
    $formId = 'F' . uniqid();
@endphp
@section('content')

<form id="popupFreeTimeUniqId" tabindex="-1">
    @csrf
    <div class="scroll-y pe-7 py-10 px-lg-17"  data-kt-scroll-offset="300px">
        
        @if ($contact->freetimes->count())
        <div class="table-responsive">

            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Từ ngày
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Đến ngày
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                   Lịch rảnh
                                </span>
                            </span>
                        </th>
                        
                        <th class="min-w-125px text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                   
                    @foreach($contact->freetimes as $freetime)
                        <tr>
                            <td>
                                {{ !isset($freetime->from_date) ? '--' : date('d/m/Y', strtotime($freetime->from_date)) }}
                            </td>
                            <td>
                                {{ !isset($freetime->to_date) ? '--' : date('d/m/Y', strtotime($freetime->to_date)) }}
                            </td>
                            <td>
                                @foreach($freetime->freeTimeRecordsByWeek() as $dayOfWeek => $timeRanges)
                                    @if($dayOfWeek == 1)
                                        Chủ nhật: {{ implode(', ', $timeRanges) }}<br>
                                    @else
                                        Thứ {{ $dayOfWeek }}: {{ implode(', ', $timeRanges) }}<br>
                                    @endif
                                @endforeach

                            </td>
                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    style="margin-left: 0px">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3" row-action="delete-free-time" 
                                        class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4"
                                        href="{{ action(
                                            [App\Http\Controllers\Edu\StudentController::class, 'deleteFreeTime'],
                                            [
                                                'id' => $freetime->id,
                                            ],
                                        ) }}">Xóa</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3" row-action="edit-free-time"
                                        class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4"
                                        href="{{ action(
                                            [App\Http\Controllers\Edu\StudentController::class, 'editFreetimeSchedule'],
                                            [
                                                'id' => $freetime->id,
                                            ],
                                        ) }}">Chỉnh sửa</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div id="error-message" class="error-message text-danger" style="display: none;"></div>
            <!--end::Table-->  
        </div>
        <div class="row">
            @if(isset($contact) && $contact->freeTimes->count() > 0)
            @php
                $freeTimeCalendarFormId = "freetime_calendar_form_id_" . uniqId();
                $freeTimeSectionsListId = "freetime_sections_list_form_id_" . uniqId();
            @endphp

            {{-- The calendar in the right side, next to the week config tool, include 2 tabs: calendar tab and sections week schedule tab --}}
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 mt-14">
                {{-- Tabs menu --}}
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="fs-4 fw-semibold nav-link active" id="calendar-tab" data-bs-toggle="tab" href="#{{ $freeTimeCalendarFormId }}" role="tab" aria-controls="{{ $freeTimeCalendarFormId }}" aria-selected="true">Lịch</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="fs-4 fw-semibold nav-link" id="list-sections" data-bs-toggle="tab" href="#{{ $freeTimeSectionsListId }}" role="tab" aria-controls="{{ $freeTimeSectionsListId }}" aria-selected="false">Danh sách</a>
                    </li>
                </ul>

                {{-- Tabs content --}}
                <div class="tab-content pt-5" id="tab-content">
                    <div class="tab-pane content home active" id="{{ $freeTimeCalendarFormId }}" role="tabpanel" aria-labelledby="calendar-tab">
                        {{-- LOAD CALENDAR HERE --}}
                    </div>

                    <div class="tab-pane" id="{{ $freeTimeSectionsListId }}" role="tabpanel" aria-labelledby="list-sections">
                        {{-- LOAD SECTIONS LIST HERE --}}
                    </div>
                </div>
            </div>
            <script>
                var calendar;
                var sectionsList;

                $(() => {
                    calendar = new Calendar({
                        container: document.querySelector('#{{ $freeTimeCalendarFormId }}')
                    })

                    sectionsList = new SectionsList({
                        container: $('#{{ $freeTimeSectionsListId }}')
                    })
                })

                var Calendar = class {
                    constructor(options) {
                        this.container = options.container;
                        this.currentDate = this.createCurrentDate();
                        this.savedEventsData;

                        this.dateData = {
                            date: this.currentDate,
                            events: JSON.parse('{!! json_encode($contact->getFreeTimeSections()) !!}')
                        };

                        this.init();
                        this.setSavedEventsData(options.events);
                    };

                    setSavedEventsData(savedEventsData) {
                        if (savedEventsData) {
                            const tmp = JSON.stringify(savedEventsData);
                
                            this.savedEventsData = JSON.parse(tmp);
                        } else {
                            this.savedEventsData = [];
                        }
                    };

                    getSavedEventsData() {
                        return this.savedEventsData;
                    };

                    getDateData() {
                        return this.dateData;
                    };

                    removeAllEvents() {
                        this.getDateData().events = [];
                        this.render();

                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                    };

                    updateAllEvents(events) {
                        this.getDateData().events = events;
                        this.render();

                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                    };

                    /**
                     * Filter out events added directly to the calendar and retain.
                     * Additionally add new events from the schedules
                     * @param events
                     * @return void
                     */
                    updateEvents(newEvents) {
                        const currCalendarEvents = this.getDateData().events;
                        const eventNeedRemoveIndexs = []; // The array of event indexs add in calendar need remove

                        for (let i = 0; i < currCalendarEvents.length; ++i) {
                            let currEvent = currCalendarEvents[i].is_add_later;

                            if (!currEvent || currEvent=== "" || currEvent === null || currEvent == "0") {
                                eventNeedRemoveIndexs.push(i);
                            };
                        };

                        // Remove old week schedule items in currCalendarEvents (ignore events add in calendar).
                        const filteredCalendarEvents = currCalendarEvents.filter((event, index) => !eventNeedRemoveIndexs.includes(index));

                        // Merge current filtered array & new array.
                        const newEventsFiltered = filteredCalendarEvents.concat(newEvents);

                        this.getDateData().events = newEventsFiltered;
                        this.render();

                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                    };

                    /**
                     * CLick delete icon on the section label in calendar
                     * @param code code of section use to references to week schedule
                     * @param date date date of section in calendar
                     * @return void
                     */
                    deleteEventInCalendar(code, date) {
                        if (!date.split(' ')[1]) {
                            date += ' 00:00:00'
                        };
                        
                        const existingEvents = this.getDateData().events;

                        const updatedEvents = existingEvents.filter(event => {
                            let eventDate = event.study_date;

                            if (!eventDate.split(' ')[1]) {
                                eventDate += ' 00:00:00'
                            };

                            return !(event.code === code && eventDate === date);
                        });

                        this.getDateData().events = updatedEvents;
                        this.render();

                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                    };

                    getContainer() {
                        return this.container;
                    };

                    getEvents() {
                        return this.dateData.events;
                    };

                    getPrevMonthBtn() {
                        return this.container.querySelector('[data-control="prev-btn"]');
                    };

                    getTodayBtn() {
                        return this.container.querySelector('[data-control="today-btn"]');
                    };

                    getNextMonthBtn() {
                        return this.container.querySelector('[data-control="next-btn"]');
                    };

                    createCurrentDate() {
                        const currentDateObject = new Date();
                        const year = currentDateObject.getFullYear();
                        const month = String(currentDateObject.getMonth() + 1).padStart(2, '0');
                        const day = String(currentDateObject.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    };

                    getCurrentDate() {
                        return this.currentDate;
                    };

                    prevMonth() {
                        this.currentDate = this.getPrevMonthByDate(this.currentDate);
                        this.dateData.date = this.currentDate;
                        this.render();
                    };

                    today() {
                        this.currentDate = this.getToday();
                        this.dateData.date = this.currentDate;
                        this.render();
                    };

                    nextMonth() {
                        this.currentDate = this.getNextMonthByDate(this.currentDate);
                        this.dateData.date = this.currentDate;
                        this.render();
                    };

                    getPrevMonthByDate(dateString) {
                        const date = new Date(dateString);
                        date.setMonth(date.getMonth() - 1);
                        return date.toISOString().slice(0, 10);
                    };

                    getToday() {
                        const date = new Date(this.createCurrentDate());
                        return date.toISOString().slice(0, 10);
                    };

                    getNextMonthByDate(dateString) {
                        const date = new Date(dateString);
                        date.setMonth(date.getMonth() + 1);
                        return date.toISOString().slice(0, 10);
                    };

                    init() {
                        this.render();
                        this.events();

                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                    };

                    events() {
                        $(this.getPrevMonthBtn()).on('click', e => {
                            e.preventDefault();

                            this.prevMonth();
                        });

                        $(this.getTodayBtn()).on('click', e => {
                            e.preventDefault();

                            this.today();
                        });

                        $(this.getNextMonthBtn()).on('click', e => {
                            e.preventDefault();

                            this.nextMonth();
                        });
                    };

                    getEventByCodeAndDate(code, date) {
                        // Use the spread operator to create a copy of an array of object, helping to avoid referencing
                        const events = [...this.getDateData().events];

                        events.forEach(event => {
                            if (event.study_date.split(' ').length < 2) {
                                event.study_date += ' 00:00:00';
                            };
                        });

                        const result = events.find(event => event.code === code && event.study_date === date);
                        const endArrTimePart = result.end_at.split(' ')[1];
                        const startArrTimePart = result.start_at.split(' ')[1];

                        if (startArrTimePart) {
                            result.start_at = startArrTimePart;
                        };

                        if (endArrTimePart) {
                            result.end_at = endArrTimePart;
                        };

                        return result;
                    };

                    editEvent(eventEdited) {
                        const existingEvents = this.getDateData().events;
                        const updatedEvents = existingEvents.filter(event => {
                            return !(event.code == eventEdited.code && event.study_date == eventEdited.study_date);
                        });

                        this.getDateData().events = updatedEvents;
                        this.getDateData().events.push(eventEdited);
                        this.render();
                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                    };

                    addEvent(event) {
                        this.dateData.events.push(event);
                        // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
                        // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
                        if (sectionsList) {
                            sectionsList.render();
                        }
                        this.render();
                    };

                    /**
                     * Sort all events by start at to index order number per section
                     * @return void
                     */
                    sortEventsByStartAt() {
                        this.dateData.events.sort((a, b) => {
                            const dateA = new Date(a.start_at);
                            const dateB = new Date(b.start_at);
                            return dateA - dateB;
                        })

                        for (let i = 0; i < this.dateData.events.length; ++i) {
                            this.dateData.events[i].order_number = i + 1;
                        }
                    }

                    /**
                     * Show calendar with all sections updated
                     * @return void
                     */
                    render() {
                        const _this = this;

                        _this.sortEventsByStartAt();

                        const data = {};

                        data._token = "{{ csrf_token() }}";
                        data.date = this.dateData.date;
                        // data.totalHours = addCourseManager.getTotalHoursInputValue();
                        data.events = JSON.stringify(this.dateData.events);

                        // addCourseManager.manageConditionConstraintForEventCreation(null, this.dateData.events);

                        $.ajax({
                            url: '{{ action('App\Http\Controllers\CalendarController@getCalendar') }}',
                            method: 'POST',
                            data: data,
                        }).done(response => {
                            $(this.container).html(response)
                            calendarSectionHandle.events();
                            
                            this.events();

                            if ($(this.getContainer())[0]) {    
                                initJs($(this.getContainer())[0]);
                            };
                        }).fail(response => {
                            weekScheduleTool.alertError(response.responseJSON.message);
                        })

                        document.addEventListener('doneLoadNewglobalCalendarManager', function(event) {
                            if (globalCalendarManager) {
                                globalCalendarManager.disableActionsInEventBoxes();
                            }
                        })
                    };
                };

                var SectionsList = class {
                    constructor(options) {
                        this.container = options.container;

                        this.init();
                    }

                    getContainer() {
                        return this.container;
                    }

                    init() {
                        this.render();
                        this.events();
                    }

                    render() {
                        const _this = this;

                        calendar.sortEventsByStartAt();

                        const data = {};

                        data._token = "{{ csrf_token() }}";
                        data.date = calendar.dateData.date;
                        // data.totalHours = addCourseManager.getTotalHoursInputValue();
                        data.events = JSON.stringify(calendar.dateData.events);
                        data.type = "freetime";

                        $.ajax({
                            url: '{{ action('App\Http\Controllers\CalendarController@getSectionsList') }}',
                            method: 'POST',
                            data: data,
                        }).done(response => {
                            this.container.html(response);

                            const calendarScript = this.container.find('[script-control="calendar-script"]').textContent;
                            
                            // Run javascript part in the response text return 
                            (new Function(calendarScript))();
                            
                            this.events();

                            if ($(this.getContainer())[0]) {
                                initJs($(this.getContainer())[0]);
                            };
                        }).fail(response => {
                            weekScheduleTool.alertError(response.responseJSON.message);
                        })
                    }

                    events() {
                        const _this = this;
                    }
                }
            </script>
        @else
            <div class="my-20">
                <span class="d-flex align-items-center justify-content-center">
                    <span class="material-symbols-rounded text-center me-2 fs-2" style="vertical-align: middle;">
                        error
                    </span>
                    <span class="text-center fs-2">Giảng viên này chưa có lịch rảnh!</span>
                </span>
            </div>
        @endif
        @else
                    <div class="py-15">
                        <div class="text-center mb-7">
                            <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                                <g style="isolation:isolate">
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="layer1">
                                            <path
                                                d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                                style="fill:#cdcdcd" />
                                            <path
                                                d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                                style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                            <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                                style="fill:#f5f5f5" />
                                            <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                            <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                            <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                            <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                            <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                            <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                            <path
                                                d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                                style="fill:#dbdbdb" />
                                            <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                                style="fill:#f5f5f5" />
                                            <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z"
                                                style="fill:#f5f5f5" />
                                            <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z"
                                                style="fill:#f5f5f5" />
                                            <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                            <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                            <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                                transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                            <path
                                                d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                                style="fill:#f8a11f" />
                                            <path
                                                d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                                style="fill:#253f8e" />
                                            <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                                style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                            <path
                                                d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                                style="fill:#dbdbdb" />
                                            <path
                                                d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                                style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <p class="fs-4 text-center mb-5">
                            Không có lịch rảnh nào!
                        </p>
                        

                    </div>
                @endif
        <div class="d-flex bd-highlight">
            <div class="p-2 flex-grow-1 bd-highlight">
                <a href="{{ action(
                    [App\Http\Controllers\Edu\StudentController::class, 'createFreetimeSchedule'],
                    [
                        'id' => $contact->id,
                    ],
                ) }}"
                    class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                    row-action="create-free-time">
                    <span class="material-symbols-rounded me-2">
                        add
                    </span>
                    Thêm lịch rảnh
                </a>
            </div>
            <div class="p-2 bd-highlight">
                <button type="reset" id="kt_modal_add_customer_cancel"
                    class="btn btn-info btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px"
                    data-bs-dismiss="modal">Đóng</button>
            </div>
            
        </div>
    </div>
</form>

<script>
 $(() => {
            FreeTime.init();
            //Update node-log
            CreatePopup.init();
            DeletePopup.init();

        });
        var CreatePopup = (function() {
            var updatePopup;

            return {
                init: function() {
                    updatePopup = new Popup();
                },
                updateUrl: function(newUrl) {
                    updatePopup.url = newUrl;
                    updatePopup.load();
                },
                getUpdatePopup: function() {
                    return updatePopup;
                }
            };
        })();
        var DeletePopup = function() {
            var deleteFreeTime = function(url) {
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa lịch này này?',
                    ok: function() {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            
                            },
                        }).done((response) => {
                            ASTool.alert({
                                message: response.message, 
                                ok: () => {
                                    UpdateContactPopup.getPopup().load();
                                    
                                }
                            });
                        }).fail(function() {
                            
                        });
                    }
                });
            };

            return {
                init: () => {
                    var deleteButtons = document.querySelectorAll('[row-action="delete-free-time"]');
                    deleteButtons.forEach(function(button) {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            var deleteUrl = this.getAttribute('href');
                            
                            deleteFreeTime(deleteUrl);
                        });
                    });
                }
            };
        }();

        var FreeTime = (function() {
            var listContent;

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="edit-free-time"]');
            }

            function getCreateBtn() {
                return document.querySelectorAll('[row-action="create-free-time"]');
            }

          
            submit = (btnUrl) => {
                var url = btnUrl
                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                }).done(response => {

                    UpdateSocialNetworkPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            extracurricularScheduleManager.load();
                        }
                    });

                }).fail(message => {
                    // UpdatePopup.getUpdatePopup().setContent(message.responseText);
                    removeSubmitEffect();
                })
            }
            return {
                init: function() {
                    listContent = document.querySelector('.table-responsive'); 
                    if (listContent) {
                        getUpdateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreatePopup.updateUrl(btnUrl);
                            });
                        });
                        getCreateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreatePopup.updateUrl(btnUrl);
                            });
                        });
                       
                    } else {
                        throw new Error("listContent is undefined or null.");
                    }
                }
            };
        })();
    
</script>
@endsection