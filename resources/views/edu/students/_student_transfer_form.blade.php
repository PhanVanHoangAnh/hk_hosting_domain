@php
    $contactId = uniqid();
@endphp
<div class="mb-10 d-none">
    <div class="form-outline mb-7">
        <div class="d-flex align-items-center">
            <label for="" class="form-label fw-semibold text-info">Học viên</label>
        </div>
        <input type="hidden" value="{{ $currentCourse->id }}" name="currentCourseId">
        @include('helpers.contactSelector', [
            'name' => 'contact_id-' . $contactId,
            'url' => action('App\Http\Controllers\Edu\StudentController@select2'),
            'controlParent' => '#' . $formId,
            'placeholder' => 'Tìm học viên từ hệ thống',
            'value' => $student !== null ? ($student->id ? $student->id : null) : null,
            'text' => $student !== null ? ($student->id ? $student->getSelect2Text() : null) : null,
            'createUrl' => action('\App\Http\Controllers\Edu\StudentController@create'),
            'editUrl' => action('\App\Http\Controllers\Edu\StudentController@edit', 'CONTACT_ID'),
            'notAdd' => true,
            'notEdit' => true,
        ])
        <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
    </div>
</div>
<div class="mb-10">
    <div class="col-12">

        <div class="">
            <div data-control="course-transfer-form">

            </div>
        </div>
        <script>
            $(() => {
                new CourseStudentBox({
                    box: $('[data-control="course-transfer-form"]'),
                    url: '{{ action('\App\Http\Controllers\Edu\StudentController@courseTransferStudentForm') }}',
                    getStudentSelectBox: function() {
                        return $('[name="contact_id-{{ $contactId }}"]');
                    },
                    getCurrentCourseId: function() {
                        return $('[name = "currentCourseId"]');
                    }

                });
            });

            var CourseStudentBox = class {
                constructor(options) {
                    this.box = options.box;
                    this.url = options.url;
                    this.getStudentSelectBox = options.getStudentSelectBox;
                    this.getCurrentCourseId = options.getCurrentCourseId;


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
                    this.getStudentSelectBox().on('change', (e) => {
                        this.render();
                    });

                    if (!this.getStudentSelectBox().val()) {
                        this.box.html('');
                        return;
                    };
                };

                render() {
                    $.ajax({
                        url: this.url,
                        type: 'GET',
                        data: {
                            student_id: this.getStudentSelectBox().val(),
                            current_course_id: this.getCurrentCourseId().val(),


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
