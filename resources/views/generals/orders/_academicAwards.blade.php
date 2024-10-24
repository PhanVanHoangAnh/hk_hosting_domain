@php
    $uniqAcademicRewardsForm = "uniq_academic_rewards_" . uniqId();
@endphp

<div class="row d-flex justify-content-around" id="{{ $uniqAcademicRewardsForm }}">
    @foreach(\App\Models\AcademicAward::all() as $key => $award)
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12" data-control="award_option" data-box="academic_award_box_{{ $key + 1 }}">
            <?php
                $awardField = 'academic_award_' . ($key + 1);
                $awardTextField = 'academic_award_text_' . ($key + 1);
            ?>

            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="form-check-input" name="academic_award_{{ $key + 1 }}" value="{{ $award->id }}" id="academic_define_{{ $key + 1 }}" 
                    {{ isset($abroadApplication->$awardField) && $abroadApplication->$awardField == $key + 1 ? 'checked' : '' }}/>
                </div>

                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
                    <label data-form="label" class="btn btn-active-info border-none btn-active-primary w-100" for="academic_define_{{ $key + 1 }}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex">
                            <span>{{ $award->name }}</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                </div>
                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
                    <div form-control="text" class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5 d-none">
                        <textarea name="academic_award_text_{{ $key + 1 }}" class="form-control bg-secondary" cols="110" rows="2">{{ isset($abroadApplication->$awardTextField) ? $abroadApplication->$awardTextField : '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        var AcademicAwardsManager = class {
            constructor(options) {
                this.container = options.container;
                
                this.init();
            }

            init() {
                this.initAwards();
            }

            getAwardOptionBoxes() {
                return this.container().find('[data-control="award_option"]');
            }

            initAwards() {
                $.each(this.getAwardOptionBoxes(), (key, box) => {
                    new Award({
                        box: () => {
                            return $(box);
                        }
                    });
                })
            }
        }

        var Award = class {
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

            hideTextArea() {
                this.getTextForm().addClass('d-none');
            }

            showTextArea() {
                this.getTextForm().removeClass('d-none');
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
        new AcademicAwardsManager({
            container: () => {
                return $('#{{ $uniqAcademicRewardsForm }}');
            }
        })
    })
</script>