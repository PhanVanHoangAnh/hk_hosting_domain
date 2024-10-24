<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
        <div class="form-outline" selector-box="type">
            <label class="fs-6 fw-semibold required mb-2">Loại đào tạo</label>
            <select class="form-select form-control" 
                name="order_type"
                data-dropdown-parent="#{{ $parentId }}"
                data-control="select2" 
                placeholder="Chọn loại đào tạo...">
                @if ($types && count($types) > 0) 
                    <option value="">Chọn loại đào tạo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ isset($selectedType) && $selectedType == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                @else 
                    <option value="" selected>Chọn loại đào tạo</option>
                @endif
            </select>

            {{-- Error --}}
            @if (isset($typeError)) 
                <span class="text-danger text-center">{{ $typeError }}</span>
            @endif
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2" data-region="subject">
        {{-- LOAD AJAX SUBJECT SELECT BOX HERE --}}
    </div>
</div>

<script>
    $(() => {
        new TypeBox({
            container: () => {
                return $('[selector-box="type"]');
            }
        })
    })
</script>

<script>
    var TypeBox = class {
        constructor(options) {
            this.container = options.container;
        
            this.events();
            this.changeOption();
        }

        getSelector() {
            return this.container().find('select');
        }

        changeOption() {
            if (this.getSelector().data('select2')) {
                if (this.getSelector().val()) {
                    this.render(this.getSelector().val());
                } else {
                    this.render();
                }
            }
        }

        render(type=null) {
            if (!type) {
                $('[data-region="subject"]').html('');
                return;
            }

            const _this = this;
            const url = "{{ action([App\Http\Controllers\SubjectController::class, 'getSubjectBoxByType']) }}";
            const data = {
                type: type,
                parentId: "{!! $parentId !!}",
                selectedSubjectId: "{!! isset($selectedSubjectId) ? $selectedSubjectId : null !!}",
                subjectError: "{!! $subjectError ? $subjectError : null !!}",
                _token: "{!! csrf_token() !!}"
            }

            $.ajax({
                url: url,
                method: 'post',
                data: data
            }).done(res => {
                $('[data-region="subject"]').html(res);
                initJs($('[data-region="subject"]')[0]);
            }).fail(res => {
                throw new Error(res.messages);
            })
        }

        events() {
            // Change level
            const _this = this;

            this.getSelector().on('change', e => {
                _this.changeOption(_this.render);
            })
        }
    }
</script>