<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="AdmissionLetterContent">

            </div>
        </div>
    </div>
</div>

<script>
    var admissionLetterManager;

    $(function() {
        admissionLetterManager = new AdmissionLetterManager({
            url: '{{ action(
                [App\Http\Controllers\Abroad\AbroadController::class, 'admissionLetter'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}',
            container: $('#AdmissionLetterContent'),
        });
    });

    var AdmissionLetterManager = class {
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
