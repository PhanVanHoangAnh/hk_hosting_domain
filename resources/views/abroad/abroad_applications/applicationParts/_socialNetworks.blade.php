<div class="pb-5 mb-5 border-bottom">
    <div class="row">
        
        <div class="col-md-12">
            <div id="SocialNetworkContent">
                
            </div>
        </div>
    </div>
</div>

<script>
    var networkSocialManager;

    $(function() {
        networkSocialManager = new NetworkSocialManager({
            url: '{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'socialNetwork'], [
                'id' => $abroadApplication->id,
            ]) }}',
            container: $('#SocialNetworkContent'),
        });
    });

    var NetworkSocialManager = class {
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