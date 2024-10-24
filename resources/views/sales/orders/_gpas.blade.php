@php
    $uniqGpasForm = "uniq_gpas_" . uniqId();
@endphp

<div class="row d-flex justify-content-around" id="{{ $uniqGpasForm }}">
    @foreach(\App\Models\Gpa::all() as $key => $gpa)
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12" data-control="gpa_option" data-box="gpa_box_{{ $key + 1 }}">
            <?php
                $gpaField = 'grade_' . ($key + 1);
                $gpaPointField = 'point_' . ($key + 1);
            ?>

            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="form-check-input" name="grade_{{ $key + 1 }}" value="{{ $gpa->id }}" id="grade_define_{{ $key + 1 }}" 
                    {{ isset($orderItem->$gpaField) && $orderItem->$gpaField == $key + 1 ? 'checked' : '' }}/>
                </div>

                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                    <label data-form="label" class="btn btn-active-info border-none btn-active-primary w-100" for="">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex">
                            <span>{{ $gpa->grade }}</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                    <div form-control="text" class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5 d-none">
                        <input name="point_{{ $key + 1 }}" value="{{ isset($orderItem->$gpaPointField) ? $orderItem->$gpaPointField : '' }}" class="form-control bg-secondary" type="number">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        var GpasManager = class {
            constructor(options) {
                this.container = options.container;
                
                this.init();
            }

            init() {
                this.initGpas();
            }

            getGpaOptionBoxes() {
                return this.container().find('[data-control="gpa_option"]');
            }

            initGpas() {
                $.each(this.getGpaOptionBoxes(), (key, box) => {
                    new Gpa({
                        box: () => {
                            return $(box);
                        }
                    });
                })
            }
        }

        var Gpa = class {
            constructor(options) {
                this.box = options.box;
                
                this.events();
                this.toggle();
            }

            getBox() {
                return this.box();
            }

            getCheckBox() {
                return this.getBox().find('input');
            }

            getTextForm() {
                return this.getBox().find('[form-control="text"]');
            }

            getLabelForm() {
                return this.getBox().find('[data-form="label"]')
            }

            showLabel() {
                this.getLabelForm().addClass("bg-info");
                this.colorLabelTextWhite();
            }

            hideLabel() {
                this.getLabelForm().removeClass("bg-info");

                if (this.isShowingTextForm()) {
                    this.colorLabelTextWhite();
                } else {
                    this.colorLabelTextBlack();
                }
            }

            colorLabelTextBlack() {
                this.getLabelForm().find('span').addClass('text-dark');
                this.getLabelForm().find('span').removeClass('text-white');
            }

            colorLabelTextWhite() {
                this.getLabelForm().find('span').addClass('text-white');
                this.getLabelForm().find('span').removeClass('text-dark');
            }

            focusTextForm() {
                this.getTextForm().focus();
            }

            hideTextArea() {
                this.getTextForm().addClass('d-none');
                this.getLabelForm().removeClass('bg-info text-white');
                this.colorLabelTextBlack();
            }

            showTextArea() {
                this.getTextForm().removeClass('d-none');
                this.getLabelForm().addClass('bg-info text-white');
                this.colorLabelTextWhite();
                this.focusTextForm();
            }

            isShowingTextForm() {
                return !this.getTextForm().hasClass('d-none');
            }

            isHoveringLabel() {
                return this.getLabelForm().hasClass('bg-info');
            }

            toggleTextForm() {
                if (this.getTextForm().hasClass('d-none')) {
                    this.showTextArea();
                } else {
                    this.hideTextArea();
                }
            }

            toggle() {
                if (this.getCheckBox().is(':checked')) {
                    this.showLabel();
                    this.focusTextForm();
                } else {
                    this.hideLabel();
                    this.hideTextArea();
                }
            }

            events() {
                this.getCheckBox().on('click', e => {
                    this.toggle();
                })

                this.getLabelForm().on('click', e => {
                    e.preventDefault();
                    this.toggleTextForm();

                    if (!this.isShowingTextForm()) {
                        this.colorLabelTextWhite();
                    }
                })

                this.getLabelForm().hover(e => {
                    e.preventDefault();
                    this.colorLabelTextWhite();
                }).mouseleave(e => { 
                    e.preventDefault();

                    if (!this.isHoveringLabel()) {
                        this.colorLabelTextBlack();
                    }
                });
            }
        }
    </script>
</div>

<script>
    $(() => {
        new GpasManager({
            container: () => {
                return $('#{{ $uniqGpasForm }}');
            }
        })
    })
</script>