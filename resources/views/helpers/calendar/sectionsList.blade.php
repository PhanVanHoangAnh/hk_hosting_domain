
@if (isset($calendar) && count($calendar->getEvents()) > 0)

@php
    $sectionsListUniqId = 'sectionsList_' . uniqid();   
@endphp

@csrf

<div id="{{ $sectionsListUniqId }}" class="table-responsive scrollable-orders-table" style="min-height: 620px">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
        @if (isset($type) && $type == \App\Models\Section::TYPE_FREE_TIME)
            <thead>
                <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Trạng thái
                            </span>
                        </span>
                    </th>

                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Ngày
                            </span>
                        </span>
                    </th>
        
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Thời gian
                            </span>
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($calendar->getEvents() as $key => $event)
                    <tr list-control="item" data-control="event-row" date-control="{{ $event[0] }}" data-code="{{ $event[5] }}">
                        {{-- Trạng thái --}}
                        <td>
                            <div class="badge badge-{{ \App\Helpers\Calendar::haveTheClassBeenCompleted($event) ? 'secondary' : 'success' }}">
                                {{ \App\Helpers\Calendar::haveTheClassBeenCompleted($event) ? 'Đã qua' : 'Chưa tới' }}
                            </div>
                        </td>
                        
                        {{-- Ngày --}}
                        <td>
                            {{ date('d/m/Y', strtotime($event[0])) }}
                        </td>
            
                        {{-- Thời gian học --}}
                        <td>
                            <span class="fw-bold">
                                {{ Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) }} phút ~
                                {{ number_format(Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) / 60, 1) }} giờ 
                            </span>
                            <span class="fs-7">
                                ({{ strlen($event[1]) > 10 ? substr($event[1], 11, 5) : $event[1] }} - {{ strlen($event[2]) > 10 ? substr($event[2], 11, 5) : $event[2] }})
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <thead>
                <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                thứ tự buổi
                            </span>
                        </span>
                    </th>

                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Phân loại
                            </span>
                        </span>
                    </th>

                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Trạng thái
                            </span>
                        </span>
                    </th>

                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Ngày học
                            </span>
                        </span>
                    </th>
        
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Thời gian học
                            </span>
                        </span>
                    </th>
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Giảng viên việt nam
                            </span>
                        </span>
                    </th>
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Giảng viên nước ngoài
                            </span>
                        </span>
                    </th>
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Gia sư
                            </span>
                        </span>
                    </th>
                    <th class="min-w-100px fs-8">
                        <span class="d-flex align-items-center">
                            <span>
                                Trợ giảng
                            </span>
                        </span>
                    </th>
                    <th class="min-w-125px text-left">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($calendar->getEvents() as $key => $event)
                    <tr list-control="item" data-control="event-row" date-control="{{ $event[0] }}" data-code="{{ $event[5] }}">
                        {{-- Thứ tự buổi học --}}
                        <td class="text-center">
                            <span class="fw-bold fs-4 badge badge-primary">{{ $event[27] }}</span>
                        </td>
    
                        {{-- Phân loại buổi học --}}
                        <td>
                            <div class="badge badge-{{ $event[24] === App\Models\Section::TYPE_TEST ? "danger" : "info" }} cursor-pointer">
                                {{ $event[24] === App\Models\Section::TYPE_TEST ? "Kiểm tra" : "Buổi học" }}
                            </div>
                        </td>
    
                        {{-- Trạng thái --}}
                        <td>
                            <div class="badge badge-{{ \App\Helpers\Calendar::haveTheClassBeenCompleted($event) ? 'secondary' : 'success' }}">
                                {{ \App\Helpers\Calendar::haveTheClassBeenCompleted($event) ? 'Đã diễn ra' : 'Chưa diến ra' }}
                            </div>
                        </td>
                        
                        {{-- Ngày học --}}
                        <td>
                            {{ date('d/m/Y', strtotime($event[0])) }}
                        </td>
            
                        {{-- Thời gian học --}}
                        <td>
                            <span class="fw-bold">
                                {{ Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) }} phút ~
                                {{ number_format(Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) / 60, 1) }} giờ 
                            </span>
                            <span class="fs-7">
                                ({{ strlen($event[1]) > 10 ? substr($event[1], 11, 5) : $event[1] }} - {{ strlen($event[2]) > 10 ? substr($event[2], 11, 5) : $event[2] }})
                            </span>
                        </td>
            
                        {{-- Giảng viên Việt Nam --}}
                        <td>
                            @if($event[6] && $event[6] !== '' && $event[6] !== 'false' && $event[6] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span class="fw-bold">{{ $event[7] ? App\Models\Teacher::find($event[7])->name : "" }}</span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span>({{ $event[8] }} - {{ $event[9] }})</span>
                                </div>
                            @endif
                        </td>
            
                        {{-- Giảng viên nước ngoài --}}
                        <td>
                            @if($event[10] && $event[10] !== '' && $event[10] !== 'false' && $event[10] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span class="fw-bold">{{ $event[11] ? App\Models\Teacher::find($event[11])->name : "" }}</span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span>({{ $event[12] }} - {{ $event[13] }})</span>
                                </div>
                            @endif
                        </td>
            
                        {{-- Gia sư --}}
                        <td>
                            @if($event[14] && $event[14] !== '' && $event[14] !== 'false' && $event[14] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span class="fw-bold">{{ $event[15] ? App\Models\Teacher::find($event[15])->name : "" }}</span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span>({{ $event[16] }} - {{ $event[17] }})</span>
                                </div>
                            @endif
                        </td>
    
                        {{-- Trợ giảng --}}
                        <td>
                            @if($event[18] && $event[18] !== '' && $event[18] !== 'false' && $event[18] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span class="fw-bold">{{ $event[19] ? App\Models\Teacher::find($event[19])->name : "" }}</span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left">
                                    <span>({{ $event[20] }} - {{ $event[21] }})</span>
                                </div>
                            @endif
                        </td>
            
                        {{-- @if (\App\Helpers\Calendar::haveTheClassBeenCompleted($event)) 
                            <td style="font-style: italic">
                                Buổi học đã qua, không thể thao tác
                            </td>
                        @else --}}
                            <td>
                                <a href="javascript:;"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3" data-control="edit-event">
                                        <a href="javascript:;"
                                            class="menu-link px-3">Chỉnh sửa buổi học</a>
                                    </div>
                                    <div class="menu-item px-3" data-control="delete-event">
                                        <a href="javascript:;"
                                            class="menu-link px-3">Xóa buổi học</a>
                                    </div>
                                </div>
                            </td>
                        {{-- @endif --}}
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
</div>
<script script-control="calendar-script">
    $(() => {
        HorizonScrollFix.init();
        const doneLoadNewglobalCalendarManager = new CustomEvent('doneLoadNewglobalCalendarManager', { detail: {status: 'DONE'} });

        globalSectionListManager = new SectionsListManager({
            container: document.querySelector('#{{ $sectionsListUniqId }}')
        });

        document.dispatchEvent(doneLoadNewglobalCalendarManager);
    });

    var HorizonScrollFix = function() {
        let sectionsListBox = $('#{{ $sectionsListUniqId }}');

        let setScroll = distanceFromLeft => {
            window.ordersListScrollFromLeft = distanceFromLeft;
        };

        let applyScroll = () => {
            sectionsListBox.scrollLeft(window.ordersListScrollFromLeft);
        }

        return {
            init: function() {

                applyScroll();

                sectionsListBox.on('scroll', () => {
                    setScroll(sectionsListBox.scrollLeft());
                });
            }
        }
    }();

    var SectionsListManager = class {
        eventRows = [];

        constructor(options) {
            this.container = options.container;

            this.loadInstanceEventRow();
        };

        getContainer() {
            return this.container;
        };

        getEventRows() {
            if(this.getContainer()) {
                return this.getContainer().querySelectorAll('[data-control="event-row"]');
            }
        };

        loadInstanceEventRow() {
            if(this.getEventRows()) {
                this.getEventRows().forEach(row => {
                    const eventRow = new EventRow({
                        sectionsList: this,
                        row: row
                    });
    
                    this.eventRows.push(eventRow); 
                });
            }
        };
    };

    var EventRow = class {
        constructor(options) {
            this.sectionsList = options.sectionsList;
            this.row = options.row;
            
            this.init();
        };

        getRow() {
            return this.row;
        };

        getDate() {
            return this.getRow().getAttribute('date-control');
        };

        getEditEventBtn() {
            return this.getRow().querySelector('[data-control="edit-event"]');
        };

        getEventItems() {
            return this.getRow().querySelectorAll('[data-item="event"]');
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

            if (studyMethod === "" || !studyMethod) {
                ASTool.alert({
                    message: "Vui lòng chọn hình thức học!",
                    icon: 'warning' 
                })

                return;
            } else if (studyMethod === offlineMethod) {
                let branch;
                
                if (typeof trainingLocationHandle != 'undefined' && trainingLocationHandle) {
                    // In screen create course
                    branch = trainingLocationHandle.getBranch();
                } else if ((typeof trainingLocationHandle == 'undefined' || !trainingLocationHandle) && editCalendarManager) {
                    // In screen edit course
                    branch = editCalendarManager.getSavedBranchValue();
                } else {
                    throw new Error("Bug: Cannot defined screen view when add event in calendar cell!");
                }

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

            let timeFormated = this.getDate();
            const endFormat = " 00:00:00";

            // Đảm bảo rằng lúc nào date truyền xuống cũng đúng format là có thêm 00:00:00 phía sau
            if (!timeFormated.endsWith(endFormat)) {
                timeFormated += endFormat;
            }

            const eventData = calendar.getEventByCodeAndDate(code, timeFormated);
            const url = "{{ action('App\Http\Controllers\CalendarController@editEventInCalendar') }}";

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

                    ASTool.alert({
                    message: "Xóa lịch học thành công!",
                });

                timeAutoCaculatForm.run();
                    ASTool.removePageLoadingEffect();
                }
            })
        };

        events() {
            const _this = this;
            const code = this.getRow().getAttribute('data-code');

            $(this.getRow()).find('[data-control="edit-event"]').on('click', function(e) {
                _this.clickEditEventButtonHandle(code);
            });

            $(this.getRow()).find('[data-control="delete-event"]').on('click', function(e) {
                _this.clickDeleteEventButtonHandle(code);
            });
        };

        init() {
            this.events();
        };
    };
</script>

@else

<div class="d-flex justify-content-center align-items-center" style="min-height: 400px">
    <div>
        <span class="fs-5" style="font-style: italic">
            Chưa có buổi học nào!    
        </span>
    </div>
</div>

@endif
