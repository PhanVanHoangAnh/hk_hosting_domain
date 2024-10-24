@extends('layouts.main.popup')

@section('title')
    Thêm dự thu
@endsection

@section('content')
    <form id="CreateAccountKpiNoteForm" action="{{ action([App\Http\Controllers\AccountKpiNoteController::class, 'store']) }}"
        method="post">
        @csrf
 
        <!--begin::Scroll-->
        <div class="pe-7  py-10 px-lg-17">
            <!--begin::Input group-->
            <div class="row">
                <div class="col-md-12">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class=" required fs-6 fw-semibold mb-2">
                            <span class="">Khách hàng</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        
                        <div class="form-outline">
                            @include('helpers.contactSelector', [
                                'name' => 'contact_id',
                                'url' => action('App\Http\Controllers\Sales\ContactController@select2'),
                                'controlParent' => '#CreateAccountKpiNoteForm',
                                'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                                'value' => $contact ? $contact->id  : null,
                                'text' => $contact  ? $contact->getSelect2Text() : null,
                                'createUrl' => action('\App\Http\Controllers\Sales\ContactController@create'),
                                'editUrl' => action('\App\Http\Controllers\Sales\ContactController@edit', 'CONTACT_ID'),
                            ])
                            {{-- <select id="contact-select" list-action="contact-select-change" data-control="select2-ajax"
                            data-dropdown-parent="#CreateAccountKpiNoteForm"
                                data-allow-clear="true" data-placeholder="Chọn khách hàng/liên hệ" data-control="select2"
                                data-url="{{ action('App\Http\Controllers\Sales\ContactController@select2') }}"
                                class="form-control" name="contact_id" required>
                                
                                <option value="">Chọn khách hàng/liên hệ</option>

                            </select> --}}
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                        </div>
                    </div>

                </div> 
            </div>

            <div class="row mb-4" data-control="service-type-container">
                <div class="col-md-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Loại dịch vụ</label> 
                        <select class="form-select " list-action='check' data-dropdown-parent="#CreateAccountKpiNoteForm"  name="service_type" 
                        data-action="service-type"
                            data-control="select2" placeholder="Chọn loại dịch vụ..." required>
                            <option value="">Chọn</option>
                            <option value="{{ config('constants.SERVICE_TYPE_EDU') }}">Đào tạo</option>
                            <option value="{{ config('constants.SERVICE_TYPE_ABROAD') }}">Du học</option>
                            <option value="{{ config('constants.SERVICE_TYPE_EXTRACURRICULAR') }}">Ngoại khóa</option>
                        </select>
                        <x-input-error :messages="$errors->get('service_type')" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-8">

                    <div class="" service-type="{{ config('constants.SERVICE_TYPE_ABROAD') }}" style="display:none;">

                    </div>

                    <div class="" service-type="{{ config('constants.SERVICE_TYPE_EXTRACURRICULAR') }}" style="display:none;">
                        <div class="">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="">Loại chương trình NK</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select list-action="marketing-type-select required" 
                                data-dropdown-parent="#CreateAccountKpiNoteForm"
                                class="form-select" data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn" name="extracurricular_type">
                                <option value="">Chọn loại chương trình NK</option>
                                @foreach(config('typeExtracurricular') as $type)
                                <option value="{{ $type }}" >{{ $type }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
    
                        </div>
                    </div>

                    <div class="" service-type="{{ config('constants.SERVICE_TYPE_EDU') }}" style="display:none;">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-6 mb-4">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2">Loại đào tạo</label>
                                    <select class="form-select form-control"  
                                        data-dropdown-parent="#CreateAccountKpiNoteForm"
                                        name="type" data-action="type-select"
                                        data-control="select2" placeholder="Chọn loại đào tạo..." >
                                        <option value="">Chọn</option>    
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-6 mb-4">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2">Môn học</label>
                                    <select class="form-select form-control " data-action="subject-select"
                                        data-dropdown-parent="#CreateAccountKpiNoteForm"
                                        data-control="select2" name="subject_id" data-placeholder="Chọn môn học...">
                                        <option value="">Chọn</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(function() {
                    new ServiceType({
                        container: $('#CreateAccountKpiNoteForm'),
                    });
                });

                var ServiceType = class {
                    constructor(options) {
                        this.container = options.container;

                        // select current type
                        this.selectType(this.getType());

                        this.events();
                    }

                    getTypeSelect() {
                        return this.container.find('[data-action="service-type"]');
                    }

                    getTypeBox(type) {
                        return this.container.find('[service-type="'+type+'"]');
                    }

                    getAllBoxes() {
                        return this.container.find('[service-type]');
                    }

                    getType() {
                        return this.getTypeSelect().val();
                    }

                    selectType(type) {
                        // hide all boxes
                        this.getAllBoxes().hide();

                        // remove all required
                        this.getAllBoxes().find(':input').prop('required', false);

                        // show select type box
                        this.getTypeBox(type).show();

                        // remove all required
                        this.getTypeBox(type).find(':input').prop('required', true);
                    }

                    events() {
                        var _this = this;

                        this.getTypeSelect().on('change', function() {
                            _this.selectType($(this).val());
                        });
                    }
                }
            </script>


            <div class="row">
                <div class="col-md-4">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class=" required fs-6 fw-semibold mb-2">
                            <span class="">Ngày dự thu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="estimated_payment_date" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class=" required fs-6 fw-semibold mb-2">
                            <span class="">Dự thu</span>
                        </label>

                        <input type="text" class="form-control" id="price-input" name="amount" placeholder="Số tiền"
                            list-action="amount-number" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Trạng thái</label>
                        <select class="form-select form-control " data-action="status-select"
                            data-control="select2" name="status" data-placeholder="Chọn dịch vụ...">
                            <option value="">Chọn</option>
                            @foreach (App\Models\AccountKpiNote::getAllTypeVariable() as $status)
                                <option value="{{ $status }}">{{ trans('messages.account_kpi_note.status.' . $status) }}</option>
                            @endforeach
                            {{-- <option value="received">Đã thu</option>
                            <option value="pending">Pending</option>
                            <option value="fail">Fail</option> --}}
                        </select>
                        <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                    </div>

                </div>

            </div>

            <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class=" fs-6 fw-semibold mb-2">Ghi chú</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="note" rows="5" cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('note')" class="mt-2" />
            <!--end::Permissions-->
        </div>

        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateAccountKpiNoteSubmitButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
        $(function() {
            AccountKpiNoteCreate.init();
            initializeEFCNumber();
            new SubjectsManager({
                container: document.getElementById('CreateAccountKpiNoteForm'), 
            });
                    
        });
        var SubjectsManager = class {
            subjects = {!! json_encode(App\Models\Subject::all()) !!};

            constructor(options) {
                this.container = options.container;
                this.allowLoadTypes = true;

                this.init();
            }

            getContainer() {
                return this.container;
            }

            setAllowLoadTypes(isAllow) {
                this.allowLoadTypes = isAllow;
            }

            getAllowLoadTypes() {
                return this.allowLoadTypes;
            }

            getSubjects() {
                return this.subjects;
            }

            getTypes() {
                const types = [];

                this.getSubjects().forEach(subject => {
                    if (!types.includes(subject.type)) {
                        types.push(subject.type);
                    }
                });

                return types;
            }

            getSubjectsByType(type) {
                return this.getSubjects().filter(subject => subject.type === type);
            }

            getSubjectById(id) {
                return this.getSubjects().find(subject => parseInt(id) === parseInt(subject.id));
            }

            getTypeSelect() {
                return this.getContainer().querySelector('[data-action="type-select"]');
            }

            getSubjectSelect() {
                return this.getContainer().querySelector('[data-action="subject-select"]');
            }

            loadTypeOptions(selectedType) {
                const optionsString = this.getTypes().map(type =>
                    `<option value="${type}" ${selectedType === type ? 'selected' : ''}>${type}</option>`
                ).join('');

                this.getTypeSelect().innerHTML = `<option value="">Chọn loại đào tạo</option>${optionsString}`;
            }

            loadSubjectOptionsByType(type, selectedSubject) {
                const subjects = this.getSubjectsByType(type);

                const optionsString = subjects.map(subject =>
                    `<option value="${subject.id}" ${selectedSubject && selectedSubject.id === subject.id ? 'selected' : ''}>${subject.name}</option>`
                ).join('');

                this.getSubjectSelect().innerHTML = `<option value="">Chọn môn học</option>${optionsString}`;
            }

            selectTypeHandle(type) {
                if (this.getAllowLoadTypes()) {
                    this.loadSubjectOptionsByType(type);
                }
            }

            init() {
                this.loadTypeOptions();
                this.events();
            }

            events() {
                const _this = this;

                $(_this.getTypeSelect()).on('change', function (e) {
                    e.preventDefault();
                    _this.selectTypeHandle(this.value);
                });
            }
        };

        var AccountKpiNoteCreate = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                // Lấy dữ liệu từ biểu mẫu.
                var data = $(form).serialize();

                // Loại bỏ dấu phân cách hàng nghìn khỏi trường dữ liệu
                var amountInput = $('[list-action="amount-number"]');

                // Kiểm tra xem có phần tử tồn tại và có giá trị không
                if (amountInput.length && amountInput[0].value !== undefined) {
                    var unmaskedValue = amountInput[0].value.replace(/,/g, '');
                    var valueWithoutSeparator = parseFloat(unmaskedValue);

                    // Kiểm tra xem giá trị là một số hợp lệ hay không
                    if (isNaN(valueWithoutSeparator)) {
                        throw new Error('Giá trị nhập không phải là một số hợp lệ.');
                        return;
                    }

                    // Thêm hiệu ứng
                    addSubmitEffect();

                    // Thay đổi dữ liệu để bỏ dấu phân cách
                    data = data.replace(/amount=[^&]*/, 'amount=' + valueWithoutSeparator);

                    $.ajax({
                        url: '{{ action([App\Http\Controllers\AccountKpiNoteController::class, 'store']) }}',
                        method: 'POST',
                        data: data,
                    }).done(function(response) {
                        // hide popup
                        CreateAccountKpiPopup.getPopup().hide();
                        
                        if (typeof UpdateContactRequestPopup !== 'undefined' && UpdateContactRequestPopup !== null) {
                                UpdateContactRequestPopup.getPopup().hide();
                            }
                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                // reload list
                                if (typeof AccountKpiList !== 'undefined' && AccountKpiList !== null) {
                                    AccountKpiList.getList().load();
                                }
                               
                               
                            }
                        });
                        
                    }).fail(function(response) {
                        CreateAccountKpiPopup.getPopup().setContent(response.responseText);

                        // 
                        removeSubmitEffect();
                    });
                } else {
                    throw new Error('Không tìm thấy phần tử hoặc giá trị không được định nghĩa.');
                }
            };

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
                    form = document.getElementById('CreateAccountKpiNoteForm');
                    btnSubmit = document.getElementById('CreateAccountKpiNoteSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();

        function initializeEFCNumber() {
            const efcInput = $('[list-action="amount-number"]');
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
    </script>
@endsection
