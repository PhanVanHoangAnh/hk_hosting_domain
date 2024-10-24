@extends('layouts.main.popup')

    @section('title')
        Tham khảo tỷ lệ lợi nhuận
    @endsection

    @php
        $formId = 'F' . uniqid();
    @endphp

    @section('content')
    <form id="{{ $formId }}" class="mb-10">
        @csrf
        <div class="scroll-y pe-7 py-10 px-lg-17">
            <div class="row g-9 mb-7">
                <!--begin::Col-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Môn học</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select form-control" data-placeholder="Chọn môn học" list-action="subject-select"
                            data-allow-clear="true" data-control="select2" name="subject_id" data-dropdown-parent="#{{ $formId }}" required>
                        <option value="">Chọn môn học</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}"> {{ $subject->name }} - {{ $subject->type }}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                </div>
            </div>
            <div class="card px-5 py-5 table-responsive">
                <!--begin::Table-->
                <div class="table-responsive table-head-sticky">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="min-w-125px text-left">Giảng viên</th>
                            <th class="min-w-125px text-left">Giờ dạy Việt Nam</th>
                            <th class="min-w-125px text-left">Giờ dạy nước ngoài</th>
                            <th class="min-w-125px text-left">Giờ dạy gia sư</th>
                            <th class="min-w-125px text-left">Chọn giảng viên</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600" list-action="teacher-list">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(() => {
            new SectionBox({
                url: '{{ action('\App\Http\Controllers\Abroad\CourseController@getPayrateTeachers') }}',
                getSubjectSelectBox: function () {
                    return $('[list-action="subject-select"]');
                },
                getTeacherList: function () {
                    return $('[list-action="teacher-list"]');
                },
                getTableContainer: function () {
                    return $('.card.table-responsive');
                },
            });
        });
    
        var SectionBox = class {
            constructor(options) {
                this.url = options.url;
                this.getSubjectSelectBox = options.getSubjectSelectBox;
                this.getTeacherList = options.getTeacherList;
                this.getTableContainer = options.getTableContainer;
                this.events();
                this.render(); 
            }
    
            events() {
                this.getSubjectSelectBox().on('change', () => {
                    this.render();
                });
            }
    
            render() {
                const subjectId = this.getSubjectSelectBox().val();
                const teacherList = this.getTeacherList();
                const tableContainer = this.getTableContainer();
    
                if (!subjectId) {
                    teacherList.html('');
                    tableContainer.addClass('d-none'); 
                    return;
                }
    
                $.ajax({
                    url: this.url,
                    type: 'GET',
                    data: {
                        subject_id: subjectId,
                    },
                }).done((response) => {
                    teacherList.html('');
                    tableContainer.removeClass('d-none'); 
    
                    response.forEach((teacher) => {
                        const formattedVnTeachingHour = formatNumber(teacher.vn_teaching_hour);
                        const formattedForeignTeachingHour = formatNumber(teacher.foreign_teaching_hour);
                        const formattedTutorTeachingHour = formatNumber(teacher.tutor_teaching_hour);

                        const row = `
                            <tr>
                                <td class="text-left">${teacher.name}</td>
                                <td class="text-left">${formattedVnTeachingHour}</td>
                                <td class="text-left">${formattedForeignTeachingHour}</td>
                                <td class="text-left">${formattedTutorTeachingHour}</td>
                                <td class="ps-1">
                                    <div class="text-center">
                                        <input list-action="check-item" name="checkbox-amount" class="form-check-input"
                                            data-expense-class="expense"
                                            type="checkbox" value="${teacher.total_amount}" />
                                    </div>
                                </td>
                            </tr>`;
                        teacherList.append(row);
                    });
                });
            }
        };
        function formatNumber(value) {
            if (value === '--') return '--';

            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0,
            }).format(value);
        }
    </script>
    
@endsection