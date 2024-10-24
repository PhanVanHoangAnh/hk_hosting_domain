<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="i20ApplicationContent">

            </div>
        </div>
    </div>
</div>

<script>
    var i20ApplicationManager;

    $(function() {
        i20ApplicationManager = new I20ApplicationManager({
            url: '{{ action(
                [App\Http\Controllers\Abroad\AbroadController::class, 'i20Application'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}',
            container: $('#i20ApplicationContent'),
        });
    });

    var I20ApplicationManager = class {
        constructor(options) {
            this.url = options.url;
            this.container = options.container;

            // load
            this.load();
        }

        getContainer() {
            return this.container;
        }

        load() {
            $.ajax({
                url: this.url,
                method: "GET",
            }).done(response => {
                this.getContainer().html(response);

                initJs(this.getContainer()[0]);
            }).fail(message => {})
        }
    }
</script>
