@php
    $subjectFormId = "subject-" . uniqId();
@endphp

<div class="col-lg-12 col-md-12 col-sm-12 col-12" data-form="{{ $subjectFormId }}">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
            <div class="form-outline" selector-box="subject">
                <label class="fs-6 fw-semibold required mb-2" for="subject-create-select">Môn học</label>
                <select data-type="product-subject" id="subject-create-select" 
                    class="form-select form-control" 
                    name="subject_id"
                    data-control="select2" 
                    data-dropdown-parent="#{{ $parentId }}" 
                    data-placeholder="Chọn môn học" 
                    data-allow-clear="true">
                    <option value="">Chọn môn học</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ isset($selectedSubjectId) && $selectedSubjectId == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>

                {{-- Error --}}
                @if (isset($subjectError)) 
                    <span class="text-danger text-center">{{ $subjectError }}</span>
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-6" data-region="content">
            
        </div>
    </div>
</div>

<script>
    $(() => {
        new SubjectForm({
            form: () => {
                return $('[data-form="{{ $subjectFormId }}"]');
            }
        })
    })
</script>

<script>
    var SubjectForm = class {
        constructor(options) {
            this.form = options.form;
            this.events();
            this.changeOption();
        }

        getContentRegion() {
            return this.form().find('[data-region="content"]');
        }

        getSelector() {
            return this.form().find('select');
        }

        changeOption() {
            if (this.getSelector().data('select2')) {
                if (this.getSelector().val()) {
                    this.loadContent(this.getSelector().val());
                } else {
                    this.loadContent();
                }
            }
        }

        loadContent(subject_id=null) {
            const _this = this;

            if (!subject_id) {
                _this.getContentRegion().html('');
                return;
            }

            const url = "{{ action([App\Http\Controllers\SubjectController::class, 'getLevelsFormBySubject']) }}";
            const data = {
                subject_id: subject_id,
                parentId: "{!! $parentId !!}",
                selectedSubjectId: "{!! isset($orderItem->subject_id) ? $orderItem->subject_id : null !!}",
                selectedLevel: "{!! isset($selectedLevel) ? $selectedLevel : null !!}",
                typeError: "{!! count($errors->get('subject_id')) > 0 ? $errors->get('subject_id')[0] : null !!}",
                levelError: "{!! count($errors->get('level')) > 0 ? $errors->get('level')[0] : null !!}",
                _token: "{!! csrf_token() !!}"
            }

            $.ajax({
                url: url,
                method: 'post',
                data: data
            }).done(res => {
                _this.getContentRegion().html(res);
                initJs(_this.getContentRegion()[0]);
            }).fail(res => {
                throw new Error(res.messages);
            })
        }

        events() {
            this.getSelector().on('change', () => {
                this.changeOption();
            })
        }
    }
</script>