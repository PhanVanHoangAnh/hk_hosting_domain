@extends('layouts.main.popup')

@section('title')
{{ !isset($orderItem) ? 'Thêm: Dịch vụ demo' : 'Sửa: Dịch vụ demo' }}
@endsection

@php
    $createDemoOrderItemPopupUniqid = 'createDemoOrderItemPopupUniqid_' . uniqid();
@endphp

@section('content')
<form id="{{ $createDemoOrderItemPopupUniqid }}" tabindex="-1">
    @csrf
    <input type="hidden" data-saved="type" value="{{ isset($type) ? $type : "" }}">
    <input type="hidden" data-saved="subject_id" value="{{ isset($subject_id) ? $subject_id : "" }}">
    <div class="scroll-y px-7 py-10 px-lg-17">
        <input type="hidden" name="type" value="request-demo">
        <input class="type-input" type="hidden" value="{{ App\Models\Order::TYPE_REQUEST_DEMO }}">
        @include('generals.subjects.subject_select_package._box', [
            'parentId' => $createDemoOrderItemPopupUniqid,
            // 'originType' => isset($subjectType) ? $subjectType : null,
            'originType' => isset($orderItem->subject->type) ? $orderItem->subject->type : (isset($subjectType) ? $subjectType : null),
            'selectedLevel' => isset($orderItem->level) ? $orderItem->level : null,
        ])  

        <h3 class="mt-15 mb-10">Chi tiết đào tạo</h3>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="class-type">Loại hình lớp</label>
                    <select id="class-type" class="form-select form-control" name="class_type"
                        data-control="select2" data-dropdown-parent="#{{ $createDemoOrderItemPopupUniqid }}" data-placeholder="Chọn loại hình học" data-allow-clear="true">
                        <option value="">Chọn loại hình lớp</option>
                        @foreach(\App\Models\Course::getAllClassTypes() as $type)
                            <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->class_type == $type ? 'selected' : '' }}>{{ trans('messages.courses.class_type.' . $type) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('class_type')" class="mt-2" />
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="study-type-select">Hình thức học</label>
                    <select id="study-type-select" class="form-select form-control" name="study_type"
                        data-control="select2" data-dropdown-parent="#{{ $createDemoOrderItemPopupUniqid }}" data-placeholder="Chọn hình thức học" data-allow-clear="true">
                        <option value="">Chọn hình thức học</option>
                        @foreach(config('studyTypes') as $type)
                        <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->study_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('study_type')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- Study location --}}
        <div class="row mb-4">
            @include('generals._location', [
                'trainingLocation' => isset($orderItem) ? $orderItem->trainingLocation : null
            ])
        </div>

        <div class="row mb-4 d-none">
            {{-- Teacher time & salary of staffs table --}}
            {{-- @include('abroad.extracurricular.orders._demoStaffTimesManager') --}}
        </div>

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="save_{{ $createDemoOrderItemPopupUniqid }}" class="btn btn-primary">
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
        // subjectsManager = new SubjectsManager({
        //     container: document.querySelector('#{{ $createDemoOrderItemPopupUniqid }}'),
        //     loadSavedDone: false
        // });

        var demoFormManage = new DemoFormManage({
            container: document.querySelector('#{{ $createDemoOrderItemPopupUniqid }}')
        });

        initJs(document.querySelector('#{{ $createDemoOrderItemPopupUniqid }}'));
    });

    var DemoFormManage = class {
        constructor(options) {
            this.container = options.container;
            this.init();
        };

        getContainer() {
            return this.container;
        };

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

        init() {
            this.demoOrderItemForm = new OrderForm({
                form: $("#{{ $createDemoOrderItemPopupUniqid }}"),
                submitBtnId: 'save_{{ $createDemoOrderItemPopupUniqid }}',
                popup: AddDemoOrderPopup.getPopup(),
                orderItemId: "{{ !isset($orderItem) ? null : $orderItemId }}",
            });

            this.scrollToErrorManager = new ScrollToErrorManager({
                container: document.querySelector('#{{ $createDemoOrderItemPopupUniqid }}')
            });
        };
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