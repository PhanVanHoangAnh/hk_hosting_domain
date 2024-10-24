@extends('layouts.main.popup')

@section('title')
    Lịch rảnh của{{$contactRequest->contact->name}}
@endsection
@php
    $formId = 'F' . uniqid();
@endphp
@section('content')
<form id="{{ $formId}}" tabindex="-1" enctype="multipart/form-data" method="post" action="{{ action( [App\Http\Controllers\Marketing\ContactRequestController::class, 'saveFreetimeSchedule'],
    [
        'id' => $contactRequest->id,
    ],
) }}">
@csrf

<!--begin::Scroll-->
<div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_staff_scroll">
    <!--begin::Input group-->
    <div class="row g-9 mb-5 d-flex justify-content-center">
        <div class="card p-5">
            
           
            <div class="row" id="schedule-free-form-{{$formId}}">
                <input type="hidden" name="contact_request_id" value="{{$contactRequest->id}}">
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-1">Từ ngày </label>
                    <div class="form-outline">
                        <div data-control="date-with-clear-button"
                            class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" name="from_date" placeholder="=asas" type="date"
                                class="form-control" placeholder="" />
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-1">Đến ngày</label>
                    <div class="form-outline">
                        <div data-control="date-with-clear-button"
                            class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" name="to_date" placeholder="=asas" type="date"
                                class="form-control" placeholder="" />
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-10">
                    <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
                        <thead class="border">
                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                                <th class="ps-3 min-w-70px">Chủ nhật</th>
                                <th class="ps-3 min-w-70px">Thứ 2</th>
                                <th class="ps-3 min-w-70px">Thứ 3</th>
                                <th class="ps-3 min-w-70px">Thứ 4</th>
                                <th class="ps-3 min-w-70px">Thứ 5</th>
                                <th class="ps-3 min-w-70px">Thứ 6</th>
                                <th class="ps-3 min-w-70px">Thứ 7</th>
                            </tr>
                        </thead>
                        <tbody style="min-height: 200px;" class="border" id="table-schedule-content">
                            <!-- table content -->
                           
                        </tbody>
                    </table>
                    <div>
                        <div class="row d-flex justify-content-center">
                            <div class="text-center col-md-3">
                                <button data-control="add-schedule-row" data-week-day="1" type="button" class="btn btn-sm btn-icon ms-1 mb-1 w-100 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                                style="display: inline-flex;" data-kt-initialized="1">
                                    <span class="material-symbols-rounded">
                                        add
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul id="list-schedule-freetime" class="list-group d-none">

                    </ul>
                </div>
            </div>
            <script>
                $(function () {
            
                    var container = document.getElementById('schedule-free-form-{{ $formId }}');
                    
                    if (container) {
                        var events = {!! json_encode($contactRequest->busy_schedule ?: []) !!};

                        new FreeTimeManager({
                            container: container,
                            events: events,
                        });
                    };
                });
            
                
                var FreeTimeManager = class {
                    constructor(options) {
                        this.container = options.container;
                        this.addEventPopupForm = new Popup();
                        this.schedule = new Schedule(options.events); 
                        

                        if (!Array.isArray(options.events)) {
                            JSON.parse(options.events).forEach(row => {
                                this.schedule.addRow(row);
                            });
                        }  else {
                            this.schedule.addRow();
                        }
                        
                        this.render();
                        this.events();

                    };

                    getAddScheduleRowBtn() {
                        return this.container.querySelector('[data-control="add-schedule-row"]');
                    };

                    events() {
                        this.getAddScheduleRowBtn().addEventListener('click', (event) => {
                            this.schedule.addRow();
                            this.render();
                        });
                    };

                    getAddEventPopupForm(row, cell) {
                        this.addEventPopupForm.setContent(`
                            <div class="modal-dialog modal-lg modal-{{ $size ?? '' }} modal-dialog-centered" class="modal"  aria-hidden="true" tabindex="-1" id="input-schedule-{{ $formId }}">
                                <!--begin::Modal content-->
                                <div class="modal-dialog modal-dialog-centered" style="width: 500px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Thời gian rảnh </h3>
                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"  onclick="closeModal()" aria-label="Close">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-outline">
                                                <label class="required fs-6 fw-semibold mb-2" for="start-at">Bắt đầu</label>
                                                <div class="d-flex align-items-center date-with-clear-button">
                                                    <input free-time-control="start-at-value" id="start-at" type="time" class="form-control 
                                                        name="start_at" placeholder=""  />
                                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                                </div>
                                                <span data-error="start-at-error" style="display: none; color:red">Vui lòng nhập thời gian bắt đầu</span>
                                            </div>
                                            <div class="form-outline py-3">
                                                <label class="required fs-6 fw-semibold mb-2" for="end-at">Kết thúc</label>
                                                <div   class="d-flex align-items-center date-with-clear-button">
                                                    <input free-time-control="end-at-value" id="end-at" type="time" class="form-control 
                                                        name="end_at" placeholder=""  />
                                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                                </div>
                                                <span data-error="end-at-error" class='' style="display: none; color:red">Vui lòng nhập thời gian kết thúc</span>
                                            </div>
                                        </div>
                                        <input popup-data-control="row" value="${row}" type="hidden" />
                                        <input popup-data-control="cell" value="${cell}" type="hidden" />
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary close" aria-hidden="true" onclick="closeModal()">Close</button>
                                            <button type="button" data-action='add-schedule-btn' class="btn btn-primary">Lưu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `); 

                        this.addEventPopupForm.show();
                        this.addPopupEvents();

                        window.closeModal = () => {
                            this.addEventPopupForm.hide();
                        };
                    };

                    addPopupEvents() {
                        const saveEventButton = document.querySelectorAll('[data-action="add-schedule-btn"]');
                        $('[data-action="add-schedule-btn"]').on('click', () => {
                            var container = document.getElementById('input-schedule-{{ $formId }}');
                            const startAtElement = container.querySelector('[free-time-control="start-at-value"]');
                            const endAtElement = container.querySelector('[free-time-control="end-at-value"]');
                            const rowValueElement = container.querySelector('[popup-data-control="row"]');
                            const cellValueElement = container.querySelector('[popup-data-control="cell"]');
                            const startAt = startAtElement ? startAtElement.value : null;
                            const endAt = endAtElement ? endAtElement.value : null;
                            const row = rowValueElement ? rowValueElement.value : null;
                            const cell = cellValueElement ? cellValueElement.value : null;

                            const startAtErrorElement = container.querySelector('[data-error="start-at-error"]');
                            const endAtErrorElement = container.querySelector('[data-error="end-at-error"]');

                            const isStartAtValid = startAtElement.value !== '';
                            const isEndAtValid = endAtElement.value !== '';

                            if (!isStartAtValid) {
                                startAtErrorElement.style.display = 'block';
                            } else {
                                startAtErrorElement.style.display = 'none';
                            }

                            if (!isEndAtValid) {
                                endAtErrorElement.style.display = 'block';
                            } else {
                                endAtErrorElement.style.display = 'none';
                            }

                            if (isStartAtValid && isEndAtValid) {
                                this.schedule.addTimeToRow(row, cell, startAt, endAt);
                                this.render();
                                this.addEventPopupForm.hide();
                            }
                        });
                    };

                    /**
                     * Function to convert the linked list schedule into an array of JavaScript objects 
                     * for easy conversion to UI. 
                     */
                    getTimeFromSchedule(schedule) {
                        const result = [];

                        for (let i = 0; i < schedule.rows.length; i++) {
                            const timeList = schedule.rows[i];
                            const timeArray = [];

                            let current = timeList.head;

                            while (current) {
                                timeArray.push({ day: current.day, time: current.time, endTime: current.endTime });
                                current = current.next;
                            };

                            result.push(timeArray);
                        };

                        return result;
                    };

                    render() {
                        const allTimeArraysFromSchedule = this.getTimeFromSchedule(this.schedule);
                        const tableBody = this.container.querySelector('#table-schedule-content');
                        tableBody.innerHTML = '';

                        for (let j = 0; j < allTimeArraysFromSchedule.length; ++j) {
                            const newRow = document.createElement('tr');
                            newRow.style.minHeight = '200px';

                            for (let i = 1; i <= 7; ++i) {
                                let newCell = document.createElement('td');
                                newCell.innerHTML = '<span class="cursor-pointer" style="color: #999; font-weight: lighter;">--</span>';

                                allTimeArraysFromSchedule[j].forEach(cell => {
                                    if (parseInt(cell.day) === i) {
                                        newCell.innerHTML = `
                                            <div style="display: flex; justify-content: space-between;">
                                                <span>${cell.time} - ${cell.endTime}</span>
                                                <span class="material-symbols-rounded cursor-pointer" 
                                                    row-data="${j}" 
                                                    cell-data="${i}" 
                                                    time-data="${cell.time}" 
                                                    data-control="remove-schedule">delete</span>
                                            </div>`;
                                    };
                                });

                                newCell.setAttribute('data-row-index', j);
                                newCell.setAttribute('data-cell-index', i);
                                newCell.setAttribute('data-control', 'schedule-cell');
                                newCell.setAttribute('class', 'text-center');

                                newRow.appendChild(newCell);
                            };

                            tableBody.appendChild(newRow);
                        };

                        const listContainer = this.container.querySelector('#list-schedule-freetime');
                        listContainer.innerHTML = '';

                        const scheduleFreetimeArray = [];

                        allTimeArraysFromSchedule.forEach((timeArray, j) => {
                            // Create a new array for each iteration of the outer loop
                            const innerArray = [];

                            timeArray.forEach((event) => {
                                const listItem = document.createElement('li');
                                const currentScheduleFreetime = { day: event.day, time: event.time, endTime: event.endTime };
                                innerArray.push(currentScheduleFreetime);

                                listItem.innerHTML = `
                                    <div>${event.time} - ${event.endTime}</div>
                                    <div class="material-symbols-rounded cursor-pointer" 
                                        data-control="remove-schedule">delete</div>
                                `;

                                listContainer.appendChild(listItem);
                            });

                            
                            scheduleFreetimeArray.push(innerArray);
                        });
                        
                        
                        const scheduleFreetimeJSON = JSON.stringify(scheduleFreetimeArray);

                        const finalListItem = document.createElement('li');
                        finalListItem.innerHTML = `
                            <input type="hidden" name="busy_schedule" value='${scheduleFreetimeJSON}'>
                        `;

                        listContainer.appendChild(finalListItem);
                        
                            this.afterRenderEvents();
                        };

                    afterRenderEvents() {
                        let cells = document.querySelectorAll('[data-control="schedule-cell"]');
                        
                        if(cells) {
                            cells.forEach(cell => {
                                let cellRemoveBtn = cell.querySelector('[data-control="remove-schedule"]');

                                /**
                                 * Check, if the cell has no data, trigger a popup display event when clicking on the cell. 
                                 * If the cell has data, only capture the event to delete the data when clicking on the trash bin icon 
                                 */
                                if(cellRemoveBtn) {
                                    cellRemoveBtn.addEventListener('click', e => {
                                        e.preventDefault();

                                        const row = parseInt(cellRemoveBtn.getAttribute('row-data'));
                                        const cell = cellRemoveBtn.getAttribute('cell-data');
                                        const time = cellRemoveBtn.getAttribute('time-data');

                                        this.schedule.removeTimeFromRow(row, cell, time);
                                        this.render();
                                    });

                                } else {
                                    cell.addEventListener('click', e => {
                                        e.preventDefault();
                
                                        const currRow = cell.getAttribute('data-row-index');
                                        const currCell = cell.getAttribute('data-cell-index');
                
                                        this.getAddEventPopupForm(currRow, currCell);
                                    });
                                };
                            });
                        };
                    };
                };
                var TimeNode = class {
                    constructor(day, time, endTime) {
                        this.day = day;
                        this.time = time;
                        this.endTime = endTime;
                        this.next = null;
                    };
                };
                var TimeList = class {
                    constructor() {
                        this.head = null;
                    };

                    addTime(day, time, endTime) {
                        const newNode = new TimeNode(day, time, endTime);

                        if (!this.head) {
                            this.head = newNode;
                            
                        } else {
                            let current = this.head;

                            while (current.next) {
                                current = current.next;
                            };

                            current.next = newNode;
                        };
                    };

                    removeTime(day, time) {
                        if (!this.head) {
                            return;
                        };

                        if (this.head.day === day && this.head.time === time) {
                            this.head = this.head.next;
                            return;
                        };

                        let current = this.head;
                        let prev = null;

                        while (current && (current.day !== day || current.time !== time)) {
                            prev = current;
                            current = current.next;
                        };

                        if (current) {
                            prev.next = current.next;
                        };
                    };
                };
                var Schedule = class {
                    constructor(events) {
                        this.rows = [];
                    };

                    addRow(events) {
                        const newList = new TimeList();

                        if (Array.isArray(events)) {
                            events.forEach(event => {
                                newList.addTime(event.day, event.time, event.endTime);
                            });
                        }
                        this.rows.push(newList);
                    };


                    addTimeToRow(row, day, time, endTime) {
                        if (row >= 0 && row < this.rows.length) {
                            this.rows[row].addTime(day, time, endTime);
                        };
                    };

                    removeTimeFromRow(row, day, time) {
                        if (row >= 0 && row < this.rows.length) {
                            this.rows[row].removeTime(day, time);
                        };
                    };
                };

            </script>
        </div>
    </div>

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="BusyScheduleSubmitButton" type="submit" class="btn btn-primary">
            <span class="indicator-label">Lưu</span>
            <span class="indicator-progress">Đang xử lý...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        <!--end::Button-->
        <!--begin::Button-->
        <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3"
            data-bs-dismiss="modal">Hủy</button>
        <!--end::Button-->
    </div>
