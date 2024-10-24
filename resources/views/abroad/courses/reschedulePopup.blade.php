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
                                        {{ isset($sectionItem->course->subject->name) ? $sectionItem->course->subject->name : "--" }} - {{  date('d/m/Y', strtotime($sectionItem->study_date)) }} -   {{ $sectionItem->start_at ? date('H:i', strtotime($sectionItem->start_at)) : '' }} - {{ $sectionItem->end_at ? date('H:i', strtotime($section->end_at)) : '' }}
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

                    @if ($errors->has('overlap_zoom_schedule_errors'))
                        <x-input-error :messages="$errors->get('overlap_zoom_schedule_errors')[0]" class="mt-2"/>
                    @endif
                </div>

                @if ($section->course->study_method == \App\Models\Course::STUDY_METHOD_ONLINE)
                    @if ($errors->has('overlap_zoom_schedule_errors'))
                        @php
                            $zoomFormUniqId = 'zoom_form_uniq_id_' . uniqId();
                        @endphp

                        {{-- ZOOM --}}
                        <div class="row mb-4 position-relative" form-control="zoom" form-uniq-id="{{ $zoomFormUniqId }}">
                            <script>
                                $(() => {
                                    zoomManager = new ZoomManager({
                                        container: () => {
                                            return $('[form-uniq-id="{{ $zoomFormUniqId }}"]');
                                        }
                                    });
                                })

                                var ZoomManager = class {
                                    constructor(options) {
                                        this.container = options.container;
                                        this.zoomAutoManager = () => {
                                            return new ZoomAutoManager({
                                                container: () => {
                                                    return this.container().find('[form-control="zoom-auto-fill"]');
                                                }
                                            })
                                        };
                                        this.zoomPastValueManager = () => {
                                            return new ZoomPastValueManager({
                                                container: () => {
                                                    return this.container().find('[form-control="zoom-past-value"]');
                                                }
                                            })
                                        };

                                        this.toggle();
                                        this.events();
                                    }

                                    getZoomAutoManager() {
                                        return this.zoomAutoManager();
                                    }

                                    getZoomPastValueManager() {
                                        return this.zoomPastValueManager();
                                    }

                                    getSwitch() {
                                        return this.container().find('[data-action="zoom-type-switch"]');
                                    }

                                    updateSwitchlabelContent(content) {
                                        this.container().find('[data-content="switch-label-content"]').html(content);
                                    }

                                    disableZoomAutoManager() {
                                        this.getZoomAutoManager().hidden();
                                        this.getZoomAutoManager().getZoomUserIdSelect().val("");
                                    }

                                    disableZoomPastValueManager() {
                                        this.getZoomPastValueManager().hidden();
                                        this.getZoomPastValueManager().getStartUrlInput().val("");
                                        this.getZoomPastValueManager().getJoinUrlInput().val("");
                                        this.getZoomPastValueManager().getPasswordInput().val("");
                                    }

                                    toggle() {
                                        let switchLabelContent = "Nhập thông tin Zoom đã có sẵn";

                                        if (this.getSwitch()[0].checked) {
                                            this.disableZoomPastValueManager();
                                            this.getZoomAutoManager().show();

                                            switchLabelContent = "Tự động tạo thông tin lớp học bằng tài khoản zoom thuộc quản lý của ASMS"
                                        } else {
                                            this.disableZoomAutoManager();
                                            this.getZoomPastValueManager().show();
                                        }

                                        this.updateSwitchlabelContent(switchLabelContent);
                                    }

                                    events() {
                                        const _this = this;

                                        _this.getSwitch().on('change', e => {
                                            e.preventDefault();

                                            this.toggle();
                                        })
                                    }
                                }
                            </script>

                            {{-- Switch button --}}
                            <div class="form-check form-switch ms-3 mb-5" style="--bs-form-switch-width:60px; --bs-form-switch-height:24px">
                                <input data-action="zoom-type-switch" class="form-check-input" type="checkbox" role="switch" id="zoom_fill_type_switch" name="zoom_switch"
                                    {{ isset($switch) && $switch ? 'checked' : '' }}
                                    style="width: var(--bs-form-switch-width); height: var(--bs-form-switch-height); border-radius: var(--bs-form-switch-height);"/>
                                <label class="form-check-label ms-2 ps-2 fw-bold" for="zoom_fill_type_switch" data-content="switch-label-content"></label>
                            </div>
                            
                            {{-- ZOOM auto fill by zoom user id --}}
                            <div form-control="zoom-auto-fill">
                                <select class="form-select form-control" name="zoom_user_id"
                                    data-dropdown-parent="#{{ $formId }}"
                                    data-control="select2" data-placeholder="Chọn tài khoản" data-allow-clear="true">
                                    <option value="">Chọn tài khoản</option>
                                    @foreach ($zoomUsers as $user)
                                        <option value="{{ $user['user_id'] }}"
                                        {{ isset($switch) && $switch ? (isset($zoomUserId) && $zoomUserId == $user['user_id'] ? 'selected' : '') : '' }}
                                        >{{ $user['email'] . " (" . $user['display_name'] . " - " . $user['dept'] . ")" }}</option>
                                    @endforeach
                                </select>
                    
                                <script>
                                    var ZoomAutoManager = class {
                                        constructor(options) {
                                            this.container = options.container;
                                            
                                            this.events();
                                        }

                                        getZoomUserIdSelect() {
                                            return this.container().find('[name="zoom_user_id"]');
                                        }

                                        getCurrentZoomUserId() {
                                            return this.getZoomUserIdSelect().val();
                                        }
                    
                                        getParentElm() {
                                            return this.getZoomUserIdSelect()[0].parentElement;
                                        }

                                        isHiding() {
                                            return this.container().hasClass('d-none');
                                        }

                                        hidden() {
                                            this.container().addClass('d-none');
                                        }

                                        show() {
                                            this.container().removeClass('d-none');
                                        }
                    
                                        addLoadingEffect() {
                                            this.getParentElm().classList.add("list-loading");
                    
                                            if (!document.querySelector('[list-action="loader"]')) {
                                                $(this.getParentElm()).before(`
                                                <div list-action="loader" class="py-20 px-3 text-center" style="position: absolute; left: 9%; top: 70%; transform: translate(-50%, -50%); z-index: 200">
                                                    <div class="spinner-border" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                                `);
                                            };
                                        };
                    
                                        removeLoadingEffect() {
                                            this.getParentElm().classList.remove("list-loading");

                                            if (document.querySelector('[list-action="loader"]')) {
                                                document.querySelector('[list-action="loader"]').remove();
                                            };
                                            
                                            KTComponents.init();
                                        };
                    
                                        addSubmitEffect() {
                                            this.getParentElm().setAttribute('data-kt-indicator', 'on');
                                            this.getParentElm().setAttribute('disabled', true);
                                        };
                                    
                                        removeSubmitEffect() {
                                            this.getParentElm().removeAttribute('data-kt-indicator');
                                            this.getParentElm().removeAttribute('disabled');
                                        };
                    
                                        reloadAvailableOptions(availableZoomUserIds) {
                                            const _this = this;
                    
                                            _this.addSubmitEffect();
                    
                                            $.ajax({
                                                url: "{{ action([App\Http\Controllers\ZoomMeetingController::class, 'getZoomUserSelectOptionsByIds']) }}",
                                                method: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    zoomUserIds: availableZoomUserIds
                                                }
                                            }).done(res => {
                                                _this.getZoomUserIdSelect().html(res);
                                                _this.removeSubmitEffect();
                                            }).fail(res => {
                                                _this.removeSubmitEffect();
                    
                                                throw new Error("Zoom select reload available options fail!");
                                            })
                                        }
                    
                                        events() {
                                            this.getZoomUserIdSelect().on('change', e => {
                                                e.preventDefault();
                                            })
                                        }
                                    }
                                </script>
                            </div>

                            {{-- ZOOM past value --}}
                            <div form-control="zoom-past-value">
                                <!-- Start link form -->
                                <div class="col-lg-11 col-xl-11 col-md-11 col-sm-11 col-11 mb-6">
                                    <label class="fs-6 mb-3" for="target-input">Link mở phòng học (cho chủ phòng)</label>
                                    <input type="text" class="form-control" placeholder="Nhập link mở phòng..." name="zoom_start_link"
                                    value="{{ isset($switch) && $switch ? '' : (isset($zoomStartLink) ? $zoomStartLink : '') }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                                </div>

                                <!-- Join link form -->
                                <div class="col-lg-11 col-xl-11 col-md-11 col-sm-11 col-11 mb-6">
                                    <label class="fs-6 mb-3" for="target-input">Link tham gia (cho các học viên)</label>
                                    <input type="text" class="form-control" placeholder="Nhập link tham gia..." name="zoom_join_link" 
                                    value="{{ isset($switch) && $switch ? '' : (isset($zoomJoinLink) ? $zoomJoinLink : '') }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                                </div>

                                <!-- Password form -->
                                <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-6">
                                    <label class="fs-6 mb-3" for="target-input">Mật khẩu</label>
                                    <input type="password" placeholder="Nhập mật khẩu phòng" class="form-control text-center" name="zoom_password" autocomplete="on"
                                    value="{{ isset($switch) && $switch ? '' : (isset($zoomPassword) ? $zoomPassword : '') }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                                </div>
                            </div>

                            <script>
                                var ZoomPastValueManager = class {
                                    constructor(options) {
                                        this.container = options.container;
                                    }

                                    getStartUrlInput() {
                                        return this.container().find('[name="zoom_start_link"]');
                                    }

                                    getJoinUrlInput() {
                                        return this.container().find('[name="zoom_join_link"]');
                                    }

                                    getPasswordInput() {
                                        return this.container().find('[name="zoom_password"]');
                                    }
                                    
                                    isHiding() {
                                        return this.container().hasClass('d-none');
                                    }
                                    
                                    hidden() {
                                        this.container().addClass('d-none');
                                    }

                                    show() {
                                        this.container().removeClass('d-none');
                                    }
                                }
                            </script>
                        </div> 
                    @endif
                @endif


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

                var url = "{{ action('App\Http\Controllers\Abroad\CourseController@updateSchedulePopup', ['id' => 'PLACEHOLDER']) }}";
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