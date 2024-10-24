@extends('layouts.main.popup')

@section('title')
Dạy thay buổi học ngày  {{  date('d/m/Y', strtotime($section->study_date)) }}
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
           <input type="hidden" name="section_id" value="{{$section->id}}">
            <div class="p-10" id={{ $formId }}>
                <div class="row mb-8">
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-12">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-2" for="start-at">Bắt đầu lúc</label>
                            <div class="d-flex align-items-center date-with-clear-button">
                                <input data-action="start-at-input" type="time" 
                                    class="form-control" value="{{date('H:i', strtotime($section->start_at))}}"
                                    placeholder="" name="start_at" readonly/>
                                    
                                </div>
                                <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-12">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-2" for="end-at">Kết thúc lúc</label>
                            <div   class="d-flex align-items-center date-with-clear-button">
                                <input data-action="end-at-input" type="time" 
                                    value="{{date('H:i', strtotime($section->end_at))}}"
                                    class="form-control"  placeholder="" name="end_at" readonly/>
                                    
                                </div>
                                <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-12 d-flex align-items-end">
                        <div class="form-outline w-100 mt-0">
                            <input type="text" class="form-control pe-none" readonly data-control="section-duration" value="{{ 
                                \Carbon\Carbon::parse($section->start_at)->diff(\Carbon\Carbon::parse($section->end_at))->format('%h giờ %i phút') 
                            }}" />
                            

                        </div>
                    </div>
                </div>
    
                <div class="card p-7 mb-4">
                    <label class="fs-6 fw-semibold mb-2" for="start-at">Giảng viên Việt Nam</label>
                    <div class="row mb-4 py-3" row-control="vn-teacher">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if(isset($section->vn_teacher_id)) checked @endif disabled
                                name="is_vn_teacher_check">
                            </div>                            
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $formId }}" class="form-select form-control " name="vn_teacher_id"
                                    data-control="select2" data-placeholder="Chọn giảng viên" @if(!isset($section->vn_teacher_id)) disabled @endif >
                                    <option value="">Chọn giảng viên</option>
                                    @foreach( App\Models\Teacher::isVietNam()->get() as $teacher )
                                        <option value="{{ $teacher->id }}" 
                                            @if (isset($section->vn_teacher_id))
                                            {{  $section->vn_teacher_id == $teacher->id ? "selected" : "" }}
                                        @endif
                                        >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vn_teacher_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12 border-end">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Bắt đầu:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input type="time" 
                                            @if (isset($section->vn_teacher_from))
                                                value="{{ isset($section->vn_teacher_from) ? $section->vn_teacher_from : "" }}" 
                                            @endif
                                            class="form-control border-0 bg-transparent" placeholder="" name="vn_teacher_from" readonly/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('vn_teacher_from')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Kết thúc:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input type="time" 
                                            @if (isset($section->vn_teacher_to))
                                                value="{{ isset($section->vn_teacher_to) ? $section->vn_teacher_to : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="vn_teacher_to"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div> 
                                    </div>
                                    <x-input-error :messages="$errors->get('vn_teacher_to')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-12 d-flex align-items-end">
                            <div class="form-outline w-100">
                                <input type="text" class="form-control pe-none" readonly data-control="vn-teacher-duration" value="{{ 
                                    \Carbon\Carbon::parse($section->vn_teacher_from)->diff(\Carbon\Carbon::parse($section->vn_teacher_to))->format('%h giờ %i phút') 
                                }}" />
                                
                            </div>
                        </div>
                    </div>
    
                    <label class="fs-6 fw-semibold mb-2" for="start-at">Giảng viên nước ngoài</label>
                    <div class="row mb-4 py-3" row-control="foreign-teacher">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center">
                            <div class="form-outline">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if(isset($section->foreign_teacher_id)) checked @endif disabled
                                name="is_foreign_teacher_check">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $formId }}" class="form-select form-control " name="foreign_teacher_id"
                                    data-control="select2" data-placeholder="Chọn giảng viên" @if(!isset($section->foreign_teacher_id)) disabled @endif>
                                    <option value="">Chọn giảng viên</option>
                                    @foreach( App\Models\Teacher::isForeign()->get() as $teacher )
                                    <option value="{{ $teacher->id }}" 
                                        @if (isset($section->foreign_teacher_id))
                                            {{  $section->foreign_teacher_id == $teacher->id ? "selected" : "" }}
                                        @endif readonly
                                    >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('foreign_teacher_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12 border-end">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Bắt đầu:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input type="time" 
                                            @if (isset($section->foreign_teacher_from))
                                                value="{{ isset($section->foreign_teacher_from) ? $section->foreign_teacher_from : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="foreign_teacher_from"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('foreign_teacher_from')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Kết thúc:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input type="time" 
                                            @if (isset($section->foreign_teacher_to))
                                                value="{{ isset($section->foreign_teacher_to) ? $section->foreign_teacher_to : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="foreign_teacher_to"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('foreign_teacher_to')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-12 d-flex align-items-end">
                            <div class="form-outline w-100">
                                <input type="text" class="form-control pe-none" readonly data-control="foreign-teacher-duration" value="{{ 
                                    \Carbon\Carbon::parse($section->foreign_teacher_from)->diff(\Carbon\Carbon::parse($section->foreign_teacher_to))->format('%h giờ %i phút') 
                                }}" />
                                
                            </div>
                        </div>
                    </div>
    
                    <label class="fs-6 fw-semibold mb-2" for="start-at">Gia sư</label>
                    <div class="row mb-4 py-3" row-control="tutor">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center">
                            <div class="form-outline">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if(isset($section->tutor_id)) checked @endif  disabled
                                name="is_tutor_check">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $formId }}" class="form-select form-control " name="tutor_id"
                                    data-control="select2" data-placeholder="Chọn gia sư" @if(!isset($section->tutor_id)) disabled @endif  >
                                    <option value="">Chọn gia sư</option>
                                    @foreach( App\Models\Teacher::isTutor()->get() as $teacher )
                                    <option value="{{ $teacher->id }}" 
                                        @if (isset($section->tutor_id))
                                            {{  $section->tutor_id == $teacher->id ? "selected" : "" }}
                                        @endif
                                    >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('tutor_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12 border-end">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Bắt đầu:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input type="time" 
                                            @if (isset($section->tutor_from))
                                                value="{{ isset($section->tutor_from) ? $section->tutor_from : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="tutor_from"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('tutor_from')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Kết thúc:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input type="time" 
                                            @if (isset($section->tutor_to))
                                                value="{{ isset($section->tutor_to) ? $section->tutor_to : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="tutor_to"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('tutor_to')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-12 d-flex align-items-end">
                            <div class="form-outline w-100">
                                <input type="text" class="form-control pe-none" readonly data-control="tutor-duration" value="{{ 
                                    \Carbon\Carbon::parse($section->tutor_from)->diff(\Carbon\Carbon::parse($section->tutor_to))->format('%h giờ %i phút') 
                                }}" />
                                
                            </div>
                        </div>
                    </div>
    
                    <div class="d-flex">
                        <label class="fs-6 fw-semibold mb-2" for="start-at">Trợ giảng</label>&nbsp;-&nbsp;
                        <p>Hỗ trợ cho giảng viên Việt Nam và giảng viên nước ngoài.</p>
                    </div>
                
                    <div class="row mb-4 py-3" row-control="assistant">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center">
                            <div class="form-outline">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if(isset($section->assistant_id)) checked @endif disabled
                                name="is_assistant_check">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $formId }}" class="form-select form-control" name="assistant_id"
                                    data-control="select2" data-placeholder="Chọn trợ giảng"  @if(!isset($section->assistant_id)) disabled @endif >
                                    <option value="">Chọn trợ giảng</option>
                                    @foreach( App\Models\Teacher::isAssistantAndAssistantKid()->get() as $teacher )
                                    <option value="{{ $teacher->id }}" 
                                        @if (isset($section->assistant_id))
                                            {{  $section->assistant_id == $teacher->id ? "selected" : "" }}
                                        @endif
                                    >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assistant_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12 border-end">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Bắt đầu:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input readonly type="time" 
                                            @if (isset($section->assistant_from))
                                                value="{{ isset($section->assistant_from) ? $section->assistant_from : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="assistant_from"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('assistant_from')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <label class="fs-6 fw-semibold mb-2" for="start-at">Kết thúc:</label>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center date-with-clear-button">
                                            <input readonly type="time" 
                                            @if (isset($section->assistant_to))
                                                value="{{ isset($section->assistant_to) ? $section->assistant_to : "" }}" 
                                            @endif readonly
                                            class="form-control border-0 bg-transparent" placeholder="" name="assistant_to"/>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('assistant_to')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-12 d-flex align-items-end">
                            <div class="form-outline w-100">
                                <input type="text" class="form-control pe-none" readonly data-control="assistant-duration" value="{{ 
                                    \Carbon\Carbon::parse($section->assistant_from)->diff(\Carbon\Carbon::parse($section->assistant_to))->format('%h giờ %i phút') 
                                }}" />
                                
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('teaching_errors')" class="mt-2" />
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

            var submit = function() {
               
                var sectionIdSelect = form.querySelector('input[name="section_id"]');
                var sectionId = sectionIdSelect.value;

                var data = $(form).serialize();
               
                var url = "{{ action('App\Http\Controllers\Abroad\SectionController@changeTeacherPopup', ['id' => 'PLACEHOLDER']) }}";
                url = url.replace('PLACEHOLDER', sectionId);


                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: data,

                }).done(function(response) {
                    
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
                    
                }).fail(function(response) {
                    if (typeof AttendancePopup !== 'undefined') {
                        AttendancePopup.getPopup().setContent(response.responseText);
                    } else if (typeof ShowOrderPopup !== 'undefined') {
                        ShowOrderPopup.getPopup().hide();
                    }
                    
                    removeSubmitEffect();
                    
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

                
            };
        })();

    </script>

@endsection