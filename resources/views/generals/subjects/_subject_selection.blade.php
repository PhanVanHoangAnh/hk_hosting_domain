{{-- VIEW INCLUDE --}}
@php
    $levelSelectorUniqId = "level_selector_uniq_id_" . uniqId();
@endphp

<div class="row mb-4" id="{{ $levelSelectorUniqId }}">
    {{-- SELECTOR BOX: Level --}}
    <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
        {{-- @include('generals.subjects._level_box') --}}
        @include('generals.subjects.subject_select_package.types')
    </div>
    {{-- SELECTOR BOX: Type --}}
    <div class="col-lg-8 col-md-8 col-sm-12 col-12 mb-2" data-region="type">
        {{-- LOAD AJAX TYPE SELECT BOX HERE --}}
    </div>
</div>

<script>
    var LevelBox = class {
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

        render(level=null) {
            if (!level) {
                $('[data-region="type"]').html('');
                return;
            }

            const _this = this;
            const url = "{{ action([App\Http\Controllers\SubjectController::class, 'getTypeBoxByLevel']) }}";
            const data = {
                level: level,
                parentId: "{!! $parentId !!}",
                selectedType: "{!! isset($orderItem->order_type) ? $orderItem->order_type : null !!}",
                selectedSubjectId: "{!! isset($orderItem->subject_id) ? $orderItem->subject_id : null !!}",
                typeError: "{!! count($errors->get('order_type')) > 0 ? $errors->get('order_type')[0] : null !!}",
                subjectError: "{!! count($errors->get('subject_id')) > 0 ? $errors->get('subject_id')[0] : null !!}",
                _token: "{!! csrf_token() !!}"
            }

            $.ajax({
                url: url,
                method: 'post',
                data: data
            }).done(res => {
                $('[data-region="type"]').html(res);
                initJs($('[data-region="type"]')[0]);
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