@php
    $containerId = 'F' . uniqid();
@endphp

<div id="{{ $containerId }}" class="mb-3 border p-4">
    @if ($relationship)
        <div class="">
            <div class="form-outline">
                <p class="mb-0">
                    <strong>{{ $contact->name }}</strong>
                    hiện được ghi nhận là
                    <strong>{{ $relationship->getWording() }}</strong>
                    của
                    <strong>{{ $toContact->name }}</strong>.
                    <a href="javascript:;" data-control="show-form" class="ms-2">
                        (<span class="material-symbols-rounded fs-7">
                            edit
                        </span> Cập nhật mối quan hệ)
                    </a>
                </p>
            </div>
        </div>
    @else
        <div class="">
            <div class="form-outline">
                <p class="mb-0">
                    Chưa có mối quan hệ của <strong>{{ $contact->name }}</strong> đối với <strong>{{ $toContact->name }}</strong>.
                    <a href="javascript:;" data-control="show-form" class="ms-2">
                        (<span class="material-symbols-rounded fs-7">
                            edit
                        </span> Thêm mối quan hệ)
                    </a>
                </p>
            </div>
        </div>
    @endif

    <div data-control="form" class="mt-4" style="display:none;">
        <div class="d-flex">
            <div class="form-outline mb-3">
                <select name="relationship_type" class="form-select">
                    @foreach (App\Helpers\Functions::getRelationshipOptions() as $option)
                        <option {{ request()->relationship_type == $option['value'] ? 'selected' : ($relationship && $relationship->type == $option['value'] ? 'selected' : '') }} value="{{ $option['value'] }}">
                            {{ $option['text'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="ms-3" box-select-toggle box-toggle-selector='[name="relationship_type"]' box-toggle-value="other" style="display:none;">
                <div class="form-outline mb-3">
                    <input type="text" name="relationship_other" value="{{ $errors->has('relationship_other') ? request()->relationship_other : ($relationship ? $relationship->other : '') }}" class="form-control" placeholder="Nhập quan hệ khác (anh, chị, cô,...)"
                        style="min-width:260px;"
                    />
                    
                    <x-input-error :messages="$errors->get('relationship_other')" class="mt-2" />
                </div>
            </div>
            <div class="ms-3">
                <button form-control="save" type="button" class="btn btn-primary">
                    <span class="indicator-label">Lưu thay đổi</span>
                    <span class="indicator-progress">Đang xử lý...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
        <x-input-error :messages="$errors->get('relationship_validate')" class="mt-2" />
    </div>

    <script>
        $(function() {
            //
            document.querySelectorAll('#{{ $containerId }} [box-select-toggle]').forEach(box => {
                new BoxSelectToggle({
                    box: box,
                    selectors: document.querySelectorAll(box.getAttribute('box-toggle-selector')),
                    value: box.getAttribute('box-toggle-value'),
                });
            });

            //
            var container = $('#{{ $containerId }}');
            new RelationshipForm({
                url: `{{ action([App\Http\Controllers\RelationshipController::class, 'save'], [
                    'contact_id' => $contact->id,
                    'to_contact_id' => $toContact->id,
                ]) }}`,
                container: container,
                form: container.find('[data-control="form"]'),
            });
        });

        var RelationshipForm = class {
            constructor(options) {
                this.url = options.url;
                this.container = options.container;
                this.form = options.form;

                //
                this.events();

                @if ($errors->count())
                    this.showForm();
                @endif
            }

            getSaveButton() {
                return this.container.find('[form-control="save"]');
            }

            getTypeSelectBox() {
                return this.container.find('[name="relationship_type"]');
            }

            getOtherSelectBox() {
                return this.container.find('[name="relationship_other"]');
            }

            addSubmitEffect() {
                this.getSaveButton()[0].setAttribute('data-kt-indicator', 'on');
                this.getSaveButton()[0].setAttribute('disabled', true);
            }

            removeSubmitEffect() {
                this.getSaveButton()[0].removeAttribute('data-kt-indicator');
                this.getSaveButton()[0].removeAttribute('disabled');
            }

            getShowFormLink() {
                return this.container.find('[data-control="show-form"]');
            }

            events() {
                this.getSaveButton().on('click', (e) => {
                    // window.contactRelationshipBox.load();
                    this.save();
                });
                
                this.getShowFormLink().on('click', (e) => {
                    this.showForm();
                });
            }

            showForm() {
                this.form.show();
                this.getShowFormLink().hide();
            }

            save() {
                this.addSubmitEffect();

                // find relationship
                $.ajax({
                    url: this.url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        relationship_type: this.getTypeSelectBox().val(),
                        relationship_other: this.getOtherSelectBox().val(),
                    }
                }).done((response) => {
                    window.contactRelationshipBox.load();
                }).fail((response) => {
                    window.contactRelationshipBox.setContent(response.responseText);
                }).always(() => {
                    this.removeSubmitEffect();
                });
            }
        };

        var BoxSelectToggle = class {
            constructor(options) {
                this.box = options.box;
                this.selectors = options.selectors;
                this.value = options.value;

                // events
                this.events();

                //
                this.toggle();
            }

            getValue() {
                var value = null;
                this.selectors.forEach(selector => {
                    value = selector.value;
                });
                return value;
            }

            toggle() {
                if (this.value == this.getValue()) {
                    this.box.style.display = 'block';
                } else {
                    this.box.style.display = 'none';
                }
            }

            events() {
                this.selectors.forEach(selector => {
                    selector.addEventListener('change', (e) => {
                        this.toggle()
                    });
                });
                    
            }
        }
    </script>
</div>
