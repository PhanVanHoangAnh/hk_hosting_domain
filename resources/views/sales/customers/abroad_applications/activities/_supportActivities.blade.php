<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        <div class="col-md-12">
            <div id="SupportActivities">
                
            </div>
        </div>
    </div>
</div>

<script>
   var supportActivities;

    $(function() {
        supportActivities = new SupportActivities({
            url: '{{ action([App\Http\Controllers\Sales\AbroadController::class, 'supportActivities'], 
            [
                'id' => $abroadApplication->id,
            ]) }}',
            container: $('#SupportActivities'),
        });
    });

    var SupportActivities = class {
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
            }).fail(message => {
            })
        }
    }
</script>