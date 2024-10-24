@extends('layouts.main.popup')

@section('title')
Chuyển buổi học
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form  method="POST" id="{{$formId}}" enctype="multipart/form-data">
        @csrf
        <!--begin::Scroll-->
        <div class="pe-7 py-5   px-lg-17" >
            <!--begin::Input group-->
            <div class="row">
                <div class="col-md-12">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Chọn buổi học</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <select class="form-select form-control" data-placeholder="Chọn buổi học" 
                                data-allow-clear="true" data-control="select2" name="section_id" required>

                                <option value="">Chọn buổi học</option>
                                @foreach($sectionAll as $sectionItem)
                                    <option value="{{ $sectionItem->id }}" {{ $sectionItem->id === $section->id ? 'selected' : '' }}>
                                        {{ $sectionItem->course->subject->name }} - {{  date('d/m/Y', strtotime($sectionItem->study_date)) }} -   {{ $sectionItem->start_at ? date('H:i', strtotime($sectionItem->start_at)) : '' }} - {{ $sectionItem->end_at ? date('H:i', strtotime($section->end_at)) : '' }}
                                        
                                    </option>
                                    
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Ngày học</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" data-action="study-date-input" name="study_date" type="date"
                                value="{{ date('Y-m-d', strtotime($section->study_date)) }}" class="form-control" required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                            <span data-error="study-date-error" class='d-none' style="color:red">Vui lòng chọn ngày học</span>
                            <span data-error="study-date-error-2" class='d-none' style="color:red">Ngày học phải lớn hơn ngày hiện tại</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xl-6 col-md-6 col-sm-12 col-12 mb-2 d-none">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 mb-2">
                            <div class="form-outline">
                                <label class="required fs-6 fw-semibold mb-2" for="start-at">Bắt đầu</label>
                                <div class="d-flex align-items-center date-with-clear-button">
                                    <input data-action="start-at-input" type="time" value="{{date('H:i', strtotime($section->start_at))}}" class="form-control"
                                        placeholder=""/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                                <span data-error="start-at-error" class='d-none' style="color:red">Vui lòng nhập thời gian bắt đầu</span>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 mb-2">
                            <div class="form-outline">
                                <label class="required fs-6 fw-semibold mb-2" for="end-at">Kết thúc</label>
                                <div   class="d-flex align-items-center date-with-clear-button">
                                    <input data-action="end-at-input" type="time" value="{{date('H:i', strtotime($section->end_at))}}" class="form-control"
                                        placeholder="" readonly/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                                <span data-error="end-at-error" class='d-none' style="color:red">Vui lòng nhập thời gian kết thúc</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Scroll-->
        <div class="d-flex justify-content-center pb-5 py-7">
            <!--begin::Button-->
            <button data-action="save-edit-btn" type="submit" class="btn btn-primary me-2">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
       $(function() {
            ScheduleUpdate.init();

          
        });

        var ScheduleUpdate = (function() {
            var form;
            var btnSubmit;

            var getContainer = function() {
                return form;
            };

            var getDataMapping = function() {
                

                return {
                    start_at: new Date( getData().studyDate + ' ' + getData().startAt).toISOString().split('T')[0] + ' ' + getData().startAt,
                    end_at: new Date( getData().studyDate + ' ' + getData().endAt).toISOString().split('T')[0] + ' ' + getData().endAt,
                };
            };

            var validate = function() {
                const data = getData();

                let errors = {
                    studyDate: !data.studyDate ,
                    studyDate2:  new Date(data.studyDate) < new Date(),
                    startAt: !data.startAt,
                    endAt: !data.endAt,
                    
                };

                showErrors(errors);

                return !Object.values(errors).some(value => value);
            };

            var showErrors = function(errors) {
                const errorElements = {
                    studyDate: getContainer().querySelector('[data-error="study-date-error"]'),
                    studyDate2: getContainer().querySelector('[data-error="study-date-error-2"]'),
                    startAt: getContainer().querySelector('[data-error="start-at-error"]'),
                    endAt: getContainer().querySelector('[data-error="end-at-error"]'),
                   
                };

                Object.keys(errors).forEach(key => {
                    if (errors[key]) {
                        errorElements[key].classList.remove('d-none');
                    } else {
                        errorElements[key].classList.add('d-none');
                    }
                });
                removeSubmitEffect();

            };

            var getData = function() {
                return {
                    studyDate: getStudyDateInputValue(),
                    startAt: getStartAtInputValue(),
                    endAt: getEndAtInputValue(),
                   
                };
            };

            var getStartAtInput = function() {
                return getContainer().querySelector('[data-action="start-at-input"]');
            };

            var getStartAtInputValue = function() {
                return getStartAtInput().value;
            };

            var getEndAtInput = function() {
                return getContainer().querySelector('[data-action="end-at-input"]');
            };

            var getEndAtInputValue = function() {
                return getEndAtInput().value;
            };

            var getStudyDateInput = function() {
                return getContainer().querySelector('[data-action="study-date-input"]');
            };

            var getStudyDateInputValue = function() {
                return getStudyDateInput().value;
            };

           
          

            var submit = function() {
                var sectionIdSelect = form.querySelector('select[name="section_id"]');
                var sectionId = sectionIdSelect.value;

                var formData = $(form).serialize();
                var dataMapping = getDataMapping();

                // var data = formData + '&start_at=' + dataMapping.start_at + '&end_at=' + dataMapping.end_at;

                var url = "{{ action('App\Http\Controllers\Student\CourseController@updateSchedulePopup', ['id' => 'PLACEHOLDER']) }}";
                url = url.replace('PLACEHOLDER', sectionId);


                addSubmitEffect();

                if (validate()) {
                    $.ajax({
                        url: url,
                        method: 'PUT',
                        data: formData,
                    }).done(response => {
                        if (typeof AttendancePopup !== 'undefined') {
                            AttendancePopup.getPopup().hide();
                        } else if (typeof ShowOrderPopup !== 'undefined') {
                            ShowOrderPopup.getPopup().hide();
                        }
                        
                        removeSubmitEffect();

                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                if (typeof SectionList !== 'undefined') {
                                    SectionList.getList().load();
                                } else if (typeof SectionsList !== 'undefined') {
                                    SectionsList.getList().load();
                                }
                                
                                
                            }
                        });
                    }).fail(response => {
                        
                        if (typeof AttendancePopup !== 'undefined') {
                            AttendancePopup.getPopup().setContent(response.responseText);
                        } else if (typeof ShowOrderPopup !== 'undefined') {
                            ShowOrderPopup.getPopup().hide();
                        }
                        
                        removeSubmitEffect();
                    });
                }
            };
            var addSubmitEffect = function() {
                
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.setAttribute('disabled', true);
            };

            var removeSubmitEffect = function() {
                
                btnSubmit.removeAttribute('data-kt-indicator');
                btnSubmit.removeAttribute('disabled');
            };
            var init = function() {
                
                btnSubmit = document.querySelector('[data-action="save-edit-btn"]');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submit();
                });
            };

            var updateEndTime = function() {
                var startAt = getStartAtInputValue();
                var duration = {{$section->calculateDurationSection()}}; 

                
                var startDateTime = new Date('2000-01-01 ' + startAt);
                var endDateTime = new Date(startDateTime.getTime() + duration * 60 * 1000); 

                
                var endAtInput = getEndAtInput();
                endAtInput.value = formatTime(endDateTime);
            };


            var formatTime = function(dateTime) {
                var hours = dateTime.getHours().toString().padStart(2, '0');
                var minutes = dateTime.getMinutes().toString().padStart(2, '0');
                return hours + ':' + minutes;
            };

            

            var handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    submit();
                });
            };

            return {
                init: function() {
                    form = document.getElementById('{{ $formId }}');
                    btnSubmit = form.querySelector('[data-action="save-edit-btn"]');

                    handleFormSubmit();
                    var startAtInput = getStartAtInput();
                        startAtInput.addEventListener('change', function() {
                            updateEndTime();
                        });
                },

                getContainer: getContainer,
                getStudyDateInput: getStudyDateInput,
                getStudyDateInputValue: getStudyDateInputValue,
                getStartAtInput: getStartAtInput,
                getStartAtInputValue: getStartAtInputValue,
                getEndAtInput: getEndAtInput,
                getEndAtInputValue: getEndAtInputValue,

                getData: getData,
                getDataMapping: getDataMapping,
                submit: submit,
                addSubmitEffect: addSubmitEffect,
                removeSubmitEffect: removeSubmitEffect,
            };
        })();

    </script>

@endsection