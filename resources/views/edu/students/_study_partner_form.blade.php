@php
    $contactId = uniqid();
@endphp
<div class="mb-10">
    <div class="col-12">
        @if ($section->count())
            <label for="" class="form-label fw-semibold">Buổi học muốn học bù</label>
            <div class="table-responsive">
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th style="width:1%"></th>
                            <th class="text-nowrap text-white">Ngày học</th>
                            <th class="text-nowrap text-white">Thời gian</th>
                            <th class="text-nowrap text-white">Trạng thái</th>
                            <th class="text-nowrap text-white">Chủ nhiệm</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                            <td>
                                <label class="form-check form-check-custom form-check-solid">

                                    <input list-action="check-item" name="section_student_id" class="form-check-input"
                                        type="radio" value="{{ $section->id }}" checked />
                                </label>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($section->start_at)) }}</td>
                            <td> {{ $section->start_at ? date('H:i', strtotime($section->start_at)) : '' }} -
                                {{ $section->end_at ? date('H:i', strtotime($section->end_at)) : '' }}</td>
                            <td>
                                @php
                                    $bgs = [
                                        App\Models\Section::LEARNING_STATUS => 'secondary',
                                        App\Models\Section::COMPLETED_STATUS => 'success',
                                        'Vắng có phép' => 'warning',
                                    ];

                                @endphp
                                <span
                                    class="badge bg-{{ $section->status === App\Models\Section::STATUS_DESTROY ? 'danger text-white' : $bgs[$section->checkStatusSection()] }}"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right">
                                    {{ $section->status === App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $section->checkStatusSection() }}
                                </span>
                            </td>
                            <td>{{ $section->course->teacher->name }} </td>

                        </tr>

                    </tbody>
                </table>
            </div>
        @else
            <div class="">
                <div class="form-outline">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                            error
                        </span>
                        <span>Lớp học không còn buổi học</span>
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="mb-10">
    <div class="col-12">

        <div class="">
            <div data-control="course-student-form">

            </div>
        </div>
        <script>
            $(() => {
                new CourseStudentBox({
                    box: $('[data-control="course-student-form"]'),
                    url: '{{ action('\App\Http\Controllers\Edu\StudentController@coursePartner') }}',
                    getSectionStudent: function() {
                        return $('[name="section_student_id"]');
                    }
                });
            });

            var CourseStudentBox = class {
                constructor(options) {
                    this.box = options.box;
                    this.url = options.url;
                    this.getSectionStudent = options.getSectionStudent;
                    this.events();
                    this.render();
                };

                getRows() {
                    return this.box[0].querySelectorAll('[request-control="row"]');
                };

                checkRow(row) {


                    this.getRows().forEach(r => {
                        r.classList.remove('bg-light-warning');
                        r.classList.remove('pe-none');
                    });

                    row.classList.add('bg-light-warning');
                    row.classList.add('pe-none');
                };

                afterRenderEvents() {
                    this.getRows().forEach(row => {
                        row.addEventListener('click', (e) => {
                            this.checkRow(row);
                        });
                    });
                };

                events() {
                    this.getSectionStudent().on('change', (e) => {
                        this.render();
                    });

                    if (!this.getSectionStudent().val()) {
                        this.box.html('');
                        return;
                    };
                };

                render() {
                    $.ajax({
                        url: this.url,
                        type: 'GET',
                        data: {
                            sectionStudentId: this.getSectionStudent().val()
                        },
                    }).done((response) => {
                        this.box.html(response);
                        initJs(this.box[0]);
                        this.afterRenderEvents();
                    });
                };
            };
        </script>
    </div>
</div>
