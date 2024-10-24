@extends('layouts.main.popup')

@section('title')
    Yêu cầu chuyển phí
@endsection

@php
    $transferId = 'transferClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $transferId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\StudentController@transferSave') }}"
            method="post">
            @csrf
            <div class="py-10">

                <input type="hidden" name="studentId" value="{{ $student->id }}">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('edu.students.transfer_form', [
                            'formId' => $transferId,
                            'student' => $student,
                            'currentCourse' => $currentCourse,
                        ])
                    </div>
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
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
            </div>
        </form>
    </div>
    <script>
        var transferManager;

        $(() => {
            transferClassManager = new TransferManager({
                container: document.querySelector('#{{ $transferId }}')
            })
        });

        var TransferManager = class {
            constructor(options) {
                this.container = options.container;

                this.events();
            };

            getContainer() {
                return this.container;
            };

            getForm() {
                return this.getContainer().querySelector('[data-action="form"]');
            };

            hasSelectedStudent() {
                const selectedStudent = this.getContainer().querySelector('[form-control="contact-select"]').value;

                return selectedStudent !== '';
            }

            hasCheckCourse() {
                return $('input[name="current_course_id"]:checked').length > 0;
            }

            hasCheckOrderItem() {
                return $('input[name="order_item_id"]:checked').length > 0;
            }

            hasSelectedReserveStartAt() {
                const selectedStudent = this.getContainer().querySelector('[id="reserve_start_at"]').value;
                
                return selectedStudent !== '';
            }

            hasInputreason() {
                const selectedStudent = this.getContainer().querySelector('[name="reason"]').value;
                
                return selectedStudent !== '';
            }

            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');

                errorContainer.style.display = 'none';
            }

            events() {
                const _this = this;

                _this.getForm().addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!_this.hasSelectedStudent()) {
                        const errorContainer = document.getElementById('error-message');

                        errorContainer.textContent = 'Vui lòng chọn học viên.';
                        errorContainer.style.display = 'block';

                        return;
                    }

                    if (!_this.hasSelectedReserveStartAt()) {
                        const errorContainer = document.getElementById('error-message');

                        errorContainer.textContent = 'Vui lòng chọn ngày yêu cầu chuyển phí!';
                        errorContainer.style.display = 'block';

                        return;
                    }

                    if (!_this.hasCheckOrderItem()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent = 'Vui lòng chọn dịch vụ để yêu cầu chuyển phí!';
                        errorContainer.style.display = 'block';

                        return;
                    }

                    if (!_this.hasInputreason()) {
                        const errorContainer = document.getElementById('error-message');

                        errorContainer.textContent = 'Vui lòng nhập lý do chuyển phí!';
                        errorContainer.style.display = 'block';

                        return;
                    }

                    const url = _this.getForm().getAttribute('action');
                    const data = $(_this.getForm()).serializeArray();
                  
                    const subject = $('#subject-create-select').val();
                    



                    const levelCreateSelect = $('#level-create-select').val();
                    const classType = $('#class-type').val();
                    const homeRoomTeacherSelect = $('#home-room-teacher-select').val();
                    const studentNumsInput = $('#student-nums-input').val();
                    const studyTypeSelect = $('#study-type-select').val();

                    const branchSelect = $('#branch-select').val();
                    const trainingLocation = $('select[name="training_location_id"]').val();
                    const orderTypeValue = $('select[name="subject_type"]').val();

                    const targetInput = $('#target-input').val();

                    const numOfVnTeacherSections = $('input[name="num_of_vn_teacher_sections"]').val();
                    const vietnam_teacher_minutes_per_section =  $('input[name="vietnam_teacher_minutes_per_section"]').val();
                    const vn_teacher_price = $('input[name="vn_teacher_price"]').val();


                    const num_of_foreign_teacher_sections = $('input[name="num_of_foreign_teacher_sections"]').val();
                    const foreign_teacher_minutes_per_section = $('input[name="foreign_teacher_minutes_per_section"]').val();
                    const foreign_teacher_price = $('input[name="foreign_teacher_price"]').val();
                   
                   
                    const num_of_tutor_sections = $('input[name="num_of_tutor_sections"]').val();
                    const tutor_minutes_per_section = $('input[name="tutor_minutes_per_section"]').val();
                    const tutor_price = $('input[name="tutor_price"]').val(); 
                   
                    // if (!orderTypeValue) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn loại hình đào tạo!';
                    //     errorContainer.style.display = 'block';
                        
                    //     return;
                    // }

                    // if (!subject) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn môn học!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    // if (!levelCreateSelect) {
                    //     const errorContainer = document.getElementById('error-message');
                        
                    //     errorContainer.textContent = 'Vui lòng chọn trình độ!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    // if (!classType) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn loại hình lớp!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    // if (!homeRoomTeacherSelect) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn chủ nhiệm đề xuất!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    // if (!studentNumsInput) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn số học sinh!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    // if (!studyTypeSelect) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn hình thức học!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    // if (!branchSelect) {
                    //     const errorContainer = document.getElementById('error-message');

                    //     errorContainer.textContent = 'Vui lòng chọn chi nhánh đào tạo!';
                    //     errorContainer.style.display = 'block';

                    //     return;
                    // }

                    data.push({
                        name: 'order_type',
                        value: orderTypeValue
                    });

                    data.push({
                        name: 'subject',
                        value: subject
                    });

                    data.push({
                        name: 'level_create_select',
                        value: levelCreateSelect
                    });

                    data.push({
                        name: 'class_type',
                        value: classType
                    });

                    data.push({
                        name: 'home_room_teacher_select',
                        value: homeRoomTeacherSelect
                    });

                    data.push({
                        name: 'student_nums_input',
                        value: studentNumsInput
                    });

                    data.push({
                        name: 'study_type_select',
                        value: studyTypeSelect
                    });

                    data.push({
                        name: 'branch_select',
                        value: branchSelect
                    });
                    data.push({
                        name: 'training_location',
                        value: trainingLocation
                    });
                    

                    data.push({
                        name: 'target_input',
                        value: targetInput
                    });

                    data.push({
                        name: 'num_of_vn_teacher_sections',
                        value: numOfVnTeacherSections
                    });

                    data.push({
                        name: 'vietnam_teacher_minutes_per_section',
                        value: vietnam_teacher_minutes_per_section
                    });
                    
                    data.push({
                        name: 'vn_teacher_price',
                        value: vn_teacher_price
                    });

                    //
                    data.push({
                        name: 'num_of_foreign_teacher_sections',
                        value: num_of_foreign_teacher_sections
                    });

                    data.push({
                        name: 'foreign_teacher_minutes_per_section',
                        value: foreign_teacher_minutes_per_section
                    });

                    data.push({
                        name: 'foreign_teacher_price',
                        value: foreign_teacher_price
                    });

                    ///
                    data.push({
                        name: 'num_of_tutor_sections',
                        value: num_of_tutor_sections
                    });

                    data.push({
                        name: 'tutor_minutes_per_section',
                        value: tutor_minutes_per_section
                    });

                    data.push({
                        name: 'tutor_price',
                        value: tutor_price
                    });

                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        UpdateContactPopup.getPopup().hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                if (typeof ContactsList !== 'undefined' &&
                                    ContactsList && typeof ContactsList.getList === 'function') {
                                    ContactsList.getList().load();
                                }

                                if (typeof StaffsList !== 'undefined' &&
                                    StaffsList && typeof StaffsList.getList ===
                                    'function') {
                                    StaffsList.getList().load();
                                }
                            }
                        });
                    }).fail(response => {
                        if (response.responseJSON && response.responseJSON.message) {
                            const errorMessage = response.responseJSON.message;
                            const errorContainer = document.getElementById('error-message');

                            // Hiển thị thông báo lỗi và hiển thị phần tử chứa thông báo lên giao diện
                            errorContainer.textContent = errorMessage;
                            errorContainer.style.display = 'block';
                        } else {
                            throw new Error('Không có thông báo lỗi được trả về từ server.');
                        }
                    })
                });
            };
        };
    </script>
@endsection
