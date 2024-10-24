@php
    $extraManagerUniqId = "_extraManagerUniqId_" . uniqId(); 
@endphp

<div class="row" id="{{ $extraManagerUniqId }}">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12">
        {{-- select extra section --}}
        <div class="row" form-control="extra-selector">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12">   
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2">Hoạt động ngoại khóa</label>
                    @include('helpers.contactSelector', [
                        'name' => 'extracurricular_id',
                        'url' => action('App\Http\Controllers\ExtracurricularController@select2'),
                        'controlParent' => "#" . $createExtraOrderItemPopupUniqid,
                        'placeholder' => 'Chọn hoạt động ngoại khóa',
                        'value' => isset($extracurricular) ? $extracurricular->id : null,
                        'text' => isset($extracurricular) ? $extracurricular->getSelect2Text() : null,
                        'createUrl' => null,
                        'editUrl' => null,
                        'notAdd' => true,
                        'notEdit' => true,
                        'bgColor' => "bg-secondary",
                        'hideBorder' => true,
                    ])
                    <x-input-error :messages="$errors->get('extracurricular_id')" class="mt-2"/>    
                </div>
            </div>
        </div>

        <div class="row" form-control="load-table">
            {{-- LOAD TABLE HERE --}}
        </div>

        <script>
            var TableManager = class {
                constructor(options) {
                    this.container = options.container;
                }

                getContainer() {
                    return this.container();
                }

                load(content) {
                    this.getContainer().html(content);
                }

                reset() {
                    this.getContainer().html("");
                }
            }
        </script>
    </div>
</div>

<script>
    var ExtraManager = class {
        constructor(options) {
            this.container = options.container;
            this.extraSelector = options.extraSelector;
            this.table = options.table;

            this.events();
            this.changeExtra();
        }

        getContainer() {
            return this.container();
        }

        getSelector() {
            return this.extraSelector().find("select[name='extracurricular_id']");
        }

        getTable() {
            return this.table;
        }

        getLink() {
            const id = this.getSelector().val();

            if (!id) {
                return null;
            }

            let rawLink = "{!! action([App\Http\Controllers\ExtracurricularController::class, 'getExtra'], ['id' => 'PLACEHOLDER', 'orderItemId' => isset($orderItem) ? $orderItem->id : null, 'priceReturn' => isset($priceReturn) ? $priceReturn : 0]) !!}";
            const finalLink = rawLink.replace('PLACEHOLDER', id);

            return finalLink;
        }

        callExtra() {
            const link = this.getLink();
            
            if (link) {
                $.ajax({
                    url: link,
                    method: 'GET',
                }).done(response => {
                    this.getTable().load(response);
                }).fail(response => {
                    throw new Error(response);
                })
            } else {
                this.getTable().reset();
            }
        }

        changeExtra() {
            if (this.getSelector().data('select2')) {
                if (this.getSelector().val()) {
                    this.callExtra();
                } else {
                    this.getTable().load("");
                }   
            }
        }

        events() {
            this.getSelector().on('change', e => {
                e.preventDefault();

                if (priceInlineEdit) {
                    priceInlineEdit.dispatchEventToUpdatePriceShare();
                }
                
                this.changeExtra();
            })

            this.getSelector().on("select2:unselecting", e => {
                this.changeExtra();
            })
        }
    }

    $(() => {
        new ExtraManager({
            container: () => {
                return $("#{{ $extraManagerUniqId }}");
            },
            extraSelector: () => {
                return $("#{{ $extraManagerUniqId }}").find('[form-control="extra-selector"]');
            },
            table: new TableManager({
                container: () => {
                    return $("#{{ $extraManagerUniqId }}").find('[form-control="load-table"]');
                }
            })
        })
    })
</script>