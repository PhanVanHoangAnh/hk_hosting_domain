<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="DepositTuitionFee">
                
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        window.depositTuitionFee = new DepositTuitionFee({
            container: $('#DepositTuitionFee'),
            url: '{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'depositTuitionFee'], ['id' => $abroadApplication->id]) }}'
        });
    })

    var DepositTuitionFee = class {
        constructor(options) {
            this.container = options.container;
            this.url = options.url;

            this.load();
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
                initJs(_this.getContainer()[0]);
            }).fail(response => {
                throw new Error(response.text);
            });
        }
    }
</script>