@extends('layouts.main.popup', [
    'size' => 'full'
])

@section('title')
{{ !isset($orderItem) ? 'Thêm: Dịch vụ đào tạo' : 'Sửa: Dịch vụ đào tạo' }}
@endsection

@php
    $createTrainOrderItemPopupUniqid = 'createTrainOrderItemPopupUniqid_' . uniqid();
@endphp

@section('content')
<form id="{{ $createTrainOrderItemPopupUniqid }}" tabindex="-1">
    @csrf
    <input type="hidden" data-saved="type" value="{{ isset($type) ? $type : "" }}">
    <input type="hidden" data-saved="subject_id" value="{{ isset($subject_id) ? $subject_id : "" }}">
    <div class="scroll-y px-7 py-10 px-lg-17">
        <input class="type-input" type="hidden" name="type" value="{{ App\Models\Order::TYPE_EDU }}">

        @include('generals.subjects.subject_select_package._box', [
            'parentId' => $createTrainOrderItemPopupUniqid,
            'originType' => isset($orderItem->subject->type) ? $orderItem->subject->type : (isset($subjectType) ? $subjectType : null),
            'selectedLevel' => isset($orderItem->level) ? $orderItem->level : null,
        ])

        <h3 class="mt-15 mb-10">Chi tiết đào tạo</h3>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="home-room-teacher-select">Chủ nhiệm đề xuất</label>
                    <select id="home-room-teacher-select" class="form-select form-control" name="home_room"
                        data-control="select2" data-dropdown-parent="#{{ $createTrainOrderItemPopupUniqid }}" data-placeholder="Chọn chủ nhiệm đề xuất" data-allow-clear="true">
                        <option value="">Chọn giáo viên chủ nhiệm</option>
                        @foreach(\App\Models\Teacher::homeRooms()->get() as $teacher)
                        <option value="{{ $teacher->id }}" {{ isset($orderItem) && $orderItem->home_room == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('home_room')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="study-type-select">Hình thức học</label>
                    <select id="study-type-select" class="form-select form-control" name="study_type" data-check-error="{{ $errors->has('study_type') ? 'error' : 'none' }}"
                        data-control="select2" data-dropdown-parent="#{{ $createTrainOrderItemPopupUniqid }}" data-placeholder="Chọn hình thức học" data-allow-clear="true">
                        <option value="">Chọn hình thức học</option>
                        @foreach(config('studyTypes') as $type)
                        <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->study_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('study_type')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="target-input">Target</label>
                    <input id="target-input" type="number" class="form-control"
                        placeholder="Nhập điểm targer nếu có" name="target" value={{ !isset($orderItem) ? '' : $orderItem->target }}>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="class-type">Loại hình lớp</label>
                    <select id="class-type" class="form-select form-control" name="class_type" data-check-error="{{ $errors->has('class_type') ? 'error' : 'none' }}"
                        data-control="select2" data-dropdown-parent="#{{ $createTrainOrderItemPopupUniqid }}" data-placeholder="Chọn loại hình lớp" data-allow-clear="true">
                        <option value="">Chọn loại hình lớp</option>
                        @foreach(\App\Models\Course::getAllClassTypes() as $type)
                            <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->class_type == $type ? 'selected' : '' }}>{{ trans('messages.courses.class_type.' . $type) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('class_type')" class="mt-2"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="student-nums-input">Số lượng học viên</label>
                    <input id="student-nums-input" type="number" class="form-control" data-check-error="{{ $errors->has('num_of_student') ? 'error' : 'none' }}"
                        placeholder="Nhập số lượng học viên..." min="1" name="num_of_student" value={{ !isset($orderItem) ? '' : $orderItem->num_of_student }}>
                        <x-input-error :messages="$errors->get('num_of_student')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- Study location --}}
        <div class="row mb-4">
            @include('generals._location', [
                'trainingLocation' => isset($orderItem) ? $orderItem->trainingLocation : null
            ])
        </div>

        <div class="row mb-4">
            {{-- Teacher time & salary of staffs table --}}
            @include('sales.orders._eduStaffTimesManager')
        </div>

        <div id="demo-container" class="row mb-4 d-none">
            <div id="have-studied-form" class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="have-studied-select">Đã học demo chưa?</label>
                    <select id="have-studied-select" class="form-select form-control" name="have_studied" data-control="select2" data-dropdown-parent="#{{ $createTrainOrderItemPopupUniqid }}"
                        data-placeholder="Chọn" data-allow-clear="true">
                        <option value="">Chọn</option>
                        <option value="true" {{ isset($orderItem) && $orderItem->have_studied == 'true' ? 'selected' : '' }}>Đã học</option>
                        <option value="false" {{ isset($orderItem) && $orderItem->have_studied == 'false' ? 'selected' : '' }}>Chưa học</option>
                    </select>
                    <x-input-error :messages="$errors->get('have_studied')" class="mt-2" />
                </div>
            </div>
            <div id="demo-deduction-form" class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2 d-none">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="has-demo-hour-deduction">Có trừ giờ demo hay không?</label>
                    <div class="row">
                        <div id="has-demo-hour-deduction-box-select" class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 pe-0">
                            <select id="has-demo-hour-deduction" class="form-select form-control" name="has_demo_hour_deduction" data-control="select2" data-dropdown-parent="#{{ $createTrainOrderItemPopupUniqid }}"
                                data-placeholder="Chọn..." data-allow-clear="true">
                                <option value="">Chọn</option>
                                <option value="true" {{ isset($orderItem) && $orderItem->has_demo_hour_deduction == 'true' ? 'selected' : '' }}>Có</option>
                                <option value="false" {{ isset($orderItem) && $orderItem->has_demo_hour_deduction == 'false' ? 'selected' : '' }}>Không</option>
                            </select>
                            <x-input-error :messages="$errors->get('has_demo_hour_deduction')" class="mt-2" />
                        </div>
                        <div id="demo-letter-box" class="col-lg-4 col-xs-4 col-sm-4 col-md-4 col-xl-4 ps-1 d-none">
                            <input id="demo-letter-input" type="text" class="form-control"
                            placeholder="Phiếu demo" name="demo_letter">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="hour-demo-input">Số giờ demo</label>
                        <input id="hour-demo-input" type="number" min="0" class="form-control"
                        placeholder="Số giờ demo..." name="demo_hours" value="{{ !isset($orderItem) ? '' : $orderItem->demo_hours }}">
                </div>
            </div>
        </div>

        <div class="row mb-4 d-none">
            <div id="train-hours-form" class="col-lg-3 col-md-3 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="hour-edu-input">Số giờ đào tạo</label>
                        <input id="hour-edu-input" type="number" min="0" class="form-control" data-check-error="{{ $errors->has('train_hours') ? 'error' : 'none' }}"
                        placeholder="Số giờ đào tạo..." name="train_hours" value="{{ !isset($orderItem) ? '' : $orderItem->train_hours }}">
                    <x-input-error :messages="$errors->get('train_hours')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            {{-- Demo studied form --}}
            @include('sales.orders._demoStudied')
        </div>

        <!--id="CreateTrainOrderButton"-->
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="save_{{ $createTrainOrderItemPopupUniqid }}" class="btn btn-primary">
                <span class="indicator-label">Lưu thông tin dịch vụ</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </div>
</form>

<script>
    $(() => {
        eduFormManage = new EduFormManage({
            container: () => {
                return document.querySelector('#{{ $createTrainOrderItemPopupUniqid }}');
            }
        });

        if (document.querySelector('#{{ $createTrainOrderItemPopupUniqid }}')) {
            initJs(document.querySelector('#{{ $createTrainOrderItemPopupUniqid }}'));
        }
    });

    var EduFormManage = class {
        constructor(options) {
            this.container = options.container;

            this.init();
            this.events();
        };

        getContainer() {
            return this.container();
        };

        getClassTypeSelect() {
            return $(this.getContainer()).find('[name="class_type"]');
        }

        getNumOfStudentInput() {
            return $(this.getContainer()).find('[name="num_of_student"]');
        }

        setNumOfStudents(value) {
            this.getNumOfStudentInput().val(value);
        }

        getPriceInput() {
            return this.getContainer().querySelector('[data-control="price-create-input"]');
        };

        disableFillInNumOfStudents() {
            this.getNumOfStudentInput().addClass('pe-none bg-secondary');
        }

        enableFillInNumOfStudents() {
            this.getNumOfStudentInput().removeClass('pe-none bg-secondary');
        }

        getTypeSaved() {
            return this.getContainer().querySelector('[data-saved="type"]');
        };

        getTypeSavedValue() {
            return this.getTypeSaved().value;
        };

        getSubjectIdSaved() {
            return this.getContainer().querySelector('[data-saved="subject_id"]');
        };

        getSubjectIdSavedValue() {
            return this.getSubjectIdSaved().value;
        };

        getScheduleItems() {
            let scheduleItems = null;

            @if($orderItem && $orderItem != null && $orderItem->schedule_items)
                scheduleItems = JSON.parse({!! json_encode($orderItem->schedule_items) !!});

                if(scheduleItems !== null && scheduleItems) {
                    if(scheduleItems.length > 0) {
                        for (let i = 0; i < scheduleItems.length; i++) {
                            scheduleItems[i] = JSON.parse(scheduleItems[i]);
                        };
                    };
                };
            @endif

            return scheduleItems;
        };

        changeToOneOneMode() {
            this.setNumOfStudents(1);
            this.disableFillInNumOfStudents();
        }

        disableOneOneMode() {
            this.enableFillInNumOfStudents();
        }

        changeClassType(value) {
            const ONE_ONE_TYPE = "{!! \App\Models\Course::CLASS_TYPE_ONE_ONE !!}";
            const GROUP_TYPE = "{!! \App\Models\Course::CLASS_TYPE_GROUP !!}";

            if (value === ONE_ONE_TYPE) {
                this.changeToOneOneMode();
            } else {
                this.disableOneOneMode();
            }
        }

        init() {
            if (this.getPriceInput()) {
                const priceInputMask = IMask(this.getPriceInput(), {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: ',',
                    padFractionalZeros: false,
                    normalizeZeros: true,
                    radix: ',',
                    mapToRadix: ['.'],
                    min: 0,
                    max: 999999999999,
                });
            };

            this.trainOrderItemForm = new OrderForm({
                form: $("#{{ $createTrainOrderItemPopupUniqid }}"),
                submitBtnId: 'save_{{ $createTrainOrderItemPopupUniqid }}',
                popup: AddTrainOrderPopup.getPopup(),
                orderItemId: "{{ !isset($orderItem) ? null : $orderItemId }}",
            }); 

            this.scrollToErrorManager = new ScrollToErrorManager({
                container: document.querySelector('#{{ $createTrainOrderItemPopupUniqid }}')
            });

            // this.loadSavedSubjectValues();
        };

        events() {
            this.getClassTypeSelect().on('change', e => {
                this.changeClassType($(e.target).val());
            })
        }
    };

    var ErrorManager = class {
        constructor(options) {
            this.tool = options.tool;
            this.container = options.container;
            this.errors = [];
        }

        // ACTION/METHOD

        getContainer() {
            return this.container;
        }

        getTool() {
            return this.tool;
        }

        // Label show error
        getLabel() {
            return this.getContainer().querySelector('[label-control="error"]');
        }

        showLabel() {
            this.getLabel().classList.remove('d-none');
        }

        hideLabel() {
            this.getLabel().classList.add('d-none');
        }

        setMessageToLabel(msg) {
            this.getLabel().innerHTML = msg;
        }

        resetLabel() {
            this.setMessageToLabel('');
        }

        getErrors() {
            return this.errors;
        }

        getFirstError() {
            return this.getErrors()[0];
        }

        addError(errorMsg) {
            this.errors.push(errorMsg);
        }

        resetErrors() {
            this.errors = [];
        }

        isHasErrors() {
            return this.getErrors().length > 0;
        }

        reset() {
            this.resetErrors();
            this.resetLabel();
            this.hideLabel();
        }

        handle() {
            this.resetLabel();

            if (this.isHasErrors()) {
                const errorMsg = this.getFirstError();
                this.setMessageToLabel(errorMsg);
                this.showLabel();
            } else {
                this.hideLabel();
            }
        }
    }
</script>
@endsection