</form>

<script>

$(function() {
    AccountsEdit.init();
});

var AccountsEdit = function() {
    var form;
    var btnSubmit;

    var handleFormSubmit = () => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            submit();
        });
    }

    submit = () => {
        var url = form.getAttribute('action');
        var data = $(form).serialize();
        
        addSubmitEffect();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,

        }).done(function(response) {
            CreatePopup.getUpdatePopup().hide();
            removeSubmitEffect();

            ASTool.alert({
                message: response.message,
                ok: function() {
                    UpdateContactRequestPopup.getPopup().load();
                }
            });
        }).fail(function(response) {
            var errorMessage = '';
            try {
                errorMessage = JSON.parse(response.responseText).message || 'An error occurred. Please try again later.';
            } catch (error) {
                errorMessage = 'An error occurred. Please try again later.';
            }
            
            ASTool.warning({
                message: errorMessage
            }); 
            removeSubmitEffect();
        });
    }

    addSubmitEffect = () => {
        // btn effect
        btnSubmit.setAttribute('data-kt-indicator', 'on');
        btnSubmit.setAttribute('disabled', true);
    }

    removeSubmitEffect = () => {
        // btn effect
        btnSubmit.removeAttribute('data-kt-indicator');
        btnSubmit.removeAttribute('disabled');
    }

    return {
        init: function() {
            form = document.getElementById('{{ $formId }}');
            btnSubmit = document.getElementById('BusyScheduleSubmitButton');

            handleFormSubmit();
        }
    }
}();
</script>

@endsection