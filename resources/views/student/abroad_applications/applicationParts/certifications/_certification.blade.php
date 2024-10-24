<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="CertificationsContent">

            </div>
        </div>
    </div>
</div>

<script>
    var certificationsManager;

    $(function() {
        certificationsManager = new CertificationsManager({
            url: '{{ action(
                [App\Http\Controllers\Student\AbroadController::class, 'certifications'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}',
            container: $('#CertificationsContent'),
        });
    });

    var CertificationsManager = class {
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
