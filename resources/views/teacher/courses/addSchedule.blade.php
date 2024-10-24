@extends('layouts.main.popup')

@section('title')
    {{ isset($weekEventEdit) ? "Sửa" : "Thêm" }} lịch học
@endsection

@php
    $uniqId = 'addScheduleItem' . uniqid();

    $action = action([App\Http\Controllers\Teacher\CourseController::class, 'createScheduleItem']);

    if(isset($weekEventEdit)) {
        $action = action([App\Http\Controllers\Teacher\CourseController::class, 'editWeekScheduleItem']);
    }

    if(isset($isAddEventInCalendar)) {
        $action = action([App\Http\Controllers\CalendarController::class, 'createEventInCalendar']);
    }

    if(isset($weekEventEditInCalendar)) {
        $action = action([App\Http\Controllers\CalendarController::class, 'updateEventInCalendar']);
    }
@endphp

@section('content')
    <div id="{{ $uniqId }}">
        <form form-control="addScheduleItemForm" action="{{ $action }}" method="post">
            @csrf
            @php
                $popupUnidId = 'popupUniqId_' . uniqid();
            @endphp
           
           <div class="p-10" id={{ $popupUnidId }}>
            <div class="row mb-8">
                <div class="col-sm-12 col-12 {{ !isset($changeType) || !$changeType ? 'col-lg-4 col-xl-4 col-md-4 d-none' : 'col-lg-3 col-xl-3 col-md-3' }}">
                    <div class="form-outline">
                            <input type="hidden" name="subject_id" value="{{ $subject_id }}">
                            <input type="hidden" name="area" value="{{ $area }}">
                            <label class="required fs-6 fw-semibold mb-2" for="start-at">Phân loại</label>
                            <div class="d-flex align-items-center date-with-clear-button">
                                <select data-dropdown-parent="#{{ $popupUnidId }}" class="form-select form-control " name="type"
                                    data-control="select2" data-placeholder="Phân loại" data-allow-clear="true">
                                    @if (isset($changeType) && $changeType)
                                        @foreach (\App\Models\Section::getAllType() as $type)
                                            <option value="{{ $type }}" 
                                                @if (isset($weekEventEdit))
                                                    {{ isset($weekEventEdit['type']) && $weekEventEdit['type'] == $type ? "selected" : "" }}
                                                @elseif (isset($weekEventEditInCalendar))
                                                    {{ isset($weekEventEditInCalendar['type']) && $weekEventEditInCalendar['type'] == $type ? "selected" : "" }}
                                                @else
                                                    {{ isset($schedule['type']) && $schedule['type'] == $type ? "selected" : "" }}
                                                @endif
                                            >{{ trans('messages.section.' . $type) }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ \App\Models\Section::TYPE_GENERAL }}" selected>{{ \App\Models\Section::TYPE_GENERAL }}</option>
                                    @endif
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12 {{ !isset($changeType) || !$changeType ? 'col-lg-4 col-xl-4 col-md-4' : 'col-lg-3 col-xl-3 col-md-3' }}">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-2" for="start-at">Bắt đầu lúc</label>
                            <div class="d-flex align-items-center date-with-clear-button">
                                <input data-action="start-at-input" type="time"
                                @if (isset($weekEventEdit))
                                    value="{{ $weekEventEdit['start_at'] ? $weekEventEdit['start_at'] : '' }}" 
                                @elseif (isset($weekEventEditInCalendar))
                                    value="{{ $weekEventEditInCalendar['start_at'] ? $weekEventEditInCalendar['start_at'] : '' }}"
                                @else
                                    value="{{ isset($schedule) && $schedule['start_at'] ? $schedule['start_at'] : '' }}" 
                                @endif
                                    class="form-control"
                                    placeholder="" name="start_at"/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                                <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-12 {{ !isset($changeType) || !$changeType ? 'col-lg-4 col-xl-4 col-md-4' : 'col-lg-3 col-xl-3 col-md-3' }}">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-2" for="end-at">Kết thúc lúc</label>
                            <div   class="d-flex align-items-center date-with-clear-button">
                                <input data-action="end-at-input" type="time" 
                                @if (isset($weekEventEdit))
                                    value="{{ $weekEventEdit['end_at'] ? $weekEventEdit['end_at'] : '' }}" 
                                @elseif (isset($weekEventEditInCalendar))
                                    value="{{ $weekEventEditInCalendar['end_at'] ? $weekEventEditInCalendar['end_at'] : '' }}"
                                @else
                                    value="{{ isset($schedule) && $schedule['end_at'] ? $schedule['end_at'] : '' }}" 
                                @endif
                                class="form-control"
                                    placeholder="" name="end_at"/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                                <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-12 {{ !isset($changeType) || !$changeType ? 'col-lg-4 col-xl-4 col-md-4' : 'col-lg-3 col-xl-3 col-md-3' }} d-flex">
                        <div class="form-outline w-100 mt-0">
                            <label class="required fs-6 fw-semibold mb-2" style="visibility: hidden">Tổng thời gian</label>
                            <input type="text" class="form-control pe-none" readonly data-control="section-duration" value="--" />
                        </div>
                    </div>
                </div>
    
                <div class="card p-7 mb-4">
                    <label class="fs-6 fw-semibold mb-2" for="start-at">Giảng viên Việt Nam</label>
                    <div class="row mb-4 py-3 d-flex align-items-start" row-control="vn-teacher">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center" style="padding-top: 1%">
                            <div class="form-check">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if (isset($weekEventEdit))
                                {{ isset($weekEventEdit['is_vn_teacher_check']) && 
                                         $weekEventEdit['is_vn_teacher_check'] && 
                                         $weekEventEdit['is_vn_teacher_check'] !== "false" && 
                                         $weekEventEdit['is_vn_teacher_check'] !== "0" 
                                        ? "checked" 
                                        : "" }}
                                @elseif (isset($weekEventEditInCalendar))
                                {{ isset($weekEventEditInCalendar['is_vn_teacher_check']) && 
                                         $weekEventEditInCalendar['is_vn_teacher_check'] && 
                                         $weekEventEditInCalendar['is_vn_teacher_check'] !== "false" && 
                                         $weekEventEditInCalendar['is_vn_teacher_check'] !== "0" 
                                        ? "checked" 
                                        : "" }}
                                @else
                                {{ isset($schedule['is_vn_teacher_check']) ? "checked" : "" }} 
                                @endif
                                name="is_vn_teacher_check">
                            </div>                            
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $popupUnidId }}" class="form-select form-control " name="vn_teacher_id"
                                    data-control="select2" data-placeholder="Chọn giảng viên" data-allow-clear="true">
                                    <option value="">Chọn giảng viên</option>
                                    @foreach( App\Models\Teacher::isVietNam()->get() as $teacher) {{-- App\Models\Teacher::isVietNam()->get() --}}
                                        <option value="{{ $teacher->id }}" 
                                            @if (isset($weekEventEdit))
                                                {{ isset($weekEventEdit['vn_teacher_id']) && $weekEventEdit['vn_teacher_id'] == $teacher->id ? "selected" : "" }}
                                            @elseif (isset($weekEventEditInCalendar))
                                                {{ isset($weekEventEditInCalendar['vn_teacher_id']) && $weekEventEditInCalendar['vn_teacher_id'] == $teacher->id ? "selected" : "" }}
                                            @else
                                                {{ isset($schedule['vn_teacher_id']) && $schedule['vn_teacher_id'] == $teacher->id ? "selected" : "" }}
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['vn_teacher_from']) ? $weekEventEdit['vn_teacher_from'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['vn_teacher_from']) ? $weekEventEditInCalendar['vn_teacher_from'] : "" }}" 
                                            @else
                                                value="{{ isset($schedule['vn_teacher_from']) ? $schedule['vn_teacher_from'] : "" }}"    
                                            @endif
                                            class="form-control border-0 bg-transparent" placeholder="" name="vn_teacher_from"/>
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['vn_teacher_to']) ? $weekEventEdit['vn_teacher_to'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['vn_teacher_to']) ? $weekEventEditInCalendar['vn_teacher_to'] : "" }}" 
                                            @else
                                                value="{{ isset($schedule['vn_teacher_to']) ? $schedule['vn_teacher_to'] : "" }}"    
                                            @endif
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
                                <input type="text" class="form-control pe-none" readonly value="--" data-control="vn-teacher-duration"/>
                            </div>
                        </div>
                    </div>
    
                    <label class="fs-6 fw-semibold mb-2" for="start-at">Giảng viên nước ngoài</label>
                    <div class="row mb-4 py-3 d-flex align-items-start" row-control="foreign-teacher">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center" style="padding-top: 1%">
                            <div class="form-outline">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if (isset($weekEventEdit))
                                {{ isset($weekEventEdit['is_foreign_teacher_check']) && 
                                         $weekEventEdit['is_foreign_teacher_check'] && 
                                         $weekEventEdit['is_foreign_teacher_check'] !== "false" && 
                                         $weekEventEdit['is_foreign_teacher_check'] !== "0" 
                                        ? "checked" 
                                        : "" }} 
                                @elseif (isset($weekEventEditInCalendar))
                                {{ isset($weekEventEditInCalendar['is_foreign_teacher_check']) && 
                                         $weekEventEditInCalendar['is_foreign_teacher_check'] && 
                                         $weekEventEditInCalendar['is_foreign_teacher_check'] !== "false" && 
                                         $weekEventEditInCalendar['is_foreign_teacher_check'] !== "0" 
                                        ? "checked" 
                                        : "" }}
                                @else
                                {{ isset($schedule['is_foreign_teacher_check']) ? "checked" : "" }} 
                                @endif
                                name="is_foreign_teacher_check">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $popupUnidId }}" class="form-select form-control " name="foreign_teacher_id"
                                    data-control="select2" data-placeholder="Chọn giảng viên" data-allow-clear="true">
                                    <option value="">Chọn giảng viên</option>
                                    @foreach( App\Models\Teacher::isForeign()->get() as $teacher) {{-- App\Models\Teacher::isForeign()->get() --}}
                                        <option value="{{ $teacher->id }}" 
                                        @if (isset($weekEventEdit))
                                            {{ isset($weekEventEdit['foreign_teacher_id']) && $weekEventEdit['foreign_teacher_id'] == $teacher->id ? "selected" : "" }}
                                        @elseif (isset($weekEventEditInCalendar))
                                            {{ isset($weekEventEditInCalendar['foreign_teacher_id']) && $weekEventEditInCalendar['foreign_teacher_id'] == $teacher->id ? "selected" : "" }}
                                        @else
                                            {{ isset($schedule['foreign_teacher_id']) && $schedule['foreign_teacher_id'] == $teacher->id ? "selected" : "" }}
                                        @endif>
                                            {{ $teacher->name }}
                                        </option>
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['foreign_teacher_from']) ? $weekEventEdit['foreign_teacher_from'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['foreign_teacher_from']) ? $weekEventEditInCalendar['foreign_teacher_from'] : "" }}" 
                                            @else
                                                value="{{ isset($schedule['foreign_teacher_from']) ? $schedule['foreign_teacher_from'] : "" }}"    
                                            @endif
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['foreign_teacher_to']) ? $weekEventEdit['foreign_teacher_to'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['foreign_teacher_to']) ? $weekEventEditInCalendar['foreign_teacher_to'] : "" }}" 
                                            @else
                                                value="{{ isset($schedule['foreign_teacher_to']) ? $schedule['foreign_teacher_to'] : "" }}"    
                                            @endif
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
                                <input type="text" class="form-control pe-none" readonly value="--" data-control="foreign-teacher-duration"/>
                            </div>
                        </div>
                    </div>
    
                    <label class="fs-6 fw-semibold mb-2" for="start-at">Gia sư</label>
                    <div class="row mb-4 py-3 d-flex align-items-start" row-control="tutor">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center" style="padding-top: 1%">
                            <div class="form-outline">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if (isset($weekEventEdit))
                                {{ isset($weekEventEdit['is_tutor_check']) && 
                                         $weekEventEdit['is_tutor_check'] && 
                                         $weekEventEdit['is_tutor_check'] !== "false"&& 
                                         $weekEventEdit['is_tutor_check'] !== "0"
                                        ? "checked" 
                                        : "" }} 
                                @elseif (isset($weekEventEditInCalendar))
                                {{ isset($weekEventEditInCalendar['is_tutor_check']) && 
                                         $weekEventEditInCalendar['is_tutor_check'] && 
                                         $weekEventEditInCalendar['is_tutor_check'] !== "false"&& 
                                         $weekEventEditInCalendar['is_tutor_check'] !== "0"
                                        ? "checked" 
                                        : "" }} 
                                @else
                                {{ isset($schedule['is_tutor_check']) ? "checked" : "" }} 
                                @endif
                                name="is_tutor_check">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $popupUnidId }}" class="form-select form-control " name="tutor_id"
                                    data-control="select2" data-placeholder="Chọn gia sư" data-allow-clear="true">
                                    <option value="">Chọn gia sư</option>
                                    @foreach( App\Models\Teacher::isTutor()->get() as $teacher) {{-- App\Models\Teacher::isTutor()->get() --}}
                                    <option value="{{ $teacher->id }}" 
                                    @if (isset($weekEventEdit))
                                        {{ isset($weekEventEdit['tutor_id']) && $weekEventEdit['tutor_id'] == $teacher->id ? "selected" : "" }}
                                    @elseif (isset($weekEventEditInCalendar))
                                        {{ isset($weekEventEditInCalendar['tutor_id']) && $weekEventEditInCalendar['tutor_id'] == $teacher->id ? "selected" : "" }}
                                    @else
                                        {{ isset($schedule['tutor_id']) && $schedule['tutor_id'] == $teacher->id ? "selected" : "" }}
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['tutor_from']) ? $weekEventEdit['tutor_from'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['tutor_from']) ? $weekEventEditInCalendar['tutor_from'] : "" }}"
                                            @else
                                                value="{{ isset($schedule['tutor_from']) ? $schedule['tutor_from'] : "" }}"    
                                            @endif
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['tutor_to']) ? $weekEventEdit['tutor_to'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['tutor_to']) ? $weekEventEditInCalendar['tutor_to'] : "" }}" 
                                            @else
                                                value="{{ isset($schedule['tutor_to']) ? $schedule['tutor_to'] : "" }}"    
                                            @endif
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
                                <input type="text" class="form-control pe-none" readonly value="--" data-control="tutor-duration"/>
                            </div>
                        </div>
                    </div>
    
                    <div class="d-flex">
                        <label class="fs-6 fw-semibold mb-2" for="start-at">Trợ giảng</label>&nbsp;-&nbsp;
                        <p>Hỗ trợ cho giảng viên Việt Nam và giảng viên nước ngoài.</p>
                    </div>
                
                    <div class="row mb-4 py-3 d-flex align-items-start" row-control="assistant">
                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-center" style="padding-top: 1%">
                            <div class="form-outline">
                                <input class="form-check-input" style="border: 1px solid #000;" type="checkbox" value="checked" 
                                @if (isset($weekEventEdit))
                                {{ isset($weekEventEdit['is_assistant_check']) && 
                                         $weekEventEdit['is_assistant_check'] && 
                                         $weekEventEdit['is_assistant_check'] !== "false" && 
                                         $weekEventEdit['is_assistant_check'] !== "0" 
                                        ? "checked" 
                                        : "" }} 
                                @elseif (isset($weekEventEditInCalendar))
                                {{ isset($weekEventEditInCalendar['is_assistant_check']) && 
                                         $weekEventEditInCalendar['is_assistant_check'] && 
                                         $weekEventEditInCalendar['is_assistant_check'] !== "false" && 
                                         $weekEventEditInCalendar['is_assistant_check'] !== "0" 
                                        ? "checked" 
                                        : "" }} 
                                @else
                                {{ isset($schedule['is_assistant_check']) ? "checked" : "" }} 
                                @endif
                                name="is_assistant_check">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-outline">
                                <select data-dropdown-parent="#{{ $popupUnidId }}" class="form-select form-control" name="assistant_id"
                                    data-control="select2" data-placeholder="Chọn trợ giảng" data-allow-clear="true">
                                    <option value="">Chọn trợ giảng</option>
                                    @foreach( App\Models\Teacher::isAssistantAndAssistantKid()->get() as $teacher) {{-- App\Models\Teacher::isAssistant()->get() --}}
                                    <option value="{{ $teacher->id }}" 
                                    @if (isset($weekEventEdit))
                                        {{ isset($weekEventEdit['assistant_id']) && $weekEventEdit['assistant_id'] == $teacher->id ? "selected" : "" }}
                                    @elseif (isset($weekEventEditInCalendar))
                                        {{ isset($weekEventEditInCalendar['assistant_id']) && $weekEventEditInCalendar['assistant_id'] == $teacher->id ? "selected" : "" }}
                                    @else
                                        {{ isset($schedule['assistant_id']) && $schedule['assistant_id'] == $teacher->id ? "selected" : "" }}
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['assistant_from']) ? $weekEventEdit['assistant_from'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['assistant_from']) ? $weekEventEditInCalendar['assistant_from'] : "" }}" 
                                            @else
                                                value="{{ isset($schedule['assistant_from']) ? $schedule['assistant_from'] : "" }}"    
                                            @endif
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
                                            @if (isset($weekEventEdit))
                                                value="{{ isset($weekEventEdit['assistant_to']) ? $weekEventEdit['assistant_to'] : "" }}" 
                                            @elseif (isset($weekEventEditInCalendar))
                                                value="{{ isset($weekEventEditInCalendar['assistant_to']) ? $weekEventEditInCalendar['assistant_to'] : "" }}"
                                            @else
                                                value="{{ isset($schedule['assistant_to']) ? $schedule['assistant_to'] : "" }}"    
                                            @endif
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
                                <input type="text" class="form-control pe-none" readonly value="--" data-control="assistant-duration"/>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('teaching_errors'))
                    <x-input-error :messages="$errors->get('teaching_errors')[0]" class="mt-2" />
                    @endif
                </div>

                @if (isset($isAddEventInCalendar)) 
                    {{-- hidden --}}
                    <input data-action="study_date" name="study_date" value="{{ isset($studyDate) ? $studyDate : $schedule['study_date']  }}" type="hidden" />
                @elseif (isset($weekEventEditInCalendar))
                    {{-- hidden --}}
                    <input data-action="code" value="{{ $weekEventEditInCalendar['code'] }}" name="code" readonly type="hidden">
                    <input data-action="study_date" value="{{ $weekEventEditInCalendar['study_date'] }}" name="study_date" readonly type="hidden">
                    <input data-action="is_add_later" value="{{ isset($weekEventEditInCalendar['is_add_later']) ? $weekEventEditInCalendar['is_add_later']: '' }}" name="is_add_later" readonly type="hidden">
                @else 
                    {{-- hidden --}}
                    <input data-action="id" value="{{ isset($weekEventEdit) ? $weekEventEdit['id'] : '' }}" type="hidden" name="id" readonly/>

                    {{-- hidden --}}
                    <input data-action="day-name"
                    @if (isset($weekEventEdit))
                        value="{{ $day_name }}"
                    @else
                    value="{{ isset($day_name) ? $day_name : $schedule['day_name'] }}"
                    @endif
                    name="day_name" type="hidden" readonly/>
                @endif

                <div class="row d-flex justify-content-center">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-2 mb-2">
                        <button type="button" popup-control="save" data-action="add-schedule-btn" data-is-edit="false" class="btn btn-primary w-100">Lưu</button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-2 d-none ">
                        <button type="button" popup-control="payrate"  data-action="suggest-teacher" data-is-edit="false" class="btn btn-light ">Tham khảo tỷ lệ lợi nhuận</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        var addScheduleManager;

        $(() => {
            addScheduleManager = new AddScheduleManager({
                container: document.querySelector(`#{{ $uniqId }}`)
            });
            
            SuggestTeacher.init();
        });
    
        var SuggestTeacher = function() {
            return {
                init: function() {
                    document.querySelector('[data-action="suggest-teacher"]').addEventListener('click', e => {
                        e.preventDefault();
                        suggestTeacherPopup.updateUrl(
                            "{{ action('\App\Http\Controllers\Teacher\CourseController@suggestTeacher') }}"
                        );
                    });
                }
            }
        }();

        var AddScheduleManager = class {
            constructor(options) {
                this.container = options.container;

                this.init();
                this.events();
            };

            getContainer() {
                return this.container;
            };

            getForm() {
                return this.getContainer().querySelector('[form-control="addScheduleItemForm"]');
            };

            getSaveDateBtn() {
                return this.getContainer().querySelector('[popup-control="save"]');
            };

            getStartAtInput() {
                return this.getContainer().querySelector('[data-action="start-at-input"]');
            };

            getStartAtValue() {
                return this.getStartAtInput().value;
            };

            getEndAtInput() {
                return this.getContainer().querySelector('[data-action="end-at-input"]');
            };

            getEndAtValue() {
                return this.getEndAtInput().value;
            };

            getDayNameInput() {
                return this.getContainer().querySelector('[data-action="day-name"]');
            };

            getDayNameValue() {
                return this.getDayNameInput().value;
            };

            getVnTeacherFromInput() {
                return this.getContainer().querySelector('[name="vn_teacher_from"]');
            };

            getVnTeacherFromValue() {
                return this.getVnTeacherFromInput().value;
            };

            getVnTeacherToValue() {
                return this.getVnTeacherToInput().value;
            };

            getForeignTeacherFromInput() {
                return this.getContainer().querySelector('[name="foreign_teacher_from"]');
            };

            getForeignTeacherFromValue() {
                return this.getForeignTeacherFromInput().value;
            };

            getForeignTeacherToInput() {
                return this.getContainer().querySelector('[name="foreign_teacher_to"]');
            };

            getForeignTeacherToValue() {
                return this.getForeignTeacherToInput().value;
            };

            getTutorFromInput() {
                return this.getContainer().querySelector('[name="tutor_from"]');
            };

            getTutorFromValue() {
                return this.getTutorFromInput().value;
            };

            getTutorToInput() {
                return this.getContainer().querySelector('[name="tutor_to"]');
            };

            getTutorToValue() {
                return this.getTutorToInput().value;
            };

            getAssistantFromInput() {
                return this.getContainer().querySelector('[name="assistant_from"]');
            };

            getAssistantFromValue() {
                return this.getAssistantFromInput().value;
            };

            getAssistantToInput() {
                return this.getContainer().querySelector('[name="assistant_to"]');
            };

            getAssistantToValue() {
                return this.getAssistantToInput().value;
            };

            getVnTeacherCheckBox() {
                return this.getContainer().querySelector('[name="is_vn_teacher_check"]');
            };

            getVnTeacherRow() {
                return this.getContainer().querySelector('[row-control="vn-teacher"]');
            };

            getVnTeacherInputs() {
                return this.getVnTeacherRow().querySelectorAll('input[type="time"]');
            };

            getVnTeacherSelects() {
                return this.getVnTeacherRow().querySelectorAll('select');
            };

            getForeignTeacherCheckBox() {
                return this.getContainer().querySelector('[name="is_foreign_teacher_check"]');
            };

            getForeignTeacherRow() {
                return this.getContainer().querySelector('[row-control="foreign-teacher"]');
            };

            getForeignTeacherInputs() {
                return this.getForeignTeacherRow().querySelectorAll('input[type="time"]');
            };

            getForeignTeacherSelects() {
                return this.getForeignTeacherRow().querySelectorAll('select');
            };

            getTutorCheckBox() {
                return this.getContainer().querySelector('[name="is_tutor_check"]');
            };

            getTutorRow() {
                return this.getContainer().querySelector('[row-control="tutor"]');
            };

            getTutorInputs() {
                return this.getTutorRow().querySelectorAll('input[type="time"]');
            };

            getTutorSelects() {
                return this.getTutorRow().querySelectorAll('select');
            };

            getAssistantCheckBox() {
                return this.getContainer().querySelector('[name="is_assistant_check"]');
            };

            getAssistantRow() {
                return this.getContainer().querySelector('[row-control="assistant"]');
            };

            getAssistantSelects() {
                return this.getAssistantRow().querySelectorAll('select');
            };

            getVnTeacherIsChecked() {
                return this.getContainer().querySelector('[name="is_vn_teacher_check"]').checked;
            };

            getForeignTeacherIsChecked() {
                return this.getContainer().querySelector('[name="is_foreign_teacher_check"]').checked;
            };

            getTutorIsChecked() {
                return this.getContainer().querySelector('[name="is_tutor_check"]').checked;
            };

            getAssistantIsChecked() {
                return this.getContainer().querySelector('[name="is_assistant_check"]').checked;
            };

            getVnTeacherIdInput() {
                return this.getContainer().querySelector('[name="vn_teacher_id"]');
            };

            getVnTeacherIdValue() {
                return this.getVnTeacherIdInput().value;
            };

            getForeignTeacherIdInput() {
                return this.getContainer().querySelector('[name="foreign_teacher_id"]');
            };

            getForeignTeacherIdValue() {
                return this.getForeignTeacherIdInput().value;
            };

            getTutorIdInput() {
                return this.getContainer().querySelector('[name="tutor_id"]');
            };

            getTutorIdValue() {
                return this.getTutorIdInput().value;
            };

            getAssistantIdInput() {
                return this.getContainer().querySelector('[name="assistant_id"]');
            };

            getAssistantIdValue() {
                return this.getAssistantIdInput().value;
            };

            getVnTeacherFromInput() {
                return this.getContainer().querySelector('[name="vn_teacher_from"]');
            };

            getVnTeacherFromValue() {
                return this.getVnTeacherFromInput().value;
            };

            getVnTeacherToInput() {
                return this.getContainer().querySelector('[name="vn_teacher_to"]');
            };

            getForeignTeacherFromInput() {
                return this.getContainer().querySelector('[name="foreign_teacher_from"]');
            };

            getForeignTeacherFromValue() {
                return this.getForeignTeacherFromInput().value;
            };

            getForeignTeacherToInput() {
                return this.getContainer().querySelector('[name="foreign_teacher_to"]');
            };

            getForeignTeacherToValue() {
                return this.getForeignTeacherToInput().value;
            };

            getTutorFromInput() {
                return this.getContainer().querySelector('[name="tutor_from"]');
            };

            getTutorFromValue() {
                return this.getTutorFromInput().value;
            };

            getTutorToInput() {
                return this.getContainer().querySelector('[name="tutor_to"]');
            };

            getTutorToValue() {
                return this.getTutorToInput().value;
            };

            getAssistantFromInput() {
                return this.getContainer().querySelector('[name="assistant_from"]');
            };

            getAssistantFromValue() {
                return this.getAssistantFromInput().value;
            };

            getAssistantToInput() {
                return this.getContainer().querySelector('[name="assistant_to"]');
            };

            getAssistantToValue() {
                return this.getAssistantToInput().value;
            };

            getSectionDurtionInput() {
                return this.getContainer().querySelector('[data-control="section-duration"]');
            };

            getVnTeacherDurtionInput() {
                return this.getContainer().querySelector('[data-control="vn-teacher-duration"]');
            };

            getForeignTeacherDurtionInput() {
                return this.getContainer().querySelector('[data-control="foreign-teacher-duration"]');
            };

            getTutorDurtionInput() {
                return this.getContainer().querySelector('[data-control="tutor-duration"]');
            };

            getAssistantDurtionInput() {
                return this.getContainer().querySelector('[data-control="assistant-duration"]');
            };

            getIdInput() {
                return this.getContainer().querySelector('[data-action="id"]');
            };

            getIdValue() {
                return this.getIdInput().value;
            };

            getCodeInput() {
                return this.getContainer().querySelector('[data-action="code"]');
            };

            getCodeValue() {
                return this.getCodeInput().value;
            };

            getStudyDateInput() {
                return this.getContainer().querySelector('[data-action="study_date"]');
            };

            getStudyDateValue() {
                return this.getStudyDateInput().value;
            };

            getIsAddLaterInput() {
                return this.getContainer().querySelector('[data-action="is_add_later"]');
            };

            getIsAddLaterValue() {
                return this.getIsAddLaterInput().value;
            };

            getTypeSelect() {
                return this.getContainer().querySelector('[name="type"]');
            };

            getTypeValue() {
                return this.getTypeSelect().value;
            };

            // Method

            highLineVnTeacherRow() {
                this.getVnTeacherRow().classList.add('bg-secondary');
            };

            unHighLineVnTeacherRow() {
                this.getVnTeacherRow().classList.remove('bg-secondary');
            };

            disableAllVnTeacherInputs() {
                this.getVnTeacherInputs().forEach(input => {
                    input.readOnly = true;
                });
            };

            enableAllVnTeacherInputs() {
                this.getVnTeacherInputs().forEach(input => {
                    input.readOnly = false;
                });
            };

            disableAllVnTeacherSelects() {
                this.getVnTeacherSelects().forEach(select => {
                    $(select).select2('destroy');
                    select.classList.add('pe-none');
                });
            };

            enableAllVnTeacherSelects() {
                this.getVnTeacherSelects().forEach(select => {
                    select.classList.remove('pe-none');
                    $(select).select2();
                    $(select).trigger('change');
                });
            };

            disableAllForeignTeacherInputs() {
                this.getForeignTeacherInputs().forEach(input => {
                    input.readOnly = true;
                });
            };

            enableAllForeignTeacherInputs() {
                this.getForeignTeacherInputs().forEach(input => {
                    input.readOnly = false;
                });
            };

            disableAllForeignTeacherSelects() {
                this.getForeignTeacherSelects().forEach(select => {
                    $(select).select2('destroy');
                    select.classList.add('pe-none');
                });
            };

            enableAllForeignTeacherSelects() {
                this.getForeignTeacherSelects().forEach(select => {
                    select.classList.remove('pe-none');
                    $(select).select2();
                    $(select).trigger('change');
                });
            };

            highLineForeignTeacherRow() {
                this.getForeignTeacherRow().classList.add('bg-secondary');
            };

            unHighLineForeignTeacherRow() {
                this.getForeignTeacherRow().classList.remove('bg-secondary');
            };

            disableAllTutorInputs() {
                this.getTutorInputs().forEach(input => {
                    input.readOnly = true;
                });
            };

            enableAllTutorInputs() {
                this.getTutorInputs().forEach(input => {
                    input.readOnly = false;
                });
            };

            disableAllTutorSelects() {
                this.getTutorSelects().forEach(select => {
                    $(select).select2('destroy');
                    select.classList.add('pe-none');
                });
            };

            enableAllTutorSelects() {
                this.getTutorSelects().forEach(select => {
                    select.classList.remove('pe-none');
                    $(select).select2();
                    $(select).trigger('change');
                });
            };

            highLineTutorRow() {
                this.getTutorRow().classList.add('bg-secondary');
            };

            unHighLineTutorRow() {
                this.getTutorRow().classList.remove('bg-secondary');
            };

            disableAllAssistantSelects() {
                this.getAssistantSelects().forEach(select => {
                    $(select).select2('destroy');
                    select.classList.add('pe-none');
                });
            };

            enableAllAssistantSelects() {
                this.getAssistantSelects().forEach(select => {
                    select.classList.remove('pe-none');
                    $(select).select2();
                    $(select).trigger('change');
                });
            };

            highLineAssistantRow() {
                this.getAssistantRow().classList.add('bg-secondary');
            };

            unHighLineAssistantRow() {
                this.getAssistantRow().classList.remove('bg-secondary');
            };
            
            getData() {
                return {
                    start_at: this.getStartAtValue(),
                    end_at: this.getEndAtValue(),
                    day_name: this.getDayNameValue(),
                    type: this.getTypeValue(),

                    is_vn_teacher_check: this.getVnTeacherIsChecked(),
                    vn_teacher_id: this.getVnTeacherIdValue(),
                    vn_teacher_from: this.getVnTeacherFromValue(),
                    vn_teacher_to: this.getVnTeacherToValue(),

                    is_foreign_teacher_check: this.getForeignTeacherIsChecked(),
                    foreign_teacher_id: this.getForeignTeacherIdValue(),
                    foreign_teacher_from: this.getForeignTeacherFromValue(),
                    foreign_teacher_to: this.getForeignTeacherToValue(),

                    is_tutor_check: this.getTutorIsChecked(),
                    tutor_id: this.getTutorIdValue(),
                    tutor_from: this.getTutorFromValue(),
                    tutor_to: this.getTutorToValue(),

                    is_assistant_check: this.getAssistantIsChecked(),
                    assistant_id: this.getAssistantIdValue(),
                    assistant_from: this.getAssistantFromValue(),
                    assistant_to: this.getAssistantToValue(),

                    code: Date.now().toString(36) + Math.random().toString(36).substr(2, 5),
                };
            };

            getDataEdit() {
                return {
                    start_at: this.getStartAtValue(),
                    end_at: this.getEndAtValue(),
                    day_name: this.getDayNameValue(),
                    id: this.getIdValue(),
                    type: this.getTypeValue(),

                    is_vn_teacher_check: this.getVnTeacherIsChecked(),
                    vn_teacher_id: this.getVnTeacherIdValue(),
                    vn_teacher_from: this.getVnTeacherFromValue(),
                    vn_teacher_to: this.getVnTeacherToValue(),

                    is_foreign_teacher_check: this.getForeignTeacherIsChecked(),
                    foreign_teacher_id: this.getForeignTeacherIdValue(),
                    foreign_teacher_from: this.getForeignTeacherFromValue(),
                    foreign_teacher_to: this.getForeignTeacherToValue(),

                    is_tutor_check: this.getTutorIsChecked(),
                    tutor_id: this.getTutorIdValue(),
                    tutor_from: this.getTutorFromValue(),
                    tutor_to: this.getTutorToValue(),

                    is_assistant_check: this.getAssistantIsChecked(),
                    assistant_id: this.getAssistantIdValue(),
                    assistant_from: this.getAssistantFromValue(),
                    assistant_to: this.getAssistantToValue(),

                    code: Date.now().toString(36) + Math.random().toString(36).substr(2, 5),
                };
            };

            getDataCreateEventInCalendar() {
                const studyDateTime = this.getStudyDateValue();
                const parts = studyDateTime.split(" ");
                const datePart = parts[0];

                return {
                    start_at: this.getStartAtValue() && this.getStartAtValue() !== "" ? datePart + " " + this.getStartAtValue() : this.getStartAtValue(),
                    end_at: this.getEndAtValue() && this.getEndAtValue() !== "" ? datePart + " " + this.getEndAtValue() : this.getEndAtValue(),
                    study_date: this.getStudyDateValue(),
                    code: Date.now().toString(36) + Math.random().toString(36).substr(2, 5),
                    is_add_later: true,
                    type: this.getTypeValue(),

                    is_vn_teacher_check: this.getVnTeacherIsChecked(),
                    vn_teacher_id: parseInt(this.getVnTeacherIdValue()),
                    vn_teacher_from: this.getVnTeacherFromValue(),
                    vn_teacher_to: this.getVnTeacherToValue(),

                    is_foreign_teacher_check: this.getForeignTeacherIsChecked(),
                    foreign_teacher_id: parseInt(this.getForeignTeacherIdValue()),
                    foreign_teacher_from: this.getForeignTeacherFromValue(),
                    foreign_teacher_to: this.getForeignTeacherToValue(),

                    is_tutor_check: this.getTutorIsChecked(),
                    tutor_id: parseInt(this.getTutorIdValue()),
                    tutor_from: this.getTutorFromValue(),
                    tutor_to: this.getTutorToValue(),

                    is_assistant_check: this.getAssistantIsChecked(),
                    assistant_id: parseInt(this.getAssistantIdValue()),
                    assistant_from: this.getAssistantFromValue(),
                    assistant_to: this.getAssistantToValue(),
                };
            };

            getDataEditedInCalendar() {
                const studyDateTime = this.getStudyDateValue();
                const parts = studyDateTime.split(" ");
                const datePart = parts[0];

                return {
                    start_at: this.getStartAtValue() && this.getStartAtValue() !== "" ? datePart + " " + this.getStartAtValue() : this.getStartAtValue(),
                    end_at: this.getEndAtValue() && this.getEndAtValue() !== "" ? datePart + " " + this.getEndAtValue() : this.getEndAtValue(),
                    code: this.getCodeValue(),
                    study_date: this.getStudyDateValue(),
                    is_add_later: this.getIsAddLaterValue(),
                    type: this.getTypeValue(),

                    is_vn_teacher_check: this.getVnTeacherIsChecked(),
                    vn_teacher_id: parseInt(this.getVnTeacherIdValue()),
                    vn_teacher_from: this.getVnTeacherFromValue(),
                    vn_teacher_to: this.getVnTeacherToValue(),

                    is_foreign_teacher_check: this.getForeignTeacherIsChecked(),
                    foreign_teacher_id: parseInt(this.getForeignTeacherIdValue()),
                    foreign_teacher_from: this.getForeignTeacherFromValue(),
                    foreign_teacher_to: this.getForeignTeacherToValue(),

                    is_tutor_check: this.getTutorIsChecked(),
                    tutor_id: parseInt(this.getTutorIdValue()),
                    tutor_from: this.getTutorFromValue(),
                    tutor_to: this.getTutorToValue(),

                    is_assistant_check: this.getAssistantIsChecked(),
                    assistant_id: parseInt(this.getAssistantIdValue()),
                    assistant_from: this.getAssistantFromValue(),
                    assistant_to: this.getAssistantToValue(),
                };
            };

            init() {
                this.handleCheck();
                this.displayInformations();
            };

            handleCheck() {
                this.handleCheckVnTeacher();
                this.handleCheckForeignTeacher();
                this.handleCheckTutor();
                this.handleCheckAssistant();
            };

            displayInformations() {
                this.displaySectionDuration();
                this.displayVnTeacherDuration();
                this.displayForeignTeacherDuration();
                this.displayTutorDuration();
                this.displayAssistantDuration();
            } ;

            handleCheckVnTeacher() {
                if(this.getVnTeacherCheckBox().checked) {
                    this.enableAllVnTeacherInputs();
                    this.enableAllVnTeacherSelects();
                    this.unHighLineVnTeacherRow();
                    this.getVnTeacherFromInput().value = this.getStartAtValue();
                    this.getVnTeacherToInput().value = this.getEndAtValue();
                } else {
                    this.disableAllVnTeacherInputs();
                    this.disableAllVnTeacherSelects();
                    this.highLineVnTeacherRow();
                    this.getVnTeacherFromInput().value = null;
                    this.getVnTeacherToInput().value = null;
                };

                this.displayVnTeacherDuration();
                // this.changeAssistantTimes();
            };

            handleCheckForeignTeacher() {
                if(this.getForeignTeacherCheckBox().checked) {
                    this.enableAllForeignTeacherInputs();
                    this.enableAllForeignTeacherSelects();
                    this.unHighLineForeignTeacherRow();
                    this.getForeignTeacherFromInput().value = this.getStartAtValue();
                    this.getForeignTeacherToInput().value = this.getEndAtValue();
                } else {
                    this.disableAllForeignTeacherInputs();
                    this.disableAllForeignTeacherSelects();
                    this.highLineForeignTeacherRow();
                    this.getForeignTeacherFromInput().value = null;
                    this.getForeignTeacherToInput().value = null;
                };

                this.displayForeignTeacherDuration();
                // this.changeAssistantTimes();
            };

            handleCheckTutor() {
                if(this.getTutorCheckBox().checked) {
                    this.enableAllTutorInputs();
                    this.enableAllTutorSelects();
                    this.unHighLineTutorRow();
                    this.getTutorFromInput().value = this.getStartAtValue();
                    this.getTutorToInput().value = this.getEndAtValue();
                    
                } else {
                    this.disableAllTutorInputs();
                    this.disableAllTutorSelects();
                    this.highLineTutorRow();
                    this.getTutorFromInput().value = null;
                    this.getTutorToInput().value = null;
                }

                this.displayTutorDuration();
            };

            handleCheckAssistant() {
                if(this.getAssistantCheckBox().checked) {
                    this.enableAllAssistantSelects();
                    this.unHighLineAssistantRow();
                    this.getAssistantFromInput().value = this.getStartAtValue();
                    this.getAssistantToInput().value = this.getEndAtValue();
                } else {
                    this.disableAllAssistantSelects();
                    this.highLineAssistantRow();
                    this.getAssistantFromInput().value = null;
                    this.getAssistantToInput().value = null;
                };

                this.displayAssistantDuration();
            };

            /**
             * Call (Show assistant time information) when:
             *      + Check assistant.
             *      + Check VN teacher.
             *      + Check Foreign teacher.
             *      + Change from - to VN teacher.
             *      + Change from - to Foreign teacher.
             * @return void
             */
            changeAssistantTimes() {
                if(this.validateToChangeAssistantTimes()) {
                    this.displayAssistantFrom();
                    this.displayAssistantTo();
                    this.displayAssistantDuration();
                } else {
                    this.hideAssistantFrom();  
                    this.hideAssistantTo();  
                    this.hideAssistantDuration();  
                };
            };

            caculateDifferenceInMinutes(startAt, endAt) {
                if(startAt && endAt) {
                    const startDate = new Date("2023-12-21 " + startAt);
                    const endDate = new Date("2023-12-21 " + endAt);
                    const startTimestamp = startDate.getTime();
                    const endTimestamp = endDate.getTime();
                    const differenceInMinutes = (endTimestamp - startTimestamp) / (1000 * 60);
    
                    return differenceInMinutes;
                } else {
                    return 0;
                }
            };

            caculateSectionDuration() {
                const startAt = this.getStartAtValue();
                const endAt = this.getEndAtValue();

                return this.caculateDifferenceInMinutes(startAt, endAt);
            };

            caculateVnTeacherDuration() {
                if(this.getVnTeacherCheckBox().checked) {
                    const startAt = this.getVnTeacherFromValue();
                    const endAt = this.getVnTeacherToValue();
    
                    return this.caculateDifferenceInMinutes(startAt, endAt);
                } else {
                    return 0;
                };
            };

            caculateForeignTeacherDuration() {
                if(this.getForeignTeacherCheckBox().checked) {
                    const startAt = this.getForeignTeacherFromValue();
                    const endAt = this.getForeignTeacherToValue();
    
                    return this.caculateDifferenceInMinutes(startAt, endAt);
                } else {
                    return 0;
                };
            };

            caculateTutorDuration() {
                const startAt = this.getTutorFromValue();
                const endAt = this.getTutorToValue();

                return this.caculateDifferenceInMinutes(startAt, endAt);
            };

            caculateAssistantDuration() {
                const startAt = this.getAssistantFromValue();
                const endAt = this.getAssistantToValue();

                return this.caculateDifferenceInMinutes(startAt, endAt);
            };

            createContentDurationDisplay(durationMinutes) {
                let displayValue;

                if(durationMinutes > 0) {
                    const totalHours = Math.floor(durationMinutes / 60);
                    const minutes = durationMinutes % 60; 

                    displayValue = `${totalHours} giờ ${minutes} phút`;
                } else {
                    displayValue = '--';
                };

                return displayValue;
            };

            displaySectionDuration() {
                const totalMinutes = this.caculateSectionDuration();

                this.getSectionDurtionInput().value = this.createContentDurationDisplay(totalMinutes);
            };

            displayVnTeacherDuration() {
                const totalMinutes = this.caculateVnTeacherDuration();

                this.getVnTeacherDurtionInput().value = this.createContentDurationDisplay(totalMinutes);
            };

            displayForeignTeacherDuration() {
                const totalMinutes = this.caculateForeignTeacherDuration();

                this.getForeignTeacherDurtionInput().value = this.createContentDurationDisplay(totalMinutes);
            };

            /**
             * Condition to show the total times of assistant -> boolean
             * When:
             *      - Click check assistant
             * Show: Total times of VN teacher & Foreign teacher
             */
            validateToChangeAssistantTimes() {
                if(!this.caculateVnTeacherDuration() && !this.caculateForeignTeacherDuration()) {
                    return false;
                };

                if(!this.caculateForeignTeacherDuration() 
                    && this.caculateVnTeacherDuration() 
                    && this.caculateVnTeacherDuration() <= 0) {
                    return false;
                };

                if(!this.caculateVnTeacherDuration() 
                    && this.caculateForeignTeacherDuration() 
                    && this.caculateForeignTeacherDuration() <= 0) {
                    return false;
                };

                if(!this.getAssistantCheckBox().checked) {
                    return false;
                };

                if(!this.getVnTeacherCheckBox().checked && !this.getForeignTeacherCheckBox().checked) {
                    return false;
                };

                if(this.getVnTeacherCheckBox().checked 
                    && !this.getForeignTeacherCheckBox().checked 
                    && this.caculateVnTeacherDuration() <= 0) {
                    return false;
                };

                if(this.getForeignTeacherCheckBox().checked 
                    && !this.getVnTeacherCheckBox().checked 
                    && this.caculateForeignTeacherDuration() <= 0) {
                    return false;
                };

                return true;
            };

            displayTutorDuration() {
                const totalMinutes = this.caculateTutorDuration();

                this.getTutorDurtionInput().value = this.createContentDurationDisplay(totalMinutes);
            };

            displayAssistantDuration() {
                const totalMinutes = this.caculateAssistantDuration();

                this.getAssistantDurtionInput().value = this.createContentDurationDisplay(totalMinutes);
            };

            hideAssistantFrom() {
                this.getAssistantFromInput().value = '';
            };

            hideAssistantTo() {
                this.getAssistantToInput().value = '';
            };

            hideAssistantDuration() {
                this.getAssistantDurtionInput().value = '--';
            };

            getAllTeacherStartTeachingTimes() {
                const times = [];

                if(this.getVnTeacherCheckBox().checked) {
                    times.push(this.getVnTeacherFromValue());
                };

                if(this.getForeignTeacherCheckBox().checked) {
                    times.push(this.getForeignTeacherFromValue());
                };

                return times;
            };

            getAllTeacherEndTeachingTimes() {
                const times = [];

                if(this.getVnTeacherCheckBox().checked) {
                    times.push(this.getVnTeacherToValue());
                };

                if(this.getForeignTeacherCheckBox().checked) {
                    times.push(this.getForeignTeacherToValue());
                };

                return times;
            };

            findEarliestTeacherFromTimeForAssistant() {
                // assistantFrom = earliest start time of vnTeacher & foreignTeacher -> MIN
                const allTeacherStartTeachingTimes = this.getAllTeacherStartTeachingTimes();

                // Validate time array 
                // Filter by regex to find time match 'HH:mm' format
                const validStartTimes = allTeacherStartTeachingTimes.filter(time => /^([01]\d|2[0-3]):[0-5]\d$/.test(time)); 

                if(validStartTimes.length <= 0) {
                    return null;
                };

                // Convert time to minutes to compare
                const allTeacherStartTeachingTimesInMinutes = validStartTimes.map(startTime => {
                    const [hours, minutes] = startTime.split(':');
                    return parseInt(hours) * 60 + parseInt(minutes);
                });

                // Find min minutes -> earliest time
                const earliestStartTimeInMinutes = Math.min(...allTeacherStartTeachingTimesInMinutes); 
                // Convert back to time format 'HH:mm'
                const earliestStartTime = `${String(Math.floor(earliestStartTimeInMinutes / 60)).padStart(2, '0')}:${String(earliestStartTimeInMinutes % 60).padStart(2, '0')}`;

                return earliestStartTime;
            };

            findLatestTeacherFromTimeForAssistant() {
                // assistantFrom = latest end time of vnTeacher & foreignTeacher -> MAX
                const allTeacherStartTeachingTimes = this.getAllTeacherEndTeachingTimes();

                // Validate time array 
                // Filter by regex to find time match 'HH:mm' format
                const validStartTimes = allTeacherStartTeachingTimes.filter(time => /^([01]\d|2[0-3]):[0-5]\d$/.test(time)); 

                if(validStartTimes.length <= 0) {
                    return null;
                };

                // Convert time to minutes to compare
                const allTeacherEndTeachingTimesInMinutes = validStartTimes.map(endTime => {
                    const [hours, minutes] = endTime.split(':');
                    return parseInt(hours) * 60 + parseInt(minutes);
                });

                // Find min minutes -> latest time
                const latestStartTimeInMinutes = Math.max(...allTeacherEndTeachingTimesInMinutes); 
                // Convert back to time format 'HH:mm'
                const latestStartTime = `${String(Math.floor(latestStartTimeInMinutes / 60)).padStart(2, '0')}:${String(latestStartTimeInMinutes % 60).padStart(2, '0')}`;

                return latestStartTime;
            };

            displayAssistantFrom() {
                let fromValue = '';
                
                if(this.findEarliestTeacherFromTimeForAssistant()) {
                    fromValue = this.findEarliestTeacherFromTimeForAssistant();
                };

                this.getAssistantFromInput().value = fromValue;
            };

            displayAssistantTo() {
                let toValue = '';
                
                if(this.findLatestTeacherFromTimeForAssistant()) {
                    toValue = this.findLatestTeacherFromTimeForAssistant();
                };

                this.getAssistantToInput().value = toValue;
            };

            displayAssistantDuration() {
                // Total times of assistant = VN teacher times + Foreign teacher times
                const totalMinutes = this.caculateVnTeacherDuration() + this.caculateForeignTeacherDuration();

                this.getAssistantDurtionInput().value = this.createContentDurationDisplay(totalMinutes);
            };

            operationSuccessHandle() {
                addSchedulePopup.hide();
                timeAutoCaculatForm.run();
            };

            changeOriginDuration() {
                if (this.getVnTeacherCheckBox().checked) {
                    this.getVnTeacherFromInput().value = this.getStartAtValue();
                    this.getVnTeacherToInput().value = this.getEndAtValue();
                } else {
                    this.getVnTeacherFromInput().value = null;
                    this.getVnTeacherToInput().value = null;
                }

                if (this.getForeignTeacherCheckBox().checked) {
                    this.getForeignTeacherFromInput().value = this.getStartAtValue();
                    this.getForeignTeacherToInput().value = this.getEndAtValue();
                } else {
                    this.getForeignTeacherFromInput().value = null;
                    this.getForeignTeacherToInput().value = null;
                }

                if (this.getTutorCheckBox().checked) {
                    this.getTutorFromInput().value = this.getStartAtValue();
                    this.getTutorToInput().value = this.getEndAtValue();
                } else {
                    this.getTutorFromInput().value = null;
                    this.getTutorToInput().value = null;
                }

                if (this.getAssistantCheckBox().checked) {
                    this.getAssistantFromInput().value = this.getStartAtValue();
                    this.getAssistantToInput().value = this.getEndAtValue();
                } else {
                    this.getAssistantFromInput().value = null;
                    this.getAssistantToInput().value = null;
                }

                this.displayVnTeacherDuration();
                this.displayForeignTeacherDuration();
                this.displayTutorDuration();
                this.displayAssistantDuration();
            }

            events() {
                const _this = this;

                $(this.getSaveDateBtn()).on('click', function(e) {
                    const data = $(_this.getForm()).serialize();
                    const url = _this.getForm().getAttribute('action');

                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        ASTool.addPageLoadingEffect();     

                        @if(isset($weekEventEdit))
                            // Edit event in week schedule
                            _this.operationSuccessHandle();
                            
                            weekScheduleTool.updateEvent(_this.getDataEdit());

                            ASTool.alert({
                                message: "Sửa lịch thành công!",
                            });
                        @elseif(isset($isAddEventInCalendar))
                            // Add event in calendar
                            _this.operationSuccessHandle();
                            
                            calendar.addEvent(_this.getDataCreateEventInCalendar());

                            ASTool.alert({
                                message: "Thêm lịch trực tiếp thành công!",
                            });
                        @elseif(isset($weekEventEditInCalendar))
                            // Edit event in calendar
                            _this.operationSuccessHandle();

                            calendar.editEvent(_this.getDataEditedInCalendar());

                            ASTool.alert({
                                message: "Sửa lịch trực tiếp thành công!",
                            });
                        @else
                            // Add week schedule item
                            // Thêm 1 lịch trình trong thời khóa biểu
                            // => Chỉ cập nhật, render lại thời khóa biểu (Form cấu hình bên trái) (không render lại form lịch bên phải)
                            if(!weekScheduleTool.validateTimeConflict(_this.getData())) {
                                _this.operationSuccessHandle();

                                weekScheduleTool.saveNewWeekEvent(_this.getData());
                                
                                ASTool.alert({
                                    message: "Thêm lịch thành công!",
                                });
                            } else {
                                ASTool.alert({
                                    icon: 'warning',
                                    message: "Đã có buổi học khác đang học trong thời gian này, vui lòng kiểm tra kỹ hơn và chọn thời gian khác!",
                                });
                            };
                            @endif

                        timeAutoCaculatForm.run(); // Update staff times duration
                        ASTool.removePageLoadingEffect();
                    }).fail(response => {
                        let errorsContent = $(response.responseText).find('[form-control="addScheduleItemForm"]');
                        
                        $(_this.getContainer()).html(errorsContent[0]);     
                        
                        if($(_this.getContainer())[0]) {
                            initJs($(_this.getContainer())[0]);
                        };

                        _this.init();
                        _this.events();
                    })
                });

                $(this.getStartAtInput()).on('change', function(e) {
                    _this.changeOriginDuration();
                    e.preventDefault();
                });

                $(this.getEndAtInput()).on('change', function(e) {
                    _this.changeOriginDuration();
                    e.preventDefault();
                });

                $(this.getVnTeacherCheckBox()).on('change', function(e) {
                    e.preventDefault();
                    _this.handleCheckVnTeacher();
                });

                $(this.getForeignTeacherCheckBox()).on('change', function(e) {
                    e.preventDefault();
                    _this.handleCheckForeignTeacher();
                });

                $(this.getTutorCheckBox()).on('change', function(e) {
                    e.preventDefault();
                    _this.handleCheckTutor();
                });

                $(this.getAssistantCheckBox()).on('change', function(e) {
                    e.preventDefault();
                    _this.handleCheckAssistant();
                });

                $(this.getStartAtInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displaySectionDuration();
                });

                $(this.getEndAtInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displaySectionDuration();
                });

                $(this.getVnTeacherFromInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displayVnTeacherDuration();
                    // _this.changeAssistantTimes();
                });

                $(this.getVnTeacherToInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displayVnTeacherDuration();
                    // _this.changeAssistantTimes();
                });

                $(this.getForeignTeacherFromInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displayForeignTeacherDuration();
                    // _this.changeAssistantTimes();
                });

                $(this.getForeignTeacherToInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displayForeignTeacherDuration();
                    // _this.changeAssistantTimes();
                });

                $(this.getTutorFromInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displayTutorDuration();
                });

                $(this.getTutorToInput()).on('change', function(e) {
                    e.preventDefault();
                    _this.displayTutorDuration();
                });
            };
        }
    </script>
@endsection
