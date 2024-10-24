<div class="mb-10">
    @if ($coursePartners->count())
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold text-info">Lớp có môn tương ứng</label>
            </div>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                <table class="table table-row-bordered table-hover table-bordered table-fixed">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th style="width:1%"></th>
                            <th class="text-nowrap text-white">Tên lớp học</th>
                            <th class="text-nowrap text-white">Môn học</th>
                            <th class="text-nowrap text-white">Trạng thái</th>
                            <th class="text-nowrap text-white">Thời gian bắt đầu</th>
                            <th class="text-nowrap text-white">Thời gian kết thúc</th>
                            <th class="text-nowrap text-white">Chủ nhiệm</th>
                            <th class="text-nowrap text-white">Số lượng học viên tối đa</th>
                            <th class="text-nowrap text-white">Tổng giờ học</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coursePartners as $coursePartner)
                            <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                                data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                                <td>
                                    <div
                                        class="form-check form-check-sm form-check-custom d-flex justify-content-center">

                                        <input request-control="select-radio" name="course_partner_id"
                                            list-action="check-item" class="form-check-input" type="radio"
                                            value="{{ $coursePartner->id }}" />
                                    </div>
                                </td>
                                <td>{{ $coursePartner->code }}</td>
                                <td>{{ $coursePartner->subject->name }}</td>
                                <td>{{ $coursePartner->checkStatusSubject() }}</td>
                                <td>{{ \Carbon\Carbon::parse($coursePartner->start_at)->format('d/m/Y') }}</td>
                                <td>{{ $coursePartner->getNumberSections() != 0 ? \Carbon\Carbon::parse($coursePartner->getEndAt())->format('d/m/Y') : '--' }}
                                </td>
                                <td>{{ $coursePartner->teacher->name }}</td>
                                <td>{{ $coursePartner->max_students }}</td>
                                <td>{{ $coursePartner->total_hours }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @else
        <div class="">
            <div class="form-outline">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                        error
                    </span>
                    <span>Chưa có lớp đang học có môn tương ứng</span>
                </span>
            </div>
        </div>
    @endif
</div>
<div class="mb-10">
    <div class="col-12">
        <div data-control="section-form"></div>
        <script>
            var studentId = studyPartnerManager.container.querySelector('[name="studentId"]').value;

            $(() => {
                new SectionsBox({
                    box: $('[data-control="section-form"]'),
                    url: '{{ action('\App\Http\Controllers\Edu\StudentController@sectionForm') }}',
                    getCourseSelectBox: function() {
                        return $('[name="course_partner_id"]');
                    },
                    getStudentId: function() {
                        return studyPartnerManager.container.querySelector('[name="studentId"]').value;
                    }
                });
            });

            var SectionsBox = class {
                constructor(options) {
                    this.box = options.box;
                    this.url = options.url;
                    this.getCourseSelectBox = options.getCourseSelectBox;
                    this.getStudentId = options.getStudentId;
                    this.events();
                    this.render();
                };

                getRows() {
                    return this.box[0].querySelectorAll('[request-control="row"]');
                };

                checkRow(row) {
                    var radio = row.querySelector('[request-control="select-radio"]');



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
                    this.getCourseSelectBox().on('change', (e) => {
                        this.render();
                    });

                    if (!this.getCourseSelectBox().val()) {
                        this.box.html('');
                        return;
                    };
                };

                render() {
                    var courseStudentSelectBoxs = this.getCourseSelectBox()
                        .filter(':checked')
                        .map(function() {
                            return $(this).val();
                        }).get();

                    $.ajax({
                        url: this.url,
                        type: 'GET',
                        data: {
                            courseIds: courseStudentSelectBoxs,
                            studentId: this.getStudentId,
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
