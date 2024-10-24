@php
    $payratesFormUniqId = 'P' . uniqid();
@endphp

<!--begin::Scroll-->
<div class="scroll-y pe-7  py-10 px-lg-17" data-kt-scroll-offset="300px">
    <!--begin::Input group-->
    <input type="hidden" name="id" value="{{ $salarySheet->id }}"/>
    <div class="row">
        {{-- SUBJECT SELECTOR --}}
        <div class="row mb-7">
            @php
                $subjectContainerId = "subject_container_id_" . uniqId();
            @endphp
            <!--begin::Col-->
            <div class="col-md-12 fv-row" id="{{ $subjectContainerId }}">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Môn học</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select form-control" data-placeholder="Chọn môn học"
                data-allow-clear="true" data-control="select2" name="subject_id" data-dropdown-parent ="#{{ $formId }}" required >
                <option value="">Chọn môn học </option>
                    @foreach($subjects as $subject)
                        <option 
                        data-url="{{ action([App\Http\Controllers\TeacherController::class, 'getTeacherSelectOptionsBySubjectId'], ['id' => $subject->id]) }}"
                        value="{{ $subject->id }}"  {{ $salarySheet->subject_id == $subject->id ? 'selected' : ''}}> {{ $subject->name }} - {{$subject->type}}</option>
                    @endforeach
                </select>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('subject_id')" class="mt-2"/>
            </div>
            <!--end::Col-->
        </div>

        {{-- TEACHER SELECTOR --}}
        <div class="row mb-7">
            @php
                $teacherContainerId = "teacher_container_id_" . uniqId();
            @endphp
            <div class="col-md-12" id="{{ $teacherContainerId }}">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Giảng viên</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select form-control {{ isset($teacherFind)  ? 'pe-none' : '' }}" data-placeholder="Chọn giảng viên"
                data-allow-clear="true" data-control="select2" name="teacher_id"  data-dropdown-parent ="#{{ $formId }}" required >
                </select>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
            </div>
        </div>
    </div>

    <script>
        var subjectSelector, teacherSelector;

        $(() => {
            teacherSelector = new TeacherSelector({
                container: () => {
                    return $('#{{ $teacherContainerId }}');
                }
            })

            subjectSelector = new SubjectSelector({
                container: () => {
                    return $('#{{ $subjectContainerId }}');
                }
            })
        })

        var SubjectSelector = class {
            constructor(options) {
                this.container = options.container; // function

                this.events();
                this.changeOption();
            }

            getContainer() {
                return this.container();
            }

            getSelector() {
                return this.getContainer().find('select');
            }

            changeOption() {
                if (this.getSelector().select2('val')) {
                    if (this.getSelector().val()) {
                        teacherSelector.loadOptionsBySubject(this.getSelector().val());
                    }
                }
            }

            events() {
                this.getSelector().on('change', e => {
                    this.changeOption();
                })

                this.getSelector().on("select2:unselecting", e => {
                    teacherSelector.resetOptions();
                });
            }
        }

        var TeacherSelector = class {
            constructor(options) {
                this.container = options.container;
            }

            getContainer() {
                return this.container();
            }

            getSelector() {
                return this.getContainer().find('select');
            }

            resetOptions(options) {
                this.getSelector().html(options ? options : '');
            }

            loadOptionsBySubject(id) {
                const selectedTeacher = "{!! isset($salarySheet->teacher_id) ? $salarySheet->teacher_id : null !!}";

                $.ajax({
                    url: "{{ action([App\Http\Controllers\TeacherController::class, 'getTeacherSelectOptionsBySubjectId']) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        selectedTeacher: selectedTeacher
                    }
                }).done(response => {
                    this.resetOptions(response);
                }).fail(response => {
                    throw new Error('Load teacher options by subject id fail!');
                })
            }
        }
    </script>

    <div class="row g-9 mb-7 ">
        <!--begin::Col-->
        <div class="col-md-12 fv-row ">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Loại hình lớp</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select form-control" data-placeholder="Chọn loại hình lớp"
            data-allow-clear="true" data-control="select2" id="type" name="type" required >
            <option value="">Chọn loại hình lớp </option>
            @foreach(\App\Models\Course::getAllClassTypes() as $type)
                <option value="{{ $type }}" {{ isset($salarySheet) && $salarySheet->type == $type ? 'selected' : '' }}>{{ trans('messages.courses.class_type.' . $type) }}</option>
            @endforeach
            </select>
            <!--end::Input-->
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>
        <!--end::Col-->
    </div>

    <div class="row g-9 mb-7 ">
        <div class="col-md-6 fv-row ">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Hình thức học</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select form-control" data-placeholder="Chọn hình thức học"
            data-allow-clear="true" data-control="select2"  name="study_method" required >
            <option value="">Chọn hình thức học</option>
            @foreach(App\Models\Course::getAllStudyMethod() as $method)
            <option value="{{ $method }}" {{ isset($salarySheet->study_method) && $salarySheet->study_method === $method ? 'selected' : '' }}>{{ $method }}</option>    
            @endforeach
            </select>
            <!--end::Input-->
            <x-input-error :messages="$errors->get('study_method')" class="mt-2" />
        </div>

        <div class="col-md-6 fv-row ">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Quy mô lớp</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" id="class_size-input" class="form-control @if ($errors->has('class_size')) is-invalid @endif"
                placeholder="" name="class_size" value="{{ $salarySheet->class_size }}" />
            <!--end::Input-->
            <x-input-error :messages="$errors->get('class_size')" class="mt-2" />
        </div>
    </div>

    <div class="row g-9 mb-7">
        <!--begin::Col-->
        <div class="col-md-4 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Lương / giờ</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="amount" id="amount-input" class="form-control @if ($errors->has('amount')) is-invalid @endif"
                placeholder="" name="amount" value="{{ $salarySheet->amount }}" />
            <!--end::Input-->
            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
        </div>
        <!--end::Col-->
         <!--begin::Col-->
         <div class="col-md-4 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Đơn vị</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select form-control" data-placeholder="Chọn đơn vị"
                data-allow-clear="true" data-control="select2" name="currency" required >
                <option value="">Chọn đơn vị</option>
                @foreach(App\Models\Payrate::getAllCurrencyTypes() as $currency)
                    <option value="{{ $currency }}" {{ isset($salarySheet->currency) && $salarySheet->currency === $currency ? 'selected' : '' }}>{{ $currency }}</option>    
                @endforeach
                
            </select>
            <!--end::Input-->
            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
        </div>
        <!--end::Col-->

         <!--begin::Col-->
         <div class="col-md-4 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Ngày áp dụng</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input data-control="input"  name="effective_date" placeholder="=asas" type="date"
            class="form-control" placeholder="" value="{{ $salarySheet->effective_date }}" required />
            <span data-control="clear" class="material-symbols-rounded clear-button"
                style="display:none;">close</span>
            <!--end::Input-->
            <x-input-error :messages="$errors->get('effective_date')" class="mt-2" />
        </div>
        <!--end::Col-->
    </div>

    <div>
        <div class="row g-9 mb-7" id="{{ $payratesFormUniqId }}">
            <div class="col-3 mb-4">
                <div class="form-outline mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="branch-select">Chọn chi nhánh</label>
                    <select id="branch-select" class="form-select form-control " data-control="select2"
                        data-placeholder="Chọn chi nhánh đào tạo">
                        <option value="">Chọn chi nhánh</option>
                        @foreach (App\Models\TrainingLocation::getBranchs() as $branch)
                            <option value="{{ $branch }}" {{ isset($salarySheet->training_location_id) &&
                                \App\Models\TrainingLocation::find($salarySheet->training_location_id)->branch === $branch
                                    ? 'selected'
                                    : '' }}>
                                {{ trans('messages.training_location.' . $branch) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="form-outline mb-5">
                    <label class="fs-6 fw-semibold required mb-2" for="location-select">Chọn địa điểm đào tạo</label>
                    <select id="location-select" class="form-select form-control" name="training_location_id"
                        data-control="select2" data-placeholder="Chọn địa điểm đào tạo">
                    </select>
                </div>
                <x-input-error :messages="$errors->get('training_location_id')" class="mt-2" />
            </div>

            <script>
                var trainingLocationHandle;
    
                $(() => {
                    trainingLocationHandle = new TrainingLocationHandle({
                        container: document.querySelector('#{{ $payratesFormUniqId }}')
                    })
                })
    
                var TrainingLocationHandle = class {
                    constructor(options) {
                        this.container = options.container;
    
                        this.init();
                    }
    
                    getContainer() {
                        return this.container;
                    }
    
                    // Branch
                    getBranchSelector() {
                        return this.getContainer().querySelector('#branch-select');
                    }
    
                    // Branch value selected
                    getBranch() {
                        return this.getBranchSelector().value;
                    }
    
                    // Location
                    getLocationSelector() {
                        return this.getContainer().querySelector('[name="training_location_id"]');
                    }
    
                    // Location value selected
                    getLocation() {
                        return this.getLocationSelector().value;
                    }
    
                    changeBranch() {
                        this.queryLocations();
                    }
    
                    getLocationSelectedId() {
                        const id = "{{ isset($salarySheet->training_location_id) ? $salarySheet->training_location_id : '' }}";
    
                        return id;
                    }
    
                    createLocationsOptions(locations) {
                        let options = '<option value="">Chọn</option>';
                        const locationSelectedId = this.getLocationSelectedId();
                        let selected = '';
    
                        locations.forEach(i => {
                            const id = i.id;
                            const name = i.name;
    
                            if (parseInt(i.id) === parseInt(locationSelectedId)) {
                                selected = 'selected';
                            } else {
                                selected = '';
                            }
    
                            options += `<option value="${id}" ${selected}>${name}</option> `;
                        })
    
                        return options;
                    }
    
                    // Call ajax to get all locations froms server
                    queryLocations() {
                        const _this = this;
                        const branch = this.getBranch();
                        const url = "{!! action([App\Http\Controllers\TrainingLocationController::class, 'getTrainingLocationsByBranch'],['branch' => 'PLACEHOLDER'],) !!}";
                        const updateUrl = url.replace('PLACEHOLDER', branch);
    
                        $.ajax({
                            url: updateUrl,
                            method: 'get'
                        }).done(response => {
                            const options = _this.createLocationsOptions(response);
    
                            _this.getLocationSelector().innerHTML = options;
                        }).fail(response => {
                            throw new Error(response.message);
                        })
                    }
    
                    init() {
                        this.events();
                        this.changeBranch();
                    }
    
                    events() {
                        const _this = this;
    
                        // Remove events before add event handle
                        // _this.getBranchSelector().outerHTML = _this.getBranchSelector().outerHTML;
    
                        $(_this.getBranchSelector()).on('change', function(e) {
                            e.preventDefault();
                            _this.changeBranch();
                        })
                    }
                }
    
            </script>

            <div class="col-md-6 fv-row ">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Tình trạng lớp học</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select form-control" data-placeholder="Chọn tình trạng lớp học"
                data-allow-clear="true" data-control="select2" name="class_status" required >
                <option value="">Chọn tình trạng lớp học</option>
                @foreach(\App\Models\Course::getAllStatus() as $status)
                    <option value="{{ $status }}" {{ isset($salarySheet->class_status) && $salarySheet->class_status == $status ? 'selected' : ''}}>{{ $status }}</option>
                @endforeach
                </select>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('class_status')" class="mt-2" />
            </div>
        </div>
    </div>

    
    <!--end::Input group-->

</div>
<!--end::Scroll-->
<script>
    $(document).ready(function() {
        initializePriceInput();
    });

    function initializePriceInput() {
        const priceInput = $('#amount-input');
        const classTypeSelect = $('#type');


        if (priceInput.length) {
            const mask = new IMask(priceInput[0], {
                mask: Number,
                scale: 0,
                thousandsSeparator: ',',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
            });

            $('#{{ $formId }}').on('submit', function() {
                priceInput.val(priceInput.val().replace(/,/g, ''));
            });
        }

        if (classTypeSelect.length) {
            classTypeSelect.on('change', function() { 
                const selectedValue = $(this).val();
                if (selectedValue === '{{ App\Models\Course::CLASS_TYPE_ONE_ONE }}') {
                    $('#class_size-input').val('1');
                    $('#class_size-input').prop('readonly', true);
                } else {
                    $('#class_size-input').prop('readonly', false);
                }
            });
        }
    }

   


</script>