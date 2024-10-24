<div class="p-3 bg-secondary">
    <div class="row">
        <label class="fs-3 fw-semibold mb-2" for="course-min-students-input">Thời gian dạy còn lại</label>
    </div>
    
    <div>
        <div class="row ps-5 form-outline mb-2">
            <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5 col-5">
                <div class="row">
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-4">
                        <span class="fs-5">Giáo viên Việt Nam:</span>
                    </div>
            
                    <div class="col-lg-8 col-xl-8 col-md-8 col-sm-8 col-8">
                        <span class="fs-5 fw-bold">{{ \App\Helpers\Functions::convertMinutesToHours($course->getRemainStudyMinutesOfVnTeacher()) }} &nbsp;~&nbsp; {{ $course->getRemainStudyMinutesOfVnTeacher() }} phút</span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row ps-5 form-outline mb-2">
            <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5 col-5">
                <div class="row">
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-4">
                        <span class="fs-5">Giáo viên nước ngoài:</span>
                    </div>
            
                    <div class="col-lg-8 col-xl-8 col-md-8 col-sm-8 col-8">
                        <span class="fs-5 fw-bold">{{ \App\Helpers\Functions::convertMinutesToHours($course->getRemainStudyMinutesOfForeignTeacher()) }} &nbsp;~&nbsp; {{ $course->getRemainStudyMinutesOfForeignTeacher() }} phút</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-15 mb-10">Mã lớp <span class="text-danger">{{ $course->code }}</span> - Mã cũ: <span class="text-danger">{{ isset($course->import_id) ? $course->import_id : '--' }}</span></h3>
