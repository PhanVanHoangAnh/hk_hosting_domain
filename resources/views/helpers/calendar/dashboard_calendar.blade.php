@php
    $calendarUniqId = 'calendar_' . uniqid();   
@endphp

@csrf

<style>
    .tooltip-inner {
        min-width: 200px; 
        max-width: 500px;
        white-space: normal;
    }

    .tooltip-inner .custom-type-section {
        position: absolute; 
        top: 20%; 
        right: 15%; 
        font-style: italic; 
        transform: translate(100%, -100%);
    }

    .tooltip-inner .custom-event {
        background-color: rgb(67, 82, 112);
        border-radius: 20px;
        color: aliceblue
    }

    .action-custom[data-bs-original-title] .tooltip-inner {
        padding: 10px; 
        background-color: #333;
        color: #fff; 
        border-radius: 5px;
    }
</style>

<div id="{{ $calendarUniqId }}" class="calendar d-flex flex-column dashboard-calendar">
    <div class="header p-0 h-25 row mb-3 border-0">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item border rounded bg-secondary"><a data-control="today-btn" class="page-link" href="javascript:;">Về tháng hiện tại</a></li>
                <li class="page-item border rounded ms-10 bg-secondary">
                    <a data-control="prev-btn" class="page-link" href="javascript:;" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item border rounded"><a class="page-link" href="javascript:;">{{ $calendar->getToday() }}</a></li>
                <li class="page-item border rounded bg-secondary">
                    <a data-control="next-btn" class="page-link" href="javascript:;" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="days d-flex flex-wrap">
        @foreach ($calendar->getDays() as $day)
            <div class="day_name border-end py-2 text-uppercase fw-bold text-light bg-info text-center">
                {{ $calendar->getDayName($day) }}
            </div>
        @endforeach
        @for ($i = $calendar->getFirstDayOfWeek(); $i > 0; $i--)
            <div class="day_num ignore p-2 text-uppercase fw-bold border border-light text-semi-bold bg-secondary">
                {{ $calendar->getNumDaysLastMonth() - $i + 1 }}
            </div>
        @endfor
        @for ($date = 1; $date <= $calendar->getNumDays(); $date++)
            <div action-control="cell-actions" data-control="event-box" date-control="{{ $calendar->getDateString($date) }}" class="day_num border-end border-bottom border-semi-light p-2 font-weight-bold text-grey cursor-pointer" style="position: relative">
                <span class="d-inline-flex fs-14 text-bold fw-bold">{{ $date }}</span>
                
                @php
                    $numOfEvents = 0;

                    foreach ($calendar->getEvents() as $event) {
                        if(date('y-m-d', strtotime($calendar->getActiveYear() . '-' . $calendar->getActiveMonth() . '-' . $date . ' -' . 0 . ' day')) == date('y-m-d', strtotime($event[0]))) {
                            $numOfEvents++;
                        }
                    }
                @endphp

                @if($numOfEvents !== 0) 
                    <div style="position: relative;" data-item="event">
                        <div list-data="event" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                            style="width: auto;background-color:#555;border-radius: 20px!important;"
                            title=
                                '
                                   @foreach($calendar->getEvents() as $event)
                                        @if(date('y-m-d', strtotime($calendar->getActiveYear() . '-' . $calendar->getActiveMonth() . '-' . $date . ' -' . 0 . ' day')) == date('y-m-d', strtotime($event[0])))
                                                <div style="position: relative;" data-item="event" class="custom-event">
                                                    <div list-data="event" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                                        class="event mt-2 p-2 fw-500 fs-14 rounded-1"
                                                        >
                                                        <div class="row px-3 fs-8 fw-bold" style="">
                                                            {{ $event[22] }}&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;{{ substr($event[1], 11, 5) }} - {{ substr($event[2], 11, 5) }}
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                   @endforeach
                                '
                            class="event mt-2 p-1 fs-14 rounded-1 text-light text-center text-bold font-weight-bold"
                            >
                            <span class="text-bold fw-bold">{{ $numOfEvents }}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endfor
        @for ($date = 1; $date <= (42 - $calendar->getNumDays() - max($calendar->getFirstDayOfWeek(), 0)); $date++)
            <div class="day_num ignore p-2 text-uppercase fw-bold border border-light text-semi-bold bg-secondary">
                {{ $date }}
            </div>
        @endfor
    </div>
