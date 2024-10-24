<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="StudentCV">
                
            </div>
        </div>
    </div>
</div>

<script>
    var studentCV;

    $(() => {
        studentCV = new StudentCV({
            container: $('#StudentCV'),
            url: '{{ action([App\Http\Controllers\Sales\AbroadController::class, 'studentCV'], ['id' => $abroadApplication->id]) }}'
        });
    })

    var StudentCV = class {
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