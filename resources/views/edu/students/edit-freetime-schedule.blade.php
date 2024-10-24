@extends('layouts.main.popup')

@section('title')
    Lịch rảnh của {{$contact->name}}
@endsection
@php
    $formId = 'F' . uniqid();
@endphp
@section('content')
<form id="{{ $formId}}" tabindex="-1"  action="{{ action( [App\Http\Controllers\Edu\StudentController::class, 'updateFreetimeSchedule'],
    [
        'id' => $freeTime->id,
    ],
) }}">
@csrf
<style>
    .column {
        float: left;
        width: 14.28%;
        padding: 5px;
        height: 40px;
        
    }
    

    .row:after {
        content: "";
        display: table;
        clear: both;
    }
    </style>
<!--begin::Scroll-->
<div class=" pe-7  py-10 px-lg-17" >
    <!--begin::Input group-->
    <div class="row g-9 mb-5 d-flex justify-content-center">
        <div class="card p-5">
             
            <div class="row" id="schedule-free-form-{{$formId}}">
                <input type="hidden" name="contact_id" value="{{$contact->id}}">
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-1">Từ ngày </label>
                    <div class="form-outline">
                        <div data-control="date-with-clear-button"
                            class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" name="from_date" placeholder="=asas" type="date"
                                class="form-control" placeholder=""  value="{{$freeTime->from_date}}"/>
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
                                class="form-control" placeholder="" value="{{$freeTime->to_date}}"/>
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                    </div>
                </div>
                <div class=" mt-10">
                    
                    <div class="row text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <div class="column">Chủ nhật</div>
                        <div class="column">Thứ 2</div>
                        <div class="column">Thứ 3</div>
                        <div class="column">Thứ 4</div>
                        <div class="column">Thứ 5</div>
                        <div class="column">Thứ 6</div>
                        <div class="column">Thứ 7</div>
                    </div>
                    <div class="row text-start fs-5 gs-0 text-nowrap">
                        
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="0" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                            
                       
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="1" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                        
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="2" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                       
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="3" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                        
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="4" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                        
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="5" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                        
                        
                        <div class="column">
                            <button  data-control="add-schedule" data-week-day="6" type="button" class="btn  btn-sm btn-icon ms-1 mb-1 border" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm" 
                            style="display: inline-flex;" data-kt-initialized="1">
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </button>
                        </div>
                        
                        
                    </div>
                    <div class="row text-start fs-5 gs-0 text-nowrap scroll-y" id="table-schedule-content"  style="min-height: 300px">
                        <div class="column" week-day="1"> 
                         
                        </div> 
                        <div class="column" week-day="2">
                            
                        </div>
                        <div class="column" week-day="3">
                            
                        </div>
                        <div class="column" week-day="4">
                            
                        </div>
                        <div class="column" week-day="5">
                           
                        </div>
                        <div class="column" week-day="6">
                            
                        </div>
                        <div class="column" week-day="7">
                            
                        </div>
                        
                    </div>
                    
                    <ul id="list-schedule-freetime" class="list-group d-none">

                    </ul>
                </div>
            </div>
        
            
    <script>
    
    $(function () {
        var container = document.getElementById('schedule-free-form-{{$formId}}');

        
        var events = {!! json_encode($sortedFreeTime ?: []) !!};

        if (container) {
            new FreeTimeManager(container, events);
        }
    });
        
    var FreeTimeManager = class {
        constructor(container, events) {
            this.container = container;
            this.addEventPopupForm = new Popup();
            this.eventsByDay = events;
            this.setupEvents();
            this.render();
        }

        render() {
            
            const allColumns = this.container.querySelectorAll('.column[week-day]');
            allColumns.forEach(columnDiv => {
                columnDiv.innerHTML = ''; 
            });

            
            for (let i = 0; i < this.eventsByDay.length; i++) {
                const dayEvents = this.eventsByDay[i];
                const index = i + 1;

                
                const columnDiv = this.container.querySelector(`.column[week-day="${index}"]`);

                if (columnDiv !== null) {
                    
                    if (dayEvents && (Array.isArray(dayEvents) || Object.keys(dayEvents).length > 0)) {
                        
                        const eventsArray = Array.isArray(dayEvents) ? dayEvents : Object.values(dayEvents);

                        
                        eventsArray.forEach(eventInfo => {
                            const fromTime = eventInfo.from;
                            const toTime = eventInfo.to;

                            
                            const eventDiv = document.createElement('div');
                            eventDiv.textContent = `${fromTime}- ${toTime}`;
                            eventDiv.classList.add('py-3');

                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'event_data';
                            hiddenInput.value = `{"day": ${index}, "time": "${fromTime}", "endTime": "${toTime}"}`;
                            eventDiv.appendChild(hiddenInput);

                           
                            eventDiv.setAttribute('cell-data', index);
                            eventDiv.setAttribute('time-data', `${fromTime}- ${toTime}`);

                            const deleteSpan = document.createElement('span');
                            deleteSpan.classList.add('material-symbols-rounded', 'cursor-pointer');
                            deleteSpan.setAttribute('data-control', 'remove-schedule');
                            deleteSpan.textContent = 'delete';

                            deleteSpan.addEventListener('click', (event) => {
                                const cellData = parseInt(event.target.parentElement.getAttribute('cell-data'));
                                const timeData = event.target.parentElement.getAttribute('time-data');
                                
                                this.removeEvent(cellData, timeData);
                            });

                            
                            eventDiv.appendChild(deleteSpan);
                            columnDiv.appendChild(eventDiv);
                        });
                    }
                } else {
                    throw new Error(`week-day="${index}" not found.`);
                }
            }

            
            const removeScheduleButtons = this.container.querySelectorAll('.delete-button');
            removeScheduleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const cellData = parseInt(button.getAttribute('cell-data'));
                    const timeData = button.getAttribute('time-data');
                    this.removeEvent(cellData, timeData);
                });
            });
        }

        renderDay(dayIndex) {
            const columnDiv = this.container.querySelector(`.column[week-day="${dayIndex}"]`);

            if (columnDiv !== null) {
                const dayEvents = this.eventsByDay[dayIndex];
                
                if (dayEvents && (Array.isArray(dayEvents) || Object.keys(dayEvents).length > 0)) {
                    const eventsArray = Array.isArray(dayEvents) ? dayEvents : Object.values(dayEvents);

                    // Get the last event from eventsArray
                    const lastEvent = eventsArray[eventsArray.length - 1];

                    const fromTime = lastEvent.from;
                    const toTime = lastEvent.to;

                    const eventDiv = document.createElement('div');
                    eventDiv.textContent = `${fromTime}- ${toTime}`;
                    eventDiv.classList.add('py-3');

                    eventDiv.setAttribute('cell-data', dayIndex);
                    eventDiv.setAttribute('time-data', `${fromTime}- ${toTime}`);

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'event_data';
                    hiddenInput.value = `{"day": ${dayIndex}, "time": "${fromTime}", "endTime": "${toTime}"}`;
                    eventDiv.appendChild(hiddenInput);

                    const deleteSpan = document.createElement('span');
                    deleteSpan.classList.add('material-symbols-rounded', 'cursor-pointer');
                    deleteSpan.setAttribute('data-control', 'remove-schedule');
                    deleteSpan.textContent = 'delete';

                    deleteSpan.addEventListener('click', (event) => {
                        const cellData = parseInt(event.target.parentElement.getAttribute('cell-data'));
                        const timeData = event.target.parentElement.getAttribute('time-data');
                                                        
                        this.removeEvent(cellData, timeData);
                    });
                                                    
                    columnDiv.appendChild(eventDiv);
                    eventDiv.appendChild(deleteSpan);
                }
            } else {
                throw new Error(` week-day="${dayIndex}" not found.`);
            }
        }

        removeEvent(cellData, timeData) {
            
            const divToDelete = this.container.querySelector(`div[cell-data="${cellData}"][time-data="${timeData}"]`);
            
            if (divToDelete) {
                
                divToDelete.remove();

                const hiddenInputs = divToDelete.querySelectorAll('input[type="hidden"]');
                hiddenInputs.forEach(input => {
                    input.remove();
                });

                
                
            } else {
                throw new Error('not found.');
            }
        }




        setupEvents() {
            this.getAddButtons().forEach(button => {
                button.addEventListener('click', (event) => {
                    const weekDay = button.getAttribute('data-week-day');
                    
                    this.showAddEventPopupForm(weekDay);
                });
            });
        }
        getAddButtons() {
            return Array.from(this.container.querySelectorAll('[data-control="add-schedule"]'));
        }
      


        getContainer() {
            return this.container;
        }
        
        getEvents() {
            return this.events;
        }

        setEvents(events) {
            this.events = events;
        }

        addEvent(event) {
            const dayOfWeek = event.weekDay;
 
            if (!Array.isArray(this.eventsByDay[dayOfWeek])) {
                this.eventsByDay[dayOfWeek] = [];
            } 
            this.eventsByDay[dayOfWeek].push(event); 

            this.renderDay(event.weekDay);
            
        }


        


        getAddEventPopupForm(weekDay) {


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
                            <input popup-data-control="weekDay" value="${weekDay}" type="hidden" />
                            
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
            
        }

        addPopupEvents(weekDay) {
            const addScheduleButton = $('[data-action="add-schedule-btn"]');

            // Unbind any existing click event handlers
            addScheduleButton.off('click');

            // Bind the click event handler
            addScheduleButton.on('click', () => {
                var container = document.getElementById('input-schedule-{{ $formId }}');
                        
                const startAtElement = container.querySelector('[free-time-control="start-at-value"]');
                const endAtElement = container.querySelector('[free-time-control="end-at-value"]');
                const weekDayElement = container.querySelector('[popup-data-control="weekDay"]');

                const from = startAtElement ? startAtElement.value : null;
                const to = endAtElement ? endAtElement.value : null;
                const weekDay = weekDayElement ? parseInt(weekDayElement.value) + 1  : null;

                const event = { weekDay, from, to };
                        
                this.addEvent(event);

                this.addEventPopupForm.hide();
                
                
            });
        }


        showAddEventPopupForm(weekDay) {
            this.weekDay = weekDay;
            this.getAddEventPopupForm(weekDay);
            this.addEventPopupForm.show();
            this.addPopupEvents(weekDay);
        }

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
        var formData = $(form).serializeArray();
        

        var data = {};

        
        formData.forEach(input => {
            var key = input.name;
            var value = input.value;

        
            if (!data[key]) {
                data[key] = value; 
            } else {
                
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]]; 
                }
                data[key].push(value); 
            }
        });

        var eventDataArray = [];
        formData.forEach(input => {
            if (input.name === 'event_data') {
                eventDataArray.push(JSON.parse(input.value)); 
            }
        });

        
        data['event_data'] = eventDataArray;

        
        addSubmitEffect();
        $.ajax({    
            url: url,
            method: 'PUT',
            data: data,
        }).done(function(response) {
        
            CreatePopup.getUpdatePopup().hide();
            removeSubmitEffect();

            ASTool.alert({
                message: response.message,
                ok: function() {
                    UpdateContactPopup.getPopup().load();
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