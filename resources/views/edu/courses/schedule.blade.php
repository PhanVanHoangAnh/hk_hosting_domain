@extends('layouts.main.app', [
    'menu' => 'edu',
])
@section('sidebar')
@include('edu.modules.sidebar', [
        'menu' => 'courses',
        'sidebar' =>'courses',
])
@endsection
@section('content')
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Thông tin chi tiết</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Lớp học</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Thông tin</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <div class="post" id="kt_post">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('edu.courses.detail', [
                    'detail' => 'schedule',
                ])
                <!--end::Details-->

                @include('edu.courses.menu', [
                    'menu' => 'schedule',
                ])
            </div>
        </div>

        <div id="StudentsIndexContainer" class="  position-relative" id="kt_post">
            <div id="calendarScheduleContent">
                
            </div>
        </div>

        <script>
            var calendar;
            var calendarManager;
        
            $(() => {
                calendar = new Calendar({
                    container: document.querySelector('#calendarScheduleContent')
                });
            })
        
            var Calendar = class {
                constructor(options) {
                    this.container = options.container;
                    this.currentDate = this.createCurrentDate();
                    this.dateData = {
                        date: this.currentDate,
                        events: {!! $sections !!}
                    };
        
                    this.init();
                };
        
                getDateData() {
                    return this.dateData;
                };
        
                removeAllEvents() {
                    this.getDateData().events = [];
                    this.render();
                };
        
                updateAllEvents(events) {
                    this.getDateData().events = events;
                    this.render();
                };
        
                /**
                 * Filter out events added directly to the calendar and retain.
                 * Additionally add new events from the schedules
                 */
                updateEvents(newEvents) {
                    const currCalendarEvents = this.getDateData().events;
                    const eventNeedRemoveIndexs = []; // The array of event indexs add in calendar need remove
        
                    for(let i = 0; i < currCalendarEvents.length; ++i) {
                        let currEvent = currCalendarEvents[i].is_add_later;
        
                        if(!currEvent || currEvent=== "" || currEvent === null || currEvent == "0") {
                            eventNeedRemoveIndexs.push(i);
                        };
                    };
        
                    // Remove old week schedule items in currCalendarEvents (ignore events add in calendar).
                    const filteredCalendarEvents = currCalendarEvents.filter((event, index) => !eventNeedRemoveIndexs.includes(index));
        
                    // Merge current filtered array & new array.
                    const newEventsFiltered = filteredCalendarEvents.concat(newEvents);
        
                    this.getDateData().events = newEventsFiltered;
                    this.render();
                };
        
                deleteEventInCalendar(code, date) {
                    if(!date.split(' ')[1]) {
                        date += ' 00:00:00'
                    };
                    
                    const existingEvents = this.getDateData().events;
        
                    const updatedEvents = existingEvents.filter(event => {
                        let eventDate = event.study_date;
        
                        if(!eventDate.split(' ')[1]) {
                            eventDate += ' 00:00:00'
                        };
        
                        return !(event.code === code && eventDate === date);
                    });
        
                    this.getDateData().events = updatedEvents;
                    this.render();
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
                    const events = this.getDateData().events;
        
                    events.forEach(event => {
                        if(event.study_date.split(' ').length < 2) {
                            event.study_date += ' 00:00:00';
                        };
                    });
        
                    const result = events.find(event => event.code === code && event.study_date === date);
                    const endArrTimePart = result.end_at.split(' ')[1];
                    const startArrTimePart = result.start_at.split(' ')[1];
        
                    if(startArrTimePart) {
                        result.start_at = startArrTimePart;
                    };
        
                    if(endArrTimePart) {
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
                };
        
                addEvent(event) {
                    this.dateData.events.push(event);
                    this.render();
                };
        
                render() {
                    const data = {};
                    data._token = "{{ csrf_token() }}";
                    data.date = this.dateData.date;
                    data.events = JSON.stringify(this.dateData.events);

                    $.ajax({
                        url: '{{ action('App\Http\Controllers\CalendarController@getCalendar') }}',
                        method: 'POST',
                        data: data,
                    }).done(response => {
                        $(this.container).html(response)
                        calendarSectionHandle.events();
                        
                        this.events();
                        
                        if($(this.getContainer())[0]) {
                            initJs($(this.getContainer())[0]);
                        };
                    }).fail(response => {
                        throw new Error(response);
                    })
        
                    document.addEventListener('doneLoadNewglobalCalendarManager', function(event) {
                        globalCalendarManager.disableActionsInEventBoxes();
                    })
                };
            };
        </script>
@endsection