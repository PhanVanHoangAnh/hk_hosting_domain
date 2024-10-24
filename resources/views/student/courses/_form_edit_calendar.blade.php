     <div id="dataSavedForm" class="d-none">
        <input readonly data-control="input" value="{{ isset($course->start_at) ? \Carbon\Carbon::parse($course->start_at)->format('Y-m-d') : '' }}" name="start_at" type="date" class="pe-none"/>
        <input readonly data-control="input" value="{{ isset($course->end_at) ? \Carbon\Carbon::parse($course->end_at)->format('Y-m-d') : '' }}" name="saved_end_at" type="date" class="pe-none"/>
        <input readonly data-control="input" type="number" value="{{ $course->total_hours ?? '' }}" class="pe-none" name="total_hours"/>
        <input readonly data-control="input" type="text" value="{{ $course->subject_id ?? '' }}" class="pe-none" name="subject_id"/> 
        <input readonly data-control="input" type="text" value="{{ $course->area ?? '' }}" class="pe-none" name="area"/> 
        <input readonly data-control="input" type="text" value="{{ $course->study_method ?? '' }}" class="pe-none" name="study_method"/>
        <input readonly data-control="input" type="text" 
                @php
                    $branchSaved = '';

                    if ($course->study_method == \App\Models\Course::STUDY_METHOD_OFFLINE) {
                        if (isset($course->training_location_id)) {
                            if (\App\Models\TrainingLocation::find($course->training_location_id)) {
                                $branchSaved = \App\Models\TrainingLocation::find($course->training_location_id)->branch;
                            }
                        }
    
                        if ($branchSaved == '') {
                            throw new \Exception("branch not found in edit course schedule screen!");
                        }
                    } else {
                        $branchSaved = 'none';
                    }
                @endphp
                value="{{ $branchSaved }}" 
                class="pe-none" name="branch"/> 
    </div>

    <div id="dataFillForm">
        <div class="row d-flex justify-content-between">
            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3 col-3">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2">Thời gian bắt đầu đổi</label>
                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                        <input name="time_to_change_schedule" time-data-control="time_to_change_schedule" data-control="input" value="{{ isset($course->time_to_change_schedule) ? \Carbon\Carbon::parse($course->time_to_change_schedule)->format('Y-m-d') : '' }}" placeholder="=asas" type="date" class="form-control" placeholder="Nhập thời gian bắt đầu đổi lịch"/>
                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                    </div>
                    <x-input-error :messages="$errors->get('time_to_change_schedule')" class="mt-2" />
                    </div>
                </div>
                
                <div class="col-lg-7 col-xl-7 col-md-7 col-sm-7 col-7 d-none">
                <div class="fs-2 fw-bold text-secondary mt-5 mb-3">
                    Chi tiết thời gian thời khóa biểu cũ
                </div>
                <table table-control="old-week-schedule-table" class="table table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="text-center">Thứ 2</th>
                            <th class="text-center">Thứ 3</th>
                            <th class="text-center">Thứ 4</th>
                            <th class="text-center">Thứ 5</th>
                            <th class="text-center">Thứ 6</th>
                            <th class="text-center">Thứ 7</th>
                            <th class="text-center">Chủ nhật</th>
                        </tr>
                    </thead>
                    <tbody form-control="table-body" class="border">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-10 p-0">
        <div class="col-lg-12 col-xl-5 col-md-12 col-sm-12 col-12 pe-6">
            <div class="fs-2 fw-bold text-secondary mt-5 mb-3">
                Cấu hình thời khóa biểu mới
            </div>
            <p>
                Sử dụng công cụ bên dưới để cấu hình thời gian học trong 1 tuần và áp dụng cho toàn bộ lịch học.
            </p>
            <div id="weekScheduleTool" class="position-relative z-index-1 border">
                <div class="d-flex">
                    <div class="">
                        <div class="nav nav-pills flex-column aos-init aos-animate bg-light" id="myTab" role="tablist" data-aos="fade-up">
                            <button row-data="day-button" day-name-data="mon" class="nav-link px-4 text-start py-5 text-nowrap position-relative active" id="d1-tab" data-bs-toggle="tab" data-bs-target="#monday" type="button" role="tab" aria-controls="monday" aria-selected="true">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 2</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="mon" style="top: 50%; right: -25%">3</span>
                            </button>
                            
                            <button row-data="day-button" day-name-data="tue" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#tuesday" type="button" role="tab" aria-controls="tuesday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 3</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="tue" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="wed" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#wednesday" type="button" role="tab" aria-controls="wednesday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 4</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="wed" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="thu" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#thursday" type="button" role="tab" aria-controls="thursday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 5</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="thu" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="fri" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#friday" type="button" role="tab" aria-controls="friday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 6</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="fri" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="sat" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#saturday" type="button" role="tab" aria-controls="saturday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 7</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="sat" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="sun" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#sunday" type="button" role="tab" aria-controls="sunday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">CN</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="sun" style="top: 50%; right: -25%">3</span>
                            </button>
                        </div>
                    </div>
                    <div class="w-100">
                        <div>
                            <div>
                                <div data-aos="fade-up" id="week-events-data-container" class="tab-content aos-init aos-animate w-100 px-10" id="myTabContent">
                                    <div class="tab-pane fade active show" row-data="day-in-week" day-name-data="mon" id="monday" role="tabpanel" aria-labelledby="d1-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="tue" id="tuesday" role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="wed" id="wednesday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="thu" id="thursday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="fri" id="friday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="sat" id="saturday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="sun" id="sunday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-between align-items-center">
                <button id="reset-week-schedule-btn" class="btn btn-light d-none">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2">
                            delete
                        </span>
                        <span>Xóa toàn bộ</span>
                    </span>
                </button>
            
                <button id="apply-week-schedule-btn" class="btn btn-info ms-auto">
                    <span class="d-flex align-items-center">
                        <span>Áp dụng</span>
                        <span class="material-symbols-rounded ms-2">
                            keyboard_double_arrow_right
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 mb-2 mt-4" form-control="timeAutoCaculatForm">
                <div class="card p-5">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6 border-end">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Giáo viên Việt Nam</label>
                                        </div>
                                        <div class="col-lg-4 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-4 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="vn_teacher_duration" value="0">
                                            <x-input-error :messages="$errors->get('vn_teacher_duration')" class="mt-2" />
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Giáo viên nước ngoài</label>
                                        </div>
                                        <div class="col-lg-4 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-4 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="foreign_teacher_duration" value="0">
                                            <x-input-error :messages="$errors->get('foreign_teacher_duration')" class="mt-2" />
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Gia sư</label>
                                        </div>
                                        <div class="col-lg-4 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-4 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="tutor_duration" value="0">
                                            <x-input-error :messages="$errors->get('tutor_duration')" class="mt-2" />
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Trợ giảng</label>
                                        </div>
                                        <div class="col-lg-4 col-xs-7 col-sm-7 col-7 col-md-7 col-xl-4 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="assistant_duration" value="0">
                                            <x-input-error :messages="$errors->get('assistant_duration')" class="mt-2" />
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 d-flex justify-content-center align-items-center">
                        <div form-control="auto-fill-values" class="fs-5 d-none">
                            Tổng&nbsp;<span class="fs-4 fw-semibold" data-control="total_dates">--</span>&nbsp;ngày
                            <span class="fw-bold">|</span>
                            Kết thúc vào ngày:<span class="fs-4 fw-semibold" data-control="end_date">--</span>
                            <input type="hidden" name="end_at" value="" readonly>
                        </div>
    
                        <div form-control="not-existing-autofill-values" class="fs-8 cursor-pointer"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                            title='Cần nhập thời gian bắt đầu, tổng số ngày cần học và có ít nhất một buổi học trong thời khóa biểu để hiện thông tin!'
                        >
                            <div class="form-outline">
                                <span class="d-flex align-items-center">
                                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                                        error
                                    </span>
                                    <span>Nhập đủ thông tin để hiện số ngày và ngày kết thúc!</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Phần lịch phía bên phải, kế bên form cấu hình tuần, bao gồm 2 tab lịch và danh sách các buổi học --}}
        <div class="col-lg-12 col-xl-7 col-md-12 col-sm-12 col-12 mt-14">
            {{-- Tabs menu --}}
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="fs-4 fw-semibold nav-link active" id="calendar-tab" data-bs-toggle="tab" href="#add-course-calendar-container" role="tab" aria-controls="add-course-calendar-container" aria-selected="true">Lịch</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="fs-4 fw-semibold nav-link" id="list-sections" data-bs-toggle="tab" href="#list-sections-tab" role="tab" aria-controls="list-sections-tab" aria-selected="false">Danh sách</a>
                </li>
            </ul>

            {{-- Tabs content --}}
            <div class="tab-content pt-5" id="tab-content">
                <div class="tab-pane content home active" id="add-course-calendar-container" role="tabpanel" aria-labelledby="calendar-tab">
                    {{-- LOAD CALENDAR HERE --}}
                </div>

                <div class="tab-pane" id="list-sections-tab" role="tabpanel" aria-labelledby="list-sections">
                    {{-- LOAD SECTIONS LIST HERE --}}
                </div>
            </div>
        </div>
    <hr class="my-10">
    <div class="form-outline d-flex justify-content-center">
        <div class="mb-10">
            <button id="doneAddCourseBtn" class="btn btn-primary me-1">Hoàn tất</button>
            <a href="{{ action('App\Http\Controllers\Student\CourseController@index') }}" id="cancelEditCalendarBtn"
                class="btn btn-light">Hủy</a>
        </div>
    </div>
