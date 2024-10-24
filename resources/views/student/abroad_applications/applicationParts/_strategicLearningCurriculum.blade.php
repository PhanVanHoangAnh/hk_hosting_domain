<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="StrategicLearningCurriculumContent">
                
            </div>
        </div>
    </div>
</div>

<script>
    var strategicLearningCurriculum;

    $(function() {
        strategicLearningCurriculum = new StrategyLearningCurriculum({
            container: $('#StrategicLearningCurriculumContent'),
            url: '{{ action([App\Http\Controllers\Student\AbroadController::class, 'strategicLearningCurriculum'], ['id' => $abroadApplication->id]) }}'
        });
    })

    var StrategyLearningCurriculum = class {
        constructor(options) {
            this.container = options.container;
            this.url = options.url;

            this.load()
        }

        getContainer() {
            return this.container;
        }

        getUrl() {
            return this.url;
        }

        updateContent(content) {
            $(this.getContainer()[0]).html(content);
        }

        load() {
            const _this = this;

            $.ajax({
                url: _this.getUrl(),
                method: 'get',
            }).done(response => {
                _this.updateContent(response);
            }).fail(response => {
                throw new Error(response.text);
            });
        }
    }
</script>
