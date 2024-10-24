@php
    $uniqExtraActivitiesForm = "uniq_extra_activities_" . uniqId();
@endphp

<div class="row d-flex justify-content-around" id="{{ $uniqExtraActivitiesForm }}">
    @foreach(\App\Models\ExtraActivity::all() as $key => $extraActivity)
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12" data-control="activity_option" data-box="extra_activity_box_{{ $key + 1 }}">
            <?php
                $extraActivityField = 'extra_activity_' . ($key + 1);
                $extraActivityTextField = 'extra_activity_text_' . ($key + 1);
            ?>
            <input type="checkbox" class="btn-check" name="extra_activity_{{ $key + 1 }}" value="{{ $extraActivity->id }}" id="extra_activity_define_{{ $key + 1 }}" 
                    {{ isset($orderItem->$extraActivityField) && $orderItem->$extraActivityField == $key + 1 ? 'checked' : '' }}/>
            <label class="btn btn-active-info border-none btn-active-primary w-100" for="">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex">
                    <span>{{ $extraActivity->name }}</span>
                </div>
            </label>
            <div form-control="text" class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5 d-none">
                <textarea name="extra_activity_text_{{ $key + 1 }}" class="form-control bg-secondary" cols="110" rows="2">{{ isset($orderItem->$extraActivityTextField) ? $orderItem->$extraActivityTextField : '' }}</textarea>
            </div>
        </div>
    @endforeach

    <script>
        var ExtraActivitiesManager = class {
            constructor(options) {
                this.container = options.container;
                
                this.init();
            }

            init() {
                this.initActivities();
            }

            getActivityOptionBoxes() {
                return this.container().find('[data-control="activity_option"]');
            }

            initActivities() {
                $.each(this.getActivityOptionBoxes(), (key, box) => {
                    new Activity({
                        box: () => {
                            return $(box);
                        }
                    });
                })
            }
        }

        var Activity = class {
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
        new ExtraActivitiesManager({
            container: () => {
                return $('#{{ $uniqExtraActivitiesForm }}');
            }
        })
    })
</script>