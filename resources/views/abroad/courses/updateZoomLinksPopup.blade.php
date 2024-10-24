@extends('layouts.main.popup')

@section('title')
Chỉnh sửa thông tin phòng học Zoom
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form method="POST" id="{{$formId}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $section->id }}" name="section_id">

        <div class="pe-7 py-5 px-lg-17" >
            <div class="row mb-7">
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="" style="filter: blur(0.5px);">Link mở lớp hiện tại</span>
                        </label>
                        <div class="form-outline">
                            <input type="text" style="border-radius: 12px; filter: blur(0.5px); font-weight: 50; cursor: not-allowed; opacity: 0.6;" class="border-0 form-control" readonly value="{{ $section->zoom_start_link }}">
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="" style="filter: blur(0.5px);">Link tham gia hiện tại</span>
                        </label>
                        <div class="form-outline">
                            <input type="text" style="border-radius: 12px; filter: blur(0.5px); font-weight: 50; cursor: not-allowed; opacity: 0.6;" class="border-0 form-control" readonly value="{{ $section->zoom_join_link }}">
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="" style="filter: blur(0.5px);">Password hiện tại</span>
                        </label>
                        <div class="form-outline">
                            <input type="password" style="border-radius: 12px; filter: blur(0.5px); font-weight: 50; cursor: not-allowed; opacity: 0.6;" class="border-0 form-control" readonly value="{{ $section->zoom_password }}">
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2"/>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mt-15">
                @if ($section->course->study_method == \App\Models\Course::STUDY_METHOD_ONLINE)
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
                                data-control="select2" data-placeholder="Chọn tài khoản để tạo mới link zoom" data-allow-clear="true">
                                <option value="">Chọn tài khoản để tạo mới link zoom</option>
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
                                <label class="fs-6 mb-3" for="target-input">Nhập link mở phòng học mới (cho chủ phòng)</label>
                                <input type="text" class="form-control" placeholder="Nhập link mở phòng mới..." name="zoom_start_link"
                                value="{{ isset($switch) && $switch ? '' : (isset($zoomStartLink) ? $zoomStartLink : '') }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                            </div>

                            <!-- Join link form -->
                            <div class="col-lg-11 col-xl-11 col-md-11 col-sm-11 col-11 mb-6">
                                <label class="fs-6 mb-3" for="target-input">Nhập link tham gia mới (cho các học viên)</label>
                                <input type="text" class="form-control" placeholder="Nhập link tham gia mới..." name="zoom_join_link" 
                                value="{{ isset($switch) && $switch ? '' : (isset($zoomJoinLink) ? $zoomJoinLink : '') }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                            </div>

                            <!-- Password form -->
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-6">
                                <label class="fs-6 mb-3" for="target-input">Nhập mật khẩu</label>
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
                <div class="col-md-12">
                    @if ($errors->has('overlap_zoom_schedule_errors'))
                        <x-input-error :messages="$errors->get('overlap_zoom_schedule_errors')[0]" class="mt-2"/>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-5 py-7">
            <button data-action="save-edit-btn" type="submit" class="btn btn-primary me-2">
                <span class="indicator-label">Chỉnh sửa</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
        </div>
    </form>

    <script>
        $(function() {
            UpdateZoomLinksManager.init();
        });

        var UpdateZoomLinksManager = (function() {
            var form;
            var btnSubmit;
            var getContainer = function() {
                return form;
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

            var addLoadingEffect = function() {
                getContainer().classList.add("list-loading");

                if (!getContainer().querySelector('[list-action="loader"]')) {
                    $(getContainer()).before(`
                        <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);
                };
            };

            var removeLoadingEffect = function() {
                getContainer().classList.remove("list-loading");
                if (getContainer().querySelector('[list-action="loader"]')) {
                    getContainer().querySelector('[list-action="loader"]').remove();
                };
                
                KTComponents.init();
            };

            var submit = function() {
                var sectionIdSelect = form.querySelector('[name="section_id"]');
                var sectionId = sectionIdSelect.value;
                var formData = $(form).serialize();
                var url = "{{ action('App\Http\Controllers\Abroad\SectionController@updateZoomLinks', ['id' => 'PLACEHOLDER']) }}";
                url = url.replace('PLACEHOLDER', sectionId);

                addSubmitEffect();
                addLoadingEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                }).done(response => {
                    if (typeof AttendancePopup !== 'undefined') {
                        AttendancePopup.getPopup().hide();
                    } else if (typeof ShowOrderPopup !== 'undefined') {
                        ShowOrderPopup.getPopup().hide();
                    }
                    
                    removeSubmitEffect();
                    removeLoadingEffect();

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
                    removeLoadingEffect();
                });
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
                },

                getContainer: getContainer,
                submit: submit,
                addSubmitEffect: addSubmitEffect,
                removeSubmitEffect: removeSubmitEffect,
            };
        })();
    </script>
@endsection