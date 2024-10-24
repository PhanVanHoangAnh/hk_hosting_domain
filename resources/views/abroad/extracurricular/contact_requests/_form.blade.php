<div class="scroll-y pe-7 py-10 px-lg-17">
    <!--begin::Input group--> 

    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fs-6 fw-semibold mb-2">Khách hàng/Liên hệ</label>
        <!--end::Label-->

        @include('helpers.contactSelector', [
            'name' => 'contact_id',
            'url' => action('App\Http\Controllers\Abroad\ContactController@select2'),
            'controlParent' => '#' . $formId,
            'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
            'value' => $contactRequest->contact_id ? $contactRequest->contact_id : null,
            'text' => $contactRequest->contact_id ? $contactRequest->contact->getSelect2Text() : null,
            'createUrl' => action('\App\Http\Controllers\Abroad\ContactController@create'),
            'editUrl' => action('\App\Http\Controllers\Abroad\ContactController@edit', 'CONTACT_ID'),
        ])
        
        <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
    </div>

    <script>
        $(function() {
            new SelectContact({
                url: '{{ action([\App\Http\Controllers\ContactController::class, 'json']) }}',
                selectBox: $('#{{ $formId }} [form-control="contact-select"]'),
            });
        });

        var SelectContact = class {
            constructor(options) {
                this.url = options.url;
                this.selectBox = options.selectBox;

                //
                this.events();
            }

            fillInformation(id) {
                $.ajax({
                    url: this.url,
                    data: {
                        id: id,
                    }
                }).done((reponse) => {
                    Object.keys(reponse).forEach((key) => {
                        var value = reponse[key];

                        if (value && key === 'time_to_call') {
                            value = value.split(':')[0] + ':' + value.split(':')[1];
                        }
                        
                        if (value && $('#{{ $formId }} [name="'+key+'"]').length) {
                            $('#{{ $formId }} [name="'+key+'"]').val(value);
                        }
                        
                    });
                });
            }

            disableContactInfoInputs() {
                $('#{{ $formId }} [name="name"]').prop('readonly', true);
                $('#{{ $formId }} [name="email"]').prop('readonly', true);
                $('#{{ $formId }} [name="phone"]').prop('readonly', true);
            }

            enableContactInfoInputs() {
                $('#{{ $formId }} [name="name"]').prop('readonly', false);
                $('#{{ $formId }} [name="email"]').prop('readonly', false);
                $('#{{ $formId }} [name="phone"]').prop('readonly', false);
            }

            events() {
                //
                this.selectBox.on('change', (e) => {
                    var id = this.selectBox.val();
                    
                    if (id) {
                        this.fillInformation(id);

                        //
                        this.disableContactInfoInputs();
                    } else {
                        this.enableContactInfoInputs();
                    }
                });
            }
        };
    </script>

    <h2 class="my-4">Chi tiết đơn hàng</h2>

    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 col-xl-12 py-3 d-none">
        <label class="fs-6 fw-semibold mb-2" for="target-input">Thời gian rảnh</label>
    
        <div class="card p-5">
            <div class="row" id="schedule-free-form-{{$formId}}">
                <div class="table-responsive">
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
        </div>
    </div>

    <script>
        $(function () {
            var container = document.getElementById('schedule-free-form-{{ $formId }}');
            
            if (container) {
                var events = {!! json_encode($contactRequest->schedule_freetime ?: []) !!};

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
                    <input type="hidden" name="schedule_freetime" value='${scheduleFreetimeJSON}'>
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

        /**
         * Utilize the linkedList data structure with the three objects TimeNode, TimeList, and Schedule 
         * to manage operations of adding and removing data for cells in the schedule table
         */ 
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
    <div class="row">
        <div class="col-md-6 d-none">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Thời gian phù hợp</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="time" class="form-control @if ($errors->has('time_to_call')) is-invalid @endif"
                    name="time_to_call" placeholder="" value="{{ $contactRequest->time_to_call }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('time_to_call')" class="mt-2" />
            </div>

        </div>
        <div class="col-md-6 d-none">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Trường học</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control @if ($errors->has('school')) is-invalid @endif"
                    name="school" placeholder="" value="{{ $contactRequest->school }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">
                    <span class="">Đơn hàng</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                {{-- <input type="text" class="form-control @if ($errors->has('demand')) is-invalid @endif"
                    name="demand" placeholder="" value="{{ $contactRequest->demand }}" /> --}}
                    <select list-action="type-select" data-dropdown-parent ="#{{ $formId }}" class="form-select filter-select" name="demand"
                        data-control="select2" data-placeholder="Chọn đơn hàng"
                        data-allow-clear="true" >
                        <option value="">Chọn đơn hàng</option>
                        @foreach (\App\Models\Demand::all() as $demand)
                            <option value="{{ $demand->name }}" {{ isset($contactRequest) && $contactRequest->demand == $demand->name ? 'selected' : '' }}>{{ $demand->name }}</option>
                        @endforeach
                    </select>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('demand')" class="mt-2" />
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6 ">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Quốc gia</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" readonly class="form-control @if ($errors->has('country')) is-invalid @endif"
                name="country" placeholder="" value="{{ $contactRequest->country }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
       
        <div class="col-md-6 ">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Thành phố</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" readonly class="form-control @if ($errors->has('city')) is-invalid @endif"
                name="city" placeholder="" value="{{ $contactRequest->city }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6 ">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Quận/ Huyện</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" readonly class="form-control @if ($errors->has('district')) is-invalid @endif"
                name="district" placeholder="" value="{{ $contactRequest->district }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6 ">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Phường/xã</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" readonly class="form-control @if ($errors->has('ward')) is-invalid @endif"
                name="ward" placeholder="" value="{{ $contactRequest->ward }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>

        <script>
            $(function() {
                var container = document.getElementById('{{ $formId }}');

                new CityManager({
                    citySelector: container.querySelector('[city-control="city-selector"]'),
                    districtSelector: container.querySelector('[city-control="district-selector"]'),
                    wardSelector: container.querySelector('[city-control="ward-selector"]'),
                });
            });

            var CityManager = class {
                constructor(options) {
                    this.citySelector = options.citySelector;
                    this.districtSelector = options.districtSelector;
                    this.wardSelector = options.wardSelector;

                    this.data = {!! json_encode(config('cities')) !!};

                    // events
                    this.events();
                }

                getCityId() {
                    return this.citySelector.value;
                }

                getDistrictId() {
                    return this.districtSelector.value;
                }

                cleanupDistrict() {
                    $(this.districtSelector).find('option[value!=""]').remove();
                }

                cleanupWard() {
                    $(this.wardSelector).find('option[value!=""]').remove();
                }

                findDistrictsByCityId(cityId) {
                    var districts = [];
                    this.data.forEach(city => {
                        if (city.Name == cityId) {
                            districts = city.Districts;
                        }
                    });

                    return districts;
                }
                
                renderDistricts(cityId) {
                    var districts = this.findDistrictsByCityId(cityId);

                    this.cleanupDistrict();
                    this.cleanupWard();

                    districts.forEach(district => {
                        $(this.districtSelector).append('<option value="' + district.Name + '">' + district.Name + '</option>');
                    });
                }

                findWardsByDistrictId(districtId) {
                    var wards = [];

                    this.findDistrictsByCityId(this.getCityId()).forEach(district => {
                        if (district.Name == districtId) {
                            wards = district.Wards;
                        }
                    });

                    return wards;
                }

                renderWards(districtId) {
                    var wards = this.findWardsByDistrictId(districtId);

                    this.cleanupWard();

                    wards.forEach(ward => {
                        $(this.wardSelector).append('<option value="' + ward.Name + '">' + ward.Name + '</option>');
                    });
                }

                events() {
                    $(this.citySelector).on('change', (e) => {
                        var cityId = e.target.value;
                        // 
                        this.renderDistricts(cityId);
                    });

                    $(this.districtSelector).on('change', (e) => {
                        var districtId = e.target.value;
                        // 
                        this.renderWards(districtId);
                    });
                }
            }
        </script>



        <div class="col-md-12">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Địa chỉ</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control  @if ($errors->has('address')) is-invalid @endif" name="address"
                    placeholder="" value="{{ $contactRequest->address }}" />
                <!--end::Input-->
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">EFC</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                {{-- <input type="text"
                    class="form-control @if ($errors->has('efc')) is-invalid @endif" name="efc"
                    placeholder="" value="{{ $contactRequest->efc }}" /> --}}
                    <div class="input-group">
                        <input list-action="efc-number"
                            class="form-control @if ($errors->has('efc')) is-invalid @endif" name="efc"
                            placeholder="" value="{{ $contactRequest->efc }}" />
                        <div class="input-group-append">
                            <span class="input-group-text p-4">
                                <i class="material-symbols-rounded">
                                    attach_money
                                    </i>
                            </span>
                        </div>
                    </div>              
                <!--end::Input-->
            </div>

        </div>
        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">List</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('list')) is-invalid @endif" name="list"
                    placeholder="" value="{{ $contactRequest->list }}" />

                <!--end::Input-->
            </div>

        </div>
        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Target</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('target')) is-invalid @endif" name="target"
                    placeholder="" value="{{ $contactRequest->target }}" />

                <!--end::Input-->
            </div>

        </div>
        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Campaign</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('campaign')) is-invalid @endif" name="campaign"
                    placeholder="" value="{{ $contactRequest->campaign }}" />
                <!--end::Input-->
            </div>

        </div>

        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Placement</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('placement')) is-invalid @endif"
                    name="placement" placeholder="" value="{{ $contactRequest->placement }}" />
                <!--end::Input-->
            </div>

        </div>
        <div class="col-md-6 d-none">
            <!--begin::Input group-->`
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">ContactRequest Owner</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('contact_owner')) is-invalid @endif"
                    name="contact_owner" placeholder="" value="{{ $contactRequest->contact_owner }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        
        @include('generals.contact_requests._source_data_manager', [
            'parentFormId' => $formId,
            'contactRequest' => isset($contactRequest) ? $contactRequest : null
        ])
   
        <div class="col-md-6 d-none" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Gclid</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('gclid')) is-invalid @endif" name="gclid"
                    placeholder="" value="{{ $contactRequest->gclid }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6 d-none" list-action='show'>

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Fbclid</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('fbcid')) is-invalid @endif" name="fbcid"
                    placeholder="" value="{{ $contactRequest->fbcid }}" />
                <!--end::Input-->
            </div>

        </div>
        <div class="col-md-6 d-none">
            <div class="fv-row mb-7">
                <label class="fs-6 fw-semibold mb-2">Lead status</label>
                <div>
                    <select class="form-select"
                        @if (!Auth::user()->can('updateLeadStatus', $contactRequest))
                            disabled
                        @else
                            data-allow-clear="true"
                        @endif
                        data-dropdown-parent="#{{ $formId }}"
                        data-control="select2" data-placeholder="Chọn Lead status" name="lead_status"
                    >
                        @foreach (config('leadStatuses') as $type)
                            <option value="{{ $type }}"
                                {{ $contactRequest->lead_status === $type ? 'selected' : '' }}>
                                {{ $type ?? 'None' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-none">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <label class="fs-6 fw-semibold mb-2">Lifecycle stage</label>
                <div>
                    <input readonly class="form-control" type="text" name="lifecycle_stage" value=" {{ $contactRequest->lifecycle_stage }}">
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-12 d-none" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Thiết bị</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control @if ($errors->has('device')) is-invalid @endif" name="device"
                    placeholder="" value="{{ $contactRequest->device }}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function() {
        initializeEFCNumber();

        new SourceDataManager({
            container: document.querySelector('#{{ $formId }}'),
            selectLeadStatus: {!! $contactRequest->lead_status && $contactRequest->lead_status != '' ? "'$contactRequest->lead_status'" : '""' !!},
            selectedSourceType: "{!! $contactRequest->source_type !!}"
        });

        setTimeout(() => {
           initJs(document.querySelector('#{{ $formId }}')); 
        }, 0);

        function initializeEFCNumber() {
            const efcInput = $('#{{ $formId }} [list-action="efc-number"]');
            if (efcInput.length) {
                const mask = new IMask(efcInput[0], {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: ',',
                    padFractionalZeros: false,
                    normalizeZeros: true,
                    radix: ',',
                    mapToRadix: ['.'],
                    min: 0,
                });
            }
        };
    });
</script>