<script>
    var oldWeekScheduleTable;
    var weekScheduleTool;
    var editCalendarManager;
    var calendar;
    var sectionsList; // Quản lý TAB 2: danh sách sections
    var addSchedulePopup;
    var timeAutoCaculatForm;

    $(() => {
        let weekEventsDataFromServer = undefined;
        let savedValues = undefined;
        let sectionsDataFromServer = undefined;

        @if (isset($course))
            weekEventsDataFromServer = {!! collect(json_decode($course->week_schedules))->map(function($section) {
                        return [
                            'name' => $section->name,
                            'schedules' => collect($section->schedules)->map(function($event) {
                                return [
                                    'id' => $event->id,
                                    'end_at' => $event->end_at,
                                    'start_at' => $event->start_at,
                                    'type' => isset($event->type) ? $event->type : null,
                                    'code' => isset($event->code) ? $event->code : "abcd1234",
                                    
                                    'is_vn_teacher_check' => $event->is_vn_teacher_check,
                                    'vn_teacher_id' => $event->vn_teacher_id,
                                    'vn_teacher_from' => $event->vn_teacher_from,
                                    'vn_teacher_to' => $event->vn_teacher_to,

                                    'is_foreign_teacher_check' => $event->is_foreign_teacher_check,
                                    'foreign_teacher_id' => $event->foreign_teacher_id,
                                    'foreign_teacher_from' => $event->foreign_teacher_from,
                                    'foreign_teacher_to' => $event->foreign_teacher_to,

                                    'is_tutor_check' => $event->is_tutor_check,
                                    'tutor_id' => $event->tutor_id,
                                    'tutor_from' => $event->tutor_from,
                                    'tutor_to' => $event->tutor_to,

                                    'is_assistant_check' => $event->is_assistant_check,
                                    'assistant_id' => $event->assistant_id,
                                    'assistant_from' => $event->assistant_from,
                                    'assistant_to' => $event->assistant_to,
                                ];
                            })
                        ];
                    }) !!}; 
        @endif

        @if (isset($sections))
            sectionsDataFromServer = {!! $sections !!};
        @endif

        oldWeekScheduleTable = new OldWeekScheduleTable({
            container: document.querySelector('[table-control="old-week-schedule-table"]'),
            weekEventsData: weekEventsDataFromServer
        });

        editCalendarManager = new EditCalendarManager({
            container: document.querySelector('#addCourseContainer'),
            savedEndAt: document.querySelector('[name="saved_end_at"]').value
        });

        /**
         * TAB 1: Calendar
         */
        calendar = new Calendar({
            container: document.querySelector('#add-course-calendar-container'),
            events: sectionsDataFromServer
        });

        /**
         * TAB 2: Sections list
         */
         sectionsList = new SectionsList({
            container: $('#list-sections-tab')
         })

        weekScheduleTool = new WeekScheduleTool({
            container: document.querySelector('#weekScheduleTool'),
            calendar: calendar,
            weekEventsData: weekEventsDataFromServer
        });

        timeAutoCaculatForm = new TimeAutoCaculatForm({
            container: editCalendarManager.getContainer().querySelector('[form-control="timeAutoCaculatForm"]')
        });

        addSchedulePopup = new AddSchedulePopup();
        suggestTeacherPopup = new SuggestTeacherPopup();
    });

    var WeekScheduleTool = class {
        addSchedulePopup = new Popup();
        startDate = null;
        endDate = null;
        totalDays = null;
        savedWeekEventsData;

        constructor(options) {
            this.container = options.container;
            this.calendar = calendar;
            this.savedWeekEventsData; // This is used to store the schedule before the change for calculating related information.

            if (typeof (options.weekEventsData) == 'undefined') {
                this.weekEventsData = [];
            } else {
                this.weekEventsData = options.weekEventsData;
            };

            this.init();
            this.setSavedWeekEventsData(options.weekEventsData);
        };

        setSavedWeekEventsData(savedWeekEventsData) {
            const tmp = JSON.stringify(savedWeekEventsData);

            this.savedWeekEventsData = JSON.parse(tmp);
        };

        getSavedWeekEventsData() {
            return this.savedWeekEventsData;
        };

        getWeekEventsData() {
            return this.weekEventsData;
        };

        getDayOfWeek(stringDate) {
            const daysOfWeek = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            const date = new Date(stringDate);
            const dayIndex = date.getDay();

            return daysOfWeek[dayIndex];
        };

        setWeekEventsData(newWeekEventsData) {
            this.weekEventsData = newWeekEventsData;
        };

        getApplyBtn() {
            return editCalendarManager.getContainer().querySelector('#apply-week-schedule-btn');
        };

        getResetBtn() {
            return editCalendarManager.getContainer().querySelector('#reset-week-schedule-btn');
        };

        getWeekEventsDataContainer() {
            return this.container.querySelector('#week-events-data-container');
        };

        getDayInWeekElements() {
            return this.getWeekEventsDataContainer().querySelectorAll('[row-data="day-in-week"]');
        };

        getDayButtonElements() {
            return this.container.querySelectorAll('[row-data="day-button"]');
        };

        getSchedulePerDayInHtml(eventSchedules, dayName) {
            let content = `<ul class="list-unstyled mb-0">`
                        
            eventSchedules.forEach(schedule => {
                // Convert String -> Date()
                const startTimeParts = schedule.start_at.split(':');
                const endTimeParts = schedule.end_at.split(':');
                const startTime = new Date();
                const endTime = new Date();

                startTime.setHours(parseInt(startTimeParts[0], 10), parseInt(startTimeParts[1], 10), 0);
                endTime.setHours(parseInt(endTimeParts[0], 10), parseInt(endTimeParts[1], 10), 0);

                // Caculate hours (In decimal)
                const elapsedHours = ((endTime - startTime) / (1000 * 60 * 60)).toFixed(2); // Devide ms

                content += 
                `
                    <li class="d-flex flex-column flex-md-row py-4 justify-content-center align-items-center">
                        <div class="align-self-center">
                            <div class="flex-grow-1 ps-4">
                                <h4><span>${schedule.start_at} - ${schedule.end_at}</span></h4>
                                <div data-control="duration-per-week-schedule-item" class="mb-0 text-wrap">
                                    ${elapsedHours} giờ
                                </div>
                            </div>
                        </div>
                        <span list-action="schedule-item-more-vert" class="material-symbols-rounded ps-10 d-flex align-items-center cursor-pointer" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            more_vert
                        </span>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a data-dayname-control="${dayName}" data-id-control="${schedule.id}" href="javascript:;" row-action="delete" class="menu-link px-3">Xóa</a>
                        </div>
                        <div class="menu-item px-3">
                            <a data-dayname-control="${dayName}" data-id-control="${schedule.id}" href="javascript:;" row-action="edit" class="menu-link px-3">Chỉnh sửa</a>
                        </div>
                    </li>
                `
            });
            
            content += `</ul>`;

            content += 
            `
                <div class="row w-100 mt-10 d-flex justify-content-center">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 fs-5 w-100 d-flex justify-content-center">
                        <div day-data="${dayName}" list-action="course-add-schedule" class="btn btn-light btn-sm">
                            <span class="material-symbols-rounded">
                                add
                                </span>
                            &nbsp;&nbsp;Thêm lịch
                        </div>
                    </div>
                </div>
            `

            return content;
        };

        getNotExistContentInHtml(dayName) {
            const content = 
            `
                <div class="mt-10" data-control="not-exist-schedule">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <p class="fs-3 d-flex justify-content-center align-items-center">
                                <span class="text-danger me-2">
                                    <span class="material-symbols-rounded me-1 fs-2" style="vertical-align: middle;">
                                        error
                                    </span>
                                </span>
                                <span>Chưa có lịch học trong ngày này</span>
                            </p>
                            <span class="d-flex">
                                <span>Bạn có thể thêm lịch học bằng cách nhấn nút thêm lịch bên dưới!</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mt-10 d-flex justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 fs-5 w-100 d-flex justify-content-center">
                        <div day-data="${dayName}" list-action="course-add-schedule" class="btn btn-light btn-sm d-flex align-items-center justify-content-center">
                            <span class="material-symbols-rounded">
                                add
                                </span>
                            &nbsp;&nbsp;Thêm lịch
                        </div>
                    </div>
                </div>
            `
            return content;
        };

        getAddScheduleButtons() {
            return this.container.querySelectorAll('[list-action="course-add-schedule"]');
        };

        getDeleteScheduleBtns() {
            return this.container.querySelectorAll('[row-action="delete"]');
        };

        getEditScheduleBtns() {
            return this.container.querySelectorAll('[row-action="edit"]');
        };

        getNotificationBadge() {
            return this.container.querySelectorAll('[data-action="notification-badge"]');
        };

        getDaysHaveEventsData() {
            const weekSchedules = this.getWeekEventsData();
            const daysHaveEvents = [];

            for(let schedule of weekSchedules) {
                if (daysHaveEvents.length === 7) {
                    break;
                };

                const numEvents = schedule.schedules.length;

                if (numEvents > 0) {
                    const dayData = {
                        name: schedule.name,
                        numEvents: numEvents
                    };

                    daysHaveEvents.push(dayData);
                };
            };

            return daysHaveEvents;
        };

        loadNotificationBadge() {
            const notificationBadges = Array.from(this.getNotificationBadge());
            const daysHaveEvents = this.getDaysHaveEventsData();

            if (daysHaveEvents.length === 0) {
                notificationBadges.forEach(badge => {
                    badge.classList.add('d-none');
                });

                return;
            };

            daysHaveEvents.forEach(dayData => {
                const matchingBadge = notificationBadges.find(badge => dayData.name === badge.getAttribute('day-name-data'));

                if (matchingBadge) {
                    matchingBadge.innerHTML = dayData.numEvents;
                    matchingBadge.classList.remove('d-none');
                };
            });

            notificationBadges.forEach(badge => {
                const badgeDayName = badge.getAttribute('day-name-data');
                const isDayWithoutEvent = !daysHaveEvents.some(dayData => dayData.name === badgeDayName);

                if (isDayWithoutEvent) {
                    badge.classList.add('d-none');
                };
            });
        };

        init() {
            this.render();
            this.events();
        };

        render() {
            const weekEvents = this.getWeekEventsData();
            const dayInWeekElements = this.getDayInWeekElements();
            const dayButtonElements = this.getDayButtonElements();
            const elementsByDayName = {};
            const elementButtonsByDayName = {};

            dayInWeekElements.forEach(day => {
                const dayName = day.getAttribute('day-name-data');
                elementsByDayName[dayName] = day;
            });

            dayButtonElements.forEach(button => {
                const dayName = button.getAttribute('day-name-data');
                elementButtonsByDayName[dayName] = button;
            });

            weekEvents.forEach(event => {
                const dayName = event.name;
                const eventSchedules = event.schedules;

                const matchingElement = elementsByDayName[dayName];
                const matchingButton = elementButtonsByDayName[dayName];

                if (matchingElement) {
                    matchingElement.innerHTML = this.getSchedulePerDayInHtml(eventSchedules, dayName);
                };
            });

            const unMatchingName = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'].filter(dayName => !weekEvents.some(event => event.name === dayName));

            dayInWeekElements.forEach(day => {
                const dayName = day.getAttribute('day-name-data');

                if (unMatchingName.includes(dayName)) {
                    day.innerHTML = this.getNotExistContentInHtml(dayName);
                };
            });

            this.loadNotificationBadge();
            this.eventsAfterRender();
        };

        getDayIndex(dayName) {
            const days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            return days.indexOf(dayName);
        };

        getStartDate() {
            return this.startDate;
        };

        setStartDate(newStartDate) {
            this.startDate = newStartDate;
        };

        getEndDate() {
            return this.endDate;
        };

        setEndDate(newEndDate) {
            this.endDate = newEndDate;
        };

        validateWhenUpdateCalendar() {
            let isValid = true;
            const _this = this;

            const now = new Date(Date.now());
            const endDate = new Date(editCalendarManager.getSavedEndAt());
            const timeToChange = new Date(editCalendarManager.getTimeToChangeScheduleValue());

            const startDate = editCalendarManager.getStartDateInputValue();
            const totalHours = editCalendarManager.getTotalHoursInputValue();
            const weekSchedules = this.getWeekEventsData();

            now.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);
            timeToChange.setHours(0, 0, 0, 0);

            if (!(startDate && totalHours && parseInt(totalHours) > 0 && weekSchedules.length > 0)) {
                isValid = false;
                _this.alertError('Cần nhập đủ thời gian bắt đầu học, tống số giờ cần học và có ít nhất 1 buổi học trong thời khóa biểu!');
            };

            // if ((now > endDate)) {
            //     isValid = false;
            //     _this.alertError('Lớp học này đã hoàn thành, không thể chỉnh sửa thời khóa biểu!');
            // }

            // if (timeToChange < now) {
            //     isValid = false;
            //     _this.alertError('Không được phép sửa thời khóa biểu trong quá khứ!');
            // }

            return isValid;
        };

        alertError(message) {
            ASTool.addPageLoadingEffect();

            ASTool.alert({
                icon: 'warning',
                message: message
            });

            ASTool.removePageLoadingEffect();
        };

        /**
         * @param weekSchedule The week schedule data
         * @param startTime The start time of the range
         * @param endTime The end time of the range
         * @returns The total hours within the time range
         */
        caculateTotalHoursWithinRangeTime(weekSchedule, startTime, endTime) {
            const startDate = new Date(startTime);
            const endDate = new Date(endTime);
            let totalMinutes = 0;
            let dayName = timeAutoCaculatForm.getDayOfWeek(startDate);
            const daysOfWeek = editCalendarManager.getDaysOfWeek();

            // Iterate through each day within the time range.
            for (var currentDate = startDate; currentDate <= endDate; currentDate.setDate(currentDate.getDate() + 1)) {
                const dayOfWeek = currentDate.getDay();
                const dayOfWeekString = daysOfWeek[dayOfWeek];

                // Check if there are events scheduled on the current day.
                for(const day of weekSchedule) {
                    if (day.name === dayOfWeekString) {
                        // Calculate the duration of each event and add it to the total minutes.
                        day.schedules.forEach(event => {
                            const start = timeAutoCaculatForm.convertToMinutes(event.start_at);
                            const end = timeAutoCaculatForm.convertToMinutes(event.end_at);
                            const duration = end - start;
                            totalMinutes += duration;
                        });
                    }
                }
            }

            // Convert the total minutes to hours and return.
            return totalMinutes / 60;
        };

        convertSchedules(weekScheduleData, startTime, endTime) {
            const _this = this;
            let events = [];

            const startDate = new Date(startTime);
            const endDate = new Date(endTime);

            while (startDate <= endDate) {
                const dayOfWeek = startDate.toLocaleDateString('en-US', {weekday: 'long'}).slice(0, 3).toLowerCase();
                const dateNameString = startDate.toISOString().split('T')[0];

                for (const day of weekScheduleData) {
                    if (day.name === dayOfWeek) {
                        day.schedules.forEach(schedule => {
                            const studyDate = dateNameString;
                            const startAt = studyDate + ' ' + schedule.start_at;
                            const endAt = studyDate + ' ' + schedule.end_at;

                            // Create an event object and add it to the events array
                            events.push({
                                study_date: studyDate,
                                start_at: startAt,
                                end_at: endAt,
                                code: schedule.code,
                                type: schedule.type,

                                is_vn_teacher_check: schedule.is_vn_teacher_check,
                                vn_teacher_id: !isNaN(parseInt(schedule.vn_teacher_id)) ? schedule.vn_teacher_id : null,
                                vn_teacher_from: schedule.vn_teacher_from,
                                vn_teacher_to: schedule.vn_teacher_to,

                                is_foreign_teacher_check: schedule.is_foreign_teacher_check,
                                foreign_teacher_id: !isNaN(parseInt(schedule.foreign_teacher_id)) ? schedule.foreign_teacher_id : null,
                                foreign_teacher_from: schedule.foreign_teacher_from,
                                foreign_teacher_to: schedule.foreign_teacher_to,

                                is_tutor_check: schedule.is_tutor_check,
                                tutor_id: !isNaN(parseInt(schedule.tutor_id)) ? schedule.tutor_id : null,
                                tutor_from: schedule.tutor_from,
                                tutor_to: schedule.tutor_to,

                                is_assistant_check: schedule.is_assistant_check,
                                assistant_id: !isNaN(parseInt(schedule.assistant_id)) ? schedule.assistant_id : null,
                                assistant_from: schedule.assistant_from,
                                assistant_to: schedule.assistant_to,
                            });
                        });
                    }
                }

                startDate.setDate(startDate.getDate() + 1); // day++
            };

            return events;
        }

        getEventsInEventsDataByDateRange(events, dateFrom, dateTo) {
            // Convert the start and end dates into Date objects
            const startDate = new Date(dateFrom);
            const endDate = new Date(dateTo);

            // Truncate the hours, minutes, seconds, and milliseconds of the start and end dates
            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            // filter the array based on the date
            const filteredArray = events.filter(event => {
                // Convert the event date into a Date object,
                const studyDate = new Date(event.study_date);

                // Truncate the hours, minutes, seconds, and milliseconds of the event date
                studyDate.setHours(0, 0, 0, 0);

                // Compare the event date with the date range start and end
                return studyDate >= startDate && studyDate < endDate;
            });

            return filteredArray;
        }

        convertSchedulesToEvents(timeToChange) {
            const _this = this;
            let eventResults;
            const savedEvents = calendar.getSavedEventsData();
            
            /**
             * (*) In case the timeToChange parameter is passed,
             * it means that the function is currently converting from the old schedule to the sections
             * within the time range from the old start time until the schedule change point (timeToChange).
             * 
             * (*) If the timeToChange parameter is not passed, 
             * it means that the function is converting the old schedule into events from the start date until the schedule change point. 
             * Convert the schedule after the change into events from the change date to the end date (This end date is calculated from the time of schedule change)..
             */
            if (!timeToChange) {
                const startDate = new Date(editCalendarManager.getStartDateInputValue());
                const endDate = new Date(timeAutoCaculatForm.getEndDate());
                eventResults = _this.convertSchedules(this.getWeekEventsData(), startDate, endDate);
            } else {
                const oldWeekSchedule = this.getSavedWeekEventsData();
                const newWeekSchedule = this.getWeekEventsData();

                const oldStartDate = new Date(editCalendarManager.getStartDateInputValue());
                const dateToChange = new Date(timeToChange);

                _this.getEventsInEventsDataByDateRange(savedEvents, oldStartDate, dateToChange)

                const totalHoursOfOldEvents = this.caculateTotalHoursWithinRangeTime(oldWeekSchedule, oldStartDate, dateToChange);
                const totalHoursFromTimeToChange = parseFloat(editCalendarManager.getTotalHoursInputValue()) - parseFloat(totalHoursOfOldEvents);

                const totalDaysFromTimeToChange = timeAutoCaculatForm.caculateTotalDays(newWeekSchedule, totalHoursFromTimeToChange, timeToChange);
                const endDateCaculateFromTimeToChange = new Date(timeAutoCaculatForm.caculateEndDate(timeToChange, totalDaysFromTimeToChange));
                
                const eventsConvertedFromOldSchedule = _this.getEventsInEventsDataByDateRange(savedEvents, oldStartDate, dateToChange); // Get old events (Old start date -> timeToChange)
                const eventsConvertedFromEditedSchedule = _this.convertSchedules(newWeekSchedule, dateToChange, endDateCaculateFromTimeToChange); // Get new events (timeToChange -> endDate caculate from timeToChange)

                eventsConvertedFromOldSchedule.forEach(event => {
                    event.is_modified = false;
                });

                eventsConvertedFromEditedSchedule.forEach(event => {
                    event.is_modified = true;
                });

                eventResults = eventsConvertedFromOldSchedule.concat(eventsConvertedFromEditedSchedule); // Get all events (Old start date -> endDate caculate from timeToChange)

                /**
                 * Search through the array of newly converted events and compare it with the array of sections previously saved in the database. 
                 * Find matching sections in the two arrays, and if found, 
                 * add a 'section_id' field to the corresponding element in the new array, matching the id of the section in the previously saved sections array
                 */
                for (const event of eventResults) {
                    const matchingEvents = savedEvents.filter(savedEvent => savedEvent.code === event.code);

                    if (matchingEvents.length > 0) {
                        let matchingStudyDateConverted;
                        let eventStudyDateConverted;

                        for (const matchingEvent of matchingEvents) {
                            if (matchingEvent.study_date.split(' ').length > 1) {
                                matchingStudyDateConverted = matchingEvent.study_date.split(' ')[0];
                            } else {
                                matchingStudyDateConverted = matchingEvent.study_date;
                            };

                            if (event.study_date.split(' ').length > 1) {
                                eventStudyDateConverted = event.study_date.split(' ')[0];
                            } else {
                                eventStudyDateConverted = event.study_date;
                            };

                            if (matchingStudyDateConverted === eventStudyDateConverted) {
                                event.section_id = matchingEvent.id;
                            };
                        }
                    }
                }
            };

            return eventResults;
        };

        isDateWithinRange(startDate, endDate, checkDate) {
            startDate = new Date(startDate);
            endDate = new Date(endDate);
            checkDate = new Date(checkDate);

            return checkDate >= startDate && checkDate <= endDate;
        };

        isDateBeforeStartDate(startDate, checkDate) {
            startDate = new Date(startDate);
            checkDate = new Date(checkDate);

            return checkDate <= startDate;
        };

        applyToCalendar() {
            let currCalendarEvents = {};
            const startDate = editCalendarManager.getStartDateInputValue();
            const endDate = timeAutoCaculatForm.getEndDate();
            const timeToChange = editCalendarManager.getTimeToChangeScheduleValue();
            const newCalendarEvents = this.convertSchedulesToEvents(timeToChange);

            // Create a new object in a new memory location distinct from the memory containing calendar.getDateData()
            currCalendarEvents.date = calendar.getDateData().date;
            currCalendarEvents.events = calendar.getDateData().events;

            calendar.updateEvents(newCalendarEvents);
            timeAutoCaculatForm.run();
        };

        setChedules(newSchedules) {
            this.setWeekEventsData(newSchedules);
        };

        getCurrEventItemData(id) {
            const weekEvents = this.getWeekEventsData();
            let currEventItem;
            let founded = false;
            
            for(const eventDay of weekEvents) {
                if (eventDay.schedules.length > 0 && founded === false) {
                    for(event of eventDay.schedules) {
                        if (event.id === id) {
                            currEventItem = event;
                            founded = true;
                            break;
                        };
                    };
                };
            };

            return currEventItem;
        };

        deleteScheduleItem(dayName, id) {
            const weekEvents = this.getWeekEventsData();

            weekEvents.forEach(event => {
                if (event.name === dayName) {
                    const index = event.schedules.findIndex(item => item.id === id);

                    if (index > -1) {
                        event.schedules.splice(index, 1);
                    };
                };
            });

            weekEvents.forEach(event => {
                if (event.schedules.length === 0) {
                    const index = weekEvents.findIndex(item => item.name === event.name);

                    if (index > -1) {
                        weekEvents.splice(index, 1);
                    };
                };
            });

            this.render();
            this.loadNotificationBadge();
        };

        filterAddLaterEvents() {
            const currWeekEvents = this.convertSchedulesToEvents();
            const currCalendarEvents = calendar.getDateData().events;

            const fiteredEvents = currCalendarEvents.filter(calendarEvent => {
                return !currWeekEvents.some(weekEvent => calendarEvent.code === weekEvent.code);
            });

            return fiteredEvents;
        };

        resetWeekScheduleEventsFromCalendar() {
            calendar.updateAllEvents(this.filterAddLaterEvents());
        };

        reset() {
            this.setStartDate('2023-01-01');
            this.setEndDate('2023-01-02');
            this.setChedules([]);
            this.render();
            this.loadNotificationBadge();
            timeAutoCaculatForm.run();
        };

        eventsAfterRender() {
            const _this = this;

            _this.getAddScheduleButtons().forEach(button => {
                $(button).on('click', e => {
                    e.preventDefault();

                    const subjectId = editCalendarManager.getSavedSubjectIdValue();

                    if (!subjectId) {
                        throw new Error("Bugs: subjectId not found!");
                    }

                    // Nếu chọn phương thức học online thì cho phép tất cả giáo viên
                    // Nếu chọn phương thức học offline thì bắt buộc phải có chọn branch
                    // => Show staffs by branch
                    const studyMethod = editCalendarManager.getSavedStudyMethodValue();
                    const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
                    const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";
                    let area = 'all';

                    if (studyMethod === "" || !studyMethod) {
                        ASTool.alert({
                            message: "Vui lòng chọn hình thức học!",
                            icon: 'warning' 
                        })

                        return;
                    } else if (studyMethod === offlineMethod) {
                        const branch = editCalendarManager.getSavedBranchValue();

                        if (typeof branch == 'undefined' || !branch) {
                            // Not select any branch
                            ASTool.alert({
                                message: "Vui lòng chọn chi nhánh!",
                                icon: 'warning'
                            })

                            // Stop
                            return;
                        }

                        // Must select branch
                        switch(branch) {
                            case 'HN':
                                area = 'HN';
                                break;
                            case 'SG':
                                area = 'SG';
                                break;
                            default:
                                area = 'all';
                                break;
                        }
                    }

                    var dayName = button.getAttribute('day-data');
                    const url = "{{ action('App\Http\Controllers\Student\CourseController@addSchedule') }}";

                    addSchedulePopup.getPopup().method = 'get';

                    addSchedulePopup.setData({
                        day_name: dayName,
                        subject_id: subjectId,
                        area: area,
                    });

                    addSchedulePopup.updateUrl(url);
                });
            });

            _this.getDeleteScheduleBtns().forEach(button => {
                $(button).on('click', e => {
                    e.preventDefault();

                    ASTool.confirm({
                        message: "Bạn có chắc xóa buổi học này không?",
                        ok: function() {
                            ASTool.addPageLoadingEffect();

                            const dayName = button.getAttribute('data-dayname-control');
                            const id = button.getAttribute('data-id-control');

                            _this.deleteScheduleItem(dayName, id);
                            
                            ASTool.alert({
                                message: "Xóa buổi học thành công!",
                            });

                            ASTool.removePageLoadingEffect();
                        }
                    });
                });
            });

            _this.getEditScheduleBtns().forEach(button => {
                $(button).on('click', e => {
                    e.preventDefault();

                    const subjectId = editCalendarManager.getSavedSubjectIdValue();

                    if (!subjectId) {
                        throw new Error("Bugs: subjectId not found!");
                    }

                    // Nếu chọn phương thức học online thì cho phép tất cả giáo viên
                    // Nếu chọn phương thức học offline thì bắt buộc phải có chọn branch
                    // => Show staffs by branch
                    const studyMethod = editCalendarManager.getSavedStudyMethodValue();
                    const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
                    const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";
                    let area = 'all';

                    if (studyMethod === "" || !studyMethod) {
                        ASTool.alert({
                            message: "Vui lòng chọn hình thức học!",
                            icon: 'warning' 
                        })

                        return;
                    } else if (studyMethod === offlineMethod) {
                        const branch = editCalendarManager.getSavedBranchValue();

                        if (typeof branch == 'undefined' || !branch) {
                            // Not select any branch
                            ASTool.alert({
                                message: "Vui lòng chọn chi nhánh!",
                                icon: 'warning'
                            })

                            // Stop
                            return;
                        }

                        // Must select branch
                        switch(branch) {
                            case 'HN':
                                area = 'HN';
                                break;
                            case 'SG':
                                area = 'SG';
                                break;
                            default:
                                area = 'all';
                                break;
                        }
                    }
                    
                    const url = "{{ action('App\Http\Controllers\Student\CourseController@editSchedule') }}";
                    const id = button.getAttribute('data-id-control');
                    const currItem = _this.getCurrEventItemData(id);

                    currItem.dayName = button.getAttribute('data-dayname-control');
                    currItem.subject_id = subjectId;
                    currItem.area = area;

                    addSchedulePopup.getPopup().method = 'get';
                    addSchedulePopup.setData(currItem);
                    addSchedulePopup.updateUrl(url);
                });
            });

            if ($(editCalendarManager.getContainer())[0]) {
                initJs($(editCalendarManager.getContainer())[0]);
            };
        };

        events() {
            const _this = this;

            $(_this.getApplyBtn()).on('click', e => {
                e.preventDefault();

                if (_this.validateWhenUpdateCalendar()) {
                    ASTool.addPageLoadingEffect();
                    
                    _this.applyToCalendar();

                    ASTool.alert({
                        message: "Áp dụng thời khóa biểu thành công!",
                    });
    
                    ASTool.removePageLoadingEffect();    
                };
            });

            $(_this.getResetBtn()).on('click', e => {
                e.preventDefault();

                ASTool.confirm({
                    message: "Bạn có chắc muốn reset lại toàn bộ thời khóa biểu không?",
                    ok: function() {
                        ASTool.addPageLoadingEffect();
                        
                        _this.reset();

                        ASTool.alert({
                            message: "Reset thời khóa biểu thành công!",
                        });

                        ASTool.removePageLoadingEffect();
                    }
                });
            });

            if ($(editCalendarManager.getContainer())[0]) {
                initJs($(editCalendarManager.getContainer())[0]);
            };
        };

        getSaveScheduleItemDataBtn() {
            return document.querySelector('[data-action="add-schedule-btn"]');
        };

        getClosePopupBtns() {
            return document.querySelectorAll('[data-action="close-add-course-week-event-popup"]');
        };

        addEventToWeekEventsData(newEvent) {
            const existingEvent = this.getWeekEventsData().find(event => event.name === newEvent.name);

            /**
             * If there is already a schedule for that day in the weekly timetable, add the schedule to that day; 
             * Otherwise, create a new day and add the schedule to it
             */ 
            if (existingEvent) {
                existingEvent.schedules = existingEvent.schedules.concat(newEvent.schedules);
            } else {
                this.getWeekEventsData().push(newEvent);
            };
        };

        generateUniqueId() {
            const timestamp = Date.now().toString(36);
            const randomString = Math.random().toString(36).substr(2, 5);

            return timestamp + randomString;
        };

        createNewWeekEvent(data) {
            const scheduleItemGetted = {
                id: this.generateUniqueId(), // Use this value to define the event in case delete or update week schedule item
                start_at: data.start_at,
                end_at: data.end_at,
                color: data.color,
                type: data.type,

                is_vn_teacher_check: data.is_vn_teacher_check,
                vn_teacher_id: data.vn_teacher_id,
                vn_teacher_from: data.vn_teacher_from,
                vn_teacher_to: data.vn_teacher_to,

                is_foreign_teacher_check: data.is_foreign_teacher_check,
                foreign_teacher_id: data.foreign_teacher_id,
                foreign_teacher_from: data.foreign_teacher_from,
                foreign_teacher_to: data.foreign_teacher_to,

                is_tutor_check: data.is_tutor_check,
                tutor_id: data.tutor_id,
                tutor_from: data.tutor_from,
                tutor_to: data.tutor_to,

                is_assistant_check: data.is_assistant_check,
                assistant_id: data.assistant_id,
                assistant_from: data.assistant_from,
                assistant_to: data.assistant_to,
                code: data.code,
            };

            const weekEventGetted = {
                name: data.day_name,
                schedules: []
            };

            weekEventGetted.schedules.push(scheduleItemGetted);

            return weekEventGetted;
        };

        getTotalDays() {
            return this.totalDays;
        };

        /**
         * Check if the study time of the given schedule item overlaps with the target time range.
         * @param schedule Given schedule item
         * @param targetStartTime Start time target
         * @param targetEndTime End time target
         * @return Boolean
         */
         isTimeOverlap(schedule, targetStartTime, targetEndTime) {
            const startTime = parseInt(schedule.start_at.split(':')[0] * 60 + parseInt(schedule.start_at.split(':')[1]));
            const endTime = parseInt(schedule.end_at.split(':')[0] * 60 + parseInt(schedule.end_at.split(':')[1]));

            const targetStart = parseInt(targetStartTime.split(':')[0] * 60 + parseInt(targetStartTime.split(':')[1]));
            const targetEnd = parseInt(targetEndTime.split(':')[0] * 60 + parseInt(targetEndTime.split(':')[1]));

            return (startTime < targetEnd && endTime > targetStart);
        };

        /**
         * Check if there is a time conflict with any existing class schedules
         * @param data New week schedule item
         * @return Boolean
         */ 
        validateTimeConflict(data) {
            const _this = this;
            const currWeekSchedule = this.getWeekEventsData();

            let isOverLap = false;

            // Check for duplicates for each item in current week schedule.
            currWeekSchedule.forEach(scheduleItem => {
                const dayName = scheduleItem.name.toLowerCase();

                if (dayName === data.day_name) {
                    scheduleItem.schedules.forEach(event => {
                        if (_this.isTimeOverlap(data, event.start_at, event.end_at)) {
                            isOverLap = true;
                            return; // End the loop when a duplicate is found.
                        }
                    });
                };

                if (isOverLap) {
                    return; // End the loop when a duplicate is found.
                };
            });

            return isOverLap;
        };

        saveNewWeekEvent(data) {
            this.addEventToWeekEventsData(this.createNewWeekEvent(data));
            this.render();
        };

        updateEvent(event) {
            this.deleteScheduleItem(event.day_name, event.id);
            this.saveNewWeekEvent(event);
        };
    };

    /**
     * TAB 1: Quản lý tab 1 -> Các sections ở nằm trên dạng tờ lịch
     * Dữ liệu sections ở đây cũng sẽ được truyền qua cho TAB 2 (Class SectionsList)
     * để render ra dữ liệu danh sách các sections đúng với dữ liệu hiện ở lịch
     * Khi class này chạy hàm render thì cũng sẽ gọi tới hàm render của class SectionsList
     * để đồng thời cập nhật dữ liệu ở cả 2 TAB
     */
    var Calendar = class {
        constructor(options) {
            this.container = options.container;
            this.currentDate = this.createCurrentDate();
            this.savedEventsData;

            this.dateData = {
                date: this.currentDate,
                events: []
            };

            if (typeof (options.events) == 'undefined') {
                this.dateData.events = [];
            } else {
                this.dateData.events = options.events;
            };

            this.init();
            this.setSavedEventsData(options.events);
        };

        setSavedEventsData(savedEventsData) {
            const tmp = JSON.stringify(savedEventsData);

            this.savedEventsData = JSON.parse(tmp);
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
         */
        updateEvents(newEvents) {
            const currCalendarEvents = this.getDateData().events;
            const eventNeedRemoveIndexs = []; // The array of event indexs add in calendar need remove

            for(let i = 0; i < currCalendarEvents.length; ++i) {
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
            const events = this.getDateData().events;

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
            this.render();

            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

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

        getTotalMonth(currDate) {
            const _this = this;
            const yearAndMonthPart = _this.getPartYearAndMonth(currDate);
            let date = new Date(yearAndMonthPart);

            if (isNaN(date.getTime())) {
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
            if (currDateArr.length > 1) {
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
                const totalMonthOfEvent = _this.getTotalMonth(event.study_date);

                if (parseInt(totalMonthOfEvent) === parseInt(totalMonthOfCurrDate)) {
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

            _this.sortEventsByStartAt();

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

                if ($(this.getContainer())[0]) {
                    initJs($(this.getContainer())[0]);
                };

                _this.removeLoadEffect();
                
            }).fail(response => {
                throw new Error(response);
            })
        };
    };

    /**
     * TAB 2: Quản lý tab 2 -> các sections ở dạng danh sách
     * Class này lấy dữ liệu các sections từ TAB 1 (Tờ lịch)
     * -> Khi render dữ liệu ra UI thì dữ liệu được lấy từ Calendar
     */
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
            data.totalHours = editCalendarManager.getTotalHoursInputValue();
            data.events = JSON.stringify(calendar.dateData.events);

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

                if($(this.getContainer())[0]) {
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

    var AddSchedulePopup = class {
        constructor(options) {
            this.popup = new Popup();
        };

        setData(data) {
            data._token = "{{ csrf_token() }}";
            this.popup.setData(data);
        };

        updateUrl(newUrl) {
            this.popup.url = newUrl;
            this.popup.load();
        };

        getPopup() {
            return this.popup;
        };

        hide() {
            this.popup.hide();
        };
    };

    var SuggestTeacherPopup = class {
        constructor(options) {
            this.popup = new Popup();
        };

        setData(data) {
            data._token = "{{ csrf_token() }}";
            this.popup.setData(data);
        };

        updateUrl(newUrl) {
            this.popup.url = newUrl;
            this.popup.load();
        };

        getPopup() {
            return this.popup;
        };

        hide() {
            this.popup.hide();
        };
    };

    var EditCalendarManager = class {
        daysOfWeek = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        constructor(options) {
            this.container = options.container;
            this.form = this.container.querySelector('#editCalendarForm');
            this.savedEndAt;

            if (typeof (options.savedEndAt) == 'undefined') {
                this.savedEndAt = null;
            } else {
                this.savedEndAt = options.savedEndAt;
            };

            this.init();
        };

        getCancelBtn() {
            return this.container.querySelector('#cancelEditCalendarBtn');
        };

        getSavedEndAt() {
            return this.savedEndAt;
        };

        getSavedSubjectIdInput() {
            return this.getContainer().querySelector('[name="subject_id"]');
        }

        getSavedSubjectIdValue() {
            return this.getSavedSubjectIdInput().value;
        }

        getSavedStudyMethodInput() {
            return this.getContainer().querySelector('[name="study_method"]');
        }

        getSavedStudyMethodValue() {
            return this.getSavedStudyMethodInput().value;
        }

        getSavedAreaInput() {
            return this.getContainer().querySelector('[name="area"]');
        }

        getSavedAreaValue() {
            return this.getSavedAreaInput().value;
        }

        getSavedBranchInput() {
            return this.getContainer().querySelector('[name="branch"]');
        }

        getSavedBranchValue() {
            return this.getSavedBranchInput().value;
        }

        getStartDateInput() {
            return this.getContainer().querySelector('[name="start_at"]');
        };

        getTimeToChangeScheduleInput() {
            return this.getContainer().querySelector('[time-data-control="time_to_change_schedule"]');
        };

        getTimeToChangeScheduleValue() {
            return this.getTimeToChangeScheduleInput().value;
        };

        createCurrentDate() {
            const currentDateObject = new Date();
            const year = currentDateObject.getFullYear();
            const month = String(currentDateObject.getMonth() + 1).padStart(2, '0');
            const day = String(currentDateObject.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        loadTimeToChangeSchedule(time) {
            this.getTimeToChangeScheduleInput().value = time;
        };

        setStartDateInput(value) {
            this.getContainer().querySelector('[name="start_at"]').value = value;
        };

        getStartDateInputValue() {
            return this.getStartDateInput().value;
        };

        getTotalHoursInput() {
            return this.getContainer().querySelector('[name="total_hours"]');
        };

        getTotalHoursInputValue() {
            return this.getTotalHoursInput().value;
        };

        getContainer() {
            return this.container;
        };

        getDaysOfWeek() {
            return this.daysOfWeek;
        };

        getForm() {
            return this.form;
        };

        getFormData() {
            return $(this.getForm()).serialize();
        };

        getSubmitBtn() {
            return this.container.querySelector('#doneAddCourseBtn');
        };

        loadTotalDays() {
            this.getTotalDaysLabel().innerHTML = this.getTotalDays();
        };

        loadEndDate() {
            this.getEndDateLabel().innerHTML = this.convertDate(this.getEndDate());
        };

        addSubmitEffect() {
            this.getSubmitBtn().setAttribute('data-kt-indicator', 'on');
            this.getSubmitBtn().setAttribute('disabled', true);
        };
    
        removeSubmitEffect() {
            this.getSubmitBtn().removeAttribute('data-kt-indicator');
            this.getSubmitBtn().removeAttribute('disabled');
        };
    
        addLoadingEffect() {
            this.getContainer().classList.add("list-loading");
        };
    
        removeLoadingEffect() {
            this.getContainer().classList.remove("list-loading");
            if (this.getContainer().querySelector('[list-action="loader"]')) {
                this.getContainer().querySelector('[list-action="loader"]').remove();
            };
            KTComponents.init();
        };

        submit() {
            const url = this.getForm().getAttribute('action');
            const eventsData = calendar.getEvents();

            eventsData.forEach(event => {
                event.is_modified = false;
            });

            const data = {
                _token: "{{ csrf_token() }}",
                form: this.getFormData(),
                events: JSON.stringify(eventsData),
                week_schedules: weekScheduleTool.getWeekEventsData(),
            };

            this.addSubmitEffect();
            this.addLoadingEffect();

            $.ajax({
                url: url,
                method: 'PUT',
                contentType: "application/json",
                data: JSON.stringify(data),
            }).done(response => {
                this.removeSubmitEffect();
                this.removeLoadingEffect();

                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        this.addLoadingEffect();
                        window.location.href = "{{ action('App\Http\Controllers\Student\CourseController@index') }}";
                    }
                });

            }).fail(response => {
                let updateContent = $(response.responseText).find('#dataFillForm');

                this.removeSubmitEffect();
                this.removeLoadingEffect();

                $('#dataFillForm').html(updateContent);

                editCalendarManager.events();

                if ($(this.getContainer())[0]) {
                    initJs($(this.getContainer())[0]);
                };
            });
        };

        events() {
            const _this = this;

            $(_this.getStartDateInput()).on('change', function(e) {
                e.preventDefault();
                timeAutoCaculatForm.loadTimesInformation();
            });

            $(_this.getTotalHoursInput()).on('change', function(e) {
                e.preventDefault();
                timeAutoCaculatForm.loadTimesInformation();
            });

            $(_this.getSubmitBtn()).on('click', e => {
                e.preventDefault();
                _this.getSubmitBtn().outerHTML = _this.getSubmitBtn().outerHTML
                _this.submit();
            });

            $(_this.getCancelBtn()).on('click', function(e) {
                e.preventDefault();

                const url = this.getAttribute('href');
                ASTool.confirm({
                    message: "Bạn có chắc muốn loại bỏ những thay đổi và quay về trang danh sách?",
                    ok: function() {
                        ASTool.addPageLoadingEffect();

                        $.ajax({
                            url: url
                        }).done(response => {
                            window.location.href = url;
                        }).fail(response => {
                            throw new Error(response);
                        });
        
                        ASTool.removePageLoadingEffect();
                    }
                });
            });
        };

        init() {
            this.loadTimeToChangeSchedule(this.createCurrentDate()); // By default, it takes the current date. Users can change the date to suit their needs.
            this.events();
        };
    };

    var TimeAutoCaculatForm = class {
        startDate = null;
        totalHours = null;
        totalDates = null;
        endDate = null;
        
        constructor(options) {
            this.container = options.container;

            this.init();
        };

        getContainer() {
            return this.container;
        };

        getVnTeacherDurationInput() {
            return this.getContainer().querySelector('[name="vn_teacher_duration"]');
        };

        getVnTeacherDurationValue() {
            return this.getVnTeacherDurationInput().value;
        };

        getForeignTeacherDurationInput() {
            return this.getContainer().querySelector('[name="foreign_teacher_duration"]');
        };

        getForeignTeacherDurationValue() {
            return this.getForeignTeacherDurationInput().value;
        };

        getTutorDurationInput() {
            return this.getContainer().querySelector('[name="tutor_duration"]');
        };

        getTutorDurationValue() {
            return this.getTutorDurationInput().value;
        };  

        getAssistantDurationInput() {
            return this.getContainer().querySelector('[name="assistant_duration"]');
        };

        getAssistantDurationValue() {
            return this.getAssistantDurationInput().value;
        };

        getTotalDays() {
            return this.totalDates;
        };

        setTotalDays(newTotalDays) {
            this.totalDates = newTotalDays;
        };

        getStartDate() {
            return this.startDate;
        };

        setStartDate(newStartDate) {
            this.startDate = newStartDate;
        };

        getTotalHours() {
            return this.totalHours;
        };

        setTotalHours(newTotalHours) {
            this.totalHours = newTotalHours;
        };

        getEndDate() {
            return this.endDate;
        };

        setEndDate(newEndDate) {
            this.endDate = newEndDate;
            this.getContainer().querySelector('[name="end_at"]').value = newEndDate;
        };

        getStartDateInputValue() {
            return editCalendarManager.getStartDateInputValue();
        };

        getTotalHoursInputValue() {
            return editCalendarManager.getTotalHoursInputValue();
        };

        getTotalDaysLabel() {
            return this.getContainer().querySelector('[data-control="total_dates"]');
        };

        getEndDateLabel() {
            return this.getContainer().querySelector('[data-control="end_date"]');
        };

        loadTotalDays() {
            this.getTotalDaysLabel().innerHTML = this.getTotalDays();
        };

        loadEndDate() {
            this.getEndDateLabel().innerHTML = this.convertDate(this.getEndDate());
        };

        getDaysOfWeek() {
            return editCalendarManager.getDaysOfWeek();
        };

        getAllEventsWithVietnameseTeacher(currentCalendarEvents) {
            const eventsWithVnTeacher = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_vn_teacher_check 
                    && event.is_vn_teacher_check !== "0" 
                    && event.is_vn_teacher_check !== "false" 
                    && event.is_vn_teacher_check !== "") {
                        eventsWithVnTeacher.push(event);
                    };
            });

            return eventsWithVnTeacher;
        };

        getAllEventsWithForeignTeacher(currentCalendarEvents) {
            const eventsWithForeignTeacher = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_foreign_teacher_check 
                    && event.is_foreign_teacher_check !== "0" 
                    && event.is_foreign_teacher_check !== "false" 
                    && event.is_foreign_teacher_check !== "") {
                        eventsWithForeignTeacher.push(event);
                    };
            });

            return eventsWithForeignTeacher;
        };

        getAllEventsWithTutor(currentCalendarEvents) {
            const eventsWithTutor = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_tutor_check 
                    && event.is_tutor_check !== "0" 
                    && event.is_tutor_check !== "false" 
                    && event.is_tutor_check !== "") {
                        eventsWithTutor.push(event);
                    };
            });

            return eventsWithTutor;
        };

        getAllEventsWithAssistant(currentCalendarEvents) {
            const eventsWithAssistant = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_assistant_check 
                    && event.is_assistant_check !== "0" 
                    && event.is_assistant_check !== "false" 
                    && event.is_assistant_check !== "") {
                        eventsWithAssistant.push(event);
                    };
            });

            return eventsWithAssistant;
        };

        caculateDurationFromStartTimeAndEndTime(startTime, endTime) {
            const startParts = startTime.split(':');
            const endParts = endTime.split(':');

            const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
            const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);

            const durationInMinutes = endMinutes - startMinutes;
    
            return durationInMinutes;
        };

        caculateTotalMinutesPerStaffType(events, staffType) {
            let durationInMinutes;
            let staffFrom;
            let staffTo;
            
            switch(staffType) {
                case 'vn_teacher':
                    staffFrom = 'vn_teacher_from';
                    staffTo = 'vn_teacher_to';
                    break;
                case 'foreign_teacher':
                    staffFrom = 'foreign_teacher_from';
                    staffTo = 'foreign_teacher_to';
                    break;
                case 'tutor':
                    staffFrom = 'tutor_from';
                    staffTo = 'tutor_to';
                    break;
                case 'assistant':
                    staffFrom = 'assistant_from';
                    staffTo = 'assistant_to';
                    break;
                default:
                    staffFrom = 'vn_teacher_from';
                    staffTo = 'vn_teacher_to';
            };
            
            if (events.length > 0) {
                durationInMinutes = 0;

                events.forEach(event => {
                    let from;
                    let to;

                    const fromTimeArray = event[staffFrom].split(' ');
                    const toTimeArray = event[staffTo].split(' ');

                    if (fromTimeArray.length > 1) {
                        from = fromTimeArray[0];
                    } else {
                        from = event[staffFrom];
                    };

                    if (toTimeArray.length > 1) {
                        to = toTimeArray[0];
                    } else {
                        to = event[staffTo];
                    };

                    const duration = this.caculateDurationFromStartTimeAndEndTime(from, to);

                    durationInMinutes += duration;
                });
            } else {
                durationInMinutes = 0;
            };

            return durationInMinutes;
        };

        caculateVnTeacherDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithVnTeacher = this.getAllEventsWithVietnameseTeacher(currentCalendarEvents); //Event with only VN teachers
            const totolVnTeacherDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithVnTeacher, 'vn_teacher');
            
            return totolVnTeacherDurationInMinutes;
        };

        caculateForeignTeacherDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithForeignTeacher = this.getAllEventsWithForeignTeacher(currentCalendarEvents); //Event with only foreign teachers
            const totolForeignTeacherDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithForeignTeacher, 'foreign_teacher');
            
            return totolForeignTeacherDurationInMinutes;
        };

        caculateTutorDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithTutor = this.getAllEventsWithTutor(currentCalendarEvents); //Event with only tutor
            const totolTutorDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithTutor, 'tutor');
            
            return totolTutorDurationInMinutes;
        };

        caculateAssistantDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithAssistant = this.getAllEventsWithAssistant(currentCalendarEvents); //Event with only assistant
            const totolAssistantDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithAssistant, 'assistant');

            return totolAssistantDurationInMinutes;
        };

        loadVnTeacherDuration(durationInHour) {
            this.getVnTeacherDurationInput().value = durationInHour;
        };

        loadForeignTeacherDuration(durationInHour) {
            this.getForeignTeacherDurationInput().value = durationInHour;
        };

        loadTutorDuration(durationInHour) {
            this.getTutorDurationInput().value = durationInHour;
        };

        loadAssistantDuration(durationInHour) {
            this.getAssistantDurationInput().value = durationInHour;
        };
        
        loadDurationTimes() {
            const totalVnTeacherInHour = (this.caculateVnTeacherDurationInMinutes() / 60).toFixed(2);
            const totalForeignTeacherInHour = (this.caculateForeignTeacherDurationInMinutes() / 60).toFixed(2);
            const totalTutorInHour = (this.caculateTutorDurationInMinutes() / 60).toFixed(2);
            const totalAssistantInHour = (this.caculateAssistantDurationInMinutes() / 60).toFixed(2);

            this.loadVnTeacherDuration(totalVnTeacherInHour);
            this.loadForeignTeacherDuration(totalForeignTeacherInHour);
            this.loadTutorDuration(totalTutorInHour);
            this.loadAssistantDuration(totalAssistantInHour);
        };

        getTotalMinutesOfAllStaffs() {
            return this.caculateVnTeacherDurationInMinutes() 
                + this.caculateForeignTeacherDurationInMinutes() 
                + this.caculateTutorDurationInMinutes() 
                + this.caculateAssistantDurationInMinutes();
        };

        convertDate(stringDate) { // convert yyyy-mm-dd -> dd-mm-yyy
            if (stringDate && typeof stringDate === 'string' && stringDate !== '--') {
                const dateObj = new Date(stringDate);
                const dateValue = dateObj.getDate();
                const monthValue = dateObj.getMonth() + 1;
                const yearValue = dateObj.getFullYear();
                const convertedDate = (dateValue < 10 ? '0' : '') + dateValue;
                const convertedMonth = (monthValue < 10 ? '0' : '') + monthValue;
                const newDate = convertedDate + '/' + convertedMonth + '/' + yearValue;
    
                return newDate;
            } else {
                return '--';
            };
        };

        getDayOfWeek(dateString) {
            const daysOfWeek = this.getDaysOfWeek();
            const date = new Date(dateString);
            const dayIndex = date.getDay();

            return daysOfWeek[dayIndex];
        };

        getNextDay(currDay) {
            const daysOfWeek = this.getDaysOfWeek();
            const currIndex = daysOfWeek.indexOf(currDay);

            if (currIndex !== -1) {
                const nextIndex = (currIndex + 1) % daysOfWeek.length;
                return daysOfWeek[nextIndex];
            };

            return 'mon';
        };

        convertToMinutes(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            return hours * 60 + minutes;
        };

        /**
         * The purpose of this function is to check whether, with the current schedule, the weekly teaching time is valid or not.
         */
        isReduceTimePerWeekValid(weekSchedules, startDate) {
            let minutesPerWeek = 0;
            let dayName = this.getNextDay(startDate);

            // Iterate through 7 times, corresponding to the 7 days of the week.
            for(let i = 0; i < 7; ++i) {
                /**
                 * For each day of the week, iterate through all the days in the weekly schedule. 
                 * If there is a day in the schedule with classes that matches the currently iterated day of the week, 
                 * => (*) Perform calculations based on the classes on that day. 
                 */
                for(let schedule of weekSchedules) {
                    if (schedule.name === dayName) {
                        schedule.schedules.forEach(event => {
                            // (*) Calculate the number of minutes for each class and add it to the weekly total minutes.
                            const start = this.convertToMinutes(event.start_at);
                            const end = this.convertToMinutes(event.end_at);
                            const duration = end - start;
                            let minutePerSection;

                            if (duration < 0) {
                                minutePerSection = (24 * 60) - duration;
                            } else {
                                minutePerSection = duration;
                            };

                            minutesPerWeek += minutePerSection;
                        });

                        break;
                    };
                };

                dayName = this.getNextDay(dayName); // Move on to the next day in the week.
            };

            return minutesPerWeek !== 0;
        };

        caculateTotalDays(weekSchedules, totalHours, startDate) {
            let totalMinutes = totalHours * 60;
            let totalDays = 0;
            let isExisScheduleItemInArray = false;
            let dayName = this.getDayOfWeek(startDate);

            if (this.isReduceTimePerWeekValid(weekSchedules, startDate)) { // There is teaching time every week.
                /**
                 * Calculate the total number of days by: 
                 * Subtracting the total minutes of classes on each day from the total minutes required to study. 
                 * Increment the total number of days by 1 until the total minutes required to study become 0.
                 */
                while(totalMinutes > 0 && dayName) {
                    for(let schedule of weekSchedules) {
                        if (schedule.name === dayName) {
                            schedule.schedules.forEach(event => {
                                const start = this.convertToMinutes(event.start_at);
                                const end = this.convertToMinutes(event.end_at);
                                const duration = end - start;
                                let reduceRange;
    
                                if (duration < 0) {
                                    reduceRange = (24 * 60) - duration;
                                } else {
                                    reduceRange = duration;
                                };
    
                                totalMinutes -= reduceRange;
                            });
    
                            break;
                        };
                    };
    
                    dayName = this.getNextDay(dayName);
                    totalDays += 1;
                };
            };

            return totalDays;
        };

        caculateEndDate(startDateStr, totalDays) {
            if (startDateStr && totalDays) {
                let startDate = new Date(startDateStr);
                let endDate = new Date(startDate);

                endDate.setDate(endDate.getDate() + (totalDays - 1));

                return endDate.toISOString().split('T')[0];
            };

            return null;
        };

        validateWhenLoadAutoFillValues() {
            let isValid = true;

            const weekSchedules = weekScheduleTool.getWeekEventsData();
            const totalHours = this.getTotalHours();
            const startDate = this.getStartDate();

            if (weekSchedules.length === 0 || !totalHours || totalHours <= 0 || !startDate) {
                isValid = false;
            };

            return isValid;
        };

        getAutoFillValuesForm() {
            return this.getContainer().querySelector('[form-control="auto-fill-values"]');
        };

        getNotExistAutoFillValuesForm() {
            return this.getContainer().querySelector('[form-control="not-existing-autofill-values"]');
        };

        showAutoFillValuesForm() {
            this.getAutoFillValuesForm().classList.remove('d-none');
        };

        hideAutoFillValuesForm() {
            this.getAutoFillValuesForm().classList.add('d-none');
        };

        showNotExistAutoFillValuesForm() {
            this.getNotExistAutoFillValuesForm().classList.remove('d-none');
        };

        hideNotExistAutoFillValuesForm() {
            this.getNotExistAutoFillValuesForm().classList.add('d-none');
        };

        loadAutoFillValues() {
            this.loadTotalDays();
            this.loadEndDate();
        };

        caculateAutoFillValues() {
            const weekSchedules = weekScheduleTool.getWeekEventsData();
            const totalHours = this.getTotalHours();
            const startDate = this.getStartDate();
            let totalDays = null;
            let endDate = null;

            if (!this.validateWhenLoadAutoFillValues()) {
                totalDays = '--';
                endDate = '--';
            } else {
                totalDays = this.caculateTotalDays(weekSchedules, totalHours, startDate);
                endDate = this.caculateEndDate(startDate, totalDays);
            };

            if (totalDays && endDate && totalDays !== '--' && endDate !== '--') {
                this.setTotalDays(totalDays);
                this.setEndDate(endDate);
                this.loadAutoFillValues();
                this.showAutoFillValuesForm();
                this.hideNotExistAutoFillValuesForm();
            } else {
                this.hideAutoFillValuesForm();
                this.showNotExistAutoFillValuesForm();
            };
        };

        hideForm() {
            this.getContainer().classList.add('d-none');
        };

        showForm() {
            this.getContainer().classList.remove('d-none');
        };

        loadTimesInformation() {
            this.setStartDate(this.getStartDateInputValue());
            this.setTotalHours(this.getTotalHoursInputValue());
            this.caculateAutoFillValues();
        };

        validateToShowForm() {
            if (this.validateWhenLoadAutoFillValues() <= 0 && calendar.getDateData().events.length <= 0) {
                return false;
            };

            return true;
        };

        run() {
            this.loadDurationTimes();
            this.loadTimesInformation();

            if (this.validateToShowForm()) {
                this.showForm();
            } else {
                this.hideForm();
            };
        };

        init() {
            this.run();
        };
    };

    var OldWeekScheduleTable = class {
        constructor(options) {
            this.container = options.container;
            this.weekEventsData = options.weekEventsData;
            this.init();
        };

        getContainer() {
            return this.container;
        };

        getOldWeekScheduleData() {
            return this.weekEventsData;
        };

        getTableBody() {
            return this.getContainer().querySelector('[form-control="table-body"]');
        };

        getDaysOfWeek() {
            return ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        };

        render() {
            const _this = this;
            const oldData = JSON.parse(JSON.stringify(this.getOldWeekScheduleData()));
            const scheduleByDay = {
                mon: [],
                tue: [],
                wed: [],
                thu: [],
                fri: [],
                sat: [],
                sun: []
            };

            oldData.forEach(day => {
                const dayName = day.name.toLowerCase();
                scheduleByDay[dayName] = day.schedules.map(event => ({
                    ...event,
                    end_at_hours: parseInt(event.end_at.split(":")[0]),
                    end_at_minutes: parseInt(event.end_at.split(":")[1])
                }));
            });

            let row = `<tr>`;

            this.getDaysOfWeek().forEach(day => {
                let newCell = '<td class="text-center ps-1">';

                const sortedEvents = scheduleByDay[day].sort((a, b) => {
                    if (a.end_at_hours !== b.end_at_hours) {
                        return a.end_at_hours - b.end_at_hours;
                    } else {
                        return a.end_at_minutes - b.end_at_minutes;
                    }
                });

                sortedEvents.forEach(event => {
                    const newCellData = `<div class="row d-flex justify-content-center">${event.start_at} - ${event.end_at}</div>`
                    newCell += newCellData;
                });

                newCell += '</td>';

                row +=  newCell;
            });

            row += "</tr>";
            this.getTableBody().innerHTML = row;
        }

        init() {
            this.render();
        };
    }
</script>