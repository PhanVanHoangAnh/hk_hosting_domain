<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="RecommendationLetter">
                
            </div>
        </div>
    </div>
</div>

<script>
    var recommendationLetter;

    $(() => {
        recommendationLetter = new RecommendationLetter({
            container: $('#RecommendationLetter'),
            url: '{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'recommendationLetter'], ['id' => $abroadApplication->id]) }}'
        });
    })

    var RecommendationLetter = class {
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