</div>
<script script-control="calendar-script">
    $(() => {
        const doneLoadNewglobalCalendarManager = new CustomEvent('doneLoadNewglobalCalendarManager', { detail: {status: 'DONE'} });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.dispatchEvent(doneLoadNewglobalCalendarManager);
    });

    var CalendarManager = class {
        eventBoxes = [];

        constructor(options) {
            this.container = options.container;

            this.loadInstanceEventBoxs();
        };

        getContainer() {
            return this.container;
        };

        getEventBoxs() {
            if(this.getContainer()) {
                return this.getContainer().querySelectorAll('[data-control="event-box"]');
            }
        };

        getAllCellActionsForm() {
            if(this.getContainer()) {
                return this.getContainer().querySelectorAll('[form-control="cell-action"]')
            };
        };

        disableActionsInEventBoxes() {
            this.eventBoxes.forEach(box => {
                box.disableAllActions();
            });

            this.disableAllCellActions();
        };

        disableAllCellActions() {
            if(this.getAllCellActionsForm()) {
                this.getAllCellActionsForm().forEach(form => {
                    form.style.visibility = "hidden";
                });
            }
        };

        loadInstanceEventBoxs() {
            if(this.getEventBoxs()) {
                this.getEventBoxs().forEach(box => {
                    const eventBox = new EventBox({
                        calendar: this,
                        box: box
                    });
    
                    this.eventBoxes.push(eventBox); 
                });
            }
        };
    };

    var EventBox = class {
        constructor(options) {
            this.calendar = options.calendar;
            this.box = options.box;
            
            this.init();
        };

        getBox() {
            return this.box;
        };

        getDate() {
            return this.getBox().getAttribute('date-control');
        };

        getAddEventBtn() {
            return this.getBox().querySelector('[data-control="add-event"]');
        };

        getEditEventBtn() {
            return this.getBox().querySelector('[data-control="edit-event"]');
        };

        getEventItems() {
            return this.getBox().querySelectorAll('[data-item="event"]');
        };

        showAddEventBtn() {
            this.getAddEventBtn().classList.remove('d-none');
        };

        hideAddEventBtn() {
            this.getAddEventBtn().classList.add('d-none');
        };

        mouseOverBoxEvents() {
            setTimeout(() => {
                this.showAddEventBtn();
            }, 100);
        };

        mouseLeaveBoxEvents() {
            setTimeout(() => {
                this.hideAddEventBtn();
            }, 100);
        };

        getEventActionsForm() {
            return this.getBox().querySelectorAll('[actions-control="event-actions"]');
        };

        disableAllActions() {
            this.disableEventActions();
        };

        clickAddEventButtonHandle(studyDate) {
            const url = "{{ action('App\Http\Controllers\CalendarController@addEventInCalendar', ['study_date' => 'PLACEHOLDER']) }}";
            const updatedUrl = url.replace('PLACEHOLDER', studyDate);
            addSchedulePopup.updateUrl(updatedUrl);
        };

        clickEditEventButtonHandle(code) {
            let timeFormated = this.getDate();
            const endFormat = " 00:00:00";
            
            // Đảm bảo rằng lúc nào date truyền xuống cũng đúng format là có thêm 00:00:00 phía sau
            if (!timeFormated.endsWith(endFormat)) {
                timeFormated += endFormat;
            }

            const eventData = calendar.getEventByCodeAndDate(code, timeFormated);
            const url = "{{ action('App\Http\Controllers\CalendarController@editEventInCalendar', ['code' => 'PLACEHOLDER']) }}";
            const updatedUrl = url.replace('PLACEHOLDER', code);
            addSchedulePopup.setData({eventData: eventData, study_date: timeFormated});
            addSchedulePopup.updateUrl(updatedUrl);
        };

        clickDeleteEventButtonHandle(code) {
            let timeFormated = this.getDate();
            const endFormat = " 00:00:00";

            // Đảm bảo rằng lúc nào date truyền xuống cũng đúng format là có thêm 00:00:00 phía sau
            if (!timeFormated.endsWith(endFormat)) {
                timeFormated += endFormat;
            }

            ASTool.confirm({
                message: "Bạn có chắc chắn muốn xóa buổi học này không?",
                ok: function() {
                    ASTool.addPageLoadingEffect();

                    calendar.deleteEventInCalendar(code, timeFormated);

                    ASTool.alert({
                    message: "Xóa lịch học thành công!",
                });

                    timeAutoCaculatForm.run();
                    ASTool.removePageLoadingEffect();
                }
            })
        };

        disableEventActions() {
            if(this.getEventActionsForm().length > 0) {
                this.getEventActionsForm().forEach(form => {
                    form.style.visibility = "hidden";
                });
            };
        };

        events() {
            const _this = this;

            $(this.getBox()).on('mouseover', function(e) {
                e.preventDefault();
                _this.mouseOverBoxEvents();
            });

            $(this.getBox()).on('mouseleave', function(e) {
                e.preventDefault();
                _this.mouseLeaveBoxEvents();
            });

            $(this.getAddEventBtn()).on('click', function(e) {
                e.preventDefault(); 
                _this.clickAddEventButtonHandle(_this.getDate());
            });

            this.getEventItems().forEach(item => {
                const code = item.getAttribute('data-code');

                $(item).on('mouseover', function(e) {
                    this.querySelector('[action-control="event-action"]').classList.remove('d-none');
                });

                $(item).on('mouseleave', function(e) {
                    this.querySelector('[action-control="event-action"]').classList.add('d-none');
                });

                $(item).find('[data-control="edit-event"]').on('click', function(e) {
                    _this.clickEditEventButtonHandle(code);
                });

                $(item).find('[data-control="delete-event"]').on('click', function(e) {
                    _this.clickDeleteEventButtonHandle(code);
                });
            });
        };

        init() {
            this.events();
        };
    };
</script>
