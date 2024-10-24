@extends('layouts.main.app', [
    'menu' => 'edu',
])
@section('sidebar')
    @include('edu.modules.sidebar', [
        'menu' => 'students',
        'sidebar' => 'students',
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
                <a href="../../demo5/dist/index.html" class="text-muted text-hover-primary">Trang chủ</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Tài khoản</li>
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
<!--end::Toolbar-->
<!--begin::Post-->
<div class="post" id="kt_post">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">

            <!--begin::Details-->
            @include('edu.staffs.detail', [
                'detail' => 'schedule',
            ])
            <!--end::Details-->

            @include('edu.staffs.menu', [
                'menu' => 'schedule',
            ])
        </div>

    </div>

    <div class="card-title" list-action="search-action-box">
        
        @include('edu.staffs.menusub', [
            'menusub' => 'calendar',
        ])
        
    </div>
    <div class="card" id="ClassesIndexContainer">
        <!--begin::Card header-->
        <div class="card-header border-0 px-4">
            <!--begin::Group actions-->
            <div list-action="top-action-box" class="menu d-flex justify-content-end align-items-center d-none"
                data-kt-menu="true">
                <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                    <!--begin::Menu link-->
                    <button type="button" class="btn btn-outline btn-outline-default px-9 "
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Thao tác
                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                    </button>
                    <!--end::Menu link-->

                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown p-3 w-150px">
                        <!--begin::Menu item-->
                        <div class="menu-item">
                            <a href="#" class="menu-link px-3"
                                data-kt-customer-table-select="delete_selected" row-action="delete-all"
                                id="">

                                <span class="menu-title">Xoá</span>
                            </a>
                        </div>
                        <!--end::Menu item-->

                    </div>
                    <!--end::Menu sub-->
                </div>
                <!--end::Menu item-->
                <div class="m-2 font-weight-bold">
                    <div list-control="count-note-selected-label"></div>
                </div>

            </div>
            <!--end::Group actions-->
            

            <!--begin::Card toolbar-->
            <div class="card-toolbar" list-action="tool-action-box">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <div class="d-flex align-items-center me-3 d-none">
                        <!--begin::Button-->
                        <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px"
                            id="buttonCreateNoteLog">
                            <i class="ki-duotone ki-abstract-10">
                                <i class="path1"></i>
                                <i class="path2"></i>
                            </i>
                            Thêm Ghi Chú
                        </a>
                        <!--end::Button-->
                    </div>


                    <!--begin::Filter-->
                    <button type="button" class="btn btn-outline btn-outline-default" id="filterButton">
                        <span class="d-flex align-items-center">
                            <span class="material-symbols-rounded me-2 text-gray-600">
                                filter_alt
                            </span>
                            <span>Lọc</span>

                            <span class="material-symbols-rounded me-2 text-gray-600">
                                <span id="filterIcon">expand_more</span>
                            </span>

                        </span>
                    </button>

                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--begin::Card toolbar-->
        <div class=" border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
            <!--begin::Card toolbar-->
            <div class="card-toolbar mb-0" list-action="tool-action-box">
                <!--begin::Toolbar-->

                <div class="row">

                    <!--begin::Input-->
                    <div class="col-md-4 mb-5">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Người ghi chú</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="account-select" class="form-select" data-control="select2"
                                data-allow-clear="true" data-placeholder="Chọn người ghi chú">
                                <option></option>
                               
                            </select>
                        </div>
                    </div>
                    <!--end::Input-->
                    
                    <div class="col-md-4 mb-5">
                        <label class="form-label">Ngày tạo (Từ - Đến)</label>
                        <div class="row" list-action="created_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_from" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_to" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-5">
                        <label class="form-label">Ngày cập nhật (Từ - Đến)</label>
                        <div class="row" list-action="updated_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="updated_at_from" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="updated_at_to" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--begin::Card body-->
    <div form-control="staff-calendar" class="card-body pt-0 mt-5">
        Calendar
    </div>

    <script>
        var calendar;
        var calendarManager;
    
        $(() => {
            calendar = new Calendar({
                container: document.querySelector('[form-control="staff-calendar"]')
            });
        })
    
        var Calendar = class {
            constructor(options) {
                this.container = options.container;
                this.currentDate = this.createCurrentDate();
                this.dateData = {
                    date: this.currentDate,
                    events: {!! $sectionCourses !!}
                };

                this.dateData.events.map(event => {
                    return event.viewer = 'staff';
                });
    
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

            getTotalMonth(currDate) {
                const _this = this;
                const yearAndMonthPart = _this.getPartYearAndMonth(currDate);

                let date = new Date(yearAndMonthPart);

                if(isNaN(date.getTime())) {
                    throw new Error('Chuối ngày tháng không hợp lệ!');
                }

                let totalMonth = date.getFullYear() * 12 + date.getMonth() + 1;

                return totalMonth;
            };

            getPartYearAndMonth(dateTime) {
                const _this = this;
                let yearAndMonth;

                // Get part year-month-date of date (ignore time if has time)
                const currDateArr = dateTime.split(' ');
                if(currDateArr.length > 1) {
                    yearAndMonth = currDateArr[0];
                } else {
                    yearAndMonth = dateTime;
                }

                return yearAndMonth;
            };

            // Load balancing for scheduling optimization.
            getEventByMonth(allEvents) {
                const _this = this;
                const currDate = this.dateData.date;
                const totalMonthOfCurrDate = _this.getTotalMonth(currDate);
                const events = [];

                allEvents.forEach(event => {
                    const totalMonthOfEvent = _this.getTotalMonth(event.start_at);

                    if(parseInt(totalMonthOfEvent) === parseInt(totalMonthOfCurrDate)) {
                        events.push(event);
                    };
                });

                return events;
            };

            addLoadEffect() {
                this.getContainer().classList.add('list-loading');

                if (!this.getContainer().querySelector('[list-action="loader"]')) {
                    $(this.listContent).before(`
                        <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);
                }
            };

            removeLoadEffect() {
                this.getContainer().classList.remove('list-loading');

                // remove loader
                if (this.getContainer().querySelector('[list-action="loader"]')) {
                    this.getContainer().querySelector('[list-action="loader"]').remove();
                }
            };
    
            render() {
                const _this = this;
                const data = {};
                const eventsByMonth = this.getEventByMonth(this.dateData.events);

                data._token = "{{ csrf_token() }}";
                data.date = this.dateData.date;
                data.events = JSON.stringify(eventsByMonth);

                _this.addLoadEffect();
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

                    _this.removeLoadEffect();
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