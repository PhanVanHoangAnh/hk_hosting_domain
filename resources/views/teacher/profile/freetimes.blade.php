@extends('layouts.main.teacher', [
    'menu' => 'teacher',
])

@section('sidebar')
    @include('teacher.modules.sidebar', [
        'menu' => 'profile', 
       
    ])
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">

            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">



                    <!--begin::Page title-->
                    
                    <!--end::Page title-->

                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Content-->
            <div id="kt_app_content" class="app-content  flex-column-fluid ">


                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container  container-xxl ">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-lg-row">
                        <!--begin::Sidebar-->
                        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">

                            <!--begin::Card-->
                            <div class="card mb-5 mb-xl-8">
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Summary-->


                                    <!--begin::User Info-->
                                    <div class="d-flex flex-center flex-column py-5">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            <img src="{{ url('/core/assets/media/avatars/blank.png') }}" alt="image" />
                                        </div>
                                        <!--end::Avatar-->

                                        <!--begin::Name-->
                                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                                            {{ Auth::User()->name }}</a>
                                        <!--end::Name-->

                                        <!--begin::Position-->
                                        <div class="mb-9">
                                            <!--begin::Badge-->
                                            <div class="badge badge-lg badge-light-primary d-inline">
                                                {{ Auth::User()->account->teacher->type }}
                                            </div>
                                            <!--begin::Badge-->
                                        </div>
                                        <!--end::Position-->

                                        <!--begin::Info-->
                                        <!--begin::Info heading-->
                                        <div class="fw-bold mb-3 d-none">
                                            Assigned Tickets

                                            <span class="ms-2" ddata-bs-toggle="popover" data-bs-trigger="hover"
                                                data-bs-html="true"
                                                data-bs-content="Number of support tickets assigned, closed and pending this week.">
                                                <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span></i> </span>
                                        </div>
                                        <!--end::Info heading-->

                                        <div class="d-flex flex-wrap flex-center d-none">
                                            <!--begin::Stats-->
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-75px">243</span>
                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <div class="fw-semibold text-muted">Total</div>
                                            </div>
                                            <!--end::Stats-->

                                            <!--begin::Stats-->
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-50px">56</span>
                                                    <i class="ki-duotone ki-arrow-down fs-3 text-danger"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <div class="fw-semibold text-muted">Solved</div>
                                            </div>
                                            <!--end::Stats-->

                                            <!--begin::Stats-->
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-50px">188</span>
                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <div class="fw-semibold text-muted">Open</div>
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User Info-->
                                    <!--end::Summary-->

                                    <!--begin::Details toggle-->
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                            href="#kt_user_view_details" role="button" aria-expanded="false"
                                            aria-controls="kt_user_view_details">
                                            Chi tiết
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-duotone ki-down fs-3"></i> </span>
                                        </div>

                                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" class="d-none"
                                            data-bs-original-title="Edit customer details" data-kt-initialized="1">
                                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_update_details">
                                                Chỉnh sửa
                                            </a>
                                        </span>
                                    </div>
                                    <!--end::Details toggle-->

                                    <div class="separator"></div>

                                    <!--begin::Details content-->
                                    <div id="kt_user_view_details" class="collapse show">
                                        <div class="pb-5 fs-6">
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Account ID</div>
                                            <div class="text-gray-600">{{ Auth::User()->id }}</div>
                                            <!--begin::Details item-->
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Email</div>
                                            <div class="text-gray-600"><a href="#"
                                                    class="text-gray-600 text-hover-primary">{{ Auth::User()->email }}</a>
                                            </div>
                                            <!--begin::Details item-->
                                           
                                            
                                        </div>
                                    </div>
                                    <!--end::Details content-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Connected Accounts-->

                            <!--end::Connected Accounts-->
                        </div>
                        <!--end::Sidebar-->

                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid ms-lg-15">

                            <div class="page-title d-flex flex-column py-1 ">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center my-1">
                                    <span class="text-dark fw-bold fs-1">Thông tin cá nhân</span>
                                </h1>
                                <!--end::Title-->
        
        
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a class="text-muted text-hover-primary">Trang chính</a>
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
                                    <li class="breadcrumb-item text-muted">Hoạt động</li>
                                    <!--end::Item-->
                                   
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>

                            <!--begin:::Tabs-->
                            @include('teacher.profile._menu', [
                                'menu' => 'freetime',
                            ]) 
                            <!--end:::Tabs-->

                            <!--begin:::Tab content-->
                            <!--begin:::Tab pane-->
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <div class="p-2">
                                        <a href="{{ action(
                                                [App\Http\Controllers\Teacher\ProfileController::class, 'createFreetime'],
                                                [
                                                    'id' => $teacher->id,
                                                ],
                                            ) }}"
                                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                                            row-action="create-free-time">
                                            <span class="material-symbols-rounded me-2">add</span>
                                            Thêm lịch rảnh
                                        </a>
                                    </div>
                                </div>
                                
                                @if(isset($teacher) && $teacher->freeTimes()->count() > 0)
                                    @php
                                        $freeTimeCalendarFormId = "freetime_calendar_form_id_" . uniqId();
                                        $freeTimeSectionsListId = "freetime_sections_list_form_id_" . uniqId();
                                    @endphp
                        
                                    {{-- The calendar in the right side, next to the week config tool, include 2 tabs: calendar tab and sections week schedule tab --}}
                                    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 ">
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
                                                    events: JSON.parse('{!! json_encode($teacher->getFreeTimeSections()) !!}')
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
                            </div>
                            
                                <!--end:::Tab pane-->

                               
                            </div>
                            <!--end:::Tab content-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Layout-->

                   

                </div>
                <!--end::Content-->

            </div>
            <!--end::Content wrapper-->



        </div>
        <!--end::Toolbar-->

    <script>
   
    $(() => {
        FreeTime.init();
        CreatePopup.init(); 
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

    var FreeTime = (function() {
            var listContent;

           
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
                    removeSubmitEffect();
                })
            }

            return {
                init: function() {0
                    
                        
                        getCreateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                CreatePopup.updateUrl(btnUrl);
                            });
                        });
                       
                    
                }
            };
        })();
    </script>
    @endsection
