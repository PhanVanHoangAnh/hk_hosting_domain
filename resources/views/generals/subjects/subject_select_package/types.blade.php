@php
    $typeFormId = "types-" . uniqId();
@endphp
<div class="col-lg-12 col-md-12 col-sm-12 col-12" data-form="{{ $typeFormId }}">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
            <div class="form-outline" selector-box="subject_type">
                <label class="fs-6 fw-semibold required mb-2" for="subject_type-create-select">Loại đào tạo</label>
                <select data-type="product-subject_type" id="subject_type-create-select" 
                    class="form-select form-control" 
                    name="subject_type"
                    data-control="select2" 
                    data-dropdown-parent="#{{ $parentId }}"
                    data-placeholder="Chọn loại đào tạo" 
                    data-allow-clear="true">
                    <option value="">Chọn loại đào tạo</option>
                    @foreach(\App\Models\Subject::getAllSubjectTypes() as $type)
                        <option value="{{ $type }}" {{ $originType && $originType == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('subject_type')" class="mt-2"/>
            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-8 col-8" data-region="content">
            {{-- Load subject select here --}}
        </div>
    </div>
</div>

<script>
    $(() => {
        new TypeForm({
            form: () => {
                return $('[data-form="{{ $typeFormId }}"]')
            }
        })
    })
</script>

<script>
    var TypeForm = class {
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

        loadContent(type=null) {
            const _this = this;

            if (!type) {
                _this.getContentRegion().html('');
                return;
        }

            const url = "{{ action([App\Http\Controllers\SubjectController::class, 'getSubjectsFormByType']) }}";
            const data = {
                type: type,
                parentId: "{!! $parentId !!}",
                selectedType: "{!! isset($orderItem->order_type) ? $orderItem->order_type : null !!}",
                selectedSubjectId: "{!! isset($orderItem->subject_id) ? $orderItem->subject_id : null !!}",
                selectedLevel: "{!! isset($selectedLevel) ? $selectedLevel : null !!}",
                typeError: "{!! count($errors->get('order_type')) > 0 ? $errors->get('order_type')[0] : null !!}",
                subjectError: "{!! count($errors->get('subject_id')) > 0 ? $errors->get('subject_id')[0] : null !!}",
                _token: "{!! csrf_token() !!}"
            }

            $.ajax({
                url: url,
                method: 'post',
                data: data
            }).done(res => {
                _this.getContentRegion().html('');
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