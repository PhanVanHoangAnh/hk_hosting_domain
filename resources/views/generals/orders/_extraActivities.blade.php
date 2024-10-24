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

            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="form-check-input" name="extra_activity_{{ $key + 1 }}" value="{{ $extraActivity->id }}" id="extra_activity_define_{{ $key + 1 }}" 
                    {{ isset($abroadApplication->$extraActivityField) && $abroadApplication->$extraActivityField == $key + 1 ? 'checked' : '' }}/>
                </div>

                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
                    <label data-form="label" class="btn btn-active-info border-none btn-active-primary w-100" for="extra_activity_define_{{ $key + 1 }}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex">
                            <span>{{ $extraActivity->name }}</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                </div>
                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
                    <div form-control="text" class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5 d-none">
                        <textarea name="extra_activity_text_{{ $key + 1 }}" class="form-control bg-secondary" cols="110" rows="2">{{ isset($abroadApplication->$extraActivityTextField) ? $abroadApplication->$extraActivityTextField : '' }}</textarea>
                    </div>
                </div>
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
                this.getLabelForm().find('span').addClass("text-white");
            }

            hideLabel() {
                this.getLabelForm().removeClass("bg-info");
                this.getLabelForm().find('span').removeClass("text-white");
            }

            hideTextArea() {
                this.getTextForm().addClass('d-none');
            }

            showTextArea() {
                this.getTextForm().removeClass('d-none');
            }

            toggle() {
                if (this.getCheckBox().is(':checked')) {
                    this.showTextArea();
                    this.showLabel();
                    this.getTextForm().focus();
                } else {
                    this.hideLabel();
                    this.hideTextArea();
                }
            }

            events() {
                this.getCheckBox().on('click', e => {
                    this.toggle();
                })
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