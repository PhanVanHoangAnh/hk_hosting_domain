<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="FinancialDocumentsContent">

            </div>
        </div>
    </div>
</div>

<script>
    var financialDocumentsManager;

    $(function() {
        financialDocumentManager = new FinancialDocumentsManager({
            url: '{{ action(
                [App\Http\Controllers\Student\AbroadController::class, 'financialDocument'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}',
            container: $('#FinancialDocumentsContent'),
        });
    });

    var FinancialDocumentsManager = class {
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
