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

    .action-custom[data-bs-original-title] .tooltip-inner {
        padding: 10px; 
        background-color: #333;
        color: #fff; 
        border-radius: 5px;
    }
</style>

<div id="{{ $calendarUniqId }}" class="calendar d-flex flex-column">
    <input type="hidden" data-control="is-abroad" value="{{ $isAbroad }}">
    <div class="header p-0 h-25">
        <div class="month-year fs-2 fw-bold text-info my-5">
            {{ $calendar->getHeaderContent() }}
        </div>
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
            <div class="day_name border-end py-5 text-uppercase fw-bold text-light bg-info text-center">
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
                <span form-control="cell-action" data-control="add-event" class="material-symbols-rounded text-center d-flex align-items-center justify-content-center hover-overlay hover-zoom hover-shadow ripple d-none"
                    style="position: absolute; top: 5%; right: 5%; width: 20px; height: 20px; transition: transform 0.3s ease; {{ \App\Helpers\Calendar::hasDayPassAlready($calendar->getActiveYear() . '-' . $calendar->getActiveMonth() . '-' . $date) ? '' : ''}}" {{-- FLAG: hidden --}}
                    onmouseover="this.style.transform='scale(2)'"
                    onmouseout="this.style.transform='scale(1)'"
                >
                    add
                </span>

                <span class="d-inline-flex w-30px fs-14 text-bold fw-bold">{{ $date }}</span>
                @foreach ($calendar->getEvents() as $key => $event)
                    @switch($event[25])
                        @case('student')
                            @include('helpers.calendar.sections.student_section', [
                                'event' => $event,
                                'date' => $date,
                                'key' => $key
                            ])

                            @break
                        @case('staff')
                            @include('helpers.calendar.sections.staff_section', [
                                'event' => $event,
                                'date' => $date,
                                'key' => $key
                            ])

                            @break
                        @case('dashboard')
                            @include('helpers.calendar.sections.dashboard_section', [
                                'event' => $event,
                                'date' => $date,
                                'key' => $key
                            ])
                            @break
                        @default
                            @include('helpers.calendar.sections.section', [
                                'event' => $event,
                                'date' => $date,
                                'key' => $key
                            ])
                    @endswitch
                @endforeach
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

        globalCalendarManager = new CalendarManager({
            container: document.querySelector('#{{ $calendarUniqId }}')
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
            let subjectId;

            // Vì view này dùng chung cho cả màn hình tạo mới và màn hình edit
            if (typeof subjectsManager !== 'undefined' && subjectsManager !== null) {
                subjectId = subjectsManager.getSubjectSelect().value;
            } else if (typeof editCalendarManager !== 'undefined' && editCalendarManager !== null) {
                subjectId = editCalendarManager.getSavedSubjectIdValue();
            } else {
                ASTool.alert({
                    message: "Chưa có môn học!",
                    icon: 'warning',
                    ok: () => {
                        throw new Error("Bugs: subject id not found!");
                    }
                })

                return;
            }

            var isAbroad = "{{ isset($isAbroad) && $isAbroad ? 1 : 0 }}"

            if (!subjectId && !isAbroad) {
                ASTool.alert({
                    message: "Vui lòng chọn môn học trước!",
                    icon: 'warning'
                })

                return;
            }

            // Nếu chọn phương thức học online thì cho phép tất cả giáo viên
            // Nếu chọn phương thức học offline thì bắt buộc phải có chọn branch
            // => Show staffs by branch
            let studyMethod;
                    
            if (typeof addCourseManager != 'undefined' && addCourseManager) {
                // In screen create course
                studyMethod = addCourseManager.getStudyMethodSelectValue();
            } else if ((typeof addCourseManager == 'undefined' || !addCourseManager) && editCalendarManager) {
                // In screen edit course
                studyMethod = editCalendarManager.getSavedStudyMethodValue();
            } else {
                throw new Error("Bug: Cannot defined screen view when add event in calendar cell!");
            }

            const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
            const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";
            let area = 'all';

            var isAbroad = "{{ isset($isAbroad) && $isAbroad ? 1 : 0 }}"

            // if ((studyMethod === "" || !studyMethod) && !isAbroad) {
            //     ASTool.alert({
            //         message: "Vui lòng chọn hình thức học!",
            //         icon: 'warning' 
            //     })

            //     return;
            // } else if (studyMethod === offlineMethod) {
            //     let branch;

            //     if (typeof trainingLocationHandle != 'undefined' && trainingLocationHandle) {
            //         // In screen create course
            //         branch = trainingLocationHandle.getBranch();
            //     } else if ((typeof trainingLocationHandle == 'undefined' || !trainingLocationHandle) && editCalendarManager) {
            //         // In screen edit course
            //         branch = editCalendarManager.getSavedBranchValue();
            //     } else {
            //         throw new Error("Bug: Cannot defined screen view when add event in calendar cell!");
            //     }

            //     if (typeof branch == 'undefined' || !branch) {
            //         // Not select any branch
            //         ASTool.alert({
            //             message: "Vui lòng chọn chi nhánh!",
            //             icon: 'warning'
            //         })

            //         // Stop
            //         return;
            //     }

            //     // Must select branch
            //     switch(branch) {
            //         case 'HN':
            //             area = 'HN';
            //             break;
            //         case 'SG':
            //             area = 'SG';
            //             break;
            //         default:
            //             area = 'all';
            //             break;
            //     }
            // }

            const url = "{!! action('App\Http\Controllers\Abroad\CalendarController@addEventInCalendar') !!}";

            addSchedulePopup.setData({
                study_date: studyDate,
                subject_id: subjectId,
                area: area,
                isAbroad: "{!! isset($isAbroad) && $isAbroad ? 1 : 0 !!}"
            });

            addSchedulePopup.updateUrl(url);
        };

        clickEditEventButtonHandle(code) {
            let subjectId;

            // Vì view này dùng chung cho cả màn hình tạo mới và màn hình edit
            if (typeof subjectsManager !== 'undefined' && subjectsManager !== null) {
                subjectId = subjectsManager.getSubjectSelect().value;
            } else if (typeof editCalendarManager !== 'undefined' && editCalendarManager !== null) {
                subjectId = editCalendarManager.getSavedSubjectIdValue();
            } else {
                ASTool.alert({
                    message: "Chưa có môn học!",
                    icon: 'warning',
                    ok: () => {
                        throw new Error("Bugs: subject id not found!");
                    }
                })
                
                return;
            }

            var isAbroad = "{{ isset($isAbroad) && $isAbroad ? 1 : 0 }}"

            if (!subjectId && !isAbroad) {
                ASTool.alert({
                    message: "Vui lòng chọn môn học trước!",
                    icon: 'warning'
                })

                return;
            }

            // Nếu chọn phương thức học online thì cho phép tất cả giáo viên
            // Nếu chọn phương thức học offline thì bắt buộc phải có chọn branch
            // => Show staffs by branch
            let studyMethod;
                    
            if (typeof addCourseManager != 'undefined' && addCourseManager) {
                // In screen create course
                studyMethod = addCourseManager.getStudyMethodSelectValue();
            } else if ((typeof addCourseManager == 'undefined' || !addCourseManager) && editCalendarManager) {
                // In screen edit course
                studyMethod = editCalendarManager.getSavedStudyMethodValue();
            } else {
                throw new Error("Bug: Cannot defined screen view when add event in calendar cell!");
            }

            const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
            const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";
            let area = 'all';

            var isAbroad = "{{ isset($isAbroad) && $isAbroad ? 1 : 0 }}"

            // if ((studyMethod === "" || !studyMethod) && !isAbroad) {
            //     ASTool.alert({
            //         message: "Vui lòng chọn hình thức học!",
            //         icon: 'warning' 
            //     })

            //     return;
            // } else if (studyMethod === offlineMethod) {
            //     let branch;
                
            //     if (typeof trainingLocationHandle != 'undefined' && trainingLocationHandle) {
            //         // In screen create course
            //         branch = trainingLocationHandle.getBranch();
            //     } else if ((typeof trainingLocationHandle == 'undefined' || !trainingLocationHandle) && editCalendarManager) {
            //         // In screen edit course
            //         branch = editCalendarManager.getSavedBranchValue();
            //     } else {
            //         throw new Error("Bug: Cannot defined screen view when add event in calendar cell!");
            //     }

            //     if (typeof branch == 'undefined' || !branch) {
            //         // Not select any branch
            //         ASTool.alert({
            //             message: "Vui lòng chọn chi nhánh!",
            //             icon: 'warning'
            //         })

            //         // Stop
            //         return;
            //     }

            //     // Must select branch
            //     switch(branch) {
            //         case 'HN':
            //             area = 'HN';
            //             break;
            //         case 'SG':
            //             area = 'SG';
            //             break;
            //         default:
            //             area = 'all';
            //             break;
            //     }
            // }

            let timeFormated = this.getDate();
            const endFormat = " 00:00:00";
            
            // Đảm bảo rằng lúc nào date truyền xuống cũng đúng format là có thêm 00:00:00 phía sau
            if (!timeFormated.endsWith(endFormat)) {
                timeFormated += endFormat;
            }

            const eventData = calendar.getEventByCodeAndDate(code, timeFormated);
            const url = "{!! action('App\Http\Controllers\Abroad\CalendarController@editEventInCalendar') !!}";

            addSchedulePopup.setData({
                eventData: eventData, 
                study_date: timeFormated,
                code: code,
                subject_id: subjectId,
                area: area,
            });

            addSchedulePopup.updateUrl(url);
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

                    // Only validate this condition in create course screen
                    if (typeof addCourseManager != 'undefined' && addCourseManager) {
                        addCourseManager.manageConditionConstraintForEventCreation(weekScheduleTool.getWeekEventsData(), calendar.dateData.events)
                    }

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
