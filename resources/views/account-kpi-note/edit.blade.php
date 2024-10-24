@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa dự thu
@endsection

@section('content')
    <form id="UpdateAccountKpiForm" action="{{ action(
        [App\Http\Controllers\AccountKpiNoteController::class, 'update'],
        [
            'id' => $account_kpi_notes->id,
        ],
    ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="pe-7  py-10 px-lg-17">
            <!--begin::Input group-->
            <input type="hidden" name="id" value="{{ $account_kpi_notes->id }}" />

            <input type="hidden" name="contact_id" value="{{ $account_kpi_notes->contact_id }}" />
            <div class="row">
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Khách hàng</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">

                            <div id="contact-select" class="form-control" >
                                <strong> {{ $account_kpi_notes->contact->name }}</strong><br>
                                {{ $account_kpi_notes->contact->email }}<br>
                                {{ $account_kpi_notes->contact->phone }} 
                            </div> 
                        </div>
                    </div> 
                </div> 
            </div>
            
            <div class="row mb-4" data-control="service-type-container">
                <div class="col-md-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Loại dịch vụ</label>
                        <select class="form-select form-control"  name="service_type" data-control="service-type"
                            data-control="select2" placeholder="Chọn loại dịch vụ..." required>
                            <option value="">Chọn</option>
                            <option {{ $account_kpi_notes->service_type == config('constants.SERVICE_TYPE_EDU') ? 'selected' : '' }} value="{{ config('constants.SERVICE_TYPE_EDU') }}">Đào tạo</option>
                            <option {{ $account_kpi_notes->service_type == config('constants.SERVICE_TYPE_ABROAD') ? 'selected' : '' }} value="{{ config('constants.SERVICE_TYPE_ABROAD') }}">Du học</option>
                            <option {{ $account_kpi_notes->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR') ? 'selected' : '' }} value="{{ config('constants.SERVICE_TYPE_EXTRACURRICULAR') }}">Ngoại khóa</option>
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
                            <select list-action="marketing-type-select" class="form-select required" data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn" name="extracurricular_type">
                                <option value="">Chọn loại chương trình NK</option>
                                @foreach(config('typeExtracurricular') as $type)
                                <option {{ $account_kpi_notes->extracurricular_type == $type ? 'selected' : '' }} value="{{ $type }}" >{{ $type }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
    
                        </div>
                    </div>

                    <div class="" service-type="{{ config('constants.SERVICE_TYPE_EDU') }}" style="display:none;">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-6 mb-4">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2">Loại dịch vụ</label>
                                    <select class="form-select form-control" name="type" data-action="type-select"  data-control="select2" placeholder="Chọn loại dịch vụ...">
                                        <option value="">Chọn</option>
                                        @foreach(App\Models\Subject::getAllTypes() as $type)
                                            <option value="{{ $type }}" {{ isset($account_kpi_notes->subject_id) && $account_kpi_notes->subject->type === $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-6 mb-4">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2">Dịch vụ</label>
                                    <select class="form-select form-control " data-action="subject-select"
                                        data-control="select2" name="subject_id" data-placeholder="Chọn dịch vụ...">
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
                        container: $('#UpdateAccountKpiForm'),
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
                        return this.container.find('[data-control="service-type"]');
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


            <script>
                $(() => {
                    new SubjectBox({
                        box: $('[data-action="subject-select"]'), 
                        url: '{{ action('\App\Http\Controllers\Edu\CourseController@getSubjects') }}', getTypeSelectBox: function() {
                            return $('[data-action="type-select"]');
                        }
                    , });
                });

                var SubjectBox = class {
                    constructor(options) {
                        this.box = options.box;
                        this.url = options.url;
                        this.getTypeSelectBox = options.getTypeSelectBox;
                        this.events();
                        this.render();
                    }

                    events() {
                        this.getTypeSelectBox().on('change', (e) => {
                            this.clearSubjects();
                            this.render();
                        });

                        if (!this.getTypeSelectBox().val()) {
                            this.box.html('');
                            return;
                        }
                    }

                    render() {
                        $.ajax({
                            url: this.url,
                            type: 'GET',
                            data: {
                                type: this.getTypeSelectBox().val(),
                            },
                        }).done((response) => {
                            this.box.html('<option value="">Chọn dịch vụ</option>');

                            response.forEach(subjects => {
                                const option = `<option value="${subjects.id}">${subjects.name}</option>`;
                                this.box.append(option);
                            });
                
                            if ('{{ isset($account_kpi_notes->subject_id) }}' && this.getTypeSelectBox().val() === '{{ $account_kpi_notes->subject ? $account_kpi_notes->subject->type : 'N/A' }}') {
                                const selectedOption = `<option value="{{$account_kpi_notes->subject_id}}" selected>{{$account_kpi_notes->subject ? $account_kpi_notes->subject->name : 'N/A' }}</option>`;
                                this.box.prepend(selectedOption);
                            }
                        });
                    }

                    clearSubjects() {
                        this.box.html('<option value="">Chọn dịch vụ</option>');
                    }
                };


              

            </script>

            <div class="row">
                <div class="col-md-4">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Ngày dự thu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="estimated_payment_date" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" required value="{{ $account_kpi_notes->estimated_payment_date }}"/>
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Dự thu</span>
                        </label>

                        <input type="text" class="form-control" id="price-edit" name="amount" placeholder="Số tiền"
                            required value="{{ $account_kpi_notes->amount }}"/>
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
                                <option value="{{ $status }}" {{ $account_kpi_notes->status == $status ? 'selected' : '' }}>{{ trans('messages.account_kpi_note.status.' . $status) }}</option>
                            @endforeach
                            {{-- <option value="received"  {{ $account_kpi_notes->status == 'received' ? 'selected' : '' }}>Đã thu</option>
                            <option value="pending"  {{ $account_kpi_notes->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="fail"  {{ $account_kpi_notes->status == 'fail' ? 'selected' : '' }}>Fail</option> --}}
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
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="note" rows="5" cols="40" value="">{{ $account_kpi_notes->note }}</textarea>
                <!--end::Textarea-->
            </div>
            
            
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateAccountKpiSubmitButton" type="submit" class="btn btn-primary">
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
        $(document).ready(function() {
            initializePriceInput();

            function initializePriceInput() {
                const priceInput = $('#price-edit');

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

                    $('#UpdateAccountKpiForm').on('submit', function() {
                        priceInput.val(priceInput.val().replace(/,/g, ''));
                    });
                }
            }
            updateReceipt.init();

        });
        
        function initializePriceInput() {
            const priceInput = $('#price-edit');

            if (priceInput.length) {
                const mask = new IMask(priceInput[0], {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: ',',
                    padFractionalZeros: false,
                    normalizeZeros: true,
                    radix: ',',
                    mapToRadix: ['.'],
                    min: 0,
                });

                $('#CreateAccountKpiForm').on('submit', function() {
                    priceInput.val(priceInput.val().replace(/,/g, ''));
                });
            }
        }

        var updateReceipt = function() {
            let form;
            let submitBtn;
            let paymentId; // Declare paymentId

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    submit();
                });
            };

            submit = () => {
                paymentId = document.querySelector('input[name="id"]').value;

                const formData = $(form).serialize();
                var url = form.getAttribute('action');
                addSubmitEffect();


                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {
                    UpdateAccountKpiPopup.getUpdatePopup().hide();

                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            AccountKpiList.getList().load();
                        },
                    });
                }).fail(message => {
                    UpdateAccountKpiPopup.getUpdatePopup().setContent(message.responseText);
                    removeSubmitEffect();
                });
            };
            addSubmitEffect = () => {

                // btn effect
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {

                // btn effect
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.removeAttribute('disabled');
            }

            deleteUpdatePopup = () => {
                form.removeEventListener('submit', submit);


            }

            return {
                init: () => {

                    form = document.querySelector("#UpdateAccountKpiForm");
                    submitBtn = document.querySelector("#UpdateAccountKpiSubmitButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