<input type="hidden" name="module" value="{{ \App\Models\Course::MODULE_ABROAD }}">
<input type="hidden" data-control="action" value="{{ $action }}" readonly>
      <div data-control="course-informations">
        <div id="dataFillForm">
            <input type="hidden" data-control="saved-values" value="{{ isset($course) ? $course : (isset($courseCopy) ? $courseCopy : '') }}">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Thông tin học viên</label>
                        @include('helpers.contactSelector', [
                            'name' => 'order_item_id',
                            'url' => action('App\Http\Controllers\Abroad\OrderItemController@select2'),
                            'controlParent' => '#dataFillForm',
                            'placeholder' => 'Tìm dịch vụ du học từ hệ thống',
                            'value' => isset($course->order_item_id) ? $course->order_item_id : (isset($courseCopy->order_item_id) ? $courseCopy->order_item_id : null),
                            'text' => isset($course->order_item_id) ? \App\Models\OrderItem::find($course->order_item_id)->getSelect2Text() : (isset($courseCopy->order_item_id) ? \App\Models\OrderItem::find($courseCopy->order_item_id)->getSelect2Text() : null),
                            'createUrl' => action('\App\Http\Controllers\Abroad\StudentController@create'),
                            'editUrl' => action('\App\Http\Controllers\Abroad\StudentController@edit', 'CONTACT_ID'),
                            'notAdd' => true,
                            'notEdit' => true,
                            'bgColor' => "bg-secondary"
                        ])
                    <x-input-error :messages="$errors->get('order_item_id')" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- The customer's feedback is to remove the option of selecting the type of study abroad, 
                    and instead of categorizing subjects, they prefer to consolidate them into one select option. 
                    Therefore, i have modified the database by removing data and the 'type' column in 'abroad_services' 
                    and temporarily excluding the functionality of this feature -->
                {{-- @include('abroad.courses._abroadServices') --}}
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="abroad-service-select">Dịch vụ</label>
                        <select select-form="service-select-form" class="form-select form-control" name="abroad_service_id"
                                data-control="select2" data-placeholder="Chọn dịch vụ du học..." data-allow-clear="true" data-dropdown-parent="#dataFillForm">
                                <option value="">Chọn dịch vụ du học</option>
                                @foreach (\App\Models\AbroadService::all() as $abroadService)
                                    <option value="{{ $abroadService->id }}" {{ isset($course) && $course->abroad_service_id == $abroadService->id ? 'selected' : (isset($courseCopy) && $courseCopy->abroad_service_id == $abroadService->id ? 'selected' : '') }}>{{ $abroadService->name }}</option>
                                @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('abroad_service_id')" class="mt-2"/>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="study_method">Hình thức học</label>
                        <select select-form="study_method" name="study_method" class="form-select form-control"
                                data-control="select2" data-placeholder="Chọn hình thức học" data-allow-clear="true">
                                <option value="">Chọn</option>
                                    @foreach (\App\Models\Course::getAllStudyMethod() as $method)
                                        <option value="{{ $method }}" {{ isset($course) && $course->study_method == $method ? 'selected' : (isset($courseCopy) && $courseCopy->study_method == $method ? 'selected' : '') }}>{{ $method }}</option> 
                                    @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('study_method')" class="mt-2"/>
                    </div>
                </div>
            </div>

            @include('abroad.courses._location')

            @php
                $zoomFormUniqId = 'zoom_form_uniq_id_' . uniqId();
            @endphp

            {{-- ZOOM --}}
            <div class="row d-none position-relative" form-control="zoom" form-uniq-id="{{ $zoomFormUniqId }}">
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
                                this.getZoomAutoManager().show();
                                this.disableZoomPastValueManager();

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
                    {{ isset($isUsingZoomUser) && $isUsingZoomUser ? 'checked' : '' }}
                        style="width: var(--bs-form-switch-width); height: var(--bs-form-switch-height); border-radius: var(--bs-form-switch-height);"/>
                    <label class="form-check-label ms-2 ps-2 fw-bold" for="zoom_fill_type_switch" data-content="switch-label-content"></label>
                </div>
                
                {{-- ZOOM auto fill by zoom user id --}}
                <div form-control="zoom-auto-fill">
                    <select class="form-select form-control" name="zoom_user_id"
                        data-control="select2" data-placeholder="Chọn tài khoản" data-allow-clear="true">
                        <option value="">Chọn tài khoản</option>
                        @foreach ($zoomUsers as $user)
                            <option value="{{ $user['user_id'] }}"
                            {{ isset($course->zoom_user_id) && $course->zoom_user_id == $user['user_id'] ? 'selected' : (isset($courseCopy->zoom_user_id) && $courseCopy->zoom_user_id == $user['user_id'] ? 'selected' : '') }}
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
                        value="{{ isset($course->zoom_start_link) ? $course->zoom_start_link : (isset($courseCopy->zoom_start_link) ? $courseCopy->zoom_start_link : '') }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                    </div>

                    <!-- Join link form -->
                    <div class="col-lg-11 col-xl-11 col-md-11 col-sm-11 col-11 mb-6">
                        <label class="fs-6 mb-3" for="target-input">Link tham gia (cho các học viên)</label>
                        <input type="text" class="form-control" placeholder="Nhập link tham gia..." name="zoom_join_link" 
                        value="{{ isset($course->zoom_join_link) ? $course->zoom_join_link : (isset($courseCopy->zoom_join_link) ? $courseCopy->zoom_join_link : '') }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
                    </div>

                    <!-- Password form -->
                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-6">
                        <label class="fs-6 mb-3" for="target-input">Mật khẩu</label>
                        <input type="password" placeholder="Nhập mật khẩu phòng" class="form-control text-center" name="zoom_password" autocomplete="on"
                        value="{{ isset($course->zoom_password) ? $course->zoom_password : (isset($courseCopy->zoom_password) ? $courseCopy->zoom_password : '') }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"/>
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
            </div>

            <div class="mt-5">
                <x-input-error :messages="$errors->get('study_method_error_custom')" class="mt-2 fs-2"/>
                <x-input-error :messages="$errors->get('sections_null_error_custom')" class="mt-2 fs-2"/>
                <x-input-error :messages="$errors->get('teacher_conflict_teach_time_custom')" class="mt-2 fs-2"/>
            </div>

            {{-- HIDE (OLDE VERSION FROM EDU) --}}
            <div class="row d-none">
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Loại đào tạo</label>
                        <select class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" name="type" data-action="type-select"
                            data-control="select2" placeholder="Chọn loại đào tạo..." >
                            <option value="">Chọn</option>    
                        </select>   
                        <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Môn học</label>
                        <select class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" data-action="subject-select"
                            data-control="select2" name="subject_id" data-placeholder="Chọn môn học...">
                            <option value="">Chọn</option>
                        </select>
                        <x-input-error :messages="$errors->get('subject_id')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="level-select">Trình độ</label>
                        <select id="level-select" class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" name="level" data-control="select2" data-dropdown-parent="#dataFillForm" data-placeholder="Chọn trình độ" data-allow-clear="true">
                            <option value="">Chọn</option>
                            @foreach(config('levels') as $level)
                                <option value="{{ $level }}" {{ isset($course) && $course->level == $level ? 'selected' : (isset($courseCopy) && $courseCopy->level == $level ? 'selected' : '') }}>{{ $level }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('level')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Hình thức học</label>
                        <select class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" data-action="study-method-select"
                            data-control="select2" placeholder="Chọn hình thức học..." name="study_method_">
                            <option value="">Chọn</option>
                            @foreach(App\Models\Course::getAllStudyMethod() as $method)
                            <option value="{{ $method }}" {{ isset($course->study_method) && $course->study_method === $method ? 'selected' : (isset($courseCopy) && $courseCopy->study_method == $method ? 'selected' : '') }}>{{ $method }}</option>    
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('study_method')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="class-type-select">Loại hình lớp</label>
                        <select id="class-type-select" class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" name="class_type" data-control="select2" data-dropdown-parent="#dataFillForm" data-placeholder="Chọn trình độ" data-allow-clear="true">
                            <option value="">Chọn</option>
                            @foreach(\App\Models\Course::getAllClassTypes() as $type)
                                <option value="{{ $type }}" {{ isset($course) && $course->class_type == $type ? 'selected' : (isset($courseCopy) && $courseCopy->class_type == $type ? 'selected' : '') }}>{{ trans('messages.courses.class_type.' . $type) }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('class_type')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6 mb-4">
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-2" for="course-min-students-input">Số HV ít nhất</label>
                                <input id="course-min-students-input" type="number" class="form-control" type="number" min="0"
                                    {{ $action === 'edit' && $course->hasFinished() ? 'readonly' : '' }}
                                    placeholder="Nhập số sĩ số tối đa..." name="min_students" value="{{ isset($course->min_students) ? $course->min_students : (isset($courseCopy->min_students) ? $courseCopy->min_students : '0') }}"/>
                                <x-input-error :messages="$errors->get('min_students')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6 mb-4">
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-2" for="course-max-students-input">Số HV tối đa</label>
                                <input id="course-max-students-input" type="number" class="form-control" type="number" min="0"
                                    {{ $action === 'edit' && $course->hasFinished() ? 'readonly' : '' }}
                                    placeholder="Nhập số sĩ số tối đa..." name="max_students" value="{{ isset($course->max_students) ? $course->max_students : (isset($courseCopy->max_students) ? $courseCopy->max_students : '0') }}"/>
                                <x-input-error :messages="$errors->get('max_students')" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('validate_fill_students')" class="mt-2"/>
                    <span class="text-danger d-none" data-control="min-max-error-label"></span>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="row">
                        {{-- <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6 mb-4">
                            <div class="form-outline">
                                <label class="required fs-6 fw-semibold mb-2" for="total_hours_input">Giờ học dự kiến</label>
                                <div data-control="date-with-cleig tpar-button" class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" id="total_hours_input" type="number" min="0" {{ $action === 'edit' && $course->hasFinished() ? 'readonly' : '' }} value="{{ isset($course->total_hours) ? $course->total_hours : (isset($courseCopy->total_hours) ? $courseCopy->total_hours : '') }}" placeholder="Nhập tổng số giờ cần học" class="form-control" name="total_hours"/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                                <x-input-error :messages="$errors->get('total_hours')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6 mb-4">
                            <div class="form-outline">
                                <label class="required fs-6 fw-semibold mb-2" for="test_hours_input">Giờ kiểm tra dự kiến</label>
                                <div data-control="date-with-cleig tpar-button" class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" id="test_hours_input" type="number" min="0" {{ $action === 'edit' && $course->hasFinished() ? 'readonly' : '' }} value="{{ isset($course->test_hours) ? $course->test_hours : (isset($courseCopy->test_hours) ? $courseCopy->test_hours : '') }}" placeholder="Nhập số giờ kiểm tra" class="form-control" name="test_hours"/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                                <x-input-error :messages="$errors->get('test_hours')" class="mt-2"/>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Thời gian bắt đầu học</label>
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" {{ $action === 'edit' && $course->hasFinished() ? 'readonly' : '' }} value="{{ isset($course->start_at) ? \Carbon\Carbon::parse($course->start_at)->format('Y-m-d') : '' }}" name="start_at_" placeholder="=asas" type="date" class="form-control" placeholder=""/>
                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                        </div>
                        <x-input-error :messages="$errors->get('start_at')" class="mt-2"/>
                    </div>
                </div>
                <div form-control="homeroom-form" class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="form-outline">
                        {{-- This hidden field is used to save teachers selected --}}
                        <input type="hidden" data-control="selected-homeroom" value="{{ isset($course->teacher_id) ? $course->teacher_id : '' }}"> 
                        <label class="required fs-6 fw-semibold mb-2" for="course-teacher-select">Giáo viên chủ nhiệm</label>
                        <select id="course-teacher-select" class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" name="teacher_id"
                            data-control="select2" data-placeholder="Chọn giáo viên" data-allow-clear="true">
                            <option value="">Chọn giáo viên chủ nhiệm</option>
                        </select>
                        <x-input-error :messages="$errors->get('teacher_id')" class="mt-2"/>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('time_range_validate')" class="mt-2"/>
            <x-input-error :messages="$errors->get('staff_busy_schedule')" class="mt-2"/>
        </div>  
    </div>  
        
    <div class="row p-0">
        <div class="col-lg-12 col-xl-5 col-md-12 col-sm-12 col-12 pe-6 d-none">
            <div class="fs-2 fw-bold text-secondary mt-5 mb-3">
                Cấu hình thời khóa biểu tuần
            </div>
            <p>
                Sử dụng công cụ bên dưới để cấu hình thời gian học trong 1 tuần và áp dụng cho toàn bộ lịch học.
            </p>
            <div id="weekScheduleTool" class="position-relative z-index-1 border">
                <div class="d-flex">
                    <div class="">
                        <div class="nav nav-pills flex-column aos-init aos-animate bg-light" id="myTab" role="tablist" data-aos="fade-up">
                            <button row-data="day-button" day-name-data="mon" class="nav-link px-4 text-start py-5 text-nowrap position-relative active" id="d1-tab" data-bs-toggle="tab" data-bs-target="#monday" type="button" role="tab" aria-controls="monday" aria-selected="true">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 2</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="mon" style="top: 50%; right: -25%">3</span>
                            </button>
                            
                            <button row-data="day-button" day-name-data="tue" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d2-tab" data-bs-toggle="tab" data-bs-target="#tuesday" type="button" role="tab" aria-controls="tuesday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 3</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="tue" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="wed" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d3-tab" data-bs-toggle="tab" data-bs-target="#wednesday" type="button" role="tab" aria-controls="wednesday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 4</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="wed" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="thu" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d4-tab" data-bs-toggle="tab" data-bs-target="#thursday" type="button" role="tab" aria-controls="thursday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 5</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="thu" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="fri" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d5-tab" data-bs-toggle="tab" data-bs-target="#friday" type="button" role="tab" aria-controls="friday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 6</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="fri" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="sat" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d6-tab" data-bs-toggle="tab" data-bs-target="#saturday" type="button" role="tab" aria-controls="saturday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">Thứ 7</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="sat" style="top: 50%; right: -25%">3</span>
                            </button>

                            <button row-data="day-button" day-name-data="sun" class="nav-link px-4 text-start py-5 text-nowrap position-relative" id="d7-tab" data-bs-toggle="tab" data-bs-target="#sunday" type="button" role="tab" aria-controls="sunday" aria-selected="false" tabindex="-1">
                                <span class="d-block fs-5 fw-bold d-flex justify-content-center">CN</span>
                                <span class="position-absolute translate-middle badge bg-danger text-white rounded-pill fs-7 d-none" data-action="notification-badge" day-name-data="sun" style="top: 50%; right: -25%">3</span>
                            </button>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="">
                            <div class="">
                                <div data-aos="fade-up" id="week-events-data-container" class="tab-content aos-init aos-animate w-100 px-10" id="myTabContent">
                                    <div class="tab-pane fade active show" row-data="day-in-week" day-name-data="mon" id="monday" role="tabpanel" aria-labelledby="d1-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="tue" id="tuesday" role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="wed" id="wednesday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="thu" id="thursday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="fri" id="friday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="sat" id="saturday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                    <div class="tab-pane fade" row-data="day-in-week" day-name-data="sun" id="sunday"  role="tabpanel" aria-labelledby="d2-tab"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-between align-items-center">
                <button id="reset-week-schedule-btn" class="btn btn-light">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2">
                            delete
                        </span>
                        <span>Xóa toàn bộ</span>
                    </span>
                </button>
            
                <button id="apply-week-schedule-btn" class="btn btn-info">
                    <span class="d-flex align-items-center">
                        <span>Áp dụng</span>
                        <span class="material-symbols-rounded ms-2">
                            keyboard_double_arrow_right
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 mb-2 mt-4" form-control="timeAutoCaculatForm">
                <div class="card p-5">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6 border-end">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 col-xl-5 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Giáo viên Việt Nam</label>
                                        </div>
                                        <div class="col-lg-5 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-5 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="vn_teacher_duration" value="0">
                                            <x-input-error :messages="$errors->get('vn_teacher_duration')" class="mt-2"/>
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 col-xl-5 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Giáo viên nước ngoài</label>
                                        </div>
                                        <div class="col-lg-5 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-5 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="foreign_teacher_duration" value="0">
                                            <x-input-error :messages="$errors->get('foreign_teacher_duration')" class="mt-2"/>
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-6">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 col-xl-5 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Gia sư</label>
                                        </div>
                                        <div class="col-lg-5 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-5 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="tutor_duration" value="0">
                                            <x-input-error :messages="$errors->get('tutor_duration')" class="mt-2"/>
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-6 mb-2">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 col-xl-5 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                                            <label class="fs-6" for="target-input">Trợ giảng</label>
                                        </div>
                                        <div class="col-lg-5 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-5 ps-1">
                                            <input type="number" readonly class="form-control"
                                            name="assistant_duration" value="0">
                                            <x-input-error :messages="$errors->get('assistant_duration')" class="mt-2"/>
                                        </div>
                                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                                            <label class="fs-6" for="target-input">Giờ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 d-flex justify-content-center align-items-center">
                        <div form-control="auto-fill-values" class="fs-5 d-none">
                            Tổng&nbsp;<span class="fs-4 fw-semibold" data-control="total_dates">--</span>&nbsp;ngày
                            <span class="fw-bold">|</span>
                            Kết thúc vào ngày:<span class="fs-4 fw-semibold" data-control="end_date">--</span>
                            <input type="hidden" name="end_at" value="" readonly>
                        </div>
    
                        <div form-control="not-existing-autofill-values" class="fs-8 cursor-pointer"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                            title='Cần nhập thời gian bắt đầu, tổng số ngày cần học và có ít nhất một buổi học trong thời khóa biểu để hiện thông tin!'
                        >
                            <div class="form-outline">
                                <span class="d-flex align-items-center">
                                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                                        error
                                    </span>
                                    <span>Nhập đủ thông tin để hiện số ngày và ngày kết thúc!</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        @if ($action === 'edit' && $course->hasFinished())
            <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                <span class="material-symbols-rounded me-4">
                    info
                </span>

                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <p class="mb-0">
                        Lớp học này đã hoàn thành, không thể thực hiện các thao tác chỉnh sửa!
                    </p>
                </div>
                <!--end::Content-->
            </div>
        @endif

        {{-- The calendar in the right side, next to the week config tool, include 2 tabs: calendar tab and sections week schedule tab --}}
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12">
            {{-- Tabs menu --}}
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="fs-4 fw-semibold nav-link active" id="calendar-tab" data-bs-toggle="tab" href="#add-course-calendar-container" role="tab" aria-controls="add-course-calendar-container" aria-selected="true">Lịch</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="fs-4 fw-semibold nav-link" id="list-sections" data-bs-toggle="tab" href="#list-sections-tab" role="tab" aria-controls="list-sections-tab" aria-selected="false">Danh sách</a>
                </li>
            </ul>

            {{-- Tabs content --}}
            <div class="tab-content pt-5" id="tab-content">
                <div class="tab-pane content home active" id="add-course-calendar-container" role="tabpanel" aria-labelledby="calendar-tab">
                    {{-- LOAD CALENDAR HERE --}}
                </div>

                <div class="tab-pane" id="list-sections-tab" role="tabpanel" aria-labelledby="list-sections">
                    {{-- LOAD SECTIONS LIST HERE --}}
                </div>
            </div>
        </div>
        <hr class="my-10">
        <div class="form-outline d-flex justify-content-center">
            <div class="mb-10">
                <button id="doneAddCourseBtn" class="btn btn-primary me-1">Hoàn tất</button>
                <a href="{{ action('App\Http\Controllers\Abroad\CourseController@index') }}" id="cancelAddCourseBtn"
                    class="btn btn-light">Hủy</a>
            </div>
        </div>
<script>
    var trainingLocationHandle;
    var weekScheduleTool; // Cấu hình thời khóa biểu mỗi tuần
    var classTypeManage; // Chọn loại hình lớp -> online, offline
    var addCourseManager; // Quản lý chính của cả màn hình tạo lớp
    var calendar; // Quản lý TAB 1: tờ lịch
    var sectionsList; // Quản lý TAB 2: danh sách sections
    var subjectsManager; // Quản lý show các môn học tương ứng
    var addSchedulePopup;
    var addEventInCalendarPopup;
    var editEventInCalendarPopup;
    var timeAutoCaculatForm; // 
    var holiday; // Lịch nghỉ, ngày lễ

    $(() => {
        let weekEventsDataFromServer = undefined;
        let savedValues = undefined;
        let sectionsDataFromServer = undefined;
        let holidaysData = undefined;

        @if (isset($course))
            weekEventsDataFromServer = {!! collect(json_decode($course->week_schedules))->map(function($section) {
                        return [
                            'name' => $section->name,
                            'schedules' => collect($section->schedules)->map(function($event) {
                                return [
                                    'id' => $event->id,
                                    'end_at' => $event->end_at,
                                    'start_at' => $event->start_at,
                                    'code' => isset($event->code) ? $event->code : "abcd1234",
                                    
                                    'is_vn_teacher_check' => $event->is_vn_teacher_check,
                                    'vn_teacher_id' => $event->vn_teacher_id,
                                    'vn_teacher_from' => $event->vn_teacher_from,
                                    'vn_teacher_to' => $event->vn_teacher_to,

                                    'is_foreign_teacher_check' => $event->is_foreign_teacher_check,
                                    'foreign_teacher_id' => $event->foreign_teacher_id,
                                    'foreign_teacher_from' => $event->foreign_teacher_from,
                                    'foreign_teacher_to' => $event->foreign_teacher_to,

                                    'is_tutor_check' => $event->is_tutor_check,
                                    'tutor_id' => $event->tutor_id,
                                    'tutor_from' => $event->tutor_from,
                                    'tutor_to' => $event->tutor_to,

                                    'is_assistant_check' => $event->is_assistant_check,
                                    'assistant_id' => $event->assistant_id,
                                    'assistant_from' => $event->assistant_from,
                                    'assistant_to' => $event->assistant_to,
                                    'code' => $event->code,
                                ];
                            })
                        ];
                    }) !!};
        @endif

        @if (isset($sections))
            sectionsDataFromServer = {!! $sections !!};
        @endif

        addCourseManager = new AddCourseManager({
            container: document.querySelector('#addCourseContainer')
        });

        classTypeManage = new ClassTypeManage({
            container: addCourseManager.getContainer()
        })

        subjectsManager = new SubjectsManager({
            container: addCourseManager.getContainer()
        });

        /**
         * TAB 1: Calendar
         */
        calendar = new Calendar({
            container: document.querySelector('#add-course-calendar-container'),
            events: sectionsDataFromServer
        });

        /**
         * TAB 2: Sections list
         */
        sectionsList = new SectionsList({
            container: $('#list-sections-tab')
         })

        trainingLocationHandle = new TrainingLocationHandle();

        weekScheduleTool = new WeekScheduleTool({
            container: document.querySelector('#weekScheduleTool'),
            calendar: calendar,
            weekEventsData: weekEventsDataFromServer
        });

        holiday = new Holiday({
            data: {!! json_encode(config('holidays')) !!},
            calendar: calendar
        });

        timeAutoCaculatForm = new TimeAutoCaculatForm({
            container: addCourseManager.getContainer().querySelector('[form-control="timeAutoCaculatForm"]')
        });

        addSchedulePopup = new AddSchedulePopup();
        suggestTeacherPopup = new SuggestTeacherPopup();

        addCourseManager.loadSavedValues();
    });

    /**
     * Quản lý form cấu hình thời khóa biểu từng tuần
     */
    var WeekScheduleTool = class {
        addSchedulePopup = new Popup();
        startDate = null;
        endDate = null;
        totalDays = null;

        constructor(options) {
            this.container = options.container;
            this.calendar = calendar;
            this.savedWeekEventsData;

            if (typeof (options.weekEventsData) == 'undefined') {
                this.weekEventsData = [];
            } else {
                this.weekEventsData = options.weekEventsData;
            };

            this.init();
            this.setSavedWeekEventsData(options.weekEventsData);
        };

        setSavedWeekEventsData(savedWeekEventsData) {
            if (savedWeekEventsData) {
                const tmp = JSON.stringify(savedWeekEventsData);
    
                this.savedWeekEventsData = JSON.parse(tmp);
            } else {
                this.savedWeekEventsData = [];
            }
        };
        
        getSavedWeekEventsData() {
            return this.savedWeekEventsData;
        };

        getWeekEventsData() {
            return this.weekEventsData;
        };

        getDayOfWeek(stringDate) {
            const daysOfWeek = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            const date = new Date(stringDate);
            const dayIndex = date.getDay();

            return daysOfWeek[dayIndex];
        };

        setWeekEventsData(newWeekEventsData) {
            this.weekEventsData = newWeekEventsData;
        };

        getApplyBtn() {
            return addCourseManager.getContainer().querySelector('#apply-week-schedule-btn');
        };

        getResetBtn() {
            return addCourseManager.getContainer().querySelector('#reset-week-schedule-btn');
        };

        getWeekEventsDataContainer() {
            return this.container.querySelector('#week-events-data-container');
        };

        getDayInWeekElements() {
            return this.getWeekEventsDataContainer().querySelectorAll('[row-data="day-in-week"]');
        };

        getDayButtonElements() {
            return this.container.querySelectorAll('[row-data="day-button"]');
        };

        getSchedulePerDayInHtml(eventSchedules, dayName) {
            let content = `<ul class="list-unstyled mb-0">`
                        
            eventSchedules.forEach(schedule => {
                // Convert String -> Date()
                const startTimeParts = schedule.start_at.split(':');
                const endTimeParts = schedule.end_at.split(':');
                const startTime = new Date();
                const endTime = new Date();

                startTime.setHours(parseInt(startTimeParts[0], 10), parseInt(startTimeParts[1], 10), 0);
                endTime.setHours(parseInt(endTimeParts[0], 10), parseInt(endTimeParts[1], 10), 0);

                // Caculate hours (In decimal)
                const elapsedHours = ((endTime - startTime) / (1000 * 60 * 60)).toFixed(2); // Devide ms

                content += 
                `
                    <li class="d-flex flex-column flex-md-row py-4 justify-content-center align-items-center">
                        <div class="align-self-center">
                            <div class="flex-grow-1 ps-4">
                                <h4><span>${schedule.start_at} - ${schedule.end_at}</span></h4>
                                <div class="mb-0 text-wrap">
                                    ${elapsedHours} giờ
                                </div>
                            </div>
                        </div>
                        <span list-action="schedule-item-more-vert" class="material-symbols-rounded ps-10 d-flex align-items-center cursor-pointer" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            more_vert
                        </span>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a data-dayname-control="${dayName}" data-id-control="${schedule.id}" href="javascript:;" row-action="delete" class="menu-link px-3">Xóa</a>
                        </div>
                        <div class="menu-item px-3">
                            <a data-dayname-control="${dayName}" data-id-control="${schedule.id}" href="javascript:;" row-action="edit" class="menu-link px-3">Chỉnh sửa</a>
                        </div>
                    </li>
                `
            });
            
            content += `</ul>`;

            content += 
            `
                <div class="row w-100 mt-10 d-flex justify-content-center">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 fs-5 w-100 d-flex justify-content-center">
                        <div day-data="${dayName}" list-action="course-add-schedule" class="btn btn-light btn-sm">
                            <span class="material-symbols-rounded">
                                add
                                </span>
                            &nbsp;&nbsp;Thêm lịch
                        </div>
                    </div>
                </div>
            `

            return content;
        };

        getNotExistContentInHtml(dayName) {
            const content = 
            `
                <div class="mt-10" data-control="not-exist-schedule">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <p class="fs-3 d-flex justify-content-center align-items-center">
                                <span class="text-danger me-2">
                                    <span class="material-symbols-rounded me-1 fs-2" style="vertical-align: middle;">
                                        error
                                    </span>
                                </span>
                                <span>Chưa có lịch học trong ngày này</span>
                            </p>
                            <span class="d-flex">
                                <span>Bạn có thể thêm lịch học bằng cách nhấn nút thêm lịch bên dưới!</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mt-10 d-flex justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 fs-5 w-100 d-flex justify-content-center">
                        <div day-data="${dayName}" list-action="course-add-schedule" class="btn btn-light btn-sm d-flex align-items-center justify-content-center">
                            <span class="material-symbols-rounded">
                                add
                                </span>
                            &nbsp;&nbsp;Thêm lịch
                        </div>
                    </div>
                </div>
            `
            return content;
        };

        getAddScheduleButtons() {
            return this.container.querySelectorAll('[list-action="course-add-schedule"]');
        };

        getDeleteScheduleBtns() {
            return this.container.querySelectorAll('[row-action="delete"]');
        };

        getEditScheduleBtns() {
            return this.container.querySelectorAll('[row-action="edit"]');
        };

        getNotificationBadge() {
            return this.container.querySelectorAll('[data-action="notification-badge"]');
        };

        getDaysHaveEventsData() {
            const weekSchedules = this.getWeekEventsData();
            const daysHaveEvents = [];

            for (let schedule of weekSchedules) {
                if (daysHaveEvents.length === 7) {
                    break;
                };

                const numEvents = schedule.schedules.length;

                if (numEvents > 0) {
                    const dayData = {
                        name: schedule.name,
                        numEvents: numEvents
                    };

                    daysHaveEvents.push(dayData);
                };
            };

            return daysHaveEvents;
        };

        loadNotificationBadge() {
            const notificationBadges = Array.from(this.getNotificationBadge());
            const daysHaveEvents = this.getDaysHaveEventsData();

            if (daysHaveEvents.length === 0) {
                notificationBadges.forEach(badge => {
                    badge.classList.add('d-none');
                });

                return;
            };

            daysHaveEvents.forEach(dayData => {
                const matchingBadge = notificationBadges.find(badge => dayData.name === badge.getAttribute('day-name-data'));

                if (matchingBadge) {
                    matchingBadge.innerHTML = dayData.numEvents;
                    matchingBadge.classList.remove('d-none');
                };
            });

            notificationBadges.forEach(badge => {
                const badgeDayName = badge.getAttribute('day-name-data');
                const isDayWithoutEvent = !daysHaveEvents.some(dayData => dayData.name === badgeDayName);

                if (isDayWithoutEvent) {
                    badge.classList.add('d-none');
                };
            });
        };

        init() {
            this.render();
            this.events();
        };

        /**
         * @return void
         */
        render() {
            const weekEvents = this.getWeekEventsData();
            const dayInWeekElements = this.getDayInWeekElements();
            const dayButtonElements = this.getDayButtonElements();
            const elementsByDayName = {};
            const elementButtonsByDayName = {};

            // Performing operations related to the necessary constraint conditions 
            addCourseManager.manageConditionConstraintForEventCreation(weekEvents, calendar.dateData.events);

            dayInWeekElements.forEach(day => {
                const dayName = day.getAttribute('day-name-data');
                elementsByDayName[dayName] = day;
            });

            dayButtonElements.forEach(button => {
                const dayName = button.getAttribute('day-name-data');
                elementButtonsByDayName[dayName] = button;
            });

            weekEvents.forEach(event => {
                const dayName = event.name;
                const eventSchedules = event.schedules;
                const matchingElement = elementsByDayName[dayName];
                const matchingButton = elementButtonsByDayName[dayName];

                if (matchingElement) {
                    matchingElement.innerHTML = this.getSchedulePerDayInHtml(eventSchedules, dayName);
                };
            });

            const unMatchingName = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'].filter(dayName => !weekEvents.some(event => event.name === dayName));

            dayInWeekElements.forEach(day => {
                const dayName = day.getAttribute('day-name-data');

                if (unMatchingName.includes(dayName)) {
                    day.innerHTML = this.getNotExistContentInHtml(dayName);
                };
            });

            this.loadNotificationBadge();
            this.eventsAfterRender();
        };

        getDayIndex(dayName) {
            const days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            return days.indexOf(dayName);
        };

        getStartDate() {
            return this.startDate;
        };

        setStartDate(newStartDate) {
            this.startDate = newStartDate;
        };

        getEndDate() {
            return this.endDate;
        };

        setEndDate(newEndDate) {
            this.endDate = newEndDate;
        };

        alertError(message) {
            ASTool.addPageLoadingEffect();

            ASTool.alert({
                icon: 'warning',
                message: message
            });

            ASTool.removePageLoadingEffect();
        };

        /**
         * @param weekSchedule The week schedule data
         * @param startTime The start time of the range
         * @param endTime The end time of the range
         * @returns The total hours within the time range
         */
         caculateTotalHoursWithinRangeTime(weekSchedule, startTime, endTime) {
            const startDate = new Date(startTime);
            const endDate = new Date(endTime);
            let totalMinutes = 0;
            let dayName = timeAutoCaculatForm.getDayOfWeek(startDate);
            const daysOfWeek = addCourseManager.getDaysOfWeek();

            // Iterate through each day within the time range.
            for (var currentDate = startDate; currentDate <= endDate; currentDate.setDate(currentDate.getDate() + 1)) {
                const dayOfWeek = currentDate.getDay();
                const dayOfWeekString = daysOfWeek[dayOfWeek];

                // Check if there are events scheduled on the current day.
                for (const day of weekSchedule) {
                    if (day.name === dayOfWeekString) {
                        // Calculate the duration of each event and add it to the total minutes.
                        day.schedules.forEach(event => {
                            const start = timeAutoCaculatForm.convertToMinutes(event.start_at);
                            const end = timeAutoCaculatForm.convertToMinutes(event.end_at);
                            const duration = end - start;
                            totalMinutes += duration;
                        });
                    }
                }
            }

            // Convert the total minutes to hours and return.
            return totalMinutes / 60;
        };

        convert(weekScheduleData, startTime, endTime) {
            const _this = this;
            const events = [];
            const startDate = new Date(startTime);
            const endDate = new Date(endTime);
            const caculateToTalMinutesInRange = function (start_at, end_at) {
                const [startHours , startMinutes] = start_at.split(':').map(Number);
                const [endHours , endMinutes] = end_at.split(':').map(Number);
                const totalStartMinutes = startHours * 60 + startMinutes;
                const totalEndMinutes = endHours * 60 + endMinutes;
                const totalMinutes = totalEndMinutes - totalStartMinutes;
                return totalMinutes;
            }
            const teachHours = addCourseManager.getTotalHoursInputValue() ? parseFloat(addCourseManager.getTotalHoursInputValue()) : 0;
            const testHours = addCourseManager.getTestHoursInputValue() ? parseFloat(addCourseManager.getTestHoursInputValue()) : 0;
            let totalMinutesRemain = (teachHours + testHours) * 60;

            while (startDate <= endDate) {
                const dayOfWeek = startDate.toLocaleDateString('en-US', {weekday: 'long'}).slice(0, 3).toLowerCase();
                const dateNameString = startDate.toISOString().split('T')[0];

                for (const day of weekScheduleData) {
                    const dayNameHash = day.name;
                    if (day.name === dayOfWeek) {
                        day.schedules.forEach(schedule => {
                            const totalMinutes = caculateToTalMinutesInRange(schedule.start_at, schedule.end_at);
                            
                            if (totalMinutesRemain > 0) {
                                const studyDate = dateNameString;
                                const startAt = studyDate + ' ' + schedule.start_at;
                                const endAt = studyDate + ' ' + schedule.end_at;
    
                                events.push({
                                    study_date: studyDate,
                                    start_at: startAt,
                                    end_at: endAt,
                                    code: schedule.code,
                                    type: schedule.type,
                                    is_vn_teacher_check: schedule.is_vn_teacher_check,
                                    vn_teacher_id: !isNaN(parseInt(schedule.vn_teacher_id)) ? schedule.vn_teacher_id : null,
                                    vn_teacher_from: schedule.vn_teacher_from,
                                    vn_teacher_to: schedule.vn_teacher_to,
                                    is_foreign_teacher_check: schedule.is_foreign_teacher_check,
                                    foreign_teacher_id: !isNaN(parseInt(schedule.foreign_teacher_id)) ? schedule.foreign_teacher_id : null,
                                    foreign_teacher_from: schedule.foreign_teacher_from,
                                    foreign_teacher_to: schedule.foreign_teacher_to,
                                    is_tutor_check: schedule.is_tutor_check,
                                    tutor_id: !isNaN(parseInt(schedule.tutor_id)) ? schedule.tutor_id : null,
                                    tutor_from: schedule.tutor_from,
                                    tutor_to: schedule.tutor_to,
                                    is_assistant_check: schedule.is_assistant_check,
                                    assistant_id: !isNaN(parseInt(schedule.assistant_id)) ? schedule.assistant_id : null,
                                    assistant_from: schedule.assistant_from,
                                    assistant_to: schedule.assistant_to,
                                });

                                totalMinutesRemain -= totalMinutes;
                            }
                        });
                    }
                }

                startDate.setDate(startDate.getDate() + 1); // day++
            };

            return events;
        }

        /**
         * Convert all schedule config to array of event instance
         * @return events
         */
        convertSchedulesToEvents() {
            const weekSchedule = this.getWeekEventsData();
            const startDate = new Date(addCourseManager.getStartDateInputValue());
            const endDate = new Date(timeAutoCaculatForm.getEndDate());
            const events = this.convert(weekSchedule, startDate, endDate);

            return events;
        };

        /**
         * Validate the end date must be greater than now
         * @return Boolean
         */
        validateTimeRange() {
            let isValid = true;
            const now = new Date(Date.now());
            const endDate = new Date(timeAutoCaculatForm.getEndDate());

            now.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            if (endDate && (now > endDate)) {
                isValid = false;
            }

            return isValid;
        }

        /**
         * Validate test hours
         * @return Boolean
         */
        validateTestHours() {
            const hours = addCourseManager.getTestHoursInputValue();
            
            // Just validate when user had fill test hours
            // Temporary not validate
            if (hours > 0) {
                // ...
            }

            return true;
        }

        /**
         * Apply all week daily config to calendar
         * @return void
         */
        applyToCalendar() {
            const currWeekScheduleEvents = this.convertSchedulesToEvents();

            // Áp dụng events mới vào data của lịch, lịch sẽ tự động cập nhật lại UI với events mới
            calendar.updateEvents(currWeekScheduleEvents);
            timeAutoCaculatForm.run();
        };

        setChedules(newSchedules) {
            this.setWeekEventsData(newSchedules);
        };

        getCurrEventItemData(id) {
            const weekEvents = this.getWeekEventsData();
            let currEventItem;
            let founded = false;
            
            for (const eventDay of weekEvents) {
                if (eventDay.schedules.length > 0 && founded === false) {
                    for (event of eventDay.schedules) {
                        if (event.id === id) {
                            currEventItem = event;
                            founded = true;
                            break;
                        };
                    };
                };
            };

            return currEventItem;
        };

        deleteScheduleItem(dayName, id) {
            const weekEvents = this.getWeekEventsData();

            weekEvents.forEach(event => {
                if (event.name === dayName) {
                    const index = event.schedules.findIndex(item => item.id === id);

                    if (index > -1) {
                        event.schedules.splice(index, 1);
                    };
                };
            });

            weekEvents.forEach(event => {
                if (event.schedules.length === 0) {
                    const index = weekEvents.findIndex(item => item.name === event.name);

                    if (index > -1) {
                        weekEvents.splice(index, 1);
                    };
                };
            });

            this.render();
            this.loadNotificationBadge();
        };

        filterAddLaterEvents() {
            const currWeekEvents = this.convertSchedulesToEvents();
            const currCalendarEvents = calendar.getDateData().events;

            const fiteredEvents = currCalendarEvents.filter(calendarEvent => {
                return !currWeekEvents.some(weekEvent => calendarEvent.code === weekEvent.code);
            });

            return fiteredEvents;
        };

        resetWeekScheduleEventsFromCalendar() {
            calendar.updateAllEvents(this.filterAddLaterEvents());
        };

        reset() {
            this.setStartDate('2023-01-01');
            this.setEndDate('2023-01-02');
            this.resetWeekScheduleEventsFromCalendar();
            this.setChedules([]);
            this.render();
            this.loadNotificationBadge();
            timeAutoCaculatForm.run();
            addCourseManager.manageConditionConstraintForEventCreation(this.getWeekEventsData(), calendar.dateData.events);
        };

        eventsAfterRender() {
            const _this = this;

            _this.getAddScheduleButtons().forEach(button => {
                $(button).on('click', e => {
                    e.preventDefault();

                    // const subjectId = subjectsManager.getSubjectSelect().value;

                    // if (!subjectId) {
                    //     ASTool.alert({
                    //         message: "Vui lòng chọn môn học!",
                    //         icon: 'warning' 
                    //     })

                    //     return;
                    // }

                    // Nếu chọn phương thức học online thì cho phép tất cả giáo viên
                    // Nếu chọn phương thức học offline thì bắt buộc phải có chọn branch
                    // => Show staffs by branch
                    const studyMethod = addCourseManager.getStudyMethodSelectValue();
                    const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
                    const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";
                    let area = 'all';

                    // if (studyMethod === "" || !studyMethod) {
                    //     ASTool.alert({
                    //         message: "Vui lòng chọn hình thức học!",
                    //         icon: 'warning' 
                    //     })

                    //     return;
                    // } else if (studyMethod === offlineMethod) {
                    //     const branch = trainingLocationHandle.getBranch();

                    //     if (typeof branch == 'undefined' || !branch) {
                    //         // Not select any branch
                    //         ASTool.alert({
                    //             message: "Vui lòng chọn chi nhánh!",
                    //             icon: 'warning'
                    //         })

                    //         // Stop
                    //         return;
                    //     }

                    //     // Must select branch
                    //     switch(branch) {
                    //         case 'HN':
                    //             area = 'HN';
                    //             break;
                    //         case 'SG':
                    //             area = 'SG';
                    //             break;
                    //         default:
                    //             area = 'all';
                    //             break;
                    //     }
                    // }

                    const dayName = button.getAttribute('day-data');
                    const url = "{!! action('App\Http\Controllers\Abroad\CourseController@addSchedule') !!}";
                    
                    addSchedulePopup.getPopup().method = 'get';

                    addSchedulePopup.setData({
                        day_name: dayName,
                        // subject_id: subjectId,
                        // area: area
                    });

                    addSchedulePopup.updateUrl(url);
                });
            });

            _this.getDeleteScheduleBtns().forEach(button => {
                $(button).on('click', e => {
                    e.preventDefault();

                    ASTool.confirm({
                        message: "Bạn có chắc xóa buổi học này không?",
                        ok: function() {
                            ASTool.addPageLoadingEffect();

                            const dayName = button.getAttribute('data-dayname-control');
                            const id = button.getAttribute('data-id-control');

                            _this.deleteScheduleItem(dayName, id);
                            
                            ASTool.alert({
                                message: "Xóa lịch thành công!",
                            });

                            ASTool.removePageLoadingEffect();
                        }
                    });
                });
            });

            _this.getEditScheduleBtns().forEach(button => {
                $(button).on('click', e => {
                    e.preventDefault();
                    // const subjectId = subjectsManager.getSubjectSelect().value;

                    // if (!subjectId) {
                    //     ASTool.alert({
                    //         message: "Vui lòng chọn môn học!",
                    //         icon: 'warning' 
                    //     })

                    //     return;
                    // }

                    // Nếu chọn phương thức học online thì cho phép tất cả giáo viên
                    // Nếu chọn phương thức học offline thì bắt buộc phải có chọn branch
                    // => Show staffs by branch
                    const studyMethod = addCourseManager.getStudyMethodSelectValue();
                    const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
                    const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";
                    let area = 'all';

                    // if (studyMethod === "" || !studyMethod) {
                    //     ASTool.alert({
                    //         message: "Vui lòng chọn hình thức học!",
                    //         icon: 'warning' 
                    //     })

                    //     return;
                    // } else if (studyMethod === offlineMethod) {
                    //     const branch = trainingLocationHandle.getBranch();

                    //     if (typeof branch == 'undefined' || !branch) {
                    //         // Not select any branch
                    //         ASTool.alert({
                    //             message: "Vui lòng chọn chi nhánh!",
                    //             icon: 'warning'
                    //         })

                    //         // Stop
                    //         return;
                    //     }

                    //     // Must select branch
                    //     switch(branch) {
                    //         case 'HN':
                    //             area = 'HN';
                    //             break;
                    //         case 'SG':
                    //             area = 'SG';
                    //             break;
                    //         default:
                    //             area = 'all';
                    //             break;
                    //     }
                    // }
                    
                    const url = "{{ action('App\Http\Controllers\Abroad\CourseController@editSchedule') }}";
                    const id = button.getAttribute('data-id-control');
                    const currItem = this.getCurrEventItemData(id);

                    currItem.dayName = button.getAttribute('data-dayname-control');
                    // currItem.subject_id = subjectId;
                    currItem.area = area;

                    addSchedulePopup.getPopup().method = 'get';
                    addSchedulePopup.setData(currItem);
                    addSchedulePopup.updateUrl(url);
                });
            });

            if ($(addCourseManager.getContainer())[0]) {
                subjectsManager.setAllowLoadTypes(false);
                initJs($(addCourseManager.getContainer())[0]);
                subjectsManager.setAllowLoadTypes(true);
            };
        };

        findApplyError() {
            let errorText = null;

            const startDate = addCourseManager.getStartDateInputValue();
            const totalHours = addCourseManager.getTotalHoursInputValue();
            const weekSchedules = this.getWeekEventsData();

            // Must have week daily config
            if (weekSchedules.length <= 0) {
                if (!errorText) {
                    errorText = 'Vui lòng cấu hình thời khóa biểu tuần!';
                }
            }

            // Must have start date 
            if (!startDate) {
                if (!errorText) {
                    errorText = 'Vui lòng nhập thời gian bắt đầu học!';
                }
            }

            // Must have total hours
            if (!totalHours) {
                if (!errorText) {
                    errorText = 'Vui lòng nhập giờ học dự kiến!';
                }
            }

            // The total hours must be greater than 0
            if (parseFloat(totalHours) <= 0) {
                if (!errorText) {
                    errorText = 'Tổng giờ học phải lớn hơn 0!';
                }
            }
            
            // if (!this.validateTimeRange()) {
            //     if (!errorText) {
            //         errorText = 'Lớp học này đã hoàn thành, không thể chỉnh sửa thời khóa biểu!';
            //     }
            // } 
            
            if (!this.validateTestHours()) {
                if (!errorText) {
                    errorText = 'Cấu hình giờ kiểm tra chưa hợp lệ!';
                }
            }

            return errorText;
        }

        events() {
            const _this = this;

            $(_this.getApplyBtn()).on('click', e => {
                e.preventDefault();

                const error = _this.findApplyError();

                if (error) {
                    _this.alertError(error);
                    return;
                }

                ASTool.addPageLoadingEffect();

                _this.applyToCalendar();

                ASTool.alert({
                    message: "Áp dụng thời khóa biểu thành công!",
                });

                ASTool.removePageLoadingEffect();
            });

            $(_this.getResetBtn()).on('click', e => {
                e.preventDefault();

                ASTool.confirm({
                    message: "Bạn có chắc muốn reset lại toàn bộ thời khóa biểu không?",
                    ok: function() {
                        ASTool.addPageLoadingEffect();
                        
                        _this.reset();

                        ASTool.alert({
                            message: "Reset thời khóa biểu thành công!",
                        });

                        ASTool.removePageLoadingEffect();
                    }
                });
            });

            if ($(addCourseManager.getContainer())[0]) {
                initJs($(addCourseManager.getContainer())[0]);
            };
        };

        getSaveScheduleItemDataBtn() {
            return document.querySelector('[data-action="add-schedule-btn"]');
        };

        getClosePopupBtns() {
            return document.querySelectorAll('[data-action="close-add-course-week-event-popup"]');
        };

        addEventToWeekEventsData(newEvent) {
            const existingEvent = this.getWeekEventsData().find(event => event.name === newEvent.name);

            /**
             * If there is already a schedule for that day in the weekly timetable, add the schedule to that day; 
             * Otherwise, create a new day and add the schedule to it
             */ 
            if (existingEvent) {
                existingEvent.schedules = existingEvent.schedules.concat(newEvent.schedules);
            } else {
                this.getWeekEventsData().push(newEvent);
            };
        };

        generateUniqueId() {
            const timestamp = Date.now().toString(36);
            const randomString = Math.random().toString(36).substr(2, 5);

            return timestamp + randomString;
        };

        createNewWeekEvent(data) {
            const scheduleItemGetted = {
                id: this.generateUniqueId(), // Use this value to define the event in case delete or update week schedule item
                start_at: data.start_at,
                end_at: data.end_at,
                color: data.color,
                type: data.type,

                is_vn_teacher_check: data.is_vn_teacher_check,
                vn_teacher_id: data.vn_teacher_id,
                vn_teacher_from: data.vn_teacher_from,
                vn_teacher_to: data.vn_teacher_to,

                is_foreign_teacher_check: data.is_foreign_teacher_check,
                foreign_teacher_id: data.foreign_teacher_id,
                foreign_teacher_from: data.foreign_teacher_from,
                foreign_teacher_to: data.foreign_teacher_to,

                is_tutor_check: data.is_tutor_check,
                tutor_id: data.tutor_id,
                tutor_from: data.tutor_from,
                tutor_to: data.tutor_to,

                is_assistant_check: data.is_assistant_check,
                assistant_id: data.assistant_id,
                assistant_from: data.assistant_from,
                assistant_to: data.assistant_to,
                code: data.code,
            };

            const weekEventGetted = {
                name: data.day_name,
                schedules: []
            };

            weekEventGetted.schedules.push(scheduleItemGetted);

            return weekEventGetted;
        };

        getTotalDays() {
            return this.totalDays;
        };

        /**
         * Check if the study time of the given schedule item overlaps with the target time range.
         * @param schedule Given schedule item
         * @param targetStartTime Start time target
         * @param targetEndTime End time target
         * @return Boolean
         */
        isTimeOverlap(schedule, targetStartTime, targetEndTime) {
            const startTime = parseInt(schedule.start_at.split(':')[0] * 60 + parseInt(schedule.start_at.split(':')[1]));
            const endTime = parseInt(schedule.end_at.split(':')[0] * 60 + parseInt(schedule.end_at.split(':')[1]));

            const targetStart = parseInt(targetStartTime.split(':')[0] * 60 + parseInt(targetStartTime.split(':')[1]));
            const targetEnd = parseInt(targetEndTime.split(':')[0] * 60 + parseInt(targetEndTime.split(':')[1]));

            return (startTime < targetEnd && endTime > targetStart);
        };

        /**
         * Check if there is a time conflict with any existing class schedules
         * @param data New week schedule item
         * @return Boolean
         */ 
        validateTimeConflict(data) {
            const _this = this;
            const currWeekSchedule = this.getWeekEventsData();

            let isOverLap = false;

            // Check for duplicates for each item in current week schedule.
            currWeekSchedule.forEach(scheduleItem => {
                const dayName = scheduleItem.name.toLowerCase();

                if (dayName === data.day_name) {
                    scheduleItem.schedules.forEach(event => {
                        if (_this.isTimeOverlap(data, event.start_at, event.end_at)) {
                            isOverLap = true;
                            return; // End the loop when a duplicate is found.
                        }
                    });
                };

                if (isOverLap) {
                    return; // End the loop when a duplicate is found.
                };
            });

            return isOverLap;
        };

        saveNewWeekEvent(data) {
            this.addEventToWeekEventsData(this.createNewWeekEvent(data));
            this.render();
        };

        updateEvent(event) {
            this.deleteScheduleItem(event.day_name, event.id);
            this.saveNewWeekEvent(event);
        };
    };

    /**
     * TAB 1: Quản lý tab 1 -> Các sections ở nằm trên dạng tờ lịch
     * Dữ liệu sections ở đây cũng sẽ được truyền qua cho TAB 2 (Class SectionsList)
     * để render ra dữ liệu danh sách các sections đúng với dữ liệu hiện ở lịch
     * Khi class này chạy hàm render thì cũng sẽ gọi tới hàm render của class SectionsList
     * để đồng thời cập nhật dữ liệu ở cả 2 TAB
     */
    var Calendar = class {
        constructor(options) {
            this.container = options.container;
            this.currentDate = this.createCurrentDate();
            this.savedEventsData;

            this.dateData = {
                date: this.currentDate,
                events: []
            };

            if (typeof (options.events) == 'undefined') {
                this.dateData.events = [];
            } else {
                this.dateData.events = options.events;
            };

            this.init();
            this.setSavedEventsData(options.events);
        };

        setSavedEventsData(savedEventsData) {
            if (savedEventsData) {
                const tmp = JSON.stringify(savedEventsData);
    
                this.savedEventsData = JSON.parse(tmp);
            } else {
                this.savedEventsData = [];
            }
        };

        getSavedEventsData() {
            return this.savedEventsData;
        };

        getDateData() {
            return this.dateData;
        };

        removeAllEvents() {
            this.getDateData().events = [];
            this.render();

            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

        updateAllEvents(events) {
            this.getDateData().events = events;
            this.render();

            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

        /**
         * Filter out events added directly to the calendar and retain.
         * Additionally add new events from the schedules
         * @param events
         * @return void
         */
        updateEvents(newEvents) {
            const currCalendarEvents = this.getDateData().events;
            const eventNeedRemoveIndexs = []; // The array of event indexs add in calendar need remove

            for (let i = 0; i < currCalendarEvents.length; ++i) {
                let currEvent = currCalendarEvents[i].is_add_later;

                if (!currEvent || currEvent=== "" || currEvent === null || currEvent == "0") {
                    eventNeedRemoveIndexs.push(i);
                };
            };

            // Remove old week schedule items in currCalendarEvents (ignore events add in calendar).
            const filteredCalendarEvents = currCalendarEvents.filter((event, index) => !eventNeedRemoveIndexs.includes(index));

            // Merge current filtered array & new array.
            const newEventsFiltered = filteredCalendarEvents.concat(newEvents);

            this.getDateData().events = newEventsFiltered;
            this.render();

            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

        /**
         * CLick delete icon on the section label in calendar
         * @param code code of section use to references to week schedule
         * @param date date date of section in calendar
         * @return void
         */
        deleteEventInCalendar(code, date) {
            if (!date.split(' ')[1]) {
                date += ' 00:00:00'
            };
            
            const existingEvents = this.getDateData().events;

            const updatedEvents = existingEvents.filter(event => {
                let eventDate = event.study_date;

                if (!eventDate.split(' ')[1]) {
                    eventDate += ' 00:00:00'
                };

                return !(event.code === code && eventDate === date);
            });

            this.getDateData().events = updatedEvents;
            this.render();

            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

        getContainer() {
            return this.container;
        };

        getEvents() {
            return this.dateData.events;
        };

        getPrevMonthBtn() {
            return this.container.querySelector('[data-control="prev-btn"]');
        };

        getTodayBtn() {
            return this.container.querySelector('[data-control="today-btn"]');
        };

        getNextMonthBtn() {
            return this.container.querySelector('[data-control="next-btn"]');
        };

        createCurrentDate() {
            const currentDateObject = new Date();
            const year = currentDateObject.getFullYear();
            const month = String(currentDateObject.getMonth() + 1).padStart(2, '0');
            const day = String(currentDateObject.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        getCurrentDate() {
            return this.currentDate;
        };

        prevMonth() {
            this.currentDate = this.getPrevMonthByDate(this.currentDate);
            this.dateData.date = this.currentDate;
            this.render();
        };

        today() {
            this.currentDate = this.getToday();
            this.dateData.date = this.currentDate;
            this.render();
        };

        nextMonth() {
            this.currentDate = this.getNextMonthByDate(this.currentDate);
            this.dateData.date = this.currentDate;
            this.render();
        };

        getPrevMonthByDate(dateString) {
            const date = new Date(dateString);
            date.setMonth(date.getMonth() - 1);
            return date.toISOString().slice(0, 10);
        };

        getToday() {
            const date = new Date(this.createCurrentDate());
            return date.toISOString().slice(0, 10);
        };

        getNextMonthByDate(dateString) {
            const date = new Date(dateString);
            date.setMonth(date.getMonth() + 1);
            return date.toISOString().slice(0, 10);
        };

        init() {
            this.render();
            this.events();

            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

        events() {
            $(this.getPrevMonthBtn()).on('click', e => {
                e.preventDefault();

                this.prevMonth();
            });

            $(this.getTodayBtn()).on('click', e => {
                e.preventDefault();

                this.today();
            });

            $(this.getNextMonthBtn()).on('click', e => {
                e.preventDefault();

                this.nextMonth();
            });
        };

        getEventByCodeAndDate(code, date) {
            // Use the spread operator to create a copy of an array of object, helping to avoid referencing
            const events = [...this.getDateData().events];

            events.forEach(event => {
                if (event.study_date.split(' ').length < 2) {
                    event.study_date += ' 00:00:00';
                };
            });

            const result = events.find(event => event.code === code && event.study_date === date);
            const endArrTimePart = result.end_at.split(' ')[1];
            const startArrTimePart = result.start_at.split(' ')[1];

            if (startArrTimePart) {
                result.start_at = startArrTimePart;
            };

            if (endArrTimePart) {
                result.end_at = endArrTimePart;
            };

            return result;
        };

        editEvent(eventEdited) {
            const existingEvents = this.getDateData().events;
            const updatedEvents = existingEvents.filter(event => {
                return !(event.code == eventEdited.code && event.study_date == eventEdited.study_date);
            });

            this.getDateData().events = updatedEvents;
            this.getDateData().events.push(eventEdited);
            this.render();
            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
        };

        addEvent(event) {
            this.dateData.events.push(event);
            // Sau khi thực hiện render cho TAB 1 (Tờ lịch) -> tiếp tục chạy hàm render các dòng dữ liệu cho TAB 2 (danh sách các sections)
            // Bởi vì TAB 2 lấy dữ liệu từ Class calendar
            if (sectionsList) {
                sectionsList.render();
            }
            this.render();
        };

        /**
         * Sort all events by start at to index order number per section
         * @return void
         */
        sortEventsByStartAt() {
            this.dateData.events.sort((a, b) => {
                const dateA = new Date(a.start_at);
                const dateB = new Date(b.start_at);
                return dateA - dateB;
            })

            for (let i = 0; i < this.dateData.events.length; ++i) {
                this.dateData.events[i].order_number = i + 1;
            }
        }

        /**
         * Show calendar with all sections updated
         * @return void
         */
        render() {
            const _this = this;

            _this.sortEventsByStartAt();

            const data = {};

            data._token = "{{ csrf_token() }}";
            data.date = this.dateData.date;
            data.totalHours = addCourseManager.getTotalHoursInputValue();
            data.isAbroad = 1;
            data.events = JSON.stringify(this.dateData.events);

            addCourseManager.manageConditionConstraintForEventCreation(null, this.dateData.events);

            $.ajax({
                url: '{{ action('App\Http\Controllers\Abroad\CalendarController@getCalendar') }}',
                method: 'POST',
                data: data,
            }).done(response => {
                $(this.container).html(response)
                calendarSectionHandle.events();
                
                this.events();

                if ($(this.getContainer())[0]) {
                    initJs($(this.getContainer())[0]);
                };
            }).fail(response => {
                weekScheduleTool.alertError(response.responseJSON.message);
            })
        };
    };

    /**
     * TAB 2: Quản lý tab 2 -> các sections ở dạng danh sách
     * Class này lấy dữ liệu các sections từ TAB 1 (Tờ lịch)
     * -> Khi render dữ liệu ra UI thì dữ liệu được lấy từ Calendar
     */
    var SectionsList = class {
        constructor(options) {
            this.container = options.container;

            this.init();
        }

        getContainer() {
            return this.container;
        }

        init() {
            this.render();
            this.events();
        }

        render() {
            const _this = this;

            calendar.sortEventsByStartAt();

            const data = {};

            data._token = "{{ csrf_token() }}";
            data.date = calendar.dateData.date;
            data.totalHours = addCourseManager.getTotalHoursInputValue();
            data.events = JSON.stringify(calendar.dateData.events);

            $.ajax({
                url: '{{ action('App\Http\Controllers\Abroad\CalendarController@getSectionsList') }}',
                method: 'POST',
                data: data,
            }).done(response => {
                this.container.html(response);

                const calendarScript = this.container.find('[script-control="calendar-script"]').textContent;
                
                // Run javascript part in the response text return 
                (new Function(calendarScript))();
                
                this.events();

                if ($(this.getContainer())[0]) {
                    initJs($(this.getContainer())[0]);
                };
            }).fail(response => {
                weekScheduleTool.alertError(response.responseJSON.message);
            })
        }

        events() {
            const _this = this;
        }
    }

    /**
     * Popup thêm thông tin và tạo mới 1 buổi học trong cấu hình tuần
     */
    var AddSchedulePopup = class {
        constructor(options) {
            this.popup = new Popup();
        };

        setData(data) {
            data._token = "{{ csrf_token() }}";
            this.popup.setData(data);
        };

        updateUrl(newUrl) {
            this.popup.url = newUrl;
            this.popup.load();
        };

        getPopup() {
            return this.popup;
        };

        hide() {
            this.popup.hide();
        };
    };

    var SuggestTeacherPopup = class {
        constructor(options) {
            this.popup = new Popup();
        };

        setData(data) {
            data._token = "{{ csrf_token() }}";
            this.popup.setData(data);
        };

        updateUrl(newUrl) {
            this.popup.url = newUrl;
            this.popup.load();
        };

        getPopup() {
            return this.popup;
        };

        hide() {
            this.popup.hide();
        };
    };

    /**
     * Popup ghi thông tin để tạo mới 1 section vào 1 ngày nào đó trong lịch
     * Hiện lên khi nhấn vào icon thêm mới 1 section ở 1 ô bất kỳ trên lịch
     */
    var AddEventInCalendarPopup = class {
        constructor(options) {
            this.popup = new Popup();
        };

        updateUrl(newUrl) {
            this.getPopup().url = newUrl;
            this.getPopup().load();
        };

        getPopup() {
            return this.popup;
        };

        hide() {
            this.popup.hide();
        };
    };

    /**
     * Popup chỉnh sửa thông tin của 1 section trong lịch
     * Hiện lên khi nhấn chỉnh sửa 1 section trên lịch
     */
    var EditEventInCalendarPopup = class {
        constructor(options) {
            this.popup = new Popup();
            this.popup.method = 'put';
        };

        setData(data) {
            data._token = "{{ csrf_token() }}";
            this.popup.setData(data);
        };

        updateUrl(newUrl) {
            this.getPopup().url = newUrl;
            this.getPopup().load();
        };

        getPopup() {
            return this.popup;
        };

        hide() {
            this.popup.hide();
        };
    };

    /**
     * Quản lý chung cả màn hình tạo mới lớp học này.
     * tập trung vào form nhập các dữ liệu ở phía trên phần lịch
     */
    var AddCourseManager = class {
        daysOfWeek = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']

        constructor(options) {
            this.container = options.container;
            this.form = this.container.querySelector('#courseForm');
            this.action = this.form.querySelector('[data-control="action"]').value;

            this.events();
        };

        getAction() {
            return this.action;
        };

        getZoomForm() {
            return this.getContainer().querySelector('[form-control="zoom"]');
        }

        getLocationForm()
        {
            return this.getContainer().querySelector('[form-control="location"]');
        }

        getCancelBtn() {
            return this.container.querySelector('#cancelAddCourseBtn');
        };

        getStudyMethodSelect() {
            return this.getContainer().querySelector('[name="study_method"]');
        }

        getStudyMethodSelectValue() {
            return this.getStudyMethodSelect().value;
        }

        // Prevent user from change the study method value
        keepCurrentStudyMethodValue() {
            const _this = this;

            if (_this.getStudyMethodSelect()) {
                _this.getStudyMethodSelect().disabled = true;
            }
        }

        // Allow user from change the study method value
        freeSelectStudyMethod() {
            const _this = this;

            if (_this.getStudyMethodSelect()) {
                _this.getStudyMethodSelect().disabled = false;
            }
        }

        // ZOOM

        // Start Link
        getZoomStartLinkInput() {
            return this.getContainer().querySelector('[name="zoom_start_link"]');
        }

        getZoomStartLinkValue() {
            return this.getZoomStartLinkInput().value;
        }

        setZoomStartLinkValue(link) {
            this.getZoomStartLinkInput().value = link;
        }

        getCopyStartLinkBtn() {
            return this.getContainer().querySelector('[action-control="copy-start-link"]');
        }

        // Join link
        getZoomJoinLinkInput() {
            return this.getContainer().querySelector('[name="zoom_join_link"]');
        }

        getZoomJoinLinkValue() {
            return this.getZoomJoinLinkInput().value;
        }

        setZoomJoinLinkValue(link) {
            this.getZoomJoinLinkInput().value = link;
        }

        getCopyjoinLinkBtn() {
            return this.getContainer().querySelector('[action-control="copy-join-link"]');
        }

        // Zoom password
        getZoomPasswordInput() {
            return this.getContainer().querySelector('[name="zoom_password"]');
        }

        getZoomPasswordValue() {
            return this.getZoomPasswordInput().value;
        }

        setZoomPasswordValue(link) {
            this.getZoomPasswordInput().value = link;
        }

        getCopyPasswordBtn() {
            return this.getContainer().querySelector('[action-control="copy-link-password"]');
        }

        // Create link
        getPullZoomLinkBtn() {
            return this.getContainer().querySelector('[button-action="get-link"]');
        }

        getStartDateInput() {
            return this.getContainer().querySelector('[name="start_at"]');
        };

        setStartDateInput(value) {
            this.getContainer().querySelector('[name="start_at"]').value = value;
        };

        getLocationSelect() {
            return this.getContainer().querySelector('[name="training_location_id"]');
        }

        getLocationValue() {
            return this.getLocationSelect().value;
        }

        setLocationValue(location) {
            this.getLocationSelect().value = location;
        }

        getHomeRoomSelect() {
            return this.getContainer().querySelector('[name="teacher_id"]');
        }

        queryHomeRoomsByArea(area) {
            let url = "{{ action([App\Http\Controllers\Abroad\StaffController::class, 'getHomeRoomByArea'], ['area' => 'PLACEHOLDER']) }}";
            const updatedUrl = url.replace('PLACEHOLDER', area);

            return new Promise((resolve, reject) => {
                // $.ajax({
                //     url: updatedUrl,
                // }).done(response => {
                //     resolve(response);
                // }).fail(response => {
                //     reject(new Error(response.messages));
                // })
            })
        }

        getHomeRoomValue() {
            return this.getHomeRoomSelect().value;
        }

        getHomeRoomForm() {
            return this.getContainer().querySelector('[form-control="homeroom-form"]');
        }

        hideHomeRoomForm() {
            this.getHomeRoomForm().classList.add('d-none');
        }

        showHomeRoomForm() {
            this.getHomeRoomForm().classList.remove('d-none');
        }

        getSelectedHomeRoomValue() {
            return this.getContainer().querySelector('[data-control="selected-homeroom"]').value;
        }

        /**
         * Tạo ra các options cho ô select chủ nhiệm theo mảng các chủ nhiệm lấy được
         * @oaram homerooms Mảng các giáo viên chủ nhiệm lấy về được từ server
         * @return void
         */
        setHomeRoomOptions(homerooms) {
            const homeroomIdSelected = this.getSelectedHomeRoomValue(); // Chủ nhiệm đã được chọn trước đó
            let options = `<option value="">Chọn giáo viên chủ nhiệm</option>`;
            let selected = '';

            homerooms.forEach(homeroom => {
                // Kiểm tra có giáo viên chủ nhiệm đã được chọn trong danh sách chủ nhiệm không?
                if (homeroom.id == parseInt(homeroomIdSelected)) {
                    // Nếu có thì cho option đó được select
                    selected = 'selected';
                } else {
                    selected = '';
                }

                options += `<option value="${homeroom.id}" ${selected}>${homeroom.name}</option>`;
            })

            this.getHomeRoomSelect().innerHTML = options;
        }

        // Data
        getStartDateInputValue() {
            return $(this.getStartDateInput()).val();
        };

        getTotalHoursInput() {
            return this.getContainer().querySelector('[name="total_hours"]');
        };

        getTotalHoursInputValue() {
            return $(this.getTotalHoursInput()).val();
        };

        getTestHoursInput() {
            return this.getContainer().querySelector('[name="test_hours"]');
        };

        getTestHoursInputValue() {
            return this.getTestHoursInput() ? this.getTestHoursInput().value : 0;
        };

        getContainer() {
            return this.container;
        };

        getDaysOfWeek() {
            return this.daysOfWeek;
        };

        getForm() {
            return this.form;
        };

        getFormData() {
            return $(this.getForm()).serialize();
        };

        getSubmitBtn() {
            return this.container.querySelector('#doneAddCourseBtn');
        };

        loadTotalDays() {
            this.getTotalDaysLabel().innerHTML = this.getTotalDays();
        };

        loadEndDate() {
            this.getEndDateLabel().innerHTML = this.convertDate(this.getEndDate());
        };

        async loadSavedValues() {
            if (!this.getContainer().querySelector('[data-control="saved-values"]').value) {
                return;
            };

            const savedValues = JSON.parse(this.getContainer().querySelector('[data-control="saved-values"]').value);

            // Fix auto load current date in date input
            if (savedValues.start_at === '') {
                this.setStartDateInput('');
            }; // Have to do this because when start_at response === '', the program auto fill current date to input form

            // Load subject selected before
            const typeSelected = savedValues.type;
            const subjectSelectedId = savedValues.subject_id; 
            const subjectSelected = subjectsManager.getSubjectById(subjectSelectedId);

            if (typeSelected) {
                subjectsManager.loadTypeOptions(typeSelected);
            };

            if (subjectSelected) {
                /**
                 * Have to use a Promise to handle the asynchronous operation here 
                 * Because when executing loadSubjectOptionsByType, loadTypeOptions might not have completed yet
                 */
                await subjectsManager.loadTypeOptions(subjectSelected.type);
                subjectsManager.loadSubjectOptionsByType(subjectSelected.type, subjectSelected);
            };
        };

        addSubmitEffect() {
            this.getSubmitBtn().setAttribute('data-kt-indicator', 'on');
            this.getSubmitBtn().setAttribute('disabled', true);
        };
    
        removeSubmitEffect() {
            this.getSubmitBtn().removeAttribute('data-kt-indicator');
            this.getSubmitBtn().removeAttribute('disabled');
        };
    
        addLoadingEffect() {
            this.getContainer().classList.add("list-loading");
        };
    
        removeLoadingEffect() {
            this.getContainer().classList.remove("list-loading");

            if (this.getContainer().querySelector('[list-action="loader"]')) {
                this.getContainer().querySelector('[list-action="loader"]').remove();
            };

            KTComponents.init();
        };

        /**
         * Performing operations related to the necessary constraint conditions 
         * when executing actions related to creating, deleting, editing, etc., events or schedules
         * @return void
         */
        manageConditionConstraintForEventCreation(weekEvents, calendarEvents) {
            const weekCondition = weekEvents ? (weekEvents.length > 0 ? true : false) : false;
            const calendarCondition = calendarEvents ? (calendarEvents.length > 0 ? true : false) : false;

            // Checking conditions related to subject when creating a new event or schedule.
            if (weekCondition || calendarCondition) {
                // If current have at least 1 event or schedule
                // => prevent user from change subject
                if (subjectsManager) {
                    subjectsManager.keepCurrentTypeValue();
                    subjectsManager.keepCurrentSubjectValue();
                }
            } else {
                if (subjectsManager) {
                    subjectsManager.freeSelectType();
                    subjectsManager.freeSelectSubject();
                }
            }

            // // Checking conditions related to learning methods, branches when creating a new event or schedule.
            // if (weekCondition || calendarCondition) {
            //     // If there is at least one class
            //     // It must be ensured that the learning method has been selected beforehand.
            //     if (addCourseManager && addCourseManager.getStudyMethodSelectValue()) {
            //         addCourseManager.keepCurrentStudyMethodValue();
            //     } else {
            //         throw new Error("Bug: exist schedule but no study method selected any more!");
            //     }

            //     if (trainingLocationHandle && trainingLocationHandle.getBranch()) {
            //         trainingLocationHandle.keepCurrentBranchValue();
            //     }
            // } else {
            //     if (addCourseManager) {addCourseManager.freeSelectStudyMethod()}
            //     if (trainingLocationHandle) {trainingLocationHandle.freeSelectBranch()}
            // }
        }

        submit() {
            (() => {
                subjectsManager.freeSelectType();
                subjectsManager.freeSelectSubject();
                addCourseManager.freeSelectStudyMethod();
                trainingLocationHandle.freeSelectBranch();
            })()

            const url = this.getForm().getAttribute('action');
            calendar.sortEventsByStartAt();

            const data = {
                _token: "{{ csrf_token() }}",
                form: this.getFormData(),
                events: JSON.stringify(calendar.getEvents()),
                week_schedules: weekScheduleTool.getWeekEventsData(),
            };

            this.addSubmitEffect();
            this.addLoadingEffect();

            $.ajax({
                url: url,
                method: 'PUT',
                contentType: "application/json",
                data: JSON.stringify(data),
            }).done(response => {
                this.removeSubmitEffect();
                this.removeLoadingEffect();

                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        this.addLoadingEffect();
                        window.location.href = "{{ action('App\Http\Controllers\Abroad\CourseController@index') }}";
                    }
                });
            }).fail(response => {
                this.removeSubmitEffect();
                this.removeLoadingEffect();
                let updateContent = $(response.responseText).find('#dataFillForm');

                $('#dataFillForm').html(updateContent);

                subjectsManager = new SubjectsManager({
                    container: addCourseManager.getContainer()
                });

                addCourseManager.events();
                addCourseManager.loadSavedValues();
                classTypeManage.events();
                trainingLocationHandle = new TrainingLocationHandle();

                addCourseManager.manageConditionConstraintForEventCreation(weekScheduleTool.getWeekEventsData(), calendar.dateData.events);

                if ($(this.getContainer())[0]) {
                    initJs($(this.getContainer())[0]);
                };
            });
        };

        getZoomMeetingLinkSuccessHandle(response) {
            const startUrl = response.startUrl;
            const joinUrl = response.joinUrl;
            const password = response.password;

            // this.setZoomStartLinkValue(startUrl);
            // this.setZoomJoinLinkValue(joinUrl);
            // this.setZoomPasswordValue(password);
        }

        addSubmitEffecttoCreateZoom(btn) {
            btn.setAttribute('disabled', true);
            btn.innerHTML = 
            `
                <div class="spinner-border text-warning me-2" style="width: 1rem; height: 1rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Đang tạo link phòng học
            `
        };

        removeSubmitEffectFromCreateZoom(btn) {
            btn.removeAttribute('disabled');
            btn.innerHTML = 
            `
                Tạo link mới thành công!  <span class='material-symbols-rounded'>done</span>
            `
            btn.classList.remove('btn-info');
            btn.classList.add('btn-success');

            setTimeout(() => {
                btn.innerHTML = 
                `
                    Tạo link phòng học ZOOM
                `

                btn.classList.remove('btn-success');
                btn.classList.add('btn-info');
            }, 1500);
        };

        clickPullZoomLinkHandle(e) {
            const _this = this;
            const button = e.target;
            const url = button.getAttribute('data-link');

            this.addSubmitEffecttoCreateZoom(button);

            $.ajax({
                url: url,
                method: 'get'
            }).done(response => {
                _this.getZoomMeetingLinkSuccessHandle(response);
                this.removeSubmitEffectFromCreateZoom(button);
            }).fail(response => {
                this.removeSubmitEffectFromCreateZoom(button);
                throw new Error(response.message);
            })
        }

        clickPassWordHandle(e) {
            const element = e.target;
            const type = element.getAttribute('type');

            if (type === 'text') {
                element.setAttribute('type', 'password');
            } else if (type === 'password') {
                element.setAttribute('type', 'text');
            } else {
                element.setAttribute('type', 'password');
            }
        }

        changeToCopied(button) {
            button.innerHTML = "<span class='material-symbols-rounded'>done</span>";
            button.classList.remove('btn-secondary');
            button.classList.add('btn-success');
        }

        changeToNotCopyYet(button) {
            button.innerHTML = "Copy";
            button.classList.remove('btn-success');
            button.classList.add('btn-secondary');
        }

        clickCopyHandle(e, value) {
            const button = e.target;
            
            copyToClipboard(value);
            this.changeToCopied(button);

            setTimeout(() => {
                this.changeToNotCopyYet(button);
            }, 2000);
        }

        showZoomForm() {
            this.getZoomForm().classList.remove('d-none');
        }

        hideZoomForm() {
            this.getZoomForm().classList.add('d-none');
        }

        showLocationForm() {
            this.getLocationForm().classList.remove('d-none');
        }

        hideLocationForm() {

            this.getLocationForm().classList.add('d-none');
        }

        changeToOnlineMethod() {
            this.setLocationValue("");
            this.hideLocationForm();
            this.showZoomForm();
        }

        changeToOfflineMethod() {
            // this.setZoomStartLinkValue("");
            // this.setZoomJoinLinkValue("");
            // this.setZoomPasswordValue("");
            this.hideZoomForm();
            this.showLocationForm();
        }

        notSelectStudyMethodYet() {
            this.hideLocationForm();
            this.hideZoomForm();
        }

        /**
         * Change the study method (Online or Offline)
         * @return void
         */
        changeStudyMethodHandle() {
            const studyMethod = this.getStudyMethodSelectValue();
            const onlineMethod = "{!! \App\Models\Course::STUDY_METHOD_ONLINE !!}";
            const offlineMethod = "{!! \App\Models\Course::STUDY_METHOD_OFFLINE !!}";

            if (studyMethod === "" || !studyMethod) {
                this.notSelectStudyMethodYet();
                this.hideHomeRoomForm(); // Hide
            } else {
                let homerooms;

                if (studyMethod === onlineMethod) {
                    // Nếu là phương thức online thì lấy ra tất cả giáo viên (Do tạm thời ASMS chưa nói rõ khúc này)
                    homerooms = JSON.parse(JSON.stringify({!! \App\Models\Teacher::all() !!}));

                    this.changeToOnlineMethod();
                    this.setHomeRoomOptions(homerooms);
                    this.showHomeRoomForm(); // Show
                } else if (studyMethod === offlineMethod) {
                    // Nếu phương thức học là offline thì sẽ dựa vào chọn chi nhánh
                    // Để lấy ra các giáo viên phù hợp với từng chi nhánh
                    this.hideHomeRoomForm(); // lại Hide đi, vì logic show lại sẽ xử lý ở khúc thay đổi branch
                    this.changeToOfflineMethod();
                    trainingLocationHandle.changeBranch();
                } else {
                    throw new Error("Invalid study method!");
                }
            }
        }

        events() {
            const _this = this;

            // Change HomeRoom
            $(_this.getHomeRoomSelect()).on('change', function(e) {
                e.preventDefault();
            })

            /**
             * Validate past time 
             * FLAG: hidden
             * Temporary hide for the fill init data in the ASMS side 
             */
            // $(_this.getStartDateInput()).on('change', function(e) {
            //     e.preventDefault();

            //     // Handle date
            //     const selectedDate = new Date(this.value);
            //     const today = new Date();
            //     today.setUTCHours(0,0,0,0);

            //     if (isNaN(selectedDate) || selectedDate < today) {
            //         ASTool.alert({
            //             message: "Không thể chọn ngày bắt đầu học trước thời điểm hiện tại!",
            //             icon: 'warning'
            //         })

            //         this.value = '';
            //         return;
            //     }

            //     timeAutoCaculatForm.loadTimesInformation();
            // });

            $(_this.getTotalHoursInput()).on('change', function(e) {
                e.preventDefault();
                timeAutoCaculatForm.loadTimesInformation();
            });

            $(_this.getSubmitBtn()).on('click', e => {
                e.preventDefault();
                _this.getSubmitBtn().outerHTML = _this.getSubmitBtn().outerHTML
                _this.submit();
            });

            $(_this.getCancelBtn()).on('click', function(e) {
                e.preventDefault();

                const url = this.getAttribute('href');
                ASTool.confirm({
                    message: "Bạn có chắc muốn loại bỏ những thay đổi và quay về trang danh sách?",
                    ok: function() {
                        ASTool.addPageLoadingEffect();

                        $.ajax({
                            url: url
                        }).done(response => {
                            window.location.href = url;
                        }).fail(response => {
                            throw new Error(response.message);
                        });
        
                        ASTool.removePageLoadingEffect();
                    }
                });
            });

            $(_this.getPullZoomLinkBtn()).on('click', function(e) {
                e.preventDefault();
                _this.clickPullZoomLinkHandle(e)
            })

            $(_this.getZoomPasswordInput()).on('click', function(e) {
                e.preventDefault();
                _this.clickPassWordHandle(e);
            })

            // Copy
            // Click Copy start link
            $(_this.getCopyStartLinkBtn()).on('click', function(e) {
                e.preventDefault();
                const value = _this.getZoomStartLinkValue();
                _this.clickCopyHandle(e, value);
            })

            // Click Copy join link
            $(_this.getCopyjoinLinkBtn()).on('click', function(e) {
                e.preventDefault();
                const value = _this.getZoomJoinLinkValue();
                _this.clickCopyHandle(e, value);
            })

            // Click Copy password
            $(_this.getCopyPasswordBtn()).on('click', function(e) {
                e.preventDefault();
                const value = _this.getZoomPasswordValue();
                _this.clickCopyHandle(e, value);
            })

            $(_this.getStudyMethodSelect()).on('change', function(e) {
                e.preventDefault();
                _this.changeStudyMethodHandle()
            })
        };
    };

    /**
     * Quản lý việc show ra các môn học ứng với từng loại đào tạo mỗi khi người dùng 
     * thay đổi loại đào tạo
     */
    var SubjectsManager = class {
        subjects = {!! json_encode(App\Models\Subject::all()) !!};

        constructor(options) {
            this.container = options.container;
            this.allowLoadTypes = true;

            this.init();
        };

        getContainer() {
            return this.container;
        };

        setAllowLoadTypes(isAllow) {
            this.allowLoadTypes = isAllow;
        };

        getAllowLoadTypes() {
            return this.allowLoadTypes;
        };

        getSubjects() {
            return this.subjects;
        };

        getTypes() {
            const types = [];

            this.getSubjects().forEach(subject => {
                if (!types.includes(subject.type)) {
                    types.push(subject.type);
                }
            });

            return types;
        };

        getSubjectsByType(type) {
            const subjects = [];

            this.getSubjects().forEach(subject => {
                if (subject.type === type) {
                    subjects.push(subject);
                };
            });

            return subjects;
        };

        getSubjectById(id) {
            if (!id) {
                return null;
            };

            let subjectResult = null;
            
            this.getSubjects().forEach(subject => {
                if (parseInt(id) === parseInt(subject.id)) {
                    subjectResult = subject;
                };
            });

            return subjectResult;
        };

        loadTypeOptions(selectedType) {
            let optionsString = `<option value="">Chọn loại đào tạo</option>`;
            
            if (!selectedType) {
                this.getTypes().forEach(type => {
                    const newOption = `<option value="${type}">${type}</option>`;
    
                    optionsString += newOption;
                });
            } else {
                let selected = '';

                this.getTypes().forEach(type => {
                    if (selectedType === type) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }

                    const newOption = `<option value="${type}" ${selected}>${type}</option>`;
    
                    optionsString += newOption;

                    return new Promise((resolve, reject) => {
                        this.getTypeSelect().innerHTML = optionsString;
                        resolve();
                    });
                });
            }

            this.getTypeSelect().innerHTML = optionsString;

        };

        loadSubjectOptionsByType(type, selectedSubject) {
            let optionsString = `<option value="">Chọn môn học</option>`;
            const subjects = this.getSubjectsByType(type);

            if (!selectedSubject) {
                subjects.forEach(subject => {
                    const newOption = `<option value="${subject.id}">${subject.name}</option>`;
    
                    optionsString += newOption;
                });
            } else {
                let selected = '';

                subjects.forEach(subject => {
                    if (parseInt(subject.id) === parseInt(selectedSubject.id)) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    };

                    const newOption = `<option value="${subject.id}" ${selected}>${subject.name}</option>`;
    
                    optionsString += newOption;
                });
            };

            this.getSubjectSelect().innerHTML = optionsString;
        };

        getTypeSelect() {
            return this.getContainer().querySelector('[data-action="type-select"]');
        };

        getSubjectSelect() {
            return this.getContainer().querySelector('[data-action="subject-select"]');
        };

        keepCurrentTypeValue() {
            const _this = this;

            if (_this.getTypeSelect()) {
                _this.getTypeSelect().disabled = true;
            }
        }

        keepCurrentSubjectValue() {
            const _this = this;

            if (_this.getSubjectSelect()) {
                _this.getSubjectSelect().disabled = true;
            }
        }

        freeSelectType() {
            const _this = this;

            if (_this.getTypeSelect()) {
                _this.getTypeSelect().disabled = false;
            }
        }

        freeSelectSubject() {
            const _this = this;

            if (_this.getSubjectSelect()) {
                _this.getSubjectSelect().disabled = false;
            }
        }

        init() {
            this.loadTypeOptions();
            this.events();
        };

        selectTypeHande(type) {
            if (this.getAllowLoadTypes()) {
                this.loadSubjectOptionsByType(type);
            };
        };

        events() {
            const _this = this;

            $(_this.getTypeSelect()).on('change', function(e) {
                e.preventDefault();
                _this.selectTypeHande(this.value);
            });
        };
    };

    /**
     * Class quản lý cho form show tổng thời gian học, khoảng thời gian, thời gian kết thúc, ...
     * ngay dưới ô cấu hình thời khóa biểu mỗi tuần.
     */
    var TimeAutoCaculatForm = class {
        startDate = null;
        totalHours = null;
        totalDates = null;
        endDate = null;
        
        constructor(options) {
            this.container = options.container;

            this.init();
        };

        getContainer() {
            return this.container;
        };

        getVnTeacherDurationInput() {
            return this.getContainer().querySelector('[name="vn_teacher_duration"]');
        };

        getVnTeacherDurationValue() {
            return this.getVnTeacherDurationInput().value;
        };

        getForeignTeacherDurationInput() {
            return this.getContainer().querySelector('[name="foreign_teacher_duration"]');
        };

        getForeignTeacherDurationValue() {
            return this.getForeignTeacherDurationInput().value;
        };

        getTutorDurationInput() {
            return this.getContainer().querySelector('[name="tutor_duration"]');
        };

        getTutorDurationValue() {
            return this.getTutorDurationInput().value;
        };  

        getAssistantDurationInput() {
            return this.getContainer().querySelector('[name="assistant_duration"]');
        };

        getAssistantDurationValue() {
            return this.getAssistantDurationInput().value;
        };

        getTotalDays() {
            return this.totalDates;
        };

        setTotalDays(newTotalDays) {
            this.totalDates = newTotalDays;
        };

        getStartDate() {
            return this.startDate;
        };

        setStartDate(newStartDate) {
            this.startDate = newStartDate;
        };

        getTotalHours() {
            return this.totalHours;
        };

        setTotalHours(newTotalHours) {
            this.totalHours = newTotalHours;
        };

        getEndDate() {
            return this.endDate;
        };

        setEndDate(newEndDate) {
            this.endDate = newEndDate;
            this.getContainer().querySelector('[name="end_at"]').value = newEndDate;
        };

        getStartDateInputValue() {
            return addCourseManager.getStartDateInputValue();
        };

        getTotalHoursInputValue() {
            return addCourseManager.getTotalHoursInputValue();
        };

        getTotalDaysLabel() {
            return this.getContainer().querySelector('[data-control="total_dates"]');
        };

        getEndDateLabel() {
            return this.getContainer().querySelector('[data-control="end_date"]');
        };

        loadTotalDays() {
            this.getTotalDaysLabel().innerHTML = this.getTotalDays();
        };

        loadEndDate() {
            this.getEndDateLabel().innerHTML = this.convertDate(this.getEndDate());
        };

        getDaysOfWeek() {
            return addCourseManager.getDaysOfWeek();
        };

        getAllEventsWithVietnameseTeacher(currentCalendarEvents) {
            const eventsWithVnTeacher = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_vn_teacher_check 
                    && event.is_vn_teacher_check !== "0" 
                    && event.is_vn_teacher_check !== "false" 
                    && event.is_vn_teacher_check !== "") {
                        eventsWithVnTeacher.push(event);
                    };
            });

            return eventsWithVnTeacher;
        };

        getAllEventsWithForeignTeacher(currentCalendarEvents) {
            const eventsWithForeignTeacher = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_foreign_teacher_check
                    && event.is_foreign_teacher_check !== "0"
                    && event.is_foreign_teacher_check !== "false"
                    && event.is_foreign_teacher_check !== "") {
                        eventsWithForeignTeacher.push(event);
                    };
            });

            return eventsWithForeignTeacher;
        };

        getAllEventsWithTutor(currentCalendarEvents) {
            const eventsWithTutor = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_tutor_check 
                    && event.is_tutor_check !== "0" 
                    && event.is_tutor_check !== "false" 
                    && event.is_tutor_check !== "") {
                        eventsWithTutor.push(event);
                    };
            });

            return eventsWithTutor;
        };

        getAllEventsWithAssistant(currentCalendarEvents) {
            const eventsWithAssistant = [];

            currentCalendarEvents.forEach(event => {
                if (event.is_assistant_check 
                    && event.is_assistant_check !== "0" 
                    && event.is_assistant_check !== "false" 
                    && event.is_assistant_check !== "") {
                        eventsWithAssistant.push(event);
                    };
            });

            return eventsWithAssistant;
        };

        caculateDurationFromStartTimeAndEndTime(startTime, endTime) {
            const startParts = startTime.split(':');
            const endParts = endTime.split(':');
            const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
            const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);
            const durationInMinutes = endMinutes - startMinutes;
    
            return durationInMinutes;
        };

        caculateTotalMinutesPerStaffType(events, staffType) {
            let durationInMinutes;
            let staffFrom;
            let staffTo;

            switch (staffType) {
                case 'vn_teacher':
                    staffFrom = 'vn_teacher_from';
                    staffTo = 'vn_teacher_to';
                    break;
                case 'foreign_teacher':
                    staffFrom = 'foreign_teacher_from';
                    staffTo = 'foreign_teacher_to';
                    break;
                case 'tutor':
                    staffFrom = 'tutor_from';
                    staffTo = 'tutor_to';
                    break;
                case 'assistant':
                    staffFrom = 'assistant_from';
                    staffTo = 'assistant_to';
                    break;
                default:
                    staffFrom = 'vn_teacher_from';
                    staffTo = 'vn_teacher_to';
            };
            
            if (events.length > 0) {
                durationInMinutes = 0;

                events.forEach(event => {
                    let from;
                    let to;

                    const fromTimeArray = event[staffFrom].split(' ');
                    const toTimeArray = event[staffTo].split(' ');

                    if (fromTimeArray.length > 1) {
                        from = fromTimeArray[0];
                    } else {
                        from = event[staffFrom];
                    };

                    if (toTimeArray.length > 1) {
                        to = toTimeArray[0];
                    } else {
                        to = event[staffTo];
                    };

                    const duration = this.caculateDurationFromStartTimeAndEndTime(from, to);

                    durationInMinutes += duration;
                });
            } else {
                durationInMinutes = 0;
            };

            return durationInMinutes;
        };

        caculateVnTeacherDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithVnTeacher = this.getAllEventsWithVietnameseTeacher(currentCalendarEvents); //Event with only VN teachers
            const totolVnTeacherDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithVnTeacher, 'vn_teacher');
            
            return totolVnTeacherDurationInMinutes;
        };

        caculateForeignTeacherDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithForeignTeacher = this.getAllEventsWithForeignTeacher(currentCalendarEvents); //Event with only foreign teachers
            const totolForeignTeacherDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithForeignTeacher, 'foreign_teacher');
            
            return totolForeignTeacherDurationInMinutes;
        };

        caculateTutorDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithTutor = this.getAllEventsWithTutor(currentCalendarEvents); //Event with only tutor
            const totolTutorDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithTutor, 'tutor');
            
            return totolTutorDurationInMinutes;
        };

        caculateAssistantDurationInMinutes() {
            const currentCalendarEvents = calendar.getDateData().events; // All events with all teachers
            const allEventsWithAssistant = this.getAllEventsWithAssistant(currentCalendarEvents); //Event with only assistant
            const totolAssistantDurationInMinutes = this.caculateTotalMinutesPerStaffType(allEventsWithAssistant, 'assistant');

            return totolAssistantDurationInMinutes;
        };

        loadVnTeacherDuration(durationInHour) {
            this.getVnTeacherDurationInput().value = durationInHour;
        };

        loadForeignTeacherDuration(durationInHour) {
            this.getForeignTeacherDurationInput().value = durationInHour;
        };

        loadTutorDuration(durationInHour) {
            this.getTutorDurationInput().value = durationInHour;
        };

        loadAssistantDuration(durationInHour) {
            this.getAssistantDurationInput().value = durationInHour;
        };
        
        loadDurationTimes() {
            const totalVnTeacherInHour = (this.caculateVnTeacherDurationInMinutes() / 60).toFixed(2);
            const totalForeignTeacherInHour = (this.caculateForeignTeacherDurationInMinutes() / 60).toFixed(2);
            const totalTutorInHour = (this.caculateTutorDurationInMinutes() / 60).toFixed(2);
            const totalAssistantInHour = (this.caculateAssistantDurationInMinutes() / 60).toFixed(2);

            this.loadVnTeacherDuration(totalVnTeacherInHour);
            this.loadForeignTeacherDuration(totalForeignTeacherInHour);
            this.loadTutorDuration(totalTutorInHour);
            this.loadAssistantDuration(totalAssistantInHour);
        };

        getTotalMinutesOfAllStaffs() {
            return this.caculateVnTeacherDurationInMinutes()
                + this.caculateForeignTeacherDurationInMinutes() 
                + this.caculateTutorDurationInMinutes() 
                + this.caculateAssistantDurationInMinutes();
        };

        // convert yyyy-mm-dd -> dd-mm-yyy
        convertDate(stringDate) {
            if (stringDate && typeof stringDate === 'string' && stringDate !== '--') {
                const dateObj = new Date(stringDate);
                const dateValue = dateObj.getDate();
                const monthValue = dateObj.getMonth() + 1;
                const yearValue = dateObj.getFullYear();
                const convertedDate = (dateValue < 10 ? '0' : '') + dateValue;
                const convertedMonth = (monthValue < 10 ? '0' : '') + monthValue;
                const newDate = convertedDate + '/' + convertedMonth + '/' + yearValue;
    
                return newDate;
            } else {
                return '--';
            };
        };

        getDayOfWeek(dateString) {
            const daysOfWeek = this.getDaysOfWeek();
            const date = new Date(dateString);
            const dayIndex = date.getDay();

            return daysOfWeek[dayIndex];
        };

        getNextDay(currDay) {
            const daysOfWeek = this.getDaysOfWeek();
            const currIndex = daysOfWeek.indexOf(currDay);

            if (currIndex !== -1) {
                const nextIndex = (currIndex + 1) % daysOfWeek.length;
                return daysOfWeek[nextIndex];
            };

            return 'mon';
        };

        convertToMinutes(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            return hours * 60 + minutes;
        };

        /**
         * To check whether, with the current schedule, the weekly teaching time is valid or not.
         */
        isReduceTimePerWeekValid(weekSchedules, startDate) {
            let minutesPerWeek = 0;
            let dayName = this.getNextDay(startDate);

            // Iterate through 7 times, corresponding to the 7 days of the week.
            for (let i = 0; i < 7; ++i) {
                /**
                 * For each day of the week, iterate through all the days in the weekly schedule. 
                 * If there is a day in the schedule with classes that matches the currently iterated day of the week, 
                 * => (*) Perform calculations based on the classes on that day. 
                 */
                for (let schedule of weekSchedules) {
                    if (schedule.name === dayName) {
                        schedule.schedules.forEach(event => {
                            // (*) Calculate the number of minutes for each class and add it to the weekly total minutes.
                            const start = this.convertToMinutes(event.start_at);
                            const end = this.convertToMinutes(event.end_at);
                            const duration = end - start;
                            let minutePerSection;

                            if (duration < 0) {
                                minutePerSection = (24 * 60) - duration;
                            } else {
                                minutePerSection = duration;
                            };

                            minutesPerWeek += minutePerSection;
                        });

                        break;
                    };
                };

                dayName = this.getNextDay(dayName); // Move on to the next day in the week.
            };

            return minutesPerWeek !== 0;
        };

        caculateTotalDays(weekSchedules, totalHours, startDate) {
            let totalMinutes = totalHours * 60;
            let totalDays = 0;
            let isExisScheduleItemInArray = false;
            let dayName = this.getDayOfWeek(startDate);

            if (this.isReduceTimePerWeekValid(weekSchedules, startDate)) {
                while(totalMinutes > 0 && dayName) {
                    for (let schedule of weekSchedules) {
                        if (schedule.name === dayName) {
                            schedule.schedules.forEach(event => {
                                const start = this.convertToMinutes(event.start_at);
                                const end = this.convertToMinutes(event.end_at);
                                const duration = end - start;
                                let reduceRange;
    
                                if (duration < 0) {
                                    reduceRange = (24 * 60) - duration;
                                } else {
                                    reduceRange = duration;
                                };
    
                                totalMinutes -= reduceRange;
                            });
    
                            break;
                        };
                    };
    
                    dayName = this.getNextDay(dayName);
                    totalDays += 1;
                };
            };

            return totalDays;
        };

        caculateEndDate(startDateStr, totalDays) {
            if (startDateStr && totalDays) {
                let startDate = new Date(startDateStr);
                let endDate = new Date(startDate);

                endDate.setDate(endDate.getDate() + totalDays);

                return endDate.toISOString().split('T')[0];
            };

            return null;
        };

        validateWhenLoadAutoFillValues() {
            let isValid = true;

            const weekSchedules = JSON.parse(JSON.stringify(weekScheduleTool.getWeekEventsData()));
            const totalHours = this.getTotalHours();
            const startDate = this.getStartDate();

            if (weekSchedules.length === 0 || !totalHours || totalHours <= 0 || !startDate) {
                isValid = false;
            };

            return isValid;
        };

        getAutoFillValuesForm() {
            return this.getContainer().querySelector('[form-control="auto-fill-values"]');
        };

        getNotExistAutoFillValuesForm() {
            return this.getContainer().querySelector('[form-control="not-existing-autofill-values"]');
        };

        showAutoFillValuesForm() {
            this.getAutoFillValuesForm().classList.remove('d-none');
        };

        hideAutoFillValuesForm() {
            this.getAutoFillValuesForm().classList.add('d-none');
        };

        showNotExistAutoFillValuesForm() {
            this.getNotExistAutoFillValuesForm().classList.remove('d-none');
        };

        hideNotExistAutoFillValuesForm() {
            this.getNotExistAutoFillValuesForm().classList.add('d-none');
        };

        loadAutoFillValues() {
            this.loadTotalDays();
            this.loadEndDate();
        };

        caculateAutoFillValues() {
            const weekSchedules = weekScheduleTool.getWeekEventsData();
            const totalHours = this.getTotalHours();
            const startDate = this.getStartDate();
            let totalDays = null;
            let endDate = null;

            setTimeout(() => {
                if (!this.validateWhenLoadAutoFillValues()) {
                    totalDays = '--';
                    endDate = '--';
                } else {
                    totalDays = this.caculateTotalDays(weekSchedules, totalHours, startDate);
                    endDate = this.caculateEndDate(startDate, totalDays);
                };
    
                if (totalDays && endDate && totalDays !== '--' && endDate !== '--') {
                    this.setTotalDays(totalDays);
                    this.setEndDate(endDate);
                    this.loadAutoFillValues();
                    this.showAutoFillValuesForm();
                    this.hideNotExistAutoFillValuesForm();
                } else {
                    this.hideAutoFillValuesForm();
                    this.showNotExistAutoFillValuesForm();
                };
            }, 0);
        };

        hideForm() {
            this.getContainer().classList.add('d-none');
        };

        showForm() {
            this.getContainer().classList.remove('d-none');
        };

        loadTimesInformation() {
            this.setStartDate(this.getStartDateInputValue());
            this.setTotalHours(this.getTotalHoursInputValue());
            this.caculateAutoFillValues();
        };

        validateToShowForm() {
            if (this.validateWhenLoadAutoFillValues() <= 0 && calendar.getDateData().events.length <= 0) {
                return false;
            };

            return true;
        };

        run() {
            this.loadDurationTimes();
            this.loadTimesInformation();

            if (this.validateToShowForm()) {
                this.showForm();
            } else {
                this.hideForm();
            };
        };

        init() {
            this.run();
        };
    }

    /**
     * Class phục vụ cho việc quản lý các ngày lễ, ngày nghỉ trên lịch
     */
    var Holiday = class {
        constructor(options) {
            this.data = options.data;
            this.calendar = options.calendar;
        
            // this.init();
        };

        getHolidays() {
            return this.data;
        };

        convertToCalendarEvents() {
            const rawData = this.getHolidays();
            const eventDatas = [];

            rawData.forEach(holiday => {
                let weekEvent = {
                    is_add_later: 'false',
                    name: holiday.name,
                    start_at: '',
                    end_at: '',
                    study_date: holiday.date,
                    title: holiday.name,
                    type: '',
                    is_holiday: 'true',
                    code: Date.now().toString(36) + Math.random().toString(36).substr(2, 5)
                };

                eventDatas.push(weekEvent);
            });

            return eventDatas;
        };

        applyToCalendar() {
            // Áp dụng events mới vào data của lịch, lịch sẽ tự động cập nhật lại UI với events mới
            this.calendar.updateEvents(this.convertToCalendarEvents());
        };

        init() {
            this.applyToCalendar();
        };
    };

    /**
     * The class performs tasks related to the type of class and the minimum and maximum number of students for current course.
     */
    var ClassTypeManage = class {
        _TYPE_ONE_ONE = "{!! \App\Models\Course::CLASS_TYPE_ONE_ONE !!}";

        constructor(options) {
            this.container = options.container;
            this.enteredMinNumberOfStudent = this.getMinNumberOfStudentsValue();
            this.enteredMaxNumberOfStudent = this.getMaxNumberOfStudentsValue();
            this.errorMessages = [];

            this.init();
        }

        getContainer() {
            return this.container;
        }

        // Error
        // Label
        getErrorLabel() {
            return this.getContainer().querySelector('[data-control="min-max-error-label"]');
        }

        setErrorLabelMessage(msg) {
            this.getErrorLabel().innerHTML = msg;
        }

        // Error messages
        getErrorMessages() {
            return this.errorMessages;
        }

        getFirstErrorMessage() {
            if (this.getErrorMessages().length > 0) {
                return this.getErrorMessages()[0];
            } else {
                return null;
            }
        }

        addErrorMessages(msg) {
            this.errorMessages.push(msg);
        }

        resetErrorMessages() {
            this.errorMessages = [];
        }

        // Class type select
        getClassTypeSelect() {
            return this.getContainer().querySelector('#class-type-select');
        }

        getClassTypeValue() {
            return this.getClassTypeSelect().value;
        }

        // Min number of students
        getMinNumberOfStudentsInput() {
            return this.getContainer().querySelector('#course-min-students-input');
        }

        getMinNumberOfStudentsValue() {
            return this.getMinNumberOfStudentsInput().value;
        }

        setMinNumberOfStudentsValue(number) {
            this.getMinNumberOfStudentsInput().value = number;
        }

        // Max number of students
        getMaxNumberOfStudentsInput() {
            return this.getContainer().querySelector('#course-max-students-input');
        }

        getMaxNumberOfStudentsValue() {
            return this.getMaxNumberOfStudentsInput().value;
        }

        setMaxNumberOfStudentsValue(number) {
            this.getMaxNumberOfStudentsInput().value = number;
        }

        // getter & setter entered value previously
        // Min number
        getEnteredMinNumberOfStudents() {
            return this.enteredMinNumberOfStudent;
        }

        setEnteredMinNumberOfStudents(number) {
            this.enteredMinNumberOfStudent = number;
        }

        // Max number
        getEnteredMaxNumberOfStudents() {
            return this.enteredMaxNumberOfStudent;
        }

        setEnteredMaxNumberOfStudents(number) {
            this.enteredMaxNumberOfStudent = number;
        }

        // Action/Method
        // Error
        showErrorLabel() {
            this.getErrorLabel().classList.remove('d-none');
        }

        hideErrorlabel() {
            this.getErrorLabel().classList.add('d-none');
        }

        resetErrorLabelMessage() {
            this.setErrorLabelMessage(""); // Set message to empty
        }

        // Data
        validate() {
            const classType = this.getClassTypeValue();
        }

        disableNumOfStudentsInput() {
            this.getMinNumberOfStudentsInput().readOnly = true;
            this.getMaxNumberOfStudentsInput().readOnly = true;
        }

        enableNumOfStudentInputs() {
            this.getMinNumberOfStudentsInput().readOnly = false;
            this.getMaxNumberOfStudentsInput().readOnly = false;
        }

        setOneAndOneToMinMax() {
            this.getMinNumberOfStudentsInput().value = 1;
            this.getMaxNumberOfStudentsInput().value = 1;
        }

        // Reset Min & Max to entered previously.
        resetMinMaxToEnteredValuePreviously() {
            const enteredMin = this.getEnteredMinNumberOfStudents();
            const enteredMax = this.getEnteredMaxNumberOfStudents();

            this.setMinNumberOfStudentsValue(enteredMin);
            this.setMaxNumberOfStudentsValue(enteredMax);
        }

        validateValues() {
            const classType = this.getClassTypeValue();
            const minStudents = parseInt(this.getMinNumberOfStudentsValue());
            const maxStudents = parseInt(this.getMaxNumberOfStudentsValue());

            let isValid = true;

            this.resetErrorMessages();

            if (minStudents === null 
            || maxStudents === null
            || minStudents === "" 
            || maxStudents === "" 
            || minStudents === 0 
            || maxStudents === 0) {
                // Not validated because at this moment, the user has not finished entering the data
                return true;
            }

            if (minStudents < 0) {
                isValid = false;
                this.addErrorMessages("Số lượng tối thiểu không được nhỏ hơn 0");
            }

            if (maxStudents < 0) {
                isValid = false;
                this.addErrorMessages("Số lượng tối đa không được nhỏ hơn 0");
            }

            if (minStudents > maxStudents) {
                isValid = false;
                this.addErrorMessages("Số lượng học viên tối thiểu không được lớn hơn số lượng học viên tối đa!");
            }

            if (minStudents > 1000 || maxStudents > 1000) {
                isValid = false;
                this.addErrorMessages("Số lượng học viên quá lớn, không hợp lý!");
            }

            if (classType !== this._TYPE_ONE_ONE && minStudents === 1 && maxStudents === 1) {
                isValid = false;
                this.addErrorMessages("Số lượng tối thiếu = 1 và tối đa = 1 thì phân loại phải là 1:1");
            }

            return isValid;
        }

        handleErrors() {
            this.resetErrorLabelMessage();

            if (!this.validateValues()) {
                const errorMsg = this.getFirstErrorMessage();
                this.setErrorLabelMessage(errorMsg);
                this.showErrorLabel();
            } else {
                this.resetErrorLabelMessage();
                this.hideErrorlabel();
            }
        }

        // Handle when change min value
        changeMinNumberHandle() {
            const value = this.getMinNumberOfStudentsValue(); // Get current min value
            this.setEnteredMinNumberOfStudents(value);
            this.handleErrors();
        }

        // Handle when change max value
        changeMaxNumberHandle() {
            const value = this.getMaxNumberOfStudentsValue(); // Get current max value
            this.setEnteredMaxNumberOfStudents(value);
            this.handleErrors();
        }

        handleClassTypeValue() {
            // Check if 1:1
            if (this.getClassTypeValue() === this._TYPE_ONE_ONE) {
                // Set 1 to min/max & disable fill
                this.setOneAndOneToMinMax();
                this.disableNumOfStudentsInput();
            } else {
                // Reset Min & Max to entered previously & enable fill
                this.enableNumOfStudentInputs();
                this.resetMinMaxToEnteredValuePreviously();
            }

            this.handleErrors();
        }

        handleWhenChangeClassType() {
            this.handleClassTypeValue();
        }

        init() {
            this.handleClassTypeValue();
            this.handleErrors();
            this.events();
        }

        events() {
            const _this = this;

            $(this.getClassTypeSelect()).on('change', function(e) {
                _this.handleWhenChangeClassType();
            })

            $(this.getMinNumberOfStudentsInput()).on('change', function(e) {
                _this.changeMinNumberHandle();
            })

            $(this.getMaxNumberOfStudentsInput()).on('change', function(e) {
                _this.changeMaxNumberHandle();
            })
        }
    }
</script>