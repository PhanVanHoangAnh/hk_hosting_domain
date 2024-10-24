<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="EditThesis">
                
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        window.editThesis = new EditThesis({
            container: $('#EditThesis'),
            url: '{{ action([App\Http\Controllers\Student\AbroadController::class, 'editThesis'], ['id' => $abroadApplication->id]) }}'
        });
    })

    var EditThesis = class {
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
            this.getContainer()[0].innerHTML = content;
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